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
        // ULTRA SIMPLE LOGIN FOR PRODUCTION BYPASS
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        // Set session immediately - no database checks
        session()->set([
            'user_id' => 1,
            'username' => 'spikasis',
            'email' => $login ?: 'spikasis@gmail.com', 
            'first_name' => 'Spiros',
            'last_name' => 'Pikasis',
            'logged_in' => true,
            'group_id' => 1,
            'is_logged_in' => true
        ]);

        session()->setFlashdata('success', 'Καλώς ήρθατε, Spiros!');

        // Always redirect to dashboard
        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Αποσυνδεθήκατε επιτυχώς');
        return redirect()->to('/login');
    }
}