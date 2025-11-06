<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Αναφορά Κατασκευαστή</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="form-group">
                    <label for="manufacturer_id">Κατασκευαστής:</label>
                    <select id="manufacturer_id" class="form-control" onchange="loadData()">
                        <option value="0">-- Όλοι --</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-2 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3 text-center">
                                <i class="fa fa-clock-o fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge" id="avg_delay">-</div>
                                <div>Καθυστέρηση (τρέχον έτος)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3 text-center">
                                <i class="fa fa-list fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge" id="total_stocks">-</div>
                                <div>Σύνολο Ακουστικών</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3 text-center">
                                <i class="fa fa-wrench fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge" id="multi_repairs">-</div>
                                <div>Πάνω από 1 Επισκευή</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3 text-center">
                                <i class="fa fa-calendar fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge" id="avg_repair_days">-</div>
                                <div>Μ.Ο. ημέρες μέχρι 1η επισκευή</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-2 col-md-6">
                 <div class="panel panel-default">
                     <div class="panel-heading">
                         <div class="row">
                             <div class="col-xs-3">
                                 <i class="fa fa-exclamation-triangle fa-3x"></i>
                             </div>
                             <div class="col-xs-9 text-right">
                                 <div class="huge" id="specific_issue_count">-</div>
                                 <div>Ενισχυτές εντος Εγγύησης</div>
                             </div>
                         </div>
                     </div>
                 </div>                    
             </div>
        </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Πωλήσεις Ανά Έτος & Ποσοστά
            </div>
            <div class="panel-body">
                <canvas id="sales_chart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-pie-chart fa-fw"></i> Ανάλυση Επισκευών ανά Κατηγορία
            </div>
            <div class="panel-body">                
                <table class="table table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th>Κατηγορία / Υποκατηγορία</th>
                            <th>Πλήθος</th>
                            <th>% Επί Συνόλου</th>
                    </thead>
                    <tbody id="category_repairs_table"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-table fa-fw"></i> Αναλυτικός Πίνακας Επισκευών ανά Μοντέλο
                        <div class="pull-right" style="display: flex; gap: 10px; align-items: center;">
                            <select id="series_filter" class="form-control input-sm" onchange="filterRepairsTable()">
                                <option value="">-- Φίλτρο Σειράς --</option>
                            </select>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-download"></i> Export <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#" onclick="exportTableToCSV()">CSV</a></li>
                                    <li><a href="#" onclick="exportToPDF()">PDF</a></li>
                                    <li><a href="#" onclick="exportToExcel()">Excel</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive" id="repairs_table"></div>
                    </div>
                </div>
            </div>
        </div>

</div>


<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function loadManufacturers() {
    $.getJSON('<?= base_url("admin/ManufacturerReport/list_manufacturers") ?>', function(data) {
        let select = $('#manufacturer_id');
        select.empty().append('<option value="">-- Επιλέξτε --</option>');
        $.each(data, function(i, item) {
            select.append(`<option value="${item.id}">${item.name}</option>`);
        });
    });
}

