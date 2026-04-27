-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: digiperpus
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `buku`
--

DROP TABLE IF EXISTS `buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(50) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_penulis` int(11) DEFAULT NULL,
  `id_penerbit` int(11) DEFAULT NULL,
  `id_rak` int(11) NOT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `tersedia` int(11) DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id_buku`),
  KEY `buku_ibfk_1` (`id_kategori`),
  KEY `buku_ibfk_2` (`id_penulis`),
  KEY `buku_ibfk_3` (`id_penerbit`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (1,'1','Filosofi Teras ','1776964478_cc219611dbf9e449e6f6.jpg',5,2,2,0,2017,3,'Latih Mentalmu menjadi Kuat'),(2,'2','Matematika','1776964470_5901242b4840dfd94e96.jpg',1,1,1,0,2014,11,'Buku Latihan'),(6,'12','Bulan','1776964461_aa14185ffc7479665b87.jpg',3,1,1,0,2020,21,'Bulann'),(7,'12','Cantik Itu Luka','1776964443_7fcca433133d5e65ba6c.jpg',3,3,2,0,0000,6,''),(8,'133','Bumi','1777136963_c91b5ce3126ccb2efbd5.webp',3,4,3,0,0000,23,'1123hfdhdf'),(10,'','Riyadul Badiyah','1776964412_7552e5fc40bde32db0b2.png',6,4,3,0,2019,5,'Ilmu Fiqih adalah Ilmu yang memepelajari tata cara kita melakukan Ibadah'),(14,'','Dilain 1990','1776964626_2fbc0adb95c70b3753aa.jpg',3,1,1,0,2021,10,'fdghjsdtjedtzmdz'),(18,NULL,'Langkah Demi Langkah','1776964392_84cfb125717af2827343.jpg',5,5,2,0,2024,7,''),(20,NULL,'How To Rich??','1776964383_792de13fe61d68cbd22a.avif',7,5,4,0,2020,10,''),(21,NULL,'Laskar Pelangi','1776964052_48c8dbcdd309d091d838.jpg',3,2,3,0,2018,10,''),(22,NULL,'Atomic Habits','1776965108_1ce99a34a8032bbc9c9c.jpg',5,2,1,0,2021,10,''),(23,NULL,'Rich Dad Poor Dad','1776965327_46fff8c4e37177ec97e0.jpg',5,3,1,0,2022,10,''),(24,NULL,'Sapiens','1776965796_2946761becb482cff525.jpg',4,10,1,0,2023,10,''),(25,NULL,'Psychology Of Money','1776965863_6e6a34022f1c2858091f.jpg',7,5,1,0,2024,9,''),(26,NULL,'Negeri 5 Menara','1776965969_dece4198d2ae926f7c88.jpg',3,9,1,0,2019,8,'Perjuangan santri dengan mantra \"Man Jadda Wajada\".'),(27,NULL,'Mantappu JIwa','1776966038_cf36d0fd402896d936b8.jpg',5,9,1,0,2024,10,'Perjalanan Jerome kuliah matematika di Jepang.');
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buku_rak`
--

DROP TABLE IF EXISTS `buku_rak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku_rak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_buku` int(11) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buku_rak_ibfk_1` (`id_buku`),
  KEY `buku_rak_ibfk_2` (`id_rak`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku_rak`
--

