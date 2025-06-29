<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Auth;
use App\Controllers\Admin\AdminDashboard;
use App\Controllers\Bendahara\BendaharaDashboard;

// Authentication routes
$routes->get('/auth', [Auth::class, 'index']);
$routes->post('/auth/login', [Auth::class, 'login']);
$routes->get('/auth/logout', [Auth::class, 'logout']);

// Protected admin route with auth filter
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', [AdminDashboard::class, 'index']);
    $routes->get('users', 'Admin\UserController::index');


    // user manajement
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');
    $routes->delete('users/delete/(:num)', 'Admin\UserController::delete/$1');

    //masjid
    $routes->get('masjid', 'Admin\MasjidController::index');
    $routes->get('masjid/create', 'Admin\MasjidController::create');
    $routes->post('masjid/store', 'Admin\MasjidController::store');
    $routes->get('masjid/edit/(:num)', 'Admin\MasjidController::edit/$1');
    $routes->post('masjid/update/(:num)', 'Admin\MasjidController::update/$1');
    $routes->delete('masjid/delete/(:num)', 'Admin\MasjidController::delete/$1');

    $routes->group('laporan', function ($routes) {
        $routes->get('/', 'Admin\LaporanController::index');
        $routes->get('generate', 'Admin\LaporanController::generate');
        $routes->post('store', 'Admin\LaporanController::store');
        $routes->get('show/(:num)', 'Admin\LaporanController::show/$1');
        $routes->get('print/(:num)', 'Admin\LaporanController::print/$1');
        $routes->delete('delete/(:num)', 'Admin\LaporanController::delete/$1');
    });

    $routes->group('kas-masuk', function ($routes) {
        $routes->get('/', 'Admin\KasMasukController::index');
        $routes->get('create', 'Admin\KasMasukController::create');
        $routes->post('store', 'Admin\KasMasukController::store');
        $routes->get('edit/(:num)', 'Admin\KasMasukController::edit/$1');
        $routes->put('update/(:num)', 'Admin\KasMasukController::update/$1');
        $routes->delete('delete/(:num)', 'Admin\KasMasukController::delete/$1');
        $routes->get('view-bukti/(:segment)', 'Admin\KasMasukController::viewBukti/$1');
    });

    $routes->get('kas-keluar', 'Admin\KasKeluar::index');
    $routes->get('kas-keluar/create', 'Admin\KasKeluar::create');
    $routes->post('kas-keluar/store', 'Admin\KasKeluar::store'); // Perubahan di sini
    $routes->get('kas-keluar/edit/(:num)', 'Admin\KasKeluar::edit/$1');
    $routes->put('kas-keluar/(:num)', 'Admin\KasKeluar::update/$1');
    $routes->delete('kas-keluar/(:num)', 'Admin\KasKeluar::delete/$1');
    $routes->get('kas-keluar/export', 'Admin\KasKeluar::export');

    $routes->get('riwayat-keuangan', 'Admin\RiwayatKeuangan::index');
    $routes->get('riwayat-keuangan/export-pdf', 'Admin\RiwayatKeuangan::exportPdf');

    $routes->get('transparansi-keuangan', 'Admin\TransparansiKeuangan::index');
    $routes->get('transparansi-keuangan/create', 'Admin\TransparansiKeuangan::createLaporan');
    $routes->post('transparansi-keuangan/store', 'Admin\TransparansiKeuangan::storeLaporan');
    $routes->get('transparansi-keuangan/publish/(:num)', 'Admin\TransparansiKeuangan::publish/$1');
    $routes->get('transparansi-keuangan/unpublish/(:num)', 'Admin\TransparansiKeuangan::unpublish/$1');
    $routes->delete('transparansi-keuangan/delete/(:num)', 'Admin\TransparansiKeuangan::deleteLaporan/$1');

});

$routes->group('bendahara', ['filter' => 'auth:bendahara'], function ($routes) {
    $routes->get('dashboard', [BendaharaDashboard::class, 'index']);
});

$routes->get('transparansi-keuangan', 'Laporan::index');
$routes->get('laporan/(:num)', 'Laporan::view/$1');

// === Riwayat Transaksi ===
// $routes->get('riwayat', 'RiwayatTransaksi::index');

