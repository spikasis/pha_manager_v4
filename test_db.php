
<?php
// Change to the project directory
chdir('c:\\Users\\spika\\PHA_MANAGER_V4\\pha_manager_v4');

// Load CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

// Create the application
$app = Config\Services::codeigniter();
$app->initialize();

// Test database connection and UserModel
try {
    $db = \Config\Database::connect();
    echo "Database connection: SUCCESS\n";
    
    $userModel = new \App\Models\UserModel();
    echo "UserModel instantiation: SUCCESS\n";
    
    // Test the fixed findByLogin method
    $testUser = $userModel->findByLogin('admin@example.com');
    echo "UserModel findByLogin test: SUCCESS\n";
    echo "User found: " . ($testUser ? "YES" : "NO") . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
?>
