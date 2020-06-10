-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 11, 2019 at 10:06 AM
-- Server version: 5.7.21
-- PHP Version: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orchid_v001`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards_category_master`
--

DROP TABLE IF EXISTS `cards_category_master`;
CREATE TABLE IF NOT EXISTS `cards_category_master` (
  `cards_category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cards_category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cards_category_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cards_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cards_category_master`
--

INSERT INTO `cards_category_master` (`cards_category_id`, `cards_category_name`, `cards_category_description`, `created_at`, `updated_at`) VALUES
(1, 'OTHER', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(2, 'BIRTHDAY', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(3, 'ANNIVERSARY', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(4, 'CONDOLENSE', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(5, 'WEDDING', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(6, 'CONGRATULATIONS', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(7, 'GET WELL', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(8, 'THANK YOU', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(9, 'RETIREMENT', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(10, 'NEW BABY', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(11, 'FAREWELL', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(12, 'GRADUATION', '', '2019-02-01 07:04:49', '2019-02-01 07:04:49'),
(13, 'USER UPLOADED', NULL, '2019-02-01 07:04:49', '2019-02-01 07:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `cards_master`
--

DROP TABLE IF EXISTS `cards_master`;
CREATE TABLE IF NOT EXISTS `cards_master` (
  `cards_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cards_category_id` int(11) NOT NULL,
  `cards_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cards_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cards_location_url` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_user_uploaded` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id_if_user_uploaded` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cards_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cards_master`
--

INSERT INTO `cards_master` (`cards_id`, `cards_category_id`, `cards_name`, `cards_description`, `cards_location_url`, `is_active`, `is_user_uploaded`, `user_id_if_user_uploaded`, `created_at`, `updated_at`) VALUES
(1, 13, '2_1549630038_bI5urp_happy_new_year.png', '\"\"', '/storage/images/cards/user/original/1549630038_bI5urp_happy_new_year.png', 'Y', 'Y', 2, '2019-02-08 07:17:18', '2019-02-08 07:17:18'),
(2, 13, '2_1549630249_ZugnoX_happy_new_year.png', '\"\"', '/storage/images/cards/user/original/1549630249_ZugnoX_happy_new_year.png', 'Y', 'Y', 2, '2019-02-08 07:20:49', '2019-02-08 07:20:49'),
(3, 13, '2_1549633659_gXaUkA_happy_new_year.png', '\"\"', '/storage/images/cards/user/original/1549633659_gXaUkA_happy_new_year.png', 'Y', 'Y', 1, '2019-02-08 08:17:39', '2019-02-08 08:17:39'),
(4, 1, 'NewYear_001', '\"\"', '/storage/images/cards/admin/original/1549634274_3v8iT8_happy_new_year.png', 'Y', 'N', 0, '2019-02-08 08:27:54', '2019-02-08 08:27:54'),
(5, 1, 'NewYear_001', '\"\"', '/storage/images/cards/admin/original/1549639488_WxUZiv_happy_new_year.png', 'Y', 'N', 0, '2019-02-08 09:54:48', '2019-02-08 09:54:48'),
(6, 1, 'NewYear_001', '\"\"', '/storage/images/cards/admin/original/1549640272_m7p76i_happy_new_year.png', 'Y', 'N', 0, '2019-02-08 10:07:52', '2019-02-08 10:07:52'),
(7, 1, 'NewYear_001', '\"\"', '/storage/images/cards/admin/original/1549873869_cIfb3n_happy_new_year.png', 'Y', 'N', 0, '2019-02-11 03:01:09', '2019-02-11 03:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_type_id` int(11) NOT NULL,
  `event_start_time` datetime NOT NULL,
  `event_response_by_time` datetime NOT NULL,
  `event_created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `events_event_created_by_foreign` (`event_created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_description`, `event_type_id`, `event_start_time`, `event_response_by_time`, `event_created_by`, `created_at`, `updated_at`) VALUES
(3, 'XYZ Birthday', 'Birthday on 15-Jan-2018', 1, '2019-01-31 12:00:00', '2019-01-31 10:00:00', 3, '2019-01-17 03:26:42', '2019-01-31 07:58:42'),
(31, 'A18 Anniversary', 'Anniversary on 20-JAN-2019', 3, '2019-01-20 12:00:00', '2019-01-20 10:00:00', 1, '2019-01-30 04:10:13', '2019-01-30 04:10:13'),
(34, 'A18 Anniversary', 'Anniversary on 20-JAN-2019', 3, '2019-01-20 12:00:00', '2019-01-20 10:00:00', 1, '2019-01-31 06:45:30', '2019-01-31 06:45:30'),
(28, 'A12 Anniversary', 'Anniversary on 25-JAN-2019', 3, '2019-01-25 12:00:00', '2019-01-24 10:00:00', 2, '2019-01-17 09:59:58', '2019-01-17 09:59:58');

-- --------------------------------------------------------

--
-- Table structure for table `event_invitation`
--

DROP TABLE IF EXISTS `event_invitation`;
CREATE TABLE IF NOT EXISTS `event_invitation` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `invitation_message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invitation_sent_by` int(11) NOT NULL,
  `invitation_sent_to` int(11) NOT NULL,
  `invitation_sent_via` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invitee_profile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invitation_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_participants`
--

DROP TABLE IF EXISTS `event_participants`;
CREATE TABLE IF NOT EXISTS `event_participants` (
  `ep_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `event_invitation_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ep_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_participants`
--

INSERT INTO `event_participants` (`ep_id`, `event_id`, `user_id`, `role_id`, `event_invitation_id`, `created_at`, `updated_at`) VALUES
(1, 28, 2, 2, 0, '2019-01-17 09:59:58', '2019-01-17 09:59:58'),
(6, 31, 1, 2, 0, '2019-01-30 04:10:13', '2019-01-30 04:10:13'),
(8, 33, 1, 2, 0, '2019-01-30 04:10:19', '2019-01-30 04:10:19'),
(9, 34, 1, 2, 0, '2019-01-31 06:45:30', '2019-01-31 06:45:30'),
(5, 3, 2, 2, 0, '2019-01-17 03:26:42', '2019-01-17 03:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `event_participants_role_master`
--

DROP TABLE IF EXISTS `event_participants_role_master`;
CREATE TABLE IF NOT EXISTS `event_participants_role_master` (
  `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_participants_role_master`
--

INSERT INTO `event_participants_role_master` (`role_id`, `role_name`, `role_description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'GUEST', 'Part of the event with no organising role', 'N', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(2, 'SUPER ADMIN', 'Event creator', 'Y', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(3, 'ADMIN', 'Have all access except delete event', 'Y', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(4, 'MEMBER', 'Have limited rights like being able to write message', 'Y', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(5, 'MODERATOR', 'Can remove members messages', 'N', '2019-01-15 06:41:31', '2019-01-15 06:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `event_type_master`
--

DROP TABLE IF EXISTS `event_type_master`;
CREATE TABLE IF NOT EXISTS `event_type_master` (
  `event_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_type_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_type_master`
--

INSERT INTO `event_type_master` (`event_type_id`, `event_type_name`, `event_type_description`, `created_at`, `updated_at`) VALUES
(1, 'OTHER', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(2, 'BIRTHDAY', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(3, 'ANNIVERSARY', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(4, 'CONDOLENSE', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(5, 'WEDDING', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(6, 'CONGRATULATIONS', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(7, 'GET WELL', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(8, 'THANK YOU', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(9, 'RETIREMENT', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(10, 'NEW BABY', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(11, 'FAREWELL', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31'),
(12, 'GRADUATION', '', '2019-01-15 06:41:31', '2019-01-15 06:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password_otp`
--

DROP TABLE IF EXISTS `forgot_password_otp`;
CREATE TABLE IF NOT EXISTS `forgot_password_otp` (
  `otp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`otp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(86, '2014_10_12_000000_create_users_table', 1),
(87, '2014_10_12_100000_create_password_resets_table', 1),
(88, '2018_12_28_090018_create_events_table', 1),
(89, '2019_01_03_151946_create_event_type_master_table', 1),
(90, '2019_01_04_142900_create_event_participants_role_master', 1),
(91, '2019_01_16_134952_create_event_participants_table', 2),
(92, '2019_01_16_143028_create_event_invitation_table', 2),
(99, '2019_01_25_122201_create_forgot_password_otp_table', 3),
(100, '2019_01_26_234923_create_social_media_login_table', 3),
(102, '2019_02_01_101803_create_e_cards_category_master_table', 4),
(105, '2019_02_01_132013_create_cards_master_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_media_login`
--

DROP TABLE IF EXISTS `social_media_login`;
CREATE TABLE IF NOT EXISTS `social_media_login` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_id` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_media_login`
--

INSERT INTO `social_media_login` (`id`, `user_id`, `email`, `provider`, `profile_id`, `created_at`, `updated_at`) VALUES
(1, 5, 'leokonwar@yahoo.co.in', 'Facebook', 'https://www.facebook.com/leokonwar', '2019-01-29 02:58:17', '2019-01-29 02:58:17'),
(2, 5, 'leokonwar@yahoo.co.in', 'Google', 'https://plus.google.com/u/0/+LeoKonwar', '2019-01-29 03:24:57', '2019-01-29 03:24:57'),
(4, 6, 'leo@yahoo.co.in', 'Google', 'https://plus.google.com/u/0/+LeoKonwar', '2019-01-29 05:53:19', '2019-01-29 05:53:19'),
(5, 9, 'lk@yahoo.co.in', 'Google', 'https://plus.google.com/u/0/+LeoKonwar', '2019-01-29 07:31:05', '2019-01-29 07:31:05'),
(6, 9, 'lk@yahoo.co.in', 'Google', 'https://plus.google.com/u/0/', '2019-01-29 07:34:41', '2019-01-29 07:34:41'),
(7, 11, 'leokonwar123@gmail.com', 'Facebook', 'https://www.facebook.com/leokonwar', '2019-01-30 08:31:45', '2019-01-30 08:31:45'),
(8, 11, 'leokonwar123@gmail.com', 'Google', 'https://plus.google.com/u/0/+LeoKonwar', '2019-01-31 02:45:14', '2019-01-31 02:45:14'),
(12, 11, 'leokonwar123@gmail.com', 'LinkedIn', 'https://www.linkedin.com/in/leokonwar/', '2019-02-01 03:23:24', '2019-02-01 03:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `profile_picture` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `last_name`, `phone_number`, `dob`, `profile_picture`, `email`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Leo', NULL, 'Konwar', '9886459056', '1984-08-06', 'Lk.jpg', 'leo@orchid.com', NULL, '$2y$10$eBycu97nFwoKgpNqKlWZ.u8zXt.4XZzgk2Z24RXV6K123g5NNlAVG', 'Y', NULL, '2019-01-17 03:02:45', '2019-01-17 03:02:45'),
(2, 'Sitesh', NULL, 'Kumar', '9886459056', '1984-08-06', 'sk.jpg', 'sitesh@orchid.com', NULL, '$2y$10$Ue1fDyj1Oi9x6qn2BW9P4eE9ZMHmWtavUrX4IJJCddYcOs.rQLiUm', 'Y', NULL, '2019-01-17 03:23:56', '2019-01-17 03:23:56'),
(3, 'Leo', NULL, 'Konwar', '9886459056', '1984-08-06', 'lk.jpg', 'leokonwar@gmail.com', NULL, '$2y$10$bqf1ehuOapc2P9Xh4T7DE.XFdnjvCBN5DhoAKGVlFYzmOcoN0pnES', 'Y', NULL, '2019-01-26 06:20:41', '2019-01-26 06:20:41'),
(5, 'Leo', NULL, NULL, NULL, NULL, NULL, 'leokonwar@yahoo.co.in', NULL, '$2y$10$43JYqY6Fkak6TZG9eS5dp.nWxQZiysWCV5.0tLeJARlDJApMPbX1W', 'Y', NULL, '2019-01-29 02:58:17', '2019-01-29 02:58:17'),
(6, 'Leo', NULL, NULL, NULL, NULL, NULL, 'leo@yahoo.co.in', NULL, '$2y$10$iEU9aCO7jRPnle/ITTcro.7MK3jw8JnUCk27ozZ760TUN9QcMKgCa', 'Y', NULL, '2019-01-29 05:53:19', '2019-01-29 05:53:19'),
(9, 'Leo', NULL, NULL, NULL, NULL, NULL, 'lk@yahoo.co.in', NULL, '$2y$10$38CeUcy4NzXr2DsrkrixdercWxOXt0l2mNYbj8Bm/MyG2gAg70nuy', 'Y', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9zb2NpYWxMb2dpbiIsImlhdCI6MTU0ODc2Njg2NSwibmJmIjoxNTQ4NzY2ODY1LCJqdGkiOiJEelliN0g1YkNrbE9MYm82Iiwic3ViIjpudWxsLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.3rYhCgPGxckx1As1TF_i_m8AbgOcuh0vi_Hf3kO5MLQ', '2019-01-29 07:31:05', '2019-01-29 07:31:05'),
(10, NULL, NULL, NULL, NULL, NULL, NULL, 'leokonwar@orchidrus.com', NULL, '$2y$10$mWIthSFcBdr6j.045P2Rce9iTqNks3pn0kRrO3L0L.n.LIgF5Vy4u', 'Y', NULL, '2019-01-29 07:57:25', '2019-01-29 07:57:25'),
(11, 'LK', NULL, NULL, NULL, NULL, NULL, 'leokonwar123@gmail.com', NULL, '$2y$10$i9yo6Qu9Krz/rWZuYsgmiuVI8aR0Y59O6ZbDrEldq2FMdBvQ2MHUm', 'Y', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU0ODg1NjM5NywibmJmIjoxNTQ4ODU2Mzk3LCJqdGkiOiJpUW9UY1pCMjJka1B0bnBsIiwic3ViIjpudWxsLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.MjPMFi--sAREZ33ijnzvmHEi4qx8g9zoKO0uavOhwNI', '2019-01-30 08:23:16', '2019-01-30 08:23:17');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_events`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_events`;
CREATE TABLE IF NOT EXISTS `view_events` (
`event_id` int(10) unsigned
,`event_name` varchar(255)
,`event_description` varchar(255)
,`event_type_id` int(11)
,`event_start_time` datetime
,`event_response_by_time` datetime
,`event_created_by` int(11)
,`first_name` varchar(45)
,`middle_name` varchar(45)
,`last_name` varchar(45)
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `view_events`
--
DROP TABLE IF EXISTS `view_events`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_events`  AS  select `e`.`event_id` AS `event_id`,`e`.`event_name` AS `event_name`,`e`.`event_description` AS `event_description`,`e`.`event_type_id` AS `event_type_id`,`e`.`event_start_time` AS `event_start_time`,`e`.`event_response_by_time` AS `event_response_by_time`,`e`.`event_created_by` AS `event_created_by`,`u`.`first_name` AS `first_name`,`u`.`middle_name` AS `middle_name`,`u`.`last_name` AS `last_name`,`e`.`created_at` AS `created_at`,`e`.`updated_at` AS `updated_at` from (`events` `e` left join `users` `u` on((`e`.`event_created_by` = `u`.`user_id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
