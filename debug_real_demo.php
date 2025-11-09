<?php
/**
 * Real Demo Page Diagnostic Script
 * Προσομοιώνει την πραγματική συμπεριφορά του demo controller
 */

echo "<h1>🔍 Real Demo Page - Pagination Diagnostic</h1>";
echo "<hr>";

// Simulate the actual demo page loading process
echo "<h2>📋 Step-by-Step Demo Page Analysis</h2>";

// Step 1: Check if we can access the demo controller
echo "<h3>1. Controller Access Test</h3>";
$demo_url = "http://localhost:8000/admin/stocks/get_demo";
echo "<p>Testing URL: <a href='$demo_url' target='_blank'>$demo_url</a></p>";

// Step 2: Check the actual view file being loaded
echo "<h3>2. View File Analysis</h3>";
$view_file = "application/modules/admin/views/themes/sbadmin2/stock_list_demo_new.php";
if (file_exists($view_file)) {
    $content = file_get_contents($view_file);
    echo "<p>✅ <strong>View File Exists:</strong> $view_file</p>";
    echo "<p><strong>File Size:</strong> " . round(filesize($view_file)/1024, 2) . " KB</p>";
    
    // Check for key DataTables elements
    $has_script_tag = strpos($content, '<script>') !== false;
    $has_datatable_init = strpos($content, 'DataTable(') !== false;
    $has_greek_config = strpos($content, 'sEmptyTable') !== false;
    $has_table_ids = strpos($content, 'trialAvailableTable') !== false;
    
    echo "<p><strong>Key Elements Check:</strong></p>";
    echo "<ul>";
    echo "<li>Script Tag: " . ($has_script_tag ? "✅ FOUND" : "❌ MISSING") . "</li>";
    echo "<li>DataTable Init: " . ($has_datatable_init ? "✅ FOUND" : "❌ MISSING") . "</li>";
    echo "<li>Greek Config: " . ($has_greek_config ? "✅ FOUND" : "❌ MISSING") . "</li>";
    echo "<li>Table IDs: " . ($has_table_ids ? "✅ FOUND" : "❌ MISSING") . "</li>";
    echo "</ul>";
} else {
    echo "<p>❌ <strong>View File NOT FOUND:</strong> $view_file</p>";
}

// Step 3: Check the controller method
echo "<h3>3. Controller Method Analysis</h3>";
$controller_file = "application/modules/admin/controllers/stocks.php";
if (file_exists($controller_file)) {
    $controller_content = file_get_contents($controller_file);
    echo "<p>✅ <strong>Controller File Exists</strong></p>";
    
    $has_get_demo = strpos($controller_content, 'function get_demo') !== false;
    $has_custom_js = strpos($controller_content, '$data[\'custom_js\']') !== false;
    
    echo "<ul>";
    echo "<li>get_demo() Method: " . ($has_get_demo ? "✅ EXISTS" : "❌ MISSING") . "</li>";
    echo "<li>custom_js Variable: " . ($has_custom_js ? "✅ SET" : "❌ NOT SET") . "</li>";
    echo "</ul>";
} else {
    echo "<p>❌ <strong>Controller File NOT FOUND</strong></p>";
}

// Step 4: Assets availability check
echo "<h3>4. DataTables Assets Check</h3>";
$assets_to_check = [
    'assets/sbadmin2/vendor/jquery/jquery.min.js' => 'jQuery',
    'assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js' => 'DataTables Core',
    'assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js' => 'DataTables Bootstrap',
    'assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css' => 'DataTables CSS'
];

foreach ($assets_to_check as $asset => $name) {
    if (file_exists($asset)) {
        $size = round(filesize($asset)/1024, 2);
        echo "<p>✅ <strong>$name:</strong> $asset (${size}KB)</p>";
    } else {
        echo "<p>❌ <strong>$name:</strong> $asset (NOT FOUND)</p>";
    }
}

echo "<h3>5. Live JavaScript Test</h3>";
echo "<div id='js-test-area'>";
echo "<p>Testing jQuery and DataTables loading in real-time...</p>";
echo "<div id='test-results'></div>";
echo "</div>";

