-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2023 at 07:56 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `w3cms_install`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` tinyint(4) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 => Published, 2 => Draft, 3 => Trash, 4 => Private, 5 => Pending',
  `visibility` enum('Pu','PP','Pr') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pu => Public, PP => Password Protected, Pr => Private',
  `publish_on` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `user_id`, `title`, `slug`, `content`, `excerpt`, `comment`, `password`, `status`, `visibility`, `publish_on`, `created_at`, `updated_at`) VALUES
(1, 1, 'Hello world!', 'hello-world', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', 0, '12345678', 1, 'Pu', '2022-08-31 00:00:00', '2022-08-30 23:31:56', '2023-02-11 03:49:04');

-- --------------------------------------------------------

--
-- Table structure for table `blog_blog_categories`
--

CREATE TABLE `blog_blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `blog_category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_blog_tags`
--

CREATE TABLE `blog_blog_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `blog_tag_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_metas`
--

CREATE TABLE `blog_metas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `blog_seos`
--

CREATE TABLE `blog_seos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_descriptions` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blog_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_tags`
--

CREATE TABLE `blog_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editable` tinyint(4) NOT NULL DEFAULT 1,
  `weight` int(11) DEFAULT NULL,
  `params` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`id`, `name`, `value`, `title`, `description`, `input_type`, `editable`, `weight`, `params`, `order`) VALUES
(1, 'Site.title', 'W3CMS Laravel', NULL, NULL, 'text', 1, 1, NULL, 0),
(2, 'Site.tagline', 'W3CMS Laravel System', NULL, NULL, 'textarea', 1, 2, NULL, 3),
(3, 'Site.email', 'test@dexignlab.com', NULL, NULL, 'text', 1, 3, NULL, 2),
(4, 'Site.status', '1', NULL, NULL, 'checkbox', 1, 4, NULL, 4),
(5, 'Site.copyright', 'Crafted with <span class=\"heart\"></span> by <a href=\"https://www.w3itexperts.com/\\\" target=\\\"_blank\\\">W3ITEXPERTS</a>', 'Copyright Text', NULL, 'text', 1, 5, NULL, 5),
(6, 'Site.footer_text', 'Developed by <a href=\"https://www.w3itexperts.com/\\\" target=\\\"_blank\\\">W3itexperts</a>', 'Footer text', NULL, 'textarea', 1, 6, NULL, 6),
(7, 'Site.coming_soon', '0', NULL, NULL, 'checkbox', 1, 7, NULL, 7),
(8, 'Site.contact', '1234567890', NULL, NULL, 'text', 1, 8, NULL, 8),
(9, 'Site.logo', '1673435349.logo-full-black.png', 'Logo', 'Site Logo', 'file', 1, 9, NULL, 9),
(10, 'Site.favicon', '1673435350.favicon.png', 'Site Favicon', 'Site Favicon', 'file', 1, 10, NULL, 10),
(11, 'Site.maintenance_message', 'PLEASE SORRY FOR THE <span class=\"text-primary\">DISTURBANCES</span>', 'Maintenance Message', 'Site down for maintenance Message will show on maintenance page', 'textarea', 1, 11, NULL, 13),
(12, 'Site.comingsoon_message', 'We Are Coming Soon !', 'Coming Soon Message', 'Coming soon message will show on coming soon page', 'textarea', 1, 12, NULL, 11),
(13, 'Site.text_logo', '1673435350.logo-text.png', 'Text Logo', NULL, 'file', 1, 13, NULL, 12),
(14, 'Writing.editable', '1', 'Enable WYSIWYG editor', NULL, 'checkbox', 1, 14, NULL, 14),
(15, 'Reading.nodes_per_page', '10', NULL, NULL, 'text', 1, 15, NULL, 15),
(16, 'Reading.date_time_format', 'M. d, Y, g:i A', NULL, 'Formates :- <br>\r\nF j, Y, g:i a (November 23, 2022, 5:45 am), <br>\r\nY-m-d , H:i (2022-11-23, 05:45), <br>\r\nm/d/Y (11/23/2022), <br>\r\nd/m/Y(23/11/2022)', 'text', 1, 16, NULL, 16),
(17, 'Social.instagram', 'https://www.instagram.com/', 'Instagram Url', NULL, 'text', 1, 17, NULL, 17),
(18, 'Social.linkedin', 'https://www.in.linkedin.com/', 'Whatsapp Url', NULL, 'text', 1, 17, NULL, 17),
(19, 'Social.facebook', 'http://www.facebook.com', 'Facebook Url', NULL, 'text', 1, 18, NULL, 18),
(20, 'Social.twitter', 'http://www.twitter.com', 'Twitter Url', NULL, 'text', 1, 19, NULL, 19),
(21, 'Site.menu_location', 'a:5:{.htaccess:7:\"primary\";a:2:{.htaccess:5:\"title\";.htaccess:23:\"Desktop Horizontal Menu\";.htaccess:4:\"menu\";.htaccess:1:\"1\";}.htaccess:8:\"expanded\";a:2:{.htaccess:5:\"title\";.htaccess:21:\"Desktop Expanded Menu\";.htaccess:4:\"menu\";.htaccess:1:\"3\";}.htaccess:6:\"mobile\";a:2:{.htaccess:5:\"title\";.htaccess:11:\"Mobile Menu\";.htaccess:4:\"menu\";N;}.htaccess:6:\"footer\";a:2:{.htaccess:5:\"title\";.htaccess:11:\"Footer Menu\";.htaccess:4:\"menu\";.htaccess:1:\"2\";}.htaccess:6:\"social\";a:2:{.htaccess:5:\"title\";.htaccess:11:\"Social Menu\";.htaccess:4:\"menu\";.htaccess:0:\"\";}}', NULL, NULL, 'text', 0, 20, NULL, 20),
(22, 'Permalink.settings', '/%slug%/', '', NULL, 'text', 1, 21, NULL, 21),
(23, 'Reading.show_on_front', 'Post', NULL, '(Home Page)', 'radio', 1, 22, 'Post,Page', 22),
(24, 'Widget.show_sidebar', '1', NULL, NULL, 'checkbox', 1, NULL, '1', 0),
(25, 'Widget.show_recent_post_widget', '1', NULL, NULL, 'checkbox', 1, NULL, '1', 0),
(26, 'Widget.show_category_widget', '1', NULL, '', 'checkbox', 1, NULL, '1', 0),
(27, 'Widget.show_archives_widget', '1', NULL, '', 'checkbox', 1, NULL, '1', 0),
(28, 'Widget.show_search_widget', '1', NULL, NULL, 'checkbox', 1, NULL, '1', 0),
(29, 'Widget.show_tags_widget', '1', NULL, '', 'checkbox', 1, NULL, '1', 0),
(30, 'Site.comingsoon_date', '2023-01-05', NULL, '', 'date', 1, NULL, '', 0),
(31, 'Site.biography', 'A Wonderful Serenity Has Taken Possession Of My Entire Soul, Like These.', NULL, '', 'text', 1, NULL, '', 0),
(32, 'Site.location', '832  Thompson Drive, San Fransisco CA 94107, United States', NULL, '', 'text', 1, NULL, '', 0),
(33, 'Site.office_time', 'Time 09:00 AM To 07:00 PM', NULL, 'Ex. : \"Time 06:00 AM To 08:00 PM\'', 'text', 1, NULL, '', 0),
(34, 'Site.icon_logo', '1673520377.image_2023_01_02T08_30_32_811Z.png', NULL, '', 'file', 1, NULL, '', 0),
(35, 'Theme.home_slider', 'hVb2rBZWmSvbwac23xvFwB6VV3LjjsctQA5kWzZu.jpg,o5EKtmWHB6jkANLnFpnoqRHUy7RWH7xBsmMulGAp.jpg,h3sl5YReWHNyyeDaIf4a7mH3pamyCkmrVUuI59Ar.jpg', 'Home Banner Slider', 'Select Images for home banner slider', 'multiple_file', 1, NULL, NULL, 0),
(36, 'Site.w3cms_locale', 'en', 'Select Language', '', 'select', 1, NULL, 'en,hi,fr,ru', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Admin','User') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'A => Admin, U => User',
  `order` bigint(20) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `user_id`, `title`, `slug`, `type`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Primary Menu', 'primary-menu', NULL, 1, '2022-12-26 08:10:57', '2023-02-11 04:09:12'),
(2, 1, 'Footer Menu', 'footer-menu', NULL, 2, '2022-11-03 05:55:38', '2023-02-11 04:09:53'),
(3, 1, 'Expanded Menu', 'secodary-menu', NULL, 3, '2022-11-03 05:57:00', '2023-02-11 04:57:53');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) DEFAULT 0,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) DEFAULT 0,
  `type` enum('Page','Link','Category','Post','Tag') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Page, Link, Category, Post, Tag',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_target` tinyint(4) DEFAULT 0,
  `css_classes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` bigint(20) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `parent_id`, `menu_id`, `item_id`, `type`, `title`, `attribute`, `link`, `menu_target`, `css_classes`, `description`, `order`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 1, 'Page', 'Home', 'Home', '', 0, '', '', 0, '2023-02-11 04:05:15', '2023-02-11 04:09:12'),
