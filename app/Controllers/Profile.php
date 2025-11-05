<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Profile extends BaseController
{
    public function __construct()
    {
        helper(['form']);
    }

    public function index()
    {
        $data = [
            'title' => 'Προφίλ Χρήστη - PHA Manager v4',
            'page_title' => 'Προφίλ Χρήστη',
            'page_description' => 'Διαχείριση προσωπικών στοιχείων και προτιμήσεων',
            'breadcrumbs' => ['Προφίλ'],
            'user' => [
                'username' => session()->get('username'),
                'email' => session()->get('email') ?: 'user@example.com',
                'full_name' => session()->get('full_name') ?: 'Χρήστης Συστήματος',
                'role' => session()->get('role') ?: 'Χρήστης'
            ]
        ];

        return view('layouts/main', $data, ['content' => view('profile/index', $data)]);
    }

    public function update()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'full_name' => 'required|min_length[2]|max_length[255]',
            'email' => 'required|valid_email|max_length[255]',
            'current_password' => 'permit_empty|min_length[6]',
            'new_password' => 'permit_empty|min_length[6]',
            'confirm_password' => 'permit_empty|matches[new_password]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error', 'Παρακαλώ διορθώστε τα σφάλματα στη φόρμα.');
            return redirect()->to('profile')->withInput();
        }

        // Implement profile update logic here
        session()->setFlashdata('success', 'Το προφίλ ενημερώθηκε επιτυχώς.');
        return redirect()->to('profile');
    }
}