/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - data_perpus
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`data_perpus` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `data_perpus`;

/*Table structure for table `log_pinjam` */

DROP TABLE IF EXISTS `log_pinjam`;

CREATE TABLE `log_pinjam` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_buku` varchar(10) NOT NULL,
  `id_anggota` varchar(10) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_buku` (`id_buku`),
  CONSTRAINT `log_pinjam_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `log_pinjam_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `log_pinjam` */

insert  into `log_pinjam`(`id_log`,`id_buku`,`id_anggota`,`tgl_pinjam`) values 
(1,'B001','A001','2020-06-23'),
(2,'B002','A001','2020-06-25'),
(3,'B003','A002','2020-06-01'),
(4,'B002','A005','2025-11-20'),
(5,'B003','A006','2025-12-17'),
(6,'B005','A003','2025-12-10');

/*Table structure for table `tb_anggota` */

DROP TABLE IF EXISTS `tb_anggota`;

CREATE TABLE `tb_anggota` (
  `id_anggota` varchar(10) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jekel` enum('Laki-laki','Perempuan') NOT NULL,
  `jurusan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_anggota` */

insert  into `tb_anggota`(`id_anggota`,`nama`,`jekel`,`jurusan`,`no_hp`) values 
('A001','Putu krisna dwipayana','Laki-laki','Sistem & Teknologi Informasi Bisnis','089987789000'),
('A002','Made Paramasura','Laki-laki','Sistem & Teknologi Informasi Bisnis','089987789098'),
('A003','NI Kadek Gelin Adinda Rasti','Perempuan','Manajemen Retail','085878526048'),
('A004','Muhamad Aldin','Laki-laki','Sistem & Teknologi Informasi Bisnis','087789987654'),
('A005','Dewa Made Arwinata Dana','Laki-laki','Sistem & Teknologi Informasi Bisnis','089987789098'),
('A006','Hieronimus Seingo Riti','Laki-laki','Sistem & Teknologi Informasi Bisnis','0875432912873'),
('A007','Uci Ramdahany','Perempuan','Sistem & Teknologi Informasi Bisnis','081672789892');

/*Table structure for table `tb_buku` */

DROP TABLE IF EXISTS `tb_buku`;

CREATE TABLE `tb_buku` (
  `id_buku` varchar(10) NOT NULL,
  `judul_buku` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pengarang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `penerbit` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `th_terbit` year NOT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_buku` */

insert  into `tb_buku`(`id_buku`,`judul_buku`,`pengarang`,`penerbit`,`th_terbit`) values 
('A006','Buku Sakti Pemrograman Web Seri PHP','Mundzir MF','Anak Hebat Indonesia',2018),
('B001','Matematika','anastasya','armi print',2010),
('B002','RPL 2','Eko','UMK',2020),
('B003','C++','Anton','Toni Perc',2010),
('B004','CI 4','anastasya','armi print',2009),
('B005','Data Mining','Anton','Toni Perc',2020);

/*Table structure for table `tb_pengguna` */

DROP TABLE IF EXISTS `tb_pengguna`;

CREATE TABLE `tb_pengguna` (
  `id_pengguna` int NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(35) NOT NULL,
  `level` enum('Administrator','Petugas') DEFAULT NULL,
  PRIMARY KEY (`id_pengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `tb_pengguna` */

insert  into `tb_pengguna`(`id_pengguna`,`nama_pengguna`,`username`,`password`,`level`) values 
(6,'Naufal Putra','naufal','292537d8c473fe207a85cdf61fab4d0f','Petugas'),
(7,'I Made Ryan Pradnyana','Ryan Pradnyana','0192023a7bbd73250516f069df18b500','Administrator');

/*Table structure for table `tb_sirkulasi` */

DROP TABLE IF EXISTS `tb_sirkulasi`;

CREATE TABLE `tb_sirkulasi` (
  `id_sk` varchar(20) NOT NULL,
  `id_buku` varchar(10) NOT NULL,
  `id_anggota` varchar(10) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `status` enum('PIN','KEM') NOT NULL,
  `tgl_dikembalikan` date DEFAULT NULL,
  PRIMARY KEY (`id_sk`),
  KEY `id_buku` (`id_buku`),
  KEY `id_anggota` (`id_anggota`),
  CONSTRAINT `tb_sirkulasi_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_sirkulasi_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_sirkulasi` */

insert  into `tb_sirkulasi`(`id_sk`,`id_buku`,`id_anggota`,`tgl_pinjam`,`tgl_kembali`,`status`,`tgl_dikembalikan`) values 
('A005','B003','A006','2025-12-17','2025-12-24','KEM','2025-12-17'),
('A006','B005','A003','2025-12-10','2025-12-17','PIN',NULL),
('S001','B001','A001','2020-06-23','2020-06-30','KEM','2025-12-15'),
('S002','B002','A001','2020-06-13','2020-06-20','PIN',NULL),
('S003','B003','A002','2020-06-22','2020-06-29','PIN',NULL),
('S004','B002','A005','2020-06-23','2020-06-30','PIN',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
