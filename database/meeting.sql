-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2020 at 12:21 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meeting`
--

-- --------------------------------------------------------

--
-- Table structure for table `fingerprint_machine`
--

CREATE TABLE `fingerprint_machine` (
  `id` int(3) NOT NULL,
  `machine_id` varchar(15) NOT NULL,
  `machine_code` varchar(15) NOT NULL,
  `max_id_numbers` int(4) NOT NULL DEFAULT 127,
  `group_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fingerprint_machine`
--

INSERT INTO `fingerprint_machine` (`id`, `machine_id`, `machine_code`, `max_id_numbers`, `group_id`) VALUES
(1, 'FTI-TIF-01', 'nodemcuv5', 127, 1),
(2, 'FTI-TP-01', 'nodemcuv5', 127, 11),
(3, 'FTI-TKIM-01', 'nodemcuv5', 127, 2),
(4, 'FTI-TE-01', 'nodemcuv5', 127, 3),
(6, 'FTI-TIND-01', 'nodemcuv5', 127, 12);

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`id`, `member_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 3),
(6, 5, 1),
(9, 9, 2),
(11, 11, 1),
(12, 12, 1),
(38, 1, 0),
(41, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `meeting_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `meeting_name` char(50) NOT NULL,
  `meeting_date` date NOT NULL,
  `meeting_start` time NOT NULL,
  `meeting_end` time NOT NULL,
  `meeting_place` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`meeting_id`, `group_id`, `meeting_name`, `meeting_date`, `meeting_start`, `meeting_end`, `meeting_place`) VALUES
(47, 1, 'Perkuliahan sem genap 20/21', '2019-07-06', '10:33:00', '11:50:00', 'Yogyakarta'),
(48, 12, 'Persiapan PKM', '2019-07-04', '11:00:00', '15:55:00', 'Yogyakarta'),
(49, 2, 'Yudisium', '2019-06-29', '11:20:00', '12:40:00', 'Yogyakarta'),
(50, 2, 'Perkuliahan sem genap 20/21', '2019-07-04', '11:36:00', '13:00:00', 'Yogyakarta'),
(51, 3, 'Lab. Riset', '2019-05-31', '17:50:00', '19:00:00', 'Yogyakarta'),
(52, 1, 'Revisi Kurikulum', '2019-08-01', '13:55:00', '14:15:00', 'Yogyakarta'),
(76, 1, 'Ruubah', '2020-09-09', '12:15:00', '13:30:00', 'Ruang Prodi Teknik Informatika'),
(77, 1, 'contoh metting', '2020-10-05', '09:30:00', '10:30:00', 'Ruang Prodi Teknik kimia'),
(78, 1, 'asdasd', '2020-10-01', '23:54:00', '23:54:00', 'Ruang Prodi Teknik Informatika'),
(79, 1, 'contoh meeting', '2020-10-02', '00:30:00', '01:00:00', 'Ruang Prodi Teknik kimia'),
(85, 1, 'contoh metting', '2020-10-22', '02:15:00', '03:15:00', 'Ruang Prodi Teknik Informatika'),
(86, 3, 'ini baru lo ya', '2020-10-26', '20:15:00', '22:00:00', 'Ruang Prodi Teknik Informatika'),
(87, 1, 'Migrate to CI', '2020-12-01', '03:56:00', '05:00:00', 'Ruang Prodi Teknik Informatika'),
(88, 1, 'Migrate to CI', '2020-10-31', '04:15:00', '05:00:00', 'Ruang Prodi Teknik Informatika'),
(89, 1, 'Done', '2020-10-31', '05:51:00', '07:00:00', 'Ruang Prodi Teknik Informatika'),
(90, 2, 'Migrate to CI', '2020-10-31', '12:15:00', '13:15:00', 'Ruang Prodi Teknik kimia'),
(91, 1, 'contoh metting', '2020-10-31', '06:07:00', '06:45:00', 'Ruang Prodi Teknik Informatika'),
(92, 1, 'contoh metting', '2020-10-31', '06:45:00', '07:15:00', 'Ruang Prodi Teknik Informatika'),
(94, 1, 'test done for create', '2020-10-31', '06:30:00', '08:00:00', 'Ruang Prodi Teknik Informatika'),
(101, 1, 'Last', '2020-11-13', '06:30:00', '08:00:00', 'Ruang Prodi Teknik Elektro');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_attendance`
--

CREATE TABLE `meeting_attendance` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `member_name` char(50) NOT NULL,
  `status` enum('Tidak hadir','Hadir','','') NOT NULL DEFAULT 'Tidak hadir',
  `attendance_time` varchar(20) DEFAULT '00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meeting_attendance`
--

INSERT INTO `meeting_attendance` (`id`, `meeting_id`, `member_id`, `group_id`, `member_name`, `status`, `attendance_time`) VALUES
(58, 76, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(59, 77, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(60, 78, 12, 1, 'gema', 'Tidak hadir', '00:00:00'),
(61, 79, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(62, 85, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(63, 85, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(64, 85, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(65, 85, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(66, 86, 4, 3, 'Luthfiantoro', 'Tidak hadir', '00:00:00'),
(67, 86, 4, 3, 'Luthfiantoro', 'Tidak hadir', '00:00:00'),
(68, 86, 4, 3, 'Luthfiantoro', 'Tidak hadir', '00:00:00'),
(69, 86, 4, 3, 'Luthfiantoro', 'Tidak hadir', '00:00:00'),
(70, 88, 5, 1, 'Luthfiantoroo', 'Tidak hadir', '00:00:00'),
(71, 89, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(72, 92, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(73, 92, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(75, 94, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(77, 94, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(78, 94, 5, 1, 'Luthfiantoroo', 'Tidak hadir', '00:00:00'),
(79, 94, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(88, 101, 1, 1, 'arfian', 'Tidak hadir', '00:00:00'),
(89, 101, 2, 1, 'ardli wibowo', 'Tidak hadir', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_groups`
--

CREATE TABLE `meeting_groups` (
  `group_id` int(3) NOT NULL,
  `group_name` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meeting_groups`
--

INSERT INTO `meeting_groups` (`group_id`, `group_name`) VALUES
(0, 'Prodi Teknologi Pangan'),
(1, 'Prodi Informatika'),
(2, 'Prodi Kimia'),
(3, 'Prodi Elektro'),
(11, 'Prodi Teknologi Pangan'),
(12, 'Teknik Industri');

-- --------------------------------------------------------

--
-- Table structure for table `membera`
--

CREATE TABLE `membera` (
  `member_name` varchar(60) NOT NULL,
  `member_email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `member_name` char(60) NOT NULL,
  `member_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `member_name`, `member_email`) VALUES
(1, 'arfian', 'arfyan.vira@gmail.com'),
(2, 'ardli wibowo', 'ardliwiebowo23@gmail.com'),
(3, 'nataya', 'arnataya8@gmail.com'),
(4, 'Lula', 'mtciemail@gmail.com'),
(5, 'Luthfiantoroo', 'muhammad.luthfi1ml@gmail.com'),
(9, 'Dwie Yulieanto Saputro', 'unduhanim@gmail.com'),
(11, 'Ardiansyah', 'ardiansyah@tif.uad.ac.id'),
(12, 'gema', 'gemaantikahr@gmail.com'),
(31, '', ''),
(32, 'saya', 'saya@gmail.com'),
(33, 'SSSA', 'Array@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `member_fingerprint`
--

CREATE TABLE `member_fingerprint` (
  `id` int(11) NOT NULL,
  `fingerprint_machine_id` varchar(10) NOT NULL,
  `member_id` int(11) NOT NULL,
  `fingerprint_code` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_fingerprint`
--

INSERT INTO `member_fingerprint` (`id`, `fingerprint_machine_id`, `member_id`, `fingerprint_code`) VALUES
(1, 'FTI-TIF-01', 1, 2),
(2, 'FTI-TIF-01', 1, 1),
(6, 'FTI-TIF-01', 2, 3),
(7, 'FTI-TE-01', 4, 10),
(8, 'FTI-TE-01', 3, 1),
(9, 'FTI-TE-01', 3, 3),
(10, 'FTI-TE-01', 3, 5),
(11, 'FTI-TE-01', 4, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fingerprint_machine`
--
ALTER TABLE `fingerprint_machine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`meeting_id`);

--
-- Indexes for table `meeting_attendance`
--
ALTER TABLE `meeting_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_groups`
--
ALTER TABLE `meeting_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `member_fingerprint`
--
ALTER TABLE `member_fingerprint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fingerprint_machine_id` (`fingerprint_machine_id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fingerprint_machine`
--
ALTER TABLE `fingerprint_machine`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `meeting_attendance`
--
ALTER TABLE `meeting_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `member_fingerprint`
--
ALTER TABLE `member_fingerprint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_id` FOREIGN KEY (`group_id`) REFERENCES `meeting_groups` (`group_id`),
  ADD CONSTRAINT `member_belongsto_group` FOREIGN KEY (`group_id`) REFERENCES `meeting_groups` (`group_id`),
  ADD CONSTRAINT `member_group` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `member_fingerprint`
--
ALTER TABLE `member_fingerprint`
  ADD CONSTRAINT `fingerprint_machine` FOREIGN KEY (`fingerprint_machine_id`) REFERENCES `fingerprint_machine` (`machine_id`),
  ADD CONSTRAINT `member_id` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
