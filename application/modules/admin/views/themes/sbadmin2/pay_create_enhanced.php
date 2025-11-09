<?php
$preset_customer_id = $this->input->get('customer_id');
$preset_hearing_aid_id = $this->input->get('hearing_aid_id');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-money-bill-wave text-success"></i> 
            <?= $preset_customer_id ? 'Νέα Πληρωμή Πελάτη' : 'Νέα Πληρωμή' ?>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Αρχική</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/pays') ?>">Πληρωμές</a></li>
            <li class="breadcrumb-item active">Νέα Πληρωμή</li>
        </ol>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Payment Form Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Στοιχεία Πληρωμής
                    </h6>
                    <?php if ($preset_customer_id): ?>
                    <span class="badge badge-info">
                        <i class="fas fa-link"></i> Συνδεδεμένη με πελάτη
                    </span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= base_url('admin/pays/create') ?>" id="paymentForm">
                        
                        <!-- Customer Selection -->
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">
                                <i class="fas fa-user"></i> Πελάτης *
                            </label>
                            <select class="form-control form-control-lg <?= $preset_customer_id ? 'border-info' : '' ?>" 
                                    id="customer" name="customer" required>
                                <option value="">-- Επιλέξτε Πελάτη --</option>
                                <?php if (count($customers)): ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <option value="<?= $customer['id'] ?>" 
                                                <?= ($preset_customer_id && $preset_customer_id == $customer['id']) ? 'selected' : '' ?>>
                                            <?= $customer['name'] ?> (ID: <?= $customer['id'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <?php if ($preset_customer_id): ?>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Επιλεγμένος από καρτέλα πελάτη
                                </small>
                            <?php endif; ?>
                        </div>

                        <!-- Hearing Aid Selection -->
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">
                                <i class="fas fa-headphones"></i> Ακουστικό (Προαιρετικό)
                            </label>
                            <select class="form-control <?= $preset_hearing_aid_id ? 'border-info' : '' ?>" 
                                    id="hearing_aid" name="hearing_aid">
                                <option value="">-- Γενική Πληρωμή (χωρίς ακουστικό) --</option>
                                <?php if (count($stock)): ?>
                                    <?php foreach ($stock as $stocks): ?>
                                        <option value="<?= $stocks['id'] ?>" 
                                                <?= ($preset_hearing_aid_id && $preset_hearing_aid_id == $stocks['id']) ? 'selected' : '' ?>>
                                            <?= $stocks['serial'] ?> - <?= $stocks['model'] ?> - <?= $stocks['type'] ?>
                                            (€<?= number_format($stocks['ha_price'], 2) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-lightbulb"></i> Αν δεν επιλέξετε ακουστικό, η πληρωμή θα καταχωρηθεί ως γενική
                            </small>
                        </div>

                        <!-- Date Selection -->
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">
                                <i class="fas fa-calendar-alt"></i> Ημερομηνία Πληρωμής *
                            </label>
                            <input type="date" class="form-control form-control-lg" 
                                   id="date" name="date" value="<?= date('Y-m-d') ?>" required>
                            <small class="form-text text-muted">
                                <i class="fas fa-clock"></i> Προεπιλογή: Σημερινή ημερομηνία
                            </small>
                        </div>

                        <!-- Payment Amount -->
                        <div class="form-group">
                            <label class="font-weight-bold text-primary">
                                <i class="fas fa-euro-sign"></i> Ποσό Πληρωμής *
                            </label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="fas fa-euro-sign"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" id="pay" name="pay" 
                                       placeholder="0.00" step="0.01" min="0" required>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-calculator"></i> Εισάγετε το ποσό με δεκαδικά (π.χ. 150.50)
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                <i class="fas fa-arrow-left"></i> Ακύρωση
                            </button>
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-undo"></i> Επαναφορά
                            </button>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Καταχώρηση Πληρωμής
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Help Card -->
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-question-circle"></i> Οδηγίες
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-info mb-3">
                        <i class="fas fa-info-circle"></i> <strong>Τρόπος Χρήσης:</strong>
                    </div>
                    
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            <strong>Πελάτης:</strong> Υποχρεωτική επιλογή
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            <strong>Ακουστικό:</strong> Προαιρετικό για συγκεκριμένη συσκευή
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            <strong>Ημερομηνία:</strong> Μπορεί να είναι παλαιότερη
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            <strong>Ποσό:</strong> Δεκαδικά με τελεία (.)
                        </li>
                    </ul>

                    <div class="alert alert-warning alert-sm mt-3">
                        <i class="fas fa-exclamation-triangle"></i>
                        <small>Οι πληρωμές επηρεάζουν άμεσα τα χρέη των πελατών</small>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Γρήγορες Ενέργειες
                    </h6>
                </div>
                <div class="card-body">
                    <a href="<?= base_url('admin/pays') ?>" class="btn btn-outline-primary btn-block mb-2">
                        <i class="fas fa-list"></i> Προβολή Όλων των Πληρωμών
                    </a>
                    <a href="<?= base_url('admin/pays/debt_list') ?>" class="btn btn-outline-danger btn-block mb-2">
                        <i class="fas fa-exclamation-triangle"></i> Λίστα Χρεών
                    </a>
                    <a href="<?= base_url('admin/customers') ?>" class="btn btn-outline-info btn-block">
                        <i class="fas fa-users"></i> Επιστροφή στους Πελάτες
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
$(document).ready(function() {
    // Enhanced form validation
    $('#paymentForm').on('submit', function(e) {
        var pay = parseFloat($('#pay').val());
        if (pay <= 0) {
            e.preventDefault();
            alert('Το ποσό πληρωμής πρέπει να είναι μεγαλύτερο από 0!');
            $('#pay').focus();
            return false;
        }
    });

    // Auto-format payment amount
    $('#pay').on('blur', function() {
        var val = parseFloat($(this).val());
        if (!isNaN(val)) {
            $(this).val(val.toFixed(2));
        }
    });

    // Enhanced customer search
    $('#customer').select2({
        placeholder: "Αναζήτηση πελάτη...",
        allowClear: true,
        width: '100%'
    });

    // Enhanced hearing aid search
    $('#hearing_aid').select2({
        placeholder: "Αναζήτηση ακουστικού...",
        allowClear: true,
        width: '100%'
    });
});
</script>