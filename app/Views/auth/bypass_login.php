<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Emergency Login - PHA Manager v4</title>
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
        }
        .btn { border-radius: 25px; }
        .form-control { border-radius: 25px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="text-primary">🚨 Emergency Login</h2>
                            <p class="text-muted">Παράκαμψη για το προβληματικό authentication system</p>
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

                        <!-- Simple Login Form -->
                        <form action="<?= base_url('auth-bypass/attempt-login') ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label for="login" class="form-label">Email ή Username</label>
                                <input type="text" class="form-control" id="login" name="login" 
                                       value="<?= old('login', 'spikasis@gmail.com') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Κωδικός</label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       value="038213sp" required>
                                <div class="form-text">Test credentials: spikasis@gmail.com / 038213sp</div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                🚀 Emergency Login
                            </button>

                            <div class="text-center">
                                <small class="text-muted">
                                    ⚠️ Αυτό είναι emergency bypass - δεν είναι ασφαλές για production!
                                </small>
                            </div>
                        </form>

                        <!-- Debug Info -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <small>
                                <strong>Debug Info:</strong><br>
                                Action URL: <?= base_url('auth-bypass/attempt-login') ?><br>
                                Current Time: <?= date('Y-m-d H:i:s') ?><br>
                                Base URL: <?= base_url() ?>
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