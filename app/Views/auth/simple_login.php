<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Login - PHA Manager</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f0f0f0; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
        }
        .login-box { 
            background: white; 
            padding: 40px; 
            border-radius: 10px; 
            box-shadow: 0 0 20px rgba(0,0,0,0.1); 
            width: 400px; 
        }
        h2 { text-align: center; color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            font-size: 14px; 
            box-sizing: border-box; 
        }
        button { 
            width: 100%; 
            padding: 12px; 
            background: #007bff; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            font-size: 16px; 
            cursor: pointer; 
        }
        button:hover { background: #0056b3; }
        .alert { 
            padding: 10px; 
            margin-bottom: 20px; 
            border-radius: 5px; 
            text-align: center; 
        }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .debug { 
            background: #f8f9fa; 
            border: 1px solid #e9ecef; 
            padding: 15px; 
            margin-top: 20px; 
            border-radius: 5px; 
            font-size: 12px; 
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🎧 PHA Manager - Simple Login</h2>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('auth-simple/attempt-login') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="login">Email/Username:</label>
                <input type="text" 
                       id="login" 
                       name="login" 
                       value="spikasis@gmail.com"
                       required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       value="038213sp"
                       required>
            </div>
            
            <button type="submit">Σύνδεση</button>
        </form>
        
        <div class="debug">
            <strong>Debug Info:</strong><br>
            Action URL: <?= base_url('auth-simple/attempt-login') ?><br>
            Base URL: <?= base_url() ?><br>
            Session ID: <?= session_id() ?><br>
            Current Time: <?= date('Y-m-d H:i:s') ?>
        </div>
    </div>
</body>
</html>