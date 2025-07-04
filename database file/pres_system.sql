-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 01, 2025 at 08:16 PM
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
-- Database: `pres_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `delivery_address` text NOT NULL,
  `delivery_time` varchar(50) NOT NULL,
  `status` enum('pending','quoted','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `user_id`, `note`, `delivery_address`, `delivery_time`, `status`, `created_at`) VALUES
(1, 1, '', '54, John Road, Michette, USA.', '8:00 AM - 10:00 AM', 'quoted', '2025-05-31 00:20:07'),
(2, 3, 'Derm Drugs', '54, Pent Road, Masachusetts', '10:00 AM - 12:00 PM', 'quoted', '2025-05-31 23:03:13'),
(3, 3, 'quotations', 'kandy', '8:00 AM - 10:00 AM', 'quoted', '2025-06-01 12:15:35'),
(4, 3, 'Drugs', '52, Tent Road, Massachussets', '4:00 PM - 6:00 PM', 'quoted', '2025-06-01 12:38:01'),
(5, 3, 'Notes', '43. Tent Road, Jonty, USA.', '2:00 PM - 4:00 PM', 'quoted', '2025-06-01 16:56:27'),
(6, 3, 'Notes', '12, Tent Road, USA', '12:00 PM - 2:00 PM', 'quoted', '2025-06-01 17:01:10'),
(7, 3, 'Note', '23, Mongel Road, USA.', '12:00 PM - 2:00 PM', 'quoted', '2025-06-01 17:09:04'),
(8, 3, 'Notes', '54, New Road, USA.', '6:00 PM - 8:00 PM', 'quoted', '2025-06-01 17:14:38'),
(9, 3, 'Noted', '23, Genk Road, USA.', '12:00 PM - 2:00 PM', 'quoted', '2025-06-01 17:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_images`
--

