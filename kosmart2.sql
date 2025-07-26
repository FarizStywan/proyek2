-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2025 at 10:58 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kosmart2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin4@example.com', '$2y$12$M.gBk8znF3AIF0sEBm6h9.4RWoF8q1rQugBZrCWKAJDCKqtQD8a62', '2025-04-24 06:53:51', '2025-04-24 06:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_kamar` varchar(10) NOT NULL,
  `fasilitas` enum('AC','Non-AC') NOT NULL DEFAULT 'Non-AC',
  `harga` decimal(10,2) NOT NULL,
  `status` enum('Kosong','Terisi') NOT NULL DEFAULT 'Kosong',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id`, `nomor_kamar`, `fasilitas`, `harga`, `status`, `created_at`, `updated_at`) VALUES
(1, '01', 'AC', 700000.00, 'Terisi', '2025-04-24 06:56:47', '2025-04-27 21:52:52'),
(2, '02', 'Non-AC', 500000.00, 'Terisi', '2025-04-27 21:52:43', '2025-06-02 19:07:39'),
(4, '03', 'AC', 700000.00, 'Terisi', '2025-06-02 19:48:54', '2025-06-03 23:02:28'),
(6, '04', 'AC', 500000.00, 'Terisi', '2025-06-03 23:02:53', '2025-06-04 23:32:24'),
(7, '05', 'AC', 700000.00, 'Terisi', '2025-06-04 23:32:14', '2025-06-05 00:02:53'),
(8, '06', 'Non-AC', 500000.00, 'Kosong', '2025-06-05 00:03:09', '2025-06-05 00:03:09'),
(9, '10', 'AC', 700000.00, 'Kosong', '2025-07-19 01:26:30', '2025-07-19 01:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
-- Error reading structure for table kosmart2.migrations: #1932 - Table &#039;kosmart2.migrations&#039; doesn&#039;t exist in engine
-- Error reading data for table kosmart2.migrations: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `kosmart2`.`migrations`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan_pengeluaran`
--

CREATE TABLE `pemasukan_pengeluaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('Pemasukan','Pengeluaran') NOT NULL,
  `deskripsi` text NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemasukan_pengeluaran`
--

INSERT INTO `pemasukan_pengeluaran` (`id`, `jenis`, `deskripsi`, `jumlah`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 'Pengeluaran', 'bayar listrik', 200000.00, '2025-06-03', '2025-06-02 20:08:01', '2025-06-02 20:08:01'),
(2, 'Pengeluaran', 'beli tempat sampah', 200000.00, '2025-06-02', '2025-06-02 20:08:33', '2025-06-02 20:08:33'),
(3, 'Pengeluaran', 'pengeluaran beli sapu', 200000.00, '2025-05-10', '2025-06-02 20:15:46', '2025-06-02 20:15:46'),
(4, 'Pengeluaran', 'bayar OB', 100000.00, '2025-04-17', '2025-06-02 20:18:10', '2025-06-02 20:18:10'),
(5, 'Pengeluaran', 'bayar wifi', 800000.00, '2025-06-12', '2025-06-02 20:18:38', '2025-06-02 20:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tagihan_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `status` enum('pending','dibayar','capture','settlement','deny','cancel','expire') DEFAULT 'pending',
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `tagihan_id`, `order_id`, `transaction_id`, `payment_type`, `status`, `jumlah`, `created_at`, `updated_at`) VALUES
(72, 4, 'ORDER-20250603065809-QqlK3', NULL, NULL, 'pending', 700000, '2025-06-02 23:58:09', '2025-06-02 23:58:09'),
(73, 4, 'ORDER-20250603070042-Spf8z', NULL, NULL, 'pending', 700000, '2025-06-03 00:00:42', '2025-06-03 00:00:42'),
(95, 6, 'ORDER-20250603142810-Qrt4w', NULL, NULL, 'pending', 1000000, '2025-06-03 07:28:10', '2025-06-03 07:28:10'),
(97, 10, 'ORDER-20250605063738-U6aJz', NULL, NULL, 'pending', 700000, '2025-06-04 23:37:38', '2025-06-04 23:37:38'),
(98, 10, 'ORDER-20250605063835-Ee6PQ', NULL, NULL, 'pending', 700000, '2025-06-04 23:38:35', '2025-06-04 23:38:35'),
(99, 11, 'ORDER-20250605070420-Y5jYt', NULL, NULL, 'pending', 500000, '2025-06-05 00:04:20', '2025-06-05 00:04:20'),
(100, 11, 'ORDER-20250605072622-RKfjp', NULL, NULL, 'pending', 500000, '2025-06-05 00:26:22', '2025-06-05 00:26:22'),
(101, 4, 'ORDER-20250719082138-5vV7D', NULL, NULL, 'pending', 700000, '2025-07-19 01:21:38', '2025-07-19 01:21:38');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penyewa_id` bigint(20) UNSIGNED NOT NULL,
  `kategori` enum('Kebersihan','Keamanan','Kerusakan') DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Diproses','Selesai') NOT NULL DEFAULT 'Pending',
  `tanggapan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id`, `penyewa_id`, `kategori`, `deskripsi`, `foto`, `status`, `tanggapan`, `created_at`, `updated_at`) VALUES
