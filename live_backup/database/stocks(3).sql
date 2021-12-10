-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2021 at 10:26 AM
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
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock_transfer_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT 'transfer_types,id',
  `stock_transfer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) DEFAULT 1,
  `stock_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'issued',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `suffix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `series_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `voucher_no`, `stock_transfer_no`, `document_no`, `transaction_type`, `stock_transfer_type`, `date`, `active`, `stock_status`, `created_at`, `updated_at`, `suffix`, `prefix`, `number`, `series_type`) VALUES
(146, 'MR-ST-2110221103', '388st3', 'MR00001', NULL, 'material_issue', '2021-10-30', 1, 'transfer', '2021-10-22 11:03:54', '2021-10-22 11:03:54', NULL, NULL, NULL, NULL),
(147, 'MR-ST-2110221104', '389st3', 'MR00001', NULL, 'material_receipt', '2021-10-30', 1, 'transfer', '2021-10-22 11:04:14', '2021-10-22 11:04:14', NULL, NULL, NULL, NULL),
(148, 'MR-ST-2110221104', '390st3', 'MR00002', NULL, 'material_transfer', '2021-10-30', 1, 'transfer', '2021-10-22 11:04:45', '2021-10-22 11:04:45', NULL, NULL, NULL, NULL),
(149, 'MR-ST-2110221105', '391st3', 'MR00003', NULL, 'material_transfer', '2021-10-30', 1, 'transfer', '2021-10-22 11:05:33', '2021-10-22 11:05:33', NULL, NULL, NULL, NULL),
(150, 'MR-ST-2111091034', '392st3', 'MR00004', NULL, 'material_issue', '2021-11-04', 1, 'transfer', '2021-11-09 10:34:06', '2021-11-09 10:34:06', NULL, NULL, NULL, NULL),
(151, 'MR-ST-2111091034', '393st3', 'MR00004', NULL, 'material_receipt', '2021-11-01', 1, 'transfer', '2021-11-09 10:34:37', '2021-11-09 10:34:37', NULL, NULL, NULL, NULL),
(152, 'MR-ST-2111091035', '394st3', 'MR00005', NULL, 'material_transfer', '2021-11-01', 1, 'transfer', '2021-11-09 10:35:38', '2021-11-09 10:35:38', NULL, NULL, NULL, NULL),
(153, 'MR-ST-2111170752', '395st3', 'MR00006', NULL, 'material_issue', '2021-11-01', 1, 'transfer', '2021-11-17 07:52:31', '2021-11-17 07:52:31', NULL, NULL, NULL, NULL),
(154, 'MR-ST-2111170753', '396st3', 'MR00006', NULL, 'material_receipt', '2021-11-01', 1, 'transfer', '2021-11-17 07:53:14', '2021-11-17 07:53:14', NULL, NULL, NULL, NULL),
(156, 'MR-ST-2111170937', '398st3', 'MR00008', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-17 09:37:06', '2021-11-17 09:37:06', NULL, NULL, NULL, NULL),
(157, 'MR-ST-2111170937', '399st3', 'MR00008', NULL, 'material_receipt', '2021-11-03', 1, 'transfer', '2021-11-17 09:37:43', '2021-11-17 09:37:43', NULL, NULL, NULL, NULL),
(158, 'MR-ST-2111170952', '400st3', 'MR00009', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-17 09:52:40', '2021-11-17 09:52:40', NULL, NULL, NULL, NULL),
(159, 'MR-ST-2111170953', '401st3', 'MR00009', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-17 09:53:41', '2021-11-17 09:53:41', NULL, NULL, NULL, NULL),
(160, 'MR-ST-2111171015', '402st3', 'MR000010', NULL, 'material_issue', '2021-11-27', 1, 'transfer', '2021-11-17 10:15:45', '2021-11-17 10:15:45', NULL, NULL, NULL, NULL),
(161, 'MR-ST-2111171016', '403st3', 'MR000010', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-17 10:16:15', '2021-11-17 10:16:15', NULL, NULL, NULL, NULL),
(163, 'MR-ST-2111170105', '405st3', 'MR000012', NULL, 'material_issue', '2021-11-27', 1, 'transfer', '2021-11-17 13:05:29', '2021-11-17 13:05:29', NULL, NULL, NULL, NULL),
(164, 'MR-ST-2111170106', '406st3', 'MR000012', NULL, 'material_receipt', '2021-11-01', 1, 'transfer', '2021-11-17 13:06:07', '2021-11-17 13:06:07', NULL, NULL, NULL, NULL),
(165, 'MR-ST-2111180448', '407st3', 'MR000013', NULL, 'material_issue', '2021-11-18', 1, 'transfer', '2021-11-18 04:48:55', '2021-11-18 04:48:55', NULL, NULL, NULL, NULL),
(166, 'MR-ST-2111180449', '408st3', 'MR000013', NULL, 'material_receipt', '2021-11-18', 1, 'transfer', '2021-11-18 04:49:53', '2021-11-18 04:49:53', NULL, NULL, NULL, NULL),
(169, 'MR-ST-2111180453', '411st3', 'MR000014', NULL, 'material_issue', '2021-11-18', 1, 'transfer', '2021-11-18 04:53:55', '2021-11-18 04:53:55', NULL, NULL, NULL, NULL),
(170, 'MR-ST-2111180454', '412st3', 'MR000014', NULL, 'material_receipt', '2021-11-18', 1, 'transfer', '2021-11-18 04:54:45', '2021-11-18 04:54:45', NULL, NULL, NULL, NULL),
(171, 'MR-ST-2111180456', '413st3', 'MR000015', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-18 04:56:01', '2021-11-18 04:56:01', NULL, NULL, NULL, NULL),
(172, 'MR-ST-2111180504', '414st3', 'MR000016', NULL, 'material_transfer', '2021-11-01', 1, 'transfer', '2021-11-18 05:04:07', '2021-11-18 05:04:07', NULL, NULL, NULL, NULL),
(173, 'MR-ST-2111180510', '415st3', 'MR000017', NULL, 'material_issue', '2021-11-18', 1, 'transfer', '2021-11-18 05:10:46', '2021-11-18 05:10:46', NULL, NULL, NULL, NULL),
(174, 'MR-ST-2111180511', '416st3', 'MR000017', NULL, 'material_receipt', '2021-11-18', 1, 'transfer', '2021-11-18 05:11:07', '2021-11-18 05:11:07', NULL, NULL, NULL, NULL),
(175, 'MR-ST-2111250620', '417st3', 'MR000018', NULL, 'material_transfer', '2021-11-25', 1, 'transfer', '2021-11-25 06:20:55', '2021-11-25 06:20:55', NULL, NULL, NULL, NULL),
(176, 'MR-ST-2111250621', '418st3', 'MR000019', NULL, 'material_issue', '2021-11-25', 1, 'transfer', '2021-11-25 06:21:56', '2021-11-25 06:21:56', NULL, NULL, NULL, NULL),
(177, 'MR-ST-2111250907', '419st3', 'MR000019', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-25 09:07:40', '2021-11-25 09:07:40', NULL, NULL, NULL, NULL),
(178, 'MR-ST-2111250912', '420st3', 'MR000020', NULL, 'material_issue', '2021-11-27', 1, 'transfer', '2021-11-25 09:12:07', '2021-11-25 09:12:07', NULL, NULL, NULL, NULL),
(179, 'MR-ST-2111250921', '421st3', 'MR000020', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-25 09:21:33', '2021-11-25 09:21:33', NULL, NULL, NULL, NULL),
(180, 'MR-ST-2111250942', '422st3', 'MR000021', NULL, 'material_transfer', '2021-11-25', 1, 'transfer', '2021-11-25 09:42:39', '2021-11-25 09:42:39', NULL, NULL, NULL, NULL),
(181, 'MR-ST-2111250944', '423st3', 'MR000022', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-25 09:44:20', '2021-11-25 09:44:20', NULL, NULL, NULL, NULL),
(182, 'MR-ST-2111251115', '424st3', 'MR000023', NULL, 'material_transfer', '2021-11-25', 1, 'transfer', '2021-11-25 11:15:09', '2021-11-25 11:15:09', NULL, NULL, NULL, NULL),
(183, 'MR-ST-2111251125', '425st3', 'MR000024', NULL, 'material_transfer', '2021-11-27', 1, 'transfer', '2021-11-25 11:25:28', '2021-11-25 11:25:28', NULL, NULL, NULL, NULL),
(184, 'MR-ST-2111251128', '426st3', 'MR000025', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-25 11:28:28', '2021-11-25 11:28:28', NULL, NULL, NULL, NULL),
(185, 'MR-ST-2111251129', '427st3', 'MR000025', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-25 11:29:23', '2021-11-25 11:29:23', NULL, NULL, NULL, NULL),
(186, 'MR-ST-2111251137', '428st3', 'MR000026', NULL, 'material_transfer', '2021-11-30', 1, 'transfer', '2021-11-25 11:37:05', '2021-11-25 11:37:05', NULL, NULL, NULL, NULL),
(187, 'MR-ST-2111260559', '429st3', 'MR000022', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-26 05:59:22', '2021-11-26 05:59:22', NULL, NULL, NULL, NULL),
(188, 'MR-ST-2111260643', '430st3', 'MR000023', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-26 06:43:10', '2021-11-26 06:43:10', NULL, NULL, NULL, NULL),
(189, 'MR-ST-2111260743', '431st3', 'MR000024', NULL, 'material_issue', '2021-11-03', 1, 'transfer', '2021-11-26 07:43:50', '2021-11-26 07:43:50', NULL, NULL, NULL, NULL),
(191, 'MR-ST-2111260951', '432st3', 'MR000025', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-26 09:51:32', '2021-11-26 09:51:32', NULL, NULL, NULL, NULL),
(192, 'MR-ST-2111260952', '433st3', 'MR000026', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-26 09:52:58', '2021-11-26 09:52:58', NULL, NULL, NULL, NULL),
(193, 'MR-ST-2111260955', '434st3', 'MR000026', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-26 09:55:14', '2021-11-26 09:55:14', NULL, NULL, NULL, NULL),
(194, 'MR-ST-2111260956', '435st3', 'MR000027', NULL, 'material_issue', '2021-11-26', 1, 'transfer', '2021-11-26 09:56:40', '2021-11-26 09:56:40', NULL, NULL, NULL, NULL),
(195, 'MR-ST-2111260957', '436st3', 'MR000027', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-26 09:57:23', '2021-11-26 09:57:23', NULL, NULL, NULL, NULL),
(196, 'MR-ST-2111261012', '437st3', 'MR000028', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-26 10:12:10', '2021-11-26 10:12:10', NULL, NULL, NULL, NULL),
(197, 'MR-ST-2111261013', '438st3', 'MR000028', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-26 10:13:14', '2021-11-26 10:13:14', NULL, NULL, NULL, NULL),
(198, 'MR-ST-2111261019', '439st3', 'MR000029', NULL, 'material_issue', '2021-11-26', 1, 'transfer', '2021-11-26 10:19:12', '2021-11-26 10:19:12', NULL, NULL, NULL, NULL),
(199, 'MR-ST-2111261019', '440st3', 'MR000029', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-26 10:19:35', '2021-11-26 10:19:35', NULL, NULL, NULL, NULL),
(200, 'MR-ST-2111261024', '441st3', 'MR000030', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-26 10:24:30', '2021-11-26 10:24:30', NULL, NULL, NULL, NULL),
(201, 'MR-ST-2111261025', '442st3', 'MR000030', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-26 10:25:08', '2021-11-26 10:25:08', NULL, NULL, NULL, NULL),
(202, 'MR-ST-2111261028', '443st3', 'MR000031', NULL, 'material_issue', '2021-11-30', 1, 'transfer', '2021-11-26 10:28:07', '2021-11-26 10:28:07', NULL, NULL, NULL, NULL),
(203, 'MR-ST-2111261028', '444st3', 'MR000031', NULL, 'material_receipt', '2021-11-02', 1, 'transfer', '2021-11-26 10:28:30', '2021-11-26 10:28:30', NULL, NULL, NULL, NULL),
(204, 'MR-ST-2111261029', '445st3', 'MR000032', NULL, 'material_transfer', '2021-11-30', 1, 'transfer', '2021-11-26 10:29:10', '2021-11-26 10:29:10', NULL, NULL, NULL, NULL),
(205, 'MR-ST-2111261036', '446st3', 'MR000033', NULL, 'material_issue', '2021-11-01', 1, 'transfer', '2021-11-26 10:36:13', '2021-11-26 10:36:13', NULL, NULL, NULL, NULL),
(206, 'MR-ST-2111261036', '447st3', 'MR000033', NULL, 'material_receipt', '2021-11-30', 1, 'transfer', '2021-11-26 10:36:35', '2021-11-26 10:36:35', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
