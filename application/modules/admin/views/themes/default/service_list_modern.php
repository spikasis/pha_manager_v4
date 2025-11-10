<?php
/**
 * Modern Service List View - Enhanced SBAdmin2 Layout
 * Βελτιωμένο layout με καλύτερη UX και περισσότερη λειτουργικότητα
 */
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <i class="fa fa-wrench fa-fw"></i> Επισκευές Ακουστικών
                <div class="pull-right">
                    <a href="<?= base_url('admin/services/create') ?>" class="btn btn-success">
                        <i class="fa fa-plus"></i> Νέα Επισκευή
                    </a>
                    <a href="<?= base_url('admin/services/service_stats') ?>" class="btn btn-info">
                        <i class="fa fa-bar-chart"></i> Στατιστικά
                    </a>
                </div>
            </h1>
        </div>
    </div>

    <!-- Φίλτρα & Αναζήτηση -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-filter fa-fw"></i> Φίλτρα & Αναζήτηση
                    <div class="pull-right">
                        <button type="button" class="btn btn-xs btn-link" data-toggle="collapse" data-target="#filters">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
                <div class="panel-body collapse in" id="filters">
                    <form method="GET" class="form-inline">
                        <div class="form-group">
                            <label>Κατάσταση:</label>
                            <select name="status" class="form-control">
                                <option value="">Όλες</option>
                                <option value="1">Νέα Επισκευή</option>
                                <option value="2">Στο Εργαστήριο</option>
                                <option value="3">Έτοιμη</option>
                                <option value="4">Παραδόθηκε</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Εργαστήριο:</label>
                            <select name="lab" class="form-control">
                                <option value="">Όλα τα Εργαστήρια</option>
                                <?php if (isset($vendors)): ?>
                                    <?php foreach ($vendors as $vendor): ?>
                                        <option value="<?= $vendor['id'] ?>"><?= $vendor['name'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Από Ημ/νία:</label>
                            <input type="date" name="date_from" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Έως Ημ/νία:</label>
                            <input type="date" name="date_to" class="form-control">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Αναζήτηση
                        </button>
                        <a href="<?= base_url('admin/services') ?>" class="btn btn-default">
                            <i class="fa fa-refresh"></i> Επαναφορά
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Κάρτες Στατιστικών -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-wrench fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="total-services"><?= count($service) ?></div>
                            <div>Συνολικές Επισκευές</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-clock-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="pending-services">-</div>
                            <div>Στο Εργαστήριο</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-exclamation-triangle fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="delayed-services">-</div>
                            <div>Καθυστερημένες >7 ημέρες</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="completed-services">-</div>
                            <div>Ολοκληρωμένες</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Κύριος Πίνακας -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i> Λίστα Επισκευών
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-download"></i> Εξαγωγή <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" id="export-excel"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                                <li><a href="#" id="export-pdf"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                                <li><a href="#" id="print-list"><i class="fa fa-print"></i> Εκτύπωση</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="servicesTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Πελάτης</th>
                                    <th>Ακουστικό</th>
                                    <th>Ημ/νία Παραλαβής</th>
                                    <th>Εργαστήριο</th>
                                    <th>Κατάσταση</th>
                                    <th>Ημέρες στο Εργαστήριο</th>
                                    <th>Κόστος</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($service)): ?>
                                    <?php 
                                    $this->load->model(array('admin/stock', 'admin/vendor', 'admin/customer', 'admin/service_condition'));
                                    foreach ($service as $key => $list): 
                                        // Φόρτωση σχετικών δεδομένων
                                        if (isset($list['ha_service'])) {
                                            $hearing_aid = $this->stock->get($list['ha_service']);
                                        }
                                        $cust = $this->customer->get($hearing_aid->customer_id ?? 0);
                                        $lab = null;
                                        if (isset($list['lab_sent']) && $list['lab_sent']) {
                                            $lab = $this->vendor->get($list['lab_sent']);
                                        }
                                        $condition = $this->service_condition->get($list['status'] ?? 1);
                                        
                                        // Υπολογισμός ημερών καθυστέρησης
                                        $days_in_lab = 0;
                                        $status_class = '';
                                        if ($list['day_in']) {
                                            $date_in = new DateTime($list['day_in']);
                                            $today = new DateTime();
                                            $days_in_lab = $today->diff($date_in)->days;
                                            
                                            if ($days_in_lab > 7) {
                                                $status_class = 'danger';
                                            } elseif ($days_in_lab > 3) {
                                                $status_class = 'warning';
                                            }
                                        }
                                    ?>
                                    <tr class="<?= $status_class ?>">
                                        <td><?= $list['id'] ?></td>
                                        <td>
                                            <strong><?= $cust->name ?? 'N/A' ?></strong>
                                            <?php if ($cust && $cust->phone): ?>
                                                <br><small class="text-muted"><i class="fa fa-phone"></i> <?= $cust->phone ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($hearing_aid): ?>
                                                <strong><?= $hearing_aid->model ?></strong>
                                                <br><small class="text-muted">S/N: <?= $hearing_aid->serial ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= $list['day_in'] ? date('d/m/Y', strtotime($list['day_in'])) : 'N/A' ?>
                                        </td>
                                        <td>
                                            <?= $lab ? $lab->name : '<span class="text-muted">Δεν ορίστηκε</span>' ?>
                                        </td>
                                        <td>
                                            <?php
                                            $status_badges = [
                                                1 => '<span class="label label-info">Νέα</span>',
                                                2 => '<span class="label label-warning">Στο Εργαστήριο</span>',
                                                3 => '<span class="label label-success">Έτοιμη</span>',
                                                4 => '<span class="label label-default">Παραδόθηκε</span>'
                                            ];
                                            echo $status_badges[$list['status'] ?? 1] ?? '<span class="label label-default">Άγνωστη</span>';
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($days_in_lab > 0): ?>
                                                <span class="badge <?= $days_in_lab > 7 ? 'badge-danger' : ($days_in_lab > 3 ? 'badge-warning' : 'badge-info') ?>">
                                                    <?= $days_in_lab ?> ημέρες
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= $list['price'] ? '€' . number_format($list['price'], 2) : '<span class="text-muted">Δεν ορίστηκε</span>' ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= base_url('admin/services/edit/' . $list['id']) ?>" 
                                                   class="btn btn-xs btn-primary" title="Επεξεργασία">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/services/service_doc/' . $list['id']) ?>" 
                                                   class="btn btn-xs btn-info" title="Έντυπο PDF" target="_blank">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                <a href="<?= base_url('admin/services/service_tickets/' . $list['id']) ?>" 
                                                   class="btn btn-xs btn-success" title="Εργασίες">
                                                    <i class="fa fa-tasks"></i>
                                                </a>
                                                <button class="btn btn-xs btn-danger delete-service" 
                                                        data-id="<?= $list['id'] ?>" 
                                                        data-customer="<?= $cust->name ?? '' ?>"
                                                        title="Διαγραφή">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <em class="text-muted">Δεν βρέθηκαν επισκευές</em>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-warning text-danger"></i> Επιβεβαίωση Διαγραφής</h4>
            </div>
            <div class="modal-body">
                <p>Είστε σίγουροι ότι θέλετε να διαγράψετε την επισκευή για τον πελάτη <strong id="customer-name"></strong>;</p>
                <p class="text-danger"><small><i class="fa fa-warning"></i> Αυτή η ενέργεια δεν μπορεί να αναιρεθεί.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ακύρωση</button>
                <a href="#" id="confirm-delete" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Διαγραφή
                </a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#servicesTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Greek.json'
        },
        pageLength: 25,
        order: [[3, 'desc']], // Ταξινόμηση κατά ημ/νία παραλαβής (νεότερα πρώτα)
        columnDefs: [
            { targets: [8], orderable: false } // Ενέργειες δεν ταξινομούνται
        ]
    });

    // Delete confirmation
    $(document).on('click', '.delete-service', function() {
        var serviceId = $(this).data('id');
        var customerName = $(this).data('customer');
        
        $('#customer-name').text(customerName);
        $('#confirm-delete').attr('href', '<?= base_url("admin/services/delete/") ?>' + serviceId);
        $('#deleteModal').modal('show');
    });

    // Export functions
    $('#export-excel').click(function() {
        table.button('.buttons-excel').trigger();
    });

    $('#export-pdf').click(function() {
        table.button('.buttons-pdf').trigger();
    });

    $('#print-list').click(function() {
        window.print();
    });

    // Load statistics
    loadServiceStatistics();
});

function loadServiceStatistics() {
    $.get('<?= base_url("admin/services/get_service_statistics") ?>', function(data) {
        $('#pending-services').text(data.pending || 0);
        $('#delayed-services').text(data.delayed || 0);
        $('#completed-services').text(data.completed || 0);
    });
}
</script>