-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 17, 2022 at 10:17 AM
-- Server version: 10.5.15-MariaDB-cll-lve
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `labandroid_esprfid`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(12) NOT NULL,
  `admin_username` varchar(30) NOT NULL,
  `admin_password` varchar(50) NOT NULL,
  `admin_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`, `admin_nama`) VALUES
(1, 'admin', 'admin', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `data_users`
--

CREATE TABLE `data_users` (
  `id` double NOT NULL,
  `rfid` varchar(50) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `alamat` text NOT NULL,
  `umur` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_users`
--

INSERT INTO `data_users` (`id`, `rfid`, `nama`, `alamat`, `umur`, `status`, `updated_at`) VALUES
(1, 'A19E551B', 'Wardana Adiaksa', 'Jakarta', 12, 0, '2022-04-27 04:08:08'),
(2, 'B23D221B', 'Rudi', 'Bandung', 12, 0, '2022-04-27 04:10:49'),
(15, 'F3C1D89A', 'Badrun Alam', 'Bandung', 13, 0, '2022-07-09 12:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `izin`
--

CREATE TABLE `izin` (
  `izin_id` int(12) NOT NULL,
  `karyawan_id` int(12) NOT NULL,
  `izin_nama` varchar(50) NOT NULL,
  `izin_dari` date NOT NULL,
  `izin_sampai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `jabatan_id` int(12) NOT NULL,
  `jabatan_nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`jabatan_id`, `jabatan_nama`) VALUES
(5, 'asd'),
(4, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `jadwal_id` int(12) NOT NULL,
  `jabatan_id` int(12) NOT NULL,
  `jadwal_hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jadwal_masuk` time NOT NULL,
  `jadwal_pulang` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`jadwal_id`, `jabatan_id`, `jadwal_hari`, `jadwal_masuk`, `jadwal_pulang`) VALUES
(8, 4, 'Senin', '12:00:00', '12:00:00'),
(9, 4, 'Selasa', '00:00:00', '00:00:00'),
(10, 4, 'Rabu', '00:00:00', '00:00:00'),
(11, 4, 'Kamis', '00:01:00', '00:36:00'),
(12, 4, 'Jumat', '00:00:00', '00:00:00'),
(13, 4, 'Sabtu', '00:00:00', '00:00:00'),
(14, 4, 'Minggu', '00:00:00', '00:00:00'),
(15, 5, 'Senin', '00:00:00', '00:00:00'),
(16, 5, 'Selasa', '00:00:00', '00:00:00'),
(17, 5, 'Rabu', '00:00:00', '00:00:00'),
(18, 5, 'Kamis', '00:00:00', '00:00:00'),
(19, 5, 'Jumat', '00:00:00', '00:00:00'),
(20, 5, 'Sabtu', '00:00:00', '00:00:00'),
(21, 5, 'Minggu', '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `karyawan_id` int(12) NOT NULL,
  `jabatan_id` int(12) NOT NULL,
  `karyawan_rfid` varchar(10) NOT NULL,
  `karyawan_nama` varchar(50) NOT NULL,
  `karyawan_nik` varchar(16) NOT NULL,
  `karyawan_jeniskelamin` enum('M','F') NOT NULL,
  `karyawan_lahir` date NOT NULL,
  `karyawan_nomorhp` varchar(20) NOT NULL,
  `karyawan_alamat` varchar(500) NOT NULL,
  `karyawan_foto` varchar(255) NOT NULL,
  `karyawan_status` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`karyawan_id`, `jabatan_id`, `karyawan_rfid`, `karyawan_nama`, `karyawan_nik`, `karyawan_jeniskelamin`, `karyawan_lahir`, `karyawan_nomorhp`, `karyawan_alamat`, `karyawan_foto`, `karyawan_status`) VALUES
(9, 4, 'E3E64D15', 'nama1', '1234567890123456', 'M', '2022-07-17', '1234567890', 'jakarta', '82799958662d3e0b6971bd.png', '1');

-- --------------------------------------------------------

--
-- Table structure for table `libur`
--

CREATE TABLE `libur` (
  `libur_id` int(12) NOT NULL,
  `libur_keterangan` varchar(50) NOT NULL,
  `libur_dari` date NOT NULL,
  `libur_sampai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rekap`
--

CREATE TABLE `rekap` (
  `rekap_id` bigint(20) NOT NULL,
  `jadwal_id` int(12) NOT NULL,
  `karyawan_id` int(12) NOT NULL,
  `rekap_tanggal` date NOT NULL,
  `rekap_masuk` time DEFAULT NULL,
  `rekap_keluar` time DEFAULT NULL,
  `rekap_photomasuk` varchar(255) DEFAULT NULL,
  `status1` tinyint(2) NOT NULL DEFAULT 0,
  `rekap_photokeluar` varchar(255) DEFAULT NULL,
  `status2` tinyint(2) NOT NULL DEFAULT 0,
  `rekap_keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekap`
--

INSERT INTO `rekap` (`rekap_id`, `jadwal_id`, `karyawan_id`, `rekap_tanggal`, `rekap_masuk`, `rekap_keluar`, `rekap_photomasuk`, `status1`, `rekap_photokeluar`, `status2`, `rekap_keterangan`) VALUES
(5, 8, 9, '2022-07-17', '17:13:18', '17:13:37', '2022.07.17_10:13:21.jpg', 0, '2022.07.17_10:13:38.jpg', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rfid_code`
--

CREATE TABLE `rfid_code` (
  `id` double NOT NULL,
  `rfid_code` varchar(64) NOT NULL,
  `used` int(11) NOT NULL DEFAULT 0,
  `time_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rfid_code`
--

INSERT INTO `rfid_code` (`id`, `rfid_code`, `used`, `time_update`) VALUES
(1, 'E3E64D15', 1, '2022-07-17 10:13:10'),
(2, '43050017', 0, '2022-07-17 10:11:28'),
(3, 'A35F6817', 0, '2022-07-17 10:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `users_logs`
--

CREATE TABLE `users_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `rfid` varchar(20) NOT NULL,
  `image_url` varchar(100) NOT NULL,
  `checkindate` date NOT NULL,
  `checkintime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_logs`
--

INSERT INTO `users_logs` (`id`, `username`, `rfid`, `image_url`, `checkindate`, `checkintime`) VALUES
(1, 'Rudi', 'B23D221B', 'mages/02012021011428.jpg 	', '2022-07-09', '19:27:15'),
(2, 'Rudi', 'B23D221B', '', '2022-07-09', '19:27:28'),
(3, 'Wardana Adiaksa', 'A19E551B', '', '2022-07-09', '19:27:37'),
(4, 'Badrun Alam', 'F3C1D89A', '', '2022-07-09', '19:28:58'),
(5, 'Rudi', 'B23D221B', '', '2022-07-09', '19:50:45'),
(6, 'Wardana Adiaksa', 'A19E551B', '', '2022-07-09', '19:50:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_username` (`admin_username`);

--
-- Indexes for table `data_users`
--
ALTER TABLE `data_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `izin`
--
ALTER TABLE `izin`
  ADD PRIMARY KEY (`izin_id`),
  ADD KEY `izin karywanid to karyawanid` (`karyawan_id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`jabatan_id`),
  ADD UNIQUE KEY `jabatan_nama` (`jabatan_nama`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`jadwal_id`),
  ADD KEY `jadwal jabatanid to jabatanid` (`jabatan_id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`karyawan_id`),
  ADD UNIQUE KEY `karyawan_rfid` (`karyawan_rfid`),
  ADD UNIQUE KEY `karyawan_nik` (`karyawan_nik`),
  ADD KEY `karyawan jabatanid to jabatanid` (`jabatan_id`);

--
-- Indexes for table `libur`
--
ALTER TABLE `libur`
  ADD PRIMARY KEY (`libur_id`);

--
-- Indexes for table `rekap`
--
ALTER TABLE `rekap`
  ADD PRIMARY KEY (`rekap_id`),
  ADD KEY `rekap karyawanid to karyawanid` (`karyawan_id`),
  ADD KEY `rekapjadwalfk` (`jadwal_id`);

--
-- Indexes for table `rfid_code`
--
ALTER TABLE `rfid_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_logs`
--
ALTER TABLE `users_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_users`
--
ALTER TABLE `data_users`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `izin`
--
ALTER TABLE `izin`
  MODIFY `izin_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `jabatan_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `jadwal_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `karyawan_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `libur`
--
ALTER TABLE `libur`
  MODIFY `libur_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rekap`
--
ALTER TABLE `rekap`
  MODIFY `rekap_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rfid_code`
--
ALTER TABLE `rfid_code`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_logs`
--
ALTER TABLE `users_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `izin`
--
ALTER TABLE `izin`
  ADD CONSTRAINT `izin karywanid to karyawanid` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`karyawan_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal jabatanid to jabatanid` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`jabatan_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan jabatanid to jabatanid` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`jabatan_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rekap`
--
ALTER TABLE `rekap`
  ADD CONSTRAINT `rekap karyawanid to karyawanid` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`karyawan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rekapjadwalfk` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`jadwal_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
