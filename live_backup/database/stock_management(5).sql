-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2021 at 10:28 AM
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
-- Table structure for table `stock_management`
--

CREATE TABLE `stock_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_item_id` bigint(20) DEFAULT NULL,
  `batch_id` bigint(20) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `document_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pack_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance_qty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_transit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1:purchase,2:sales,5:opening_stock',
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_management`
--

INSERT INTO `stock_management` (`id`, `stock_item_id`, `batch_id`, `warehouse_id`, `document_no`, `item_name`, `pack_code`, `uom`, `qty`, `balance_qty`, `rate`, `balance_value`, `total_balance`, `voucher_type`, `in_transit`, `description`, `created`, `status`, `active`, `created_at`, `updated_at`, `voucher_no`) VALUES
(586, 52, 7, 9, 'MR000014', 'Baking powder', '859874', 'Kg', '-25', NULL, '25', '-625', '625', 'Stock entry - material_issue', '1', NULL, '2021-11-18 04:53:55', 3, 1, NULL, NULL, 'MR-ST-2111180453'),
(587, 53, 8, 10, 'MR000014', 'Caustic soda', '78', 'Litre', '-20', NULL, '10', '-200', '200', 'Stock entry - material_issue', '1', NULL, '2021-11-18 04:53:55', 3, 1, NULL, NULL, 'MR-ST-2111180453'),
(588, 52, 7, 9, 'MR000014', 'Baking powder', '859874', 'Kg', '25', NULL, '25', '625', '1250', 'Stock entry - material_receipt', '1', NULL, '2021-11-18 04:54:45', 3, 1, NULL, NULL, 'MR-ST-2111180454'),
(589, 53, 8, 10, 'MR000014', 'Caustic soda', '78', 'Litre', '20', NULL, '10', '200', '400', 'Stock entry - material_receipt', '1', NULL, '2021-11-18 04:54:45', 3, 1, NULL, NULL, 'MR-ST-2111180454'),
(590, 55, 10, 11, 'MR000015', 'Shoda', '4587', 'Kg', '-30', NULL, '30', '-900', '900', 'Stock entry - material_issue', '1', NULL, '2021-11-18 04:56:01', 3, 1, NULL, NULL, 'MR-ST-2111180456'),
(591, 58, 13, 27, 'MR000016', ' Adipic acid', '856', 'Kg', '-50', NULL, '50', '-2500', '2500', 'Stock entry - material_transfer', '1', NULL, '2021-11-18 05:04:07', 3, 1, NULL, NULL, 'MR-ST-2111180504'),
(592, 58, 13, 27, 'MR000016', ' Adipic acid', '856', 'Kg', '50', NULL, '50', '2500', '2500', 'Stock entry - material_transfer', '1', NULL, '2021-11-18 05:04:07', 3, 1, NULL, NULL, 'MR-ST-2111180504'),
(593, 58, 13, 27, 'MR000017', ' Adipic acid', '856', 'Kg', '-25', NULL, '20', '-500', '2000', 'Stock entry - material_issue', '1', NULL, '2021-11-18 05:10:46', 3, 1, NULL, NULL, 'MR-ST-2111180510'),
(594, 58, 13, 27, 'MR000017', ' Adipic acid', '856', 'Kg', '25', NULL, '20', '500', '2500', 'Stock entry - material_receipt', '1', NULL, '2021-11-18 05:11:07', 3, 1, NULL, NULL, 'MR-ST-2111180511'),
(595, 53, NULL, 10, NULL, 'Caustic soda', '78', 'Litre', '1000', NULL, '100', '100000', '100400', 'Purchase Receipt', '1', NULL, '2021-11-25 06:19:01', 1, 1, NULL, NULL, 'MR-PR-2111250619'),
(596, 53, 8, 10, 'MR000018', 'Caustic soda', '78', 'Litre', '-150', NULL, '100', '-15000', '-14600', 'Stock entry - material_transfer', '1', NULL, '2021-11-25 06:20:55', 3, 1, NULL, NULL, 'MR-ST-2111250620'),
(597, 53, 8, 11, 'MR000018', 'Caustic soda', '78', 'Litre', '150', NULL, '100', '15000', '15400', 'Stock entry - material_transfer', '1', NULL, '2021-11-25 06:20:55', 3, 1, NULL, NULL, 'MR-ST-2111250620'),
(598, 53, 8, 10, 'MR000019', 'Caustic soda', '78', 'Litre', '-200', NULL, '100', '-20000', '-34600', 'Stock entry - material_issue', '1', NULL, '2021-11-25 06:21:56', 3, 1, NULL, NULL, 'MR-ST-2111250621'),
(601, 53, 8, 25, 'MR000020', 'Caustic soda', '78', 'Litre', '100', NULL, '20', '2000', '-32600', 'Stock entry - material_receipt', '1', NULL, '2021-11-25 09:21:33', 3, 1, NULL, NULL, 'MR-ST-2111250921'),
(606, 53, 8, 10, 'MR000023', 'Caustic soda', '78', 'Litre', '-40', NULL, '10', '-400', '-35000', 'Stock entry - material_transfer', '1', NULL, '2021-11-25 11:15:09', 3, 1, NULL, NULL, 'MR-ST-2111251115'),
(607, 53, 8, 27, 'MR000023', 'Caustic soda', '78', 'Litre', '40', NULL, '10', '400', '-34200', 'Stock entry - material_transfer', '1', NULL, '2021-11-25 11:15:09', 3, 1, NULL, NULL, 'MR-ST-2111251115'),
(608, 59, NULL, 26, NULL, 'Medicine-liquied', '741', 'Litre', '600', NULL, '10', '6000', '6000', 'Purchase Receipt', '1', NULL, '2021-11-25 11:24:38', 1, 1, NULL, NULL, 'MR-PR-2111251124'),
(609, 59, 14, 26, 'MR000024', 'Medicine-liquied', '741', 'Litre', '-100', NULL, '10', '-1000', '1000', 'Stock entry - material_transfer', '1', NULL, '2021-11-25 11:25:28', 3, 1, NULL, NULL, 'MR-ST-2111251125'),
(610, 59, 14, 27, 'MR000024', 'Medicine-liquied', '741', 'Litre', '100', NULL, '10', '1000', '1000', 'Stock entry - material_transfer', '1', NULL, '2021-11-25 11:25:28', 3, 1, NULL, NULL, 'MR-ST-2111251125'),
(611, 59, 14, 26, 'MR000025', 'Medicine-liquied', '741', 'Litre', '-50', NULL, '10', '-500', '500', 'Stock entry - material_issue', '1', NULL, '2021-11-25 11:28:28', 3, 1, NULL, NULL, 'MR-ST-2111251128'),
(612, 59, 14, 9, 'MR000025', 'Medicine-liquied', '741', 'Litre', '50', NULL, '10', '500', '1000', 'Stock entry - material_receipt', '1', NULL, '2021-11-25 11:29:23', 3, 1, NULL, NULL, 'MR-ST-2111251129'),
(613, 59, 14, 26, 'MR000026', 'Medicine-liquied', '741', 'Litre', '-20', NULL, '20', '-400', '100', 'Stock entry - material_transfer', '1', NULL, '2021-11-25 11:37:05', 3, 1, NULL, NULL, 'MR-ST-2111251137'),
(614, 59, 14, 26, 'MR000026', 'Medicine-liquied', '741', 'Litre', '20', NULL, '20', '400', '900', 'Stock entry - material_transfer', '1', NULL, '2021-11-25 11:37:05', 3, 1, NULL, NULL, 'MR-ST-2111251137'),
(615, 59, NULL, 26, NULL, 'Medicine-liquied', '741', 'GM', '-100', NULL, '10', '-1000', '-100', 'Sales Invoice', '1', NULL, '2021-11-25 11:42:33', 2, 1, NULL, NULL, 'MR-SO-2111251142'),
(616, 52, NULL, 26, 'MR000022', 'Baking powder', '859874', 'Kg', '50', NULL, '10', '500', '500', 'Stock entry - material_receipt', '1', NULL, '2021-11-26 05:59:22', 3, 1, NULL, NULL, 'MR-ST-2111260559'),
(617, 59, 14, 26, 'MR000023', 'Medicine-liquied', '741', 'Litre', '-100', NULL, '100', '-10000', '-9100', 'Stock entry - material_issue', '1', NULL, '2021-11-26 06:43:10', 3, 1, NULL, NULL, 'MR-ST-2111260643'),
(621, 62, NULL, 26, NULL, 'Detergent', '8569', '15', '2300', '2300', '1', '2300', '2300', 'Stock Entry - opening_stock', '1', NULL, '2021-11-26 07:34:45', 5, 1, NULL, NULL, NULL),
(622, 62, NULL, 9, NULL, 'Detergent', '8569', 'GM', '1300', '1300', '20', '26000', '28300', 'Purchase Receipt', '1', NULL, '2021-11-26 07:38:24', 1, 1, NULL, NULL, 'MR-PR-2111260738'),
(623, 62, 15, 25, 'MR000024', 'Detergent', '8569', 'GM', '-100', NULL, '10', '-1000', '1000', 'Stock entry - material_issue', '1', NULL, '2021-11-26 07:43:50', 3, 1, NULL, NULL, 'MR-ST-2111260743'),
(624, 62, NULL, 26, NULL, 'Detergent', '8569', 'GM', '100', '100', '100', '10000', '11000', 'Purchase Receipt', '1', NULL, '2021-11-26 07:51:34', 1, 1, NULL, NULL, 'MR-PR-2111260751'),
(625, 62, NULL, 9, NULL, 'Detergent', '8569', 'GM', '200', '200', '100', '20000', '31000', 'Purchase Receipt', '1', NULL, '2021-11-26 07:53:32', 1, 1, NULL, NULL, 'MR-PR-2111260753'),
(626, 62, NULL, 9, NULL, 'Detergent', '8569', 'GM', '100', '300', '10', '1000', '32000', 'Purchase Receipt', '1', NULL, '2021-11-26 08:37:37', 1, 1, NULL, NULL, 'MR-PR-2111260837'),
(627, 52, NULL, 9, NULL, 'Baking powder', '859874', 'Kg', '100', '100', '10', '1000', '1500', 'Purchase Receipt', '1', NULL, '2021-11-26 08:41:19', 1, 1, NULL, NULL, 'MR-PR-2111260841'),
(628, 52, NULL, 9, NULL, 'Baking powder', '859874', 'Kg', '10', '110', '10', '100', '1600', 'Purchase Receipt', '1', NULL, '2021-11-26 08:43:21', 1, 1, NULL, NULL, 'MR-PR-2111260843'),
(629, 62, 7, 9, NULL, 'Detergent', '8569', 'GM', '-100', NULL, '10', '-1000', '31000', 'Sales Invoice', '1', NULL, '2021-11-26 08:51:36', 2, 1, NULL, NULL, 'MR-SO-2111260851'),
(630, 62, NULL, 9, NULL, 'Detergent', '8569', 'GM', '-100', NULL, '10', '-1000', '30000', 'Sales Invoice', '1', NULL, '2021-11-26 08:58:47', 2, 1, NULL, NULL, 'MR-SO-2111260858'),
(631, 62, 7, 9, NULL, 'Detergent', '8569', 'GM', '-100', NULL, '10', '-1000', '29000', 'Sales Invoice', '1', NULL, '2021-11-26 09:04:37', 2, 1, NULL, NULL, 'MR-SO-2111260904'),
(632, 62, NULL, 9, NULL, 'Detergent', '8569', 'GM', '-100', '-100', '10', '-1000', '28000', 'Sales Invoice', '1', NULL, '2021-11-26 09:11:41', 2, 1, NULL, NULL, 'MR-SO-2111260911'),
(633, 62, NULL, 9, NULL, 'Detergent', '8569', 'GM', '-100', '200', '10', '-1000', '27000', 'Sales Invoice', '1', NULL, '2021-11-26 09:14:29', 2, 1, NULL, NULL, 'MR-SO-2111260914'),
(634, 62, NULL, 9, NULL, 'Detergent', '8569', 'GM', '-150', '50', '10', '-1500', '25500', 'Sales Invoice', '1', NULL, '2021-11-26 09:18:23', 2, 1, NULL, NULL, 'MR-SO-2111260918'),
(635, 62, NULL, 9, NULL, 'Detergent', '8569', 'GM', '-20', '30', '10', '-200', '25300', 'Sales Invoice', '1', NULL, '2021-11-26 09:20:08', 2, 1, NULL, NULL, 'MR-SO-2111260920'),
(636, 62, NULL, 9, 'MR000025', 'Detergent', '8569', 'GM', '-10', '20', '10', '-100', '25200', 'Stock entry - material_issue', '1', NULL, '2021-11-26 09:51:32', 3, 1, NULL, NULL, 'MR-ST-2111260951'),
(637, 62, NULL, 9, 'MR000026', 'Detergent', '8569', 'GM', '-10', '10', '10', '-100', '25100', 'Stock entry - material_issue', '1', NULL, '2021-11-26 09:52:58', 3, 1, NULL, NULL, 'MR-ST-2111260952'),
(638, 59, 12, 9, 'MR000026', 'Medicine-liquied', '741', 'Litre', '20', '20', '20', '400', '400', 'Stock entry - material_receipt', '1', NULL, '2021-11-26 09:55:14', 3, 1, NULL, NULL, 'MR-ST-2111260955'),
(639, 62, NULL, 9, 'MR000026', 'Detergent', '8569', 'GM', '10', '10', '10', '100', '25200', 'Stock entry - material_receipt', '1', NULL, '2021-11-26 09:55:14', 3, 1, NULL, NULL, 'MR-ST-2111260955'),
(640, 62, NULL, 9, 'MR000027', 'Detergent', '8569', 'GM', '-10', '0', '10', '-100', '25100', 'Stock entry - material_issue', '1', NULL, '2021-11-26 09:56:40', 3, 1, NULL, NULL, 'MR-ST-2111260956'),
(641, 62, NULL, 9, 'MR000027', 'Detergent', '8569', 'GM', '10', '10', '10', '100', '25200', 'Stock entry - material_receipt', '1', NULL, '2021-11-26 09:57:23', 3, 1, NULL, NULL, 'MR-ST-2111260957'),
(642, 63, NULL, 27, NULL, 'Phenyl', '789', '7', '1500', '1500', '1', '1500', '1500', 'Stock Entry - opening_stock', '1', NULL, '2021-11-26 10:00:31', 5, 1, NULL, NULL, NULL),
(643, 63, NULL, 27, NULL, 'Phenyl', '789', 'Litre', '2500', '4000', '10', '25000', '26500', 'Purchase Receipt', '1', NULL, '2021-11-26 10:05:39', 1, 1, NULL, NULL, 'MR-PR-2111261005'),
(644, 63, NULL, 27, NULL, 'Phenyl', '789', 'Litre', '200', '4200', '10', '2000', '28500', 'Purchase Receipt', '1', NULL, '2021-11-26 10:08:05', 1, 1, NULL, NULL, 'MR-PR-2111261008'),
(645, 63, NULL, 27, NULL, 'Phenyl', '789', 'Litre', '-400', '3800', '10', '-4000', '24500', 'Sales Invoice', '1', NULL, '2021-11-26 10:09:56', 2, 1, NULL, NULL, 'MR-SO-2111261009'),
(646, 63, 16, 27, 'MR000028', 'Phenyl', '789', 'Litre', '-250', '3550', '10', '-2500', '2500', 'Stock entry - material_issue', '1', NULL, '2021-11-26 10:12:10', 3, 1, NULL, NULL, 'MR-ST-2111261012'),
(647, 63, 8001, 27, 'MR000028', 'Phenyl', '789', 'Litre', '250', '250', '10', '2500', '2500', 'Stock entry - material_receipt', '1', NULL, '2021-11-26 10:13:14', 3, 1, NULL, NULL, 'MR-ST-2111261013'),
(648, 63, 16, 27, 'MR000029', 'Phenyl', '789', 'Litre', '-200', '50', '10', '-2000', '500', 'Stock entry - material_issue', '1', NULL, '2021-11-26 10:19:12', 3, 1, NULL, NULL, 'MR-ST-2111261019'),
(649, 63, 8001, 27, 'MR000029', 'Phenyl', '789', 'Litre', '200', '200', '10', '2000', '4500', 'Stock entry - material_receipt', '1', NULL, '2021-11-26 10:19:35', 3, 1, NULL, NULL, 'MR-ST-2111261019'),
(650, 63, 16, 27, 'MR000030', 'Phenyl', '789', 'Litre', '-50', '150', '10', '-500', '0', 'Stock entry - material_issue', '1', NULL, '2021-11-26 10:24:30', 3, 1, NULL, NULL, 'MR-ST-2111261024'),
(651, 63, 8001, 27, 'MR000030', 'Phenyl', '789', 'Litre', '50', '50', '10', '500', '5000', 'Stock entry - material_receipt', '1', NULL, '2021-11-26 10:25:08', 3, 1, NULL, NULL, 'MR-ST-2111261025'),
(652, 63, 16, 27, 'MR000031', 'Phenyl', '789', 'Litre', '-40', '10', '10', '-400', '-400', 'Stock entry - material_issue', '1', NULL, '2021-11-26 10:28:07', 3, 1, NULL, NULL, 'MR-ST-2111261028'),
(653, 63, 8001, 27, 'MR000031', 'Phenyl', '789', 'Litre', '40', '50', '10', '400', '5400', 'Stock entry - material_receipt', '1', NULL, '2021-11-26 10:28:30', 3, 1, NULL, NULL, 'MR-ST-2111261028'),
(654, 63, 16, 27, 'MR000032', 'Phenyl', '789', 'Litre', '-50', '0', '10', '-500', '-900', 'Stock entry - material_transfer', '1', NULL, '2021-11-26 10:29:10', 3, 1, NULL, NULL, 'MR-ST-2111261029'),
(655, 63, 16, 26, 'MR000032', 'Phenyl', '789', 'Litre', '50', '50', '10', '500', '100', 'Stock entry - material_transfer', '1', NULL, '2021-11-26 10:29:10', 3, 1, NULL, NULL, 'MR-ST-2111261029'),
(656, 64, NULL, 11, NULL, 'Acid', '789', '7', '100', '100', '1', '100', '100', 'Stock Entry - opening_stock', '1', NULL, '2021-11-26 10:32:04', 5, 1, NULL, NULL, NULL),
(657, 64, NULL, 11, NULL, 'Acid', '789', 'Litre', '100', '200', '10', '1000', '1100', 'Purchase Receipt', '1', NULL, '2021-11-26 10:34:25', 1, 1, NULL, NULL, 'MR-PR-2111261034'),
(658, 64, NULL, 11, NULL, 'Acid', '789', 'Litre', '-50', '150', '10', '-500', '600', 'Sales Invoice', '1', NULL, '2021-11-26 10:35:39', 2, 1, NULL, NULL, 'MR-SO-2111261035'),
(659, 64, NULL, 11, 'MR000033', 'Acid', '789', 'Litre', '-20', '130', '10', '-200', '400', 'Stock entry - material_issue', '1', NULL, '2021-11-26 10:36:13', 3, 1, NULL, NULL, 'MR-ST-2111261036'),
(660, 64, NULL, 11, 'MR000033', 'Acid', '789', 'Litre', '20', '150', '10', '200', '600', 'Stock entry - material_receipt', '1', NULL, '2021-11-26 10:36:35', 3, 1, NULL, NULL, 'MR-ST-2111261036');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stock_management`
--
ALTER TABLE `stock_management`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stock_management`
--
ALTER TABLE `stock_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=693;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
