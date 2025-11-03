<?php
/**
 * Static Files Check Script
 * This script checks if the required static files exist in the public directory
 */

// Required static files
$requiredFiles = [
    'sbadmin2/css/sb-admin-2.min.css',
    'sbadmin2/js/sb-admin-2.min.js',
    'sbadmin2/img/undraw_profile.svg',
    'vendor/fontawesome-free/css/all.min.css',
    'vendor/jquery-easing/jquery.easing.min.js',
    'vendor/datatables/jquery.dataTables.min.js',
    'vendor/datatables/dataTables.bootstrap4.min.js',
    'vendor/datatables/dataTables.bootstrap4.min.css',
    'vendor/chart.js/Chart.min.js'
];

echo "<h2>Static Files Status Check</h2>\n";
echo "<table border='1'>\n";
echo "<tr><th>File</th><th>Status</th><th>Size</th></tr>\n";

$publicPath = FCPATH; // CodeIgniter's public path

foreach ($requiredFiles as $file) {
    $fullPath = $publicPath . $file;
    $exists = file_exists($fullPath);
    $size = $exists ? filesize($fullPath) : 0;
    $status = $exists ? 'EXISTS' : 'MISSING';
    $statusColor = $exists ? 'green' : 'red';
    
    echo "<tr>";
    echo "<td>{$file}</td>";
    echo "<td style='color: {$statusColor}'>{$status}</td>";
    echo "<td>" . ($exists ? number_format($size) . " bytes" : "N/A") . "</td>";
    echo "</tr>\n";
}

echo "</table>\n";

// Check .htaccess
$htaccessPath = $publicPath . '.htaccess';
echo "<br><h3>Additional Checks</h3>\n";
echo "<p>.htaccess exists: " . (file_exists($htaccessPath) ? 'YES' : 'NO') . "</p>\n";

// Check if mod_rewrite is available (this won't work in CLI)
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo "<p>mod_rewrite enabled: " . (in_array('mod_rewrite', $modules) ? 'YES' : 'NO') . "</p>\n";
} else {
    echo "<p>Cannot check mod_rewrite status (not running under Apache or CLI mode)</p>\n";
}

// Check base URL configuration
echo "<p>Base URL: " . base_url() . "</p>\n";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' . "</p>\n";
echo "<p>Script Path: " . __FILE__ . "</p>\n";

echo "<br><h3>Recommendations</h3>\n";
echo "<ul>\n";
echo "<li>Missing files should be restored from the original SB Admin 2 theme</li>\n";
echo "<li>Check file permissions (should be readable by web server)</li>\n";
echo "<li>Verify .htaccess is properly configured</li>\n";
echo "<li>Consider using CDN links as fallbacks for missing files</li>\n";
echo "</ul>\n";

?>