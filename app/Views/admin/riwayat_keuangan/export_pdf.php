<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            padding: 0;
        }

        .header p {
            margin: 5px 0 0 0;
            padding: 0;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .text-success {
            color: #28a745;
        }

        .text-danger {
            color: #dc3545;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN KEUANGAN MASJID</h2>
        <?php if ($masjid): ?>
            <p><?= esc($masjid['nama_masjid']) ?></p>
        <?php endif; ?>
        <p>Periode: <?= $startDate ?> s/d <?= $endDate ?></p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="20%">Tanggal Cetak</td>
                <td>: <?= date('d-m-Y H:i:s') ?></td>
            </tr>
            <tr>
                <td>Saldo Awal</td>
                <td>: Rp <?= number_format($saldoAwal, 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="10%">Jenis</th>
                <th width="25%">Keterangan</th>
                <th width="15%">Kategori</th>
                <th width="15%">Jumlah</th>
                <th width="15%">Saldo</th>
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
                <td class="text-right">Rp <?= number_format($saldo, 0, ',', '.') ?></td>
            </tr>
            <?php foreach ($transaksi as $trx): ?>
                <?php
                if ($trx['jenis'] === 'masuk') {
                    $saldo += $trx['jumlah'];
                    $color = 'text-success';
                    $icon = 'Masuk';
                } else {
                    $saldo -= $trx['jumlah'];
                    $color = 'text-danger';
                    $icon = 'Keluar';
                }
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($trx['tanggal'])) ?></td>
                    <td class="<?= $color ?>"><?= $icon ?></td>
                    <td><?= esc($trx['keterangan']) ?></td>
                    <td><?= esc($trx['kategori'] ?? '-') ?></td>
                    <td class="text-right <?= $color ?>">
                        Rp <?= number_format($trx['jumlah'], 0, ',', '.') ?>
                    </td>
                    <td class="text-right">
                        Rp <?= number_format($saldo, 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Pemasukan</th>
                <th class="text-right text-success">
                    Rp <?= number_format($totalPemasukan, 0, ',', '.') ?>
                </th>
                <th></th>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Total Pengeluaran</th>
                <th class="text-right text-danger">
                    Rp <?= number_format($totalPengeluaran, 0, ',', '.') ?>
                </th>
                <th></th>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Saldo Akhir</th>
                <th></th>
                <th class="text-right">
                    Rp <?= number_format($saldo, 0, ',', '.') ?>
                </th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Bendahara Masjid</strong></p>
    </div>
</body>

</html>