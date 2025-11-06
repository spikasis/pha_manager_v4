<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2>Καρτέλα Ιατρού</h2>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Ονοματεπώνυμο Ιατρού: <strong><?php echo $doctor->doc_name ?></strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form class="no-print" role="form" method="POST" action="<?= base_url('admin/doctors/edit/' . $doctor->id) ?>">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <tbody>
                                        <tr>                                            
                                            <th>Ετος</th>
                                            <th>Χαμένα</th>
                                            <th>Κλεισμένα</th>
                                            <th>Συνολο Συστάσεων</th>
                                            <th>Ποσοστό Επιτυχίας</th>
                                            <th>Ποσοστό Ασθενών (Επι συνόλου)</th>
                                            <th>Σύνολο Έτους</th>
                                            <th>Σύνολο Έτους ($$)</th>
                                        </tr>
                                        <?php $doc = $this->doctor->get($doctor->id);?>
                                        <?php for ($year; $year <= $year_now; $year++) {
                                            
                                            $this->load->model(array('admin/chart'));
                                            $this->load->model(array('admin/stock'));
                                            
                                            $patients_yes = $this->stock->get_all('*', 'doctor_id =' . $doctor->id . ' AND YEAR(day_out) =' . $year);
                                            //$patients_yes = $this->chart->get_doc_stats($year, $doctor->id, 1);
                                            
                                            $patients_no = $this->chart->get_doc_stats($year, $doctor->id, 3);
                                            
                                            //$sum = $this->stock->get_all('*', 'YEAR(day_out) =' . $year);
                                            //$sum = $this->chart->get_year_sum($year);                                           
                                            
                                            $years[] = $year;
                                            $yes[] = count($patients_yes);
                                            $no[] = count($patients_no); 
                                            $year_sum[] = $sum[0]->data;
                                            ?>
                                        <tr>
                                            <td><a href="<?= base_url('admin/customers/view_doctors_customers/' . $doctor->id . '/' . $year) ?>" class="no-print"><?= $year ?></a></td> 
                                            <td><?= count($patients_no)?></td>
                                            <td><?= count($patients_yes) ?></td>
                                            <td><?= count($patients_no)+count($patients_yes) ?></td>
                                            <td><?= round((count($patients_yes))/(count($patients_no)+count($patients_yes)+0.000001)*100)?>%</td>
                                            <td><?= round((count($patients_yes))/(($sum[0]->data)+0.000001)*100)?>%</td>
                                            <td><?= $sum[0]->data?></td>
                                            <td>€ <?= count($patients_yes)*$doc->doc_price?></td>
                                        </tr> 
                                        <?php } ?>
                                    </tbody> 
                                </table>
                            <a  href="<?= base_url('admin/doctors') ?>" class="btn btn-warning hidden-print">Πίσω</a>                        
                        </div>
                        <div class="col-lg-6">
                            <div id="chart_year" ><?php for ($year; $year <= $year_now; $year++) {echo $stats[$year]['patients_yes'];}  ?></div>                                
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
                text: 'Ετήσια Ροή Περιστατικών'
            },
            xAxis: {
                categories: <?php echo json_encode($years) ?>
            },
            yAxis: {
                title: {
                    text: 'Περιστατικά Ιατρού'
                }
            },
            series: [{
                    name: 'Συστάσεις',
                    data: <?php echo json_encode($yes) ?>
                }, {
                    name: 'Χαμένα',
                    data: <?php echo json_encode($no)?>
                }]
        });
    });     
</script>
