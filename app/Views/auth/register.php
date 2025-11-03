<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Εγγραφή - PHA Manager v4</title>

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
        
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .brand-logo {
            color: #4e73df;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .brand-text {
            color: #5a5c69;
            font-weight: 800;
            font-size: 1.5rem;
        }
        
        .form-control-user {
            border-radius: 10rem;
            padding: 1rem;
            border: 1px solid #e3e6f0;
            font-size: 0.875rem;
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
        
        .form-label {
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 0.25rem;
        }
        
        .required:after {
            content: " *";
            color: red;
        }
        
        .password-strength {
            margin-top: 0.25rem;
        }
        
        .password-strength .progress {
            height: 4px;
            border-radius: 2px;
        }
        
        .strength-text {
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .login-link {
            color: #4e73df;
            font-weight: 800;
            text-decoration: none;
        }
        
        .login-link:hover {
            color: #2e59d9;
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            border: none;
            font-size: 0.875rem;
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

        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <div class="animated-bg"></div>
    
    <div class="register-container">
        <div class="row justify-content-center w-100">
            <div class="col-xl-8 col-lg-10 col-md-11">
                <div class="card register-card border-0">
                    <div class="card-body p-5">
                        <!-- Brand Header -->
                        <div class="text-center mb-4">
                            <div class="brand-logo">
                                <i class="fas fa-assistive-listening-systems"></i>
                            </div>
                            <div class="brand-text">Εγγραφή Χρήστη</div>
                            <p class="text-muted mb-0">Δημιουργήστε τον λογαριασμό σας</p>
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

                        <!-- Registration Form -->
                        <?= form_open(base_url('auth/attempt-register'), ['class' => 'user', 'id' => 'registerForm']) ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="first_name" class="form-label required">Όνομα</label>
                                        <input type="text" 
                                               class="form-control form-control-user <?= isset($validation) && $validation->hasError('first_name') ? 'is-invalid' : '' ?>" 
                                               id="first_name" 
                                               name="first_name" 
                                               placeholder="Εισάγετε το όνομά σας"
                                               value="<?= old('first_name') ?>" 
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('first_name')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('first_name') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="last_name" class="form-label required">Επώνυμο</label>
                                        <input type="text" 
                                               class="form-control form-control-user <?= isset($validation) && $validation->hasError('last_name') ? 'is-invalid' : '' ?>" 
                                               id="last_name" 
                                               name="last_name" 
                                               placeholder="Εισάγετε το επώνυμό σας"
                                               value="<?= old('last_name') ?>" 
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('last_name')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('last_name') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="username" class="form-label required">Username</label>
                                        <input type="text" 
                                               class="form-control form-control-user <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                                               id="username" 
                                               name="username" 
                                               placeholder="Επιλέξτε username"
                                               value="<?= old('username') ?>" 
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('username')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('username') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label required">Email</label>
                                        <input type="email" 
                                               class="form-control form-control-user <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                                               id="email" 
                                               name="email" 
                                               placeholder="Εισάγετε το email σας"
                                               value="<?= old('email') ?>" 
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('email') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company" class="form-label">Εταιρεία</label>
                                        <input type="text" 
                                               class="form-control form-control-user <?= isset($validation) && $validation->hasError('company') ? 'is-invalid' : '' ?>" 
                                               id="company" 
                                               name="company" 
                                               placeholder="Εταιρεία (προαιρετικό)"
                                               value="<?= old('company') ?>">
                                        <?php if (isset($validation) && $validation->hasError('company')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('company') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">Τηλέφωνο</label>
                                        <input type="tel" 
                                               class="form-control form-control-user <?= isset($validation) && $validation->hasError('phone') ? 'is-invalid' : '' ?>" 
                                               id="phone" 
                                               name="phone" 
                                               placeholder="Τηλέφωνο (προαιρετικό)"
                                               value="<?= old('phone') ?>">
                                        <?php if (isset($validation) && $validation->hasError('phone')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('phone') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label required">Κωδικός</label>
                                        <input type="password" 
                                               class="form-control form-control-user <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Εισάγετε κωδικό"
                                               required>
                                        <div class="password-strength">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" id="strengthBar"></div>
                                            </div>
                                            <div class="strength-text" id="strengthText"></div>
                                        </div>
                                        <?php if (isset($validation) && $validation->hasError('password')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('password') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="confirm_password" class="form-label required">Επιβεβαίωση Κωδικού</label>
                                        <input type="password" 
                                               class="form-control form-control-user <?= isset($validation) && $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>" 
                                               id="confirm_password" 
                                               name="confirm_password" 
                                               placeholder="Επιβεβαιώστε τον κωδικό"
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('confirm_password') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Συμφωνώ με τους <a href="#" class="text-primary">Όρους Χρήσης</a> και την <a href="#" class="text-primary">Πολιτική Απορρήτου</a>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block mb-4" id="registerBtn">
                                <i class="fas fa-user-plus me-1"></i> Εγγραφή
                            </button>
                        <?= form_close() ?>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="mb-0">Έχετε ήδη λογαριασμό;</p>
                            <a href="<?= base_url('auth/login') ?>" class="login-link">
                                Συνδεθείτε εδώ!
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="register-footer">
                    <p>&copy; 2024 PHA Manager v4. Professional Hearing Aid Management System.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
        <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // Password strength checker
            $('#password').on('input', function() {
                const password = $(this).val();
                const strength = checkPasswordStrength(password);
                updatePasswordStrengthIndicator(strength);
            });

            // Confirm password validation
            $('#confirm_password').on('input', function() {
                const password = $('#password').val();
                const confirmPassword = $(this).val();
                
                if (confirmPassword && password !== confirmPassword) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Form validation
            $('#registerForm').on('submit', function(e) {
                let isValid = true;
                
                // Required fields validation
                $('input[required]').each(function() {
                    if ($(this).val().trim() === '') {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                
                // Email validation
                const email = $('#email').val();
                if (email && !isValidEmail(email)) {
                    $('#email').addClass('is-invalid');
                    isValid = false;
                }
                
                // Password confirmation
                const password = $('#password').val();
                const confirmPassword = $('#confirm_password').val();
                if (password !== confirmPassword) {
                    $('#confirm_password').addClass('is-invalid');
                    isValid = false;
                }
                
                // Terms agreement
                if (!$('#terms').is(':checked')) {
                    alert('Πρέπει να συμφωνήσετε με τους όρους χρήσης');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Remove validation classes on input
            $('.form-control').on('input', function() {
                $(this).removeClass('is-invalid');
            });

            // Auto-generate username from first and last name
            $('#first_name, #last_name').on('input', function() {
                if (!$('#username').val()) {
                    const firstName = $('#first_name').val().toLowerCase();
                    const lastName = $('#last_name').val().toLowerCase();
                    if (firstName && lastName) {
                        const username = firstName + '.' + lastName;
                        $('#username').val(username.replace(/\s+/g, ''));
                    }
                }
            });

            // Phone number formatting
            $('#phone').on('input', function() {
                let phone = $(this).val().replace(/\D/g, '');
                $(this).val(phone);
            });

            // Focus first input field
            $('#first_name').focus();
        });

        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = [];

            if (password.length >= 8) strength += 1;
            else feedback.push('τουλάχιστον 8 χαρακτήρες');

            if (/[a-z]/.test(password)) strength += 1;
            else feedback.push('πεζά γράμματα');

            if (/[A-Z]/.test(password)) strength += 1;
            else feedback.push('κεφαλαία γράμματα');

            if (/[0-9]/.test(password)) strength += 1;
            else feedback.push('αριθμούς');

            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            else feedback.push('ειδικούς χαρακτήρες');

            return {
                score: strength,
                feedback: feedback
            };
        }

        function updatePasswordStrengthIndicator(strength) {
            const bar = $('#strengthBar');
            const text = $('#strengthText');
            
            const percentage = (strength.score / 5) * 100;
            bar.css('width', percentage + '%');
            
            if (strength.score <= 2) {
                bar.removeClass().addClass('progress-bar bg-danger');
                text.text('Αδύναμος κωδικός - ' + strength.feedback.join(', '));
                text.removeClass().addClass('strength-text text-danger');
            } else if (strength.score <= 3) {
                bar.removeClass().addClass('progress-bar bg-warning');
                text.text('Μέτριος κωδικός - ' + strength.feedback.join(', '));
                text.removeClass().addClass('strength-text text-warning');
            } else if (strength.score <= 4) {
                bar.removeClass().addClass('progress-bar bg-info');
                text.text('Καλός κωδικός');
                text.removeClass().addClass('strength-text text-info');
            } else {
                bar.removeClass().addClass('progress-bar bg-success');
                text.text('Εξαιρετικός κωδικός!');
                text.removeClass().addClass('strength-text text-success');
            }
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
</body>

</html>