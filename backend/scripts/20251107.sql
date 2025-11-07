-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2025 at 04:03 AM
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
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `description`, `price`, `image_url`, `category_id`) VALUES
(1, 'Espresso', 'Strong and rich single-shot espresso to kickstart your day.', 6.50, '/item/coffee_espresso.png', 1),
(2, 'Americano', 'Smooth black coffee made with espresso and hot water.', 7.00, '/item/coffee_americano.png', 1),
(3, 'Cappuccino', 'Espresso topped with steamed milk and frothy foam.', 8.00, '/item/coffee_cappuccino.png', 1),
(4, 'Orange Juice', 'Freshly squeezed oranges packed with vitamin C.', 6.00, '/item/juice_orange.png', 2),
(5, 'Apple Juice', 'Crisp and refreshing apple juice.', 6.00, '/item/juice_apple.png', 2),
(6, 'Watermelon Cooler', 'Chilled watermelon juice with a hint of mint.', 7.00, '/item/juice_watermelon.png', 2),
(7, 'Chocolate Fudge Cake', 'Rich and moist chocolate cake with creamy fudge frosting.', 12.00, '/item/cake_chocolate_fudge.png', 3),
(8, 'Cheesecake', 'Classic creamy cheesecake with a buttery biscuit base.', 11.00, '/item/cake_cheesecake.png', 3),
(9, 'Red Velvet Cake', 'Soft red velvet sponge layered with cream cheese frosting.', 12.50, '/item/cake_red_velvet.png', 3),
(10, 'Chocolate Chip Cookie', 'Classic chewy cookie loaded with chocolate chips.', 4.00, '/item/cookie_choc_chip.png', 4),
(11, 'Oatmeal Raisin Cookie', 'Hearty cookie with oats and sweet raisins.', 4.50, '/item/cookie_oatmeal_raisin.png', 4),
(12, 'Double Chocolate Cookie', 'Rich chocolate cookie with chocolate chunks.', 4.50, '/item/cookie_double_choc.png', 4);

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
  `order_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `item_id`, `table_id`, `quantity`, `status`, `order_time`) VALUES
(1, 1, 1, 1, 'D', '2025-11-07 10:57:45'),
(2, 2, 1, 1, 'D', '2025-11-07 10:57:45'),
(3, 3, 1, 1, 'D', '2025-11-07 10:57:45'),
(4, 3, 1, 1, 'D', '2025-11-07 10:57:45'),
(5, 4, 1, 2, 'D', '2025-11-07 10:57:45'),
(6, 4, 1, 2, 'D', '2025-11-07 10:57:46'),
(7, 1, 1, 2, 'D', '2025-09-10 10:00:00'),
(8, 7, 1, 1, 'D', '2025-09-10 10:01:00'),
(9, 3, 2, 1, 'D', '2025-09-22 14:30:00'),
(10, 9, 3, 2, 'D', '2025-10-05 09:15:00'),
(11, 9, 4, 1, 'D', '2025-10-20 11:00:00'),
(12, 2, 4, 1, 'D', '2025-10-20 11:00:00'),
(13, 10, 5, 2, 'D', '2025-11-01 12:00:00'),
(14, 11, 6, 3, 'D', '2025-11-02 13:00:00'),
(15, 2, 7, 3, 'D', '2025-08-15 11:00:00'),
(16, 8, 8, 2, 'D', '2025-08-20 16:00:00'),
(17, 1, 9, 1, 'D', '2025-10-10 08:30:00'),
(18, 4, 10, 2, 'D', '2025-10-25 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `seating`
--

CREATE TABLE `seating` (
  `id` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `status` char(1) NOT NULL CHECK (`status` in ('F','P','C')),
  `floor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seating`
--

INSERT INTO `seating` (`id`, `table_no`, `status`, `floor`) VALUES
(1, 1, 'F', 1),
(2, 2, 'F', 1),
(3, 3, 'F', 1),
(4, 4, 'F', 1),
(5, 5, 'F', 2),
(6, 6, 'F', 2),
(7, 7, 'F', 2),
(8, 8, 'F', 2),
(9, 9, 'F', 3),
(10, 10, 'F', 3),
(11, 11, 'F', 3),
(12, 12, 'F', 3);

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` char(1) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'A', 'admin');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `seating`
--
ALTER TABLE `seating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
