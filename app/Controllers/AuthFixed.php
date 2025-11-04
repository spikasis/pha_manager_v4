<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthFixed extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/login', ['title' => 'Σύνδεση']);
    }

    public function attemptLogin()
    {
        // Get POST data
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        // Basic validation
        if (empty($login) || empty($password)) {
            session()->setFlashdata('error', 'Παρακαλώ συμπληρώστε email και κωδικό');
            return redirect()->to('/login')->withInput();
        }

        try {
            // Find user by email/username
            $user = $this->userModel->findByLogin($login);

            if (!$user) {
                session()->setFlashdata('error', 'Λάθος στοιχεία σύνδεσης');
                return redirect()->to('/login')->withInput();
            }

            // Check password
            if (!password_verify($password, $user['password'])) {
                session()->setFlashdata('error', 'Λάθος στοιχεία σύνδεσης');
                return redirect()->to('/login')->withInput();
            }

            // Check if active
            if (!$user['active']) {
                session()->setFlashdata('error', 'Ο λογαριασμός σας δεν είναι ενεργός');
                return redirect()->to('/login');
            }

            // Update last login (don't fail if this fails)
            try {
                $this->userModel->updateLastLogin($user['id']);
            } catch (\Exception $e) {
                // Log but don't fail
                log_message('warning', 'Could not update last login: ' . $e->getMessage());
            }

            // Set session data
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'logged_in' => true
            ];

            session()->set($sessionData);

            // Success message
            $name = !empty($user['first_name']) ? $user['first_name'] : $user['username'];
            session()->setFlashdata('success', "Καλώς ήρθατε, {$name}!");

            // Redirect to dashboard
            return redirect()->to('/dashboard');

        } catch (\Exception $e) {
            // Log the actual error
            log_message('error', 'AuthFixed Login Error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            
            session()->setFlashdata('error', 'Παρουσιάστηκε σφάλμα. Προσπαθήστε ξανά.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Αποσυνδεθήκατε επιτυχώς');
        return redirect()->to('/login');
    }
}