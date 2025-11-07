<div id="page-wrapper" align="justify" lang="el">
    <div class="row">
        <h2 style="align-content: center">Στατιστικά επισκευών-βλαβών εταιρίας <?php echo $brand->name ?></h2>
        <!-- Dropdown for selecting Manufacturer -->
        <div class="col-lg-1">
            <label for="manufacturerDropdown">Επιλογή Κατασκευαστή:</label>
            <select id="manufacturerDropdown" class="form-control">
                <?php foreach ($manufacturers as $manufacturer): ?>
                <option value="<?= base_url('admin/service_tickets/service_stats/' . $manufacturer['id']) ?>" 
                        <?= $manufacturer['id'] == $brand->id ? 'selected' : '' ?>>
                        <?= $manufacturer['name'] ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-lg-7">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <th>ΣΤΑΤΙΣΤΙΚΑ ΕΠΙΣΚΕΥΩΝ σε σύνολο</th>               
                <th><?php echo json_encode(count($fittings)) ?> εφαρμογών</th> 
                <th>Ποσοστό</th>
                <tr>
                    <td>Μεγάφωνα</td>
                    <td><?php echo json_encode(count($receivers)) ?></td>
                    <td><?php echo round(((count($receivers))/count($fittings))*100, 2) ?>%</td>
                </tr>
                <tr>
                    <td>Μικρόφωνα</td>
                    <td><?php echo json_encode(count($microphones)) ?></td>
                    <td><?php echo round(((count($microphones))/count($fittings))*100, 2) ?>%</td>
                </tr>
                <tr>
                    <td>Ενισχυτές</td>
                    <td><?php echo json_encode(count($amplifiers)) ?></td>
                    <td><?php echo round(((count($amplifiers))/count($fittings))*100, 2) ?>%</td>
                </tr>
                <tr>
                    <td>Επανακατασκευές Εργαστηρίου (Αφορά Αντιπρόσωπο)</td>
                    <td><?php echo json_encode(count($earmolds_redesign)) ?></td>
                    <td><?php echo round(((count($earmolds_redesign))/count($fittings))*100, 2) ?>%</td>
                </tr>
                <tr>
                    <td>Καθαρισμοί Μικρόφωνα/Μεγάφωνα</td>
                    <td><?php echo json_encode(count($cleaning)) ?></td>
                    <td><?php echo round(((count($cleaning))/count($fittings))*100, 2) ?>%</td>
                </tr>
            </table>
        </div>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#repairStatsModal">
    Γράφημα Επισκευών Ανά Κατασκευαστή
</button>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#repairStatsModalSeries">
    Γράφημα Επισκευών Ανά Σειρά Ακουστικών
</button>

<!-- Manufacturer Modal -->
<div class="modal fade" id="repairStatsModal" tabindex="-1" role="dialog" aria-labelledby="repairStatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="repairStatsModalLabel">Στατιστικά Επισκευών Ανά Κατασκευαστή</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="repairCategory">Επιλέξτε Κατηγορία Επισκευής:</label>
                    <select id="repairCategory" class="form-control">
                        <option value="receivers">Μεγάφωνα</option>
                        <option value="microphones">Μικρόφωνα</option>
                        <option value="amplifiers">Ενισχυτές</option>
                        <option value="earmolds_redesign">Επανακατασκευές</option>
                        <option value="cleaning">Καθαρισμοί</option>
                    </select>
                </div>
                <div id="repairChart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Series Modal -->
<div class="modal fade" id="repairStatsModalSeries" tabindex="-1" role="dialog" aria-labelledby="repairStatsModalSeriesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="repairStatsModalSeriesLabel">Στατιστικά Επισκευών Ανά Σειρά Ακουστικών</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="repairCategory">Επιλέξτε Κατηγορία Επισκευής:</label>
                    <select id="repairCategory" class="form-control">
                        <option value="receivers">Μεγάφωνα</option>
                        <option value="microphones">Μικρόφωνα</option>
                        <option value="amplifiers">Ενισχυτές</option>
                        <option value="earmolds_redesign">Επανακατασκευές</option>
                        <option value="cleaning">Καθαρισμοί</option>
                    </select>
                </div>
                <div id="repairChartSeries"></div>
            </div>
        </div>
    </div>
