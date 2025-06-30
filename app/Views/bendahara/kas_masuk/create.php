<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Tambah Kas Masuk
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('/bendahara/dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/bendahara/kas_masuk') ?>">Kas Masuk</a></li>
<li class="breadcrumb-item active">Tambah</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle"></i>
                    Formulir Tambah Data Kas Masuk
                </h3>
            </div>
            <div class="card-body">

                <!-- Tampilan Error yang Lebih Baik -->
                <?php if (session('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading">Gagal Menyimpan Data!</h5>
                        <p>Mohon periksa kembali kesalahan input di bawah ini:</p>
                        <ul>
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>

                <!-- PERUBAHAN: Menambahkan enctype untuk upload file -->
                <form action="<?= base_url('bendahara/kas-masuk/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal"
                            class="form-control <?= (validation_show_error('tanggal')) ? 'is-invalid' : '' ?>"
                            value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                        <div class="invalid-feedback">
                            <?= validation_show_error('tanggal') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" id="jumlah" name="jumlah"
                                class="form-control <?= (validation_show_error('jumlah')) ? 'is-invalid' : '' ?>"
                                value="<?= old('jumlah') ?>" placeholder="Contoh: 50000" required>
                            <div class="invalid-feedback">
                                <?= validation_show_error('jumlah') ?>
                            </div>
                        </div>
                    </div>

                    <!-- PERUBAHAN: Mengganti input teks menjadi dropdown -->
                    <div class="mb-3">
                        <label for="id_sumber_dana" class="form-label">Sumber Dana</label>
                        <select id="id_sumber_dana" name="id_sumber_dana"
                            class="form-select <?= (validation_show_error('id_sumber_dana')) ? 'is-invalid' : '' ?>"
                            required>
                            <option value="" disabled selected>-- Pilih Sumber Dana --</option>
                            <?php foreach ($sumberDana as $sumber): ?>
                                <option value="<?= $sumber['id_sumber_dana'] ?>"
                                    <?= old('id_sumber_dana') == $sumber['id_sumber_dana'] ? 'selected' : '' ?>>
                                    <?= esc($sumber['nama_sumber']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= validation_show_error('id_sumber_dana') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3"
                            placeholder="Tambahkan detail jika diperlukan..."><?= old('keterangan') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="bukti" class="form-label">Upload Bukti (Gambar)</label>
                        <input class="form-control <?= (validation_show_error('bukti')) ? 'is-invalid' : '' ?>"
                            type="file" id="bukti" name="bukti" required>
                        <div class="invalid-feedback">
                            <?= validation_show_error('bukti') ?>
                        </div>
                        <small class="form-text text-muted">Format: JPG, JPEG, PNG. Ukuran Maksimal: 2MB.</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('bendahara/kas-masuk') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan Data</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>