<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Riwayat Transaksi<?= $this->endSection() ?>
<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active">Riwayat Transaksi</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header bg-info text-white">
        <h3>Sisa Saldo Rp <?= number_format($sisaSaldo, 0, ',', '.') ?></h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Sumber</th>
                        <th>Tujuan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayat as $item): ?>
                        <tr>
                            <td><?= date('d-m-Y', strtotime($item['tanggal'])) ?></td>
                            <td><?= $item['jenis'] ?></td>
                            <td class="<?= $item['jenis'] == 'Keluar' ? 'text-danger' : 'text-success' ?>">
                                Rp <?= number_format($item['jumlah'], 0, ',', '.') ?>
                            </td>
                            <td><?= $item['sumber'] ?></td>
                            <td><?= $item['kategori'] ?></td>
                            <td><?= $item['keterangan'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?= $this->endSection() ?>