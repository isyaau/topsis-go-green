-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 01, 2024 at 07:41 AM
-- Server version: 8.2.0
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `topsis5`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idadmin` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `level` varchar(10) NOT NULL,
  `namalengkap` varchar(30) NOT NULL,
  PRIMARY KEY (`idadmin`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idadmin`, `username`, `password`, `level`, `namalengkap`) VALUES
(1, 'admin', 'ADMIN', 'ADMIN', 'ADMIN'),
(2, 'shifa', 'shifa', 'USER', 'shifa adzkia');

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

DROP TABLE IF EXISTS `alternatif`;
CREATE TABLE IF NOT EXISTS `alternatif` (
  `id_alternatif` int NOT NULL AUTO_INCREMENT,
  `nama_alternatif` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rt_a` varchar(10) NOT NULL,
  `rt_b` varchar(10) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL,
  PRIMARY KEY (`id_alternatif`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_alternatif`, `rt_a`, `rt_b`, `kecamatan`, `kota`) VALUES
(19, 'Nglambangan', '03', '02', 'Pandean', 'Madiun'),
(15, 'Mojoagung', '08', '09', 'Kartoharjo', 'Madiun'),
(16, 'Kejuron', '08', '10', 'Nglames', 'Madiun'),
(17, 'Dungus', '08', '09', 'Nglanduk', 'Madiun'),
(18, 'Kartoharjo', '03', '02', 'Demangan', 'Madiun');

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

DROP TABLE IF EXISTS `auth_activation_attempts`;
CREATE TABLE IF NOT EXISTS `auth_activation_attempts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_activation_attempts`
--

