<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-microscope text-primary"></i> Demo Ακουστικά - Debug Version
        </h1>
    </div>

    <!-- Simple Demo Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table"></i> Demo Table Test
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="demoTestTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Model</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($trial_available) && !empty($trial_available)): ?>
                                    <?php foreach ($trial_available as $item): ?>
                                        <tr>
                                            <td><?= $item['serial'] ?? 'TEST-001' ?></td>
                                            <td><?= ($item['manufacturer_name'] ?? 'Test') . ' - ' . ($item['model_name'] ?? 'Model') ?></td>
                                            <td><?= isset($item['day_in']) ? date('d/m/Y', strtotime($item['day_in'])) : date('d/m/Y') ?></td>
                                            <td><span class="badge badge-success">Available</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">View</button>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Generate test data if no real data -->
                                    <?php for($i = 1; $i <= 15; $i++): ?>
                                        <tr>
                                            <td>TEST-<?= str_pad($i, 3, '0', STR_PAD_LEFT) ?></td>
                                            <td>Test Manufacturer - Test Model <?= $i ?></td>
                                            <td><?= date('d/m/Y', strtotime("-{$i} days")) ?></td>
                                            <td><span class="badge badge-<?= ($i % 2 == 0) ? 'success' : 'warning' ?>">
                                                <?= ($i % 2 == 0) ? 'Available' : 'In Use' ?>
                                            </span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">View</button>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Debug Info -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Debug Information</h6>
                </div>
                <div class="card-body">
                    <div id="debug-info">
                        <p><strong>Custom JS:</strong> <?= isset($custom_js) ? 'YES' : 'NO' ?></p>
                        <p><strong>Trial Available Count:</strong> <?= isset($trial_available) ? count($trial_available) : '0' ?></p>
                        <p><strong>Current Time:</strong> <?= date('Y-m-d H:i:s') ?></p>
                    </div>
                    
                    <div id="js-debug" style="background: #f8f9fa; padding: 10px; margin-top: 15px; font-family: monospace; min-height: 100px;">
                        <strong>JavaScript Debug Output:</strong><br>
                        <div id="js-output">Waiting for JavaScript...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($custom_js)): ?>
<script>
$(document).ready(function() {
    function debugLog(message) {
        const output = document.getElementById('js-output');
        const timestamp = new Date().toLocaleTimeString();
        output.innerHTML += `<br>[${timestamp}] ${message}`;
    }
    
    debugLog('🚀 Starting DataTable initialization...');
    
    // Check if DataTables is available
    if (typeof $.fn.DataTable === 'undefined') {
        debugLog('❌ ERROR: DataTables library not loaded!');
        return;
    }
    debugLog('✅ DataTables library detected');
    
    // Check if table exists
    if ($('#demoTestTable').length === 0) {
        debugLog('❌ ERROR: Target table #demoTestTable not found!');
        return;
    }
    debugLog('✅ Target table found');
    
    try {
        // Simple DataTable initialization
        const table = $('#demoTestTable').DataTable({
            "language": {
                "sEmptyTable": "Δεν βρέθηκαν δεδομένα στον πίνακα",
                "sInfo": "Εμφάνιση _START_ έως _END_ από _TOTAL_ εγγραφές",
                "sInfoEmpty": "Εμφάνιση 0 έως 0 από 0 εγγραφές",
                "sInfoFiltered": "(φιλτράρισμα από _MAX_ συνολικές εγγραφές)",
                "sLengthMenu": "Εμφάνιση _MENU_ εγγραφών",
                "sSearch": "Αναζήτηση:",
                "sZeroRecords": "Δεν βρέθηκαν εγγραφές που να ταιριάζουν",
                "oPaginate": {
                    "sFirst": "Πρώτη",
                    "sLast": "Τελευταία",
                    "sNext": "Επόμενη",
                    "sPrevious": "Προηγούμενη"
                }
            },
            "pageLength": 10,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Όλα"]],
            "order": [[0, "asc"]],
            "searching": true,
            "paging": true,
            "info": true,
            "responsive": true
        });
        
        debugLog('🎉 SUCCESS: DataTable initialized successfully!');
        debugLog(`📊 Table contains ${table.data().count()} rows`);
        
    } catch (error) {
        debugLog('❌ ERROR initializing DataTable: ' + error.message);
        console.error('DataTable error:', error);
    }
});
</script>
<?php endif; ?>