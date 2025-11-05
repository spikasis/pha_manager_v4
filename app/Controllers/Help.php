<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Help extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Βοήθεια - PHA Manager v4',
            'page_title' => 'Βοήθεια & Υποστήριξη',
            'page_description' => 'Οδηγός χρήσης και συχνές ερωτήσεις',
            'breadcrumbs' => ['Βοήθεια']
        ];

        return view('layouts/main', $data, ['content' => view('help/index', $data)]);
    }
}