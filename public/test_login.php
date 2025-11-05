<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHA Manager v4 - Σύνδεση</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(135deg, #4e73df, #36b9cc);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .brand-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .btn-login {
            background: linear-gradient(45deg, #4e73df, #36b9cc);
            border: none;
            border-radius: 25px;
            padding: 1rem 2rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);
            color: white;
        }
        
        .login-footer {
            background: #f8f9fc;
            padding: 1.5rem 2rem;
            text-align: center;
            border-top: 1px solid #e3e6f0;
            font-size: 0.85rem;
            color: #858796;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="login-card">
                    <!-- Header -->
                    <div class="login-header">
                        <div class="brand-icon">
                            <i class="fas fa-assistive-listening-systems"></i>
                        </div>
                        <h2 class="mb-1">PHA Manager</h2>
                        <p class="mb-0 opacity-75">Professional Hearing Aid Management System v4</p>
                    </div>

                    <!-- Body -->
                    <div class="login-body">
                        <div class="text-center mb-4">
                            <h5 class="text-primary">Είστε ήδη συνδεδεμένος!</h5>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Η σύνδεση είναι ενεργή
                            </div>
                        </div>

                        <div class="d-grid gap-3">
                            <a href="<?= base_url('dashboard') ?>" class="btn btn-login">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Συνέχεια στο Dashboard
                            </a>
                            
                            <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Αποσύνδεση
                            </a>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6">
                                <a href="#" class="btn btn-outline-info w-100">
                                    <i class="fas fa-question-circle me-1"></i>
                                    Βοήθεια
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= base_url('auth?force_logout=1') ?>" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-broom me-1"></i>
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="login-footer">
                        <div class="mb-2">
                            <i class="fas fa-shield-alt text-success me-2"></i>
                            <strong>Ασφαλής Σύνδεση</strong> |
                            <i class="fas fa-server text-info me-2 ms-2"></i>
                            <strong>Παραγωγικό Περιβάλλον</strong>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-globe me-2"></i>
                            <?= base_url() ?>
                        </div>
                        <div class="text-primary">
                            <small>© <?= date('Y') ?> Pikas Hearing Aid Center - Powered by CodeIgniter 4</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        console.log('Simple login page loaded');
        console.log('Base URL:', '<?= base_url() ?>');
        
        // Add hover effects
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', () => btn.classList.add('shadow-lg'));
            btn.addEventListener('mouseleave', () => btn.classList.remove('shadow-lg'));
        });
    </script>
</body>
</html>