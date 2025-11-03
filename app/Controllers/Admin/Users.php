<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\GroupModel;

class Users extends BaseController
{
    protected $userModel;
    protected $groupModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
    }

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Check if user is admin
        if (!is_admin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Access Denied');
        }
    }

    /**
     * Display users list
     */
    public function index()
    {
        $users = $this->userModel->getUsersWithGroups();
        
        $data = [
            'title' => 'Διαχείριση Χρηστών - PHA Manager v4',
            'users' => $users,
            'total_users' => count($users)
        ];

        return view('admin/users/index', $data);
    }

    /**
     * Show create user form
     */
    public function create()
    {
        $groups = $this->groupModel->findAll();
        
        $data = [
            'title' => 'Νέος Χρήστης - PHA Manager v4',
            'groups' => $groups,
            'validation' => session()->getFlashdata('validation')
        ];

        return view('admin/users/create', $data);
    }

    /**
     * Store new user
     */
    public function store()
    {
        $validation = service('validation');
        
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'first_name' => 'required|max_length[50]',
            'last_name' => 'required|max_length[50]',
            'group_id' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $userData = [
            'ip_address' => $this->request->getIPAddress(),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'email' => $this->request->getPost('email'),
            'created_on' => time(),
            'active' => $this->request->getPost('active') ? 1 : 0,
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'company' => $this->request->getPost('company'),
            'phone' => $this->request->getPost('phone')
        ];

        $userId = $this->userModel->insert($userData);

        if ($userId) {
            // Assign user to group
            $groupId = $this->request->getPost('group_id');
            $this->userModel->addToGroup($userId, $groupId);

            session()->setFlashdata('success', 'Ο χρήστης δημιουργήθηκε επιτυχώς!');
            return redirect()->to('/admin/users');
        }

        session()->setFlashdata('error', 'Σφάλμα κατά τη δημιουργία του χρήστη.');
        return redirect()->back()->withInput();
    }

    /**
     * Show user details
     */
    public function show($id)
    {
        $user = $this->userModel->getUserWithGroups($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ο χρήστης δεν βρέθηκε');
        }

        $loginAttempts = $this->userModel->getLoginAttempts($user['email'], 10);
        
        $data = [
            'title' => 'Προβολή Χρήστη - PHA Manager v4',
            'user' => $user,
            'login_attempts' => $loginAttempts
        ];

        return view('admin/users/show', $data);
    }

    /**
     * Show edit user form
     */
    public function edit($id)
    {
        $user = $this->userModel->getUserWithGroups($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ο χρήστης δεν βρέθηκε');
        }

        $groups = $this->groupModel->findAll();
        
        $data = [
            'title' => 'Επεξεργασία Χρήστη - PHA Manager v4',
            'user' => $user,
            'groups' => $groups,
            'validation' => session()->getFlashdata('validation')
        ];

        return view('admin/users/edit', $data);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ο χρήστης δεν βρέθηκε');
        }

        $validation = service('validation');
        
        $rules = [
            'username' => "required|min_length[3]|max_length[100]|is_unique[users.username,id,{$id}]",
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'first_name' => 'required|max_length[50]',
            'last_name' => 'required|max_length[50]',
            'group_id' => 'required|integer'
        ];

        // Only validate password if provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'active' => $this->request->getPost('active') ? 1 : 0,
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'company' => $this->request->getPost('company'),
            'phone' => $this->request->getPost('phone')
        ];

        // Update password if provided
        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $userData)) {
            // Update user group
            $groupId = $this->request->getPost('group_id');
            $this->userModel->removeFromAllGroups($id);
            $this->userModel->addToGroup($id, $groupId);

            session()->setFlashdata('success', 'Ο χρήστης ενημερώθηκε επιτυχώς!');
            return redirect()->to('/admin/users');
        }

        session()->setFlashdata('error', 'Σφάλμα κατά την ενημέρωση του χρήστη.');
        return redirect()->back()->withInput();
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            session()->setFlashdata('error', 'Ο χρήστης δεν βρέθηκε.');
            return redirect()->to('/admin/users');
        }

        // Don't allow deleting the current user
        if ($id == current_user_id()) {
            session()->setFlashdata('error', 'Δεν μπορείτε να διαγράψετε τον εαυτό σας.');
            return redirect()->to('/admin/users');
        }

        if ($this->userModel->delete($id)) {
            session()->setFlashdata('success', 'Ο χρήστης διαγράφηκε επιτυχώς!');
        } else {
            session()->setFlashdata('error', 'Σφάλμα κατά τη διαγραφή του χρήστη.');
        }

        return redirect()->to('/admin/users');
    }

    /**
     * Activate user
     */
    public function activate($id)
    {
        if ($this->userModel->update($id, ['active' => 1])) {
            session()->setFlashdata('success', 'Ο χρήστης ενεργοποιήθηκε επιτυχώς!');
        } else {
            session()->setFlashdata('error', 'Σφάλμα κατά την ενεργοποίηση του χρήστη.');
        }

        return redirect()->to('/admin/users');
    }

    /**
     * Deactivate user
     */
    public function deactivate($id)
    {
        // Don't allow deactivating the current user
        if ($id == current_user_id()) {
            session()->setFlashdata('error', 'Δεν μπορείτε να απενεργοποιήσετε τον εαυτό σας.');
            return redirect()->to('/admin/users');
        }

        if ($this->userModel->update($id, ['active' => 0])) {
            session()->setFlashdata('success', 'Ο χρήστης απενεργοποιήθηκε επιτυχώς!');
        } else {
            session()->setFlashdata('error', 'Σφάλμα κατά την απενεργοποίηση του χρήστη.');
        }

        return redirect()->to('/admin/users');
    }
}