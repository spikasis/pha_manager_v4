<div id="page-wrapper" align="justify" lang="el">
    <div class="row">
            <h2 style="align-content: center">Στατιστικά Ιατρών Έτους <?php echo $year ?></h2>        
        <div class="col-lg-4">
          <?php //echo json_encode($doctors) ?>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <th> Ιατρός</th>
                <!--<th> ΜΟΝΤΕΛΟ</th> -->
                <th> Ασθενείς </th>
                <!--<th> ΜΕΣΗ ΤΙΜΗ</th> -->
                <?php //if (count($patients)): ?>
                        <?php //foreach ($patients as $key => $list): ?>
                <tr>
                    <td><?php echo $doctor->doc_name ?></td>
                    <!--<td><?php //echo $list['name'] ?></td> -->
                    <td><?php echo count($patients)?></td>
                    <!--<td><?php //echo count($patients)?></td> -->
                </tr>
                    <? //endforeach; ?>
                        <? //endif; ?>
                <td></td>
            </table>
        </div>
        <div  class="col-lg-8">
            <div id='chart_manufacturer' ></div>
        </div>            
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
                title: {
                    text: 'Τμχ Ακουστικών'
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
                    showInLegend: true
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