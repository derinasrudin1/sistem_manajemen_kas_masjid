<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Edit Kas Masuk<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('admin/kas-masuk') ?>">Kas Masuk</a></li>
<li class="breadcrumb-item active">Edit Data</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Kas Masuk</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/kas-masuk/update/' . $kasMasuk['id_kas_masuk']) ?>" method="POST"
            enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : '' ?>"
                    id="tanggal" name="tanggal" value="<?= old('tanggal', $kasMasuk['tanggal']) ?>" required>
                <div class="invalid-feedback">
                    <?= $validation->getError('tanggal') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="id_masjid">Masjid</label>
                <select class="form-control <?= ($validation->hasError('id_masjid')) ? 'is-invalid' : '' ?>"
                    id="id_masjid" name="id_masjid" required>
                    <option value="">Pilih Masjid</option>
                    <?php foreach ($masjids as $masjid): ?>
                        <option value="<?= $masjid['id_masjid'] ?>" <?= old('id_masjid', $kasMasuk['id_masjid']) == $masjid['id_masjid'] ? 'selected' : '' ?>>
                            <?= esc($masjid['nama_masjid']) ?> (<?= esc($masjid['rt_rw']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('id_masjid') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah (Rp)</label>
                <input type="number" class="form-control <?= ($validation->hasError('jumlah')) ? 'is-invalid' : '' ?>"
                    id="jumlah" name="jumlah" value="<?= old('jumlah', $kasMasuk['jumlah']) ?>" min="1" required>
                <div class="invalid-feedback">
                    <?= $validation->getError('jumlah') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="sumber">Sumber Dana</label>
                <select class="form-control <?= ($validation->hasError('sumber')) ? 'is-invalid' : '' ?>" id="sumber"
                    name="sumber" required>
                    <option value="">Pilih Sumber Dana</option>
                    <?php foreach ($sumberDana as $sumber): ?>
                        <option value="<?= $sumber['nama_sumber'] ?>" <?= old('sumber', $kasMasuk['sumber']) == $sumber['nama_sumber'] ? 'selected' : '' ?>>
                            <?= esc($sumber['nama_sumber']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('sumber') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan"
                    rows="3"><?= old('keterangan', $kasMasuk['keterangan']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="bukti">Bukti Transaksi</label>
                <?php if (!empty($kasMasuk['bukti'])): ?>
                    <div class="mb-2">
                        <a href="<?= base_url('admin/kas-masuk/view-bukti/' . $kasMasuk['bukti']) ?>" target="_blank"
                            class="d-block mb-2">
                            <img src="<?= base_url('admin/kas-masuk/view-bukti/' . $kasMasuk['bukti']) ?>"
                                class="img-thumbnail" style="max-height: 150px; max-width: 150px;">
                        </a>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hapus_bukti" name="hapus_bukti" value="1">
                            <label class="form-check-label text-danger" for="hapus_bukti">
                                Hapus bukti saat ini
                            </label>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="custom-file">
                    <input type="file"
                        class="custom-file-input <?= ($validation->hasError('bukti')) ? 'is-invalid' : '' ?>" id="bukti"
                        name="bukti" accept="image/jpeg,image/png,image/jpg">
                    <label class="custom-file-label" for="bukti">
                        <?= empty($kasMasuk['bukti']) ? 'Pilih file bukti' : 'Unggah file baru (opsional)' ?>
                    </label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('bukti') ?>
                    </div>
                    <small class="form-text text-muted">Format: JPG, JPEG, PNG (max 2MB)</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="<?= base_url('admin/kas-masuk') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Menampilkan nama file yang dipilih
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Disable file input jika hapus bukti dicentang
        $('#hapus_bukti').change(function() {
            if ($(this).is(':checked')) {
                $('#bukti').prop('disabled', true);
                $('.custom-file-label').text('Bukti akan dihapus');
            } else {
                $('#bukti').prop('disabled', false);
                $('.custom-file-label').text('Pilih file baru');
            }
        });
    });
</script>
<?= $this->endSection() ?>