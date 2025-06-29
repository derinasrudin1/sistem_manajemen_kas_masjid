<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= esc($laporan['judul']) ?></h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Masjid:</strong> <?= esc($masjid['nama_masjid']) ?></p>
                            <p><strong>Alamat:</strong> <?= esc($masjid['alamat']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Periode:</strong> 
                                <?= date('d M Y', strtotime($laporan['periode_awal'])) ?> - 
                                <?= date('d M Y', strtotime($laporan['periode_akhir'])) ?>
                            </p>
                            <p><strong>Tanggal Publikasi:</strong> 
                                <?= date('d M Y H:i', strtotime($laporan['created_at'])) ?>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>Total Pemasukan</h5>
                                    <h3>Rp <?= number_format($laporan['total_pemasukan'], 0, ',', '.') ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h5>Total Pengeluaran</h5>
                                    <h3>Rp <?= number_format($laporan['total_pengeluaran'], 0, ',', '.') ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5>Saldo Akhir</h5>
                                    <h3>Rp <?= number_format($laporan['saldo_akhir'], 0, ',', '.') ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($laporan['catatan'])) : ?>
                        <div class="alert alert-info">
                            <h5>Catatan:</h5>
                            <p><?= nl2br(esc($laporan['catatan'])) ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="text-center mt-4">
                        <a href="<?= base_url('/transparansi-keuangan') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>