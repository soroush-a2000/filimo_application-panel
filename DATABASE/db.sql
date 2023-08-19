-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 03, 2021 at 12:09 AM
-- Server version: 5.7.31-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codegrap_flix2`
--

-- --------------------------------------------------------

--
-- Table structure for table `actor_table`
--

CREATE TABLE `actor_table` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `born` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `height` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bio` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `actor_table`
--

INSERT INTO `actor_table` (`id`, `media_id`, `name`, `born`, `height`, `bio`) VALUES
(28, 453, 'اسکارلت جوهانسون', 'آمریکا', '1980', 'درباره'),
(29, 479, 'دوئین جانسون', 'آمریکا', '1980', 'درباره'),
(30, 480, 'میشل رودریگز', 'آمریکا', '1980', 'درباره'),
(31, 481, 'زک افران', 'آمریکا', '1980', 'درباره'),
(32, 482, 'الکساندرا داداریو', 'آمریکا', '1980', 'درباره');

-- --------------------------------------------------------

--
-- Table structure for table `category_table`
--

CREATE TABLE `category_table` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category_table`
--

INSERT INTO `category_table` (`id`, `media_id`, `title`, `position`) VALUES
(17, NULL, 'تلویزیون ایران', 1),
(18, NULL, 'استانی', 2),
(19, NULL, 'برون مرزی', 4),
(20, NULL, 'ترکیه', 3),
(21, NULL, 'کوردی', 5),
(22, NULL, 'ورزشی', 6),
(23, NULL, 'رادیو', 7);

-- --------------------------------------------------------

--
-- Table structure for table `channels_categories`
--

CREATE TABLE `channels_categories` (
  `channel_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `channels_categories`
--

INSERT INTO `channels_categories` (`channel_id`, `category_id`) VALUES
(4, 17),
(7, 22),
(8, 17),
(9, 17),
(10, 17);

-- --------------------------------------------------------

--
-- Table structure for table `channel_table`
--

CREATE TABLE `channel_table` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `tags` longtext COLLATE utf8_unicode_ci,
  `rating` double NOT NULL,
  `classification` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `views` int(11) NOT NULL,
  `shares` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `playas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `channel_table`
--

INSERT INTO `channel_table` (`id`, `media_id`, `title`, `description`, `tags`, `rating`, `classification`, `country_id`, `website`, `views`, `shares`, `created`, `enabled`, `featured`, `playas`, `comment`) VALUES
(4, 417, 'شبکه سوم سیما', 'شبکه سوم', NULL, 0, '+3', 86, NULL, 55, 0, '2020-11-16 10:59:44', 1, 0, '1', 0),
(7, 416, 'ورزش', NULL, NULL, 0, NULL, NULL, NULL, 1, 1, '2021-06-17 18:58:57', 1, 0, '2', 0),
(8, 415, 'مستند', NULL, NULL, 0, NULL, NULL, NULL, 5, 0, '2021-06-17 18:59:44', 1, 0, '1', 0),
(9, 414, 'شبکه دو سیما', NULL, NULL, 0, NULL, NULL, NULL, 2, 1, '2021-06-17 19:00:20', 1, 0, '1', 0),
(10, 413, 'شبکه یک سیما', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', NULL, 0, '18+', 86, 'https://jas.com', 24, 0, '2021-06-17 19:01:10', 1, 0, '3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comment_table`
--

