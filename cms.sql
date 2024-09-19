-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2024 at 10:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
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
(1, '123', 'account', 0, 1, 1, 0.00, 0.00, 0.00, 1, 1, 0, 1, 1, NULL, '2024-09-05 15:31:09', '2024-09-05 16:10:06'),
(2, '12345', 'Account child1', 0, 1, 1, 0.00, 0.00, 0.00, 1, 1, 1, 1, NULL, 1, '2024-09-05 16:10:54', '2024-09-05 16:16:46'),
(3, '1234', 'parent child1', 0, 0, 1, 0.00, 0.00, 0.00, 0, 1, 1, 1, NULL, 1, '2024-09-05 16:16:33', '2024-09-05 16:16:41'),
(4, '123456', 'child1', 1, 1, 1, 0.00, 0.00, 0.00, 0, 2, 1, 1, NULL, 1, '2024-09-05 16:40:16', '2024-09-05 16:50:33'),
(5, '1234', 'child', 1, 1, 0, 0.00, 0.00, 0.00, 0, 2, 0, 1, NULL, NULL, '2024-09-05 16:55:24', '2024-09-05 19:18:26'),
(6, '12345', 'child2', 1, 1, 1, 0.00, 0.00, 0.00, 0, 2, 0, 1, NULL, NULL, '2024-09-05 16:56:24', '2024-09-05 16:56:24'),
(7, '12', 'Parent', 0, 2, 1, 0.00, 0.00, 0.00, 0, 1, 0, 1, NULL, NULL, '2024-09-05 16:57:14', '2024-09-05 19:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
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
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cnic` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `anniversary_date` date DEFAULT NULL,
  `ring_size` varchar(255) DEFAULT NULL,
  `bangle_size` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `comment` varchar(191) DEFAULT NULL,
  `bank_name` varchar(191) DEFAULT NULL,
  `account_title` varchar(191) DEFAULT NULL,
  `account_no` varchar(191) DEFAULT NULL,
  `cnic_images` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `account_id` int(12) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(12) DEFAULT NULL,
  `updatedby_id` int(12) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deletedby_id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `contact`, `email`, `cnic`, `address`, `date_of_birth`, `anniversary_date`, `ring_size`, `bangle_size`, `reference`, `comment`, `bank_name`, `account_title`, `account_no`, `cnic_images`, `is_active`, `account_id`, `is_deleted`, `createdby_id`, `updatedby_id`, `created_at`, `updated_at`, `deletedby_id`) VALUES
(1, 'Idola Russell', 'Provident', 'lexozozadu@mailinator.com', 'Quod praesent', 'Quia molestias neque architecto non ut non incidunt eum minim eius maxime cumque lorem sunt aut ut', '1985-08-14', '1977-01-03', 'Aute offic', 'Nostrum do', NULL, NULL, NULL, NULL, NULL, NULL, 1, 6, 1, 1, 1, '2024-09-09 18:40:22', '2024-09-09 18:41:08', 1),
(2, 'Merrill Benson', '123456789023467', NULL, 'Dolorem cupiditate non necessitatibus est eum accusamus consequat Quas exercitation sit eu earum deleniti aliquam et velit dolor', 'Minim delectus nostrud magna irure in accusamus cillum aliquip perferendis deleniti neque officiis adipisicing laborum Molestiae enim quis qui incidunt', '1975-09-04', '2022-02-11', '13', '2.1', 'Voluptatem deleniti a ut harum quis est sed sed officiis accusantium blanditiis asperiores sint placeat sunt quae ut minim', 'Ipsa beatae recusandae Eveniet et necessitatibus', NULL, NULL, NULL, '[\"cnic_images\\/1726089432-66e208d8822a3.jpg\",\"cnic_images\\/1726089432-66e208d882a3f.jpg\",\"cnic_images\\/1726089432-66e208d882eb5.jpg\",\"cnic_images\\/1726089432-66e208d8833d0.jpg\"]', 1, NULL, 0, 1, 1, '2024-09-11 16:13:46', '2024-09-11 16:40:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cnic` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_name` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `emergency_relation` varchar(255) DEFAULT NULL,
  `job_role` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `employee_type` varchar(255) DEFAULT NULL COMMENT 'Full-time, Part-time, Contract',
  `date_of_joining` date DEFAULT NULL,
  `shift` varchar(255) DEFAULT NULL COMMENT 'shift time in string',
  `salary` decimal(8,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_title` varchar(255) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `is_overtime` tinyint(1) NOT NULL DEFAULT 0,
  `sick_leave` decimal(8,2) NOT NULL DEFAULT 0.00,
  `casual_leave` decimal(8,2) NOT NULL DEFAULT 0.00,
  `annual_leave` decimal(8,2) NOT NULL DEFAULT 0.00,
  `picture` varchar(255) DEFAULT NULL,
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
(1, 'Quidem atque dolores esse aliquip quaerat optio voluptas dolorem deleniti aperiam ab cumque tenetur', 'Fallon Armstrong', 'Sed dolor consectetur sequi adipisci Nam nostrum delectus id debitis ut', 'Male', '1974-06-21', 'Sit mollit tempora vel id recusandae Velit quos pariatur Inventore duis sequi blanditiis duis ut', 'kozijowyja@mailinator.com', 'Vel ullam sit quisquam et maiores qui cillum totam ea inventore ea minim alias', 'Erasmus Acosta', 'Esse magna iusto perspiciatis et exercitationem et voluptatem sed omnis est occaecat', 'Non magna similique suscipit quaerat et sit facere aspernatur suscipit deserunt dolor dolores ut sed impedit', 'Dolorem dolorem nihil ex numquam', 'Production', 'Contract', '1980-02-04', '02PM-10PM', 120000.00, 'Bank Transfer', 'Dawn Harding', 'Ullamco est beatae non corporis autem amet aut quos ex lorem id exercitationem qui aliquip eaque omnis amet illum culpa', 'Assumenda iste e', 0, 8.00, 8.00, 14.00, 'picture/1726100954-66e235daf41d6.jpg', 6, 1, 1, 1, 1, 1, '2024-09-11 19:25:46', '2024-09-11 19:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
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
(1, 'Journal Voucher', 'JV', 1, 1, 1, 1, 1, '2024-09-06 04:18:29', '2024-09-06 04:46:20'),
(2, 'Journal Voucher', 'JV', 1, 0, 1, 1, NULL, '2024-09-06 04:46:33', '2024-09-06 04:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entryNum` varchar(255) DEFAULT NULL,
  `journal_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `date_post` date DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `amount_in_words` varchar(255) DEFAULT NULL,
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
(5, 'JV-2024-09-0001', 2, 2, NULL, '2024-09-06', 'sss', NULL, 1, NULL, 1, 1, '2024-09-06 15:47:08', '2024-09-06 15:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `journal_entry_details`
--

CREATE TABLE `journal_entry_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_entry_id` int(11) DEFAULT NULL,
  `explanation` longtext DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `check_no` varchar(255) DEFAULT NULL,
  `check_date` date DEFAULT NULL,
  `credit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `debit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `doc_date` varchar(255) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount_in_words` varchar(191) DEFAULT NULL,
  `account_code` varchar(191) DEFAULT NULL,
  `createdby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_entry_details`
--

INSERT INTO `journal_entry_details` (`id`, `journal_entry_id`, `explanation`, `bill_no`, `check_no`, `check_date`, `credit`, `debit`, `doc_date`, `account_id`, `amount`, `amount_in_words`, `account_code`, `createdby_id`, `created_at`, `updated_at`) VALUES
(1, 5, '', '', '', NULL, 0.00, 200.00, '2024-09-06', 6, 200.00, 'two hundred ', '12345', NULL, '2024-09-06 15:47:08', '2024-09-06 15:47:08'),
(2, 5, '', '', '', NULL, 200.00, 0.00, '2024-09-06', 6, 200.00, 'two hundred ', '12345', NULL, '2024-09-06 15:47:08', '2024-09-06 15:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
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
(24, '2024_09_18_222641_create_ratti_kaat_diamonds_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
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
(54, 'employees_delete', 'web', '2024-09-11 19:11:38', '2024-09-11 19:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
  `name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
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
(2, 'Baliya', 'BL', 1, 0, 1, NULL, NULL, '2024-09-16 11:27:42', '2024-09-16 11:27:42');

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaats`
--

CREATE TABLE `ratti_kaats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ratti_kaat_no` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `purchase_account` int(11) DEFAULT NULL,
  `paid_account` int(11) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `pictures` text DEFAULT NULL,
  `tax_amount` decimal(8,3) DEFAULT NULL,
  `tax_account` int(11) DEFAULT NULL,
  `sub_total` decimal(8,3) DEFAULT NULL,
  `total` decimal(8,3) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 for active, 0 for inactive',
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

INSERT INTO `ratti_kaats` (`id`, `ratti_kaat_no`, `purchase_date`, `supplier_id`, `purchase_account`, `paid_account`, `reference`, `pictures`, `tax_amount`, `tax_account`, `sub_total`, `total`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'RK-18092024-0001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:30:14', '2024-09-18 18:30:14'),
(2, 'RK-18092024-0002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:30:18', '2024-09-18 18:30:18'),
(3, 'RK-18092024-0003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:34:04', '2024-09-18 18:34:04'),
(4, 'RK-18092024-0004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:34:14', '2024-09-18 18:34:14'),
(5, 'RK-18092024-0005', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:38:08', '2024-09-18 18:38:08'),
(6, 'RK-18092024-0006', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:38:15', '2024-09-18 18:38:15'),
(7, 'RK-18092024-0007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:38:41', '2024-09-18 18:38:41'),
(8, 'RK-18092024-0008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:38:47', '2024-09-18 18:38:47'),
(9, 'RK-18092024-0009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:40:11', '2024-09-18 18:40:11'),
(10, 'RK-18092024-0010', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:40:19', '2024-09-18 18:40:19'),
(11, 'RK-18092024-0011', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:42:26', '2024-09-18 18:42:26'),
(12, 'RK-18092024-0012', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:42:33', '2024-09-18 18:42:33'),
(13, 'RK-18092024-0013', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:43:15', '2024-09-18 18:43:15'),
(14, 'RK-18092024-0014', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:43:22', '2024-09-18 18:43:22'),
(15, 'RK-18092024-0015', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:46:01', '2024-09-18 18:46:01'),
(16, 'RK-18092024-0016', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:46:07', '2024-09-18 18:46:07'),
(17, 'RK-18092024-0017', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:46:52', '2024-09-18 18:46:52'),
(18, 'RK-18092024-0018', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 18:47:02', '2024-09-18 18:47:02'),
(19, 'RK-19092024-0019', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:03:53', '2024-09-18 19:03:53'),
(20, 'RK-19092024-0020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:04:00', '2024-09-18 19:04:00'),
(21, 'RK-19092024-0021', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:09:51', '2024-09-18 19:09:51'),
(22, 'RK-19092024-0022', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:09:57', '2024-09-18 19:09:57'),
(23, 'RK-19092024-0023', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:12:50', '2024-09-18 19:12:50'),
(24, 'RK-19092024-0024', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:12:57', '2024-09-18 19:12:57'),
(25, 'RK-19092024-0025', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:20:46', '2024-09-18 19:20:46'),
(26, 'RK-19092024-0026', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:20:49', '2024-09-18 19:20:49'),
(27, 'RK-19092024-0027', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:21:14', '2024-09-18 19:21:14'),
(28, 'RK-19092024-0028', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:21:19', '2024-09-18 19:21:19'),
(29, 'RK-19092024-0029', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:24:02', '2024-09-18 19:24:02'),
(30, 'RK-19092024-0030', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:24:06', '2024-09-18 19:24:06'),
(31, 'RK-19092024-0031', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:24:46', '2024-09-18 19:24:46'),
(32, 'RK-19092024-0032', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:24:51', '2024-09-18 19:24:51'),
(33, 'RK-19092024-0033', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:35:37', '2024-09-18 19:35:37'),
(34, 'RK-19092024-0034', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '2024-09-18 19:35:39', '2024-09-18 19:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaat_beads`
--

CREATE TABLE `ratti_kaat_beads` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `ratti_kaat_beads` (`id`, `ratti_kaat_id`, `product_id`, `beads`, `gram`, `carat`, `gram_rate`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 21, 2, 1.000, 34.200, 171.000, 75.000, 15.000, 2565.000, 0, 1, NULL, NULL, '2024-09-18 19:10:14', '2024-09-18 19:10:14'),
(2, 31, 2, 1.000, 25.690, 128.450, 75.000, 15.000, 1926.750, 0, 1, NULL, NULL, '2024-09-18 19:26:54', '2024-09-18 19:26:54'),
(3, 33, 2, 1.000, 25.690, 128.450, 75.000, 15.000, 1926.750, 0, 1, NULL, NULL, '2024-09-18 19:36:19', '2024-09-18 19:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaat_details`
--

CREATE TABLE `ratti_kaat_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ratti_kaat_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `scale_weight` decimal(8,3) NOT NULL DEFAULT 0.000,
  `bead_weight` decimal(8,3) NOT NULL DEFAULT 0.000,
  `stones_weight` decimal(8,3) NOT NULL DEFAULT 0.000,
  `diamond_carat` decimal(8,3) NOT NULL DEFAULT 0.000,
  `net_weight` decimal(8,3) NOT NULL DEFAULT 0.000,
  `supplier_kaat` decimal(8,3) NOT NULL DEFAULT 0.000,
  `kaat` decimal(8,3) NOT NULL DEFAULT 0.000,
  `approved_by` int(11) DEFAULT NULL,
  `pure_payable` decimal(8,3) NOT NULL DEFAULT 0.000,
  `other_charge` decimal(8,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(8,3) NOT NULL DEFAULT 0.000,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaat_diamonds`
--

CREATE TABLE `ratti_kaat_diamonds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ratti_kaat_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `diamonds` decimal(8,3) NOT NULL DEFAULT 0.000,
  `type` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `cut` varchar(255) DEFAULT NULL,
  `clarity` varchar(255) DEFAULT NULL,
  `carat` decimal(8,3) NOT NULL DEFAULT 0.000,
  `carat_rate` decimal(18,3) NOT NULL DEFAULT 0.000,
  `total_amount` decimal(8,3) NOT NULL DEFAULT 0.000,
  `total_dollar` decimal(8,3) NOT NULL DEFAULT 0.000,
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
(1, 19, 2, 1.000, 'Natural', 'D', 'Round', 'F', 0.250, 118500.000, 29625.000, 105.806, 0, 1, NULL, NULL, '2024-09-18 19:07:25', '2024-09-18 19:07:25'),
(2, 23, 2, 1.000, 'Natural', 'D', 'Round', 'VVS-1', 0.250, 118500.000, 29625.000, 124.000, 0, 1, NULL, NULL, '2024-09-18 19:13:59', '2024-09-18 19:13:59'),
(3, 31, 2, 1.000, 'Natural', 'H', 'Round', 'VVS-1', 0.250, 118500.000, 29625.000, 105.806, 0, 1, NULL, NULL, '2024-09-18 19:28:19', '2024-09-18 19:28:19'),
(4, 33, 2, 1.000, 'Natural', 'H', 'Round', 'VVS-2', 0.250, 118500.000, 29625.000, 105.806, 0, 1, NULL, NULL, '2024-09-18 19:37:05', '2024-09-18 19:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `ratti_kaat_stones`
--

CREATE TABLE `ratti_kaat_stones` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `ratti_kaat_stones` (`id`, `ratti_kaat_id`, `product_id`, `stones`, `gram`, `carat`, `gram_rate`, `carat_rate`, `total_amount`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 23, 2, 1.000, 12.000, 60.000, 75.000, 15.000, 900.000, 0, 1, NULL, NULL, '2024-09-18 19:13:13', '2024-09-18 19:13:13'),
(2, 31, 2, 1.000, 3.485, 17.425, 75.000, 15.000, 261.375, 0, 1, NULL, NULL, '2024-09-18 19:27:31', '2024-09-18 19:27:31'),
(3, 33, 2, 1.000, 3.485, 17.425, 75.000, 15.000, 261.375, 0, 1, NULL, NULL, '2024-09-18 19:36:42', '2024-09-18 19:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-09-03 17:04:50', '2024-09-03 17:04:50');

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
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
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
(54, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `cnic` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '0 for supplier, 1 for karigar and 2 for both',
  `account_id` int(11) DEFAULT NULL,
  `gold_waste` decimal(18,2) NOT NULL DEFAULT 0.00 COMMENT 'waste/tola',
  `stone_waste` decimal(18,2) NOT NULL DEFAULT 0.00 COMMENT 'Stone Studding Waste',
  `kaat` decimal(18,2) NOT NULL DEFAULT 0.00 COMMENT 'kaat/tola',
  `bank_name` varchar(191) DEFAULT NULL,
  `account_title` varchar(191) DEFAULT NULL,
  `account_no` varchar(191) DEFAULT NULL,
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

INSERT INTO `suppliers` (`id`, `name`, `contact`, `cnic`, `company`, `type`, `account_id`, `gold_waste`, `stone_waste`, `kaat`, `bank_name`, `account_title`, `account_no`, `is_active`, `is_deleted`, `createdby_id`, `updatedby_id`, `deletedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Jamalia Russo', 'Soluta amet', 'Itaque incidu', 'Gallegos Workman Plc', 1, NULL, 0.00, 0.00, 0.00, NULL, NULL, NULL, 1, 1, 1, 1, 1, '2024-09-05 18:40:36', '2024-09-05 18:54:54'),
(2, 'Sopoline Palmer', 'Corporis to', 'Animi molest', 'Baker Baldwin Co', 0, 6, 6.50, 0.25, 4.00, NULL, NULL, NULL, 1, 0, 1, 1, NULL, '2024-09-05 19:08:39', '2024-09-09 18:02:55'),
(3, 'aa', '12344', '123', NULL, 0, 6, 12.00, 2.00, 1.00, NULL, NULL, NULL, 1, 0, 1, 1, NULL, '2024-09-11 16:54:31', '2024-09-11 16:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@admin.com', NULL, '$2y$10$my0ITJsPEi//k75reS1dve8V8LlWQtP0hn/r2bsMbZYDCWwlYsU/i', 0, '8eBfYLsXQ0pwoTRHBCN6d70cslzPZWzUp5nxteXkRb6ZZ3PSl8yMDJPgDgQR', NULL, '2024-09-03 18:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `createdby_id` int(11) DEFAULT NULL,
  `updatedby_id` int(11) DEFAULT NULL,
  `deletedby_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `customers`
--
ALTER TABLE `customers`
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
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `journal_entry_details`
--
ALTER TABLE `journal_entry_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ratti_kaats`
--
ALTER TABLE `ratti_kaats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `ratti_kaat_beads`
--
ALTER TABLE `ratti_kaat_beads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ratti_kaat_details`
--
ALTER TABLE `ratti_kaat_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratti_kaat_diamonds`
--
ALTER TABLE `ratti_kaat_diamonds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ratti_kaat_stones`
--
ALTER TABLE `ratti_kaat_stones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
