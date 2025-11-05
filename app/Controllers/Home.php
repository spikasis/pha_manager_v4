<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return $this->renderWelcomePage();
    }
    
    private function renderWelcomePage(): string
    {
        $html = '<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHA Manager v4 - Clean Start</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .container {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            animation: slideIn 0.8s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo {
            font-size: 72px;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #4e73df;
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .subtitle {
            font-size: 24px;
            color: #858796;
            margin-bottom: 30px;
        }
        
        .status {
            background: #1cc88a;
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            margin: 30px 0;
            display: inline-block;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 40px 0;
        }
        
        .info-card {
            background: #f8f9fc;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #4e73df;
        }
        
        .info-card h3 {
            color: #4e73df;
            margin-bottom: 10px;
        }
        
        .next-steps {
            background: #fff3cd;
            padding: 30px;
            border-radius: 15px;
            border-left: 4px solid #f6c23e;
            margin-top: 30px;
            text-align: left;
        }
        
        .next-steps h3 {
            color: #856404;
            margin-bottom: 15px;
        }
        
        .next-steps ol {
            color: #856404;
            margin-left: 20px;
        }
        
        .next-steps li {
            margin-bottom: 8px;
        }
        
        .footer {
            margin-top: 40px;
            color: #858796;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🦻</div>
        <h1>PHA Manager v4</h1>
        <p class="subtitle">Professional Hearing Aid Management System</p>
        
        <div class="status">
            ✅ System Successfully Reset
        </div>
        
        <div class="info-grid">
            <div class="info-card">
                <h3>🧹 Clean State</h3>
                <p>All old authentication files have been completely removed</p>
            </div>
            
            <div class="info-card">
                <h3>🚀 Ready to Build</h3>
                <p>System is ready for fresh authentication architecture</p>
            </div>
        </div>
        
        <div class="next-steps">
            <h3>📋 Next Development Steps:</h3>
            <ol>
                <li><strong>Design Authentication Architecture</strong> - Plan the new login system structure</li>
                <li><strong>Create Authentication Controller</strong> - Build the core login/logout functionality</li>
                <li><strong>Design Login Interface</strong> - Create modern, responsive login UI</li>
                <li><strong>Implement Session Management</strong> - Add secure session handling</li>
                <li><strong>Add Security Features</strong> - CSRF protection, rate limiting, etc.</li>
                <li><strong>Create Authorization System</strong> - Role-based access control</li>
                <li><strong>Build User Management</strong> - CRUD for users and permissions</li>
                <li><strong>Add Audit Trail</strong> - Login attempts and security logging</li>
            </ol>
        </div>
        
        <div class="footer">
            <p><strong>Framework:</strong> CodeIgniter 4.6.3</p>
            <p><strong>Status:</strong> Development Mode</p>
            <p><strong>Date:</strong> ' . date('d/m/Y H:i') . '</p>
        </div>
    </div>
</body>
</html>';
        
        return $html;
    }
}
