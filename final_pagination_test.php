<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <title>Final Pagination Test - Exact Demo Structure</title>
    
    <!-- Exact same CSS as real system -->
    <link href="assets/sbadmin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/sbadmin2/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    
    <style>
        body { padding: 20px; background: #f8f9fc; }
        .test-info { 
            background: #fff; 
            padding: 15px; 
            margin-bottom: 20px; 
            border: 1px solid #e3e6f0; 
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="test-info">
        <h3>🔍 Final Test: Exact Demo Structure</h3>
        <p>This replicates the exact HTML structure and JavaScript from the real demo view.</p>
        <div id="test-log"></div>
    </div>

    <!-- EXACT COPY OF TRIAL SECTION FROM REAL DEMO -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-user-check"></i> Ακουστικά Προς Δοκιμή
                        <span class="badge badge-success ml-2">15</span>
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="trialTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="trial-available-tab" data-toggle="tab" 
                                    data-target="#trial-available" type="button" role="tab">
                                <i class="fas fa-check-circle text-success"></i> 
                                Διαθέσιμα <span class="badge badge-light ml-1">10</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="trial-inuse-tab" data-toggle="tab" 
                                    data-target="#trial-inuse" type="button" role="tab">
                                <i class="fas fa-user-clock text-warning"></i> 
                                Σε Δοκιμή <span class="badge badge-light ml-1">5</span>
                            </button>
                        </li>
                    </ul>
                    
                    <!-- Tab Content -->
                    <div class="tab-content mt-3" id="trialTabsContent">
                        <!-- Available Trial Items -->
                        <div class="tab-pane fade show active" id="trial-available" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="trialAvailableTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Μοντέλο</th>
                                            <th>Ημ. Εισαγωγής</th>
                                            <th>Τιμή</th>
                                            <th>Σχόλια</th>
                                            <th>Ενέργειες</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i = 1; $i <= 15; $i++): ?>
                                        <tr>
                                            <td><strong>TRIAL-<?= str_pad($i, 3, '0', STR_PAD_LEFT) ?></strong></td>
                                            <td>Test Manufacturer - Series <?= $i ?> - Model <?= $i ?></td>
                                            <td><?= date('d/m/Y', strtotime("-{$i} days")) ?></td>
                                            <td>
                                                <span class="badge badge-info">€<?= number_format(500 + ($i * 50), 2) ?></span>
                                            </td>
                                            <td>Test comment <?= $i ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" 
                                                            data-toggle="dropdown">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-user-plus"></i> Ανάθεση σε Πελάτη
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-eye"></i> Προβολή
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Trial Items In Use -->
                        <div class="tab-pane fade" id="trial-inuse" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="trialInUseTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Πελάτης</th>
                                            <th>Μοντέλο</th>
                                            <th>Ημ. Παράδοσης</th>
                                            <th>Μέρες Δοκιμής</th>
                                            <th>Status</th>
                                            <th>Ενέργειες</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i = 1; $i <= 8; $i++): ?>
                                        <tr>
                                            <td><strong>INUSE-<?= str_pad($i, 3, '0', STR_PAD_LEFT) ?></strong></td>
                                            <td>Customer <?= $i ?></td>
                                            <td>Test Model <?= $i ?></td>
                                            <td><?= date('d/m/Y', strtotime("-{$i} days")) ?></td>
                                            <td><span class="badge badge-success"><?= $i ?> μέρες</span></td>
                                            <td><span class="badge badge-success">Εντάξει</span></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm">Return</button>
                                                <button class="btn btn-info btn-sm">View</button>
                                            </td>
                                        </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EXACT SAME JAVASCRIPT INCLUDES AS REAL SYSTEM -->
