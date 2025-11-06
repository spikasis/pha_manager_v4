<div ></div>
<div id="page-wrapper" align="justify" lang="el" >
    <div class="row">        
        <h2 style="align-content: center">Στατιστικά Πωλήσεων Έτους <?php echo $year ?></h2>
        <div>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <th> ΚΑΤΑΣΚΕΥΑΣΤΗΣ</th>               
                <th> TMX</th>
                          <?php if (count($manufacturer_statistics)): ?>
                        <?php foreach ($manufacturer_statistics as $key => $list): ?>
                <tr>
                    <td><?php echo $list['brand'] ?></td>
                    <td><?php echo $list['data'] ?></td>
                </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
            </table>
        </div>  
    </div>
    <div class="row">
    <table class="table-bordered table-responsive table-condensed" >
        <tr>
            <td><div id='chart_monthly'></div></td>
            <td><div id='chart_manufacturer' ></div></td>
        </tr>
        <tr>
            <td><div id='chart_doctor' ></div></td>
            <td><div id='chart_vendor' ></div></td>
        </tr>        
        </tbody>
    </table>  
    <!-- 
    <div id='chart_monthly'></div>
    <div id='chart_manufacturer' ></div>
    <div id='chart_doctor' ></div>
    <div id='chart_vendor' ></div>
    
    -->
    </div>
</div>
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
                    data: <?php echo $sales ?>
                }, {
                    name: 'Χαμένα',
                    data: <?php echo $nosales ?>
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
            series: [{name: 'Brands', data: <?php echo $brands ?>}],
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
            series: [{name: 'Brands', data: <?php echo $doctors ?>}],
        });
        var vendors_chart = Highcharts.chart('chart_vendor', {
            chart: {type: 'pie'},
            title: {text: 'Πωλήσεις ανα Προμηθευτή'},
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
            series: [{name: 'Brands', data: <?php echo $vendors ?>}],
        });
    });
</script>