<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Tambah Kas Masuk<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('admin/kas-masuk') ?>">Kas Masuk</a></li>
<li class="breadcrumb-item active">Tambah Data</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Kas Masuk</h3>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/kas-masuk/store') ?>" method="POST" enctype="multipart/form-data"
            id="formKasMasuk">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                <input type="date" class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : '' ?>"
                    id="tanggal" name="tanggal" value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                <div class="invalid-feedback">
                    <?= $validation->getError('tanggal') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="id_masjid">Masjid <span class="text-danger">*</span></label>
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
                <label for="jumlah">Jumlah (Rp) <span class="text-danger">*</span></label>
                <input type="number" class="form-control <?= ($validation->hasError('jumlah')) ? 'is-invalid' : '' ?>"
                    id="jumlah" name="jumlah" value="<?= old('jumlah') ?>" min="1" required>
                <div class="invalid-feedback">
                    <?= $validation->getError('jumlah') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="sumber">Sumber Dana <span class="text-danger">*</span></label>
                <select class="form-control <?= ($validation->hasError('sumber')) ? 'is-invalid' : '' ?>" id="sumber"
                    name="sumber" required>
                    <option value="">Pilih Sumber Dana</option>
                    <?php foreach ($sumberDana as $sumber): ?>
                        <option value="<?= $sumber['nama_sumber'] ?>" <?= old('sumber') == $sumber['nama_sumber'] ? 'selected' : '' ?>>
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
                    rows="3"><?= old('keterangan') ?></textarea>
            </div>

            <div class="form-group">
                <label for="bukti">Bukti Transaksi <span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file"
                        class="custom-file-input <?= ($validation->hasError('bukti')) ? 'is-invalid' : '' ?>" id="bukti"
                        name="bukti" required accept=".jpg,.jpeg,.png">
                    <label class="custom-file-label" for="bukti">Pilih file...</label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('bukti') ?>
                    </div>
                </div>
                <small class="form-text text-muted">Format: JPG, JPEG, PNG (max 2MB)</small>
                <div id="previewContainer" class="mt-2" style="display:none;">
                    <img id="previewImage" src="#" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="<?= base_url('admin/kas-masuk') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        // Menampilkan nama file yang dipilih
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);

            // Preview gambar
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#previewImage').attr('src', e.target.result);
                    $('#previewContainer').show();
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        // Validasi form sebelum submit
        $('#formKasMasuk').on('submit', function () {
            $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        });
    });
</script>
<?= $this->endSection() ?>