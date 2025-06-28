<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Generate Laporan<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('admin/laporan') ?>">Master Data Laporan</a></li>
<li class="breadcrumb-item active">Generate Laporan</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Generate Laporan Baru</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/laporan/store') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="id_masjid">Masjid</label>
                <select class="form-control <?= ($validation->hasError('id_masjid')) ? 'is-invalid' : '' ?>"
                    id="id_masjid" name="id_masjid" required>
                    <option value="">Pilih Masjid</option>
                    <?php foreach ($masjids as $masjid): ?>
                        <option value="<?= $masjid['id_masjid'] ?>" <?= old('id_masjid') == $masjid['id_masjid'] ? 'selected' : '' ?>>
                            <?= esc($masjid['nama_masjid']) ?> (<?= esc($masjid['rt_rw']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('id_masjid') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="judul">Judul Laporan</label>
                <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : '' ?>"
                    id="judul" name="judul" value="<?= old('judul') ?>" required>
                <div class="invalid-feedback">
                    <?= $validation->getError('judul') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="periode_awal">Periode Awal</label>
                        <input type="date"
                            class="form-control <?= ($validation->hasError('periode_awal')) ? 'is-invalid' : '' ?>"
                            id="periode_awal" name="periode_awal" value="<?= old('periode_awal') ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('periode_awal') ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="periode_akhir">Periode Akhir</label>
                        <input type="date"
                            class="form-control <?= ($validation->hasError('periode_akhir')) ? 'is-invalid' : '' ?>"
                            id="periode_akhir" name="periode_akhir" value="<?= old('periode_akhir') ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('periode_akhir') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea class="form-control" id="catatan" name="catatan" rows="3"><?= old('catatan') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Generate Laporan</button>
            <a href="<?= base_url('admin/laporan') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>