<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes (no authentication required)
$routes->get('/', function() {
    return redirect()->to('/direct-login');
}); // Redirect to direct login

// DIRECT LOGIN ROUTES (working solution)
$routes->get('direct-login', 'DirectLogin::index');
$routes->get('direct-login/login', 'DirectLogin::login');
$routes->get('direct-login/logout', 'DirectLogin::logout');

// Alternative routes without prefix for backward compatibility
$routes->get('login', 'DirectLogin::index');
$routes->post('login', 'AuthFixed::attemptLogin');
$routes->get('logout', 'DirectLogin::logout');

// Simple dashboard route
$routes->get('dashboard-simple', 'DashboardSimple::index');



// Protected routes (authentication required)
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Branch-specific dashboards
$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    $routes->get('thiva', 'Dashboard::thiva');
    $routes->get('levadia', 'Dashboard::levadia');
    $routes->get('service', 'Dashboard::service');
    $routes->get('selling-points', 'Dashboard::sellingPoints');
    $routes->get('lab', 'Dashboard::lab');
});

// Database analyzer (temporary - for migration)
$routes->get('analyze', 'DatabaseAnalyzer::index');

// Patients routes
$routes->group('patients', function($routes) {
    $routes->get('/', 'Patients::index');
    $routes->get('create', 'Patients::create');
    $routes->post('store', 'Patients::store');
    $routes->get('show/(:num)', 'Patients::show/$1');
    $routes->get('edit/(:num)', 'Patients::edit/$1');
    $routes->post('update/(:num)', 'Patients::update/$1');
    $routes->delete('delete/(:num)', 'Patients::delete/$1');
    $routes->get('search', 'Patients::search');
});

// Customers routes (protected)
$routes->group('customers', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Customers::index');
    $routes->get('create', 'Customers::create');
    $routes->post('/', 'Customers::store');
    $routes->get('(:num)', 'Customers::show/$1');
    $routes->get('(:num)/edit', 'Customers::edit/$1');
    $routes->put('(:num)', 'Customers::update/$1');
    $routes->delete('(:num)', 'Customers::delete/$1');
    $routes->get('search', 'Customers::search');
    $routes->get('export', 'Customers::exportCustomers');
});

// Admin only routes
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    // User management
    $routes->group('users', function($routes) {
        $routes->get('/', 'Admin\Users::index');
        $routes->get('create', 'Admin\Users::create');
        $routes->post('/', 'Admin\Users::store');
        $routes->get('(:num)', 'Admin\Users::show/$1');
        $routes->get('(:num)/edit', 'Admin\Users::edit/$1');
        $routes->put('(:num)', 'Admin\Users::update/$1');
        $routes->delete('(:num)', 'Admin\Users::delete/$1');
        $routes->post('(:num)/activate', 'Admin\Users::activate/$1');
        $routes->post('(:num)/deactivate', 'Admin\Users::deactivate/$1');
    });
    
    // Group management
    $routes->group('groups', function($routes) {
        $routes->get('/', 'Admin\Groups::index');
        $routes->get('create', 'Admin\Groups::create');
        $routes->post('/', 'Admin\Groups::store');
        $routes->get('(:num)', 'Admin\Groups::show/$1');
        $routes->get('(:num)/edit', 'Admin\Groups::edit/$1');
        $routes->put('(:num)', 'Admin\Groups::update/$1');
        $routes->delete('(:num)', 'Admin\Groups::delete/$1');
    });
    
    // System settings
    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings', 'Admin\Settings::update');
});

// REST API routes (optional)
$routes->resource('api/patients', ['controller' => 'API\Patients']);

// Login attempts (security monitoring) - READ-ONLY
$routes->group('login-attempts', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'LoginAttempts::index');
    $routes->get('getData', 'LoginAttempts::getData');
    $routes->get('show/(:num)', 'LoginAttempts::show/$1');
    $routes->get('getStatistics', 'LoginAttempts::getStatistics');
    $routes->post('cleanup', 'LoginAttempts::cleanup');
});

// CRUD Management Routes (new system)
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Users CRUD
    $routes->resource('users', ['controller' => 'Users']);
    $routes->get('users/getData', 'Users::getData');
    $routes->post('users/toggleActive/(:num)', 'Users::toggleActive/$1');
    $routes->post('users/checkUnique', 'Users::checkUnique');

    // Groups CRUD
    $routes->resource('groups', ['controller' => 'Groups']);
    $routes->get('groups/getData', 'Groups::getData');
    $routes->post('groups/checkUnique', 'Groups::checkUnique');
    $routes->get('groups/getStatistics', 'Groups::getStatistics');
    
    // Doctors CRUD (Lookup Table)
    $routes->resource('doctors', ['controller' => 'Doctors']);
    $routes->get('doctors/getData', 'Doctors::getData');
    $routes->get('doctors/getStatistics', 'Doctors::getStatistics');
    $routes->get('doctors/getForSelect', 'Doctors::getForSelect');
});


