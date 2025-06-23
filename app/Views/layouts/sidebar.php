<?php use CodeIgniter\HTTP\URI; ?>
<?php
$uri = service('uri');
$segment1 = $uri->getSegment(1); // bagian setelah domain
?>


<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= base_url('adminlte/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Masjid Al Undira</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('adminlte/dist/img/image.png') ?>" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Anya Geraldine</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="<?= base_url('/') ?>" class="nav-link <?= $segment1 == '' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <a href="<?= base_url('kasmasuk') ?>" class="nav-link  <?= $segment1 == 'kasmasuk' ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-arrow-down"></i>
                    <p>Kas Masuk</p>
                </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('kaskeluar') ?>"
                        class="nav-link <?= $segment1 == 'kaskeluar' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-arrow-up"></i>
                        <p>Kas Keluar</p>
                    </a>
                </li>
                <a href="<?= base_url('riwayat') ?>" class="nav-link  <?= $segment1 == 'riwayat' ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Riwayat</p>
                </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>