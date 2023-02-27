-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.22 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for ujian_online
DROP DATABASE IF EXISTS `ujian_online`;
CREATE DATABASE IF NOT EXISTS `ujian_online` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ujian_online`;

-- Dumping structure for table ujian_online.jawaban
DROP TABLE IF EXISTS `jawaban`;
CREATE TABLE IF NOT EXISTS `jawaban` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `peserta_id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `jawaban` text COLLATE utf8mb4_unicode_ci,
  `nilai` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.jawaban: ~9 rows (approximately)
/*!40000 ALTER TABLE `jawaban` DISABLE KEYS */;
INSERT INTO `jawaban` (`id`, `peserta_id`, `soal_id`, `jawaban`, `nilai`, `created_at`, `updated_at`) VALUES
	(1, 5, 128, 'b', NULL, NULL, NULL),
	(2, 5, 129, 'c', NULL, NULL, NULL),
	(3, 5, 130, 'a', NULL, NULL, NULL),
	(4, 5, 131, 'kui jaran', 60, NULL, NULL),
	(5, 6, 131, 'kuda', 100, NULL, NULL),
	(6, 6, 129, 'a', NULL, NULL, NULL),
	(7, 6, 130, 'a', NULL, NULL, NULL),
	(8, 6, 128, 'c', NULL, NULL, NULL),
	(9, 6, 132, 'c', NULL, NULL, NULL),
	(10, 6, 133, 'd', NULL, NULL, NULL),
	(11, 6, 136, 'c', NULL, NULL, NULL),
	(12, 6, 135, 'd', NULL, NULL, NULL),
	(13, 6, 134, 'e', NULL, NULL, NULL),
	(14, 6, 137, 'sak pinter pintere bajing loncat, mesti tau kejlungup', 80, NULL, NULL),
	(15, 5, 133, 'd', NULL, NULL, NULL),
	(16, 5, 132, 'c', NULL, NULL, NULL),
	(17, 5, 135, 'd', NULL, NULL, NULL),
	(18, 5, 136, 'c', NULL, NULL, NULL),
	(19, 5, 134, 'e', NULL, NULL, NULL),
	(20, 5, 137, 'pintere seee wwuuuu', NULL, NULL, NULL);
/*!40000 ALTER TABLE `jawaban` ENABLE KEYS */;

