<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-plus"></i> <?= esc($title) ?>
    </h1>
    <a href="<?= esc($cancelUrl) ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Επιστροφή
    </a>
</div>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= site_url('/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= esc($cancelUrl) ?>"><?= ucfirst($tableName ?? 'Λίστα') ?></a></li>
        <li class="breadcrumb-item active">Δημιουργία</li>
    </ol>
</nav>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Validation Errors -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6><i class="fas fa-exclamation-triangle"></i> Σφάλματα Επικύρωσης:</h6>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Create Form Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-edit"></i> Στοιχεία Εγγραφής
        </h6>
    </div>
    <div class="card-body">
        <?= form_open($formAction, ['class' => 'needs-validation', 'novalidate' => true]) ?>
            
            <?= $this->renderSection('form_fields') ?>
            
            <!-- Submit Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="<?= esc($cancelUrl) ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Ακύρωση
                        </a>
                        <div>
                            <button type="reset" class="btn btn-warning mr-2">
                                <i class="fas fa-undo"></i> Επαναφορά
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Αποθήκευση
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
        <?= form_close() ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Bootstrap form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Date picker initialization (if jQuery UI is available)
    if (typeof $.datepicker !== 'undefined') {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            language: 'el'
        });
    }

    // Phone number formatting
    $('.phone-input').on('input', function() {
        var value = $(this).val().replace(/\D/g, '');
        if (value.length <= 10) {
            $(this).val(value);
        }
    });

    // Auto-focus first input
    $('input:not([type=hidden]):first').focus();

    // Confirm form reset
    $('button[type="reset"]').click(function(e) {
        if (!confirm('Είστε σίγουροι ότι θέλετε να επαναφέρετε τη φόρμα;')) {
            e.preventDefault();
        }
    });
    
    // Form submission loading state
    $('form').on('submit', function() {
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true)
                 .html('<i class="fas fa-spinner fa-spin"></i> Αποθήκευση...');
        
        // Re-enable button after 10 seconds (fallback)
        setTimeout(function() {
            submitBtn.prop('disabled', false).html(originalText);
        }, 10000);
    });
});
</script>

<?= $this->endSection() ?>