<!DOCTYPE html><!DOCTYPE html><!DOCTYPE html><!DOCTYPE html>

<html lang="el">

<head><html lang="el">

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1"><head><html lang="el"><html lang="el">

    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>

        <meta charset="utf-8">

    <!-- CDN Resources for Maximum Compatibility -->

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">    <meta http-equiv="X-UA-Compatible" content="IE=edge"><head><head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous">    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



    <style>    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>    <meta charset="utf-8">    <meta charset="utf-8">

        body {

            font-family: 'Nunito', sans-serif;

            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);

            min-height: 100vh;    <!-- Google Fonts -->    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta http-equiv="X-UA-Compatible" content="IE=edge">

            display: flex;

            align-items: center;    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

            justify-content: center;

        }        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



        .login-card {    <!-- FontAwesome - Local first, then CDN fallback -->

            background: rgba(255, 255, 255, 0.95);

            border-radius: 20px;    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>

            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);

            overflow: hidden;    

            max-width: 420px;

            width: 100%;    <!-- SB Admin 2 CSS (includes Bootstrap) -->

            backdrop-filter: blur(10px);

        }    <link href="<?= base_url('sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet" type="text/css">



        .login-header {        <!-- Custom fonts -->    <!-- Custom fonts -->

            background: linear-gradient(135deg, #4e73df, #36b9cc);

            color: white;    <!-- Bootstrap 5 CDN for additional components -->

            padding: 2rem;

            text-align: center;    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        }



        .login-header.success {

            background: linear-gradient(135deg, #1cc88a, #36b9cc);    <style>        

        }

        :root {

        .brand-icon {

            font-size: 3rem;            --primary-color: #4e73df;    <!-- Bootstrap CSS -->    <!-- Bootstrap CSS -->

            margin-bottom: 1rem;

            opacity: 0.9;            --secondary-color: #858796;

        }

            --success-color: #1cc88a;    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        .login-body {

            padding: 2rem;            --info-color: #36b9cc;

        }

            --warning-color: #f6c23e;        

        .btn-login {

            background: linear-gradient(45deg, #4e73df, #36b9cc);            --danger-color: #e74a3b;

            border: none;

            border-radius: 25px;            --light-color: #f8f9fc;    <!-- FontAwesome -->    <!-- FontAwesome -->

            padding: 1rem 2rem;

            font-weight: 600;            --dark-color: #5a5c69;

            color: white;

            width: 100%;        }    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

            transition: all 0.3s ease;

            font-size: 1.1rem;

        }

        body {

        .btn-login:hover {

            transform: translateY(-2px);            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;

            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);

            color: white;            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);    <style>        <!-- Custom fonts -->

            background: linear-gradient(45deg, #36b9cc, #4e73df);

        }            min-height: 100vh;



        .login-footer {            display: flex;        :root {

            background: #f8f9fc;

            padding: 1.5rem 2rem;            align-items: center;

            text-align: center;

            border-top: 1px solid #e3e6f0;        }            --primary-color: #4e73df;    <style>

            font-size: 0.85rem;

            color: #858796;

        }

        .login-card {            --secondary-color: #858796;

        .session-info {

            background: #f8f9fc;            border: none;

            border-radius: 10px;

            padding: 1rem;            border-radius: 20px;            --success-color: #1cc88a;        :root {    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">    <!-- Bootstrap CSS -->

            margin-bottom: 1rem;

            border-left: 4px solid #1cc88a;            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);

        }

            backdrop-filter: blur(10px);            --info-color: #36b9cc;

        .alert {

            border-radius: 15px;            background: rgba(255, 255, 255, 0.95);

            border: none;

            margin-bottom: 1.5rem;            max-width: 450px;            --warning-color: #f6c23e;            --primary-color: #4e73df;

        }

            margin: 0 auto;

        /* Floating animations */

        .floating-shapes {        }            --danger-color: #e74a3b;

            position: fixed;

            top: 0;

            left: 0;

            width: 100%;        .login-header {            --light-color: #f8f9fc;            --secondary-color: #858796;        <!-- Bootstrap CSS -->

            height: 100%;

            overflow: hidden;            background: linear-gradient(135deg, var(--primary-color), var(--info-color));

            z-index: -1;

            pointer-events: none;            color: white;            --dark-color: #5a5c69;

        }

            padding: 2rem;

        .floating-shapes div {

            position: absolute;            border-radius: 20px 20px 0 0;        }            --success-color: #1cc88a;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.1);            text-align: center;

            animation: float 6s ease-in-out infinite;

        }        }



        .shape1 { width: 80px; height: 80px; top: 20%; left: 10%; animation-delay: 0s; }

        .shape2 { width: 120px; height: 120px; top: 60%; right: 10%; animation-delay: 2s; }

        .shape3 { width: 60px; height: 60px; bottom: 20%; left: 20%; animation-delay: 4s; }        .login-header.success {        body {            --info-color: #36b9cc;    <!-- Bootstrap CSS -->    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">



        @keyframes float {            background: linear-gradient(135deg, var(--success-color), var(--info-color));

            0%, 100% { transform: translateY(0px) rotate(0deg); }

            50% { transform: translateY(-20px) rotate(180deg); }        }            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;

        }



        .fade-in {

            animation: fadeIn 0.8s ease-in;        .login-body {            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);            --warning-color: #f6c23e;

        }

            padding: 2rem;

        @keyframes fadeIn {

            from { opacity: 0; transform: translateY(30px); }        }            min-height: 100vh;

            to { opacity: 1; transform: translateY(0); }

        }



        /* Responsive adjustments */        .btn-login {            display: flex;            --danger-color: #e74a3b;    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    <!-- FontAwesome -->

        @media (max-width: 576px) {

            .login-card {            background: linear-gradient(45deg, var(--primary-color), var(--info-color));

                margin: 1rem;

                max-width: calc(100% - 2rem);            border: none;            align-items: center;

            }

            .login-body {            border-radius: 25px;

                padding: 1.5rem;

            }            padding: 0.875rem 2rem;        }            --light-color: #f8f9fc;

            .login-header {

                padding: 1.5rem;            font-size: 1.1rem;

            }

        }            font-weight: 600;

    </style>

</head>            color: white;



<body>            width: 100%;        .login-card {            --dark-color: #5a5c69;        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous">

    <!-- Floating Background Animation -->

    <div class="floating-shapes">            transition: all 0.3s;

        <div class="shape1"></div>

        <div class="shape2"></div>        }            border: none;

        <div class="shape3"></div>

    </div>



    <div class="container-fluid">        .btn-login:hover {            border-radius: 20px;        }

        <div class="row justify-content-center">

            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">            background: linear-gradient(45deg, var(--info-color), var(--primary-color));

                <div class="login-card fade-in">

                    <!-- Header -->            transform: translateY(-2px);            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);

                    <div class="login-header <?= (isset($already_logged_in) && $already_logged_in) ? 'success' : '' ?>">

                        <div class="brand-icon">            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);

                            <i class="fas fa-assistive-listening-systems"></i>

                        </div>            color: white;            backdrop-filter: blur(10px);    <!-- FontAwesome -->    <!-- SB Admin 2 -->

                        <h2 class="mb-1">PHA Manager</h2>

                        <p class="mb-0 opacity-75">Professional Hearing Aid Management System v4</p>        }

                    </div>

            background: rgba(255, 255, 255, 0.95);

                    <!-- Body -->

                    <div class="login-body">        .login-footer {

                        <!-- Flash Messages -->

                        <?php if (session()->getFlashdata('error')): ?>            background-color: #f8f9fc;            max-width: 450px;        body {

                            <div class="alert alert-danger">

                                <i class="fas fa-exclamation-triangle me-2"></i>            padding: 1.5rem 2rem;

                                <?= session()->getFlashdata('error') ?>

                            </div>            border-radius: 0 0 20px 20px;            margin: 0 auto;

                        <?php endif; ?>

            text-align: center;

                        <?php if (session()->getFlashdata('success')): ?>

                            <div class="alert alert-success">            border-top: 1px solid #e3e6f0;        }            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet" crossorigin="anonymous">

                                <i class="fas fa-check-circle me-2"></i>

                                <?= session()->getFlashdata('success') ?>        }

                            </div>

                        <?php endif; ?>



                        <?php if (session()->getFlashdata('info')): ?>        .system-info {

                            <div class="alert alert-info">

                                <i class="fas fa-info-circle me-2"></i>            font-size: 0.85rem;        .login-header {            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);

                                <?= session()->getFlashdata('info') ?>

                            </div>            color: var(--secondary-color);

                        <?php endif; ?>

        }            background: linear-gradient(135deg, var(--primary-color), var(--info-color));

                        <?php if (isset($already_logged_in) && $already_logged_in): ?>

                            <!-- Already Logged In State -->

                            <div class="text-center mb-4">

                                <h5 class="text-success mb-3">        .brand-icon {            color: white;            min-height: 100vh;    

                                    <i class="fas fa-check-circle me-2"></i>

                                    Είστε ήδη συνδεδεμένος!            font-size: 3rem;

                                </h5>

                                <div class="session-info">            margin-bottom: 1rem;            padding: 2rem;

                                    <div class="row">

                                        <div class="col-12 mb-2">            color: rgba(255, 255, 255, 0.9);

                                            <strong><i class="fas fa-user me-2 text-primary"></i>Χρήστης:</strong> 

                                            <?= esc($username ?? 'Administrator') ?>        }            border-radius: 20px 20px 0 0;            display: flex;

                                        </div>

                                        <div class="col-12">

                                            <strong><i class="fas fa-clock me-2 text-info"></i>Σύνδεση:</strong> 

                                            <?= esc($login_time ?? date('d/m/Y H:i')) ?>        .alert {            text-align: center;

                                        </div>

                                    </div>            border-radius: 15px;

                                </div>

                            </div>            border: none;        }            align-items: center;    <!-- SB Admin 2 CSS -->    <style>



                            <!-- Action Buttons -->            margin-bottom: 1.5rem;

                            <div class="d-grid gap-3 mb-4">

                                <a href="<?= site_url('dashboard') ?>" class="btn btn-success" style="border-radius: 25px; font-weight: 600;">        }

                                    <i class="fas fa-tachometer-alt me-2"></i>

                                    Συνέχεια στο Dashboard

                                </a>

                                        .floating-shapes {        .login-header.success {        }

                                <a href="<?= site_url('auth/logout') ?>" class="btn btn-outline-danger" style="border-radius: 25px;">

                                    <i class="fas fa-sign-out-alt me-2"></i>            position: fixed;

                                    Αποσύνδεση

                                </a>            top: 0;            background: linear-gradient(135deg, var(--success-color), var(--info-color));

                            </div>

            left: 0;

                            <!-- Utility Links -->

                            <div class="row">            width: 100%;        }    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">        body {

                                <div class="col-6">

                                    <a href="#" class="btn btn-outline-info w-100 btn-sm">            height: 100%;

                                        <i class="fas fa-question-circle"></i>

                                        Βοήθεια            overflow: hidden;

                                    </a>

                                </div>            z-index: -1;

                                <div class="col-6">

                                    <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-outline-warning w-100 btn-sm">        }        .login-body {        .login-card {

                                        <i class="fas fa-broom"></i>

                                        Reset

                                    </a>

                                </div>        .floating-shapes div {            padding: 2rem;

                            </div>

            position: absolute;

                        <?php else: ?>

                            <!-- Fresh Login State -->            border-radius: 50%;        }            border: none;                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

                            <div class="text-center mb-4">

                                <h5 class="text-primary mb-3">Σύνδεση στο Σύστημα</h5>            background: rgba(255, 255, 255, 0.1);

                                <p class="text-muted small mb-4">

                                    <i class="fas fa-info-circle me-1"></i>            animation: float 6s ease-in-out infinite;

                                    Κλικ για άμεση είσοδο στο PHA Manager v4

                                </p>        }



                                <!-- Main Login Button -->        .btn-login {            border-radius: 20px;

                                <div class="d-grid mb-4">

                                    <button type="button" class="btn btn-login" id="quickLoginBtn" onclick="performLogin()">        .floating-shapes div:nth-child(1) {

                                        <i class="fas fa-sign-in-alt me-2"></i>

                                        Είσοδος στο Σύστημα            width: 80px;            background: linear-gradient(45deg, var(--primary-color), var(--info-color));

                                    </button>

                                </div>            height: 80px;

                            </div>

            top: 20%;            border: none;            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);    <style>            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;

                            <!-- Alternative Actions -->

                            <div class="row">            left: 10%;

                                <div class="col-6">

                                    <a href="#" class="btn btn-outline-info w-100 btn-sm">            animation-delay: 0s;            border-radius: 25px;

                                        <i class="fas fa-question-circle"></i>

                                        Βοήθεια        }

                                    </a>

                                </div>            padding: 0.875rem 2rem;            backdrop-filter: blur(10px);

                                <div class="col-6">

                                    <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-outline-warning w-100 btn-sm">        .floating-shapes div:nth-child(2) {

                                        <i class="fas fa-broom"></i>

                                        Reset            width: 120px;            font-size: 1.1rem;

                                    </a>

                                </div>            height: 120px;

                            </div>

                        <?php endif; ?>            top: 60%;            font-weight: 600;            background: rgba(255, 255, 255, 0.95);        :root {        }

                    </div>

            right: 10%;

                    <!-- Footer -->

                    <div class="login-footer">            animation-delay: 2s;            color: white;

                        <div class="row align-items-center">

                            <div class="col-12 mb-2">        }

                                <i class="fas fa-shield-alt text-success me-1"></i>

                                <strong>Ασφαλής Σύνδεση</strong>            width: 100%;            max-width: 450px;

                                <span class="mx-2">|</span>

                                <i class="fas fa-server text-info me-1"></i>        .floating-shapes div:nth-child(3) {

                                <strong>Παραγωγικό Περιβάλλον</strong>

                            </div>            width: 60px;            transition: all 0.3s;

                            <div class="col-12 mb-2">

                                <i class="fas fa-globe me-1"></i>            height: 60px;

                                <small><?= base_url() ?></small>

                            </div>            bottom: 20%;        }            margin: 0 auto;            --primary-color: #4e73df;        

                            <div class="col-12 text-primary">

                                <small>© <?= date('Y') ?> Pikas Hearing Aid Center</small>            left: 20%;

                            </div>

                        </div>            animation-delay: 4s;

                    </div>

                </div>        }

            </div>

        </div>        .btn-login:hover {        }

    </div>

        @keyframes float {

    <!-- JavaScript -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>            0%, 100% { transform: translateY(0px) rotate(0deg); }            background: linear-gradient(45deg, var(--info-color), var(--primary-color));

    

    <script>            50% { transform: translateY(-20px) rotate(180deg); }

        console.log('PHA Manager v4 Login Page Loaded');

        console.log('Base URL:', '<?= base_url() ?>');        }            transform: translateY(-2px);            --secondary-color: #858796;        .login-container {



        // Login function

        function performLogin() {

            const btn = document.getElementById('quickLoginBtn');        .fade-in {            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);

            const originalText = btn.innerHTML;

                        animation: fadeIn 0.8s ease-in;

            // Show loading state

            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Σύνδεση...';        }            color: white;        .login-header {

            btn.disabled = true;

            

            // Redirect to login endpoint

            window.location.href = '<?= site_url('auth/login') ?>';        @keyframes fadeIn {        }

        }

            from { opacity: 0; transform: translateY(30px); }

        // Auto-dismiss alerts

        setTimeout(function() {            to { opacity: 1; transform: translateY(0); }            background: linear-gradient(135deg, var(--primary-color), var(--info-color));            --success-color: #1cc88a;            min-height: 100vh;

            const alerts = document.querySelectorAll('.alert');

            alerts.forEach(alert => {        }

                alert.style.transition = 'opacity 0.5s';

                alert.style.opacity = '0';        .login-footer {

                setTimeout(() => alert.remove(), 500);

            });        .session-info {

        }, 5000);

            background: #f8f9fc;            background-color: #f8f9fc;            color: white;

        // Add hover effects

        document.querySelectorAll('.btn').forEach(btn => {            border-radius: 10px;

            btn.addEventListener('mouseenter', () => {

                btn.classList.add('shadow-lg');            padding: 1rem;            padding: 1.5rem 2rem;

            });

            btn.addEventListener('mouseleave', () => {            margin-bottom: 1rem;

                btn.classList.remove('shadow-lg');

            });        }            border-radius: 0 0 20px 20px;            padding: 2rem;            --info-color: #36b9cc;            display: flex;

        });

    </style>

        // Keyboard shortcuts

        document.addEventListener('keydown', function(e) {</head>            text-align: center;

            if (e.key === 'Enter' && document.getElementById('quickLoginBtn')) {

                performLogin();

            }

        });<body>            border-top: 1px solid #e3e6f0;            border-radius: 20px 20px 0 0;



        // Session status logging    <!-- Floating Background Shapes -->

        <?php if (isset($already_logged_in) && $already_logged_in): ?>

            console.log('Session Active - User: <?= esc($username ?? 'Administrator') ?>');    <div class="floating-shapes">        }

        <?php else: ?>

            console.log('Fresh login required');        <div></div>

        <?php endif; ?>

    </script>        <div></div>            text-align: center;            --warning-color: #f6c23e;            align-items: center;

