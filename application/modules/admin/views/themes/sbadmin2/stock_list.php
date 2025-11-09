<!-- Morris.js -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<!-- Bootstrap (αν δεν υπάρχει ήδη) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div id="page-wrapper">    
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>
                    <?php echo $title ?>                    
                    <a  href="<?= base_url('admin/stocks/create') ?>" class="btn btn-success" style="float: right">Προσθήκη Νέου</a>                    
                </h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->      
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">Λίστα Αποθήκης Ακουστικών</div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" sortable="day_out">
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
                                
                                <?php
                                //echo json_encode($stock);
                                
                                $empty = 'not set';
                                if (count($stock)):
                                    foreach ($stock as $key => $list):
                                    //echo json_encode($list);
                                    /*
                                    if (isset($list['customer_id'])) {
                                            $customer = $this->customer->get($list['customer_id']);
                                        }                                        
                                       
                                        $type = $this->ha_type->get($list['type']);  
                                        $status = $this->stock_status->get($list['status']);
                                        $selling_point = $this->selling_point->get($list['selling_point']);
                                        
                                        $ha_model = $this->model->get($list['ha_model']);
                                        $ha_series = $this->serie->get($ha_model->series);
                                        $ha_type = $this->ha_type->get($ha_model->ha_type);
                                        $manufacturer = $this->manufacturer->get($ha_series->brand);
                                        $battery = $this->battery_type->get($ha_model->battery);
                                    */   
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?= $list['doctor_id'] ?></td>
                                            <td><?= $list['serial'] ?></td>
                                            <td><?= $list['customer_name'] ?></td>
                                            <td><?= $list['day_in'] ?></td>
                                            <td><?= $list['day_out'] ?></td>                                            
                                            <td><?= $list['manufacturer_name'] ?> - <?= $list['series_name'] ?> <?= $list['model_name'] ?> - <?= $list['ha_type'] ?></td>                                            
                                            <td><?= $list['battery_type'] ?></td>
                                            <td><?= $list['stock_status'] ?></td>
                                            <td><?= $list['selling_point_city'] ?></td>
                                            <td><?= $list['ekapty_code']?></td>
                                            <td><?= $list['ektelesi_eopyy']?></td>                                            
                                            <td style="width: 100px;">
                                                <div class="action-buttons" style="display: flex; align-items: center;">
                                                    <a href="<?= base_url('admin/stocks/edit/' . $list['id']) ?>" title="Επεξεργασία" style="margin-right: 10px;">
                                                        <i class="fas fa-pencil-alt"></i> <!-- Εικονίδιο για επεξεργασία -->
                                                    </a>
                                                    <a href="<?= base_url('admin/stocks/view/' . $list['id']) ?>" title="Προβολή" style="margin-right: 10px;">
                                                        <i class="fas fa-eye"></i> <!-- Εικονίδιο για προβολή -->
                                                    </a>
                                                    <a href="<?= base_url('admin/stocks/delete/' . $list['id']) ?>" title="Διαγραφή" style="margin-right: 10px;">
                                                        <i class="fas fa-trash-alt"></i> <!-- Εικονίδιο για διαγραφή -->
                                                    </a>
                                                    <a href="<?= base_url('admin/stocks/eggyisi_doc/' . $list['id']) ?>" title="Εγγύηση" style="margin-right: 10px;">
                                                        <i class="fas fa-file-alt"></i> <!-- Εικονίδιο για εγγύηση -->
                                                    </a>
                                                    <a href="<?= base_url('admin/stocks/ha_doc/' . $list['id']) ?>" title="Ετικέτα" style="margin-right: 10px;">
                                                        <i class="fas fa-tag"></i> <!-- Εικονίδιο για ετικέτα -->
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="even gradeC">
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>No data</td>
                                        <td>
                                            <a href="#" class="btn btn-info">edit</a>  
                                            <a href="#" class="btn btn-danger">delete</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>                    
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
        <!-- Modal -->
        <div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chartModalLabel">Γράφημα Αποθήκης</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modal-bar-chart" style="height: 400px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /#page-wrapper -->
    <!-- Modal Button στο κάτω μέρος της σελίδας -->
    <div class="text-center" style="margin-top: 20px;">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chartModal">
            Προβολή Γραφήματος
        </button>
    </div>
</div>   

<script>
    // Extract data from PHP and format for Morris.js
    var chartData = <?php echo json_encode($chart_data); ?>;
    
    // Render Morris.js bar chart when the modal opens
    $('#chartModal').on('shown.bs.modal', function () {
        // Initialize Morris.js bar chart in the modal
        new Morris.Bar({
            element: 'modal-bar-chart',
            data: chartData,
            xkey: 'model_name',
            ykeys: ['model_count'],
            labels: ['Model Count'],
            hideHover: 'auto',
            resize: true
        });
    });

    // Clear the chart when the modal is closed to avoid re-rendering issues
    $('#chartModal').on('hidden.bs.modal', function () {
        // Clear the chart container
        $('#modal-bar-chart').empty();
    });

    // Initialize DataTables for modern functionality
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Όλα"]],
            "pageLength": 25,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "language": {
                "lengthMenu": "Εμφάνιση _MENU_ εγγραφών ανά σελίδα",
                "zeroRecords": "Δε βρέθηκαν εγγραφές",
                "info": "Εμφανίζονται _START_ έως _END_ από _TOTAL_ εγγραφές",
                "infoEmpty": "Εμφανίζονται 0 έως 0 από 0 εγγραφές",
                "infoFiltered": "(φιλτραρισμένες από _MAX_ συνολικές εγγραφές)",
                "search": "Αναζήτηση:",
                "paginate": {
                    "first": "Πρώτη",
                    "last": "Τελευταία", 
                    "next": "Επόμενη",
                    "previous": "Προηγούμενη"
                }
            }
        });
    });
</script>





