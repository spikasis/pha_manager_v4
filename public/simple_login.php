<?php
session_start();

// Simple login without full CodeIgniter bootstrap
$is_logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /simple_login.php');
    exit;
}

// Handle login attempt
if ($_POST['action'] ?? '' === 'login') {
    // Simple hardcoded check for now
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // You can replace this with actual database check later
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = time();
        header('Location: /simple_login.php');
        exit;
    } else {
        $error = 'Λάθος στοιχεία σύνδεσης';
    }
}

?><!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHA Manager v4 - Simple Login</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4e73df, #224abe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 450px;
            width: 90%;
        }
        
        .header {
            background: linear-gradient(135deg, #4e73df, #36b9cc);
            color: white;
            margin: -40px -40px 30px -40px;
            padding: 30px;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #5a5c69;
            font-weight: 600;
        }
        
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d3e2;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .btn {
            background: linear-gradient(45deg, #4e73df, #36b9cc);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .logged-in-panel {
            text-align: center;
        }
        
        .user-info {
            background: #f8f9fc;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e3e6f0;
            color: #858796;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🦻 PHA Manager v4</h1>
            <p>Simple Login System - Backup Mode</p>
        </div>

        <?php if ($is_logged_in): ?>
            <!-- User is logged in -->
            <div class="logged-in-panel">
                <div class="alert alert-success">
                    <strong>✅ Επιτυχής Σύνδεση!</strong><br>
                    Είστε συνδεδεμένος στο σύστημα
                </div>
                
                <div class="user-info">
                    <h3>👤 <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                    <p>🕐 Σύνδεση: <?php echo date('d/m/Y H:i', $_SESSION['login_time']); ?></p>
                    <p>🆔 Session ID: <?php echo substr(session_id(), 0, 8); ?>...</p>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <a href="/dashboard" class="btn" style="text-decoration: none; text-align: center;">
                        📊 Dashboard
                    </a>
                    <a href="?logout=1" class="btn" style="background: #e74a3b; text-decoration: none; text-align: center;">
                        🚪 Αποσύνδεση
                    </a>
                </div>
                
                <p style="margin-top: 20px; font-size: 14px; color: #858796;">
                    <strong>💡 Σημείωση:</strong> Αυτή είναι η backup λειτουργία login.<br>
                    Μόλις διορθωθεί το κύριο σύστημα, θα επιστρέψουμε στο κανονικό login.
                </p>
            </div>
        <?php else: ?>
            <!-- Login form -->
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <strong>❌ Σφάλμα:</strong> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="username">👤 Όνομα Χρήστη:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">🔒 Κωδικός:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" name="action" value="login" class="btn">
                    🔐 Σύνδεση
                </button>
            </form>
            
            <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; font-size: 14px;">
                <strong>🧪 Test Credentials:</strong><br>
                Username: <code>admin</code><br>
                Password: <code>admin</code>
            </div>
        <?php endif; ?>

        <div class="footer">
            <p>🛡️ Simple Session Authentication | 🌐 Backup Mode Active</p>
            <p>© 2025 Pikas Hearing Aid Center</p>
        </div>
    </div>
</body>
</html>