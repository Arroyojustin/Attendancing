-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 06:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_history`
--

CREATE TABLE `action_history` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `action_history`
--

INSERT INTO `action_history` (`id`, `admin_id`, `action`, `description`, `created_at`) VALUES
(1, NULL, 'Added', 'alias, albert D (Email: abetalias@edu.ph) added as coordinator.', '2024-11-14 13:37:56'),
(2, NULL, 'Added', 'Bollodo, Lovelly rose G (Email: coor@edu.php) added as coordinator.', '2024-11-24 21:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_no` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('Present','Absent','Excused') NOT NULL,
  `attendance_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_no`, `name`, `status`, `attendance_date`) VALUES
(1, '1-210134', '', 'Present', '2024-12-04'),
(2, '1-190009', 'Leif mclean Nazario', 'Present', '2024-12-04'),
(3, '1-190009', 'Leif mclean Nazario', 'Absent', '2024-12-04'),
(4, '1-190009', 'Leif mclean Nazario', 'Present', '2024-12-04');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(50) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `acads_progress` decimal(5,2) DEFAULT 0.00,
  `training_progress` decimal(5,2) DEFAULT 0.00,
  `attendance_status` enum('present','absent','excused') DEFAULT 'present'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `name`, `position`, `status`, `acads_progress`, `training_progress`, `attendance_status`) VALUES
(2, 14, 'justin randolf arroyo', 'forward', 'active', 55.00, 44.00, 'present'),
(3, 38, 'Leif mclean Nazario', 'Setter', 'inactive', 0.00, 0.00, 'present');

-- --------------------------------------------------------

--
-- Table structure for table `training_sessions`
--

CREATE TABLE `training_sessions` (
  `id` int(11) NOT NULL,
  `training_date` date NOT NULL,
  `training_time` varchar(50) NOT NULL,
  `sport_type` enum('basketball','volleyball') NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_sessions`
--

INSERT INTO `training_sessions` (`id`, `training_date`, `training_time`, `sport_type`, `location`) VALUES
(1, '2024-12-05', '4:00PM', 'basketball', 'Asiatech Squadrangle');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `student_no` varchar(50) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `bmi` decimal(4,2) DEFAULT NULL,
  `bloodtype` enum('A','B','AB','O') DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','coordinator','student','coach') NOT NULL DEFAULT 'student',
  `gender` enum('male','female','other') DEFAULT NULL,
  `civil_status` enum('single','married','divorced','widowed') DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `sports_type` enum('basketball','volleyball') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `middle_initial`, `student_no`, `weight`, `height`, `bmi`, `bloodtype`, `phone_no`, `email`, `password`, `user_type`, `gender`, `civil_status`, `profile_photo`, `sports_type`) VALUES
(12, 'Lleve', 'Shelalin', '', '1-210056', 60.00, 144.78, 28.90, 'O', '09068377106', 'admin@edu.ph', '$2y$10$2ey6fmYSA4xnxIPVp2qRG.Gqt1k1BdGNF7fvBR1835GpQfSSABtVq', 'admin', 'female', 'single', NULL, NULL),
(14, 'Arroyo', 'Justin randolf', 'M', '1-210134', 57.00, 167.00, 20.40, 'O', '0936797034', '1-210134@edu.ph', '$2y$10$7lG2fuuKookVEbUHcV9WFO4/hLLDgnvNCq7G10ZCyxXdntjflRqGa', 'student', 'male', 'single', NULL, 'basketball'),
(34, 'Perez', 'Jerome', NULL, 'N/A', NULL, NULL, NULL, NULL, '09068377106', 'coor@edu.ph', '$2y$10$xsE1UXxac8BNLHisq/RGU.Y8pC8EB3USeGAgN14aFbFI6AMKXp2KS', 'coordinator', 'female', 'single', NULL, NULL),
(38, 'Nazario', 'Leif mclean', 'R', '1-190009', 55.00, 168.00, 19.50, 'A', '09917269833', '1-190009@edu.ph', '$2y$10$Q6RAIYan1Kq4UZJQJ81ZruYxcIFPpnIr2A9/UDIaGHA9n0mo5nYj.', 'student', 'male', NULL, NULL, 'volleyball'),
(39, 'Pablo', 'Lucas', '', '', NULL, NULL, NULL, NULL, '09369007677', 'coach@edu.ph', '$2y$10$9yuaJq1dt/j0t/sXTuWH9ePA53nPkhuCInZZeb76GCFNP0qTlgqJu', 'coach', 'male', NULL, NULL, 'basketball'),
(46, 'Hernandez', 'Arnel', '', NULL, NULL, NULL, NULL, NULL, '099999999', 'vcoach@edu.ph', '$2y$10$sHWYwtAe3BBRgois4yPJq.7q/4BqEs5P9aHV.MXEC8AekrmrBW62e', 'coach', 'male', NULL, NULL, 'volleyball'),
(55, 'Alias', 'Albert', 'D', '1-210153', NULL, NULL, NULL, NULL, '988888888', '1-210152@edu.ph', '$2y$10$yQowXLkVXuTYbpX6/MhArOch.AcFAtd6Xq6nrmzVZWmhqVtUYVGvS', 'student', 'male', NULL, NULL, 'basketball');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action_history`
--
ALTER TABLE `action_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_no` (`student_no`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `training_sessions`
--
ALTER TABLE `training_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_no` (`student_no`),
  ADD KEY `idx_student_no` (`student_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_history`
--
ALTER TABLE `action_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `training_sessions`
--
ALTER TABLE `training_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `action_history`
--
ALTER TABLE `action_history`
  ADD CONSTRAINT `action_history_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_users` FOREIGN KEY (`student_no`) REFERENCES `users` (`student_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_no` FOREIGN KEY (`student_no`) REFERENCES `users` (`student_no`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_students_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
