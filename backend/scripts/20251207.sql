-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 07, 2025 at 10:49 AM
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
-- Database: `se_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `status` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `status`) VALUES
(1, 'Coffee', 'Coffee drinks to boost your day.', b'1'),
(2, 'Juices', 'Healthy juices that taste great.', b'1'),
(3, 'Cakes', 'Beautiful cake slices that look super appetizing.', b'1'),
(4, 'Cookies', 'Delicious cookies baked with love.', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(200) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `description`, `price`, `image_url`, `category_id`, `active`) VALUES
(1, 'Espresso', 'Strong and rich single-shot espresso to kickstart your day.', 600.50, '/item/coffee_espresso.png', 1, 1),
(2, 'Americano', 'Smooth black coffee made with espresso and hot water.', 8.00, '/item/coffee_americano.jpg', 1, 1),
(3, 'Cappuccino', 'Espresso topped with steamed milk and frothy foam.', 8.00, '/item/coffee_cappuccino.png', 1, 1),
(4, 'Orange Juice', 'Freshly squeezed oranges packed with vitamin C.', 6.00, '/item/juice_orange.png', 2, 1),
(5, 'Apple Juice', 'Crisp and refreshing apple juice.', 6.00, '/item/juice_apple.png', 2, 1),
(6, 'Watermelon Cooler', 'Chilled watermelon juice with a hint of mint.', 7.00, '/item/juice_watermelon.png', 2, 1),
(7, 'Chocolate Fudge Cake', 'Rich and moist chocolate cake with creamy fudge frosting.', 12.00, '/item/cake_chocolate_fudge.png', 3, 1),
(8, 'Cheesecake', 'Classic creamy cheesecake with a buttery biscuit base.', 11.00, '/item/cake_cheesecake.png', 3, 1),
(9, 'Red Velvet Cake', 'Soft red velvet sponge layered with cream cheese frosting.', 12.50, '/item/cake_red_velvet.png', 3, 1),
(10, 'Chocolate Chip Cookie', 'Classic chewy cookie loaded with chocolate chips.', 4.00, '/item/cookie_choc_chip.png', 4, 1),
(11, 'Oatmeal Raisin Cookie', 'Hearty cookie with oats and sweet raisins.', 4.50, '/item/cookie_oatmeal_raisin.png', 4, 1),
(12, 'Double Chocolate Cookie', 'Rich chocolate cookie with chocolate chunks.', 4.50, '/item/cookie_double_choc.png', 4, 0),
(19, 'Latte', 'this is our new latte', 12.40, '/item/coffee_latte.jpeg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `status` char(1) NOT NULL CHECK (`status` in ('O','P','D')),
  `is_complete` char(1) NOT NULL CHECK (`is_complete` in ('Y','N')),
  `order_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `item_id`, `table_id`, `quantity`, `status`, `is_complete`, `order_time`) VALUES
