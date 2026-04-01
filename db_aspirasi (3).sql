-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 01, 2026 at 02:41 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_aspirasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `Username`, `Password`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` int NOT NULL,
  `status` enum('Menunggu','Proses','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Id_pelaporan` int NOT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `status`, `Id_pelaporan`, `feedback`) VALUES
(1, 'Menunggu', 1, 'Sedang diproses oleh teknisi\r\n'),
(2, 'Selesai', 2, 'sudah bersih'),
(3, 'Selesai', 3, 'Satpam sudah ditambah'),
(4, 'Menunggu', 4, 'Akan dibahas di rapat OSIS'),
(5, 'Proses', 5, 'Sudah ditegur oleh kepala sekolah'),
(6, 'Selesai', 6, 'Komputer sudah diperbaiki'),
(7, 'Menunggu', 7, 'Akan dicek oleh pengelola kantin'),
(8, 'Proses', 8, 'Pengadaan buku sedang dilakukan'),
(9, 'Selesai', 9, 'Area parkir sudah diperluas'),
(10, 'Proses', 10, 'Provider internet sedang diperbaiki'),
(16, 'Proses', 25, '-segera kami bersihkan\r\n'),
(17, 'Selesai', 26, 'sudahh ya neuk\r\n'),
(18, 'Selesai', 27, 'sudah selesai\r\n'),
(19, 'Menunggu', 28, '-'),
(21, 'Selesai', 30, 'oke');

-- --------------------------------------------------------

--
-- Table structure for table `input_aspirasi`
--

CREATE TABLE `input_aspirasi` (
  `Id_pelaporan` int NOT NULL,
  `nis` int NOT NULL,
  `id_kategori` int NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `ket` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `input_aspirasi`
--

INSERT INTO `input_aspirasi` (`Id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `ket`, `created_at`) VALUES
(1, 1001, 1, 'Ruang Kelas X-RPL1', 'AC tidak berfungsi', '2026-03-04 12:24:19'),
(2, 1002, 2, 'Toilet Lantai 1', 'Toilet kurang bersih', '2026-03-04 12:24:19'),
(3, 1003, 3, 'Gerbang Sekolah', 'Keamanan kurang ketat', '2026-03-04 12:24:19'),
(4, 1004, 4, 'lapangan', 'Siswa sering terlambat', '2026-03-04 12:24:19'),
(5, 1005, 5, 'Ruang Guru', 'Guru sering terlambat', '2026-03-04 12:24:19'),
(6, 1006, 6, 'Lab Komputer', 'Beberapa komputer rusak', '2026-03-04 12:24:19'),
(7, 1007, 7, 'Kantin', 'Harga makanan mahal', '2026-03-04 12:24:19'),
(8, 1008, 8, 'perpustakaan', 'Buku kurang lengkap', '2026-03-04 12:24:19'),
(9, 1009, 9, 'Area parkir', 'parkir sempit', '2026-03-04 12:24:19'),
(10, 1010, 10, 'Lab Jaringan', 'Internet lambat', '2026-03-04 12:24:19'),
(25, 1024, 2, 'kelas', 'ngeri kali kotor nya\r\n', '2026-03-04 22:09:57'),
(26, 1003, 3, 'kamar mandi', 'kursanh', '2026-03-06 01:54:00'),
(27, 1003, 7, 'knton', 'lumayan', '2026-04-24 03:05:00'),
(28, 1005, 3, 'kantin', 'selalu ribut kai', '2026-03-05 21:54:54'),
(29, 1007, 4, 'ruaang guru', 'sangajsjsw', '2026-03-05 23:46:59'),
(30, 1006, 5, 'kelas', 'bagus', '2026-03-10 11:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `Id_kategori` int NOT NULL,
  `ket_kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`Id_kategori`, `ket_kategori`) VALUES
(1, 'Fasilitass'),
(2, 'kebersihan'),
(3, 'keamanan'),
(4, 'kedisiplinan'),
(5, 'Pelayanan Guru'),
(6, 'Sarana Prasarana'),
(7, 'kantin'),
(8, 'Perpustakaan'),
(9, 'Parkiran'),
(10, 'Laboratorium'),
(17, 'iyaaa');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` int NOT NULL,
  `kelas` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `kelas`) VALUES
(1001, 'X-RPL1'),
(1002, 'X-RPL2'),
(1003, 'XI-RPL1'),
(1004, 'XI-RPL2'),
(1005, 'XII-RPL1'),
(1006, 'XII-RPL2'),
(1007, 'X-TKJ1'),
(1008, 'X-TKJ2'),
(1009, 'XI-TKJ1'),
(1010, 'XII-TKJ1'),
(1011, 'XII-TKJ3'),
(1024, 'XBP1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `Id_pelaporan` (`Id_pelaporan`);

--
-- Indexes for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD PRIMARY KEY (`Id_pelaporan`),
  ADD KEY `nis` (`nis`,`id_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`Id_kategori`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  MODIFY `Id_pelaporan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `Id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `nis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1025;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_ibfk_1` FOREIGN KEY (`Id_pelaporan`) REFERENCES `input_aspirasi` (`Id_pelaporan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD CONSTRAINT `input_aspirasi_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `input_aspirasi_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`Id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
