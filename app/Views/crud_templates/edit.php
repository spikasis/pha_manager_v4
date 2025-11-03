<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit"></i> <?= esc($title) ?>
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
        <li class="breadcrumb-item active">Επεξεργασία</li>
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

<!-- Edit Form Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-edit"></i> Επεξεργασία Στοιχείων
        </h6>
        <small class="text-muted">
            ID: <?= isset($formData['id']) ? $formData['id'] : 'N/A' ?>
        </small>
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
                                <i class="fas fa-save"></i> Ενημέρωση
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
        <?= form_close() ?>
    </div>
</div>

<!-- Change History Card (Optional) -->
<?php if (isset($showHistory) && $showHistory): ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            <i class="fas fa-history"></i> Ιστορικό Αλλαγών
        </h6>
    </div>
    <div class="card-body">
        <?= $this->renderSection('change_history') ?>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Store original form data for change detection
    var originalData = $('form').serialize();
    var hasChanges = false;
    
    // Detect form changes
    $('form input, form select, form textarea').on('change input', function() {
        var currentData = $('form').serialize();
        hasChanges = (originalData !== currentData);
        
        // Update reset button state
        $('button[type="reset"]').prop('disabled', !hasChanges);
        
        // Add visual indicator for changed fields
        $(this).addClass('changed-field');
    });

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

    // Warn before leaving if there are unsaved changes
    $(window).on('beforeunload', function() {
        if (hasChanges) {
            return 'Έχετε μη αποθηκευμένες αλλαγές. Είστε σίγουροι ότι θέλετε να αποχωρήσετε;';
        }
    });

    // Date picker initialization
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

    // Confirm form reset
    $('button[type="reset"]').click(function(e) {
        if (!confirm('Είστε σίγουροι ότι θέλετε να επαναφέρετε τις αλλαγές;')) {
            e.preventDefault();
            return false;
        }
        
        // Reset change detection
        hasChanges = false;
        $('.changed-field').removeClass('changed-field');
        $(this).prop('disabled', true);
    });
    
    // Form submission
    $('form').on('submit', function() {
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true)
                 .html('<i class="fas fa-spinner fa-spin"></i> Ενημέρωση...');
        
        // Disable beforeunload warning
        hasChanges = false;
        
        // Re-enable button after 10 seconds (fallback)
        setTimeout(function() {
            submitBtn.prop('disabled', false).html(originalText);
        }, 10000);
    });
    
    // Auto-save feature (optional)
    <?php if (isset($enableAutoSave) && $enableAutoSave): ?>
    var autoSaveTimer;
    $('form input, form select, form textarea').on('change input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            autoSave();
        }, 30000); // Auto-save after 30 seconds of inactivity
    });
    
    function autoSave() {
        if (!hasChanges) return;
        
        var formData = $('form').serialize();
        $.ajax({
            url: '<?= $formAction ?>',
            type: 'POST',
            data: formData + '&auto_save=1',
            success: function() {
                showNotification('Αυτόματη αποθήκευση επιτυχής', 'info');
                hasChanges = false;
            }
        });
    }
    <?php endif; ?>
    
    // Show notification function
    function showNotification(message, type) {
        var alertClass = 'alert-' + (type || 'info');
        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show auto-save-alert" role="alert">' +
            message +
            '<button type="button" class="close" data-dismiss="alert">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>';
        
        $('.card').first().before(alertHtml);
        
        setTimeout(function() {
            $('.auto-save-alert').fadeOut();
        }, 3000);
    }
});
</script>

<!-- CSS for changed fields indication -->
<style>
.changed-field {
    border-left: 3px solid #28a745 !important;
    background-color: #f8fff9 !important;
}
</style>

<?= $this->endSection() ?>