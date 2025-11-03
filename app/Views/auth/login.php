<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Σύνδεση - PHA Manager v4</title>

    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous">
    <!-- SB Admin 2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet" crossorigin="anonymous">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .brand-logo {
            color: #4e73df;
            font-size: 3rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .brand-text {
            color: #5a5c69;
            font-weight: 800;
            font-size: 1.75rem;
        }
        
        .form-control-user {
            border-radius: 10rem;
            padding: 1.5rem 1rem;
            border: 1px solid #e3e6f0;
            font-size: 0.9rem;
        }
        
        .form-control-user:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-user {
            border-radius: 10rem;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.1rem;
            text-transform: uppercase;
        }
        
        .divider {
            position: relative;
            text-align: center;
            margin: 1.5rem 0;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e3e6f0;
        }
        
        .divider span {
            background: white;
            padding: 0 1rem;
            color: #858796;
            font-size: 0.85rem;
        }
        
        .remember-me {
            font-size: 0.85rem;
        }
        
        .forgot-password {
            color: #4e73df;
            font-size: 0.85rem;
            text-decoration: none;
        }
        
        .forgot-password:hover {
            color: #2e59d9;
            text-decoration: underline;
        }
        
        .register-link {
            color: #4e73df;
            font-weight: 800;
            text-decoration: none;
        }
        
        .register-link:hover {
            color: #2e59d9;
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            border: none;
            font-size: 0.875rem;
        }

        .input-group-text {
            border-radius: 10rem 0 0 10rem;
            border-right: none;
            background-color: #f8f9fc;
            color: #858796;
        }

        .form-control-user.with-icon {
            border-radius: 0 10rem 10rem 0;
            border-left: none;
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
        }
    </style>
</head>

<body>
    <div class="animated-bg"></div>
    
    <div class="login-container">
        <div class="row justify-content-center w-100">
            <div class="col-xl-6 col-lg-8 col-md-9">
                <div class="card login-card border-0">
                    <div class="card-body p-5">
                        <!-- Brand Header -->
                        <div class="text-center mb-4">
                            <div class="brand-logo">
                                <i class="fas fa-assistive-listening-systems"></i>
                            </div>
                            <div class="brand-text">PHA Manager</div>
                            <p class="text-muted mb-0">Professional Hearing Aid Management</p>
                        </div>

                        <!-- Flash Messages -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <?= form_open(base_url('auth/attempt-login'), ['class' => 'user']) ?>
                            <?= csrf_field() ?>
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control form-control-user with-icon <?= isset($validation) && $validation->hasError('login') ? 'is-invalid' : '' ?>" 
                                           id="login" 
                                           name="login" 
                                           placeholder="Email ή Username"
                                           value="<?= old('login') ?>" 
                                           required>
                                </div>
                                <?php if (isset($validation) && $validation->hasError('login')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('login') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control form-control-user with-icon <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Κωδικός"
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-radius: 0 10rem 10rem 0;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php if (isset($validation) && $validation->hasError('password')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check remember-me">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">
                                        <label class="form-check-label" for="remember">
                                            Να με θυμάσαι
                                        </label>
                                    </div>
                                    <a href="<?= base_url('auth/forgot-password') ?>" class="forgot-password">
                                        Ξεχάσατε τον κωδικό;
                                    </a>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block mb-3">
                                <i class="fas fa-sign-in-alt me-1"></i> Σύνδεση
                            </button>

                            <div class="divider">
                                <span>ή</span>
                            </div>

                            <!-- Alternative Login Options (for future implementation) -->
                            <div class="row mb-3">
                                <div class="col-6">
                                    <button type="button" class="btn btn-google btn-user btn-block disabled" disabled>
                                        <i class="fab fa-google fa-fw"></i> Google
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-facebook btn-user btn-block disabled" disabled>
                                        <i class="fab fa-facebook-f fa-fw"></i> Facebook
                                    </button>
                                </div>
                            </div>
                        <?= form_close() ?>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="mb-0">Δεν έχετε λογαριασμό;</p>
                            <a href="<?= base_url('auth/register') ?>" class="register-link">
                                Δημιουργήστε λογαριασμό εδώ!
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="login-footer">
                    <p>&copy; 2024 PHA Manager v4. Professional Hearing Aid Management System.</p>
                    <p>Developed with ❤️ for better healthcare management.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
        <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- SB Admin 2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Password toggle functionality
            $('#togglePassword').on('click', function() {
                const passwordField = $('#password');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
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