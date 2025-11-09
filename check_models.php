<?php
define('BASEPATH', '');
define('ENVIRONMENT', 'production');
require_once 'application/config/database.php';

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

echo "Models table structure:\n";
$result = $mysqli->query('DESCRIBE models');
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}

echo "\nModel ID 114 data:\n";
$result = $mysqli->query('SELECT * FROM models WHERE id = 114');
if ($row = $result->fetch_assoc()) {
    print_r($row);
} else {
    echo "Model ID 114 not found!\n";
}
?>