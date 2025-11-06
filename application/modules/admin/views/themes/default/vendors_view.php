<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Καρτέλα Προμηθευτή</h2>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Εταιρία: <strong><?php echo $vendor->name ?></strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="POST" action="<?= base_url('admin/vendors/edit/' . $vendor->id) ?>">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <tbody>
                                        <tr>                                            
                                            <th>Ετος</th>                                            
                                            <th>Τεμάχια</th>   
                                            <th>Ποσοστό Αγοράς</th>
                                            <th>Σύνολο Αγορών Έτους</th>
                                            <th>Εκτελεσμένα</th>
                                            <th>Τζιρος προ Rebate</th>
                                        </tr>
                                        <?php for ($year; $year <= $year_now; $year++) {
                                            
                                            $this->load->model(array('admin/chart'));
                                            $this->load->model(array('admin/stock'));
                                                                                        
                                            
                                            $hearin_aids_count = $this->chart->get_vendor_stats_year($vendor->id, $year); 
                                            //$hearing_aids_count = $this->chart->get_stocks_by_vendor($vendor->id, $year);
                                            
                                            $eopyy_year = $this->stock->get_all('COUNT(id) AS data','vendor=' . $vendor->id . ' AND eopyy<>0 AND YEAR(day_out)=' . $year);
                                            
                                            $year_sum = $this->stock->get_all('COUNT(id) AS data', 'YEAR(stocks.day_out)=' . $year);
                                            $ha_count[] = $hearin_aids_count[0]->data;
                                            $years[] = $year; 
                                            ?>
                                        <tr>                                            
                                            <td><a href="<?= base_url('admin/stocks/view_vendors_stock/' . $vendor->id . '/' . $year) ?>" class="media"><?= $year ?></a></td> 
                                            <td><?= $hearin_aids_count[0]->data?></td>      
                                            <td><?= round(($hearin_aids_count[0]->data)/(($year_sum[0]->data +1)))?>%</td>
                                            <td><?= $year_sum[0]->data ?></td>
                                            <td><?= $eopyy_year[0]['data'] ?></td>
                                            <td><?= $eopyy_year[0]['data']*450?></td>
                                            
                                        </tr> 
                                                                              
                                        <?php } ?>
                                    </tbody> 
                                </table>
                                <?php 
                                            $ha_count2 = str_replace('"', '', json_encode($ha_count));
                                            //echo ($ha_count2);  
                                            //echo json_encode($years);
                                       ?> 
                            <a  href="<?= base_url('admin/vendors') ?>" class="btn btn-warning hidden-print">Πίσω</a>                        
                        </div>
                        <div class="col-lg-6">
                            <div id="chart_year" ><?php for ($year; $year <= $year_now; $year++) {echo $stats[$year]['hearin_aids_count'];}  ?></div>                                
                        </div>
                    </div><!-- /.row (nested) -->                        
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->  
</div><!-- /#page-wrapper -->
<script>        
    $(function () {
        var year_chart = Highcharts.chart('chart_year', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Ετήσιες Πωλήσεις Ακουστικών'
            },
            xAxis: {
                categories: <?php echo json_encode($years); ?>
            },
            yAxis: {
                title: {
                    text: 'Τεμαχια Ακουστικών'
                }
            },
            series: [{
                    name: 'ΤΜΧ',
                    data: <?php echo $ha_count2 ?>                
                }]
        });
    });     
</script>
