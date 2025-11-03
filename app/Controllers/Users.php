<?php

namespace App\Controllers;

use App\Controllers\BaseCRUD;
use App\Models\UserModel;
use App\Models\GroupModel;

/**
 * Users Controller
 * 
 * Manages user CRUD operations for the system administration
 */
class Users extends BaseCRUD
{
    protected $model;
    protected $tableName = 'users';
    protected $viewPath = 'users/';
    protected $pageTitle = 'Χρήστες';
    
    // Validation rules for BaseCRUD
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'password' => 'required|min_length[6]',
        'first_name' => 'permit_empty|max_length[50]',
        'last_name' => 'permit_empty|max_length[50]',
        'company' => 'permit_empty|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
        'branch_id' => 'permit_empty|integer'
    ];

    public function __construct()
    {
        $this->model = new UserModel();
    }
    
    /**
     * Apply search filter to the model
     */
    protected function applySearchFilter($search)
    {
        $this->model->groupStart();
        $this->model->like('username', $search);
        $this->model->orLike('email', $search);
        $this->model->orLike('first_name', $search);
        $this->model->orLike('last_name', $search);
        $this->model->orLike('company', $search);
        $this->model->orLike('phone', $search);
        $this->model->groupEnd();
    }
    
    /**
     * Format row data for display
     */
    protected function formatRowData($record)
    {
        return [
            'id' => $record['id'],
            'username' => esc($record['username']),
            'email' => esc($record['email']),
            'first_name' => esc($record['first_name'] ?? ''),
            'last_name' => esc($record['last_name'] ?? ''),
            'full_name' => esc(($record['first_name'] ?? '') . ' ' . ($record['last_name'] ?? '')),
            'company' => esc($record['company'] ?? '-'),
            'phone' => esc($record['phone'] ?? '-'),
            'active' => $record['active'] ? '<span class="badge badge-success">Ενεργός</span>' : '<span class="badge badge-secondary">Ανενεργός</span>',
            'last_login' => !empty($record['last_login']) ? date('d/m/Y H:i', $record['last_login']) : 'Ποτέ',
            'created_on' => !empty($record['created_on']) ? date('d/m/Y H:i', $record['created_on']) : '-'
        ];
    }
    
    /**
     * Show create form with groups
     */
    public function create()
    {
        $data = $this->getFormData();
        $data['title'] = 'Δημιουργία ' . $this->pageTitle;
        $data['formAction'] = site_url($this->viewPath . 'store');
        $data['cancelUrl'] = site_url($this->viewPath);
        $data['formData'] = [];
        $data['errors'] = session('errors') ?? [];
        
        return view($this->viewPath . 'create', $data);
    }
    
    /**
     * Show edit form with groups
     */
    public function edit($id)
    {
        $record = $this->model->find($id);
        
        if (!$record) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $data = $this->getFormData();
        $data['title'] = 'Επεξεργασία ' . $this->pageTitle;
        $data['formAction'] = site_url($this->viewPath . 'update/' . $id);
        $data['cancelUrl'] = site_url($this->viewPath);
        $data['formData'] = $record;
        $data['errors'] = session('errors') ?? [];
        $data['userGroups'] = $this->model->getUserGroups($id);
        
        return view($this->viewPath . 'edit', $data);
    }
    
    /**
     * Store with password hashing and groups
     */
    public function store()
    {
        $rules = $this->validationRules;
        $rules['password_confirm'] = 'required|matches[password]';
        $rules['email'] .= '|is_unique[users.email]';
        $rules['username'] .= '|is_unique[users.username]';
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        try {
            $data = $this->getFormData();
            
            // Hash password
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            
            // Remove password confirmation
            unset($data['password_confirm']);
            
            // Set default values
            $data['active'] = isset($data['active']) ? 1 : 0;
            $data['created_on'] = time();
            
            $userId = $this->model->insert($data);
            
            if ($userId) {
                // Assign groups if selected
                if (!empty($data['groups'])) {
                    foreach ($data['groups'] as $groupId) {
                        $this->model->addToGroup($userId, $groupId);
                    }
                }
                
                session()->setFlashdata('success', 'Ο χρήστης δημιουργήθηκε επιτυχώς!');
                return redirect()->to($this->viewPath);
            } else {
                session()->setFlashdata('error', 'Σφάλμα κατά τη δημιουργία του χρήστη!');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            log_message('error', 'Error creating user: ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    /**
     * Update with password handling and groups
     */
    public function update($id)
    {
        $record = $this->model->find($id);
        
        if (!$record) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $rules = $this->validationRules;
        
        // Check for unique constraints excluding current user
        $rules['email'] .= '|is_unique[users.email,id,' . $id . ']';
        $rules['username'] .= '|is_unique[users.username,id,' . $id . ']';
        
        // Password is optional on update
        $rules['password'] = 'permit_empty|min_length[6]';
        
        if (!empty($this->request->getPost('password'))) {
            $rules['password_confirm'] = 'required|matches[password]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        try {
            $data = $this->getFormData();
            
            // Handle password update
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                unset($data['password']);
            }
            
            // Remove password confirmation
            unset($data['password_confirm']);
            
            // Set active status
            $data['active'] = isset($data['active']) ? 1 : 0;
            
            if ($this->model->update($id, $data)) {
                // Update groups if provided
                if (isset($data['groups'])) {
                    // Remove existing groups
                    $existingGroups = $this->model->getUserGroups($id);
                    foreach ($existingGroups as $group) {
                        $this->model->removeFromGroup($id, $group['id']);
                    }
                    
                    // Add new groups
                    foreach ($data['groups'] as $groupId) {
                        $this->model->addToGroup($id, $groupId);
                    }
                }
                
                session()->setFlashdata('success', 'Ο χρήστης ενημερώθηκε επιτυχώς!');
                return redirect()->to($this->viewPath);
            } else {
                session()->setFlashdata('error', 'Σφάλμα κατά την ενημέρωση του χρήστη!');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            log_message('error', 'Error updating user: ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    /**
     * Get form data including groups
     */
    protected function getFormData()
    {
        try {
            $groupModel = new GroupModel();
            $groups = $groupModel->findAll();
        } catch (\Exception $e) {
            // If GroupModel doesn't exist, create basic options
            $groups = [
                ['id' => 1, 'name' => 'Admin', 'description' => 'Administrators'],
                ['id' => 2, 'name' => 'User', 'description' => 'Regular Users']
            ];
        }
        
        return [
            'groups' => $groups,
            'branches' => $this->getBranchOptions()
        ];
    }
    
    /**
     * Get branch options for dropdown
     */
    protected function getBranchOptions()
    {
        try {
            // Try to get from selling_points table
            $db = \Config\Database::connect();
            $builder = $db->table('selling_points');
            $results = $builder->select('id, city as name')->get()->getResultArray();
            
            return array_column($results, 'name', 'id');
        } catch (\Exception $e) {
            // Fallback options
            return [
                1 => 'Κεντρικό Κατάστημα',
                2 => 'Υποκατάστημα 1'
            ];
        }
    }
    
    /**
     * Toggle user active status
     */
    public function toggleActive($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to($this->viewPath);
        }
        
        try {
            $user = $this->model->find($id);
            
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ο χρήστης δεν βρέθηκε!'
                ]);
            }
            
            $newStatus = $user['active'] ? 0 : 1;
            
            if ($this->model->update($id, ['active' => $newStatus])) {
                $statusText = $newStatus ? 'ενεργοποιήθηκε' : 'απενεργοποιήθηκε';
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Ο χρήστης ' . $statusText . ' επιτυχώς!',
                    'active' => $newStatus
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Σφάλμα κατά την ενημέρωση της κατάστασης!'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error toggling user status: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Σφάλμα: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Generate action buttons with toggle active
     */
    protected function generateActionButtons($id)
    {
        $viewUrl = site_url($this->viewPath . 'show/' . $id);
        $editUrl = site_url($this->viewPath . 'edit/' . $id);
        $deleteUrl = site_url($this->viewPath . 'delete/' . $id);
        $toggleUrl = site_url($this->viewPath . 'toggleActive/' . $id);
        
        return '
            <div class="btn-group" role="group">
                <a href="' . $viewUrl . '" class="btn btn-info btn-sm" title="Προβολή">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="' . $editUrl . '" class="btn btn-warning btn-sm" title="Επεξεργασία">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn btn-secondary btn-sm" onclick="toggleUserActive(' . $id . ')" title="Ενεργοποίηση/Απενεργοποίηση">
                    <i class="fas fa-power-off"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $id . ')" title="Διαγραφή">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        ';
    }
}