<?php
/**
 * Test pagination για το demo view
 * URL: http://localhost:8000/test_demo_pagination.php
 */

echo "<h2>🔧 Demo View Pagination Test</h2>";
echo "<hr>";

echo "<h3>📋 Configuration Check</h3>";

// Check if DataTables assets exist
$datatables_css = "assets/sbladmin2/vendor/datatables/dataTables.bootstrap4.min.css";
$datatables_js = "assets/sbladmin2/vendor/datatables/jquery.dataTables.min.js";
$datatables_bootstrap = "assets/sbladmin2/vendor/datatables/dataTables.bootstrap4.min.js";

echo "<ul>";
echo "<li>DataTables CSS: " . (file_exists($datatables_css) ? "✅ EXISTS" : "❌ MISSING") . "</li>";
echo "<li>DataTables JS: " . (file_exists($datatables_js) ? "✅ EXISTS" : "❌ MISSING") . "</li>";
echo "<li>DataTables Bootstrap: " . (file_exists($datatables_bootstrap) ? "✅ EXISTS" : "❌ MISSING") . "</li>";
echo "</ul>";

echo "<hr>";

// Check view file
$view_file = "application/modules/admin/views/themes/sbadmin2/stock_list_demo_new.php";
if (file_exists($view_file)) {
    echo "<h3>✅ Demo View File Analysis</h3>";
    echo "<p><strong>File:</strong> $view_file</p>";
    
    $content = file_get_contents($view_file);
    
    // Check for DataTables initialization
    $datatables_init = strpos($content, 'DataTable(') !== false;
    $pagination_config = strpos($content, '"paging": true') !== false;
    $length_menu = strpos($content, 'lengthMenu') !== false;
    $custom_js_check = strpos($content, 'custom_js') !== false;
    
    echo "<h4>JavaScript Configuration:</h4>";
    echo "<ul>";
    echo "<li>DataTables Initialization: " . ($datatables_init ? "✅ FOUND" : "❌ MISSING") . "</li>";
    echo "<li>Pagination Enabled: " . ($pagination_config ? "✅ FOUND" : "❌ MISSING") . "</li>";
    echo "<li>Length Menu: " . ($length_menu ? "✅ FOUND" : "❌ MISSING") . "</li>";
    echo "<li>Custom JS Check: " . ($custom_js_check ? "✅ FOUND" : "❌ MISSING") . "</li>";
    echo "</ul>";
    
    // Count table elements
    $tables = substr_count($content, 'id="trial') + substr_count($content, 'id="replacement');
    echo "<p><strong>Demo Tables Found:</strong> $tables</p>";
    
    if ($datatables_init && $pagination_config && $length_menu && $custom_js_check) {
        echo "<h3 style='color: green;'>🎉 SUCCESS: Pagination Configuration Complete!</h3>";
    } else {
        echo "<h3 style='color: orange;'>⚠️ ISSUE: Some Configuration Missing</h3>";
    }
} else {
    echo "<h3 style='color: red;'>❌ Demo View File Not Found</h3>";
}

echo "<hr>";

// Check controller
$controller_file = "application/modules/admin/controllers/stocks.php";
if (file_exists($controller_file)) {
    echo "<h3>📋 Controller Configuration</h3>";
    $controller_content = file_get_contents($controller_file);
    
    $get_demo_method = strpos($controller_content, 'function get_demo') !== false;
    $custom_js_set = strpos($controller_content, '$data[\'custom_js\'] = true') !== false;
    
    echo "<ul>";
    echo "<li>get_demo() Method: " . ($get_demo_method ? "✅ EXISTS" : "❌ MISSING") . "</li>";
    echo "<li>custom_js Variable: " . ($custom_js_set ? "✅ SET" : "❌ NOT SET") . "</li>";
    echo "</ul>";
}

echo "<hr>";

// Check header and footer includes
$header_file = "application/views/admin/themes/sbadmin2/header.php";
$footer_file = "application/views/admin/themes/sbladmin2/footer.php";

echo "<h3>📦 Asset Includes Check</h3>";

if (file_exists($header_file)) {
    $header_content = file_get_contents($header_file);
    $datatables_css_include = strpos($header_content, 'dataTables.bootstrap4.min.css') !== false;
    echo "<p>Header DataTables CSS: " . ($datatables_css_include ? "✅ INCLUDED" : "❌ MISSING") . "</p>";
}

if (file_exists($footer_file)) {
    $footer_content = file_get_contents($footer_file);
    $datatables_js_include = strpos($footer_content, 'jquery.dataTables.min.js') !== false;
    $sweetalert_include = strpos($footer_content, 'sweetalert2') !== false;
    echo "<p>Footer DataTables JS: " . ($datatables_js_include ? "✅ INCLUDED" : "❌ MISSING") . "</p>";
    echo "<p>Footer SweetAlert2: " . ($sweetalert_include ? "✅ INCLUDED" : "❌ MISSING") . "</p>";
}

echo "<hr>";

echo "<h3>🧪 Testing Instructions</h3>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #007bff;'>";
echo "<ol>";
echo "<li><strong>Access Demo Page:</strong>";
echo "<ul><li>Login at: <a href='http://localhost:8000/auth/login' target='_blank'>http://localhost:8000/auth/login</a></li>";
echo "<li>Navigate to: Ακουστικά → Demo Γενικά</li></ul></li>";
echo "<li><strong>Verify Pagination:</strong>";
echo "<ul><li>Check for pagination controls at bottom of tables</li>";
echo "<li>Test 'Show entries' dropdown (10, 15, 25, 50, 100, Όλα)</li>";
echo "<li>Test page navigation buttons</li>";
echo "<li>Test search functionality</li></ul></li>";
echo "<li><strong>Expected Features:</strong>";
echo "<ul><li>4 separate tables with individual pagination</li>";
echo "<li>Greek language support</li>";
echo "<li>Responsive design</li>";
echo "<li>Search and sorting capabilities</li></ul></li>";
echo "</ol>";
echo "</div>";

echo "<hr>";

echo "<h3>📊 Pagination Features Summary</h3>";
echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 5px;'>";
echo "<p><strong>✅ Enhanced Features Added:</strong></p>";
echo "<ul>";
echo "<li>📄 Page Length: 15 items per page (default)</li>";
echo "<li>📋 Length Menu: 10, 15, 25, 50, 100, Όλα options</li>";
echo "<li>🔍 Search: Real-time table filtering</li>";
echo "<li>📊 Info Display: Shows current page/total records</li>";
echo "<li>🇬🇷 Greek Language: Full localization support</li>";
echo "<li>📱 Responsive: Auto-adjusts on tab switching</li>";
echo "<li>🔧 Actions Column: Non-sortable/searchable</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p><em>🔗 Next: Login and test the Demo functionality with full pagination support!</em></p>";
?>