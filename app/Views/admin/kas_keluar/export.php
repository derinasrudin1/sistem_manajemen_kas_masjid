<?= $this->extend('layouts/main') ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Export Data Kas Keluar</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Masjid</th>
                                    <th>Jumlah</th>
                                    <th>Kategori</th>
                                    <th>Keterangan</th>
                                    <th>Input Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($kasKeluar as $kk) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= date('d-m-Y', strtotime($kk['tanggal'])); ?></td>
                                        <td><?= $kk['nama_masjid'] ?? '-'; ?></td>
                                        <td><?= number_format($kk['jumlah'], 0, ',', '.'); ?></td>
                                        <td><?= $kk['kategori']; ?></td>
                                        <td><?= $kk['keterangan'] ?? '-'; ?></td>
                                        <td><?= $kk['nama_user'] ?? '-'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('/admin/kas-keluar'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>