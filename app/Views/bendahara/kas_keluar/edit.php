<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Kas Keluar
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('/bendahara/dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/bendahara/kas-keluar') ?>">Kas Keluar</a></li>
<li class="breadcrumb-item active">Edit</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit"></i> Formulir Edit Kas Keluar</h3>
            </div>
            <div class="card-body">
                <?php if (session('errors')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <h5 class="alert-heading"><i class="icon fas fa-ban"></i> Gagal Memperbarui!</h5>
                        <ul><?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li><?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
                <form action="<?= base_url('bendahara/kas-keluar/update/' . $kasKeluar['id_kas_keluar']) ?>"
                    method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Pengeluaran</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control"
                            value="<?= old('tanggal', $kasKeluar['tanggal']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <div class="input-group"><span class="input-group-text">Rp</span><input type="number"
                                id="jumlah" name="jumlah" class="form-control"
                                value="<?= old('jumlah', $kasKeluar['jumlah']) ?>" required></div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control <?= ($validation->hasError('kategori')) ? 'is-invalid' : ''; ?>"
                                id="kategori" name="kategori">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['nama_kategori']; ?>" <?= (old('kategori', $kasKeluar['kategori']) == $k['nama_kategori']) ? 'selected' : ''; ?>>
                                        <?= $k['nama_kategori']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kategori'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control"
                            rows="3"><?= old('keterangan', $kasKeluar['keterangan']) ?></textarea>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="bukti" class="form-label">Upload Bukti Baru (Opsional)</label>
                        <input class="form-control" type="file" id="bukti" name="bukti">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah bukti.</small>
                    </div> -->
                    <?php if (!empty($kasKeluar['bukti'])): ?>
                        <div class="mb-3"><label class="form-label">Bukti Saat Ini:</label>
                            <div><a href="<?= base_url('uploads/bukti_kas_keluar/' . $kasKeluar['bukti']) ?>"
                                    target="_blank"><img
                                        src="<?= base_url('uploads/bukti_kas_keluar/' . $kasKeluar['bukti']) ?>" alt="Bukti"
                                        style="max-width: 200px; height: auto; border-radius: 5px; border: 1px solid #ddd; padding: 5px;"></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('bendahara/kas-keluar') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>