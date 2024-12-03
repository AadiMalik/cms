-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 11:02 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `account_type_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `opening_balance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `opening_cr` decimal(8,2) NOT NULL DEFAULT 0.00,
  `opening_dr` decimal(8,2) NOT NULL DEFAULT 0.00,
  `is_cash_account` int(11) NOT NULL DEFAULT 0,
  `level` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `code`, `name`, `parent_id`, `account_type_id`, `is_active`, `opening_balance`, `opening_cr`, `opening_dr`, `is_cash_account`, `level`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, '123', 'account', 0, 1, 1, '0.00', '0.00', '0.00', 1, 1, 0, 1, 1, NULL, '2024-09-05 15:31:09', '2024-09-05 16:10:06'),
(2, '12345', 'Account child1', 0, 1, 1, '0.00', '0.00', '0.00', 1, 1, 1, 1, NULL, 1, '2024-09-05 16:10:54', '2024-09-05 16:16:46'),
(3, '1234', 'parent child1', 0, 0, 1, '0.00', '0.00', '0.00', 0, 1, 1, 1, NULL, 1, '2024-09-05 16:16:33', '2024-09-05 16:16:41'),
(4, '123456', 'child1', 1, 1, 1, '0.00', '0.00', '0.00', 0, 2, 1, 1, NULL, 1, '2024-09-05 16:40:16', '2024-09-05 16:50:33'),
(5, '1234', 'child', 1, 1, 1, '0.00', '0.00', '0.00', 0, 2, 0, 1, NULL, NULL, '2024-09-05 16:55:24', '2024-09-20 17:30:05'),
(6, '12345', 'child2', 1, 1, 1, '0.00', '0.00', '0.00', 0, 2, 0, 1, NULL, NULL, '2024-09-05 16:56:24', '2024-09-05 16:56:24'),
(7, '12', 'Parent', 0, 2, 1, '0.00', '0.00', '0.00', 0, 1, 0, 1, NULL, NULL, '2024-09-05 16:57:14', '2024-09-05 19:18:19'),
(8, '12-001', 'Supplier Account', 7, 2, 1, '0.00', '0.00', '0.00', 0, 2, 0, 1, NULL, NULL, '2024-09-20 17:30:39', '2024-09-20 17:30:39'),
(9, '002', 'Local Karigar', 0, 1, 1, '0.00', '0.00', '0.00', 0, 1, 0, 1, NULL, NULL, '2024-09-23 17:52:22', '2024-09-23 17:52:22'),
(10, '002-001', 'Local Karigar PKR', 9, 1, 1, '0.00', '0.00', '0.00', 0, 2, 0, 1, NULL, NULL, '2024-09-23 17:52:57', '2024-09-23 17:52:57'),
(11, '002-002', 'Local Karigar AU', 9, 1, 1, '0.00', '0.00', '0.00', 0, 2, 0, 1, NULL, NULL, '2024-09-23 17:53:12', '2024-09-23 17:53:12'),
(12, '002-003', 'Local Karigar $', 9, 1, 1, '0.00', '0.00', '0.00', 0, 2, 0, 1, NULL, NULL, '2024-09-23 17:53:28', '2024-09-23 17:53:28');

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'type 1', NULL, NULL),
(2, 'Type 2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bead_types`
--

CREATE TABLE `bead_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bead_types`
--

INSERT INTO `bead_types` (`id`, `name`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Natural', 1, 1, 1, NULL, 1, '2024-10-26 19:04:14', '2024-10-26 19:04:22'),
(2, 'Ruby', 1, 0, 1, NULL, NULL, '2024-10-26 19:04:30', '2024-10-26 19:04:30'),
(3, 'Sapphire', 1, 0, 1, NULL, NULL, '2024-10-26 19:04:41', '2024-10-26 19:04:41');

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `purchase_account_id` int(11) DEFAULT NULL,
  `sale_account_id` int(11) DEFAULT NULL,
  `cash_account_id` int(11) DEFAULT NULL,
  `revenue_account_id` int(11) DEFAULT NULL,
  `bank_account_id` int(11) DEFAULT NULL,
  `card_account_id` int(11) DEFAULT NULL,
  `advance_account_id` int(11) DEFAULT NULL,
  `gold_impurity_account_id` int(11) DEFAULT NULL,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_settings`
--

INSERT INTO `company_settings` (`id`, `company_id`, `purchase_account_id`, `sale_account_id`, `cash_account_id`, `revenue_account_id`, `bank_account_id`, `card_account_id`, `advance_account_id`, `gold_impurity_account_id`, `createdby_id`, `updatedby_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 10, 11, 12, 8, 5, 6, 12, 12, 1, NULL, '2024-11-22 09:39:32', '2024-11-22 09:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `anniversary_date` date DEFAULT NULL,
  `ring_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bangle_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnic_images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `account_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `contact`, `email`, `cnic`, `address`, `date_of_birth`, `anniversary_date`, `ring_size`, `bangle_size`, `reference`, `comment`, `bank_name`, `account_title`, `account_no`, `cnic_images`, `is_active`, `account_id`, `is_deleted`, `createdby_id`, `updatedby_id`, `created_at`, `updated_at`, `deletedby_id`) VALUES
(1, 'Idola Russell', 'Provident', 'lexozozadu@mailinator.com', 'Quod praesent', 'Quia molestias neque architecto non ut non incidunt eum minim eius maxime cumque lorem sunt aut ut', '1985-08-14', '1977-01-03', 'Aute offic', 'Nostrum do', NULL, NULL, NULL, NULL, NULL, NULL, 1, 6, 1, 1, 1, '2024-09-09 18:40:22', '2024-09-09 18:41:08', 1),
(2, 'Merrill Benson', '123456789023467', NULL, 'Dolorem cupiditate non necessitatibus est eum accusamus consequat Quas exercitation sit eu earum deleniti aliquam et velit dolor', 'Minim delectus nostrud magna irure in accusamus cillum aliquip perferendis deleniti neque officiis adipisicing laborum Molestiae enim quis qui incidunt', '1975-09-04', '2022-02-11', '13', '2.1', 'Voluptatem deleniti a ut harum quis est sed sed officiis accusantium blanditiis asperiores sint placeat sunt quae ut minim', 'Ipsa beatae recusandae Eveniet et necessitatibus', NULL, NULL, NULL, '[\"cnic_images\\/1726089432-66e208d8822a3.jpg\",\"cnic_images\\/1726089432-66e208d882a3f.jpg\",\"cnic_images\\/1726089432-66e208d882eb5.jpg\",\"cnic_images\\/1726089432-66e208d8833d0.jpg\"]', 1, NULL, 0, 1, 1, '2024-09-11 16:13:46', '2024-09-11 16:40:05', NULL),
(3, 'Shahid', '03214000000', NULL, '000000', 'ns', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, NULL, '2024-10-17 19:25:35', '2024-10-17 19:25:35', NULL),
(4, 'Ahmad Suleman', '03214300000', 'admin@admin.com', NULL, 'Liberty', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, NULL, '2024-10-27 23:56:28', '2024-10-27 23:56:28', NULL),
(5, 'Mrs Riffat Sahiba', '00447440472359', NULL, NULL, 'Bradford England UK', NULL, NULL, '15', '2.3', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, NULL, '2024-11-20 18:05:39', '2024-11-20 18:05:39', NULL),
(6, 'Adnan Junaid', '03002871891', NULL, NULL, 'Pakpattan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 1, NULL, '2024-11-26 02:01:14', '2024-11-26 02:01:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `diamond_clarities`
--

CREATE TABLE `diamond_clarities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diamond_clarities`
--

INSERT INTO `diamond_clarities` (`id`, `name`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'VVS1', 1, 0, 1, NULL, NULL, '2024-11-07 16:33:44', '2024-11-07 16:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `diamond_colors`
--

CREATE TABLE `diamond_colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diamond_colors`
--

INSERT INTO `diamond_colors` (`id`, `name`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'E', 1, 0, 1, NULL, NULL, '2024-10-26 19:44:49', '2024-10-26 19:44:49'),
(2, 'F', 1, 0, 1, NULL, NULL, '2024-10-26 19:44:54', '2024-10-26 19:44:54'),
(3, 'G', 1, 0, 1, NULL, NULL, '2024-10-26 19:44:59', '2024-10-26 19:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `diamond_cuts`
--

CREATE TABLE `diamond_cuts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diamond_cuts`
--

INSERT INTO `diamond_cuts` (`id`, `name`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Round', 1, 0, 1, NULL, NULL, '2024-10-26 19:57:06', '2024-10-26 19:57:06');

-- --------------------------------------------------------

--
-- Table structure for table `diamond_types`
--

CREATE TABLE `diamond_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diamond_types`
--

INSERT INTO `diamond_types` (`id`, `name`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Setting Size 0 to 4 Cents', 1, 0, 1, 1, NULL, '2024-10-26 19:05:35', '2024-10-26 19:08:58'),
(2, 'Pointer 7 to 12 Cents', 1, 0, 1, 1, NULL, '2024-10-26 19:05:46', '2024-10-26 19:08:50'),
(3, 'Pointer 12.1 to 20 Cents', 1, 0, 1, NULL, NULL, '2024-10-26 19:06:26', '2024-10-26 19:06:26'),
(4, 'Setting Size 4.1 to 6.9 Cents', 1, 0, 1, NULL, NULL, '2024-10-26 19:08:41', '2024-10-26 19:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `dollar_rates`
--

CREATE TABLE `dollar_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `createdby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dollar_rates`
--

INSERT INTO `dollar_rates` (`id`, `rate`, `createdby_id`, `created_at`, `updated_at`) VALUES
(1, '277.320', 1, '2024-09-27 08:19:04', '2024-09-27 08:19:04'),
(2, '280.000', 1, '2024-09-27 18:19:30', '2024-09-27 18:19:30'),
(3, '277.750', 1, '2024-10-01 15:02:45', '2024-10-01 15:02:45'),
(4, '277.750', 1, '2024-10-01 15:02:46', '2024-10-01 15:02:46'),
(5, '277.600', 1, '2024-10-11 17:56:15', '2024-10-11 17:56:15'),
(6, '277.000', 1, '2024-10-26 19:11:28', '2024-10-26 19:11:28');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_relation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Full-time, Part-time, Contract',
  `date_of_joining` date DEFAULT NULL,
  `shift` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'shift time in string',
  `salary` decimal(8,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_overtime` tinyint(1) NOT NULL DEFAULT 0,
  `sick_leave` decimal(8,2) NOT NULL DEFAULT 0.00,
  `casual_leave` decimal(8,2) NOT NULL DEFAULT 0.00,
  `annual_leave` decimal(8,2) NOT NULL DEFAULT 0.00,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 for active, 0 for inactive',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `name`, `cnic`, `gender`, `date_of_birth`, `contact`, `email`, `address`, `emergency_name`, `emergency_contact`, `emergency_relation`, `job_role`, `department`, `employee_type`, `date_of_joining`, `shift`, `salary`, `payment_method`, `bank_name`, `account_title`, `account_no`, `is_overtime`, `sick_leave`, `casual_leave`, `annual_leave`, `picture`, `account_id`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Quidem atque dolores esse aliquip quaerat optio voluptas dolorem deleniti aperiam ab cumque tenetur', 'Fallon Armstrong', 'Sed dolor consectetur sequi adipisci Nam nostrum delectus id debitis ut', 'Male', '1974-06-21', 'Sit mollit tempora vel id recusandae Velit quos pariatur Inventore duis sequi blanditiis duis ut', 'kozijowyja@mailinator.com', 'Vel ullam sit quisquam et maiores qui cillum totam ea inventore ea minim alias', 'Erasmus Acosta', 'Esse magna iusto perspiciatis et exercitationem et voluptatem sed omnis est occaecat', 'Non magna similique suscipit quaerat et sit facere aspernatur suscipit deserunt dolor dolores ut sed impedit', 'Dolorem dolorem nihil ex numquam', 'Production', 'Contract', '1980-02-04', '02PM-10PM', '120000.00', 'Bank Transfer', 'Dawn Harding', 'Ullamco est beatae non corporis autem amet aut quos ex lorem id exercitationem qui aliquip eaque omnis amet illum culpa', 'Assumenda iste e', 0, '8.00', '8.00', '14.00', 'picture/1726100954-66e235daf41d6.jpg', 6, 1, 1, 1, 1, 1, '2024-09-11 19:25:46', '2024-09-11 19:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finish_products`
--

CREATE TABLE `finish_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ratti_kaat_id` int(11) DEFAULT NULL,
  `job_purchase_id` int(12) DEFAULT NULL,
  `ratti_kaat_detail_id` int(11) DEFAULT NULL,
  `job_purchase_detail_id` int(12) DEFAULT NULL,
  `tag_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gold_carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `scale_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `bead_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `stones_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `diamond_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `net_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `waste_per` decimal(18,3) NOT NULL DEFAULT 0.000,
  `waste` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gross_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `making_gram` decimal(18,3) NOT NULL DEFAULT 0.000,
  `making` decimal(18,3) NOT NULL DEFAULT 0.000,
  `laker` decimal(18,3) NOT NULL DEFAULT 0.000,
  `bead_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `stones_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `diamond_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_bead_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_stones_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_diamond_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `other_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gold_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_gold_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_saled` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finish_products`
--

INSERT INTO `finish_products` (`id`, `ratti_kaat_id`, `job_purchase_id`, `ratti_kaat_detail_id`, `job_purchase_detail_id`, `tag_no`, `barcode`, `product_id`, `warehouse_id`, `picture`, `gold_carat`, `scale_weight`, `bead_weight`, `stones_weight`, `diamond_weight`, `net_weight`, `waste_per`, `waste`, `gross_weight`, `making_gram`, `making`, `laker`, `bead_price`, `stones_price`, `diamond_price`, `total_bead_price`, `total_stones_price`, `total_diamond_price`, `other_amount`, `gold_rate`, `total_gold_price`, `total_amount`, `is_saled`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 79, NULL, 9, NULL, 'BL40403', 'barcodes/BL40403.png', 2, 1, 'pictures/172803763566ffc3030ecb9.png', '21.000', '100.000', '25.690', '3.485', '1.250', '69.575', '20.000', '13.915', '83.490', '750.000', '62617.500', '1200.000', '175.000', '250.000', '400000.000', '4495.750', '871.250', '500000.000', '5000.000', '21004.801', '21088.291', '595272.791', 0, 1, 1, 1, NULL, 1, '2024-10-04 17:27:15', '2024-10-04 17:28:22'),
(2, 79, NULL, 9, NULL, 'BL12198', 'barcodes/BL12198.png', 2, 1, 'pictures/17281276296701228d64e03.png', '21.000', '100.000', '25.690', '3.485', '1.250', '69.575', '20.000', '13.915', '83.490', '750.000', '62617.500', '1200.000', '175.000', '250.000', '400000.000', '4495.750', '871.250', '500000.000', '5000.000', '21079.818', '21163.308', '595347.808', 0, 1, 1, 1, NULL, 1, '2024-10-05 18:27:09', '2024-11-19 20:25:25'),
(3, 93, NULL, 10, NULL, 'BL21888', 'barcodes/BL21888.png', 2, 1, 'pictures/17282543146703116ac0231.png', '21.000', '100.000', '48.690', '0.000', '0.000', '51.310', '20.000', '10.262', '61.572', '750.000', '46179.000', '1200.000', '0.000', '0.000', '0.000', '3651.750', '0.000', '0.000', '0.000', '21079.818', '21141.390', '72172.140', 1, 1, 1, 1, 1, 1, '2024-10-07 05:38:34', '2024-11-19 20:25:30'),
(4, 105, NULL, 11, NULL, 'NS39136', 'barcodes/NS39136.png', 3, 1, 'pictures/17291559086710d344f0432.png', '21.000', '120.987', '22.994', '3.420', '3.400', '91.173', '20.000', '18.235', '109.408', '550.000', '60174.400', '7500.000', '0.000', '0.000', '0.000', '7778.100', '9983.000', '568740.000', '15000.000', '21064.815', '21174.223', '690349.723', 1, 1, 1, 1, 1, 1, '2024-10-17 16:05:09', '2024-11-19 20:25:34'),
(5, 107, NULL, 14, NULL, 'NS90095', 'barcodes/NS90095.png', 3, 1, 'pictures/1730050865671e7b312b48b.png', '21.000', '35.480', '0.000', '0.000', '0.000', '35.480', '20.000', '7.096', '42.576', '750.000', '31932.000', '5000.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '4500.000', '21477.409', '21519.985', '62951.985', 0, 1, 1, 1, NULL, 1, '2024-10-28 00:41:05', '2024-11-19 20:25:37'),
(10, NULL, 1, NULL, 1, 'LR65344', 'barcodes/LR65344.png', 6, 1, 'pictures/1733179104674e36e0614cf.jpg', '21.000', '28.579', '0.000', '0.000', '0.000', '28.579', '10.000', '2.858', '31.437', '500.000', '15718.500', '1200.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '500.000', '21004.801', '660327.929', '677746.429', 0, 1, 0, 1, NULL, NULL, '2024-12-02 17:38:24', '2024-12-02 17:38:24');

-- --------------------------------------------------------

--
-- Table structure for table `finish_product_beads`
--

CREATE TABLE `finish_product_beads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `beads` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finish_product_beads`
--

INSERT INTO `finish_product_beads` (`id`, `type`, `finish_product_id`, `beads`, `gram`, `carat`, `gram_rate`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Glass Bead', 3, '1.000', '23.000', '115.000', '75.000', '15.000', '1725.000', 1, NULL, 1, '2024-10-07 05:38:34', '2024-11-19 20:25:30'),
(2, 'Metal Bead', 3, '1.000', '25.690', '128.450', '75.000', '15.000', '1926.750', 1, NULL, 1, '2024-10-07 05:38:34', '2024-11-19 20:25:30'),
(3, 'Glass Bead', 4, '1.000', '20.654', '103.270', '150.000', '30.000', '3098.100', 1, NULL, 1, '2024-10-17 16:05:09', '2024-11-19 20:25:34'),
(4, 'Glass Bead', 4, '1.000', '2.340', '11.700', '2000.000', '400.000', '4680.000', 1, NULL, 1, '2024-10-17 16:05:09', '2024-11-19 20:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `finish_product_diamonds`
--

CREATE TABLE `finish_product_diamonds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `diamonds` decimal(18,3) NOT NULL DEFAULT 0.000,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clarity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_dollar` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finish_product_diamonds`
--

INSERT INTO `finish_product_diamonds` (`id`, `finish_product_id`, `diamonds`, `type`, `color`, `cut`, `clarity`, `carat`, `carat_rate`, `total_amount`, `total_dollar`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 4, '1.000', 'Natural', 'H', 'Round', 'VS-1', '1.000', '118500.000', '118500.000', '0.000', 1, NULL, 1, '2024-10-17 16:05:09', '2024-11-19 20:25:34'),
(2, 4, '12.000', 'Natural', 'I', 'Emerald', 'VVS-2', '2.400', '187600.000', '450240.000', '0.000', 1, NULL, 1, '2024-10-17 16:05:09', '2024-11-19 20:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `finish_product_stones`
--

CREATE TABLE `finish_product_stones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `stones` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finish_product_stones`
--

INSERT INTO `finish_product_stones` (`id`, `category`, `type`, `finish_product_id`, `stones`, `gram`, `carat`, `gram_rate`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Metamorphic', 'Ruby', 4, '357.000', '1.340', '6.700', '2250.000', '450.000', '3015.000', 1, NULL, 1, '2024-10-17 16:05:09', '2024-11-19 20:25:34'),
(2, 'Igneous', 'Sapphire', 4, '140.000', '2.080', '10.400', '3350.000', '670.000', '6968.000', 1, NULL, 1, '2024-10-17 16:05:09', '2024-11-19 20:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `gold_rates`
--

CREATE TABLE `gold_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `carat` int(11) NOT NULL DEFAULT 24,
  `gold` decimal(18,3) NOT NULL DEFAULT 100.000,
  `impurity` decimal(18,3) NOT NULL DEFAULT 0.000,
  `ratti` int(11) NOT NULL DEFAULT 96,
  `ratti_impurity` int(11) NOT NULL DEFAULT 0,
  `rate_tola` decimal(18,3) NOT NULL DEFAULT 0.000,
  `rate_gram` decimal(18,3) NOT NULL DEFAULT 0.000,
  `createdby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gold_rates`
--

INSERT INTO `gold_rates` (`id`, `carat`, `gold`, `impurity`, `ratti`, `ratti_impurity`, `rate_tola`, `rate_gram`, `createdby_id`, `created_at`, `updated_at`) VALUES
(1, 24, '100.000', '0.000', 96, 0, '263700.000', '22608.025', 1, '2024-09-27 08:18:40', '2024-09-27 08:18:40'),
(2, 24, '100.000', '0.000', 96, 0, '285000.000', '24434.156', 1, '2024-09-27 17:40:33', '2024-09-27 17:40:33'),
(3, 24, '100.000', '0.000', 96, 0, '280000.000', '24005.487', 1, '2024-10-01 15:02:02', '2024-10-01 15:02:02'),
(4, 24, '100.000', '0.000', 96, 0, '281100.000', '24099.794', 1, '2024-10-04 18:39:57', '2024-10-04 18:39:57'),
(5, 24, '100.000', '0.000', 96, 0, '281000.000', '24091.221', 1, '2024-10-05 17:57:30', '2024-10-05 17:57:30'),
(6, 24, '100.000', '0.000', 96, 0, '278000.000', '23834.019', 1, '2024-10-11 17:56:05', '2024-10-11 17:56:05'),
(7, 24, '100.000', '0.000', 96, 0, '280800.000', '24074.074', 1, '2024-10-17 01:01:10', '2024-10-17 01:01:10'),
(8, 24, '100.000', '0.000', 96, 0, '286300.000', '24545.610', 1, '2024-10-26 19:03:45', '2024-10-26 19:03:45'),
(9, 24, '100.000', '0.000', 96, 0, '270300.000', '23173.868', 1, '2024-11-14 20:26:59', '2024-11-14 20:26:59'),
(10, 24, '100.000', '0.000', 96, 0, '270300.000', '23173.868', 1, '2024-11-14 20:26:59', '2024-11-14 20:26:59'),
(11, 24, '100.000', '0.000', 96, 0, '280000.000', '24005.487', 1, '2024-11-19 20:25:17', '2024-11-19 20:25:17');

-- --------------------------------------------------------

--
-- Table structure for table `gold_rate_types`
--

CREATE TABLE `gold_rate_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_purchases`
--

CREATE TABLE `job_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_purchase_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_purchase_date` date DEFAULT NULL,
  `purchase_order_id` int(11) DEFAULT NULL,
  `sale_order_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `purchase_account_id` int(11) DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_recieved_au` decimal(18,3) DEFAULT NULL,
  `total` decimal(18,3) DEFAULT NULL,
  `total_au` decimal(18,3) DEFAULT NULL,
  `total_dollar` decimal(18,3) DEFAULT NULL,
  `jv_id` int(11) DEFAULT NULL,
  `jv_au_id` int(11) DEFAULT NULL,
  `jv_dollar_id` int(11) DEFAULT NULL,
  `jv_recieved_id` int(11) DEFAULT NULL,
  `supplier_au_payment_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 for active, 0 for inactive',
  `is_posted` tinyint(1) NOT NULL DEFAULT 0,
  `is_saled` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_purchases`
--

INSERT INTO `job_purchases` (`id`, `job_purchase_no`, `job_purchase_date`, `purchase_order_id`, `sale_order_id`, `supplier_id`, `warehouse_id`, `purchase_account_id`, `reference`, `total_recieved_au`, `total`, `total_au`, `total_dollar`, `jv_id`, `jv_au_id`, `jv_dollar_id`, `jv_recieved_id`, `supplier_au_payment_id`, `is_active`, `is_posted`, `is_saled`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'JP-22112024-0001', '2024-11-22', 5, NULL, 8, 1, NULL, 'aaa', '23.570', '4372.500', '28.579', '0.000', 39, NULL, NULL, 40, 6, 1, 1, 0, 0, 1, NULL, NULL, '2024-11-22 09:50:39', '2024-11-22 09:54:48'),
(2, 'JP-26112024-0002', '2024-11-26', 6, NULL, 8, 1, NULL, 'aaa', '23.403', '3425.000', '35.251', '0.000', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 3, NULL, NULL, '2024-11-26 18:20:40', '2024-11-26 18:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `job_purchase_details`
--

CREATE TABLE `job_purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_purchase_id` int(11) DEFAULT NULL,
  `purchase_order_detail_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `design_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waste_ratti` decimal(18,3) NOT NULL DEFAULT 0.000,
  `waste` decimal(18,3) NOT NULL DEFAULT 0.000,
  `polish_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `stone_waste` decimal(18,3) NOT NULL DEFAULT 0.000 COMMENT '0.25/100 stones',
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Upper, Inner',
  `mail_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `stone_waste_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `recieved_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_recieved_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `bead_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `stones_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `diamond_carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `with_stone_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `pure_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `payable_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `stone_adjustement` decimal(18,3) NOT NULL DEFAULT 0.000,
  `final_pure_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `pure_payable` decimal(18,3) NOT NULL DEFAULT 0.000,
  `laker` decimal(18,3) NOT NULL DEFAULT 0.000,
  `rp` decimal(18,3) NOT NULL DEFAULT 0.000,
  `wax` decimal(18,3) NOT NULL DEFAULT 0.000,
  `other` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_bead_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_stones_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_diamond_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_dollar` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_finish_product` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `approvedby_id` int(11) DEFAULT NULL,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_purchase_details`
--

INSERT INTO `job_purchase_details` (`id`, `job_purchase_id`, `purchase_order_detail_id`, `product_id`, `category`, `design_no`, `waste_ratti`, `waste`, `polish_weight`, `stone_waste`, `mail`, `mail_weight`, `stone_waste_weight`, `recieved_weight`, `total_recieved_weight`, `bead_weight`, `stones_weight`, `diamond_carat`, `with_stone_weight`, `total_weight`, `pure_weight`, `payable_weight`, `stone_adjustement`, `final_pure_weight`, `pure_payable`, `laker`, `rp`, `wax`, `other`, `total_bead_amount`, `total_stones_amount`, `total_diamond_amount`, `total_amount`, `total_dollar`, `is_finish_product`, `is_deleted`, `approvedby_id`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 6, 'asdd', 'aas', '6.000', '1.646', '26.340', '0.350', '0', '13.000', '0.003', '23.567', '23.570', '0.000', '2.300', '0.000', '28.640', '27.986', '24.196', '5.070', '4.383', '28.579', '0.000', '1200.000', '1200.000', '1300.000', '500.000', '0.000', '172.500', '0.000', '4372.500', '0.000', 1, 0, NULL, 1, 1, NULL, '2024-11-22 09:50:39', '2024-12-02 17:38:24'),
(2, 2, 4, 11, 'ac', 'ww', '6.000', '1.875', '30.000', '0.350', '0', '13.000', '0.003', '23.400', '23.403', '0.000', '2.300', '0.000', '32.300', '31.875', '27.559', '8.897', '7.692', '35.251', '0.000', '500.000', '500.000', '600.000', '100.000', '0.000', '1725.000', '0.000', '3425.000', '0.000', 0, 0, NULL, 3, NULL, NULL, '2024-11-26 18:20:41', '2024-11-26 18:20:41');

-- --------------------------------------------------------

--
-- Table structure for table `job_purchase_detail_beads`
--

CREATE TABLE `job_purchase_detail_beads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_purchase_detail_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beads` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_purchase_detail_diamonds`
--

CREATE TABLE `job_purchase_detail_diamonds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_purchase_detail_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `diamonds` decimal(18,3) NOT NULL DEFAULT 0.000,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clarity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_dollar` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_purchase_detail_stones`
--

CREATE TABLE `job_purchase_detail_stones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_purchase_detail_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stones` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_purchase_detail_stones`
--

INSERT INTO `job_purchase_detail_stones` (`id`, `job_purchase_detail_id`, `product_id`, `category`, `type`, `stones`, `gram`, `carat`, `gram_rate`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Ruby', '1', '1.000', '2.300', '11.500', '75.000', '15.000', '172.500', 0, 1, NULL, NULL, '2024-11-22 09:50:39', '2024-11-22 09:50:39'),
(2, 2, NULL, 'Ruby', '1', '1.000', '2.300', '11.500', '750.000', '150.000', '1725.000', 0, 3, NULL, NULL, '2024-11-26 18:20:41', '2024-11-26 18:20:41');

-- --------------------------------------------------------

--
-- Table structure for table `job_tasks`
--

CREATE TABLE `job_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_task_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_task_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `purchase_order_id` int(11) DEFAULT NULL,
  `sale_order_id` int(11) DEFAULT NULL,
  `total_qty` decimal(18,3) DEFAULT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_tasks`
--

INSERT INTO `job_tasks` (`id`, `job_task_no`, `job_task_date`, `delivery_date`, `supplier_id`, `warehouse_id`, `purchase_order_id`, `sale_order_id`, `total_qty`, `is_complete`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'JT-22112024-0001', '2024-11-22 01:38:38', NULL, 8, 1, 5, NULL, '1.000', 0, 0, 1, NULL, NULL, '2024-11-22 09:38:38', '2024-11-22 09:38:38'),
(2, 'JT-26112024-0002', '2024-11-26 23:11:16', NULL, 8, 1, 4, NULL, '1.000', 0, 0, 1, NULL, NULL, '2024-11-26 18:11:16', '2024-11-26 18:11:16'),
(3, 'JT-26112024-0003', '2024-11-26 23:11:21', NULL, 8, 1, 3, NULL, '1.000', 0, 0, 1, NULL, NULL, '2024-11-26 18:11:21', '2024-11-26 18:11:21'),
(4, 'JT-26112024-0004', '2024-11-26 23:18:05', NULL, 8, 1, 6, NULL, '1.000', 0, 0, 1, NULL, NULL, '2024-11-26 18:18:05', '2024-11-26 18:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `job_task_activities`
--

CREATE TABLE `job_task_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_task_id` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `design_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_task_details`
--

CREATE TABLE `job_task_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_task_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `design_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_task_details`
--

INSERT INTO `job_task_details` (`id`, `job_task_id`, `product_id`, `category`, `design_no`, `net_weight`, `description`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'asdd', 'aas', '23.567', 'Reaction on Trade of Jannah', 0, 1, NULL, '2024-11-22 09:38:38', '2024-11-22 09:38:38'),
(2, 2, 10, '21K', 'B00049', '40.000', '2.3 Inches ', 0, 1, NULL, '2024-11-26 18:11:16', '2024-11-26 18:11:16'),
(3, 3, 10, '21K', 'B00049', '40.000', '2.3 Inch size and same as picture', 0, 1, NULL, '2024-11-26 18:11:21', '2024-11-26 18:11:21'),
(4, 4, 11, 'ac', 'ww', '23.400', 'Reaction on Trade of Jannah', 0, 1, NULL, '2024-11-26 18:18:05', '2024-11-26 18:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journals`
--

INSERT INTO `journals` (`id`, `name`, `prefix`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Bank Payment Voucher', 'BPV', 1, 0, 1, NULL, NULL, '2024-09-23 19:46:24', '2024-09-23 19:46:24'),
(2, 'Bank Receipt Voucher', 'BRV', 1, 0, 1, NULL, NULL, '2024-09-23 19:47:25', '2024-09-23 19:47:25'),
(3, 'Cash Payment Voucher', 'CPV', 1, 0, 1, NULL, NULL, '2024-09-23 19:47:42', '2024-09-23 19:47:42'),
(4, 'Cash Receipt Voucher', 'CRV', 1, 0, 1, NULL, NULL, '2024-09-23 19:48:02', '2024-09-23 19:48:02'),
(5, 'Journal Voucher', 'JV', 1, 0, 1, NULL, NULL, '2024-09-23 19:48:18', '2024-09-23 19:48:18'),
(6, 'PMU Sales JV', 'PSJ', 1, 0, 1, NULL, NULL, '2024-09-23 19:48:49', '2024-09-23 19:48:49'),
(7, 'Purchase Return Voucher', 'PRV', 1, 0, 1, NULL, NULL, '2024-09-23 19:49:04', '2024-09-23 19:49:04'),
(8, 'Purchase Voucher', 'PV', 1, 0, 1, NULL, NULL, '2024-09-23 19:49:15', '2024-09-23 19:49:15'),
(9, 'Sales Return Voucher', 'SRV', 1, 0, 1, NULL, NULL, '2024-09-23 19:49:29', '2024-09-23 19:49:29'),
(10, 'Sales Voucher', 'SV', 1, 0, 1, NULL, NULL, '2024-09-23 19:49:42', '2024-09-23 19:49:42'),
(11, 'Store Transaction Voucher', 'STV', 1, 0, 1, NULL, NULL, '2024-09-23 19:49:57', '2024-09-23 19:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entryNum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `journal_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `date_post` date DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_in_words` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_entries`
--

INSERT INTO `journal_entries` (`id`, `entryNum`, `journal_id`, `supplier_id`, `customer_id`, `date_post`, `reference`, `amount_in_words`, `createdby_id`, `updatedby_id`, `is_deleted`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(5, 'JV-2024-09-0001', 2, 2, NULL, '2024-09-06', 'sss', NULL, 1, NULL, 1, 1, '2024-09-06 15:47:08', '2024-09-06 15:52:35'),
(6, 'JV-2024-09-0001', 5, NULL, NULL, '2024-09-24', 'Voluptatem deleniti a ut harum quis est sed sed officiis accusantium blanditiis asperiores sint placeat sunt quae ut minim', NULL, 1, NULL, 0, NULL, '2024-09-23 20:27:46', '2024-09-23 20:27:46'),
(19, 'PV-2024-09-0001', 8, 2, NULL, '2024-09-23', 'Date :2024-09-23 Against RK-23092024-0076. From Sopoline Palmer', NULL, 1, NULL, 1, 1, '2024-09-25 00:14:06', '2024-09-25 19:11:01'),
(20, 'BPV-2024-09-0001', 1, 2, NULL, '2024-09-23', 'Date :2024-09-23 PKR Payment Against RK. RK-23092024-0076', NULL, 1, NULL, 1, 1, '2024-09-25 00:14:06', '2024-09-25 19:11:01'),
(21, 'PV-2024-09-0020', 8, 2, NULL, '2024-09-20', 'Date :2024-09-20 Against RK-20092024-0022. From Sopoline Palmer', NULL, 1, NULL, 0, NULL, '2024-09-25 00:25:32', '2024-09-25 00:25:32'),
(22, 'PV-2024-09-0022', 8, 2, NULL, '2024-09-21', 'Date :2024-09-21 Against RK-19092024-0001. From Sopoline Palmer', NULL, 1, NULL, 0, NULL, '2024-09-25 00:26:12', '2024-09-25 00:26:12'),
(23, 'BPV-2024-09-0021', 1, 2, NULL, '2024-09-21', 'Date :2024-09-21 PKR Payment Against RK. RK-19092024-0001', NULL, 1, NULL, 0, NULL, '2024-09-25 00:26:12', '2024-09-25 00:26:12'),
(24, 'BPV-2024-09-0024', 1, 2, NULL, '2024-09-26', 'Date :2024-09-26 Against Supplier/Karigar. Sopoline Palmer', NULL, 1, NULL, 1, 1, '2024-09-25 17:25:50', '2024-09-25 18:28:20'),
(25, 'PV-2024-09-0023', 8, 4, NULL, '2024-09-27', 'Date :2024-09-27 Against RK-27092024-0090. From Abdul Majeed', NULL, 1, NULL, 0, NULL, '2024-09-28 04:57:35', '2024-09-28 04:57:35'),
(26, 'SV-2024-10-0001', 10, NULL, 2, '2024-10-16', 'Date :2024-10-16 Sale SL-16102024-0001. Customer is Merrill Benson', NULL, 1, NULL, 0, NULL, '2024-10-17 04:21:33', '2024-10-17 04:21:33'),
(33, 'PV-2024-10-0001', 8, 5, NULL, '2024-10-17', 'Date :2024-10-17 Against RK-17102024-0102. From Usman Khan', NULL, 1, NULL, 0, NULL, '2024-10-17 16:01:37', '2024-10-17 16:01:37'),
(34, 'SV-2024-10-0027', 10, NULL, 3, '2024-10-17', 'Date :2024-10-17 Sale SL-17102024-0005. Customer is Shahid', NULL, 1, NULL, 0, NULL, '2024-10-17 19:28:27', '2024-10-17 19:28:27'),
(35, 'PV-2024-10-0034', 8, 2, NULL, '2024-10-22', 'Date :2024-10-22 Against RK-22102024-0103. From Sopoline Palmer', NULL, 1, NULL, 0, NULL, '2024-10-22 18:19:29', '2024-10-22 18:19:29'),
(36, 'PV-2024-10-0036', 8, 6, NULL, '2024-10-27', 'Date :2024-10-27 Against RK-27102024-0104. From Abid Karigar', NULL, 1, NULL, 0, NULL, '2024-10-28 00:37:27', '2024-10-28 00:37:27'),
(37, 'PV-2024-11-0001', 8, 7, NULL, '2024-11-07', 'Date :2024-11-07 Against RK-07112024-0108. From Sohail Gold Smith', NULL, 1, NULL, 0, NULL, '2024-11-07 16:36:34', '2024-11-07 16:36:34'),
(38, 'BPV-2024-11-0001', 1, 8, NULL, '2024-11-20', 'Date :2024-11-20 Against Supplier/Karigar. Abdul Majeed', NULL, 1, NULL, 1, 1, '2024-11-20 18:21:56', '2024-11-20 18:23:58'),
(39, 'PV-2024-11-0038', 8, 8, NULL, '2024-11-22', 'Date :2024-11-22 Against JP-22112024-0001. From Abdul Majeed', NULL, 1, NULL, 0, NULL, '2024-11-22 09:54:48', '2024-11-22 09:54:48'),
(40, 'BPV-2024-11-0039', 1, 8, NULL, '2024-11-22', 'Date :2024-11-22 AU payment Against RK. JP-22112024-0001', NULL, 1, NULL, 0, NULL, '2024-11-22 09:54:48', '2024-11-22 09:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `journal_entry_details`
--

CREATE TABLE `journal_entry_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_entry_id` int(11) DEFAULT NULL,
  `explanation` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_date` date DEFAULT NULL,
  `credit` decimal(18,3) NOT NULL DEFAULT 0.000,
  `debit` decimal(18,3) NOT NULL DEFAULT 0.000,
  `currency` int(11) NOT NULL DEFAULT 0 COMMENT '0 for pkr, 1 for AU, 2 for dollar',
  `doc_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `amount_in_words` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_entry_details`
--

INSERT INTO `journal_entry_details` (`id`, `journal_entry_id`, `explanation`, `bill_no`, `check_no`, `check_date`, `credit`, `debit`, `currency`, `doc_date`, `account_id`, `amount`, `amount_in_words`, `account_code`, `createdby_id`, `created_at`, `updated_at`) VALUES
(1, 5, '', '', '', NULL, '0.000', '200.000', 0, '2024-09-06', 6, '200.000', 'two hundred ', '12345', NULL, '2024-09-06 15:47:08', '2024-09-06 15:47:08'),
(2, 5, '', '', '', NULL, '200.000', '0.000', 0, '2024-09-06', 6, '200.000', 'two hundred ', '12345', NULL, '2024-09-06 15:47:08', '2024-09-06 15:47:08'),
(3, 6, '', '', '', NULL, '0.000', '120.000', 0, '2024-09-24', 12, '120.000', 'one hundred twenty ', '002-003', NULL, '2024-09-23 20:27:46', '2024-09-23 20:27:46'),
(4, 6, '', '', '', NULL, '120.000', '0.000', 0, '2024-09-24', 5, '120.000', 'one hundred twenty ', '1234', NULL, '2024-09-23 20:27:46', '2024-09-23 20:27:46'),
(45, 19, 'Ratti Kaat PKR Debit Entry', '79', '0', '2024-09-23', '0.000', '150313.125', 0, NULL, 8, '150313.125', 'One Hundred  Fifty    Thousand and  Three Hundreds  Thirteen', '12-001', 1, NULL, NULL),
(46, 19, 'Ratti Kaat PKR Supplier/Karigar Credit Entry', '79', '0', '2024-09-23', '150313.125', '0.000', 0, NULL, 10, '150313.125', 'One Hundred  Fifty    Thousand and  Three Hundreds  Thirteen', '002-001', 1, NULL, NULL),
(47, 19, 'Ratti Kaat Gold(AU) Debit Entry', '79', '0', '2024-09-23', '0.000', '66.676', 1, NULL, 8, '66.676', 'Sixty  Six', '12-001', 1, NULL, NULL),
(48, 19, 'Ratti Kaat Gold(AU) Supplier/Karigar Credit Entry', '79', '0', '2024-09-23', '66.676', '0.000', 1, NULL, 11, '66.676', 'Sixty  Six', '002-002', 1, NULL, NULL),
(49, 19, 'Ratti Kaat Dollar($) Debit Entry', '79', '0', '2024-09-23', '0.000', '225.806', 1, NULL, 8, '225.806', 'Two Hundreds  Twenty  Five', '12-001', 1, NULL, NULL),
(50, 19, 'Ratti Kaat Dollar($) Supplier/Karigar Credit Entry', '79', '0', '2024-09-23', '225.806', '0.000', 1, NULL, 12, '225.806', 'Two Hundreds  Twenty  Five', '002-003', 1, NULL, NULL),
(51, 20, 'Paid PKR Payment Debit Against Ratti Kaat. RK-23092024-0076', '79', '0', '2024-09-23', '0.000', '15000.000', 0, NULL, 10, '15000.000', 'Fifteen  Thousand', '002-001', 1, NULL, NULL),
(52, 20, 'Paid PKR Payment Credit Against Ratti Kaat. RK-23092024-0076', '79', '0', '2024-09-23', '15000.000', '0.000', 0, NULL, 6, '15000.000', 'Fifteen  Thousand', '12345', 1, NULL, NULL),
(53, 21, 'Ratti Kaat PKR Debit Entry', '25', '0', '2024-09-20', '0.000', '17550.000', 0, NULL, 6, '17550.000', 'Seventeen  Thousand and  Five Hundreds  Fifty', '12345', 1, NULL, NULL),
(54, 21, 'Ratti Kaat PKR Supplier/Karigar Credit Entry', '25', '0', '2024-09-20', '17550.000', '0.000', 0, NULL, 10, '17550.000', 'Seventeen  Thousand and  Five Hundreds  Fifty', '002-001', 1, NULL, NULL),
(55, 22, 'Ratti Kaat PKR Debit Entry', '1', '0', '2024-09-21', '0.000', '31813.125', 0, NULL, 6, '31813.125', 'Thirty  One  Thousand and  Eight Hundreds  Thirteen', '12345', 1, NULL, NULL),
(56, 22, 'Ratti Kaat PKR Supplier/Karigar Credit Entry', '1', '0', '2024-09-21', '31813.125', '0.000', 0, NULL, 10, '31813.125', 'Thirty  One  Thousand and  Eight Hundreds  Thirteen', '002-001', 1, NULL, NULL),
(57, 23, 'Paid PKR Payment Debit Against Ratti Kaat. RK-19092024-0001', '1', '0', '2024-09-21', '0.000', '1234.000', 0, NULL, 10, '1234.000', 'One  Thousand and  Two Hundreds  Thirty  Four', '002-001', 1, NULL, NULL),
(58, 23, 'Paid PKR Payment Credit Against Ratti Kaat. RK-19092024-0001', '1', '0', '2024-09-21', '1234.000', '0.000', 0, NULL, 6, '1234.000', 'One  Thousand and  Two Hundreds  Thirty  Four', '12345', 1, NULL, NULL),
(59, 24, 'Supplier/Karigar Payment Credit From child', '4', '0', '2024-09-26', '1000.000', '0.000', 0, NULL, 5, '1000.000', 'One  Thousand', '1234', 1, NULL, NULL),
(60, 24, 'Supplier Payment Debit', '4', '0', '2024-09-26', '0.000', '1000.000', 0, NULL, 10, '1000.000', 'One  Thousand', '002-001', 1, NULL, NULL),
(61, 25, 'Ratti Kaat PKR Debit Entry', '93', '0', '2024-09-27', '0.000', '1725.000', 0, NULL, 5, '1725.000', 'One  Thousand and  Seven Hundreds  Twenty  Five', '1234', 1, NULL, NULL),
(62, 25, 'Ratti Kaat PKR Supplier/Karigar Credit Entry', '93', '0', '2024-09-27', '1725.000', '0.000', 0, NULL, 10, '1725.000', 'One  Thousand and  Seven Hundreds  Twenty  Five', '002-001', 1, NULL, NULL),
(63, 25, 'Ratti Kaat Gold(AU) Debit Entry', '93', '0', '2024-09-27', '0.000', '72.187', 1, NULL, 5, '72.187', 'Seventy  Two', '1234', 1, NULL, NULL),
(64, 25, 'Ratti Kaat Gold(AU) Supplier/Karigar Credit Entry', '93', '0', '2024-09-27', '72.187', '0.000', 1, NULL, 11, '72.187', 'Seventy  Two', '002-002', 1, NULL, NULL),
(65, 26, 'Cash Amount From Sale Debit Entry', '1', '0', '2024-10-16', '0.000', '73966.396', 0, NULL, 10, '73966.396', 'Seventy  Three  Thousand and  Nine Hundreds  Sixty  Six', '002-001', 1, NULL, NULL),
(66, 26, 'Revenue From Sale Credit Entry', '1', '0', '2024-10-16', '73966.396', '0.000', 0, NULL, 11, '73966.396', 'Seventy  Three  Thousand and  Nine Hundreds  Sixty  Six', '002-002', 1, NULL, NULL),
(91, 33, 'Ratti Kaat PKR Debit Entry', '105', '0', '2024-10-17', '0.000', '587955.000', 0, NULL, 11, '587955.000', 'Five Hundreds  Eighty  Seven  Thousand and  Nine Hundreds  Fifty  Five', '002-002', 1, NULL, NULL),
(92, 33, 'Ratti Kaat PKR Supplier/Karigar Credit Entry', '105', '0', '2024-10-17', '587955.000', '0.000', 0, NULL, 10, '587955.000', 'Five Hundreds  Eighty  Seven  Thousand and  Nine Hundreds  Fifty  Five', '002-001', 1, NULL, NULL),
(93, 33, 'Ratti Kaat Gold(AU) Debit Entry', '105', '0', '2024-10-17', '0.000', '81.578', 1, NULL, 11, '81.578', 'Eighty  One', '002-002', 1, NULL, NULL),
(94, 33, 'Ratti Kaat Gold(AU) Supplier/Karigar Credit Entry', '105', '0', '2024-10-17', '81.578', '0.000', 1, NULL, 11, '81.578', 'Eighty  One', '002-002', 1, NULL, NULL),
(95, 33, 'Ratti Kaat Dollar($) Debit Entry', '105', '0', '2024-10-17', '0.000', '2048.775', 1, NULL, 11, '2048.775', 'Two  Thousand and  Forty  Eight', '002-002', 1, NULL, NULL),
(96, 33, 'Ratti Kaat Dollar($) Supplier/Karigar Credit Entry', '105', '0', '2024-10-17', '2048.775', '0.000', 1, NULL, 12, '2048.775', 'Two  Thousand and  Forty  Eight', '002-003', 1, NULL, NULL),
(97, 34, 'Cash Amount From Sale Debit Entry', '5', '0', '2024-10-17', '0.000', '685855.327', 0, NULL, 5, '685855.327', 'Six Hundreds  Eighty  Five  Thousand and  Eight Hundreds  Fifty  Five', '1234', 1, NULL, NULL),
(98, 34, 'Revenue From Sale Credit Entry', '5', '0', '2024-10-17', '685855.327', '0.000', 0, NULL, 6, '685855.327', 'Six Hundreds  Eighty  Five  Thousand and  Eight Hundreds  Fifty  Five', '12345', 1, NULL, NULL),
(99, 35, 'Ratti Kaat PKR Debit Entry', '106', '0', '2024-10-22', '0.000', '6550.000', 0, NULL, 6, '6550.000', 'Six  Thousand and  Five Hundreds  Fifty', '12345', 1, NULL, NULL),
(100, 35, 'Ratti Kaat PKR Supplier/Karigar Credit Entry', '106', '0', '2024-10-22', '6550.000', '0.000', 0, NULL, 10, '6550.000', 'Six  Thousand and  Five Hundreds  Fifty', '002-001', 1, NULL, NULL),
(101, 35, 'Ratti Kaat Gold(AU) Debit Entry', '106', '0', '2024-10-22', '0.000', '141.833', 1, NULL, 6, '141.833', 'One Hundred  Forty  One', '12345', 1, NULL, NULL),
(102, 35, 'Ratti Kaat Gold(AU) Supplier/Karigar Credit Entry', '106', '0', '2024-10-22', '141.833', '0.000', 1, NULL, 11, '141.833', 'One Hundred  Forty  One', '002-002', 1, NULL, NULL),
(103, 36, 'Ratti Kaat PKR Debit Entry', '107', '0', '2024-10-27', '0.000', '3000.000', 0, NULL, 11, '3000.000', 'Three  Thousand', '002-002', 1, NULL, NULL),
(104, 36, 'Ratti Kaat PKR Supplier/Karigar Credit Entry', '107', '0', '2024-10-27', '3000.000', '0.000', 0, NULL, 10, '3000.000', 'Three  Thousand', '002-001', 1, NULL, NULL),
(105, 36, 'Ratti Kaat Gold(AU) Debit Entry', '107', '0', '2024-10-27', '0.000', '33.263', 1, NULL, 11, '33.263', 'Thirty  Three', '002-002', 1, NULL, NULL),
(106, 36, 'Ratti Kaat Gold(AU) Supplier/Karigar Credit Entry', '107', '0', '2024-10-27', '33.263', '0.000', 1, NULL, 11, '33.263', 'Thirty  Three', '002-002', 1, NULL, NULL),
(107, 37, 'Ratti Kaat PKR Debit Entry', '111', '0', '2024-11-07', '0.000', '5403600.000', 0, NULL, 11, '5403600.000', 'Five  Million and  Four Hundreds  Three  Thousand and  Six Hundreds', '002-002', 1, NULL, NULL),
(108, 37, 'Ratti Kaat PKR Supplier/Karigar Credit Entry', '111', '0', '2024-11-07', '5403600.000', '0.000', 0, NULL, 10, '5403600.000', 'Five  Million and  Four Hundreds  Three  Thousand and  Six Hundreds', '002-001', 1, NULL, NULL),
(109, 37, 'Ratti Kaat Gold(AU) Debit Entry', '111', '0', '2024-11-07', '0.000', '91.265', 1, NULL, 11, '91.265', 'Ninety  One', '002-002', 1, NULL, NULL),
(110, 37, 'Ratti Kaat Gold(AU) Supplier/Karigar Credit Entry', '111', '0', '2024-11-07', '91.265', '0.000', 1, NULL, 11, '91.265', 'Ninety  One', '002-002', 1, NULL, NULL),
(111, 37, 'Ratti Kaat Dollar($) Debit Entry', '111', '0', '2024-11-07', '0.000', '19453.430', 1, NULL, 11, '19453.430', 'Nineteen  Thousand and  Four Hundreds  Fifty  Three', '002-002', 1, NULL, NULL),
(112, 37, 'Ratti Kaat Dollar($) Supplier/Karigar Credit Entry', '111', '0', '2024-11-07', '19453.430', '0.000', 1, NULL, 12, '19453.430', 'Nineteen  Thousand and  Four Hundreds  Fifty  Three', '002-003', 1, NULL, NULL),
(113, 38, 'Supplier/Karigar Payment Credit From Local Karigar AU', '5', '0', '2024-11-20', '70.000', '0.000', 0, NULL, 11, '70.000', 'Seventy', '002-002', 1, NULL, NULL),
(114, 38, 'Supplier Payment Debit', '5', '0', '2024-11-20', '0.000', '70.000', 0, NULL, 10, '70.000', 'Seventy', '002-001', 1, NULL, NULL),
(115, 39, 'Job Purchase PKR Debit Entry', '1', '0', '2024-11-22', '0.000', '4372.500', 0, NULL, 10, '4372.500', 'Four  Thousand and  Three Hundreds  Seventy  Two', '002-001', 1, NULL, NULL),
(116, 39, 'Job Purchase PKR Supplier/Karigar Credit Entry', '1', '0', '2024-11-22', '4372.500', '0.000', 0, NULL, 10, '4372.500', 'Four  Thousand and  Three Hundreds  Seventy  Two', '002-001', 1, NULL, NULL),
(117, 39, 'Job Purchase Gold(AU) Debit Entry', '1', '0', '2024-11-22', '0.000', '28.579', 1, NULL, 10, '28.579', 'Twenty  Eight', '002-001', 1, NULL, NULL),
(118, 39, 'Job Purchase Gold(AU) Supplier/Karigar Credit Entry', '1', '0', '2024-11-22', '28.579', '0.000', 1, NULL, 11, '28.579', 'Twenty  Eight', '002-002', 1, NULL, NULL),
(119, 40, 'Paid AU Payment Debit Against Job Purchase. JP-22112024-0001', '1', '0', '2024-11-22', '0.000', '23.570', 1, NULL, 10, '23.570', 'Twenty  Three', '002-001', 1, NULL, NULL),
(120, 40, 'Paid AU Payment Credit Against Job Purchase. JP-22112024-0001', '1', '0', '2024-11-22', '23.570', '0.000', 1, NULL, 11, '23.570', 'Twenty  Three', '002-002', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_09_02_194924_create_permission_tables', 1),
(6, '2024_09_04_212533_create_warehouses_table', 2),
(7, '2024_09_05_000951_create_accounts_table', 3),
(8, '2024_09_05_001923_create_account_types_table', 3),
(9, '2024_09_05_230824_create_suppliers_table', 4),
(10, '2024_09_06_082046_create_journals_table', 5),
(11, '2024_09_06_182838_create_journal_entries_table', 6),
(12, '2024_09_06_183423_create_journal_entry_details_table', 6),
(13, '2024_09_09_230457_create_customers_table', 7),
(14, '2024_09_09_234727_create_products_table', 8),
(15, '2024_09_11_224744_create_employees_table', 9),
(20, '2024_09_14_193707_create_ratti_kaats_table', 10),
(21, '2024_09_15_173639_create_ratti_kaat_details_table', 11),
(22, '2024_09_15_213003_create_ratti_kaat_beads_table', 12),
(23, '2024_09_15_213235_create_ratti_kaat_stones_table', 13),
(24, '2024_09_18_222641_create_ratti_kaat_diamonds_table', 14),
(25, '2024_09_25_053101_create_supplier_payments_table', 15),
(26, '2024_09_26_223244_create_gold_rates_table', 16),
(27, '2024_09_27_005629_create_dollar_rates_table', 16),
(28, '2024_09_30_213559_create_finish_products_table', 17),
(29, '2024_10_05_210049_create_finish_product_beads_table', 18),
(30, '2024_10_05_211105_create_finish_product_stones_table', 18),
(31, '2024_10_05_211222_create_finish_product_diamonds_table', 18),
(32, '2024_10_04_220010_create_sales_table', 19),
(33, '2024_10_04_223105_create_sale_details_table', 19),
(34, '2024_10_04_230549_create_sale_detail_beads_table', 19),
(35, '2024_10_04_231850_create_sale_detail_stones_table', 19),
(36, '2024_10_04_232014_create_sale_detail_diamonds_table', 19),
(37, '2024_10_24_133042_create_bead_types_table', 20),
(38, '2024_10_24_133652_create_stone_categories_table', 20),
(39, '2024_10_24_133806_create_diamond_types_table', 20),
(40, '2024_10_24_133844_create_diamond_colors_table', 20),
(41, '2024_10_24_133905_create_diamond_cuts_table', 20),
(42, '2024_10_24_133945_create_diamond_clarities_table', 20),
(43, '2024_10_26_215001_create_other_sales_table', 21),
(44, '2024_10_26_215627_create_other_sale_details_table', 21),
(45, '2024_10_26_231811_create_other_products_table', 21),
(46, '2024_10_26_232159_create_other_product_units_table', 21),
(47, '2024_10_26_233238_create_transactions_table', 21),
(48, '2024_10_27_173619_create_other_purchases_table', 22),
(49, '2024_10_27_182503_create_other_purchase_details_table', 22),
(50, '2024_10_29_002339_create_stock_takings_table', 22),
(51, '2024_10_29_002813_create_stock_taking_details_table', 22),
(52, '2024_10_31_225107_create_company_settings_table', 23),
(53, '2024_11_01_221029_create_sale_orders_table', 23),
(54, '2024_11_01_221955_create_gold_rate_types_table', 23),
(55, '2024_11_01_222120_create_sale_order_details_table', 23),
(56, '2024_11_05_141632_create_purchase_orders_table', 23),
(57, '2024_11_05_141949_create_purchase_order_details_table', 23),
(58, '2024_11_06_165508_create_job_tasks_table', 23),
(59, '2024_11_06_165907_create_job_task_details_table', 23),
(60, '2024_11_06_165934_create_job_task_activities_table', 23),
(61, '2024_11_08_223900_create_job_purchases_table', 23),
(62, '2024_11_08_224031_create_job_purchase_details_table', 23),
(63, '2024_11_08_224144_create_job_purchase_detail_beads_table', 23),
(64, '2024_11_08_224203_create_job_purchase_detail_stones_table', 23),
(65, '2024_11_08_224222_create_job_purchase_detail_diamonds_table', 23);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `other_products`
--

CREATE TABLE `other_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_product_unit_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_products`
--

INSERT INTO `other_products` (`id`, `code`, `name`, `other_product_unit_id`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'PA3239', 'Packing Ring Light Boxes', 1, 1, 0, 1, NULL, NULL, '2024-10-27 23:55:10', '2024-10-27 23:55:10'),
(2, 'PA4214', 'Pakcing Simple ring boxes', 1, 1, 0, 1, NULL, NULL, '2024-11-07 16:17:00', '2024-11-07 16:17:00'),
(3, 'CH5214', 'Chinese Ruby Strings', 1, 1, 0, 1, NULL, NULL, '2024-11-07 16:17:35', '2024-11-07 16:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `other_product_units`
--

CREATE TABLE `other_product_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_product_units`
--

INSERT INTO `other_product_units` (`id`, `name`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Piece', 1, 0, 1, NULL, NULL, NULL, NULL),
(2, 'KG', 1, 0, 1, NULL, NULL, NULL, NULL),
(3, 'Liter', 1, 0, 1, NULL, NULL, NULL, NULL),
(4, 'Meter', 1, 0, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `other_purchases`
--

CREATE TABLE `other_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `other_purchase_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_purchase_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `reference` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_qty` decimal(18,3) DEFAULT NULL,
  `tax` decimal(18,3) DEFAULT NULL,
  `tax_amount` decimal(18,3) DEFAULT NULL,
  `sub_total` decimal(18,3) DEFAULT NULL,
  `total` decimal(18,3) DEFAULT NULL,
  `paid` decimal(18,3) DEFAULT NULL,
  `purchase_account_id` int(11) DEFAULT NULL,
  `paid_account_id` int(11) DEFAULT NULL,
  `supplier_payment_id` int(11) DEFAULT NULL,
  `jv_id` int(11) DEFAULT NULL,
  `paid_jv_id` int(11) DEFAULT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_purchases`
--

INSERT INTO `other_purchases` (`id`, `other_purchase_no`, `other_purchase_date`, `bill_no`, `supplier_id`, `warehouse_id`, `reference`, `total_qty`, `tax`, `tax_amount`, `sub_total`, `total`, `paid`, `purchase_account_id`, `paid_account_id`, `supplier_payment_id`, `jv_id`, `paid_jv_id`, `posted`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'OPO-07112024-0001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-11-07 16:19:10', '2024-11-07 16:19:10'),
(2, 'OPO-14112024-0002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-11-14 23:32:47', '2024-11-14 23:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `other_purchase_details`
--

CREATE TABLE `other_purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `other_purchase_id` int(11) DEFAULT NULL,
  `other_product_id` int(11) DEFAULT NULL,
  `qty` decimal(18,3) NOT NULL DEFAULT 0.000,
  `unit_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_sales`
--

CREATE TABLE `other_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `other_sale_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_sale_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_cnic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_qty` decimal(18,3) DEFAULT NULL,
  `tax` decimal(18,3) DEFAULT NULL,
  `tax_amount` decimal(18,3) DEFAULT NULL,
  `sub_total` decimal(18,3) DEFAULT NULL,
  `total` decimal(18,3) DEFAULT NULL,
  `is_credit` tinyint(1) NOT NULL DEFAULT 0,
  `cash_amount` decimal(18,3) DEFAULT NULL,
  `bank_transfer_amount` decimal(18,3) DEFAULT NULL,
  `card_amount` decimal(18,3) DEFAULT NULL,
  `advance_amount` decimal(18,3) DEFAULT NULL,
  `total_received` decimal(18,3) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `jv_id` int(11) DEFAULT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_sales`
--

INSERT INTO `other_sales` (`id`, `other_sale_no`, `other_sale_date`, `customer_id`, `customer_name`, `customer_cnic`, `customer_contact`, `customer_email`, `customer_address`, `total_qty`, `tax`, `tax_amount`, `sub_total`, `total`, `is_credit`, `cash_amount`, `bank_transfer_amount`, `card_amount`, `advance_amount`, `total_received`, `warehouse_id`, `jv_id`, `posted`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'OSL-27102024-0001', '2024-10-27', 4, 'Ahmad Suleman', '', '03214300000', NULL, 'Liberty', '0.000', NULL, NULL, NULL, '5000.000', 0, '5000.000', '0.000', '0.000', '0.000', '5000.000', NULL, NULL, 0, 0, 1, 1, NULL, '2024-10-27 23:55:46', '2024-10-27 23:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `other_sale_details`
--

CREATE TABLE `other_sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `other_sale_id` int(11) DEFAULT NULL,
  `other_product_id` int(11) DEFAULT NULL,
  `qty` decimal(18,3) NOT NULL DEFAULT 0.000,
  `unit_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_sale_details`
--

INSERT INTO `other_sale_details` (`id`, `other_sale_id`, `other_product_id`, `qty`, `unit_price`, `total_amount`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1.000', '5000.000', '5000.000', 0, 1, NULL, '2024-10-27 23:57:11', '2024-10-27 23:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard_access', 'web', '2024-09-03 15:09:01', '2024-09-03 15:09:01'),
(2, 'logout_access', 'web', '2024-09-03 15:35:18', '2024-09-03 18:45:59'),
(3, 'user_management_access', 'web', '2024-09-03 16:44:56', '2024-09-03 16:44:56'),
(4, 'permissions_access', 'web', '2024-09-03 16:45:15', '2024-09-03 18:43:18'),
(5, 'permissions_create', 'web', '2024-09-03 16:45:28', '2024-09-03 18:43:52'),
(6, 'permissions_edit', 'web', '2024-09-03 16:45:40', '2024-09-04 18:09:02'),
(7, 'roles_access', 'web', '2024-09-03 16:46:06', '2024-09-03 16:46:18'),
(8, 'roles_create', 'web', '2024-09-03 16:46:30', '2024-09-03 16:46:30'),
(9, 'roles_edit', 'web', '2024-09-03 16:46:44', '2024-09-03 16:46:44'),
(10, 'users_access', 'web', '2024-09-03 18:46:17', '2024-09-03 18:46:17'),
(11, 'users_create', 'web', '2024-09-03 18:46:26', '2024-09-03 18:46:26'),
(12, 'users_edit', 'web', '2024-09-03 18:46:37', '2024-09-03 18:46:37'),
(13, 'inventory_access', 'web', '2024-09-04 18:10:16', '2024-09-04 18:10:16'),
(14, 'warehouses_access', 'web', '2024-09-04 18:10:32', '2024-09-04 18:10:32'),
(15, 'warehouses_create', 'web', '2024-09-04 18:10:43', '2024-09-04 18:10:43'),
(16, 'warehouses_edit', 'web', '2024-09-04 18:10:54', '2024-09-04 18:10:54'),
(17, 'warehouses_delete', 'web', '2024-09-04 18:12:49', '2024-09-04 18:12:49'),
(18, 'accounting_access', 'web', '2024-09-05 17:49:20', '2024-09-05 17:49:20'),
(19, 'accounts_access', 'web', '2024-09-05 17:49:32', '2024-09-05 17:49:32'),
(20, 'accounts_create', 'web', '2024-09-05 17:49:41', '2024-09-05 17:49:41'),
(21, 'accounts_edit', 'web', '2024-09-05 17:49:50', '2024-09-05 17:49:50'),
(22, 'accounts_delete', 'web', '2024-09-05 17:49:59', '2024-09-05 17:49:59'),
(23, 'accounts_status', 'web', '2024-09-05 17:50:09', '2024-09-05 17:50:09'),
(24, 'suppliers_access', 'web', '2024-09-05 18:31:05', '2024-09-05 18:31:05'),
(25, 'suppliers_create', 'web', '2024-09-05 18:31:14', '2024-09-05 18:31:14'),
(26, 'suppliers_edit', 'web', '2024-09-05 18:31:21', '2024-09-05 18:31:21'),
(27, 'suppliers_delete', 'web', '2024-09-05 18:31:35', '2024-09-05 18:31:35'),
(28, 'suppliers_status', 'web', '2024-09-05 18:31:45', '2024-09-05 18:31:45'),
(29, 'journals_access', 'web', '2024-09-06 04:08:19', '2024-09-06 04:08:19'),
(30, 'journals_create', 'web', '2024-09-06 04:08:30', '2024-09-06 04:08:30'),
(31, 'journals_edit', 'web', '2024-09-06 04:08:44', '2024-09-06 04:08:44'),
(32, 'journals_delete', 'web', '2024-09-06 04:08:54', '2024-09-06 04:08:54'),
(33, 'journals_status', 'web', '2024-09-06 04:09:05', '2024-09-06 04:09:05'),
(34, 'journal_entries_access', 'web', '2024-09-06 15:22:33', '2024-09-06 15:22:33'),
(35, 'journal_entries_create', 'web', '2024-09-06 15:22:44', '2024-09-06 15:22:44'),
(36, 'journal_entries_edit', 'web', '2024-09-06 15:22:57', '2024-09-06 15:22:57'),
(37, 'journal_entries_print', 'web', '2024-09-06 15:23:10', '2024-09-06 15:23:10'),
(38, 'journal_entries_delete', 'web', '2024-09-06 15:23:22', '2024-09-06 15:23:22'),
(39, 'customers_access', 'web', '2024-09-09 18:32:21', '2024-09-09 18:32:21'),
(40, 'customers_create', 'web', '2024-09-09 18:32:33', '2024-09-09 18:32:33'),
(41, 'customers_edit', 'web', '2024-09-09 18:32:42', '2024-09-09 18:32:42'),
(42, 'customers_status', 'web', '2024-09-09 18:32:53', '2024-09-09 18:32:53'),
(43, 'customers_delete', 'web', '2024-09-09 18:33:03', '2024-09-09 18:33:03'),
(44, 'products_access', 'web', '2024-09-09 18:55:23', '2024-09-09 18:55:23'),
(45, 'products_create', 'web', '2024-09-09 18:55:32', '2024-09-09 18:55:32'),
(46, 'products_edit', 'web', '2024-09-09 18:55:40', '2024-09-09 18:55:40'),
(47, 'products_status', 'web', '2024-09-09 18:55:50', '2024-09-09 18:55:50'),
(48, 'products_delete', 'web', '2024-09-09 18:55:59', '2024-09-09 18:55:59'),
(49, 'hrm_access', 'web', '2024-09-11 19:10:46', '2024-09-11 19:10:46'),
(50, 'employees_access', 'web', '2024-09-11 19:10:53', '2024-09-11 19:10:53'),
(51, 'employees_create', 'web', '2024-09-11 19:11:09', '2024-09-11 19:11:09'),
(52, 'employees_edit', 'web', '2024-09-11 19:11:18', '2024-09-11 19:11:18'),
(53, 'employees_status', 'web', '2024-09-11 19:11:28', '2024-09-11 19:11:28'),
(54, 'employees_delete', 'web', '2024-09-11 19:11:38', '2024-09-11 19:11:38'),
(55, 'ratti_kaat_access', 'web', '2024-09-19 19:42:15', '2024-09-19 19:42:15'),
(56, 'ratti_kaat_create', 'web', '2024-09-19 19:42:24', '2024-09-19 19:42:24'),
(57, 'ratti_kaat_edit', 'web', '2024-09-19 19:42:31', '2024-09-19 19:42:31'),
(58, 'ratti_kaat_delete', 'web', '2024-09-19 19:42:40', '2024-09-19 19:42:40'),
(59, 'ratti_kaat_post', 'web', '2024-09-19 19:42:48', '2024-09-19 19:42:48'),
(60, 'purchase_access', 'web', '2024-09-19 20:25:46', '2024-09-19 20:25:46'),
(61, 'supplier_payment_access', 'web', '2024-09-25 16:25:17', '2024-09-25 16:25:17'),
(62, 'supplier_payment_create', 'web', '2024-09-25 16:25:31', '2024-09-25 16:25:31'),
(63, 'supplier_payment_edit', 'web', '2024-09-25 16:25:44', '2024-09-25 16:25:44'),
(64, 'supplier_payment_delete', 'web', '2024-09-25 16:25:56', '2024-09-25 16:25:56'),
(65, 'supplier_payment_print', 'web', '2024-09-25 17:35:50', '2024-09-25 17:35:50'),
(66, 'tagging_product_access', 'web', '2024-12-02 18:40:38', '2024-12-02 18:47:49'),
(67, 'tagging_product_create', 'web', '2024-12-02 18:40:53', '2024-12-02 18:48:01'),
(68, 'tagging_product_view', 'web', '2024-12-02 18:41:04', '2024-12-02 18:48:38'),
(69, 'tagging_product_delete', 'web', '2024-12-02 18:41:14', '2024-12-02 18:48:14'),
(70, 'tagging_product_status', 'web', '2024-12-02 18:41:32', '2024-12-02 18:48:26'),
(71, 'other_product_access', 'web', '2024-12-02 18:42:12', '2024-12-02 18:48:52'),
(72, 'other_product_create', 'web', '2024-12-02 18:42:25', '2024-12-02 18:42:25'),
(73, 'other_product_edit', 'web', '2024-12-02 18:42:37', '2024-12-02 18:42:37'),
(74, 'other_product_delete', 'web', '2024-12-02 18:42:46', '2024-12-02 18:42:46'),
(75, 'stock_access', 'web', '2024-12-02 18:43:23', '2024-12-02 18:49:10'),
(76, 'stock_taking_access', 'web', '2024-12-02 18:44:15', '2024-12-02 18:49:23'),
(77, 'stock_taking_create', 'web', '2024-12-02 18:44:26', '2024-12-02 18:44:26'),
(78, 'stock_taking_edit', 'web', '2024-12-02 18:44:36', '2024-12-02 18:44:36'),
(79, 'stock_taking_delete', 'web', '2024-12-02 18:44:47', '2024-12-02 18:44:47'),
(80, 'bead_type_access', 'web', '2024-12-02 18:49:39', '2024-12-02 18:49:39'),
(81, 'bead_type_create', 'web', '2024-12-02 18:51:07', '2024-12-02 18:51:07'),
(82, 'bead_type_edit', 'web', '2024-12-02 18:51:21', '2024-12-02 18:51:21'),
(83, 'bead_type_status', 'web', '2024-12-02 18:51:33', '2024-12-02 18:51:33'),
(84, 'bead_type_delete', 'web', '2024-12-02 18:51:46', '2024-12-02 18:51:46'),
(85, 'setting_access', 'web', '2024-12-02 18:54:10', '2024-12-02 18:54:10'),
(86, 'setting_update', 'web', '2024-12-02 18:54:20', '2024-12-02 18:54:20'),
(87, 'diamond_clarity_access', 'web', '2024-12-02 18:55:47', '2024-12-02 18:55:47'),
(88, 'diamond_clarity_create', 'web', '2024-12-02 18:55:59', '2024-12-02 18:55:59'),
(89, 'diamond_clarity_edit', 'web', '2024-12-02 18:56:09', '2024-12-02 18:56:09'),
(90, 'diamond_clarity_status', 'web', '2024-12-02 18:56:19', '2024-12-02 18:56:19'),
(91, 'diamond_clarity_delete', 'web', '2024-12-02 18:56:28', '2024-12-02 18:56:28'),
(92, 'diamond_color_access', 'web', '2024-12-02 19:04:42', '2024-12-02 19:04:42'),
(93, 'diamond_color_create', 'web', '2024-12-02 19:04:53', '2024-12-02 19:04:53'),
(94, 'diamond_color_edit', 'web', '2024-12-02 19:05:02', '2024-12-02 19:05:02'),
(95, 'diamond_color_status', 'web', '2024-12-02 19:05:13', '2024-12-02 19:05:13'),
(96, 'diamond_color_delete', 'web', '2024-12-02 19:05:24', '2024-12-02 19:05:24'),
(97, 'diamond_cut_access', 'web', '2024-12-02 19:05:42', '2024-12-02 19:05:42'),
(98, 'diamond_cut_create', 'web', '2024-12-02 19:05:52', '2024-12-02 19:05:52'),
(99, 'diamond_cut_edit', 'web', '2024-12-02 19:06:05', '2024-12-02 19:06:05'),
(100, 'diamond_cut_delete', 'web', '2024-12-02 19:06:15', '2024-12-02 19:06:15'),
(101, 'diamond_cut_status', 'web', '2024-12-02 19:06:31', '2024-12-02 19:06:31'),
(102, 'diamond_type_access', 'web', '2024-12-02 19:06:43', '2024-12-02 19:06:43'),
(103, 'diamond_type_create', 'web', '2024-12-02 19:06:53', '2024-12-02 19:06:53'),
(104, 'diamond_type_edit', 'web', '2024-12-02 19:07:04', '2024-12-02 19:07:04'),
(105, 'diamond_type_status', 'web', '2024-12-02 19:07:15', '2024-12-02 19:07:15'),
(106, 'diamond_type_delete', 'web', '2024-12-02 19:07:25', '2024-12-02 19:07:25'),
(107, 'gold_chart_access', 'web', '2024-12-03 03:51:49', '2024-12-03 03:51:49'),
(108, 'gold_rate_log_access', 'web', '2024-12-03 03:53:58', '2024-12-03 03:53:58'),
(109, 'gold_rate_log_create', 'web', '2024-12-03 03:55:16', '2024-12-03 03:55:16'),
(110, 'dollar_rate_log_create', 'web', '2024-12-03 03:55:26', '2024-12-03 03:55:26'),
(111, 'dollar_rate_log_access', 'web', '2024-12-03 03:55:41', '2024-12-03 03:55:41'),
(112, 'job_purchase_access', 'web', '2024-12-03 04:00:55', '2024-12-03 04:00:55'),
(113, 'job_purchase_create', 'web', '2024-12-03 04:01:06', '2024-12-03 04:01:06'),
(114, 'job_purchase_print', 'web', '2024-12-03 04:01:24', '2024-12-03 04:01:24'),
(115, 'job_purchase_unpost', 'web', '2024-12-03 04:01:52', '2024-12-03 04:01:52'),
(116, 'job_purchase_post', 'web', '2024-12-03 04:02:04', '2024-12-03 04:02:04'),
(117, 'job_purchase_delete', 'web', '2024-12-03 04:02:16', '2024-12-03 04:02:16'),
(118, 'job_purchase_jvs', 'web', '2024-12-03 04:03:10', '2024-12-03 04:03:10'),
(119, 'job_task_activity_access', 'web', '2024-12-03 04:06:28', '2024-12-03 04:07:35'),
(120, 'job_task_activity_create', 'web', '2024-12-03 04:06:38', '2024-12-03 04:07:47'),
(121, 'job_task_activity_delete', 'web', '2024-12-03 04:06:48', '2024-12-03 04:07:58'),
(122, 'job_task_access', 'web', '2024-12-03 04:11:10', '2024-12-03 04:11:10'),
(123, 'job_task_create', 'web', '2024-12-03 04:11:20', '2024-12-03 04:11:20'),
(124, 'job_task_print', 'web', '2024-12-03 04:11:38', '2024-12-03 04:11:38'),
(125, 'job_task_delete', 'web', '2024-12-03 04:11:49', '2024-12-03 04:11:49'),
(126, 'job_task_complete', 'web', '2024-12-03 04:14:02', '2024-12-03 04:14:02'),
(131, 'other_product_status', 'web', '2024-12-03 04:49:48', '2024-12-03 04:49:48'),
(132, 'other_purchase_access', 'web', '2024-12-03 04:55:04', '2024-12-03 04:55:04'),
(133, 'other_purchase_create', 'web', '2024-12-03 04:55:13', '2024-12-03 04:55:13'),
(134, 'other_purchase_print', 'web', '2024-12-03 04:55:29', '2024-12-03 04:55:29'),
(135, 'other_purchase_unpost', 'web', '2024-12-03 04:56:04', '2024-12-03 04:56:04'),
(136, 'other_purchase_post', 'web', '2024-12-03 04:56:36', '2024-12-03 04:56:36'),
(137, 'other_purchase_jvs', 'web', '2024-12-03 04:56:49', '2024-12-03 04:56:49'),
(138, 'other_purchase_delete', 'web', '2024-12-03 04:56:59', '2024-12-03 04:56:59'),
(139, 'other_sale_access', 'web', '2024-12-03 05:00:12', '2024-12-03 05:00:12'),
(140, 'other_sale_create', 'web', '2024-12-03 05:00:22', '2024-12-03 05:00:22'),
(141, 'other_sale_print', 'web', '2024-12-03 05:00:40', '2024-12-03 05:00:40'),
(142, 'other_sale_unpost', 'web', '2024-12-03 05:00:53', '2024-12-03 05:00:53'),
(143, 'other_sale_post', 'web', '2024-12-03 05:01:02', '2024-12-03 05:01:02'),
(144, 'other_sale_delete', 'web', '2024-12-03 05:01:18', '2024-12-03 05:01:18');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `prefix`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Ladies Rings', 'LR', 1, 1, 1, 1, 1, '2024-09-09 19:13:26', '2024-09-09 19:13:38'),
(2, 'Ladies Rings', 'LR', 1, 1, 1, 1, 1, '2024-09-16 11:27:42', '2024-11-19 20:26:20'),
(3, 'Necklace Set', 'NS', 1, 1, 1, NULL, 1, '2024-10-07 15:56:49', '2024-11-19 20:26:07'),
(4, 'Diamond Ladie Rings', 'DLR', 1, 1, 1, NULL, 1, '2024-11-07 16:29:30', '2024-11-19 20:25:59'),
(5, 'Ladies Rings', 'LR', 1, 1, 1, NULL, 1, '2024-11-14 21:05:10', '2024-11-19 20:26:04'),
(6, 'Ladies Rings', 'LR', 1, 0, 1, NULL, NULL, '2024-11-19 20:26:45', '2024-11-19 20:26:45'),
(7, 'Diamond Ladies Rings', 'DLR', 1, 0, 1, NULL, NULL, '2024-11-19 20:27:02', '2024-11-19 20:27:02'),
(8, 'Gents Rings', 'GR', 1, 0, 1, NULL, NULL, '2024-11-19 20:27:14', '2024-11-19 20:27:14'),
(9, 'Diamond Gents Ring', 'DGR', 1, 0, 1, NULL, NULL, '2024-11-19 20:27:31', '2024-11-19 20:27:31'),
(10, 'Bangles', 'B', 1, 0, 1, NULL, NULL, '2024-11-19 20:27:46', '2024-11-19 20:27:46'),
(11, 'Loose Bracelet', 'LBR', 1, 0, 1, NULL, NULL, '2024-11-19 20:28:12', '2024-11-19 20:28:12'),
(12, 'Crown', 'CR', 1, 0, 1, 1, NULL, '2024-11-19 20:28:35', '2024-11-19 20:35:20'),
(13, 'Kara Bangle', 'KB', 1, 0, 1, NULL, NULL, '2024-11-19 20:28:59', '2024-11-19 20:28:59'),
(14, 'Baliya', 'BL', 1, 1, 1, NULL, 1, '2024-11-21 04:08:37', '2024-11-21 04:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_order_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `sale_order_id` int(11) DEFAULT NULL,
  `total_qty` decimal(18,3) DEFAULT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `approvedby_id` int(11) DEFAULT NULL,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `purchase_order_no`, `purchase_order_date`, `delivery_date`, `status`, `reference_no`, `supplier_id`, `warehouse_id`, `sale_order_id`, `total_qty`, `is_complete`, `is_deleted`, `approvedby_id`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'POO-14112024-0001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 1, NULL, NULL, '2024-11-14 23:16:38', '2024-11-14 23:16:38'),
(2, 'POO-14112024-0002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 1, NULL, NULL, '2024-11-14 23:35:27', '2024-11-14 23:35:27'),
(3, 'POO-20112024-0003', '2024-11-20', '2024-11-29T16:15', 'Approved', 'Sales Order', 8, 1, NULL, '1.000', 0, 0, NULL, 1, 1, NULL, '2024-11-20 18:14:54', '2024-11-26 18:11:21'),
(4, 'POO-20112024-0004', '2024-11-20', '2024-11-29T16:17', 'Approved', 'SO 991', 8, 1, NULL, '1.000', 0, 0, NULL, 1, 1, NULL, '2024-11-20 18:16:31', '2024-11-26 18:11:16'),
(5, 'POO-22112024-0005', '2024-11-22', '2024-11-21T17:33', 'Approved', 'aaaa', 8, 1, NULL, '1.000', 1, 0, 1, 1, 1, NULL, '2024-11-22 09:33:17', '2024-11-22 09:54:48'),
(6, 'POO-26112024-0006', '2024-11-26', '2024-11-28T04:17', 'Approved', 'aaaa', 8, 1, NULL, '1.000', 0, 0, NULL, 1, 1, NULL, '2024-11-26 18:17:22', '2024-11-26 18:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_details`
--

CREATE TABLE `purchase_order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `design_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_details`
--

INSERT INTO `purchase_order_details` (`id`, `purchase_order_id`, `product_id`, `category`, `design_no`, `net_weight`, `description`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 3, 10, '21K', 'B00049', '40.000', '2.3 Inch size and same as picture', 0, 1, NULL, '2024-11-20 18:16:14', '2024-11-20 18:16:14'),
(2, 4, 10, '21K', 'B00049', '40.000', '2.3 Inches ', 0, 1, NULL, '2024-11-20 18:18:47', '2024-11-20 18:18:47'),
(3, 5, 6, 'asdd', 'aas', '23.567', 'Reaction on Trade of Jannah', 0, 1, NULL, '2024-11-22 09:34:05', '2024-11-22 09:34:05'),
(4, 6, 11, 'ac', 'ww', '23.400', 'Reaction on Trade of Jannah', 0, 1, NULL, '2024-11-26 18:17:58', '2024-11-26 18:17:58');

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaats`
--

CREATE TABLE `ratti_kaats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ratti_kaat_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `purchase_account` int(11) DEFAULT NULL,
  `paid` decimal(18,3) NOT NULL DEFAULT 0.000,
  `paid_account` int(11) DEFAULT NULL,
  `paid_au` decimal(18,3) NOT NULL DEFAULT 0.000,
  `paid_account_au` int(11) DEFAULT NULL,
  `paid_dollar` decimal(18,3) NOT NULL DEFAULT 0.000,
  `paid_account_dollar` int(11) DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pictures` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_amount` decimal(18,3) DEFAULT NULL,
  `tax_account` int(11) DEFAULT NULL,
  `sub_total` decimal(18,3) DEFAULT 0.000,
  `total` decimal(18,3) DEFAULT 0.000,
  `total_au` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_dollar` decimal(18,3) NOT NULL DEFAULT 0.000,
  `jv_id` int(11) DEFAULT NULL,
  `paid_jv_id` int(11) DEFAULT NULL,
  `paid_au_jv_id` int(11) DEFAULT NULL,
  `paid_dollar_jv_id` int(11) DEFAULT NULL,
  `supplier_payment_id` int(11) DEFAULT NULL,
  `supplier_au_payment_id` int(11) DEFAULT NULL,
  `supplier_dollar_payment_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 for active, 0 for inactive',
  `is_posted` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratti_kaats`
--

INSERT INTO `ratti_kaats` (`id`, `ratti_kaat_no`, `purchase_date`, `supplier_id`, `purchase_account`, `paid`, `paid_account`, `paid_au`, `paid_account_au`, `paid_dollar`, `paid_account_dollar`, `reference`, `pictures`, `tax_amount`, `tax_account`, `sub_total`, `total`, `total_au`, `total_dollar`, `jv_id`, `paid_jv_id`, `paid_au_jv_id`, `paid_dollar_jv_id`, `supplier_payment_id`, `supplier_au_payment_id`, `supplier_dollar_payment_id`, `is_active`, `is_posted`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'RK-19092024-0001', '2024-09-21', 2, 6, '1234.000', 6, '0.000', NULL, '0.000', NULL, 'Voluptatem deleniti a ut harum quis est sed sed officiis accusantium blanditiis asperiores sint placeat sunt quae ut minim', '[\"pictures\\/172687815366ee11c9c84e2.png\",\"pictures\\/172687815366ee11c9c89fc.jpg\"]', NULL, NULL, NULL, '31813.125', '0.000', '0.000', 22, 23, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-09-19 18:45:04', '2024-09-25 00:26:12'),
(5, 'RK-20092024-0002', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-19 19:44:20', '2024-09-19 19:44:20'),
(6, 'RK-20092024-0003', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-19 19:44:22', '2024-09-19 19:44:22'),
(7, 'RK-20092024-0004', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-19 20:26:08', '2024-09-19 20:26:08'),
(8, 'RK-20092024-0005', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-19 20:26:11', '2024-09-19 20:26:11'),
(9, 'RK-20092024-0006', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:26:57', '2024-09-20 16:26:57'),
(10, 'RK-20092024-0007', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:27:10', '2024-09-20 16:27:10'),
(11, 'RK-20092024-0008', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:35:04', '2024-09-20 16:35:04'),
(12, 'RK-20092024-0009', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:35:07', '2024-09-20 16:35:07'),
(13, 'RK-20092024-0010', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:38:46', '2024-09-20 16:38:46'),
(14, 'RK-20092024-0011', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:38:52', '2024-09-20 16:38:52'),
(15, 'RK-20092024-0012', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:42:26', '2024-09-20 16:42:26'),
(16, 'RK-20092024-0013', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:42:32', '2024-09-20 16:42:32'),
(17, 'RK-20092024-0014', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:44:42', '2024-09-20 16:44:42'),
(18, 'RK-20092024-0015', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:44:48', '2024-09-20 16:44:48'),
(19, 'RK-20092024-0016', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:45:58', '2024-09-20 16:45:58'),
(20, 'RK-20092024-0017', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:46:02', '2024-09-20 16:46:02'),
(21, 'RK-20092024-0018', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:47:10', '2024-09-20 16:47:10'),
(22, 'RK-20092024-0019', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:47:15', '2024-09-20 16:47:15'),
(23, 'RK-20092024-0020', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:48:58', '2024-09-20 16:48:58'),
(24, 'RK-20092024-0021', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:49:03', '2024-09-20 16:49:03'),
(25, 'RK-20092024-0022', '2024-09-20', 2, 6, '0.000', NULL, '0.000', NULL, '0.000', NULL, 'Voluptatem deleniti a ut harum quis est sed sed officiis accusantium blanditiis asperiores sint placeat sunt quae ut minim', NULL, NULL, NULL, NULL, '17550.000', '0.000', '0.000', 21, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-09-20 16:51:30', '2024-09-25 00:25:32'),
(26, 'RK-20092024-0023', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:51:35', '2024-09-20 16:51:35'),
(27, 'RK-20092024-0024', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:54:34', '2024-09-20 16:54:34'),
(28, 'RK-20092024-0025', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:54:36', '2024-09-20 16:54:36'),
(29, 'RK-20092024-0026', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:55:22', '2024-09-20 16:55:22'),
(30, 'RK-20092024-0027', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 16:55:23', '2024-09-20 16:55:23'),
(31, 'RK-20092024-0028', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:26:10', '2024-09-20 18:26:10'),
(32, 'RK-20092024-0029', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:26:11', '2024-09-20 18:26:11'),
(33, 'RK-20092024-0030', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:27:17', '2024-09-20 18:27:17'),
(34, 'RK-20092024-0031', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:27:19', '2024-09-20 18:27:19'),
(35, 'RK-20092024-0032', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:27:40', '2024-09-20 18:27:40'),
(36, 'RK-20092024-0033', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:27:42', '2024-09-20 18:27:42'),
(37, 'RK-20092024-0034', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:28:06', '2024-09-20 18:28:06'),
(38, 'RK-20092024-0035', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:28:08', '2024-09-20 18:28:08'),
(39, 'RK-20092024-0036', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:30:08', '2024-09-20 18:30:08'),
(40, 'RK-20092024-0037', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-20 18:30:09', '2024-09-20 18:30:09'),
(41, 'RK-23092024-0038', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 16:57:12', '2024-09-23 16:57:12'),
(42, 'RK-23092024-0039', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 16:57:33', '2024-09-23 16:57:33'),
(43, 'RK-23092024-0040', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:00:56', '2024-09-23 17:00:56'),
(44, 'RK-23092024-0041', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:00:58', '2024-09-23 17:00:58'),
(45, 'RK-23092024-0042', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:03:30', '2024-09-23 17:03:30'),
(46, 'RK-23092024-0043', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:03:33', '2024-09-23 17:03:33'),
(47, 'RK-23092024-0044', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:03:54', '2024-09-23 17:03:54'),
(48, 'RK-23092024-0045', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:03:55', '2024-09-23 17:03:55'),
(49, 'RK-23092024-0046', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:04:51', '2024-09-23 17:04:51'),
(50, 'RK-23092024-0047', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:04:53', '2024-09-23 17:04:53'),
(51, 'RK-23092024-0048', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:06:56', '2024-09-23 17:06:56'),
(52, 'RK-23092024-0049', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:06:59', '2024-09-23 17:06:59'),
(53, 'RK-23092024-0050', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:10:14', '2024-09-23 17:10:14'),
(54, 'RK-23092024-0051', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:10:17', '2024-09-23 17:10:17'),
(55, 'RK-23092024-0052', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:10:28', '2024-09-23 17:10:28'),
(56, 'RK-23092024-0053', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:10:29', '2024-09-23 17:10:29'),
(57, 'RK-23092024-0054', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:10:54', '2024-09-23 17:10:54'),
(58, 'RK-23092024-0055', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:10:55', '2024-09-23 17:10:55'),
(59, 'RK-23092024-0056', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:12:51', '2024-09-23 17:12:51'),
(60, 'RK-23092024-0057', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:12:53', '2024-09-23 17:12:53'),
(61, 'RK-23092024-0058', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:15:19', '2024-09-23 17:15:19'),
(62, 'RK-23092024-0059', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:15:20', '2024-09-23 17:15:20'),
(63, 'RK-23092024-0060', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:16:00', '2024-09-23 17:16:00'),
(64, 'RK-23092024-0061', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:16:03', '2024-09-23 17:16:03'),
(65, 'RK-23092024-0062', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:16:05', '2024-09-23 17:16:05'),
(66, 'RK-23092024-0063', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:16:07', '2024-09-23 17:16:07'),
(67, 'RK-23092024-0064', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:16:17', '2024-09-23 17:16:17'),
(68, 'RK-23092024-0065', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:16:20', '2024-09-23 17:16:20'),
(69, 'RK-23092024-0066', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:16:35', '2024-09-23 17:16:35'),
(70, 'RK-23092024-0067', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 17:16:37', '2024-09-23 17:16:37'),
(71, 'RK-23092024-0068', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 18:17:55', '2024-09-23 18:17:55'),
(72, 'RK-23092024-0069', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 18:18:04', '2024-09-23 18:18:04'),
(73, 'RK-23092024-0070', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 18:18:08', '2024-09-23 18:18:08'),
(74, 'RK-23092024-0071', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 18:18:10', '2024-09-23 18:18:10'),
(75, 'RK-23092024-0072', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 18:28:07', '2024-09-23 18:28:07'),
(76, 'RK-23092024-0073', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 18:28:11', '2024-09-23 18:28:11'),
(77, 'RK-23092024-0074', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 18:32:19', '2024-09-23 18:32:19'),
(78, 'RK-23092024-0075', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 18:32:22', '2024-09-23 18:32:22'),
(79, 'RK-23092024-0076', '2024-09-23', 2, 8, '15000.000', 6, '60.000', 5, '200.000', 8, 'Voluptatem deleniti a ut harum quis est sed sed officiis accusantium blanditiis asperiores sint placeat sunt quae ut minim', '[]', NULL, NULL, NULL, '150313.125', '66.676', '225.806', 19, 20, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, '2024-09-23 18:34:57', '2024-09-25 19:11:01'),
(80, 'RK-23092024-0077', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-23 18:35:00', '2024-09-23 18:35:00'),
(81, 'RK-26092024-0078', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-27 03:18:30', '2024-09-27 03:18:30'),
(82, 'RK-26092024-0079', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-27 03:18:32', '2024-09-27 03:18:32'),
(83, 'RK-27092024-0080', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-27 08:18:24', '2024-09-27 08:18:24'),
(84, 'RK-27092024-0081', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-27 08:18:25', '2024-09-27 08:18:25'),
(85, 'RK-27092024-0082', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-27 08:18:40', '2024-09-27 08:18:40'),
(86, 'RK-27092024-0083', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-27 08:18:41', '2024-09-27 08:18:41'),
(87, 'RK-27092024-0084', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-27 17:40:47', '2024-09-27 17:40:47'),
(88, 'RK-27092024-0085', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-27 17:44:10', '2024-09-27 17:44:10'),
(89, 'RK-27092024-0086', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-27 18:15:10', '2024-09-27 18:15:10'),
(90, 'RK-27092024-0087', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-28 02:09:41', '2024-09-28 02:09:41'),
(91, 'RK-27092024-0088', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-28 04:13:48', '2024-09-28 04:13:48'),
(92, 'RK-27092024-0089', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-28 04:13:50', '2024-09-28 04:13:50'),
(93, 'RK-27092024-0090', '2024-09-27', 4, 5, '0.000', NULL, '0.000', NULL, '0.000', NULL, 'abc', '[]', NULL, NULL, '0.000', '1725.000', '72.187', '0.000', 25, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-09-28 04:56:11', '2024-09-28 04:57:35'),
(94, 'RK-27092024-0091', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-09-28 04:56:12', '2024-09-28 04:56:12'),
(95, 'RK-04102024-0092', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-04 20:39:46', '2024-10-04 20:39:46'),
(96, 'RK-05102024-0093', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-05 18:13:16', '2024-10-05 18:13:16'),
(97, 'RK-05102024-0094', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-05 18:36:05', '2024-10-05 18:36:05'),
(98, 'RK-05102024-0095', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-05 18:36:05', '2024-10-05 18:36:05'),
(99, 'RK-06102024-0096', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-07 02:09:57', '2024-10-07 02:09:57'),
(100, 'RK-06102024-0097', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-07 02:09:59', '2024-10-07 02:09:59'),
(101, 'RK-07102024-0098', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-07 15:55:22', '2024-10-07 15:55:22'),
(102, 'RK-07102024-0099', '2024-10-07', 4, 11, '0.000', NULL, '0.000', NULL, '0.000', NULL, 'Purchase for Stock', '[]', NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, '2024-10-07 15:56:57', '2024-10-07 16:00:34'),
(103, 'RK-16102024-0100', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-17 00:59:03', '2024-10-17 00:59:03'),
(104, 'RK-17102024-0101', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-17 15:34:24', '2024-10-17 15:34:24'),
(105, 'RK-17102024-0102', '2024-10-17', 5, 11, '0.000', 10, '0.000', 11, '0.000', 12, 'Sales Order', '[]', NULL, NULL, '0.000', '587955.000', '81.578', '2048.775', 33, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-10-17 15:39:37', '2024-10-17 16:01:37'),
(106, 'RK-22102024-0103', '2024-10-22', 2, 6, '0.000', NULL, '0.000', NULL, '0.000', NULL, '111', '[]', NULL, NULL, '0.000', '6550.000', '141.833', '0.000', 35, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-10-22 18:17:55', '2024-10-22 18:19:29'),
(107, 'RK-27102024-0104', '2024-10-27', 6, 11, '0.000', NULL, '0.000', NULL, '0.000', NULL, 'Internal Requisition', '[]', NULL, NULL, '0.000', '3000.000', '33.263', '0.000', 36, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-10-28 00:36:15', '2024-10-28 00:37:27'),
(108, 'RK-30102024-0105', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-10-30 17:39:36', '2024-10-30 17:39:36'),
(109, 'RK-07112024-0106', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-11-07 16:28:51', '2024-11-07 16:28:51'),
(110, 'RK-07112024-0107', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-11-07 16:29:44', '2024-11-07 16:29:44'),
(111, 'RK-07112024-0108', '2024-11-07', 7, 11, '0.000', 10, '0.000', 11, '0.000', 12, '12345', '[]', NULL, NULL, '0.000', '5403600.000', '91.265', '19453.430', 37, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, NULL, '2024-11-07 16:34:07', '2024-11-07 16:36:34'),
(112, 'RK-07112024-0109', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-11-07 16:37:19', '2024-11-07 16:37:19'),
(113, 'RK-14112024-0110', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-11-14 23:19:51', '2024-11-14 23:19:51'),
(114, 'RK-20112024-0111', NULL, NULL, NULL, '0.000', NULL, '0.000', NULL, '0.000', NULL, NULL, NULL, NULL, NULL, '0.000', '0.000', '0.000', '0.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, NULL, '2024-11-20 18:03:25', '2024-11-20 18:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaat_beads`
--

CREATE TABLE `ratti_kaat_beads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ratti_kaat_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `beads` decimal(8,3) NOT NULL DEFAULT 0.000,
  `gram` decimal(8,3) NOT NULL DEFAULT 0.000,
  `carat` decimal(8,3) NOT NULL DEFAULT 0.000,
  `gram_rate` decimal(8,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(8,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(8,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratti_kaat_beads`
--

INSERT INTO `ratti_kaat_beads` (`id`, `type`, `ratti_kaat_id`, `product_id`, `beads`, `gram`, `carat`, `gram_rate`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 2, '1.000', '25.690', '128.450', '75.000', '15.000', '1926.750', 1, 1, NULL, 1, '2024-09-19 18:45:53', '2024-09-19 20:08:05'),
(2, NULL, 1, 2, '1.000', '25.690', '128.450', '75.000', '15.000', '1926.750', 1, 1, NULL, 1, '2024-09-19 20:08:01', '2024-09-19 20:18:26'),
(3, NULL, 1, 2, '1.000', '25.690', '128.450', '75.000', '15.000', '1926.750', 0, 1, NULL, NULL, '2024-09-19 20:18:20', '2024-09-19 20:18:20'),
(4, NULL, 23, 2, '1.000', '12.000', '60.000', '75.000', '15.000', '900.000', 0, 1, NULL, NULL, '2024-09-20 16:50:29', '2024-09-20 16:50:29'),
(5, NULL, 25, 2, '1.000', '234.000', '1170.000', '75.000', '15.000', '17550.000', 0, 1, NULL, NULL, '2024-09-20 16:52:04', '2024-09-20 16:52:04'),
(6, 'Glass Bead', 79, 2, '1.000', '25.690', '128.450', '75.000', '15.000', '1926.750', 0, 1, NULL, NULL, '2024-09-23 18:35:32', '2024-09-23 18:35:32'),
(7, 'Gemstone Bead', 88, 2, '1.000', '1.200', '6.000', '1500.000', '300.000', '1800.000', 0, 1, NULL, NULL, '2024-09-27 17:45:28', '2024-09-27 17:45:28'),
(8, 'Glass Bead', 90, 2, '1.000', '2.000', '10.000', '75.000', '15.000', '150.000', 0, 1, NULL, NULL, '2024-09-28 02:10:13', '2024-09-28 02:10:13'),
(9, 'Glass Bead', 91, 2, '1.000', '23.000', '115.000', '75.000', '15.000', '1725.000', 0, 1, NULL, NULL, '2024-09-28 04:14:26', '2024-09-28 04:14:26'),
(10, 'Glass Bead', 93, 2, '1.000', '23.000', '115.000', '75.000', '15.000', '1725.000', 0, 1, NULL, NULL, '2024-09-28 04:56:39', '2024-09-28 04:56:39'),
(11, 'Glass Bead', 102, 3, '1.000', '18.460', '92.300', '75.000', '15.000', '1384.500', 0, 1, NULL, NULL, '2024-10-07 15:58:30', '2024-10-07 15:58:30'),
(12, 'Metal Bead', 103, 3, '1.000', '10.000', '50.000', '150.000', '30.000', '1500.000', 0, 1, NULL, NULL, '2024-10-17 01:00:15', '2024-10-17 01:00:15'),
(13, 'Glass Bead', 105, 3, '1.000', '20.654', '103.270', '150.000', '30.000', '3098.100', 0, 1, NULL, NULL, '2024-10-17 15:41:36', '2024-10-17 15:41:36'),
(14, 'Gemstone Bead', 105, 3, '2.000', '4.380', '21.900', '280.000', '56.000', '1226.400', 0, 1, NULL, NULL, '2024-10-17 15:42:01', '2024-10-17 15:42:01'),
(15, 'Seed Bead', 106, 3, '2.000', '2.000', '10.000', '775.000', '155.000', '1550.000', 0, 1, NULL, NULL, '2024-10-22 18:18:45', '2024-10-22 18:18:45');

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaat_details`
--

CREATE TABLE `ratti_kaat_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ratti_kaat_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scale_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `bead_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `stones_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `diamond_carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `net_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `supplier_kaat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `kaat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `approved_by` int(11) DEFAULT NULL,
  `pure_payable` decimal(18,3) NOT NULL DEFAULT 0.000,
  `other_charge` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_bead_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_stones_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_diamond_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_dollar` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_finish_product` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratti_kaat_details`
--

INSERT INTO `ratti_kaat_details` (`id`, `ratti_kaat_id`, `product_id`, `description`, `scale_weight`, `bead_weight`, `stones_weight`, `diamond_carat`, `net_weight`, `supplier_kaat`, `kaat`, `approved_by`, `pure_payable`, `other_charge`, `total_bead_amount`, `total_stones_amount`, `total_diamond_amount`, `total_amount`, `total_dollar`, `is_finish_product`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Manual', '100.356', '0.000', '3.485', '0.000', '70.931', '0.000', '2.955', NULL, '67.976', '0.000', '1926.750', '261.375', '29625.000', '31813.125', '0.000', 0, 1, 1, NULL, 1, '2024-09-19 18:49:07', '2024-09-20 19:22:33'),
(2, 1, 2, 'Reaction on Trade of Jannah', '100.256', '0.000', '3.485', '0.000', '70.831', '4.000', '2.951', NULL, '67.880', '0.000', '1926.750', '261.375', '29625.000', '31813.125', '0.000', 0, 1, 1, NULL, 1, '2024-09-19 20:19:34', '2024-09-20 19:22:33'),
(3, 25, 2, 'aa', '300.000', '234.000', '0.000', '0.000', '66.000', '7.000', '4.813', 1, '61.187', '0.000', '17550.000', '0.000', '0.000', '17550.000', '0.000', 0, 0, 1, NULL, NULL, '2024-09-20 16:53:17', '2024-09-20 16:53:17'),
(4, 1, 2, 'Reaction on Trade of Jannah', '100.256', '0.000', '3.485', '0.000', '70.831', '4.000', '2.951', NULL, '67.880', '0.000', '1926.750', '261.375', '29625.000', '31813.125', '0.000', 0, 1, 1, NULL, 1, NULL, '2024-09-20 19:22:33'),
(5, 1, 2, 'Reaction on Trade of Jannah', '100.256', '0.000', '3.485', '0.000', '70.831', '4.000', '2.951', NULL, '67.880', '0.000', '1926.750', '261.375', '29625.000', '31813.125', '0.000', 0, 1, 1, NULL, 1, '2024-09-20 19:17:27', '2024-09-20 19:22:33'),
(6, 1, 2, 'Reaction on Trade of Jannah', '100.256', '0.000', '3.485', '0.000', '70.831', '4.000', '2.951', NULL, '67.880', '0.000', '1926.750', '261.375', '29625.000', '31813.125', '0.000', 0, 1, 1, NULL, 1, '2024-09-20 19:21:29', '2024-09-20 19:22:33'),
(7, 1, 2, 'Reaction on Trade of Jannah', '100.256', '0.000', '3.485', '0.000', '70.831', '4.000', '2.951', NULL, '67.880', '0.000', '1926.750', '261.375', '29625.000', '31813.125', '0.000', 0, 0, 1, NULL, NULL, '2024-09-20 19:22:33', NULL),
(9, 79, 2, 'Reaction on Trade of Jannah', '100.000', '25.690', '3.485', '1.250', '69.575', '4.000', '2.899', NULL, '66.676', '0.000', '1926.750', '261.375', '148125.000', '150313.125', '225.806', 0, 0, 1, 1, NULL, '2024-09-23 19:10:06', '2024-11-19 20:25:25'),
(10, 93, 2, 'aa', '100.000', '23.000', '0.000', '0.000', '77.000', '6.000', '4.813', NULL, '72.187', '0.000', '1725.000', '0.000', '0.000', '1725.000', '0.000', 0, 0, 1, 1, NULL, '2024-09-28 04:57:28', '2024-11-19 20:25:30'),
(11, 105, 3, 'Jarao neclace set with bindi and ring', '120.987', '25.034', '5.050', '3.400', '87.503', '6.500', '5.925', NULL, '81.578', '4500.000', '4324.500', '10390.500', '568740.000', '587955.000', '2048.775', 0, 1, 1, 1, 1, '2024-10-17 15:47:22', '2024-11-19 20:25:34'),
(12, 105, 3, 'Jarao neclace set with bindi and ring', '120.987', '25.034', '5.050', '3.400', '87.503', '6.500', '5.925', NULL, '81.578', '4500.000', '4324.500', '10390.500', '568740.000', '587955.000', '2048.775', 0, 0, 1, NULL, NULL, '2024-10-17 16:01:30', NULL),
(13, 106, 3, '22', '150.000', '2.000', '0.000', '0.000', '148.000', '4.000', '6.167', NULL, '141.833', '5000.000', '1550.000', '0.000', '0.000', '6550.000', '0.000', 0, 0, 1, NULL, NULL, '2024-10-22 18:19:23', NULL),
(14, 107, 3, 'Neclace set for stock', '35.480', '0.000', '0.000', '0.000', '35.480', '6.000', '2.217', NULL, '33.263', '3000.000', '0.000', '0.000', '0.000', '3000.000', '0.000', 0, 0, 1, 1, NULL, '2024-10-28 00:37:18', '2024-11-19 20:25:37'),
(15, 111, 4, '18 Diamond Ladies Rings for Stock', '120.780', '0.000', '0.000', '24.500', '96.280', '5.000', '5.015', NULL, '91.265', '15000.000', '0.000', '0.000', '5388600.000', '5403600.000', '19453.430', 0, 0, 1, NULL, NULL, '2024-11-07 16:36:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaat_diamonds`
--

CREATE TABLE `ratti_kaat_diamonds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ratti_kaat_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `diamonds` decimal(8,3) NOT NULL DEFAULT 0.000,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clarity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carat` decimal(8,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_dollar` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratti_kaat_diamonds`
--

INSERT INTO `ratti_kaat_diamonds` (`id`, `ratti_kaat_id`, `product_id`, `diamonds`, `type`, `color`, `cut`, `clarity`, `carat`, `carat_rate`, `total_amount`, `total_dollar`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '1.000', 'Natural', 'G', 'Round', 'VVS-1', '0.250', '118500.000', '29625.000', '105.806', 1, 1, NULL, 1, '2024-09-19 18:46:39', '2024-09-19 20:16:10'),
(2, 1, 2, '1.000', 'Natural', 'H', 'Round', 'VVS-1', '0.250', '118500.000', '29625.000', '105.806', 0, 1, NULL, NULL, '2024-09-19 20:19:12', '2024-09-19 20:19:12'),
(3, 73, 2, '1.000', 'Natural', 'G', 'Round', 'VVS-1', '0.250', '118500.000', '29625.000', '105.806', 0, 1, NULL, NULL, '2024-09-23 18:19:09', '2024-09-23 18:19:09'),
(4, 79, 2, '1.000', 'Natural', 'G', 'Round', 'VVS-1', '0.250', '118500.000', '29625.000', '105.806', 0, 1, NULL, NULL, '2024-09-23 18:36:26', '2024-09-23 18:36:26'),
(5, 79, 2, '1.000', 'Natural', 'H', 'Princess', 'VVS-2', '1.000', '118500.000', '118500.000', '120.000', 0, 1, NULL, NULL, '2024-09-23 18:39:26', '2024-09-23 18:39:26'),
(6, 102, 3, '1111.000', 'Natural', 'G', 'Round', 'VS-1', '0.580', '118000.000', '68440.000', '246.409', 0, 1, NULL, NULL, '2024-10-07 15:59:59', '2024-10-07 15:59:59'),
(7, 105, 3, '1.000', 'Natural', 'H', 'Round', 'VS-1', '1.000', '118500.000', '118500.000', '426.873', 0, 1, NULL, NULL, '2024-10-17 15:45:25', '2024-10-17 15:45:25'),
(8, 105, 3, '12.000', 'Natural', 'I', 'Emerald', 'VVS-2', '2.400', '187600.000', '450240.000', '1621.902', 0, 1, NULL, NULL, '2024-10-17 15:46:20', '2024-10-17 15:46:20'),
(9, 111, 4, '111.000', 'Pointer 7 to 12 Cents', 'G', 'Round', 'VVS1', '18.900', '250000.000', '4725000.000', '17057.762', 0, 1, NULL, NULL, '2024-11-07 16:34:52', '2024-11-07 16:34:52'),
(10, 111, 4, '1111.000', 'Setting Size 0 to 4 Cents', 'F', 'Round', 'VVS1', '5.600', '118500.000', '663600.000', '2395.668', 0, 1, NULL, NULL, '2024-11-07 16:35:14', '2024-11-07 16:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaat_stones`
--

CREATE TABLE `ratti_kaat_stones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ratti_kaat_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `stones` decimal(8,3) NOT NULL DEFAULT 0.000,
  `gram` decimal(8,3) NOT NULL DEFAULT 0.000,
  `carat` decimal(8,3) NOT NULL DEFAULT 0.000,
  `gram_rate` decimal(8,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(8,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(8,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratti_kaat_stones`
--

INSERT INTO `ratti_kaat_stones` (`id`, `category`, `type`, `ratti_kaat_id`, `product_id`, `stones`, `gram`, `carat`, `gram_rate`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 1, 2, '1.000', '3.485', '17.425', '75.000', '15.000', '261.375', 1, 1, NULL, 1, '2024-09-19 18:46:15', '2024-09-19 20:08:14'),
(2, NULL, NULL, 1, 2, '1.000', '3.485', '17.425', '75.000', '15.000', '261.375', 1, 1, NULL, 1, '2024-09-19 20:08:42', '2024-09-19 20:16:02'),
(3, NULL, NULL, 1, 2, '1.000', '3.485', '17.425', '75.000', '15.000', '261.375', 0, 1, NULL, NULL, '2024-09-19 20:18:54', '2024-09-19 20:18:54'),
(4, 'Sedimentary', 'stone', 79, 2, '1.000', '3.485', '17.425', '75.000', '15.000', '261.375', 0, 1, NULL, NULL, '2024-09-23 18:35:58', '2024-09-23 18:35:58'),
(5, 'Sedimentary', '1', 88, 2, '2.000', '0.850', '4.250', '22500.000', '4500.000', '19125.000', 0, 1, NULL, NULL, '2024-09-27 17:46:08', '2024-09-27 17:46:08'),
(6, 'Metamorphic', '1', 102, 3, '200.000', '3.000', '15.000', '375.000', '75.000', '1125.000', 0, 1, NULL, NULL, '2024-10-07 15:59:12', '2024-10-07 15:59:12'),
(7, 'Metamorphic', 'Ruby', 105, 3, '357.000', '1.340', '6.700', '2250.000', '450.000', '3015.000', 0, 1, NULL, NULL, '2024-10-17 15:43:06', '2024-10-17 15:43:06'),
(8, 'Igneous', 'Sapphire', 105, 3, '140.000', '2.080', '10.400', '3350.000', '670.000', '6968.000', 0, 1, NULL, NULL, '2024-10-17 15:43:34', '2024-10-17 15:43:34'),
(9, 'Man-made', 'Cubic', 105, 3, '567.000', '1.630', '8.150', '250.000', '50.000', '407.500', 0, 1, NULL, NULL, '2024-10-17 15:44:03', '2024-10-17 15:44:03');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-09-03 17:04:50', '2024-09-03 17:04:50'),
(2, 'Accountant', 'web', '2024-11-14 20:30:40', '2024-11-14 20:30:40'),
(3, 'Supplier/Karigar User', 'web', '2024-11-26 17:03:43', '2024-11-26 17:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(20, 2),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(34, 2),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(56, 2),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(63, 1),
(64, 1),
(65, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_cnic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_qty` decimal(18,3) DEFAULT NULL,
  `tax` decimal(18,3) DEFAULT NULL,
  `tax_amount` decimal(18,3) DEFAULT NULL,
  `sub_total` decimal(18,3) DEFAULT NULL,
  `total` decimal(18,3) DEFAULT NULL,
  `is_credit` tinyint(1) NOT NULL DEFAULT 0,
  `cash_amount` decimal(18,3) DEFAULT NULL,
  `bank_transfer_amount` decimal(18,3) DEFAULT NULL,
  `card_amount` decimal(18,3) DEFAULT NULL,
  `advance_amount` decimal(18,3) DEFAULT NULL,
  `gold_impure_amount` decimal(18,3) DEFAULT NULL,
  `total_received` decimal(18,3) DEFAULT NULL,
  `jv_id` int(11) DEFAULT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `sale_no`, `sale_date`, `customer_id`, `customer_name`, `customer_cnic`, `customer_contact`, `customer_email`, `customer_address`, `total_qty`, `tax`, `tax_amount`, `sub_total`, `total`, `is_credit`, `cash_amount`, `bank_transfer_amount`, `card_amount`, `advance_amount`, `gold_impure_amount`, `total_received`, `jv_id`, `posted`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'SL-16102024-0001', '2024-10-16', 2, 'Merrill Benson', 'Dolorem cupiditate non necessitatibus est eum accusamus consequat Quas exercitation sit eu earum deleniti aliquam et velit dolor', '123456789023467', NULL, 'Minim delectus nostrud magna irure in accusamus cillum aliquip perferendis deleniti neque officiis adipisicing laborum Molestiae enim quis qui incidunt', '1.000', NULL, NULL, NULL, '73966.396', 0, '73966.396', '0.000', '0.000', '0.000', '0.000', '73966.396', 26, 1, 0, 1, 1, NULL, '2024-10-17 04:20:10', '2024-10-17 04:21:33'),
(2, 'SL-16102024-0002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-17 04:20:11', '2024-10-17 04:20:11'),
(3, 'SL-17102024-0003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-17 15:11:39', '2024-10-17 15:11:39'),
(4, 'SL-17102024-0004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-17 15:11:40', '2024-10-17 15:11:40'),
(5, 'SL-17102024-0005', '2024-10-17', 3, 'Shahid', '000000', '03214000000', NULL, 'ns', '1.000', NULL, NULL, NULL, '685855.327', 0, '685855.327', '0.000', '0.000', '0.000', '0.000', '685855.327', 34, 1, 0, 1, 1, NULL, '2024-10-17 19:24:50', '2024-10-17 19:28:27'),
(6, 'SL-18102024-0006', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-18 23:07:26', '2024-10-18 23:07:26'),
(7, 'SL-26102024-0007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-26 22:05:22', '2024-10-26 22:05:22'),
(8, 'SL-26102024-0008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-26 22:08:08', '2024-10-26 22:08:08'),
(9, 'SL-27102024-0009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-28 00:41:24', '2024-10-28 00:41:24'),
(10, 'SL-27102024-0010', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-28 01:25:29', '2024-10-28 01:25:29'),
(11, 'SL-27102024-0011', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-28 01:25:31', '2024-10-28 01:25:31'),
(12, 'SL-30102024-0012', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-10-30 17:41:02', '2024-10-30 17:41:02'),
(13, 'SL-26112024-0013', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, '2024-11-26 02:03:14', '2024-11-26 02:03:14');

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `ratti_kaat_id` int(11) DEFAULT NULL,
  `ratti_kaat_detail_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `gold_carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `scale_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `bead_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `stones_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `diamond_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `net_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `waste` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gross_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `making` decimal(18,3) NOT NULL DEFAULT 0.000,
  `bead_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `stones_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `diamond_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_bead_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_stones_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_diamond_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `other_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gold_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_gold_price` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `finish_product_id`, `ratti_kaat_id`, `ratti_kaat_detail_id`, `product_id`, `gold_carat`, `scale_weight`, `bead_weight`, `stones_weight`, `diamond_weight`, `net_weight`, `waste`, `gross_weight`, `making`, `bead_price`, `stones_price`, `diamond_price`, `total_bead_price`, `total_stones_price`, `total_diamond_price`, `other_amount`, `gold_rate`, `total_gold_price`, `total_amount`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 93, 10, 2, '21.000', '100.000', '48.690', '0.000', '0.000', '51.310', '10.262', '61.572', '46179.000', '0.000', '0.000', '0.000', '3651.750', '0.000', '0.000', '0.000', '24074.074', '24135.646', '73966.396', 0, 1, NULL, '2024-10-17 04:20:53', '2024-10-17 04:20:53'),
(2, 5, 4, 105, 11, 3, '21.000', '120.987', '22.994', '3.420', '3.400', '91.173', '14.580', '105.753', '60174.400', '0.000', '0.000', '0.000', '7778.100', '9983.000', '568740.000', '15000.000', '24074.074', '24179.827', '685855.327', 0, 1, NULL, '2024-10-17 19:26:30', '2024-10-17 19:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `sale_detail_beads`
--

CREATE TABLE `sale_detail_beads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_detail_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `beads` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_detail_beads`
--

INSERT INTO `sale_detail_beads` (`id`, `type`, `sale_detail_id`, `product_id`, `beads`, `gram`, `carat`, `gram_rate`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Glass Bead', 1, NULL, '1.000', '23.000', '115.000', '75.000', '15.000', '1725.000', 0, NULL, NULL, '2024-10-17 04:20:53', '2024-10-17 04:20:53'),
(2, 'Metal Bead', 1, NULL, '1.000', '25.690', '128.450', '75.000', '15.000', '1926.750', 0, NULL, NULL, '2024-10-17 04:20:53', '2024-10-17 04:20:53'),
(3, 'Glass Bead', 2, NULL, '1.000', '20.654', '103.270', '150.000', '30.000', '3098.100', 0, NULL, NULL, '2024-10-17 19:26:30', '2024-10-17 19:26:30'),
(4, 'Glass Bead', 2, NULL, '1.000', '2.340', '11.700', '2000.000', '400.000', '4680.000', 0, NULL, NULL, '2024-10-17 19:26:30', '2024-10-17 19:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `sale_detail_diamonds`
--

CREATE TABLE `sale_detail_diamonds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_detail_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `diamonds` decimal(18,3) NOT NULL DEFAULT 0.000,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clarity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_detail_diamonds`
--

INSERT INTO `sale_detail_diamonds` (`id`, `sale_detail_id`, `product_id`, `diamonds`, `type`, `color`, `cut`, `clarity`, `carat`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, '1.000', 'Natural', 'H', 'Round', 'VS-1', '1.000', '118500.000', '118500.000', 0, NULL, NULL, '2024-10-17 19:26:30', '2024-10-17 19:26:30'),
(2, 2, NULL, '12.000', 'Natural', 'I', 'Emerald', 'VVS-2', '2.400', '187600.000', '450240.000', 0, NULL, NULL, '2024-10-17 19:26:30', '2024-10-17 19:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `sale_detail_stones`
--

CREATE TABLE `sale_detail_stones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_detail_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `stones` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gram_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_detail_stones`
--

INSERT INTO `sale_detail_stones` (`id`, `category`, `type`, `sale_detail_id`, `product_id`, `stones`, `gram`, `carat`, `gram_rate`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Metamorphic', 'Ruby', 2, NULL, '357.000', '1.340', '6.700', '2250.000', '450.000', '3015.000', 0, NULL, NULL, '2024-10-17 19:26:30', '2024-10-17 19:26:30'),
(2, 'Igneous', 'Sapphire', 2, NULL, '140.000', '2.080', '10.400', '3350.000', '670.000', '6968.000', 0, NULL, NULL, '2024-10-17 19:26:30', '2024-10-17 19:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `sale_orders`
--

CREATE TABLE `sale_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_order_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_order_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `total_qty` decimal(18,3) DEFAULT NULL,
  `gold_rate` decimal(18,3) DEFAULT NULL,
  `gold_rate_type_id` int(11) DEFAULT NULL,
  `is_purchased` tinyint(1) NOT NULL DEFAULT 0,
  `is_saled` tinyint(1) NOT NULL DEFAULT 0,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_orders`
--

INSERT INTO `sale_orders` (`id`, `sale_order_no`, `sale_order_date`, `customer_id`, `warehouse_id`, `total_qty`, `gold_rate`, `gold_rate_type_id`, `is_purchased`, `is_saled`, `is_complete`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'SO-14112024-0001', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, NULL, NULL, '2024-11-14 23:38:29', '2024-11-14 23:38:29'),
(2, 'SO-20112024-0002', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, NULL, NULL, '2024-11-20 18:04:03', '2024-11-20 18:04:03'),
(3, 'SO-20112024-0003', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, NULL, NULL, '2024-11-20 18:05:52', '2024-11-20 18:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `sale_order_details`
--

CREATE TABLE `sale_order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `design_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `waste` decimal(18,3) NOT NULL DEFAULT 0.000,
  `gross_weight` decimal(18,3) NOT NULL DEFAULT 0.000,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_takings`
--

CREATE TABLE `stock_takings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_taking_details`
--

CREATE TABLE `stock_taking_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_taking_id` int(11) DEFAULT NULL,
  `other_product_id` int(11) DEFAULT NULL,
  `quantity_in_stock` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actual_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stone_categories`
--

CREATE TABLE `stone_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stone_categories`
--

INSERT INTO `stone_categories` (`id`, `name`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Ruby', 1, 0, 1, 1, NULL, '2024-10-26 19:04:53', '2024-10-30 17:40:35'),
(2, 'jjj', 1, 0, 1, NULL, NULL, '2024-10-30 17:40:30', '2024-10-30 17:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '0 for supplier, 1 for karigar and 2 for both',
  `account_id` int(11) DEFAULT NULL,
  `account_au_id` int(11) DEFAULT NULL,
  `account_dollar_id` int(11) DEFAULT NULL,
  `gold_waste` decimal(18,2) NOT NULL DEFAULT 0.00 COMMENT 'waste/tola',
  `stone_waste` decimal(18,2) NOT NULL DEFAULT 0.00 COMMENT 'Stone Studding Waste',
  `kaat` decimal(18,2) NOT NULL DEFAULT 0.00 COMMENT 'kaat/tola',
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact`, `cnic`, `company`, `type`, `account_id`, `account_au_id`, `account_dollar_id`, `gold_waste`, `stone_waste`, `kaat`, `bank_name`, `account_title`, `account_no`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Jamalia Russo', 'Soluta amet', 'Itaque incidu', 'Gallegos Workman Plc', 1, NULL, NULL, NULL, '0.00', '0.00', '0.00', NULL, NULL, NULL, 1, 1, 1, 1, 1, '2024-09-05 18:40:36', '2024-09-05 18:54:54'),
(2, 'Sopoline Palmer', 'Corporis to', 'Animi molest', 'Baker Baldwin Co', 0, 10, 11, 12, '6.50', '0.25', '4.00', NULL, NULL, NULL, 1, 1, 1, 1, 1, '2024-09-05 19:08:39', '2024-11-19 20:19:47'),
(3, 'aa', '12344', '123', NULL, 0, 6, NULL, NULL, '12.00', '2.00', '1.00', NULL, NULL, NULL, 1, 1, 1, 1, 1, '2024-09-11 16:54:31', '2024-11-19 20:19:25'),
(4, 'Abdul Majeed', '03228006800', NULL, NULL, 2, 10, 11, 12, '6.00', '0.35', '6.00', NULL, NULL, NULL, 1, 1, 1, 1, 1, '2024-09-27 17:43:43', '2024-11-19 20:19:29'),
(5, 'Usman Khan', '03210000000', '3520200000', 'Usman Imran', 2, 10, 11, 12, '6.50', '0.30', '6.50', 'UBL', 'Usman Azam', '00000000000000000', 1, 1, 1, NULL, 1, '2024-10-17 15:39:24', '2024-11-19 20:19:42'),
(6, 'Abid Karigar', '03214000000', NULL, NULL, 1, 10, 11, 12, '4.00', '0.25', '6.00', 'MZN Bank', 'Shahzad', '02700000000000', 1, 1, 1, NULL, 1, '2024-10-28 00:35:59', '2024-11-19 20:19:34'),
(7, 'Sohail Gold Smith', '03210000001', NULL, 'Sohail Goldsmith', 2, 10, 11, 12, '6.50', '0.30', '5.00', 'MZN Bank', 'Sohail SB', '0200010005500', 1, 1, 1, NULL, 1, '2024-11-07 16:28:28', '2024-11-19 20:19:38'),
(8, 'Abdul Majeed', '03228006800', NULL, 'Abdul Majeed RangMahal', 2, 10, 11, 12, '6.00', '0.35', '6.00', 'N/A', 'N/A', 'N/A', 1, 0, 1, NULL, NULL, '2024-11-19 20:20:56', '2024-11-19 20:20:56'),
(9, 'Usman Khan', '03215645579', NULL, 'Usman and Imran Company', 2, 10, 11, 12, '6.50', '0.35', '6.00', 'UBL', 'Umar Azam', '1921', 1, 0, 1, NULL, NULL, '2024-11-19 20:24:02', '2024-11-19 20:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `payment_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_purchase_id` int(11) DEFAULT NULL,
  `cheque_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` int(11) NOT NULL DEFAULT 0 COMMENT '0 for PKR, 1 for AU and 2 for Dollar',
  `tax` decimal(18,3) DEFAULT NULL,
  `tax_amount` decimal(18,3) DEFAULT NULL,
  `tax_account_id` int(11) DEFAULT NULL,
  `sub_total` decimal(18,3) DEFAULT NULL,
  `total` decimal(18,3) DEFAULT NULL,
  `jv_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_payments`
--

INSERT INTO `supplier_payments` (`id`, `supplier_id`, `account_id`, `payment_date`, `other_purchase_id`, `cheque_ref`, `currency`, `tax`, `tax_amount`, `tax_account_id`, `sub_total`, `total`, `jv_id`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(4, 2, 5, '2024-09-26', NULL, NULL, 0, '0.000', '0.000', NULL, '1000.000', '1000.000', 24, 1, NULL, NULL, 1, '2024-09-25 17:25:50', '2024-09-25 18:28:20'),
(5, 8, 11, '2024-11-20', NULL, NULL, 1, '0.000', '0.000', 11, '70.000', '70.000', 38, 1, 1, NULL, 1, '2024-11-20 18:21:56', '2024-11-20 18:23:58'),
(6, 8, 11, '2024-11-22', NULL, NULL, 1, '0.000', '0.000', NULL, '23.570', '23.570', 40, 0, NULL, NULL, NULL, '2024-11-22 09:54:48', '2024-11-22 09:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0 for purchase, 1 for other sale',
  `date` date DEFAULT NULL,
  `other_product_id` int(11) DEFAULT NULL,
  `qty` decimal(18,3) DEFAULT NULL,
  `unit_price` decimal(18,3) DEFAULT NULL,
  `other_purchase_id` int(11) DEFAULT NULL,
  `other_sale_id` int(11) DEFAULT NULL,
  `stock_taking_id` int(11) DEFAULT NULL,
  `stock_taking_link_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` tinyint(4) NOT NULL DEFAULT 0,
  `supplier_id` int(12) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `supplier_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@admin.com', NULL, '$2y$10$my0ITJsPEi//k75reS1dve8V8LlWQtP0hn/r2bsMbZYDCWwlYsU/i', 0, NULL, 'by9DFIJpPyj9duyFRZx2pD04ypDSABh5taJEprMibZ7OYgnxArVAekHb1X4B', NULL, '2024-09-03 18:50:18'),
(2, 'Accountant', 'hsuleman.acca@gmail.com', NULL, '$2y$10$XA/0bopiUKuAJn2oVDTyhOPuwfjH3.P/R0ZBLo2CZfB4ZsTdTZwoy', 0, NULL, NULL, '2024-11-14 20:31:14', '2024-11-14 20:31:14'),
(3, 'Majeed User', 'majeed@gmail.com', NULL, '$2y$10$5iJ2HDrv4sZPGWXCWTg.d.ek4wi23JwWE69IMHn7OzxYbRwaOzxAi', 0, 8, NULL, '2024-11-26 17:54:32', '2024-11-26 17:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `email`, `phone`, `address`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Liberty Market', '', '', '', 0, 1, NULL, NULL, '2024-10-04 17:26:21', '2024-10-04 17:26:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bead_types`
--
ALTER TABLE `bead_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diamond_clarities`
--
ALTER TABLE `diamond_clarities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diamond_colors`
--
ALTER TABLE `diamond_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diamond_cuts`
--
ALTER TABLE `diamond_cuts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diamond_types`
--
ALTER TABLE `diamond_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dollar_rates`
--
ALTER TABLE `dollar_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `finish_products`
--
ALTER TABLE `finish_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finish_product_beads`
--
ALTER TABLE `finish_product_beads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finish_product_diamonds`
--
ALTER TABLE `finish_product_diamonds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finish_product_stones`
--
ALTER TABLE `finish_product_stones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gold_rates`
--
ALTER TABLE `gold_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gold_rate_types`
--
ALTER TABLE `gold_rate_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_purchases`
--
ALTER TABLE `job_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_purchase_details`
--
ALTER TABLE `job_purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_purchase_detail_beads`
--
ALTER TABLE `job_purchase_detail_beads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_purchase_detail_diamonds`
--
ALTER TABLE `job_purchase_detail_diamonds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_purchase_detail_stones`
--
ALTER TABLE `job_purchase_detail_stones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_tasks`
--
ALTER TABLE `job_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_task_activities`
--
ALTER TABLE `job_task_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_task_details`
--
ALTER TABLE `job_task_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_entry_details`
--
ALTER TABLE `journal_entry_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `other_products`
--
ALTER TABLE `other_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_product_units`
--
ALTER TABLE `other_product_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_purchases`
--
ALTER TABLE `other_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_purchase_details`
--
ALTER TABLE `other_purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_sales`
--
ALTER TABLE `other_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_sale_details`
--
ALTER TABLE `other_sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratti_kaats`
--
ALTER TABLE `ratti_kaats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratti_kaat_beads`
--
ALTER TABLE `ratti_kaat_beads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratti_kaat_details`
--
ALTER TABLE `ratti_kaat_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratti_kaat_diamonds`
--
ALTER TABLE `ratti_kaat_diamonds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratti_kaat_stones`
--
ALTER TABLE `ratti_kaat_stones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_detail_beads`
--
ALTER TABLE `sale_detail_beads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_detail_diamonds`
--
ALTER TABLE `sale_detail_diamonds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_detail_stones`
--
ALTER TABLE `sale_detail_stones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_orders`
--
ALTER TABLE `sale_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_order_details`
--
ALTER TABLE `sale_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_takings`
--
ALTER TABLE `stock_takings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_taking_details`
--
ALTER TABLE `stock_taking_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stone_categories`
--
ALTER TABLE `stone_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bead_types`
--
ALTER TABLE `bead_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `diamond_clarities`
--
ALTER TABLE `diamond_clarities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `diamond_colors`
--
ALTER TABLE `diamond_colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `diamond_cuts`
--
ALTER TABLE `diamond_cuts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `diamond_types`
--
ALTER TABLE `diamond_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dollar_rates`
--
ALTER TABLE `dollar_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finish_products`
--
ALTER TABLE `finish_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `finish_product_beads`
--
ALTER TABLE `finish_product_beads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `finish_product_diamonds`
--
ALTER TABLE `finish_product_diamonds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `finish_product_stones`
--
ALTER TABLE `finish_product_stones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gold_rates`
--
ALTER TABLE `gold_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `gold_rate_types`
--
ALTER TABLE `gold_rate_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_purchases`
--
ALTER TABLE `job_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_purchase_details`
--
ALTER TABLE `job_purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_purchase_detail_beads`
--
ALTER TABLE `job_purchase_detail_beads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_purchase_detail_diamonds`
--
ALTER TABLE `job_purchase_detail_diamonds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_purchase_detail_stones`
--
ALTER TABLE `job_purchase_detail_stones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_tasks`
--
ALTER TABLE `job_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `job_task_activities`
--
ALTER TABLE `job_task_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_task_details`
--
ALTER TABLE `job_task_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `journal_entry_details`
--
ALTER TABLE `journal_entry_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `other_products`
--
ALTER TABLE `other_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `other_product_units`
--
ALTER TABLE `other_product_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `other_purchases`
--
ALTER TABLE `other_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `other_purchase_details`
--
ALTER TABLE `other_purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_sales`
--
ALTER TABLE `other_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `other_sale_details`
--
ALTER TABLE `other_sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ratti_kaats`
--
ALTER TABLE `ratti_kaats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `ratti_kaat_beads`
--
ALTER TABLE `ratti_kaat_beads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ratti_kaat_details`
--
ALTER TABLE `ratti_kaat_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ratti_kaat_diamonds`
--
ALTER TABLE `ratti_kaat_diamonds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ratti_kaat_stones`
--
ALTER TABLE `ratti_kaat_stones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sale_detail_beads`
--
ALTER TABLE `sale_detail_beads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sale_detail_diamonds`
--
ALTER TABLE `sale_detail_diamonds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sale_detail_stones`
--
ALTER TABLE `sale_detail_stones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sale_orders`
--
ALTER TABLE `sale_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_order_details`
--
ALTER TABLE `sale_order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_takings`
--
ALTER TABLE `stock_takings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_taking_details`
--
ALTER TABLE `stock_taking_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stone_categories`
--
ALTER TABLE `stone_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