CREATE TABLE `comment_table` (
  `id` int(11) NOT NULL,
  `poster_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comment_table`
--

INSERT INTO `comment_table` (`id`, `poster_id`, `channel_id`, `user_id`, `content`, `created`, `enabled`) VALUES
(1, 28, NULL, 18, '2LnYp9mE24w=\n', '2020-11-25 14:58:42', 0),
(2, 31, NULL, 21, '2YbYuNixINiq2LPYqiA=\n', '2021-06-11 13:10:54', 0),
(3, 39, NULL, 22, '2K7ZiNio2Yc=\n', '2021-07-04 15:02:52', 0),
(4, 48, NULL, 22, '2LPZhNin2YUg2K7ZiNio2Yc=\n', '2021-07-12 00:09:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `country_table`
--

CREATE TABLE `country_table` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `country_table`
--

INSERT INTO `country_table` (`id`, `media_id`, `title`) VALUES
(8, 27, 'ارمنستان'),
(9, 28, 'آنگولا'),
(10, 29, 'آرژانتین'),
(11, 30, 'اتریش'),
(12, 31, 'استرالیا'),
(13, 32, 'جمهوری آذربایجان'),
(14, 33, 'بوسنی و هرزگوین'),
(15, 34, 'باربادوس'),
(16, 35, 'بنگلادش'),
(17, 36, 'بلژیک'),
(18, 37, 'بورکینافاسو'),
(19, 38, 'بلغارستان'),
(20, 39, 'بحرین'),
(21, 40, 'بوروندی'),
(22, 41, 'بنین'),
(23, 42, 'برونئی'),
(24, 43, 'بولیوی'),
(25, 44, 'برزیل'),
(26, 45, 'باهاما'),
(27, 46, 'پادشاهی بوتان'),
(28, 47, 'بوتسوانا'),
(29, 48, 'بلاروس'),
(30, 49, 'بلیز'),
(31, 50, 'کانادا'),
(32, 51, 'جمهوری دموکراتیک کنگو'),
(33, 52, 'جمهوری آفریقای مرکزی'),
(34, 53, 'جمهوری کنگو'),
(35, 54, 'سوئیس'),
(36, 55, 'ساحل عاج'),
(37, 56, 'جزایر کوک'),
(38, 57, 'شیلی'),
(39, 58, 'کامرون'),
(40, 59, 'چین'),
(41, 60, 'کلمبیا'),
(42, 61, 'کاستاریکا'),
(43, 62, 'کوبا'),
(44, 63, 'کیپ ورد'),
(45, 64, 'قبرس'),
(46, 65, 'جمهوری چک'),
(47, 66, 'آلمان'),
(48, 67, 'جیبوتی'),
(49, 68, 'دانمارک'),
(50, 69, 'دومینیکا'),
(51, 70, 'جمهوری دومینیکن'),
(52, 71, 'الجزایر'),
(53, 72, 'اکوادور'),
(54, 73, 'استونی'),
(55, 74, 'مصر'),
(56, 75, 'صحرای غربی'),
(57, 76, 'اریتره'),
(58, 77, 'اسپانیا'),
(59, 78, 'اتیوپی'),
(60, 79, 'فنلاند'),
(61, 80, 'فیجی'),
(62, 81, 'ایالات فدرال میکرونزی'),
(63, 82, 'فرانسه'),
(64, 83, 'گابون'),
(65, 84, 'بریتانیا'),
(66, 85, 'گرنادا'),
(67, 86, 'گرجستان'),
(68, 87, 'غنا'),
(69, 88, 'گامبیا'),
(70, 89, 'گینه'),
(72, 91, 'گینه استوایی'),
(73, 92, 'یونان'),
(74, 93, 'گواتمالا'),
(75, 94, 'گینه بیسائو'),
(76, 95, 'گویان'),
(77, 96, 'هندوراس'),
(78, 97, 'کرواسی'),
(79, 98, 'هائیتی'),
(80, 99, 'مجارستان'),
(81, 100, 'اندونزی'),
(82, 101, 'جمهوری ایرلند'),
(83, 102, 'اسرائیل'),
(84, 103, 'هند'),
(85, 104, 'عراق'),
(86, 105, 'ایران'),
(87, 106, 'ایسلند'),
(88, 107, 'ایتالیا'),
(89, 108, 'جامائیکا'),
(90, 109, 'اردن'),
(91, 110, 'ژاپن'),
(92, 111, 'کنیا'),
(93, 112, 'قرقیزستان'),
(94, 113, 'کامبوج'),
(95, 114, 'کیریباتی'),
(96, 115, 'مجمع‌الجزایر قمر'),
(97, 116, 'سنت کیتس و نویس'),
(98, 117, 'کره شمالی'),
(99, 118, 'کره جنوبی'),
(100, 119, 'کویت'),
(101, 120, 'قزاقستان'),
(102, 121, 'لائوس'),
(103, 122, 'لبنان'),
(104, 123, 'سنت لوسیا'),
(105, 124, 'لیختن‌اشتاین'),
(106, 125, 'سری‌لانکا'),
(107, 126, 'لیبریا'),
(108, 127, 'لسوتو'),
(109, 128, 'لیتوانی'),
(110, 129, 'لوکزامبورگ'),
(111, 130, 'لتونی'),
(112, 131, 'لیبی'),
(113, 132, 'مراکش'),
(114, 133, 'موناکو'),
(115, 134, 'مولداوی'),
(116, 135, 'مونته‌نگرو'),
(117, 136, 'ماداگاسکار'),
(118, 137, 'جزایر مارشال'),
(119, 138, 'مقدونیه شمالی'),
(120, 139, 'مالی'),
(121, 140, 'میانمار'),
(122, 141, 'مغولستان'),
(123, 142, 'موریتانی'),
(124, 143, 'مالت'),
(125, 144, 'موریس'),
(126, 145, 'مالدیو'),
(128, 147, 'مالاوی'),
(129, 148, 'مکزیک'),
(130, 149, 'مالزی'),
(131, 150, 'موزامبیک'),
(132, 151, 'نامیبیا'),
(133, 152, 'نیجر'),
(134, 153, 'نیجریه'),
(135, 154, 'نیکاراگوئه'),
(136, 155, 'هلند'),
(137, 156, 'نروژ'),
(138, 157, 'نپال'),
(139, 158, 'نائورو'),
(140, 159, 'نیووی'),
(141, 160, 'نیوزیلند'),
(142, 161, 'عمان'),
(143, 162, 'پاناما'),
(144, 163, 'پرو'),
(145, 164, 'پاپوآ گینهٔ نو'),
(146, 165, 'فیلیپین'),
(147, 166, 'پاکستان'),
(148, 167, 'لهستان'),
(149, 168, 'فلسطین'),
(150, 169, 'پرتغال'),
(151, 170, 'پالائو'),
(152, 171, 'پاراگوئه'),
(153, 172, 'قطر'),
(154, 173, 'رومانی'),
(155, 174, 'صربستان'),
(156, 175, 'روسیه'),
(157, 176, 'رواندا'),
(158, 177, 'عربستان سعودی'),
(159, 178, 'جزایر سلیمان'),
(160, 179, 'سیشل'),
(161, 180, 'سودان'),
(162, 181, 'سوئد'),
(163, 182, 'سنگاپور'),
(164, 183, 'اسلوونی'),
(165, 184, 'اسلواکی'),
(166, 185, 'سیرالئون'),
(167, 186, 'سن مارینو'),
(168, 187, 'سنگال'),
(169, 188, 'سومالی'),
(170, 189, 'سورینام'),
(171, 190, 'سائوتومه و پرینسیپ'),
(172, 191, 'اتحاد جماهیر شوروی سوسیالیستی'),
(173, 192, 'السالوادور'),
(174, 193, 'سوریه'),
(175, 194, 'اسواتینی'),
(176, 195, 'چاد'),
(177, 196, 'توگو'),
(178, 197, 'تایلند'),
(179, 198, 'تاجیکستان'),
(180, 199, 'تیمور شرقی'),
(181, 200, 'ترکمنستان'),
(182, 201, 'تونس'),
(183, 202, 'تونگا'),
(184, 203, 'ترکیه'),
(185, 204, 'ترینیداد و توباگو'),
(186, 205, 'تووالو'),
(187, 206, 'تایوان'),
(188, 207, 'تانزانیا'),
(189, 208, 'اوکراین'),
(190, 209, 'اوگاندا'),
(191, 210, 'آمریکا'),
(192, 211, 'اروگوئه'),
(193, 212, 'ازبکستان'),
(194, 213, 'واتیکان'),
(195, 214, 'سنت وینسنت و گرنادین‌ها'),
(196, 215, 'ونزوئلا'),
(197, 216, 'ویتنام'),
(198, 217, 'وانواتو'),
(199, 218, 'ساموآ'),
(200, 219, 'یمن'),
(201, 220, 'آفریقای جنوبی'),
(202, 221, 'زامبیا'),
(203, 222, 'زیمبابوه'),
(204, 223, 'ولز');

-- --------------------------------------------------------

--
-- Table structure for table `device_table`
--

CREATE TABLE `device_table` (
  `id` int(11) NOT NULL,
  `token` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `episode_table`
--

CREATE TABLE `episode_table` (
  `id` int(11) NOT NULL,
  `season_id` int(11) DEFAULT NULL,
  `thumbnail_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `duration` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `playas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `downloadas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `downloads` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `episode_table`
--

INSERT INTO `episode_table` (`id`, `season_id`, `thumbnail_id`, `media_id`, `title`, `description`, `duration`, `playas`, `downloadas`, `enabled`, `position`, `downloads`, `views`, `created`) VALUES
(2, 2, NULL, 370, 'قسمت اول', 'به گزارش خبرنگار فرهنگی باشگاه خبرنگاران پویا،', '60 دقیقه', '3', '3', 1, 1, 0, 19, '2020-11-16 10:58:17'),
(3, 3, NULL, NULL, 'قسمت اول', NULL, NULL, '1', '1', 1, 1, 0, 0, '2021-06-07 19:32:05'),
(4, 2, NULL, NULL, 'قسمت دوم', NULL, NULL, '1', '1', 1, 2, 0, 0, '2021-06-07 19:37:36'),
(5, 2, NULL, NULL, 'قسمت دوم', NULL, NULL, '1', '1', 1, 3, 0, 0, '2021-06-07 19:37:56'),
(6, 2, NULL, NULL, 'قسمت چهارم', NULL, NULL, '1', '1', 1, 4, 0, 0, '2021-06-07 19:38:13'),
(7, 6, NULL, 386, 'قسمت اول', NULL, NULL, '1', '1', 1, 1, 0, 12, '2021-06-09 21:24:01'),
(8, 6, NULL, NULL, 'قسمت دوم', NULL, NULL, '1', '1', 1, 2, 0, 0, '2021-06-09 21:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `fos_user_table`
--

CREATE TABLE `fos_user_table` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reset_password` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_status` tinyint(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` longtext COLLATE utf8_unicode_ci,
  `purchase_token` longtext COLLATE utf8_unicode_ci,
  `subscribe_days` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fos_user_table`
--

INSERT INTO `fos_user_table` (`id`, `media_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `reset_password`, `reset_password_status`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `name`, `type`, `token`, `purchase_token`, `subscribe_days`, `purchase_date`) VALUES
(1, NULL, 'ADMIN', 'admin', 'ADMIN', 'admin', 1, 'djtfgbufxr4gwk4k0gss4sgs4k48wc4', '$2y$13$djtfgbufxr4gwk4k0gss4ekodAwfJ3IP01OyKvMD.stoxgr6MMa2S', NULL, 0, '2021-08-02 23:10:35', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 0, NULL, 'Video Status', 'email', NULL, NULL, NULL, NULL),
(16, 372, '09378155323', '09378155323', '09378155323', '09378155323', 1, 'cd4q1zznjgo4ww4ws0skcggcw8c8ccg', '$2y$13$cd4q1zznjgo4ww4ws0skceHSozb0FIj6UvWzeSGLVYkF8VVzqVWtW', 'zv0ms3m6', 1, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'u_161512', 'phone', NULL, NULL, '10', '2021-06-12 10:37:33'),
(17, 373, '09362155652', '09362155652', '09362155652', '09362155652', 1, 'iz3uy52wz0o4cc0s4s4c4808w0ko4wc', '$2y$13$iz3uy52wz0o4cc0s4s4c4u8J18UX2HkWbQdnwGpSnqbv7u8Vp0CMi', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'u_179945', 'phone', NULL, NULL, NULL, NULL),
(18, 375, '09394529096', '09394529096', '09394529096', '09394529096', 1, '5dt9k9am998gkokcgwww8gk4c0w4cck', '$2y$13$5dt9k9am998gkokcgwww8eX/8HFzTq1flU6LHoEvRcEGfHieLMxw.', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'حمید', 'phone', NULL, NULL, NULL, NULL),
(19, 377, '09931619570', '09931619570', '09931619570', '09931619570', 1, 'reudhwye0z4skccgogc8oogoso0400w', '$2y$13$reudhwye0z4skccgogc8oed.h1t/SsbMQnMa3yogwdkcKwEoq4Jvy', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'u_195913', 'phone', 'pid_e504-c0ce-3f', NULL, '10', '2021-07-25 00:16:39'),
(21, 388, '09192973085', '09192973085', '09192973085', '09192973085', 1, 'k99bazn5sm8g0gks0co80ssks4oow0s', '$2y$13$k99bazn5sm8g0gks0co80exBvj5DvTxuCyQbOpp9OQuWWPAaQ6L4i', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'u_218781', 'phone', 'pid_e297-c4a8-31', NULL, NULL, NULL),
(22, 430, '09023900530', '09023900530', '09023900530', '09023900530', 1, 'h15ch7o0jxck08kw8socgsccwgwwoso', '$2y$13$h15ch7o0jxck08kw8socgeuDQIkuWvqOZSZkxSoU.Gk3YY3Xwlh4G', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'u_223974', 'phone', 'pid_485a-27ed-32', NULL, NULL, NULL),
(23, 431, '09032740352', '09032740352', '09032740352', '09032740352', 1, 'gpggyfkalr4kgsc8cc8sss4so4gccso', '$2y$13$gpggyfkalr4kgsc8cc8ssej05iQq/PfsWQIXGJ0RRbPvay.u.qa7S', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'Pouyazamani', 'phone', 'pid_b2ba-4cf6-3e', NULL, '0', '2021-08-03 00:08:02'),
(24, 445, '09193810454', '09193810454', '09193810454', '09193810454', 1, 'qs7kiu8xfc0ksk0gcsg4s8goo4448oc', '$2y$13$qs7kiu8xfc0ksk0gcsg4su6xUHUH.p0fh86xX8wQPfUJkcCka4J1C', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'u_247433', 'phone', 'pid_b092-6e75-34', NULL, NULL, NULL),
(25, 467, '9054924564', '9054924564', '9054924564', '9054924564', 1, 'h9p4tchtmnwcwocco80ws4gssg00o8c', '$2y$13$h9p4tchtmnwcwocco80wsuhohjpOvdHle3H2ScruS40mZK0eJfw9O', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'u_258703', 'phone', 'pid_33c5-9e9b-36', NULL, NULL, NULL),
(26, 468, '09180606351', '09180606351', '09180606351', '09180606351', 1, 'cchxtiqkb8gks08owscs08og8kskgcg', '$2y$13$cchxtiqkb8gks08owscs0uNjx8dpGCmCHvSZTCWPFQDP2G4zx1LbC', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'u_268306', 'phone', 'pid_978f-26fd-39', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_table`
--

CREATE TABLE `gallery_table` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre_table`
--

CREATE TABLE `genre_table` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `genre_table`
--

INSERT INTO `genre_table` (`id`, `title`, `position`) VALUES
(7, 'اکشن', 1),
(8, 'انیمیشن', 2),
(9, 'تاریخی', 3),
(10, 'ترسناک', 4),
(11, 'جنایی', 5),
(12, 'جنگی', 6),
(13, 'خانوادگی', 7),
(14, 'درام', 8),
(15, 'زندگی نامه', 9),
(16, 'علمی - تخیلی', 10),
(17, 'فانتزی', 11),
(18, 'کمدی', 12),
(19, 'کوتاه', 13),
(20, 'ماجراجویی', 14),
(21, 'مستند', 15),
(22, 'معمایی', 16),
(23, 'موزیکال', 17),
(24, 'موسیقی', 18),
(26, 'هندی', 19),
(27, 'هیجان انگیز', 20),
(28, 'ورزشی', 21);

-- --------------------------------------------------------

--
-- Table structure for table `language_table`
--

CREATE TABLE `language_table` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medias_gallerys_table`
--

CREATE TABLE `medias_gallerys_table` (
  `gallery_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_table`
--

CREATE TABLE `media_table` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `media_table`
--

INSERT INTO `media_table` (`id`, `titre`, `url`, `type`, `extension`, `date`, `enabled`) VALUES
(1, 'Untitled-1.png', 'd218853ef5171de13e677b8b51dd63e6.png', 'image/png', 'png', '2019-11-19 22:21:00', 1),
(27, 'am.jpg', 'ebb6a4e1d7a2d92c1f6e1e30281766f9.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:18:42', 1),
(28, 'ao.jpg', 'b30eb01d1d2233a78adeca8321e6e97f.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:19:13', 1),
(29, 'ar.jpg', 'c967777396ad0acbaf347371617846f4.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:19:54', 1),
(30, 'at.jpg', '25a96c1d83e3b503be8affc6b51b965a.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:20:42', 1),
(31, 'au.jpg', '7ded166dab33b187ead080f0224a8060.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:21:11', 1),
(32, 'az.jpg', '499a58018f56a7643466dd9c0f1f65c0.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:21:37', 1),
(33, 'ba.jpg', '0c2b64da20e7e860d82a22d6868615ab.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:22:00', 1),
(34, 'bb.jpg', 'a82c2717f2a52c3f7260783510553603.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:22:27', 1),
(35, 'bd.jpg', 'd57ba3274024d95984ab9df7be42389e.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:23:06', 1),
(36, 'be.jpg', 'd7111bd3f62db34cba8adba5adcf034f.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:23:33', 1),
(37, 'bf.jpg', 'b42d7ac68b408498211a75c9bda60361.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:24:04', 1),
(38, 'bg.jpg', '7db921333d6c8a196fa093731c4b28d4.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:25:27', 1),
(39, 'bh.jpg', '7e675f3eb0b98f500da605814d2eecc2.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:25:51', 1),
(40, 'bi.jpg', 'd4fa491fba98837557c6f13ddc8fe482.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:26:22', 1),
(41, 'bj.jpg', '3d0c2688b2c7cf963d2c7a601010f057.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:26:42', 1),
(42, 'bn.jpg', 'e8601f36695294f5ddadf37edd33e735.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:27:14', 1),
(43, 'bo.jpg', 'e82da095230e7df4599bb9e658fa7f93.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:34:14', 1),
(44, 'br.jpg', '197535a84eee78ae12036a02db982850.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:34:24', 1),
(45, 'bs.jpg', '179f36b0974ff80e0e05dfe5edc483db.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:34:49', 1),
(46, 'bt.jpg', 'e053bf567959c6471b345757e65eadea.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:35:11', 1),
(47, 'bw.jpg', 'cdc5d69f1025d85650e64334743bfcc7.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:35:40', 1),
(48, 'by.jpg', '1dde64cb42d64952183d4ffbd7108563.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:36:06', 1),
(49, 'bz.jpg', 'f7e2422e4f5e6fc4bec555aeba674c20.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:36:31', 1),
(50, 'ca.jpg', 'a986ada483cf718ed56199a7fdaed394.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:36:53', 1),
(51, 'cd.jpg', '587898272325028657b2ff411a5eeee2.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:37:27', 1),
(52, 'cf.jpg', 'd29ddc23d63ae1bf7d36c048fb2ad49a.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:37:51', 1),
(53, 'cg.jpg', 'de3fb1867c651c04c0ce68e30cac4a34.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:38:19', 1),
(54, 'ch.jpg', 'b8e2101ec45666d71979b17d9c1c0742.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:38:46', 1),
(55, 'ci.jpg', '988d7a734cf6af47b9d313d1e31f7665.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:39:19', 1),
(56, 'ck.jpg', 'f60bbeeaaeac37fb66754e429e250c48.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:40:22', 1),
(57, 'cl.jpg', 'bb1849675e207d792ec84cdb446dd3e2.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:40:37', 1),
(58, 'cm.jpg', '471c7f258e82640a9ce1d110eb05aea1.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:41:10', 1),
(59, 'cn.jpg', 'f4674fb11bef3aa848dd810b0fd8ffb1.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:41:34', 1),
(60, 'co.jpg', '0117ccb02b037f0a89cab9e2c2adfe3f.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:41:53', 1),
(61, 'cr.jpg', '6f54afcb3592e1168730d50b0216d171.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:42:22', 1),
(62, 'cu.jpg', '866b75be042cba43e0068f2b43335339.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:42:57', 1),
(63, 'cv.jpg', 'f8108b51e3a63966758f3e718b435b7d.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:43:42', 1),
(64, 'cy.jpg', '8ff39c5f0b7d4b314c2c322baaf62378.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:44:31', 1),
(65, 'cz.jpg', 'a1b58f704876e7863c893ea5b2f43c07.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:44:52', 1),
(66, 'de.jpg', '2cee90f26e936392839f42b6eff9a633.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:45:20', 1),
(67, 'dj.jpg', '0f0333ed9ca4ed5551c728ac5e881a6c.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:45:49', 1),
(68, 'dk.jpg', '1bd71006001de4454f63dc940c1d0383.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:46:20', 1),
(69, 'dm.jpg', '9a4ac57b59214eb3184102f4f87ea8e4.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:47:13', 1),
(70, 'do.jpg', '02a0120a259cc91b95aba9c0909e1704.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:47:43', 1),
(71, 'dz.jpg', 'fc99820de7e74ea579d7001c63a77df1.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:48:05', 1),
(72, 'ec.jpg', 'a92b87791f786b468891754283db47a1.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:49:28', 1),
(73, 'ee.jpg', 'e51aa00fb69f80a0b88e41c1a8613e56.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:49:54', 1),
(74, 'eg.jpg', '98cc6561681d0dd41e63f08f6b499a99.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:50:16', 1),
(75, 'eh.jpg', 'e1599de92e2a373c9db065997f8b701e.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:52:04', 1),
(76, 'er.jpg', '3bccfe2b4b16a1713bfe90a974606501.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:52:28', 1),
(77, 'es.jpg', '26749cbd5829d5596cab809ab875af69.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:52:49', 1),
(78, 'et.jpg', '2af683c7224ee427ca99bc1b62b491df.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:53:16', 1),
(79, 'fi.jpg', '700f1490dd37a1328321edc968291a2f.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:53:38', 1),
(80, 'fj.jpg', 'f0a1b5d7ca9f0473e5bf1d47a80affe2.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:53:58', 1),
(81, 'fm.jpg', 'a63e009ab48488b071a2d5359ab3f680.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:54:19', 1),
(82, 'fr.jpg', '43ca4db37671753f9866f27005321cd3.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:54:35', 1),
(83, 'ga.jpg', '3c97ea8fd796e9404de97e6cff7f7a82.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:54:57', 1),
(84, 'gb.jpg', '6431745f6f56f351a9473ae313b21f69.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:55:47', 1),
(85, 'gd.jpg', 'f369d57c04efcf5dd294b5e56204c92f.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:56:46', 1),
(86, 'ge.jpg', '04c6a813a5772024241c9d8a79d5cc09.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:57:09', 1),
(87, 'gh.jpg', 'bae5d702530459a4e38a93ae9859e0b8.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:57:33', 1),
(88, 'gm.jpg', '206470a59e4e7362bf4eee0bf77236d8.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:58:16', 1),
(89, 'gn.jpg', '647d2bb23849b348172f8bbb77b0edbd.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:58:54', 1),
(91, 'gq.jpg', '7252fbab55465082c196b4dac80f38af.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:59:35', 1),
(92, 'gr.jpg', 'df6a66e72d5ee418dab0d64c4d4c9d21.jpg', 'image/jpeg', 'jpg', '2020-03-18 16:59:54', 1),
(93, 'gt.jpg', '8a6c513d58db979280bb33a98b82028c.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:00:29', 1),
(94, 'gw.jpg', '1881f98577c79471925a60e8eede3ce7.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:00:48', 1),
(95, 'gy.jpg', '3287ce5910071dad5ceeeed1531c184e.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:01:05', 1),
(96, 'hn.jpg', '76131ec66ddb3b9f5503567d279033bd.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:01:29', 1),
(97, 'hr.jpg', '0ef780637eaf70521502e23f9abdc9a6.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:01:50', 1),
(98, 'ht.jpg', 'cb139cda9e061f4677b425c21b3f355d.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:02:05', 1),
(99, 'hu.jpg', '8ac576a050e26c9a254434163b655977.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:02:28', 1),
(100, 'id.jpg', 'df2402f9e9d06b17b97509cedd1de7bc.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:02:49', 1),
(101, 'ie.jpg', '529ef75e1e50eb7b4b1a46e86dcc5e2b.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:03:37', 1),
(102, 'il.jpg', 'cb8acb7fb8f1ddd0c7cc1cc7cb2e57f7.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:04:00', 1),
(103, 'in.jpg', '48441468cc04990a9a8ea88cda214f2d.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:04:27', 1),
(104, 'iq.jpg', 'd289018e2b9452d8febc174b3d41d83f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:04:35', 1),
(105, 'ir.jpg', 'f4de682e82560982702f60407c92f079.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:04:43', 1),
(106, 'is.jpg', '381eaf8ac50dadbaa8de779a6a5d5450.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:04:59', 1),
(107, 'it.jpg', 'ad5e929f5e1e4ee4a9e227e4f09d9082.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:05:15', 1),
(108, 'jm.jpg', '6863e6d42fe6967fea7965f431e8109f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:05:29', 1),
(109, 'jo.jpg', 'cbe99fef9283ae62f7bfb1226b6051cd.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:05:55', 1),
(110, 'jp.jpg', 'b3d3410f1b0102310038a7f814cf3bd5.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:06:07', 1),
(111, 'ke.jpg', '30bfd1a1c6813761c2e8ea968f1d2ca6.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:06:18', 1),
(112, 'kg.jpg', '26b56274e2ab614f9763e557589b8604.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:06:40', 1),
(113, 'kh.jpg', '09168533ffc504a7c89bd20656500ad5.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:07:39', 1),
(114, 'ki.jpg', '497fd8d1c8d08b5bded99556ed1a9185.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:08:04', 1),
(115, 'km.jpg', 'dac6381834efd580e4e01ab51d1dfc17.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:08:24', 1),
(116, 'kn.jpg', 'b93c712ea0bc4e0721008a45537319bb.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:09:41', 1),
(117, 'kp.jpg', '22931906958fda48b187fd803e7cb0ef.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:10:00', 1),
(118, 'kr.jpg', '483fd9e56b8cc6e13886820d833f1509.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:10:39', 1),
(119, 'kw.jpg', 'e5da988d9436eedbed5a3786fd6e4ede.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:11:06', 1),
(120, 'kz.jpg', '290bd33e98d1a2f3ae0769bba7d58531.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:11:23', 1),
(121, 'la.jpg', 'c03b6280f9d2219d866935e7e7284b8c.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:11:38', 1),
(122, 'lb.jpg', '395559dbb62ebd7286b22cddb9e2aebe.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:11:56', 1),
(123, 'lc.jpg', 'd3f8f0deca9bc71704cefc38d74d121f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:12:19', 1),
(124, 'li.jpg', 'fa7a6cbfecd14ce58b7594a0cf1f9d70.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:12:37', 1),
(125, 'lk.jpg', '61374556b7df021a1fdb30554cf964ea.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:12:54', 1),
(126, 'lr.jpg', '3ec65a8b7742d0ca1272f12d38c7907f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:13:09', 1),
(127, 'ls.jpg', '2a007576e2f6c666e3e4f8eccc140e54.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:13:37', 1),
(128, 'lt.jpg', '24ef482f387338ec05835852407db1db.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:14:17', 1),
(129, 'lu.jpg', '1476c07bda66e32d2326d66408a4f8b9.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:14:30', 1),
(130, 'lv.jpg', 'f1b97c525db8da01fb2df61449f0c468.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:14:47', 1),
(131, 'ly.jpg', 'd5f39197f3db617551f0846601b33fc7.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:15:08', 1),
(132, 'ma.jpg', '112906daea7af8203be63828282e5715.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:15:24', 1),
(133, 'mc.jpg', '1769d2bd342f9e25c5275c78c1b1ddba.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:15:46', 1),
(134, 'md.jpg', 'b2873ada19701b1582e8492bc242a356.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:16:02', 1),
(135, 'me.jpg', 'f196d1bc522e61496db2ae071b9a8891.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:16:42', 1),
(136, 'mg.jpg', '72a0cf6ca505554054b5bce7b41aec3f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:17:04', 1),
(137, 'mh.jpg', '5c92f06f2ffbc387de797c1139e2ef37.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:17:26', 1),
(138, 'mk.jpg', 'b2d4384cb849e68ae036ab1ff53d2218.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:17:59', 1),
(139, 'ml.jpg', '48baa7a30d3ae0f2b9a972eccc32c689.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:18:18', 1),
(140, 'mm.jpg', 'be4dbf4ba1e9411ec750a278b2e5d8b8.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:18:38', 1),
(141, 'mn.jpg', 'fe394a0105362988e97f2114d44c2922.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:18:51', 1),
(142, 'mr.jpg', 'ff220197eb6660bfe093c0fce46f46db.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:19:12', 1),
(143, 'mt.jpg', '14d035c31415fad86658a37b5920295c.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:19:27', 1),
(144, 'mu.jpg', '47830669e5e31d351d1a3ae758082e3f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:19:41', 1),
(145, 'mv.jpg', '068d9d25af987a97c294d752b9625b5e.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:20:01', 1),
(147, 'mw.jpg', '40cedd988bef48bab589ca6fc493392a.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:21:25', 1),
(148, 'mx.jpg', '358944e567e4409850606c1f5437f6da.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:21:37', 1),
(149, 'my.jpg', '547644eae5e97ce1af52fe7ec496b47e.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:21:54', 1),
(150, 'mz.jpg', '53ad7ee680e5bd12673b6a976300263a.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:22:15', 1),
(151, 'na.jpg', '6099a931ddceada3aac53f0bcf77e6b1.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:22:45', 1),
(152, 'ne.jpg', '7bb1425d2b09981ebfdb4d956f706fd8.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:23:16', 1),
(153, 'ng.jpg', '456815cec9ba6103e8416e369b9f1b35.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:23:33', 1),
(154, 'ni.jpg', '0b829dbbaa1e0a4c78aa02f656be2376.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:23:47', 1),
(155, 'nl.jpg', 'fae462b0261cd43038076f843331335b.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:24:08', 1),
(156, 'no.jpg', 'a80a0c7e20331ac7523c6fe5466f5d02.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:24:40', 1),
(157, 'np.jpg', '75522d7da62f611e3cf290854835a48f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:24:59', 1),
(158, 'nr.jpg', '98fd3a8ea86e05898fd3976c892701f7.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:25:14', 1),
(159, 'nu.jpg', 'e3744e771c2f3494b14bf3496f4a2705.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:25:35', 1),
(160, 'nz.jpg', '7efe75028d8fe2910c2608530f5ea3a4.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:26:00', 1),
(161, 'om.jpg', 'ff17d767686be469a70f16018106de0f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:26:20', 1),
(162, 'pa.jpg', 'd8d4556d2a811e9d20394de30eb0d103.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:26:40', 1),
(163, 'pe.jpg', 'ecebb4be02523e9c85ca57fcc7c4aabb.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:26:49', 1),
(164, 'pg.jpg', '2ca021f16551fa3e24afaa18af041ee6.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:27:04', 1),
(165, 'ph.jpg', 'ff372c69cd4833136a6ce34acab5cfdc.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:27:22', 1),
(166, 'pk.jpg', '737354c3029f6e3e66d2fe8cda1e3906.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:27:37', 1),
(167, 'pl.jpg', 'd0db9fcebbdebb37a1c4fa4fb07e9039.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:27:56', 1),
(168, 'ps.jpg', '6a43dc15b22350b33d4e7ae9bab1ca35.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:28:13', 1),
(169, 'pt.jpg', '530100059304bc84f10edec15809bc7b.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:29:31', 1),
(170, 'pw.jpg', 'b871bc4946ced19c81df75fcbafc45b5.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:29:53', 1),
(171, 'py.jpg', '588ab51a0ea7d6270e7eb2939a8a26ad.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:30:09', 1),
(172, 'qa.jpg', 'ec02cf890c8cfd28726d96b96ac525f0.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:30:26', 1),
(173, 'ro.jpg', '13c7fc64461a2e27fd7377f0eee1fc7d.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:30:46', 1),
(174, 'rs.jpg', 'c6489dda3312903d5c7f8f15bbd54b5a.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:31:00', 1),
(175, 'ru.jpg', 'a5f12a008cc79475434ce3b891773aa2.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:31:25', 1),
(176, 'rw.jpg', '3d400b8b0cb60d6a91a40d8d6c712263.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:31:40', 1),
(177, 'sa.jpg', '1d1da8d5fb0b751c18043f743edb27f9.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:32:04', 1),
(178, 'sb.jpg', '6ab066c477af74d32fc4b789ca9c98b4.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:32:18', 1),
(179, 'sc.jpg', 'f4c02188abce5e219f83de307c013ff4.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:33:23', 1),
(180, 'sd.jpg', '41be9fc633a21f90411b8fdc9bdd440a.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:33:38', 1),
(181, 'se.jpg', 'c9e78504ba8770d85be084dcf039b5ff.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:33:57', 1),
(182, 'sg.jpg', 'bed22ea3af11084331ac8de5e5145fd1.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:34:10', 1),
(183, 'si.jpg', 'b37c60dcceda24c8eb68cd7ad530fcee.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:35:00', 1),
(184, 'sk.jpg', 'df3a2e2ba131b9c0045ec21fcb079090.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:35:16', 1),
(185, 'sl.jpg', '6bb4074e74a1ac251cf16e72b1e76c6e.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:35:33', 1),
(186, 'sm.jpg', '9d5037738d322fa26f05b3fad471ec72.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:35:47', 1),
(187, 'sn.jpg', '536eb2e85afd6ec910f78f7e4e911895.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:36:06', 1),
(188, 'so.jpg', 'c923182c924682e3bc1ed4df8fd84b76.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:36:26', 1),
(189, 'sr.jpg', '9f0cd9c2ee39d9ca73230f218e32ca59.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:36:52', 1),
(190, 'st.jpg', 'da88b2c32589a9e78616097e059baa93.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:38:33', 1),
(191, 'SU.png', '070f34aba45d815287a6fec757a1ada6.png', 'image/png', 'png', '2020-03-18 17:40:09', 1),
(192, 'sv.jpg', '7d1d0ab1aef4d679dea044626e485196.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:40:47', 1),
(193, 'sy.jpg', '30de8390ddda0f509d73e02d559553f6.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:41:03', 1),
(194, 'sz.jpg', 'a9b54916e38eccfb467e98ea4bbd3c15.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:41:18', 1),
(195, 'td.jpg', 'a5d361451e877e8e949ccaebadbeda58.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:42:40', 1),
(196, 'tg.jpg', '386c22f2a7e7e63fa750a09ba104e62f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:43:16', 1),
(197, 'th.jpg', '80af8286a8c56657ce8b1d2dbc63464d.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:43:45', 1),
(198, 'tj.jpg', 'dc344dcdebc392c3aa14bf080151ace3.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:44:05', 1),
(199, 'tl.jpg', 'db7e7a8ea5cbe4d6faa65a8d2de2d15c.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:44:31', 1),
(200, 'tm.jpg', '11e7c37df4eb4665b36a2d70f64c7a1f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:44:46', 1),
(201, 'tn.jpg', 'a29574cce87f49c508ae74c4a6487f17.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:44:57', 1),
(202, 'to.jpg', '19b83d6290e9fa61c8a9eea6fc4ac001.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:45:18', 1),
(203, 'tr.jpg', '7e432397d3da4f5857665b419313f2d9.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:45:36', 1),
(204, 'tt.jpg', 'd0d104b854f7315349f623f81744482e.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:46:20', 1),
(205, 'tv.jpg', 'adc279a13d31de9029487a67904c32da.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:46:40', 1),
(206, 'tw.jpg', '2c9acd30c480faa6e08b0e12b3366a04.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:46:54', 1),
(207, 'tz.jpg', '4e9317ed42e9c119c1516f6e5c229563.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:47:19', 1),
(208, 'ua.jpg', '493ee70620862b2548ac1f355cbbbeea.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:47:32', 1),
(209, 'ug.jpg', '3cff3c6c44a3e66238ec4e0814f6fd38.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:48:19', 1),
(210, 'us.jpg', '94b30ca9da3dde62162bcf9a4196eb7f.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:48:27', 1),
(211, 'uy.jpg', '1bafef2d7e02a4c1044ccedb14bd4a5e.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:48:46', 1),
(212, 'uz.jpg', 'fe951ca05fa82684b0a740921e2d6d27.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:49:06', 1),
(213, 'va.jpg', '34db967957f57728f37ba5b2f1e77b4e.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:50:56', 1),
(214, 'vc.jpg', '1342f01da60fb5a163357ec4259a8827.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:51:19', 1),
(215, 've.jpg', '97b5675f08070e620a27e917593ae70b.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:51:38', 1),
(216, 'vn.jpg', '13f15c23d3a20d6a4cbb38a60ed5cbd5.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:51:56', 1),
(217, 'vu.jpg', 'aba9b28380a9952baabff506678171f6.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:52:21', 1),
(218, 'ws.jpg', 'c0cbdffbf28f6284f714a0d06796f3c2.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:52:47', 1),
(219, 'ye.jpg', 'f63b0dd8715f7977882f238b202bca40.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:53:50', 1),
(220, 'za.jpg', '2b201260f1344e08b122562c15942bb0.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:54:05', 1),
(221, 'zm.jpg', '46b5aa76de23f3764d1838c3c1160310.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:54:25', 1),
(222, 'zw.jpg', '0f3882d212845af11049d04615bcfc7e.jpg', 'image/jpeg', 'jpg', '2020-03-18 17:54:49', 1),
(223, '1200px-Flag_of_Wales.svg.png', '2265d0be743e37eadae25f13704cfc54.png', 'image/png', 'png', '2020-03-18 17:56:26', 1),
(226, '0438eb7ae17a4c5f0b81600768798a02.jpg', '5bb2b5137258296b51bba306a79c5204.jpg', 'image/jpeg', 'jpg', '2020-03-19 12:06:54', 1),
(227, '0438eb7ae17a4c5f0b81600768798a02.jpg', '8659a34b9f7dcf89d6f5f60e0f668160.jpg', 'image/jpeg', 'jpg', '2020-03-19 12:16:00', 1),
(228, '0438eb7ae17a4c5f0b81600768798a02.jpg', 'ee80bcd9a6fa118e5d275f20c4887003.jpg', 'image/jpeg', 'jpg', '2020-03-19 12:18:17', 1),
(229, '0438eb7ae17a4c5f0b81600768798a02.jpg', '038e6a0cc20d26b43e56059dff71cca0.jpg', 'image/jpeg', 'jpg', '2020-03-19 12:20:14', 1),
(230, '0438eb7ae17a4c5f0b81600768798a02.jpg', '231108d4b85b2c775b8c4d3d26928a99.jpg', 'image/jpeg', 'jpg', '2020-03-19 12:22:42', 1),
(231, '0438eb7ae17a4c5f0b81600768798a02.jpg', '718f13b6d2877ad83ea051e168d7ee28.jpg', 'image/jpeg', 'jpg', '2020-03-19 12:22:58', 1),
(232, '0438eb7ae17a4c5f0b81600768798a02.jpg', '0a394f812fb79bed9aaa05ddc030ea28.jpg', 'image/jpeg', 'jpg', '2020-03-19 12:23:34', 1),
(233, '0438eb7ae17a4c5f0b81600768798a02.jpg', 'a8d23622e05bb3c92725dff57022c3e1.jpg', 'image/jpeg', 'jpg', '2020-03-19 12:24:47', 1),
(234, '0438eb7ae17a4c5f0b81600768798a02.jpg', '89f5bc810da52c6ca46bc75d48b12d50.jpg', 'image/jpeg', 'jpg', '2020-03-19 12:24:57', 1),
(240, '0438eb7ae17a4c5f0b81600768798a02.jpg', '822e3f51b6a6c784208e3a03d1fe237d.jpg', 'image/jpeg', 'jpg', '2020-03-20 17:53:03', 1),
(241, '0438eb7ae17a4c5f0b81600768798a02.jpg', 'b8a5e826dd69ffea12efee40d8cf7acf.jpg', 'image/jpeg', 'jpg', '2020-03-20 17:53:03', 1),
(245, '636555302409684315.jpg', '8e802765d03372f087e2072abbf6138e.jpg', 'image/jpeg', 'jpg', '2020-04-16 10:18:02', 1),
(246, 'place_holder_defult.jpg', 'babdca6e71d2c295d1272c74959d168a.jpg', 'image/jpeg', 'jpg', '2020-04-16 10:39:48', 1),
(249, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-16 12:12:25', 1),
(250, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-17 21:43:43', 1),
(251, '636555302409684315.jpg', 'd1edb7e84b41e6c5c88d6feabdea385b.jpg', 'image/jpeg', 'jpg', '2020-04-18 19:38:12', 1),
(252, '636555302409684315.jpg', 'c171c0cb03019d904d989b8b6662bbb5.jpg', 'image/jpeg', 'jpg', '2020-04-18 19:40:26', 1),
(253, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-19 08:39:46', 1),
(254, '636555302409684315.jpg', 'd60f7bf0749a84ee1e409730eeecf15f.jpg', 'image/jpeg', 'jpg', '2020-04-20 02:13:30', 1),
(255, '1539076808-635910431989123123.jpg', 'c1d8863eb221b44579383d550e6bbfa1.jpg', 'image/jpeg', 'jpg', '2020-04-20 02:13:52', 1),
(256, 'place_holder_defult.jpg', '4e4579d813be026ad57c2e5de7153f3a.jpg', 'image/jpeg', 'jpg', '2020-04-20 02:14:09', 1),
(257, 'notebook-paper-pencil-table-blur-book-store-background_7190-137.jpg', '8a562cf3cfb44b64eabf9235eb01bc15.jpg', 'image/jpeg', 'jpg', '2020-04-20 02:14:29', 1),
(258, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-22 19:47:40', 1),
(259, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-23 00:04:09', 1),
(260, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-23 00:11:06', 1),
(261, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-23 00:43:48', 1),
(262, 'notebook-paper-pencil-table-blur-book-store-background_7190-137.jpg', '369c678ef42c5e78c08824fe0d4ce0b7.jpg', 'image/jpeg', 'jpg', '2020-04-25 00:05:44', 1),
(263, '1539076808-635910431989123123.jpg', 'a9885deb1ecf423fdc6a09ca2cf83cc9.jpg', 'image/jpeg', 'jpg', '2020-04-25 00:17:18', 1),
(264, '636555302409684315.jpg', '9e3bf7b2ba15a8d6c850bed346b60f38.jpg', 'image/jpeg', 'jpg', '2020-04-25 01:59:13', 1),
(265, 'notebook-paper-pencil-table-blur-book-store-background_7190-137.jpg', '94df7696650696e423da2a8bf06aa20d.jpg', 'image/jpeg', 'jpg', '2020-04-25 02:00:25', 1),
(266, 'slide1.jpg', '5a3b31a49d07c37a54fba08598e5d902.jpg', 'image/jpeg', 'jpg', '2020-04-25 02:02:07', 1),
(271, 'mahanteymori-ph-otokade-0.jpg', '459cef38f88e8a025a68ae92a75cdd69.jpg', 'image/jpeg', 'jpg', '2020-04-29 13:22:25', 1),
(272, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-29 13:29:43', 1),
(273, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-29 13:29:46', 1),
(274, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-29 13:30:38', 1),
(275, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-29 13:30:48', 1),
(276, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-29 13:36:29', 1),
(277, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-29 13:37:15', 1),
(278, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-04-29 13:44:11', 1),
(282, 'IMG_20200421_220546_667.jpg', '46645ba44b6f1325e0f2e604eba727a5.jpg', 'image/*', 'jpg', '2020-04-29 16:05:31', 1),
(287, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-05-01 13:52:00', 1),
(290, 'DSC02632.jpg', 'a181ee7bdcf401b51d8eb03109908107.jpg', 'image/jpeg', 'jpg', '2020-05-02 00:20:27', 1),
(291, 'tmfh52qry9yr.jpeg', '3d9ccaaafc6b126f88ec0d2fa72e0eaf.jpeg', 'image/jpeg', 'jpeg', '2020-05-02 00:22:36', 1),
(292, 'ahmad_kalaate.png', '3117c46bcc6661e759c30b7823c0e8f4.png', 'image/png', 'png', '2020-05-02 00:26:51', 1),
(293, 'abasmanesh.png', 'e43cdf0ac883e71e8253accf57957bc4.png', 'image/png', 'png', '2020-05-02 00:28:34', 1),
(294, 'Ahmad-Hellat.png', '88d3bef0219700116b56edd7b00a52d5.png', 'image/png', 'png', '2020-05-02 00:29:56', 1),
(295, 'arshian.png', '6e8c441e45be268ea2ca5f23f4c66ed0.png', 'image/png', 'png', '2020-05-02 00:30:43', 1),
(296, 'dralirezaazmandian.png', 'a5a5ae93635d86e2b38794d83ea5f686.png', 'image/png', 'png', '2020-05-02 00:32:00', 1),
(297, 'dralishahhosseini.png', '92353ee68992826828eddaca934ea0bf.png', 'image/png', 'png', '2020-05-02 00:33:04', 1),
(298, 'hajimohamadiinsta.png', 'a5e3467516d2a847d0974498b4cfadc5.png', 'image/png', 'png', '2020-05-02 00:34:07', 1),
(299, 'Mohammad-Mahdi-Rabbani.png', '66a97efd6699f0ce0ab4b833a78e3ed1.png', 'image/png', 'png', '2020-05-02 00:34:52', 1),
(300, 'Mahmoud-Moazami.png', '9bda22bf634af00d0f5f94cb521b1f1b.png', 'image/png', 'png', '2020-05-02 00:35:36', 1),
(301, 'Mehdi-Safaei.png', '5ed81c0b933d6798f527f9a60168f608.png', 'image/png', 'png', '2020-05-02 00:36:18', 1),
(302, 'nimakimiaei.png', 'f8b56b186cbd547c11821cba2e7f762a.png', 'image/png', 'png', '2020-05-02 00:37:10', 1),
(303, 'shahram-c.png', 'dcc88a1ac58c2cd0c269c70a7a4ebf52.png', 'image/png', 'png', '2020-05-02 00:38:39', 1),
(304, 'bishtarazyek.png', '39f761bb489a91c0ca9d7bd52ac78f45.png', 'image/png', 'png', '2020-05-02 00:40:23', 1),
(305, 'Untitled-1.jpg20.jpg', 'c65e953f277535726845308a32cb9314.jpg', 'image/jpeg', 'jpg', '2020-05-02 00:41:19', 1),
(306, '021.png', '4a9942088c100a425ac71c9a49dc10dd.png', 'image/png', 'png', '2020-05-04 22:27:35', 1),
(307, '21.png', 'ef576963d512ae5954296dc0aa69119e.png', 'image/png', 'png', '2020-05-04 22:27:35', 1),
(308, '022.png', 'b85ff69575bb908e63510c2cc2557369.png', 'image/png', 'png', '2020-05-04 22:28:33', 1),
(309, '22.png', 'b594c8d1fbf735531a09e252de34d317.png', 'image/png', 'png', '2020-05-04 22:28:33', 1),
(310, '023.png', '7fd77ca481f393021271a6b404bf9e82.png', 'image/png', 'png', '2020-05-04 22:44:04', 1),
(311, '23.png', 'a1e30133790407beb94d8b1ba41d7b3c.png', 'image/png', 'png', '2020-05-04 22:44:04', 1),
(312, '025.png', '6cc583cd9fd5007ee487356a0157e439.png', 'image/png', 'png', '2020-05-04 23:17:50', 1),
(313, '25.png', '4bacc8731342be4e8a8d80c7681c3433.png', 'image/png', 'png', '2020-05-04 23:17:51', 1),
(314, '026.png', 'fb50b7d1536dd7e912dd0761ce43a216.png', 'image/png', 'png', '2020-05-04 23:18:17', 1),
(315, '26.png', '188694d7a355f8eae043fef4ddce8b43.png', 'image/png', 'png', '2020-05-04 23:18:17', 1),
(316, '027.png', 'f0d89c6433f32e9927d60e834af45020.png', 'image/png', 'png', '2020-05-04 23:18:37', 1),
(317, '27.png', '4291347f5b9562871ef91b4b5290e2d0.png', 'image/png', 'png', '2020-05-04 23:18:37', 1),
(318, '028.png', '38f152340192b614a9e1e1a3c5b1fad5.png', 'image/png', 'png', '2020-05-04 23:19:16', 1),
(319, '28.png', '6602b1eaca548a9081283ea40c4c2918.png', 'image/png', 'png', '2020-05-04 23:19:16', 1),
(320, '029.png', '95d5712d5c4265883126b0d6f99f9bc8.png', 'image/png', 'png', '2020-05-04 23:19:39', 1),
(321, '29.png', '4f7fff2b6e7b147178f97b06e6fcb708.png', 'image/png', 'png', '2020-05-04 23:19:39', 1),
(322, '030.png', '1b8d4a220bae29ea8168298e44ef85af.png', 'image/png', 'png', '2020-05-04 23:20:42', 1),
(323, '30.png', 'adc72e0d5b74e87f286f9502a4aa21fd.png', 'image/png', 'png', '2020-05-04 23:20:42', 1),
(324, '031.png', '2023b44c23e4b5a07a62656c562ec4cc.png', 'image/png', 'png', '2020-05-04 23:21:04', 1),
(325, '31.png', '59f6f0a21ecae9b658904ddf0f8bb621.png', 'image/png', 'png', '2020-05-04 23:21:04', 1),
(326, '032.png', '6406ac24ba0217f79fd1c84291bd497c.png', 'image/png', 'png', '2020-05-04 23:21:28', 1),
(327, '32.png', '93f37d8be96ba4b0b78fb494ae53b44e.png', 'image/png', 'png', '2020-05-04 23:21:28', 1),
(328, '033.png', 'b9749291d103492a4ed1a6ab0f4eb553.png', 'image/png', 'png', '2020-05-04 23:21:49', 1),
(329, '33.png', 'a8e136695aafb74a4041055ea00c26b2.png', 'image/png', 'png', '2020-05-04 23:21:49', 1),
(330, '034.png', '8f52dcb9de292aa94166671069112e95.png', 'image/png', 'png', '2020-05-04 23:22:08', 1),
(331, '34.png', '687e92a308d8d5506b946f1ba6334eae.png', 'image/png', 'png', '2020-05-04 23:22:08', 1),
(332, '035.png', '3a4c9ec95829e2717563dbf76b4daef5.png', 'image/png', 'png', '2020-05-04 23:22:37', 1),
(333, '35.png', '48bb3da84f0e8512f65d0b10bbe98b9f.png', 'image/png', 'png', '2020-05-04 23:22:37', 1),
(334, '036.png', '0c9c1192c056cfe19d36015d77dadfc3.png', 'image/png', 'png', '2020-05-04 23:22:58', 1),
(335, '36.png', '1c71b6c69cc92f36ba6d70611647f5cf.png', 'image/png', 'png', '2020-05-04 23:22:58', 1),
(336, '037.png', '86da0b290d35444cce5f3f5d0ecdb103.png', 'image/png', 'png', '2020-05-04 23:23:23', 1),
(337, '37.png', '17110bbe25bae5be411492865725837e.png', 'image/png', 'png', '2020-05-04 23:23:23', 1),
(338, '038.png', '0c90866bc8930373ace9180b8808cf97.png', 'image/png', 'png', '2020-05-04 23:23:50', 1),
(339, '38.png', 'c6ea4d58baec55bc534a7d901ba4c935.png', 'image/png', 'png', '2020-05-04 23:23:50', 1),
(340, '039.png', '5d443fa2dee050772033b1bfbf6e8a52.png', 'image/png', 'png', '2020-05-04 23:24:10', 1),
(341, '39.png', '8bda30287349c086c777fd2d6fc142d3.png', 'image/png', 'png', '2020-05-04 23:24:10', 1),
(342, '040.png', '2d77fd613ee883bf6179338678dc5503.png', 'image/png', 'png', '2020-05-04 23:24:40', 1),
(343, '40.png', '8fc48431620c60cd2068d2f66a1e543b.png', 'image/png', 'png', '2020-05-04 23:24:40', 1),
(344, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-06-12 15:36:13', 1),
(345, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-06-12 15:36:26', 1),
(346, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-06-12 15:38:30', 1),
(347, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-06-12 15:38:58', 1),
(348, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-06-12 15:46:53', 1),
(349, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-06-12 15:59:45', 1),
(360, 'Zombie-for-Sale-2019.jpg', 'ef72dc4d1011530548e2494515e61251.jpg', 'image/jpeg', 'jpg', '2020-11-16 10:46:25', 1),
(361, 'Zombie-for-Sale-2019.jpg', '875199f6a45a999a21a59f31719116ae.jpg', 'image/jpeg', 'jpg', '2020-11-16 10:46:25', 1),
(364, 'Jungleland-2019.jpg', '27bfa3dca1e7e66461f629db50a8b01e.jpg', 'image/jpeg', 'jpg', '2020-11-16 10:51:34', 1),
(365, 'Jungleland-2019.jpg', 'de136dc4219af3a93ae69f321bbca0f3.jpg', 'image/jpeg', 'jpg', '2020-11-16 10:51:34', 1),
(366, 'Money-Heist-Series-Season-Four.jpg', '2ee01a6ceff292e02afb2ea3a3d00c92.jpg', 'image/jpeg', 'jpg', '2020-11-16 10:54:50', 1),
(367, 'Money-Heist-Series-Season-Four.jpg', 'fde347cbf9295c2f49514adbfc5fb164.jpg', 'image/jpeg', 'jpg', '2020-11-16 10:54:50', 1),
(370, 'Money-Heist-Series-Season-Four.jpg', '8b02fbef0a9f26301bc2f7f55e82d05b.jpg', 'image/jpeg', 'jpg', '2020-11-16 10:58:17', 1),
(372, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-11-16 12:42:06', 1),
(373, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2020-11-24 14:19:50', 1),
(375, 'my1qa7cn8548wsz.png', 'ee402668ddc0d33bb13d94d897694c41.png', 'image/*', 'png', '2020-11-25 14:41:23', 1),
(377, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2021-06-01 17:54:40', 1),
(381, 'Cruella-2021.jpg', '97a68e109d1c963158f4e056f78b9adf.jpg', 'image/jpeg', 'jpg', '2021-06-07 18:23:03', 1),
(382, 'Cruella-2021.jpg', '465c1e20a3a6891f86b0e113c391db50.jpg', 'image/jpeg', 'jpg', '2021-06-07 18:32:06', 1),
(385, 'episod9giso.jpg', '4391ab6d5bcca427b0151821c4c8eafe.jpg', 'image/jpeg', 'jpg', '2021-06-09 21:22:11', 1),
(386, 'episod9giso.jpg', 'aeb9652ebb0909b646c6853e602e726c.jpg', 'image/jpeg', 'jpg', '2021-06-09 21:24:01', 1),
(387, 'episod9giso.jpg', '92ce8e4e1da3af1f4598caf983bb1c19.jpg', 'image/jpeg', 'jpg', '2021-06-09 21:30:09', 1),
(388, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2021-06-11 10:59:01', 1),
(391, 'Goodfellas.jpg', '37b8a4bfb0a33dca8af162a55611e19c.jpg', 'image/jpeg', 'jpg', '2021-06-12 20:43:30', 1),
(392, 'Goodfellas.jpg', '8d875278fb7de3ea9491025c44c6c889.jpg', 'image/jpeg', 'jpg', '2021-06-12 20:43:30', 1),
(393, 'download-series-asheghaneh.jpg', 'cd4f87fc9eb59da47dd1107d88de9590.jpg', 'image/jpeg', 'jpg', '2021-06-13 00:23:22', 1),
(394, 'download-series-asheghaneh.jpg', 'c6cd49a06b7e5b40ddf7c1e0062313a4.jpg', 'image/jpeg', 'jpg', '2021-06-13 00:23:23', 1),
(413, 'شبکه-1.jpg', 'c1111018bbb1fc8cd4282eb54c7a8e5d.jpg', 'image/jpeg', 'jpg', '2021-06-17 20:18:13', 1),
(414, 'شبکه-2.jpg', 'db3b6bc90b228b6475b4fe55ca05b113.jpg', 'image/jpeg', 'jpg', '2021-06-17 20:18:24', 1),
(415, 'شبکه-مستند.jpg', 'c8c1742aee45b2c348025cc541e82729.jpg', 'image/jpeg', 'jpg', '2021-06-17 20:18:35', 1),
(416, 'شبکه-ورزش.jpg', '565ba00653105d4b08d89f349bd21136.jpg', 'image/jpeg', 'jpg', '2021-06-17 20:18:47', 1),
(417, '353556bd0f79b513075267b9fba2fb27.jpg', '97eae6bffe6078e133efaa8398919de7.jpg', 'image/jpeg', 'jpg', '2021-06-17 20:18:56', 1),
(423, 'download-series-asheghaneh.jpg', '694e080ef625fff2b68f3b934aa72917.jpg', 'image/jpeg', 'jpg', '2021-06-19 17:31:28', 1),
(424, 'The_Monster_(Season_2).jpg', '37becf1b379269e51b1c0fe48de1d9a9.jpg', 'image/jpeg', 'jpg', '2021-06-19 17:31:28', 1),
(429, 'Kong: Skull Island', 'b7f9ee6e1c7565e6830268054642a3c8.jpg', 'image/jpg', 'jpg', '2021-07-03 13:38:01', 1),
(430, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2021-07-04 15:02:34', 1),
(431, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2021-07-04 18:28:45', 1),
(432, 'Radhe', 'fbe9ac5874fb91e4facf9732b25dcb5e.jpg', 'image/jpg', 'jpg', '2021-07-09 10:01:05', 1),
(433, 'King Kong', '291953782823db0532b6e09bb8161cd9.jpg', 'image/jpg', 'jpg', '2021-07-09 12:36:02', 1),
(434, '291953782823db0532b6e09bb8161cd9.jpg', '0686f72bd071009d092d2731eb58f709.jpg', 'image/jpeg', 'jpg', '2021-07-09 13:10:28', 1),
(436, '.collage_temp.jpg', 'fe4aafc6d0f92970859f87d7e15782e8.jpg', 'image/jpeg', 'jpg', '2021-07-09 17:20:41', 1),
(438, 'conjuring_the_devil_made_me_do_it.jpg', '75500d96cb321889afe9898f3f61510b.jpg', 'image/jpeg', 'jpg', '2021-07-10 12:09:42', 1),
(439, 'conjuring_the_devil_made_me_do_it.jpg', 'bf3c319606b017c364fffc2d9a8c9d6e.jpg', 'image/jpeg', 'jpg', '2021-07-10 12:09:42', 1),
(440, 'MV5BNjRmNDI5MjMtMmFhZi00YzcwLWI4ZGItMGI2MjI0N2Q3YmIwXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_SX500.jpg', 'b861426ecb8b433a95b42771ac17c5ec.jpg', 'image/jpeg', 'jpg', '2021-07-12 00:03:16', 1),
(441, 'QEJ3hrg5MfDyUSa69STRjG.jpg', '176b42b658755fab83899c825f918abd.jpg', 'image/jpeg', 'jpg', '2021-07-12 00:03:16', 1),
(445, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2021-07-20 21:12:14', 1),
(446, 'mov_41500_748-b.jpg', '9f56404aece4f15666403933bbd0c440.jpg', 'image/jpeg', 'jpg', '2021-07-27 00:40:03', 1),
(447, 'mov_41500_748-b.jpg', '28fb47db73f23a1c3f835ac6065d43e7.jpg', 'image/jpeg', 'jpg', '2021-07-27 00:40:03', 1),
(450, 'Gisoo-E21-250x375.jpg', '1d8a97dc5472f93f0875a97a18348ae8.jpg', 'image/jpeg', 'jpg', '2021-07-27 01:07:59', 1),
(451, 'Gisoo-E21-250x375.jpg', 'b606fcfa953355611bc4664c2730dcf0.jpg', 'image/jpeg', 'jpg', '2021-07-27 01:07:59', 1),
(453, 'img_20200607_023051.jpg', '9e02f7aa67bad0d90026c75324fcf7f4.jpg', 'image/jpeg', 'jpg', '2021-08-01 00:04:14', 1),
(467, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2021-08-01 23:49:13', 1),
(468, NULL, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'link', 'jpeg', '2021-08-02 11:31:44', 1),
(474, 'Gisoo.jpg', '37c0a3d525f914c337a9d91160c1ff32.jpg', 'image/jpeg', 'jpg', '2021-08-02 13:08:06', 1),
(478, '456.jpg', '563f146b1720742736f2fb69e4f54a48.jpg', 'image/jpeg', 'jpg', '2021-08-02 13:19:16', 1),
(479, 'Dwayne_Johnson_2,_2013.jpg', '72ae945090073914b7cf308a07e6d6f4.jpg', 'image/jpeg', 'jpg', '2021-08-02 18:48:48', 1),
(480, '667579480_michelle-rodriguez-zoom-55c3bb76-3a62-4248-89ff-2836db88dbc5.jpg', '4cb82c870bd3e700a69e8d0ef5c052c8.jpg', 'image/jpeg', 'jpg', '2021-08-02 18:49:44', 1),
(481, 'unnamed.jpg', '812757f57fa1e03625c24e73ab5e1a36.jpg', 'image/jpeg', 'jpg', '2021-08-02 18:50:45', 1),
(482, '220px-Alexandra_Daddario_April_2015.jpg', 'c4edabf176777d300a4b93b3d6b47f1d.jpg', 'image/jpeg', 'jpg', '2021-08-02 18:51:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posters_genres`
--

CREATE TABLE `posters_genres` (
  `poster_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posters_genres`
--

INSERT INTO `posters_genres` (`poster_id`, `genre_id`) VALUES
(28, 7),
(29, 7),
(30, 7),
(31, 7),
(31, 11),
(32, 7),
(34, 11),
(39, 14),
(39, 18),
(41, 7),
(42, 7),
(43, 7),
(43, 16),
(47, 10),
(48, 7),
(50, 7),
(50, 18),
(52, 11),
(52, 14);

-- --------------------------------------------------------

--
-- Table structure for table `poster_table`
--

CREATE TABLE `poster_table` (
  `id` int(11) NOT NULL,
  `cover_id` int(11) DEFAULT NULL,
  `posted_id` int(11) DEFAULT NULL,
  `trailer_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `playas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `downloadas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tags` longtext COLLATE utf8_unicode_ci,
  `rating` double NOT NULL,
  `imdb` double DEFAULT NULL,
  `classification` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `downloads` int(11) NOT NULL,
  `shares` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `comment` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `poster_table`
--

INSERT INTO `poster_table` (`id`, `cover_id`, `posted_id`, `trailer_id`, `country_id`, `title`, `duration`, `playas`, `downloadas`, `type`, `tags`, `rating`, `imdb`, `classification`, `year`, `description`, `downloads`, `shares`, `views`, `created`, `enabled`, `comment`) VALUES
(28, 361, 360, 44, 99, 'Zombie for Sale 2019', '112 دقیقه', '1', '3', 'movie', NULL, 1, 4.5, '+12', NULL, 'پس از اینکه آزمایش‌ های غیرقانونی یک شرکت داروسازی باعث ایجاد یک زامبی میشود، خانواده پارک این زامبی را پیدا کرده و سعی میکنند با استفاده از آن به سود برسند اما…', 0, 2, 12, '2020-11-16 10:46:25', 1, 1),
(29, 365, 364, 46, 65, 'Jungleland 2019', '90 دقیقه', '2', '3', 'movie', NULL, 2, 6.5, NULL, NULL, 'فیلم داستان یک بوکسر به نام لاین و برادر و مربی او به نام استنلی را روایت می‌کند. استنلی بابت یک شرطبندی مبلغی به یک جنایت‌کار بدهکار شده و سرنوشتش به یک مبارزه گره خورده و…', 0, 0, 0, '2020-11-16 10:51:34', 1, 1),
(30, 367, 366, 48, 58, 'Money Heist', 'در 4 فصل', NULL, NULL, 'serie', NULL, 5, 8.4, '+16', 2021, 'زمان تقریبی هر قسمت ۸۰ دقیقه \r\nدر فصل چهارم خشم و اندوه، تنش‌ها را میان اعضای گروه افزایش می‌دهد. از سوی دیگر، پروفسور هنگام عزاداری، در اقدامی جسورانه تلاش می‌کند که از یک موقعیت خطرناک بگریزد. پالرمو با رفتارهای خود، اعضای گروه را حیرت‌زده می‌کند. از سوی دیگر، سیرا سوژه خود را برای انجام یک معامله، تحت فشار قرار می‌دهد و پروفسور جشن عروسی برادرش را به خاطر می‌آورد. عامل نفوذی پروفسور تلاش می‌کند که پیام خود را به فردی انتقال دهد که زیر سایبان حضور دارد. از سوی دیگر، حسادت دنور نسبت به رابطه دوستانه میان مونیکا و ریو شدت می‌گیرد و…', 0, 0, 19, '2020-11-16 10:54:50', 1, 0),
(31, 382, 381, NULL, NULL, 'کروئلا دوبله فارسی Cruella 2021', '137دقیقه', '1', '3', 'movie', NULL, 5, 7.3, '+12', NULL, 'این فیلم در واقع  لایو اکشن انیمیشن دیزنی به نام صد و یک سگ خالدار در سال ۱۹۶۱ است. داستان در مورد یک طراح مد جوان به نام استلا علاقه بسیاری به پوست حیوانات دارد و تلاش می کند تا به هدف خود برسد. اما همین امر باعث می شود تا به یک زن شرور و بدجنس تبدیل شود و…', 2, 3, 9, '2021-06-07 18:23:03', 1, 1),
(32, 387, 385, 56, 86, 'سریال گیسو', '1', NULL, NULL, 'serie', NULL, 0, 5.5, '+14', 1400, 'خلاصه داستان : دانلود سریال گیسو ، رضا در مخمصه‌ای افتاده که برای بیرون آمدن از آن به کمک سهیل و پیمان نیاز دارد. اما نقشه آن‌ها آن‌طور که باید پیش نمی‌رود و اتفاقاتی رخ می‌دهد که کنترل اوضاع را از دست همه خارج می‌کند و …\r\n\r\nگیسو سریالی درام، معمایی و عاشقانه با نویسندگی علیرضا کاظمی پور و سعید جلالی و کارگردانی منوچهر هادی و تهیه کنندگی هومن کبیری محصول سال ۱۳۹۹ کشور ایران است که با هنرنمایی محمدرضا گلزار، ساره بیات، هانیه توسلی، حسین یاری، هومن سیدی، مسعود رایگان، شمسی فضل الهی، بیژن امکانیان، آزاده ریاضی، علیرضا زمانی نسب، سانیا سالاری و بهاره رهنما در شبکه نمایش خانگی میباشد.\r\n\r\nمحمدرضا گلزار علاوه بر بازیگری، تیتراژ این سریال جذاب و هیجان انگیز را نیز خوانده است.\r\n\r\nهومن کبیری، تهیه‌کننده این پروژه اعلام کرده است، گیسو، درامی معمایی با رویکردهای اجتماعی از جمله پول‌شویی است و با توجه به ساخت سریال‌های مختلفی که روابط رومانتیک در آنها محور اصلی بوده، در این فصل در جهت ارتباط با مخاطب، تحولی اساسی در داستان صورت گرفته است', 0, 2, 12, '2021-06-09 21:22:11', 1, 0),
(34, 392, 391, 60, 191, 'رفقای خوب', '145 دقیقه', '1', '3', 'movie', NULL, 0, 8.7, '+18', NULL, 'داستان بر اساس زندگی واقعی و رویدادهای حقیقی هنری هیل، گنگستر مخوف سابق را روایت می‌کند. هنری از کودکی آرزو داشته یک گانگستر شود به‌طوری‌که گانگستر شدن را از رئیس جمهور آمریکا شدن بهتر می‌دانست. هنری جوان به عنوان صرفاً یک پیشخدمت و راننده برای سازمان جنایی نزدیک محله‌شان', 0, 0, 8, '2021-06-12 20:43:29', 1, 1),
(35, 394, 393, 62, 86, 'عاشقانه', '1', NULL, NULL, 'serie', NULL, 0, 5.6, '+14', NULL, 'زنی به زندگی چند زوج جوان وارد می شود تا آرامش ظاهری زندگی آنان به آشوب کشیده شود...', 0, 0, 0, '2021-06-13 00:23:22', 1, 0),
(39, 424, 423, 76, 86, 'عاشقانه2', '2', NULL, NULL, 'serie', NULL, 0, 5.6, '+10', 1400, NULL, 0, 0, 0, '2021-06-19 17:31:28', 1, 0),
(41, NULL, 429, NULL, NULL, 'Kong: Skull Island', '118 min', '1', '3', 'movie', 'Action, Adventure, Fantasy', 0, 6.6, 'PG-13', 2017, 'After the Vietnam war, a team of scientists explores an uncharted island in the Pacific, venturing into the domain of the mighty Kong, and must fight to escape a primal Eden.', 0, 0, 0, '2021-07-03 13:37:58', 1, 1),
(42, NULL, 432, NULL, 84, 'Radhe', '135 min', '1', '3', 'movie', 'Action, Crime, Thriller', 2, 1.8, 'TV-MA', 2021, 'After taking the dreaded gangster Gani Bhai, ACP Rajveer Shikawat aka Radhe goes on a manhunt to find the wealthiest man of the town secretly running a crime syndicate.', 0, 1, 0, '2021-07-09 10:01:01', 1, 1),
(43, 434, 433, NULL, 12, 'King Kong', '187 دقیقه', '1', '3', 'movie', 'Action, Adventure, Drama, Romance', 0, 7.2, 'PG-13', 2005, 'A greedy film producer assembles a team of moviemakers and sets out for the infamous Skull Island, where they find more than just cannibalistic natives.', 0, 0, 0, '2021-07-09 12:35:59', 1, 1),
(45, NULL, 436, NULL, 47, 'لوکا', '120', '1', '3', 'movie', NULL, 0, 10, NULL, 2021, 'لوکا توسط والت دیزنی ساته شده محصول ۲۰۲۱', 0, 0, 1, '2021-07-09 17:20:41', 1, 1),
(47, 439, 438, 80, 191, 'The Conjuring: The Devil Made Me Do It 2021', '2', '1', '3', 'movie', NULL, 0, 6.4, '+17', 2021, NULL, 0, 0, 4, '2021-07-10 12:09:41', 1, 1),
(48, 441, 440, NULL, 191, 'بیوه سیاه 2021', '120 دقیقه', '3', '2', 'movie', NULL, 5, 7.5, '12+', 2021, 'یک فیلم در سبک اکشن ، علمی تخیلی و ماجراجویی به کارگردانی «کیت شورت‌لند» بر پایه شخصیتی خیالی به همین نام از کمپانی مارول و محصول ایالات متحده آمریکا که در سال ۲۰۲۰ میباشد.  فیلم‌نامه این فیلم را «ژاک شفر» و »ند بنسون »نگاشته‌اند. ستارگانی همچون «اسکارلت جوهانسون»، «فلورنس پیو»، «دیوید هاربر»، «ریچل وایس» و «او.تی. فاگبنلی» در این فیلم به ایفای نقش میپردازند. تولید', 1, 1, 6, '2021-07-12 00:03:16', 1, 1),
(50, 447, 446, 85, 86, 'سریال خوب، بد، جلف', '1', NULL, NULL, 'serie', NULL, 5, 6.5, '12+', 1399, 'پژمان و سام به عنوان گروگان به همراه کیک زرد توسط آصف رئیس گروه جانفدایان داغستان آزاد دزدیده شده اند و قرار است از مرز شمال غربی کشور به چچن بروند و از ...', 0, 0, 0, '2021-07-27 00:40:02', 1, 1),
(52, 451, 450, 88, 86, 'گیسو', '5', NULL, NULL, 'serie', NULL, 0, 5.3, '17', 1400, 'خلاصه سریال گیسو: این سریال که به نوعی فصل دوم سریال عاشقانه محسوب میشود، داستانی معمایی و عاشقانه را به تصویر کشیده است. گیسو درامی معمایی با رویکردهای اجتماعی از جمله پولشویی است…\r\n\r\n\r\nدرباره سریال گیسو: محصول کشور ایران و در ژانر جنایی ، درام می‌باشد و به کارگردانی منوچهر هادی در سال 1400 ساخته شده است. در سریال بازیگرانی چون آزاده ریاضی، بهاره رهنما، جولیا پانلی، حسین یاری، ساره بیات، سانیا سالاری و... به ایفای نقش پرداخته اند.', 0, 0, 0, '2021-07-27 01:07:59', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rate_table`
--

CREATE TABLE `rate_table` (
  `id` int(11) NOT NULL,
  `poster_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `review` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rate_table`
--

INSERT INTO `rate_table` (`id`, `poster_id`, `channel_id`, `user_id`, `value`, `review`, `created`) VALUES
(1, 28, NULL, 18, 1, NULL, '2020-11-25 11:48:15'),
(2, 30, NULL, 18, 5, NULL, '2020-11-25 15:00:24'),
(3, 31, NULL, 21, 5, NULL, '2021-06-11 11:10:02'),
(4, 48, NULL, 24, 5, NULL, '2021-07-21 22:09:13'),
(6, 48, NULL, 25, 5, NULL, '2021-08-02 00:57:27'),
(7, 42, NULL, 25, 2, NULL, '2021-08-02 00:57:36'),
(8, 29, NULL, 25, 2, NULL, '2021-08-02 00:57:43'),
(9, 31, NULL, 25, 5, NULL, '2021-08-02 00:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `role_table`
--

CREATE TABLE `role_table` (
  `id` int(11) NOT NULL,
  `poster_id` int(11) DEFAULT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_table`
--

INSERT INTO `role_table` (`id`, `poster_id`, `actor_id`, `role`, `position`) VALUES
(10, 31, NULL, 'Emma Stone', 1),
(11, 31, NULL, 'Emma Thompson', 2),
(12, 31, NULL, 'Joel Fry', 3);

-- --------------------------------------------------------

--
-- Table structure for table `season_table`
--

CREATE TABLE `season_table` (
  `id` int(11) NOT NULL,
  `poster_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `season_table`
--

INSERT INTO `season_table` (`id`, `poster_id`, `title`, `position`) VALUES
(2, 30, 'فصل اول', 1),
(3, 30, 'فصل دوم', 2),
(4, 30, 'فصل سوم', 3),
(5, 30, 'فصل چهارم', 4),
(6, 32, '1', 1),
(7, 35, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings_table`
--

CREATE TABLE `settings_table` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `appname` int(255) DEFAULT NULL,
  `appdescription` longtext COLLATE utf8_unicode_ci,
  `download_link` longtext COLLATE utf8_unicode_ci,
  `privacypolicy` longtext COLLATE utf8_unicode_ci,
  `notif_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notif_app_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auto_slider` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_slider` int(11) DEFAULT NULL,
  `payment_gateway` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `merchant_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pay_api` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_description` text COLLATE utf8_unicode_ci,
  `rewardedadmobid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banneradmobid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bannerfacebookid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bannertype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nativeadmobid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nativefacebookid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nativeitem` int(11) DEFAULT NULL,
  `nativetype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interstitialadmobid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interstitialfacebookid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interstitialtype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interstitialclick` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings_table`
--

INSERT INTO `settings_table` (`id`, `media_id`, `appname`, `appdescription`, `download_link`, `privacypolicy`, `notif_key`, `notif_app_id`, `auto_slider`, `time_slider`, `payment_gateway`, `merchant_id`, `pay_api`, `payment_description`, `rewardedadmobid`, `banneradmobid`, `bannerfacebookid`, `bannertype`, `nativeadmobid`, `nativefacebookid`, `nativeitem`, `nativetype`, `interstitialadmobid`, `interstitialfacebookid`, `interstitialtype`, `interstitialclick`) VALUES
(2, 1, NULL, 'توضیحات اپلیکیشن', 'http://exapmle.com/flix.apk', '<p>قوانین و مقررات اپلیکیشن</p>', '05e0769e8cb2afd12c8c3a5da20a2ef94f3e630a', 'PUSHPOLE_7997083131', 'TRUE', NULL, 'zarinpal', NULL, 'test', 'پرداخت اشتراک برای اپلیکیشن فلیکس', 'ca-app-pub-3940256099942544/5224354917', 'ca-app-pub-3940256099942544/630097xxxx', '600492759fdc760001291558', 'FALSE', 'rosdpcehfbmbfkmrjorseimppjfiffmhmqqmjpnbkpomolilrponksboeoqgnaseonqsqd', '610551f0e2f0ed2c4b826026', NULL, 'FACEBOOK', 'ca-app-pub-3940256099942544/1033173712', '60049288eda39a000141f489', 'FALSE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `slide_table`
--

CREATE TABLE `slide_table` (
  `id` int(11) NOT NULL,
  `poster_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slide_table`
--

INSERT INTO `slide_table` (`id`, `poster_id`, `channel_id`, `genre_id`, `category_id`, `media_id`, `title`, `url`, `type`, `position`) VALUES
(10, 32, NULL, NULL, NULL, 474, '2LPYsduM2KfZhCDar9uM2LPZiA==', NULL, '4', 2),
(11, NULL, NULL, 7, NULL, 478, '2YHbjNmE2YUg2YfYp9uMINin2qnYtNmG', NULL, '5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `source_table`
--

CREATE TABLE `source_table` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `poster_id` int(11) DEFAULT NULL,
  `episode_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quality` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `source_table`
--

INSERT INTO `source_table` (`id`, `media_id`, `poster_id`, `episode_id`, `channel_id`, `type`, `quality`, `url`) VALUES
(44, NULL, NULL, NULL, NULL, 'mp4', NULL, 'http://dl2.film2serial.ir/film2serial/film/asli/99/8/Zombie.for.Sale.2019.1080p.Farsi.Subbed.mkv'),
(45, NULL, 28, NULL, NULL, 'mp4', 'Full HD 1080', 'http://dl2.film2serial.ir/film2serial/film/asli/99/8/Zombie.for.Sale.2019.1080p.Farsi.Subbed.mkv'),
(46, NULL, NULL, NULL, NULL, 'mp4', NULL, 'http://dl2.film2serial.ir/film2serial/film/asli/99/8/Jungleland%202019-1080.mp4'),
(48, NULL, NULL, NULL, NULL, 'mkv', NULL, 'http://dl2.film2serial.ir/film2serial/serial/kharegi/Money.Heist.4/Money.Heist.S04E01.480p.Censored.Farsi.Subbed.mkv'),
(49, NULL, NULL, 2, NULL, 'mkv', '1080 FullHD', 'http://dl2.film2serial.ir/film2serial/serial/kharegi/Money.Heist.4/Money.Heist.S04E01.1080p.Censored.Farsi.Subbed.mkv'),
(50, NULL, NULL, NULL, 4, 'embed', '360', 'https://cdn1live.irib.ir/live-channels/smil:mostanad/chunklist_b307200_slFa.m3u8?s=laKV6rX46JJSaeETH9ajEQ&t=1623947537'),
(51, NULL, 28, NULL, NULL, 'youtube', 'کیفیت خوب', 'http://s1.upmedia.me/movie/Foreign/10-99/Inside-Out-2015/Inside-Out-2015-BluRay-subtitle_720%28UpMedia.Me%29.mp4'),
(55, NULL, 31, NULL, NULL, 'mkv', '720', 'http://192.168.10.12/film/Constantine_2005/Constantine_2005_720p_Farsi_Dubbed.mkv'),
(56, NULL, NULL, NULL, NULL, 'mp4', NULL, 'http://192.168.10.12/film/gisoo/Gisoo.Series.Trailer.mp4'),
(57, NULL, NULL, 7, NULL, 'mp4', '720', 'http://192.168.10.12/film/gisoo/Gisoo.Series.part1.mp4'),
(58, NULL, NULL, 8, NULL, 'mp4', '720', 'http://192.168.10.12/film/gisoo/Gisoo.Series.part2.mp4'),
(60, NULL, NULL, NULL, NULL, 'embed', NULL, 'https://hajifirouz4.cdn.asset.aparat.com/aparat-video/673932d11219124f93d864d66a32065234527181-480p.apt/chunk.m3u8?wmsAuthSign=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbiI6IjQyYzRhMmYyMmFjYWE1NGZhNjkzODIxZjk0MDExZGMxIiwiZXhwIjoxNjIzOTYzNjQzLCJpc3MiOiJTYWJhIElkZWEgR1NJRyJ9.h-RfKThi_oo846fY8Kk75tmDeLO6Tz9Ixoo0iRuDHzc'),
(61, NULL, 34, NULL, NULL, 'mov', 'کیفیت 1080', 'https://www.movineh.com/playonline/11093/?player=aHR0cHM6Ly90cmFmZmljLnVwZXJhLnR2LzI2ODQ2MjMtMC0xMDgwLm1wND9yZWY9bWVCeA=='),
(62, NULL, NULL, NULL, NULL, 'mkv', NULL, 'https://www.movineh.com/playonline/11093/?player=aHR0cHM6Ly90cmFmZmljLnVwZXJhLnR2LzI2ODQ2MjMtMC0xMDgwLm1wND9yZWY9bWVCeA=='),
(75, NULL, NULL, NULL, 4, 'embed', '380', 'https://tv3.ir/live'),
(76, NULL, NULL, NULL, NULL, 'youtube', NULL, 'https://youtu.be/am6Cb4IzuIk'),
(79, NULL, NULL, NULL, 10, 'm3u8', '1080', 'https://sdm.telewebion.com/live/mostanad/mostanad_dvr-576p/index.m3u8'),
(80, NULL, NULL, NULL, NULL, 'mp4', NULL, 'https://aspb30.cdn.asset.aparat.com/aparat-video/88da2e8be1ae376dfd64bbac73042c3e33995136-360p.mp4?wmsAuthSign=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbiI6ImQ4ZTJhYzgxMmMxOTgyZDQ0MTgyOTQ3OWFmMDkwZWUyIiwiZXhwIjoxNjI1OTIwNjcyLCJpc3MiOiJTYWJhIElkZWEgR1NJRyJ9.JZqStQwwkFXq6Id7hLCKj73GFvtEgaNIGcVgccCkseg'),
(81, NULL, 47, NULL, NULL, 'mp4', 'کفیت 180', 'https://dl2.sbjbdcbjdhdscjhdsbjdcjhsbjscbchjdsdsj.tk/a/film/1400/03/The.Conjuring.the.Devil.Made.Me.Do.It.2021.480p.WEB-DL.HardSub.DigiMoviez.mp4'),
(82, NULL, 48, NULL, NULL, 'mkv', '720p', 'https://dl1.sbjhdcbjdhdscjhdsbjdcjhsbjscbcdjdsdsj.tk/m3/film/1400/04/Black.Widow.2021.720p.WEB-DL.x265.SoftSub.DigiMoviez.mkv'),
(85, NULL, NULL, NULL, NULL, 'mp4', NULL, 'https://srvfa.top/2021/Khoob/Khoob-Bad-01.mp4'),
(88, NULL, NULL, NULL, NULL, 'mp4', NULL, 'https://static.namava.ir/Content/Upload/Images/09f9b32a-5a20-4d6b-b0f4-4de0a48f5daf.mp4'),
(89, NULL, NULL, NULL, 8, 'mp4', '1080', 'http://tv1.ir/live'),
(92, NULL, 45, NULL, NULL, 'mkv', '720', 'http://dl6.downloadha.com/hosein/animation/June2021/Rick.and.Morty.S05/720p.x265/Rick.and.Morty.S05E04.Rickdependence.Spray.720p.WEBRip.2CH.x265.HEVC-PSA_www.Downloadha.com_.mkv');

-- --------------------------------------------------------

--
-- Table structure for table `subtitle_table`
--

CREATE TABLE `subtitle_table` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `poster_id` int(11) DEFAULT NULL,
  `episode_id` int(11) DEFAULT NULL,
  `language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_pack_table`
--

CREATE TABLE `sub_pack_table` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `days` int(11) NOT NULL,
  `sku_key` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `price_off` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `sub_pack_table`
--

INSERT INTO `sub_pack_table` (`id`, `title`, `days`, `sku_key`, `price`, `price_off`, `enabled`) VALUES
(9, 'اشتراک یک ماهه', 30, NULL, '10000', '9000', 1),
(10, 'اشتراک یک ساله', 365, NULL, '100000', '90000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `support_table`
--

CREATE TABLE `support_table` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `support_table`
--

INSERT INTO `support_table` (`id`, `email`, `subject`, `message`, `created`) VALUES
(1, 'hamid.haghjoo68@gmail.com', 'للر', 'دووودات', '2020-11-25 15:02:27'),
(2, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2020-11-25 17:16:15'),
(3, 'Milad0661@gmail.com', 'عدم شارژ شدن حساب کاربری', 'این یک پیغام تست می باشد', '2021-07-04 15:03:54'),
(4, 'm4626277@gmail.com', 'عدم شارژ شدن حساب کاربری', 'جحخحننن', '2021-07-06 17:39:27'),
(5, 'a@gmail.com', 'پیشنهاد فیلم و سریال', 'فیلم جدید بزارین', '2021-07-09 13:55:19'),
(6, 'm462i2i18@gmail.com', 'موضوع درخواست', 'وسوستس', '2021-07-11 20:37:01'),
(7, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', '', '2021-07-13 16:14:48'),
(8, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:20'),
(9, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:20'),
(10, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:20'),
(11, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:20'),
(12, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:21'),
(13, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:21'),
(14, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:21'),
(15, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:21'),
(16, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:21'),
(17, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:21'),
(18, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:22'),
(19, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:22'),
(20, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:22'),
(21, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:22'),
(22, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:22'),
(23, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:22'),
(24, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:23'),
(25, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:23'),
(26, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:25'),
(27, 'امتیاز برای اپلیکیشن', '5.0 امتیاز ', 'عالی', '2021-07-18 19:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `verify_table`
--

CREATE TABLE `verify_table` (
  `id` int(11) NOT NULL,
  `mobile` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `outdated` tinyint(1) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verify_table`
--

INSERT INTO `verify_table` (`id`, `mobile`, `code`, `outdated`, `create_at`) VALUES
(8, '09106344069', 39865, 0, '2020-11-15 20:52:09'),
(9, '09378155323', 88460, 1, '2020-11-16 12:42:28'),
(10, '9378155323', 71496, 0, '2020-11-16 12:29:19'),
(11, '09378155195', 24050, 0, '2020-11-16 12:11:06'),
(12, '09362155652', 23994, 1, '2020-11-24 14:20:10'),
(13, '09394529096', 52952, 1, '2020-11-25 11:38:52'),
(14, '09116924536', 87817, 0, '2021-06-01 17:24:52'),
(15, '9116924536', 77996, 0, '2021-06-01 17:18:39'),
(16, '09931619570', 49694, 1, '2021-06-01 17:54:55'),
(17, '09054924564', 45366, 1, '2021-06-01 18:23:47'),
(18, '09184757073', 71222, 0, '2021-07-18 18:09:50'),
(19, '09156172396', 16559, 0, '2021-06-06 19:42:58'),
(20, '09187439157', 64504, 0, '2021-06-11 11:33:18'),
(21, '09192973085', 74400, 1, '2021-06-11 10:59:23'),
(22, '09020291654', 13377, 0, '2021-06-12 10:38:08'),
(23, '09335537883', 12162, 0, '2021-06-18 20:56:20'),
(24, '09352842098', 16707, 0, '2021-06-18 20:57:32'),
(25, '09394716688', 51098, 0, '2021-07-02 15:20:24'),
(26, '0703051241', 95800, 0, '2021-07-03 13:34:41'),
(27, '0747251070', 64342, 0, '2021-07-03 13:35:16'),
(28, '09023900530', 22550, 1, '2021-07-04 15:02:57'),
(29, '09032740352', 18313, 1, '2021-07-04 18:29:20'),
(30, '09127985816', 43961, 0, '2021-07-13 16:21:09'),
(31, '09184757075', 93905, 0, '2021-07-15 23:38:30'),
(32, '06165465456', 66072, 0, '2021-07-19 00:09:12'),
(33, '09186491983', 78564, 0, '2021-07-19 00:09:29'),
(34, '09193810454', 29705, 1, '2021-07-20 21:12:39'),
(35, '09931206786', 42859, 0, '2021-08-01 23:47:57'),
(36, '9054924564', 93345, 1, '2021-08-01 23:49:19'),
(37, '09180606351', 77432, 1, '2021-08-02 11:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `version_table`
--

CREATE TABLE `version_table` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `features` longtext COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `clear_data` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actor_table`
--
ALTER TABLE `actor_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D2AD64D2EA9FDD75` (`media_id`);

--
-- Indexes for table `category_table`
--
ALTER TABLE `category_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1E1AC00FEA9FDD75` (`media_id`);

--
-- Indexes for table `channels_categories`
--
ALTER TABLE `channels_categories`
  ADD PRIMARY KEY (`channel_id`,`category_id`),
  ADD KEY `IDX_5D59DF4872F5A1AA` (`channel_id`),
  ADD KEY `IDX_5D59DF4812469DE2` (`category_id`);

--
-- Indexes for table `channel_table`
--
ALTER TABLE `channel_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_410887DEEA9FDD75` (`media_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `comment_table`
--
ALTER TABLE `comment_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5FB317B75BB66C05` (`poster_id`),
  ADD KEY `IDX_5FB317B772F5A1AA` (`channel_id`),
  ADD KEY `IDX_5FB317B7A76ED395` (`user_id`);

--
-- Indexes for table `country_table`
--
ALTER TABLE `country_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_51C99AACEA9FDD75` (`media_id`);

--
-- Indexes for table `device_table`
--
ALTER TABLE `device_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `episode_table`
--
ALTER TABLE `episode_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CD2379124EC001D1` (`season_id`),
  ADD KEY `IDX_CD237912FDFF2E92` (`thumbnail_id`),
  ADD KEY `IDX_CD237912EA9FDD75` (`media_id`);

--
-- Indexes for table `fos_user_table`
--
ALTER TABLE `fos_user_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C3D4D4BD92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_C3D4D4BDA0D96FBF` (`email_canonical`),
  ADD KEY `IDX_C3D4D4BDEA9FDD75` (`media_id`);

--
-- Indexes for table `gallery_table`
--
ALTER TABLE `gallery_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genre_table`
--
ALTER TABLE `genre_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_table`
--
ALTER TABLE `language_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_89718B17EA9FDD75` (`media_id`);

--
-- Indexes for table `medias_gallerys_table`
--
ALTER TABLE `medias_gallerys_table`
  ADD PRIMARY KEY (`gallery_id`,`media_id`),
  ADD KEY `IDX_CC965DCE4E7AF8F` (`gallery_id`),
  ADD KEY `IDX_CC965DCEEA9FDD75` (`media_id`);

--
-- Indexes for table `media_table`
--
ALTER TABLE `media_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posters_genres`
--
ALTER TABLE `posters_genres`
  ADD PRIMARY KEY (`poster_id`,`genre_id`),
  ADD KEY `IDX_888D8635BB66C05` (`poster_id`),
  ADD KEY `IDX_888D8634296D31F` (`genre_id`);

--
-- Indexes for table `poster_table`
--
ALTER TABLE `poster_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2AD2483922726E9` (`cover_id`),
  ADD KEY `IDX_2AD24832EC46446` (`posted_id`),
  ADD KEY `IDX_2AD2483B6C04CFD` (`trailer_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `rate_table`
--
ALTER TABLE `rate_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_666996655BB66C05` (`poster_id`),
  ADD KEY `IDX_6669966572F5A1AA` (`channel_id`),
  ADD KEY `IDX_66699665A76ED395` (`user_id`);

--
-- Indexes for table `role_table`
--
ALTER TABLE `role_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F567695BB66C05` (`poster_id`),
  ADD KEY `IDX_1F5676910DAF24A` (`actor_id`);

--
-- Indexes for table `season_table`
--
ALTER TABLE `season_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E11878995BB66C05` (`poster_id`);

--
-- Indexes for table `settings_table`
--
ALTER TABLE `settings_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4EF0C90FEA9FDD75` (`media_id`);

--
-- Indexes for table `slide_table`
--
ALTER TABLE `slide_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_77A059655BB66C05` (`poster_id`),
  ADD KEY `IDX_77A0596572F5A1AA` (`channel_id`),
  ADD KEY `IDX_77A059654296D31F` (`genre_id`),
  ADD KEY `IDX_77A0596512469DE2` (`category_id`),
  ADD KEY `IDX_77A05965EA9FDD75` (`media_id`);

--
-- Indexes for table `source_table`
--
ALTER TABLE `source_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6F215479EA9FDD75` (`media_id`),
  ADD KEY `IDX_6F2154795BB66C05` (`poster_id`),
  ADD KEY `IDX_6F215479362B62A0` (`episode_id`),
  ADD KEY `IDX_6F21547972F5A1AA` (`channel_id`);

--
-- Indexes for table `subtitle_table`
--
ALTER TABLE `subtitle_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_79585A84EA9FDD75` (`media_id`),
  ADD KEY `IDX_79585A845BB66C05` (`poster_id`),
  ADD KEY `IDX_79585A84362B62A0` (`episode_id`),
  ADD KEY `IDX_79585A8482F1BAF4` (`language_id`);

--
-- Indexes for table `sub_pack_table`
--
ALTER TABLE `sub_pack_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_table`
--
ALTER TABLE `support_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify_table`
--
ALTER TABLE `verify_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verify_fi_29554a` (`mobile`);

--
-- Indexes for table `version_table`
--
ALTER TABLE `version_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actor_table`
--
ALTER TABLE `actor_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `category_table`
--
ALTER TABLE `category_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `channel_table`
--
ALTER TABLE `channel_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comment_table`
--
ALTER TABLE `comment_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `country_table`
--
ALTER TABLE `country_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `device_table`
--
ALTER TABLE `device_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `episode_table`
--
ALTER TABLE `episode_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fos_user_table`
--
ALTER TABLE `fos_user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `gallery_table`
--
ALTER TABLE `gallery_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genre_table`
--
ALTER TABLE `genre_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `language_table`
--
ALTER TABLE `language_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `media_table`
--
ALTER TABLE `media_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;

--
-- AUTO_INCREMENT for table `poster_table`
--
ALTER TABLE `poster_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `rate_table`
--
ALTER TABLE `rate_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role_table`
--
ALTER TABLE `role_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `season_table`
--
ALTER TABLE `season_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings_table`
--
ALTER TABLE `settings_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `slide_table`
--
ALTER TABLE `slide_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `source_table`
--
ALTER TABLE `source_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `subtitle_table`
--
ALTER TABLE `subtitle_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_pack_table`
--
ALTER TABLE `sub_pack_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `support_table`
--
ALTER TABLE `support_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `verify_table`
--
ALTER TABLE `verify_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `version_table`
--
ALTER TABLE `version_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actor_table`
--
ALTER TABLE `actor_table`
  ADD CONSTRAINT `FK_D2AD64D2EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`);

--
-- Constraints for table `category_table`
--
ALTER TABLE `category_table`
  ADD CONSTRAINT `FK_1E1AC00FEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`);

--
-- Constraints for table `channels_categories`
--
ALTER TABLE `channels_categories`
  ADD CONSTRAINT `FK_5D59DF4812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category_table` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5D59DF4872F5A1AA` FOREIGN KEY (`channel_id`) REFERENCES `channel_table` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `channel_table`
--
ALTER TABLE `channel_table`
  ADD CONSTRAINT `FK_410887DEEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`),
  ADD CONSTRAINT `channel_table_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country_table` (`id`);

--
-- Constraints for table `comment_table`
--
ALTER TABLE `comment_table`
  ADD CONSTRAINT `FK_5FB317B75BB66C05` FOREIGN KEY (`poster_id`) REFERENCES `poster_table` (`id`),
  ADD CONSTRAINT `FK_5FB317B772F5A1AA` FOREIGN KEY (`channel_id`) REFERENCES `channel_table` (`id`),
  ADD CONSTRAINT `FK_5FB317B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user_table` (`id`);

--
-- Constraints for table `country_table`
--
ALTER TABLE `country_table`
  ADD CONSTRAINT `FK_51C99AACEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`);

--
-- Constraints for table `episode_table`
--
ALTER TABLE `episode_table`
  ADD CONSTRAINT `FK_CD2379124EC001D1` FOREIGN KEY (`season_id`) REFERENCES `season_table` (`id`),
  ADD CONSTRAINT `FK_CD237912EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`),
  ADD CONSTRAINT `FK_CD237912FDFF2E92` FOREIGN KEY (`thumbnail_id`) REFERENCES `media_table` (`id`);

--
-- Constraints for table `fos_user_table`
--
ALTER TABLE `fos_user_table`
  ADD CONSTRAINT `FK_C3D4D4BDEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`);

--
-- Constraints for table `language_table`
--
ALTER TABLE `language_table`
  ADD CONSTRAINT `FK_89718B17EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`);

--
-- Constraints for table `medias_gallerys_table`
--
ALTER TABLE `medias_gallerys_table`
  ADD CONSTRAINT `FK_CC965DCE4E7AF8F` FOREIGN KEY (`gallery_id`) REFERENCES `gallery_table` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CC965DCEEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posters_genres`
--
ALTER TABLE `posters_genres`
  ADD CONSTRAINT `FK_888D8634296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre_table` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_888D8635BB66C05` FOREIGN KEY (`poster_id`) REFERENCES `poster_table` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `poster_table`
--
ALTER TABLE `poster_table`
  ADD CONSTRAINT `FK_2AD24832EC46446` FOREIGN KEY (`posted_id`) REFERENCES `media_table` (`id`),
  ADD CONSTRAINT `FK_2AD2483922726E9` FOREIGN KEY (`cover_id`) REFERENCES `media_table` (`id`),
  ADD CONSTRAINT `FK_2AD2483B6C04CFD` FOREIGN KEY (`trailer_id`) REFERENCES `source_table` (`id`),
  ADD CONSTRAINT `poster_table_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country_table` (`id`);

--
-- Constraints for table `rate_table`
--
ALTER TABLE `rate_table`
  ADD CONSTRAINT `FK_666996655BB66C05` FOREIGN KEY (`poster_id`) REFERENCES `poster_table` (`id`),
  ADD CONSTRAINT `FK_6669966572F5A1AA` FOREIGN KEY (`channel_id`) REFERENCES `channel_table` (`id`),
  ADD CONSTRAINT `FK_66699665A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user_table` (`id`);

--
-- Constraints for table `role_table`
--
ALTER TABLE `role_table`
  ADD CONSTRAINT `FK_1F5676910DAF24A` FOREIGN KEY (`actor_id`) REFERENCES `actor_table` (`id`),
  ADD CONSTRAINT `FK_1F567695BB66C05` FOREIGN KEY (`poster_id`) REFERENCES `poster_table` (`id`);

--
-- Constraints for table `season_table`
--
ALTER TABLE `season_table`
  ADD CONSTRAINT `FK_E11878995BB66C05` FOREIGN KEY (`poster_id`) REFERENCES `poster_table` (`id`);

--
-- Constraints for table `settings_table`
--
ALTER TABLE `settings_table`
  ADD CONSTRAINT `FK_4EF0C90FEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`);

--
-- Constraints for table `slide_table`
--
ALTER TABLE `slide_table`
  ADD CONSTRAINT `FK_77A0596512469DE2` FOREIGN KEY (`category_id`) REFERENCES `category_table` (`id`),
  ADD CONSTRAINT `FK_77A059654296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre_table` (`id`),
  ADD CONSTRAINT `FK_77A059655BB66C05` FOREIGN KEY (`poster_id`) REFERENCES `poster_table` (`id`),
  ADD CONSTRAINT `FK_77A0596572F5A1AA` FOREIGN KEY (`channel_id`) REFERENCES `channel_table` (`id`),
  ADD CONSTRAINT `FK_77A05965EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`);

--
-- Constraints for table `source_table`
--
ALTER TABLE `source_table`
  ADD CONSTRAINT `FK_6F215479362B62A0` FOREIGN KEY (`episode_id`) REFERENCES `episode_table` (`id`),
  ADD CONSTRAINT `FK_6F2154795BB66C05` FOREIGN KEY (`poster_id`) REFERENCES `poster_table` (`id`),
  ADD CONSTRAINT `FK_6F21547972F5A1AA` FOREIGN KEY (`channel_id`) REFERENCES `channel_table` (`id`),
  ADD CONSTRAINT `FK_6F215479EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`);

--
-- Constraints for table `subtitle_table`
--
ALTER TABLE `subtitle_table`
  ADD CONSTRAINT `FK_79585A84362B62A0` FOREIGN KEY (`episode_id`) REFERENCES `episode_table` (`id`),
  ADD CONSTRAINT `FK_79585A845BB66C05` FOREIGN KEY (`poster_id`) REFERENCES `poster_table` (`id`),
  ADD CONSTRAINT `FK_79585A8482F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `language_table` (`id`),
  ADD CONSTRAINT `FK_79585A84EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media_table` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