(2, 0, 3, 1, 'Page', 'Home', 'Home', '', 0, '', '', 0, '2023-02-11 04:30:35', '2023-02-11 04:57:53'),
(3, 0, 2, 1, 'Page', 'Home', 'Home', NULL, 0, NULL, NULL, 147, '2023-02-11 04:30:53', '2023-02-11 04:30:53');

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
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_06_22_115736_create_configurations_table', 1),
(7, '2021_10_21_093713_create_temp_permissions_tables', 1),
(8, '2021_10_21_093714_create_permission_tables', 1),
(9, '2021_10_23_113846_create_sessions_table', 1),
(10, '2021_11_01_070431_create_pages_table', 1),
(11, '2021_11_01_070450_create_page_metas_table', 1),
(12, '2021_11_01_070459_create_page_seos_table', 1),
(13, '2021_11_12_103141_create_blogs_table', 1),
(14, '2021_11_12_103153_create_blog_tags_table', 1),
(15, '2021_11_12_103159_create_blog_metas_table', 1),
(16, '2021_11_12_103208_create_blog_categories_table', 1),
(17, '2021_11_12_103209_create_blog_blog_categories_table', 1),
(18, '2021_11_12_103216_create_blog_blog_tags_table', 1),
(19, '2021_11_12_103305_create_blog_seos_table', 1),
(20, '2022_01_21_064821_create_menus_table', 1),
(21, '2022_01_21_064832_create_menu_items_table', 1),
(22, '2022_12_17_114134_create_contacts_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `deny` tinyint(4) NOT NULL DEFAULT 0
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

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_type` enum('Page','Widget') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` tinyint(4) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 => Published, 2 => Draft, 3 => Trash, 4 => Private, 5 => Pending',
  `visibility` enum('Pu','PP','Pr') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pu => Public, PP => Password Protected, Pr => Private',
  `publish_on` datetime DEFAULT NULL,
  `order` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `parent_id`, `user_id`, `title`, `slug`, `page_type`, `content`, `excerpt`, `comment`, `password`, `status`, `visibility`, `publish_on`, `order`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Home', 'home', NULL, '<!-- Crypto Coins Start -->\n<div class=\"clearfix bg-primary-light\">\n  <div class=\"container\">\n   <div class=\"currancy-wrapper\">\n      <div class=\"row justify-content-center\">\n        <div class=\"col-lg-4 col-md-6 m-b30 wow fadeInUp\" data-wow-delay=\"0.2s\">\n          <div class=\"icon-bx-wraper style-1 box-hover\">\n            <div class=\"icon-media\">\n              <img src=\"front/images/coins/coin4.png\" alt=\"\">\n              <div class=\"icon-info\">\n               <h5 class=\"title\">Bitcoin</h5>\n                <span>BTC</span>\n              </div>\n            </div>\n            <div class=\"icon-content\">\n              <ul class=\"price\">\n                <li>\n                  <h6 class=\"mb-0 amount\">$16,048.40</h6>\n                 <span class=\"text-red percentage\">-1.26%</span>\n               </li>\n               <li>\n                  <span>Latest price</span>\n                 <span>24h change</span>\n               </li>\n             </ul>\n           </div>\n          </div>\n        </div>\n        <div class=\"col-lg-4 col-md-6 m-b30 wow fadeInUp\" data-wow-delay=\"0.4s\">\n          <div class=\"icon-bx-wraper style-1 box-hover\">\n            <div class=\"icon-media\">\n              <img src=\"front/images/coins/coin3.png\" alt=\"\">\n              <div class=\"icon-info\">\n               <h5 class=\"title\">Ethereum</h5>\n               <span>ETH</span>\n              </div>\n            </div>\n            <div class=\"icon-content\">\n              <ul class=\"price\">\n                <li>\n                  <h6 class=\"mb-0 amount\">$1,122.44</h6>\n                  <span class=\"text-red percentage\">-1.55%</span>\n               </li>\n               <li>\n                  <span>Latest price</span>\n                 <span>24h change</span>\n               </li>\n             </ul>\n           </div>\n          </div>\n        </div>\n        <div class=\"col-lg-4 col-md-6 m-b30 wow fadeInUp\" data-wow-delay=\"0.6s\">\n          <div class=\"icon-bx-wraper style-1 box-hover\">\n            <div class=\"icon-media\">\n              <img src=\"front/images/coins/coin1.png\" alt=\"\">\n              <div class=\"icon-info\">\n               <h5 class=\"title\">Tether</h5>\n               <span>USDT</span>\n             </div>\n            </div>\n            <div class=\"icon-content\">\n              <ul class=\"price\">\n                <li>\n                  <h6 class=\"mb-0 amount\">$1.00</h6>\n                  <span class=\"text-green percentage\">0.0099%</span>\n                </li>\n               <li>\n                  <span>Latest price</span>\n                 <span>24h change</span>\n               </li>\n             </ul>\n           </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n<!-- Crypto Coins End -->\n\n<!-- Why Trust Us Start -->\n<section class=\"clearfix section-wrapper1 bg-primary-light\">\n  <div class=\"container\">\n   <div class=\"content-inner-1\">\n     <div class=\"section-head text-center\">\n        <h2 class=\"title\">Why Trust Us?</h2>\n        <p>Trust comes from experience. Many of the pleased customers may function as a guide for you.</p>\n      </div>\n      <div class=\"row\">\n       <div class=\"col-lg-6 m-b30 wow fadeInUp\" data-wow-delay=\"0.2s\">\n         <div class=\"icon-bx-wraper style-2\">\n            <div class=\"icon-media\">\n              <img src=\"front/images/icons/wallet.svg\" alt=\"\">\n           </div>\n            <div class=\"icon-content\">\n              <h4 class=\"title\">Buy Cryptocurrency with cash</h4>\n             <p>Lorem Ipsum has been the industry\'.htaccess standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>\n              <a class=\"btn btn-primary btn-gradient btn-shadow\" href=\"javascript:void(0);\">Read More</a>\n           </div>\n          </div>\n        </div>            \n        <div class=\"col-lg-6 m-b30 wow fadeInUp\" data-wow-delay=\"0.4s\">\n         <div class=\"icon-bx-wraper style-2\">\n            <div class=\"icon-media\">\n              <img src=\"front/images/icons/friend.svg\" alt=\"\">\n           </div>\n            <div class=\"icon-content\">\n              <h4 class=\"title\">Cryptocurrency Consultancy</h4>\n             <p>Lorem Ipsum has been the industry\'.htaccess standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>\n              <a class=\"btn btn-primary btn-gradient btn-shadow\" href=\"javascript:void(0);\">Read More</a>\n           </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n  <div class=\"container\">\n   <div class=\"form-wrapper-box style-1 text-center\">\n      <div class=\"section-head wow fadeInUp\" data-wow-delay=\"0.2s\">\n       <h4 class=\"title m-t0\">How to Purchase from us ?</h4>\n       <p>Fill out the below form and we will contact you via email & details</p>\n      </div>\n      <form method=\"POST\" class=\"dz-form\" action=\"#\">\n       <div class=\"form-wrapper\">\n          <div class=\"flex-1\">\n            <div class=\"row g-3\">\n             <div class=\"col-xl-3 col-md-6 wow fadeInUp\" data-wow-delay=\"0.2s\">\n                <input name=\"dzName\" type=\"text\" required=\"\" placeholder=\"Wallet Address\" class=\"form-control\">\n             </div>\n              <div class=\"col-xl-3 col-md-6 wow fadeInUp\" data-wow-delay=\"0.4s\">\n                <select class=\"form-control custom-image-select-1 image-select\">\n                  <option data-thumbnail=\"front/images/coins/coin4.png\">Bitcoin</option>\n                 <option data-thumbnail=\"front/images/coins/coin3.png\">Ethereum</option>\n                  <option data-thumbnail=\"front/images/coins/coin1.png\">Tether</option>\n                </select>\n             </div>\n              <div class=\"col-xl-3 col-md-6 wow fadeInUp\" data-wow-delay=\"0.6s\">\n                <input name=\"dzName\" type=\"text\" required=\"\" placeholder=\"How much worth in $?\" class=\"form-control\">\n             </div>\n              <div class=\"col-xl-3 col-md-6 wow fadeInUp\" data-wow-delay=\"0.8s\">\n                <input name=\"dzName\" type=\"text\" required=\"\" placeholder=\"Email Address\" class=\"form-control\">\n              </div>\n            </div>\n          </div>\n          <button type=\"submit\" class=\"btn btn-lg btn-gradient btn-primary btn-shadow\">Get Strated</button>\n       </div>\n      </form>\n   </div>\n  </div>\n  <img class=\"bg-shape1\" src=\"front/images/home-banner/shape1.png\" alt=\"\">\n</section>\n<!-- Why Trust Us End -->\n\n<!-- Crypto From And Services Start -->\n<section class=\"content-inner bg-light icon-section section-wrapper2\">\n <div class=\"container\">\n   <div class=\"section-head text-center\">\n      <h2 class=\"title\">One-stop solution to buy and sell <span class=\"text-primary\"> cryptocurrency </span> with Cash</h2>\n   </div>\n    <div class=\"row sp60\">\n      <div class=\"col-xl-4 col-md-6 m-b60 wow fadeInUp\" data-wow-delay=\"0.2s\">\n        <div class=\"icon-bx-wraper style-3 text-center\">\n          <div class=\"icon-media\">\n            <img src=\"front/images/icons/icon9.svg\" alt=\"\">\n          </div>\n          <div class=\"icon-content\">\n            <h4 class=\"title\">Competitive Pricing</h4>\n            <p class=\"m-b0\">Lorem Ipsum has been the industry\'.htaccess standard dummy text ever since the 1500s, when an unknown printer.</p>\n         </div>\n        </div>\n      </div>\n      <div class=\"col-xl-4 col-md-6 m-b60 wow fadeInUp\" data-wow-delay=\"0.4s\">\n        <div class=\"icon-bx-wraper style-3 text-center\">\n          <div class=\"icon-media\">\n            <img src=\"front/images/icons/icon10.svg\" alt=\"\">\n         </div>\n          <div class=\"icon-content\">\n            <h4 class=\"title\">Support</h4>\n            <p class=\"m-b0\">Lorem Ipsum has been the industry\'.htaccess standard dummy text ever since the 1500s, when an unknown printer.</p>\n         </div>\n        </div>\n      </div>\n      <div class=\"col-xl-4 col-md-6 m-b60 wow fadeInUp\" data-wow-delay=\"0.6s\">\n        <div class=\"icon-bx-wraper style-3 text-center\">\n          <div class=\"icon-media\">\n            <img src=\"front/images/icons/icon11.svg\" alt=\"\">\n         </div>\n          <div class=\"icon-content\">\n            <h4 class=\"title\">Fast and Easy KYC</h4>\n            <p class=\"m-b0\">Lorem Ipsum has been the industry\'.htaccess standard dummy text ever since the 1500s, when an unknown printer.</p>\n         </div>\n        </div>\n      </div>\n      <div class=\"col-xl-4 col-md-6 m-b60 wow fadeInUp\" data-wow-delay=\"0.8s\">\n        <div class=\"icon-bx-wraper style-3 text-center\">\n          <div class=\"icon-media\">\n            <img src=\"front/images/icons/icon12.svg\" alt=\"\">\n         </div>\n          <div class=\"icon-content\">\n            <h4 class=\"title\">Security</h4>\n           <p class=\"m-b0\">Lorem Ipsum has been the industry\'.htaccess standard dummy text ever since the 1500s, when an unknown printer.</p>\n         </div>\n        </div>\n      </div>\n      <div class=\"col-xl-4 col-md-6 m-b60 wow fadeInUp\" data-wow-delay=\"1.0s\">\n        <div class=\"icon-bx-wraper style-3 text-center\">\n          <div class=\"icon-media\">\n            <img src=\"front/images/icons/icon13.svg\" alt=\"\">\n         </div>\n          <div class=\"icon-content\">\n            <h4 class=\"title\">Fast Transaction</h4>\n           <p class=\"m-b0\">Every minute counts when buying or selling in cryptocurrencies. Complete your transactions as quickly as possible.</p>\n          </div>\n        </div>\n      </div>\n      <div class=\"col-xl-4 col-md-6 m-b60 wow fadeInUp\" data-wow-delay=\"1.2s\">\n        <div class=\"icon-bx-wraper style-4\" style=\"background-image: url(front/images/about/pic1.jpg);\">\n         <div class=\"inner-content\">\n           <div class=\"icon-media m-b30\">\n              <img src=\"front/images/icons/support1.png\" alt=\"\">\n           </div>\n            <div class=\"icon-content\">\n              <a href=\"javascript:void(0);\" class=\"btn btn-primary\">Call Us</a>\n           </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n  <img class=\"bg-shape1\" src=\"front/images/home-banner/shape1.png\" alt=\"\">\n</section>\n<!-- Crypto From And Services End -->\n\n<!-- From Our Blog Start -->\n<section class=\"content-inner bg-white blog-wrapper\">\n <img class=\"bg-shape1\" src=\"front/images/home-banner/shape1.png\" alt=\"\">\n\n <div class=\"container\">\n   <div class=\"row\">\n     <div class=\"col-xl-7 col-lg-12\">\n        <div class=\"section-head wow fadeInUp\" data-wow-delay=\"0.2s\">\n         <h6 class=\"sub-title text-primary\">FROM OUR BLOG</h6>\n         <h2 class=\"title\">Recent News &amp; Updates</h2>\n        </div>\n        <div class=\"dz-card style-1 blog-half m-b30 wow fadeInUp\" data-wow-delay=\"0.4s\">\n          <div class=\"dz-media\">\n            <a href=\"javascript:void(0);\"><img src=\"front/images/blog/pic1.jpg\" alt=\"\"></a>\n            <ul class=\"dz-badge-list\">\n              <li><a href=\"javascript:void(0);\" class=\"dz-badge\">14 February 2023</a></li>\n            </ul>\n           <a href=\"javascript:void(0);\" class=\"btn btn-secondary\">Read More</a>\n         </div>\n          <div class=\"dz-info\">\n           <div class=\"dz-meta\">\n             <ul>\n                <li class=\"post-author\">\n                  <a href=\"javascript:void(0);\">\n                    <img src=\"front/images/avatar/avatar1.jpg\" alt=\"\">\n                   <span>By Noare</span>\n                 </a>\n                </li>\n               <li class=\"post-date\"><a href=\"javascript:void(0);\"> 12 May 2022</a></li>\n             </ul>\n           </div>\n            <h4 class=\"dz-title\"><a href=\"javascript:void(0);\">Five Things To Avoid In Cryptocurrency.</a></h4>\n           <p class=\"m-b0\">Nostrud tem exrcitation duis laboris nisi ut aliquip sed duis aute.</p>\n         </div>\n        </div>\n        <div class=\"dz-card style-1 blog-half m-b30 wow fadeInUp\" data-wow-delay=\"0.6s\">\n          <div class=\"dz-media\">\n            <a href=\"javascript:void(0);\"><img src=\"front/images/blog/pic2.jpg\" alt=\"\"></a>\n            <ul class=\"dz-badge-list\">\n              <li><a href=\"javascript:void(0);\" class=\"dz-badge\">14 February 2023</a></li>\n            </ul>\n           <a href=\"javascript:void(0);\" class=\"btn btn-secondary\">Read More</a>\n         </div>\n          <div class=\"dz-info\">\n           <div class=\"dz-meta\">\n             <ul>\n                <li class=\"post-author\">\n                  <a href=\"javascript:void(0);\">\n                    <img src=\"front/images/avatar/avatar2.jpg\" alt=\"\">\n                   <span>By Noare</span>\n                 </a>\n                </li>\n               <li class=\"post-date\"><a href=\"javascript:void(0);\"> 12 May 2022</a></li>\n             </ul>\n           </div>\n            <h4 class=\"dz-title\"><a href=\"javascript:void(0);\">Things That Make You Love Cryptocurrency.</a></h4>\n           <p class=\"m-b0\">Nostrud tem exrcitation duis laboris nisi ut aliquip sed duis aute.</p>\n         </div>\n        </div>\n      </div>\n      <div class=\"col-xl-5 col-lg-12 m-b30 wow fadeInUp\" data-wow-delay=\"0.8s\">\n       <div class=\"dz-card style-2\" style=\"background-image: url(front/images/blog/blog-ig.png)\">\n         <div class=\"dz-category\">\n           <ul class=\"dz-badge-list\">\n              <li><a href=\"javascript:void(0);\" class=\"dz-badge\">14 February 2023</a></li>\n            </ul>\n         </div>\n          <div class=\"dz-info\">\n           <h2 class=\"dz-title\"><a href=\"javascript:void(0);\" class=\"text-white\">Directly support individuals Crypto</a></h2>\n            <div class=\"dz-meta\">\n             <ul>\n                <li class=\"post-author\">\n                  <a href=\"javascript:void(0);\">\n                    <img src=\"front/images/avatar/avatar3.jpg\" alt=\"\">\n                   <span>By Noare</span>\n                 </a>\n                </li>\n               <li class=\"post-date\"><a href=\"javascript:void(0);\"> 12 May 2022</a></li>\n             </ul>\n           </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</section>\n<!-- From Our Blog End -->\n\n', 'Excerpt2', 1, '123456', 1, 'Pu', '2022-10-31 00:00:00', NULL, '2022-10-31 07:00:14', '2023-01-05 01:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `page_metas`
--

CREATE TABLE `page_metas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `page_seos`
--

CREATE TABLE `page_seos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_descriptions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `temp_permission_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('pre-define','user-define') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user-define',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `temp_permission_id`, `name`, `action`, `guard_name`, `type`, `created_at`, `updated_at`) VALUES
(1, 4, 'Controllers > PermissionsController > index', 'Controllers/PermissionsController@index', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(2, 5, 'Controllers > PermissionsController > roles_permissions', 'Controllers/PermissionsController@roles_permissions', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(3, 6, 'Controllers > PermissionsController > role_permissions', 'Controllers/PermissionsController@role_permissions', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(4, 7, 'Controllers > PermissionsController > user_permissions', 'Controllers/PermissionsController@user_permissions', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(5, 8, 'Controllers > PermissionsController > manage_user_permissions', 'Controllers/PermissionsController@manage_user_permissions', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(6, 9, 'Controllers > PermissionsController > sync', 'Controllers/PermissionsController@sync', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(7, 10, 'Controllers > PermissionsController > manage_role_all_permissions', 'Controllers/PermissionsController@manage_role_all_permissions', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(8, 11, 'Controllers > PermissionsController > manage_role_permission', 'Controllers/PermissionsController@manage_role_permission', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(9, 12, 'Controllers > PermissionsController > manage_user_permission', 'Controllers/PermissionsController@manage_user_permission', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(10, 13, 'Controllers > PermissionsController > delete_user_permission', 'Controllers/PermissionsController@delete_user_permission', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(11, 14, 'Controllers > PermissionsController > remove_user_all_permission', 'Controllers/PermissionsController@remove_user_all_permission', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(12, 15, 'Controllers > PermissionsController > temp_permissions', 'Controllers/PermissionsController@temp_permissions', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(13, 16, 'Controllers > PermissionsController > generate_permissions', 'Controllers/PermissionsController@generate_permissions', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(14, 17, 'Controllers > PermissionsController > add_to_permissions', 'Controllers/PermissionsController@add_to_permissions', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(15, 18, 'Controllers > PermissionsController > permission_by_action', 'Controllers/PermissionsController@permission_by_action', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(16, 19, 'Controllers > PermissionsController > get_users_by_role', 'Controllers/PermissionsController@get_users_by_role', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(17, 20, 'Controllers > PermissionsController > get_permission_by_user', 'Controllers/PermissionsController@get_permission_by_user', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(18, 22, 'Controllers > UsersController > dashboard', 'Controllers/UsersController@dashboard', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(19, 23, 'Controllers > UsersController > index', 'Controllers/UsersController@index', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(20, 24, 'Controllers > UsersController > create', 'Controllers/UsersController@create', 'web', 'user-define', '2022-12-13 07:20:56', '2022-12-13 07:20:56'),
(21, 25, 'Controllers > UsersController > store', 'Controllers/UsersController@store', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(22, 26, 'Controllers > UsersController > edit', 'Controllers/UsersController@edit', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(23, 27, 'Controllers > UsersController > update', 'Controllers/UsersController@update', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(24, 28, 'Controllers > UsersController > destroy', 'Controllers/UsersController@destroy', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(25, 29, 'Controllers > UsersController > update_password', 'Controllers/UsersController@update_password', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(26, 30, 'Controllers > UsersController > update_user_roles', 'Controllers/UsersController@update_user_roles', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(27, 31, 'Controllers > UsersController > profile', 'Controllers/UsersController@profile', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(28, 33, 'Controllers > RolesController > index', 'Controllers/RolesController@index', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(29, 34, 'Controllers > RolesController > create', 'Controllers/RolesController@create', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(30, 35, 'Controllers > RolesController > store', 'Controllers/RolesController@store', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(31, 36, 'Controllers > RolesController > edit', 'Controllers/RolesController@edit', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(32, 37, 'Controllers > RolesController > update', 'Controllers/RolesController@update', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(33, 38, 'Controllers > RolesController > destroy', 'Controllers/RolesController@destroy', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(34, 40, 'Controllers > BlogsController > admin_index', 'Controllers/BlogsController@admin_index', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(35, 41, 'Controllers > BlogsController > admin_create', 'Controllers/BlogsController@admin_create', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(36, 42, 'Controllers > BlogsController > admin_store', 'Controllers/BlogsController@admin_store', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(37, 43, 'Controllers > BlogsController > admin_edit', 'Controllers/BlogsController@admin_edit', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(38, 44, 'Controllers > BlogsController > admin_update', 'Controllers/BlogsController@admin_update', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(39, 45, 'Controllers > BlogsController > admin_destroy', 'Controllers/BlogsController@admin_destroy', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(40, 46, 'Controllers > BlogsController > admin_trash_status', 'Controllers/BlogsController@admin_trash_status', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(41, 47, 'Controllers > BlogsController > remove_feature_image', 'Controllers/BlogsController@remove_feature_image', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(42, 49, 'Controllers > BlogCategoriesController > list', 'Controllers/BlogCategoriesController@list', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(43, 50, 'Controllers > BlogCategoriesController > admin_index', 'Controllers/BlogCategoriesController@admin_index', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(44, 51, 'Controllers > BlogCategoriesController > admin_create', 'Controllers/BlogCategoriesController@admin_create', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(45, 52, 'Controllers > BlogCategoriesController > admin_store', 'Controllers/BlogCategoriesController@admin_store', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(46, 53, 'Controllers > BlogCategoriesController > admin_edit', 'Controllers/BlogCategoriesController@admin_edit', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(47, 54, 'Controllers > BlogCategoriesController > admin_update', 'Controllers/BlogCategoriesController@admin_update', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(48, 55, 'Controllers > BlogCategoriesController > admin_destroy', 'Controllers/BlogCategoriesController@admin_destroy', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(49, 56, 'Controllers > BlogCategoriesController > admin_trash_status', 'Controllers/BlogCategoriesController@admin_trash_status', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(50, 57, 'Controllers > BlogCategoriesController > admin_ajax_add_category', 'Controllers/BlogCategoriesController@admin_ajax_add_category', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(51, 58, 'Controllers > BlogCategoriesController > admin_moveup', 'Controllers/BlogCategoriesController@admin_moveup', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(52, 59, 'Controllers > BlogCategoriesController > admin_movedown', 'Controllers/BlogCategoriesController@admin_movedown', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(53, 61, 'Controllers > PagesController > admin_index', 'Controllers/PagesController@admin_index', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(54, 62, 'Controllers > PagesController > admin_create', 'Controllers/PagesController@admin_create', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(55, 63, 'Controllers > PagesController > admin_store', 'Controllers/PagesController@admin_store', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(56, 64, 'Controllers > PagesController > admin_edit', 'Controllers/PagesController@admin_edit', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(57, 65, 'Controllers > PagesController > admin_update', 'Controllers/PagesController@admin_update', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(58, 66, 'Controllers > PagesController > admin_destroy', 'Controllers/PagesController@admin_destroy', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(59, 67, 'Controllers > PagesController > admin_trash_status', 'Controllers/PagesController@admin_trash_status', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(60, 68, 'Controllers > PagesController > remove_feature_image', 'Controllers/PagesController@remove_feature_image', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(61, 70, 'Controllers > MenusController > admin_index', 'Controllers/MenusController@admin_index', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(62, 71, 'Controllers > MenusController > admin_create', 'Controllers/MenusController@admin_create', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(63, 72, 'Controllers > MenusController > admin_store', 'Controllers/MenusController@admin_store', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(64, 73, 'Controllers > MenusController > admin_edit', 'Controllers/MenusController@admin_edit', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(65, 74, 'Controllers > MenusController > admin_update', 'Controllers/MenusController@admin_update', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(66, 75, 'Controllers > MenusController > admin_destroy', 'Controllers/MenusController@admin_destroy', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(67, 76, 'Controllers > MenusController > ajax_menu_item_delete', 'Controllers/MenusController@ajax_menu_item_delete', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(68, 77, 'Controllers > MenusController > admin_select_menu', 'Controllers/MenusController@admin_select_menu', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(69, 78, 'Controllers > MenusController > ajax_add_link', 'Controllers/MenusController@ajax_add_link', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(70, 79, 'Controllers > MenusController > ajax_add_page', 'Controllers/MenusController@ajax_add_page', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(71, 80, 'Controllers > MenusController > search_menus', 'Controllers/MenusController@search_menus', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(72, 82, 'Controllers > ConfigurationsController > admin_index', 'Controllers/ConfigurationsController@admin_index', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(73, 83, 'Controllers > ConfigurationsController > admin_add', 'Controllers/ConfigurationsController@admin_add', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(74, 84, 'Controllers > ConfigurationsController > admin_edit', 'Controllers/ConfigurationsController@admin_edit', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(75, 85, 'Controllers > ConfigurationsController > admin_delete', 'Controllers/ConfigurationsController@admin_delete', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(76, 86, 'Controllers > ConfigurationsController > admin_view', 'Controllers/ConfigurationsController@admin_view', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(77, 87, 'Controllers > ConfigurationsController > admin_prefix', 'Controllers/ConfigurationsController@admin_prefix', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(78, 88, 'Controllers > ConfigurationsController > admin_change_theme', 'Controllers/ConfigurationsController@admin_change_theme', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(79, 89, 'Controllers > ConfigurationsController > admin_change', 'Controllers/ConfigurationsController@admin_change', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(80, 90, 'Controllers > ConfigurationsController > admin_moveup', 'Controllers/ConfigurationsController@admin_moveup', 'web', 'user-define', '2022-12-13 07:20:57', '2022-12-13 07:20:57'),
(81, 91, 'Controllers > ConfigurationsController > admin_movedown', 'Controllers/ConfigurationsController@admin_movedown', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(82, 92, 'Controllers > ConfigurationsController > save_permalink', 'Controllers/ConfigurationsController@save_permalink', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(83, 93, 'Controllers > ConfigurationsController > upload_editor_image', 'Controllers/ConfigurationsController@upload_editor_image', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(84, 130, 'Controllers > DashboardController > dashboard', 'Controllers/DashboardController@dashboard', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(85, 132, 'Controllers > BlogTagsController > list', 'Controllers/BlogTagsController@list', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(86, 133, 'Controllers > BlogTagsController > admin_index', 'Controllers/BlogTagsController@admin_index', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(87, 134, 'Controllers > BlogTagsController > admin_create', 'Controllers/BlogTagsController@admin_create', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(88, 135, 'Controllers > BlogTagsController > admin_store', 'Controllers/BlogTagsController@admin_store', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(89, 136, 'Controllers > BlogTagsController > admin_edit', 'Controllers/BlogTagsController@admin_edit', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(90, 137, 'Controllers > BlogTagsController > admin_update', 'Controllers/BlogTagsController@admin_update', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(91, 138, 'Controllers > BlogTagsController > admin_destroy', 'Controllers/BlogTagsController@admin_destroy', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(92, 96, 'Controllers > HomeController > blogcategory', 'Controllers/HomeController@blogcategory', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(93, 97, 'Controllers > HomeController > detail', 'Controllers/HomeController@detail', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(94, 125, 'Controllers > HomeController > author', 'Controllers/HomeController@author', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(95, 126, 'Controllers > HomeController > blogtag', 'Controllers/HomeController@blogtag', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(96, 127, 'Controllers > HomeController > search', 'Controllers/HomeController@search', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(97, 128, 'Controllers > HomeController > all', 'Controllers/HomeController@all', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(98, 139, 'Controllers > HomeController > blogarchive', 'Controllers/HomeController@blogarchive', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(99, 140, 'Controllers > HomeController > blogslist', 'Controllers/HomeController@blogslist', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(100, 102, 'Installation > WelcomeController > welcome', 'Installation/WelcomeController@welcome', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(101, 104, 'Installation > EnvironmentController > environmentMenu', 'Installation/EnvironmentController@environmentMenu', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(102, 105, 'Installation > EnvironmentController > environmentWizard', 'Installation/EnvironmentController@environmentWizard', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(103, 106, 'Installation > EnvironmentController > saveWizard', 'Installation/EnvironmentController@saveWizard', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(104, 107, 'Installation > EnvironmentController > environmentClassic', 'Installation/EnvironmentController@environmentClassic', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(105, 108, 'Installation > EnvironmentController > saveClassic', 'Installation/EnvironmentController@saveClassic', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(106, 110, 'Installation > RequirementsController > requirements', 'Installation/RequirementsController@requirements', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(107, 112, 'Installation > PermissionsController > permissions', 'Installation/PermissionsController@permissions', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(108, 114, 'Installation > DatabaseController > database', 'Installation/DatabaseController@database', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(109, 116, 'Installation > AdminSetupController > admin', 'Installation/AdminSetupController@admin', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(110, 117, 'Installation > AdminSetupController > saveAdmin', 'Installation/AdminSetupController@saveAdmin', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(111, 119, 'Installation > FinalController > finish', 'Installation/FinalController@finish', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(112, 121, 'Installation > UpdateController > welcome', 'Installation/UpdateController@welcome', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(113, 122, 'Installation > UpdateController > overview', 'Installation/UpdateController@overview', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(114, 123, 'Installation > UpdateController > database', 'Installation/UpdateController@database', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(115, 124, 'Installation > UpdateController > finish', 'Installation/UpdateController@finish', 'web', 'user-define', '2022-12-13 07:20:58', '2022-12-13 07:20:58'),
(116, 141, 'Controllers > UsersController > remove_user_image', 'Controllers/UsersController@remove_user_image', 'web', 'user-define', '2022-12-23 03:48:13', '2022-12-23 03:48:13'),
(117, 142, 'Controllers > HomeController > contact', 'Controllers/HomeController@contact', 'web', 'user-define', '2022-12-23 03:48:13', '2022-12-23 03:48:13'),
(118, 143, 'Controllers > ConfigurationsController > remove_config_image', 'Controllers/ConfigurationsController@remove_config_image', 'web', 'user-define', '2023-02-11 04:32:50', '2023-02-11 04:32:50');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'for laravel plugin/modules roles',
  `level` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'to maintain hierarchy',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `module`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', NULL, 0, '2022-10-29 08:21:29', '2023-01-07 07:36:54'),
(2, 'Manager', 'web', NULL, 0, '2022-10-29 08:21:29', '2022-12-24 05:19:21'),
(3, 'Customer', 'web', NULL, 0, '2022-12-08 07:03:15', '2022-12-24 05:25:42'),
(4, 'Admin', 'web', NULL, 0, '2023-01-07 05:07:01', '2023-01-07 07:30:13');

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
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(84, 2),
(84, 3),
(84, 4),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_permissions`
--

CREATE TABLE `temp_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('App','Module','Controller','Action') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'App',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_permissions`
--

INSERT INTO `temp_permissions` (`id`, `parent_id`, `name`, `path`, `controller`, `action`, `type`, `created_at`, `updated_at`) VALUES
(1, 0, 'Controllers', 'App\\Http\\Controllers\\Admin\\PermissionsController@index', NULL, NULL, 'App', NULL, NULL),
(2, 1, 'Admin', 'App\\Http\\Controllers\\Admin\\PermissionsController@index', NULL, NULL, 'App', NULL, NULL),
(3, 2, 'App\\Http\\Controllers\\Admin\\PermissionsController', 'App\\Http\\Controllers\\Admin\\PermissionsController@index', 'PermissionsController', NULL, 'Controller', NULL, NULL),
(4, 3, 'index', 'App\\Http\\Controllers\\Admin\\PermissionsController@index', 'PermissionsController', 'index', 'Action', NULL, NULL),
(5, 3, 'roles_permissions', 'App\\Http\\Controllers\\Admin\\PermissionsController@roles_permissions', 'PermissionsController', 'roles_permissions', 'Action', NULL, NULL),
(6, 3, 'role_permissions', 'App\\Http\\Controllers\\Admin\\PermissionsController@role_permissions', 'PermissionsController', 'role_permissions', 'Action', NULL, NULL),
(7, 3, 'user_permissions', 'App\\Http\\Controllers\\Admin\\PermissionsController@user_permissions', 'PermissionsController', 'user_permissions', 'Action', NULL, NULL),
(8, 3, 'manage_user_permissions', 'App\\Http\\Controllers\\Admin\\PermissionsController@manage_user_permissions', 'PermissionsController', 'manage_user_permissions', 'Action', NULL, NULL),
(9, 3, 'sync', 'App\\Http\\Controllers\\Admin\\PermissionsController@sync', 'PermissionsController', 'sync', 'Action', NULL, NULL),
(10, 3, 'manage_role_all_permissions', 'App\\Http\\Controllers\\Admin\\PermissionsController@manage_role_all_permissions', 'PermissionsController', 'manage_role_all_permissions', 'Action', NULL, NULL),
(11, 3, 'manage_role_permission', 'App\\Http\\Controllers\\Admin\\PermissionsController@manage_role_permission', 'PermissionsController', 'manage_role_permission', 'Action', NULL, NULL),
(12, 3, 'manage_user_permission', 'App\\Http\\Controllers\\Admin\\PermissionsController@manage_user_permission', 'PermissionsController', 'manage_user_permission', 'Action', NULL, NULL),
(13, 3, 'delete_user_permission', 'App\\Http\\Controllers\\Admin\\PermissionsController@delete_user_permission', 'PermissionsController', 'delete_user_permission', 'Action', NULL, NULL),
(14, 3, 'remove_user_all_permission', 'App\\Http\\Controllers\\Admin\\PermissionsController@remove_user_all_permission', 'PermissionsController', 'remove_user_all_permission', 'Action', NULL, NULL),
(15, 3, 'temp_permissions', 'App\\Http\\Controllers\\Admin\\PermissionsController@temp_permissions', 'PermissionsController', 'temp_permissions', 'Action', NULL, NULL),
(16, 3, 'generate_permissions', 'App\\Http\\Controllers\\Admin\\PermissionsController@generate_permissions', 'PermissionsController', 'generate_permissions', 'Action', NULL, NULL),
(17, 3, 'add_to_permissions', 'App\\Http\\Controllers\\Admin\\PermissionsController@add_to_permissions', 'PermissionsController', 'add_to_permissions', 'Action', NULL, NULL),
(18, 3, 'permission_by_action', 'App\\Http\\Controllers\\Admin\\PermissionsController@permission_by_action', 'PermissionsController', 'permission_by_action', 'Action', NULL, NULL),
(19, 3, 'get_users_by_role', 'App\\Http\\Controllers\\Admin\\PermissionsController@get_users_by_role', 'PermissionsController', 'get_users_by_role', 'Action', NULL, NULL),
(20, 3, 'get_permission_by_user', 'App\\Http\\Controllers\\Admin\\PermissionsController@get_permission_by_user', 'PermissionsController', 'get_permission_by_user', 'Action', NULL, NULL),
(21, 2, 'App\\Http\\Controllers\\Admin\\UsersController', 'App\\Http\\Controllers\\Admin\\UsersController@dashboard', 'UsersController', NULL, 'Controller', NULL, NULL),
(22, 21, 'dashboard', 'App\\Http\\Controllers\\Admin\\UsersController@dashboard', 'UsersController', 'dashboard', 'Action', NULL, NULL),
(23, 21, 'index', 'App\\Http\\Controllers\\Admin\\UsersController@index', 'UsersController', 'index', 'Action', NULL, NULL),
(24, 21, 'create', 'App\\Http\\Controllers\\Admin\\UsersController@create', 'UsersController', 'create', 'Action', NULL, NULL),
(25, 21, 'store', 'App\\Http\\Controllers\\Admin\\UsersController@store', 'UsersController', 'store', 'Action', NULL, NULL),
(26, 21, 'edit', 'App\\Http\\Controllers\\Admin\\UsersController@edit', 'UsersController', 'edit', 'Action', NULL, NULL),
(27, 21, 'update', 'App\\Http\\Controllers\\Admin\\UsersController@update', 'UsersController', 'update', 'Action', NULL, NULL),
(28, 21, 'destroy', 'App\\Http\\Controllers\\Admin\\UsersController@destroy', 'UsersController', 'destroy', 'Action', NULL, NULL),
(29, 21, 'update_password', 'App\\Http\\Controllers\\Admin\\UsersController@update_password', 'UsersController', 'update_password', 'Action', NULL, NULL),
(30, 21, 'update_user_roles', 'App\\Http\\Controllers\\Admin\\UsersController@update_user_roles', 'UsersController', 'update_user_roles', 'Action', NULL, NULL),
(31, 21, 'profile', 'App\\Http\\Controllers\\Admin\\UsersController@profile', 'UsersController', 'profile', 'Action', NULL, NULL),
(32, 2, 'App\\Http\\Controllers\\Admin\\RolesController', 'App\\Http\\Controllers\\Admin\\RolesController@index', 'RolesController', NULL, 'Controller', NULL, NULL),
(33, 32, 'index', 'App\\Http\\Controllers\\Admin\\RolesController@index', 'RolesController', 'index', 'Action', NULL, NULL),
(34, 32, 'create', 'App\\Http\\Controllers\\Admin\\RolesController@create', 'RolesController', 'create', 'Action', NULL, NULL),
(35, 32, 'store', 'App\\Http\\Controllers\\Admin\\RolesController@store', 'RolesController', 'store', 'Action', NULL, NULL),
(36, 32, 'edit', 'App\\Http\\Controllers\\Admin\\RolesController@edit', 'RolesController', 'edit', 'Action', NULL, NULL),
(37, 32, 'update', 'App\\Http\\Controllers\\Admin\\RolesController@update', 'RolesController', 'update', 'Action', NULL, NULL),
(38, 32, 'destroy', 'App\\Http\\Controllers\\Admin\\RolesController@destroy', 'RolesController', 'destroy', 'Action', NULL, NULL),
(39, 2, 'App\\Http\\Controllers\\Admin\\BlogsController', 'App\\Http\\Controllers\\Admin\\BlogsController@admin_index', 'BlogsController', NULL, 'Controller', NULL, NULL),
(40, 39, 'admin_index', 'App\\Http\\Controllers\\Admin\\BlogsController@admin_index', 'BlogsController', 'admin_index', 'Action', NULL, NULL),
(41, 39, 'admin_create', 'App\\Http\\Controllers\\Admin\\BlogsController@admin_create', 'BlogsController', 'admin_create', 'Action', NULL, NULL),
(42, 39, 'admin_store', 'App\\Http\\Controllers\\Admin\\BlogsController@admin_store', 'BlogsController', 'admin_store', 'Action', NULL, NULL),
(43, 39, 'admin_edit', 'App\\Http\\Controllers\\Admin\\BlogsController@admin_edit', 'BlogsController', 'admin_edit', 'Action', NULL, NULL),
(44, 39, 'admin_update', 'App\\Http\\Controllers\\Admin\\BlogsController@admin_update', 'BlogsController', 'admin_update', 'Action', NULL, NULL),
(45, 39, 'admin_destroy', 'App\\Http\\Controllers\\Admin\\BlogsController@admin_destroy', 'BlogsController', 'admin_destroy', 'Action', NULL, NULL),
(46, 39, 'admin_trash_status', 'App\\Http\\Controllers\\Admin\\BlogsController@admin_trash_status', 'BlogsController', 'admin_trash_status', 'Action', NULL, NULL),
(47, 39, 'remove_feature_image', 'App\\Http\\Controllers\\Admin\\BlogsController@remove_feature_image', 'BlogsController', 'remove_feature_image', 'Action', NULL, NULL),
(48, 2, 'App\\Http\\Controllers\\Admin\\BlogCategoriesController', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@list', 'BlogCategoriesController', NULL, 'Controller', NULL, NULL),
(49, 48, 'list', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@list', 'BlogCategoriesController', 'list', 'Action', NULL, NULL),
(50, 48, 'admin_index', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_index', 'BlogCategoriesController', 'admin_index', 'Action', NULL, NULL),
(51, 48, 'admin_create', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_create', 'BlogCategoriesController', 'admin_create', 'Action', NULL, NULL),
(52, 48, 'admin_store', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_store', 'BlogCategoriesController', 'admin_store', 'Action', NULL, NULL),
(53, 48, 'admin_edit', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_edit', 'BlogCategoriesController', 'admin_edit', 'Action', NULL, NULL),
(54, 48, 'admin_update', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_update', 'BlogCategoriesController', 'admin_update', 'Action', NULL, NULL),
(55, 48, 'admin_destroy', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_destroy', 'BlogCategoriesController', 'admin_destroy', 'Action', NULL, NULL),
(56, 48, 'admin_trash_status', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_trash_status', 'BlogCategoriesController', 'admin_trash_status', 'Action', NULL, NULL),
(57, 48, 'admin_ajax_add_category', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_ajax_add_category', 'BlogCategoriesController', 'admin_ajax_add_category', 'Action', NULL, NULL),
(58, 48, 'admin_moveup', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_moveup', 'BlogCategoriesController', 'admin_moveup', 'Action', NULL, NULL),
(59, 48, 'admin_movedown', 'App\\Http\\Controllers\\Admin\\BlogCategoriesController@admin_movedown', 'BlogCategoriesController', 'admin_movedown', 'Action', NULL, NULL),
(60, 2, 'App\\Http\\Controllers\\Admin\\PagesController', 'App\\Http\\Controllers\\Admin\\PagesController@admin_index', 'PagesController', NULL, 'Controller', NULL, NULL),
(61, 60, 'admin_index', 'App\\Http\\Controllers\\Admin\\PagesController@admin_index', 'PagesController', 'admin_index', 'Action', NULL, NULL),
(62, 60, 'admin_create', 'App\\Http\\Controllers\\Admin\\PagesController@admin_create', 'PagesController', 'admin_create', 'Action', NULL, NULL),
(63, 60, 'admin_store', 'App\\Http\\Controllers\\Admin\\PagesController@admin_store', 'PagesController', 'admin_store', 'Action', NULL, NULL),
(64, 60, 'admin_edit', 'App\\Http\\Controllers\\Admin\\PagesController@admin_edit', 'PagesController', 'admin_edit', 'Action', NULL, NULL),
(65, 60, 'admin_update', 'App\\Http\\Controllers\\Admin\\PagesController@admin_update', 'PagesController', 'admin_update', 'Action', NULL, NULL),
(66, 60, 'admin_destroy', 'App\\Http\\Controllers\\Admin\\PagesController@admin_destroy', 'PagesController', 'admin_destroy', 'Action', NULL, NULL),
(67, 60, 'admin_trash_status', 'App\\Http\\Controllers\\Admin\\PagesController@admin_trash_status', 'PagesController', 'admin_trash_status', 'Action', NULL, NULL),
(68, 60, 'remove_feature_image', 'App\\Http\\Controllers\\Admin\\PagesController@remove_feature_image', 'PagesController', 'remove_feature_image', 'Action', NULL, NULL),
(69, 2, 'App\\Http\\Controllers\\Admin\\MenusController', 'App\\Http\\Controllers\\Admin\\MenusController@admin_index', 'MenusController', NULL, 'Controller', NULL, NULL),
(70, 69, 'admin_index', 'App\\Http\\Controllers\\Admin\\MenusController@admin_index', 'MenusController', 'admin_index', 'Action', NULL, NULL),
(71, 69, 'admin_create', 'App\\Http\\Controllers\\Admin\\MenusController@admin_create', 'MenusController', 'admin_create', 'Action', NULL, NULL),
(72, 69, 'admin_store', 'App\\Http\\Controllers\\Admin\\MenusController@admin_store', 'MenusController', 'admin_store', 'Action', NULL, NULL),
(73, 69, 'admin_edit', 'App\\Http\\Controllers\\Admin\\MenusController@admin_edit', 'MenusController', 'admin_edit', 'Action', NULL, NULL),
(74, 69, 'admin_update', 'App\\Http\\Controllers\\Admin\\MenusController@admin_update', 'MenusController', 'admin_update', 'Action', NULL, NULL),
(75, 69, 'admin_destroy', 'App\\Http\\Controllers\\Admin\\MenusController@admin_destroy', 'MenusController', 'admin_destroy', 'Action', NULL, NULL),
(76, 69, 'ajax_menu_item_delete', 'App\\Http\\Controllers\\Admin\\MenusController@ajax_menu_item_delete', 'MenusController', 'ajax_menu_item_delete', 'Action', NULL, NULL),
(77, 69, 'admin_select_menu', 'App\\Http\\Controllers\\Admin\\MenusController@admin_select_menu', 'MenusController', 'admin_select_menu', 'Action', NULL, NULL),
(78, 69, 'ajax_add_link', 'App\\Http\\Controllers\\Admin\\MenusController@ajax_add_link', 'MenusController', 'ajax_add_link', 'Action', NULL, NULL),
(79, 69, 'ajax_add_page', 'App\\Http\\Controllers\\Admin\\MenusController@ajax_add_page', 'MenusController', 'ajax_add_page', 'Action', NULL, NULL),
(80, 69, 'search_menus', 'App\\Http\\Controllers\\Admin\\MenusController@search_menus', 'MenusController', 'search_menus', 'Action', NULL, NULL),
(81, 2, 'App\\Http\\Controllers\\Admin\\ConfigurationsController', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_index', 'ConfigurationsController', NULL, 'Controller', NULL, NULL),
(82, 81, 'admin_index', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_index', 'ConfigurationsController', 'admin_index', 'Action', NULL, NULL),
(83, 81, 'admin_add', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_add', 'ConfigurationsController', 'admin_add', 'Action', NULL, NULL),
(84, 81, 'admin_edit', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_edit', 'ConfigurationsController', 'admin_edit', 'Action', NULL, NULL),
(85, 81, 'admin_delete', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_delete', 'ConfigurationsController', 'admin_delete', 'Action', NULL, NULL),
(86, 81, 'admin_view', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_view', 'ConfigurationsController', 'admin_view', 'Action', NULL, NULL),
(87, 81, 'admin_prefix', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_prefix', 'ConfigurationsController', 'admin_prefix', 'Action', NULL, NULL),
(88, 81, 'admin_change_theme', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_change_theme', 'ConfigurationsController', 'admin_change_theme', 'Action', NULL, NULL),
(89, 81, 'admin_change', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_change', 'ConfigurationsController', 'admin_change', 'Action', NULL, NULL),
(90, 81, 'admin_moveup', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_moveup', 'ConfigurationsController', 'admin_moveup', 'Action', NULL, NULL),
(91, 81, 'admin_movedown', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@admin_movedown', 'ConfigurationsController', 'admin_movedown', 'Action', NULL, NULL),
(92, 81, 'save_permalink', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@save_permalink', 'ConfigurationsController', 'save_permalink', 'Action', NULL, NULL),
(93, 81, 'upload_editor_image', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@upload_editor_image', 'ConfigurationsController', 'upload_editor_image', 'Action', NULL, NULL),
(94, 1, 'Front', 'App\\Http\\Controllers\\Front\\HomeController@blogcategory', NULL, NULL, 'App', NULL, NULL),
(95, 94, 'App\\Http\\Controllers\\Front\\HomeController', 'App\\Http\\Controllers\\Front\\HomeController@blogcategory', 'HomeController', NULL, 'Controller', NULL, NULL),
(96, 95, 'blogcategory', 'App\\Http\\Controllers\\Front\\HomeController@blogcategory', 'HomeController', 'blogcategory', 'Action', NULL, NULL),
(97, 95, 'detail', 'App\\Http\\Controllers\\Front\\HomeController@detail', 'HomeController', 'detail', 'Action', NULL, NULL),
(98, 0, 'Installation 0', 'Modules\\Installation\\Http\\Controllers\\WelcomeController@welcome', NULL, NULL, 'Module', NULL, NULL),
(99, 98, 'Http 98', 'Modules\\Installation\\Http\\Controllers\\WelcomeController@welcome', NULL, NULL, 'Module', NULL, NULL),
(100, 99, 'Controllers 99', 'Modules\\Installation\\Http\\Controllers\\WelcomeController@welcome', NULL, NULL, 'Module', NULL, NULL),
(101, 100, 'Modules\\Installation\\Http\\Controllers\\WelcomeController', 'Modules\\Installation\\Http\\Controllers\\WelcomeController@welcome', 'WelcomeController', NULL, 'Controller', NULL, NULL),
(102, 101, 'welcome', 'Modules\\Installation\\Http\\Controllers\\WelcomeController@welcome', 'WelcomeController', 'welcome', 'Action', NULL, NULL),
(103, 100, 'Modules\\Installation\\Http\\Controllers\\EnvironmentController', 'Modules\\Installation\\Http\\Controllers\\EnvironmentController@environmentMenu', 'EnvironmentController', NULL, 'Controller', NULL, NULL),
(104, 103, 'environmentMenu', 'Modules\\Installation\\Http\\Controllers\\EnvironmentController@environmentMenu', 'EnvironmentController', 'environmentMenu', 'Action', NULL, NULL),
(105, 103, 'environmentWizard', 'Modules\\Installation\\Http\\Controllers\\EnvironmentController@environmentWizard', 'EnvironmentController', 'environmentWizard', 'Action', NULL, NULL),
(106, 103, 'saveWizard', 'Modules\\Installation\\Http\\Controllers\\EnvironmentController@saveWizard', 'EnvironmentController', 'saveWizard', 'Action', NULL, NULL),
(107, 103, 'environmentClassic', 'Modules\\Installation\\Http\\Controllers\\EnvironmentController@environmentClassic', 'EnvironmentController', 'environmentClassic', 'Action', NULL, NULL),
(108, 103, 'saveClassic', 'Modules\\Installation\\Http\\Controllers\\EnvironmentController@saveClassic', 'EnvironmentController', 'saveClassic', 'Action', NULL, NULL),
(109, 100, 'Modules\\Installation\\Http\\Controllers\\RequirementsController', 'Modules\\Installation\\Http\\Controllers\\RequirementsController@requirements', 'RequirementsController', NULL, 'Controller', NULL, NULL),
(110, 109, 'requirements', 'Modules\\Installation\\Http\\Controllers\\RequirementsController@requirements', 'RequirementsController', 'requirements', 'Action', NULL, NULL),
(111, 100, 'Modules\\Installation\\Http\\Controllers\\PermissionsController', 'Modules\\Installation\\Http\\Controllers\\PermissionsController@permissions', 'PermissionsController', NULL, 'Controller', NULL, NULL),
(112, 111, 'permissions', 'Modules\\Installation\\Http\\Controllers\\PermissionsController@permissions', 'PermissionsController', 'permissions', 'Action', NULL, NULL),
(113, 100, 'Modules\\Installation\\Http\\Controllers\\DatabaseController', 'Modules\\Installation\\Http\\Controllers\\DatabaseController@database', 'DatabaseController', NULL, 'Controller', NULL, NULL),
(114, 113, 'database', 'Modules\\Installation\\Http\\Controllers\\DatabaseController@database', 'DatabaseController', 'database', 'Action', NULL, NULL),
(115, 100, 'Modules\\Installation\\Http\\Controllers\\AdminSetupController', 'Modules\\Installation\\Http\\Controllers\\AdminSetupController@admin', 'AdminSetupController', NULL, 'Controller', NULL, NULL),
(116, 115, 'admin', 'Modules\\Installation\\Http\\Controllers\\AdminSetupController@admin', 'AdminSetupController', 'admin', 'Action', NULL, NULL),
(117, 115, 'saveAdmin', 'Modules\\Installation\\Http\\Controllers\\AdminSetupController@saveAdmin', 'AdminSetupController', 'saveAdmin', 'Action', NULL, NULL),
(118, 100, 'Modules\\Installation\\Http\\Controllers\\FinalController', 'Modules\\Installation\\Http\\Controllers\\FinalController@finish', 'FinalController', NULL, 'Controller', NULL, NULL),
(119, 118, 'finish', 'Modules\\Installation\\Http\\Controllers\\FinalController@finish', 'FinalController', 'finish', 'Action', NULL, NULL),
(120, 100, 'Modules\\Installation\\Http\\Controllers\\UpdateController', 'Modules\\Installation\\Http\\Controllers\\UpdateController@welcome', 'UpdateController', NULL, 'Controller', NULL, NULL),
(121, 120, 'welcome', 'Modules\\Installation\\Http\\Controllers\\UpdateController@welcome', 'UpdateController', 'welcome', 'Action', NULL, NULL),
(122, 120, 'overview', 'Modules\\Installation\\Http\\Controllers\\UpdateController@overview', 'UpdateController', 'overview', 'Action', NULL, NULL),
(123, 120, 'database', 'Modules\\Installation\\Http\\Controllers\\UpdateController@database', 'UpdateController', 'database', 'Action', NULL, NULL),
(124, 120, 'finish', 'Modules\\Installation\\Http\\Controllers\\UpdateController@finish', 'UpdateController', 'finish', 'Action', NULL, NULL),
(125, 95, 'author', 'App\\Http\\Controllers\\Front\\HomeController@author', 'HomeController', 'author', 'Action', NULL, NULL),
(126, 95, 'blogtag', 'App\\Http\\Controllers\\Front\\HomeController@blogtag', 'HomeController', 'blogtag', 'Action', NULL, NULL),
(127, 95, 'search', 'App\\Http\\Controllers\\Front\\HomeController@search', 'HomeController', 'search', 'Action', NULL, NULL),
(128, 95, 'all', 'App\\Http\\Controllers\\Front\\HomeController@all', 'HomeController', 'all', 'Action', NULL, NULL),
(129, 2, 'App\\Http\\Controllers\\Admin\\DashboardController', 'App\\Http\\Controllers\\Admin\\DashboardController@dashboard', 'DashboardController', NULL, 'Controller', NULL, NULL),
(130, 129, 'dashboard', 'App\\Http\\Controllers\\Admin\\DashboardController@dashboard', 'DashboardController', 'dashboard', 'Action', NULL, NULL),
(131, 2, 'App\\Http\\Controllers\\Admin\\BlogTagsController', 'App\\Http\\Controllers\\Admin\\BlogTagsController@list', 'BlogTagsController', NULL, 'Controller', NULL, NULL),
(132, 131, 'list', 'App\\Http\\Controllers\\Admin\\BlogTagsController@list', 'BlogTagsController', 'list', 'Action', NULL, NULL),
(133, 131, 'admin_index', 'App\\Http\\Controllers\\Admin\\BlogTagsController@admin_index', 'BlogTagsController', 'admin_index', 'Action', NULL, NULL),
(134, 131, 'admin_create', 'App\\Http\\Controllers\\Admin\\BlogTagsController@admin_create', 'BlogTagsController', 'admin_create', 'Action', NULL, NULL),
(135, 131, 'admin_store', 'App\\Http\\Controllers\\Admin\\BlogTagsController@admin_store', 'BlogTagsController', 'admin_store', 'Action', NULL, NULL),
(136, 131, 'admin_edit', 'App\\Http\\Controllers\\Admin\\BlogTagsController@admin_edit', 'BlogTagsController', 'admin_edit', 'Action', NULL, NULL),
(137, 131, 'admin_update', 'App\\Http\\Controllers\\Admin\\BlogTagsController@admin_update', 'BlogTagsController', 'admin_update', 'Action', NULL, NULL),
(138, 131, 'admin_destroy', 'App\\Http\\Controllers\\Admin\\BlogTagsController@admin_destroy', 'BlogTagsController', 'admin_destroy', 'Action', NULL, NULL),
(139, 95, 'blogarchive', 'App\\Http\\Controllers\\Front\\HomeController@blogarchive', 'HomeController', 'blogarchive', 'Action', NULL, NULL),
(140, 95, 'blogslist', 'App\\Http\\Controllers\\Front\\HomeController@blogslist', 'HomeController', 'blogslist', 'Action', NULL, NULL),
(141, 21, 'remove_user_image', 'App\\Http\\Controllers\\Admin\\UsersController@remove_user_image', 'UsersController', 'remove_user_image', 'Action', NULL, NULL),
(142, 95, 'contact', 'App\\Http\\Controllers\\Front\\HomeController@contact', 'HomeController', 'contact', 'Action', NULL, NULL),
(143, 81, 'remove_config_image', 'App\\Http\\Controllers\\Admin\\ConfigurationsController@remove_config_image', 'ConfigurationsController', 'remove_config_image', 'Action', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_blog_categories`
--
ALTER TABLE `blog_blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_blog_categories_blog_id_foreign` (`blog_id`),
  ADD KEY `blog_blog_categories_blog_category_id_foreign` (`blog_category_id`);

--
-- Indexes for table `blog_blog_tags`
--
ALTER TABLE `blog_blog_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_blog_tags_blog_id_foreign` (`blog_id`),
  ADD KEY `blog_blog_tags_blog_tag_id_foreign` (`blog_tag_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `blog_metas`
--
ALTER TABLE `blog_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_metas_blog_id_foreign` (`blog_id`);

--
-- Indexes for table `blog_seos`
--
ALTER TABLE `blog_seos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_seos_blog_id_foreign` (`blog_id`);

--
-- Indexes for table `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_tags_user_id_foreign` (`user_id`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

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
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_metas`
--
ALTER TABLE `page_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_metas_page_id_foreign` (`page_id`);

--
-- Indexes for table `page_seos`
--
ALTER TABLE `page_seos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_seos_page_id_foreign` (`page_id`);

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
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `permissions_temp_permission_id_foreign` (`temp_permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `temp_permissions`
--
ALTER TABLE `temp_permissions`
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
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_blog_categories`
--
ALTER TABLE `blog_blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_blog_tags`
--
ALTER TABLE `blog_blog_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_metas`
--
ALTER TABLE `blog_metas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_seos`
--
ALTER TABLE `blog_seos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_tags`
--
ALTER TABLE `blog_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `page_metas`
--
ALTER TABLE `page_metas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `page_seos`
--
ALTER TABLE `page_seos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `temp_permissions`
--
ALTER TABLE `temp_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_blog_categories`
--
ALTER TABLE `blog_blog_categories`
  ADD CONSTRAINT `blog_blog_categories_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_blog_categories_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_blog_tags`
--
ALTER TABLE `blog_blog_tags`
  ADD CONSTRAINT `blog_blog_tags_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_blog_tags_blog_tag_id_foreign` FOREIGN KEY (`blog_tag_id`) REFERENCES `blog_tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD CONSTRAINT `blog_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_metas`
--
ALTER TABLE `blog_metas`
  ADD CONSTRAINT `blog_metas_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_seos`
--
ALTER TABLE `blog_seos`
  ADD CONSTRAINT `blog_seos_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD CONSTRAINT `blog_tags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `page_metas`
--
ALTER TABLE `page_metas`
  ADD CONSTRAINT `page_metas_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `page_seos`
--
ALTER TABLE `page_seos`
  ADD CONSTRAINT `page_seos_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_temp_permission_id_foreign` FOREIGN KEY (`temp_permission_id`) REFERENCES `temp_permissions` (`id`) ON DELETE CASCADE;

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
