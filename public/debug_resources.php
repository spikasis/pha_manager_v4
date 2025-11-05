<!DOCTYPE html>
<html>
<head>
    <title>Resource Debug - PHA Manager v4</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f8f9fc;
        }
        .debug-section {
            background: white;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
        .resource-test {
            margin: 10px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>🔧 PHA Manager v4 - Resource Debug</h1>
    
    <div class="debug-section">
        <h2>📂 Base URL Configuration</h2>
        <p><strong>Base URL:</strong> <?= base_url() ?></p>
        <p><strong>Current URL:</strong> <?= current_url() ?></p>
        <p><strong>Site URL:</strong> <?= site_url() ?></p>
    </div>

    <div class="debug-section">
        <h2>🎨 CSS Resource Tests</h2>
        
        <div class="resource-test">
            <h4>FontAwesome CSS</h4>
            <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
            <p>Path: <?= base_url('vendor/fontawesome-free/css/all.min.css') ?></p>
            <p>Test Icon: <i class="fas fa-check-circle success"></i> <i class="fas fa-assistive-listening-systems"></i></p>
        </div>

        <div class="resource-test">
            <h4>SB Admin 2 CSS</h4>
            <link href="<?= base_url('sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet" type="text/css">
            <p>Path: <?= base_url('sbadmin2/css/sb-admin-2.min.css') ?></p>
            <button class="btn btn-primary">Bootstrap Button Test</button>
        </div>

        <div class="resource-test">
            <h4>Bootstrap 5 CDN</h4>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <p>CDN: https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css</p>
            <div class="alert alert-success">Bootstrap 5 Alert Test</div>
        </div>
    </div>

    <div class="debug-section">
        <h2>🔗 JavaScript Resource Tests</h2>
        
        <div class="resource-test">
            <h4>jQuery</h4>
            <p>Path: <?= base_url('vendor/jquery/jquery.min.js') ?></p>
            <p id="jquery-status">Loading...</p>
        </div>

        <div class="resource-test">
            <h4>Bootstrap JS</h4>
            <p>Path: <?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?></p>
            <p id="bootstrap-status">Loading...</p>
        </div>
    </div>

    <div class="debug-section">
        <h2>🌐 Network Test</h2>
        <div class="resource-test">
            <h4>External CDN Test</h4>
            <p id="cdn-test">Testing external CDNs...</p>
        </div>
    </div>

    <!-- Load Resources -->
    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script>
        // Test jQuery
        if (typeof jQuery !== 'undefined') {
            document.getElementById('jquery-status').innerHTML = '<span class="success">✅ jQuery Loaded Successfully (v' + jQuery.fn.jquery + ')</span>';
        } else {
            document.getElementById('jquery-status').innerHTML = '<span class="error">❌ jQuery Failed to Load</span>';
            // Fallback to CDN
            document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
        }
    </script>

    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        // Test Bootstrap
        setTimeout(function() {
            if (typeof bootstrap !== 'undefined') {
                document.getElementById('bootstrap-status').innerHTML = '<span class="success">✅ Bootstrap JS Loaded Successfully</span>';
            } else {
                document.getElementById('bootstrap-status').innerHTML = '<span class="error">❌ Bootstrap JS Failed to Load</span>';
            }

            // Test CDN connectivity
            var img = new Image();
            img.onload = function() {
                document.getElementById('cdn-test').innerHTML = '<span class="success">✅ CDN Connectivity OK</span>';
            };
            img.onerror = function() {
                document.getElementById('cdn-test').innerHTML = '<span class="error">❌ CDN Connectivity Failed</span>';
            };
            img.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css';
        }, 1000);
    </script>

    <div class="debug-section">
        <h2>🚀 Actions</h2>
        <a href="<?= site_url() ?>" class="btn btn-primary">← Back to Login</a>
        <a href="<?= site_url('auth') ?>" class="btn btn-success">Auth Page</a>
        <a href="<?= site_url('dashboard') ?>" class="btn btn-info">Dashboard</a>
    </div>
</body>
</html>