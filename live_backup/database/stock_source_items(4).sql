-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2021 at 10:27 AM
-- Server version: 10.5.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u422338526_sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `stock_source_items`
--

CREATE TABLE `stock_source_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) NOT NULL COMMENT 'stocks,id',
  `batch_id` bigint(20) DEFAULT NULL,
  `target_batch_id` int(11) DEFAULT NULL,
  `source_warehouse` bigint(20) DEFAULT NULL,
  `target_warehouse` bigint(20) DEFAULT NULL,
  `item_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stock_items,id',
  `document_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_source_items`
--

INSERT INTO `stock_source_items` (`id`, `stock_id`, `batch_id`, `target_batch_id`, `source_warehouse`, `target_warehouse`, `item_id`, `document_no`, `item_name`, `item_code`, `rate`, `uom`, `quantity`, `voucher_type`, `created_at`, `updated_at`) VALUES
(178, 146, 7, NULL, 9, NULL, '52', 'MR00001', 'Baking powder', '859874', '10', '14', '10', NULL, '2021-10-22 11:03:54', '2021-10-22 11:03:54'),
(179, 147, 7, 9, 9, 9, '52', 'MR00001', 'Baking powder', '859874', '10', '14', '10', NULL, '2021-10-22 11:04:14', '2021-10-22 11:04:14'),
(180, 148, 10, 10, 11, 11, '55', 'MR00002', 'Shoda', '4587', '20', '14', '10', NULL, '2021-10-22 11:04:45', '2021-10-22 11:04:45'),
(181, 149, 7, NULL, 9, 10, '52', 'MR00003', 'Baking powder', '859874', '20', '14', '10', NULL, '2021-10-22 11:05:33', '2021-10-22 11:05:33'),
(182, 149, NULL, 8, 9, 10, '53', 'MR00003', 'Caustic soda', '78', '20', '7', '10', NULL, '2021-10-22 11:05:33', '2021-10-22 11:05:33'),
(183, 150, 7, NULL, 9, NULL, '52', 'MR00004', 'Baking powder', '859874', '20', '14', '10', NULL, '2021-11-09 10:34:06', '2021-11-09 10:34:06'),
(184, 151, 7, 7, 9, 9, '52', 'MR00004', 'Baking powder', '859874', '20', '14', '10', NULL, '2021-11-09 10:34:37', '2021-11-09 10:34:37'),
(185, 152, 7, NULL, 9, 10, '52', 'Select Document No', 'Baking powder', '859874', '20', '14', '10', NULL, '2021-11-09 10:35:38', '2021-11-09 10:36:12'),
(186, 152, 8, 8, 10, 10, '53', 'Select Document No', 'Caustic soda', '78', '15', '7', '10', NULL, '2021-11-09 10:35:38', '2021-11-09 10:36:12'),
(187, 152, 10, 10, 11, 11, '55', 'Select Document No', 'Shoda', '4587', '5', '14', '4', NULL, '2021-11-09 10:36:12', '2021-11-09 10:36:12'),
(188, 153, 10, NULL, 11, NULL, '55', 'MR00006', 'Shoda', '4587', '10', '14', '20', NULL, '2021-11-17 07:52:31', '2021-11-17 07:52:31'),
(189, 154, 10, 10, 11, 11, '55', 'MR00006', 'Shoda', '4587', '10', '14', '20', NULL, '2021-11-17 07:53:14', '2021-11-17 07:53:14'),
(191, 156, 11, NULL, 26, NULL, '58', 'MR00008', ' Adipic acid', '856', '20', '14', '10', NULL, '2021-11-17 09:37:06', '2021-11-17 09:37:06'),
(192, 157, 11, NULL, 26, 0, '58', 'MR00008', ' Adipic acid', '856', '20', '14', '10', NULL, '2021-11-17 09:37:43', '2021-11-17 09:37:43'),
(193, 158, 11, NULL, 9, NULL, '58', 'MR00009', ' Adipic acid', '856', '20', '14', '20', NULL, '2021-11-17 09:52:40', '2021-11-17 09:52:40'),
(194, 159, 11, 11, 9, 9, '58', 'MR00009', ' Adipic acid', '856', '20', '14', '20', NULL, '2021-11-17 09:53:41', '2021-11-17 09:53:41'),
(195, 160, 12, NULL, 24, NULL, '53', 'MR000010', 'Caustic soda', '78', '20', '7', '20', NULL, '2021-11-17 10:15:45', '2021-11-17 10:15:45'),
(196, 161, 12, 12, 24, 24, '53', 'MR000010', 'Caustic soda', '78', '20', '7', '20', NULL, '2021-11-17 10:16:15', '2021-11-17 10:16:15'),
(198, 163, 11, NULL, 9, NULL, '58', 'MR000012', ' Adipic acid', '856', '5', '14', '5', NULL, '2021-11-17 13:05:29', '2021-11-17 13:05:29'),
(199, 164, 11, 11, 9, 9, '58', 'MR000012', ' Adipic acid', '856', '5', '14', '5', NULL, '2021-11-17 13:06:07', '2021-11-17 13:06:07'),
(200, 165, 7, NULL, 9, NULL, '52', 'MR000013', 'Baking powder', '859874', '20', '14', '20', NULL, '2021-11-18 04:48:55', '2021-11-18 04:48:55'),
(201, 166, 7, 9, 9, 9, '52', 'MR000013', 'Baking powder', '859874', '20', '14', '20', NULL, '2021-11-18 04:49:53', '2021-11-18 04:49:53'),
(204, 169, 7, NULL, 9, NULL, '52', 'MR000014', 'Baking powder', '859874', '25', '14', '25', NULL, '2021-11-18 04:53:55', '2021-11-18 04:53:55'),
(205, 169, 8, NULL, 10, NULL, '53', 'MR000014', 'Caustic soda', '78', '10', '7', '20', NULL, '2021-11-18 04:53:55', '2021-11-18 04:53:55'),
(206, 170, 7, 9, 9, 9, '52', 'MR000014', 'Baking powder', '859874', '25', '14', '25', NULL, '2021-11-18 04:54:45', '2021-11-18 04:54:45'),
(207, 170, 8, 8, 10, 10, '53', 'MR000014', 'Caustic soda', '78', '10', '7', '20', NULL, '2021-11-18 04:54:45', '2021-11-18 04:54:45'),
(208, 171, 10, NULL, 11, NULL, '55', 'MR000015', 'Shoda', '4587', '30', '14', '30', NULL, '2021-11-18 04:56:01', '2021-11-18 04:56:01'),
(209, 172, 13, 13, 27, 27, '58', 'MR000016', ' Adipic acid', '856', '50', '14', '50', NULL, '2021-11-18 05:04:07', '2021-11-18 05:04:07'),
(210, 173, 13, NULL, 27, NULL, '58', 'MR000017', ' Adipic acid', '856', '20', '14', '25', NULL, '2021-11-18 05:10:46', '2021-11-18 05:10:46'),
(211, 174, 13, 13, 27, 27, '58', 'MR000017', ' Adipic acid', '856', '20', '14', '25', NULL, '2021-11-18 05:11:07', '2021-11-18 05:11:07'),
(212, 175, 8, NULL, 10, 11, '53', 'MR000018', 'Caustic soda', '78', '100', '7', '150', NULL, '2021-11-25 06:20:55', '2021-11-25 06:20:55'),
(213, 176, 8, NULL, 10, NULL, '53', 'MR000019', 'Caustic soda', '78', '100', '7', '200', NULL, '2021-11-25 06:21:56', '2021-11-25 06:21:56'),
(214, 177, 8, NULL, 10, 25, '53', 'MR000019', 'Caustic soda', '78', '100', '7', '200', NULL, '2021-11-25 09:07:40', '2021-11-25 09:07:40'),
(215, 178, 8, NULL, 10, NULL, '53', 'MR000020', 'Caustic soda', '78', '20', '7', '100', NULL, '2021-11-25 09:12:07', '2021-11-25 09:12:07'),
(216, 179, 8, NULL, 10, 25, '53', 'MR000020', 'Caustic soda', '78', '20', '7', '100', NULL, '2021-11-25 09:21:33', '2021-11-25 09:21:33'),
(217, 180, NULL, NULL, 27, 26, '52', 'MR000021', 'Baking powder', '859874', '10', '14', '50', NULL, '2021-11-25 09:42:39', '2021-11-25 09:42:39'),
(218, 181, NULL, NULL, 27, NULL, '52', 'MR000022', 'Baking powder', '859874', '10', '14', '50', NULL, '2021-11-25 09:44:20', '2021-11-25 09:44:20'),
(219, 182, 8, NULL, 10, 27, '53', 'MR000023', 'Caustic soda', '78', '10', '7', '40', NULL, '2021-11-25 11:15:09', '2021-11-25 11:15:09'),
(220, 183, 14, NULL, 26, 27, '59', 'MR000024', 'Medicine-liquied', '741', '10', '7', '100', NULL, '2021-11-25 11:25:28', '2021-11-25 11:25:28'),
(221, 184, 14, NULL, 26, NULL, '59', 'MR000025', 'Medicine-liquied', '741', '10', '7', '50', NULL, '2021-11-25 11:28:28', '2021-11-25 11:28:28'),
(222, 185, 14, NULL, 26, 9, '59', 'MR000025', 'Medicine-liquied', '741', '10', '7', '50', NULL, '2021-11-25 11:29:23', '2021-11-25 11:29:23'),
(223, 186, 14, NULL, 26, 26, '59', 'MR000026', 'Medicine-liquied', '741', '20', '7', '20', NULL, '2021-11-25 11:37:05', '2021-11-25 11:37:05'),
(224, 187, NULL, NULL, 27, 26, '52', 'MR000022', 'Baking powder', '859874', '10', '14', '50', NULL, '2021-11-26 05:59:22', '2021-11-26 05:59:22'),
(225, 188, 14, NULL, 26, NULL, '59', 'MR000023', 'Medicine-liquied', '741', '100', '7', '100', NULL, '2021-11-26 06:43:10', '2021-11-26 06:43:10'),
(226, 189, 15, NULL, 25, NULL, '62', 'MR000024', 'Detergent', '8569', '10', '15', '100', NULL, '2021-11-26 07:43:50', '2021-11-26 07:43:50'),
(227, 190, NULL, NULL, 9, NULL, '62', 'MR000025', 'Detergent', '8569', '10', '15', '10', NULL, '2021-11-26 09:48:02', '2021-11-26 09:48:02'),
(228, 191, NULL, NULL, 9, NULL, '62', 'MR000025', 'Detergent', '8569', '10', '15', '10', NULL, '2021-11-26 09:51:32', '2021-11-26 09:51:32'),
(229, 192, NULL, NULL, 9, NULL, '62', 'MR000026', 'Detergent', '8569', '10', '15', '10', NULL, '2021-11-26 09:52:58', '2021-11-26 09:52:58'),
(230, 193, 12, NULL, 26, 9, '59', 'MR000026', 'Medicine-liquied', '741', '20', '7', '20', NULL, '2021-11-26 09:55:14', '2021-11-26 09:55:14'),
(231, 193, NULL, NULL, 9, 9, '62', 'MR000026', 'Detergent', '8569', '10', '15', '10', NULL, '2021-11-26 09:55:14', '2021-11-26 09:55:14'),
(232, 194, NULL, NULL, 9, NULL, '62', 'MR000027', 'Detergent', '8569', '10', '15', '10', NULL, '2021-11-26 09:56:40', '2021-11-26 09:56:40'),
(233, 195, NULL, NULL, 9, 9, '62', 'MR000027', 'Detergent', '8569', '10', '15', '10', NULL, '2021-11-26 09:57:23', '2021-11-26 09:57:23'),
(234, 196, 16, NULL, 27, NULL, '63', 'MR000028', 'Phenyl', '789', '10', '7', '250', NULL, '2021-11-26 10:12:10', '2021-11-26 10:12:10'),
(235, 197, 8001, 16, 27, 27, '63', 'MR000028', 'Phenyl', '789', '10', '7', '250', NULL, '2021-11-26 10:13:14', '2021-11-26 10:13:14'),
(236, 198, 16, NULL, 27, NULL, '63', 'MR000029', 'Phenyl', '789', '10', '7', '200', NULL, '2021-11-26 10:19:12', '2021-11-26 10:19:12'),
(237, 199, 8001, 16, 27, 27, '63', 'MR000029', 'Phenyl', '789', '10', '7', '200', NULL, '2021-11-26 10:19:35', '2021-11-26 10:19:35'),
(238, 200, 16, NULL, 27, NULL, '63', 'MR000030', 'Phenyl', '789', '10', '7', '50', NULL, '2021-11-26 10:24:30', '2021-11-26 10:24:30'),
(239, 201, 8001, 16, 27, 27, '63', 'MR000030', 'Phenyl', '789', '10', '7', '50', NULL, '2021-11-26 10:25:08', '2021-11-26 10:25:08'),
(240, 202, 16, NULL, 27, NULL, '63', 'MR000031', 'Phenyl', '789', '10', '7', '40', NULL, '2021-11-26 10:28:07', '2021-11-26 10:28:07'),
(241, 203, 8001, 16, 27, 27, '63', 'MR000031', 'Phenyl', '789', '10', '7', '40', NULL, '2021-11-26 10:28:30', '2021-11-26 10:28:30'),
(242, 204, 16, NULL, 27, 26, '63', 'MR000032', 'Phenyl', '789', '10', '7', '50', NULL, '2021-11-26 10:29:10', '2021-11-26 10:29:10'),
(243, 205, NULL, NULL, 11, NULL, '64', 'MR000033', 'Acid', '789', '10', '7', '20', NULL, '2021-11-26 10:36:13', '2021-11-26 10:36:13'),
(244, 206, NULL, NULL, 11, 11, '64', 'MR000033', 'Acid', '789', '10', '7', '20', NULL, '2021-11-26 10:36:35', '2021-11-26 10:36:35'),
(272, 234, 7, NULL, 9, NULL, '52', 'MR000034', 'Baking powder', '859874', '10', '14', '60', NULL, '2021-11-29 05:32:43', '2021-11-29 05:32:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stock_source_items`
--
ALTER TABLE `stock_source_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stock_source_items`
--
ALTER TABLE `stock_source_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