</body>

</html>        <div></div>

    </div>        .system-info {



    <div class="container">            font-size: 0.85rem;        }

        <div class="row justify-content-center">

            <div class="col-md-6">            color: var(--secondary-color);

                <div class="login-card fade-in">

                    <!-- Login Header -->        }            --danger-color: #e74a3b;            justify-content: center;

                    <div class="login-header <?= (isset($already_logged_in) && $already_logged_in) ? 'success' : '' ?>">

                        <div class="brand-icon">

                            <i class="fas fa-assistive-listening-systems"></i>

                        </div>        .brand-icon {        .login-header.success {

                        <h2 class="mb-1">PHA Manager</h2>

                        <p class="mb-0 opacity-75">Professional Hearing Aid Management System v4</p>            font-size: 3rem;

                    </div>

            margin-bottom: 1rem;            background: linear-gradient(135deg, var(--success-color), var(--info-color));            --light-color: #f8f9fc;            padding: 2rem 0;

                    <!-- Login Body -->

                    <div class="login-body">            color: rgba(255, 255, 255, 0.9);

                        <!-- Flash Messages -->

                        <?php if (session()->getFlashdata('error')): ?>        }        }

                            <div class="alert alert-danger">

                                <i class="fas fa-exclamation-triangle me-2"></i>

                                <?= session()->getFlashdata('error') ?>

                            </div>        .alert {            --dark-color: #5a5c69;        }

                        <?php endif; ?>

            border-radius: 15px;

                        <?php if (session()->getFlashdata('success')): ?>

                            <div class="alert alert-success">            border: none;        .login-body {

                                <i class="fas fa-check-circle me-2"></i>

                                <?= session()->getFlashdata('success') ?>            margin-bottom: 1.5rem;

                            </div>

                        <?php endif; ?>        }            padding: 2rem;        }        



                        <?php if (session()->getFlashdata('info')): ?>

                            <div class="alert alert-info">

                                <i class="fas fa-info-circle me-2"></i>        .floating-shapes {        }

                                <?= session()->getFlashdata('info') ?>

                            </div>            position: fixed;

                        <?php endif; ?>

            top: 0;        .login-card {

                        <?php if (isset($already_logged_in) && $already_logged_in): ?>

                            <!-- Already Logged In -->            left: 0;

                            <div class="text-center mb-4">

                                <h5 class="text-success">Είστε ήδη συνδεδεμένος!</h5>            width: 100%;        .btn-login {

                                <div class="session-info">

                                    <p class="mb-2">            height: 100%;

                                        <strong><i class="fas fa-user me-2"></i>Χρήστης:</strong> <?= esc($username) ?>

                                    </p>            overflow: hidden;            background: linear-gradient(45deg, var(--primary-color), var(--info-color));        body {            background: rgba(255, 255, 255, 0.95);

                                    <p class="mb-0">

                                        <strong><i class="fas fa-clock me-2"></i>Σύνδεση:</strong> <?= esc($login_time) ?>            z-index: -1;

                                    </p>

                                </div>        }            border: none;

                            </div>



                            <div class="d-grid gap-3">

                                <a href="<?= site_url('dashboard') ?>" class="btn btn-success" style="border-radius: 25px; font-weight: 600;">        .floating-shapes div {            border-radius: 25px;            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;            border-radius: 15px;

                                    <i class="fas fa-tachometer-alt me-2"></i>

                                    Συνέχεια στο Dashboard            position: absolute;

                                </a>

                                            border-radius: 50%;            padding: 0.875rem 2rem;

                                <a href="<?= site_url('auth/logout') ?>" class="btn btn-outline-danger" style="border-radius: 25px;">

                                    <i class="fas fa-sign-out-alt me-2"></i>            background: rgba(255, 255, 255, 0.1);

                                    Αποσύνδεση

                                </a>            animation: float 6s ease-in-out infinite;            font-size: 1.1rem;            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);

                            </div>

        }

                            <div class="text-center mt-3">

                                <small>            font-weight: 600;

                                    <a href="<?= site_url('auth?force_logout=1') ?>" class="text-muted">

                                        <i class="fas fa-broom me-1"></i>        .floating-shapes div:nth-child(1) {

                                        Καθαρισμός Session

                                    </a>            width: 80px;            color: white;            min-height: 100vh;            backdrop-filter: blur(10px);

                                </small>

                            </div>            height: 80px;

                        <?php else: ?>

                            <!-- Fresh Login -->            top: 20%;            width: 100%;

                            <div class="text-center mb-4">

                                <h5 class="text-primary">Σύνδεση στο Σύστημα</h5>            left: 10%;

                                <p class="text-muted small">Κλικ για άμεση είσοδο στο PHA Manager v4</p>

                            </div>            animation-delay: 0s;            transition: all 0.3s;            display: flex;            border: 1px solid rgba(255, 255, 255, 0.2);



                            <div class="d-grid gap-3">        }

                                <a href="<?= site_url('auth/login') ?>" class="btn btn-login" id="quickLoginBtn">

                                    <i class="fas fa-sign-in-alt me-2"></i>        }

                                    Είσοδος στο Σύστημα

                                </a>        .floating-shapes div:nth-child(2) {

                            </div>

            width: 120px;            align-items: center;        }

                            <!-- Alternative Access -->

                            <div class="row mt-4">            height: 120px;

                                <div class="col-6">

                                    <a href="<?= site_url('help') ?>" class="btn btn-outline-info w-100" style="border-radius: 20px;">            top: 60%;        .btn-login:hover {

                                        <i class="fas fa-question-circle me-1"></i>

                                        Βοήθεια            right: 10%;

                                    </a>

                                </div>            animation-delay: 2s;            background: linear-gradient(45deg, var(--info-color), var(--primary-color));        }        

                                <div class="col-6">

                                    <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-outline-warning w-100" style="border-radius: 20px;">        }

                                        <i class="fas fa-broom me-1"></i>

                                        Reset Session            transform: translateY(-2px);

                                    </a>

                                </div>        .floating-shapes div:nth-child(3) {

                            </div>

                        <?php endif; ?>            width: 60px;            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);        .brand-logo {

                    </div>

            height: 60px;

                    <!-- Login Footer -->

                    <div class="login-footer">            bottom: 20%;            color: white;

                        <div class="system-info">

                            <div class="mb-2">            left: 20%;

                                <i class="fas fa-shield-alt text-success me-2"></i>

                                <strong>Ασφαλής Σύνδεση</strong> |             animation-delay: 4s;        }        .login-card {            color: #4e73df;

                                <i class="fas fa-server text-info me-2 ms-2"></i>

                                <strong>Παραγωγικό Περιβάλλον</strong>        }

                            </div>

                            <div class="mb-2">

                                <i class="fas fa-globe me-2"></i>

                                <?= base_url() ?>        @keyframes float {

                            </div>

                            <div class="text-primary">            0%, 100% { transform: translateY(0px) rotate(0deg); }        .login-footer {            border: none;            font-size: 3rem;

                                <small>© <?= date('Y') ?> Pikas Hearing Aid Center - Powered by CodeIgniter 4</small>

                            </div>            50% { transform: translateY(-20px) rotate(180deg); }

                        </div>

                    </div>        }            background-color: #f8f9fc;

                </div>

            </div>

        </div>

    </div>        .fade-in {            padding: 1.5rem 2rem;            border-radius: 20px;            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);



    <!-- Scripts - Local first, then CDN fallback -->            animation: fadeIn 0.8s ease-in;

    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>

    <script>        }            border-radius: 0 0 20px 20px;

        // Fallback to CDN if local jQuery fails

        if (typeof jQuery === 'undefined') {

            document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');

        }        @keyframes fadeIn {            text-align: center;            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);        }

    </script>

                from { opacity: 0; transform: translateY(30px); }

    <!-- Bootstrap JS - Local preferred -->

    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>            to { opacity: 1; transform: translateY(0); }            border-top: 1px solid #e3e6f0;

    <script>

        // Fallback to CDN if local Bootstrap fails        }

        if (typeof bootstrap === 'undefined') {

            document.write('<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"><\/script>');        }            backdrop-filter: blur(10px);        

        }

    </script>        .session-info {



    <script>            background: #f8f9fc;

        $(document).ready(function() {

            console.log('Login page loaded successfully');            border-radius: 10px;

            console.log('Base URL: <?= base_url() ?>');

                        padding: 1rem;        .system-info {            background: rgba(255, 255, 255, 0.95);        .brand-text {

            // Add loading animation to login button

            $('#quickLoginBtn').on('click', function(e) {            margin-bottom: 1rem;

                var btn = $(this);

                var originalText = btn.html();        }            font-size: 0.85rem;

                

                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Σύνδεση...');    </style>

                btn.prop('disabled', true);

                </head>            color: var(--secondary-color);            max-width: 450px;            color: #5a5c69;

                // Re-enable after 3 seconds if something goes wrong

                setTimeout(function() {

                    btn.html(originalText);

                    btn.prop('disabled', false);<body>        }

                }, 3000);

            });    <!-- Floating Background Shapes -->



            // Auto-dismiss alerts    <div class="floating-shapes">            margin: 0 auto;            font-weight: 800;

            setTimeout(function() {

                $('.alert').fadeOut('slow');        <div></div>

            }, 5000);

        <div></div>        .brand-icon {

            // Add hover effect to buttons

            $('.btn').hover(        <div></div>

                function() {

                    $(this).addClass('shadow-lg');    </div>            font-size: 3rem;        }            font-size: 1.75rem;

                },

                function() {

                    $(this).removeClass('shadow-lg');

                }    <div class="container">            margin-bottom: 1rem;

            );

        <div class="row justify-content-center">

            // Focus management for better UX

            $(document).keydown(function(e) {            <div class="col-md-6">            color: rgba(255, 255, 255, 0.9);        }

                if (e.key === 'Enter' && $('#quickLoginBtn').length) {

                    $('#quickLoginBtn')[0].click();                <div class="login-card fade-in">

                }

            });                    <!-- Login Header -->        }



            // Show session status if needed                    <div class="login-header <?= (isset($already_logged_in) && $already_logged_in) ? 'success' : '' ?>">

            <?php if (isset($already_logged_in) && $already_logged_in): ?>

                console.log('User already logged in: <?= esc($username) ?>');                        <div class="brand-icon">        .login-header {        

            <?php endif; ?>

        });                            <i class="fas fa-assistive-listening-systems"></i>

    </script>

