<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Data Masjid<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Data Masjid</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Masjid</h3>
        <div class="card-tools">
            <a href="<?= base_url('admin/masjid/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Masjid</th>
                    <th>Alamat</th>
                    <th>RT/RW</th>
                    <th>Takmir</th>
                    <th>Kontak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($masjids as $i => $masjid): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($masjid['nama_masjid']) ?></td>
                        <td><?= esc($masjid['alamat']) ?></td>
                        <td><?= esc($masjid['rt_rw']) ?></td>
                        <td><?= esc($masjid['nama_takmir'] ?? '-') ?></td>
                        <td><?= esc($masjid['kontak'] ?? '-') ?></td>
                        <td>
                            <a href="<?= base_url("admin/masjid/edit/{$masjid['id_masjid']}") ?>"
                                class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?= base_url("admin/masjid/delete/{$masjid['id_masjid']}") ?>" method="POST"
                                class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Apakah Anda yakin?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>