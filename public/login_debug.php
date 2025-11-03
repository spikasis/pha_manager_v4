<?php
/**
 * Login Debug Script - Redirect to proper CodeIgniter login page
 */

echo "<h1>🔐 Login Debug - Redirecting...</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";

echo "<div style='text-align: center; margin: 50px;'>";
echo "<h2>Redirecting to proper login page...</h2>";
echo "<p>This page will redirect you to the proper CodeIgniter login form with CSRF protection.</p>";
echo "<p>If you're not redirected automatically, <a href='http://localhost:8080/auth/login'>click here</a>.</p>";
echo "</div>";

echo "<script>setTimeout(function(){ window.location.href = 'http://localhost:8080/auth/login'; }, 2000);</script>";
?>