(4, 7, 'Kerusakan', 'kipas rusak', 'pengaduan/89suutf86Qy1FWspt124Ys4xCeSxYQpgMLtVJy8H.png', 'Diproses', 'oke saya kesna', '2025-06-02 19:44:34', '2025-06-02 19:44:56'),
(5, 6, 'Kebersihan', 'punten pak kok seminggu ini halaman kos kotor yah', 'pengaduan/ucfQ1kKtwzUsNyL0ZEITSNm6AAZmUxMWOQF0HgqM.jpg', 'Pending', NULL, '2025-06-03 23:35:59', '2025-06-03 23:35:59'),
(6, 12, 'Kebersihan', 'kotor kosnya goblok', 'pengaduan/tdcxDKwaoD7kokGeqOWgYMlxJkG9ODw8CAFRtFoE.jpg', 'Diproses', 'oke goblok saya kesan', '2025-06-04 22:59:56', '2025-06-04 23:00:33'),
(7, 13, 'Kerusakan', 'kipas angin macet, ada suaran tititititi', 'pengaduan/Ue6gquZW3UWqh1x6BjWWinn8gWaVXoo8V6j2c23S.jpg', 'Diproses', 'oke segera saya perbaiki', '2025-06-04 23:34:33', '2025-06-04 23:35:47'),
(8, 15, 'Kerusakan', 'kipasnya rusak', 'pengaduan/I9gMBMA6ZgPw4pOtaEPEbOX0zP15MCNAZ7mz2gf4.jpg', 'Diproses', 'oke nanti saya kesana', '2025-06-05 00:06:25', '2025-06-05 00:06:49'),
(9, 15, 'Keamanan', 'bu kemaren ada yg intip saya', 'pengaduan/UKms2wEEFza25Bg9fsFwL9SDM3JduCGIRivc0emc.jpg', 'Diproses', 'oke saya tindak lanjuti besok', '2025-06-05 00:25:25', '2025-06-05 00:26:01'),
(10, 4, 'Kebersihan', 'kotor banget bu', 'pengaduan/JCgONJ1PBQKpiuNAa7xmnknnSNN9AaH1t8u2wQHd.jpg', 'Selesai', 'oke nnti saya bersihkan', '2025-07-19 01:23:45', '2025-07-19 01:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `penghasilan_bulanan`
--

CREATE TABLE `penghasilan_bulanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bulan` varchar(10) NOT NULL,
  `tahun` int(11) NOT NULL,
  `total_pemasukan` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_pengeluaran` decimal(10,2) NOT NULL DEFAULT 0.00,
  `keuntungan_bersih` decimal(10,2) GENERATED ALWAYS AS (`total_pemasukan` - `total_pengeluaran`) STORED,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penyewa`
--

CREATE TABLE `penyewa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_kamar` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penyewa`
--

INSERT INTO `penyewa` (`id`, `nama`, `email`, `no_hp`, `password`, `nomor_kamar`, `tanggal_mulai`, `foto_profil`, `status`, `created_at`, `updated_at`) VALUES
(4, 'frz', 'frzzz@example.com', '0895363121559', '$2y$12$knmwjwrs9UbysOizOyCdVOaMuGPAyehSdc5J.y3aUeTcWhNKftT66', '01', '2025-05-22', NULL, 'Aktif', '2025-05-21 11:02:14', '2025-05-21 11:02:14'),
(6, 'mukti', 'mukti@example.com', '089562371526', '$2y$12$mEIXmeHpHn7jhmij5xBGK.krlWl7a9mG/Cq/GAz.6Tg6hXDyrhvTC', '03', '2025-06-03', NULL, 'Aktif', '2025-06-02 19:14:52', '2025-06-02 19:40:58'),
(7, 'ningsih', 'ningsih@example.com', '0889967453', '$2y$12$7nAPwG93kA9vJRzhyKjD5.fWELJ8e7Epqi3ouf07EYbXJqj1WIJ02', '02', '2025-06-27', NULL, 'Aktif', '2025-06-02 19:30:17', '2025-06-02 19:41:20'),
(12, 'Salma Rusyda Shofalia', 'salmarusyda13@gmail.com', '08988901966', '$2y$12$jw1BFCgT3n2nQxmVwtj26OYcJgnUiDRtgLshSZXjXT49kLadC1sQy', '04', '2025-06-13', NULL, 'Aktif', '2025-06-04 22:59:17', '2025-06-04 22:59:17'),
(13, 'likz', 'likz@example.com', '08957466834334', '$2y$12$lnl70VH3OpefAUD2mwra6.SekXS4rVtQMY6FAcvAvBRkoOWy.HpqC', '05', '2025-06-05', NULL, 'Aktif', '2025-06-04 23:33:28', '2025-06-04 23:33:28'),
(15, 'mukti rahayu', 'rahayu@example.com', '08954673843', '$2y$12$cV2QBchnIk3MrsyMc520y.w4Zw7nfedyp3jrowdEilW5e3m4RrmcO', '06', '2025-06-05', NULL, 'Aktif', '2025-06-05 00:04:05', '2025-06-05 00:04:05');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7mrnKsvIGg9iROHwvzrDETKWNRic494YKExmwwkp', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYk5YQlBXMzJ3dU9tV3M4ampKM1E1bGtTajNENjUyMGU4QzVNbUJuYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE1O3M6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1749111232),
('IHjL8gD1obzgcQZZcIv2PMnpGOVc5Qxwq9EHQ5jl', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMjgzNzR2Z3Z0MTNWdWR5bnc4cmpIc1BHZE9WTjNRcXRvS0Z6NFdQcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZW55ZXdhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1752913815),
('UIeeRLrtLgBdqDMUe1bsEO0vkuvuo4a6EjnAXlRl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0FPOGV2UjMwdEh4VzRxRjRoenVFenRLNkpPTk1SYjc4Zk5QQXNMQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW55ZXdhL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752923644),
('V7LfOlOXJlTlrwZNaKIyjKvWAmyFCGurGfFomufL', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid0NYeVVoOXdTc1Rva3Y1NzhMcFlSZFlyUFhST29kamRDanY0RmI4UiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW55ZXdhL3N0YXR1cy1wZW1iYXlhcmFuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Njt9', 1752924050);

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penyewa_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `sisa_tagihan` decimal(10,2) DEFAULT NULL,
  `status` enum('Menunggu Verifikasi','Lunas','Belum Lunas') NOT NULL DEFAULT 'Belum Lunas',
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `midtrans_order_id` varchar(255) DEFAULT NULL,
  `jatuh_tempo` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id`, `penyewa_id`, `jumlah`, `sisa_tagihan`, `status`, `metode_pembayaran`, `midtrans_order_id`, `jatuh_tempo`, `created_at`, `updated_at`) VALUES
