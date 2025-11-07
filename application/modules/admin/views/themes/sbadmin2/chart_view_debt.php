<div id="page-wrapper">    
    <table class="table-bordered table-responsive table-condensed">
        <tr>
            <td><div id='chart_monthly'><?php echo $debt_data ?></div></td>
            <!--<td><div id='chart_manufacturer' ><?php //echo $balance_data ?></div></td>-->
        </tr>
        <tr>
            <!--<td><div id='chart_doctor' style="height: 300px"><?php //echo $eopyy_data ?></div></td>-->
            <!--<td><div id='chart_vendor' ></div></td>-->
        </tr>        
        </tbody>
        
    </table>    
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
                    name: 'Νέα Χρέη',
                    data: <?php echo $debt_data ?>
                }, {
                    name: 'Πληρωμές',
                    data: <?php //echo $debt_data->eopyy ?>
                }, {
                    name: 'ΕΟΠΥΥ',
                    data: <?php //echo $debt_data->balance ?>
                }]
        });

        /*
        var brand_chart = Highcharts.chart('chart_manufacturer', {
            chart: {type: 'pie'},
            title: {text: 'Κατασκευές Εργαστηρίου ανα Τύπο'},
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
            series: [{name: 'Brands', data: <?php //echo $debt_data ?>}],
        });

        var doctors_chart = Highcharts.chart('chart_doctor', {
            chart: {type: 'pie'},
            title: {text: 'Κατανομή Κατασκευών ανα Πελάτη'},
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
            series: [{name: 'Brands', data: <?php //echo $debt_data ?>}],
        });
        var vendors_chart = Highcharts.chart('chart_vendor', {
            chart: {type: 'pie'},
            title: {text: 'Κατανομή Κατασκευών (Δικές μας)'},
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
            series: [{name: 'Brands', data: <?php //echo $debt_data ?>}],
        });
        */
    });
</script>