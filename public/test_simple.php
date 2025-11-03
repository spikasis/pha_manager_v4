<?php
echo "Test page working - " . date('Y-m-d H:i:s');
echo "<br><br>";
echo "Session status: ";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "ACTIVE";
} else {
    echo "NOT ACTIVE";
}
echo "<br>";
echo "CodeIgniter environment: " . (defined('ENVIRONMENT') ? ENVIRONMENT : 'NOT SET');
?>