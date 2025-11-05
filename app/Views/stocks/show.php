<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-boxes"></i>
                <?= $title ?>
            </h1>
            <p class="mb-0 text-gray-600"><?= $subtitle ?></p>
        </div>
        
        <div class="d-flex gap-2">
            <a href="<?= $edit_url ?>" class="btn btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> 
                Επεξεργασία
            </a>
            <a href="<?= $back_url ?>" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> 
                Επιστροφή
            </a>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <?php foreach ($breadcrumbs as $name => $url): ?>
                <?php if ($url): ?>
                    <li class="breadcrumb-item">
                        <a href="<?= $url ?>" class="text-decoration-none"><?= $name ?></a>
                    </li>
                <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page"><?= $name ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ol>
    </nav>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Stock Status Alert -->
    <?php if ($needs_restocking): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Ειδοποίηση Χαμηλού Αποθέματος!</strong>
            Αυτό το προϊόν χρειάζεται αναπλήρωση. Η τρέχουσα ποσότητα (<?= $stock['quantity'] ?>) είναι κάτω από το ελάχιστο όριο (<?= $stock['min_quantity'] ?>).
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($stock['quantity'] == 0): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle"></i>
            <strong>Εξαντλημένο Προϊόν!</strong>
            Αυτό το προϊόν έχει τελειώσει από την αποθήκη.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Main Product Information -->
        <div class="col-lg-8">
            <!-- Basic Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i>
                        Βασικές Πληροφορίες
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Όνομα:</th>
                                    <td><?= esc($stock['name']) ?></td>
                                </tr>
                                <tr>
                                    <th>Κατηγορία:</th>
                                    <td>
                                        <?php if (!empty($stock['category'])): ?>
                                            <span class="badge badge-primary"><?= esc($stock['category']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Κατασκευαστής:</th>
                                    <td><?= esc($stock['manufacturer']) ?: '<span class="text-muted">-</span>' ?></td>
                                </tr>
                                <tr>
                                    <th>SKU:</th>
                                    <td>
                                        <?php if (!empty($stock['sku'])): ?>
                                            <code><?= esc($stock['sku']) ?></code>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Barcode:</th>
                                    <td>
                                        <?php if (!empty($stock['barcode'])): ?>
                                            <code><?= esc($stock['barcode']) ?></code>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Τοποθεσία:</th>
                                    <td><?= esc($stock['location']) ?: '<span class="text-muted">-</span>' ?></td>
                                </tr>
                                <tr>
                                    <th>Κατάσταση:</th>
                                    <td>
                                        <?= $stock['is_active'] ? 
                                            '<span class="badge badge-success">Ενεργό</span>' : 
                                            '<span class="badge badge-secondary">Ανενεργό</span>' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>ID:</th>
                                    <td><code><?= $stock['id'] ?></code></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <?php if (!empty($stock['description'])): ?>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-dark">Περιγραφή:</h6>
                            <p class="text-muted mb-0"><?= nl2br(esc($stock['description'])) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Inventory Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-warehouse"></i>
                        Στοιχεία Αποθέματος
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateQuantityModal">
                        <i class="fas fa-edit"></i> Ενημέρωση Ποσότητας
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-primary mb-1">
                                    <?php if ($stock['quantity'] == 0): ?>
                                        <span class="text-danger"><?= $stock['quantity'] ?></span>
                                    <?php elseif ($needs_restocking): ?>
                                        <span class="text-warning"><?= $stock['quantity'] ?></span>
                                    <?php else: ?>
                                        <span class="text-success"><?= $stock['quantity'] ?></span>
                                    <?php endif; ?>
                                </h4>
                                <div class="text-xs font-weight-bold text-uppercase text-muted">
                                    Διαθέσιμα
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-info mb-1"><?= $stock['min_quantity'] ?: '0' ?></h4>
                                <div class="text-xs font-weight-bold text-uppercase text-muted">
                                    Ελάχιστη
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-secondary mb-1"><?= $stock['max_quantity'] ?: '∞' ?></h4>
                                <div class="text-xs font-weight-bold text-uppercase text-muted">
                                    Μέγιστη
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-success mb-1">€<?= number_format($total_value, 2) ?></h4>
                                <div class="text-xs font-weight-bold text-uppercase text-muted">
                                    Συνολική Αξία
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-euro-sign"></i>
                        Στοιχεία Τιμολόγησης
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-danger mb-1">
                                    €<?= $stock['cost_price'] > 0 ? number_format($stock['cost_price'], 2) : '0.00' ?>
                                </h4>
                                <div class="text-xs font-weight-bold text-uppercase text-muted">
                                    Τιμή Κόστους
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-success mb-1">
                                    €<?= $stock['unit_price'] > 0 ? number_format($stock['unit_price'], 2) : '0.00' ?>
                                </h4>
                                <div class="text-xs font-weight-bold text-uppercase text-muted">
                                    Τιμή Πώλησης
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="<?= $profit_margin > 0 ? 'text-success' : 'text-muted' ?> mb-1">
                                    <?= $profit_margin > 0 ? $profit_margin . '%' : 'N/A' ?>
                                </h4>
                                <div class="text-xs font-weight-bold text-uppercase text-muted">
                                    Περιθώριο Κέρδους
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Card -->
            <?php if (!empty($stock['notes'])): ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-sticky-note"></i>
                        Σημειώσεις
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= nl2br(esc($stock['notes'])) ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i>
                        Γρήγορες Ενέργειες
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= $edit_url ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Επεξεργασία Προϊόντος
                        </a>
                        <button type="button" class="btn btn-info btn-block" data-bs-toggle="modal" data-bs-target="#updateQuantityModal">
                            <i class="fas fa-plus-minus"></i> Ενημέρωση Ποσότητας
                        </button>
                        <?php if ($stock['is_active']): ?>
                        <button class="btn btn-secondary btn-block" onclick="toggleActive(<?= $stock['id'] ?>, false)">
                            <i class="fas fa-pause"></i> Απενεργοποίηση
                        </button>
                        <?php else: ?>
                        <button class="btn btn-success btn-block" onclick="toggleActive(<?= $stock['id'] ?>, true)">
                            <i class="fas fa-play"></i> Ενεργοποίηση
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Stock Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie"></i>
                        Κατάσταση Αποθέματος
                    </h6>
                </div>
                <div class="card-body text-center">
                    <?php if ($stock['quantity'] == 0): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                            <h5>Εξαντλημένο</h5>
                            <p class="mb-0">Δεν υπάρχουν διαθέσιμα τεμάχια</p>
                        </div>
                    <?php elseif ($needs_restocking): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h5>Χαμηλό Απόθεμα</h5>
                            <p class="mb-0">Χρειάζεται αναπλήρωση</p>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5>Επαρκές Απόθεμα</h5>
                            <p class="mb-0">Διαθέσιμο για πώληση</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Timestamps Card -->
            <?php if (isset($stock['created_at']) || isset($stock['updated_at'])): ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clock"></i>
                        Χρονικές Πληροφορίες
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($stock['created_at'])): ?>
                    <p class="mb-2">
                        <strong>Δημιουργήθηκε:</strong><br>
                        <small class="text-muted"><?= date('d/m/Y H:i:s', strtotime($stock['created_at'])) ?></small>
                    </p>
                    <?php endif; ?>
                    
                    <?php if (isset($stock['updated_at']) && $stock['updated_at'] != $stock['created_at']): ?>
                    <p class="mb-0">
                        <strong>Τελευταία ενημέρωση:</strong><br>
                        <small class="text-muted"><?= date('d/m/Y H:i:s', strtotime($stock['updated_at'])) ?></small>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Update Quantity Modal -->
