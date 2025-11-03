<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthSimple extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Show login page
     */
    public function login()
    {
        return view('auth/login', ['title' => 'Σύνδεση']);
    }

    /**
     * Process login - SIMPLE DEBUG VERSION
     */
    public function attemptLogin()
    {
        echo "<!DOCTYPE html><html><head><title>Login Debug</title></head><body>";
        echo "<h1>🔍 Login Debug - Simple Version</h1>";
        
        try {
            // Get form data
            $login = $this->request->getPost('login');
            $password = $this->request->getPost('password');
            
            echo "<p>✅ Form data received:</p>";
            echo "<p>Login: " . htmlspecialchars($login ?? 'NULL') . "</p>";
            echo "<p>Password: " . (empty($password) ? 'EMPTY' : 'PROVIDED (' . strlen($password) . ' chars)') . "</p>";
            
            if (empty($login) || empty($password)) {
                echo "<p>❌ Missing login or password</p>";
                echo "<p><a href='/auth/login'>← Back to Login</a></p>";
                echo "</body></html>";
                return;
            }
            
            // Test database connection
            echo "<h2>Database Test</h2>";
            $db = \Config\Database::connect();
            echo "<p>✅ Database connected</p>";
            
            // Test UserModel
            echo "<h2>UserModel Test</h2>";
            $user = $this->userModel->findByLogin($login);
            
            if (!$user) {
                echo "<p>❌ User not found for login: " . htmlspecialchars($login) . "</p>";
                echo "<p><a href='/auth/login'>← Back to Login</a></p>";
                echo "</body></html>";
                return;
            }
            
            echo "<p>✅ User found:</p>";
            echo "<ul>";
            echo "<li>ID: " . $user['id'] . "</li>";
            echo "<li>Username: " . htmlspecialchars($user['username']) . "</li>";
            echo "<li>Email: " . htmlspecialchars($user['email']) . "</li>";
            echo "<li>Active: " . ($user['active'] ? 'YES' : 'NO') . "</li>";
            echo "</ul>";
            
            // Test password
            echo "<h2>Password Test</h2>";
            if (password_verify($password, $user['password'])) {
                echo "<p>✅ Password is correct!</p>";
                
                if (!$user['active']) {
                    echo "<p>❌ User account is not active</p>";
                } else {
                    echo "<h2>🎉 LOGIN SUCCESS!</h2>";
                    echo "<p>Setting up session...</p>";
                    
                    // Set basic session data
                    $sessionData = [
                        'user_id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'logged_in' => true
                    ];
                    
                    session()->set($sessionData);
                    echo "<p>✅ Session set successfully</p>";
                    
                    echo "<h3>Manual Navigation Links:</h3>";
                    echo "<ul>";
                    echo "<li><a href='/'>Home Page</a></li>";
                    echo "<li><a href='/dashboard'>Dashboard</a></li>";
                    echo "<li><a href='/simple-test'>Simple Test Page</a></li>";
                    echo "</ul>";
                }
            } else {
                echo "<p>❌ Password is incorrect</p>";
            }
            
        } catch (\Exception $e) {
            echo "<h2>❌ ERROR OCCURRED</h2>";
            echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
            echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
            echo "<h3>Stack Trace:</h3>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        }
        
        echo "<hr><p><a href='/auth/login'>← Back to Login</a></p>";
        echo "</body></html>";
    }

    /**
     * Simple logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('auth/login');
    }
}