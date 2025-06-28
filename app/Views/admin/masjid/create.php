<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Tambah Data Masjid<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('admin/masjid') ?>">Data Masjid</a></li>
<li class="breadcrumb-item active">Tambah Data</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Masjid</h3>
    </div>
    <form action="<?= base_url('admin/masjid/store') ?>" method="post">
        <div class="card-body">
            <?php if (isset($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label>Nama Masjid</label>
                <input type="text" name="nama_masjid" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>RT/RW</label>
                <input type="text" name="rt_rw" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nama Takmir</label>
                <input type="text" name="nama_takmir" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kontak</label>
                <input type="text" name="kontak" class="form-control" required>
                <small class="text-muted">Contoh: 081234567890</small>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="<?= base_url('admin/masjid') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>