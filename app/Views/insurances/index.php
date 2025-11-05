<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .insurance-table {
        margin-top: 1rem;
    }
    
    .table th {
        background-color: #f8f9fc;
        border-top: none;
        font-weight: 600;
        color: #5a5c69;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 20px;
        padding: 8px 15px;
        border: 1px solid #d1d3e2;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border-radius: 20px;
        padding: 5px 10px;
    }
    
    .insurance-stats {
        background: linear-gradient(45deg, #4e73df, #36b9cc);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <!-- Insurance Stats -->
    <div class="col-lg-12 mb-4">
        <div class="insurance-stats">
            <div class="row align-items-center">
                <div class="col">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shield-alt fa-3x me-3"></i>
                        <div>
                            <h4 class="mb-1">Ασφαλιστικά Ταμεία</h4>
                            <p class="mb-0 opacity-75">Διαχείριση ασφαλιστικών ταμείων και οργανισμών συνεργασίας</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="text-center">
                        <div class="h2 mb-0" id="total-insurances">-</div>
                        <small class="opacity-75">Συνολικά Ταμεία</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list"></i> Λίστα Ασφαλιστικών Ταμείων
                        </h6>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('insurances/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Νέο Ταμείο
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered insurance-table" id="insurancesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Όνομα</th>
                                <th style="width: 120px;">Ενέργειες</th>
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
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#insurancesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= base_url('insurances/getData') ?>",
            "type": "POST",
            "data": function(d) {
                d.<?= csrf_token() ?> = "<?= csrf_hash() ?>";
            }
        },
        "columns": [
            { "data": 0, "width": "80px", "className": "text-center" },
            { "data": 1 },
            { "data": 2, "orderable": false, "className": "text-center" }
        ],
        "order": [[ 1, "asc" ]],
        "pageLength": 25,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/el.json"
        },
        "responsive": true,
        "autoWidth": false,
        "drawCallback": function(settings) {
            // Update total count
            var api = this.api();
            $('#total-insurances').text(api.page.info().recordsTotal);
        }
    });
    
    // Store DataTable instance globally
    window.insurancesTable = table;
});

/**
 * Delete insurance record
 */
function deleteRecord(id) {
    Swal.fire({
        title: 'Είστε σίγουροι;',
        text: 'Αυτή η ενέργεια δεν μπορεί να αναιρεθεί!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ναι, διαγραφή!',
        cancelButtonText: 'Άκυρο'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send DELETE request
            $.ajax({
                url: '<?= base_url('insurances') ?>/' + id,
                type: 'DELETE',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Διαγράφηκε!', response.message, 'success');
                        window.insurancesTable.ajax.reload();
                    } else {
                        Swal.fire('Σφάλμα!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Σφάλμα!', 'Παρουσιάστηκε σφάλμα κατά τη διαγραφή', 'error');
                }
            });
        }
    });
}
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= $this->endSection() ?>