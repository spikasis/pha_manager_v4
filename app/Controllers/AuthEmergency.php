<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

/**
 * Emergency Auth Controller
 * Simplified login handling for production issues
 */
class AuthEmergency extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Display login form
     */
    public function login()
    {
        $data = [
            'title' => 'Σύνδεση - Emergency Mode',
            'validation' => session('validation')
        ];

        return view('auth/login', $data);
    }

    /**
     * Simple, robust login attempt
     */
    public function attemptLogin()
    {
        try {
            // Check if this is a POST request
            if ($this->request->getMethod() !== 'post') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Μόνο POST αιτήματα επιτρέπονται'
                ]);
            }

            // Get login data
            $login = $this->request->getPost('login');
            $password = $this->request->getPost('password');
            $remember = (bool) $this->request->getPost('remember');

            // Basic validation
            if (empty($login) || empty($password)) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Παρακαλώ συμπληρώστε email και κωδικό'
                    ]);
                } else {
                    session()->setFlashdata('error', 'Παρακαλώ συμπληρώστε email και κωδικό');
                    return redirect()->back()->withInput();
                }
            }

            // Try to find user
            $user = $this->userModel->findByLogin($login);

            if (!$user) {
                $message = 'Λάθος στοιχεία σύνδεσης';
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => $message
                    ]);
                } else {
                    session()->setFlashdata('error', $message);
                    return redirect()->back()->withInput();
                }
            }

            // Verify password
            if (!password_verify($password, $user['password'])) {
                $message = 'Λάθος στοιχεία σύνδεσης';
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => $message
                    ]);
                } else {
                    session()->setFlashdata('error', $message);
                    return redirect()->back()->withInput();
                }
            }

            // Check if user is active
            if (!$user['active']) {
                $message = 'Ο λογαριασμός δεν είναι ενεργός';
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => $message
                    ]);
                } else {
                    session()->setFlashdata('error', $message);
                    return redirect()->back();
                }
            }

            // Login successful - set session
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'full_name' => $user['first_name'] . ' ' . $user['last_name'],
                'is_logged_in' => true
            ]);

            // Update last login
            try {
                $this->userModel->update($user['id'], [
                    'last_login' => time(),
                    'ip_address' => $this->request->getIPAddress()
                ]);
            } catch (\Exception $e) {
                // Don't fail login if we can't update last_login
                log_message('warning', 'Could not update last login: ' . $e->getMessage());
            }

            $message = 'Επιτυχής σύνδεση!';
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'redirect' => base_url('dashboard')
                ]);
            } else {
                session()->setFlashdata('success', $message);
                return redirect()->to('dashboard');
            }

        } catch (\Exception $e) {
            // Log the full error
            log_message('error', 'Emergency Auth Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            
            $message = 'Προέκυψε σφάλμα. Δοκιμάστε ξανά.';
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'debug' => [
                        'error' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]
                ]);
            } else {
                session()->setFlashdata('error', $message);
                return redirect()->back();
            }
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Αποσύνδεση επιτυχής');
        return redirect()->to('auth-emergency/login');
    }

    /**
     * Check if user is logged in
     */
    protected function isLoggedIn()
    {
        return session()->has('user_id') && session()->get('is_logged_in') === true;
    }
}