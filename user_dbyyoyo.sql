-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 09:04 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `roll_no` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('Present','Absent') DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `roll_no`, `name`, `date`, `status`, `email`, `subject`) VALUES
(134, '27', '5', 'ravi prakash jangid ', '2025-05-17', 'Present', 'rk@gmail.com', 'physics'),
(135, '28', '34', 'raghav kumar', '2025-05-17', 'Present', 'rkk@gmail.com', 'physics'),
(136, '27', '5', 'ravi prakash jangid ', '2025-05-17', 'Present', 'rk@gmail.com', 'chemistry'),
(137, '28', '34', 'raghav kumar', '2025-05-17', 'Present', 'rkk@gmail.com', 'chemistry'),
(138, '27', '5', 'ravi prakash jangid ', '2025-05-19', 'Present', 'rk@gmail.com', 'subjects'),
(139, '29', '34', 'yogesh', '2025-05-19', 'Present', 'bji16886@gmail.com', 'subjects'),
(140, '30', '7 ', 'Shubham', '2025-05-19', 'Present', 'bji16886@gmail.com', 'subjects'),
(141, '29', '34', 'yogesh', '2025-05-20', 'Present', 'bji16886@gmail.com', 'math'),
(142, '30', '7 ', 'Shubham', '2025-05-20', 'Present', 'bji16886@gmail.com', 'math'),
(143, '31', '5', 'ravi prakash jangid ', '2025-05-20', 'Present', 'rk@gmail.com', 'math'),
(144, '29', '34', 'yogesh', '2025-05-20', 'Present', 'bji16886@gmail.com', 'chemistry'),
(145, '30', '7 ', 'Shubham', '2025-05-20', 'Present', 'bji16886@gmail.com', 'chemistry'),
(146, '31', '5', 'ravi prakash jangid ', '2025-05-20', 'Present', 'rk@gmail.com', 'chemistry');

-- --------------------------------------------------------

--
-- Table structure for table `hidden_students`
--

CREATE TABLE `hidden_students` (
  `id` int(11) NOT NULL,
  `roll` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `enrollment_no` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `message`, `created_at`) VALUES
(18, 'holiday ', 'I declare that tommorrow is holiday', '2025-05-15 09:33:05'),
(19, 'holiday', 'kal ki chutti h ', '2025-05-20 09:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `roll` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `enrollment_no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `roll`, `name`, `branch`, `semester`, `enrollment_no`, `email`, `phone`) VALUES
(30, '7 ', 'Shubham', 'cs', '4', '45435857', 'bji16886@gmail.com', '06350437805'),
(31, '5', 'ravi prakash jangid ', 'cs', '6', '23453643', 'rk@gmail.com', '6350061427'),
(32, '37', 'ravi kumar', 'cs ', '6', '2022/0008', 'jangidravi2117@gmail.com', '6350061427'),
(33, '34', 'yogesh', 'cs', '6', '3943875', 'bji16886@gmail.com', '06350437806');

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(2, 'Shubham ', 'rowdyji6350@gmail.com', '$2y$10$/sEBda8d30k5XiuDjyHTv.u/J3TH3zdftUgv5zP3LMQlhG7CkixvW', 'admin'),
(3, 'yogesh', 'yk@gmail.com', '$2y$10$ZG/yrdILBVFXzzd.qwbGK.NOABwJCqPXkcgpyHwuWU4xjAr7FUHse', 'admin'),
(6, 'devendra', 'dk@gmail.com', '$2y$10$ZX42V1FKlOFfxdklIk3C8OlrTdLG0Vzs5zNH77jj0dsmJt9taI7Ty', 'faculty'),
(12, 'Shubham ', 'bji16886@gmail.com', '$2y$10$KKO.2py.hhK6MJ7PXSrAfewUQZNQ0R2iegX7uMkW3IxpLuKTb51ey', 'faculty'),
(15, 'Shubham ', 'sr@gmail.com', '$2y$10$we8rAiiPFfBQ714OdtAJquhl9dzrr73lmZYnZ2vY4w.95RitauJI6', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hidden_students`
--
ALTER TABLE `hidden_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `hidden_students`
--
ALTER TABLE `hidden_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
