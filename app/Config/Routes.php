<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('dashboard', 'Dashboard::index');

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

// REST API routes (optional)
$routes->resource('api/patients', ['controller' => 'API\Patients']);
