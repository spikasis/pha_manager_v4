<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            width: 100%;
        }

        .row {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .col {
            max-width: 400px;
            width: 100%;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-header {
            background: linear-gradient(135deg, #4e73df, #36b9cc);
            color: white;
            text-align: center;
            padding: 40px 20px;
        }

        .card-header.success {
            background: linear-gradient(135deg, #1cc88a, #36b9cc);
        }

        .brand-icon {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
        }

        .card-header h2 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 700;
        }

        .card-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .card-body {
            padding: 30px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: none;
            font-size: 14px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background: #d1eddd;
            color: #155724;
        }

        .alert-info {
            background: #cce7f0;
            color: #0c5460;
        }

        .session-info {
            background: #f8f9fc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #1cc88a;
        }

        .session-info .row {
            display: block;
        }

        .session-info .col-12 {
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-success {
            color: #1cc88a;
        }

        .text-primary {
            color: #4e73df;
        }

        .text-muted {
            color: #858796;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .mb-4 {
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4e73df, #36b9cc);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);
        }

        .btn-success {
            background: #1cc88a;
            color: white;
        }

        .btn-success:hover {
            background: #17a673;
            transform: translateY(-2px);
        }

        .btn-outline-danger {
            background: transparent;
            color: #e74a3b;
            border: 1px solid #e74a3b;
        }

        .btn-outline-danger:hover {
            background: #e74a3b;
            color: white;
        }

        .btn-outline-info {
            background: transparent;
            color: #36b9cc;
            border: 1px solid #36b9cc;
            padding: 8px 12px;
            font-size: 14px;
        }

        .btn-outline-info:hover {
            background: #36b9cc;
            color: white;
        }

        .btn-outline-warning {
            background: transparent;
            color: #f6c23e;
            border: 1px solid #f6c23e;
            padding: 8px 12px;
            font-size: 14px;
        }

        .btn-outline-warning:hover {
            background: #f6c23e;
            color: black;
        }

        .d-grid {
            display: grid;
            gap: 15px;
        }

        .row-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 20px;
        }

        .card-footer {
            background: #f8f9fc;
            border-top: 1px solid #e3e6f0;
            text-align: center;
            font-size: 12px;
            color: #858796;
            padding: 20px;
        }

        .card-footer .row {
            display: block;
        }

        .card-footer .col-12 {
            margin-bottom: 8px;
        }

        .icon {
            margin-right: 8px;
        }

        /* Icons using Unicode symbols */
        .icon-user::before { content: "👤"; }
        .icon-clock::before { content: "🕐"; }
        .icon-check::before { content: "✅"; }
        .icon-login::before { content: "🔐"; }
        .icon-logout::before { content: "🚪"; }
        .icon-dashboard::before { content: "📊"; }
        .icon-help::before { content: "❓"; }
        .icon-reset::before { content: "🧹"; }
        .icon-shield::before { content: "🛡️"; }
        .icon-server::before { content: "💻"; }
        .icon-globe::before { content: "🌐"; }
        .icon-warning::before { content: "⚠️"; }
        .icon-info::before { content: "ℹ️"; }
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