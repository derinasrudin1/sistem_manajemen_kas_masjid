<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Kas Masuk
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('kasmasuk') ?>">Kas Masuk</a></li>
<li class="breadcrumb-item active">Edit</li>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <!-- <h1 class="card-title h4 mb-0">Edit Data Kas Masuk</h1> -->
            </div>
            <div class="card-body">

                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="<?= base_url('kasmasuk/update/' . $kas['id_kas_masuk']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal"
                            class="form-control <?= (validation_show_error('tanggal')) ? 'is-invalid' : '' ?>"
                            value="<?= old('tanggal', $kas['tanggal']) ?>" required>
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
                                value="<?= old('jumlah', $kas['jumlah']) ?>" placeholder="Contoh: 50000" required>
                            <div class="invalid-feedback">
                                <?= validation_show_error('jumlah') ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sumber" class="form-label">Sumber Dana</label>
                        <input type="text" id="sumber" name="sumber"
                            class="form-control <?= (validation_show_error('sumber')) ? 'is-invalid' : '' ?>"
                            value="<?= old('sumber', esc($kas['sumber'])) ?>" placeholder="Contoh: Donasi Hamba Allah"
                            required>
                        <div class="invalid-feedback">
                            <?= validation_show_error('sumber') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="4"
                            placeholder="Tambahkan detail jika diperlukan..."><?= old('keterangan', esc($kas['keterangan'])) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('kasmasuk') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>