-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Jul 27, 2023 at 08:42 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amanfoo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `admin_id` varchar(100) NOT NULL,
  `admin_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `admin_id`, `admin_name`) VALUES
(1, 'admin@admin.com', 'admin', 'Charles');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `candidate_id` int(11) NOT NULL,
  `position_id` int(11) DEFAULT NULL,
  `election_id` int(11) DEFAULT NULL,
  `candidate_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `candidate_phone` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `candidate_house` varchar(255) DEFAULT NULL,
  `candidate_yeargroup` int(11) DEFAULT NULL,
  `candidate_class` varchar(255) DEFAULT NULL,
  `votes_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`candidate_id`, `position_id`, `election_id`, `candidate_name`, `created_at`, `updated_at`, `candidate_phone`, `photo`, `candidate_house`, `candidate_yeargroup`, `candidate_class`, `votes_count`) VALUES
(1, 11, 8, 'Snr Kwame Boateng Adele Palmas', '2023-07-23 01:32:18', '2023-07-27 06:20:55', '+18177977178', 'image_64c20cc742f7d.jpg', 'Ramseyer', 1986, 'Texas, USA', 3),
(2, 12, 8, 'Snr Keneth Ohene Mantey', '2023-07-23 01:34:04', '2023-07-24 19:28:03', '+233243354079', 'image_64bd4cea755c1.jpg', 'Ramseyer', 2006, 'Obuasi Municipal, Ashanti', 3),
(3, 12, 8, 'Eric Kwadwo Tsitsi', '2023-07-23 01:36:30', '2023-07-27 06:31:17', '+233202009046', 'image_64c20f35d763c.jpg', 'Ramseyer', 2005, 'Kumasi, GH', 3),
(23, 13, 8, 'Snr Yaw G Ayim', '2023-07-23 01:38:07', '2023-07-23 19:30:30', '+1240-906-2033', 'image_64bd5a23db44a.jpg', 'Ramseyer', 1989, 'Bowie, MD', 2),
(24, 13, 8, 'Snr Timothy Richard', '2023-07-23 01:40:55', '2023-07-27 06:30:19', '+233541454522', 'image_64c20efbc2e2f.jpg', 'Ramseyer', 2017, 'Kumasi, Ghana', 4),
(25, 14, 8, 'Snr Ebenezer Andoh Korsah', '2023-07-23 01:42:43', '2023-07-27 06:31:03', '+233257900732', 'image_64c20f27c59f3.jpg', 'Ramseyer', 2012, 'Tema, GH', 4),
(26, 14, 8, 'Snr Clinton Owusu ', '2023-07-23 01:44:22', '2023-07-27 06:30:44', '+233542492196', 'image_64c20f148452b.jpg', 'Ramseyer', 2015, 'Kumasi, Ghana', 2),
(27, 15, 8, 'Snr. William Acheampong Asenso', '2023-07-23 01:46:01', '2023-07-27 06:20:22', '+233243146592', 'image_64c20ca6d8e0f.jpg', 'Ramseyer', 1990, 'Kumasi', 3),
(28, 15, 8, 'Snr. Denis Ofori Ababio', '2023-07-23 01:52:16', '2023-07-23 22:05:04', '+233555436800', 'image_64bd5bf9c1aed.jpg', 'Ramseyer', 1998, 'Kumasi, Ghana', 3);

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE `elections` (
  `election_id` int(11) NOT NULL,
  `election_name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`election_id`, `election_name`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(8, 'RHOSA ELECTIONS', '2023-07-23', '2023-07-27', '2023-07-23 01:20:47', '2023-07-23 01:20:47'),
(9, 'FHOSA ELECTIONS', '2023-07-23', '2023-07-27', '2023-07-23 14:52:35', '2023-07-23 14:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `election_id` int(11) DEFAULT NULL,
  `position_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `election_id`, `position_name`, `created_at`, `updated_at`) VALUES
(11, 8, 'President', '2023-07-23 01:21:47', '2023-07-23 01:21:47'),
(12, 8, 'Vice President', '2023-07-23 01:22:35', '2023-07-23 01:22:35'),
(13, 8, 'Secretary', '2023-07-23 01:22:56', '2023-07-23 01:22:56'),
(14, 8, 'Organizer', '2023-07-23 01:23:13', '2023-07-23 01:23:13'),
(15, 8, 'Financial Controller', '2023-07-23 01:23:56', '2023-07-23 01:23:56'),
(18, 9, 'President', '2023-07-23 14:54:12', '2023-07-23 14:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `voter_id` varchar(20) DEFAULT NULL,
  `election_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `house`, `voter_id`, `election_id`, `photo`, `created_at`, `updated_at`, `location`) VALUES
