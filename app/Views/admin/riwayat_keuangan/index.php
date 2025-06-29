<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Keuangan Masjid</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('/admin/riwayat-keuangan/export-pdf') . '?' . http_build_query($_GET); ?>"
                            class="btn btn-success btn-sm">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Masjid</label>
                                    <select name="masjid" class="form-control">
                                        <option value="">Semua Masjid</option>
                                        <?php foreach ($masjidList as $masjid): ?>
                                            <option value="<?= $masjid['id_masjid'] ?>"
                                                <?= ($selectedMasjid == $masjid['id_masjid']) ? 'selected' : '' ?>>
                                                <?= esc($masjid['nama_masjid']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dari Tanggal</label>
                                    <input type="date" name="start_date" class="form-control" value="<?= $startDate ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" name="end_date" class="form-control" value="<?= $endDate ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="padding-top: 30px">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="<?= base_url('/admin/riwayat-keuangan') ?>" class="btn btn-secondary">
                                        <i class="fas fa-sync"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Keterangan</th>
                                            <th>Kategori</th>
                                            <th>Jumlah</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $saldo = $saldoAwal;
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td colspan="4" class="text-right"><strong>Saldo Awal</strong></td>
                                            <td class="text-right"><?= number_format($saldo, 0, ',', '.') ?></td>
                                        </tr>
                                        <?php foreach ($transaksi as $trx): ?>
                                            <?php
                                            if ($trx['jenis'] === 'masuk') {
                                                $saldo += $trx['jumlah'];
                                                $color = 'text-success';
                                                $icon = '<i class="fas fa-arrow-down"></i> Masuk';
                                            } else {
                                                $saldo -= $trx['jumlah'];
                                                $color = 'text-danger';
                                                $icon = '<i class="fas fa-arrow-up"></i> Keluar';
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= date('d-m-Y', strtotime($trx['tanggal'])) ?></td>
                                                <td class="<?= $color ?>"><?= $icon ?></td>
                                                <td><?= esc($trx['keterangan']) ?></td>
                                                <td><?= esc($trx['kategori'] ?? '-') ?></td>
                                                <td class="text-right <?= $color ?>">
                                                    <?= number_format($trx['jumlah'], 0, ',', '.') ?>
                                                </td>
                                                <td class="text-right">
                                                    <?= number_format($saldo, 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-right">Total Pemasukan</th>
                                            <th class="text-right text-success">
                                                <?= number_format($totalPemasukan, 0, ',', '.') ?>
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" class="text-right">Total Pengeluaran</th>
                                            <th class="text-right text-danger">
                                                <?= number_format($totalPengeluaran, 0, ',', '.') ?>
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" class="text-right">Saldo Akhir</th>
                                            <th></th>
                                            <th class="text-right">
                                                <?= number_format($saldo, 0, ',', '.') ?>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[1, 'asc']],
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data per halaman',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: '&raquo;',
                    previous: '&laquo;'
                }
            }
        });
    });
</script>
<?= $this->endSection(); ?>