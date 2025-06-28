-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2025 at 02:34 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kas_masjid`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id_anggaran` int UNSIGNED NOT NULL,
  `id_masjid` int UNSIGNED NOT NULL,
  `nama_anggaran` varchar(100) NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tahun` year NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donasi_online`
--

CREATE TABLE `donasi_online` (
  `id_donasi` int NOT NULL,
  `id_masjid` int UNSIGNED DEFAULT NULL,
  `nama_donatur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `tanggal` date NOT NULL,
  `metode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('pending','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `bukti` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donasi_online`
--

INSERT INTO `donasi_online` (`id_donasi`, `id_masjid`, `nama_donatur`, `nominal`, `tanggal`, `metode`, `status`, `bukti`) VALUES
(1, NULL, 'Tari Oktaviani', 229529.00, '2007-01-12', 'Transfer BCA', 'pending', NULL),
(2, NULL, 'Umar Manullang S.T.', 216030.00, '1992-12-14', 'Dana', 'pending', NULL),
(3, NULL, 'Unggul Prasasta S.Ked', 87166.00, '1974-11-22', 'Dana', 'pending', NULL),
(4, NULL, 'Karen Aisyah Farida', 92319.00, '1994-08-10', 'OVO', 'pending', NULL),
(5, NULL, 'Sakura Hesti Utami', 369410.00, '1974-09-15', 'ShopeePay', 'pending', NULL),
(6, NULL, 'Naradi Hardiansyah', 225125.00, '1976-02-16', 'Dana', 'pending', NULL),
(7, NULL, 'Estiono Hidayanto', 458860.00, '2004-03-13', 'Dana', 'selesai', NULL),
(8, NULL, 'Cawuk Budiman M.Farm', 411730.00, '1971-09-21', 'ShopeePay', 'selesai', NULL),
(9, NULL, 'Olivia Gilda Utami', 384797.00, '1976-10-07', 'Dana', 'pending', NULL),
(10, NULL, 'Lasmono Siregar', 56065.00, '2018-01-17', 'OVO', 'selesai', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kas_keluar`
--

CREATE TABLE `kas_keluar` (
  `id_kas_keluar` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `bukti` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_user` int UNSIGNED DEFAULT NULL,
  `id_masjid` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kas_keluar`
--

INSERT INTO `kas_keluar` (`id_kas_keluar`, `tanggal`, `jumlah`, `kategori`, `keterangan`, `bukti`, `id_user`, `id_masjid`) VALUES
(1, '2007-05-31', 123664.00, 'Kegiatan Ramadhan', 'Adipisci ut sit sunt et ex voluptatibus sed qui.', NULL, NULL, NULL),
(2, '2002-06-09', 46237.00, 'Listrik', 'Quia nemo saepe architecto nobis ut non ut.', NULL, NULL, NULL),
(3, '2001-12-16', 61849.00, 'Air', 'At aut consequatur quia numquam esse ipsum.', NULL, NULL, NULL),
(4, '1987-02-21', 91583.00, 'Perlengkapan Masjid', 'Molestiae animi molestias autem et quis vitae.', NULL, NULL, NULL),
(5, '1976-08-16', 35580.00, 'Kegiatan Ramadhan', 'Corporis dolorem id est reprehenderit.', NULL, NULL, NULL),
(6, '1981-09-29', 107273.00, 'Perlengkapan Masjid', 'Cum quae placeat ut qui rerum.', NULL, NULL, NULL),
(7, '2018-09-13', 78000.00, 'Kegiatan Ramadhan', 'Pariatur deleniti odit ipsa aperiam.', NULL, NULL, NULL),
(8, '1986-06-05', 130784.00, 'Air', 'Non deserunt molestias tempora sit architecto neque quos nobis.', NULL, NULL, NULL),
(9, '1979-07-30', 50654.00, 'Air', 'Ducimus fuga iure aut alias esse cumque.', NULL, NULL, NULL),
(10, '2000-10-30', 101246.00, 'Perlengkapan Masjid', 'Libero praesentium molestiae et debitis quis.', NULL, NULL, NULL),
(11, '1978-02-12', 34344.00, 'Kegiatan Ramadhan', 'Commodi est deleniti ullam quam perspiciatis omnis.', NULL, NULL, NULL),
(12, '1987-11-26', 13672.00, 'Perlengkapan Masjid', 'Tempore optio magnam soluta dolores magnam fuga.', NULL, NULL, NULL),
(13, '1974-11-06', 76459.00, 'Listrik', 'Ipsum sed quod illo est sint aut.', NULL, NULL, NULL),
(14, '2016-12-01', 60946.00, 'Listrik', 'Qui quidem qui deleniti sed dolorum minus.', NULL, NULL, NULL),
(15, '1973-12-08', 32314.00, 'Kegiatan Ramadhan', 'Error velit optio ut doloremque eum qui.', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kas_masuk`
--

CREATE TABLE `kas_masuk` (
  `id_kas_masuk` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `sumber` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `bukti` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_user` int UNSIGNED DEFAULT NULL,
  `id_masjid` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kas_masuk`
--

INSERT INTO `kas_masuk` (`id_kas_masuk`, `tanggal`, `jumlah`, `sumber`, `keterangan`, `bukti`, `id_user`, `id_masjid`) VALUES
(1, '2025-04-15', 194616.00, 'Kotak Amal', 'Hasil Jumatan\r\n', NULL, NULL, NULL),
(2, '1977-01-12', 63846.00, 'Lainnya', 'Perferendis quae id deserunt quo reprehenderit aliquid.', NULL, NULL, NULL),
(3, '2016-08-30', 68988.00, 'Lainnya', 'Quidem quia assumenda facere odit.', NULL, NULL, NULL),
(4, '1996-05-25', 142365.00, 'Donatur Tetap', 'Maiores atque voluptatem nisi aspernatur quos vel doloremque.', NULL, NULL, NULL),
(5, '1977-11-04', 99294.00, 'Transfer Bank', 'Vero optio perferendis aperiam sed iusto voluptate est.', NULL, NULL, NULL),
(6, '1987-01-04', 185608.00, 'Lainnya', 'Occaecati quos in et atque beatae.', NULL, NULL, NULL),
(7, '2019-07-07', 22933.00, 'Lainnya', 'Earum qui incidunt quae debitis et atque.', NULL, NULL, NULL),
(8, '1999-03-01', 110878.00, 'Lainnya', 'Animi debitis odit omnis qui.', NULL, NULL, NULL),
(9, '2010-05-30', 167932.00, 'Donatur Tetap', 'Similique natus et labore et.', NULL, NULL, NULL),
(10, '1983-02-13', 100522.00, 'Lainnya', 'Qui id est labore architecto.', NULL, NULL, NULL),
(12, '1977-04-03', 118551.00, 'Lainnya', 'Sit aut iusto excepturi alias dolor reiciendis adipisci.', NULL, NULL, NULL),
(13, '1999-10-29', 72466.00, 'Kotak Amal', 'Dolor et consequuntur porro voluptas enim dolore officiis ipsa.', NULL, NULL, NULL),
(15, '1992-12-16', 119635.00, 'Lainnya', 'Modi alias cupiditate in autem.', NULL, NULL, NULL),
(16, '1999-09-11', 171832.00, 'Lainnya', 'Aut nemo repellendus voluptatem et quia sint delectus.', NULL, NULL, NULL),
(17, '1975-05-08', 169500.00, 'Transfer Bank', 'Fuga voluptatem quod sit et.', NULL, NULL, NULL),
(18, '1993-08-09', 173580.00, 'Lainnya', 'Ratione qui labore eveniet qui necessitatibus voluptatem.', NULL, NULL, NULL),
(20, '1986-09-29', 160790.00, 'Donatur Tetap', 'Id sunt voluptatem quia enim.', NULL, NULL, NULL),
(21, '2025-06-03', 50000.00, 'Ovo', 'Hamba Allah di Cibugis', NULL, NULL, NULL),
(22, '2025-06-20', 500000.00, 'Warga RT 02', 'Hasil keliling RT 02', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pengeluaran`
--

CREATE TABLE `kategori_pengeluaran` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_pengeluaran`
--

INSERT INTO `kategori_pengeluaran` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Listrik'),
(2, 'Air'),
(3, 'Perlengkapan Masjid'),
(4, 'Kegiatan Ramadhan');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int UNSIGNED NOT NULL,
  `id_masjid` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `total_pemasukan` decimal(12,2) NOT NULL,
  `total_pengeluaran` decimal(12,2) NOT NULL,
  `saldo_akhir` decimal(12,2) NOT NULL,
  `catatan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `masjid`
--

CREATE TABLE `masjid` (
  `id_masjid` int UNSIGNED NOT NULL,
  `nama_masjid` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `rt_rw` varchar(10) NOT NULL,
  `nama_takmir` varchar(100) DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-06-21-105602', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1750503996, 1),
(2, '2025-06-21-105729', 'App\\Database\\Migrations\\CreateSumberDanaTable', 'default', 'App', 1750503996, 1),
(3, '2025-06-21-105801', 'App\\Database\\Migrations\\CreateKategoriPengeluaranTable', 'default', 'App', 1750503996, 1),
(4, '2025-06-21-105827', 'App\\Database\\Migrations\\CreateKasMasukTable', 'default', 'App', 1750504525, 2),
(5, '2025-06-21-105859', 'App\\Database\\Migrations\\CreateKasKeluarTable', 'default', 'App', 1750504713, 3),
(6, '2025-06-21-105923', 'App\\Database\\Migrations\\CreateRiwayatTransaksiTable', 'default', 'App', 1750504713, 3),
(7, '2025-06-21-105950', 'App\\Database\\Migrations\\CreateDonasiOnlineTable', 'default', 'App', 1750504713, 3);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_transaksi`
--

CREATE TABLE `riwayat_transaksi` (
  `id_transaksi` int NOT NULL,
  `jenis` enum('masuk','keluar') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `id_user` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_transaksi`
--

INSERT INTO `riwayat_transaksi` (`id_transaksi`, `jenis`, `tanggal`, `jumlah`, `keterangan`, `id_user`) VALUES
(1, 'masuk', '1983-09-02', 24595.00, 'Transaksi kas masuk', NULL),
(2, 'keluar', '1971-02-27', 201203.00, 'Transaksi kas keluar', NULL),
(3, 'masuk', '1983-08-18', 185115.00, 'Transaksi kas masuk', NULL),
(4, 'keluar', '2019-03-19', 141769.00, 'Transaksi kas keluar', NULL),
(5, 'masuk', '2009-03-24', 152041.00, 'Transaksi kas masuk', NULL),
(6, 'keluar', '2022-06-26', 74146.00, 'Transaksi kas keluar', NULL),
(7, 'masuk', '2014-12-24', 105593.00, 'Transaksi kas masuk', NULL),
(8, 'keluar', '1991-06-10', 57435.00, 'Transaksi kas keluar', NULL),
(9, 'masuk', '1986-01-31', 76688.00, 'Transaksi kas masuk', NULL),
(10, 'keluar', '1986-01-24', 76174.00, 'Transaksi kas keluar', NULL),
(11, 'masuk', '1997-03-29', 117679.00, 'Transaksi kas masuk', NULL),
(12, 'keluar', '1984-08-11', 139235.00, 'Transaksi kas keluar', NULL),
(13, 'masuk', '2017-07-19', 97798.00, 'Transaksi kas masuk', NULL),
(14, 'keluar', '2006-10-02', 75307.00, 'Transaksi kas keluar', NULL),
(15, 'masuk', '2006-01-26', 125608.00, 'Transaksi kas masuk', NULL),
(16, 'keluar', '2023-01-21', 211972.00, 'Transaksi kas keluar', NULL),
(17, 'masuk', '1992-10-14', 28885.00, 'Transaksi kas masuk', NULL),
(18, 'keluar', '1970-10-23', 180282.00, 'Transaksi kas keluar', NULL),
(19, 'masuk', '2015-04-08', 38184.00, 'Transaksi kas masuk', NULL),
(20, 'keluar', '1972-05-30', 104639.00, 'Transaksi kas keluar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rt_masjid`
--

CREATE TABLE `rt_masjid` (
  `id` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `id_masjid` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sumber_dana`
--

CREATE TABLE `sumber_dana` (
  `id_sumber` int NOT NULL,
  `nama_sumber` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sumber_dana`
--

INSERT INTO `sumber_dana` (`id_sumber`, `nama_sumber`) VALUES
(1, 'Kotak Amal'),
(2, 'Transfer Bank'),
(3, 'Donatur Tetap'),
(4, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int UNSIGNED NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','bendahara','rt') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama`, `role`, `created_at`, `updated_at`) VALUES
(4, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator', 'admin', '2025-06-28 02:06:50', '2025-06-28 02:06:50'),
(5, 'bendahara', 'c9ccd7f3c1145515a9d3f7415d5bcbea', 'Bendahara', 'bendahara', '2025-06-28 02:19:10', '2025-06-28 02:19:10'),
(6, 'rt01', '327f42dc9cc897f17dc63852d31d3a99', 'kevin tak ingin disakiti', 'rt', '2025-06-28 02:34:11', '2025-06-28 02:34:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id_anggaran`),
  ADD KEY `fk_anggaran_masjid` (`id_masjid`);

--
-- Indexes for table `donasi_online`
--
ALTER TABLE `donasi_online`
  ADD PRIMARY KEY (`id_donasi`),
  ADD KEY `fk_donasi_masjid` (`id_masjid`);

--
-- Indexes for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  ADD PRIMARY KEY (`id_kas_keluar`),
  ADD KEY `kas_keluar_id_user_foreign` (`id_user`),
  ADD KEY `fk_kas_keluar_masjid` (`id_masjid`);

--
-- Indexes for table `kas_masuk`
--
ALTER TABLE `kas_masuk`
  ADD PRIMARY KEY (`id_kas_masuk`),
  ADD KEY `kas_masuk_id_user_foreign` (`id_user`),
  ADD KEY `fk_kas_masuk_masjid` (`id_masjid`);

--
-- Indexes for table `kategori_pengeluaran`
--
ALTER TABLE `kategori_pengeluaran`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `fk_laporan_masjid` (`id_masjid`),
  ADD KEY `fk_laporan_user` (`id_user`);

--
-- Indexes for table `masjid`
--
ALTER TABLE `masjid`
  ADD PRIMARY KEY (`id_masjid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `riwayat_transaksi_id_user_foreign` (`id_user`);

--
-- Indexes for table `rt_masjid`
--
ALTER TABLE `rt_masjid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rt_user` (`id_user`),
  ADD KEY `fk_rt_masjid` (`id_masjid`);

--
-- Indexes for table `sumber_dana`
--
ALTER TABLE `sumber_dana`
  ADD PRIMARY KEY (`id_sumber`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id_anggaran` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donasi_online`
--
ALTER TABLE `donasi_online`
  MODIFY `id_donasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  MODIFY `id_kas_keluar` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kas_masuk`
--
ALTER TABLE `kas_masuk`
  MODIFY `id_kas_masuk` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `kategori_pengeluaran`
--
ALTER TABLE `kategori_pengeluaran`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `masjid`
--
ALTER TABLE `masjid`
  MODIFY `id_masjid` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rt_masjid`
--
ALTER TABLE `rt_masjid`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sumber_dana`
--
ALTER TABLE `sumber_dana`
  MODIFY `id_sumber` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD CONSTRAINT `fk_anggaran_masjid` FOREIGN KEY (`id_masjid`) REFERENCES `masjid` (`id_masjid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donasi_online`
--
ALTER TABLE `donasi_online`
  ADD CONSTRAINT `fk_donasi_masjid` FOREIGN KEY (`id_masjid`) REFERENCES `masjid` (`id_masjid`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  ADD CONSTRAINT `fk_kas_keluar_masjid` FOREIGN KEY (`id_masjid`) REFERENCES `masjid` (`id_masjid`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kas_keluar_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kas_masuk`
--
ALTER TABLE `kas_masuk`
  ADD CONSTRAINT `fk_kas_masuk_masjid` FOREIGN KEY (`id_masjid`) REFERENCES `masjid` (`id_masjid`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kas_masuk_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `fk_laporan_masjid` FOREIGN KEY (`id_masjid`) REFERENCES `masjid` (`id_masjid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_laporan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  ADD CONSTRAINT `riwayat_transaksi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rt_masjid`
--
ALTER TABLE `rt_masjid`
  ADD CONSTRAINT `fk_rt_masjid` FOREIGN KEY (`id_masjid`) REFERENCES `masjid` (`id_masjid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rt_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
