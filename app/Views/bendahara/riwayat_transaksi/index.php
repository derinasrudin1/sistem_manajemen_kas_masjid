<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Riwayat Keuangan
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('/bendahara/dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Riwayat Keuangan</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Riwayat Keuangan Masjid</h3>
            </div>
            <div class="card-body">
                <!-- //Form Filter Tanggal
                <form action="<?= base_url('bendahara/riwayat-transaksi') ?>" method="get" class="mb-4">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="<?= esc($startDate) ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="<?= esc($endDate) ?>">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                            <a href="<?= base_url('bendahara/riwayat-transaksi') ?>" class="btn btn-secondary"><i
                                    class="fas fa-sync-alt"></i> Reset</a>
                        </div>
                    </div>
                </form> -->

                <div class="table-responsive">
                    <table id="riwayatTable" class="table table-bordered table-striped" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Kategori/Sumber</th>
                                <th class="text-end">Pemasukan</th>
                                <th class="text-end">Pengeluaran</th>
                                <th class="text-end">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Baris Saldo Awal
                            <tr class="table-secondary">
                                <td colspan="7" class="fw-bold">Saldo Awal</td>
                                <td class="text-end fw-bold">Rp <?= number_format($saldoAwal, 0, ',', '.') ?></td>
                            </tr> -->

                            <?php
                            $saldoBerjalan = $saldoAwal;
                            if (!empty($transaksi)):
                                foreach ($transaksi as $i => $trx):
                                    if ($trx['jenis'] === 'Pemasukan') {
                                        $saldoBerjalan += $trx['jumlah'];
                                    } else {
                                        $saldoBerjalan -= $trx['jumlah'];
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= date('d M Y', strtotime($trx['tanggal'])) ?></td>
                                        <td>
                                            <?php if ($trx['jenis'] == 'Pemasukan'): ?>
                                                <span class="badge bg-success">Pemasukan</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Pengeluaran</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($trx['keterangan']) ?></td>
                                        <td><?= esc($trx['sumber_kategori']) ?></td>

                                        <td class="text-success text-end">
                                            <?= $trx['jenis'] === 'Pemasukan' ? 'Rp ' . number_format($trx['jumlah'], 0, ',', '.') : '-' ?>
                                        </td>
                                        <td class="text-danger text-end">
                                            <?= $trx['jenis'] === 'Pengeluaran' ? 'Rp ' . number_format($trx['jumlah'], 0, ',', '.') : '-' ?>
                                        </td>
                                        <td class="text-end fw-bold">Rp <?= number_format($saldoBerjalan, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr class="fw-bold">
                                <td colspan="5">Total</td>
                                <td class="text-end">Rp <?= number_format($totalPemasukan, 0, ',', '.') ?></td>
                                <td class="text-end">Rp <?= number_format($totalPengeluaran, 0, ',', '.') ?></td>
                                <td class="text-end">Rp
                                    <?= number_format($saldoAwal + $totalPemasukan - $totalPengeluaran, 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    $(document).ready(function () {
        $('#riwayatTable').DataTable({
            "paging": true,
            "info": true,
            "searching": true,
            "ordering": true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12'B>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                { extend: 'copy', text: '<i class="fas fa-copy"></i> Salin', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } },
                { extend: 'print', text: '<i class="fas fa-print"></i> Cetak', className: 'btn btn-secondary', exportOptions: { columns: ':not(.no-export)' } }
            ],
            language: { url: "https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json" }
        });
    });
</script>
<?= $this->endSection() ?>