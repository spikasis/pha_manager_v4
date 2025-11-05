<?= $this->extend('layouts/main') ?><?= $this->extend('templates/layout') ?>



<?= $this->section('content') ?><?= $this->section('content') ?>



<!-- Dashboard Header Stats -->                    <!-- Page Heading -->

<div class="row">                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                            <div>

    <!-- Total Customers -->                            <h1 class="h3 mb-0 text-gray-800">Dashboard - <?= esc($branch_name ?? 'PHA Manager v4') ?></h1>

    <div class="col-xl-3 col-md-6 mb-4">                            <p class="mb-0 text-muted">Καλώς ήρθατε, <?= esc($user_data['full_name'] ?? $user['username'] ?? 'Χρήστη') ?></p>

        <div class="card stats-card h-100 py-2">                        </div>

            <div class="card-body">                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i

                <div class="row no-gutters align-items-center">                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>

                    <div class="col mr-2">                    </div>

                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">

                            Συνολικοί Πελάτες                    <!-- User Info Alert (if not admin) -->

                        </div>                    <?php if (!($user_data['is_admin'] ?? false)): ?>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">                    <div class="alert alert-info mb-4" role="alert">

                            <?= number_format($stats['customers'] ?? 0) ?>                        <i class="fas fa-info-circle"></i>

                        </div>                        <strong>Υποκατάστημα:</strong> <?= esc($branch_name ?? 'Κεντρική Διοίκηση') ?> 

                    </div>                        | <strong>Ρόλος:</strong> <?= implode(', ', array_column($user_data['groups'] ?? [], 'name')) ?>

                    <div class="col-auto">                    </div>

                        <i class="fas fa-users fa-2x text-gray-300"></i>                    <?php endif; ?>

                    </div>

                </div>                    <!-- Content Row -->

            </div>                    <div class="row">

        </div>

    </div>                        <!-- Customers Card -->

                        <div class="col-xl-3 col-md-6 mb-4">

    <!-- Total Doctors -->                            <div class="card border-left-primary shadow h-100 py-2 card-clickable" onclick="window.location.href='<?= base_url('customers') ?>'">

    <div class="col-xl-3 col-md-6 mb-4">                                <div class="card-body">

        <div class="card stats-card h-100 py-2">                                    <div class="row no-gutters align-items-center">

            <div class="card-body">                                        <div class="col mr-2">

                <div class="row no-gutters align-items-center">                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">

                    <div class="col mr-2">                                                Συνολικοί Πελάτες</div>

                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                            Γιατροί                                                <?= esc($customer_stats['total_customers'] ?? 0) ?>

                        </div>                                            </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">                                        </div>

                            <?= number_format($stats['doctors'] ?? 0) ?>                                        <div class="col-auto">

                        </div>                                            <i class="fas fa-users fa-2x text-gray-300"></i>

                    </div>                                        </div>

                    <div class="col-auto">                                    </div>

                        <i class="fas fa-user-md fa-2x text-gray-300"></i>                                </div>

                    </div>                            </div>

                </div>                        </div>

            </div>

        </div>                        <!-- Active Services Card -->

    </div>                        <div class="col-xl-3 col-md-6 mb-4">

                            <div class="card border-left-success shadow h-100 py-2">

    <!-- Total Users -->                                <div class="card-body">

    <div class="col-xl-3 col-md-6 mb-4">                                    <div class="row no-gutters align-items-center">

        <div class="card stats-card h-100 py-2">                                        <div class="col mr-2">

            <div class="card-body">                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">

                <div class="row no-gutters align-items-center">                                                Ενεργές Υπηρεσίες</div>

                    <div class="col mr-2">                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">                                                <?= esc($service_stats['active_services'] ?? 0) ?>

                            Χρήστες Συστήματος                                            </div>

                        </div>                                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">                                        <div class="col-auto">

                            <?= number_format($stats['users'] ?? 0) ?>                                            <i class="fas fa-tools fa-2x text-gray-300"></i>

                        </div>                                        </div>

                    </div>                                    </div>

                    <div class="col-auto">                                </div>

                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>                            </div>

                    </div>                        </div>

                </div>

            </div>                        <!-- Doctors Card -->

        </div>                        <div class="col-xl-3 col-md-6 mb-4">

    </div>                            <div class="card border-left-info shadow h-100 py-2">

                                <div class="card-body">

    <!-- System Status -->                                    <div class="row no-gutters align-items-center">

    <div class="col-xl-3 col-md-6 mb-4">                                        <div class="col mr-2">

        <div class="card stats-card h-100 py-2">                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">

            <div class="card-body">                                                Συνεργάτες Γιατροί</div>

                <div class="row no-gutters align-items-center">                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                    <div class="col mr-2">                                                <?= esc($doctor_stats['total_doctors'] ?? 0) ?>

                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">                                            </div>

                            Κατάσταση Συστήματος                                        </div>

                        </div>                                        <div class="col-auto">

                        <div class="h5 mb-0 font-weight-bold text-gray-800">                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>

                            <i class="fas fa-check-circle text-success"></i> Ενεργό                                        </div>

                        </div>                                    </div>

                    </div>                                </div>

                    <div class="col-auto">                            </div>

                        <i class="fas fa-server fa-2x text-gray-300"></i>                        </div>

                    </div>

                </div>                        <!-- Customers with Debt Card -->

            </div>                        <div class="col-xl-3 col-md-6 mb-4">

        </div>                            <div class="card border-left-warning shadow h-100 py-2">

    </div>                                <div class="card-body">

                                    <div class="row no-gutters align-items-center">

