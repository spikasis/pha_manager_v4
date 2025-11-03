<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardSimple extends BaseController
{
    public function index()
    {
        // Check if logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth-simple/login');
        }
        
        $data = [
            'title' => 'Dashboard - PHA Manager',
            'user' => [
                'id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'email' => session()->get('email'),
                'first_name' => session()->get('first_name'),
                'last_name' => session()->get('last_name')
            ]
        ];
        
        return view('dashboard/simple', $data);
    }
}