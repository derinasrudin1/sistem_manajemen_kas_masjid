<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Detail Laporan<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('admin/laporan') ?>">Master Data Laporan</a></li>
<li class="breadcrumb-item active">Detail Laporan</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Laporan</h3>
        <div class="card-tools">
            <a href="<?= base_url("admin/laporan/print/{$laporan['id_laporan']}") ?>" class="btn btn-sm btn-secondary"
                target="_blank">
                <i class="fas fa-print"></i> Cetak
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h4><?= esc($laporan['judul']) ?></h4>
                <p>
                    <strong>Masjid:</strong> <?= esc($laporan['nama_masjid']) ?><br>
                    <strong>Periode:</strong>
                    <?= date('d M Y', strtotime($laporan['periode_awal'])) ?> -
                    <?= date('d M Y', strtotime($laporan['periode_akhir'])) ?>
                </p>
            </div>
            <div class="col-md-6 text-right">
                <p>
                    <strong>Dibuat oleh:</strong> <?= esc($laporan['nama_user']) ?><br>
                    <strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($laporan['created_at'])) ?>
                </p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pemasukan</span>
                        <span class="info-box-number">Rp
                            <?= number_format($laporan['total_pemasukan'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-danger">
                    <span class="info-box-icon"><i class="fas fa-receipt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pengeluaran</span>
                        <span class="info-box-number">Rp
                            <?= number_format($laporan['total_pengeluaran'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Saldo Akhir</span>
                        <span class="info-box-number">Rp
                            <?= number_format($laporan['saldo_akhir'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <h5>Daftar Transaksi</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $t): ?>
                    <tr>
                        <td><?= date('d M Y', strtotime($t['tanggal'])) ?></td>
                        <td>
                            <?php if ($t['jenis'] == 'masuk'): ?>
                                <span class="badge badge-success">Pemasukan</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Pengeluaran</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($t['keterangan']) ?></td>
                        <td class="text-right">Rp <?= number_format($t['jumlah'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (!empty($laporan['catatan'])): ?>
            <div class="mt-4">
                <h5>Catatan</h5>
                <p><?= nl2br(esc($laporan['catatan'])) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>