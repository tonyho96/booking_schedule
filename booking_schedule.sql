-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th10 06, 2018 lúc 05:22 AM
-- Phiên bản máy phục vụ: 5.7.19
-- Phiên bản PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `booking_schedule`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(19, '2014_10_12_000000_create_users_table', 1),
(20, '2014_10_12_100000_create_password_resets_table', 1),
(21, '2018_03_16_202501_create_bookings_table', 1),
(22, '2018_03_16_202513_create_projects_table', 1),
(23, '2018_03_16_202547_create_resources_table', 1),
(24, '2018_03_16_202643_create_statuses_table', 1),
(25, '2018_08_02_105229_create_schedules_table', 1),
(26, '2018_08_03_152901_update_resources_table', 1),
(27, '2018_08_03_153330_update_statuses_table', 1),
(28, '2018_08_03_172810_projects_delete_created_id_updated_id', 1),
(29, '2018_08_03_173017_update_projects_table', 1),
(30, '2018_08_06_030539_delete_createdat_updatedat_projects', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
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
-- Cấu trúc bảng cho bảng `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(6400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `start_timestamp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_timestamp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `private` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_folder_id` int(11) DEFAULT NULL,
  `client_person_id` int(11) DEFAULT NULL,
  `client_organization_id` int(11) DEFAULT NULL,
  `project_order` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_background` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12088 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `projects`
--

INSERT INTO `projects` (`id`, `name`, `code`, `description`, `status_id`, `start_timestamp`, `end_timestamp`, `private`, `parent_folder_id`, `client_person_id`, `client_organization_id`, `project_order`, `color_background`, `color_text`, `created`, `updated`, `created_id`, `updated_id`) VALUES
(3294, 'Barnwood ádasdFunded', 'BF', '', 1, '0', '0', 'Yes', 0, 0, 0, '0', '#53ff00', '#000000', '1460042289', '1487926066', 1771, 1771),
(7180, 'Alicia Leonard', 'AL', '', 0, '0', '0', 'No', 6171, 0, 0, '0', '#3c78d8', '#000000', '1498122252', '1498123017', 1771, 1771),
(6174, 'Chris H', 'CH', '', 0, '0', '0', 'No', 6171, 0, 0, '0', '#9900ff', '#000000', '1487926463', '1487926463', 1771, 1771),
(6600, 'James B', 'JB', '', 0, '0', '0', 'No', 6171, 0, 0, '0', '#ffff00', '#000000', '1492423248', '1492423248', 1771, 1771),
(6172, 'Matt', 'MF', '', 1, '0', '0', 'No', 6171, 0, 0, '0', '#ff9900', '#000000', '1487926370', '1487926370', 1771, 1771),
(6529, 'Alex', 'AH', '', 0, '0', '0', 'No', 6171, 0, 0, '1', '#ff9900', '#000000', '1491903018', '1491903082', 1771, 1771),
(6714, 'Paul', 'P', '', 0, '0', '0', 'No', 6171, 0, 0, '0', '#3c78d8', '#000000', '1493374681', '1493391178', 1771, 1771),
(6188, 'Not Applicable', 'NA', '', 1, '0', '0', 'No', 6170, 0, 0, '0', '#3c78d8', '#000000', '1488194842', '1500367844', 1771, 1771),
(6173, 'Alice', 'A', '', 0, '0', '0', 'No', 6171, 0, 0, '0', '#00ffff', '#000000', '1487926412', '1487926412', 1771, 1771),
(7105, 'Rich', 'RB', '', 0, '0', '0', 'No', 6171, 0, 0, '0', '#3c78d8', '#000000', '1497264274', '1497264274', 1771, 1771),
(7181, 'Tom Button', 'TB', '', 0, '0', '0', 'No', 6171, 0, 0, '0', '#3c78d8', '#000000', '1498122348', '1498122396', 1771, 1771),
(9654, 'Ceri', 'CD', '', NULL, '', '', 'No', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL),
(11567, 'Dave', 'DS', '', NULL, '', '', 'No', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL),
(10624, 'Kayleigh', 'KP', '', NULL, '', '', 'No', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL),
(11678, 'James W', 'JW', '', NULL, '', '', 'No', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL),
(11679, 'Chris L', 'CL', '', NULL, '', '', 'No', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL),
(12074, 'Eddie', 'ER', '', NULL, '', '', 'No', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL),
(12086, 'Andy', 'AM', '', 1, '', '', 'No', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL),
(12087, 'vandoan', 'BF', 'ajdkjasd', 1, '', '', 'No', NULL, NULL, NULL, '', '#000000', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order_pos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11348 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `resources`
--

INSERT INTO `resources` (`id`, `name`, `description`, `type_id`, `parent_id`, `order_pos`) VALUES
(4590, 'Cancelled or Unavailable', 'Bookings cancelled by event or by us due to a clash etc', 5, 0, 6),
(8937, '4x4 Wilts hhhh', '', 5, 0, 1),
(11345, 'Van 1 Ireland', '', 5, 0, 2),
(10600, 'Ryan', 'EA15 JYT', 3, 0, 3),
(3158, 'Luther', 'YJ66 HLD', 3, 0, 5),
(8554, 'Notes', '', 5, 0, 4),
(5390, 'Tabitha', 'YJ14 GYG', 3, 0, 7),
(10051, 'Lottie', 'MX14 WKH', 3, 0, 8),
(7771, 'Annabelle', 'Annabelle', 3, 0, 9),
(7316, 'Gertrude', 'Gertrude', 3, 0, 10),
(10601, 'Josephine', 'EU63 YGE', 3, 0, 11),
(10603, 'Philip', 'BU14 LHA', 3, 0, 12),
(10602, 'Holly', 'EU63 YJV', 3, 0, 13),
(5795, 'Trailer 1 Ireland', '', 5, 0, 14),
(11347, 'IRL Cancelled or unable to attend', '', 5, 0, 15),
(10604, 'Luton 6', '', 3, 0, 16),
(7775, 'Skoda', 'WJ17 UHB', 5, 0, 17),
(11346, 'IRL Notes', '', 5, 0, 18),
(7770, 'Van 3 Dundee', 'YJ17 FMK', 5, 0, 19),
(7779, 'Pop-Up', '', 3, 0, 20),
(8446, 'Renault Low-Floor Van', '', 5, 0, 21),
(33, '33', '33', NULL, NULL, 22),
(333, '333', '33355', NULL, NULL, 23);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(6400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_pos` int(11) DEFAULT NULL,
  `resource_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `schedules`
--

INSERT INTO `schedules` (`id`, `name`, `description`, `order_pos`, `resource_ids`, `permission_ids`, `created_at`, `updated_at`) VALUES
(15, 'test1', 'test1', 122, '[10600]', '[]', '2018-07-06 16:59:04', NULL),
(16, 'test3', 'test3', 100, '[5390,7771,10600]', '[1,2]', '2018-07-06 17:00:08', NULL),
(17, 'New Schedule', 'Description', 1, '[4590,7770]', '[0]', '2018-07-09 07:43:42', NULL),
(18, 'vandoan', 'a', 1, '[11345]', '[0]', '2018-07-09 15:43:17', NULL),
(19, 'kjahsdkjákjdh', 'hjádhkjádkjhádkjhakjh', 1, '[3158]', '[]', '2018-07-09 15:48:04', NULL),
(20, 'ádkla/s;ldnk;ná', 'dnjậd;ládhạoudhnakjbdlkjádkljlabdhjl', 1, '[11345]', '', '2018-07-09 15:50:34', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_background` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=593 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `color_background`, `color_text`) VALUES
(316, 'Provisional', '#0cfa95', '#060606'),
(317, 'Confirmed', '#2b2bf0', ''),
(592, 'Invoiced', '#ad37ec', ''),
(326, 'Targeted', '#ab12cb', '#7cf733'),
(330, 'Unavailable', '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `role`, `created_at`, `updated_at`, `deleted_at`, `password`, `remember_token`) VALUES
(1, 'admin', NULL, 'admin@admin.com', 0, NULL, NULL, NULL, '$2y$10$kQWm9ZGgZfqxXJOjiyqBHO.Dxwjbg7t/uv0Cprcxoa5zGRiDQ6k16', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
