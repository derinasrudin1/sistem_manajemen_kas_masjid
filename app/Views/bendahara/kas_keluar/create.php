<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Kas Keluar
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('/bendahara/dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/bendahara/kas-keluar') ?>">Kas Keluar</a></li>
<li class="breadcrumb-item active">Tambah</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle"></i> Formulir Tambah Kas Keluar</h3>
            </div>
            <div class="card-body">
                <?php if (session('errors')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <h5 class="alert-heading"><i class="icon fas fa-ban"></i> Gagal Menyimpan!</h5>
                        <ul><?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li><?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
                <form action="<?= base_url('bendahara/kas-keluar/store') ?>" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Pengeluaran</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control"
                            value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <div class="input-group"><span class="input-group-text">Rp</span><input type="number"
                                id="jumlah" name="jumlah" class="form-control" value="<?= old('jumlah') ?>"
                                placeholder="Contoh: 150000" required></div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="kategori">Kategori *</label>
                            <select class="form-control <?= (session()->get('errors.kategori')) ? 'is-invalid' : '' ?>"
                                id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['nama_kategori'] ?>" <?= (old('kategori') == $k['nama_kategori']) ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kategori']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <?php if (session()->get('errors.kategori')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->get('errors.kategori') ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3"
                            placeholder="Contoh: Pembayaran tagihan listrik bulan Juni"><?= old('keterangan') ?></textarea>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="bukti" class="form-label">Upload Bukti (Nota/Struk)</label>
                        <input class="form-control" type="file" id="bukti" name="bukti" required>
                        <small class="form-text text-muted">Format: JPG, PNG. Maks: 2MB.</small>
                    </div> -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('bendahara/kas-keluar') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-danger">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>