-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 06:27 PM
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
-- Database: `educational_center_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--
CREATE Database educational_center_db;
USE educational_center_db;


CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_room` varchar(50) DEFAULT NULL,
  `schedule` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `course_id`, `teacher_id`, `class_room`, `schedule`, `capacity`, `start_date`, `end_date`) VALUES
(2, 2, 8, 'class B', 'هر روز  3-4 pm', 30, '2026-06-18', '2026-07-11'),
(7, 1, 15, 'class B', 'هر روز از 8-12', 23, '2026-06-20', '2026-07-10'),
(8, 3, 8, 'class C', 'هر روز  3-4 pm', 35, '2026-07-03', '2026-07-11'),
(9, 6, 15, 'class A', 'روز های تاق  5-6 pm', 25, '2026-06-27', '2026-07-11');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `price`, `duration`) VALUES
(1, 'python', 'مقدماتی پایتون', 1500.00, 60),
(2, 'react', 'react zero to hero', 2000.00, 45),
(3, 'english', 'basic English', 800.00, 60),
(4, 'node js', '', 1200.00, 60),
(5, 'Programming Go language', '', 2500.00, 60),
(6, 'UX/UI', '', 1200.00, 60);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','completed','dropped') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `class_id`, `enrollment_date`, `status`) VALUES
(9, 6, 2, '2026-06-19 07:48:45', 'active'),
(11, 14, 8, '2026-06-19 07:48:58', 'active'),
(13, 12, 8, '2026-06-20 02:01:11', 'active'),
(14, 6, 9, '2026-06-20 02:04:35', 'active'),
(15, 12, 9, '2026-06-20 02:04:43', 'active'),
(16, 14, 9, '2026-06-20 02:04:49', 'active'),
(17, 17, 9, '2026-06-20 02:04:54', 'active'),
(18, 18, 9, '2026-06-20 02:05:00', 'active'),
(19, 19, 9, '2026-06-20 02:05:05', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `category` enum('food','bills','salary','rent','equipment','other') DEFAULT 'other',
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `title`, `category`, `amount`, `expense_date`, `description`, `created_at`) VALUES
(1, 'computer', 'equipment', 8500.00, '2026-06-17', 'کمپیوتر برای اداره', '2026-06-17 05:31:08'),
(2, 'رنگ کاری صنف', 'other', 3500.00, '2026-06-18', '', '2026-06-18 05:01:08');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `grade` decimal(5,2) NOT NULL,
  `exam_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `enrollment_id`, `grade`, `exam_date`) VALUES
(7, 14, 18.00, '2026-06-20'),
(8, 15, 17.00, '2026-06-20'),
(9, 16, 18.00, '2026-06-20'),
(10, 17, 18.50, '2026-06-20'),
(11, 11, 17.75, '2026-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `class_id`, `amount`, `payment_date`) VALUES
(10, 6, 9, 1200.00, '2026-06-20'),
(11, 12, 9, 1200.00, '2026-06-20'),
(12, 14, 9, 1200.00, '2026-06-20'),
(13, 17, 9, 1200.00, '2026-06-20'),
(14, 6, 2, 2000.00, '2026-06-20'),
(15, 18, 9, 1200.00, '2026-06-20'),
(16, 19, 9, 1200.00, '2026-06-20'),
(17, 14, 8, 800.00, '2026-06-20'),
(18, 6, 2, 2000.00, '2026-06-20'),
(19, 12, 8, 800.00, '2026-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','teacher','employ') NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `create_at`) VALUES
(1, 'mosa', 'mosa@gmail.com', '$2y$10$e853FcKDQYnJbGRPCtJKfO6IdcaFxY05xg/5a.YvglZBG2hd7QgPC', 'admin', '2026-06-17'),
(6, 'khalid', 'khalid@gmail.com', '$2y$10$zXjXXbgOgfn5YzFjr8cwu.CT3lDTAF11HRGqWT5IEu/xgoVD85qFS', 'student', '2026-06-17'),
(8, 'Basir  naji', 'basir@gmail.com', '$2y$10$HL3Re0bokM.0/JUu2PjLZuI9FRRZq4VmzqjB2ApsMdJeD6BAtN9xa', 'teacher', '2026-06-17'),
(9, 'JAN AGHA', 'janagha@gmail.com', '$2y$10$kxoPOZc6ms25LOL2r/CXGujTHbsHHk0lt21WAvHaweNGoEtSXhBhy', 'employ', '2026-06-17'),
(12, 'frid', 'farid@gmail.com', '$2y$10$zZl2OIpMytykMU9vrz5imOLWPZD5HBlhsd8zy0S4lX8Nc.Gm4lXhy', 'student', '2026-06-17'),
(13, 'محمد موسی مهدیار', 'mahdyar@gmail.com', '$2y$10$WV3P0g1vDWTL755I.2VZqeLSZl9nJHoG4j7jsy8Z8xe7RjjGJE2y2', 'admin', '2026-06-17'),
(14, 'رحمت الله', 'rahmat@gmail.ocm', '$2y$10$WrYs4ZVneHaAUMFATCYzuOIiB3TWT0erEKEze75FHHaPfXCanyQfG', 'student', '2026-06-18'),
(15, 'Mohammad', 'mohammad@gmail.com', '$2y$10$kwf4OEjgcpj.yvRWwGxyxeht35m87yduzSKW.fwUTcaBsRlXHadby', 'teacher', '2026-06-19'),
(17, 'haider', 'haider@gmail.com', '$2y$10$.Sryf6EKKcmzEjlnkl6Wxes2X0Bwry8hOEMvQgjRoEzIcwOzhQn6i', 'student', '2026-06-20'),
(18, 'amin', 'amin@gmail.com', '$2y$10$JtbayogMiodUFR2/sAr2yerM7kyFOAbp.Mcq4/CE.qeTPABxxEQGu', 'student', '2026-06-20'),
(19, 'karim', 'karim@gmail.com', '$2y$10$Xh5qCs2iSvoo9SaMhnwHkeitvJhSqw4iJCljlBmYqKs3F4BB5jKti', 'student', '2026-06-20'),
(20, 'محمد موسی مهدیار', 'mahdyar1@gmail.com', '$2y$10$dvhnPmu8BjbvpIKu8Pak1uHrJ79xhfZMnwRKuDe1FkVsnIEqwpLEO', 'admin', '2026-06-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
