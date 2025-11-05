<!DOCTYPE html><!DOCTYPE html><!DOCTYPE html>

<html lang="el">

<head><html lang="el"><html lang="el">

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge"><head>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>    <meta charset="utf-8"><head>



    <!-- Custom fonts -->    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta charset="utf-8">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    <title><?= $title ?? 'Σύνδεση - PHA Manager v4' ?></title>    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    

    <!-- FontAwesome -->    <title>Σύνδεση - PHA Manager v4</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <!-- Custom fonts -->

    <style>

        :root {    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">    <!-- Bootstrap CSS -->

            --primary-color: #4e73df;

            --secondary-color: #858796;        <!-- Bootstrap CSS -->

            --success-color: #1cc88a;

            --info-color: #36b9cc;    <!-- Bootstrap CSS -->    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

            --warning-color: #f6c23e;

            --danger-color: #e74a3b;    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    <!-- FontAwesome -->

            --light-color: #f8f9fc;

            --dark-color: #5a5c69;        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous">

        }

    <!-- FontAwesome -->    <!-- SB Admin 2 -->

        body {

            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet" crossorigin="anonymous">

            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);

            min-height: 100vh;    

            display: flex;

            align-items: center;    <!-- SB Admin 2 CSS -->    <style>

        }

    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">        body {

        .login-card {

            border: none;                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

            border-radius: 20px;

            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);    <style>            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;

            backdrop-filter: blur(10px);

            background: rgba(255, 255, 255, 0.95);        :root {        }

            max-width: 450px;

            margin: 0 auto;            --primary-color: #4e73df;        

        }

            --secondary-color: #858796;        .login-container {

        .login-header {

            background: linear-gradient(135deg, var(--primary-color), var(--info-color));            --success-color: #1cc88a;            min-height: 100vh;

            color: white;

            padding: 2rem;            --info-color: #36b9cc;            display: flex;

            border-radius: 20px 20px 0 0;

            text-align: center;            --warning-color: #f6c23e;            align-items: center;

        }

            --danger-color: #e74a3b;            justify-content: center;

        .login-header.success {

            background: linear-gradient(135deg, var(--success-color), var(--info-color));            --light-color: #f8f9fc;            padding: 2rem 0;

        }

            --dark-color: #5a5c69;        }

        .login-body {

            padding: 2rem;        }        

        }

        .login-card {

        .btn-login {

            background: linear-gradient(45deg, var(--primary-color), var(--info-color));        body {            background: rgba(255, 255, 255, 0.95);

            border: none;

            border-radius: 25px;            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;            border-radius: 15px;

            padding: 0.875rem 2rem;

            font-size: 1.1rem;            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);

            font-weight: 600;

            color: white;            min-height: 100vh;            backdrop-filter: blur(10px);

            width: 100%;

            transition: all 0.3s;            display: flex;            border: 1px solid rgba(255, 255, 255, 0.2);

        }

            align-items: center;        }

        .btn-login:hover {

            background: linear-gradient(45deg, var(--info-color), var(--primary-color));        }        

            transform: translateY(-2px);

            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);        .brand-logo {

            color: white;

        }        .login-card {            color: #4e73df;



        .login-footer {            border: none;            font-size: 3rem;

            background-color: #f8f9fc;

            padding: 1.5rem 2rem;            border-radius: 20px;            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);

            border-radius: 0 0 20px 20px;

            text-align: center;            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);        }

            border-top: 1px solid #e3e6f0;

        }            backdrop-filter: blur(10px);        



        .system-info {            background: rgba(255, 255, 255, 0.95);        .brand-text {

            font-size: 0.85rem;

            color: var(--secondary-color);            max-width: 450px;            color: #5a5c69;

        }

            margin: 0 auto;            font-weight: 800;

        .brand-icon {

            font-size: 3rem;        }            font-size: 1.75rem;

            margin-bottom: 1rem;

            color: rgba(255, 255, 255, 0.9);        }

        }

        .login-header {        

        .alert {

            border-radius: 15px;            background: linear-gradient(135deg, var(--primary-color), var(--info-color));        .form-control-user {

            border: none;

            margin-bottom: 1.5rem;            color: white;            border-radius: 10rem;

        }

            padding: 2rem;            padding: 1.5rem 1rem;

        .floating-shapes {

            position: fixed;            border-radius: 20px 20px 0 0;            border: 1px solid #e3e6f0;

            top: 0;

            left: 0;            text-align: center;            font-size: 0.9rem;

            width: 100%;

            height: 100%;        }        }

            overflow: hidden;

            z-index: -1;        

        }

        .login-body {        .form-control-user:focus {

        .floating-shapes div {

            position: absolute;            padding: 2rem;            border-color: #4e73df;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.1);        }            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);

            animation: float 6s ease-in-out infinite;

        }        }



        .floating-shapes div:nth-child(1) {        .form-control {        

            width: 80px;

            height: 80px;            border-radius: 25px;        .btn-user {

            top: 20%;

            left: 10%;            padding: 0.875rem 1.125rem;            border-radius: 10rem;

            animation-delay: 0s;

        }            border: 2px solid #e3e6f0;            padding: 0.75rem 1rem;



        .floating-shapes div:nth-child(2) {            font-size: 1rem;            font-size: 0.9rem;

            width: 120px;

            height: 120px;        }            font-weight: 800;

            top: 60%;

            right: 10%;            letter-spacing: 0.1rem;

            animation-delay: 2s;

        }        .form-control:focus {            text-transform: uppercase;



        .floating-shapes div:nth-child(3) {            border-color: var(--primary-color);        }

            width: 60px;

            height: 60px;            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);        

            bottom: 20%;

            left: 20%;        }        .divider {

            animation-delay: 4s;

        }            position: relative;



        @keyframes float {        .btn-login {            text-align: center;

            0%, 100% { transform: translateY(0px) rotate(0deg); }

            50% { transform: translateY(-20px) rotate(180deg); }            background: linear-gradient(45deg, var(--primary-color), var(--info-color));            margin: 1.5rem 0;

        }

            border: none;        }

        .fade-in {

            animation: fadeIn 0.8s ease-in;            border-radius: 25px;        

        }

            padding: 0.875rem 2rem;        .divider::before {

        @keyframes fadeIn {

            from { opacity: 0; transform: translateY(30px); }            font-size: 1.1rem;            content: '';

            to { opacity: 1; transform: translateY(0); }

        }            font-weight: 600;            position: absolute;



        .session-info {            color: white;            top: 50%;

            background: #f8f9fc;

            border-radius: 10px;            width: 100%;            left: 0;

            padding: 1rem;

            margin-bottom: 1rem;            transition: all 0.3s;            right: 0;

        }

    </style>        }            height: 1px;

</head>

            background: #e3e6f0;

<body>

    <!-- Floating Background Shapes -->        .btn-login:hover {        }

    <div class="floating-shapes">

        <div></div>            background: linear-gradient(45deg, var(--info-color), var(--primary-color));        

        <div></div>

        <div></div>            transform: translateY(-2px);        .divider span {

    </div>

            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);            background: white;

    <div class="container">

        <div class="row justify-content-center">            color: white;            padding: 0 1rem;

            <div class="col-md-6">

                <div class="login-card fade-in">        }            color: #858796;

                    <!-- Login Header -->

                    <div class="login-header <?= (isset($already_logged_in) && $already_logged_in) ? 'success' : '' ?>">            font-size: 0.85rem;

                        <div class="brand-icon">

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