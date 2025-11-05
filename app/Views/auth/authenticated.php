<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="<?= site_url('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    
    <!-- Custom fonts -->
    <link href="<?= site_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    
    <!-- Custom styles -->
    <link href="<?= site_url('sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    
    <style>
        .dashboard-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .user-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .session-info {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .action-buttons .btn {
            margin: 0.25rem;
        }
    </style>
</head>

<body class="dashboard-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="user-card">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="text-primary">
                                <i class="fas fa-tachometer-alt"></i>
                                Καλώς ήρθατε στο PHA Manager v4
                            </h2>
                            
                            <p class="text-muted mb-4">
                                Είστε συνδεδεμένοι και έτοιμοι να χρησιμοποιήσετε το σύστημα διαχείρισης.
                            </p>
                            
                            <!-- User Information -->
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Χρήστης:</strong></div>
                                <div class="col-sm-8"><?= $user['full_name'] ?></div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Username:</strong></div>
                                <div class="col-sm-8"><?= $user['username'] ?></div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Email:</strong></div>
                                <div class="col-sm-8"><?= $user['email'] ?></div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Ρόλος:</strong></div>
                                <div class="col-sm-8">
                                    <?php 
                                    $badgeClass = 'info';
                                    if ($user['role'] === 'Owner') $badgeClass = 'danger';
                                    elseif ($user['role'] === 'Admin') $badgeClass = 'warning';
                                    ?>
                                    <span class="badge badge-<?= $badgeClass ?>">
                                        <?= $user['role'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 text-center">
                            <i class="fas fa-user-circle fa-6x text-primary mb-3"></i>
                            
                            <div class="session-info">
                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-clock"></i> Πληροφορίες Session
                                </h6>
                                
                                <p class="mb-1">
                                    <strong>Σύνδεση:</strong><br>
                                    <?= date('d/m/Y H:i', $user['login_time']) ?>
                                </p>
                                
                                <p class="mb-1">
                                    <strong>Τελευταία Δραστηριότητα:</strong><br>
                                    <?= date('H:i:s', $user['last_activity']) ?>
                                </p>
                                
                                <p class="mb-0">
                                    <strong>Χρόνος που απομένει:</strong><br>
                                    <span id="session-timer" class="text-success font-weight-bold">
                                        <?= gmdate('i:s', $session_remaining) ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons text-center mt-4">
                        <a href="<?= site_url('dashboard') ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-tachometer-alt"></i> Μετάβαση στο Dashboard
                        </a>
                        
                        <a href="<?= site_url('auth/logout') ?>" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-sign-out-alt"></i> Αποσύνδεση
                        </a>
                        
                        <button id="refresh-session" class="btn btn-outline-info btn-lg">
                            <i class="fas fa-sync-alt"></i> Ανανέωση Session
                        </button>
                    </div>
                    
                    <!-- Development Info -->
                    <div class="mt-4 p-3 bg-light border-left border-warning">
                        <h6 class="text-warning mb-2">
                            <i class="fas fa-code"></i> Development Information
                        </h6>
                        
                        <div class="row small text-muted">
                            <div class="col-md-6">
                                <strong>User ID:</strong> <?= $user['id'] ?><br>
                                <strong>Framework:</strong> CodeIgniter 4.6.3<br>
                                <strong>Environment:</strong> Development
                            </div>
                            <div class="col-md-6">
                                <strong>Session Timeout:</strong> 30 minutes<br>
                                <strong>CSRF Protection:</strong> Enabled<br>
                                <strong>SSL/TLS:</strong> Configured
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JavaScript -->
    <script src="<?= site_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= site_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    
    <!-- Session Management -->
    <script>
        let sessionRemaining = <?= $session_remaining ?>;
        
        // Update timer every second
        const timerInterval = setInterval(function() {
            sessionRemaining--;
            
            if (sessionRemaining <= 0) {
                alert('Η συνεδρία σας έχει λήξει. Θα ανακατευθυνθείτε στη σελίδα σύνδεσης.');
                window.location.href = '<?= site_url('auth') ?>';
                return;
            }
            
            const minutes = Math.floor(sessionRemaining / 60);
            const seconds = sessionRemaining % 60;
            document.getElementById('session-timer').textContent = 
                minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
                
            // Warning when 5 minutes remaining
            if (sessionRemaining === 300) {
                alert('Προειδοποίηση: Η συνεδρία σας θα λήξει σε 5 λεπτά.');
            }
        }, 1000);
        
        // Keep session alive
        setInterval(function() {
            $.ajax({
                url: '<?= site_url('auth/keepAlive') ?>',
                method: 'POST',
                success: function(response) {
                    if (response.status === 'success') {
                        sessionRemaining = response.session_remaining;
                    }
                },
                error: function() {
                    console.log('Failed to keep session alive');
                }
            });
        }, 60000); // Every minute
        
        // Refresh session button
        document.getElementById('refresh-session').addEventListener('click', function() {
            $.ajax({
                url: '<?= site_url('auth/keepAlive') ?>',
                method: 'POST',
                success: function(response) {
                    if (response.status === 'success') {
                        sessionRemaining = response.session_remaining;
                        alert('Η συνεδρία σας ανανεώθηκε επιτυχώς!');
                    }
                },
                error: function() {
                    alert('Σφάλμα κατά την ανανέωση της συνεδρίας.');
                }
            });
        });
    </script>
</body>
</html>