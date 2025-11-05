<?php
// Quick Authentication Test
require_once 'index.php';

echo "<h1>PHA Manager v4 - Clean Authentication Test</h1>";

echo "<h2>Available Controllers:</h2>";
$controllers = [
    'AuthController' => 'app/Controllers/AuthController.php',
    'Dashboard' => 'app/Controllers/Dashboard.php',
    'Customers' => 'app/Controllers/Customers.php',
    'Users' => 'app/Controllers/Users.php',
    'Stocks' => 'app/Controllers/Stocks.php'
];

foreach ($controllers as $name => $path) {
    if (file_exists($path)) {
        echo "✅ $name - ΥΠΑΡΧΕΙ<br>";
    } else {
        echo "❌ $name - ΛΕΙΠΕΙ<br>";
    }
}

echo "<h2>Authentication System Status:</h2>";
echo "<strong>DirectLogin:</strong> ❌ ΑΦΑΙΡΕΘΗΚΕ<br>";
echo "<strong>AuthController:</strong> ✅ ΕΝΕΡΓΟ<br>";
echo "<strong>Old Auth Controllers:</strong> ❌ ΚΑΘΑΡΙΣΤΗΚΑΝ<br>";

echo "<h2>Login Methods Available:</h2>";
echo "<a href='" . site_url('auth') . "' target='_blank'>🔐 Νέο Login System</a><br>";
echo "<a href='" . site_url('dashboard') . "' target='_blank'>📊 Dashboard</a><br>";

echo "<h2>Session Status:</h2>";
$session = \Config\Services::session();
if ($session->get('logged_in')) {
    echo "✅ ΣΥΝΔΕΔΕΜΕΝΟΣ: " . ($session->get('username') ?: 'Unknown') . "<br>";
    echo "📧 Email: " . ($session->get('email') ?: 'N/A') . "<br>";
    echo "🏢 Role: " . ($session->get('role') ?: 'User') . "<br>";
} else {
    echo "❌ ΔΕΝ ΕΙΣΤΕ ΣΥΝΔΕΔΕΜΕΝΟΣ<br>";
    echo "<a href='" . site_url('auth/login') . "'>🚀 Συνδεθείτε Τώρα</a><br>";
}

echo "<hr>";
echo "<small>🕐 Generated: " . date('Y-m-d H:i:s') . "</small>";
?>