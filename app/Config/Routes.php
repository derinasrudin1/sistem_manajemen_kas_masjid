<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// $routes->get('/kasmasuk', 'KasMasuk::index');
// $routes->get('/kasmasuk/create', 'KasMasuk::create');
// $routes->post('/kasmasuk/store', 'KasMasuk::store');
// $routes->get('/kasmasuk/edit/(:num)', 'KasMasuk::edit/$1');
// $routes->post('/kasmasuk/update/(:num)', 'KasMasuk::update/$1');
// $routes->post('/kasmasuk/delete/(:num)', 'KasMasuk::delete/$1');
// === Halaman Utama atau Dashboard (opsional) ===
$routes->get('/', 'Auth::index');
$routes->post('/checklogin', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

//Admin Pages
$routes->get('/admin/dashboard', 'Admin\AdminDashboard::index');

// === Kas Masuk ===
$routes->get('/kasmasuk', 'KasMasuk::index');
$routes->get('/kasmasuk/create', 'KasMasuk::create');
$routes->post('/kasmasuk/store', 'KasMasuk::store');
$routes->get('/kasmasuk/edit/(:num)', 'KasMasuk::edit/$1');
$routes->post('/kasmasuk/update/(:num)', 'KasMasuk::update/$1');
$routes->post('/kasmasuk/delete/(:num)', 'KasMasuk::delete/$1');

// === Kas Keluar ===
$routes->get('/kaskeluar', 'KasKeluar::index');
$routes->get('/kaskeluar/create', 'KasKeluar::create');
$routes->post('/kaskeluar/store', 'KasKeluar::store');
$routes->get('/kaskeluar/edit/(:num)', 'KasKeluar::edit/$1');
$routes->post('/kaskeluar/update/(:num)', 'KasKeluar::update/$1');
$routes->post('/kaskeluar/delete/(:num)', 'KasKeluar::delete/$1');

// === Riwayat Transaksi ===
$routes->get('riwayat', 'RiwayatTransaksi::index');

