<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-eye"></i> <?= esc($title) ?>
    </h1>
    <div>
        <a href="<?= esc($editUrl) ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-edit fa-sm text-white-50"></i> Επεξεργασία
        </a>
        <a href="<?= esc($backUrl) ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Επιστροφή
        </a>
    </div>
</div>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= site_url('/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= esc($backUrl) ?>"><?= ucfirst($tableName ?? 'Λίστα') ?></a></li>
        <li class="breadcrumb-item active">Προβολή</li>
    </ol>
</nav>

<!-- Record Details Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-info-circle"></i> Στοιχεία Εγγραφής
        </h6>
        <div>
            <small class="text-muted">
                ID: <?= isset($record['id']) ? $record['id'] : 'N/A' ?>
            </small>
            <?php if (isset($record['created_at'])): ?>
                <small class="text-muted ml-3">
                    Δημιουργήθηκε: <?= date('d/m/Y H:i', strtotime($record['created_at'])) ?>
                </small>
            <?php endif; ?>
            <?php if (isset($record['updated_at'])): ?>
                <small class="text-muted ml-3">
                    Τελευταία Ενημέρωση: <?= date('d/m/Y H:i', strtotime($record['updated_at'])) ?>
                </small>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <?= $this->renderSection('record_details') ?>
    </div>
</div>

<!-- Action Buttons -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="<?= esc($backUrl) ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Επιστροφή στη Λίστα
                </a>
            </div>
            <div>
                <a href="<?= esc($editUrl) ?>" class="btn btn-warning mr-2">
                    <i class="fas fa-edit"></i> Επεξεργασία
                </a>
                <button type="button" class="btn btn-info mr-2" onclick="printRecord()">
                    <i class="fas fa-print"></i> Εκτύπωση
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $record['id'] ?? 0 ?>)">
                    <i class="fas fa-trash"></i> Διαγραφή
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Related Records Section (Optional) -->
<?php if (isset($showRelated) && $showRelated): ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            <i class="fas fa-link"></i> Σχετικές Εγγραφές
        </h6>
    </div>
    <div class="card-body">
        <?= $this->renderSection('related_records') ?>
    </div>
</div>
<?php endif; ?>

<!-- Activity Log Section (Optional) -->
<?php if (isset($showActivityLog) && $showActivityLog): ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">
            <i class="fas fa-history"></i> Ιστορικό Δραστηριοτήτων
        </h6>
    </div>
    <div class="card-body">
        <?= $this->renderSection('activity_log') ?>
    </div>
</div>
<?php endif; ?>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Επιβεβαίωση Διαγραφής
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Είστε σίγουροι ότι θέλετε να διαγράψετε αυτήν την εγγραφή;</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Προσοχή:</strong> Αυτή η ενέργεια δεν μπορεί να αναιρεθεί!
                </div>
                <?= $this->renderSection('delete_warning') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Ακύρωση
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash"></i> Οριστική Διαγραφή
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var deleteId = null;
    
    // Delete confirmation
    window.confirmDelete = function(id) {
        deleteId = id;
        $('#deleteModal').modal('show');
    };
    
    $('#confirmDeleteBtn').click(function() {
        if (deleteId) {
            var btn = $(this);
            var originalText = btn.html();
            
            btn.prop('disabled', true)
               .html('<i class="fas fa-spinner fa-spin"></i> Διαγραφή...');
            
            $.ajax({
                url: "<?= site_url($viewPath ?? '') ?>delete/" + deleteId,
                type: 'POST',
                data: {
                    <?= csrf_token() ?>: "<?= csrf_hash() ?>"
                },
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    
                    if (response.success) {
                        // Show success message and redirect
                        showAlert('success', response.message);
                        setTimeout(function() {
                            window.location.href = "<?= esc($backUrl) ?>";
                        }, 2000);
                    } else {
                        // Show error message
                        showAlert('error', response.message);
                        btn.prop('disabled', false).html(originalText);
                    }
                },
                error: function() {
                    $('#deleteModal').modal('hide');
                    showAlert('error', 'Σφάλμα κατά τη διαγραφή της εγγραφής!');
                    btn.prop('disabled', false).html(originalText);
                }
            });
        }
    });
    
    // Print function
    window.printRecord = function() {
        // Hide action buttons and navigation for printing
        var printCSS = `
            <style type="text/css">
                @media print {
                    .no-print { display: none !important; }
                    .card { border: 1px solid #ddd; box-shadow: none; }
                    .card-header { background-color: #f8f9fa !important; }
                    body { font-size: 12pt; }
                }
            </style>
        `;
        
        // Clone the content
        var printContent = $('body').clone();
        
        // Remove no-print elements
        printContent.find('.btn, .breadcrumb, nav, .modal').addClass('no-print');
        
        // Create a new window for printing
        var printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Εκτύπωση - <?= esc($title) ?></title>
                <link href="<?= base_url('public/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
                <link href="<?= base_url('public/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
                ${printCSS}
            </head>
            <body>
                ${printContent.html()}
            </body>
            </html>
        `);
        
        printWindow.document.close();
        
        // Wait for content to load and then print
        printWindow.onload = function() {
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500);
        };
    };
    
    // Export functions
    window.exportToExcel = function() {
        // Implementation for Excel export
        showAlert('info', 'Η λειτουργία εξαγωγής σε Excel θα υλοποιηθεί σύντομα.');
    };
    
    window.exportToPDF = function() {
        // Implementation for PDF export
        showAlert('info', 'Η λειτουργία εξαγωγής σε PDF θα υλοποιηθεί σύντομα.');
    };
    
    // Keyboard shortcuts
    $(document).keydown(function(e) {
        // Ctrl+E for Edit
        if (e.ctrlKey && e.keyCode === 69) {
            e.preventDefault();
            window.location.href = "<?= esc($editUrl) ?>";
        }
        
        // Ctrl+P for Print
        if (e.ctrlKey && e.keyCode === 80) {
            e.preventDefault();
            printRecord();
        }
        
        // Escape to go back
        if (e.keyCode === 27) {
            window.location.href = "<?= esc($backUrl) ?>";
        }
    });
    
    // Show alert function
    function showAlert(type, message) {
        var alertClass = type === 'success' ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-info');
        var icon = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle');
        
        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
            '<i class="fas ' + icon + '"></i> ' + message +
            '<button type="button" class="close" data-dismiss="alert">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>';
        
        $('.card').first().before(alertHtml);
        
        // Auto-hide after 5 seconds for info messages
        if (type === 'info') {
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        }
    }
    
    // Tooltip initialization
    $('[data-toggle="tooltip"]').tooltip();
    
    // Enhanced navigation with browser history
    if (window.history && window.history.pushState) {
        $(document).on('click', 'a[href*="edit"], a[href*="show"]', function(e) {
            var href = $(this).attr('href');
            if (href && !e.ctrlKey && !e.metaKey) {
                window.history.pushState({}, '', href);
            }
        });
    }
});
</script>

<!-- CSS for print styles -->
<style>
.record-field {
    margin-bottom: 1rem;
}

.record-field .label {
    font-weight: bold;
    color: #5a5c69;
    margin-bottom: 0.25rem;
}

.record-field .value {
    padding: 0.5rem;
    background-color: #f8f9fa;
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
}

.record-field .value.empty {
    color: #6c757d;
    font-style: italic;
}

@media print {
    .no-print {
        display: none !important;
    }
    
    .card {
        border: 1px solid #ddd;
        box-shadow: none;
        page-break-inside: avoid;
    }
    
    .card-header {
        background-color: #f8f9fa !important;
        color: #000 !important;
    }
}
</style>

<?= $this->endSection() ?>