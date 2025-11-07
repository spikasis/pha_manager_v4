<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>Συνεργάτες Ιατροί<a  href="<?= base_url('admin/doctors/create') ?>" class="btn btn-success" style="float: right">Νέος Ιατρός</a></h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Λίστα Ιατρών</div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Όνοματεπώνυμο</th>
                                    <th>Διεύθυνση</th>
                                    <th>Πόλη</th>
                                    <th>Τηλέφωνο</th> 
                                    <th>Τιμή</th>
                                    <th>Περιστατικά <?php echo $year ?></th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $this->load->model(array('admin/chart'));?>
                                <?php if (count($doctors)): ?>
                                    <?php foreach ($doctors as $key => $list): ?>
                                        <tr class="odd gradeX">
                                            <td><?=$list['doc_name']?></td>
                                            <td><?=$list['doc_address']?></td>
                                            <td><?=$list['doc_city']?></td>
                                            <td><?=$list['doc_phone_work']?></td>
                                            <td>€<?=$list['doc_price']?></td> 
                                            <?php $patients = $this->chart->get_doc_stats($year, $list['id'], 1) ?>
                                            <td><?= count($patients) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/doctors/edit/'.$list['id']) ?>" class="btn btn-info no-print">Edit</a> 
                                                <a href="<?= base_url('admin/doctors/view/'.$list['id']) ?>" class="btn btn-info no-print">Stats</a>
                                                <a href="<?= base_url('admin/doctors/delete/'.$list['id']) ?>" class="btn btn-danger no-print">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="even gradeC">
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
                    <div id="chart_monthly"></div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div><!-- /#page-wrapper -->
<script type="text/javascript">
    $(function () {
        var month_chart = Highcharts.chart('chart_monthly', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    viewDistance: 25,
                    depth: 40
                }
            },
            title: {
                text: 'Μηνιαίες Συστάσεις Γιατρών έτους <?php echo $year ?>'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {text: 'Περιστατικά'}, 
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: 0,
                verticalAlign: 'right',
                y: 25,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: true
            },
            
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },        
            series: [
                <?php if (count($doctors)): 
                 foreach ($doctors as $key => $list): ?>
                                 {
                                     name: '<?php echo $list['doc_name'] ?>',
                                     data: <?php echo $doctor['v_' . $list['id']] ?>
                                 },
                                     <?php endforeach;
                                     endif; ?>]
        });
    });
</script>