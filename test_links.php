<?php

// Test script to check routes and configuration

echo "<h1>PHA Manager v4 - Links Test</h1>";

echo "<h2>Configuration Check:</h2>";
echo "<strong>Environment:</strong> " . ENVIRONMENT . "<br>";

// Load CodeIgniter
require_once 'index.php';

echo "<h2>Base URL Test:</h2>";
echo "<strong>base_url():</strong> " . base_url() . "<br>";
echo "<strong>site_url():</strong> " . site_url() . "<br>";
echo "<strong>current_url():</strong> " . current_url() . "<br>";

echo "<h2>Session Check:</h2>";
$session = \Config\Services::session();
$sessionData = $session->get();
echo "<strong>Session Data:</strong><br>";
echo "<pre>";
print_r($sessionData);
echo "</pre>";

echo "<h2>Routes Test:</h2>";
$routes = [
    'dashboard' => base_url('dashboard'),
    'customers' => base_url('customers'),
    'users' => base_url('users'),
    'doctors' => base_url('doctors'),
    'stocks' => base_url('stocks'),
    'direct-login' => base_url('direct-login'),
    'profile' => base_url('profile'),
    'help' => base_url('help'),
];

foreach ($routes as $name => $url) {
    echo "<a href='$url' target='_blank'>$name</a> - $url<br>";
}

echo "<h2>Controller Check:</h2>";
$controllers = [
    'Dashboard' => 'App\\Controllers\\Dashboard',
    'Customers' => 'App\\Controllers\\Customers', 
    'Users' => 'App\\Controllers\\Users',
    'DirectLogin' => 'App\\Controllers\\DirectLogin',
    'Profile' => 'App\\Controllers\\Profile',
    'Settings' => 'App\\Controllers\\Settings',
    'Help' => 'App\\Controllers\\Help'
];

foreach ($controllers as $name => $class) {
    if (class_exists($class)) {
        echo "✅ $name controller exists<br>";
    } else {
        echo "❌ $name controller missing<br>";
    }
}

?>