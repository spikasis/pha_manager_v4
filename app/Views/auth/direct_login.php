<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Direct Login - PHA Manager v4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card { 
            border-radius: 15px; 
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        .btn-xl { 
            padding: 20px 40px; 
            font-size: 1.2rem;
            border-radius: 25px; 
            font-weight: bold;
        }
        .direct-login-btn {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            transition: all 0.3s;
        }
        .direct-login-btn:hover {
            background: linear-gradient(45deg, #20c997, #28a745);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <h1 class="text-primary mb-3">🎧 PHA Manager v4</h1>
                            <h3 class="text-muted">Direct Access Login</h3>
                            <p class="text-muted">Παράκαμψη του προβληματικού POST authentication</p>
                        </div>

                        <!-- Flash Messages -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Direct Login Buttons -->
                        <div class="d-grid gap-3">
                            <a href="<?= base_url('direct-login/login') ?>" class="btn direct-login-btn btn-xl">
                                🚀 ΜΠΕΣ ΣΤΟΝ ΔΙΑΧΕΙΡΙΣΤΗ
                            </a>
                            
                            <div class="row mt-4">
                                <div class="col-6">
                                    <a href="<?= base_url('customers') ?>" class="btn btn-outline-primary w-100">
                                        👥 Πελάτες
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-success w-100">
                                        📊 Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Info -->
                        <div class="mt-5 p-3 bg-light rounded">
                            <small class="text-muted">
                                <strong>🔧 Τεχνικές πληροφορίες:</strong><br>
                                • Αυτό bypasses το POST login που βγάζει Error 500<br>
                                • Χρησιμοποιεί GET requests μόνο<br>
                                • Άμεση πρόσβαση στο σύστημα<br>
                                • Base URL: <?= base_url() ?>
                            </small>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                ⚠️ Emergency access - όχι για production χρήση<br>
                                Φτιάχτηκε για να παρακάμψει το post_max_size πρόβλημα
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>