-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Aug 15, 2023 at 03:39 PM
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
  `admin_name` varchar(255) NOT NULL,
  `isSuperAdmin` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `admin_id`, `admin_name`, `isSuperAdmin`) VALUES
(1, 'admin@admin.com', 'admin', 'Charles', b'1');

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
(1, 11, 8, 'Snr Kwame Boateng Adele Palmas', '2023-07-23 01:32:18', '2023-08-13 19:35:41', '+18177977178', 'image_64c20cc742f7d.jpg', 'Ramseyer', 1986, 'Texas, USA', 11),
(2, 12, 8, 'Snr Keneth Ohene Mantey', '2023-07-23 01:34:04', '2023-08-13 19:35:41', '+233243354079', 'image_64bd4cea755c1.jpg', 'Ramseyer', 2006, 'Obuasi, Ashanti, Ghana', 10),
(3, 12, 8, 'Eric Kwadwo Tsitsi', '2023-07-23 01:36:30', '2023-08-10 14:39:56', '+233202009046', 'image_64c20f35d763c.jpg', 'Ramseyer', 2005, 'Kumasi, Ashanti, Ghana', 5),
(23, 13, 8, 'Snr Yaw G. Ayim', '2023-07-23 01:38:07', '2023-08-10 16:17:43', '+1240-906-2033', 'image_64bd5a23db44a.jpg', 'Ramseyer', 1989, 'Bowie, Maryland, USA', 7),
(24, 13, 8, 'Snr Timothy Richard', '2023-07-23 01:40:55', '2023-08-13 19:35:41', '+233541454522', 'image_64c20efbc2e2f.jpg', 'Ramseyer', 2017, 'Kumasi, Ashanti, Ghana', 8),
(25, 14, 8, 'Snr Ebenezer Andoh Korsah', '2023-07-23 01:42:43', '2023-08-10 16:17:43', '+233257900732', 'image_64c20f27c59f3.jpg', 'Ramseyer', 2012, 'Tema, Greater Accra, Ghana', 10),
(26, 14, 8, 'Snr Clinton Owusu ', '2023-07-23 01:44:22', '2023-08-13 19:35:41', '+233542492196', 'image_64c20f148452b.jpg', 'Ramseyer', 2015, 'Kumasi, Ashanti, Ghana', 5),
(27, 15, 8, 'Snr. William Acheampong Asenso', '2023-07-23 01:46:01', '2023-08-13 19:35:41', '+233243146592', 'image_64c20ca6d8e0f.jpg', 'Ramseyer', 1990, 'Kumasi, Ashanti, Ghana', 7),
(28, 15, 8, 'Snr. Denis Ofori-Ababio', '2023-07-23 01:52:16', '2023-08-13 22:10:22', '+233555436800', 'image_64d954ce96b0a.jpg', 'Ramseyer', 1998, 'Kumasi, Ashanti, Ghana', 8),
(29, 18, 9, 'Snr. Dr. Akwasi Amponsah', '2023-08-06 14:23:34', '2023-08-06 19:05:29', '+175345367', 'image_64cface69c4ec.jpg', 'Freeman', 1977, 'U.S.A', 1),
(30, 19, 9, 'Snr. Marklord Nana Osei Banahene', '2023-08-06 14:27:44', '2023-08-06 19:05:29', '0564345678', 'image_64cfade087bcf.jpg', 'Freeman', 2011, 'Ablekuma, Greater Accra, Ghana', 1),
(31, 20, 9, 'Snr. Adubofour Agyemang', '2023-08-06 14:29:28', '2023-08-06 19:05:29', '0345678987', 'image_64cfae48ded78.jpg', 'Freeman', 2016, 'Ejisu, Ashanti, Ghana', 1),
(32, 21, 9, 'Snr. Edmund Adubofour Afrifa', '2023-08-06 14:30:40', '2023-08-15 13:01:03', '0456789092', 'image_64db770fad9a8.jpg', 'Freeman', 2016, 'Fawoade, Ashanti, Ghana', 1),
(33, 22, 9, 'Snr. Selasie Ahiable Hope', '2023-08-06 14:32:27', '2023-08-06 19:05:29', '04567876543', 'image_64cfaefb4e2f4.jpg', 'Freeman', 2007, 'Kumasi, Ashanti, Ghana', 1);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `house` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`election_id`, `election_name`, `start_date`, `end_date`, `created_at`, `updated_at`, `house`) VALUES
(8, 'RAMSEYER ELECTIONS', '2023-07-23', '2023-07-27', '2023-07-23 01:20:47', '2023-08-10 13:47:10', 'Ramseyer'),
(9, 'FREEMAN ELECTIONS', '2023-07-23', '2023-07-27', '2023-07-23 14:52:35', '2023-08-10 13:47:20', 'Freeman');

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
(12, 8, 'Vice-President', '2023-07-23 01:22:35', '2023-08-10 14:37:29'),
(13, 8, 'Secretary', '2023-07-23 01:22:56', '2023-07-23 01:22:56'),
(14, 8, 'Organizer', '2023-07-23 01:23:13', '2023-07-23 01:23:13'),
(15, 8, 'Financial Controller', '2023-07-23 01:23:56', '2023-07-23 01:23:56'),
(18, 9, 'President', '2023-07-23 14:54:12', '2023-07-23 14:54:12'),
(19, 9, 'Vice-President', '2023-08-06 14:15:18', '2023-08-06 14:15:18'),
(20, 9, 'Secretary', '2023-08-06 14:15:55', '2023-08-06 14:15:55'),
(21, 9, 'Finanacial Controller', '2023-08-06 14:16:13', '2023-08-06 14:16:13'),
(22, 9, 'Organiser', '2023-08-06 14:16:54', '2023-08-06 14:16:54');

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
  `location` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `election_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

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