</div>

</div>
<script>
    // Ανανεώνει τη σελίδα με βάση την επιλογή κατασκευαστή από το dropdown
    document.getElementById('manufacturerDropdown').addEventListener('change', function() {
        window.location.href = this.value;
    });
    

    // When the modal is shown for Manufacturer repairs, render the manufacturer chart
    $('#repairStatsModal').on('shown.bs.modal', function () {
        renderChartByManufacturer($('#repairCategory').val());
    });
    
    // When the modal is shown for Series repairs, render the series chart
    $('#repairStatsModalSeries').on('shown.bs.modal', function () {
        renderChartBySeries($('#repairCategory').val());
    });
    
    // Re-render the chart when a new category is selected from the dropdown (for both manufacturer and series)
    $('#repairCategory').on('change', function () {
        renderChartByManufacturer($(this).val());  // For Manufacturer Chart
        renderChartBySeries($(this).val());        // For Series Chart
        
    });
    
    // Function to render the Highcharts chart based on the selected category for manufacturers
    function renderChartByManufacturer(category) {
        $.ajax({
            url: "<?= base_url('admin/service_tickets/get_repair_data') ?>",
            type: "POST",
            data: { category: category },
            success: function (data) {
                let parsedData = JSON.parse(data);
                
        // Check if data is empty
        if (parsedData.length === 0) {
            $('#repairChart').html('<p class="text-center">Δεν υπάρχουν δεδομένα για την επιλεγμένη κατηγορία επισκευής.</p>');
            return;
        }
        
        let manufacturers = [];
        let repairPercentages = [];
        
        parsedData.forEach(function (item) {
            let repairPercentage = (parseInt(item.repair_count) / parseInt(item.total_fittings)) * 100;
            manufacturers.push(item.name);
            repairPercentages.push(repairPercentage.toFixed(2));  // Store percentage, rounded to 2 decimal places
        });
        
        Highcharts.chart('repairChart', {
            chart: { type: 'bar' },
            title: { text: 'Ποσοστό Επισκευών Ανά Κατασκευαστή (ως ποσοστό επί των συνολικών εφαρμογών)' },
            xAxis: { categories: manufacturers },
            yAxis: {
                title: { text: 'Ποσοστό Επισκευών (%)' },
                labels: {
                    formatter: function () {
                        return this.value + '%';  // Append '%' to y-axis labels
                    }
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y:.2f}%</b>',
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true,
                formatter: function() {
                    return this.y + '%';  // Show percentage in data labels
                    }
                }
            }
        },
        series: [{
                name: 'Ποσοστό Επισκευών',
                data: repairPercentages.map(Number)  // Convert the percentages to numbers
                }]
        });
    }
});
}       
        
        
// Function to render the Highcharts chart based on the selected category for series
function renderChartBySeries(category) {
    $.ajax({
        url: "<?= base_url('admin/service_tickets/get_series_repair_data') ?>",
        type: "POST",
        data: { category: category },
        success: function (data) {
            let parsedData = JSON.parse(data);

            if (parsedData.length === 0) {
                $('#repairChartSeries').html('<p class="text-center">Δεν υπάρχουν δεδομένα για την επιλεγμένη κατηγορία επισκευής.</p>');
                return;
            }

            let seriesNames = [];
            let repairPercentages = [];

            parsedData.forEach(function (item) {
                let repairPercentage = (parseInt(item.repair_count) / parseInt(item.total_fittings)) * 100;
                seriesNames.push(item.series_name);
                repairPercentages.push(repairPercentage.toFixed(2));
            });

            Highcharts.chart('repairChartSeries', {
                chart: { type: 'bar' },
                title: { text: 'Ποσοστό Επισκευών Ανά Σειρά Ακουστικών (ως ποσοστό επί των συνολικών εφαρμογών)' },
                xAxis: { categories: seriesNames },
                yAxis: {
                    title: { text: 'Ποσοστό Επισκευών (%)' },
                    labels: {
                        formatter: function () {
                            return this.value + '%';
                        }
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.2f}%</b>',
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return this.y + '%';
                            }
                        }
                    }
                },
                series: [{
                    name: 'Ποσοστό Επισκευών',
                    data: repairPercentages.map(Number)
                }]
            });
        }
    });
}

</script>