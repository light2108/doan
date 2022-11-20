-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 22, 2022 lúc 05:52 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `doan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `class_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `role` int(11) NOT NULL DEFAULT 0,
  `birth_day` datetime DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `mobile`, `image`, `subject_id`, `class_id`, `status`, `role`, `birth_day`, `address`, `sex`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@com', '$2y$10$kwiQqqSuheRRuqXIhGZsd.FIjF8u.6yhzAKkZiqr5SpM/Ts4Vis9G', '0989068867', 'imgs/1645024422.jpg', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2022-06-06 08:57:13'),
(10, 'Tam', 'tam@com', '$2y$10$/tlB7bxd5OqNOmxUVesDaO3PE27M8U4HRjMAClLJVjUxHGnmWrGIW', '123', 'imgs/1652410748.jpg', 10, '5,6,8', 1, -1, '1989-06-01 00:00:00', 'kjkk', 1, '2022-03-03 15:56:59', '2022-06-15 03:19:04'),
(11, 'long', 'long@com', '$2y$10$1XBjpjWqphAJnwm7zgsYRuAUMfalTuu0R5q/U9VX5gblhle.nbqqC', '234', 'imgs/1652410799.jpg', 11, '6,7', 1, 0, NULL, NULL, NULL, '2022-03-03 15:58:01', '2022-06-11 17:09:53'),
(12, 'minh', 'minh@com', '$2y$10$/YIohxt1a8lksl0pcLC56uezTWemMExxKoIDHIhao0iFpHhF.LPoW', '345', NULL, 10, '7,8', 1, 0, NULL, NULL, NULL, '2022-05-07 16:26:10', '2022-06-06 09:19:00'),
(13, 'thanh', 'thanh@com', '$2y$10$OqnnB5Ny/OSWQ4CuARrXcOwNWULj1SDsBTcBpmRs6T2Lb1nzQzclG', '123', 'imgs/1652410831.jpg', 12, '6,9', 1, 0, NULL, NULL, NULL, '2022-05-10 15:41:40', '2022-05-13 03:00:31'),
(17, 'Huy', 'huy@com', '$2y$10$u3Rj5Gq40vm54QO1ciA3TeO6MsxnNofUt25vyV3JmRiq7pcgPJozu', '43423', 'imgs/1653126214.280971460_577751616924692_4174660045656840212_n.jpg', 12, '7', 1, 0, '1986-02-03 00:00:00', 'adasdasda', 1, '2022-05-21 09:43:35', '2022-05-21 09:43:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `answer`
--

CREATE TABLE `answer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `answer`, `correct_answer`, `status`, `created_at`, `updated_at`) VALUES
(1, '37', 'fsfsfsdf', 0, 1, '2022-05-08 02:12:03', '2022-05-08 02:12:03'),
(2, '37', 'fdfsf', 1, 1, '2022-05-08 02:12:33', '2022-05-08 02:12:43'),
(6, '39', 'ddd', 0, 1, '2022-05-11 02:49:56', '2022-05-11 02:49:56'),
(7, '39', 'eee', 0, 1, '2022-05-11 02:50:06', '2022-05-11 02:50:06'),
(8, '39', 'fff', 1, 1, '2022-05-11 02:50:16', '2022-05-11 02:50:16'),
(9, '39', 'ggg', 0, 1, '2022-05-11 02:50:25', '2022-05-11 02:50:25'),
(10, '40', 'ppp', 0, 1, '2022-05-11 03:16:03', '2022-05-11 03:16:03'),
(11, '40', 'qqq', 0, 1, '2022-05-11 03:16:12', '2022-05-11 03:16:12'),
(12, '40', 'ttt', 1, 1, '2022-05-11 03:16:22', '2022-05-11 03:16:29'),
(13, '41', 'hhh', 1, 1, '2022-05-11 03:17:06', '2022-05-11 03:17:21'),
(14, '41', 'fsdfsfsdf', 0, 1, '2022-05-11 03:17:14', '2022-05-11 03:17:14'),
(15, '42', 'ggdgdfg', 0, 1, '2022-05-11 03:17:38', '2022-05-11 03:17:38'),
(16, '42', 'gfgdgg', 0, 1, '2022-05-11 03:17:48', '2022-05-11 03:17:48'),
(17, '42', 'dadasd', 1, 1, '2022-05-11 03:18:00', '2022-05-11 03:18:00'),
(18, '43', 'fdfsdf', 0, 1, '2022-05-15 03:52:09', '2022-05-15 03:52:09'),
(19, '43', 'adas', 1, 1, '2022-05-15 03:52:19', '2022-05-15 03:52:19'),
(20, '43', 'dasdasd', 0, 1, '2022-05-15 03:52:27', '2022-05-15 03:52:27'),
(21, '44', 'qwer', 0, 1, '2022-05-18 03:24:13', '2022-05-18 03:24:13'),
(22, '44', 'fadfadf', 0, 1, '2022-05-18 03:24:21', '2022-05-18 03:24:21'),
(23, '44', 'fadfadfad', 1, 1, '2022-05-18 03:24:31', '2022-05-18 03:24:31'),
(24, '45', 'dhfshdfsd', 0, 1, '2022-05-18 03:25:36', '2022-05-18 03:25:36'),
(25, '45', 'afdafadfda', 1, 1, '2022-05-18 03:25:47', '2022-05-18 03:25:47'),
(26, '45', 'hfhsodfodf', 0, 1, '2022-05-18 03:25:57', '2022-05-18 03:25:57'),
(27, '46', 'aaa', 0, 1, '2022-05-19 10:00:52', '2022-05-19 10:00:52'),
(28, '46', 'bbb', 1, 1, '2022-05-19 10:01:02', '2022-05-19 10:01:02'),
(29, '46', 'ccc', 0, 1, '2022-05-19 10:01:10', '2022-05-19 10:01:10'),
(30, '47', 'hhh', 0, 1, '2022-05-19 10:02:07', '2022-05-19 10:02:07'),
(31, '47', 'kkk', 0, 1, '2022-05-19 10:02:17', '2022-05-19 10:02:17'),
(32, '47', 'lll', 1, 1, '2022-05-19 10:02:28', '2022-05-19 10:02:28'),
(35, '38', 'aaa', 0, 1, '2022-05-23 03:26:28', '2022-05-23 03:26:28'),
(36, '38', 'bbb', 1, 1, '2022-05-23 03:26:29', '2022-05-23 03:26:29'),
(37, '38', 'ccc', 0, 1, '2022-05-23 03:26:30', '2022-05-23 03:26:30'),
(38, '38', 'ddd', 0, 1, '2022-05-23 03:26:30', '2022-05-23 03:26:30'),
(44, '54', 'aaaaaaaa', 0, 1, '2022-05-23 16:20:33', '2022-05-23 16:20:33'),
(45, '54', 'zzzzzzzzzzzz', 1, 1, '2022-05-23 16:20:33', '2022-05-23 16:20:33'),
(46, '54', 'oooooooooo', 0, 1, '2022-05-23 16:20:33', '2022-05-23 16:20:33'),
(47, '55', 'gfgdfg', 1, 1, '2022-05-23 16:21:08', '2022-05-23 16:21:08'),
(48, '55', 'yoyuiui', 0, 1, '2022-05-23 16:21:08', '2022-05-23 16:21:08'),
(49, '55', 'hghfgh', 0, 1, '2022-05-23 16:21:08', '2022-05-23 16:21:08'),
(50, '56', 'qqqqqqqqq', 0, 1, '2022-05-23 16:34:24', '2022-05-23 16:34:24'),
(51, '56', 'wwwwwwwww', 0, 1, '2022-05-23 16:34:24', '2022-05-23 16:34:24'),
(52, '56', 'eeeeeeeeeee', 1, 1, '2022-05-23 16:34:24', '2022-05-23 16:34:24'),
(53, '57', 'tdrdt', 0, 1, '2022-05-23 16:35:09', '2022-05-23 16:35:09'),
(54, '57', 'trtdrt', 1, 1, '2022-05-23 16:35:09', '2022-05-23 16:35:09'),
(55, '57', 'uiiuiu', 0, 1, '2022-05-23 16:35:09', '2022-05-23 16:35:09'),
(56, '58', 'hvhhv', 1, 1, '2022-05-23 16:35:33', '2022-05-23 16:35:33'),
(57, '58', 'hghyu', 0, 1, '2022-05-23 16:35:33', '2022-05-23 16:35:33'),
(58, '59', 'guyuyut', 1, 1, '2022-05-23 16:36:01', '2022-05-23 16:36:01'),
(59, '59', 'fgdgfg', 0, 1, '2022-05-23 16:36:01', '2022-05-23 16:36:01'),
(60, '59', 'gdgdfgdfg', 0, 1, '2022-05-23 16:36:01', '2022-05-23 16:36:01'),
(61, '60', 'dasdasdsad', 0, 1, '2022-05-24 03:43:58', '2022-05-24 03:43:58'),
(62, '60', 'rwerwerwer', 1, 1, '2022-05-24 03:43:58', '2022-05-24 03:43:58'),
(63, '60', 'vffrsrgf', 0, 1, '2022-05-24 03:43:58', '2022-05-24 03:43:58'),
(67, '53', 'aaaaa', 1, 1, '2022-05-24 15:09:17', '2022-05-24 15:09:17'),
(68, '53', 'bbbbb', 0, 1, '2022-05-24 15:09:17', '2022-05-24 15:09:17'),
(69, '53', 'cccccc', 0, 1, '2022-05-24 15:09:17', '2022-05-24 15:09:17'),
(70, '61', '1', 0, 1, '2022-05-25 08:11:46', '2022-05-25 08:11:46'),
(71, '61', '2', 1, 1, '2022-05-25 08:11:46', '2022-05-25 08:11:46'),
(72, '61', '3', 0, 1, '2022-05-25 08:11:47', '2022-05-25 08:11:47'),
(73, '61', '4', 0, 1, '2022-05-25 08:11:47', '2022-05-25 08:11:47'),
(74, '62', '5', 1, 1, '2022-05-25 08:11:47', '2022-05-25 08:11:47'),
(75, '62', '4', 0, 1, '2022-05-25 08:11:47', '2022-05-25 08:11:47'),
(76, '62', '3', 0, 1, '2022-05-25 08:11:48', '2022-05-25 08:11:48'),
(77, '62', '2', 0, 1, '2022-05-25 08:11:48', '2022-05-25 08:11:48'),
(89, '51', 'bcd', 0, 1, '2022-05-26 10:04:24', '2022-05-26 10:04:24'),
(90, '51', 'dfsf', 1, 1, '2022-05-26 10:04:24', '2022-05-26 10:04:24'),
(91, '51', 'fdf', 0, 1, '2022-05-26 10:04:24', '2022-05-26 10:04:24'),
(92, '52', 'co', 1, 1, '2022-05-26 10:04:45', '2022-05-26 10:04:45'),
(93, '52', 'khong', 0, 1, '2022-05-26 10:04:45', '2022-05-26 10:04:45'),
(94, '63', '1', 0, 1, '2022-05-27 04:12:28', '2022-05-27 04:12:28'),
(95, '63', '2', 1, 1, '2022-05-27 04:12:28', '2022-05-27 04:12:28'),
(96, '63', '3', 0, 1, '2022-05-27 04:12:29', '2022-05-27 04:12:29'),
(97, '63', '4', 0, 1, '2022-05-27 04:12:29', '2022-05-27 04:12:29'),
(98, '64', '5', 1, 1, '2022-05-27 04:12:29', '2022-05-27 04:12:29'),
(99, '64', '4', 0, 1, '2022-05-27 04:12:29', '2022-05-27 04:12:29'),
(100, '64', '3', 0, 1, '2022-05-27 04:12:29', '2022-05-27 04:12:29'),
(101, '64', '2', 0, 1, '2022-05-27 04:12:29', '2022-05-27 04:12:29'),
(102, '65', '1', 0, 1, '2022-06-08 04:06:46', '2022-06-08 04:06:46'),
(103, '65', '2', 1, 1, '2022-06-08 04:06:46', '2022-06-08 04:06:46'),
(104, '65', '3', 0, 1, '2022-06-08 04:06:46', '2022-06-08 04:06:46'),
(105, '65', '4', 0, 1, '2022-06-08 04:06:46', '2022-06-08 04:06:46'),
(106, '66', '5', 1, 1, '2022-06-08 04:06:46', '2022-06-08 04:06:46'),
(107, '66', '4', 0, 1, '2022-06-08 04:06:46', '2022-06-08 04:06:46'),
(108, '66', '3', 0, 1, '2022-06-08 04:06:47', '2022-06-08 04:06:47'),
(109, '66', '2', 0, 1, '2022-06-08 04:06:47', '2022-06-08 04:06:47'),
(110, '67', '1', 0, 1, '2022-06-08 08:35:21', '2022-06-08 08:35:21'),
(111, '67', '2', 1, 1, '2022-06-08 08:35:21', '2022-06-08 08:35:21'),
(112, '67', '3', 0, 1, '2022-06-08 08:35:21', '2022-06-08 08:35:21'),
(113, '67', '4', 0, 1, '2022-06-08 08:35:21', '2022-06-08 08:35:21'),
(114, '68', '5', 1, 1, '2022-06-08 08:35:21', '2022-06-08 08:35:21'),
(115, '68', '4', 0, 1, '2022-06-08 08:35:21', '2022-06-08 08:35:21'),
(116, '68', '3', 0, 1, '2022-06-08 08:35:21', '2022-06-08 08:35:21'),
(117, '68', '2', 0, 1, '2022-06-08 08:35:21', '2022-06-08 08:35:21'),
(118, '69', 'aaa', 1, 1, '2022-06-08 15:31:48', '2022-06-08 15:31:48'),
(119, '69', 'bbb', 1, 1, '2022-06-08 15:31:48', '2022-06-08 15:31:48'),
(120, '69', 'ccc', 0, 1, '2022-06-08 15:31:48', '2022-06-08 15:31:48'),
(121, '69', 'ddd', 0, 1, '2022-06-08 15:31:48', '2022-06-08 15:31:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `check_login_exam`
--

CREATE TABLE `check_login_exam` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `check_login_exam`
--

INSERT INTO `check_login_exam` (`id`, `exam_id`, `student_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 15, 20, 1, '2022-06-15 18:04:46', '2022-06-15 18:06:31'),
(2, 15, 40, 0, '2022-06-15 18:04:46', '2022-06-15 18:04:46'),
(3, 15, 53, 0, '2022-06-15 18:04:46', '2022-06-15 18:04:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `classes`
--

INSERT INTO `classes` (`id`, `grade_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(5, 1, '10A1', 1, '2022-03-03 15:54:30', '2022-03-08 14:54:29'),
(6, 1, '10A2', 1, '2022-03-03 15:54:50', '2022-03-03 15:54:50'),
(7, 1, '10A3', 1, '2022-03-03 15:55:04', '2022-03-03 15:55:04'),
(8, 2, '11A1', 1, '2022-03-04 15:18:48', '2022-03-04 15:18:48'),
(9, 2, '11A2', 1, '2022-03-05 16:09:43', '2022-03-05 16:09:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `grade_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `password` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `time` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `multiple` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL,
  `video` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exams`
--

INSERT INTO `exams` (`id`, `name`, `subject_id`, `grade_id`, `class_id`, `teacher_id`, `password`, `start_time`, `end_time`, `time`, `multiple`, `status`, `video`, `created_at`, `updated_at`) VALUES
(5, 'tu cach', 10, '1', '5', 10, '123', '2022-03-08 22:04:00', '2022-03-30 22:04:00', NULL, 0, 1, NULL, '2022-03-10 15:04:17', '2022-05-08 17:07:47'),
(6, 'giua ki', 10, '1', '5,6', 10, '123', '2022-03-16 22:43:00', '2022-06-18 17:00:00', '75', 0, 1, NULL, '2022-03-19 15:43:16', '2022-06-12 08:21:02'),
(7, 'tu cach', 11, '1', '6', 11, '123', '2022-06-26 15:57:00', '2022-06-27 15:57:00', '50', 0, 1, 'video/1652174462.mp4', '2022-05-10 08:57:47', '2022-06-12 03:31:12'),
(8, 'cuoi ki', 11, '1', '6,7', 11, '123', '2022-05-18 15:59:00', '2022-05-20 15:59:00', NULL, 0, 1, NULL, '2022-05-10 08:59:57', '2022-05-10 08:59:57'),
(9, 'cuoi ki', 10, '1', '6', 10, NULL, '2022-05-11 22:38:00', '2022-06-02 22:38:00', '20', 0, 1, NULL, '2022-05-10 15:38:55', '2022-05-31 03:33:30'),
(10, 'giua ki', 11, '1', '6', 11, NULL, '2022-05-11 22:40:00', '2022-05-13 22:40:00', NULL, 0, 1, NULL, '2022-05-10 15:40:21', '2022-05-10 15:40:21'),
(11, 'tu cach', 12, '1', '6', 13, NULL, '2022-05-12 22:42:00', '2022-05-14 22:42:00', NULL, 0, 1, NULL, '2022-05-10 15:42:36', '2022-05-10 15:42:36'),
(12, 'giua ki', 12, '1', '6', 13, NULL, '2022-05-21 23:05:00', '2022-05-29 23:05:00', NULL, 0, 1, NULL, '2022-05-10 16:05:40', '2022-05-10 16:05:40'),
(14, 'bo sung', 10, '1', '5,6', 10, NULL, '2022-05-27 11:15:00', '2022-05-31 11:15:00', '60', 1, 1, NULL, '2022-05-27 04:15:43', '2022-05-31 02:47:28'),
(15, 'test', 10, '1', '5,6', 10, NULL, '2022-06-16 00:53:00', '2022-06-23 00:53:00', '20', 0, 1, NULL, '2022-06-15 17:53:25', '2022-06-15 17:53:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `grades`
--

INSERT INTO `grades` (`id`, `grade`, `status`, `created_at`, `updated_at`) VALUES
(1, 10, 1, '2022-03-03 15:31:35', '2022-03-08 14:53:54'),
(2, 11, 1, '2022-03-03 15:31:56', '2022-03-03 15:31:56'),
(4, 12, 1, '2022-03-03 15:32:35', '2022-03-03 15:32:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_02_15_224136_create_admins_table', 1),
(6, '2022_02_17_221058_create_students_table', 2),
(7, '2022_02_17_230353_create_questions_table', 3),
(8, '2022_02_18_220416_create_exams_table', 4),
(9, '2022_02_18_220756_create_subjects_table', 4),
(10, '2022_02_20_223600_create_classes_table', 5),
(11, '2022_02_28_220636_create_teacher_class_table', 6),
(12, '2022_03_03_215532_create_grades_table', 7),
(13, '2022_04_25_091904_create_answer_table', 8),
(14, '2022_05_02_101205_create_results_table', 8),
(15, '2022_05_23_103917_create_units_table', 9),
(16, '2022_06_04_234330_create_result_answer_exam_table', 10),
(17, '2022_06_07_225323_create_result_merger_table', 11),
(18, '2022_06_15_110411_create_check_login_exam_table', 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` int(11) DEFAULT 0,
  `select_id` text COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `teacher_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `question` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_id` int(11) DEFAULT 0,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_listen` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` double DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`id`, `exam_id`, `select_id`, `teacher_id`, `subject_id`, `question`, `grade_id`, `unit_id`, `image`, `file_listen`, `score`, `status`, `created_at`, `updated_at`) VALUES
(37, 5, '0', 10, 10, 'dsadsadasd', '1', 0, NULL, NULL, NULL, 1, '2022-05-07 16:20:44', '2022-05-12 15:45:02'),
(38, 0, '0', 12, 10, 'sadasdasfdjfjs;dfj;djf;df;djfdfkFfsdlfsdf;sdfj;sdf;sdfdsljflsdsdfsdf', '1', 0, 'imgckeditor/1652238300.jpg', NULL, NULL, 1, '2022-05-07 16:27:08', '2022-05-19 16:07:57'),
(39, 6, '0', 10, 10, 'faffafdfsdfsdfsf', '1', 0, NULL, NULL, NULL, 1, '2022-05-11 02:49:39', '2022-05-11 02:49:39'),
(40, 6, '0', 10, 10, 'dsadasjldasdjlasdasd', '1', 0, NULL, NULL, NULL, 1, '2022-05-11 03:15:00', '2022-05-19 09:32:49'),
(41, 6, '0', 10, 10, 'pdpsapdakldf,nd,fns,dsdffd', '1', 0, NULL, NULL, NULL, 1, '2022-05-11 03:15:20', '2022-05-11 03:15:20'),
(42, 6, '0', 10, 10, 'jfldfslfdfasdm,asndm,andsandansd', '1', 0, NULL, NULL, NULL, 1, '2022-05-11 03:15:39', '2022-05-11 03:15:39'),
(43, 0, '0', 10, 10, 'dasdadasd', '1', 0, NULL, NULL, NULL, 1, '2022-05-15 03:51:53', '2022-05-19 09:56:19'),
(44, 6, '0', 10, 10, 'jsdfjsodfosdfjsoddfsdf', '1', 0, NULL, NULL, NULL, 1, '2022-05-18 03:23:51', '2022-05-18 03:23:51'),
(45, 6, '0', 10, 10, 'ghfgjsdjsdfjapfjsjdasda', '1', 0, NULL, NULL, NULL, 1, '2022-05-18 03:25:18', '2022-05-19 09:24:50'),
(46, 0, '0', 12, 10, 'aaaaaaaaaaaaaaa', '1', 0, NULL, NULL, NULL, 1, '2022-05-19 10:00:31', '2022-05-22 15:23:14'),
(47, 0, '0', 12, 10, 'bbbbbbbbbbbbbbb', '1', 0, NULL, NULL, NULL, 1, '2022-05-19 10:01:37', '2022-05-19 10:01:37'),
(48, 0, '0', 10, 10, 'ban cho biet 1+1=', '1', 0, NULL, NULL, NULL, 1, '2022-05-20 02:35:37', '2022-05-20 02:35:37'),
(51, 6, '0', 10, 10, 'fakflaflalfkanfa', '1', 0, NULL, NULL, NULL, 1, '2022-05-22 16:29:58', '2022-05-26 09:46:15'),
(52, 6, '0', 10, 10, 'sfafafafaf', '1', 0, NULL, NULL, NULL, 1, '2022-05-22 16:32:24', '2022-05-26 10:04:44'),
(53, 0, '0,6', 10, 10, 'tttttttttttt', '1', 1, NULL, NULL, NULL, 1, '2022-05-23 09:59:57', '2022-05-27 04:10:21'),
(54, 0, '0,6,14', 10, 10, 'kkkkkkkkkkk', '1', 1, NULL, NULL, NULL, 1, '2022-05-23 16:20:33', '2022-05-27 04:16:21'),
(55, 0, '0,6', 10, 10, 'fsdfsgsgfhdhd', '1', 1, NULL, NULL, NULL, 1, '2022-05-23 16:21:08', '2022-05-27 04:10:21'),
(56, 0, '0,6', 10, 10, 'ppppppppppp', '1', 1, NULL, NULL, NULL, 1, '2022-05-23 16:34:24', '2022-05-27 04:10:21'),
(57, 0, '0,14', 10, 10, 'ffdfsfd', '1', 2, NULL, NULL, NULL, 1, '2022-05-23 16:35:08', '2022-05-27 04:16:21'),
(58, 0, '0,14', 10, 10, 'opupop', '1', 2, NULL, NULL, NULL, 1, '2022-05-23 16:35:33', '2022-05-27 04:16:21'),
(59, 0, '0', 10, 10, 'gfgddd', '1', 2, NULL, NULL, NULL, 1, '2022-05-23 16:36:01', '2022-05-24 03:48:01'),
(60, 0, '0,14', 10, 10, 'rrrrrrrrrrrr', '1', 2, NULL, NULL, NULL, 1, '2022-05-24 03:43:58', '2022-05-27 04:16:21'),
(61, 0, '0,6,14', 10, 10, '1+1=?', '1', 1, NULL, NULL, 0.5, 1, '2022-05-25 08:11:45', '2022-05-27 04:16:21'),
(62, 0, '0,6', 10, 10, '2+3=?', '1', 1, NULL, NULL, NULL, 1, '2022-05-25 08:11:47', '2022-05-27 04:10:21'),
(65, 0, '0', 10, 10, '1+1=?', '1', 1, NULL, NULL, 0.5, 1, '2022-06-08 04:06:46', '2022-06-08 04:06:46'),
(66, 0, '0', 10, 10, '2+3=?', '1', 1, NULL, NULL, NULL, 1, '2022-06-08 04:06:46', '2022-06-08 04:06:46'),
(69, 6, '0', 10, 10, 'cau nhieu dap an', '1', 0, NULL, NULL, NULL, 1, '2022-06-08 15:31:47', '2022-06-08 15:31:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `results`
--

CREATE TABLE `results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `score` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `time` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `results`
--

INSERT INTO `results` (`id`, `exam_id`, `student_id`, `class_id`, `subject_id`, `score`, `created_at`, `time`, `updated_at`) VALUES
(37, 6, 20, 6, 10, '3.42', '2022-06-07 16:34:45', '2022-06-07 23:34:45', '2022-06-07 16:34:45'),
(40, 6, 20, 6, 10, '4.88', '2022-06-07 16:49:48', '2022-06-07 23:49:48', '2022-06-07 16:49:48'),
(47, 6, 20, 6, 10, '1.86', '2022-06-11 15:35:45', '2022-06-11 22:35:45', '2022-06-11 15:35:45'),
(48, 9, 20, 6, 10, '0', '2022-06-11 15:48:49', '2022-06-02', '2022-06-11 15:48:49'),
(49, 14, 20, 6, 10, '0', '2022-06-11 15:49:48', '2022-05-31', '2022-06-11 15:49:48'),
(52, 6, 20, 6, 10, '1.18', '2022-06-12 10:33:16', '2022-06-12 17:33:16', '2022-06-12 10:33:16'),
(53, 9, 20, 6, 10, '0', '2022-06-15 17:22:24', '2022-06-02', '2022-06-15 17:22:24'),
(54, 9, 40, 6, 10, '0', '2022-06-15 17:22:24', '2022-06-02', '2022-06-15 17:22:24'),
(55, 9, 53, 6, 10, '0', '2022-06-15 17:22:24', '2022-06-02', '2022-06-15 17:22:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `result_answer_exam`
--

CREATE TABLE `result_answer_exam` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `result_id` int(11) DEFAULT NULL,
  `score_answer` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `result_answer_exam`
--

INSERT INTO `result_answer_exam` (`id`, `result_id`, `score_answer`, `created_at`, `updated_at`) VALUES
(72, 37, 0, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(73, 37, 0.5, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(74, 37, 0, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(75, 37, 0, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(76, 37, 0.73, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(77, 37, 0.73, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(78, 37, 0, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(79, 37, 0.73, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(80, 37, 0, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(81, 37, 0, '2022-06-07 16:34:47', '2022-06-07 16:34:47'),
(82, 37, 0, '2022-06-07 16:34:48', '2022-06-07 16:34:48'),
(83, 37, 0, '2022-06-07 16:34:48', '2022-06-07 16:34:48'),
(84, 37, 0, '2022-06-07 16:34:48', '2022-06-07 16:34:48'),
(85, 37, 0.73, '2022-06-07 16:34:48', '2022-06-07 16:34:48'),
(114, 40, 0.73, '2022-06-07 16:49:48', '2022-06-07 16:49:48'),
(115, 40, 0.73, '2022-06-07 16:49:48', '2022-06-07 16:49:48'),
(116, 40, 0.73, '2022-06-07 16:49:48', '2022-06-07 16:49:48'),
(117, 40, 0.73, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(118, 40, 0, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(119, 40, 0.73, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(120, 40, 0, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(121, 40, 0, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(122, 40, 0.73, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(123, 40, 0, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(124, 40, 0.5, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(125, 40, 0, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(126, 40, 0, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(127, 40, 0, '2022-06-07 16:49:49', '2022-06-07 16:49:49'),
(163, 47, 0, '2022-06-11 15:35:46', '2022-06-11 15:35:46'),
(164, 47, 0.68, '2022-06-11 15:35:47', '2022-06-11 15:35:47'),
(165, 47, 0.5, '2022-06-11 15:35:47', '2022-06-11 15:35:47'),
(166, 47, 0, '2022-06-11 15:35:47', '2022-06-11 15:35:47'),
(167, 47, 0, '2022-06-11 15:35:48', '2022-06-11 15:35:48'),
(168, 47, 0, '2022-06-11 15:35:48', '2022-06-11 15:35:48'),
(169, 47, 0.68, '2022-06-11 15:35:51', '2022-06-11 15:35:51'),
(170, 47, 0, '2022-06-11 15:35:51', '2022-06-11 15:35:51'),
(171, 47, 0, '2022-06-11 15:35:51', '2022-06-11 15:35:51'),
(172, 47, 0, '2022-06-11 15:35:52', '2022-06-11 15:35:52'),
(173, 47, 0, '2022-06-11 15:35:52', '2022-06-11 15:35:52'),
(174, 47, 0, '2022-06-11 15:35:52', '2022-06-11 15:35:52'),
(175, 47, 0, '2022-06-11 15:35:52', '2022-06-11 15:35:52'),
(176, 47, 0, '2022-06-11 15:35:52', '2022-06-11 15:35:52'),
(177, 47, 0, '2022-06-11 15:35:53', '2022-06-11 15:35:53'),
(178, 52, 0, '2022-06-12 10:33:18', '2022-06-12 10:33:18'),
(179, 52, 0.5, '2022-06-12 10:33:18', '2022-06-12 10:33:18'),
(180, 52, 0, '2022-06-12 10:33:18', '2022-06-12 10:33:18'),
(181, 52, 0.68, '2022-06-12 10:33:18', '2022-06-12 10:33:18'),
(182, 52, 0, '2022-06-12 10:33:18', '2022-06-12 10:33:18'),
(183, 52, 0, '2022-06-12 10:33:18', '2022-06-12 10:33:18'),
(184, 52, 0, '2022-06-12 10:33:19', '2022-06-12 10:33:19'),
(185, 52, 0, '2022-06-12 10:33:19', '2022-06-12 10:33:19'),
(186, 52, 0, '2022-06-12 10:33:19', '2022-06-12 10:33:19'),
(187, 52, 0, '2022-06-12 10:33:19', '2022-06-12 10:33:19'),
(188, 52, 0, '2022-06-12 10:33:19', '2022-06-12 10:33:19'),
(189, 52, 0, '2022-06-12 10:33:19', '2022-06-12 10:33:19'),
(190, 52, 0, '2022-06-12 10:33:19', '2022-06-12 10:33:19'),
(191, 52, 0, '2022-06-12 10:33:19', '2022-06-12 10:33:19'),
(192, 52, 0, '2022-06-12 10:33:19', '2022-06-12 10:33:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `result_merger`
--

CREATE TABLE `result_merger` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `score` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `result_merger`
--

INSERT INTO `result_merger` (`id`, `exam_id`, `subject_id`, `class_id`, `student_id`, `score`, `created_at`, `updated_at`) VALUES
(1, 6, 10, 6, 20, '3.42,4.88,1.86,1.18', '2022-06-07 16:34:46', '2022-06-12 10:33:17'),
(4, 9, 10, 6, 20, '0', '2022-06-15 17:22:24', '2022-06-15 17:22:24'),
(5, 9, 10, 6, 40, '0', '2022-06-15 17:22:24', '2022-06-15 17:22:24'),
(6, 9, 10, 6, 53, '0', '2022-06-15 17:22:24', '2022-06-15 17:22:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_code` bigint(20) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `year_admission` datetime DEFAULT NULL,
  `year` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_day` datetime DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `students`
--

INSERT INTO `students` (`id`, `name`, `student_code`, `password`, `grade_id`, `mobile`, `image`, `class_id`, `year_admission`, `year`, `birth_day`, `address`, `sex`, `status`, `created_at`, `updated_at`) VALUES
(18, 'Nguyễn Đức Long', 2022001, '$2y$10$JrN6AI/JeftYwBmBEBBbr.3t8cwtsKe0MEbu8DK1Heu2YLsc4BbLa', 1, '12345', 'imgstudent/1654015419.jpg', 5, '2022-05-12 00:00:00', '2022', NULL, NULL, NULL, 1, '2022-05-12 15:11:59', '2022-05-31 16:43:39'),
(20, 'Nguyễn Tất Tám', 2022003, '$2y$10$m2Anh0qwIQd7S.64o.jY5uJA3pnpnxwkEZqQIdg1B.knOtD/UPHym', 1, '345', 'imgstudent/1652410921.jpg', 6, '2022-05-12 00:00:00', '2022', NULL, NULL, NULL, 1, '2022-05-12 15:13:08', '2022-05-13 03:02:01'),
(40, 'Hoàng Quí Thành', 2022004, '$2y$10$y6J/a2o4YBqMJ2A9ITatZuzPl2vMQhyYDP9Aadq1bStohJ0SpN8Bi', 1, '987', 'imgstudent/1653039266.258555895_386970326517721_2180826541852369119_n.jpg', 6, '2022-03-02 00:00:00', '2022', '2000-07-06 00:00:00', 'fdfadfafadf', 1, 1, '2022-05-20 09:34:26', '2022-05-21 03:33:30'),
(51, 'Fasfasf', 2023001, '$2y$10$FPdHrkr61yfEdkEGkcBDceLHEc2GpecfLV385SBkG88EZsGjO4iAm', 1, NULL, NULL, 5, '2023-06-06 00:00:00', '2023', '2022-06-06 00:00:00', 'fsafa', 1, 1, '2022-06-06 16:15:02', '2022-06-06 16:15:03'),
(53, 'Hoàng Quí Thành', 2022005, '$2y$10$r8vErdkWKaI36..Fl.967eL6rJJoF9rtdZ34WbqRhq5.ak083n662', 1, '987', 'imgstudent/1654532974.258555895_386970326517721_2180826541852369119_n.jpg', 6, '2022-03-02 00:00:00', '2022', '2022-06-07 00:00:00', 'afasfasfa', 1, 1, '2022-06-06 16:29:34', '2022-06-06 16:29:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `subjects`
--

INSERT INTO `subjects` (`id`, `grade_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(10, '1,2,4', 'toan', 1, '2022-03-03 15:45:34', '2022-06-11 16:05:42'),
(11, '1,2,4', 'ly', 1, '2022-03-03 15:46:03', '2022-05-07 16:11:08'),
(12, '1,2,4', 'hoa', 1, '2022-03-03 15:49:31', '2022-05-07 16:11:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `units`
--

INSERT INTO `units` (`id`, `name`, `grade_id`, `subject_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'chuong 1', 1, 10, 1, '2022-05-23 09:05:49', '2022-05-25 09:48:48'),
(2, 'chuong 2', 1, 10, 1, '2022-05-23 09:09:12', '2022-05-25 09:48:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `check_login_exam`
--
ALTER TABLE `check_login_exam`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `result_answer_exam`
--
ALTER TABLE `result_answer_exam`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `result_merger`
--
ALTER TABLE `result_merger`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `answer`
--
ALTER TABLE `answer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT cho bảng `check_login_exam`
--
ALTER TABLE `check_login_exam`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT cho bảng `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `result_answer_exam`
--
ALTER TABLE `result_answer_exam`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT cho bảng `result_merger`
--
ALTER TABLE `result_merger`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
