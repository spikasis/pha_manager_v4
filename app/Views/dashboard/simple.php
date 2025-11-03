<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Dashboard - PHA Manager</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f8f9fa; 
            margin: 0; 
            padding: 20px; 
        }
        .header { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            margin-bottom: 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        .welcome { 
            color: #333; 
            margin: 0; 
        }
        .logout-btn { 
            background: #dc3545; 
            color: white; 
            padding: 10px 20px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold; 
        }
        .logout-btn:hover { 
            background: #c82333; 
            text-decoration: none; 
            color: white; 
        }
        .success-message { 
            background: #d4edda; 
            color: #155724; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            border: 1px solid #c3e6cb; 
        }
        .card { 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            margin-bottom: 20px; 
        }
        .nav-links { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            margin-top: 30px; 
        }
        .nav-link { 
            background: #007bff; 
            color: white; 
            padding: 20px; 
            text-decoration: none; 
            border-radius: 10px; 
            text-align: center; 
            font-weight: bold; 
            transition: background 0.3s; 
        }
        .nav-link:hover { 
            background: #0056b3; 
            text-decoration: none; 
            color: white; 
        }
        .user-info { 
            background: #e9ecef; 
            padding: 15px; 
            border-radius: 5px; 
            margin-top: 20px; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="welcome">🎧 PHA Manager v4 - Dashboard</h1>
        <a href="<?= base_url('auth-simple/logout') ?>" class="logout-btn">Αποσύνδεση</a>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="success-message">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <h2>✅ Επιτυχής Σύνδεση!</h2>
        <p>Καλώς ήρθατε στο σύστημα διαχείρισης ακουστικών βαρηκοΐας PHA Manager v4.</p>
        
        <div class="user-info">
            <h3>Στοιχεία Χρήστη:</h3>
            <p><strong>ID:</strong> <?= $user['id'] ?></p>
            <p><strong>Username:</strong> <?= $user['username'] ?></p>
            <p><strong>Email:</strong> <?= $user['email'] ?></p>
            <p><strong>Όνομα:</strong> <?= $user['first_name'] ?? 'Δεν έχει οριστεί' ?></p>
            <p><strong>Επώνυμο:</strong> <?= $user['last_name'] ?? 'Δεν έχει οριστεί' ?></p>
        </div>
        
        <div class="nav-links">
            <a href="<?= base_url('customers') ?>" class="nav-link">
                👥 Πελάτες<br>
                <small>Διαχείριση πελατών</small>
            </a>
            <a href="<?= base_url('doctors') ?>" class="nav-link">
                👨‍⚕️ Γιατροί<br>
                <small>Διαχείριση γιατρών</small>
            </a>
            <a href="<?= base_url('users') ?>" class="nav-link">
                🔐 Χρήστες<br>
                <small>Διαχείριση χρηστών</small>
            </a>
            <a href="<?= base_url('groups') ?>" class="nav-link">
                👥 Ομάδες<br>
                <small>Διαχείριση ομάδων</small>
            </a>
        </div>
    </div>
    
    <div class="card">
        <h3>🔧 Debug Information</h3>
        <p><strong>Session ID:</strong> <?= session_id() ?></p>
        <p><strong>Base URL:</strong> <?= base_url() ?></p>
        <p><strong>Current Time:</strong> <?= date('Y-m-d H:i:s') ?></p>
        <p><strong>Login Status:</strong> <?= session()->get('logged_in') ? 'Logged In' : 'Not Logged In' ?></p>
    </div>
</body>
</html>