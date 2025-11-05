<?php

namespace App\Controllers;

class DirectLogin extends BaseController
{
    public function index()
    {
        // If already logged in, go to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/direct_login');
    }

    public function login()
    {
        // DIRECT LOGIN - NO VALIDATION, NO DATABASE
        // Just set session and redirect
        
        session()->set([
            'user_id' => 1,
            'username' => 'spikasis',
            'email' => 'spikasis@gmail.com',
            'first_name' => 'Spiros', 
            'last_name' => 'Pikasis',
            'logged_in' => true,
            'is_logged_in' => true,
            'group_id' => 1
        ]);

        session()->setFlashdata('success', 'Καλώς ήρθατε! Direct Login επιτυχής.');

        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('direct-login'))->with('success', 'Αποσυνδεθήκατε επιτυχώς');
    }
}