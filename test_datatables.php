<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DataTables Test</title>
    
    <!-- Bootstrap CSS -->
    <link href="assets/sbadmin2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    
    <style>
        body { padding: 20px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <h1>DataTables Pagination Test</h1>
    
    <div class="test-section">
        <h3>Asset Loading Test</h3>
        <div id="asset-status">
            <p>📦 <strong>jQuery:</strong> <span id="jquery-status">Checking...</span></p>
            <p>📊 <strong>DataTables:</strong> <span id="datatables-status">Checking...</span></p>
            <p>🎨 <strong>Bootstrap:</strong> <span id="bootstrap-status">Checking...</span></p>
        </div>
    </div>
    
    <div class="test-section">
        <h3>Demo Test Table</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="testTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Model</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 1; $i <= 25; $i++): ?>
                    <tr>
                        <td>HA<?= str_pad($i, 4, '0', STR_PAD_LEFT) ?></td>
                        <td>Test Model <?= $i ?></td>
                        <td><?= date('d/m/Y', strtotime("-{$i} days")) ?></td>
                        <td>€<?= number_format(500 + ($i * 10), 2) ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary">View</button>
                            <button class="btn btn-sm btn-warning">Edit</button>
                        </td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="test-section">
        <h3>Console Output</h3>
        <div id="console-output" style="background: #f8f9fa; padding: 10px; font-family: monospace; min-height: 100px;">
            Console messages will appear here...
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="assets/sbadmin2/vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Redirect console.log to our display
    const originalLog = console.log;
    const originalError = console.error;
    
    function addToConsole(message, type = 'log') {
        const output = document.getElementById('console-output');
        const timestamp = new Date().toLocaleTimeString();
        const color = type === 'error' ? 'red' : (type === 'warn' ? 'orange' : 'black');
        output.innerHTML += `<div style="color: ${color}">[${timestamp}] ${message}</div>`;
        output.scrollTop = output.scrollHeight;
    }
    
    console.log = function(...args) {
        originalLog.apply(console, args);
        addToConsole(args.join(' '), 'log');
    };
    
    console.error = function(...args) {
        originalError.apply(console, args);
        addToConsole(args.join(' '), 'error');
    };
    
    // Test asset loading
    console.log('🚀 Starting asset loading test...');
    
    // Check jQuery
    if (typeof $ !== 'undefined') {
        $('#jquery-status').html('✅ Loaded (version: ' + $.fn.jquery + ')').css('color', 'green');
        console.log('✅ jQuery loaded successfully');
    } else {
        $('#jquery-status').html('❌ Not loaded').css('color', 'red');
        console.error('❌ jQuery not loaded');
    }
    
    // Check DataTables
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#datatables-status').html('✅ Loaded').css('color', 'green');
        console.log('✅ DataTables loaded successfully');
        
        // Initialize test table
        console.log('🔧 Initializing test DataTable...');
        
        try {
            const table = $('#testTable').DataTable({
                "language": {
                    "sEmptyTable": "Δεν βρέθηκαν δεδομένα στον πίνακα",
                    "sInfo": "Εμφάνιση _START_ έως _END_ από _TOTAL_ εγγραφές",
                    "sInfoEmpty": "Εμφάνιση 0 έως 0 από 0 εγγραφές",
                    "sInfoFiltered": "(φιλτράρισμα από _MAX_ συνολικές εγγραφές)",
                    "sLengthMenu": "Εμφάνιση _MENU_ εγγραφών",
                    "sLoadingRecords": "Φόρτωση...",
                    "sProcessing": "Επεξεργασία...",
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
                "columnDefs": [
                    {
                        "targets": -1,
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "responsive": true,
                "searching": true,
                "paging": true,
                "info": true
            });
            
            console.log('🎉 DataTable initialized successfully!');
            console.log('📄 Total rows:', table.data().count());
            
        } catch (error) {
            console.error('❌ Error initializing DataTable:', error);
        }
        
    } else {
        $('#datatables-status').html('❌ Not loaded').css('color', 'red');
        console.error('❌ DataTables not loaded');
    }
    
    // Check Bootstrap
    if (typeof $.fn.modal !== 'undefined') {
        $('#bootstrap-status').html('✅ Loaded').css('color', 'green');
        console.log('✅ Bootstrap loaded successfully');
    } else {
        $('#bootstrap-status').html('❌ Not loaded').css('color', 'red');
        console.error('❌ Bootstrap not loaded');
    }
    
    console.log('✅ Asset loading test completed');
});
</script>

</body>
</html>