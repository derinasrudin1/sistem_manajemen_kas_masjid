<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Master Data Laporan<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Master Data Laporan</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <a href="<?= base_url('admin/laporan/generate') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Generate Laporan
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Laporan</th>
                    <th>Masjid</th>
                    <th>Periode</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>Saldo</th>
                    <th>Dibuat Oleh</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($laporans as $i => $laporan): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($laporan['judul']) ?></td>
                        <td><?= esc($laporan['nama_masjid'] ?? '-') ?></td>
                        <td>
                            <?= date('d M Y', strtotime($laporan['periode_awal'])) ?> -
                            <?= date('d M Y', strtotime($laporan['periode_akhir'])) ?>
                        </td>
                        <td class="text-right"><?= number_format($laporan['total_pemasukan'], 0, ',', '.') ?></td>
                        <td class="text-right"><?= number_format($laporan['total_pengeluaran'], 0, ',', '.') ?></td>
                        <td class="text-right"><?= number_format($laporan['saldo_akhir'], 0, ',', '.') ?></td>
                        <td><?= esc($laporan['nama_user'] ?? '-') ?></td>
                        <td><?= date('d M Y H:i', strtotime($laporan['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url("admin/laporan/show/{$laporan['id_laporan']}") ?>"
                                class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= base_url("admin/laporan/print/{$laporan['id_laporan']}") ?>"
                                class="btn btn-sm btn-secondary" title="Cetak" target="_blank">
                                <i class="fas fa-print"></i>
                            </a>
                            <form action="<?= base_url("admin/laporan/delete/{$laporan['id_laporan']}") ?>" method="POST"
                                class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="return confirm('Apakah Anda yakin?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[8, 'desc']]
        });
    });
</script>
<?= $this->endSection() ?>