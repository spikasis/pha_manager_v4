<?php $this->extend('templates/header') ?>

<?php $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user"></i> Προφίλ Πελάτη
    </h1>
    <div>
        <a href="<?= base_url('customers/' . $customer['id'] . '/edit') ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm mr-2">
            <i class="fas fa-edit fa-sm text-white-50"></i> Επεξεργασία
        </a>
        <a href="<?= base_url('customers') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Επιστροφή
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Customer Information -->
    <div class="col-lg-8">
        <!-- Personal Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-circle"></i> <?= esc($customer['name']) ?>
                </h6>
                <span class="badge badge-<?= $customer['status'] ? 'success' : 'secondary' ?> badge-lg">
                    <?= $customer['status'] ? 'Ενεργός' : 'Ανενεργός' ?>
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-id-card"></i> Προσωπικά Στοιχεία
                        </h6>
                        
                        <div class="info-group mb-3">
                            <label class="info-label">Ονοματεπώνυμο:</label>
                            <div class="info-value"><?= esc($customer['name']) ?></div>
                        </div>

                        <?php if (!empty($customer['father_name'])): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">Πατρώνυμο:</label>
                                <div class="info-value"><?= esc($customer['father_name']) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($customer['birth_date'])): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">Ημερομηνία Γέννησης:</label>
                                <div class="info-value">
                                    <?= date('d/m/Y', strtotime($customer['birth_date'])) ?>
                                    <small class="text-muted">
                                        (<?= date_diff(date_create($customer['birth_date']), date_create('today'))->y ?> ετών)
                                    </small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($customer['amka'])): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">ΑΜΚΑ:</label>
                                <div class="info-value">
                                    <?= esc($customer['amka']) ?>
                                    <?php if (!empty($customer['amka_expire_date'])): ?>
                                        <br><small class="text-muted">Λήξη: <?= date('d/m/Y', strtotime($customer['amka_expire_date'])) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($customer['identity_number'])): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">Ταυτότητα:</label>
                                <div class="info-value">
                                    <?= esc($customer['identity_number']) ?>
                                    <?php if (!empty($customer['identity_expire_date'])): ?>
                                        <br><small class="text-muted">Λήξη: <?= date('d/m/Y', strtotime($customer['identity_expire_date'])) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-address-book"></i> Στοιχεία Επικοινωνίας
                        </h6>

                        <?php if (!empty($customer['phone_mobile'])): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">Κινητό:</label>
                                <div class="info-value">
                                    <a href="tel:<?= esc($customer['phone_mobile']) ?>" class="text-decoration-none">
                                        <i class="fas fa-mobile-alt text-success"></i> <?= esc($customer['phone_mobile']) ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($customer['phone_landline'])): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">Σταθερό:</label>
                                <div class="info-value">
                                    <a href="tel:<?= esc($customer['phone_landline']) ?>" class="text-decoration-none">
                                        <i class="fas fa-phone text-primary"></i> <?= esc($customer['phone_landline']) ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($customer['email'])): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">Email:</label>
                                <div class="info-value">
                                    <a href="mailto:<?= esc($customer['email']) ?>" class="text-decoration-none">
                                        <i class="fas fa-envelope text-info"></i> <?= esc($customer['email']) ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($customer['address'])): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">Διεύθυνση:</label>
                                <div class="info-value">
                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                    <?= esc($customer['address']) ?>
                                    <?php if (!empty($customer['city'])): ?>
                                        <br><?= esc($customer['city']) ?>
                                        <?php if (!empty($customer['postal_code'])): ?>
                                            , <?= esc($customer['postal_code']) ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($doctor)): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">Γιατρός:</label>
                                <div class="info-value">
                                    <i class="fas fa-user-md text-success"></i>
                                    <?= esc($doctor['name']) ?>
                                    <?php if (!empty($doctor['doc_city'])): ?>
                                        <br><small class="text-muted"><?= esc($doctor['doc_city']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($customer['notes'])): ?>
                            <div class="info-group mb-3">
                                <label class="info-label">Σημειώσεις:</label>
                                <div class="info-value">
                                    <div class="alert alert-light">
                                        <?= nl2br(esc($customer['notes'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Audit Information -->
                <hr class="mt-4 mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar-plus"></i>
                            Δημιουργία: <?= date('d/m/Y H:i', strtotime($customer['created_at'])) ?>
                        </small>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php if (!empty($customer['updated_at'])): ?>
                            <small class="text-muted">
                                <i class="fas fa-calendar-edit"></i>
                                Τελευταία ενημέρωση: <?= date('d/m/Y H:i', strtotime($customer['updated_at'])) ?>
                            </small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Action Buttons -->
                <hr class="mt-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="<?= base_url('customers') ?>" class="btn btn-secondary">
                                    <i class="fas fa-list"></i> Λίστα Πελατών
                                </a>
                            </div>
                            <div>
                                <a href="<?= base_url('customers/' . $customer['id'] . '/edit') ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Επεξεργασία
                                </a>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                    <i class="fas fa-trash"></i> Διαγραφή
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics and Quick Actions -->
    <div class="col-lg-4">
        <!-- Quick Statistics -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-line"></i> Στατιστικά
                </h6>
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center mb-3">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Συνολικές Υπηρεσίες
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $statistics['total_services'] ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wrench fa-2x text-gray-300"></i>
                    </div>
                </div>

                <div class="row no-gutters align-items-center mb-3">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Ακουστικά Βαρηκοΐας
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $statistics['total_hearing_aids'] ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-assistive-listening-systems fa-2x text-gray-300"></i>
                    </div>
                </div>

                <div class="row no-gutters align-items-center mb-3">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Συνολικό Ποσό
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            €<?= number_format($statistics['total_spent'], 2) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                    </div>
                </div>

                <?php if ($statistics['last_service_date']): ?>
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Τελευταία Υπηρεσία
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?= date('d/m/Y', strtotime($statistics['last_service_date'])) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt"></i> Γρήγορες Ενέργειες
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-primary btn-block">
                        <i class="fas fa-plus"></i> Νέα Υπηρεσία
                    </a>
                    <a href="#" class="btn btn-success btn-block">
                        <i class="fas fa-assistive-listening-systems"></i> Νέο Ακουστικό
                    </a>
                    <a href="#" class="btn btn-info btn-block">
                        <i class="fas fa-file-invoice"></i> Νέο Τιμολόγιο
                    </a>
                    <a href="#" class="btn btn-warning btn-block">
                        <i class="fas fa-calendar-alt"></i> Προγραμματισμός Ραντεβού
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history"></i> Πρόσφατη Δραστηριότητα
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center text-muted">
                    <i class="fas fa-clock fa-3x mb-3"></i>
                    <p>Δεν υπάρχει πρόσφατη δραστηριότητα</p>
                    <small>Οι πρόσφατες υπηρεσίες και αλλαγές θα εμφανιστούν εδώ</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle"></i> Επιβεβαίωση Διαγραφής
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Είστε σίγουροι ότι θέλετε να διαγράψετε τον πελάτη:</p>
                <p class="font-weight-bold"><?= esc($customer['name']) ?></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Προσοχή:</strong> Ο πελάτης θα απενεργοποιηθεί αλλά τα δεδομένα του θα διατηρηθούν.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Άκυρο</button>
                <form id="deleteForm" method="POST" action="<?= base_url('customers/' . $customer['id']) ?>" style="display: inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Απενεργοποίηση
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    $('#deleteModal').modal('show');
}
</script>

<style>
.info-group {
    border-bottom: 1px solid #eaecf4;
    padding-bottom: 8px;
}

.info-label {
    font-weight: 600;
    color: #5a5c69;
    font-size: 0.85rem;
    text-transform: uppercase;
    margin-bottom: 2px;
    display: block;
}

.info-value {
    color: #3a3b45;
    font-size: 0.95rem;
    line-height: 1.4;
}

.badge-lg {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
}

.card-header h6 {
    margin-bottom: 0;
}

.btn-block {
    margin-bottom: 0.5rem;
}

.text-primary {
    color: #4e73df !important;
}

a.text-decoration-none:hover {
    text-decoration: underline !important;
}
</style>

<?php $this->endSection() ?>