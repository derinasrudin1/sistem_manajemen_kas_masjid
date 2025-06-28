<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Auth;
use App\Controllers\Admin\AdminDashboard;

// Authentication routes
$routes->get('/auth', [Auth::class, 'index']);
$routes->post('/auth/login', [Auth::class, 'login']);
$routes->get('/auth/logout', [Auth::class, 'logout']);

$routes->get('test', function() {
    $filters = config('Filters');
    
    echo "<h2>Registered Filter Aliases:</h2>";
    echo "<pre>";
    print_r($filters->aliases);
    echo "</pre>";
    
    echo "<h2>Auth Class Exists:</h2>";
    echo class_exists('\App\Filters\Auth') ? "YES" : "NO";
    
    echo "<h2>Filter File Contents:</h2>";
    highlight_file(APPPATH.'Filters/Auth.php');
});

// Protected admin route with auth filter
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('dashboard', [AdminDashboard::class, 'index']);
});

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