(20, 'Andrews Asare', 'asareandrews44@gmail.com', 'Ramseyer', 'H50mKS8', 8, 'image_64bc927daf834.jpg', '2023-07-23 02:37:49', '2023-07-23 02:38:31', 'Sefwi Bekwai'),
(21, 'Charles Owusu', 'charlesowusubih@gmail.com', 'Ramseyer', 'zCOEqQ8', 8, 'image_64bd36de8cef0.jpg', '2023-07-23 14:19:10', '2023-07-24 19:28:03', 'Tema, Ghana'),
(22, 'Charles Owusu', 'bihcharles2004@gmail.com', 'Ramseyer', 'f74nsx8', 8, 'image_64bd38e12baf2.jpg', '2023-07-23 14:27:45', '2023-07-23 14:31:13', 'Tarkwa, Ghana'),
(23, 'Charles Owusu', 'charlesbih@gmail.com', 'Ramseyer', '9ZkQ0v8', 8, 'image_64bd7a3404416.jpg', '2023-07-23 19:06:28', '2023-07-23 19:06:28', 'Sefwi Bekwai, Ghana'),
(24, 'Charles Owusu Bih', 'owusubih@gmail.com', 'Ramseyer', 'ylmJt48', 8, 'image_64bd7e8a77508.jpg', '2023-07-23 19:24:58', '2023-07-23 19:30:30', 'Sefwi Bekwai, Ghana'),
(25, 'Nana Osei', 'nanaosei@gmail.com', 'Ramseyer House', 'UC4Nlp8', 8, 'image_64bda173233e0.jpg', '2023-07-23 21:53:55', '2023-07-23 22:05:05', 'Sefwi Bekwai, Ghana');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vote_id`, `user_id`, `candidate_id`, `created_at`, `updated_at`) VALUES
(64, 20, 2, '2023-07-23 02:38:31', '2023-07-23 02:38:31'),
(65, 20, 24, '2023-07-23 02:38:31', '2023-07-23 02:38:31'),
(66, 20, 25, '2023-07-23 02:38:31', '2023-07-23 02:38:31'),
(67, 20, 28, '2023-07-23 02:38:31', '2023-07-23 02:38:31'),
(68, 22, 1, '2023-07-23 14:31:13', '2023-07-23 14:31:13'),
(69, 22, 2, '2023-07-23 14:31:13', '2023-07-23 14:31:13'),
(70, 22, 23, '2023-07-23 14:31:13', '2023-07-23 14:31:13'),
(71, 22, 25, '2023-07-23 14:31:13', '2023-07-23 14:31:13'),
(72, 22, 27, '2023-07-23 14:31:13', '2023-07-23 14:31:13'),
(73, 24, 3, '2023-07-23 19:30:30', '2023-07-23 19:30:30'),
(74, 24, 23, '2023-07-23 19:30:30', '2023-07-23 19:30:30'),
(75, 24, 25, '2023-07-23 19:30:30', '2023-07-23 19:30:30'),
(76, 24, 28, '2023-07-23 19:30:30', '2023-07-23 19:30:30'),
(77, 25, 1, '2023-07-23 22:05:04', '2023-07-23 22:05:04'),
(78, 25, 3, '2023-07-23 22:05:04', '2023-07-23 22:05:04'),
(79, 25, 24, '2023-07-23 22:05:04', '2023-07-23 22:05:04'),
(80, 25, 26, '2023-07-23 22:05:04', '2023-07-23 22:05:04'),
(81, 25, 28, '2023-07-23 22:05:04', '2023-07-23 22:05:04'),
(82, 21, 2, '2023-07-24 19:28:03', '2023-07-24 19:28:03'),
(83, 21, 24, '2023-07-24 19:28:03', '2023-07-24 19:28:03'),
(84, 21, 25, '2023-07-24 19:28:03', '2023-07-24 19:28:03'),
(85, 21, 27, '2023-07-24 19:28:03', '2023-07-24 19:28:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`candidate_id`),
  ADD KEY `candidates_ibfk_1` (`position_id`),
  ADD KEY `candidates_ibfk_2` (`election_id`);

--
-- Indexes for table `elections`
--
ALTER TABLE `elections`
  ADD PRIMARY KEY (`election_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `election_id` (`election_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `users_ibfk_1` (`election_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD KEY `votes_ibfk_1` (`user_id`),
  ADD KEY `votes_ibfk_2` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `election_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `candidates_ibfk_2` FOREIGN KEY (`election_id`) REFERENCES `elections` (`election_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `elections` (`election_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `elections` (`election_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`candidate_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
