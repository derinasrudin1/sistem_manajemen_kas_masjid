<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Kas Keluar</h3>
                </div>
                
                <!-- Tampilkan error validasi -->
                <?php if (session()->get('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->get('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
                
                <!-- Tampilkan pesan error lainnya -->
                <?php if (session()->get('error')) : ?>
                    <div class="alert alert-danger">
                        <?= session()->get('error') ?>
                    </div>
                <?php endif ?>
                
                <form action="<?= base_url('/admin/kas-keluar/store'); ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal *</label>
                                    <input type="date" class="form-control <?= (session()->get('errors.tanggal')) ? 'is-invalid' : '' ?>" 
                                           id="tanggal" name="tanggal" 
                                           value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                                    <?php if (session()->get('errors.tanggal')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session()->get('errors.tanggal') ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_masjid">Masjid</label>
                                    <select class="form-control" id="id_masjid" name="id_masjid">
                                        <option value="">Pilih Masjid</option>
                                        <?php foreach ($masjid as $m) : ?>
                                            <option value="<?= $m['id_masjid'] ?>" 
                                                <?= (old('id_masjid') == $m['id_masjid']) ? 'selected' : '' ?>>
                                                <?= esc($m['nama_masjid']) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah">Jumlah *</label>
                                    <input type="number" class="form-control <?= (session()->get('errors.jumlah')) ? 'is-invalid' : '' ?>" 
                                           id="jumlah" name="jumlah" 
                                           value="<?= old('jumlah') ?>" placeholder="Masukkan jumlah" required>
                                    <?php if (session()->get('errors.jumlah')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session()->get('errors.jumlah') ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kategori">Kategori *</label>
                                    <select class="form-control <?= (session()->get('errors.kategori')) ? 'is-invalid' : '' ?>" 
                                            id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kategori as $k) : ?>
                                            <option value="<?= $k['nama_kategori'] ?>" 
                                                <?= (old('kategori') == $k['nama_kategori']) ? 'selected' : '' ?>>
                                                <?= esc($k['nama_kategori']) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                    <?php if (session()->get('errors.kategori')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session()->get('errors.kategori') ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" 
                                      rows="3" placeholder="Masukkan keterangan"><?= old('keterangan') ?></textarea>
                        </div>

                        <!-- <div class="form-group">
                            <label for="bukti">Bukti Transaksi *</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input <?= (session()->get('errors.bukti')) ? 'is-invalid' : '' ?>" 
                                       id="bukti" name="bukti" required>
                                <label class="custom-file-label" for="bukti">Pilih file</label>
                                <?php if (session()->get('errors.bukti')) : ?>
                                    <div class="invalid-feedback">
                                        <?= session()->get('errors.bukti') ?>
                                    </div>
                                <?php endif ?>
                                <small class="text-muted">Format: JPG/PNG, Max: 2MB</small>
                            </div>
                        </div> -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?= base_url('/admin/kas-keluar') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
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
    // Menampilkan nama file yang dipilih
    $(document).ready(function() {
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
        
        // Set tanggal default ke hari ini
        $('#tanggal').val(new Date().toISOString().substr(0, 10));
    });
</script>
<?= $this->endSection(); ?>