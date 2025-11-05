<?php

namespace App\Controllers;

class DebugInfo extends BaseController
{
    public function index()
    {
        // Security: Only show in development
        if (ENVIRONMENT === 'production') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('debug/phpinfo');
    }

    public function settings()
    {
        $settings = [
            'PHP Version' => phpversion(),
            'CodeIgniter Version' => \CodeIgniter\CodeIgniter::CI_VERSION,
            'Environment' => ENVIRONMENT,
            'Base URL' => base_url(),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'max_input_time' => ini_get('max_input_time'),
            'max_input_vars' => ini_get('max_input_vars'),
            'session.save_handler' => ini_get('session.save_handler'),
            'session.save_path' => ini_get('session.save_path'),
            'date.timezone' => ini_get('date.timezone'),
        ];

        return $this->response->setJSON([
            'status' => 'success',
            'settings' => $settings,
            'session_data' => session()->get(),
            'server_info' => [
                'HTTP_HOST' => $_SERVER['HTTP_HOST'] ?? 'N/A',
                'SERVER_NAME' => $_SERVER['SERVER_NAME'] ?? 'N/A',
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? 'N/A',
                'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? 'N/A',
            ]
        ]);
    }
}