-- Dumping structure for table ujian_online.migrations
DROP TABLE IF EXISTS `migrations`;
	CREATE TABLE IF NOT EXISTS `migrations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	`batch` int(11) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.migrations: ~10 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2018_06_30_061746_create_jawaban_table', 1),
	(4, '2018_06_30_061746_create_peserta_table', 1),
	(5, '2018_06_30_061746_create_pilihan_table', 1),
	(6, '2018_06_30_061746_create_soal_table', 1),
	(7, '2018_06_30_061746_create_ujian_peserta_table', 1),
	(8, '2018_06_30_061746_create_ujian_table', 1),
	(9, '2019_07_16_222846_create_table_ruang', 2),
	(10, '2019_07_24_203851_alter_table_ujian_perserta', 2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table ujian_online.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('dannyfachrulh@gmail.com', '$2y$10$rXE2djptdxNTqOtf/LR7uucZ6qIm94AgCEQT61HdOTtaeY4a.aOJC', '2019-04-22 11:00:21');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table ujian_online.peserta
DROP TABLE IF EXISTS `peserta`;
CREATE TABLE IF NOT EXISTS `peserta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_induk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `peserta_email_unique` (`email`),
  UNIQUE KEY `peserta_no_induk_unique` (`no_induk`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.peserta: ~7 rows (approximately)
/*!40000 ALTER TABLE `peserta` DISABLE KEYS */;
INSERT INTO `peserta` (`id`, `nama`, `email`, `password`, `phone`, `no_induk`, `remember_token`, `created_at`, `updated_at`, `api_token`) VALUES
	(3, 'Budi', 'budi@gmail.com', '$2y$10$w6QfEUenGOoQgfylAVGsIuXSUdz4uje7Q1TEhexWmN7RKR91LhDY6', '082345173524', '1323133', NULL, '2018-07-19 16:10:24', '2019-07-29 20:44:15', NULL),
	(4, 'Deni', 'deni@gmail.com', '$2y$10$vsgEJPKnD7isvjva265JWOZQu2g3ADsuKTNeZZzbg8nALssYoV1pK', '085234517876', '1452324', NULL, '2018-07-21 01:10:47', '2018-07-21 01:10:47', NULL),
	(5, 'Naruto Uzumaki', 'naruto@uzumaki.com', '$2y$10$z7ykOMYdUWn8F.2vlMI0xejjY5uKTj0WWjcqzz5v3M.JwYOPOxH2G', '0352771', '1234567', NULL, '2018-12-31 17:19:23', '2019-06-23 21:46:42', 'LMOiW2RIPxieKqVMtyW564k7jYQLeIcIUZkCD5dfANINbIs1ue'),
	(6, '12345', '12345@gmail.com', '$2y$10$LXHYJset3AzSbS389f0lDu2uyWwx86FVVAmXHFZSXp2N6E3f4PwvK', '0352771', '12345', NULL, '2019-04-17 18:32:04', '2019-06-23 21:39:28', 'Xa1lrAsucPBi2nrpMUgYSpgGhv7XJduPkkhurvJISegXan9uFU'),
	(7, '54321', '54321', '$2y$10$Nk29WVeUsErdk04tJUwm/e5R/oK3JAvFqRs21Rnd5/kQM30YPYBfG', '21312', '54321', NULL, '2019-04-17 19:50:55', '2019-04-17 19:51:22', 'V1DZWb0OKhvyysMqphmzZUCXB0wmeWAHW8eRRx4p3l83d7NlHS'),
	(8, 'Sasuke Uchiha', 'sasuke@uchiha.com', '$2y$10$zosDN.BQz24YsyHHWwEpx.k52.befgUDzASmtQRfxjj7pmZYMrchi', '30307878', '654321', NULL, '2019-06-23 22:02:35', '2019-06-23 22:02:35', NULL),
	(9, 'sss', 'sss@gmail.com', '$2y$10$jfLojHy9yMzBafGTB9mLVuCtITRmTpbMVpbTy59OOKxTbhkFYjBuS', 'sss', 'sss', NULL, '2019-08-13 18:07:15', '2019-08-13 18:07:15', NULL);
/*!40000 ALTER TABLE `peserta` ENABLE KEYS */;

-- Dumping structure for table ujian_online.pilihan
DROP TABLE IF EXISTS `pilihan`;
CREATE TABLE IF NOT EXISTS `pilihan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `benar` tinyint(4) NOT NULL DEFAULT '0',
  `soal_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.pilihan: ~20 rows (approximately)
/*!40000 ALTER TABLE `pilihan` DISABLE KEYS */;
INSERT INTO `pilihan` (`id`, `isi`, `benar`, `soal_id`, `created_at`, `updated_at`) VALUES
	(16, '123213', 0, 9, '2018-07-03 01:58:25', '2018-07-03 01:58:25'),
	(17, '123123', 0, 9, '2018-07-03 01:58:25', '2018-07-03 01:58:25'),
	(18, '123123', 0, 9, '2018-07-03 01:58:25', '2018-07-03 01:58:25'),
	(19, '123112', 0, 9, '2018-07-03 01:58:25', '2018-07-03 01:58:25'),
	(20, '1231', 0, 9, '2018-07-03 01:58:25', '2018-07-03 01:58:25'),
	(21, '', 0, 10, '2018-07-03 02:25:30', '2018-07-03 02:25:30'),
	(22, '', 0, 10, '2018-07-03 02:25:30', '2018-07-03 02:25:30'),
	(23, '', 0, 10, '2018-07-03 02:25:30', '2018-07-03 02:25:30'),
	(24, '', 0, 10, '2018-07-03 02:25:30', '2018-07-03 02:25:30'),
	(25, '', 0, 10, '2018-07-03 02:25:30', '2018-07-03 02:25:30'),
	(26, 'xvgfxfg', 0, 11, '2018-07-03 23:40:46', '2018-07-03 23:40:46'),
	(27, 'cvcv', 0, 11, '2018-07-03 23:40:46', '2018-07-03 23:40:46'),
	(28, 'cbc', 0, 11, '2018-07-03 23:40:46', '2018-07-03 23:40:46'),
	(29, 'dfdf', 0, 11, '2018-07-03 23:40:46', '2018-07-03 23:40:46'),
	(30, 'dfd', 0, 11, '2018-07-03 23:40:46', '2018-07-03 23:40:46'),
	(31, 'df', 0, 12, '2018-07-03 23:40:46', '2018-07-03 23:40:46'),
	(32, 'gfhg', 0, 12, '2018-07-03 23:40:46', '2018-07-03 23:40:46'),
	(33, 'hggh', 0, 12, '2018-07-03 23:40:46', '2018-07-03 23:40:46'),
	(34, 'dfd', 0, 12, '2018-07-03 23:40:46', '2018-07-03 23:40:46'),
	(35, 'dfdf', 0, 12, '2018-07-03 23:40:46', '2018-07-03 23:40:46');
/*!40000 ALTER TABLE `pilihan` ENABLE KEYS */;

-- Dumping structure for table ujian_online.ruang
DROP TABLE IF EXISTS `ruang`;
CREATE TABLE IF NOT EXISTS `ruang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.ruang: ~0 rows (approximately)
/*!40000 ALTER TABLE `ruang` DISABLE KEYS */;
INSERT INTO `ruang` (`id`, `nama`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, '213', NULL, '2019-08-13 18:06:48', '2019-08-13 18:06:48');
/*!40000 ALTER TABLE `ruang` ENABLE KEYS */;

-- Dumping structure for table ujian_online.soal
DROP TABLE IF EXISTS `soal`;
CREATE TABLE IF NOT EXISTS `soal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `a` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `e` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `benar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.soal: ~26 rows (approximately)
/*!40000 ALTER TABLE `soal` DISABLE KEYS */;
INSERT INTO `soal` (`id`, `pertanyaan`, `type`, `ujian_id`, `a`, `b`, `c`, `d`, `e`, `benar`, `created_at`, `updated_at`) VALUES
	(117, '<p>Apakah lalala?</p>', 'pilihan', 7, '1', '2', '3', '4', '5', 'b', '2018-07-14 09:33:13', '2018-07-14 09:33:13'),
	(118, '2', 'pilihan', 7, '3', '4', '5', '7', '8', 'a', '2018-07-14 09:33:13', '2018-07-14 09:33:13'),
	(119, '3', 'pilihan', 7, '4', '5', '6', '7', '8', 'e', '2018-07-14 09:33:13', '2018-07-14 09:33:13'),
	(120, '<p>&nbsp;</p>', 'pilihan', 7, '', '', '', '', '', 'a', '2018-07-14 09:33:13', '2018-07-14 09:33:13'),
	(121, '<p>scadadq22eefcsa</p>', 'esay', 7, '', '', '', '', '', '0', '2018-07-14 09:33:13', '2018-07-14 09:33:13'),
	(122, '<p>12123t4fdsdnhfda</p>', 'esay', 7, '', '', '', '', '', '0', '2018-07-14 09:33:13', '2018-07-14 09:33:13'),
	(123, '<p>asdw2qassv6884</p>', 'esay', 7, '', '', '', '', '', '0', '2018-07-14 09:33:13', '2018-07-14 09:33:13'),
	(124, '<p>soal esay tak ada gunanya</p>', 'esay', 7, '', '', '', '', '', '0', '2018-07-14 09:33:13', '2018-07-14 09:33:13'),
	(125, 'hjlaoala', 'pilihan', 6, '123', '345', '567', '897', '456', 'e', '2018-07-21 01:01:12', '2018-07-21 01:01:12'),
	(126, '123113', 'pilihan', 1, 'xvgfxfg', 'cvcv', 'cbc', 'dfdf', 'dfd', 'c', '2018-07-21 01:01:27', '2018-07-21 01:01:27'),
	(127, 'dfdf dfdf', 'pilihan', 1, 'df', 'gfhg', 'hggh', 'dfd', 'dfdf', 'd', '2018-07-21 01:01:27', '2018-07-21 01:01:27'),
	(128, '<p>apa warna mu?</p>', 'pilihan', 11, 'hitam', 'coklat kehitaman', 'mbuh', 'aku ', 'koe', 'b', '2018-12-31 12:57:48', '2018-12-31 12:57:48'),
	(129, '<p>fuad itu siapa?</p>', 'pilihan', 11, 'masmu', 'sada', 'asdasd', 'asda', 'asdad', 'a', '2018-12-31 12:57:48', '2018-12-31 12:57:48'),
	(130, '<p>iman itu siapa?</p>', 'pilihan', 11, 'bakul jamu', 'bakul finto', 'bakul cola cola', 'mbuh', 'asdsadas', 'a', '2018-12-31 12:57:48', '2018-12-31 12:57:48'),
	(131, '<p><img src="https://i.ytimg.com/vi/ZlqyWX0f2ZM/hqdefault.jpg" alt="" /></p>\n<p>halo aku apa ya?</p>', 'esay', 11, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-31 12:57:48', '2018-12-31 12:57:48'),
	(132, '<p>jika perut anda mengeluarkan bunyi-bunyian berarti anda sedang....</p>', 'pilihan', 12, 'menabuh perut anda sendiri', 'menelan radio gema surya', 'Kelaparan (ini yang betul)', 'mules gak karuan', 'kebingungan krna tidak tahu', 'c', '2019-06-23 09:03:22', '2019-06-23 09:03:22'),
	(133, '<p>sepiring makanan ada di depan anda, apa yang akan anda lakukan?&nbsp;</p>', 'pilihan', 12, 'diam tak bergeming', 'ngupil dulu', 'menatap tajam makanan', 'Segera makan (ini yang betul)', 'kebingungan krna tidak tahu', 'd', '2019-06-23 09:03:22', '2019-06-23 09:03:22'),
	(134, '<p>banyu, banyu opo sing ambune enak?</p>', 'pilihan', 12, 'banyu langit (didi kempot)', 'banyu mas ninggal janji (tanjung lek)', 'banyu kalen', 'banyu skak', 'banyuwangi (iki sing betul)', 'e', '2019-06-23 09:03:22', '2019-06-23 09:03:22'),
	(135, '<p>becik ketitik, olo .....</p>', 'pilihan', 12, 'diguwak', 'didelikne', 'ra ketok', 'ketoro (iki sing bener)', 'ola olo', 'd', '2019-06-23 09:03:22', '2019-06-23 09:03:22'),
	(136, '<p>piro bobote gunung semeru?</p>', 'pilihan', 12, 'tekok kang pairan', 'sopo sing gelem nimbang?', 'sak juta (iki sing bener)', 'tekok sing teko pas posyadune semeru', 'tekok kirun', 'c', '2019-06-23 09:03:22', '2019-06-23 21:48:25'),
	(137, '<p>sepiro pintere awakmu kui?</p>', 'esay', 12, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-23 09:03:22', '2019-06-23 09:03:22'),
	(138, '<p>halo halo</p>', 'pilihan', 13, 'bandung', '1', '2', '3', '4', 'a', '2019-06-23 22:01:16', '2019-06-23 22:01:16'),
	(139, '<p>ibukota</p>', 'pilihan', 13, 'jakarta', '2', '3', '4', '5', 'a', '2019-06-23 22:01:16', '2019-06-23 22:01:16'),
	(140, '<p>reyog</p>', 'pilihan', 13, 'ponorogo', '2', '3', '4', '5', 'a', '2019-06-23 22:01:16', '2019-06-23 22:01:16'),
	(141, '<p>bujang</p>', 'pilihan', 13, 'ganong', '2', '3', '4', '5', 'a', '2019-06-23 22:01:16', '2019-06-23 22:01:16'),
	(142, '<p>jelaskan teori quantum!</p>', 'esay', 13, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-23 22:01:16', '2019-06-23 22:01:16');
/*!40000 ALTER TABLE `soal` ENABLE KEYS */;

-- Dumping structure for table ujian_online.ujian
DROP TABLE IF EXISTS `ujian`;
CREATE TABLE IF NOT EXISTS `ujian` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `waktu_mulai` timestamp NULL DEFAULT NULL,
  `waktu_akhir` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `jumlah_pilihan` int(11) NOT NULL,
  `jumlah_esay` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.ujian: ~8 rows (approximately)
/*!40000 ALTER TABLE `ujian` DISABLE KEYS */;
INSERT INTO `ujian` (`id`, `nama`, `deskripsi`, `waktu_mulai`, `waktu_akhir`, `user_id`, `jumlah_pilihan`, `jumlah_esay`, `created_at`, `updated_at`) VALUES
	(1, 'Kalkulus', 'Lemparlah', '2018-07-21 01:01:27', '2018-07-21 01:01:27', 2, 25, 0, '2018-07-03 00:50:39', '2018-07-21 01:01:27'),
	(6, 'Alogaritma', 'qweqw', '2018-07-21 01:01:12', '2018-07-21 01:01:12', 2, 10, 5, '2018-07-03 02:29:45', '2018-07-21 01:01:12'),
	(7, 'Kecerdasan Buatan', 'Ojo ngawur lee', '2018-07-11 08:15:00', '2018-07-11 09:00:00', 2, 4, 4, '2018-07-03 02:32:23', '2018-07-14 09:33:13'),
	(8, 'Jaringan Komputer', 'Jangan Menyontek seh', '2018-07-15 08:00:00', '2018-07-15 10:00:00', 2, 10, 1, '2018-07-14 05:56:17', '2019-08-13 18:07:25'),
	(11, 'Gemblung', 'Ujian mengetes kegemblungan', '2019-06-22 21:00:00', '2019-06-22 22:00:00', 1, 5, 2, '2018-07-21 02:38:08', '2019-06-23 21:40:19'),
	(12, 'Menguji tingkat berpikir', 'Seberapa pintar anda', '2019-06-23 21:00:00', '2019-06-23 23:00:00', 1, 5, 1, '2019-06-23 09:03:22', '2019-06-23 21:40:45'),
	(13, 'halo test', 'iki po yo', '2019-06-23 21:59:00', '2019-06-23 21:59:00', 1, 4, 1, '2019-06-23 22:01:16', '2019-06-23 22:01:16'),
	(14, 'asda', NULL, '2019-07-01 21:50:00', '2019-07-01 00:58:00', 1, 4, 4, '2019-07-01 21:51:02', '2019-07-01 21:53:36');
/*!40000 ALTER TABLE `ujian` ENABLE KEYS */;

-- Dumping structure for table ujian_online.ujian_peserta
DROP TABLE IF EXISTS `ujian_peserta`;
CREATE TABLE IF NOT EXISTS `ujian_peserta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ujian_id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `ruang_id` int(11) NOT NULL,
  `soal_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_pilihan` int(11) DEFAULT NULL,
  `nilai_esay` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.ujian_peserta: ~0 rows (approximately)
/*!40000 ALTER TABLE `ujian_peserta` DISABLE KEYS */;
INSERT INTO `ujian_peserta` (`id`, `ujian_id`, `peserta_id`, `ruang_id`, `soal_ids`, `status`, `nilai_pilihan`, `nilai_esay`, `created_at`, `updated_at`) VALUES
	(1, 11, 5, 0, '128,129,130,131', 'done', 67, 60, NULL, NULL),
	(2, 8, 5, 0, '', 'pending', NULL, NULL, NULL, NULL),
	(3, 11, 6, 0, '128,130,129,131', 'done', 67, 100, NULL, NULL),
	(4, 8, 6, 0, '', 'pending', NULL, NULL, NULL, NULL),
	(5, 11, 7, 0, '128,129,130,131', 'pending', NULL, NULL, NULL, NULL),
	(6, 12, 5, 0, '133,132,135,136,134,137', 'allowed', 80, NULL, NULL, NULL),
	(7, 12, 6, 0, '132,133,136,135,134,137', 'allowed', 80, 80, NULL, NULL);
/*!40000 ALTER TABLE `ujian_peserta` ENABLE KEYS */;

-- Dumping structure for table ujian_online.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table ujian_online.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `api_token`) VALUES
	(1, 'Admin', 'admin@gmail.com', '$2y$10$jfpdyrDp/GJqVuRUKvcPt.fEkQ.UaN/eMqIMJJbkhhv.cKpcc1dEO', 'admin', 'CAauwzl8RRWA0yPBUMoi8TnoCDZ0dwQKlnZBXxIGn7hF8DtTj6bfWxU694qc', '2018-07-03 00:48:20', '2018-07-14 07:20:53', '1232123'),
	(2, 'Danny Fachrul', 'dannyfachrulh@gmail.com', '$2y$10$7.1Hc49es8cG6ESqmEvrv.jCta2XBUn7AL7Y7RoK3nINDOw17oBZW', NULL, 'AEy5Wo66jcWjrLm3BhdibI7LZhGznXNPBdcmKA7Xlpwc2d5t3JExIwtkfHhy', '2018-07-13 00:52:49', '2019-04-22 11:00:09', NULL),
	(3, 'Nizar Faisal H', 'nizarfh@gmail.com', '$2y$10$7.2lvITmUStzJ/JcnfbKlOdLnPM2t.ksOSlvnb9E0gmzJM.z6IXhW', NULL, NULL, '2018-07-18 05:51:47', '2018-07-18 05:51:47', NULL),
	(4, '12345', '12345@gmail.com', '$2y$10$NoVzbQq/swK4ZFUeuAL9MOFOBb3Ourn8cGFrHjNkn1aQ08u459ncG', 'admin', 'gaBK4WDHJOeLylH0OgY5mzASvEWmiFJpNhRrCDIK1MT3SZGfrlA7DZBgbmvb', '2019-04-17 19:06:46', '2019-04-17 19:06:46', NULL),
	(5, 'Prof. Bambang Gentolet SH, MPd', 'gentolet@gaul.com', '$2y$10$Y/T7gQS.q9jCHCiYsd3WQ.Q9i4ra/as0mYzq05.4Tx2OBbEeDY1IS', NULL, NULL, '2019-06-23 22:03:33', '2019-06-23 22:03:48', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
