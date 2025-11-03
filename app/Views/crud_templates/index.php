<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-table"></i> <?= esc($title) ?>
    </h1>
    <a href="<?= esc($createUrl) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Νέα Εγγραφή
    </a>
</div>

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

<!-- DataTable Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-database"></i> Λίστα <?= esc($title) ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <?= $this->renderSection('table_headers') ?>
                        <th width="120">Ενέργειες</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

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
                Είστε σίγουροι ότι θέλετε να διαγράψετε αυτήν την εγγραφή;
                <br><strong>Αυτή η ενέργεια δεν μπορεί να αναιρεθεί!</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Ακύρωση
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash"></i> Διαγραφή
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- DataTables CSS -->
<link href="<?= base_url('public/vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">

<!-- DataTables JavaScript -->
<script src="<?= base_url('public/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('public/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= esc($ajaxUrl) ?>",
            "type": "POST",
            "data": function(d) {
                // Add CSRF token
                d.<?= csrf_token() ?> = "<?= csrf_hash() ?>";
            }
        },
        "columns": [
            <?= $this->renderSection('datatable_columns') ?>
            {
                "data": "actions",
                "name": "actions",
                "orderable": false,
                "searchable": false,
                "className": "text-center"
            }
        ],
        "order": [[0, "desc"]], // Default order by first column descending
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Όλα"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Greek.json"
        },
        "responsive": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Αντιγραφή',
                className: 'btn btn-sm btn-secondary'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Εκτύπωση',
                className: 'btn btn-sm btn-info'
            }
        ]
    });

    // Add custom styling to buttons
    table.buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
    
    // Delete confirmation
    var deleteId = null;
    
    window.confirmDelete = function(id) {
        deleteId = id;
        $('#deleteModal').modal('show');
    };
    
    $('#confirmDeleteBtn').click(function() {
        if (deleteId) {
            $.ajax({
                url: "<?= site_url($viewPath ?? '') ?>delete/" + deleteId,
                type: 'POST',
                data: {
                    <?= csrf_token() ?>: "<?= csrf_hash() ?>"
                },
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    
                    if (response.success) {
                        // Show success message
                        showAlert('success', response.message);
                        // Reload table
                        table.ajax.reload();
                    } else {
                        // Show error message
                        showAlert('error', response.message);
                    }
                },
                error: function() {
                    $('#deleteModal').modal('hide');
                    showAlert('error', 'Σφάλμα κατά τη διαγραφή της εγγραφής!');
                }
            });
        }
    });
    
    // Show alert function
    function showAlert(type, message) {
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
        
        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
            '<i class="fas ' + icon + '"></i> ' + message +
            '<button type="button" class="close" data-dismiss="alert">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>';
        
        $('.card').before(alertHtml);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>

<?= $this->endSection() ?>