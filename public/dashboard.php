<?php
/**
 * Simple Dashboard - No CodeIgniter Dependencies
 */

// Start session
session_start();

// Check if logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: /safe_login.php');
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /safe_login.php?message=logged_out');
    exit;
}

$user = [
    'id' => $_SESSION['user_id'],
    'username' => $_SESSION['username'],
    'email' => $_SESSION['email']
];

?><!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - PHA Manager v4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fc; }
        .sidebar { background: linear-gradient(180deg, #4e73df 0%, #6f42c1 100%); min-height: 100vh; }
        .navbar { background: white; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
        .card { border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="text-white p-4">
                    <h4><i class="fas fa-assistive-listening-systems"></i> PHA Manager</h4>
                    <small>Professional Dashboard</small>
                </div>
                <nav class="nav flex-column p-3">
                    <a href="#" class="nav-link text-white active">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="#patients" class="nav-link text-white-50">
                        <i class="fas fa-users me-2"></i> Ασθενείς
                    </a>
                    <a href="#appointments" class="nav-link text-white-50">
                        <i class="fas fa-calendar-alt me-2"></i> Ραντεβού
                    </a>
                    <a href="#devices" class="nav-link text-white-50">
                        <i class="fas fa-cogs me-2"></i> Συσκευές
                    </a>
                    <a href="#reports" class="nav-link text-white-50">
                        <i class="fas fa-chart-bar me-2"></i> Αναφορές
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand navbar-light mb-4">
                    <div class="container-fluid">
                        <span class="navbar-text">
                            Καλώς ήρθες, <strong><?= htmlspecialchars($user['username']) ?></strong>!
                        </span>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle fa-lg"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><h6 class="dropdown-header"><?= htmlspecialchars($user['email']) ?></h6></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Προφίλ</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Ρυθμίσεις</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="?logout=1"><i class="fas fa-sign-out-alt me-2"></i> Αποσύνδεση</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Dashboard Content -->
                <div class="container-fluid">
                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Επιτυχία!</strong> Το σύστημα authentication λειτουργεί τέλεια!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>

                    <!-- Stats Row -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Σύνολο Ασθενών
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">1,245</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Ραντεβού Σήμερα
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Ενεργές Συσκευές
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">856</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Εκκρεμείς Επισκευές
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-wrench fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-rocket me-2"></i>Γρήγορες Ενέργειες
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center mb-3">
                                            <a href="#" class="btn btn-primary btn-circle btn-lg mb-2">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <p class="text-muted">Νέος Ασθενής</p>
                                        </div>
                                        <div class="col-md-4 text-center mb-3">
                                            <a href="#" class="btn btn-success btn-circle btn-lg mb-2">
                                                <i class="fas fa-calendar-plus"></i>
                                            </a>
                                            <p class="text-muted">Νέο Ραντεβού</p>
                                        </div>
                                        <div class="col-md-4 text-center mb-3">
                                            <a href="#" class="btn btn-info btn-circle btn-lg mb-2">
                                                <i class="fas fa-search"></i>
                                            </a>
                                            <p class="text-muted">Αναζήτηση</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-success">
                                        <i class="fas fa-check-double me-2"></i>Κατάσταση Συστήματος
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-circle text-success me-2"></i>
                                        <span>Σύνδεση στη Βάση</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-circle text-success me-2"></i>
                                        <span>Authentication</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-circle text-success me-2"></i>
                                        <span>Session Management</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-circle text-warning me-2"></i>
                                        <span>CodeIgniter (Safe Mode)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Development Notice -->
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Πληροφορίες Ανάπτυξης</h5>
                        <p class="mb-2">
                            <strong>✅ Ολοκληρωμένα:</strong> Authentication, Session Management, Database Connection<br>
                            <strong>🔧 Σε εξέλιξη:</strong> Patient Management, Appointments, Device Tracking<br>
                            <strong>📱 Επόμενα:</strong> Mobile App, API Integration, Advanced Reporting
                        </p>
                        <p class="mb-0">
                            <a href="/auth/login" class="btn btn-sm btn-outline-primary me-2">CodeIgniter Mode</a>
                            <a href="/ultra_debug.php" class="btn btn-sm btn-outline-info">Debug Tools</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>