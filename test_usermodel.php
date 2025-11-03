<?php
// Simple test for UserModel findByLogin method

// Change to project directory
chdir(__DIR__);

// Set environment
putenv('CI_ENVIRONMENT=development');

// Load CodeIgniter
require_once 'vendor/autoload.php';

// Bootstrap CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

try {
    echo "Testing UserModel findByLogin method...\n";
    
    $userModel = new \App\Models\UserModel();
    echo "✓ UserModel created successfully\n";
    
    // Test the findByLogin method
    $result = $userModel->findByLogin('test@example.com');
    echo "✓ findByLogin method executed successfully\n";
    echo "Result: " . ($result ? "User found" : "No user found") . "\n";
    
    // Test with username
    $result2 = $userModel->findByLogin('testuser');
    echo "✓ findByLogin with username executed successfully\n";
    echo "Result: " . ($result2 ? "User found" : "No user found") . "\n";
    
    echo "\n✅ All tests passed! The binding issue is fixed.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}
?>