<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan - <?= $laporan['judul'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .info {
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary-item {
            display: inline-block;
            margin-right: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">LAPORAN KEUANGAN MASJID</div>
        <div><?= $laporan['judul'] ?></div>
    </div>

    <div class="info">
        <table width="100%">
            <tr>
                <td width="50%">
                    <strong>Masjid:</strong> <?= $laporan['nama_masjid'] ?><br>
                    <strong>Periode:</strong>
                    <?= date('d M Y', strtotime($laporan['periode_awal'])) ?> -
                    <?= date('d M Y', strtotime($laporan['periode_akhir'])) ?>
                </td>
                <td width="50%" style="text-align: right;">
                    <strong>Dibuat oleh:</strong> <?= $laporan['nama_user'] ?><br>
                    <strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($laporan['created_at'])) ?>
                </td>
            </tr>
        </table>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>Total Pemasukan:</strong> Rp <?= number_format($laporan['total_pemasukan'], 0, ',', '.') ?>
        </div>
        <div class="summary-item">
            <strong>Total Pengeluaran:</strong> Rp <?= number_format($laporan['total_pengeluaran'], 0, ',', '.') ?>
        </div>
        <div class="summary-item">
            <strong>Saldo Akhir:</strong> Rp <?= number_format($laporan['saldo_akhir'], 0, ',', '.') ?>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transaksi as $t): ?>
                <tr>
                    <td><?= date('d M Y', strtotime($t['tanggal'])) ?></td>
                    <td><?= $t['jenis'] == 'masuk' ? 'Pemasukan' : 'Pengeluaran' ?></td>
                    <td><?= $t['keterangan'] ?></td>
                    <td class="text-right">Rp <?= number_format($t['jumlah'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (!empty($laporan['catatan'])): ?>
        <div class="catatan">
            <strong>Catatan:</strong><br>
            <?= nl2br($laporan['catatan']) ?>
        </div>
    <?php endif; ?>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br><br>
        <p>_________________________</p>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>