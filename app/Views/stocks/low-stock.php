<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-exclamation-triangle text-warning"></i>
                <?= $title ?>
            </h1>
            <p class="mb-0 text-gray-600"><?= $subtitle ?></p>
        </div>
        
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-info shadow-sm">
                <i class="fas fa-print fa-sm text-white-50"></i> 
                Εκτύπωση
            </button>
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

    <!-- Summary Card -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Προϊόντα Χαμηλού Αποθέματος
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count($low_stock_items) ?>
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
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Εξαντλημένα Προϊόντα
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $out_of_stock = 0;
                                foreach ($low_stock_items as $item) {
                                    if ($item['quantity'] == 0) $out_of_stock++;
                                }
                                echo $out_of_stock;
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
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
                                Άμεση Προτεραιότητα
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $critical = 0;
                                foreach ($low_stock_items as $item) {
                                    if ($item['quantity'] <= ($item['min_quantity'] * 0.5)) $critical++;
                                }
                                echo $critical;
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fire fa-2x text-gray-300"></i>
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
                                Ημερομηνία Αναφοράς
                            </div>
                            <div class="text-xs mb-0 font-weight-bold text-gray-800">
                                <?= date('d/m/Y H:i') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <?php if (empty($low_stock_items)): ?>
        <!-- No Low Stock Items -->
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                <h3 class="text-success">Εξαιρετικά!</h3>
                <p class="text-muted mb-0">
                    Δεν υπάρχουν προϊόντα με χαμηλό απόθεμα αυτή τη στιγμή.<br>
                    Όλα τα προϊόντα βρίσκονται πάνω από τα ελάχιστα όρια αποθέματος.
                </p>
            </div>
        </div>
    <?php else: ?>
        <!-- Low Stock Items Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table"></i>
                    Προϊόντα που Χρειάζονται Αναπλήρωση
                </h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                         aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Εξαγωγή:</div>
                        <a class="dropdown-item" href="#" onclick="exportToCSV()">
                            <i class="fas fa-file-csv fa-sm fa-fw mr-2 text-gray-400"></i>
                            Εξαγωγή CSV
                        </a>
                        <a class="dropdown-item" href="#" onclick="window.print()">
                            <i class="fas fa-print fa-sm fa-fw mr-2 text-gray-400"></i>
                            Εκτύπωση
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="lowStockTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Όνομα Προϊόντος</th>
                                <th>Τρέχουσα Ποσότητα</th>
                                <th>Ελάχιστη Ποσότητα</th>
                                <th>Διαφορά</th>
                                <th>Τοποθεσία</th>
                                <th>Προτεραιότητα</th>
                                <th class="no-print">Ενέργειες</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($low_stock_items as $item): ?>
                                <?php 
                                $difference = $item['quantity'] - $item['min_quantity'];
                                $priority = 'Κανονική';
                                $priorityClass = 'badge-warning';
                                
                                if ($item['quantity'] == 0) {
                                    $priority = 'Κρίσιμη';
                                    $priorityClass = 'badge-danger';
                                } elseif ($item['quantity'] <= ($item['min_quantity'] * 0.5)) {
                                    $priority = 'Υψηλή';
                                    $priorityClass = 'badge-danger';
                                } elseif ($difference >= -2) {
                                    $priority = 'Μέτρια';
                                    $priorityClass = 'badge-info';
                                }
                                ?>
                                <tr class="<?= $item['quantity'] == 0 ? 'table-danger' : 'table-warning' ?>">
                                    <td><?= $item['id'] ?></td>
                                    <td>
                                        <strong><?= esc($item['name']) ?></strong>
                                        <?php if ($item['quantity'] == 0): ?>
                                            <br><small class="text-danger"><i class="fas fa-times-circle"></i> Εξαντλημένο</small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= $item['quantity'] == 0 ? 'badge-danger' : 'badge-warning' ?>">
                                            <?= $item['quantity'] ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info"><?= $item['min_quantity'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-secondary"><?= $difference ?></span>
                                    </td>
                                    <td><?= esc($item['location']) ?: '<span class="text-muted">-</span>' ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $priorityClass ?>"><?= $priority ?></span>
                                    </td>
                                    <td class="text-center no-print">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= site_url('stocks/show/' . $item['id']) ?>" 
                                               class="btn btn-info" title="Προβολή">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('stocks/edit/' . $item['id']) ?>" 
                                               class="btn btn-warning" title="Επεξεργασία">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-success update-quantity-btn" 
                                                    data-id="<?= $item['id'] ?>" 
                                                    data-name="<?= esc($item['name']) ?>" 
                                                    data-current="<?= $item['quantity'] ?>"
                                                    data-min="<?= $item['min_quantity'] ?>"
                                                    title="Ενημέρωση Ποσότητας">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="card shadow mb-4 no-print">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt"></i>
                    Γρήγορες Ενέργειες
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-warning btn-block" onclick="updateAllCritical()">
                            <i class="fas fa-fire"></i> Ενημέρωση Κρίσιμων
                        </button>
                        <small class="text-muted">Ενημέρωση όλων των εξαντλημένων προϊόντων</small>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-info btn-block" onclick="generateOrderList()">
                            <i class="fas fa-shopping-cart"></i> Λίστα Παραγγελιών
                        </button>
                        <small class="text-muted">Δημιουργία λίστας προς παραγγελία</small>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success btn-block" onclick="markAllReviewed()">
                            <i class="fas fa-check"></i> Σημείωση Ελέγχου
                        </button>
                        <small class="text-muted">Σημείωση ότι ελέγχθηκαν όλα τα προϊόντα</small>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Update Quantity Modal -->
