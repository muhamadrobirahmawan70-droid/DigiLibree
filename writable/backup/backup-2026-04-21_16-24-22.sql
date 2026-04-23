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
  `id_kategori` int(11) DEFAULT NULL,
  `id_penulis` int(11) DEFAULT NULL,
  `id_penerbit` int(11) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 0,
  `tersedia` int(11) DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  PRIMARY KEY (`id_buku`),
  KEY `buku_ibfk_1` (`id_kategori`),
  KEY `buku_ibfk_2` (`id_penulis`),
  KEY `buku_ibfk_3` (`id_penerbit`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (1,'1','Filosofi Teras ',4,2,2,2017,6,3,'Latih Mentalmu menjadi Kuat',NULL,9),(2,'2','Matematika',1,1,1,2013,11,11,'Buku Latihan',NULL,11),(6,'12','Bulan',1,1,1,0000,23512,235124,'',NULL,10),(7,'12','Cantik Itu Luka',2,3,2,0000,215545,51634632,'',NULL,11),(8,'133','Bumi',3,4,3,0000,33,23,'1123hfdhdf',NULL,10),(10,'','Riyadul Badiyah',5,4,3,2019,6,4,'Ilmu Fiqih adalah Ilmu yang memepelajari tata cara kita melakukan Ibadah',NULL,10),(14,'','Cantik Itu Luka',2,2,1,2021,6,3,'fdghjsdtjedtzmdz',NULL,6);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku_rak`
--

LOCK TABLES `buku_rak` WRITE;
/*!40000 ALTER TABLE `buku_rak` DISABLE KEYS */;
INSERT INTO `buku_rak` VALUES (1,0,0),(2,0,0),(3,3,0),(4,4,0),(5,5,0),(6,6,0),(7,7,0),(8,8,0),(9,13,NULL),(10,14,1);
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
INSERT INTO `kategori` VALUES (1,'Sains & Teknologi'),(2,'Novel & Fiksi'),(3,'Sejarah'),(4,'Pengembangan Diri'),(5,'Agama');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_aktivitas`
--

LOCK TABLES `log_aktivitas` WRITE;
/*!40000 ALTER TABLE `log_aktivitas` DISABLE KEYS */;
INSERT INTO `log_aktivitas` VALUES (1,1,'Pinjam Kilat','User meminjam: Matematika','::1','2026-04-20 13:19:43'),(2,1,'Pengembalian Buku','User mengembalikan buku: Matematika','::1','2026-04-20 13:19:47'),(3,1,'Pinjam Buku','User mengajukan pinjam: Bulan (Status: disetujui)','::1','2026-04-20 22:29:14'),(4,1,'Pinjam Buku','User mengajukan pinjam: Cantik Itu Luka (Status: disetujui)','::1','2026-04-20 22:30:59'),(5,1,'Pengembalian Buku','User mengembalikan buku: Bulan','::1','2026-04-20 22:32:58'),(6,1,'Pinjam Buku','User mengajukan pinjam: Filosofi Teras  (Status: disetujui)','::1','2026-04-20 23:04:39'),(7,1,'Pinjam Buku','User mengajukan pinjam: Cantik Itu Luka (Status: disetujui)','::1','2026-04-20 23:04:58'),(8,1,'Pinjam Buku','User mengajukan pinjam: Bulan (Status: pending)','::1','2026-04-20 23:05:04'),(9,1,'Pengembalian Buku','User mengembalikan buku: Bulan','::1','2026-04-21 22:37:46'),(10,1,'Pinjam Buku','User mengajukan pinjam: Riyadul Badiyah (Status: pending)','::1','2026-04-21 22:47:54'),(11,1,'Pinjam Buku','User mengajukan pinjam: Riyadul Badiyah (Status: pending)','::1','2026-04-21 22:49:02');
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
  PRIMARY KEY (`id_peminjaman`),
  KEY `id_buku` (`id_buku`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (2,3,7,'2026-04-18','2026-04-25',NULL,'',0,'2026-04-18 13:08:33','2026-04-18 13:20:20'),(5,1,2,'2026-04-18','2026-04-18','2026-04-18','kembali',0,'2026-04-18 13:38:36','2026-04-21 21:55:16'),(9,3,8,'2026-04-18','2026-04-25',NULL,'',0,'2026-04-18 14:03:10','2026-04-18 14:03:10'),(10,6,8,'2026-04-18','2026-04-25','2026-04-18','kembali',0,'2026-04-18 23:02:06','2026-04-19 00:03:57'),(11,6,2,'2026-04-18','2026-04-25','2026-04-18','kembali',0,'2026-04-18 23:26:32','2026-04-19 02:31:07'),(12,6,2,'2026-04-18','2026-04-25','2026-04-18','kembali',0,'2026-04-18 23:27:50','2026-04-19 03:44:38'),(13,6,2,'2026-04-18','2026-04-25','2026-04-20','kembali',0,'2026-04-18 23:40:59','2026-04-20 13:19:47'),(14,6,6,'2026-04-18','2026-04-25',NULL,'',0,'2026-04-18 23:58:06','2026-04-18 23:58:06'),(15,6,1,'2026-04-18','2026-04-25',NULL,'',0,'2026-04-19 00:07:28','2026-04-19 00:07:28'),(16,6,1,'2026-04-18','2026-04-25',NULL,'',0,'2026-04-19 02:30:54','2026-04-19 02:30:54'),(17,6,2,'2026-04-20','2026-04-27',NULL,'',0,'2026-04-20 13:19:43','2026-04-20 13:19:43'),(18,6,6,'2026-04-20','2026-04-27','2026-04-20','kembali',0,'2026-04-20 22:29:14','2026-04-20 22:32:58'),(19,6,14,'2026-04-20','2026-04-27',NULL,'disetujui',0,'2026-04-20 22:30:59','2026-04-20 22:30:59'),(20,6,1,'2026-04-20','2026-04-27',NULL,'disetujui',0,'2026-04-20 23:04:39','2026-04-20 23:04:39'),(21,6,7,'2026-04-20','2026-04-27',NULL,'disetujui',0,'2026-04-20 23:04:58','2026-04-20 23:04:58'),(22,6,6,'2026-04-20','2026-04-20','2026-04-21','kembali',2000,'2026-04-20 23:05:04','2026-04-21 22:37:46'),(23,6,10,'2026-04-21','2026-04-28',NULL,'',0,'2026-04-21 22:47:54','2026-04-21 22:47:54'),(24,6,10,'2026-04-21','2026-04-28',NULL,'disetujui',0,'2026-04-21 22:49:02','2026-04-21 22:49:18');
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
INSERT INTO `penulis` VALUES (1,'Tere Liye'),(2,'Andrea Hirata'),(3,'Dewi Lestari'),(4,'Pramoedya Ananta Toer'),(5,'Boy Candra');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rak`
--

LOCK TABLES `rak` WRITE;
/*!40000 ALTER TABLE `rak` DISABLE KEYS */;
INSERT INTO `rak` VALUES (1,'B-3','B-3');
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
  PRIMARY KEY (`id_riwayat`)
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
  `role` enum('admin','petugas','anggota') DEFAULT 'anggota',
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `telepon` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Obeyy','Bett','Beyy','$2y$10$mN0VlSGGtLX7EHzKM0Cyc.IachwUzGbDPLIIt5dCIve1U7WPEoOCC','admin','1775880153_09cd2933c38eb181b94f.webp','aktif',NULL,'2026-04-11 02:17:32'),(2,'Ahmad Syahid','muhamadrobirahmawan70@gmail.com','Ahmad','$2y$10$.zblxY02g/c5w7QwEvIKW.gv/4DnLXNO9LKOQ8W23/AzhdFgMpKkS','anggota','1775880599_4ff5ed0b7d23c330fc7b.webp','aktif',NULL,'2026-04-11 04:09:59'),(3,'Aboyy','robim7630@gmail.com','aboyy','$2y$10$dobBGaArf0cWkRcMYyLkOufQ9Icd7lvNhgPNAsuwqimheeiIgy.Fe','petugas','1775924146_4cd5b0b1162562b3e500.webp','aktif',NULL,'2026-04-11 16:15:46'),(6,'Obett','muhamadrobirahmawan70@gmail.com','bett','$2y$10$6K289mLJdred6.MfriK72ORNWIJlPjuWV.qdGCBZoqS3J3xZwj/H2','anggota','1776526492_ee9b995ae82a7e63267e.webp','aktif',NULL,'2026-04-18 15:34:52'),(7,'Bayu Suaidi','muhamadrobirahmawan70@gmail.com','Bayu','$2y$10$0ue5PvsSoFPoZm5CU37jlOWcP1.ybWvDoM7JxXYlg5a6H27XSpSMu','anggota','1776541579_e437268d566226a6f3f3.webp','aktif',NULL,'2026-04-18 19:46:19');
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

-- Dump completed on 2026-04-21 23:24:23
