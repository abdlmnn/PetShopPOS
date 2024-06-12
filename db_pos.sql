-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 03:15 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `reference_no` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `received` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `reference_no`, `total_amount`, `received`, `date`) VALUES
(1, 9492, 30, 30, '2024-05-18'),
(2, 7597, 999, 999, '2024-05-19'),
(3, 4341, 1998, 2000, '2024-05-19'),
(16, 9908, 1029, 2000, '2024-05-23'),
(17, 1959, 5025, 5100, '2024-05-23'),
(18, 8322, 50, 50, '2024-05-24');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `category`, `name`, `price`, `stock`, `description`, `status`) VALUES
(1, 'Dog', 'Liverolin', 399, 10, 'Supplement', 1),
(2, 'Dog', 'Bone Treats', 30, 9, 'Food\r\n', 1),
(3, 'Dog', 'Meat', 699, 10, 'Food', 1),
(4, 'Cat', 'Tuna Fillets', 99, 10, 'Food', 1),
(5, 'Cat', 'Ball', 20, 9, 'Toy', 1),
(6, 'Cat', 'Whiskas', 250, 10, 'Food', 1),
(7, 'Cat', 'Royal Canin', 350, 10, 'Food', 1),
(8, 'Dog', 'Purina', 150, 10, 'Food', 1),
(9, 'Cat', 'Liverolin', 399, 10, 'Supplement', 1),
(10, 'Dog', 'Troy Nutripet', 879, 10, 'Supplement', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_orders`
--

CREATE TABLE `products_orders` (
  `o_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_orders`
--

INSERT INTO `products_orders` (`o_id`, `p_id`, `quantity`) VALUES
(1, 2, 1),
(2, 1, 1),
(3, 1, 2),
(16, 2, 1),
(16, 1, 1),
(17, 1, 5),
(17, 2, 1),
(18, 5, 1),
(18, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` enum('admin','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `usertype`) VALUES
(1, 'abdul', '123', 'admin'),
(2, 'elca', '123', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `products_orders`
--
ALTER TABLE `products_orders`
  ADD KEY `o_id` (`o_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products_orders`
--
ALTER TABLE `products_orders`
  ADD CONSTRAINT `o_id` FOREIGN KEY (`o_id`) REFERENCES `orders` (`o_id`),
  ADD CONSTRAINT `p_id` FOREIGN KEY (`p_id`) REFERENCES `products` (`p_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
