-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 01, 2023 at 08:13 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `user_role`) VALUES
(1, 'Budi', '202cb962ac59075b964b07152d234b70', 'Admin'),
(6, 'richard', '202cb962ac59075b964b07152d234b70', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `bisnis_partner`
--

CREATE TABLE `bisnis_partner` (
  `id_bisnis_partner` int NOT NULL,
  `seller_business` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_num` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  `bisnis_partner_name` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bisnis_partner`
--

INSERT INTO `bisnis_partner` (`id_bisnis_partner`, `seller_business`, `address`, `phone_num`, `city`, `password`, `user_role`, `bisnis_partner_name`, `category`, `description`, `logo`) VALUES
(101, 'Rudy', 'Jl. Kelapa Gading no 56', '082116045354', 'Jakarta', '202cb962ac59075b964b07152d234b70', 'Business Partner', 'Skeeter\'s', 'Food and Beverage', 'Halo', 'BLogo1.jpg'),
(102, 'Reynard', 'Jl. Kebonjeruk no 23', '082356044210', 'Bandung', '202cb962ac59075b964b07152d234b70', 'Business Partner', 'Danny Boy', 'Food and Beverage', NULL, 'BLogo2.jpg'),
(103, 'Silla', 'Jl. Sukatenang no 10', '082177889257', 'Cirebon', '202cb962ac59075b964b07152d234b70', 'Business Partner', 'Delice Perle', 'Food and Beverage', NULL, 'BLogo3.jpg'),
(104, 'Darren', 'Jl Asia Afrika no 17', '082116044210', 'Bandung', '202cb962ac59075b964b07152d234b70', 'Business Partner', 'Burger Hut', 'Food and Beverage', NULL, 'BLogo4.jpg'),
(105, 'William', 'Jl Apel No. 1', '086748734897', 'Bandung', '202cb962ac59075b964b07152d234b70', 'Business Partner', 'Techcloset', 'Fashion', NULL, 'FLogo1.jpg'),
(106, 'Daniel', 'Jl. Kemuning no 23 ', '082116728129', 'Cirebon', '202cb962ac59075b964b07152d234b70', 'Business Partner', 'Feaner', 'Fashion', NULL, 'FLogo2.jpg'),
(107, 'Rizki', 'Jl. Mekar Wangi no 30', '082116044210', 'Bandung', '202cb962ac59075b964b07152d234b70', 'Business Partner', 'Urban ', 'Fashion', '-', 'FLogo3.jpg'),
(108, 'Budiman', 'Jl. ternate no 12', '08212731313', 'Bogor', '202cb962ac59075b964b07152d234b70', 'Business Partner', 'Elegant ', 'Fashion', NULL, 'FLogo4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `id_order` varchar(255) NOT NULL,
  `id_product` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `temporary_price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`id_order`, `id_product`, `quantity`, `temporary_price`) VALUES
('OI003', 'PD002', 14, 12000),
('OI004', 'PD003', 6, 8000),
('OI006', 'PD001', 12, 8000),
('OI007', 'PD001', 12, 8000),
('OI008', 'PD001', 22, 8000),
('OI009', 'PD002', 11, 12000);

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `id_order` varchar(255) NOT NULL,
  `id_user` int NOT NULL,
  `total_price` int DEFAULT NULL,
  `order_date` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`id_order`, `id_user`, `total_price`, `order_date`, `status`) VALUES
('OI003', 1, 168000, '2023-06-12', 'Delivery'),
('OI004', 1, 48000, '2023-06-14', 'Payment Validation'),
('OI006', 4, 96000, '2023-06-13', 'Delivery'),
('OI007', 1, 96000, '2023-06-12', 'Payment Validation'),
('OI008', 1, 176000, '2023-06-14', 'Delivery'),
('OI009', 1, 132000, '2023-06-15', 'No Payment Validation');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_product` varchar(255) NOT NULL,
  `id_bisnis_partner` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image_product` varchar(255) NOT NULL,
  `status_product` varchar(255) DEFAULT NULL,
  `ingredients_product` varchar(225) NOT NULL,
  `price` int NOT NULL,
  `category_product` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description_product` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_product`, `id_bisnis_partner`, `product_name`, `image_product`, `status_product`, `ingredients_product`, `price`, `category_product`, `description_product`) VALUES
('PD001', 101, 'Cookies', 'Food1.jpg', '', '', 8000, 'Cookies', ''),
('PD002', 101, 'Macaroon', 'Food2.jpg', 'Halal', '', 12000, 'Cookies', ''),
('PD003', 101, 'Checkerboard', 'Food3.jpg', 'Halal', 'Vanila, Coklat, Tepung, Gula, dll', 7000, 'Cokies', 'terbuat dari bahan berkualitas');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_num` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `user_name`, `address`, `phone_num`, `password`, `user_role`) VALUES
(1, 'Gnia', 'Jl Sumber Nanjung III no 8', '81214914609', '202cb962ac59075b964b07152d234b70', 'User'),
(4, 'Rangga', 'Jl. Cibubur no 45', '0834526541123', '202cb962ac59075b964b07152d234b70', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `bisnis_partner`
--
ALTER TABLE `bisnis_partner`
  ADD PRIMARY KEY (`id_bisnis_partner`);

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id` (`id_bisnis_partner`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bisnis_partner`
--
ALTER TABLE `bisnis_partner`
  MODIFY `id_bisnis_partner` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail`
--
ALTER TABLE `detail`
  ADD CONSTRAINT `detail_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orderitem` (`id_order`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detail_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_bisnis_partner`) REFERENCES `bisnis_partner` (`id_bisnis_partner`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