INSERT INTO `auth_activation_attempts` (`id`, `ip_address`, `user_agent`, `token`, `created_at`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 Edg/113.0.1774.42', '9607c433f718589e84099c0388349de7', '2023-05-16 16:26:32'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 Edg/113.0.1774.50', 'c507bc409c18061bb08297ff79c73419', '2023-05-24 02:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

DROP TABLE IF EXISTS `auth_groups`;
CREATE TABLE IF NOT EXISTS `auth_groups` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'administrator', 'Administrator'),
(2, 'user', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

DROP TABLE IF EXISTS `auth_groups_permissions`;
CREATE TABLE IF NOT EXISTS `auth_groups_permissions` (
  `group_id` int UNSIGNED NOT NULL DEFAULT '0',
  `permission_id` int UNSIGNED NOT NULL DEFAULT '0',
  KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  KEY `group_id_permission_id` (`group_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

DROP TABLE IF EXISTS `auth_groups_users`;
CREATE TABLE IF NOT EXISTS `auth_groups_users` (
  `group_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  KEY `auth_groups_users_user_id_foreign` (`user_id`),
  KEY `group_id_user_id` (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 13),
(2, 14),
(2, 15);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

DROP TABLE IF EXISTS `auth_logins`;
CREATE TABLE IF NOT EXISTS `auth_logins` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'isyaau@gmail.com', 1, '2023-05-04 08:27:52', 1),
(2, '::1', 'isyaau@gmail.com', NULL, '2023-05-04 15:01:55', 0),
(3, '::1', 'isyaau@gmail.com', 1, '2023-05-04 15:02:07', 1),
(4, '::1', 'isyaau@gmail.com', 1, '2023-05-05 04:43:08', 1),
(5, '::1', 'isyaau@gmail.com', 1, '2023-05-05 04:47:48', 1),
(6, '::1', 'isyaau@gmail.com', 1, '2023-05-05 04:49:35', 1),
(7, '::1', 'isyaau@gmail.com', 1, '2023-05-05 08:39:04', 1),
(8, '::1', 'isyaau@gmail.com', 1, '2023-05-11 02:39:58', 1),
(9, '::1', 'isyaau@gmail.com', 1, '2023-05-11 14:17:46', 1),
(10, '::1', 'isyaau@gmail.com', 1, '2023-05-11 20:25:24', 1),
(11, '::1', 'isyaau@gmail.com', 1, '2023-05-11 20:41:59', 1),
(12, '::1', 'alfia@gmail.com', 11, '2023-05-11 20:52:17', 1),
(13, '::1', 'isyaau@gmail.com', 1, '2023-05-12 03:56:58', 1),
(14, '::1', 'alfia@gmail.com', 11, '2023-05-12 04:19:09', 1),
(15, '::1', 'isyaau@gmail.com', 1, '2023-05-12 05:03:21', 1),
(16, '::1', 'isyaau@gmail.com', 1, '2023-05-15 07:59:12', 1),
(17, '::1', 'admin@gmail.com', 0, '2023-05-15 08:59:34', 1),
(18, '::1', 'admin@gmail.com', 0, '2023-05-15 08:59:54', 1),
(19, '::1', 'admin@gmail.com', 0, '2023-05-15 09:00:16', 1),
(20, '::1', 'admin@gmail.com', NULL, '2023-05-15 09:01:02', 0),
(21, '::1', 'admin@gmail.com', 0, '2023-05-15 09:01:25', 1),
(22, '::1', 'admin@gmail.com', 0, '2023-05-15 09:03:28', 1),
(23, '::1', 'admin@gmail.com', 0, '2023-05-15 09:03:55', 1),
(24, '::1', 'alfia@gmail.com', 11, '2023-05-15 09:04:27', 1),
(25, '::1', 'admin@gmail.com', NULL, '2023-05-15 09:05:41', 0),
(26, '::1', 'admin@gmail.com', 0, '2023-05-15 09:05:59', 1),
(27, '::1', 'admin@gmail.com', 0, '2023-05-16 06:03:09', 1),
(28, '::1', 'isyaau@gmail.com', 1, '2023-05-16 06:03:19', 1),
(29, '::1', 'admin', NULL, '2023-05-16 06:27:23', 0),
(30, '::1', 'admin@gmail.com', 13, '2023-05-16 06:27:39', 1),
(31, '::1', 'fuadiazhar12@gmail.com', NULL, '2023-05-16 16:27:08', 0),
(32, '::1', 'fuadiazhar12@gmail.com', 14, '2023-05-16 16:27:18', 1),
(33, '::1', 'admin@gmail.com', NULL, '2023-05-16 16:35:41', 0),
(34, '::1', 'admin@gmail.com', 13, '2023-05-16 16:35:50', 1),
(35, '::1', 'fuadiazhar12@gmail.com', NULL, '2023-05-16 16:38:15', 0),
(36, '::1', 'fuadiazhar12@gmail.com', 14, '2023-05-16 16:38:31', 1),
(37, '::1', 'admin@gmail.com', 13, '2023-05-16 16:39:03', 1),
(38, '::1', 'fuadiazhar12@gmail.com', 14, '2023-05-16 16:42:41', 1),
(39, '::1', 'admin@gmail.com', NULL, '2023-05-16 16:45:35', 0),
(40, '::1', 'admin@gmail.com', NULL, '2023-05-16 16:45:44', 0),
(41, '::1', 'admin@gmail.com', 13, '2023-05-16 16:45:52', 1),
(42, '::1', 'fuadiazhar12@gmail.com', 14, '2023-05-16 16:48:26', 1),
(43, '::1', 'isyaau@gmail.com', NULL, '2023-05-17 12:35:16', 0),
(44, '::1', 'isyaau@gmail.com', 1, '2023-05-17 12:35:26', 1),
(45, '::1', 'isyaau#gmail.com', NULL, '2023-05-19 12:39:44', 0),
(46, '::1', 'iyaau@gmail.com', NULL, '2023-05-19 12:40:00', 0),
(47, '::1', 'isyaau@gmail.com', 1, '2023-05-19 12:40:16', 1),
(48, '::1', 'isyaau@gmailcom', NULL, '2023-05-20 19:15:48', 0),
(49, '::1', 'isyaau@gmail.com', 1, '2023-05-20 19:16:02', 1),
(50, '::1', 'isyaau@gmail.com', 1, '2023-05-22 14:22:46', 1),
(51, '::1', 'isyaau@gmail.com', 1, '2023-05-24 01:21:52', 1),
(52, '::1', 'admin@gmail.com', NULL, '2023-05-24 01:32:45', 0),
(53, '::1', 'admin', NULL, '2023-05-24 01:32:58', 0),
(54, '::1', 'isyaau@gmail.com', 1, '2023-05-24 01:33:03', 1),
(55, '::1', 'admin@gmail.com', NULL, '2023-05-24 01:33:42', 0),
(56, '::1', 'admin@gmail.com', NULL, '2023-05-24 01:34:28', 0),
(57, '::1', 'admin@gmail.com', NULL, '2023-05-24 01:34:49', 0),
(58, '::1', 'isyaau@gmail.com', 1, '2023-05-24 01:35:01', 1),
(59, '::1', 'admin@gmail.com', NULL, '2023-05-24 01:36:05', 0),
(60, '::1', 'isyaau@gmail.com', 1, '2023-05-24 01:40:11', 1),
(61, '::1', 'admin@gmail.com', 13, '2023-05-24 01:40:57', 1),
(62, '::1', 'andi00@afpeterg.com', 15, '2023-05-24 02:05:39', 1),
(63, '::1', 'andi00@afpeterg.com', 15, '2023-05-24 02:10:36', 1),
(64, '::1', 'admin@gmail.com', 13, '2023-05-24 02:16:08', 1),
(65, '::1', 'isyaau@gmail.com', 1, '2023-05-24 15:30:04', 1),
(66, '::1', 'isyaau@gmail.com', 1, '2023-06-17 15:55:54', 1),
(67, '::1', 'isyaau@gmail.com', 1, '2023-07-25 07:37:29', 1),
(68, '::1', 'isyaau@gmail.com', 1, '2023-07-26 01:13:42', 1),
(69, '::1', 'isyaau@gmail.com', 1, '2023-07-26 04:16:47', 1),
(70, '::1', 'isyaau@gmail.com', 1, '2023-07-27 16:24:38', 1),
(71, '::1', 'isyaau@gmail.com', 1, '2023-07-28 01:16:49', 1),
(72, '::1', 'isyaau@gmail.com', 1, '2024-01-16 04:23:28', 1),
(73, '::1', 'isyaau@gmail.com', 1, '2024-01-16 04:27:38', 1),
(74, '::1', 'isyaau@gmail.com', 1, '2024-01-18 02:43:29', 1),
(75, '::1', 'isyaau@gmail.com', 1, '2024-01-19 06:10:59', 1),
(76, '::1', 'isyaau@gmail.com', NULL, '2024-01-19 23:45:34', 0),
(77, '::1', 'isyaau@gmail.com', 1, '2024-01-19 23:45:46', 1),
(78, '::1', 'isyaau@gmail.com', 1, '2024-01-20 04:48:08', 1),
(79, '::1', 'isyaau@gmail.com', 1, '2024-01-23 07:57:35', 1),
(80, '::1', 'isyaau@gmail.com', 1, '2024-01-24 05:48:46', 1),
(81, '::1', 'isyaau@gmail.com', 1, '2024-01-25 04:02:19', 1),
(82, '::1', 'isyaau@gmail.com', 1, '2024-01-25 13:31:01', 1),
(83, '::1', 'isyaau@gmail.com', 1, '2024-01-26 03:22:46', 1),
(84, '::1', 'isyaau@gmail.com', 1, '2024-01-26 06:54:57', 1),
(85, '::1', 'isyaau@gmail.com', 1, '2024-01-30 07:58:59', 1),
(86, '::1', 'isyaau@gmail.com', NULL, '2024-01-30 13:33:59', 0),
(87, '::1', 'isyaau@gmail.com', 1, '2024-01-30 13:34:08', 1),
(88, '::1', 'isyaau@gmail.com', 1, '2024-01-31 01:40:05', 1),
(89, '::1', 'isyaau@gmail.com', 1, '2024-01-31 01:43:23', 1),
(90, '::1', 'isyaau@gmail.com', 1, '2024-01-31 01:44:26', 1),
(91, '::1', 'isyaau@gmail.com', 1, '2024-01-31 01:45:43', 1),
(92, '::1', 'isyaau@gmail.com', 1, '2024-01-31 01:47:26', 1),
(93, '::1', 'isyaau@gmail.com', 1, '2024-01-31 01:48:25', 1),
(94, '::1', 'isyaau@gmail.com', 1, '2024-01-31 01:49:31', 1),
(95, '::1', 'isyaau@gmail.com', 1, '2024-02-01 05:42:54', 1),
(96, '::1', 'admin@gmail.com', NULL, '2024-02-01 14:18:38', 0),
(97, '::1', 'admin@gmail.com', NULL, '2024-02-01 14:18:45', 0),
(98, '::1', 'admin@gmail.com', 13, '2024-02-01 14:18:52', 1),
(99, '::1', 'admin@gmail.com', 13, '2024-02-01 14:35:48', 1),
(100, '::1', 'admin@gmail.com', 13, '2024-02-01 14:36:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

DROP TABLE IF EXISTS `auth_permissions`;
CREATE TABLE IF NOT EXISTS `auth_permissions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

DROP TABLE IF EXISTS `auth_reset_attempts`;
CREATE TABLE IF NOT EXISTS `auth_reset_attempts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_reset_attempts`
--

INSERT INTO `auth_reset_attempts` (`id`, `email`, `ip_address`, `user_agent`, `token`, `created_at`) VALUES
(1, 'fuadiazhar12@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 Edg/113.0.1774.42', '546029a3c08ed689fbfb765d11bc0ae4', '2023-05-16 16:38:00'),
(2, 'andi00@afpeterg.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 Edg/113.0.1774.50', '6d30588243b3a4501f63163ae0aa88f0', '2023-05-24 02:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

DROP TABLE IF EXISTS `auth_tokens`;
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_tokens_user_id_foreign` (`user_id`),
  KEY `selector` (`selector`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

DROP TABLE IF EXISTS `auth_users_permissions`;
CREATE TABLE IF NOT EXISTS `auth_users_permissions` (
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `permission_id` int UNSIGNED NOT NULL DEFAULT '0',
  KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  KEY `user_id_permission_id` (`user_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

DROP TABLE IF EXISTS `kriteria`;
CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` int NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `bobot` int NOT NULL,
  `sifat` varchar(20) NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `deskripsi`, `bobot`, `sifat`) VALUES
(11, 'Pengelolaan', 'Upaya pengelolaan lingkungan hidup di Kantor Kelurahan', 5, 'benefit'),
(12, 'Pembinaan', 'Kegiatan pembinaan pengelolaan lingkungan hidup bagi Warga/Kader Lingkungan selama 1 (satu) tahun terakhir ', 5, 'benefit'),
(10, 'Kebijakan', 'Kebijakan dan Peraturan terkait Lingkungan Hidup (SK Bupati/Walikota/Kepala DLH/ Kepala Dinas Terkait/ Kepala Desa/Lurah)', 5, 'benefit'),
(13, 'Organisasi', 'Organisasi Kelembagaan kader lingkungan hidup', 5, 'benefit'),
(14, 'Program', 'Program kelurahan untuk kegiatan Pelestarian Sumberdaya Alam yang melibatkan masyarakat  ', 5, 'benefit'),
(15, 'Tempat Sampah', 'Tersedia tempat sampah terpilah di setiap rumah', 5, 'benefit'),
(16, 'Komposter', 'Jumlah komposter yang berfungsi dengan baik dan ada bukti hasil pengomposan', 5, 'benefit'),
(17, 'Biopori', 'Jumlah lubang resapan biopori yang berfungsi untuk pengomposan', 5, 'benefit'),
(18, 'Bank Sampah', 'Bank Sampah sebagai upaya pengelolaan sampah kering/anorganik', 5, 'benefit'),
(19, 'Kreatifitas', 'Mempunyai inovasi/kreatifitas yang memanfaatkan Sumber Daya Alam Setempat', 5, 'benefit'),
(20, 'Kebersihan', 'Kondisi kebersihan drainase/sungai/got/saluran air', 5, 'benefit'),
(21, 'Penataan dan Penghujauan', 'Kondisi penataan dan penghijauan di sepanjang jalan/gang, taman, dan fasilitas umum', 5, 'benefit'),
(22, 'Lahan', 'Mempunyai lahan percontohan untuk Urban Farming melalui budidaya tanaman/ peternakan/perikanan dalam rangka peningkatkan ketersediaan pangan di lahan fasilitas umum milik RT/RW/Desa/Kelurahan', 5, 'benefit'),
(23, 'Slogan', 'Adanya pemasangan slogan - slogan tentang lingkungan hidup yang memotivasi pengelolaan lingkungan', 5, 'benefit'),
(24, 'Lahan Toga', 'Mempunyai lahan percontohan untuk Urban Farming melalui budidaya tanaman Toga \r\n(minimal 3 jenis)', 5, 'benefit');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(6, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1683085034, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_matrix`
--

DROP TABLE IF EXISTS `nilai_matrix`;
CREATE TABLE IF NOT EXISTS `nilai_matrix` (
  `id_matrix` int NOT NULL AUTO_INCREMENT,
  `id_alternatif` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `nilai` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_matrix`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nilai_matrix`
--

INSERT INTO `nilai_matrix` (`id_matrix`, `id_alternatif`, `id_kriteria`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 19, 10, 1, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(2, 19, 11, 2, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(3, 19, 12, 2, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(4, 19, 13, 3, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(5, 19, 14, 2, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(6, 19, 15, 2, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(7, 19, 16, 2, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(8, 19, 17, 2, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(9, 19, 18, 2, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(10, 19, 19, 2, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(11, 19, 20, 3, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(12, 19, 21, 3, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(13, 19, 22, 3, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(14, 19, 23, 4, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(15, 19, 24, 2, '2024-01-30 22:35:27', '2024-01-30 22:35:27'),
(16, 15, 10, 2, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(17, 15, 11, 3, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(18, 15, 12, 3, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(19, 15, 13, 4, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(20, 15, 14, 3, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(21, 15, 15, 4, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(22, 15, 16, 3, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(23, 15, 17, 4, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(24, 15, 18, 3, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(25, 15, 19, 5, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(26, 15, 20, 3, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(27, 15, 21, 5, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(28, 15, 22, 3, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(29, 15, 23, 5, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(30, 15, 24, 2, '2024-01-30 22:37:41', '2024-01-30 22:37:41'),
(31, 16, 10, 2, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(32, 16, 11, 4, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(33, 16, 12, 3, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(34, 16, 13, 4, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(35, 16, 14, 2, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(36, 16, 15, 5, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(37, 16, 16, 4, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(38, 16, 17, 3, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(39, 16, 18, 4, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(40, 16, 19, 2, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(41, 16, 20, 5, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(42, 16, 21, 3, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(43, 16, 22, 5, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(44, 16, 23, 2, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(45, 16, 24, 3, '2024-01-30 22:38:16', '2024-01-30 22:38:16'),
(46, 17, 10, 2, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(47, 17, 11, 4, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(48, 17, 12, 4, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(49, 17, 13, 4, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(50, 17, 14, 4, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(51, 17, 15, 3, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(52, 17, 16, 5, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(53, 17, 17, 2, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(54, 17, 18, 5, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(55, 17, 19, 2, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(56, 17, 20, 3, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(57, 17, 21, 2, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(58, 17, 22, 4, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(59, 17, 23, 2, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(60, 17, 24, 2, '2024-01-30 22:38:50', '2024-01-30 22:38:50'),
(61, 18, 10, 2, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(62, 18, 11, 4, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(63, 18, 12, 2, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(64, 18, 13, 4, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(65, 18, 14, 3, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(66, 18, 15, 4, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(67, 18, 16, 2, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(68, 18, 17, 5, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(69, 18, 18, 4, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(70, 18, 19, 3, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(71, 18, 20, 5, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(72, 18, 21, 3, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(73, 18, 22, 4, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(74, 18, 23, 3, '2024-01-30 22:39:24', '2024-01-30 22:39:24'),
(75, 18, 24, 3, '2024-01-30 22:39:24', '2024-01-30 22:39:24');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_preferensi`
--

DROP TABLE IF EXISTS `nilai_preferensi`;
CREATE TABLE IF NOT EXISTS `nilai_preferensi` (
  `nama_alternatif` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nilai` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nilai_preferensi`
--

INSERT INTO `nilai_preferensi` (`nama_alternatif`, `nilai`) VALUES
('Mojoagung', 0.5993),
('Kejuron', 0.4896),
('Dungus', 0.4687),
('Kartoharjo', 0.5096),
('Nglambangan', 0.2042);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fullname` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `jenis_kelamin` int DEFAULT NULL,
  `alamat` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `foto` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'default-avatar.jpg',
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `reset_hash` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status_message` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `fullname`, `jenis_kelamin`, `alamat`, `foto`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'isyaau@gmail.com', 'Admin Super', 2, 'Jalan Nongo Karangjati Ngawi', '1683091202_3253c312f0d5aabdb6a2.jpg', 'isyaau', '$2y$10$aNuFBFe/qEbds36lgWtsFOTSwoj3IkTr6WujcDLcnF78mlfDVVOBy', NULL, NULL, NULL, NULL, '1', NULL, 1, 0, '2023-05-03 03:40:35', '2023-05-11 06:57:44', NULL),
(13, 'admin@gmail.com', 'Administrator', 1, 'Madiun', 'default-avatar.jpg', 'admin', '$2y$10$jxkfS08KzZ.cq9Oxaf00X.lc.cVHb5MTttGJUitXkgtcvcluriBO2', NULL, NULL, NULL, NULL, '1', NULL, 1, 0, '2023-05-16 06:25:49', '2023-05-24 01:35:15', NULL),
(15, 'andi00@afpeterg.com', 'Andi', NULL, NULL, 'default-avatar.jpg', 'andi', '$2y$10$mBZ4WsJTspBFmYBkKTXGieaL/gIF7XQF7Vk8QZruWW7gp23lez/Wi', NULL, '2023-05-24 02:13:07', NULL, NULL, '2', NULL, 1, 0, '2023-05-24 02:00:41', '2023-05-24 02:13:07', NULL),
(14, 'fuadiazhar12@gmail.com', 'Azhar', NULL, NULL, 'default-avatar.jpg', 'azrhar', '$2y$10$BpoI5ga48TgK6SZQVZAUouugGeZoLU8j6lPtgR8sjb8fAXUNHlA.e', NULL, '2023-05-16 16:38:02', NULL, NULL, '2', NULL, 1, 0, '2023-05-16 16:24:01', '2023-05-16 16:40:48', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
