<?php
/**
 * Ultra Debug - No CodeIgniter Dependencies
 * Direct PHP file to test if the issue is CodeIgniter or server-level
 */

// Enable all error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Ultra Debug Test</title></head><body>";
echo "<h1>🔍 Ultra Debug Test - No CodeIgniter</h1>";
echo "<p>This file tests basic PHP functionality without any framework.</p>";

// Test 1: Basic PHP
echo "<h2>Test 1: Basic PHP ✅</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
echo "<p>Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</p>";

// Test 2: Database Connection
echo "<h2>Test 2: Direct Database Connection</h2>";
try {
    $host = 'linux2917.grserver.gr';
    $dbname = 'customers_db2';
    $username = 'spik';
    $password = '0382sp@#';
    
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    
    echo "<p>✅ Database connection: SUCCESS</p>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "<p>✅ Users table: " . $result['count'] . " users found</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 3: Session Test
echo "<h2>Test 3: Session Test</h2>";
try {
    session_start();
    $_SESSION['test'] = 'working';
    echo "<p>✅ Session started successfully</p>";
    echo "<p>Session ID: " . session_id() . "</p>";
} catch (Exception $e) {
    echo "<p>❌ Session Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 4: Form Processing
if ($_POST) {
    echo "<h2>Test 4: Form Data Received ✅</h2>";
    echo "<p>Login: " . htmlspecialchars($_POST['login'] ?? 'Not provided') . "</p>";
    echo "<p>Password: " . (empty($_POST['password']) ? 'Not provided' : 'Provided') . "</p>";
    
    if ($_POST['login'] && $_POST['password']) {
        echo "<p>🎉 <strong>Form processing works!</strong></p>";
        echo "<p>This proves the server can handle POST requests correctly.</p>";
    }
} else {
    echo "<h2>Test 4: Form Test</h2>";
    echo '<form method="post">';
    echo '<input type="text" name="login" placeholder="Username" value="test"><br><br>';
    echo '<input type="password" name="password" placeholder="Password" value="test"><br><br>';
    echo '<button type="submit">Test Form Processing</button>';
    echo '</form>';
}

// Test 5: File System
echo "<h2>Test 5: File System</h2>";
$writable_path = dirname(__DIR__) . '/writable';
if (is_dir($writable_path)) {
    echo "<p>✅ Writable directory exists: $writable_path</p>";
    if (is_writable($writable_path)) {
        echo "<p>✅ Writable directory is writable</p>";
    } else {
        echo "<p>❌ Writable directory is NOT writable</p>";
    }
} else {
    echo "<p>❌ Writable directory does NOT exist: $writable_path</p>";
}

// Test 6: CodeIgniter Bootstrap Test
echo "<h2>Test 6: CodeIgniter Bootstrap Test</h2>";
try {
    $ci_path = dirname(__DIR__) . '/app/Config/App.php';
    if (file_exists($ci_path)) {
        echo "<p>✅ CodeIgniter App.php exists</p>";
        // Try to include it
        include_once $ci_path;
        echo "<p>✅ App.php included successfully</p>";
    } else {
        echo "<p>❌ CodeIgniter App.php NOT found</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ CodeIgniter Bootstrap Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h2>Navigation Links</h2>";
echo "<ul>";
echo "<li><a href='/'>Home Page</a></li>";
echo "<li><a href='/auth-ultra/login'>Ultra Simple Auth (CodeIgniter)</a></li>";
echo "<li><a href='/test.php'>Basic Test</a></li>";
echo "<li><a href='/info.php'>PHP Info</a></li>";
echo "</ul>";

echo "</body></html>";
?>