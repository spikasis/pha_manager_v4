<?php
/**
 * Redirect Index for PHA Manager v4
 * 
 * This file should be placed in the web root (public_html)
 * and redirects all traffic to the CodeIgniter public folder
 */

// Define the path to CodeIgniter's public folder relative to this file
define('FCPATH', __DIR__ . '/pha_manager_v4/public/');

// Check if the CodeIgniter index.php exists
if (file_exists(FCPATH . 'index.php')) {
    // Include the CodeIgniter bootstrap
    include_once FCPATH . 'index.php';
} else {
    // Fallback error message
    http_response_code(500);
    echo '<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHA Manager v4 - Setup Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .error-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
        }
        .error-icon {
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        h1 {
            color: #dc3545;
            margin-bottom: 20px;
        }
        .details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-family: monospace;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1>PHA Manager v4 Setup Error</h1>
        <p>Το σύστημα δεν μπορεί να βρει τα αρχεία του CodeIgniter.</p>
        
        <div class="details">
            <strong>Expected Path:</strong><br>
            ' . FCPATH . 'index.php<br><br>
            
            <strong>Current Directory:</strong><br>
            ' . __DIR__ . '<br><br>
            
            <strong>Solution:</strong><br>
            1. Ανεβάστε τα αρχεία του PHA Manager v4 στον φάκελο pha_manager_v4/<br>
            2. Ή αλλάξτε το Document Root στο hosting panel
        </div>
        
        <p style="margin-top: 20px; color: #666;">
            Για υποστήριξη επικοινωνήστε με τη διαχείριση.
        </p>
    </div>
</body>
</html>';
}
?>