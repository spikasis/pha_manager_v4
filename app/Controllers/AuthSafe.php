<?php

namespace App\Controllers;

/**
 * Safe Auth Controller - Fallback without intl dependencies
 * This controller works even when PHP intl extension is missing
 */
class AuthSafe extends BaseController
{
    /**
     * Simple login form
     */
    public function login()
    {
        // Check if already logged in
        if (session('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Σύνδεση - PHA Manager',
            'error' => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success'),
            'validation' => session('validation')
        ];

        echo $this->renderSimpleLogin($data);
    }

    /**
     * Process login
     */
    public function attemptLogin()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        if (empty($login) || empty($password)) {
            session()->setFlashdata('error', 'Παρακαλώ συμπληρώστε όλα τα πεδία.');
            return redirect()->to('/auth-safe/login');
        }

        try {
            // Direct database connection
            $config = [
                'host' => 'linux2917.grserver.gr',
                'database' => 'customers_db2', 
                'username' => 'spik',
                'password' => '0382sp@#'
            ];

            $pdo = new \PDO(
                "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4",
                $config['username'],
                $config['password']
            );

            // Find user
            $stmt = $pdo->prepare("SELECT id, username, email, password, active FROM users WHERE email = ? OR username = ? LIMIT 1");
            $stmt->execute([$login, $login]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['password'])) {
                session()->setFlashdata('error', 'Λάθος στοιχεία σύνδεσης.');
                return redirect()->to('/auth-safe/login');
            }

            if (!$user['active']) {
                session()->setFlashdata('error', 'Ο λογαριασμός δεν είναι ενεργός.');
                return redirect()->to('/auth-safe/login');
            }

            // Set session
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'logged_in' => true
            ]);

            // Update last login
            $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$user['id']]);

            session()->setFlashdata('success', 'Επιτυχής σύνδεση!');
            return redirect()->to('/dashboard');

        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Σφάλμα σύνδεσης: ' . $e->getMessage());
            return redirect()->to('/auth-safe/login');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Επιτυχής αποσύνδεση.');
        return redirect()->to('/auth-safe/login');
    }

    /**
     * Render simple login form without complex dependencies
     */
    private function renderSimpleLogin($data)
    {
        return '<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . $data['title'] . '</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { background: rgba(255,255,255,0.95); border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .btn-primary { background: #4e73df; border: none; }
        .form-control { border-radius: 25px; padding: 12px 20px; }
        .btn { border-radius: 25px; padding: 12px 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-assistive-listening-systems fa-3x text-primary mb-3"></i>
                        <h2>PHA Manager</h2>
                        <p class="text-muted">Safe Authentication Mode</p>
                    </div>

                    ' . ($data['error'] ? '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' . $data['error'] . '</div>' : '') . '
                    ' . ($data['success'] ? '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' . $data['success'] . '</div>' : '') . '

                    <form method="post" action="/auth-safe/attempt-login">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" name="login" placeholder="Email ή Username" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="Κωδικός" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt"></i> Σύνδεση
                        </button>
                    </form>

                    <hr class="my-4">
                    <div class="text-center">
                        <small class="text-muted">Safe Mode - No intl dependencies</small><br>
                        <a href="/pure_auth.php" class="btn btn-sm btn-outline-secondary mt-2">Pure PHP Auth</a>
                        <a href="/ultra_debug.php" class="btn btn-sm btn-outline-info mt-2">Debug</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>';
    }
}