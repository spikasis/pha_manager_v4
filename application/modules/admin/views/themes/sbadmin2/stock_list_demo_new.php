<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-microscope text-primary"></i> <?= $title ?>
        </h1>
        <div class="d-flex">
            <div class="mr-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Σύνολο: <?= $total_demo ?> | 
                    Δοκιμές: <?= $total_trial ?> | 
                    Αντικαταστάσεις: <?= $total_replacement ?>
                </small>
            </div>
        </div>
    </div>

    <!-- Trial Hearing Aids Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-user-check"></i> Ακουστικά Προς Δοκιμή
                        <span class="badge badge-success ml-2"><?= $total_trial ?></span>
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="trialTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="trial-available-tab" data-toggle="tab" 
                                    data-target="#trial-available" type="button" role="tab">
                                <i class="fas fa-check-circle text-success"></i> 
                                Διαθέσιμα <span class="badge badge-light ml-1"><?= count($trial_available) ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="trial-inuse-tab" data-toggle="tab" 
                                    data-target="#trial-inuse" type="button" role="tab">
                                <i class="fas fa-user-clock text-warning"></i> 
                                Σε Δοκιμή <span class="badge badge-light ml-1"><?= count($trial_in_use) ?></span>
                            </button>
                        </li>
                    </ul>
                    
                    <!-- Tab Content -->
                    <div class="tab-content mt-3" id="trialTabsContent">
                        <!-- Available Trial Items -->
                        <div class="tab-pane fade show active" id="trial-available" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="trialAvailableTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Μοντέλο</th>
                                            <th>Ημ. Εισαγωγής</th>
                                            <th>Τιμή</th>
                                            <th>Σχόλια</th>
                                            <th>Ενέργειες</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($trial_available)): ?>
                                            <?php foreach ($trial_available as $item): ?>
                                                <tr>
                                                    <td><strong><?= $item['serial'] ?></strong></td>
                                                    <td><?= $item['manufacturer_name'] ?> - <?= $item['series_name'] ?> - <?= $item['model_name'] ?></td>
                                                    <td><?= $item['day_in'] ? date('d/m/Y', strtotime($item['day_in'])) : '-' ?></td>
                                                    <td>
                                                        <?php if ($item['ha_price']): ?>
                                                            <span class="badge badge-info">€<?= number_format($item['ha_price'], 2) ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $item['comments'] ?: '-' ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" 
                                                                    data-toggle="dropdown">
                                                                <i class="fas fa-cog"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item assign-customer" href="#" 
                                                                   data-id="<?= $item['id'] ?>">
                                                                    <i class="fas fa-user-plus"></i> Ανάθεση σε Πελάτη
                                                                </a>
                                                                <a class="dropdown-item" 
                                                                   href="<?= base_url('admin/stocks/view/' . $item['id']) ?>">
                                                                    <i class="fas fa-eye"></i> Προβολή
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item change-demo-type" href="#" 
                                                                   data-id="<?= $item['id'] ?>" data-type="replacement">
                                                                    <i class="fas fa-exchange-alt"></i> Μετατροπή σε Αντικατάσταση
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                    Δεν υπάρχουν διαθέσιμα ακουστικά προς δοκιμή
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Trial Items In Use -->
                        <div class="tab-pane fade" id="trial-inuse" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="trialInUseTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Πελάτης</th>
                                            <th>Μοντέλο</th>
                                            <th>Ημ. Παράδοσης</th>
                                            <th>Μέρες Δοκιμής</th>
                                            <th>Status</th>
                                            <th>Ενέργειες</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($trial_in_use)): ?>
                                            <?php foreach ($trial_in_use as $item): ?>
                                                <tr class="<?php 
                                                    if ($item['days_out'] > 15) echo 'table-danger';
                                                    elseif ($item['days_out'] > 7) echo 'table-warning';
                                                    else echo 'table-success';
                                                ?>">
                                                    <td><strong><?= $item['serial'] ?></strong></td>
                                                    <td><?= $item['customer_name'] ?></td>
                                                    <td><?= $item['manufacturer_name'] ?> - <?= $item['series_name'] ?> - <?= $item['model_name'] ?></td>
                                                    <td><?= $item['day_out'] ? date('d/m/Y', strtotime($item['day_out'])) : '-' ?></td>
                                                    <td>
                                                        <?php if ($item['days_out'] !== null): ?>
                                                            <span class="badge badge-<?php 
                                                                if ($item['days_out'] > 15) echo 'danger';
                                                                elseif ($item['days_out'] > 7) echo 'warning';
                                                                else echo 'success';
                                                            ?>"><?= $item['days_out'] ?> μέρες</span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($item['days_out'] > 15): ?>
                                                            <span class="badge badge-danger">Εκπρόθεσμη</span>
                                                        <?php elseif ($item['days_out'] > 7): ?>
                                                            <span class="badge badge-warning">Προσοχή</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-success">Εντάξει</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-warning btn-sm dropdown-toggle" type="button" 
                                                                    data-toggle="dropdown">
                                                                <i class="fas fa-cog"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item return-item" href="#" 
                                                                   data-id="<?= $item['id'] ?>">
                                                                    <i class="fas fa-undo"></i> Επιστροφή
                                                                </a>
                                                                <a class="dropdown-item" 
                                                                   href="<?= base_url('admin/stocks/view/' . $item['id']) ?>">
                                                                    <i class="fas fa-eye"></i> Προβολή
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item change-demo-type" href="#" 
                                                                   data-id="<?= $item['id'] ?>" data-type="replacement">
                                                                    <i class="fas fa-exchange-alt"></i> Μετατροπή σε Αντικατάσταση
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                    Δεν υπάρχουν ακουστικά σε δοκιμή
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Replacement Hearing Aids Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-sync-alt"></i> Ακουστικά Προς Αντικατάσταση
                        <span class="badge badge-info ml-2"><?= $total_replacement ?></span>
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="replacementTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="replacement-available-tab" data-toggle="tab" 
                                    data-target="#replacement-available" type="button" role="tab">
                                <i class="fas fa-warehouse text-info"></i> 
                                Διαθέσιμα <span class="badge badge-light ml-1"><?= count($replacement_available) ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="replacement-inuse-tab" data-toggle="tab" 
                                    data-target="#replacement-inuse" type="button" role="tab">
                                <i class="fas fa-user-cog text-warning"></i> 
                                Σε Χρήση <span class="badge badge-light ml-1"><?= count($replacement_in_use) ?></span>
                            </button>
                        </li>
                    </ul>
                    
                    <!-- Tab Content -->
                    <div class="tab-content mt-3" id="replacementTabsContent">
                        <!-- Available Replacement Items -->
                        <div class="tab-pane fade show active" id="replacement-available" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="replacementAvailableTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Μοντέλο</th>
                                            <th>Ημ. Εισαγωγής</th>
                                            <th>Τιμή</th>
                                            <th>Σχόλια</th>
                                            <th>Ενέργειες</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($replacement_available)): ?>
                                            <?php foreach ($replacement_available as $item): ?>
                                                <tr>
                                                    <td><strong><?= $item['serial'] ?></strong></td>
                                                    <td><?= $item['manufacturer_name'] ?> - <?= $item['series_name'] ?> - <?= $item['model_name'] ?></td>
                                                    <td><?= $item['day_in'] ? date('d/m/Y', strtotime($item['day_in'])) : '-' ?></td>
                                                    <td>
                                                        <?php if ($item['ha_price']): ?>
                                                            <span class="badge badge-info">€<?= number_format($item['ha_price'], 2) ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $item['comments'] ?: '-' ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" 
                                                                    data-toggle="dropdown">
                                                                <i class="fas fa-cog"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item assign-replacement" href="#" 
                                                                   data-id="<?= $item['id'] ?>">
                                                                    <i class="fas fa-user-plus"></i> Ανάθεση σε Πελάτη
                                                                </a>
                                                                <a class="dropdown-item" 
                                                                   href="<?= base_url('admin/stocks/view/' . $item['id']) ?>">
                                                                    <i class="fas fa-eye"></i> Προβολή
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item change-demo-type" href="#" 
                                                                   data-id="<?= $item['id'] ?>" data-type="trial">
                                                                    <i class="fas fa-exchange-alt"></i> Μετατροπή σε Δοκιμή
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                    Δεν υπάρχουν διαθέσιμα ακουστικά για αντικατάσταση
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Replacement Items In Use -->
                        <div class="tab-pane fade" id="replacement-inuse" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="replacementInUseTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Πελάτης</th>
                                            <th>Μοντέλο</th>
                                            <th>Ημ. Παράδοσης</th>
                                            <th>Μέρες Χρήσης</th>
                                            <th>Σχόλια</th>
                                            <th>Ενέργειες</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($replacement_in_use)): ?>
                                            <?php foreach ($replacement_in_use as $item): ?>
                                                <tr>
                                                    <td><strong><?= $item['serial'] ?></strong></td>
                                                    <td><?= $item['customer_name'] ?></td>
                                                    <td><?= $item['manufacturer_name'] ?> - <?= $item['series_name'] ?> - <?= $item['model_name'] ?></td>
                                                    <td><?= $item['day_out'] ? date('d/m/Y', strtotime($item['day_out'])) : '-' ?></td>
                                                    <td>
                                                        <?php if ($item['days_out'] !== null): ?>
                                                            <span class="badge badge-primary"><?= $item['days_out'] ?> μέρες</span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $item['comments'] ?: '-' ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" 
                                                                    data-toggle="dropdown">
                                                                <i class="fas fa-cog"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item return-item" href="#" 
                                                                   data-id="<?= $item['id'] ?>">
                                                                    <i class="fas fa-undo"></i> Επιστροφή
                                                                </a>
                                                                <a class="dropdown-item" 
                                                                   href="<?= base_url('admin/stocks/view/' . $item['id']) ?>">
                                                                    <i class="fas fa-eye"></i> Προβολή
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item change-demo-type" href="#" 
                                                                   data-id="<?= $item['id'] ?>" data-type="trial">
                                                                    <i class="fas fa-exchange-alt"></i> Μετατροπή σε Δοκιμή
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                    Δεν υπάρχουν ακουστικά σε χρήση για αντικατάσταση
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->

