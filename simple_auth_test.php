<?php
/**
 * Simple Auth Test - Minimal Login Test
 * Test the exact login functionality without CodeIgniter overhead
 */

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simple response function
function jsonResponse($success, $message, $data = null) {
    return json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}

try {
    // Check request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo jsonResponse(false, 'Only POST method allowed');
        exit;
    }

    // Get raw POST data
    $rawInput = file_get_contents('php://input');
    $postData = json_decode($rawInput, true) ?? $_POST;

    // Check if we have login data
    if (empty($postData['login']) || empty($postData['password'])) {
        echo jsonResponse(false, 'Login and password required', [
            'received_data' => $postData,
            'raw_input' => $rawInput,
            'post_method' => $_POST
        ]);
        exit;
    }

    $login = $postData['login'];
    $password = $postData['password'];

    // Database connection test
    $config = [
        'host' => 'linux2917.grserver.gr',
        'database' => 'customers_db2',
        'username' => 'spik',
        'password' => '0382sp@#'
    ];

    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4",
        $config['username'],
        $config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Try to find user
    $stmt = $pdo->prepare("
        SELECT id, username, email, password, first_name, last_name, active 
        FROM users 
        WHERE (username = :login OR email = :login) AND active = 1
        LIMIT 1
    ");
    
    $stmt->execute(['login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo jsonResponse(false, 'User not found or inactive', [
            'searched_for' => $login
        ]);
        exit;
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        echo jsonResponse(false, 'Invalid password');
        exit;
    }

    // Success
    unset($user['password']); // Don't send password back
    echo jsonResponse(true, 'Login successful', [
        'user' => $user,
        'login_method' => 'direct_database'
    ]);

} catch (PDOException $e) {
    echo jsonResponse(false, 'Database error: ' . $e->getMessage());
} catch (Exception $e) {
    echo jsonResponse(false, 'Server error: ' . $e->getMessage(), [
        'error_file' => $e->getFile(),
        'error_line' => $e->getLine()
    ]);
}
?>