<?php

namespace App\Controllers;

use PDO;
use Exception;

class AuthUltraSimple extends BaseController
{
    /**
     * Ultra simple login - no dependencies
     */
    public function login()
    {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Ultra Simple Login</title>
            <style>
                body { font-family: Arial; margin: 50px; }
                form { max-width: 400px; }
                input { display: block; margin: 10px 0; padding: 10px; width: 300px; }
                button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; }
            </style>
        </head>
        <body>
            <h1>🔹 Ultra Simple Login Test</h1>
            <p>This form tests the most basic login without any CodeIgniter dependencies.</p>
            
            <form method="post" action="/auth-ultra/attempt-login">
                <label>Username/Email:</label>
                <input type="text" name="login" value="admin" required>
                
                <label>Password:</label>
                <input type="password" name="password" value="123456" required>
                
                <button type="submit">Test Login</button>
            </form>
            
            <h2>Debug Links:</h2>
            <ul>
                <li><a href="/auth-ultra/test-db">Test Database Connection</a></li>
                <li><a href="/auth-ultra/test-models">Test Models</a></li>
                <li><a href="/test.php">Basic PHP Test</a></li>
                <li><a href="/">Back to Home</a></li>
            </ul>
        </body>
        </html>
        <?php
        exit;
    }

    /**
     * Test database connection without models
     */
    public function testDb()
    {
        echo "<h1>🔍 Database Connection Test</h1>";
        
        try {
            // Direct PDO connection using .env values
            $host = 'linux2917.grserver.gr';
            $dbname = 'customers_db2';
            $username = 'spik';
            $password = '0382sp@#';
            
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $pdo = new \PDO($dsn, $username, $password);
            
            echo "<p>✅ Direct PDO connection: SUCCESS</p>";
            
            // Test users table
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
            $result = $stmt->fetch();
            echo "<p>✅ Users table accessible: " . $result['count'] . " users found</p>";
            
            // Test finding a user
            $stmt = $pdo->prepare("SELECT id, username, email, active FROM users WHERE username = ? OR email = ? LIMIT 1");
            $stmt->execute(['admin', 'admin']);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                echo "<p>✅ Sample user found:</p>";
                echo "<ul>";
                echo "<li>ID: " . $user['id'] . "</li>";
                echo "<li>Username: " . htmlspecialchars($user['username']) . "</li>";
                echo "<li>Email: " . htmlspecialchars($user['email']) . "</li>";
                echo "<li>Active: " . ($user['active'] ? 'YES' : 'NO') . "</li>";
                echo "</ul>";
            } else {
                echo "<p>⚠️ No user found with username/email 'admin'</p>";
                
                // Show first 3 users
                $stmt = $pdo->query("SELECT id, username, email FROM users LIMIT 3");
                echo "<p>First 3 users in database:</p><ul>";
                while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li>ID: " . $user['id'] . " - " . htmlspecialchars($user['username']) . " (" . htmlspecialchars($user['email']) . ")</li>";
                }
                echo "</ul>";
            }
            
        } catch (Exception $e) {
            echo "<p>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        
        echo "<p><a href='/auth-ultra/login'>← Back to Login</a></p>";
        exit;
    }

    /**
     * Test CodeIgniter models
     */
    public function testModels()
    {
        echo "<h1>🔍 CodeIgniter Models Test</h1>";
        
        try {
            echo "<p>Testing CodeIgniter Database class...</p>";
            $db = \Config\Database::connect();
            echo "<p>✅ CodeIgniter Database: SUCCESS</p>";
            
            echo "<p>Testing UserModel...</p>";
            $userModel = new \App\Models\UserModel();
            echo "<p>✅ UserModel instantiation: SUCCESS</p>";
            
            echo "<p>Testing UserModel->findAll()...</p>";
            $users = $userModel->findAll(3);
            echo "<p>✅ UserModel findAll: " . count($users) . " users returned</p>";
            
            if (!empty($users)) {
                echo "<p>Sample users:</p><ul>";
                foreach ($users as $user) {
                    echo "<li>ID: " . $user['id'] . " - " . htmlspecialchars($user['username']) . "</li>";
                }
                echo "</ul>";
            }
            
        } catch (Exception $e) {
            echo "<p>❌ Models Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p>File: " . $e->getFile() . "</p>";
            echo "<p>Line: " . $e->getLine() . "</p>";
        }
        
        echo "<p><a href='/auth-ultra/login'>← Back to Login</a></p>";
        exit;
    }

    /**
     * Ultra simple login attempt
     */
    public function attemptLogin()
    {
        echo "<h1>🔍 Ultra Simple Login Attempt</h1>";
        
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';
        
        echo "<p>Received login: " . htmlspecialchars($login) . "</p>";
        echo "<p>Received password: " . (empty($password) ? 'EMPTY' : 'PROVIDED') . "</p>";
        
        if (empty($login) || empty($password)) {
            echo "<p>❌ Missing credentials</p>";
            echo "<p><a href='/auth-ultra/login'>← Back to Login</a></p>";
            exit;
        }
        
        // Simple hardcoded test first
        if ($login === 'test' && $password === 'test') {
            echo "<h2>🎉 HARDCODED TEST LOGIN SUCCESS!</h2>";
            echo "<p>Login system is working at basic level.</p>";
            echo "<p>Now testing database...</p>";
        }
        
        // Test database login
        try {
            $host = 'linux2917.grserver.gr';
            $dbname = 'customers_db2';
            $username = 'spik';
            $dbpassword = '0382sp@#';
            
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $pdo = new PDO($dsn, $username, $dbpassword);
            
            echo "<p>✅ Database connected</p>";
            
            $stmt = $pdo->prepare("SELECT id, username, email, password, active FROM users WHERE username = ? OR email = ? LIMIT 1");
            $stmt->execute([$login, $login]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                echo "<p>✅ User found in database</p>";
                echo "<p>User ID: " . $user['id'] . "</p>";
                echo "<p>Username: " . htmlspecialchars($user['username']) . "</p>";
                echo "<p>Active: " . ($user['active'] ? 'YES' : 'NO') . "</p>";
                
                if (password_verify($password, $user['password'])) {
                    echo "<h2>🎉 DATABASE LOGIN SUCCESS!</h2>";
                    echo "<p>Authentication is working completely!</p>";
                    
                    // Test session
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    echo "<p>✅ Session set successfully</p>";
                    
                } else {
                    echo "<p>❌ Password verification failed</p>";
                    echo "<p>Password hash in DB: " . substr($user['password'], 0, 20) . "...</p>";
                }
            } else {
                echo "<p>❌ User not found in database</p>";
            }
            
        } catch (Exception $e) {
            echo "<p>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        
        echo "<hr><p><a href='/auth-ultra/login'>← Back to Login</a></p>";
        exit;
    }
}