// Step 6: Create a mini reproduction of the actual demo page
echo "<h3>6. Mini Demo Table Test</h3>";
echo "<div class='card'>";
echo "<div class='card-body'>";
echo "<table class='table table-bordered' id='miniDemoTable'>";
echo "<thead><tr><th>Serial</th><th>Model</th><th>Status</th><th>Actions</th></tr></thead>";
echo "<tbody>";
for($i = 1; $i <= 20; $i++) {
    echo "<tr>";
    echo "<td>DEMO-" . str_pad($i, 3, '0', STR_PAD_LEFT) . "</td>";
    echo "<td>Test Model $i</td>";
    echo "<td><span class='badge badge-success'>Available</span></td>";
    echo "<td><button class='btn btn-sm btn-primary'>View</button></td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";

echo "<h3>7. Expected vs Actual Behavior</h3>";
echo "<div style='display: grid; grid-template-columns: 1fr 1fr; gap: 20px;'>";
echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 5px;'>";
echo "<h4>✅ Expected (Working)</h4>";
echo "<ul>";
echo "<li>Pagination controls visible</li>";
echo "<li>\"Εμφάνιση X εγγραφών\" dropdown</li>";
echo "<li>Search box functional</li>";
echo "<li>Page navigation buttons</li>";
echo "<li>Greek language interface</li>";
echo "</ul>";
echo "</div>";
echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px;'>";
echo "<h4>❌ Actual (Current Issue)</h4>";
echo "<ul>";
echo "<li>No pagination controls</li>";
echo "<li>All records shown at once</li>";
echo "<li>Τεράστια λίστα without breaks</li>";
echo "<li>No length menu options</li>";
echo "<li>JavaScript not initializing tables</li>";
echo "</ul>";
echo "</div>";
echo "</div>";

echo "<h3>8. Debugging Actions</h3>";
echo "<div style='background: #d1ecf1; padding: 15px; border-radius: 5px;'>";
echo "<ol>";
echo "<li><strong>Check Browser Console:</strong> Open Developer Tools (F12) → Console tab</li>";
echo "<li><strong>Look for JavaScript Errors:</strong> Any red error messages?</li>";
echo "<li><strong>Verify Asset Loading:</strong> Network tab → Check if all JS/CSS files load with 200 status</li>";
echo "<li><strong>Test DataTables Manually:</strong> Try running <code>$('#tablename').DataTable()</code> in console</li>";
echo "</ol>";
echo "</div>";

?>

<!-- Include the actual assets that should be loaded -->
<link href="assets/sbadmin2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<script src="assets/sbadmin2/vendor/jquery/jquery.min.js"></script>
<script src="assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    const results = document.getElementById('test-results');
    
    function log(message, type = 'info') {
        const color = type === 'error' ? 'red' : (type === 'success' ? 'green' : 'blue');
        results.innerHTML += `<div style="color: ${color}; font-family: monospace;">[${new Date().toLocaleTimeString()}] ${message}</div>`;
    }
    
    log('🚀 Starting real-time diagnostic...', 'info');
    
    // Test 1: jQuery
    if (typeof $ !== 'undefined') {
        log('✅ jQuery loaded successfully (v' + $.fn.jquery + ')', 'success');
    } else {
        log('❌ jQuery NOT loaded', 'error');
        return;
    }
    
    // Test 2: DataTables
    if (typeof $.fn.DataTable !== 'undefined') {
        log('✅ DataTables loaded successfully', 'success');
    } else {
        log('❌ DataTables NOT loaded', 'error');
        return;
    }
    
    // Test 3: Initialize mini table
    try {
        log('🔧 Attempting to initialize mini demo table...', 'info');
        
        const table = $('#miniDemoTable').DataTable({
            "language": {
                "sEmptyTable": "Δεν βρέθηκαν δεδομένα στον πίνακα",
                "sInfo": "Εμφάνιση _START_ έως _END_ από _TOTAL_ εγγραφές",
                "sLengthMenu": "Εμφάνιση _MENU_ εγγραφών",
                "sSearch": "Αναζήτηση:",
                "oPaginate": {
                    "sNext": "Επόμενη",
                    "sPrevious": "Προηγούμενη"
                }
            },
            "pageLength": 5,
            "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Όλα"]],
            "paging": true,
            "searching": true,
            "info": true
        });
        
        log('🎉 SUCCESS! Mini table initialized with ' + table.data().count() + ' rows', 'success');
        log('📄 Pagination should now be visible below the mini table', 'success');
        
    } catch (error) {
        log('❌ ERROR initializing mini table: ' + error.message, 'error');
    }
    
    // Test 4: Check what happens on the real page
    log('🔍 Next step: Compare this working example with your demo page', 'info');
    log('➡️ If mini table above has pagination but demo page doesn\'t, there\'s a specific issue in the demo view', 'info');
});
</script>

<hr>
<div style="text-align: center; padding: 20px; background: #fff3cd; border-radius: 5px;">
    <h3>🎯 Next Steps</h3>
    <p><strong>1.</strong> Check if mini table above shows pagination</p>
    <p><strong>2.</strong> Compare with actual demo page: <a href="http://localhost:8000/admin/stocks/get_demo" target="_blank">Open Demo Page</a></p>
    <p><strong>3.</strong> Open browser console (F12) on demo page and look for JavaScript errors</p>
    <p><strong>4.</strong> Report back what you see in both cases</p>
</div>