</body>                        </div>        .alert {

</html>
                        <h2 class="mb-1">PHA Manager</h2>

                        <p class="mb-0 opacity-75">Professional Hearing Aid Management System v4</p>            border-radius: 15px;            background: linear-gradient(135deg, var(--primary-color), var(--info-color));        .form-control-user {

                    </div>

            border: none;

                    <!-- Login Body -->

                    <div class="login-body">            margin-bottom: 1.5rem;            color: white;            border-radius: 10rem;

                        <!-- Flash Messages -->

                        <?php if (session()->getFlashdata('error')): ?>        }

                            <div class="alert alert-danger">

                                <i class="fas fa-exclamation-triangle me-2"></i>            padding: 2rem;            padding: 1.5rem 1rem;

                                <?= session()->getFlashdata('error') ?>

                            </div>        .floating-shapes {

                        <?php endif; ?>

            position: fixed;            border-radius: 20px 20px 0 0;            border: 1px solid #e3e6f0;

                        <?php if (session()->getFlashdata('success')): ?>

                            <div class="alert alert-success">            top: 0;

                                <i class="fas fa-check-circle me-2"></i>

                                <?= session()->getFlashdata('success') ?>            left: 0;            text-align: center;            font-size: 0.9rem;

                            </div>

                        <?php endif; ?>            width: 100%;



                        <?php if (session()->getFlashdata('info')): ?>            height: 100%;        }        }

                            <div class="alert alert-info">

                                <i class="fas fa-info-circle me-2"></i>            overflow: hidden;

                                <?= session()->getFlashdata('info') ?>

                            </div>            z-index: -1;        

                        <?php endif; ?>

        }

                        <?php if (isset($already_logged_in) && $already_logged_in): ?>

                            <!-- Already Logged In -->        .login-body {        .form-control-user:focus {

                            <div class="text-center mb-4">

                                <h5 class="text-success">Είστε ήδη συνδεδεμένος!</h5>        .floating-shapes div {

                                <div class="session-info">

                                    <p class="mb-2">            position: absolute;            padding: 2rem;            border-color: #4e73df;

                                        <strong><i class="fas fa-user me-2"></i>Χρήστης:</strong> <?= esc($username) ?>

                                    </p>            border-radius: 50%;

                                    <p class="mb-0">

                                        <strong><i class="fas fa-clock me-2"></i>Σύνδεση:</strong> <?= esc($login_time) ?>            background: rgba(255, 255, 255, 0.1);        }            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);

                                    </p>

                                </div>            animation: float 6s ease-in-out infinite;

                            </div>

        }        }

                            <div class="d-grid gap-3">

                                <a href="<?= site_url('dashboard') ?>" class="btn btn-success" style="border-radius: 25px; font-weight: 600;">

                                    <i class="fas fa-tachometer-alt me-2"></i>

                                    Συνέχεια στο Dashboard        .floating-shapes div:nth-child(1) {        .form-control {        

                                </a>

                                            width: 80px;

                                <a href="<?= site_url('auth/logout') ?>" class="btn btn-outline-danger" style="border-radius: 25px;">

                                    <i class="fas fa-sign-out-alt me-2"></i>            height: 80px;            border-radius: 25px;        .btn-user {

                                    Αποσύνδεση

                                </a>            top: 20%;

                            </div>

            left: 10%;            padding: 0.875rem 1.125rem;            border-radius: 10rem;

                            <div class="text-center mt-3">

                                <small>            animation-delay: 0s;

                                    <a href="<?= site_url('auth?force_logout=1') ?>" class="text-muted">

                                        <i class="fas fa-broom me-1"></i>        }            border: 2px solid #e3e6f0;            padding: 0.75rem 1rem;

                                        Καθαρισμός Session

                                    </a>

                                </small>

                            </div>        .floating-shapes div:nth-child(2) {            font-size: 1rem;            font-size: 0.9rem;

                        <?php else: ?>

                            <!-- Fresh Login -->            width: 120px;

                            <div class="text-center mb-4">

                                <h5 class="text-primary">Σύνδεση στο Σύστημα</h5>            height: 120px;        }            font-weight: 800;

                                <p class="text-muted small">Κλικ για άμεση είσοδο στο PHA Manager v4</p>

                            </div>            top: 60%;



                            <div class="d-grid gap-3">            right: 10%;            letter-spacing: 0.1rem;

                                <a href="<?= site_url('auth/login') ?>" class="btn btn-login" id="quickLoginBtn">

                                    <i class="fas fa-sign-in-alt me-2"></i>            animation-delay: 2s;

                                    Είσοδος στο Σύστημα

                                </a>        }        .form-control:focus {            text-transform: uppercase;

                            </div>



                            <!-- Alternative Access -->

                            <div class="row mt-4">        .floating-shapes div:nth-child(3) {            border-color: var(--primary-color);        }

                                <div class="col-6">

                                    <a href="<?= site_url('help') ?>" class="btn btn-outline-info w-100" style="border-radius: 20px;">            width: 60px;

                                        <i class="fas fa-question-circle me-1"></i>

                                        Βοήθεια            height: 60px;            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);        

                                    </a>

                                </div>            bottom: 20%;

                                <div class="col-6">

                                    <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-outline-warning w-100" style="border-radius: 20px;">            left: 20%;        }        .divider {

                                        <i class="fas fa-broom me-1"></i>

                                        Reset Session            animation-delay: 4s;

                                    </a>

                                </div>        }            position: relative;

                            </div>

                        <?php endif; ?>

                    </div>

        @keyframes float {        .btn-login {            text-align: center;

                    <!-- Login Footer -->

                    <div class="login-footer">            0%, 100% { transform: translateY(0px) rotate(0deg); }

                        <div class="system-info">

                            <div class="mb-2">            50% { transform: translateY(-20px) rotate(180deg); }            background: linear-gradient(45deg, var(--primary-color), var(--info-color));            margin: 1.5rem 0;

                                <i class="fas fa-shield-alt text-success me-2"></i>

                                <strong>Ασφαλής Σύνδεση</strong> |         }

                                <i class="fas fa-server text-info me-2 ms-2"></i>

                                <strong>Παραγωγικό Περιβάλλον</strong>            border: none;        }

                            </div>

                            <div class="mb-2">        .fade-in {

                                <i class="fas fa-globe me-2"></i>

                                <?= base_url() ?>            animation: fadeIn 0.8s ease-in;            border-radius: 25px;        

                            </div>

                            <div class="text-primary">        }

                                <small>© <?= date('Y') ?> Pikas Hearing Aid Center - Powered by CodeIgniter 4</small>

                            </div>            padding: 0.875rem 2rem;        .divider::before {

                        </div>

                    </div>        @keyframes fadeIn {

                </div>

            </div>            from { opacity: 0; transform: translateY(30px); }            font-size: 1.1rem;            content: '';

        </div>

    </div>            to { opacity: 1; transform: translateY(0); }



    <!-- Scripts -->        }            font-weight: 600;            position: absolute;

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <script>        .session-info {            color: white;            top: 50%;

        $(document).ready(function() {

            // Add loading animation to login button            background: #f8f9fc;

            $('#quickLoginBtn').on('click', function(e) {

                var btn = $(this);            border-radius: 10px;            width: 100%;            left: 0;

                var originalText = btn.html();

                            padding: 1rem;

                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Σύνδεση...');

                btn.prop('disabled', true);            margin-bottom: 1rem;            transition: all 0.3s;            right: 0;

                

                // Re-enable after 3 seconds if something goes wrong        }

                setTimeout(function() {

                    btn.html(originalText);    </style>        }            height: 1px;

                    btn.prop('disabled', false);

                }, 3000);</head>

            });

            background: #e3e6f0;

            // Auto-dismiss alerts

            setTimeout(function() {<body>

                $('.alert').fadeOut('slow');

            }, 5000);    <!-- Floating Background Shapes -->        .btn-login:hover {        }



            // Add hover effect to buttons    <div class="floating-shapes">

            $('.btn').hover(

                function() {        <div></div>            background: linear-gradient(45deg, var(--info-color), var(--primary-color));        

                    $(this).addClass('shadow-lg');

                },        <div></div>

                function() {

                    $(this).removeClass('shadow-lg');        <div></div>            transform: translateY(-2px);        .divider span {

                }

            );    </div>



            // Focus management for better UX            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);            background: white;

            $(document).keydown(function(e) {

                if (e.key === 'Enter' && $('#quickLoginBtn').length) {    <div class="container">

                    $('#quickLoginBtn')[0].click();

                }        <div class="row justify-content-center">            color: white;            padding: 0 1rem;

            });

            <div class="col-md-6">

            // Show session status if needed

            <?php if (isset($already_logged_in) && $already_logged_in): ?>                <div class="login-card fade-in">        }            color: #858796;

                console.log('User already logged in: <?= esc($username) ?>');

            <?php endif; ?>                    <!-- Login Header -->

        });

    </script>                    <div class="login-header <?= (isset($already_logged_in) && $already_logged_in) ? 'success' : '' ?>">            font-size: 0.85rem;

</body>

</html>                        <div class="brand-icon">

                            <i class="fas fa-assistive-listening-systems"></i>        .form-floating > label {        }

                        </div>

                        <h2 class="mb-1">PHA Manager</h2>            color: var(--secondary-color);        

                        <p class="mb-0 opacity-75">Professional Hearing Aid Management System v4</p>

                    </div>        }        .remember-me {



                    <!-- Login Body -->            font-size: 0.85rem;

                    <div class="login-body">

                        <!-- Flash Messages -->        .login-footer {        }

                        <?php if (session()->getFlashdata('error')): ?>

                            <div class="alert alert-danger">            background-color: #f8f9fc;        

                                <i class="fas fa-exclamation-triangle me-2"></i>

                                <?= session()->getFlashdata('error') ?>            padding: 1.5rem 2rem;        .forgot-password {

                            </div>

                        <?php endif; ?>            border-radius: 0 0 20px 20px;            color: #4e73df;



                        <?php if (session()->getFlashdata('success')): ?>            text-align: center;            font-size: 0.85rem;

                            <div class="alert alert-success">

                                <i class="fas fa-check-circle me-2"></i>            border-top: 1px solid #e3e6f0;            text-decoration: none;

                                <?= session()->getFlashdata('success') ?>

                            </div>        }        }

                        <?php endif; ?>

        

                        <?php if (session()->getFlashdata('info')): ?>

                            <div class="alert alert-info">        .system-info {        .forgot-password:hover {

                                <i class="fas fa-info-circle me-2"></i>

                                <?= session()->getFlashdata('info') ?>            font-size: 0.85rem;            color: #2e59d9;

                            </div>

                        <?php endif; ?>            color: var(--secondary-color);            text-decoration: underline;



                        <?php if (isset($already_logged_in) && $already_logged_in): ?>        }        }

                            <!-- Already Logged In -->

                            <div class="text-center mb-4">        

                                <h5 class="text-success">Είστε ήδη συνδεδεμένος!</h5>

                                <div class="session-info">        .brand-icon {        .register-link {

                                    <p class="mb-2">

                                        <strong><i class="fas fa-user me-2"></i>Χρήστης:</strong> <?= esc($username) ?>            font-size: 3rem;            color: #4e73df;

                                    </p>

                                    <p class="mb-0">            margin-bottom: 1rem;            font-weight: 800;

                                        <strong><i class="fas fa-clock me-2"></i>Σύνδεση:</strong> <?= esc($login_time) ?>

                                    </p>            color: rgba(255, 255, 255, 0.9);            text-decoration: none;

                                </div>

                            </div>        }        }



                            <div class="d-grid gap-3">        

                                <a href="<?= site_url('dashboard') ?>" class="btn btn-success" style="border-radius: 25px; font-weight: 600;">

                                    <i class="fas fa-tachometer-alt me-2"></i>        .alert {        .register-link:hover {

                                    Συνέχεια στο Dashboard

                                </a>            border-radius: 15px;            color: #2e59d9;

                                

                                <a href="<?= site_url('auth/logout') ?>" class="btn btn-outline-danger" style="border-radius: 25px;">            border: none;            text-decoration: underline;

                                    <i class="fas fa-sign-out-alt me-2"></i>

                                    Αποσύνδεση            margin-bottom: 1.5rem;        }

                                </a>

                            </div>        }



                            <div class="text-center mt-3">        .alert {

                                <small>

                                    <a href="<?= site_url('auth?force_logout=1') ?>" class="text-muted">        .floating-shapes {            border-radius: 10px;

                                        <i class="fas fa-broom me-1"></i>

                                        Καθαρισμός Session            position: fixed;            border: none;

                                    </a>

                                </small>            top: 0;            font-size: 0.875rem;

                            </div>

                        <?php else: ?>            left: 0;        }

                            <!-- Fresh Login -->

                            <div class="text-center mb-4">            width: 100%;

                                <h5 class="text-primary">Σύνδεση στο Σύστημα</h5>

                                <p class="text-muted small">Κλικ για άμεση είσοδο στο PHA Manager v4</p>            height: 100%;        .input-group-text {

                            </div>

            overflow: hidden;            border-radius: 10rem 0 0 10rem;

                            <div class="d-grid gap-3">

                                <a href="<?= site_url('auth/login') ?>" class="btn btn-login" id="quickLoginBtn">            z-index: -1;            border-right: none;

                                    <i class="fas fa-sign-in-alt me-2"></i>

                                    Είσοδος στο Σύστημα        }            background-color: #f8f9fc;

                                </a>

                            </div>            color: #858796;



                            <!-- Alternative Access -->        .floating-shapes div {        }

                            <div class="row mt-4">

                                <div class="col-6">            position: absolute;

                                    <a href="<?= site_url('help') ?>" class="btn btn-outline-info w-100" style="border-radius: 20px;">

                                        <i class="fas fa-question-circle me-1"></i>            border-radius: 50%;        .form-control-user.with-icon {

                                        Βοήθεια

                                    </a>            background: rgba(255, 255, 255, 0.1);            border-radius: 0 10rem 10rem 0;

                                </div>

                                <div class="col-6">            animation: float 6s ease-in-out infinite;            border-left: none;

                                    <a href="<?= site_url('auth?force_logout=1') ?>" class="btn btn-outline-warning w-100" style="border-radius: 20px;">

                                        <i class="fas fa-broom me-1"></i>        }        }

                                        Reset Session

                                    </a>

                                </div>

                            </div>        .floating-shapes div:nth-child(1) {        .login-footer {

                        <?php endif; ?>

                    </div>            width: 80px;            text-align: center;



                    <!-- Login Footer -->            height: 80px;            margin-top: 2rem;

                    <div class="login-footer">

                        <div class="system-info">            top: 20%;            color: rgba(255, 255, 255, 0.8);

                            <div class="mb-2">

                                <i class="fas fa-shield-alt text-success me-2"></i>            left: 10%;            font-size: 0.8rem;

                                <strong>Ασφαλής Σύνδεση</strong> | 

                                <i class="fas fa-server text-info me-2 ms-2"></i>            animation-delay: 0s;        }

                                <strong>Παραγωγικό Περιβάλλον</strong>

                            </div>        }

                            <div class="mb-2">

                                <i class="fas fa-globe me-2"></i>        .animated-bg {

                                <?= base_url() ?>

                            </div>        .floating-shapes div:nth-child(2) {            position: fixed;

                            <div class="text-primary">

                                <small>© <?= date('Y') ?> Pikas Hearing Aid Center - Powered by CodeIgniter 4</small>            width: 120px;            top: 0;

                            </div>

                        </div>            height: 120px;            left: 0;

                    </div>

                </div>            top: 60%;            width: 100%;

            </div>

        </div>            right: 10%;            height: 100%;

    </div>

            animation-delay: 2s;            z-index: -1;

    <!-- Scripts -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>        }            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        }

    <script>

        $(document).ready(function() {        .floating-shapes div:nth-child(3) {

            // Add loading animation to login button

            $('#quickLoginBtn').on('click', function(e) {            width: 60px;        .animated-bg::before {

                var btn = $(this);

                var originalText = btn.html();            height: 60px;            content: '';

                

                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Σύνδεση...');            bottom: 20%;            position: absolute;

                btn.prop('disabled', true);

                            left: 20%;            top: 0;

                // Re-enable after 3 seconds if something goes wrong

                setTimeout(function() {            animation-delay: 4s;            left: 0;

                    btn.html(originalText);

                    btn.prop('disabled', false);        }            width: 100%;

                }, 3000);

            });            height: 100%;



            // Auto-dismiss alerts        @keyframes float {            background: 

            setTimeout(function() {

                $('.alert').fadeOut('slow');            0%, 100% { transform: translateY(0px) rotate(0deg); }                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),

            }, 5000);

            50% { transform: translateY(-20px) rotate(180deg); }                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),

            // Add hover effect to buttons

            $('.btn').hover(        }                radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);

                function() {

                    $(this).addClass('shadow-lg');        }

                },

                function() {        .fade-in {    </style>

                    $(this).removeClass('shadow-lg');

                }            animation: fadeIn 0.8s ease-in;</head>

            );

        }

            // Focus management for better UX

            $(document).keydown(function(e) {<body>

                if (e.key === 'Enter' && $('#quickLoginBtn').length) {

                    $('#quickLoginBtn')[0].click();        @keyframes fadeIn {    <div class="animated-bg"></div>

                }

            });            from { opacity: 0; transform: translateY(30px); }    



            // Show session status if needed            to { opacity: 1; transform: translateY(0); }    <div class="login-container">

            <?php if (isset($already_logged_in) && $already_logged_in): ?>

                console.log('User already logged in: <?= esc($username) ?>');        }        <div class="row justify-content-center w-100">

            <?php endif; ?>

        });    </style>            <div class="col-xl-6 col-lg-8 col-md-9">

    </script>

