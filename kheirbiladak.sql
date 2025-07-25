-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306 
-- Generation Time: 18 يونيو 2025 الساعة 23:24
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kheirbiladak`
--

-- --------------------------------------------------------

--
-- بنية الجدول `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` int(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `category`
--

INSERT INTO `category` (`c_id`, `name`, `img`, `description`) VALUES
(1, 'إلكترونيات', 255, 'أجهزة إلكترونية متنوعة'),
(2, 'ملابس', 255, 'ملابس رجالية ونسائية'),
(3, 'مستلزمات منزلية', 255, 'أدوات ومستلزمات للمنزل');

-- --------------------------------------------------------

--
-- بنية الجدول `discount`
--

CREATE TABLE `discount` (
  `d_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `expiry_date` date NOT NULL,
  `start_date` date NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `order`
--

CREATE TABLE `order` (
  `O_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `order`
--

INSERT INTO `order` (`O_id`, `order_date`, `address`, `status`, `price`, `u_id`) VALUES
(3, '2025-06-16', 'حزما, حزما, 504', 'قيد المعالجة', 8069.95, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `order_product`
--

CREATE TABLE `order_product` (
  `p_id` int(11) NOT NULL,
  `o_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `order_product`
--

INSERT INTO `order_product` (`p_id`, `o_id`, `count`, `price`) VALUES
(1, 3, 2, 999.99),
(2, 3, 2, 2499.99);

-- --------------------------------------------------------

--
-- بنية الجدول `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `product`
--

INSERT INTO `product` (`p_id`, `name`, `description`, `img`, `price`, `c_id`) VALUES
(1, 'هاتف ذكي', 'هاتف ذكي بمواصفات عالية', 'phone.jpg', 999.99, 1),
(2, 'لابتوب', 'جهاز لابتوب للعمل والدراسة', 'laptop.jpg', 2499.99, 1),
(3, 'قميص قطني', 'قميص قطني مريح وأنيق', 'shirt.jpg', 89.99, 2),
(4, 'حذاء رياضي', 'حذاء رياضي مريح للمشي', 'shoes.jpg', 199.99, 2),
(5, 'طقم أواني طبخ', 'طقم أواني طبخ من الستانلس ستيل', 'cookware.jpg', 299.99, 3),
(6, 'مكنسة كهربائية', 'مكنسة كهربائية قوية للتنظيف', 'vacuum.jpg', 399.99, 3);

-- --------------------------------------------------------

--
-- بنية الجدول `user`
--

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `user`
--

INSERT INTO `user` (`u_id`, `name`, `email`, `password`) VALUES
(1, 'ali', 'ali@gmail.com', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`O_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`p_id`,`o_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `O_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
