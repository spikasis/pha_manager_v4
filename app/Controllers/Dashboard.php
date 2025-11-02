<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard - PHA Manager v4'
        ];
        
        return view('dashboard/index', $data);
    }
}
