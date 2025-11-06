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
                                            <td style="width: 100px">                                                
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ενέργειες
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <!--<a href="<?= base_url('admin/services/create_this/' . $list['id']) ?>" class="btn btn-danger">Επισκευή</a><br>-->
                                                        <a href="<?= base_url('admin/stocks/edit/' . $list['id']) ?>" class="btn btn-warning">Επεξεργασία</a>
                                                        <a href="<?= base_url('admin/stocks/view/' . $list['id']) ?>" class="btn btn-info">Προβολή</a>
                                                        <a href="<?= base_url('admin/stocks/delete/' . $list['id']) ?>" class="btn btn-danger">Διαγραφή</a>
                                                        <a href="<?= base_url('admin/stocks/eggyisi_doc/' . $list['id']) ?>" class="btn btn-success" target="_blank">Εγγύηση</a>
                                                        <a href="<?= base_url('admin/stocks/ha_doc/' . $list['id']) ?>" class="btn btn-success" target="_blank">Ετικετα</a>
                                                    </div>
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
    </div>    
    <div id="bar-chart"></div>
</div><!-- /#page-wrapper -->
<script>
    // Extract data from PHP and format for Morris.js
    var chartData = <?php echo json_encode($chart_data); ?>;
    
    console.log(chartData); // Log the data to the console
    
    // Render Morris.js bar chart
    var barChart = new Morris.Bar({
        element: 'bar-chart',
        data: chartData,
        xkey: 'model_name',
        ykeys: ['model_count'],
        labels: ['Model Count'],
        hoverCallback: function(index, options, content, row) {
            var series = row.model_series ? 'Series: ' + row.model_series + '<br>' : '';
            var manufacturer = row.brand ? 'Manufacturer: ' + row.brand + '<br>' : '';
            return series + manufacturer + content;
        }
    });

    // No change event listener on the year filter dropdown

</script>

