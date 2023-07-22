-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Jul 22, 2023 at 05:09 AM
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
(4, 3, 1, 'Asamoah Kofi', '2023-07-18 08:46:42', '2023-07-20 16:08:50', '+2335567344', 'image_64b83334c41e4.jpeg', 'Peerson HOuse', 20055, 'Accra, Ghana', 5),
(9, 2, 1, 'Bediako Yaw', '2023-07-18 10:47:58', '2023-07-20 16:08:50', '05597171234', 'image2.jpg', 'Serwaa', 1996, 'Texas, USA', 70),
(12, 2, 1, 'Meander Gee', '2023-07-19 22:38:11', '2023-07-20 16:08:50', '0556558655', 'image_64b865d3b5021.jpg', 'Peerson House', 1998, 'Paris, France', 30),
(13, 7, 2, 'Yaw Bih', '2023-07-20 05:45:08', '2023-07-20 16:08:50', '0242155123', 'image_64b8c9e400c0c.jpg', 'Peerson', 1995, 'Kumasi, Ghana', 0),
(14, 7, 2, 'Kwame Suarez', '2023-07-20 05:51:22', '2023-07-20 16:08:50', '0554378966', 'image_64b8cb5ab236b.jpg', 'Aggrey House', 2017, 'Tarkwa, Ghana', 0);

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
(1, 'Ramseyer Executive Election', '2023-07-18', '2023-07-25', '2023-07-18 01:49:44', '2023-07-18 01:49:44'),
(2, 'Aggrey Executive Election', '2023-07-18', '2023-07-26', '2023-07-18 01:50:30', '2023-07-18 01:50:30'),
(3, 'Butler House Elections', '2023-07-18', '2023-07-23', '2023-07-18 09:23:14', '2023-07-18 09:24:43'),
(6, 'Aggrey', '2023-07-18', '2023-07-23', '2023-07-18 09:29:26', '2023-07-18 09:29:26');

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
(2, 1, 'Organiser', '2023-07-18 08:42:25', '2023-07-18 08:42:25'),
(3, 1, 'Vice President', '2023-07-18 08:42:25', '2023-07-18 08:42:25'),
(7, 2, 'President', '2023-07-20 05:44:06', '2023-07-20 05:44:06');

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
  `candidate_voted_for_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `house`, `voter_id`, `election_id`, `photo`, `created_at`, `updated_at`, `candidate_voted_for_id`, `location`) VALUES
(1, 'Owusu Bih', 'bihcharles2004@gmail.com', 'Ramseyer', 'X4H5RAMHSE', 1, 'image1.jpg', '2023-07-18 08:44:28', '2023-07-20 03:31:24', 12, NULL),
(3, 'Owusu Karl', 'bihcharles2004@gmail.com', 'Ramseyer', 'X4H5RAMHSE', 1, 'image1.jpg', '2023-07-18 08:44:28', '2023-07-20 03:31:24', 9, NULL),
(4, 'Owusu', 'bihcharles2004@gmail.com', 'Ramseyer', 'X4H5RAMHSE', 1, 'image1.jpg', '2023-07-18 08:44:28', '2023-07-20 03:31:24', 9, NULL),
(5, 'yaw kwame', 'bihcharles2004@gmail.com', 'Ramseyer', 'X4H5RAMHSE', 1, 'image1.jpg', '2023-07-18 08:44:28', '2023-07-20 03:31:24', 9, NULL),
(6, 'chris', 'bihcharles2004@gmail.com', 'Ramseyer', 'X4H5RAMHSE', 1, 'image1.jpg', '2023-07-18 08:44:28', '2023-07-20 03:31:24', 12, NULL),
(7, 'Asare Edwin', 'bihcharles2004@gmail.com', 'Ramseyer', 'X4H5RAMHSE', 1, 'image1.jpg', '2023-07-18 08:44:28', '2023-07-20 03:31:24', 9, NULL),
(8, 'Charles Karl', 'charlesbih@gmail.com', 'Ramseyer House', NULL, 6, 'image_64b9727746af9.jpg', '2023-07-20 17:44:23', '2023-07-20 17:44:23', NULL, 'Accra, Ghana'),
(9, 'Rendosland Agyapong', 'charlesdd@gg.com', 'Ramseyer', NULL, 2, 'image_64b97c77eebd3.jpg', '2023-07-20 18:27:03', '2023-07-20 18:27:03', NULL, 'Kumasi, Ghana'),
(10, 'Kwame Bih', 'clifford@gmail.com', 'Butler', NULL, 2, 'image_64b97ce7163d9.jpg', '2023-07-20 18:28:55', '2023-07-20 18:28:55', NULL, 'Tarkwa, Ghana'),
(11, 'Christopher Columbus', 'yawboakye@gd.com', 'Butler', '5D762V3', 3, 'image_64b98e8495223.jpg', '2023-07-20 19:44:04', '2023-07-20 19:44:04', NULL, 'Tarkwa'),
(12, 'Ansah Moro', 'ansah@moro.gh', 'Ramseyer House', 'EVWIBc3', 3, 'image_64b9c4304c8db.jpg', '2023-07-20 23:33:04', '2023-07-20 23:33:04', NULL, 'Axim, Western'),
(13, 'Emmanuel Effah', 'emanueleffah@gmail.com', 'Peerson', '1eHBRq1', 1, 'image_64b9ccd1ed6a8.png', '2023-07-21 00:09:53', '2023-07-21 00:09:53', NULL, 'Accra Gh');

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
(2, 1, 12, '2023-07-20 02:11:58', '2023-07-20 02:11:58'),
(3, 3, 12, '2023-07-20 02:11:58', '2023-07-20 02:25:33'),
(4, 4, 12, '2023-07-20 02:11:58', '2023-07-20 02:25:33'),
(5, 6, 12, '2023-07-20 02:11:58', '2023-07-20 02:25:33'),
(7, 7, 12, '2023-07-20 02:11:58', '2023-07-20 02:25:33'),
(8, 5, 9, '2023-07-20 02:11:58', '2023-07-20 02:25:33');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `election_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