</body></head>                <div class="card login-card border-0">

</html>
                    <div class="card-body p-5">

<body>                        <!-- Brand Header -->

    <!-- Floating Background Shapes -->                        <div class="text-center mb-4">

    <div class="floating-shapes">                            <div class="brand-logo">

        <div></div>                                <i class="fas fa-assistive-listening-systems"></i>

        <div></div>                            </div>

        <div></div>                            <div class="brand-text">PHA Manager</div>

    </div>                            <p class="text-muted mb-0">Professional Hearing Aid Management</p>

                        </div>

    <div class="container">

        <div class="row justify-content-center">                        <!-- Flash Messages -->

            <div class="col-md-6">                        <?php if (session()->getFlashdata('error')): ?>

                <div class="login-card fade-in">                            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    <!-- Login Header -->                                <i class="fas fa-exclamation-triangle me-2"></i>

                    <div class="login-header">                                <?= session()->getFlashdata('error') ?>

                        <div class="brand-icon">                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                            <i class="fas fa-assistive-listening-systems"></i>                            </div>

                        </div>                        <?php endif; ?>

                        <h2 class="mb-1">PHA Manager</h2>

                        <p class="mb-0 opacity-75">Professional Hearing Aid Management System v4</p>                        <?php if (session()->getFlashdata('success')): ?>

                    </div>                            <div class="alert alert-success alert-dismissible fade show" role="alert">

                                <i class="fas fa-check-circle me-2"></i>

                    <!-- Login Body -->                                <?= session()->getFlashdata('success') ?>

                    <div class="login-body">                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                        <!-- Flash Messages -->                            </div>

                        <?php if (session()->getFlashdata('error')): ?>                        <?php endif; ?>

                            <div class="alert alert-danger">

                                <i class="fas fa-exclamation-triangle me-2"></i>                        <!-- Login Form -->

                                <?= session()->getFlashdata('error') ?>                        <?= form_open(base_url('login'), ['class' => 'user']) ?>

                            </div>                            <?= csrf_field() ?>

                        <?php endif; ?>                            <div class="form-group mb-3">

                                <div class="input-group">

                        <?php if (session()->getFlashdata('success')): ?>                                    <span class="input-group-text">

                            <div class="alert alert-success">                                        <i class="fas fa-user"></i>

                                <i class="fas fa-check-circle me-2"></i>                                    </span>

                                <?= session()->getFlashdata('success') ?>                                    <input type="text" 

                            </div>                                           class="form-control form-control-user with-icon <?= isset($validation) && $validation->hasError('login') ? 'is-invalid' : '' ?>" 

                        <?php endif; ?>                                           id="login" 

                                           name="login" 

                        <?php if (session()->getFlashdata('info')): ?>                                           placeholder="Email ή Username"

                            <div class="alert alert-info">                                           value="<?= old('login') ?>" 

                                <i class="fas fa-info-circle me-2"></i>                                           required>

                                <?= session()->getFlashdata('info') ?>                                </div>

                            </div>                                <?php if (isset($validation) && $validation->hasError('login')): ?>

                        <?php endif; ?>                                    <div class="invalid-feedback d-block">

                                        <?= $validation->getError('login') ?>

                        <!-- Quick Access Login -->                                    </div>

                        <div class="text-center mb-4">                                <?php endif; ?>

                            <h5 class="text-primary">Γρήγορη Πρόσβαση</h5>                            </div>

                            <p class="text-muted small">Κλικ για άμεση είσοδο στο σύστημα</p>

                        </div>                            <div class="form-group mb-3">

                                <div class="input-group">

                        <div class="d-grid gap-3">                                    <span class="input-group-text">

                            <a href="<?= site_url('auth/login') ?>" class="btn btn-login" id="quickLoginBtn">                                        <i class="fas fa-lock"></i>

                                <i class="fas fa-sign-in-alt me-2"></i>                                    </span>

                                Είσοδος στο Σύστημα                                    <input type="password" 

                            </a>                                           class="form-control form-control-user with-icon <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 

                        </div>                                           id="password" 

                                           name="password" 

                        <!-- Alternative Access -->                                           placeholder="Κωδικός"

                        <div class="row mt-4">                                           required>

                            <div class="col-6">                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-radius: 0 10rem 10rem 0;">

                                <a href="<?= site_url('dashboard') ?>" class="btn btn-outline-primary w-100" style="border-radius: 20px;">                                        <i class="fas fa-eye"></i>

                                    <i class="fas fa-tachometer-alt me-1"></i>                                    </button>

                                    Dashboard                                </div>

                                </a>                                <?php if (isset($validation) && $validation->hasError('password')): ?>

                            </div>                                    <div class="invalid-feedback d-block">

                            <div class="col-6">                                        <?= $validation->getError('password') ?>

                                <a href="<?= site_url('help') ?>" class="btn btn-outline-info w-100" style="border-radius: 20px;">                                    </div>

                                    <i class="fas fa-question-circle me-1"></i>                                <?php endif; ?>

                                    Βοήθεια                            </div>

                                </a>

                            </div>                            <div class="form-group mb-3">

                        </div>                                <div class="d-flex justify-content-between align-items-center">

                    </div>                                    <div class="form-check remember-me">

                                        <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">

                    <!-- Login Footer -->                                        <label class="form-check-label" for="remember">

                    <div class="login-footer">                                            Να με θυμάσαι

                        <div class="system-info">                                        </label>

                            <div class="mb-2">                                    </div>

                                <i class="fas fa-shield-alt text-success me-2"></i>                                    <a href="<?= base_url('auth/forgot-password') ?>" class="forgot-password">

                                <strong>Ασφαλής Σύνδεση</strong> |                                         Ξεχάσατε τον κωδικό;

                                <i class="fas fa-server text-info me-2 ms-2"></i>                                    </a>

                                <strong>Παραγωγικό Περιβάλλον</strong>                                </div>

                            </div>                            </div>

                            <div class="mb-2">

                                <i class="fas fa-globe me-2"></i>                            <button type="submit" class="btn btn-primary btn-user btn-block mb-3">

                                <?= base_url() ?>                                <i class="fas fa-sign-in-alt me-1"></i> Σύνδεση

                            </div>                            </button>

                            <div class="text-primary">

                                <small>© <?= date('Y') ?> Pikas Hearing Aid Center - Powered by CodeIgniter 4</small>                            <div class="divider">

                            </div>                                <span>ή</span>

                        </div>                            </div>

                    </div>

                </div>                            <!-- Alternative Login Options (for future implementation) -->

            </div>                            <div class="row mb-3">

        </div>                                <div class="col-6">

    </div>                                    <button type="button" class="btn btn-google btn-user btn-block disabled" disabled>

                                        <i class="fab fa-google fa-fw"></i> Google

    <!-- Scripts -->                                    </button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>                                </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>                                <div class="col-6">

                                    <button type="button" class="btn btn-facebook btn-user btn-block disabled" disabled>

    <script>                                        <i class="fab fa-facebook-f fa-fw"></i> Facebook

        $(document).ready(function() {                                    </button>

            // Add loading animation to login button                                </div>

            $('#quickLoginBtn').on('click', function(e) {                            </div>

                var btn = $(this);                        <?= form_close() ?>

                var originalText = btn.html();

                                        <!-- Register Link -->

                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Σύνδεση...');                        <div class="text-center">

                btn.prop('disabled', true);                            <p class="mb-0">Δεν έχετε λογαριασμό;</p>

                                            <a href="<?= base_url('auth/register') ?>" class="register-link">

                // Re-enable after 3 seconds if something goes wrong                                Δημιουργήστε λογαριασμό εδώ!

                setTimeout(function() {                            </a>

                    btn.html(originalText);                        </div>

                    btn.prop('disabled', false);                    </div>

                }, 3000);                </div>

            });

                <!-- Footer -->

            // Auto-dismiss alerts                <div class="login-footer">

            setTimeout(function() {                    <p>&copy; 2024 PHA Manager v4. Professional Hearing Aid Management System.</p>

                $('.alert').fadeOut('slow');                    <p>Developed with ❤️ for better healthcare management.</p>

            }, 5000);                </div>

            </div>

            // Add hover effect to buttons        </div>

            $('.btn').hover(    </div>

                function() {

                    $(this).addClass('shadow-lg');    <!-- Bootstrap JS -->

                },        <!-- Scripts -->

                function() {    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

                    $(this).removeClass('shadow-lg');    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

                }    <!-- SB Admin 2 JS -->

            );    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>



            // Focus management for better UX    <script>

            $(document).keydown(function(e) {        $(document).ready(function() {

                if (e.key === 'Enter') {            // Password toggle functionality

                    $('#quickLoginBtn')[0].click();            $('#togglePassword').on('click', function() {

                }                const passwordField = $('#password');

            });                const icon = $(this).find('i');

        });                

    </script>                if (passwordField.attr('type') === 'password') {

</body>                    passwordField.attr('type', 'text');

</html>                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Form validation
            $('.user').on('submit', function(e) {
                let isValid = true;
                
                // Check login field
                if ($('#login').val().trim() === '') {
                    $('#login').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#login').removeClass('is-invalid');
                }
                
                // Check password field
                if ($('#password').val().trim() === '') {
                    $('#password').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#password').removeClass('is-invalid');
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Remove validation classes on input
            $('.form-control').on('input', function() {
                $(this).removeClass('is-invalid');
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Focus first input field
            $('#login').focus();
        });
    </script>
</body>

</html>