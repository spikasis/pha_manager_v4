<!DOCTYPE html><!DOCTYPE html><!DOCTYPE html><!DOCTYPE html>

<html lang="el">

<head><html lang="el">

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1"><head><html lang="el"><html lang="el">

    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>

        <meta charset="utf-8">

    <style>

        * {    <meta name="viewport" content="width=device-width, initial-scale=1"><head><head>

            margin: 0;

            padding: 0;    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>

            box-sizing: border-box;

        }        <meta charset="utf-8">    <meta charset="utf-8">

        body {

            font-family: Arial, sans-serif;    <style>

            background: linear-gradient(135deg, #4e73df, #224abe);

            min-height: 100vh;        * {    <meta name="viewport" content="width=device-width, initial-scale=1">    <meta name="viewport" content="width=device-width, initial-scale=1">

            display: flex;

            align-items: center;            margin: 0;

            justify-content: center;

            padding: 20px;            padding: 0;    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>

        }

        .login-card {            box-sizing: border-box;

            background: white;

            border-radius: 15px;        }        

            box-shadow: 0 15px 35px rgba(0,0,0,0.1);

            overflow: hidden;

            max-width: 400px;

            width: 100%;        body {    <style>    <style>

        }

        .card-header {            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;

            background: linear-gradient(135deg, #4e73df, #36b9cc);

            color: white;            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);        body {        * {

            text-align: center;

            padding: 40px 20px;            min-height: 100vh;

        }

        .card-header.success {            display: flex;            font-family: Arial, sans-serif;            margin: 0;

            background: linear-gradient(135deg, #1cc88a, #36b9cc);

        }            align-items: center;

        .card-header h2 {

            margin: 0 0 10px 0;            justify-content: center;            background: linear-gradient(135deg, #4e73df, #224abe);            padding: 0;

            font-size: 28px;

        }            padding: 20px;

        .card-body {

            padding: 30px;        }            min-height: 100vh;            box-sizing: border-box;

        }

        .alert {

            padding: 12px 16px;

            border-radius: 8px;        .container {            display: flex;        }

            margin-bottom: 20px;

            font-size: 14px;            max-width: 1200px;

        }

        .alert-danger {            width: 100%;            align-items: center;

            background: #f8d7da;

            color: #721c24;        }

        }

        .alert-success {            justify-content: center;        body {

            background: #d1eddd;

            color: #155724;        .row {

        }

        .alert-info {            display: flex;            margin: 0;            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;

            background: #cce7f0;

            color: #0c5460;            justify-content: center;

        }

        .session-info {            align-items: center;        }            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);

            background: #f8f9fc;

            border-radius: 10px;        }

            padding: 20px;

            margin-bottom: 20px;                    min-height: 100vh;

            border-left: 4px solid #1cc88a;

        }        .col {

        .btn {

            display: block;            max-width: 400px;        .login-container {            display: flex;

            padding: 12px 24px;

            border: none;            width: 100%;

            border-radius: 8px;

            text-decoration: none;        }            background: white;            align-items: center;

            font-weight: 600;

            font-size: 16px;

            cursor: pointer;

            text-align: center;        .login-card {            padding: 40px;            justify-content: center;

            width: 100%;

            margin-bottom: 10px;            background: white;

            transition: all 0.3s ease;

        }            border-radius: 15px;            border-radius: 15px;            padding: 20px;

        .btn-primary {

            background: linear-gradient(45deg, #4e73df, #36b9cc);            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);

            color: white;

        }            overflow: hidden;            box-shadow: 0 10px 30px rgba(0,0,0,0.2);        }

        .btn-primary:hover {

            transform: translateY(-2px);            animation: fadeIn 0.8s ease-in;

        }

        .btn-success {        }            max-width: 400px;

            background: #1cc88a;

            color: white;

        }

        .btn-outline-danger {        @keyframes fadeIn {            width: 90%;        .container {

            background: transparent;

            color: #e74a3b;            from { opacity: 0; transform: translateY(30px); }

            border: 1px solid #e74a3b;

        }            to { opacity: 1; transform: translateY(0); }            text-align: center;            max-width: 1200px;

        .btn-outline-danger:hover {

            background: #e74a3b;        }

            color: white;

        }        }            width: 100%;

        .btn-small {

            padding: 8px 12px;        .card-header {

            font-size: 14px;

            display: inline-block;            background: linear-gradient(135deg, #4e73df, #36b9cc);                }

            width: auto;

            margin: 5px;            color: white;

        }

        .text-center { text-align: center; }            text-align: center;        .header {

        .text-success { color: #1cc88a; }

        .text-primary { color: #4e73df; }            padding: 40px 20px;

        .text-muted { color: #858796; }

        .mb-3 { margin-bottom: 20px; }        }            background: linear-gradient(135deg, #4e73df, #36b9cc);        .row {

        .mb-4 { margin-bottom: 25px; }

        .card-footer {

            background: #f8f9fc;

            border-top: 1px solid #e3e6f0;        .card-header.success {            color: white;            display: flex;

            text-align: center;

            font-size: 12px;            background: linear-gradient(135deg, #1cc88a, #36b9cc);

            color: #858796;

            padding: 20px;        }            margin: -40px -40px 30px -40px;            justify-content: center;

        }

    </style>

</head>

<body>        .brand-icon {            padding: 30px;            align-items: center;

    <div class="login-card">

        <!-- Header -->            font-size: 48px;

        <div class="card-header <?= (isset($already_logged_in) && $already_logged_in) ? 'success' : '' ?>">

            <div style="font-size: 48px; margin-bottom: 15px;">🦻</div>            margin-bottom: 15px;            border-radius: 15px 15px 0 0;        }

            <h2>PHA Manager</h2>

            <p>Professional Hearing Aid Management System v4</p>            display: block;

        </div>

        }        }

        <!-- Body -->

        <div class="card-body">

            <!-- Flash Messages -->

            <?php if (session()->getFlashdata('error')): ?>        .card-header h2 {                .col {

                <div class="alert alert-danger">

                    ⚠️ <?= session()->getFlashdata('error') ?>            margin: 0 0 10px 0;

                </div>

            <?php endif; ?>            font-size: 28px;        .header h1 {            max-width: 400px;



            <?php if (session()->getFlashdata('success')): ?>            font-weight: 700;

                <div class="alert alert-success">

                    ✅ <?= session()->getFlashdata('success') ?>        }            margin: 0 0 10px 0;            width: 100%;

                </div>

            <?php endif; ?>



            <?php if (session()->getFlashdata('info')): ?>        .card-header p {            font-size: 24px;        }

                <div class="alert alert-info">

                    ℹ️ <?= session()->getFlashdata('info') ?>            margin: 0;

                </div>

            <?php endif; ?>            opacity: 0.9;        }



            <?php if (isset($already_logged_in) && $already_logged_in): ?>            font-size: 14px;

                <!-- Already Logged In -->

                <div class="text-center mb-4">        }                .login-card {

                    <h4 class="text-success mb-3">✅ Είστε ήδη συνδεδεμένος!</h4>

                    

                    <div class="session-info">

                        <p><strong>👤 Χρήστης:</strong> <?= esc($username ?? 'Administrator') ?></p>        .card-body {        .header p {            background: white;

                        <p><strong>🕐 Σύνδεση:</strong> <?= esc($login_time ?? date('d/m/Y H:i')) ?></p>

                    </div>            padding: 30px;

                </div>

        }            margin: 0;            border-radius: 15px;

                <!-- Action Buttons -->

                <a href="<?= site_url('dashboard') ?>" class="btn btn-success">

                    📊 Συνέχεια στο Dashboard

                </a>        .alert {            opacity: 0.9;            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);

                

                <a href="<?= site_url('auth/logout') ?>" class="btn btn-outline-danger">            padding: 12px 16px;

                    🚪 Αποσύνδεση

                </a>            border-radius: 8px;            font-size: 14px;            overflow: hidden;



                <!-- Utility Links -->            margin-bottom: 20px;

                <div style="text-align: center; margin-top: 20px;">

                    <a href="#" class="btn btn-small">❓ Βοήθεια</a>            border: none;        }            animation: fadeIn 0.8s ease-in;

                    <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-small">🧹 Reset</a>

                </div>            font-size: 14px;



            <?php else: ?>        }                }

                <!-- Fresh Login -->

                <div class="text-center mb-4">

                    <h4 class="text-primary mb-3">Σύνδεση στο Σύστημα</h4>

                    <p class="text-muted mb-4">        .alert-danger {        .btn {

                        ℹ️ Κλικ για άμεση είσοδο στο PHA Manager v4

                    </p>            background: #f8d7da;



                    <!-- Main Login Button -->            color: #721c24;            background: linear-gradient(45deg, #4e73df, #36b9cc);        @keyframes fadeIn {

                    <button type="button" class="btn btn-primary" id="quickLoginBtn" onclick="performLogin()">

                        🔐 Είσοδος στο Σύστημα        }

                    </button>

                </div>            color: white;            from { opacity: 0; transform: translateY(30px); }



                <!-- Alternative Actions -->        .alert-success {

                <div style="text-align: center; margin-top: 20px;">

                    <a href="#" class="btn btn-small">❓ Βοήθεια</a>            background: #d1eddd;            border: none;            to { opacity: 1; transform: translateY(0); }

                    <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-small">🧹 Reset</a>

                </div>            color: #155724;

            <?php endif; ?>

        </div>        }            padding: 15px 30px;        }



        <!-- Footer -->

        <div class="card-footer">

            <p>🛡️ <strong>Ασφαλής Σύνδεση</strong> | 💻 <strong>Παραγωγικό Περιβάλλον</strong></p>        .alert-info {            border-radius: 25px;

            <p>🌐 <?= base_url() ?></p>

            <p>© <?= date('Y') ?> Pikas Hearing Aid Center</p>            background: #cce7f0;

        </div>

    </div>            color: #0c5460;            font-size: 16px;        .card-header {



    <script>        }

        console.log('PHA Manager v4 Login Page Loaded (Clean Simple Version)');

            font-weight: 600;            background: linear-gradient(135deg, #4e73df, #36b9cc);

        // Login function

        function performLogin() {        .session-info {

            const btn = document.getElementById('quickLoginBtn');

            if (btn) {            background: #f8f9fc;            cursor: pointer;            color: white;

                btn.innerHTML = '⏳ Σύνδεση...';

                btn.disabled = true;            border-radius: 10px;

                window.location.href = '<?= site_url('auth/login') ?>';

            }            padding: 20px;            width: 100%;            text-align: center;

        }

            margin-bottom: 20px;

        // Auto-dismiss alerts after 5 seconds

        setTimeout(function() {            border-left: 4px solid #1cc88a;            margin: 10px 0;            padding: 40px 20px;

            const alerts = document.querySelectorAll('.alert');

            alerts.forEach(function(alert) {        }

                if (alert) {

                    alert.style.transition = 'opacity 0.5s';            transition: transform 0.2s;        }

                    alert.style.opacity = '0';

                    setTimeout(function() {        .session-info .row {

                        if (alert.parentNode) {

                            alert.parentNode.removeChild(alert);            display: block;        }

                        }

                    }, 500);        }

                }

            });                .card-header.success {

        }, 5000);

        .session-info .col-12 {

        // Session status logging

        <?php if (isset($already_logged_in) && $already_logged_in): ?>            margin-bottom: 10px;        .btn:hover {            background: linear-gradient(135deg, #1cc88a, #36b9cc);

            console.log('Session Active - User: <?= esc($username ?? 'Administrator') ?>');

        <?php else: ?>        }

            console.log('Fresh login required');

        <?php endif; ?>            transform: translateY(-2px);        }

    </script>

</body>        .text-center {

</html>
            text-align: center;        }

        }

                .brand-icon {

        .text-success {

            color: #1cc88a;        .btn-success {            font-size: 48px;

        }

            background: #1cc88a;            margin-bottom: 15px;

        .text-primary {

            color: #4e73df;        }            display: block;

        }

                }

        .text-muted {

            color: #858796;        .btn-outline {

        }

            background: transparent;        .card-header h2 {

        .mb-3 {

            margin-bottom: 20px;            border: 2px solid #e74a3b;            margin: 0 0 10px 0;

        }

            color: #e74a3b;            font-size: 28px;

        .mb-4 {

            margin-bottom: 25px;        }            font-weight: 700;

        }

                }

        .btn {

            display: inline-block;        .btn-outline:hover {

            padding: 12px 24px;

            border: none;            background: #e74a3b;        .card-header p {

            border-radius: 8px;

            text-decoration: none;            color: white;            margin: 0;

            font-weight: 600;

            font-size: 16px;        }            opacity: 0.9;

            cursor: pointer;

            transition: all 0.3s ease;                    font-size: 14px;

            text-align: center;

            width: 100%;        .session-info {        }

            margin-bottom: 10px;

        }            background: #f8f9fc;



        .btn-primary {            padding: 20px;        .card-body {

            background: linear-gradient(45deg, #4e73df, #36b9cc);

            color: white;            border-radius: 10px;            padding: 30px;

        }

            margin: 20px 0;        }

        .btn-primary:hover {

            transform: translateY(-2px);            border-left: 4px solid #1cc88a;

            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);

        }            text-align: left;        .alert {



        .btn-success {        }            padding: 12px 16px;

            background: #1cc88a;

            color: white;                    border-radius: 8px;

        }

        .alert {            margin-bottom: 20px;

        .btn-success:hover {

            background: #17a673;            padding: 15px;            border: none;

            transform: translateY(-2px);

        }            border-radius: 8px;            font-size: 14px;



        .btn-outline-danger {            margin: 15px 0;        }

            background: transparent;

            color: #e74a3b;        }

            border: 1px solid #e74a3b;

        }                .alert-danger {



        .btn-outline-danger:hover {        .alert-success {            background: #f8d7da;

            background: #e74a3b;

            color: white;            background: #d1eddd;            color: #721c24;

        }

            color: #155724;        }

        .btn-outline-info {

            background: transparent;            border: 1px solid #1cc88a;

            color: #36b9cc;

            border: 1px solid #36b9cc;        }        .alert-success {

            padding: 8px 12px;

            font-size: 14px;                    background: #d1eddd;

        }

        .alert-danger {            color: #155724;

        .btn-outline-info:hover {

            background: #36b9cc;            background: #f8d7da;        }

            color: white;

        }            color: #721c24;



        .btn-outline-warning {            border: 1px solid #e74a3b;        .alert-info {

            background: transparent;

            color: #f6c23e;        }            background: #cce7f0;

            border: 1px solid #f6c23e;

            padding: 8px 12px;                    color: #0c5460;

            font-size: 14px;

        }        .alert-info {        }



        .btn-outline-warning:hover {            background: #cce7f0;

            background: #f6c23e;

            color: black;            color: #0c5460;        .session-info {

        }

            border: 1px solid #36b9cc;            background: #f8f9fc;

        .d-grid {

            display: grid;        }            border-radius: 10px;

            gap: 15px;

        }                    padding: 20px;



        .row-buttons {        .footer {            margin-bottom: 20px;

            display: grid;

            grid-template-columns: 1fr 1fr;            background: #f8f9fc;            border-left: 4px solid #1cc88a;

            gap: 10px;

            margin-top: 20px;            margin: 30px -40px -40px -40px;        }

        }

            padding: 20px;

        .card-footer {

            background: #f8f9fc;            border-radius: 0 0 15px 15px;        .session-info .row {

            border-top: 1px solid #e3e6f0;

            text-align: center;            border-top: 1px solid #e3e6f0;            display: block;

            font-size: 12px;

            color: #858796;            font-size: 12px;        }

            padding: 20px;

        }            color: #858796;



        .card-footer .row {        }        .session-info .col-12 {

            display: block;

        }                    margin-bottom: 10px;



        .card-footer .col-12 {        .text-success { color: #1cc88a; }        }

            margin-bottom: 8px;

        }        .text-primary { color: #4e73df; }



        .icon {        .mb-3 { margin-bottom: 20px; }        .text-center {

            margin-right: 8px;

        }                    text-align: center;



        /* Icons using Unicode symbols */        .row {        }

        .icon-user::before { content: "👤"; }

        .icon-clock::before { content: "🕐"; }            display: flex;

        .icon-check::before { content: "✅"; }

        .icon-login::before { content: "🔐"; }            gap: 10px;        .text-success {

        .icon-logout::before { content: "🚪"; }

        .icon-dashboard::before { content: "📊"; }            margin-top: 15px;            color: #1cc88a;

        .icon-help::before { content: "❓"; }

        .icon-reset::before { content: "🧹"; }        }        }

        .icon-shield::before { content: "🛡️"; }

        .icon-server::before { content: "💻"; }        

        .icon-globe::before { content: "🌐"; }

        .icon-warning::before { content: "⚠️"; }        .col {        .text-primary {

        .icon-info::before { content: "ℹ️"; }

        .icon-hearing::before { content: "🦻"; }            flex: 1;            color: #4e73df;



        /* Responsive */        }        }

        @media (max-width: 576px) {

            .card-header {        

                padding: 30px 20px;

            }        .btn-small {        .text-muted {

            

            .card-body {            padding: 8px 16px;            color: #858796;

                padding: 20px;

            }            font-size: 14px;        }



            .brand-icon {        }

                font-size: 40px;

            }    </style>        .mb-3 {



            .card-header h2 {</head>            margin-bottom: 20px;

                font-size: 24px;

            }<body>        }

        }

    </style>    <div class="login-container">

</head>

        <div class="header">        .mb-4 {

<body>

    <div class="container">            <h1>🦻 PHA Manager</h1>            margin-bottom: 25px;

        <div class="row">

            <div class="col">            <p>Professional Hearing Aid Management System v4</p>        }

                <div class="login-card">

                    <!-- Header -->        </div>

                    <div class="card-header <?= (isset($already_logged_in) && $already_logged_in) ? 'success' : '' ?>">

                        <div class="brand-icon icon-hearing"></div>                .btn {

                        <h2>PHA Manager</h2>

                        <p>Professional Hearing Aid Management System v4</p>        <!-- Flash Messages -->            display: inline-block;

                    </div>

        <?php if (session()->getFlashdata('error')): ?>            padding: 12px 24px;

                    <!-- Body -->

                    <div class="card-body">            <div class="alert alert-danger">            border: none;

                        <!-- Flash Messages -->

                        <?php if (session()->getFlashdata('error')): ?>                ⚠️ <?= session()->getFlashdata('error') ?>            border-radius: 8px;

                            <div class="alert alert-danger">

                                <span class="icon icon-warning"></span>            </div>            text-decoration: none;

                                <?= session()->getFlashdata('error') ?>

                            </div>        <?php endif; ?>            font-weight: 600;

                        <?php endif; ?>

            font-size: 16px;

                        <?php if (session()->getFlashdata('success')): ?>

                            <div class="alert alert-success">        <?php if (session()->getFlashdata('success')): ?>            cursor: pointer;

                                <span class="icon icon-check"></span>

                                <?= session()->getFlashdata('success') ?>            <div class="alert alert-success">            transition: all 0.3s ease;

                            </div>

                        <?php endif; ?>                ✅ <?= session()->getFlashdata('success') ?>            text-align: center;



                        <?php if (session()->getFlashdata('info')): ?>            </div>            width: 100%;

                            <div class="alert alert-info">

                                <span class="icon icon-info"></span>        <?php endif; ?>            margin-bottom: 10px;

                                <?= session()->getFlashdata('info') ?>

                            </div>        }

                        <?php endif; ?>

        <?php if (session()->getFlashdata('info')): ?>

                        <?php if (isset($already_logged_in) && $already_logged_in): ?>

                            <!-- Already Logged In -->            <div class="alert alert-info">        .btn-primary {

                            <div class="text-center mb-4">

                                <h4 class="text-success mb-3">                ℹ️ <?= session()->getFlashdata('info') ?>            background: linear-gradient(45deg, #4e73df, #36b9cc);

                                    <span class="icon icon-check"></span>

                                    Είστε ήδη συνδεδεμένος!            </div>            color: white;

                                </h4>

                                        <?php endif; ?>        }

                                <div class="session-info">

                                    <div class="row">

                                        <div class="col-12">

                                            <strong>        <?php if (isset($already_logged_in) && $already_logged_in): ?>        .btn-primary:hover {

                                                <span class="icon icon-user"></span>

                                                Χρήστης:            <!-- Already Logged In -->            transform: translateY(-2px);

                                            </strong> 

                                            <?= esc($username ?? 'Administrator') ?>            <h3 class="text-success mb-3">✅ Είστε ήδη συνδεδεμένος!</h3>            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);

                                        </div>

                                        <div class="col-12">                    }

                                            <strong>

                                                <span class="icon icon-clock"></span>            <div class="session-info">

                                                Σύνδεση:

                                            </strong>                 <p><strong>👤 Χρήστης:</strong> <?= esc($username ?? 'Administrator') ?></p>        .btn-success {

                                            <?= esc($login_time ?? date('d/m/Y H:i')) ?>

                                        </div>                <p><strong>🕐 Σύνδεση:</strong> <?= esc($login_time ?? date('d/m/Y H:i')) ?></p>            background: #1cc88a;

                                    </div>

                                </div>            </div>            color: white;

                            </div>

        }

                            <!-- Action Buttons -->

                            <div class="d-grid mb-4">            <button class="btn btn-success" onclick="goToDashboard()">

                                <a href="<?= site_url('dashboard') ?>" class="btn btn-success">

                                    <span class="icon icon-dashboard"></span>                📊 Συνέχεια στο Dashboard        .btn-success:hover {

                                    Συνέχεια στο Dashboard

                                </a>            </button>            background: #17a673;

                                

                                <a href="<?= site_url('auth/logout') ?>" class="btn btn-outline-danger">                        transform: translateY(-2px);

                                    <span class="icon icon-logout"></span>

                                    Αποσύνδεση            <button class="btn btn-outline" onclick="logout()">        }

                                </a>

                            </div>                🚪 Αποσύνδεση



                            <!-- Utility Links -->            </button>        .btn-outline-danger {

                            <div class="row-buttons">

                                <a href="#" class="btn btn-outline-info">            background: transparent;

                                    <span class="icon icon-help"></span>

                                    Βοήθεια            <div class="row">            color: #e74a3b;

                                </a>

                                <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-outline-warning">                <div class="col">            border: 1px solid #e74a3b;

                                    <span class="icon icon-reset"></span>

                                    Reset                    <button class="btn btn-small" onclick="showHelp()">❓ Βοήθεια</button>        }

                                </a>

                            </div>                </div>



                        <?php else: ?>                <div class="col">        .btn-outline-danger:hover {

                            <!-- Fresh Login -->

                            <div class="text-center mb-4">                    <button class="btn btn-small" onclick="resetSession()">🧹 Reset</button>            background: #e74a3b;

                                <h4 class="text-primary mb-3">Σύνδεση στο Σύστημα</h4>

                                <p class="text-muted mb-4">                </div>            color: white;

                                    <span class="icon icon-info"></span>

                                    Κλικ για άμεση είσοδο στο PHA Manager v4            </div>        }

                                </p>



                                <!-- Main Login Button -->

                                <div class="d-grid mb-4">        <?php else: ?>        .btn-outline-info {

                                    <button type="button" class="btn btn-primary" id="quickLoginBtn" onclick="performLogin()">

                                        <span class="icon icon-login"></span>            <!-- Fresh Login -->            background: transparent;

                                        Είσοδος στο Σύστημα

                                    </button>            <h3 class="text-primary mb-3">Σύνδεση στο Σύστημα</h3>            color: #36b9cc;

                                </div>

                            </div>            <p style="color: #858796; margin-bottom: 30px;">            border: 1px solid #36b9cc;



                            <!-- Alternative Actions -->                ℹ️ Κλικ για άμεση είσοδο στο PHA Manager v4            padding: 8px 12px;

                            <div class="row-buttons">

                                <a href="#" class="btn btn-outline-info">            </p>            font-size: 14px;

                                    <span class="icon icon-help"></span>

                                    Βοήθεια        }

                                </a>

                                <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-outline-warning">            <button class="btn" onclick="performLogin()">

                                    <span class="icon icon-reset"></span>

                                    Reset                🔐 Είσοδος στο Σύστημα        .btn-outline-info:hover {

                                </a>

                            </div>            </button>            background: #36b9cc;

                        <?php endif; ?>

                    </div>            color: white;



                    <!-- Footer -->            <div class="row">        }

                    <div class="card-footer">

                        <div class="row">                <div class="col">

                            <div class="col-12">

                                <span class="icon icon-shield"></span>                    <button class="btn btn-small" onclick="showHelp()">❓ Βοήθεια</button>        .btn-outline-warning {

                                <strong>Ασφαλής Σύνδεση</strong>

                                |                </div>            background: transparent;

                                <span class="icon icon-server"></span>

                                <strong>Παραγωγικό Περιβάλλον</strong>                <div class="col">            color: #f6c23e;

                            </div>

                            <div class="col-12">                    <button class="btn btn-small" onclick="resetSession()">🧹 Reset</button>            border: 1px solid #f6c23e;

                                <span class="icon icon-globe"></span>

                                <?= base_url() ?>                </div>            padding: 8px 12px;

                            </div>

                            <div class="col-12 text-primary">            </div>            font-size: 14px;

                                © <?= date('Y') ?> Pikas Hearing Aid Center - Powered by CodeIgniter 4

                            </div>        <?php endif; ?>        }

                        </div>

                    </div>

                </div>

            </div>        <div class="footer">        .btn-outline-warning:hover {

        </div>

    </div>            <p>🛡️ <strong>Ασφαλής Σύνδεση</strong> | 💻 <strong>Παραγωγικό Περιβάλλον</strong></p>            background: #f6c23e;



    <script>            <p>🌐 <?= base_url() ?></p>            color: black;

        console.log('PHA Manager v4 Login Page Loaded (Clean Version)');

        console.log('Base URL:', '<?= base_url() ?>');            <p>© <?= date('Y') ?> Pikas Hearing Aid Center</p>        }



        // Login function        </div>

        function performLogin() {

            const btn = document.getElementById('quickLoginBtn');    </div>        .d-grid {

            if (btn) {

                const originalText = btn.innerHTML;            display: grid;

                

                // Show loading state    <script>            gap: 15px;

                btn.innerHTML = '⏳ Σύνδεση...';

                btn.disabled = true;        console.log('PHA Manager v4 Login Loaded');        }

                

                // Redirect to login endpoint

                window.location.href = '<?= site_url('auth/login') ?>';

            }        function performLogin() {        .row-buttons {

        }

            const btn = event.target;            display: grid;

        // Auto-dismiss alerts

        setTimeout(function() {            btn.innerHTML = '⏳ Σύνδεση...';            grid-template-columns: 1fr 1fr;

            const alerts = document.querySelectorAll('.alert');

            alerts.forEach(function(alert) {            btn.disabled = true;            gap: 10px;

                if (alert) {

                    alert.style.transition = 'opacity 0.5s';            window.location.href = '<?= site_url('auth/login') ?>';            margin-top: 20px;

                    alert.style.opacity = '0';

                    setTimeout(function() {        }        }

                        if (alert.parentNode) {

                            alert.parentNode.removeChild(alert);

                        }

                    }, 500);        function goToDashboard() {        .card-footer {

                }

            });            window.location.href = '<?= site_url('dashboard') ?>';            background: #f8f9fc;

        }, 5000);

        }            border-top: 1px solid #e3e6f0;

        // Add hover effects

        const buttons = document.querySelectorAll('.btn');            text-align: center;

        buttons.forEach(function(btn) {

            btn.addEventListener('mouseenter', function() {        function logout() {            font-size: 12px;

                this.style.transform = 'translateY(-2px)';

                this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';            window.location.href = '<?= site_url('auth/logout') ?>';            color: #858796;

            });

            btn.addEventListener('mouseleave', function() {        }            padding: 20px;

                this.style.transform = 'translateY(0)';

                this.style.boxShadow = 'none';        }

            });

        });        function resetSession() {



        // Keyboard shortcuts            window.location.href = '<?= site_url('auth?force_logout=1') ?>';        .card-footer .row {

        document.addEventListener('keydown', function(e) {

            if (e.key === 'Enter') {        }            display: block;

                const loginBtn = document.getElementById('quickLoginBtn');

                if (loginBtn && !loginBtn.disabled) {        }

                    performLogin();

                }        function showHelp() {

            }

        });            alert('Για βοήθεια επικοινωνήστε με τον διαχειριστή του συστήματος.');        .card-footer .col-12 {



        // Session status logging        }            margin-bottom: 8px;

        <?php if (isset($already_logged_in) && $already_logged_in): ?>

            console.log('Session Active - User: <?= esc($username ?? 'Administrator') ?>');        }

        <?php else: ?>

            console.log('Fresh login required');        // Auto-dismiss alerts

        <?php endif; ?>

    </script>        setTimeout(function() {        .icon {

</body>

</html>            const alerts = document.querySelectorAll('.alert');            margin-right: 8px;

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