<!-- Customer Assignment Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ανάθεση Ακουστικού σε Πελάτη</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="customerAssignForm">
                    <input type="hidden" id="stock_id" name="stock_id">
                    <div class="form-group">
                        <label for="customer_select">Επιλογή Πελάτη:</label>
                        <select class="form-control" id="customer_select" name="customer_id" required>
                            <option value="">-- Επιλέξτε Πελάτη --</option>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?= $customer['id'] ?>"><?= $customer['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="delivery_date">Ημερομηνία Παράδοσης:</label>
                        <input type="date" class="form-control" id="delivery_date" name="day_out" 
                               value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="comments">Σχόλια:</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
                <button type="button" class="btn btn-primary" id="saveAssignment">Αποθήκευση</button>
            </div>
        </div>
    </div>
</div>

<?php if (isset($custom_js)): ?>
<script>
    // Initialize DataTables for all tables with enhanced configuration
    $(document).ready(function() {
        // Enhanced DataTable configuration with proper pagination
        const tableConfig = {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/Greek.json"
            },
            "pageLength": 15,
            "lengthMenu": [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Όλα"]],
            "order": [[0, "asc"]], // Sort by Serial column
            "columnDefs": [
                {
                    "targets": [-1], // Last column (Actions)
                    "orderable": false,
                    "searchable": false
                }
            ],
            "responsive": true,
            "searching": true,
            "paging": true,
            "info": true,
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                   '<"row"<"col-sm-12"tr>>' +
                   '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "drawCallback": function() {
                // Re-initialize tooltips and dropdowns after table redraw
                $('[data-toggle="tooltip"]').tooltip();
            }
        };
        
        // Initialize all demo tables
        $('#trialAvailableTable').DataTable(tableConfig);
        $('#trialInUseTable').DataTable(tableConfig);
        $('#replacementAvailableTable').DataTable(tableConfig);
        $('#replacementInUseTable').DataTable(tableConfig);
        
        // Handle tab switching and table redraw for proper display
        $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
        
        // Customer assignment handlers
        $(document).on('click', '.assign-customer, .assign-replacement', function(e) {
            e.preventDefault();
            const stockId = $(this).data('id');
            $('#stock_id').val(stockId);
            $('#customerModal').modal('show');
        });
        
        $('#saveAssignment').click(function() {
            const formData = $('#customerAssignForm').serialize();
            
            $.ajax({
                url: '<?= base_url("admin/stocks/assign_customer") ?>',
                type: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Επιτυχία!',
                        text: 'Η ανάθεση στον πελάτη ολοκληρώθηκε.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Σφάλμα!',
                        text: 'Υπήρξε πρόβλημα κατά την ανάθεση.'
                    });
                }
            });
        });
        
        // Return item handler
        $(document).on('click', '.return-item', function(e) {
            e.preventDefault();
            const stockId = $(this).data('id');
            
            Swal.fire({
                title: 'Επιστροφή Ακουστικού',
                text: 'Είστε σίγουροι ότι θέλετε να επιστρέψετε αυτό το ακουστικό;',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ναι, επιστροφή',
                cancelButtonText: 'Ακύρωση'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url("admin/stocks/return_demo") ?>',
                        type: 'POST',
                        data: { stock_id: stockId },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Επιτυχία!',
                                text: 'Το ακουστικό επιστράφηκε επιτυχώς.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Σφάλμα!',
                                text: 'Υπήρξε πρόβλημα κατά την επιστροφή.'
                            });
                        }
                    });
                }
            });
        });
        
        // Demo type change handler
        $(document).on('click', '.change-demo-type', function(e) {
            e.preventDefault();
            const stockId = $(this).data('id');
            const newType = $(this).data('type');
            const typeLabel = newType === 'trial' ? 'Δοκιμή' : 'Αντικατάσταση';
            
            Swal.fire({
                title: `Μετατροπή σε ${typeLabel}`,
                text: `Θέλετε να αλλάξετε αυτό το ακουστικό σε κατηγορία ${typeLabel};`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ναι, μετατροπή',
                cancelButtonText: 'Ακύρωση'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url("admin/stocks/update_demo_type") ?>',
                        type: 'POST',
                        data: { 
                            stock_id: stockId,
                            demo_type: newType
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Επιτυχία!',
                                text: `Η μετατροπή σε ${typeLabel} ολοκληρώθηκε.`,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Σφάλμα!',
                                text: 'Υπήρξε πρόβλημα κατά την μετατροπή.'
                            });
                        }
                    });
                }
            });
        });

    });
</script>
<?php endif; ?>