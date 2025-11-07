<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Στατιστικά Στοιχεία <?php echo $year ?></h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="row">
        <?php if ($this->session->flashdata('message')): ?>
        <div class="col-lg-12 col-md-12">
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $this->session->flashdata('message') ?>
            </div>
        </div>
        <?php endif; ?>        
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check-square fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $sales[0]['data'] ?></div>
                            <div>Πωλήσεις Ετους</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/customers/view_customer_list/' . $year . '/' . $selling_point) ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $debt[0]['data'] ?></div>
                            <div>Οφειλές Έτους</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/stocks/view_stock_on_debt/' . $year . '/' . $selling_point)?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bomb fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $no_sales[0]['data'] ?></div>
                            <div>Χαμένα</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/customers/get_interested_list/' . $year . '/' . $selling_point) ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-barcode fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $avg_price[0]['data'] ?></div>
                            <div>Μέση Τιμή Έτους (Πώλησης)</div>
                        </div>
                    </div>
                </div>
                <a href="">
                    <div class="panel-footer">
                        <span class="pull-left">Λεπτομέρειες</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div id='chart_monthly'></div>
        </div>    
        <div class="col-lg-6 col-md-6">
            <div id='chart_manufacturer'></div>
        </div>    
        <div class="col-lg-6 col-md-6">
            <div id='chart_doctor'></div>
        </div>    
        <div class="col-lg-6 col-md-6">
            <div id='chart_visits'></div>
        </div>  
        <!--
        <table class="table-bordered table-responsive table-condensed">
            <tr>
                <td><div id='chart_monthly'></div></td>
                <td><div id='chart_manufacturer' ></div></td>
            </tr>
            <tr>
                <td><div id='chart_doctor' ></div></td>
                <td><div id='chart_visits' ></div></td>
            </tr>        
            </tbody>
        </table> 
        -->
    </div>
</div><!-- /#page-wrapper -->
<script type="text/javascript">
    $(function () {
        var month_chart = Highcharts.chart('chart_monthly', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Μηνιαίες Πωλήσεις Ακουστικών'
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
                    name: 'Πωλήσεις',
                    data: <?php echo $sales_graph ?>
                }, {
                    name: 'Χαμένα',
                    data: <?php echo $nosales_graph ?>
                }]
        });

        var brand_chart = Highcharts.chart('chart_manufacturer', {
            chart: {type: 'pie'},
            title: {text: 'Μηνιαίες Πωλήσεις Ακουστικών ανα Κατασκευαστή'},
            tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{name: 'Brands', data: <?php echo $brands_graph ?>}],
        });

        var doctors_chart = Highcharts.chart('chart_doctor', {
            chart: {type: 'pie'},
            title: {text: 'Μηνιαία περιστατικά ανα Ιατρό'},
            tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true
                    },
                    showInLegend: false
                }
            },
            series: [{name: 'Brands', data: <?php echo $doctors_graph ?>}],
        });
        var month_chart = Highcharts.chart('chart_visits', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Μηνιαίες Ενημερώσεις (Ενδιαφερόμενοι και Πωλήσεις)'
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
                    name: 'Επισκέπτες',
                    data: <?php echo $visits ?>
                }]
        });
    });
</script>