LOCK TABLES `buku_rak` WRITE;
/*!40000 ALTER TABLE `buku_rak` DISABLE KEYS */;
INSERT INTO `buku_rak` VALUES (1,0,0),(2,0,0),(3,3,0),(4,4,0),(5,5,0),(6,6,2),(7,7,2),(8,8,1),(9,13,NULL),(14,2,1),(15,18,3),(17,20,4),(18,21,2),(19,14,2),(20,10,1),(21,1,1),(22,22,3),(23,23,3),(24,24,7),(25,25,4),(26,26,2),(27,27,1);
/*!40000 ALTER TABLE `buku_rak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Sains & Matematika'),(2,'Teknologi & Komputer'),(3,'Fiksi & Novel'),(4,'Sejarah & Budaya'),(5,'Pengembangan Diri'),(6,'Agama & Spiritualitas'),(7,'Bisnis & Ekonomi'),(8,'Psikologi'),(9,'Kesehatan'),(10,'Seni & Desain');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_aktivitas`
--

DROP TABLE IF EXISTS `log_aktivitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `aksi` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_log`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_aktivitas`
--

LOCK TABLES `log_aktivitas` WRITE;
/*!40000 ALTER TABLE `log_aktivitas` DISABLE KEYS */;
INSERT INTO `log_aktivitas` VALUES (3,1,'Pinjam Buku','User mengajukan pinjam: Bulan (Status: disetujui)','::1','2026-04-20 22:29:14'),(4,1,'Pinjam Buku','User mengajukan pinjam: Cantik Itu Luka (Status: disetujui)','::1','2026-04-20 22:30:59'),(5,1,'Pengembalian Buku','User mengembalikan buku: Bulan','::1','2026-04-20 22:32:58'),(6,1,'Pinjam Buku','User mengajukan pinjam: Filosofi Teras  (Status: disetujui)','::1','2026-04-20 23:04:39'),(7,1,'Pinjam Buku','User mengajukan pinjam: Cantik Itu Luka (Status: disetujui)','::1','2026-04-20 23:04:58'),(8,1,'Pinjam Buku','User mengajukan pinjam: Bulan (Status: pending)','::1','2026-04-20 23:05:04'),(9,1,'Pengembalian Buku','User mengembalikan buku: Bulan','::1','2026-04-21 22:37:46'),(10,1,'Pinjam Buku','User mengajukan pinjam: Riyadul Badiyah (Status: pending)','::1','2026-04-21 22:47:54'),(11,1,'Pinjam Buku','User mengajukan pinjam: Riyadul Badiyah (Status: pending)','::1','2026-04-21 22:49:02'),(12,1,'Pengembalian Buku','Buku dikembalikan: Cantik Itu Luka','::1','2026-04-22 13:14:19'),(13,1,'Pinjam Buku','User mengajukan pinjam: Bulan (Status: pending)','::1','2026-04-22 13:56:07'),(14,1,'Pengembalian Buku','Buku dikembalikan: Riyadul Badiyah','::1','2026-04-23 00:16:04'),(15,1,'Pinjam Buku','User mengajukan pinjam: Langkah Demi Langkah (Status: disetujui)','::1','2026-04-23 00:44:00'),(16,1,'Pinjam Buku','User mengajukan pinjam: Laskar Pelangi (Status: pending)','::1','2026-04-23 14:13:55'),(17,1,'Pinjam Buku','User mengajukan pinjam: How To Rich?? (Status: pending)','::1','2026-04-24 00:18:13'),(18,1,'Pengembalian Buku','Buku dikembalikan: How To Rich?? dengan denda Rp2000','::1','2026-04-24 14:15:07'),(19,1,'Pengembalian Buku','Buku dikembalikan: Laskar Pelangi dengan denda Rp2000','::1','2026-04-24 14:15:19'),(20,1,'Pengembalian Buku','Buku dikembalikan: Langkah Demi Langkah dengan denda Rp2000','::1','2026-04-24 14:15:22'),(22,6,'Pinjam Buku','Meminjam Negeri 5 Menara','::1','2026-04-24 23:02:37'),(23,6,'Pengembalian','Buku Filosofi Teras  kembali','::1','2026-04-24 23:03:27'),(24,8,'Pinjam Buku','Meminjam Langkah Demi Langkah','::1','2026-04-25 00:07:40'),(25,8,'Pengembalian','Buku Langkah Demi Langkah kembali','::1','2026-04-25 00:08:26'),(26,6,'Pinjam Buku','Meminjam Filosofi Teras ','::1','2026-04-25 02:09:52'),(27,8,'Pinjam Buku','Meminjam Negeri 5 Menara','::1','2026-04-25 23:16:16'),(28,8,'Pinjam Buku','Meminjam Psychology','::1','2026-04-25 23:16:27'),(29,6,'Pinjam Buku','Meminjam Psychology Of Money','::1','2026-04-26 00:35:40'),(30,6,'Pinjam Buku','Meminjam Sapiens','::1','2026-04-26 17:17:08'),(31,6,'Pengembalian','Buku Mantappu JIwa kembali','::1','2026-04-26 17:17:20'),(32,6,'Pengembalian','Buku Psychology Of Money kembali','::1','2026-04-27 15:49:18');
/*!40000 ALTER TABLE `log_aktivitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_pengembalian_asli` date DEFAULT NULL,
  `status` enum('dipinjam','pending','disetujui','ditolak','kembali') DEFAULT 'disetujui',
  `denda` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_denda` enum('tidak_ada','belum_bayar','proses','lunas') DEFAULT 'tidak_ada',
  `bukti_bayar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_peminjaman`),
  KEY `id_buku` (`id_buku`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (23,6,10,'2026-04-21','2026-04-28',NULL,'',0,'2026-04-21 22:47:54','2026-04-21 22:47:54','tidak_ada',NULL),(24,6,10,'2026-04-21','2026-04-28','2026-04-22','kembali',0,'2026-04-21 22:49:02','2026-04-23 00:16:04','tidak_ada',NULL),(25,6,6,'2026-04-22','2026-04-29',NULL,'ditolak',0,'2026-04-22 13:56:07','2026-04-22 13:56:42','tidak_ada',NULL),(26,6,18,'2026-04-22','2026-04-23','2026-04-24','kembali',0,'2026-04-23 00:44:00','2026-04-25 02:01:51','lunas',NULL),(27,6,21,'2026-04-23','2026-04-23','2026-04-24','kembali',0,'2026-04-23 14:13:55','2026-04-25 02:12:51','lunas','1777050679_2b27bb712936f8667df4.png'),(28,6,20,'2026-04-23','2026-04-23','2026-04-24','kembali',0,'2026-04-24 00:18:13','2026-04-24 21:57:21','lunas','1777018433_bd102fbc7f9a4d342feb.jpg'),(29,6,27,'2026-04-24','2026-05-01','2026-04-26','kembali',0,'2026-04-24 22:37:44','2026-04-26 17:17:20','tidak_ada',NULL),(30,6,26,'2026-04-24','2026-05-01',NULL,'disetujui',0,'2026-04-24 23:02:37','2026-04-24 23:03:04','tidak_ada',NULL),(31,8,18,'2026-04-24','2026-05-01','2026-04-24','kembali',0,'2026-04-25 00:07:40','2026-04-25 00:08:26','tidak_ada',NULL),(32,6,1,'2026-04-24','2026-05-01',NULL,'disetujui',0,'2026-04-25 02:09:52','2026-04-25 02:10:09','tidak_ada',NULL),(33,8,26,'2026-04-25','2026-05-02',NULL,'disetujui',0,'2026-04-25 23:16:16','2026-04-25 23:16:16','tidak_ada',NULL),(34,8,25,'2026-04-25','2026-05-02',NULL,'disetujui',0,'2026-04-25 23:16:27','2026-04-25 23:16:27','tidak_ada',NULL),(35,6,25,'2026-04-25','2026-04-24','2026-04-27','kembali',6000,'2026-04-26 00:35:40','2026-04-27 15:49:18','belum_bayar',NULL),(36,6,24,'2026-04-26','2026-05-03',NULL,'ditolak',0,'2026-04-26 17:17:08','2026-04-26 17:18:38','tidak_ada',NULL);
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penerbit`
--

DROP TABLE IF EXISTS `penerbit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL,
  `nama_penerbit` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerbit`
--

LOCK TABLES `penerbit` WRITE;
/*!40000 ALTER TABLE `penerbit` DISABLE KEYS */;
INSERT INTO `penerbit` VALUES (1,'Gramedia Pustaka Utama',NULL),(2,'Erlangga',NULL),(3,'Bentang Pustaka',NULL),(4,'Mizan Pustaka',NULL),(5,'Republika',NULL);
/*!40000 ALTER TABLE `penerbit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penulis`
--

DROP TABLE IF EXISTS `penulis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penulis` (
  `id_penulis` int(11) NOT NULL,
  `nama_penulis` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penulis`
--

LOCK TABLES `penulis` WRITE;
/*!40000 ALTER TABLE `penulis` DISABLE KEYS */;
INSERT INTO `penulis` VALUES (1,'Tere Liye'),(2,'Andrea Hirata'),(3,'Dewi Lestari'),(4,'Pramoedya Ananta Toer'),(5,'Boy Candra'),(2,'James Clear'),(3,'Robert T. Kiyosaki'),(4,'Dee Lestari'),(5,'Elon Musk'),(6,'Mark Manson'),(7,'Fiersa Besari'),(8,'Yuval Noah Harari'),(9,'Raditya Dika'),(10,'Dale Carnegie');
/*!40000 ALTER TABLE `penulis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rak`
--

DROP TABLE IF EXISTS `rak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rak` (
  `id_rak` int(11) NOT NULL AUTO_INCREMENT,
  `nama_rak` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_rak`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rak`
--

LOCK TABLES `rak` WRITE;
/*!40000 ALTER TABLE `rak` DISABLE KEYS */;
INSERT INTO `rak` VALUES (1,'Motivasi','Lantai 1'),(2,'Novel','Lantai 1'),(3,'Self Improvement','Lantai 1'),(4,'Bisnis','Lantai 2'),(5,'Sejarah','Lantai 2'),(6,'Teknologi','Lantai 2'),(7,'Biografi','Lantai 1'),(8,'Komik','Lantai 1'),(9,'Referensi','Lantai 2'),(10,'Motivasi','Lantai 1');
/*!40000 ALTER TABLE `rak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riwayat_peminjaman`
--

DROP TABLE IF EXISTS `riwayat_peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `riwayat_peminjaman` (
  `id_riwayat` int(11) NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int(11) DEFAULT NULL,
  `judul_buku` varchar(255) DEFAULT NULL,
  `nama_peminjam` varchar(100) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali_seharusnya` date DEFAULT NULL,
  `tanggal_kembali_asli` date DEFAULT NULL,
  `denda` int(11) DEFAULT 0,
  `status_akhir` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_riwayat`),
  KEY `riwayat_peminjaman_ibfk_1` (`id_peminjaman`),
  CONSTRAINT `riwayat_peminjaman_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riwayat_peminjaman`
--

LOCK TABLES `riwayat_peminjaman` WRITE;
/*!40000 ALTER TABLE `riwayat_peminjaman` DISABLE KEYS */;
/*!40000 ALTER TABLE `riwayat_peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ulasan`
--

DROP TABLE IF EXISTS `ulasan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_peminjaman` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `komentar` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_ulasan`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ulasan`
--

LOCK TABLES `ulasan` WRITE;
/*!40000 ALTER TABLE `ulasan` DISABLE KEYS */;
INSERT INTO `ulasan` VALUES (1,6,7,NULL,5,'','2026-04-22 16:54:37'),(2,6,7,NULL,5,'','2026-04-22 16:54:37'),(3,6,6,NULL,5,'Seruu bangett!!!!\r\n','2026-04-22 17:15:52'),(4,6,2,NULL,5,'','2026-04-22 17:20:50'),(5,6,2,NULL,5,'','2026-04-22 17:22:22'),(6,6,2,NULL,5,'','2026-04-22 17:23:31'),(7,6,2,NULL,1,'','2026-04-22 17:24:24'),(8,6,10,NULL,5,'alhamdulillah','2026-04-23 07:20:38'),(9,6,10,NULL,5,'','2026-04-23 17:18:22'),(10,6,10,NULL,5,'efashsdej','2026-04-23 17:18:33'),(11,6,20,NULL,5,'','2026-04-24 14:59:20'),(12,6,10,NULL,4,'Mantappu alhamdulillah minn!!','2026-04-24 15:10:08'),(13,6,7,NULL,5,'fdjdfmxf','2026-04-24 22:18:39'),(14,6,6,NULL,5,'hasjhdtjt','2026-04-24 22:18:52'),(15,6,6,NULL,5,'stkjrykmfhsm','2026-04-24 22:18:59'),(16,6,8,NULL,5,'dkhgfhmfgsxm','2026-04-24 22:19:08'),(17,6,2,12,5,'rhgarehj','2026-04-24 22:26:38'),(18,6,20,28,5,'fgmdfh,h','2026-04-24 22:36:56'),(19,6,6,18,5,'fhjszajhdtajkdt','2026-04-24 22:37:20'),(20,6,10,24,5,'nhswtnjwtrj','2026-04-24 23:03:38'),(21,8,18,31,5,'1234','2026-04-25 00:08:37'),(22,6,21,27,5,'Maff ya telatt nagsihhnya\r\n','2026-04-25 02:10:43'),(23,6,18,26,5,'sfhsdgxmjfsghm','2026-04-26 00:35:26'),(24,6,27,29,5,'bukuunya baguss','2026-04-26 17:18:03');
/*!40000 ALTER TABLE `ulasan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','anggota') DEFAULT 'anggota',
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `telepon` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Obeyy','muhamadrobirahmawan70@gmail.com','Beyy','$2y$10$mN0VlSGGtLX7EHzKM0Cyc.IachwUzGbDPLIIt5dCIve1U7WPEoOCC','admin','1775880153_09cd2933c38eb181b94f.webp','aktif',NULL,'2026-04-11 02:17:32'),(2,'Ahmad Syahid','muhamadrobirahmawan70@gmail.com','Ahmad','$2y$10$.zblxY02g/c5w7QwEvIKW.gv/4DnLXNO9LKOQ8W23/AzhdFgMpKkS','anggota','1775880599_4ff5ed0b7d23c330fc7b.webp','aktif',NULL,'2026-04-11 04:09:59'),(6,'Obett','muhamadrobirahmawan70@gmail.com','bett','$2y$10$6K289mLJdred6.MfriK72ORNWIJlPjuWV.qdGCBZoqS3J3xZwj/H2','anggota','1776526492_ee9b995ae82a7e63267e.webp','aktif',NULL,'2026-04-18 15:34:52'),(8,'adit','muhamadrobirahmawan70@gmail.com','aditganteng','$2y$10$q4x9Uz7aaO6S6SEpIuCNjeNhNF1twulk0ZDdXZrGcslKtq5RH0O2K','anggota','1777050386_8918a3849645e6e29a8e.webp','aktif',NULL,'2026-04-24 17:06:26'),(9,'Ahmad Syahid','muhamadrobirahmawan70@gmail.com','medd','$2y$10$92WDrTGhmAz/QaHG08eAs.aaTH7FwApuZoAhmZp6b2vm1Jy0mYauS','anggota','1777199485_89c07994a60bfb34d150.jpg','aktif',NULL,'2026-04-26 10:31:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-27 16:11:16