</div>                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">

<!-- Main Dashboard Content -->                                                Πελάτες με Οφειλή</div>

<div class="row">                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                <?= esc($customers_with_debt ?? 0) ?>

    <!-- Quick Actions -->                                            </div>

    <div class="col-lg-6 mb-4">                                        </div>

        <div class="card shadow">                                        <div class="col-auto">

            <div class="card-header py-3">                                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>

                <h6 class="m-0 font-weight-bold text-primary">                                        </div>

                    <i class="fas fa-bolt"></i> Γρήγορες Ενέργειες                                    </div>

                </h6>                                </div>

            </div>                            </div>

            <div class="card-body">                        </div>

                <div class="row">                    </div>

                    <div class="col-md-6 mb-3">

                        <a href="<?= base_url('customers/create') ?>" class="btn btn-primary btn-block">                    <!-- Content Row -->

                            <i class="fas fa-plus"></i> Νέος Πελάτης                    <div class="row">

                        </a>

                    </div>                        <!-- Area Chart -->

                    <div class="col-md-6 mb-3">                        <div class="col-xl-8 col-lg-7">

                        <a href="<?= base_url('doctors/create') ?>" class="btn btn-success btn-block">                            <div class="card shadow mb-4">

                            <i class="fas fa-user-md"></i> Νέος Γιατρός                                <!-- Card Header - Dropdown -->

                        </a>                                <div

                    </div>                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <div class="col-md-6 mb-3">                                    <h6 class="m-0 font-weight-bold text-primary">Monthly Overview</h6>

                        <a href="<?= base_url('customers') ?>" class="btn btn-info btn-block">                                </div>

                            <i class="fas fa-search"></i> Αναζήτηση Πελάτη                                <!-- Card Body -->

                        </a>                                <div class="card-body">

                    </div>                                    <div class="chart-area">

                    <div class="col-md-6 mb-3">                                        <canvas id="myAreaChart"></canvas>

                        <a href="<?= base_url('users') ?>" class="btn btn-warning btn-block">                                    </div>

                            <i class="fas fa-users"></i> Διαχείριση Χρηστών                                </div>

                        </a>                            </div>

                    </div>                        </div>

                </div>

            </div>                        <!-- Pie Chart -->

        </div>                        <div class="col-xl-4 col-lg-5">

    </div>                            <div class="card shadow mb-4">

                                <!-- Card Header - Dropdown -->

    <!-- Recent Activity -->                                <div

    <div class="col-lg-6 mb-4">                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

        <div class="card shadow">                                    <h6 class="m-0 font-weight-bold text-primary">Patient Categories</h6>

            <div class="card-header py-3">                                </div>

                <h6 class="m-0 font-weight-bold text-primary">                                <!-- Card Body -->

                    <i class="fas fa-clock"></i> Πρόσφατη Δραστηριότητα                                <div class="card-body">

                </h6>                                    <div class="chart-pie pt-4 pb-2">

            </div>                                        <canvas id="myPieChart"></canvas>

            <div class="card-body">                                    </div>

                <div class="list-group list-group-flush">                                    <div class="mt-4 text-center small">

                    <div class="list-group-item d-flex align-items-center">                                        <span class="mr-2">

                        <div class="me-3">                                            <i class="fas fa-circle text-primary"></i> Regular

                            <i class="fas fa-user-plus text-success"></i>                                        </span>

                        </div>                                        <span class="mr-2">

                        <div>                                            <i class="fas fa-circle text-success"></i> Critical

                            <div class="fw-bold">Επιτυχής σύνδεση</div>                                        </span>

                            <small class="text-muted">Χρήστης: <?= session()->get('username') ?: 'Spiros' ?></small>                                        <span class="mr-2">

                        </div>                                            <i class="fas fa-circle text-info"></i> Follow-up

                        <small class="text-muted ms-auto"><?= date('H:i') ?></small>                                        </span>

                    </div>                                    </div>

                    <div class="list-group-item d-flex align-items-center">                                </div>

                        <div class="me-3">                            </div>

                            <i class="fas fa-server text-info"></i>                        </div>

                        </div>                    </div>

                        <div>

                            <div class="fw-bold">Σύστημα ενεργό</div>                    <!-- Quick Actions -->

                            <small class="text-muted">Όλες οι υπηρεσίες λειτουργούν κανονικά</small>                    <div class="row mb-4">

                        </div>                        <div class="col-12">

                        <small class="text-muted ms-auto"><?= date('H:i') ?></small>                            <div class="card shadow">

                    </div>                                <div class="card-header py-3">

                    <div class="list-group-item d-flex align-items-center">                                    <h6 class="m-0 font-weight-bold text-primary">

                        <div class="me-3">                                        <i class="fas fa-bolt"></i> Γρήγορες Ενέργειες

                            <i class="fas fa-database text-primary"></i>                                    </h6>

                        </div>                                </div>

                        <div>                                <div class="card-body">

                            <div class="fw-bold">Βάση δεδομένων</div>                                    <div class="row">

                            <small class="text-muted">Σύνδεση επιτυχής</small>                                        <div class="col-lg-3 col-md-6 mb-3">

                        </div>                                            <a href="<?= base_url('customers') ?>" class="btn btn-primary btn-block btn-lg">

                        <small class="text-muted ms-auto"><?= date('H:i') ?></small>                                                <i class="fas fa-users"></i><br>

                    </div>                                                <small>Διαχείριση Πελατών</small>

                </div>                                            </a>

            </div>                                        </div>

        </div>                                        <div class="col-lg-3 col-md-6 mb-3">

    </div>                                            <a href="<?= base_url('customers/create') ?>" class="btn btn-success btn-block btn-lg">

                                                <i class="fas fa-user-plus"></i><br>

