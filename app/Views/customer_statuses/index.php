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
        
        <?php if ($can_create): ?>
        <a href="<?= $create_url ?>" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> 
            Νέα Κατάσταση
        </a>
        <?php endif; ?>
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

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i>
                Λίστα Καταστάσεων Πελατών
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
                        Νέα Κατάσταση
                    </a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="$('#customerStatusesTable').DataTable().ajax.reload();">
                        <i class="fas fa-sync fa-sm fa-fw mr-2 text-gray-400"></i>
                        Ανανέωση Λίστας
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="customerStatusesTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Όνομα</th>
                            <th>Περιγραφή</th>
                            <th>Χρώμα</th>
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
                <p>Είστε σίγουρος ότι θέλετε να διαγράψετε την κατάσταση πελάτη:</p>
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
    const table = $('#customerStatusesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= $ajax_url ?>',
            type: 'GET'
        },
        columns: [
            { data: 0, name: 'id', width: '80px' },
            { data: 1, name: 'name', width: '200px' },
            { data: 2, name: 'description' },
            { data: 3, name: 'color', width: '120px', orderable: false },
            { data: 4, name: 'is_active', width: '100px' },
            { data: 5, name: 'actions', width: '150px', orderable: false, searchable: false }
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
});
</script>

<style>
/* Custom styles for better UX */
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

/* Color preview style */
.badge[style*="background-color"] {
    border: 1px solid #dee2e6;
    min-width: 60px;
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

/* Responsive table adjustments */
@media (max-width: 768px) {
    .btn-group-sm > .btn {
        padding: 0.125rem 0.25rem;
        font-size: 0.7rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>