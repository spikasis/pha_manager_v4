<?php

namespace App\Controllers;

class AuthBypass extends BaseController
{
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/bypass_login');
    }

    public function attemptLogin()
    {
        try {
            $email = $this->request->getPost('login');
            $password = $this->request->getPost('password');

            // Basic validation
            if (empty($email) || empty($password)) {
                return redirect()->back()->with('error', 'Παρακαλώ συμπληρώστε όλα τα πεδία');
            }

            // Load user model
            $userModel = new \App\Models\UserModel();
            
            // Find user by email or username
            $user = $userModel->where('email', $email)
                             ->orWhere('username', $email)
                             ->where('is_active', 1)
                             ->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Μη έγκυροι διαπιστευτήρια');
            }

            // Verify password (assuming plain text for now - NOT SECURE!)
            if ($user['password'] !== $password) {
                return redirect()->back()->with('error', 'Μη έγκυροι διαπιστευτήρια');
            }

            // Set session data
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'group_id' => $user['group_id'],
                'is_logged_in' => true
            ]);

            // Update last login
            $userModel->update($user['id'], [
                'last_login' => date('Y-m-d H:i:s')
            ]);

            // Redirect based on role
            switch ($user['group_id']) {
                case 1: // Admin
                    return redirect()->to('/dashboard')->with('success', 'Καλώς ήρθατε, Διαχειριστή!');
                case 2: // Manager  
                    return redirect()->to('/dashboard')->with('success', 'Καλώς ήρθατε!');
                case 3: // User
                    return redirect()->to('/dashboard')->with('success', 'Καλώς ήρθατε!');
                default:
                    return redirect()->to('/dashboard')->with('success', 'Καλώς ήρθατε!');
            }

        } catch (\Exception $e) {
            log_message('error', 'AuthBypass::attemptLogin Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Σφάλμα σύνδεσης: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Αποσυνδεθήκατε επιτυχώς');
    }
}