CREATE TABLE `prescription_images` (
  `id` int(11) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription_images`
--

INSERT INTO `prescription_images` (`id`, `prescription_id`, `image_path`) VALUES
(1, 1, '../uploads/prescriptions/1748650807_image-04-26-2025_08_59_PM.png'),
(2, 2, '../uploads/prescriptions/1748732593_istockphoto-1340209614-612x612.png'),
(7, 4, '../uploads/prescriptions/1748781481_winged-frames-flying-bird-shield-emblem-eagle-wings-badge-frame-and-retro-aviation-fast-wing-delivery-cargo-logotype-or-military-wings-insignia-isolated-symbols-vector-set-winged-frames-flying-bird-shield-emblem-.jpg'),
(8, 5, '../uploads/prescriptions/1748796987_be2ca990355e419e9b058a14c348adc0-fotor-ai-art-effects-20250510054316.png'),
(9, 6, '../uploads/prescriptions/1748797270_Udakkiya.png'),
(10, 7, '../uploads/prescriptions/1748797744_ollama-ai.png'),
(11, 8, '../uploads/prescriptions/1748798078_istockphoto-1340209614-612x612-removebg-preview.png'),
(12, 9, '../uploads/prescriptions/1748798403_istockphoto-1340209614-612x612-removebg-preview.png');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int(11) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `prescription_id`, `pharmacy_id`, `total_amount`, `status`, `created_at`) VALUES
(1, 1, 2, 9750.00, 'pending', '2025-05-31 00:59:20'),
(2, 1, 2, 1000.00, 'pending', '2025-05-31 01:00:44'),
(3, 1, 2, 1600.00, 'pending', '2025-05-31 03:12:48'),
(4, 2, 4, 4490.00, 'accepted', '2025-05-31 23:06:57'),
(6, 3, 4, 1527.00, 'pending', '2025-06-01 12:34:20'),
(7, 4, 4, 1060.00, 'accepted', '2025-06-01 12:39:14'),
(8, 5, 4, 13248.00, 'pending', '2025-06-01 16:57:37'),
(9, 6, 4, 1464.00, 'pending', '2025-06-01 17:01:33'),
(10, 7, 4, 1464.00, 'pending', '2025-06-01 17:09:37'),
(11, 8, 4, 1464.00, 'pending', '2025-06-01 17:14:56'),
(12, 9, 4, 6741.00, 'accepted', '2025-06-01 17:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

CREATE TABLE `quotation_items` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `drug_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotation_items`
--

INSERT INTO `quotation_items` (`id`, `quotation_id`, `drug_name`, `quantity`, `unit_price`, `total_price`) VALUES
(1, 1, 'Cetrizine', 5, 200.00, 1000.00),
(2, 1, 'Carvedilol', 10, 600.00, 6000.00),
(3, 1, 'Rosuvas', 6, 165.00, 990.00),
(4, 1, 'Tell-OD', 8, 220.00, 1760.00),
(5, 2, 'Cetrizine', 5, 200.00, 1000.00),
(6, 3, 'Cetrizine', 5, 200.00, 1000.00),
(7, 3, 'Piriton', 2, 300.00, 600.00),
(8, 4, 'acythromycine', 12, 80.00, 960.00),
(9, 4, 'Mestrov', 8, 240.00, 1920.00),
(10, 4, 'Carvedelol', 7, 230.00, 1610.00),
(14, 6, 'Cetrizine', 1, 12.00, 12.00),
(15, 6, 'piriton', 5, 15.00, 75.00),
(16, 6, 'Tell-OD', 12, 120.00, 1440.00),
(17, 7, 'Cetrizine', 5, 20.00, 100.00),
(18, 7, 'Metphormine', 8, 120.00, 960.00),
(19, 8, 'Cetrizine', 12, 124.00, 1488.00),
(20, 8, 'Tell-OD', 24, 90.00, 2160.00),
(21, 8, 'Empazin', 30, 320.00, 9600.00),
(22, 9, 'Cetrizine', 12, 122.00, 1464.00),
(23, 10, 'Cetrizine', 12, 122.00, 1464.00),
(24, 11, 'acythromycine', 12, 122.00, 1464.00),
(25, 12, 'Cetrizine1', 21, 321.00, 6741.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `user_type` enum('user','pharmacy') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address`, `contact_no`, `dob`, `user_type`, `created_at`) VALUES
(1, 'Ashik', 'ashikniza@gmail.com', '$2y$10$hAuN3P2vwxfFP84vJ0ifBu.qKv1TtD0euJP/5N6e4rtLym5S6xBUa', '26, John Road, Michelle,  USA.', '+94776654432', '1999-05-15', 'user', '2025-05-30 21:27:21'),
(2, 'Raj', 'rajpharma@hotmail.com', '$2y$10$f5wvwBtecvsm1t1BTJKHyuB3b4cvMgEfp.lIUcbvpH2s1EzYHV2v6', '23, Jonathan Road, Michette, USA.', '+9467375772', '2004-12-12', 'pharmacy', '2025-05-31 00:46:31'),
(3, 'Niz', 'ashikshaheed4@gmail.com', '$2y$10$X7znOCMX7exb03n8CFv.s.Ut6138MkbOBBLRZHkmwzn4FLCUZN0x2', '25, John Road, Masachusetts, USA.', '+9477654378', '1978-05-13', 'user', '2025-05-31 23:01:00'),
(4, '7E', 'minicoup@hotmail.com', '$2y$10$0uF3LweJJ3V8SrIDrzYhdOJTTQ18Xzvz8L9p4tJXCwKcYsMZS419m', '66, Tent Road, Masechussetts.', '+94776286732', '1999-05-14', 'pharmacy', '2025-05-31 23:05:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `prescription_images`
--
ALTER TABLE `prescription_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_id` (`prescription_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_id` (`prescription_id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_id` (`quotation_id`);

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
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prescription_images`
--
ALTER TABLE `prescription_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `prescription_images`
--
ALTER TABLE `prescription_images`
  ADD CONSTRAINT `prescription_images_ibfk_1` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_ibfk_1` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`),
  ADD CONSTRAINT `quotations_ibfk_2` FOREIGN KEY (`pharmacy_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD CONSTRAINT `quotation_items_ibfk_1` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
