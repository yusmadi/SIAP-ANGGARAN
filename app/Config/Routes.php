<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Guest Routes
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/process', 'Auth::process');
$routes->get('/logout', 'Auth::logout');

// Authenticated Routes
$routes->group('', ['filter' => ['auth', 'rbac']], static function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');

    // Admin Users Management
    $routes->get('/users', 'Users::index');
    $routes->post('/users/store', 'Users::store');
    $routes->get('/users/toggle/(:num)', 'Users::toggleStatus/$1');
});
