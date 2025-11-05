<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes (no authentication required)
$routes->get('/', function() {
    return redirect()->to('/auth');
}); // Redirect to auth login

// AUTHENTICATION ROUTES
$routes->group('auth', function($routes) {
    $routes->get('/', 'AuthController::index');
    $routes->get('login', 'AuthController::login');
    $routes->get('logout', 'AuthController::logout');
    $routes->get('check', 'AuthController::checkAuth');
    $routes->post('keep-alive', 'AuthController::keepAlive');
});

// Alternative routes for backward compatibility
$routes->get('login', 'AuthController::index');
$routes->get('logout', 'AuthController::logout');
$routes->get('direct-login', 'AuthController::index'); // Backward compatibility



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
    
    // Insurances CRUD (Lookup Table)
    $routes->resource('insurances', ['controller' => 'Insurances']);
    $routes->get('insurances/getData', 'Insurances::getData');
    $routes->get('insurances/getForSelect', 'Insurances::getForSelect');
    
    // Customer Statuses CRUD (Lookup Table)
    $routes->resource('customer-statuses', ['controller' => 'CustomerStatuses']);
    $routes->get('customer-statuses/getData', 'CustomerStatuses::getData');
    $routes->get('customer-statuses/getForSelect', 'CustomerStatuses::getForSelect');
    $routes->get('customer-statuses/getStatistics', 'CustomerStatuses::getStatistics');
    
    // Stocks CRUD (Inventory Management)
    $routes->resource('stocks', ['controller' => 'Stocks']);
    $routes->get('stocks/getData', 'Stocks::getData');
    $routes->get('stocks/getForSelect', 'Stocks::getForSelect');
    $routes->get('stocks/low-stock', 'Stocks::lowStock');
    $routes->post('stocks/update-quantity/(:num)', 'Stocks::updateQuantity/$1');
});

// Additional system routes
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Profile and settings
    $routes->get('profile', 'Profile::index');
    $routes->post('profile', 'Profile::update');
    $routes->get('settings/account', 'Settings::account');
    $routes->post('settings/account', 'Settings::updateAccount');
    $routes->get('settings/general', 'Settings::general');
    $routes->post('settings/general', 'Settings::updateGeneral');
    $routes->get('settings/security', 'Settings::security');
    $routes->post('settings/security', 'Settings::updateSecurity');
    $routes->get('settings/backup', 'Settings::backup');
    $routes->post('settings/backup', 'Settings::createBackup');
    
    // Help and notifications
    $routes->get('help', 'Help::index');
    $routes->get('notifications', 'Notifications::index');
    $routes->post('notifications/mark-read/(:num)', 'Notifications::markRead/$1');
});


