<?= $this->extend('layouts/main') ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Kas Keluar</h3>
                </div>
                <form action="<?= base_url('/admin/kas-keluar/' . $kasKeluar['id_kas_keluar']); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date"
                                        class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : ''; ?>"
                                        id="tanggal" name="tanggal"
                                        value="<?= old('tanggal', $kasKeluar['tanggal']); ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tanggal'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_masjid">Masjid</label>
                                    <select class="form-control" id="id_masjid" name="id_masjid">
                                        <option value="">Pilih Masjid</option>
                                        <?php foreach ($masjid as $m): ?>
                                            <option value="<?= $m['id_masjid']; ?>" <?= (old('id_masjid', $kasKeluar['id_masjid']) == $m['id_masjid']) ? 'selected' : ''; ?>>
                                                <?= $m['nama_masjid']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number"
                                        class="form-control <?= ($validation->hasError('jumlah')) ? 'is-invalid' : ''; ?>"
                                        id="jumlah" name="jumlah" value="<?= old('jumlah', $kasKeluar['jumlah']); ?>"
                                        placeholder="Masukkan jumlah">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jumlah'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select
                                        class="form-control <?= ($validation->hasError('kategori')) ? 'is-invalid' : ''; ?>"
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
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Masukkan keterangan"><?= old('keterangan', $kasKeluar['keterangan']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="bukti">Bukti Transaksi</label>
                            <div class="custom-file">
                                <input type="file"
                                    class="custom-file-input <?= ($validation->hasError('bukti')) ? 'is-invalid' : ''; ?>"
                                    id="bukti" name="bukti">
                                <label class="custom-file-label"
                                    for="bukti"><?= $kasKeluar['bukti'] ? $kasKeluar['bukti'] : 'Pilih file'; ?></label>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('bukti'); ?>
                                </div>
                                <small class="text-muted">Format: JPG/PNG, Max: 2MB</small>
                                <?php if ($kasKeluar['bukti']): ?>
                                    <div class="mt-2">
                                        <a href="<?= base_url('uploads/bukti_kas_keluar/' . $kasKeluar['bukti']); ?>"
                                            target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Lihat Bukti Saat Ini
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= base_url('/admin/kas-keluar'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    // Menampilkan nama file yang dipilih
    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
<?= $this->endSection(); ?>