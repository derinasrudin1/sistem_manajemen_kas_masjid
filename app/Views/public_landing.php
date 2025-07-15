<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Smart Finacial Mangement For Mosques') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        /* PERUBAHAN: Navbar tidak lagi menggunakan style custom karena sudah menggunakan bg-dark */
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* PERUBAHAN: Menambahkan URL gambar baru untuk hero section */
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?= base_url('hero-bg.jpg') ?>');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 12rem 0;
            text-align: center;

        }

        .hero-section h1 {
            font-weight: 700;
            font-size: 3.5rem;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: #0d6efd;
            border-radius: 2px;
        }

        .btn-whatsapp {
            background-color: #25D366;
            color: white;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-whatsapp:hover {
            background-color: #1DAE51;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .table-wrapper,
        .masjid-card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .masjid-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        footer {
            background-color: #212529;
            color: #adb5bd;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
                <i class="fas fa-mosque text-white-50"></i> Sistem Kas Masjid
            </a>
            <a href="<?= base_url('/auth') ?>" class="btn btn-outline-light">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <h1 class="display-4">Selamat Datang</h1>
            <p class="lead">Aplikasi Manajemen Keuangan Masjid Terpadu & Transparan</p>
        </div>
    </header>


    <!-- Donation Section -->
    <section id="donasi" class="py-5">
        <div class="container text-center">
            <h2 class="section-title">Salurkan Infaq & Donasi Anda</h2>
            <p class="lead text-muted mb-4">Dana yang terkumpul akan dialokasikan untuk biaya operasional, pembangunan,
                serta kegiatan sosial masjid. <br>Untuk berdonasi, silakan hubungi admin kami melalui WhatsApp.</p>
            <a href="https://wa.me/6289687598053?text=Assalamualaikum,%20saya%20ingin%20berdonasi%20untuk%20masjid."
                class="btn btn-whatsapp" target="_blank">
                <i class="fab fa-whatsapp"></i> Hubungi Admin
            </a>
        </div>
    </section>
    <!-- Masjid List Section (dengan Nama Bendahara Dinamis) -->
    <section id="masjid" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Masjid yang Kami Kelola</h2>

            <div class="row">
                <?php if (!empty($masjidList)): ?>
                    <?php foreach ($masjidList as $masjid): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 text-center masjid-card">
                                <div class="card-body d-flex flex-column">
                                    <div class="mb-3"><i class="fas fa-mosque fa-3x text-primary"></i></div>
                                    <h5 class="card-title fw-bold"><?= esc($masjid['nama_masjid']) ?></h5>
                                    <p class="card-text text-muted small flex-grow-1"><?= esc($masjid['alamat']) ?></p>
                                    <p class="card-text text-muted small flex-grow-1">Takmir :
                                        <?= esc($masjid['nama_takmir']) ?>
                                    </p>
                                    <hr>


                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Belum ada data masjid yang terdaftar.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Financial History Section -->
    <section id="laporan" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Transparansi Keuangan</h2>

            <!-- Form Filter -->
            <form action="<?= base_url('/') ?>" method="get" class="mb-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select name="id_masjid" class="form-select">
                                <option value="">Tampilkan Semua Masjid</option>
                                <?php foreach ($masjidList as $masjid): ?>
                                    <option value="<?= $masjid['id_masjid'] ?>" <?= ($selectedMasjid == $masjid['id_masjid']) ? 'selected' : '' ?>>
                                        <?= esc($masjid['nama_masjid']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-wrapper bg-white p-4">
                <table id="riwayatTable" class="table table-hover" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Masjid</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi)): ?>
                            <?php foreach ($transaksi as $trx): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($trx['tanggal'])) ?></td>
                                    <td><?= esc($trx['nama_masjid']) ?></td>
                                    <td>
                                        <span
                                            class="badge bg-<?= $trx['jenis'] == 'Pemasukan' ? 'success' : 'danger' ?>"><?= $trx['jenis'] ?></span>
                                    </td>
                                    <td><?= esc($trx['keterangan']) ?></td>
                                    <td
                                        class="text-end fw-bold text-<?= $trx['jenis'] == 'Pemasukan' ? 'success' : 'danger' ?>">
                                        Rp <?= number_format($trx['jumlah'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 text-center bg-dark text-white-50">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> Smart Finacial Mangement For Mosques. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function () {
            $('#riwayatTable').DataTable({
                "order": [[0, "desc"]],
                "language": { "url": "https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json" }
            });
        });
    </script>
</body>

</html>