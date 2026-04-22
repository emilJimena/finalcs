-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2026 at 09:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `school`;
USE `school`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `program_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `years` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`program_id`, `code`, `title`, `years`) VALUES
(1, 'BS-IT', 'Bachelor of Science in Information Technology', 4),
(2, 'BS-EDUC', 'Bachelor of Science in Education', 4),
(3, 'BS-NURS', 'Bachelor of Science in Nursing', 4),
(4, 'AA-BUS', 'Associate of Arts in Business', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `code`, `title`, `unit`) VALUES
(1, 'MATH101', 'Basic Mathematics', 3),
(2, 'ENG101', 'English Language', 4),
(3, 'SCI101', 'General Science', 3),
(4, 'HIST101', 'History of the World', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_type` enum('admin','staff','teacher','student') NOT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `account_type`, `created_on`, `created_by`, `updated_on`, `updated_by`) VALUES
(1, 'admin', '$2y$10$HYA7XLPz.gz6gFDu0i.dhOXsXqhs.ul.aAu.CKP1Bnl1al36a5gT6', 'admin', '2026-02-03 16:09:50', 1, '2026-02-24 16:43:43', 1),
(2, 'staff1', '$2y$10$iWe96L9/ti65cxJz1Cpjpev4tPDEXKwD9oNuUTFhhWVS7M1pZE01W', 'staff', '2026-02-03 16:09:50', 1, '2026-02-03 16:09:50', 1),
(3, 'teacher1', '$2y$10$iWe96L9/ti65cxJz1Cpjpev4tPDEXKwD9oNuUTFhhWVS7M1pZE01W', 'teacher', '2026-02-03 16:09:50', 1, '2026-02-03 16:09:50', 1),
(4, 'student1', '$2y$10$iWe96L9/ti65cxJz1Cpjpev4tPDEXKwD9oNuUTFhhWVS7M1pZE01W', 'student', '2026-02-03 16:09:50', 1, '2026-02-03 16:09:50', 1),
(5, 'emil', '$2y$10$graKtijHkiOtkFl748RgtuStUsCb0fWrv1OhNLCkdnfThNqu7sSOW', 'student', '2026-02-03 16:11:13', 1, '2026-02-03 16:15:24', 5),
(6, 'student2', '$2y$10$vw57sGcOCpTA3ehZJKpuquRQRIekKoeMstNBYw8WgdYAFu3ZmoDu2', 'student', '2026-02-24 15:57:44', 1, '2026-02-24 15:57:44', 1),
(7, 'ivan', '$2y$10$m9gXCWHQIRGIGm5XdrLnReYzpgPIO28MCfiAyUQcozui6W1ALGoMG', 'staff', '2026-02-24 16:07:36', 1, '2026-02-24 16:07:36', 1),
(8, 'gab', '$2y$10$vZCIh2dckmTDZyuUdkX9GOlmJlPCJtZR.KT6VWx3WkzT6IWx1yMK6', 'teacher', '2026-02-24 16:07:47', 1, '2026-02-24 16:07:47', 1),
(9, 'jimena', '$2y$10$cH/uQsIXBOUv3BrpoOV/d.RoOp4WILAjvpJ.h2QXKAPoZ07AVIb1i', 'student', '2026-02-24 16:24:31', 1, '2026-02-24 16:24:31', 1),
(10, 'anthony', '$2y$10$nnB4BxuzZ0SJ7OF9P9TYHOA56V31N7aowMg9KsbOE1JIBASYo.Mde', 'student', '2026-02-24 16:25:54', 1, '2026-02-24 16:28:01', 10),
(11, 'ivan1', '$2y$10$/ieS9k0l2ebJ4wpNAkTNJeyosp02swrZ6UzQSPrfAyBxsxcY/4g92', 'student', '2026-02-24 16:40:47', 1, '2026-02-24 16:41:28', 1),
(12, 'anthony1', '$2y$10$Ff0p7aVFbMc1uouJkd.ep.ixBLpUaGt7xESgpy0tFVA3H51va/dme', 'student', '2026-02-26 16:18:55', 1, '2026-02-26 16:19:32', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`program_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
