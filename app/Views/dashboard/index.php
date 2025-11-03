<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Dashboard - <?= esc($branch_name ?? 'PHA Manager v4') ?></h1>
                            <p class="mb-0 text-muted">Καλώς ήρθατε, <?= esc($user_data['full_name'] ?? $user['username'] ?? 'Χρήστη') ?></p>
                        </div>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- User Info Alert (if not admin) -->
                    <?php if (!($user_data['is_admin'] ?? false)): ?>
                    <div class="alert alert-info mb-4" role="alert">
                        <i class="fas fa-info-circle"></i>
                        <strong>Υποκατάστημα:</strong> <?= esc($branch_name ?? 'Κεντρική Διοίκηση') ?> 
                        | <strong>Ρόλος:</strong> <?= implode(', ', array_column($user_data['groups'] ?? [], 'name')) ?>
                    </div>
                    <?php endif; ?>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Customers Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2 card-clickable" onclick="window.location.href='<?= base_url('customers') ?>'">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Συνολικοί Πελάτες</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= esc($customer_stats['total_customers'] ?? 0) ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Services Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Ενεργές Υπηρεσίες</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= esc($service_stats['active_services'] ?? 0) ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tools fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Doctors Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Συνεργάτες Γιατροί</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= esc($doctor_stats['total_doctors'] ?? 0) ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customers with Debt Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Πελάτες με Οφειλή</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= esc($customers_with_debt ?? 0) ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Monthly Overview</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Patient Categories</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Regular
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Critical
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Follow-up
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-bolt"></i> Γρήγορες Ενέργειες
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <a href="<?= base_url('customers') ?>" class="btn btn-primary btn-block btn-lg">
                                                <i class="fas fa-users"></i><br>
                                                <small>Διαχείριση Πελατών</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <a href="<?= base_url('customers/create') ?>" class="btn btn-success btn-block btn-lg">
                                                <i class="fas fa-user-plus"></i><br>
                                                <small>Νέος Πελάτης</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <a href="#" class="btn btn-info btn-block btn-lg">
                                                <i class="fas fa-wrench"></i><br>
                                                <small>Νέα Υπηρεσία</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <a href="#" class="btn btn-warning btn-block btn-lg">
                                                <i class="fas fa-assistive-listening-systems"></i><br>
                                                <small>Νέο Ακουστικό</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Recent Activity -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">Patient Registration <span
                                            class="float-right">20%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Appointments Scheduled <span
                                            class="float-right">40%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Medical Records Updated <span
                                            class="float-right">60%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: 60%"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Prescriptions Issued <span
                                            class="float-right">80%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Reports Generated <span
                                            class="float-right">Complete!</span></h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Color System -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">System Status</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <div class="card bg-primary text-white shadow">
                                                <div class="card-body">
                                                    Primary
                                                    <div class="text-white-50 small">Database: OK</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="card bg-success text-white shadow">
                                                <div class="card-body">
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
