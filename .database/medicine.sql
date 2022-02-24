-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2022 at 05:33 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicine`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_ad` int(3) NOT NULL COMMENT 'รหัสไอดีแอดมิน',
  `username_ad` varchar(55) NOT NULL COMMENT '	ยูเชอร์เนม',
  `password_ad` varchar(55) NOT NULL COMMENT 'รหัสผ่าน',
  `name_ad` varchar(55) NOT NULL COMMENT 'ชื่อ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_history`
--

CREATE TABLE `detail_history` (
  `id_detail_his` int(10) NOT NULL,
  `id_drug` int(5) NOT NULL,
  `item` varchar(55) NOT NULL,
  `id_oh` int(5) NOT NULL COMMENT 'รหัสประวัติการขาย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `drug_allergy`
--

CREATE TABLE `drug_allergy` (
  `id_allgy` int(11) NOT NULL COMMENT 'ไอดีการแพ้ยา',
  `detail_allgy` text NOT NULL COMMENT 'รายละเอียดการแพ้ยา	',
  `id_drug` int(5) NOT NULL COMMENT 'รหัสยาที่เเพ้',
  `id_mem` int(5) NOT NULL COMMENT '	ไอดีผู้ใช้'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `drug_information`
--

CREATE TABLE `drug_information` (
  `id_drug` int(5) NOT NULL COMMENT 'ไอดียา',
  `name_drug` varchar(55) NOT NULL COMMENT 'ชื่อยา',
  `size_drug` varchar(6) NOT NULL COMMENT '	ขนาดยา',
  `price_drug` varchar(55) NOT NULL COMMENT 'ราคายา',
  `stock` varchar(55) NOT NULL,
  `prope_durg` text NOT NULL COMMENT '	คุณสบัติการรักษา	',
  `expi_date_durg` datetime NOT NULL COMMENT 'วันหมดอายุ',
  `status` varchar(4) NOT NULL COMMENT '	0 = ลบ 1 = ปกติ	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_mem` int(11) NOT NULL,
  `name_mem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `id_oh` int(5) NOT NULL COMMENT 'รหัสไอดีประวัติ',
  `dateTime_oh` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่ซื้อ',
  `id_pma` int(5) NOT NULL COMMENT '	รหัสผู้ซื้อยา',
  `id_mem` int(5) NOT NULL COMMENT '	รหัสผู้ซื้อยา',
  `sum_pi` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacist`
--

CREATE TABLE `pharmacist` (
  `id_pma` int(5) NOT NULL COMMENT 'รหัสไอดีเภสัชกร',
  `username_pma` varchar(55) NOT NULL COMMENT 'ยูเชอร์',
  `password_pma` varchar(55) NOT NULL COMMENT 'รหัสผ่าน',
  `name_pma` varchar(55) NOT NULL COMMENT 'ชื่อ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_ad`);

--
-- Indexes for table `detail_history`
--
ALTER TABLE `detail_history`
  ADD PRIMARY KEY (`id_detail_his`),
  ADD KEY `e` (`id_drug`),
  ADD KEY `dd` (`id_oh`);

--
-- Indexes for table `drug_allergy`
--
ALTER TABLE `drug_allergy`
  ADD PRIMARY KEY (`id_allgy`),
  ADD KEY `r` (`id_mem`);

--
-- Indexes for table `drug_information`
--
ALTER TABLE `drug_information`
  ADD PRIMARY KEY (`id_drug`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_mem`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id_oh`),
  ADD KEY `sd` (`id_mem`),
  ADD KEY `d` (`id_pma`);

--
-- Indexes for table `pharmacist`
--
ALTER TABLE `pharmacist`
  ADD PRIMARY KEY (`id_pma`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_ad` int(3) NOT NULL AUTO_INCREMENT COMMENT 'รหัสไอดีแอดมิน';

--
-- AUTO_INCREMENT for table `detail_history`
--
ALTER TABLE `detail_history`
  MODIFY `id_detail_his` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drug_allergy`
--
ALTER TABLE `drug_allergy`
  MODIFY `id_allgy` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีการแพ้ยา';

--
-- AUTO_INCREMENT for table `drug_information`
--
ALTER TABLE `drug_information`
  MODIFY `id_drug` int(5) NOT NULL AUTO_INCREMENT COMMENT 'ไอดียา';

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_mem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id_oh` int(5) NOT NULL AUTO_INCREMENT COMMENT 'รหัสไอดีประวัติ';

--
-- AUTO_INCREMENT for table `pharmacist`
--
ALTER TABLE `pharmacist`
  MODIFY `id_pma` int(5) NOT NULL AUTO_INCREMENT COMMENT 'รหัสไอดีเภสัชกร';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_history`
--
ALTER TABLE `detail_history`
  ADD CONSTRAINT `dd` FOREIGN KEY (`id_oh`) REFERENCES `order_history` (`id_oh`),
  ADD CONSTRAINT `e` FOREIGN KEY (`id_drug`) REFERENCES `drug_information` (`id_drug`);

--
-- Constraints for table `drug_allergy`
--
ALTER TABLE `drug_allergy`
  ADD CONSTRAINT `r` FOREIGN KEY (`id_mem`) REFERENCES `member` (`id_mem`);

--
-- Constraints for table `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `d` FOREIGN KEY (`id_pma`) REFERENCES `pharmacist` (`id_pma`),
  ADD CONSTRAINT `sd` FOREIGN KEY (`id_mem`) REFERENCES `member` (`id_mem`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
