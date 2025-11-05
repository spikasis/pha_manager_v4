<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="<?= $entity_config['icon'] ?>"></i>
                <?= $title ?>
            </h1>
            <p class="mb-0 text-gray-600"><?= $subtitle ?></p>
        </div>
        
        <div class="d-flex gap-2">
            <a href="<?= $low_stock_url ?>" class="btn btn-warning shadow-sm">
                <i class="fas fa-exclamation-triangle fa-sm text-white-50"></i> 
                Χαμηλό Απόθεμα (<?= count($low_stock_items) ?>)
            </a>
            <?php if ($can_create): ?>
            <a href="<?= $create_url ?>" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> 
                Νέο Προϊόν
            </a>
            <?php endif; ?>
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

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Inventory Statistics Row -->
    <div class="row mb-4">
        <!-- Total Products -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Συνολικά Προϊόντα
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($inventory_stats['total_products']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Products -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ενεργά Προϊόντα
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($inventory_stats['active_products']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Χαμηλό Απόθεμα
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($inventory_stats['low_stock']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Out of Stock -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Εξαντλημένα
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($inventory_stats['out_of_stock']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Value -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Αξία Αποθέματος
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                €<?= number_format($inventory_stats['inventory_value'], 2) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Price -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Μέση Τιμή
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                €<?= number_format($inventory_stats['avg_price'], 2) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i>
                Λίστα Προϊόντων Αποθήκης
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                     aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Ενέργειες:</div>
                    <?php if ($can_create): ?>
                    <a class="dropdown-item" href="<?= $create_url ?>">
                        <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                        Νέο Προϊόν
                    </a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="<?= $low_stock_url ?>">
                        <i class="fas fa-exclamation-triangle fa-sm fa-fw mr-2 text-gray-400"></i>
                        Αναφορά Χαμηλού Αποθέματος
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="$('#stocksTable').DataTable().ajax.reload();">
                        <i class="fas fa-sync fa-sm fa-fw mr-2 text-gray-400"></i>
                        Ανανέωση Λίστας
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="stocksTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Όνομα</th>
                            <th>SKU</th>
                            <th>Κατηγορία</th>
                            <th>Κατασκευαστής</th>
                            <th>Ποσότητα</th>
                            <th>Τιμή</th>
                            <th>Τοποθεσία</th>
                            <th>Κατάσταση</th>
                            <th class="text-center">Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Επιβεβαίωση Διαγραφής
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Είστε σίγουρος ότι θέλετε να διαγράψετε το προϊόν:</p>
                <div class="alert alert-warning">
                    <strong id="deleteItemName"></strong>
                </div>
                <p class="text-danger mb-0">
                    <i class="fas fa-info-circle"></i>
                    Αυτή η ενέργεια δεν μπορεί να αναιρεθεί!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Ακύρωση
                </button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash"></i> Διαγραφή
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#stocksTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= $ajax_url ?>',
            type: 'GET'
        },
        columns: [
            { data: 0, name: 'id', width: '60px' },
            { data: 1, name: 'name', width: '200px' },
            { data: 2, name: 'sku', width: '120px' },
            { data: 3, name: 'category', width: '150px' },
            { data: 4, name: 'manufacturer', width: '150px' },
            { data: 5, name: 'quantity', width: '100px' },
            { data: 6, name: 'unit_price', width: '100px' },
            { data: 7, name: 'location', width: '120px' },
            { data: 8, name: 'is_active', width: '100px' },
            { data: 9, name: 'actions', width: '150px', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        pageLength: 25,
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
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-secondary btn-sm'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Εκτύπωση',
                className: 'btn btn-secondary btn-sm'
            }
        ],
        responsive: true,
        stateSave: true,
        drawCallback: function(settings) {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Highlight low stock rows
            $('#stocksTable tbody tr').each(function() {
                const $quantityCell = $(this).find('td:eq(5)');
                if ($quantityCell.find('.badge-warning, .badge-danger').length > 0) {
                    $(this).addClass('table-warning');
                }
            });
        }
    });
    
    // Delete functionality
    let deleteId = null;
    
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        deleteId = $(this).data('id');
        const itemName = $(this).data('name');
        
        $('#deleteItemName').text(itemName);
        $('#deleteModal').modal('show');
    });
    
    $('#confirmDelete').click(function() {
        if (deleteId) {
            // Show loading state
            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Διαγραφή...');
            
            $.ajax({
                url: '<?= $delete_url ?>/' + deleteId,
                type: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        $('#deleteModal').modal('hide');
                        table.ajax.reload();
                        
                        // Show success message
                        showAlert('success', response.message || 'Η διαγραφή ολοκληρώθηκε επιτυχώς');
                    } else {
                        showAlert('error', response.message || 'Σφάλμα κατά τη διαγραφή');
                    }
                },
                error: function(xhr) {
                    let message = 'Σφάλμα κατά τη διαγραφή';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showAlert('error', message);
                },
                complete: function() {
                    $('#confirmDelete').prop('disabled', false).html('<i class="fas fa-trash"></i> Διαγραφή');
                    $('#deleteModal').modal('hide');
                    deleteId = null;
                }
            });
        }
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
        $('.alert').remove();
        
        // Add new alert at the top of the container
        $('.container-fluid').prepend(alert);
        
        // Auto hide after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
    
    // Refresh button in dropdown
    $('.dropdown-item[href="#"]').click(function(e) {
        e.preventDefault();
        if ($(this).text().trim().includes('Ανανέωση')) {
            table.ajax.reload();
            showAlert('success', 'Η λίστα ανανεώθηκε επιτυχώς');
        }
    });
    
    // Auto-refresh every 5 minutes to update low stock alerts
    setInterval(function() {
        location.reload();
    }, 300000); // 5 minutes
});
</script>

<style>
/* Custom styles for inventory management */
.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.border-left-danger { border-left: 0.25rem solid #e74a3b !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-secondary { border-left: 0.25rem solid #858796 !important; }

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

/* Quantity badge styling */
.badge-warning { background-color: #f6c23e !important; }
.badge-danger { background-color: #e74a3b !important; }
.badge-success { background-color: #1cc88a !important; }

/* Low stock row highlighting */
.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

/* Statistics cards hover effect */
.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s;
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

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-group-sm > .btn {
        padding: 0.125rem 0.25rem;
        font-size: 0.7rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
}

/* Loading animation for auto-refresh */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.auto-refresh {
    animation: pulse 2s infinite;
}
</style>