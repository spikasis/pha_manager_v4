<?php $this->extend('templates/header') ?>

<?php $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-users"></i> Διαχείριση Πελατών
    </h1>
    <a href="<?= base_url('customers/create') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Νέος Πελάτης
    </a>
</div>

<!-- Search and Filter Row -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-search"></i> Αναζήτηση & Φιλτράρισμα
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="<?= current_url() ?>">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Αναζήτηση:</label>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="<?= esc($search ?? '') ?>" 
                               placeholder="Όνομα, τηλέφωνο, email...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="city">Πόλη:</label>
                        <select class="form-control" id="city" name="city">
                            <option value="">Όλες οι πόλεις</option>
                            <?php if (isset($cities)): ?>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?= esc($city) ?>" 
                                            <?= ($filters['city'] ?? '') === $city ? 'selected' : '' ?>>
                                        <?= esc($city) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Κατάσταση:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Όλες</option>
                            <option value="1" <?= ($filters['status'] ?? '') === '1' ? 'selected' : '' ?>>Ενεργός</option>
                            <option value="0" <?= ($filters['status'] ?? '') === '0' ? 'selected' : '' ?>>Ανενεργός</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="doctor_id">Γιατρός:</label>
                        <select class="form-control" id="doctor_id" name="doctor_id">
                            <option value="">Όλοι οι γιατροί</option>
                            <?php if (isset($doctors)): ?>
                                <?php foreach ($doctors as $doctor): ?>
                                    <option value="<?= $doctor['id'] ?>" 
                                            <?= ($filters['doctor_id'] ?? '') == $doctor['id'] ? 'selected' : '' ?>>
                                        <?= esc($doctor['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Αναζήτηση
                            </button>
                            <a href="<?= base_url('customers') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Καθαρισμός
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Συνολικοί Πελάτες</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= number_format($stats['total'] ?? 0) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Ενεργοί Πελάτες</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= number_format($stats['active'] ?? 0) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Με Οφειλές</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= number_format($stats['with_debt'] ?? 0) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Νέοι (30 ημέρες)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= number_format($stats['new_customers'] ?? 0) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customers Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Λίστα Πελατών
            <?php if (isset($pager)): ?>
                <span class="badge badge-secondary ml-2">
                    <?= $pager->getDetails()['start'] ?>-<?= $pager->getDetails()['end'] ?> από <?= $pager->getDetails()['total'] ?>
                </span>
            <?php endif; ?>
        </h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Εξαγωγή δεδομένων:</div>
                <a class="dropdown-item" href="<?= current_url() ?>?export=excel">
                    <i class="fas fa-file-excel fa-sm fa-fw mr-2 text-gray-400"></i>
                    Excel
                </a>
                <a class="dropdown-item" href="<?= current_url() ?>?export=pdf">
                    <i class="fas fa-file-pdf fa-sm fa-fw mr-2 text-gray-400"></i>
                    PDF
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($customers)): ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-500">Δεν βρέθηκαν πελάτες</h5>
                <p class="text-gray-400">Δοκιμάστε να αλλάξετε τα κριτήρια αναζήτησης ή προσθέστε έναν νέο πελάτη.</p>
                <a href="<?= base_url('customers/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Προσθήκη Πελάτη
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="customersTable">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Όνομα</th>
                            <th>Τηλέφωνο</th>
                            <th>Email</th>
                            <th>Πόλη</th>
                            <th>Κατάσταση</th>
                            <th>Γιατρός</th>
                            <th>Τελευταία Επίσκεψη</th>
                            <th class="text-center">Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?= esc($customer['id']) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm mr-2">
                                            <div class="avatar-initial rounded-circle bg-primary">
                                                <?= strtoupper(substr($customer['name'], 0, 1)) ?>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="<?= base_url('customers/' . $customer['id']) ?>" 
                                               class="font-weight-bold text-decoration-none">
                                                <?= esc($customer['name']) ?>
                                            </a>
                                            <?php if (!empty($customer['father_name'])): ?>
                                                <br><small class="text-muted">του <?= esc($customer['father_name']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($customer['phone_mobile'])): ?>
                                        <a href="tel:<?= esc($customer['phone_mobile']) ?>" class="text-decoration-none">
                                            <i class="fas fa-mobile-alt text-primary"></i>
                                            <?= esc($customer['phone_mobile']) ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($customer['phone_landline'])): ?>
                                        <br><a href="tel:<?= esc($customer['phone_landline']) ?>" class="text-decoration-none text-muted">
                                            <i class="fas fa-phone"></i>
                                            <?= esc($customer['phone_landline']) ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($customer['email'])): ?>
                                        <a href="mailto:<?= esc($customer['email']) ?>" class="text-decoration-none">
                                            <i class="fas fa-envelope text-primary"></i>
                                            <?= esc($customer['email']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($customer['city'] ?? '-') ?></td>
                                <td>
                                    <?php if ($customer['status'] == 1): ?>
                                        <span class="badge badge-success">Ενεργός</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Ανενεργός</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($customer['doctor_name'])): ?>
                                        <span class="text-primary">
                                            <i class="fas fa-user-md"></i>
                                            <?= esc($customer['doctor_name']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($customer['last_visit'])): ?>
                                        <span class="text-muted">
                                            <i class="fas fa-calendar"></i>
                                            <?= date('d/m/Y', strtotime($customer['last_visit'])) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('customers/' . $customer['id']) ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Προβολή">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('customers/' . $customer['id'] . '/edit') ?>" 
                                           class="btn btn-sm btn-outline-success" 
                                           title="Επεξεργασία">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Διαγραφή"
                                                onclick="confirmDelete(<?= $customer['id'] ?>, '<?= esc($customer['name']) ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (isset($pager)): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
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
                <p class="font-weight-bold" id="customerToDelete"></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Προσοχή:</strong> Αυτή η ενέργεια δεν μπορεί να αναιρεθεί!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Άκυρο</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Διαγραφή
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(customerId, customerName) {
    $('#customerToDelete').text(customerName);
    $('#deleteForm').attr('action', '<?= base_url('customers') ?>/' + customerId);
    $('#deleteModal').modal('show');
}

// Auto-submit search form on filter change
$(document).ready(function() {
    $('#city, #status, #doctor_id').change(function() {
        $(this).closest('form').submit();
    });
});
</script>

<style>
.avatar {
    width: 2.5rem;
    height: 2.5rem;
}
.avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
}
.table th {
    border-top: none;
}
.btn-group .btn {
    border-radius: 0.25rem;
    margin-right: 2px;
}
</style>

<?php $this->endSection() ?>