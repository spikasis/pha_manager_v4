<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800"><?= esc($branch_name) ?></h1>
                            <p class="mb-0 text-muted">Καλώς ήρθατε, <?= esc($user_data['full_name']) ?></p>
                        </div>
                        <div class="btn-group">
                            <?php if($user_data['is_admin']): ?>
                                <a href="<?= base_url('dashboard') ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-tachometer-alt fa-sm"></i> Κεντρικό Dashboard
                                </a>
                            <?php endif; ?>
                            <a href="#" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Αναφορά <?= esc($branch_type) ?>
                            </a>
                        </div>
                    </div>

                    <!-- Branch Info Alert -->
                    <div class="alert alert-info mb-4" role="alert">
                        <i class="fas fa-info-circle"></i>
                        <strong>Υποκατάστημα:</strong> <?= esc($branch_name) ?> 
                        | <strong>Χρήστης:</strong> <?= esc($user_data['username']) ?>
                        | <strong>Ρόλος:</strong> <?= implode(', ', array_column($user_data['groups'], 'name')) ?>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Branch Customers Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2 card-clickable" onclick="window.location.href='<?= base_url('customers') ?>'">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Πελάτες <?= esc($branch_type) ?></div>
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

                        <!-- Branch Services Card -->
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

                        <!-- Customers with Debt Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Οφειλές</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= esc($customers_with_debt) ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expiring Guarantees Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Εγγυήσεις που Λήγουν</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= esc($expiring_guarantees) ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Recent Services -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Πρόσφατες Υπηρεσίες - <?= esc($branch_type) ?></h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Επιλογές:</div>
                                            <a class="dropdown-item" href="<?= base_url('services') ?>">Δες όλες τις υπηρεσίες</a>
                                            <a class="dropdown-item" href="<?= base_url('services/create') ?>">Νέα Υπηρεσία</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($recent_services)): ?>
                                        <div class="text-center py-4">
                                            <i class="fas fa-tools fa-3x text-gray-300 mb-3"></i>
                                            <p class="text-muted">Δεν υπάρχουν πρόσφατες υπηρεσίες για το <?= esc($branch_type) ?></p>
                                            <a href="<?= base_url('services/create') ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus"></i> Προσθήκη Υπηρεσίας
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Ημερομηνία</th>
                                                        <th>Πελάτης</th>
                                                        <th>Υπηρεσία</th>
                                                        <th>Κατάσταση</th>
                                                        <th>Ενέργειες</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($recent_services as $service): ?>
                                                    <tr>
                                                        <td><?= date('d/m/Y', strtotime($service['created_at'] ?? 'now')) ?></td>
                                                        <td><?= esc($service['customer_name'] ?? 'Άγνωστος') ?></td>
                                                        <td><?= esc($service['service_type'] ?? 'Υπηρεσία') ?></td>
                                                        <td>
                                                            <span class="badge badge-<?= ($service['status'] ?? 'pending') === 'completed' ? 'success' : 'warning' ?>">
                                                                <?= ($service['status'] ?? 'pending') === 'completed' ? 'Ολοκληρωμένη' : 'Εν εξελίξει' ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('services/show/' . ($service['id'] ?? '')) ?>" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Branch Quick Actions -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Γρήγορες Ενέργειες - <?= esc($branch_type) ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="<?= base_url('customers/create') ?>" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><i class="fas fa-user-plus text-primary"></i> Νέος Πελάτης</h6>
                                            </div>
                                            <p class="mb-1">Προσθέστε νέο πελάτη στο σύστημα</p>
                                        </a>
                                        
                                        <a href="<?= base_url('services/create') ?>" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><i class="fas fa-tools text-success"></i> Νέα Υπηρεσία</h6>
                                            </div>
                                            <p class="mb-1">Δημιουργήστε νέα εργασία service</p>
                                        </a>
                                        
                                        <a href="<?= base_url('customers/search') ?>" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><i class="fas fa-search text-info"></i> Αναζήτηση Πελάτη</h6>
                                            </div>
                                            <p class="mb-1">Βρείτε πελάτη γρήγορα</p>
                                        </a>

                                        <?php if ($branch_type === 'Service'): ?>
                                        <a href="<?= base_url('repairs') ?>" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><i class="fas fa-wrench text-warning"></i> Επισκευές</h6>
                                            </div>
                                            <p class="mb-1">Διαχείριση επισκευών</p>
                                        </a>
                                        <?php endif; ?>

                                        <?php if ($branch_type === 'Lab'): ?>
                                        <a href="<?= base_url('orders') ?>" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><i class="fas fa-flask text-danger"></i> Παραγγελίες Εργαστηρίου</h6>
                                            </div>
                                            <p class="mb-1">Διαχείριση παραγγελιών</p>
                                        </a>
                                        <?php endif; ?>
                                        
                                        <a href="<?= base_url('reports/branch/' . strtolower($branch_type)) ?>" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><i class="fas fa-chart-bar text-secondary"></i> Αναφορές</h6>
                                            </div>
                                            <p class="mb-1">Αναφορές για το <?= esc($branch_name) ?></p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Branch Info Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Πληροφορίες Χρήστη</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <i class="fas fa-user-circle fa-3x text-gray-300"></i>
                                        </div>
                                        <div class="col ml-3">
                                            <div class="font-weight-bold"><?= esc($user_data['full_name']) ?></div>
                                            <div class="text-muted"><?= esc($user_data['email']) ?></div>
                                            <div class="text-muted">
                                                <small>
                                                    <i class="fas fa-building"></i> <?= esc($branch_name) ?><br>
                                                    <i class="fas fa-clock"></i> Τελευταία σύνδεση: 
                                                    <?= $user_data['last_login'] ? date('d/m/Y H:i', $user_data['last_login']) : 'Ποτέ' ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

<?= $this->endSection() ?>

<!-- Custom CSS for branch dashboard -->
<style>
.card-clickable {
    cursor: pointer;
    transition: transform 0.2s;
}

.card-clickable:hover {
    transform: translateY(-2px);
}

.alert-info {
    border-left: 4px solid #36b9cc;
}

.list-group-item:hover {
    background-color: #f8f9fc;
}
</style>