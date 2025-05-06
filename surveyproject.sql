-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 06:24 PM
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
-- Database: `surveyproject`
--

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
-- Table structure for table `graduates`
--

CREATE TABLE `graduates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `graduation_year` int(11) NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `employed` tinyint(1) NOT NULL DEFAULT 0,
  `current_employment` varchar(255) NOT NULL DEFAULT 'unemployed',
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `industry_sector` varchar(255) DEFAULT NULL,
  `is_cpe_related` tinyint(1) DEFAULT NULL,
  `has_awards` tinyint(1) DEFAULT NULL,
  `is_involved_organizations` tinyint(1) DEFAULT NULL,
  `lifelong_learner` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `graduates`
--

INSERT INTO `graduates` (`id`, `user_id`, `phone_number`, `gender`, `graduation_year`, `facebook`, `employed`, `current_employment`, `photo`, `created_at`, `updated_at`, `position`, `company_name`, `company_address`, `industry_sector`, `is_cpe_related`, `has_awards`, `is_involved_organizations`, `lifelong_learner`) VALUES
(1, 2, '2312312313', 'male', 2024, '1231231', 0, 'employed', 'graduate-photos/bUsCfC2L9pxHzMgR8UQO9nvbhKDqVxLmDF4FGgWK.png', '2025-03-07 05:28:58', '2025-03-07 05:28:58', '123123', '123123', '123123123', '1231231', 1, 1, 1, NULL),
(2, 3, '19230841', 'female', 2025, 'ascavv', 1, 'employed', 'graduate-photos/lsZ6Cm3M9Ak3Kt9dX9tViA2LCGf7VPPhAcXoLuzz.png', '2025-03-07 05:40:14', '2025-03-07 05:40:45', 'vss', 'svavg', 'savasgagag', 'addbvcnvn', 1, 1, 1, NULL),
(3, 4, '1029183913', 'male', 2025, 'oakcoc', 1, 'employed', NULL, '2025-03-07 05:42:27', '2025-03-07 05:42:27', 'bslkalca', 'aassasas', 'fsaffaff', 'saasasas', 0, 0, 0, NULL),
(4, 5, '121212', 'female', 2022, '121211', 0, 'employed', 'graduate-photos/K3VWpaGhey7MBbbdSiTybPtHyZi2wZgesaNqAjml.png', '2025-03-07 05:43:53', '2025-03-09 20:13:42', 'alskalkcoa', 'apcpakcakc', 'bsdvsv', 'avsv', 1, 1, 1, NULL),
(5, 6, '1029183913', 'male', 2022, 'askpac', 0, 'unemployed', 'graduate-photos/7BBk76q9R5rFqi52AvxM6eNwHdUjWiaIsu2e95sT.png', '2025-03-07 05:50:31', '2025-03-07 05:50:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 7, '19280138', 'female', 2023, 'vsdbbd', 1, 'employed', 'graduate-photos/asTBcrzbrQpANfnVskZPIVlb8lRQJRGcl9A2THK4.png', '2025-03-07 16:56:59', '2025-03-07 16:56:59', 'acvav', 'vddvd', 'egwggeg', 'afdasvv', 1, 0, 0, NULL),
(7, 8, '01291983781', 'male', 2024, 'vakscnkc', 1, 'employed', 'graduate-photos/BKPUGMXtEnD2FsQHfm3UY4BRgrt2O6qhKOsDK940.jpg', '2025-03-07 19:18:52', '2025-03-07 19:18:52', 'sasvv', 'dsbsbvb', 'aefdgg', 'dfdfs', 0, 0, 0, NULL),
(8, 9, '3252545', 'male', 2024, 'msejfnjsdvnk', 1, 'unemployed', 'graduate-photos/qKaE05UeDhx7ykSb4z8dko0hH31k58r7nQUX9RgR.png', '2025-03-08 19:45:13', '2025-03-08 19:45:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 12, '10299381', 'female', 2024, 'vsvdsdvda', 1, 'employed', 'graduate-photos/CHEnlLLrIgqu92kqF36BSESnpvUHla4PTqH8sT2u.png', '2025-03-09 04:07:47', '2025-03-09 04:07:47', 'avdava', 'zvzvzxv', 'sgdsvv', 'asfxzv', 1, 1, 1, NULL),
(10, 13, '0123183', 'male', 2023, 'vakjscoc', 1, 'unemployed', 'graduate-photos/zqtKVPC9cTfBr2u1onwDtF36UbDRXCvIPTHula64.png', '2025-03-09 05:05:11', '2025-03-09 05:05:11', 'dfbfdb', 'asvasv', 'bdfbfdb', 'zsczxv', 1, 1, 1, NULL),
(11, 14, '19230841', 'male', 2022, 'asdasc', 1, 'unemployed', 'graduate-photos/M5HWd322N1LfdrCX211MLctEiOAHmEhdz9kb7G3K.jpg', '2025-03-23 06:05:28', '2025-03-23 06:05:28', 'assv', 'vsav', 'asvasv', 'dfdfs', 1, 1, 0, NULL),
(18, 16, '09171466518', 'male', 2025, 'reiggs', 1, 'unemployed', NULL, '2025-04-03 08:15:44', '2025-04-03 08:15:44', 'awd', 'awd', 'awd', 'awf', 0, 0, 1, '1');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_10_000002_create_surveys_table', 1),
(6, '2024_01_15_000000_create_graduates_table', 1),
(7, '2024_01_15_000001_add_employed_to_graduates_table', 1),
(8, '2024_01_15_000001_create_graduates_table', 1),
(9, '2024_01_15_000002_add_fields_to_graduates_table', 1),
(10, '2024_01_15_000004_create_graduates_table', 1),
(11, '2024_01_20_add_additional_employment_details_to_graduates', 1),
(12, '2024_03_07_add_is_admin_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`questions`)),
  `valid_until` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, 'Admin', '', 'User', 'admin@gmail.com', NULL, '$2y$12$g3q0KeKkBqPCJ3xjFm.c2e4nWPhU52MU356wZWN.IId6q/pmbQVPq', NULL, '2025-03-07 05:27:34', '2025-03-07 05:27:34', 0),
(2, 'Test', 'test', 'Test', 'test@gmail.com', NULL, '$2y$12$7Uy2jz51iAJ.1uOO9vhs4e8gODWAMjRpMAhUNzxhy6DmpOIxOV6vO', NULL, '2025-03-07 05:28:15', '2025-03-07 05:28:15', 0),
(3, 'user1', 'adavdvdv', 'user1', 'user1@gmail.com', NULL, '$2y$12$z7ZLJC1Vak/BpGcpsYuVvejg0djpVXDzXCa9gmDwQOAbVjFkQSar.', NULL, '2025-03-07 05:37:17', '2025-03-07 05:37:17', 0),
(4, 'user2', 'lakdakc', 'user2', 'user2@gmail.com', NULL, '$2y$12$uAOEveIX11SvazgeFoUF4uHzZFPnhxC6xOu6pma/YXumUxsXKjvrO', NULL, '2025-03-07 05:41:45', '2025-03-07 05:41:45', 0),
(5, 'user3', 'aksakd', 'user3', 'user3@gmail.com', NULL, '$2y$12$3QeuftkOmkxrmz9Dx.inf.Tw4Tc2aql7E/PJmMPsKHiCzNYNG5O06', NULL, '2025-03-07 05:43:28', '2025-03-07 05:43:28', 0),
(6, 'user4', NULL, 'user4', 'user4@gmail.com', NULL, '$2y$12$X4eAkNj1REm9IYo48hY2y.zmn9Rh6lUJeZpUh/vYbNDh.ZtMy3/hC', NULL, '2025-03-07 05:49:59', '2025-03-07 05:49:59', 0),
(7, 'user5', NULL, 'user5', 'user5@gmail.com', NULL, '$2y$12$swmKWqKLbCEN13BAFpT/l.DgCBrl2FOra475mL0KvEWWIa6CzZ7mW', NULL, '2025-03-07 16:55:42', '2025-03-07 16:55:42', 0),
(8, 'user6', NULL, 'user6', 'user6@gmail.com', NULL, '$2y$12$k6avKuvQm6G03mU0JaVTEe/.Q1jXd9eRGbpfURnQfl44tkHLTp8XS', NULL, '2025-03-07 19:16:50', '2025-03-07 19:16:50', 0),
(9, 'user7', NULL, 'user7', 'user7@gmail.com', NULL, '$2y$12$FQ1Ist1QaoFWGoUjnJOx6.s8R.VOrPq6tAOrlBZYCkvfgRojOn7ki', NULL, '2025-03-08 19:44:21', '2025-03-08 19:44:21', 0),
(12, 'user8', NULL, 'user8', 'user8@gmail.com', NULL, '$2y$12$jmszAJ3Y08KHVoOOKSau0uKx7zq/Ok1YY5bAYtbyKDHCo5KFgrxyy', NULL, '2025-03-09 04:06:17', '2025-03-09 04:06:17', 0),
(13, 'user10', NULL, 'user10', 'user10@gmail.com', NULL, '$2y$12$iMXwErdrgJ.PKRtM/qqAp.QPPjcZjUZETAaSuYt0hU4PbQubAGanm', NULL, '2025-03-09 05:04:12', '2025-03-09 05:04:12', 0),
(14, 'user11', NULL, 'user11', 'user11@gmail.com', NULL, '$2y$12$FiQUz8t95xhaW5t9pRkWm.ZmARXXa3d2Jhytw0jlus6nRyK80Ukku', NULL, '2025-03-23 06:04:26', '2025-03-23 06:04:26', 0),
(16, 'reiggs', NULL, 'lim', 'reiggs22@gmail.com', NULL, '$2y$12$VdIioDoiF0eO1b2LBeyRYOwAoTteatVVADjRrsuwTORhJ8aqmCo6K', NULL, '2025-04-01 19:06:00', '2025-04-01 19:06:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `graduates`
--
ALTER TABLE `graduates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `graduates_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `graduates`
--
ALTER TABLE `graduates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `graduates`
--
ALTER TABLE `graduates`
  ADD CONSTRAINT `graduates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
