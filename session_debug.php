<?php
// Session Debug Script
require_once 'index.php';

echo "<h1>🔍 Session Debug - PHA Manager v4</h1>";

echo "<h2>📊 Current Session Status:</h2>";
$session = \Config\Services::session();
$sessionData = $session->get();

if (empty($sessionData)) {
    echo "❌ <strong>ΚΑΜΙΑ SESSION ΔΕΔΟΜΕΝΑ</strong><br>";
} else {
    echo "✅ <strong>ΥΠΑΡΧΟΥΝ SESSION ΔΕΔΟΜΕΝΑ:</strong><br>";
    echo "<pre style='background: #f8f9fc; padding: 1rem; border-radius: 5px;'>";
    print_r($sessionData);
    echo "</pre>";
}

echo "<h2>🔐 Authentication Check:</h2>";
$isLoggedIn = $session->get('logged_in') || $session->get('user_id');
echo "<strong>Logged In Status:</strong> " . ($isLoggedIn ? "✅ ΝΑΙ" : "❌ ΟΧΙ") . "<br>";
echo "<strong>User ID:</strong> " . ($session->get('user_id') ?: 'N/A') . "<br>";
echo "<strong>Username:</strong> " . ($session->get('username') ?: 'N/A') . "<br>";

echo "<h2>🌐 URL Information:</h2>";
echo "<strong>Base URL:</strong> " . base_url() . "<br>";
echo "<strong>Site URL:</strong> " . site_url() . "<br>";
echo "<strong>Current URL:</strong> " . current_url() . "<br>";
echo "<strong>URI String:</strong> " . uri_string() . "<br>";

echo "<h2>🔗 Quick Actions:</h2>";
echo "<div style='margin: 1rem 0;'>";
echo "<a href='" . site_url('auth') . "' style='display: inline-block; margin: 0.5rem; padding: 0.5rem 1rem; background: #4e73df; color: white; text-decoration: none; border-radius: 5px;'>🔐 Login Page</a>";
echo "<a href='" . site_url('auth?force_logout=1') . "' style='display: inline-block; margin: 0.5rem; padding: 0.5rem 1rem; background: #e74a3b; color: white; text-decoration: none; border-radius: 5px;'>🧹 Clear Session</a>";
echo "<a href='" . site_url('dashboard') . "' style='display: inline-block; margin: 0.5rem; padding: 0.5rem 1rem; background: #1cc88a; color: white; text-decoration: none; border-radius: 5px;'>📊 Dashboard</a>";
echo "</div>";

echo "<h2>⚙️ System Info:</h2>";
echo "<strong>CodeIgniter Version:</strong> " . \CodeIgniter\CodeIgniter::CI_VERSION . "<br>";
echo "<strong>PHP Version:</strong> " . PHP_VERSION . "<br>";
echo "<strong>Environment:</strong> " . ENVIRONMENT . "<br>";
echo "<strong>Server Time:</strong> " . date('Y-m-d H:i:s') . "<br>";

echo "<hr style='margin: 2rem 0;'>";
echo "<p style='color: #858796; font-size: 0.9rem;'>";
echo "🕐 Debug generated at: " . date('Y-m-d H:i:s') . "<br>";
echo "📍 Access this debug at: " . current_url();
echo "</p>";
?>