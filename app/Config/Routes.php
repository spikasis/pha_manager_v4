<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes (no authentication required)
$routes->get('/', 'AuthSafe::login'); // Redirect home to safe login

// Authentication routes with auth prefix
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->post('attempt-login', 'Auth::attemptLogin'); // Support dash format
    $routes->get('logout', 'Auth::logout');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::attemptRegister');
    $routes->post('attempt-register', 'Auth::attemptRegister'); // Support dash format
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::attemptForgotPassword');
    $routes->get('reset-password/(:segment)', 'Auth::resetPassword/$1');
    $routes->post('reset-password/(:segment)', 'Auth::attemptResetPassword/$1');
    $routes->get('activate-account/(:segment)', 'Auth::activateAccount/$1');
});

// Alternative routes without prefix for backward compatibility
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

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

// Test routes for debugging
$routes->get('test', 'Test::index');
$routes->get('simple-test', 'SimpleTest::index');

// Simple Auth routes for debugging
$routes->get('auth-simple/login', 'AuthSimple::login');
$routes->post('auth-simple/attempt-login', 'AuthSimple::attemptLogin');
$routes->get('auth-simple/logout', 'AuthSimple::logout');

// Ultra Simple Auth routes - no CodeIgniter dependencies
$routes->get('auth-ultra/login', 'AuthUltraSimple::login');
$routes->post('auth-ultra/attempt-login', 'AuthUltraSimple::attemptLogin');
$routes->get('auth-ultra/test-db', 'AuthUltraSimple::testDb');
$routes->get('auth-ultra/test-models', 'AuthUltraSimple::testModels');

// Safe Auth routes - works without intl extension
$routes->get('auth-safe/login', 'AuthSafe::login');
$routes->post('auth-safe/attempt-login', 'AuthSafe::attemptLogin');
$routes->get('auth-safe/logout', 'AuthSafe::logout');
