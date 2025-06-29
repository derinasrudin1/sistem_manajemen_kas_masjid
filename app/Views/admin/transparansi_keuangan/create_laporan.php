<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buat Laporan Transparansi</h3>
                </div>
                <form action="<?= base_url('/admin/transparansi-keuangan/store') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="judul">Judul Laporan *</label>
                            <input type="text" class="form-control <?= (session()->get('errors.judul') ? 'is-invalid' : '' ?>"
                                   id="judul" name="judul" value="<?= old('judul') ?>" required>
                            <?php if (session()->get('errors.judul')) : ?>
                                <div class="invalid-feedback">
                                    <?= session()->get('errors.judul') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="id_masjid">Masjid *</label>
                            <select class="form-control <?= (session()->get('errors.id_masjid') ? 'is-invalid' : '' ?>" 
                                    id="id_masjid" name="id_masjid" required>
                                <option value="">Pilih Masjid</option>
                                <?php foreach ($masjidList as $masjid) : ?>
                                    <option value="<?= $masjid['id_masjid'] ?>" 
                                        <?= (old('id_masjid') == $masjid['id_masjid']) ? 'selected' : '' ?>>
                                        <?= esc($masjid['nama_masjid']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->get('errors.id_masjid')) : ?>
                                <div class="invalid-feedback">
                                    <?= session()->get('errors.id_masjid') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="periode_awal">Periode Awal *</label>
                                    <input type="date" class="form-control <?= (session()->get('errors.periode_awal') ? 'is-invalid' : '' ?>" 
                                           id="periode_awal" name="periode_awal" value="<?= old('periode_awal') ?>" required>
                                    <?php if (session()->get('errors.periode_awal')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session()->get('errors.periode_awal') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="periode_akhir">Periode Akhir *</label>
                                    <input type="date" class="form-control <?= (session()->get('errors.periode_akhir') ? 'is-invalid' : '' ?>" 
                                           id="periode_akhir" name="periode_akhir" value="<?= old('periode_akhir') ?>" required>
                                    <?php if (session()->get('errors.periode_akhir')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session()->get('errors.periode_akhir') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" 
                                      rows="3"><?= old('catatan') ?></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Laporan
                        </button>
                        <a href="<?= base_url('/admin/transparansi-keuangan') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        // Set default tanggal periode
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        
        $('#periode_awal').val(firstDay.toISOString().substr(0, 10));
        $('#periode_akhir').val(today.toISOString().substr(0, 10));
    });
</script>
<?= $this->endSection(); ?>