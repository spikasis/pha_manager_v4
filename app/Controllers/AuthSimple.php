<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthSimple extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Show login page
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard-simple');
        }
        
        $data = [
            'title' => 'Σύνδεση - PHA Manager',
            'validation' => session('validation')
        ];
        
        return view('auth/simple_login', $data);
    }

    /**
     * Process login attempt
     */
    public function attemptLogin()
    {
        // Basic validation
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        
        if (empty($login) || empty($password)) {
            session()->setFlashdata('error', 'Παρακαλώ συμπληρώστε όλα τα πεδία');
            return redirect()->back()->withInput();
        }
        
        try {
            // Find user
            $user = $this->userModel->findByLogin($login);
            
            if (!$user) {
                session()->setFlashdata('error', 'Δεν βρέθηκε χρήστης με αυτά τα στοιχεία');
                return redirect()->back()->withInput();
            }
            
            // Verify password
            if (!password_verify($password, $user['password'])) {
                session()->setFlashdata('error', 'Λάθος κωδικός');
                return redirect()->back()->withInput();
            }
            
            // Check if active
            if (!$user['active']) {
                session()->setFlashdata('error', 'Ο λογαριασμός δεν είναι ενεργός');
                return redirect()->back();
            }
            
            // Update last login
            $this->userModel->updateLastLogin($user['id']);
            
            // Set session
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'logged_in' => true
            ];
            
            session()->set($sessionData);
            
            session()->setFlashdata('success', 'Καλώς ήρθατε, ' . ($user['first_name'] ?: $user['username']) . '!');
            
            // Simple redirect to dashboard
            return redirect()->to('/dashboard-simple');
            
        } catch (\Exception $e) {
            log_message('error', 'Simple Auth Error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα σύνδεσης: ' . $e->getMessage());
            return redirect()->back();
        }
    }
    
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Αποσυνδεθήκατε επιτυχώς');
        return redirect()->to('/auth-simple/login');
    }
}