</div>                                                <small>Νέος Πελάτης</small>

                                            </a>

<!-- System Information -->                                        </div>

<div class="row">                                        <div class="col-lg-3 col-md-6 mb-3">

    <div class="col-lg-12">                                            <a href="#" class="btn btn-info btn-block btn-lg">

        <div class="card shadow">                                                <i class="fas fa-wrench"></i><br>

            <div class="card-header py-3">                                                <small>Νέα Υπηρεσία</small>

                <h6 class="m-0 font-weight-bold text-primary">                                            </a>

                    <i class="fas fa-info-circle"></i> Πληροφορίες Συστήματος                                        </div>

                </h6>                                        <div class="col-lg-3 col-md-6 mb-3">

            </div>                                            <a href="#" class="btn btn-warning btn-block btn-lg">

            <div class="card-body">                                                <i class="fas fa-assistive-listening-systems"></i><br>

                <div class="row">                                                <small>Νέο Ακουστικό</small>

                    <div class="col-md-3">                                            </a>

                        <div class="text-center p-3">                                        </div>

                            <h5 class="text-primary">PHA Manager v4</h5>                                    </div>

                            <p class="text-muted mb-0">Professional Hearing Aid Management</p>                                </div>

                        </div>                            </div>

                    </div>                        </div>

                    <div class="col-md-3">                    </div>

                        <div class="text-center p-3">

                            <h5 class="text-success"><?= count($crud_modules) ?> Modules</h5>                    <!-- Content Row -->

                            <p class="text-muted mb-0">Διαθέσιμα CRUD modules</p>                    <div class="row">

                        </div>

                    </div>                        <!-- Recent Activity -->

                    <div class="col-md-3">                        <div class="col-lg-6 mb-4">

                        <div class="text-center p-3">                            <div class="card shadow mb-4">

                            <h5 class="text-info">Online</h5>                                <div class="card-header py-3">

                            <p class="text-muted mb-0">Κατάσταση σύνδεσης</p>                                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>

                        </div>                                </div>

                    </div>                                <div class="card-body">

                    <div class="col-md-3">                                    <h4 class="small font-weight-bold">Patient Registration <span

                        <div class="text-center p-3">                                            class="float-right">20%</span></h4>

                            <h5 class="text-warning"><?= date('d/m/Y') ?></h5>                                    <div class="progress mb-4">

                            <p class="text-muted mb-0">Τρέχουσα ημερομηνία</p>                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"

                        </div>                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>

                    </div>                                    </div>

                </div>                                    <h4 class="small font-weight-bold">Appointments Scheduled <span

            </div>                                            class="float-right">40%</span></h4>

        </div>                                    <div class="progress mb-4">

    </div>                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"

