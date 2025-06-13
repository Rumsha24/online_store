-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 09:28 AM
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
-- Database: `ecommerce`
--
CREATE DATABASE IF NOT EXISTS `ecommerce` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ecommerce`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `userID`, `productID`, `quantity`) VALUES
(11, 1, 8, 2),
(14, 2, 9, 3),
(15, 2, 10, 5),
(16, 2, 13, 1),
(17, 2, 21, 6),
(18, 2, 16, 1),
(19, 2, 19, 1),
(20, 2, 18, 6);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `productID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentID`, `productID`, `userID`, `rating`, `image`, `text`) VALUES
(9, 7, 2, 5, NULL, 'Amazing fragrance!'),
(10, 7, 1, 5, NULL, 'Long-lasting scent'),
(11, 7, 1, 5, '6849f7d6555b7_perfume_review.jpg', 'My favorite perfume!');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalAmount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `userID`, `orderDate`, `totalAmount`) VALUES
(1, 1, '2025-06-12 09:28:00', 198.00),
(2, 2, '2025-06-12 09:28:00', 240.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `shippingCost` decimal(10,2) DEFAULT 0.00,
  `size` varchar(20) DEFAULT NULL,
  `fragrance_family` varchar(50) DEFAULT NULL,
  `top_notes` varchar(255) DEFAULT NULL,
  `middle_notes` varchar(255) DEFAULT NULL,
  `base_notes` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `name`, `description`, `image`, `price`, `shippingCost`, `size`, `fragrance_family`, `top_notes`, `middle_notes`, `base_notes`, `stock_quantity`, `is_featured`) VALUES
(7, 'Velvet Aurora', 'A radiant blend of violet, musk, and soft amber for a dreamy evening.', '../images/1.jpg', 99.00, 0.00, '100ml', 'Floral Oriental', 'Bergamot, Black Currant', 'Violet, Jasmine', 'Amber, Musk, Vanilla', 50, 1),
(8, 'Midnight Peony', 'Peony and blackcurrant wrapped in a mysterious vanilla base.', '../images/2.jpg', 120.00, 0.00, '50ml', 'Floral', 'Peony, Black Currant', 'Rose, Lily of the Valley', 'Vanilla, Musk', 30, 1),
(9, 'Amber Whisper', 'Warm amber, sandalwood, and a hint of fig for a cozy embrace.', '../images/3.jpg', 88.00, 0.00, '90ml', 'Oriental', 'Fig, Cardamom', 'Amber, Orchid', 'Sandalwood, Vanilla', 45, 0),
(10, 'Celestial Bloom', 'A celestial bouquet of jasmine, neroli, and white tea.', '../images/4.jpg', 135.00, 0.00, '100ml', 'Floral', 'Neroli, Mandarin', 'Jasmine, White Tea', 'Musk, Cedar', 25, 1),
(11, 'Rosewood Reverie', 'Rose, cedar, and a touch of citrus for a modern classic.', '../images/5.jpg', 105.00, 0.00, '50ml', 'Woody Floral', 'Bergamot, Pink Pepper', 'Rose, Lily', 'Cedar, Amber', 40, 0),
(12, 'Golden Mirage', 'A sparkling blend of saffron, pear, and golden woods.', '../images/6.jpg', 112.50, 0.00, '90ml', 'Oriental Woody', 'Saffron, Pear', 'Orris, Rose', 'Sandalwood, Vanilla', 35, 1),
(13, 'Lush Serenity', 'Green tea, bamboo, and lotus for a calming escape.', '../images/7.png', 89.00, 0.00, '75ml', 'Fresh', 'Green Tea, Citrus', 'Bamboo, Lotus', 'Musk, Amber', 60, 0),
(14, 'Moonlit Jasmine', 'Night-blooming jasmine with hints of citrus and musk.', '../images/25.jpg', 75.00, 0.00, '80ml', 'Floral', 'Citrus, Bergamot', 'Jasmine, Orange Blossom', 'Musk, Vanilla', 55, 0),
(15, 'Saffron Veil', 'Saffron, rose, and creamy sandalwood for a rich finish.', '../images/11.jpeg', 120.00, 0.00, '50ml', 'Oriental', 'Saffron, Cardamom', 'Rose, Orris', 'Sandalwood, Vanilla', 20, 1),
(16, 'Petal Noir', 'Dark rose, patchouli, and black pepper for a bold statement.', '../images/12.png', 130.00, 0.00, '100ml', 'Floral Woody', 'Black Pepper, Bergamot', 'Dark Rose, Patchouli', 'Amber, Vanilla', 30, 1),
(17, 'Azure Muse', 'Aquatic notes, blue lotus, and driftwood for a fresh vibe.', '../images/14.jpeg', 108.00, 0.00, '100ml', 'Aquatic', 'Sea Notes, Citrus', 'Blue Lotus, Jasmine', 'Driftwood, Musk', 40, 0),
(18, 'Blush Ember', 'Pink pepper, rose, and smoky woods for a warm embrace.', '../images/19.jpg', 118.00, 0.00, '85ml', 'Woody Floral', 'Pink Pepper, Bergamot', 'Rose, Orris', 'Smoky Woods, Vanilla', 35, 0),
(19, 'Opal Essence', 'Iris, white musk, and pear for a luminous signature.', '../images/20.jpg', 95.00, 0.00, '100ml', 'Floral', 'Pear, Bergamot', 'Iris, Jasmine', 'White Musk, Vanilla', 50, 1),
(20, 'Wild Iris', 'Wild iris, bergamot, and vetiver for a fresh, green scent.', '../images/21.png', 89.00, 0.00, '75ml', 'Floral Fresh', 'Bergamot, Green Notes', 'Wild Iris, Violet', 'Vetiver, Musk', 45, 0),
(21, 'Enchanted Fig', 'Fig, coconut, and tonka bean for a sweet, creamy finish.', '../images/22.png', 122.00, 0.00, '90ml', 'Gourmand', 'Fig, Coconut', 'Orchid, Jasmine', 'Tonka Bean, Vanilla', 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `shippingAddress` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `password`, `username`, `shippingAddress`) VALUES
(1, 'test@example.com', '$2y$10$CSx4JP4MLWSUuD5YRRqq1.6YZcpQspUaZ7Uj2U1lt6ifhDfEO5YsO', 'testuser', '123 Test St'),
(2, 'rumsha26@gmail.com', '$2y$10$M.K//BJu0bgMWqsQQa12vuHYnuv/85LS9eFrM6udk9gw8.A71ovfG', 'Rumsha', '456 Flower Lane');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;