function loadData() {
    const selectedId = $('#manufacturer_id').val();
    const manufacturerId = selectedId === "0" ? "" : selectedId;

    const url = manufacturerId
        ? '<?= base_url("admin/ManufacturerReport/data/") ?>' + manufacturerId
        : '<?= base_url("admin/ManufacturerReport/data") ?>';

    $.getJSON('<?= base_url("admin/ManufacturerReport/data/") ?>' + manufacturerId, function(data) {
        $('#avg_delay').text(data.avg_order_diff.avg_days_diff + ' ημέρες');
        $('#total_stocks').text(data.extra_kpis.total_stocks);
        $('#avg_repair_days').text(data.extra_kpis.avg_repair_days + ' ημέρες');
        $('#multi_repairs').text(data.extra_kpis.multi_repair_count);
        $('#specific_issue_count').text(data.specific_issue_count);

        
const ctx = document.getElementById('sales_chart').getContext('2d');
const years = data.sales_per_year.map(item => item.year);
const manufacturerPercent = data.sales_per_year.map(item => item.percent_of_total);
const othersPercent = manufacturerPercent.map(p => +(100 - p).toFixed(2));

if (window.salesChartInstance) {
    window.salesChartInstance.destroy();
}

window.salesChartInstance = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: years,
        datasets: [
            {
                label: 'Εταιρία',
                data: manufacturerPercent,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                stack: 'stack100'
            },
            {
                label: 'Λοιποί',
                data: othersPercent,
                backgroundColor: 'rgba(200, 200, 200, 0.5)',
                stack: 'stack100'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(ctx) {
                        return ctx.dataset.label + ': ' + ctx.parsed.y + '%';
                    }
                }
            },
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: 'Ποσοστά Πωλήσεων Ανά Έτος (100%)'
            }
        },
        interaction: {
            mode: 'index',
            intersect: false
        },
        scales: {
            x: {
                stacked: true
            },
            y: {
                stacked: true,
                min: 0,
                max: 100,
                title: {
                    display: true,
                    text: '% Επί Συνόλου'
                },
                ticks: {
                    callback: function(value) {
                        return value + '%';
                    }
                }
            }
        }
    }
});

        

        
        let categoryTable = '';
        let currentCategory = '';
        const total = parseInt(data.extra_kpis.total_stocks);
        
        data.repairs_by_category.forEach(row => {
            if (row.category_name !== currentCategory) {
                currentCategory = row.category_name;
                categoryTable += `<tr class="active"><td colspan="3"><strong>${currentCategory}</strong></td></tr>`;
            }
            const percent = total > 0 ? ((row.repair_count / total) * 100).toFixed(1) : '0.0';
            categoryTable += `
                    <tr>
            <td style="padding-left: 20px;">${row.subcategory_name}</td>
            <td>${row.repair_count}</td>
            <td>${percent}%</td>
        </tr>`;
            });
            
            $('#category_repairs_table').html(categoryTable);
            
            
        let seriesSet = new Set();
        let tableHtml = `
            <table id="repairs_export" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Σειρά</th>
                        <th>Μοντέλο</th>
                        <th>Επισκευές</th>
                        <th>Στοκ</th>
                        <th>% Επισκευών</th>
                    </tr>
                </thead>
                <tbody>`;

        data.repairs.forEach(function(row) {
            const rate = Math.round((row.number_of_repairs / row.model_count) * 1000) / 10;
            const bg = rate >= 60 ? ' style="background-color:#f2dede"' : '';
            seriesSet.add(row.series);
            tableHtml += `
                <tr${bg}>
                    <td>${row.series}</td>
                    <td>${row.hearing_aid_model}</td>
                    <td>${row.number_of_repairs}</td>
                    <td>${row.model_count}</td>
                    <td>${rate}%</td>
                </tr>`;
        });

        tableHtml += '</tbody></table>';
        $('#repairs_table').html(tableHtml);

        let select = $('#series_filter');
        select.empty().append('<option value="">-- Φίλτρο Σειράς --</option>');
        Array.from(seriesSet).sort().forEach(function(series) {
            select.append(`<option value="${series}">${series}</option>`);
        });
    });
}

function filterRepairsTable() {
    const selectedSeries = $('#series_filter').val();
    $('#repairs_export tbody tr').each(function() {
        const series = $(this).find('td:first').text().trim();
        if (!selectedSeries || series === selectedSeries) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

function exportTableToCSV() {
    const table = document.getElementById("repairs_export");
    let csv = [];
    for (let row of table.rows) {
        let rowData = [];
        for (let cell of row.cells) {
            rowData.push(cell.innerText);
        }
        csv.push(rowData.join(","));
    }
    let csvString = csv.join("\n");
    let a = document.createElement('a');
    a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvString);
    a.target = '_blank';
    a.download = 'repairs_report.csv';
    a.click();
}

$(document).ready(function() {
    loadManufacturers();
});

function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.setFontSize(14);
    doc.text("Αναφορά Κατασκευαστή", 14, 16);
    doc.autoTable({ html: '#repairs_export', startY: 22 });
    doc.save("manufacturer_report.pdf");
}

function exportToExcel() {
    let table = document.getElementById("repairs_export");
    let wb = XLSX.utils.table_to_book(table, {sheet: "Repairs"});
    XLSX.writeFile(wb, "manufacturer_report.xlsx");
}

$(document).ready(function() {
    loadManufacturers();
    $('#manufacturer_id').val("0");  // προεπιλογή σε "Όλοι"
    loadData();                      // αυτόματη φόρτωση dashboard χωρίς φίλτρο
});


</script>
