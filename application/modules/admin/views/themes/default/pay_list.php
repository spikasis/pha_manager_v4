<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
                <h2>Πληρωμές Δόσεων
                    <!--<a style="float: right; align-self: center;"  href="<?= base_url('admin/pays/create') ?>" class="btn btn-success">Προσθήκη Νέας Πληρωμής</a>-->
                </h2>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Λίστα Πληρωμών</div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Πελάτης</th>
                                    <th>Ημερομηνία</th> 
                                    <th>Ακουστικό</th>
                                    <th>Ποσό</th> 
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $empty = 'not set';
                                if (count($pay)):
                                    foreach ($pay as $key => $list):
                                        if (isset($list['customer'])) {
                                            $customer = $this->customer->get($list['customer']);
                                        }
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?= $list['id'] ?></td>
                                            <td>
                                            <?php 
                                            if(isset($customer->name)){                                
                                                echo $customer->name;                                
                                                }
                                            else
                                            {echo 'not set';}
                                            ?>
                                            </td>                                            
                                            <td><?= $list['date'] ?></td> 
                                            <td><?= $list['hearing_aid'] ?></td>
                                            <td><?= $list['pay'] ?></td>
                                            <td style="width: 270px">
                                                <a href="<?= base_url('admin/pays/edit/' . $list['id']) ?>" class="btn btn-info">edit</a>  
                                                <a href="<?= base_url('admin/pays/delete/' . $list['id']) ?>" class="btn btn-danger">delete</a>
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
                    </div><div id="chart_monthly"></div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
</div><!-- /#page-wrapper -->
<script type="text/javascript">
    $(function () {
        var month_chart = Highcharts.chart('chart_monthly', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Μηνιαίες Εισπράξεις (στατιστικά όλων των ετών)'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {text: 'Τμχ Ακουστικών'}, 
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
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
            series: [{
                    name: 'Εισπράξεις',
            data: <?php echo $pays ?>
        }]
        });
    });
</script>