<?php

namespace App\Controllers;

class SimpleTest extends BaseController
{
    public function index()
    {
        // Very basic output without any CodeIgniter helpers
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Simple Test - PHA Manager</title>
        </head>
        <body>
            <h1>✅ Simple Test Page Works!</h1>
            <p>If you see this page, basic routing is working.</p>
            <p>Server: <?php echo $_SERVER['HTTP_HOST'] ?? 'Unknown'; ?></p>
            <p>Request URI: <?php echo $_SERVER['REQUEST_URI'] ?? 'Unknown'; ?></p>
            <p>Script Name: <?php echo $_SERVER['SCRIPT_NAME'] ?? 'Unknown'; ?></p>
            <p>Time: <?php echo date('Y-m-d H:i:s'); ?></p>
            
            <h2>Session Test</h2>
            <?php
            if (session_id() == '') {
                session_start();
            }
            ?>
            <p>Session ID: <?php echo session_id(); ?></p>
            <p>Session Data: <?php var_dump($_SESSION); ?></p>
            
            <h2>Navigation Tests</h2>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/auth/login">Login</a></li>
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="/test">Test</a></li>
            </ul>
        </body>
        </html>
        <?php
        exit;
    }
}