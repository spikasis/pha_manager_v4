<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Στατιστικά Στοιχεία <?php echo $year ?> -<?php echo $sp->city; ?></h1>            
        </div><!-- /.col-lg-12 -->
    <?php if ($this->session->flashdata('message')): ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('message') ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
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
                            <div class="huge"><?php echo json_encode($total_all) ?></div>
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
    </div><!-- /.row -->
    </div><!-- /.row -->

    
    <!-- Dropdown for year selection -->
    <div class="row" >
        <div class="col-lg-6">
            <div class="dropdown" style="float: left;">
                <button class="btn btn-primary dropdown-toggle" type="button" id="yearDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Επιλέξτε Έτος
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="yearDropdown">
                    <li><a href="#" class="year-select" data-year="all">Συνολικά Στοιχεία</a></li>
        <?php for ($i = 2014; $i <= date('Y'); $i++): ?>
                    <li><a href="#" class="year-select" data-year="<?= $i ?>"><?= $i ?></a></li>
        <?php endfor; ?>
                </ul>
            </div>            
        </div>    
    <!-- Dropdown menu for selecting the chart -->
    
    <div class="col-lg-6">
            <div class="dropdown" style="float: right;">
                <button class="btn btn-primary dropdown-toggle" type="button" id="chartDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Επιλέξτε Γράφημα
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="chartDropdown">
                    <li><a href="#" class="chart-select" data-chart="chart_monthly">Μηνιαίες Πωλήσεις Ακουστικών</a></li>
                    <li><a href="#" class="chart-select" data-chart="chart_manufacturer">Πωλήσεις ανα Κατασκευαστή</a></li>
                    <li><a href="#" class="chart-select" data-chart="chart_visits">Μηνιαίες Ενημερώσεις</a></li>
                    <li><a href="#" class="chart-select" data-chart="chart_doctor">Πωλήσεις ανα Ιατρό</a></li>
                    <li><a href="#" class="chart-select" data-chart="stockChart">Στατιστικά Ακουστικών</a></li>
                </ul>
            </div>
        </div>
    </div><!-- /.row -->

    <!-- Chart Containers -->
    <div class="row">
        <div class="col-lg-12">
            <div id="chart_monthly" class="chart-container"></div>
            <div id="chart_manufacturer" class="chart-container" style="display:none;"></div>
            <div id="chart_visits" class="chart-container" style="display:none;"></div>
            <div id="chart_doctor" class="chart-container" style="display:none;"></div>
            <div id="stockChart" class="chart-container" style="display:none;"></div>
        </div>
    </div><!-- /.row -->

    <script>
        $(document).ready(function () {
            // Function to toggle between charts
            $('.chart-select').on('click', function (e) {
                e.preventDefault();
                var selectedChart = $(this).data('chart');
                $('.chart-container').hide();  // Hide all charts
                $('#' + selectedChart).show();  // Show selected chart
            });

            // Initial chart rendering (e.g., chart_monthly is shown by default)
            $('#chart_monthly').show();
        });
    </script>
</div><!-- /#page-wrapper -->

<script>
    $(document).ready(function() {
        // Function to switch between charts
        $('.chart-select').on('click', function(event) {
            event.preventDefault();

            // Get the selected chart ID
            var selectedChart = $(this).data('chart');

            // Hide all chart containers
            $('.chart-container').hide();

            // Show the selected chart container
            $('#' + selectedChart).show();
        });

        // Monthly sales chart
        Highcharts.chart('chart_monthly', {
            chart: { type: 'column' },
            title: { text: 'Μηνιαίες Πωλήσεις Ακουστικών' },
            xAxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] },
            yAxis: {
                min: 0,
                title: { text: 'Τμχ Ακουστικών' }
            },
            series: [{
                name: 'Πωλήσεις',
                data: <?php echo $sales_graph ?>
            }, {
                name: 'Ενημερώσεις',
                data: <?php echo $nosales_graph ?>
            }]
        });

        // Manufacturer sales chart (pie)
        Highcharts.chart('chart_manufacturer', {
            chart: { type: 'pie' },
            title: { text: 'Πωλήσεις ανα Κατασκευαστή' },
            tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>' },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: { enabled: false },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Κατασκευαστές',
                colorByPoint: true,
                data: <?php echo $brands_graph ?>
            }]
        });

        // Visits chart (line)
        Highcharts.chart('chart_visits', {
            chart: { type: 'line' },
            title: { text: 'Μηνιαίες Ενημερώσεις (Ενδιαφερόμενοι και Πωλήσεις)' },
            xAxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] },
            yAxis: {
                min: 0,
                title: { text: 'Τμχ Ακουστικών' }
            },
            series: [{
                name: 'Επισκέπτες',
                data: <?php echo $visits ?>
            }]
        });

        // Doctor chart (pie)
        Highcharts.chart('chart_doctor', {
            chart: { type: 'pie' },
            title: { text: 'Πωλήσεις ανα Ιατρό' },
            tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>' },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: { enabled: true },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Doctors',
                colorByPoint: true,
                data: <?php echo $doc_dat ?>
            }]
        });

        // Stock statistics by hearing aid type (bar)
        var totalStocks = 0;
        <?php if (!empty($stock_type_stats)): ?>
            <?php foreach ($stock_type_stats as $stat): ?>
                totalStocks += <?= $stat['total_stocks']; ?>;
            <?php endforeach; ?>
        <?php endif; ?>

        Highcharts.chart('stockChart', {
            chart: { type: 'bar' },
            title: { text: 'Στατιστικά Ακουστικών ανα Τύπο' },
            xAxis: {
                categories: [<?php if (!empty($stock_type_stats)): ?>
                    <?php foreach ($stock_type_stats as $stat): ?>
                        '<?= $stat['ha_type']; ?>',
                    <?php endforeach; ?>
                <?php endif; ?>]
            },
            yAxis: { title: { text: 'Σύνολο Ακουστικών' } },
            series: [{
                name: 'Σύνολο Ακουστικών',
                data: [<?php if (!empty($stock_type_stats)): ?>
                    <?php foreach ($stock_type_stats as $stat): ?>
                        <?= $stat['total_stocks']; ?>,
                    <?php endforeach; ?>
                <?php endif; ?>],
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        var percentage = (this.y / totalStocks * 100).toFixed(2);
                        return this.y + ' (' + percentage + '%)';
                    }
                }
            }]
        });
    });
</script>
<script>
    $(document).ready(function() {
    // Όταν επιλέγεται ένα έτος από το dropdown
    $('.year-select').on('click', function(e) {
        e.preventDefault();
        
        // Παίρνουμε το επιλεγμένο έτος από το data attribute
        var selectedYear = $(this).data('year');
        var sellingPoint = "<?= $selling_point ?>"; // Παίρνουμε το τρέχον σημείο πώλησης

        // Έλεγχος αν η επιλογή είναι για "Συνολικά Στοιχεία"
        if (selectedYear === "all") {
            window.location.href = "<?= base_url('admin/dashboard/') ?>" + sellingPoint;
        } else {
            // Ανακατεύθυνση στη σελίδα με το συγκεκριμένο έτος
            window.location.href = "<?= base_url('admin/dashboard/') ?>" + sellingPoint + '/' + selectedYear;
        }
    });
});

</script>