(7, 1, 1, 2, 'D', 'Y', '2025-09-10 10:00:00'),
(8, 7, 1, 1, 'D', 'Y', '2025-11-12 10:01:00'),
(9, 3, 2, 1, 'D', 'Y', '2025-09-22 14:30:00'),
(10, 9, 3, 2, 'D', 'Y', '2025-10-05 09:15:00'),
(11, 9, 4, 1, 'D', 'Y', '2025-10-20 11:00:00'),
(12, 2, 4, 1, 'D', 'Y', '2025-10-20 11:00:00'),
(13, 10, 5, 2, 'D', 'Y', '2025-11-12 12:00:00'),
(17, 1, 1, 1, 'D', 'Y', '2025-11-12 08:30:00'),
(18, 4, 10, 2, 'D', 'Y', '2025-11-05 12:00:00'),
(22, 7, 2, 2, 'D', 'Y', '2024-11-10 14:00:00'),
(23, 10, 3, 3, 'D', 'Y', '2024-11-15 11:30:00'),
(24, 3, 4, 1, 'D', 'Y', '2024-11-20 19:00:00'),
(25, 5, 5, 2, 'D', 'Y', '2024-11-25 09:00:00'),
(26, 2, 6, 1, 'D', 'Y', '2024-12-05 10:15:00'),
(27, 8, 7, 2, 'D', 'Y', '2024-12-10 14:00:00'),
(28, 11, 8, 3, 'D', 'Y', '2024-12-15 11:30:00'),
(29, 4, 9, 1, 'D', 'Y', '2024-12-20 19:00:00'),
(30, 6, 45, 2, 'D', 'Y', '2025-11-12 09:00:00'),
(31, 9, 1, 1, 'D', 'Y', '2025-01-05 10:15:00'),
(32, 12, 2, 2, 'D', 'Y', '2025-01-10 14:00:00'),
(33, 1, 3, 3, 'D', 'Y', '2025-01-15 11:30:00'),
(34, 3, 4, 1, 'D', 'Y', '2025-01-20 19:00:00'),
(35, 7, 5, 2, 'D', 'Y', '2025-01-25 09:00:00'),
(36, 4, 6, 1, 'D', 'Y', '2025-02-05 10:15:00'),
(37, 5, 7, 2, 'D', 'Y', '2025-02-10 14:00:00'),
(38, 8, 8, 3, 'D', 'Y', '2025-02-15 11:30:00'),
(39, 10, 9, 1, 'D', 'Y', '2025-02-20 19:00:00'),
(40, 11, 10, 2, 'D', 'Y', '2025-02-25 09:00:00'),
(41, 12, 1, 1, 'D', 'Y', '2025-03-05 10:15:00'),
(42, 9, 2, 2, 'D', 'Y', '2025-03-10 14:00:00'),
(43, 6, 3, 3, 'D', 'Y', '2025-03-15 11:30:00'),
(44, 3, 4, 1, 'D', 'Y', '2025-03-20 19:00:00'),
(45, 1, 5, 2, 'D', 'Y', '2025-03-25 09:00:00'),
(46, 2, 6, 1, 'D', 'Y', '2025-04-05 10:15:00'),
(47, 1, 1, 1, 'D', 'Y', '2024-11-05 10:15:00'),
(48, 7, 2, 2, 'D', 'Y', '2024-11-10 14:00:00'),
(49, 10, 3, 3, 'D', 'Y', '2024-11-15 11:30:00'),
(50, 3, 4, 1, 'D', 'Y', '2024-11-20 19:00:00'),
(51, 5, 5, 2, 'D', 'Y', '2024-11-25 09:00:00'),
(52, 2, 6, 1, 'D', 'Y', '2024-12-05 10:15:00'),
(53, 8, 7, 2, 'D', 'Y', '2024-12-10 14:00:00'),
(54, 11, 8, 3, 'D', 'Y', '2024-12-15 11:30:00'),
(55, 4, 9, 1, 'D', 'Y', '2024-12-20 19:00:00'),
(56, 6, 10, 2, 'D', 'Y', '2024-12-25 09:00:00'),
(57, 9, 1, 1, 'D', 'Y', '2025-01-05 10:15:00'),
(58, 12, 2, 2, 'D', 'Y', '2025-01-10 14:00:00'),
(59, 1, 3, 3, 'D', 'Y', '2025-01-15 11:30:00'),
(60, 3, 4, 1, 'D', 'Y', '2025-01-20 19:00:00'),
(61, 7, 5, 2, 'D', 'Y', '2025-01-25 09:00:00'),
(62, 4, 6, 1, 'D', 'Y', '2025-02-05 10:15:00'),
(63, 5, 7, 2, 'D', 'Y', '2025-02-10 14:00:00'),
(64, 8, 8, 3, 'D', 'Y', '2025-02-15 11:30:00'),
(65, 10, 9, 1, 'D', 'Y', '2025-02-20 19:00:00'),
(66, 11, 10, 2, 'D', 'Y', '2025-02-25 09:00:00'),
(67, 12, 1, 1, 'D', 'Y', '2025-03-05 10:15:00'),
(68, 9, 2, 2, 'D', 'Y', '2025-03-10 14:00:00'),
(69, 6, 3, 3, 'D', 'Y', '2025-03-15 11:30:00'),
(70, 3, 4, 1, 'D', 'Y', '2025-03-20 19:00:00'),
(71, 1, 5, 2, 'D', 'Y', '2025-03-25 09:00:00'),
(72, 2, 6, 1, 'D', 'Y', '2025-04-05 10:15:00'),
(73, 4, 7, 2, 'D', 'Y', '2025-04-10 14:00:00'),
(74, 7, 8, 3, 'D', 'Y', '2025-04-15 11:30:00'),
(75, 10, 9, 1, 'D', 'Y', '2025-04-20 19:00:00'),
(76, 12, 10, 2, 'D', 'Y', '2025-04-25 09:00:00'),
(77, 5, 1, 1, 'D', 'Y', '2025-05-05 10:15:00'),
(78, 8, 2, 2, 'D', 'Y', '2025-05-10 14:00:00'),
(79, 11, 3, 3, 'D', 'Y', '2025-05-15 11:30:00'),
(80, 1, 4, 1, 'D', 'Y', '2025-05-20 19:00:00'),
(81, 3, 5, 2, 'D', 'Y', '2025-05-25 09:00:00'),
(82, 6, 6, 1, 'D', 'Y', '2025-06-05 10:15:00'),
(83, 9, 7, 2, 'D', 'Y', '2025-06-10 14:00:00'),
(84, 12, 8, 3, 'D', 'Y', '2025-06-15 11:30:00'),
(85, 2, 9, 1, 'D', 'Y', '2025-06-20 19:00:00'),
(86, 4, 10, 2, 'D', 'Y', '2025-06-25 09:00:00'),
(87, 7, 1, 1, 'D', 'Y', '2025-07-05 10:15:00'),
(88, 10, 2, 2, 'D', 'Y', '2025-07-10 14:00:00'),
(89, 1, 3, 3, 'D', 'Y', '2025-07-15 11:30:00'),
(90, 5, 4, 1, 'D', 'Y', '2025-07-20 19:00:00'),
(91, 8, 5, 2, 'D', 'Y', '2025-11-12 09:00:00'),
(92, 11, 6, 1, 'D', 'Y', '2025-08-05 10:15:00'),
(93, 3, 7, 2, 'D', 'Y', '2025-08-10 14:00:00'),
(94, 6, 8, 3, 'D', 'Y', '2025-08-15 11:30:00'),
(95, 9, 9, 1, 'D', 'Y', '2025-09-20 19:00:00'),
(96, 12, 45, 2, 'D', 'Y', '2025-11-12 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `seating`
--

CREATE TABLE `seating` (
  `id` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `status` char(1) NOT NULL CHECK (`status` in ('F','P','C')),
  `type` varchar(50) NOT NULL CHECK (`type` in ('Private Room','Solo Work Bar','Group Work Table','Lounge','Minibar','Open Dining')),
  `ttype` varchar(50) NOT NULL,
  `floor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seating`
--

INSERT INTO `seating` (`id`, `table_no`, `status`, `type`, `ttype`, `floor`) VALUES
(1, 1, 'F', 'Private Room', 'Long Table', 1),
(2, 2, 'F', 'Private Room', 'Long Table', 1),
(3, 3, 'F', 'Solo Work Bar', 'Bar Stool', 1),
(4, 4, 'F', 'Solo Work Bar', 'Bar Stool', 1),
(5, 5, 'F', 'Solo Work Bar', 'Bar Stool', 1),
(6, 6, 'F', 'Solo Work Bar', 'Bar Stool', 1),
(7, 7, 'F', 'Solo Work Bar', 'Bar Stool', 1),
(8, 8, 'F', 'Solo Work Bar', 'Bar Stool', 1),
(9, 9, 'F', 'Group Work Table', 'Long', 1),
(10, 10, 'F', 'Group Work Table', 'Long', 1),
(11, 11, 'F', 'Group Work Table', 'Long', 1),
(12, 12, 'F', 'Group Work Table', 'Long', 1),
(13, 13, 'F', 'Group Work Table', 'Round', 1),
(14, 14, 'F', 'Group Work Table', 'Round', 1),
(15, 15, 'F', 'Group Work Table', 'Round', 1),
(16, 16, 'F', 'Group Work Table', 'Round', 1),
(17, 17, 'F', 'Group Work Table', 'Square', 1),
(18, 18, 'F', 'Group Work Table', 'Square', 1),
(19, 19, 'F', 'Group Work Table', 'Square', 1),
(20, 20, 'F', 'Group Work Table', 'Square', 1),
(21, 21, 'F', 'Lounge', 'Sofa', 1),
(22, 22, 'F', 'Lounge', 'Sofa', 1),
(23, 23, 'F', 'Lounge', 'Sofa', 1),
(24, 24, 'F', 'Lounge', 'Stool', 1),
(25, 25, 'F', 'Lounge', 'Stool', 1),
(26, 26, 'F', 'Minibar', 'Bar Stool', 2),
(27, 27, 'F', 'Minibar', 'Bar Stool', 2),
(28, 28, 'F', 'Minibar', 'Bar Stool', 2),
(29, 29, 'F', 'Minibar', 'Bar Stool', 2),
(30, 30, 'F', 'Minibar', 'Bar Stool', 2),
(31, 31, 'F', 'Minibar', 'Bar Stool', 2),
(32, 32, 'F', 'Open Dining', 'Square', 2),
(33, 33, 'F', 'Open Dining', 'Round', 2),
(34, 34, 'F', 'Open Dining', 'Square', 2),
(35, 35, 'F', 'Open Dining', 'Round', 2),
(36, 36, 'F', 'Open Dining', 'Square', 2),
(37, 37, 'F', 'Open Dining', 'Round', 2),
(38, 38, 'F', 'Open Dining', 'Square', 2),
(39, 39, 'F', 'Open Dining', 'Round', 2),
(40, 40, 'F', 'Open Dining', 'Long', 2),
(41, 41, 'F', 'Open Dining', 'Long', 2),
(42, 42, 'F', 'Open Dining', 'Long', 2),
(43, 43, 'F', 'Open Dining', 'Round', 2),
(44, 44, 'F', 'Open Dining', 'Square', 2),
(45, 45, 'F', 'Open Dining', 'Round', 2);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expire_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `user_id`, `token`, `expire_at`) VALUES
(74, 3, 'c5ddb5d287b8af7ac0c783ffc9c157d3cbe128fb76b8bdbdd088776317404ded', '2025-12-03 00:42:07'),
(84, 5, 'bf3a6d9f74c96a1b16b4b4d4ddfa739c0b5f4a2988f5f1992de1cef0f2a011ae', '2025-12-03 16:11:31'),
(97, 2, '41467164602558077302b9aeff63c66585bad191cbc11a0d350e9f7313417519', '2025-12-07 19:38:31'),
(99, 1, '41a166afe005b15e87df8eadff9306808bfb044520b494bbbbf4f2a47b0beab7', '2025-12-07 20:32:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` char(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `active`) VALUES
(1, 'admin', 'admin@gmail.com', 'A', '$2y$10$PGQgfOlqACp6x.hjV0mEkemI/kifQBZHbJHm6lo8SDgNCCICO2YB2', 1),
(2, 'admin3', 'admin3@gmail.com', 'A', '$2y$10$C07BywnvPHKLt5T.z7Dtteu8BA2dEERSZbCq0pybM6Lqcg/QdWpGa', 1),
(3, 'cook1', 'cook1@gmail.com', 'K', '$2y$10$qo9E/Z5b/yO2D4ar3SSG5eOcvesbOBJBrdEmulESni2hK72gS/tCi', 1),
(4, 'test1', 'test1@gmail.com', 'A', '$2y$10$kYuTk6d2b7MXqXUdk5lane1nSM6pnhcDaovoek1W1fEcNhvqbhUei', 1),
(5, 'kianara', 'kian@gmail.com', 'A', '$2y$10$868CSSd1dtvghn4GoBSPNOGKt7jeZW6DdFAL4tz3Y6haSvDEgxF2q', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `table_id` (`table_id`);

--
-- Indexes for table `seating`
--
ALTER TABLE `seating`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `table_no` (`table_no`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `seating`
--
ALTER TABLE `seating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `seating` (`id`);

--
-- Constraints for table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