(4, 4, 700000.00, 700000.00, 'Belum Lunas', NULL, NULL, '2025-06-20', '2025-05-21 11:02:14', '2025-05-21 11:02:14'),
(6, 6, 1000000.00, 1000000.00, 'Belum Lunas', NULL, NULL, '2025-07-03', '2025-06-02 19:14:53', '2025-06-02 19:14:53'),
(7, 7, 500000.00, 500000.00, 'Belum Lunas', NULL, NULL, '2025-07-03', '2025-06-02 19:30:17', '2025-06-02 19:30:17'),
(9, 12, 500000.00, 500000.00, 'Belum Lunas', NULL, NULL, '2025-07-05', '2025-06-04 22:59:17', '2025-06-04 22:59:17'),
(10, 13, 700000.00, 700000.00, 'Belum Lunas', NULL, NULL, '2025-07-05', '2025-06-04 23:33:28', '2025-06-04 23:33:28'),
(11, 15, 500000.00, 500000.00, 'Belum Lunas', NULL, NULL, '2025-07-05', '2025-06-05 00:04:05', '2025-06-05 00:04:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-04-24 06:52:38', '$2y$12$dh9Q2ir.Z8RcIW.Z1g92CeVLLUoyKICmEqHNV7672eC63gu14ShE6', 'rqMOtFVPlA', '2025-04-24 06:52:38', '2025-04-24 06:52:38');

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi_pembayaran`
--

CREATE TABLE `verifikasi_pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tagihan_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Terverifikasi','Ditolak','Menunggu Verifikasi') NOT NULL DEFAULT 'Menunggu Verifikasi',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kamar_nomor_kamar_unique` (`nomor_kamar`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pemasukan_pengeluaran`
--
ALTER TABLE `pemasukan_pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembayaran_order_id_unique` (`order_id`),
  ADD KEY `pembayaran_tagihan_id_foreign` (`tagihan_id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_penyewa_id_foreign` (`penyewa_id`);

--
-- Indexes for table `penghasilan_bulanan`
--
ALTER TABLE `penghasilan_bulanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penyewa`
--
ALTER TABLE `penyewa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penyewa_email_unique` (`email`),
  ADD UNIQUE KEY `penyewa_nomor_kamar_unique` (`nomor_kamar`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagihan_penyewa_id_foreign` (`penyewa_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `verifikasi_pembayaran`
--
ALTER TABLE `verifikasi_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verifikasi_pembayaran_tagihan_id_foreign` (`tagihan_id`),
  ADD KEY `verifikasi_pembayaran_admin_id_foreign` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pemasukan_pengeluaran`
--
ALTER TABLE `pemasukan_pengeluaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `penghasilan_bulanan`
--
ALTER TABLE `penghasilan_bulanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penyewa`
--
ALTER TABLE `penyewa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `verifikasi_pembayaran`
--
ALTER TABLE `verifikasi_pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_penyewa_id_foreign` FOREIGN KEY (`penyewa_id`) REFERENCES `penyewa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_penyewa_id_foreign` FOREIGN KEY (`penyewa_id`) REFERENCES `penyewa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verifikasi_pembayaran`
--
ALTER TABLE `verifikasi_pembayaran`
  ADD CONSTRAINT `verifikasi_pembayaran_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `verifikasi_pembayaran_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
