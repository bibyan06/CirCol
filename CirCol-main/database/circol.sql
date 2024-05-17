-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 06:05 PM
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
-- Database: `ebuy`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifs`
--

CREATE TABLE `admin_notifs` (
  `id` int(11) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `notif_date` date NOT NULL,
  `notif_time` time NOT NULL,
  `seen_date` date NOT NULL,
  `seen_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_notifs`
--

INSERT INTO `admin_notifs` (`id`, `message`, `notif_date`, `notif_time`, `seen_date`, `seen_time`) VALUES
(5, 'Dear seller,&nbsp;<br><br>We are the admins, we are hoping for your consideration as our system is under maintenance.<br>', '2024-04-21', '00:51:10', '2024-04-29', '23:30:07'),
(10, 'almerqarkp]qwr', '2024-04-29', '23:34:47', '0000-00-00', '00:00:00'),
(11, 'sewhetriohwerphwerojeriegrcn grhqiwownskfisbdfklsbdfjnsdfhsdfhisodfhsifhs', '2024-04-29', '23:34:55', '2024-04-29', '23:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(20, 3, 6, 1),
(88, 5, 4, 1),
(89, 5, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_slug` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `cat_slug`) VALUES
(1, 'Lanyard', 'lanyard'),
(4, 'Totebag', 'totebag'),
(5, 'T-shirt', 'shirt'),
(6, 'Sticker', 'sticker'),
(7, 'Seals', 'seals'),
(8, 'Plates', 'plates');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `notif_date` date NOT NULL,
  `notif_time` time NOT NULL,
  `seen_date` date NOT NULL,
  `seen_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `order_id`, `message`, `notif_date`, `notif_time`, `seen_date`, `seen_time`) VALUES
(4, 22, 'Your order from our shop is ready to pickup', '2024-04-20', '14:26:51', '2024-04-20', '14:43:02'),
(5, 21, 'Your order from our shop is ready to pickup', '2024-04-20', '14:32:26', '2024-04-20', '14:42:48'),
(6, 22, 'Your order from our shop is ready to pickup', '2024-04-20', '14:32:28', '2024-04-21', '11:31:47'),
(7, 21, 'Your order from our shop is ready to pickup', '2024-04-20', '14:35:39', '2024-04-20', '23:06:33'),
(8, 22, 'Your order from our shop is ready to pickup', '2024-04-20', '14:40:21', '2024-04-20', '15:03:58'),
(15, 21, 'Your order from our shop is ready to pickup', '2024-04-21', '11:34:47', '2024-04-29', '14:46:21'),
(16, 21, 'Your order from our shop is ready to pickup', '2024-04-22', '23:25:54', '2024-04-27', '21:38:01'),
(17, 22, 'Your order from our shop is ready to pickup', '2024-04-29', '00:22:09', '2024-04-29', '15:12:46'),
(18, 33, 'Your order from our shop is ready to pickup', '2024-04-29', '17:04:08', '0000-00-00', '00:00:00'),
(19, 33, 'Your order from our shop is ready to pickup', '2024-04-29', '17:38:01', '0000-00-00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` double NOT NULL,
  `order_date` date NOT NULL,
  `status` int(1) NOT NULL,
  `order_track` date NOT NULL,
  `gcash_acc_name` varchar(255) NOT NULL,
  `gcash_refno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `seller_id`, `product_id`, `quantity`, `total_price`, `order_date`, `status`, `order_track`, `gcash_acc_name`, `gcash_refno`) VALUES
(1, 3, 4, 5, 2, 330, '2024-03-28', 3, '2024-04-19', 'Angela Anne Therese Hugo', '92749248DFE'),
(2, 5, 4, 6, 2, 400, '2024-04-12', 3, '2024-04-19', 'Byeon Woo-Seok', 'Woo0032'),
(3, 3, 2, 4, 1, 165, '2024-04-12', 0, '0000-00-00', 'Angela Anne Therese Hugo', '92749248'),
(21, 5, 4, 5, 1, 165, '2024-04-16', 3, '0000-00-00', 'Byeon Woo-Seok', 'WOO0006'),
(22, 5, 4, 6, 1, 200, '2024-04-16', 2, '2024-04-20', 'Byeon Woo-Seok', 'WOO0006'),
(23, 5, 4, 5, 1, 165, '2024-04-22', 0, '0000-00-00', 'Byeon Woo-Seok', '11111111111111111'),
(24, 5, 4, 6, 1, 200, '2024-04-22', 0, '0000-00-00', 'Byeon Woo-Seok', '11111111111111111'),
(33, 5, 4, 5, 1, 165, '2024-04-28', 1, '0000-00-00', 'Byeon Woo-Seok', 'OGNOGNOE93745969'),
(34, 5, 2, 4, 1, 165, '2024-04-28', 0, '0000-00-00', 'Byeon Woo-Seok', 'NIFIWEHRF2364834'),
(37, 5, 4, 6, 1, 200, '2024-04-28', 0, '0000-00-00', 'Byeon Woo-Seok', 'NKDSBGIKHGI923457935'),
(38, 5, 4, 5, 1, 165, '2024-04-28', 0, '0000-00-00', 'Byeon Woo-Seok', 'DNGOHGOHR-4385038603685'),
(39, 5, 2, 4, 1, 165, '2024-04-28', 0, '0000-00-00', 'Byeon Woo-Seok', 'KBDIKABSDGAFTW85R6856834'),
(40, 5, 4, 6, 1, 200, '2024-04-28', 0, '0000-00-00', 'Byeon Woo-Seok', 'KDGIDHTGI74937593745'),
(41, 5, 4, 6, 1, 200, '2024-04-28', 0, '0000-00-00', 'Byeon Woo-Seok', 'NDIFBIEHR945976');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `stock` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `photo` varchar(200) NOT NULL,
  `date_view` date NOT NULL,
  `seller_id` int(11) NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `stock`, `description`, `slug`, `price`, `photo`, `date_view`, `seller_id`, `counter`) VALUES
(4, 1, 'Circuits Lanyard', '93', '', 'circuits-lanyard', 165, 'circuits-lanyard.jpg', '2024-04-29', 2, 1),
(5, 1, 'Comsi Lanyard 2020', '100', 'Computer Science Lanyard 2020\r\n', 'comsi-lanyard', 130, 'product_662f7b0d7a80e.jpg', '2024-04-28', 4, 1),
(6, 4, 'Season Totebag', '20', 'Bicol Univesity Season Totebag\r\n', 'season-totebag', 200, 'season-totebag.jpg', '2024-04-29', 4, 4),
(7, 1, 'Access Lanyard', '125', 'Computer Science Exclusive Lanyard (Access)', 'access-lanyard', 130, 'access-lanyard.jpg', '2024-04-29', 4, 0),
(8, 1, 'Comsi Lanyard 2024', '125', 'Computer Science Lanyard 2024', 'comsi-lanyard-2024', 130, 'comsi-lanyard-2024.jpg', '2024-04-29', 4, 0),
(9, 4, 'Access Totebag', '100', 'ACCeSS Totebag this school year', 'access-totebag', 160, 'access-totebag.jpg', '2024-04-29', 4, 0),
(10, 5, 'Access Black Shirt', '100', 'ACCeSSories Black Shirt (KUMSAY)\r\n\r\nAvailable in XS, S, M, L, XL, 2XL sizes', 'access-black-shirt', 249, 'access-black-shirt.jpg', '2024-04-29', 4, 0),
(11, 5, 'Access White Shirt', '25', 'ACCeSSories White Shirt (KUMSAY)\r\n\r\nAvailable in XS, S, M, L, XL, 2XL sizes', 'access-white-shirt', 249, 'access-white-shirt.jpg', '2024-04-29', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type` int(1) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `gcash_qr` varchar(200) NOT NULL,
  `gcash_number` varchar(100) NOT NULL,
  `created_on` date NOT NULL,
  `shop_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `type`, `firstname`, `lastname`, `address`, `contact_info`, `photo`, `status`, `gcash_qr`, `gcash_number`, `created_on`, `shop_name`) VALUES
(1, 'ronabalangat2130@gmail.com', '$2y$10$8tTM/KD65VyA.y3YhANBa.W3NYYOSVdkqRrlHF/IbXy491gaQ7c4W', 1, 'Rona May', 'Balangat', 'Calyucay, Sto.Domingo, Albay', '09998563419', 'rona.png', 1, '', '', '2024-03-28', ''),
(2, 'circuits@gmail.com', '$2y$10$CLm8LH71XgjqkBModfqPKexJD9v2BsoWeTewgJau5yiwxWMjm3BW2', 2, 'Information Technology', 'BUCS', 'Bicol University Main Campus B2', '09998563419', 'Circuits.jpg', 1, 'Screenshot_20240309_154245_GCash.jpg', '09998563419', '2024-03-28', 'Circuits'),
(3, 'angelahugo@gmail.com', '$2y$10$Pf20Zg2rpt4Zr24iJq75HOW5.hPzFi2z.l/WWRo8cpCHAeO80tcbu', 0, 'Angela Anne Therese', 'Hugo', 'Albay', '10898262458', 'female3.jpg', 1, '', '', '2024-03-28', ''),
(4, 'comsi@gmail.com', '$2y$10$bNLVzH3XlkTWUqOZEU8k5ubVU4cPXWACMpY4mJA88KKIh5roP7qq.', 2, 'Computer Science', 'BUCS', 'Bicol University Main Campus', '09998785748', 'Comsi_Logo.jpg', 1, 'Comsi_GcashQR.jpg', '09998785748', '2024-03-28', 'Comsi'),
(5, 'byeonwooseok@gmail.com', '$2y$10$cBEZqVhV5slfAL4KIL0LguMxfgjGlA2ngH.e.2qh8JrYuhjp1Xk5u', 0, 'Woo-Seok', 'Byeon', 'Seoul, South Korea', '10898262458', 'WooSeok.jpg', 1, '', '', '2024-04-10', ''),
(6, 'bicoluniversity-usc@gmail.com', '$2y$10$gmg1nuqaXsH5aVkS6UAEbuxL4uA4Msl5oonh6ivTa7UaBgjKjdQxa', 2, 'University Student Council', 'BU Main', 'BU Main Campus', '09863829172', '407127525_851599090089223_468135145711494632_n.jpg', 1, 'bu-usc_gcash.png', '09863829172', '2024-04-29', 'BU LABELS'),
(7, 'symbiosis@gmail.com', '$2y$10$gTUqzCHqYldnyr6/j4MUm.sNe/rNlaG8V2aBsP4llEA0aIsDLKG46', 2, 'Biology', 'BUCS B3', 'BUCS Main Campus', '09863829172', '347415420_653212253508957_7416280906203680132_n.jpg', 1, 'symbio_qrgcash.png', '09863829172', '2024-04-29', 'Symbiosis');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_notifs`
--
ALTER TABLE `admin_notifs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notifs`
--
ALTER TABLE `admin_notifs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