</div>                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>

                                    </div>

<!-- Available CRUD Modules -->                                    <h4 class="small font-weight-bold">Medical Records Updated <span

<div class="row mt-4">                                            class="float-right">60%</span></h4>

    <div class="col-lg-12">                                    <div class="progress mb-4">

        <div class="card shadow">                                        <div class="progress-bar" role="progressbar" style="width: 60%"

            <div class="card-header py-3">                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>

                <h6 class="m-0 font-weight-bold text-primary">                                    </div>

                    <i class="fas fa-th-large"></i> Διαθέσιμα Modules                                    <h4 class="small font-weight-bold">Prescriptions Issued <span

                </h6>                                            class="float-right">80%</span></h4>

            </div>                                    <div class="progress mb-4">

            <div class="card-body">                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%"

                <div class="row">                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>

                    <?php foreach ($crud_modules as $module): ?>                                    </div>

                    <div class="col-lg-4 col-md-6 mb-3">                                    <h4 class="small font-weight-bold">Reports Generated <span

                        <div class="card border-left-primary h-100">                                            class="float-right">Complete!</span></h4>

                            <div class="card-body">                                    <div class="progress">

                                <div class="row no-gutters align-items-center">                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"

                                    <div class="col mr-2">                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>

                                        <div class="font-weight-bold text-primary text-uppercase mb-1">                                    </div>

                                            <?= $module['title'] ?>                                </div>

                                        </div>                            </div>

                                        <div class="mb-0 text-gray-600 small">                        </div>

                                            <?= $module['description'] ?>

                                        </div>                        <!-- Color System -->

                                    </div>                        <div class="col-lg-6 mb-4">

                                    <div class="col-auto">                            <div class="card shadow mb-4">

                                        <a href="<?= base_url($module['url']) ?>" class="btn btn-primary btn-sm">                                <div class="card-header py-3">

                                            <i class="<?= $module['icon'] ?>"></i>                                    <h6 class="m-0 font-weight-bold text-primary">System Status</h6>

                                        </a>                                </div>

                                    </div>                                <div class="card-body">

                                </div>                                    <div class="row">

                            </div>                                        <div class="col-lg-6 mb-4">

                        </div>                                            <div class="card bg-primary text-white shadow">

                    </div>                                                <div class="card-body">

                    <?php endforeach; ?>                                                    Primary

                </div>                                                    <div class="text-white-50 small">Database: OK</div>

            </div>                                                </div>

        </div>                                            </div>

    </div>                                        </div>

</div>                                        <div class="col-lg-6 mb-4">

                                            <div class="card bg-success text-white shadow">

<?= $this->endSection() ?>                                                <div class="card-body">
                                                    Success
                                                    <div class="text-white-50 small">API: Connected</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="card bg-info text-white shadow">
                                                <div class="card-body">
                                                    Info
                                                    <div class="text-white-50 small">Storage: 75% Used</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="card bg-warning text-white shadow">
                                                <div class="card-body">
                                                    Warning
                                                    <div class="text-white-50 small">Memory: High Usage</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
.card-clickable {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card-clickable:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
}

.btn-lg i {
    font-size: 1.5rem;
    margin-bottom: 5px;
}
</style>
<?= $this->endSection() ?>