<div class="modal fade" id="updateQuantityModal" tabindex="-1" aria-labelledby="updateQuantityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateQuantityModalLabel">
                    <i class="fas fa-edit"></i>
                    Ενημέρωση Ποσότητας
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateQuantityForm">
                    <div class="mb-3">
                        <label for="newQuantity" class="form-label">Νέα Ποσότητα</label>
                        <input type="number" class="form-control" id="newQuantity" name="quantity" 
                               value="<?= $stock['quantity'] ?>" min="0" required>
                        <div class="form-text">Τρέχουσα ποσότητα: <?= $stock['quantity'] ?></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label">Αιτιολογία Αλλαγής</label>
                        <select class="form-control" id="reason" name="reason">
                            <option value="Χειροκίνητη ενημέρωση">Χειροκίνητη ενημέρωση</option>
                            <option value="Νέα παραλαβή">Νέα παραλαβή</option>
                            <option value="Πώληση">Πώληση</option>
                            <option value="Επιστροφή">Επιστροφή</option>
                            <option value="Απώλεια/Βλάβη">Απώλεια/Βλάβη</option>
                            <option value="Διόρθωση αποθέματος">Διόρθωση αποθέματος</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Ακύρωση
                </button>
                <button type="button" class="btn btn-primary" id="confirmQuantityUpdate">
                    <i class="fas fa-save"></i> Ενημέρωση
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Update quantity functionality
    $('#confirmQuantityUpdate').click(function() {
        const newQuantity = $('#newQuantity').val();
        const reason = $('#reason').val();
        
        if (!newQuantity || newQuantity < 0) {
            alert('Παρακαλώ εισάγετε έγκυρη ποσότητα');
            return;
        }
        
        // Show loading state
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Ενημέρωση...');
        
        $.ajax({
            url: '<?= $quantity_update_url ?>',
            type: 'POST',
            data: {
                quantity: newQuantity,
                reason: reason
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    $('#updateQuantityModal').modal('hide');
                    showAlert('success', response.message);
                    
                    // Reload page after 1 second
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert('error', response.message || 'Σφάλμα ενημέρωσης ποσότητας');
                }
            },
            error: function(xhr) {
                let message = 'Σφάλμα ενημέρωσης ποσότητας';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showAlert('error', message);
            },
            complete: function() {
                $('#confirmQuantityUpdate').prop('disabled', false)
                                          .html('<i class="fas fa-save"></i> Ενημέρωση');
            }
        });
    });
    
    // Alert function
    function showAlert(type, message) {
        const alertType = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
        
        const alert = `
            <div class="alert ${alertType} alert-dismissible fade show" role="alert">
                <i class="${icon}"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').not('.alert:has(.btn-close)').remove();
        
        // Add new alert at the top of the container
        $('.container-fluid').prepend(alert);
        
        // Auto hide after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
    
    // Make showAlert globally available
    window.showAlert = showAlert;
});

// Toggle active status function
function toggleActive(id, status) {
    const action = status ? 'ενεργοποίηση' : 'απενεργοποίηση';
    
    if (confirm(`Είστε σίγουρος ότι θέλετε την ${action} αυτού του προϊόντος;`)) {
        // This would need a separate endpoint - placeholder for now
        showAlert('info', 'Η λειτουργία θα υλοποιηθεί σύντομα');
    }
}
</script>

<style>
/* Custom styling for product details */
.table-borderless th {
    font-weight: 600;
    color: #5a5c69;
    padding: 0.5rem 0;
    border: none;
}

.table-borderless td {
    padding: 0.5rem 0;
    border: none;
}

/* Status badges */
.badge-primary { background-color: #4e73df; }
.badge-success { background-color: #1cc88a; }
.badge-secondary { background-color: #858796; }

/* Quantity display colors */
.text-danger { color: #e74a3b !important; }
.text-warning { color: #f6c23e !important; }
.text-success { color: #1cc88a !important; }

/* Code styling */
code {
    color: #e74a3b;
    background-color: #f8f9fc;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
}

/* Alert customizations */
.alert {
    border: none;
    border-radius: 0.5rem;
}

/* Card hover effects */
.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s;
}

/* Button styling */
.btn-block {
    width: 100%;
    margin-bottom: 0.5rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .col-md-3, .col-md-4 {
        margin-bottom: 1rem;
    }
}

/* Modal styling */
.modal-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.modal-footer {
    background-color: #f8f9fc;
    border-top: 1px solid #e3e6f0;
}

/* Status icons sizing */
.fa-3x {
    font-size: 3em;
}

/* Border utilities */
.border {
    border: 1px solid #e3e6f0 !important;
}

.rounded {
    border-radius: 0.375rem !important;
}
</style>