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

    // Master Data SKPK
    $routes->get('/skpk', 'Skpk::index');
    $routes->post('/skpk/store', 'Skpk::store');
    $routes->post('/skpk/update/(:num)', 'Skpk::update/$1');
    $routes->get('/skpk/delete/(:num)', 'Skpk::delete/$1');
    $routes->post('/skpk/switch', 'Skpk::switch');

    // Master Data Rekening - Akun
    $routes->get('/akun', 'Akun::index');
    $routes->post('/akun/store', 'Akun::store');
    $routes->post('/akun/update/(:num)', 'Akun::update/$1');
    $routes->get('/akun/delete/(:num)', 'Akun::delete/$1');

    // Master Data Rekening - Kelompok
    $routes->get('/kelompok', 'Kelompok::index');
    $routes->post('/kelompok/store', 'Kelompok::store');
    $routes->post('/kelompok/update/(:num)', 'Kelompok::update/$1');
    $routes->get('/kelompok/delete/(:num)', 'Kelompok::delete/$1');

    // Master Data Rekening - Jenis
    $routes->get('/jenis', 'Jenis::index');
    $routes->post('/jenis/store', 'Jenis::store');
    $routes->post('/jenis/update/(:num)', 'Jenis::update/$1');
    $routes->get('/jenis/delete/(:num)', 'Jenis::delete/$1');

    // Master Data Rekening - Objek
    $routes->get('/objek', 'Objek::index');
    $routes->post('/objek/store', 'Objek::store');
    $routes->post('/objek/update/(:num)', 'Objek::update/$1');
    $routes->get('/objek/delete/(:num)', 'Objek::delete/$1');

    // Master Data Rekening - Rincian Objek
    $routes->get('/rincian-objek', 'RincianObjek::index');
    $routes->post('/rincian-objek/store', 'RincianObjek::store');
    $routes->post('/rincian-objek/update/(:num)', 'RincianObjek::update/$1');
    $routes->get('/rincian-objek/delete/(:num)', 'RincianObjek::delete/$1');

    // Master Data Rekening - Sub Rincian Objek
    $routes->get('/sub-rincian-objek', 'SubRincianObjek::index');
    $routes->post('/sub-rincian-objek/store', 'SubRincianObjek::store');
    $routes->post('/sub-rincian-objek/update/(:num)', 'SubRincianObjek::update/$1');
    $routes->get('/sub-rincian-objek/delete/(:num)', 'SubRincianObjek::delete/$1');

    // Admin Users Management
    $routes->get('/users', 'Users::index');
    $routes->post('/users/store', 'Users::store');
    $routes->get('/users/toggle/(:num)', 'Users::toggleStatus/$1');

    // APBK (Target) - Pendapatan
    $routes->get('/target-pendapatan', 'TargetPendapatan::index');
    $routes->post('/target-pendapatan/store', 'TargetPendapatan::store');
    $routes->post('/target-pendapatan/update/(:num)', 'TargetPendapatan::update/$1');
    $routes->get('/target-pendapatan/delete/(:num)', 'TargetPendapatan::delete/$1');
});

