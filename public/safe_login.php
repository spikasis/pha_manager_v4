<?php
/**
 * Safe Entry Point for PHA Manager v4
 * Works without any CodeIgniter dependencies or intl extension
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Check if already logged in via session
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    // Redirect to dashboard or show simple dashboard
    header('Location: /dashboard.php');
    exit;
}

// Database configuration
$config = [
    'host' => 'linux2917.grserver.gr',
    'database' => 'customers_db2',
    'username' => 'spik', 
    'password' => '0382sp@#'
];

$error = '';
$success = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    
    if (empty($login) || empty($password)) {
        $error = 'Παρακαλώ συμπληρώστε όλα τα πεδία.';
    } else {
        try {
            // Connect to database
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
            $pdo = new PDO($dsn, $config['username'], $config['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Find user
            $stmt = $pdo->prepare("SELECT id, username, email, password, active FROM users WHERE email = ? OR username = ? LIMIT 1");
            $stmt->execute([$login, $login]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                $error = 'Δεν βρέθηκε χρήστης με αυτά τα στοιχεία.';
            } elseif (!$user['active']) {
                $error = 'Ο λογαριασμός δεν είναι ενεργός.';
            } elseif (!password_verify($password, $user['password'])) {
                $error = 'Λάθος κωδικός.';
            } else {
                // Success! Set session and update last login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                
                // Update last login
                $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $stmt->execute([$user['id']]);
                
                // Redirect to dashboard
                header('Location: /dashboard.php');
                exit;
            }
            
        } catch (Exception $e) {
            $error = 'Σφάλμα σύνδεσης: ' . $e->getMessage();
        }
    }
}

?><!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHA Manager v4 - Σύνδεση</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Nunito', sans-serif;
        }
        .login-card {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        .form-control {
            border-radius: 25px;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            font-size: 16px;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        .btn-primary {
            background: linear-gradient(45deg, #4e73df, #6f42c1);
            border: none;
            border-radius: 25px;
            padding: 15px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #2e59d9, #5a2d91);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .alert {
            border-radius: 15px;
            border: none;
        }
        .brand-icon {
            font-size: 4rem;
            color: #4e73df;
            margin-bottom: 20px;
        }
        .input-group-text {
            border-radius: 25px 0 0 25px;
            border: 2px solid #e9ecef;
            border-right: none;
            background: #f8f9fc;
        }
        .form-control.with-icon {
            border-radius: 0 25px 25px 0;
            border-left: none;
        }
        .footer-links {
            margin-top: 30px;
            text-align: center;
        }
        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        .footer-links a:hover {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="login-card p-5">
                    <!-- Brand Header -->
                    <div class="text-center mb-4">
                        <i class="fas fa-assistive-listening-systems brand-icon"></i>
                        <h1 class="h2 mb-2">PHA Manager v4</h1>
                        <p class="text-muted mb-0">Professional Hearing Aid Management</p>
                        <small class="text-success">✓ Safe Mode - No Dependencies</small>
                    </div>

                    <!-- Messages -->
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= htmlspecialchars($success) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form method="post" action="">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control with-icon" 
                                       name="login" 
                                       placeholder="Email ή Username"
                                       value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control with-icon" 
                                       name="password" 
                                       placeholder="Κωδικός"
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePassword()"
                                        style="border-radius: 0 25px 25px 0;">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Σύνδεση
                        </button>
                    </form>

                    <!-- Alternative Options -->
                    <div class="text-center">
                        <hr class="my-4">
                        <h6 class="text-muted mb-3">Εναλλακτικές Επιλογές</h6>
                        <div class="d-grid gap-2 d-md-block">
                            <a href="/auth-safe/login" class="btn btn-outline-primary btn-sm">CodeIgniter Auth</a>
                            <a href="/ultra_debug.php" class="btn btn-outline-info btn-sm">Διαγνωστικά</a>
                        </div>
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="footer-links">
                    <a href="/pure_auth.php">Pure PHP Mode</a>
                    <a href="/info.php">Server Info</a>
                    <a href="mailto:support@pikasishearing.gr">Υποστήριξη</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.querySelector('input[name="password"]');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Focus first input
        document.querySelector('input[name="login"]').focus();
    </script>
</body>
</html>