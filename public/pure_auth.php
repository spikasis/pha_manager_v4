<?php
/**
 * Pure PHP Authentication - No CodeIgniter Dependencies
 * This file works completely independently of CodeIgniter
 */

// Enable all error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Database configuration
$config = [
    'host' => 'linux2917.grserver.gr',
    'database' => 'customers_db2',
    'username' => 'spik',
    'password' => '0382sp@#',
    'charset' => 'utf8mb4'
];

/**
 * Get database connection
 */
function getDbConnection($config) {
    try {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        $pdo = new PDO($dsn, $config['username'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        throw new Exception("Database connection failed: " . $e->getMessage());
    }
}

/**
 * Find user by login (email or username)
 */
function findUser($pdo, $login) {
    $stmt = $pdo->prepare("SELECT id, username, email, password, active FROM users WHERE email = ? OR username = ? LIMIT 1");
    $stmt->execute([$login, $login]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Update last login
 */
function updateLastLogin($pdo, $userId) {
    $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
    return $stmt->execute([$userId]);
}

/**
 * Set user session
 */
function setUserSession($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['logged_in'] = true;
}

// Handle POST request
if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
    
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    
    try {
        $pdo = getDbConnection($config);
        
        // Find user
        $user = findUser($pdo, $login);
        
        if (!$user) {
            $error = "❌ User not found: " . htmlspecialchars($login);
        } elseif (!$user['active']) {
            $error = "❌ User account is not active";
        } elseif (!password_verify($password, $user['password'])) {
            $error = "❌ Invalid password";
        } else {
            // Success! Update last login and set session
            updateLastLogin($pdo, $user['id']);
            setUserSession($user);
            
            $success = "🎉 LOGIN SUCCESSFUL!";
        }
        
    } catch (Exception $e) {
        $error = "❌ Database Error: " . htmlspecialchars($e->getMessage());
    }
}

?><!DOCTYPE html>
<html>
<head>
    <title>Pure PHP Auth - PHA Manager</title>
    <style>
        body { font-family: Arial; margin: 50px; background: #f8f9fa; }
        .container { max-width: 500px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        .btn { background: #007cba; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        .btn:hover { background: #005a8b; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .debug { background: #e2e3e5; padding: 15px; border-radius: 4px; margin: 15px 0; font-size: 14px; }
        .nav-links { margin-top: 20px; }
        .nav-links a { display: inline-block; margin: 5px 10px 5px 0; color: #007cba; text-decoration: none; }
        .nav-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <h1>🔐 Pure PHP Authentication</h1>
    <p>This authentication system works completely independent of CodeIgniter.</p>

    <?php if (isset($success)): ?>
        <div class="success">
            <?= $success ?>
            <br><br>
            <strong>User Details:</strong><br>
            • ID: <?= htmlspecialchars($user['id']) ?><br>
            • Username: <?= htmlspecialchars($user['username']) ?><br>
            • Email: <?= htmlspecialchars($user['email']) ?><br>
            • Session: Active
        </div>
        
        <div class="nav-links">
            <h3>🎯 Next Steps:</h3>
            <a href="/dashboard">Go to Dashboard</a>
            <a href="/">Homepage</a>
            <a href="/auth/logout">Logout (CodeIgniter)</a>
            <a href="?action=logout">Logout (Pure PHP)</a>
        </div>
        
    <?php else: ?>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="login">Username or Email:</label>
                <input type="text" id="login" name="login" value="<?= htmlspecialchars($_POST['login'] ?? 'admin') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="123456" required>
            </div>
            
            <button type="submit" class="btn">🔑 Login</button>
        </form>
        
    <?php endif; ?>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'logout'): ?>
        <?php 
        session_destroy();
        echo '<div class="success">✅ Logged out successfully!</div>';
        echo '<meta http-refresh="2;url=?">';
        ?>
    <?php endif; ?>

    <div class="nav-links">
        <h3>🔍 Debug Links:</h3>
        <a href="/ultra_debug.php">Ultra Debug Test</a>
        <a href="/auth-ultra/login">CodeIgniter Auth (if working)</a>
        <a href="/test.php">Basic PHP Test</a>
        <a href="/">Homepage</a>
    </div>

    <div class="debug">
        <strong>🏥 For PHA Manager v4:</strong><br>
        This pure PHP authentication can be used as a fallback while we fix the CodeIgniter issues.<br>
        <strong>Current Issues Found:</strong><br>
        • Missing PHP intl extension (Locale class)<br>
        • SQL syntax errors in UserModel<br>
        • Database binding parameter issues<br>
    </div>
</div>

</body>
</html>