<script src="assets/sbadmin2/vendor/jquery/jquery.min.js"></script>
<script src="assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- EXACT SAME JAVASCRIPT LOGIC AS REAL DEMO VIEW -->
<script>
$(document).ready(function() {
    function logTest(message) {
        const log = document.getElementById('test-log');
        const time = new Date().toLocaleTimeString();
        log.innerHTML += `<div>[${time}] ${message}</div>`;
    }
    
    // Wait a bit more to ensure everything is loaded
    setTimeout(function() {
        initializeDemoTables();
    }, 1000);
    
    function initializeDemoTables() {
        logTest('=== STARTING DEMO TABLES INITIALIZATION ===');
        
        // Check jQuery
        if (typeof $ === 'undefined') {
            logTest('❌ jQuery is not loaded!');
            return;
        }
        logTest('✅ jQuery version: ' + $.fn.jquery);
        
        // Check DataTables
        if (typeof $.fn.DataTable === 'undefined') {
            logTest('❌ DataTables library is not loaded!');
            return;
        }
        logTest('✅ DataTables is available');
        
        // Debug: Check if tables exist in DOM
        const tableSelectors = [
            '#trialAvailableTable',
            '#trialInUseTable'
        ];
        
        logTest('🔍 Checking table existence:');
        tableSelectors.forEach(selector => {
            const exists = $(selector).length > 0;
            const rows = exists ? $(selector + ' tbody tr').length : 0;
            logTest(`  ${selector}: ${exists ? '✅ EXISTS' : '❌ MISSING'} (${rows} rows)`);
        });
        
        // Initialize visible tables first
        initializeVisibleTables();
        
        // Setup tab handlers
        setupTabHandlers();
    }
    
    function initializeVisibleTables() {
        // Find currently active tabs
        const activeTrialTab = $('#trialTabs .nav-link.active').attr('data-target');
        
        logTest('🎯 Active trial tab: ' + activeTrialTab);
        
        // Initialize tables in active tabs
        if (activeTrialTab === '#trial-available') {
            initializeTable('trialAvailableTable');
        } else if (activeTrialTab === '#trial-inuse') {
            initializeTable('trialInUseTable');
        }
    }
    
    function initializeTable(tableId) {
        const $table = $('#' + tableId);
        
        if ($table.length === 0) {
            logTest(`⚠️ Table ${tableId} not found`);
            return false;
        }
        
        try {
            // Destroy existing instance if it exists
            if ($.fn.DataTable.isDataTable('#' + tableId)) {
                logTest(`🔄 Destroying existing ${tableId} instance`);
                $table.DataTable().destroy();
            }
            
            logTest(`🔧 Initializing ${tableId}...`);
            
            const config = {
                "paging": true,
                "pageLength": 5, // Small page size to force pagination
                "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Όλα"]],
                "searching": true,
                "info": true,
                "autoWidth": false,
                "language": {
                    "emptyTable": "Δεν βρέθηκαν δεδομένα",
                    "info": "Εμφάνιση _START_ έως _END_ από _TOTAL_ εγγραφές",
                    "lengthMenu": "Εμφάνιση _MENU_ εγγραφών",
                    "search": "Αναζήτηση:",
                    "paginate": {
                        "next": "Επόμενη",
                        "previous": "Προηγούμενη"
                    }
                },
                "columnDefs": [{
                    "targets": -1,
                    "orderable": false
                }]
            };
            
            const dataTable = $table.DataTable(config);
            logTest(`✅ ${tableId} initialized with ${dataTable.rows().count()} rows`);
            logTest(`📄 Pagination should now be visible below the table!`);
            return true;
            
        } catch (error) {
            logTest(`❌ Failed to initialize ${tableId}: ${error.message}`);
            console.error('Full error:', error);
            return false;
        }
    }
    
    function setupTabHandlers() {
        // Handle tab switching for trial tabs
        $('#trialTabs a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            const target = $(e.target).attr('data-target');
            logTest(`🔄 Trial tab switched to: ${target}`);
            
            setTimeout(function() {
                if (target === '#trial-available') {
                    initializeTable('trialAvailableTable');
                } else if (target === '#trial-inuse') {
                    initializeTable('trialInUseTable');
                }
                
                // Adjust visible tables
                try {
                    $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
                    logTest('📏 Table columns adjusted');
                } catch (error) {
                    logTest('⚠️ Column adjust error: ' + error.message);
                }
            }, 100);
        });
    }
});
</script>

</body>
</html>