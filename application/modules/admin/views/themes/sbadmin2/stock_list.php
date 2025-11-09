<!-- Morris.js CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<!-- Note: Morris.js scripts will be loaded after jQuery in the footer -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-boxes text-primary"></i> <?= $title ?>
        </h1>
        <a href="<?= base_url('admin/stocks/create') ?>" class="btn btn-success shadow-sm hidden-print">
            <i class="fas fa-plus fa-sm text-white-50"></i> Προσθήκη Νέου
        </a>
    </div>

    <!-- DataTables Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i> Λίστα Αποθήκης Ακουστικών
            </h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#chartModal">
                <i class="fas fa-chart-bar"></i> Προβολή Γραφήματος
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="stocksTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ΔΟΚΤΟΡ No</th>
                            <th>Serial No</th>
                            <th>Πελάτης</th>
                            <th>Εισαγωγή</th>
                            <th>Ημ/νια Πώλησης</th>
                            <th>Μοντέλο Ακουστικού</th>                                    
                            <th>Μπαταρία</th> 
                            <th>Κατάσταση</th>
                            <th>Σημείο Πώλησης</th>
                            <th>Barcode ΕΟΠΥΥ</th>
                            <th>Εκτέλεση ΕΟΠΥΥ</th>                                                                       
                            <th>Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($stock)): ?>
                            <?php foreach ($stock as $key => $list): ?>
                                <tr>
                                    <td><?= $list['doctor_id'] ?></td>
                                    <td><?= $list['serial'] ?></td>
                                    <td><?= $list['customer_name'] ?></td>
                                    <td><?= $list['day_in'] ?></td>
                                    <td><?= $list['day_out'] ?></td>                                            
                                    <td><?= $list['manufacturer_name'] ?> - <?= $list['series_name'] ?> <?= $list['model_name'] ?> - <?= $list['ha_type'] ?></td>                                            
                                    <td><?= $list['battery_type'] ?></td>
                                    <td>
                                        <?php
                                        // Helper function για badges
                                        $status = strtolower(trim($list['stock_status']));
                                        $badge_class = 'light';
                                        switch ($status) {
                                            case 'διαθέσιμο':
                                            case 'available':
                                            case 'onstock':
                                                $badge_class = 'success';
                                                break;
                                            case 'πωλήθηκε':
                                            case 'sold':
                                                $badge_class = 'primary';
                                                break;
                                            case 'επιστροφή':
                                            case 'return':
                                            case 'returns':
                                                $badge_class = 'warning';
                                                break;
                                            case 'service':
                                                $badge_class = 'info';
                                                break;
                                            case 'demo':
                                                $badge_class = 'secondary';
                                                break;
                                            case 'ελαττωματικό':
                                            case 'defected':
                                            case 'μαύρη λίστα':
                                            case 'blacklist':
                                                $badge_class = 'danger';
                                                break;
                                        }
                                        ?>
                                        <span class="badge badge-<?= $badge_class ?>">
                                            <?= $list['stock_status'] ?>
                                        </span>
                                    </td>
                                    <td><?= $list['selling_point_city'] ?></td>
                                    <td><?= $list['ekapty_code'] ?></td>
                                    <td><?= $list['ektelesi_eopyy'] ?></td>                                            
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/stocks/view/'.$list['id']) ?>" 
                                               class="btn btn-sm btn-info" title="Προβολή">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/stocks/edit/'.$list['id']) ?>" 
                                               class="btn btn-sm btn-warning" title="Επεξεργασία">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" 
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Περισσότερες Ενέργειες">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?= base_url('admin/stocks/eggyisi_doc/'.$list['id']) ?>">
                                                        <i class="fas fa-file-alt"></i> Εγγύηση
                                                    </a>
                                                    <a class="dropdown-item" href="<?= base_url('admin/stocks/ha_doc/'.$list['id']) ?>">
                                                        <i class="fas fa-tag"></i> Ετικέτα
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="<?= base_url('admin/stocks/delete/'.$list['id']) ?>"
                                                       onclick="return confirm('Είστε σίγουροι για τη διαγραφή;')">
                                                        <i class="fas fa-trash"></i> Διαγραφή
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="12" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Δεν βρέθηκαν εγγραφές αποθήκης
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart Modal -->
    <div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chartModalLabel">
                        <i class="fas fa-chart-bar text-primary"></i> Γράφημα Αποθήκης
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modal-bar-chart" style="height: 400px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Κλείσιμο
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Page Content -->

<script>
$(document).ready(function() {
    // Extract data from PHP and format for Morris.js
    <?php if (isset($chart_data) && !empty($chart_data)): ?>
    var chartData = <?php echo json_encode($chart_data); ?>;
    
    // Render Morris.js bar chart when the modal opens
    $('#chartModal').on('shown.bs.modal', function () {
        // Initialize Morris.js bar chart in the modal
        if (typeof Morris !== 'undefined') {
            new Morris.Bar({
                element: 'modal-bar-chart',
                data: chartData,
                xkey: 'model_name',
                ykeys: ['model_count'],
                labels: ['Model Count'],
                hideHover: 'auto',
                resize: true
            });
        } else {
            console.log('Morris.js is not loaded');
            $('#modal-bar-chart').html('<div class="text-center text-muted p-4"><i class="fas fa-exclamation-triangle fa-3x mb-2"></i><br>Σφάλμα φόρτωσης γραφήματος</div>');
        }
    });
    <?php else: ?>
    // No chart data available
    $('#chartModal').on('shown.bs.modal', function () {
        $('#modal-bar-chart').html('<div class="text-center text-muted p-4"><i class="fas fa-chart-bar fa-3x mb-2"></i><br>Δεν υπάρχουν δεδομένα γραφήματος</div>');
    });
    <?php endif; ?>

    // Clear the chart when the modal is closed to avoid re-rendering issues
    $('#chartModal').on('hidden.bs.modal', function () {
        // Clear the chart container
        $('#modal-bar-chart').empty();
    });
});
</script>

<?php if (isset($custom_js)): ?>
<script>
    <?php echo $custom_js; ?>
</script>
<?php endif; ?>





