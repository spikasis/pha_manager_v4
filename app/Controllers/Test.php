<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        echo "<h1>Test Page - Login Successful!</h1>";
        echo "<p>If you see this page, the authentication and routing are working.</p>";
        echo "<p>Base URL: " . base_url() . "</p>";
        echo "<p>Current URL: " . current_url() . "</p>";
        echo "<p>Session data:</p>";
        echo "<pre>" . print_r(session()->get(), true) . "</pre>";
        exit;
    }
}