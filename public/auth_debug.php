<!DOCTYPE html>
<html>
<head>
    <title>Authentication Debug - PHA Manager v4</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .debug-box { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .info { color: #17a2b8; }
        .warning { color: #ffc107; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .btn { display: inline-block; padding: 10px 20px; margin: 5px; text-decoration: none; border-radius: 5px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-warning { background: #ffc107; color: black; }
    </style>
</head>
<body>
    <h1>🔍 Authentication & Routing Debug - PHA Manager v4</h1>
    
    <div class="debug-box">
        <h2>🌐 Environment Information</h2>
        <p><strong>Base URL:</strong> <?= base_url() ?></p>
        <p><strong>Current URL:</strong> <?= current_url() ?></p>
        <p><strong>Site URL:</strong> <?= site_url() ?></p>
        <p><strong>Environment:</strong> <?= ENVIRONMENT ?></p>
        <p><strong>CI Version:</strong> <?= \CodeIgniter\CodeIgniter::CI_VERSION ?></p>
    </div>

    <div class="debug-box">
        <h2>🔐 Session Status</h2>
        <?php
        $session = session();
        $sessionData = $session->get();
        ?>
        <p><strong>Session ID:</strong> <?= session_id() ?></p>
        <p><strong>Session Driver:</strong> <?= get_class($session) ?></p>
        <p><strong>Logged In:</strong> 
            <?php if ($session->get('logged_in')): ?>
                <span class="success">✅ Yes</span>
            <?php else: ?>
                <span class="error">❌ No</span>
            <?php endif; ?>
        </p>
        
        <?php if ($session->get('logged_in')): ?>
            <p><strong>Username:</strong> <?= $session->get('username') ?></p>
            <p><strong>User ID:</strong> <?= $session->get('user_id') ?></p>
            <p><strong>Role:</strong> <?= $session->get('role') ?></p>
            <p><strong>Login Time:</strong> <?= date('d/m/Y H:i:s', $session->get('login_time') ?: time()) ?></p>
        <?php endif; ?>

        <h4>Full Session Data:</h4>
        <pre><?= print_r($sessionData, true) ?></pre>
    </div>

    <div class="debug-box">
        <h2>📂 File System Check</h2>
        <?php
        $checks = [
            'AuthController' => APPPATH . 'Controllers/AuthController.php',
            'Dashboard Controller' => APPPATH . 'Controllers/Dashboard.php',
            'Login View' => APPPATH . 'Views/auth/login.php',
            'Routes Config' => APPPATH . 'Config/Routes.php',
            'FontAwesome CSS' => FCPATH . 'vendor/fontawesome-free/css/all.min.css',
            'SB Admin CSS' => FCPATH . 'sbadmin2/css/sb-admin-2.min.css',
            'jQuery JS' => FCPATH . 'vendor/jquery/jquery.min.js',
            'Bootstrap JS' => FCPATH . 'vendor/bootstrap/js/bootstrap.bundle.min.js'
        ];

        foreach ($checks as $name => $path):
            $exists = file_exists($path);
        ?>
            <p>
                <strong><?= $name ?>:</strong>
                <?php if ($exists): ?>
                    <span class="success">✅ EXISTS</span> - <?= $path ?>
                <?php else: ?>
                    <span class="error">❌ MISSING</span> - <?= $path ?>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
    </div>

    <div class="debug-box">
        <h2>🔄 Route Testing</h2>
        <?php
        $routes = [
            'Base URL' => base_url(),
            'Auth Index' => site_url('auth'),
            'Auth Login' => site_url('auth/login'),
            'Auth Logout' => site_url('auth/logout'),
            'Dashboard' => site_url('dashboard'),
            'Force Logout' => site_url('auth?force_logout=1')
        ];

        foreach ($routes as $name => $url):
        ?>
            <p><strong><?= $name ?>:</strong> <a href="<?= $url ?>" target="_blank"><?= $url ?></a></p>
        <?php endforeach; ?>
    </div>

    <div class="debug-box">
        <h2>⚡ Actions</h2>
        <a href="<?= site_url() ?>" class="btn btn-primary">🏠 Home</a>
        <a href="<?= site_url('auth') ?>" class="btn btn-success">🔐 Auth Page</a>
        <a href="<?= site_url('auth/login') ?>" class="btn btn-success">➡️ Direct Login</a>
        <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">📊 Dashboard</a>
        <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger">🚪 Logout</a>
        <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-warning">🧹 Force Clear Session</a>
    </div>

    <div class="debug-box">
        <h2>🔧 CSS/JS Test</h2>
        
        <!-- Test CSS Loading -->
        <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('sbladmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
        
        <p>FontAwesome Icon Test: <i class="fas fa-check-circle success"></i> <i class="fas fa-assistive-listening-systems info"></i> <i class="fas fa-user warning"></i></p>
        <button class="btn btn-primary">Bootstrap Button Test</button>
        
        <div id="js-test" style="margin-top: 20px;">
            <p><strong>JavaScript Status:</strong> <span id="js-status">Loading...</span></p>
        </div>
        
        <!-- Test JS Loading -->
        <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
        <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script>
            document.getElementById('js-status').innerHTML = 
                (typeof jQuery !== 'undefined' ? '✅ jQuery Loaded' : '❌ jQuery Failed') +
                ' | ' +
                (typeof bootstrap !== 'undefined' ? '✅ Bootstrap Loaded' : '❌ Bootstrap Failed');
        </script>
    </div>

    <div class="debug-box">
        <h2>📋 Recommendations</h2>
        <ul>
            <li class="info">✅ Check if all CSS/JS files exist in the expected paths</li>
            <li class="info">✅ Verify that .htaccess allows access to vendor directory</li>
            <li class="info">✅ Test CDN fallbacks if local files fail</li>
            <li class="info">✅ Check browser developer tools for 404 errors</li>
            <li class="info">✅ Verify that session is working correctly</li>
        </ul>
    </div>
</body>
</html>