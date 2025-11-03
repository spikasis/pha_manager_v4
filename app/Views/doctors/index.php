<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>
<?= $title ?> - PHA Manager
<?= $this->endSection() ?>

<?= $this->section('page-title') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-md fa-fw mr-2"></i>
        <?= $moduleTitle ?>
    </h1>
    <div class="ml-auto">
        <button type="button" class="btn btn-info btn-sm mr-2" onclick="showStatistics()">
            <i class="fas fa-chart-bar"></i> Στατιστικά
        </button>
        <a href="<?= $createUrl ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Νέος <?= $moduleTitleSingle ?>
        </a>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Statistics Cards (Initially Hidden) -->
<div id="statistics-cards" class="row mb-4" style="display: none;">
    <div class="col-xl-2 col-md-4 mb-2">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Συνολικοί</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-total">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-md fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-2">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ενεργοί</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-active">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-2">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Πλήρη Στοιχεία</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-complete">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-address-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Μέση Τιμή</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">€<span id="stat-avg-price">0</span></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Κορυφαία Πόλη</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800" id="stat-top-city">-</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-city fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTable Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary"><?= $moduleTitle ?></h6>
            </div>
            <div class="col-auto">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary" onclick="refreshTable()">
                        <i class="fas fa-sync-alt"></i> Ανανέωση
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <?php foreach ($datatableColumns as $column): ?>
                            <th<?= isset($column['width']) ? ' style="width: '.$column['width'].'"' : '' ?>>
                                <?= $column['title'] ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= $datatableUrl ?>",
            type: "POST"
        },
        columns: [
            <?php foreach ($datatableColumns as $column): ?>
            {
                data: "<?= $column['data'] ?>",
                name: "<?= $column['name'] ?>",
                orderable: <?= $column['orderable'] ? 'true' : 'false' ?>,
                searchable: <?= $column['searchable'] ? 'true' : 'false' ?>
            }<?= $column !== end($datatableColumns) ? ',' : '' ?>
            <?php endforeach; ?>
        ],
        order: [[1, 'asc']], // Sort by doctor name
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Greek.json'
        },
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: 'Αντιγραφή',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'csv',
                text: 'CSV',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                text: 'PDF',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });
    
    // Store table reference globally
    window.doctorsTable = table;
});

// Show/hide statistics
function showStatistics() {
    var $stats = $('#statistics-cards');
    
    if ($stats.is(':visible')) {
        $stats.slideUp();
        return;
    }
    
    // Load statistics via AJAX
    $.get('<?= base_url('doctors/getStatistics') ?>')
        .done(function(data) {
            $('#stat-total').text(data.total);
            $('#stat-active').text(data.active);
            $('#stat-complete').text(data.complete_contact);
            $('#stat-avg-price').text(data.avg_price);
            
            // Show top city
            if (data.by_city && data.by_city.length > 0) {
                $('#stat-top-city').text(data.by_city[0].doc_city + ' (' + data.by_city[0].count + ')');
            } else {
                $('#stat-top-city').text('-');
            }
            
            $stats.slideDown();
        })
        .fail(function() {
            toastr.error('Σφάλμα κατά τη φόρτωση των στατιστικών');
        });
}

// Refresh table
function refreshTable() {
    if (window.doctorsTable) {
        window.doctorsTable.ajax.reload();
        toastr.success('Ο πίνακας ανανεώθηκε');
    }
}

// Delete record function
function deleteRecord(id) {
    Swal.fire({
        title: 'Είστε σίγουροι;',
        text: "Δεν θα μπορείτε να αναιρέσετε αυτή την ενέργεια!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ναι, διαγραφή!',
        cancelButtonText: 'Ακύρωση'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send delete request
            $.ajax({
                url: '<?= base_url('doctors/delete') ?>/' + id,
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Διαγράφηκε!',
                            'Ο γιατρός διαγράφηκε επιτυχώς.',
                            'success'
                        );
                        refreshTable();
                    } else {
                        Swal.fire(
                            'Σφάλμα!',
                            response.message || 'Παρουσιάστηκε σφάλμα κατά τη διαγραφή.',
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Σφάλμα!',
                        'Παρουσιάστηκε σφάλμα επικοινωνίας.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
<?= $this->endSection() ?>