<div class="modal fade" id="quickUpdateModal" tabindex="-1" aria-labelledby="quickUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickUpdateModalLabel">
                    <i class="fas fa-plus"></i>
                    Γρήγορη Ενημέρωση Ποσότητας
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong id="productName"></strong><br>
                    <small>Τρέχουσα ποσότητα: <span id="currentQuantity"></span> | Ελάχιστη: <span id="minQuantity"></span></small>
                </div>
                
                <form id="quickUpdateForm">
                    <input type="hidden" id="productId" name="product_id">
                    
                    <div class="mb-3">
                        <label for="addQuantity" class="form-label">Ποσότητα προς προσθήκη</label>
                        <input type="number" class="form-control" id="addQuantity" name="add_quantity" 
                               min="1" value="10" required>
                        <div class="form-text">Η ποσότητα θα προστεθεί στην υπάρχουσα</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="quickReason" class="form-label">Αιτιολογία</label>
                        <select class="form-control" id="quickReason" name="reason">
                            <option value="Αναπλήρωση αποθέματος">Αναπλήρωση αποθέματος</option>
                            <option value="Νέα παραλαβή">Νέα παραλαβή</option>
                            <option value="Διόρθωση χαμηλού αποθέματος">Διόρθωση χαμηλού αποθέματος</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-success" id="newQuantityPreview" style="display: none;">
                        <strong>Νέα ποσότητα:</strong> <span id="previewQuantity"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Ακύρωση
                </button>
                <button type="button" class="btn btn-success" id="confirmQuickUpdate">
                    <i class="fas fa-plus"></i> Προσθήκη
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#lowStockTable').DataTable({
        order: [[6, 'desc'], [2, 'asc']], // Sort by priority first, then quantity
        pageLength: 50,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/el.json'
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Αντιγραφή',
                className: 'btn btn-secondary btn-sm'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-secondary btn-sm'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Εκτύπωση',
                className: 'btn btn-secondary btn-sm'
            }
        ],
        responsive: true
    });
    
    // Quick update quantity functionality
    $(document).on('click', '.update-quantity-btn', function() {
        const productId = $(this).data('id');
        const productName = $(this).data('name');
        const currentQuantity = $(this).data('current');
        const minQuantity = $(this).data('min');
        
        $('#productId').val(productId);
        $('#productName').text(productName);
        $('#currentQuantity').text(currentQuantity);
        $('#minQuantity').text(minQuantity);
        $('#addQuantity').val(Math.max(10, minQuantity - currentQuantity + 5));
        
        updatePreview();
        $('#quickUpdateModal').modal('show');
    });
    
    // Update preview when quantity changes
    $('#addQuantity').on('input', updatePreview);
    
    function updatePreview() {
        const currentQuantity = parseInt($('#currentQuantity').text()) || 0;
        const addQuantity = parseInt($('#addQuantity').val()) || 0;
        const newQuantity = currentQuantity + addQuantity;
        
        $('#previewQuantity').text(newQuantity);
        $('#newQuantityPreview').show();
    }
    
    // Confirm quick update
    $('#confirmQuickUpdate').click(function() {
        const productId = $('#productId').val();
        const currentQuantity = parseInt($('#currentQuantity').text()) || 0;
        const addQuantity = parseInt($('#addQuantity').val()) || 0;
        const newQuantity = currentQuantity + addQuantity;
        const reason = $('#quickReason').val();
        
        if (addQuantity <= 0) {
            alert('Η ποσότητα προσθήκης πρέπει να είναι μεγαλύτερη από 0');
            return;
        }
        
        // Show loading state
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Ενημέρωση...');
        
        $.ajax({
            url: '<?= site_url('stocks/update-quantity') ?>/' + productId,
            type: 'POST',
            data: {
                quantity: newQuantity,
                reason: reason + ' (Γρήγορη ενημέρωση: +' + addQuantity + ')'
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    $('#quickUpdateModal').modal('hide');
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
                $('#confirmQuickUpdate').prop('disabled', false)
                                        .html('<i class="fas fa-plus"></i> Προσθήκη');
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
        $('.alert').not('.alert-info').remove();
        
        // Add new alert at the top of the container
        $('.container-fluid').prepend(alert);
        
        // Auto hide after 5 seconds
        setTimeout(function() {
            $('.alert-success, .alert-danger').fadeOut();
        }, 5000);
    }
    
    // Make functions globally available
    window.showAlert = showAlert;
});

// Export to CSV function
function exportToCSV() {
    const table = $('#lowStockTable').DataTable();
    const data = table.rows().data().toArray();
    
    let csv = 'ID,Όνομα Προϊόντος,Τρέχουσα Ποσότητα,Ελάχιστη Ποσότητα,Διαφορά,Τοποθεσία,Προτεραιότητα\n';
    
    data.forEach(function(row) {
        csv += '"' + row.join('","') + '"\n';
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'low_stock_report_' + new Date().toISOString().slice(0, 10) + '.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}

// Quick action functions
function updateAllCritical() {
    if (confirm('Θέλετε να ενημερώσετε όλα τα κρίσιμα προϊόντα (εξαντλημένα);')) {
        showAlert('info', 'Η λειτουργία θα υλοποιηθεί σύντομα');
    }
}

function generateOrderList() {
    showAlert('info', 'Δημιουργία λίστας παραγγελιών - Θα υλοποιηθεί σύντομα');
}

function markAllReviewed() {
    if (confirm('Επιβεβαιώστε ότι έχετε ελέγξει όλα τα προϊόντα χαμηλού αποθέματος.')) {
        showAlert('success', 'Όλα τα προϊόντα σημειώθηκαν ως ελεγμένα');
    }
}
</script>

<style>
/* Print styles */
@media print {
    .no-print {
        display: none !important;
    }
    
    .container-fluid {
        padding: 0 !important;
    }
    
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
    
    .table {
        font-size: 12px;
    }
    
    .badge {
        border: 1px solid #000;
        color: #000 !important;
        background-color: #fff !important;
    }
}

/* Custom styling */
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.border-left-danger { border-left: 0.25rem solid #e74a3b !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }

.table th {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
    font-weight: 600;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.badge {
    font-size: 0.75em;
}

/* Priority badge colors */
.badge-danger { background-color: #e74a3b !important; }
.badge-warning { background-color: #f6c23e !important; }
.badge-info { background-color: #36b9cc !important; }
.badge-secondary { background-color: #858796 !important; }

/* Table row highlighting */
.table-danger {
    background-color: rgba(231, 74, 59, 0.1) !important;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
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
    
    .btn-group-sm > .btn {
        padding: 0.125rem 0.25rem;
        font-size: 0.7rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .col-md-4 {
        margin-bottom: 1rem;
    }
}

/* Success icon styling */
.fa-5x {
    font-size: 5em;
}

/* DataTables custom styling */
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
    padding: 0.375rem 0.75rem;
}

.dataTables_wrapper .dataTables_length select {
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
    padding: 0.375rem 0.75rem;
}
</style>