<!-- Demo Type Management Page -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cogs text-primary"></i> Διαχείριση Demo Types
        </h1>
    </div>

    <!-- Status Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Κατάσταση Demo Types
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border-left-info p-3">
                                <h5 class="font-weight-bold text-info" id="total-demo">-</h5>
                                <small class="text-muted">Σύνολο Demo</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-left-success p-3">
                                <h5 class="font-weight-bold text-success" id="trial-count">-</h5>
                                <small class="text-muted">Trial (Δοκιμές)</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-left-warning p-3">
                                <h5 class="font-weight-bold text-warning" id="replacement-count">-</h5>
                                <small class="text-muted">Replacement (Αντικαταστάσεις)</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-left-danger p-3">
                                <h5 class="font-weight-bold text-danger" id="null-count">-</h5>
                                <small class="text-muted">Χωρίς Τύπο</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-magic"></i> Αυτόματες Ενέργειες
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6><i class="fas fa-user-check"></i> Ορισμός Trial</h6>
                                    <p class="small mb-3">Όλα τα demo με on_test=1 γίνονται "trial"</p>
                                    <button class="btn btn-light btn-sm" onclick="setTrialTypes()">
                                        <i class="fas fa-play"></i> Εκτέλεση
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6><i class="fas fa-sync-alt"></i> Ορισμός Replacement</h6>
                                    <p class="small mb-3">Όλα τα demo με on_test=0 γίνονται "replacement"</p>
                                    <button class="btn btn-light btn-sm" onclick="setReplacementTypes()">
                                        <i class="fas fa-play"></i> Εκτέλεση
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manual Update Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Χειροκίνητη Ενημέρωση
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="demoStocksTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Μοντέλο</th>
                                    <th>On Test</th>
                                    <th>Demo Type</th>
                                    <th>Πελάτης</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody id="demo-stocks-tbody">
                                <!-- Data loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load initial data
    loadDemoStats();
    loadDemoStocks();
    
    // Initialize DataTable
    $('#demoStocksTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/Greek.json"
        },
        "pageLength": 10,
        "order": [[0, "asc"]]
    });
});

function loadDemoStats() {
    $.ajax({
        url: '<?= base_url("admin/stocks/get_demo_stats") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#total-demo').text(data.total || 0);
            $('#trial-count').text(data.trial || 0);
            $('#replacement-count').text(data.replacement || 0);
            $('#null-count').text(data.null_type || 0);
        },
        error: function() {
            console.error('Failed to load demo statistics');
        }
    });
}

function loadDemoStocks() {
    $.ajax({
        url: '<?= base_url("admin/stocks/get_demo_management_data") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            let tbody = $('#demo-stocks-tbody');
            tbody.empty();
            
            data.forEach(function(item) {
                let row = `
                    <tr>
                        <td><strong>${item.serial}</strong></td>
                        <td>${item.manufacturer_name || ''} - ${item.model_name || ''}</td>
                        <td>
                            <span class="badge badge-${item.on_test == 1 ? 'success' : 'secondary'}">
                                ${item.on_test == 1 ? 'Ναι' : 'Όχι'}
                            </span>
                        </td>
                        <td>
                            <select class="form-control form-control-sm demo-type-select" 
                                    data-id="${item.id}" style="width: 150px;">
                                <option value="">-- Επιλέξτε --</option>
                                <option value="trial" ${item.demo_type == 'trial' ? 'selected' : ''}>Trial</option>
                                <option value="replacement" ${item.demo_type == 'replacement' ? 'selected' : ''}>Replacement</option>
                            </select>
                        </td>
                        <td>${item.customer_name || '<span class="text-muted">Κανένας</span>'}</td>
                        <td>
                            <button class="btn btn-primary btn-sm save-demo-type" data-id="${item.id}">
                                <i class="fas fa-save"></i> Αποθήκευση
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
            
            // Re-initialize DataTable
            $('#demoStocksTable').DataTable().destroy();
            $('#demoStocksTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/Greek.json"
                },
                "pageLength": 10,
                "order": [[0, "asc"]]
            });
        },
        error: function() {
            console.error('Failed to load demo stocks data');
        }
    });
}

function setTrialTypes() {
    Swal.fire({
        title: 'Ορισμός Trial Types',
        text: 'Θέλετε να ορίσετε όλα τα demo με on_test=1 ως "trial";',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ναι, εκτέλεση',
        cancelButtonText: 'Ακύρωση'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/stocks/bulk_set_demo_type") ?>',
                type: 'POST',
                data: { type: 'trial', condition: 'on_test_1' },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Επιτυχία!', response.message, 'success');
                        loadDemoStats();
                        loadDemoStocks();
                    } else {
                        Swal.fire('Σφάλμα!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Σφάλμα!', 'Υπήρξε πρόβλημα κατά την εκτέλεση', 'error');
                }
            });
        }
    });
}

function setReplacementTypes() {
    Swal.fire({
        title: 'Ορισμός Replacement Types',
        text: 'Θέλετε να ορίσετε όλα τα demo με on_test=0 ως "replacement";',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ναι, εκτέλεση',
        cancelButtonText: 'Ακύρωση'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/stocks/bulk_set_demo_type") ?>',
                type: 'POST',
                data: { type: 'replacement', condition: 'on_test_0' },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Επιτυχία!', response.message, 'success');
                        loadDemoStats();
                        loadDemoStocks();
                    } else {
                        Swal.fire('Σφάλμα!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Σφάλμα!', 'Υπήρξε πρόβλημα κατά την εκτέλεση', 'error');
                }
            });
        }
    });
}

// Individual save demo type
$(document).on('click', '.save-demo-type', function() {
    let stockId = $(this).data('id');
    let demoType = $(this).closest('tr').find('.demo-type-select').val();
    
    if (!demoType) {
        Swal.fire('Προσοχή!', 'Παρακαλώ επιλέξτε έναν τύπο demo', 'warning');
        return;
    }
    
    $.ajax({
        url: '<?= base_url("admin/stocks/update_demo_type") ?>',
        type: 'POST',
        data: { stock_id: stockId, demo_type: demoType },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Επιτυχία!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                loadDemoStats();
            } else {
                Swal.fire('Σφάλμα!', response.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Σφάλμα!', 'Υπήρξε πρόβλημα κατά την ενημέρωση', 'error');
        }
    });
});
</script>