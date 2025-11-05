<!DOCTYPE html><?php

<html lang="el">echo "Test page working - " . date('Y-m-d H:i:s');

<head>echo "<br><br>";

    <meta charset="utf-8">echo "Session status: ";

    <meta name="viewport" content="width=device-width, initial-scale=1">if (session_status() === PHP_SESSION_ACTIVE) {

    <title>Test - PHA Manager v4</title>    echo "ACTIVE";

    <style>} else {

        body {    echo "NOT ACTIVE";

            font-family: Arial, sans-serif;}

            background: #4e73df;echo "<br>";

            color: white;echo "CodeIgniter environment: " . (defined('ENVIRONMENT') ? ENVIRONMENT : 'NOT SET');

            text-align: center;?>
            padding: 50px;
        }
        .test-card {
            background: white;
            color: black;
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="test-card">
        <h1>Test Page</h1>
        <p>Αυτή είναι μια test σελίδα</p>
        <p><strong>Base URL:</strong> <?= base_url() ?></p>
        <p><strong>Current Time:</strong> <?= date('d/m/Y H:i:s') ?></p>
        
        <div style="margin-top: 20px;">
            <a href="<?= site_url() ?>" style="background: #4e73df; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Πίσω στο Login</a>
        </div>
    </div>
    
    <script>
        console.log('Test page loaded successfully');
    </script>
</body>
</html>