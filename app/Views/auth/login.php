<!DOCTYPE html><!DOCTYPE html>

<html lang="el"><html lang="el">

<head><head>

    <meta charset="utf-8">    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>

        

    <style>    <style>

        body {        * {

            font-family: Arial, sans-serif;            margin: 0;

            background: linear-gradient(135deg, #4e73df, #224abe);            padding: 0;

            min-height: 100vh;            box-sizing: border-box;

            display: flex;        }

            align-items: center;

            justify-content: center;        body {

            margin: 0;            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;

        }            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);

                    min-height: 100vh;

        .login-container {            display: flex;

            background: white;            align-items: center;

            padding: 40px;            justify-content: center;

            border-radius: 15px;            padding: 20px;

            box-shadow: 0 10px 30px rgba(0,0,0,0.2);        }

            max-width: 400px;

            width: 90%;        .container {

            text-align: center;            max-width: 1200px;

        }            width: 100%;

                }

        .header {

            background: linear-gradient(135deg, #4e73df, #36b9cc);        .row {

            color: white;            display: flex;

            margin: -40px -40px 30px -40px;            justify-content: center;

            padding: 30px;            align-items: center;

            border-radius: 15px 15px 0 0;        }

        }

                .col {

        .header h1 {            max-width: 400px;

            margin: 0 0 10px 0;            width: 100%;

            font-size: 24px;        }

        }

                .login-card {

        .header p {            background: white;

            margin: 0;            border-radius: 15px;

            opacity: 0.9;            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);

            font-size: 14px;            overflow: hidden;

        }            animation: fadeIn 0.8s ease-in;

                }

        .btn {

            background: linear-gradient(45deg, #4e73df, #36b9cc);        @keyframes fadeIn {

            color: white;            from { opacity: 0; transform: translateY(30px); }

            border: none;            to { opacity: 1; transform: translateY(0); }

            padding: 15px 30px;        }

            border-radius: 25px;

            font-size: 16px;        .card-header {

            font-weight: 600;            background: linear-gradient(135deg, #4e73df, #36b9cc);

            cursor: pointer;            color: white;

            width: 100%;            text-align: center;

            margin: 10px 0;            padding: 40px 20px;

            transition: transform 0.2s;        }

        }

                .card-header.success {

        .btn:hover {            background: linear-gradient(135deg, #1cc88a, #36b9cc);

            transform: translateY(-2px);        }

        }

                .brand-icon {

        .btn-success {            font-size: 48px;

            background: #1cc88a;            margin-bottom: 15px;

        }            display: block;

                }

        .btn-outline {

            background: transparent;        .card-header h2 {

            border: 2px solid #e74a3b;            margin: 0 0 10px 0;

            color: #e74a3b;            font-size: 28px;

        }            font-weight: 700;

                }

        .btn-outline:hover {

            background: #e74a3b;        .card-header p {

            color: white;            margin: 0;

        }            opacity: 0.9;

                    font-size: 14px;

        .session-info {        }

            background: #f8f9fc;

            padding: 20px;        .card-body {

            border-radius: 10px;            padding: 30px;

            margin: 20px 0;        }

            border-left: 4px solid #1cc88a;

            text-align: left;        .alert {

        }            padding: 12px 16px;

                    border-radius: 8px;

        .alert {            margin-bottom: 20px;

            padding: 15px;            border: none;

            border-radius: 8px;            font-size: 14px;

            margin: 15px 0;        }

        }

                .alert-danger {

        .alert-success {            background: #f8d7da;

            background: #d1eddd;            color: #721c24;

            color: #155724;        }

            border: 1px solid #1cc88a;

        }        .alert-success {

                    background: #d1eddd;

        .alert-danger {            color: #155724;

            background: #f8d7da;        }

            color: #721c24;

            border: 1px solid #e74a3b;        .alert-info {

        }            background: #cce7f0;

                    color: #0c5460;

        .alert-info {        }

            background: #cce7f0;

            color: #0c5460;        .session-info {

            border: 1px solid #36b9cc;            background: #f8f9fc;

        }            border-radius: 10px;

                    padding: 20px;

        .footer {            margin-bottom: 20px;

            background: #f8f9fc;            border-left: 4px solid #1cc88a;

            margin: 30px -40px -40px -40px;        }

            padding: 20px;

            border-radius: 0 0 15px 15px;        .session-info .row {

            border-top: 1px solid #e3e6f0;            display: block;

            font-size: 12px;        }

            color: #858796;

        }        .session-info .col-12 {

                    margin-bottom: 10px;

        .text-success { color: #1cc88a; }        }

        .text-primary { color: #4e73df; }

        .mb-3 { margin-bottom: 20px; }        .text-center {

                    text-align: center;

        .row {        }

            display: flex;

            gap: 10px;        .text-success {

            margin-top: 15px;            color: #1cc88a;

        }        }

        

        .col {        .text-primary {

            flex: 1;            color: #4e73df;

        }        }

        

        .btn-small {        .text-muted {

            padding: 8px 16px;            color: #858796;

            font-size: 14px;        }

        }

    </style>        .mb-3 {

</head>            margin-bottom: 20px;

<body>        }

    <div class="login-container">

        <div class="header">        .mb-4 {

            <h1>🦻 PHA Manager</h1>            margin-bottom: 25px;

            <p>Professional Hearing Aid Management System v4</p>        }

        </div>

                .btn {

        <!-- Flash Messages -->            display: inline-block;

        <?php if (session()->getFlashdata('error')): ?>            padding: 12px 24px;

            <div class="alert alert-danger">            border: none;

                ⚠️ <?= session()->getFlashdata('error') ?>            border-radius: 8px;

            </div>            text-decoration: none;

        <?php endif; ?>            font-weight: 600;

            font-size: 16px;

        <?php if (session()->getFlashdata('success')): ?>            cursor: pointer;

            <div class="alert alert-success">            transition: all 0.3s ease;

                ✅ <?= session()->getFlashdata('success') ?>            text-align: center;

            </div>            width: 100%;

        <?php endif; ?>            margin-bottom: 10px;

        }

        <?php if (session()->getFlashdata('info')): ?>

            <div class="alert alert-info">        .btn-primary {

                ℹ️ <?= session()->getFlashdata('info') ?>            background: linear-gradient(45deg, #4e73df, #36b9cc);

            </div>            color: white;

        <?php endif; ?>        }



        <?php if (isset($already_logged_in) && $already_logged_in): ?>        .btn-primary:hover {

            <!-- Already Logged In -->            transform: translateY(-2px);

            <h3 class="text-success mb-3">✅ Είστε ήδη συνδεδεμένος!</h3>            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);

                    }

            <div class="session-info">

                <p><strong>👤 Χρήστης:</strong> <?= esc($username ?? 'Administrator') ?></p>        .btn-success {

                <p><strong>🕐 Σύνδεση:</strong> <?= esc($login_time ?? date('d/m/Y H:i')) ?></p>            background: #1cc88a;

            </div>            color: white;

        }

            <button class="btn btn-success" onclick="goToDashboard()">

                📊 Συνέχεια στο Dashboard        .btn-success:hover {

            </button>            background: #17a673;

                        transform: translateY(-2px);

            <button class="btn btn-outline" onclick="logout()">        }

                🚪 Αποσύνδεση

            </button>        .btn-outline-danger {

            background: transparent;

            <div class="row">            color: #e74a3b;

                <div class="col">            border: 1px solid #e74a3b;

                    <button class="btn btn-small" onclick="showHelp()">❓ Βοήθεια</button>        }

                </div>

                <div class="col">        .btn-outline-danger:hover {

                    <button class="btn btn-small" onclick="resetSession()">🧹 Reset</button>            background: #e74a3b;

                </div>            color: white;

            </div>        }



        <?php else: ?>        .btn-outline-info {

            <!-- Fresh Login -->            background: transparent;

            <h3 class="text-primary mb-3">Σύνδεση στο Σύστημα</h3>            color: #36b9cc;

            <p style="color: #858796; margin-bottom: 30px;">            border: 1px solid #36b9cc;

                ℹ️ Κλικ για άμεση είσοδο στο PHA Manager v4            padding: 8px 12px;

            </p>            font-size: 14px;

        }

            <button class="btn" onclick="performLogin()">

                🔐 Είσοδος στο Σύστημα        .btn-outline-info:hover {

            </button>            background: #36b9cc;

            color: white;

            <div class="row">        }

                <div class="col">

                    <button class="btn btn-small" onclick="showHelp()">❓ Βοήθεια</button>        .btn-outline-warning {

                </div>            background: transparent;

                <div class="col">            color: #f6c23e;

                    <button class="btn btn-small" onclick="resetSession()">🧹 Reset</button>            border: 1px solid #f6c23e;

                </div>            padding: 8px 12px;

            </div>            font-size: 14px;

        <?php endif; ?>        }



        <div class="footer">        .btn-outline-warning:hover {

            <p>🛡️ <strong>Ασφαλής Σύνδεση</strong> | 💻 <strong>Παραγωγικό Περιβάλλον</strong></p>            background: #f6c23e;

            <p>🌐 <?= base_url() ?></p>            color: black;

            <p>© <?= date('Y') ?> Pikas Hearing Aid Center</p>        }

        </div>

    </div>        .d-grid {

            display: grid;

    <script>            gap: 15px;

        console.log('PHA Manager v4 Login Loaded');        }



        function performLogin() {        .row-buttons {

            const btn = event.target;            display: grid;

            btn.innerHTML = '⏳ Σύνδεση...';            grid-template-columns: 1fr 1fr;

            btn.disabled = true;            gap: 10px;

            window.location.href = '<?= site_url('auth/login') ?>';            margin-top: 20px;

        }        }



        function goToDashboard() {        .card-footer {

            window.location.href = '<?= site_url('dashboard') ?>';            background: #f8f9fc;

        }            border-top: 1px solid #e3e6f0;

            text-align: center;

        function logout() {            font-size: 12px;

            window.location.href = '<?= site_url('auth/logout') ?>';            color: #858796;

        }            padding: 20px;

        }

        function resetSession() {

            window.location.href = '<?= site_url('auth?force_logout=1') ?>';        .card-footer .row {

        }            display: block;

        }

        function showHelp() {

            alert('Για βοήθεια επικοινωνήστε με τον διαχειριστή του συστήματος.');        .card-footer .col-12 {

        }            margin-bottom: 8px;

        }

        // Auto-dismiss alerts

        setTimeout(function() {        .icon {

            const alerts = document.querySelectorAll('.alert');            margin-right: 8px;

            alerts.forEach(function(alert) {        }

                alert.style.opacity = '0';

                alert.style.transition = 'opacity 0.5s';        /* Icons using Unicode symbols */

                setTimeout(() => alert.remove(), 500);        .icon-user::before { content: "👤"; }

            });        .icon-clock::before { content: "🕐"; }

        }, 5000);        .icon-check::before { content: "✅"; }

        .icon-login::before { content: "🔐"; }

        // Log session status        .icon-logout::before { content: "🚪"; }

        <?php if (isset($already_logged_in) && $already_logged_in): ?>        .icon-dashboard::before { content: "📊"; }

            console.log('Session Active - User: <?= esc($username ?? 'Administrator') ?>');        .icon-help::before { content: "❓"; }

        <?php else: ?>        .icon-reset::before { content: "🧹"; }

            console.log('Fresh login required');        .icon-shield::before { content: "🛡️"; }

        <?php endif; ?>        .icon-server::before { content: "💻"; }

    </script>        .icon-globe::before { content: "🌐"; }

</body>        .icon-warning::before { content: "⚠️"; }

</html>        .icon-info::before { content: "ℹ️"; }
        .icon-hearing::before { content: "🦻"; }

        /* Responsive */
        @media (max-width: 576px) {
            .card-header {
                padding: 30px 20px;
            }
            
            .card-body {
                padding: 20px;
            }

            .brand-icon {
                font-size: 40px;
            }

            .card-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="login-card">
                    <!-- Header -->
                    <div class="card-header <?= (isset($already_logged_in) && $already_logged_in) ? 'success' : '' ?>">
                        <div class="brand-icon icon-hearing"></div>
                        <h2>PHA Manager</h2>
                        <p>Professional Hearing Aid Management System v4</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Flash Messages -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <span class="icon icon-warning"></span>
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <span class="icon icon-check"></span>
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('info')): ?>
                            <div class="alert alert-info">
                                <span class="icon icon-info"></span>
                                <?= session()->getFlashdata('info') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($already_logged_in) && $already_logged_in): ?>
                            <!-- Already Logged In -->
                            <div class="text-center mb-4">
                                <h4 class="text-success mb-3">
                                    <span class="icon icon-check"></span>
                                    Είστε ήδη συνδεδεμένος!
                                </h4>
                                
                                <div class="session-info">
                                    <div class="row">
                                        <div class="col-12">
                                            <strong>
                                                <span class="icon icon-user"></span>
                                                Χρήστης:
                                            </strong> 
                                            <?= esc($username ?? 'Administrator') ?>
                                        </div>
                                        <div class="col-12">
                                            <strong>
                                                <span class="icon icon-clock"></span>
                                                Σύνδεση:
                                            </strong> 
                                            <?= esc($login_time ?? date('d/m/Y H:i')) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid mb-4">
                                <a href="<?= site_url('dashboard') ?>" class="btn btn-success">
                                    <span class="icon icon-dashboard"></span>
                                    Συνέχεια στο Dashboard
                                </a>
                                
                                <a href="<?= site_url('auth/logout') ?>" class="btn btn-outline-danger">
                                    <span class="icon icon-logout"></span>
                                    Αποσύνδεση
                                </a>
                            </div>

                            <!-- Utility Links -->
                            <div class="row-buttons">
                                <a href="#" class="btn btn-outline-info">
                                    <span class="icon icon-help"></span>
                                    Βοήθεια
                                </a>
                                <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-outline-warning">
                                    <span class="icon icon-reset"></span>
                                    Reset
                                </a>
                            </div>

                        <?php else: ?>
                            <!-- Fresh Login -->
                            <div class="text-center mb-4">
                                <h4 class="text-primary mb-3">Σύνδεση στο Σύστημα</h4>
                                <p class="text-muted mb-4">
                                    <span class="icon icon-info"></span>
                                    Κλικ για άμεση είσοδο στο PHA Manager v4
                                </p>

                                <!-- Main Login Button -->
                                <div class="d-grid mb-4">
                                    <button type="button" class="btn btn-primary" id="quickLoginBtn" onclick="performLogin()">
                                        <span class="icon icon-login"></span>
                                        Είσοδος στο Σύστημα
                                    </button>
                                </div>
                            </div>

                            <!-- Alternative Actions -->
                            <div class="row-buttons">
                                <a href="#" class="btn btn-outline-info">
                                    <span class="icon icon-help"></span>
                                    Βοήθεια
                                </a>
                                <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-outline-warning">
                                    <span class="icon icon-reset"></span>
                                    Reset
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <span class="icon icon-shield"></span>
                                <strong>Ασφαλής Σύνδεση</strong>
                                |
                                <span class="icon icon-server"></span>
                                <strong>Παραγωγικό Περιβάλλον</strong>
                            </div>
                            <div class="col-12">
                                <span class="icon icon-globe"></span>
                                <?= base_url() ?>
                            </div>
                            <div class="col-12 text-primary">
                                © <?= date('Y') ?> Pikas Hearing Aid Center - Powered by CodeIgniter 4
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        console.log('PHA Manager v4 Login Page Loaded (Standalone Version)');
        console.log('Base URL:', '<?= base_url() ?>');

        // Login function
        function performLogin() {
            const btn = document.getElementById('quickLoginBtn');
            if (btn) {
                const originalText = btn.innerHTML;
                
                // Show loading state
                btn.innerHTML = '⏳ Σύνδεση...';
                btn.disabled = true;
                
                // Redirect to login endpoint
                window.location.href = '<?= site_url('auth/login') ?>';
            }
        }

        // Auto-dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 500);
                }
            });
        }, 5000);

        // Add hover effects
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(function(btn) {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const loginBtn = document.getElementById('quickLoginBtn');
                if (loginBtn && !loginBtn.disabled) {
                    performLogin();
                }
            }
        });

        // Session status logging
        <?php if (isset($already_logged_in) && $already_logged_in): ?>
            console.log('Session Active - User: <?= esc($username ?? 'Administrator') ?>');
        <?php else: ?>
            console.log('Fresh login required');
        <?php endif; ?>
    </script>
</body>
</html>