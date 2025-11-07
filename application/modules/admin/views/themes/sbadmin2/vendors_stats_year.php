<div id="page-wrapper">
    <div class="row">
        <table style="width: 100%">
            <td style="float: left"><div class="col-lg-8"><img src="<?= base_url() ?>images/logo_pha.png" style="height: 80px" alt="logo"/></div></td>
            <td style="float: center">www.pikasishearing.gr</td>
            <td style="float: right">
                <div class=""><strong><?php echo $company->company_name   ?></strong></div>
                <div class="">Διεύθυνση: <?php echo $company->address   ?></div>
                <div class="">Τηλέφωνο: <?php echo $company->phone   ?></div>
            </td>
        </table>       
    </div>
    <p><br></p><p><br></p>
    <h2 style="align-content: center">Μηνιαία Στατιστικά <?php echo $vendors->name ?></h2>
    <p><br></p>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   Στατιστικά Στοιχεία Προμηθευτή Συνολικά
                   <a href="<?= base_url('admin/vendors/stats/'. $vendors->id) ?>" class="btn btn-info" style="float: right">Πίσω</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                                       <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Επωνυμία</th>
                                    <th>Αριθμός Τεμαχίων</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr class="odd gradeX">
                                     <td><?php echo $vendors->name?></td>
                                     <td><?php echo array_sum( explode( ',', $vendor_stats)) ?></td> 
                                 </tr>                                                              
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
        <div id="chart_monthly"><?php echo json_encode($vendor_year) ?></div>
    </div>
</div><!-- /#page-wrapper -->
<script type="text/javascript">
    $(function () {
        var month_chart = Highcharts.chart('chart_monthly', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Μηνιαίες Αγορές Ακουστικών απο <?php echo $vendors->name ?>'
            },
            xAxis: {
                categories: <?php echo json_encode($vendor_year) ?>
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
                    name: 'Ακουστικά - ΤΜΧ',
                    data: <?php echo $vendor_stats ?>
                }]
        });
    });
</script>