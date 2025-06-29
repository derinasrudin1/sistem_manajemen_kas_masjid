<?php
use CodeIgniter\HTTP\URI;
$uri = service('uri');
$currentPath = '/' . $uri->getPath();
$role = session()->get('role');
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= $role ? base_url("$role/dashboard") : base_url('/') ?>" class="brand-link">
        <img src="<?= base_url('icon.jpg') ?>" alt="Logo Masjid" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Masjid Al Undira</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('adminlte/dist/img/user2-160x160.jpg') ?>" class="img-circle elevation-2"
                    alt="Foto User">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= session()->get('nama') ?? 'Pengguna' ?></a>
                <small class="d-block text-success"><?= strtoupper($role) ?></small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?= base_url("$role/dashboard") ?>"
                        class="nav-link <?= strpos($currentPath, "/$role/dashboard") !== false ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard
                            <?= strpos($currentPath, "/$role/dashboard") !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                        </p>
                    </a>
                </li>

                <!-- MENU ADMIN -->
                <?php if ($role === 'admin'): ?>
                    <li class="nav-header">ADMINISTRATOR</li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/users') ?>"
                            class="nav-link <?= strpos($currentPath, '/admin/users') !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Manajemen User
                                <?= strpos($currentPath, '/admin/users') !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/masjid') ?>"
                            class="nav-link <?= strpos($currentPath, '/admin/masjid') !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-mosque"></i>
                            <p>Data Masjid
                                <?= strpos($currentPath, '/admin/masjid') !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/laporan') ?>"
                            class="nav-link <?= strpos($currentPath, '/admin/laporan') !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Sistem
                                <?= strpos($currentPath, '/admin/laporan') !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                            </p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- MENU BENDHARA -->
                <?php if (in_array($role, ['admin', 'bendahara'])): ?>
                    <li class="nav-header">KEUANGAN</li>
                    
                    <li class="nav-item">
                    <a href="<?= base_url("$role/kas-masuk") ?> "
                            class="nav-link <?= strpos($currentPath, "$role/kas-masuk") !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-donate"></i>
                            <p>Kas Masuk
                                <?= strpos($currentPath, "$role/kas-masuk") !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                    <a href="<?= base_url("$role/kas-keluar") ?> "
                            class="nav-link <?= strpos($currentPath, "$role/kas-keluar") !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-donate"></i>
                            <p>Kas Keluar
                                <?= strpos($currentPath, "$role/kas-keluar") !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/riwayat') ?>"
                            class="nav-link <?= strpos($currentPath, '/riwayat') !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Riwayat Keuangan
                                <?= strpos($currentPath, '/riwayat') !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                            </p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- MENU RT -->
                <?php if ($role === 'rt'): ?>
                    <li class="nav-header">PENGAWASAN</li>
                    <li class="nav-item">
                        <a href="<?= base_url('rt/monitoring') ?>"
                            class="nav-link <?= strpos($currentPath, '/rt/monitoring') !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-search-dollar"></i>
                            <p>Monitoring Transaksi
                                <?= strpos($currentPath, '/rt/monitoring') !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('rt/verifikasi') ?>"
                            class="nav-link <?= strpos($currentPath, '/rt/verifikasi') !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>Verifikasi Transaksi
                                <?= strpos($currentPath, '/rt/verifikasi') !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('rt/laporan') ?>"
                            class="nav-link <?= strpos($currentPath, '/rt/laporan') !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>Laporan Masjid
                                <?= strpos($currentPath, '/rt/laporan') !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                            </p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- MENU PUBLIK -->
                <li class="nav-header">INFORMASI PUBLIK</li>
                <li class="nav-item">
                    <a href="<?= base_url('transparansi') ?>"
                        class="nav-link <?= strpos($currentPath, '/transparansi') !== false ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Transparansi Keuangan
                            <?= strpos($currentPath, '/transparansi') !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('donasi') ?>"
                        class="nav-link <?= strpos($currentPath, '/donasi') !== false ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>Donasi Online
                            <?= strpos($currentPath, '/donasi') !== false ? '<span class="right badge badge-success">•</span>' : '' ?>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<style>
    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.1);
        border-left: 3px solid #28a745;
    }

    .nav-link p {
        display: inline-block;
    }

    .badge-success {
        background-color: #28a745;
        animation: pulse 1.5s infinite;
        width: 8px;
        height: 8px;
        padding: 0;
        border-radius: 50%;
        position: relative;
        top: -1px;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.6;
        }

        100% {
            opacity: 1;
        }
    }

    .nav-header {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
        color: #adb5bd;
    }
</style>