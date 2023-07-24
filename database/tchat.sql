-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2023 at 07:30 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tchat`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_user_table`
--

CREATE TABLE `chat_user_table` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_profile` varchar(255) NOT NULL,
  `user_status` enum('Disabled','Enable') NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_verification_code` varchar(255) NOT NULL,
  `user_login_status` enum('Logout','Login') NOT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `connection_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat_user_table`
--

INSERT INTO `chat_user_table` (`user_id`, `user_name`, `user_email`, `user_password`, `user_profile`, `user_status`, `user_created_on`, `user_verification_code`, `user_login_status`, `session_id`, `connection_id`) VALUES
(1, 'Gibran', 'gibran321@hotmail.com', '$2y$10$MRTTXZnQKLHIfsgnS/LZP.fE8VY7w6EUuWmnAk/pbG3a0uu3pHAqm', 'images/1688945103.jpg', 'Enable', '2023-07-08 19:34:28', '71f5332d6f3f8c6a598de61d0f42f320', 'Logout', 's0t79llfr4quvd5tjse3apsdh5', 145),
(3, 'Abo jad', 'abojad987@hotmail.com', '$2y$10$KkXIi8ROZNnAzGyzcr/ra.OwOe.PZSpAJLu4.tkGIAQbOvalu7OPy', 'images/1689066853.png', 'Enable', '2023-07-11 11:14:13', '9c66441e2f64c8bf6482da5bde161284', 'Logout', 'of9vpkv0t0fdboiieu5qojl3da', 130),
(4, 'Gobier', 'gibran987@gmail.com', '$2y$10$PW0K6Egyfqv8BYzBI.rrQuaL/VjDj0fpy5iY48w/0tjy9mniI0L5K', 'images/1689631370.png', 'Enable', '2023-07-18 00:02:50', '78a8747b05c32d637681168fdfb77a77', 'Logout', 'ugnnhpf1i19at34q94r0m0eodm', 121);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `user_creator_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `user_creator_id`, `name`, `description`, `created_at`) VALUES
(1, 1, 'ICTE', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', '2023-07-11 14:47:09'),
(20, 1, 'All members group', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deserunt veniam commodi laboriosam sequi hic fugiat ad doloribus quos error harum voluptate ducimus, illo culpa magnam id nihil natus? Quasi, qui.', '2023-07-21 17:40:55'),
(21, 3, 'Web Development', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sapiente id rem voluptatum sunt ad libero earum nihil rerum fugit nemo mollitia, sit dicta, totam numquam ea doloribus tempora voluptas atque.', '2023-07-21 17:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `groups_users`
--

CREATE TABLE `groups_users` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups_users`
--

INSERT INTO `groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 3),
(20, 1),
(20, 3),
(20, 4),
(21, 3),
(21, 4);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `user_id`, `group_id`, `created_at`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 3, 1, '2023-07-11 14:48:07'),
(2, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.', 1, 1, '2023-07-11 14:48:27'),
(3, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.', 3, 1, '2023-07-11 14:48:56'),
(4, 'ciatis unde omnis iste natus error sit voluptatem accusantium doloremque la', 1, 1, '2023-07-15 16:54:50'),
(26, 'Hi', 1, 20, '2023-07-21 17:41:10'),
(28, 'Hi', 4, 20, '2023-07-21 17:47:01'),
(29, 'Hello', 3, 20, '2023-07-21 17:47:08'),
(30, 'It is web development group', 3, 21, '2023-07-21 17:49:28'),
(31, 'OK!', 4, 21, '2023-07-21 17:49:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_user_table`
--
ALTER TABLE `chat_user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_creator_id` (`user_creator_id`);

--
-- Indexes for table `groups_users`
--
ALTER TABLE `groups_users`
  ADD PRIMARY KEY (`group_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_user_table`
--
ALTER TABLE `chat_user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`user_creator_id`) REFERENCES `chat_user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `groups_users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `chat_user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `chat_user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
