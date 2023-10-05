-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2023 at 07:23 PM
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
-- Database: `pet_planet`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `floor` tinyint(2) DEFAULT NULL,
  `flat` tinyint(4) DEFAULT NULL,
  `building` smallint(3) DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `address`, `lat`, `lng`, `street`, `floor`, `flat`, `building`, `notes`, `user_id`) VALUES
(72, 'Giza, Egypt', 29.9345, 31.1657, NULL, NULL, NULL, NULL, NULL, 127),
(73, 'tahrir street', 29.9394, 31.1651, NULL, NULL, NULL, NULL, NULL, 127),
(76, '285 B Ramsis St., ABBASSEYA', 31.2608, 30.0122, NULL, NULL, NULL, NULL, NULL, 132),
(86, '2 A El Khalifa El Maamoun St., HELIOPOLIS ', 31.2115, 29.8825, NULL, NULL, NULL, NULL, NULL, 142),
(89, 'San Stefano, Alexandria, Egypt', 31.2608, 30.0122, NULL, NULL, NULL, NULL, NULL, 144),
(90, 'Qaleet Qaietbay, Qesm El Gomrok, Alexandria', 31.2115, 29.8825, NULL, NULL, NULL, NULL, NULL, 144),
(91, ' زاوية أبو مسلم, الجيزة', 29.9394, 31.1651, NULL, NULL, NULL, NULL, NULL, 144),
(93, 'san stefanooo', 42.5206, 26.8786, NULL, NULL, NULL, NULL, NULL, 149),
(94, 'Giza, Egyptt', 30.0096, 31.2138, NULL, NULL, NULL, NULL, NULL, 151),
(95, 'التحرير، الدقي أ، الدقى،, الجيزة, محافظة الجيزة', 30.0398, 31.2178, NULL, NULL, NULL, NULL, NULL, 154),
(151, 'زاوية أبوو مسلم, الجيزة', 29.9394, 31.1651, NULL, NULL, NULL, NULL, NULL, 157),
(155, '15 Ahmed Sabry, Zamalek', 30.0612, 31.222, NULL, NULL, NULL, NULL, NULL, 161),
(156, ' 30 Salah Taher St Ras ', 27.9158, 34.3262, NULL, NULL, NULL, NULL, NULL, 160),
(157, 'Zakareya Othman Street', 31.9833, 35.8664, NULL, NULL, NULL, NULL, NULL, 162),
(158, 'Hadayek Al ahram, Giza', 29.9691, 31.0974, NULL, NULL, NULL, NULL, NULL, 163),
(161, 'الدكتور عبد العزيز الشناوي، مدينة نصر‬ ', 30.061, 31.3156, NULL, NULL, NULL, NULL, NULL, 167),
(162, 'الجمالية، قسم الجمالية، محافظة القاهرة‬ ', 0, 0, NULL, NULL, NULL, NULL, NULL, 160),
(174, '', 29.9345, 31.1657, NULL, NULL, NULL, NULL, NULL, 177),
(175, '103, Al Ahram St, Giza', 29.9909, 31.1525, NULL, NULL, NULL, NULL, NULL, 178),
(176, '9 Abou al hool, giza, cairo', 0, 0, NULL, NULL, NULL, NULL, NULL, 160),
(177, '28 Ahmed El Zomor St., Nasr City', 30.0469, 31.3598, NULL, NULL, NULL, NULL, NULL, 161);

-- --------------------------------------------------------

--
-- Table structure for table `alarms`
--

CREATE TABLE `alarms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_needed` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`user_id`, `product_id`, `quantity_needed`) VALUES
(145, 4, 1),
(151, 3, 3),
(151, 8, 1),
(162, 2, 1),
(162, 4, 1),
(168, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(64) DEFAULT 'categoryDefault.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(1, 'Dogs', 'dogicon.jpg'),
(2, 'Cats', 'caticon.jpg'),
(3, 'Birds', 'birdicon.jpg'),
(4, 'Hamsters', 'hamstericon.jpg'),
(5, 'Turtles', 'turtleicon.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `reciever_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` char(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `work_days` varchar(255) NOT NULL,
  `image` varchar(64) NOT NULL DEFAULT 'default.jpg',
  `rate` tinyint(4) DEFAULT NULL,
  `opens_at` time DEFAULT NULL,
  `closes_at` time DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`id`, `name`, `phone`, `price`, `work_days`, `image`, `rate`, `opens_at`, `closes_at`, `address_id`) VALUES
(14, 'Pet Soul', '01115653155', '10.00', 'Friday, Saturday', 'puppy_1400x.progressive.webp', NULL, '14:00:00', '00:00:00', 89),
(15, 'Pet Zone', '01215953142', '25.00', 'Monday, Tuesday', 'R (2).jpeg', NULL, '15:00:00', '19:00:00', 90),
(16, 'Petty', '01115953156', '30.00', 'Friday, Sunday', 'R (6).jpeg', NULL, '16:00:00', '21:00:00', 91),
(18, 'Furry family', '01223710522', '135.00', 'Monday, Tuesday, Friday', 'th (1).jpeg', NULL, '11:00:00', '16:00:00', 155),
(19, 'Bolt', '01114568729', '140.00', 'Monday, Tuesday', '1047488.jpg', NULL, '15:00:00', '21:00:00', 161),
(21, 'Grand Vet ', '01278889944', '200.00', 'Monday, Wednesday', 'clinic.jpeg', NULL, '07:30:00', '12:00:00', 177);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `date` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `report` tinyint(1) NOT NULL COMMENT '0=>not reported  \r\n, 1=> reported'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `date`, `created_at`, `updated_at`, `post_id`, `user_id`, `username`, `report`) VALUES
(47, 'dd66', '30 June', '2023-06-30 20:26:50', '2023-06-30 20:36:07', 81, 97, 'omnia magdy', 0),
(49, 'Hi Reem', '2 July', '2023-07-02 15:14:18', NULL, 83, 154, 'Reem Adel', 0),
(50, 'Hi Gamila', '7 July', '2023-07-07 21:25:58', NULL, 84, 168, 'Yara Gamal', 0),
(51, 'hi', '8 July', '2023-07-08 04:28:43', '2023-07-08 04:30:41', 84, 162, 'Wael Hussien', 0),
(55, 'Hi Reem , how are you?', '10 July', '2023-07-10 02:16:46', '2023-07-10 02:17:03', 83, 177, 'Laila Ahmed', 0),
(56, 'I hate you', '10 July', '2023-07-10 02:31:23', '2023-07-10 02:41:57', 83, 166, 'Reem Mostafa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `favs`
--

CREATE TABLE `favs` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favs`
--

INSERT INTO `favs` (`user_id`, `product_id`) VALUES
(145, 8),
(151, 2),
(166, 6),
(166, 22);

-- --------------------------------------------------------

--
-- Table structure for table `hotelmanagers`
--

CREATE TABLE `hotelmanagers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotelmanagers`
--

INSERT INTO `hotelmanagers` (`id`, `user_id`, `hotel_id`) VALUES
(8, 127, 6),
(9, 127, 7),
(11, 160, 9),
(12, 160, 10),
(15, 160, 13);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` char(11) NOT NULL,
  `rate` tinyint(4) NOT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(64) NOT NULL DEFAULT 'hotelDefault.jpg',
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `phone`, `rate`, `address_id`, `image`, `user_id`) VALUES
(6, 'Hayat', '01226555555', 5, 72, 'ice-319927-100765785-234212.jpg', 127),
(7, 'Wonder', '01515953142', 4, 73, 'expediav2-7638255-3ad7d5-808679.jpg', 127),
(9, 'SUNRISE', '01226666644', 5, 156, 'defaultHotel.jpeg', 160),
(10, 'Al Masa', '01114522277', 4, 162, 'Cat and dog-amico.png', 160),
(13, 'Pyramids', '01112348974', 5, 176, '467807357.jpg', 160);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_reservations`
--

CREATE TABLE `hotel_reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  `type_of_room` tinyint(1) NOT NULL COMMENT '0 => single, 1 => double',
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_provider_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotel_reservations`
--

INSERT INTO `hotel_reservations` (`id`, `total_price`, `start_at`, `end_at`, `type_of_room`, `hotel_id`, `user_id`, `service_provider_id`) VALUES
(1, '3600.00', '2023-07-11', '2023-07-14', 1, 6, 145, 17),
(2, '2400.00', '2023-07-05', '2023-07-07', 1, 6, 145, 17),
(3, '1200.00', '2023-07-10', '2023-07-12', 0, 7, 145, 17),
(4, '3600.00', '2023-07-13', '2023-07-19', 0, 9, 166, 38),
(5, '1800.00', '2023-07-18', '2023-07-21', 0, 7, 166, 17),
(6, '6000.00', '2023-07-12', '2023-07-17', 1, 7, 166, 17);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `rating_action` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `rating_action`) VALUES
(79, 14, 66, 'like'),
(81, 1, 66, 'like');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` mediumtext NOT NULL,
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `content`, `user_id`, `date`) VALUES
(4, 'Maria Emad wants to buy your pet: LOLO , If you want to communicate here is the email: jeroemad@gmail.com', 150, '1 July'),
(5, 'Yara Gamal wants to buy your pet: Max , If you want to communicate here is the email: yaragamal@gmail.com', 166, '7 July'),
(6, 'Yara Gamal wants to adopt your pet: Kitty , If you want to communicate here the email: yaragamal@gmail.com', 166, '7 July'),
(7, 'Reem Mostafa wants to buy your pet: weso , If you want to communicate here is the email: reemmostafa@gmail.com', 168, '7 July'),
(8, 'Reem Mostafa wants your pet: Kiki for mating , If you want to communicate here is the email: reemmostafa@gmail.com', 168, '7 July'),
(9, 'Yara Gamal wants to buy your pet: Max , If you want to communicate here is the email: yaragamal@gmail.com', 166, '7 July');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=>not active, 1=>active',
  `delivered_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `address_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `total_price`, `status`, `delivered_at`, `address_id`) VALUES
(43, '134.00', 1, NULL, 157),
(47, '474.00', 1, NULL, 174);

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`order_id`, `product_id`, `quantity`) VALUES
(43, 8, 3),
(47, 8, 1),
(47, 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `petreports`
--

CREATE TABLE `petreports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `location` mediumtext NOT NULL,
  `situation_description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petreports`
--

INSERT INTO `petreports` (`id`, `date`, `location`, `situation_description`) VALUES
(1, '2023-02-02', 'El haram, Yehia shahin street', 'inguired cat '),
(9, '2023-02-04', 'Cairo,Talaat Harb street', 'dog is so sick'),
(10, '2023-02-18', 'Maadi, street 9', 'cat is sick'),
(11, '2023-02-26', 'ElHegaz street, Heliopolis, cairo', 'homeless dog'),
(13, '2023-07-08', 'صلاح سالم، الأستاد، قسم ثان مدينة نصر، محافظة القاهرة‬ ', 'Dog with broken leg'),
(14, '2023-07-10', 'Cat have an accident', 'Maadi, Street 10'),
(15, '2023-07-10', 'Dog is sick', 'Maadi street 9'),
(16, '2023-07-10', 'cat is very ill', 'El haram street, giza');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `family` varchar(255) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `age` tinyint(4) NOT NULL,
  `image` varchar(64) DEFAULT 'petDefault.jpg',
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `placed_adoption` tinyint(1) NOT NULL COMMENT '0=> not placed, 1=> placed',
  `placed_selling` tinyint(1) NOT NULL COMMENT '0=> not placed, 1=> placed',
  `placed_mating` tinyint(1) NOT NULL COMMENT '0=> not placed, 1=> placed',
  `pending` tinyint(1) NOT NULL COMMENT '0=> not pending, 1=> pending',
  `user_id_for_operation` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `name`, `type`, `family`, `gender`, `age`, `image`, `category_id`, `placed_adoption`, `placed_selling`, `placed_mating`, `pending`, `user_id_for_operation`, `user_id`) VALUES
(17, 'Max', 'haski', '1', 'm', 2, 'Rolly.jpeg', 1, 0, 0, 0, 0, 0, 14),
(19, 'Kitty', 'siami', '2', 'f', 5, 'cat1.jpg', 2, 0, 0, 0, 0, 0, 14),
(21, 'Rolly', 'haski', '1', 'm', 1, 'Rolly.jpeg', 1, 0, 0, 0, 0, 0, 14),
(30, 'toto', 'siami', '2', 'f', 2, 'cat-mammal-fluffy-cat-blue-eyes-wallpaper-preview.jpg', 2, 0, 0, 0, 0, 0, 145),
(33, 'LOLO', 'tt', '5', 'f', 5, '1047488.jpg', 5, 0, 0, 0, 1, 150, 150),
(39, 'Kitty', 'American shorthair', '2', 'f', 4, 'GettyImages-1205113925.jpg', 2, 1, 0, 0, 1, 168, 166),
(40, 'Max', 'Golden', '1', 'm', 3, 'Rolly.jpeg', 1, 0, 1, 0, 1, 168, 166),
(41, 'Kiki', 'tt', '3', 'f', 3, 'petdefault.webp', 3, 0, 0, 0, 1, 166, 168),
(42, 'weso', 'll', '4', 'm', 5, 'maxresdefault.jpg', 4, 0, 0, 0, 1, 166, 168),
(44, 'jojo', 'golden', '1', 'm', 2, '5282873907_dc42328235_z.jpg', 1, 0, 1, 0, 0, 0, 166),
(45, 'sosy', 'bird', '3', 'f', 2, 'GettyImages-655307584-5c76f13546e0fb0001edc770.webp', 3, 1, 0, 0, 0, 0, 166),
(46, 'kito', 'siami', '2', 'f', 2, 'animals-blue-cats-eyes-wallpaper-preview.jpg', 2, 0, 1, 0, 0, 0, 166),
(47, 'titi', 'siami', '2', 'm', 2, 'cute-kitten-kitty-cat-wallpaper-preview.jpg', 2, 0, 0, 0, 0, 0, 166),
(54, 'Lucy', 'British Shorthair', '2', 'f', 3, 'cute-kitten-kitty-cat-wallpaper-preview.jpg', 2, 0, 0, 1, 0, 0, 177);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `image` varchar(64) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `Date` text DEFAULT NULL,
  `username` text NOT NULL,
  `likes` bigint(20) NOT NULL,
  `report` tinyint(1) NOT NULL COMMENT '0=> not reported ,\r\n1=> reported'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `content`, `image`, `created_at`, `updated_at`, `user_id`, `Date`, `username`, `likes`, `report`) VALUES
(72, 'sss', NULL, '2023-06-30 20:01:29', NULL, 97, '30 June', 'omnia magdy', 0, 0),
(73, 'hdf', NULL, '2023-06-30 20:01:44', NULL, 97, '30 June', 'omnia magdy', 0, 0),
(74, 'rrr', NULL, '2023-06-30 20:01:54', NULL, 97, '30 June', 'omnia magdy', 0, 0),
(75, '\'', NULL, '2023-06-30 20:11:51', NULL, 97, '30 June', 'omnia magdy', 0, 0),
(76, 'sx', NULL, '2023-06-30 20:13:25', NULL, 97, '30 June', 'omnia magdy', 0, 0),
(77, 'm', NULL, '2023-06-30 20:17:51', NULL, 97, '30 June', 'omnia magdy', 0, 0),
(78, 'scc', NULL, '2023-06-30 20:18:02', NULL, 97, '30 June', 'omnia magdy', 0, 0),
(79, ';', NULL, '2023-06-30 20:18:21', NULL, 97, '30 June', 'omnia magdy', 0, 0),
(80, 'd', NULL, '2023-06-30 20:19:19', NULL, 97, '30 June', 'omnia magdy', 0, 0),
(81, 'c55', NULL, '2023-06-30 20:21:33', '2023-07-01 02:53:56', 97, '30 June', 'omnia magdy', 0, 0),
(83, 'HI peoplr', NULL, '2023-07-02 15:14:05', '2023-07-10 02:41:57', 154, '2 July', 'Reem Adel', 0, 1),
(84, 'HI peoplr', NULL, '2023-07-03 17:57:03', '2023-07-10 01:57:17', 146, '3 July', 'Gamila Khaled', 0, 1),
(88, 'Hi Everyone', NULL, '2023-07-10 02:16:32', NULL, 177, '10 July', 'Laila Ahmed', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_code` bigint(20) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` smallint(3) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `image` varchar(64) NOT NULL DEFAULT 'default.jpg',
  `status` tinyint(1) NOT NULL COMMENT '0=>not active, 1=>active',
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `product_code`, `price`, `quantity`, `details`, `image`, `status`, `subcategory_id`, `category_id`) VALUES
(1, 'Purina One', 1234, '120.00', 4, 'Natural SmartBlend Chicken & Rice Formula Dry Dog Food, 40-lb bag', 'Purina One.webp', 1, 1, 1),
(2, 'Lams', 1235, '110.00', 5, 'Proactive Health MiniChunks Small Kibble Adult Chicken & Whole Grain High Protein Dry Dog', 'Lams.webp', 1, 1, 1),
(3, 'Pedigree', 1236, '130.00', 6, 'Complete Nutrition Grilled Steak & Vegetable Flavor Dog Kibble Adult Dry Dog Food', 'pedigree.webp', 1, 1, 1),
(4, 'Purina Pro Plan', 1237, '150.00', 2, 'High Protein Shredded Blend Chicken & Rice Formula with Probiotics Dry Dog Food', 'Proplan.webp', 1, 1, 1),
(5, 'Dog Socks', 1238, '50.00', 10, 'Non-Skid Non-Skid Fair Isle Dog Socks, Size 2', 'Dog Socks.webp', 1, 2, 1),
(6, 'Kurgo', 1239, '40.00', 8, 'Non-Skid Non-Skid Fair Isle Dog Socks, Size 2', 'Kurgo.webp', 1, 2, 1),
(8, 'Star Wars', 1240, '20.00', 6, 'THE MANDALORIAN GROGU \"Cutest Bounty\" Reversible Dog Bandana, Medium/Large', 'Star Wars.jpg', 1, 2, 1),
(9, 'Nylabone', 1241, '40.00', 8, 'Power Chew Variety Triple Pack Chicken, Bacon & Peanut Butter, Small', 'Nylabone.jpg', 1, 4, 1),
(11, 'Pacific Pups Rescue', 1243, '105.00', 4, 'Ball Dog Toy Variety Pack, 6 count', 'Pacific Pups Rescue.jpg', 1, 4, 1),
(13, 'Star Wars', 1245, '100.00', 2, 'R2-D2 \"Beep! Beep! Beep! Feed Me Treats!\" Dog T-shirt, Medium', 'Star Wars T-shirt.webp', 1, 3, 1),
(14, 'Meaw Mix', 1250, '190.00', 3, 'Original Choice Dry Cat Food, 22-lb bag', 'Meaw Mix.webp', 1, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` bigint(20) NOT NULL,
  `rate` tinyint(4) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_provider_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `rate`, `user_id`, `service_provider_id`) VALUES
(15, 4, 146, 132),
(16, 2, 146, 132),
(17, 4, 146, 132),
(18, 4, 146, 142),
(19, 2, 146, 142),
(20, 4, 146, 142),
(21, 4, 177, 163);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` bigint(20) NOT NULL,
  `content` text NOT NULL,
  `date` text NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `username` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `report` tinyint(1) NOT NULL COMMENT '0=> not reported,\r\n1=> reported'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `content`, `date`, `comment_id`, `user_id`, `username`, `created_at`, `updated_at`, `report`) VALUES
(15, '000', '30 June', 47, 97, 'omnia magdy', '2023-06-30 20:26:58', NULL, 0),
(18, 'wow', '7 July', 50, 168, 'Yara Gamal', '2023-07-07 21:26:23', NULL, 0),
(19, 'do you need help?', '8 July', 50, 142, 'Ola Emad', '2023-07-08 02:03:25', NULL, 0),
(20, 'hello?', '8 July', 51, 162, 'Wael Hussien', '2023-07-08 04:29:10', NULL, 0),
(23, 'Hi', '10 July', 47, 177, 'Laila Ahmed', '2023-07-10 02:17:26', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `serviceproviders`
--

CREATE TABLE `serviceproviders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_provider_type` tinyint(1) NOT NULL COMMENT '0=>vet, 1=>Trainer, 2=>Sitter, 3=>Hotel Manager',
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `serviceproviders`
--

INSERT INTO `serviceproviders` (`id`, `service_provider_type`, `user_id`) VALUES
(17, 3, 127),
(19, 1, 132),
(20, 1, 133),
(21, 1, 134),
(22, 1, 135),
(29, 2, 142),
(30, 2, 143),
(31, 0, 144),
(33, 1, 149),
(34, 1, 151),
(35, 1, 154),
(36, 0, 157),
(37, 3, 158),
(38, 3, 160),
(39, 0, 161),
(40, 1, 162),
(41, 2, 163),
(44, 0, 167),
(46, 2, 178);

-- --------------------------------------------------------

--
-- Table structure for table `sitters`
--

CREATE TABLE `sitters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_days` varchar(255) NOT NULL,
  `price_per_hour` decimal(8,2) NOT NULL,
  `rate` tinyint(4) DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sitters`
--

INSERT INTO `sitters` (`id`, `work_days`, `price_per_hour`, `rate`, `address_id`, `user_id`) VALUES
(3, 'Monday', '12.00', 4, 86, 142),
(5, 'sunday, monday', '50.00', 4, 158, 163),
(9, 'Sunday, Monday', '100.00', NULL, 175, 178);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`) VALUES
(1, 'Food', 1),
(2, 'Accessories', 1),
(3, 'Clothes', 1),
(4, 'Toys', 1),
(5, 'Food', 2),
(6, 'Accessories', 2),
(7, 'Clothes', 2),
(8, 'Toys', 2),
(9, 'Food', 3),
(10, 'Accessories', 3),
(11, 'Toys', 3),
(12, 'Food', 4),
(13, 'Toys', 4),
(14, 'Food', 5),
(15, 'Toys', 5);

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_days` varchar(255) NOT NULL,
  `price_per_hour` decimal(8,2) NOT NULL,
  `rate` tinyint(4) DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `work_days`, `price_per_hour`, `rate`, `address_id`, `user_id`) VALUES
(21, 'Sunday, Monday, Friday', '10.00', 3, 76, 132),
(25, 'Friday,Monday', '19.00', NULL, 93, 149),
(26, 'sunday', '21.00', NULL, 94, 151),
(27, 'sunday, monday', '25.00', NULL, 95, 154),
(28, 'Sunday, Monday, Friday', '150.00', NULL, 157, 162);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `phone` char(11) NOT NULL,
  `image` varchar(64) NOT NULL DEFAULT 'default.jpg',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=> not active, 1=> active',
  `admin_status` tinyint(1) NOT NULL COMMENT '0=> user, 1=>admin',
  `banned` tinyint(1) NOT NULL COMMENT '0 => not banned, 1 => banned',
  `service_provider_status` tinyint(1) NOT NULL COMMENT '0=> customer, 1=>service provider',
  `service_provider_type` tinyint(1) DEFAULT NULL COMMENT '0=>vet, 1=>Trainer, 2=>Sitter, 3=>Hotel Manager',
  `verification_code` mediumint(6) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `gender`, `phone`, `image`, `status`, `admin_status`, `banned`, `service_provider_status`, `service_provider_type`, `verification_code`, `email_verified_at`) VALUES
(14, 'Janet', 'Emad', 'janetemad5@gmail.com', '$2y$10$NrlW.1tboxcrgWoXBOn0..TRbwiR6xYK/k82GEJyJ53hDvfIUdnM.', 'f', '01115953142', 'default.jpg', 1, 0, 0, 0, NULL, 886396, '2023-02-23 04:38:57'),
(97, 'om', 'ma', 'omniamagdi21@gmail.com', '$2y$10$xyr2Hq/u/6rinU8UaeONP.YllfMF7JMrrrnvUlvrAOK.fAM2S1tfS', 'f', '01098184691', 'default.jpg', 1, 0, 0, 0, NULL, 677521, '2023-06-30 22:57:29'),
(127, 'Omar', 'Emad', 'jero3001emad@gmail.com', '$2y$10$Ow6YqDiSFjHe66idKkZ2ruJePq.v/szDp9RzsKOOTZLUaZcHPdU7y', 'm', '01115253142', 'OIP (2).jpeg', 1, 0, 0, 1, 3, 345560, '2023-06-26 18:53:58'),
(129, 'Janet', 'Emad', 'jero6emad@gmail.com', '$2y$10$E0jQOsY1cgljEi.eVY8EIuf7WYeCnLGK.S3Doys.3PAtadC7dCEjW', 'f', '01224444444', 'dog-rolling-and-rubbing-their-head.webp', 1, 0, 0, 0, NULL, 892646, '2023-06-25 22:49:58'),
(132, 'Janet', 'Emad', 'jero2015emad@gmail.com', '$2y$10$4hUd2yIQfVL1C4bCzAB0XO1r81RUGJARMJFTjWgM10ZxFTip2Yf.G', 'f', '01115953141', 'default.jpg', 1, 0, 0, 1, 1, 935584, NULL),
(133, 'Yara', 'Gamal', 'jero2014emad@gmail.com', '$2y$10$kUJ34V9Nua3ICH8uNhg6nOftuvFq.37nSH1O3ShciqCoPefSWbc9a', 'f', '01115953143', 'default.jpg', 1, 0, 0, 1, 1, 932317, '2023-06-25 17:04:44'),
(134, 'Aya', 'Alaa', 'jero2013emad@gmail.com', '$2y$10$mLZ7BXZmTMsxAwg1N99SUOos9nqOFwn3hdLOi2VYJHC747cFz2Lm2', 'f', '01115953144', 'default.jpg', 1, 0, 0, 1, 1, 595577, NULL),
(135, 'Dalia', 'Mohsen', 'jero2012emad@gmail.com', '$2y$10$uSWJH/2HDa0ifCcvRU6BJesF9WlsWXSzPo5WEjx4PvCvcv9KDPBne', 'f', '01115953146', 'default.jpg', 1, 0, 0, 1, 1, 377639, NULL),
(142, 'Ola', 'Emad', 'jero2009emad@gmail.com', '$2y$10$BjfT5QJZj1cvw7eH5Tz8L.h0pElo1tO9pgeiOCCC7NkZWACwMdkJi', 'f', '01115953149', 'default.jpg', 1, 0, 0, 1, 2, 700254, NULL),
(143, 'Pet', 'soul', 'jero2008emad@gmail.com', '$2y$10$8PTIp6oZRSG55TeTveYu8uYjwk14aJbO0Nnny/i2tY/.2lqSNVRk.', 'f', '01111111111', '76790e776a939a8bcd35422779e417db.jpg', 1, 0, 0, 1, 2, 170372, '2023-06-26 18:30:04'),
(144, 'Ahmed', 'Adel', 'ahmed@gmaail.com', '$2y$10$/9xplBp3It3PwTf1it2HkOf0ia8pJEy4l0p3dGtzcga6sHQfsCsWC', 'm', '01115953111', 'default.jpg', 1, 0, 0, 1, 0, 382270, NULL),
(145, 'Amani', 'Emad', 'amaniemad@gmail.com', '$2y$10$hA80R630JWSt87/nlc.rceBZC8SkmpZqp/mSgmlunEqLj8HjoZgeu', 'f', '01115953500', 'Dog paw-cuate.png', 1, 0, 1, 0, NULL, 331330, '2023-07-05 06:56:44'),
(146, 'Gamila', 'Khaled', 'jero5emad@gmail.com', '$2y$10$BfYHuKii7dN4KlBRgIBOTe8nXKYriLslsrdpzajyDUqjI0/wEHu4y', 'f', '01115953556', 'default.jpg', 1, 0, 0, 0, NULL, 706446, '2023-06-25 23:01:51'),
(149, 'Samira', 'Emad', 'jero00emad@gmail.com', '$2y$10$YSnG/mng9I5MrC.hnhEf9uYzwmc42EJTLCL2OlqfVQ4Bi6eowrL2G', 'f', '01115953102', 'default.jpg', 1, 0, 0, 1, 1, 134716, '2023-06-26 18:13:50'),
(150, 'Maria', 'Emad', 'jeroemad@gmail.com', '$2y$10$5ms9DtJvpbrQFF7dHZ8xiufKN4GhuKF3F6azhRb/iBdlXXa.XAjIi', 'f', '01115950000', 'default.jpg', 1, 0, 0, 0, NULL, 566967, NULL),
(151, 'Talia', 'Emad', 'taliaemad@gmail.com', '$2y$10$z88qc0So5iL/LJ3qxZi8JesaDEhFXSvUay7jhPkdc0Nc2wk.S.5ZC', 'f', '01115900000', '5282873907_dc42328235_z.jpg', 1, 0, 0, 1, 1, 156581, '2023-07-01 03:23:15'),
(154, 'Reem', 'Adel', 'reemadel@gmail.com', '$2y$10$ioEqcQ95F08xLFiFb4S9J.qzZoDaGqUthODrD7nezqlaNGyoz96sS', 'f', '01115951111', 'default.jpg', 1, 0, 1, 1, 1, 216542, '2023-07-10 02:36:54'),
(156, 'Jadmin', 'Emad', 'admin@gmail.com', '123456789@Yy', 'm', '01111111112', 'default.jpg', 1, 1, 0, 0, NULL, NULL, '2023-07-10 00:50:35'),
(157, 'Janet', 'Emad', 'jeremad@gmail.com', '$2y$10$EKs.HNKG3ks28uHoFLoWqe9bScdnixk4DZdLpDT5LEks5vdMJgaFS', 'f', '01115999999', 'default.jpg', 1, 0, 0, 1, 0, 927452, NULL),
(158, 'Janet', 'Emad', 'jeromad@gmail.com', '$2y$10$W4WwPWmhkpADsIbpf5JI0enmNaWqjbR68CY4MNlLTWGQXb.s81AxS', 'f', '01233333333', 'default.jpg', 1, 0, 0, 1, 3, 746189, NULL),
(159, 'Janet', 'Emad', 'jemad@gmail.com', '$2y$10$mXBgcYfJyp64MjTRP.lyPe7LIj9rT/eXWTj7JU8KVetoJBxlPjm6q', 'f', '01199999999', 'default.jpg', 1, 0, 0, 0, NULL, 108259, NULL),
(160, 'Youssef', 'Ahmed', 'youssefahmed@gmail.com', '$2y$10$.oK74KFrhaJ4GrtEEcjyEeoVenF3ieGi3WwEYBY60R7fTuVtyLlL.', 'm', '01111111113', 'default.jpg', 1, 0, 0, 1, 3, 892034, '2023-07-05 06:18:00'),
(161, 'Yasmine', 'Helmy', 'yasminehelmy23@gmail.com', '$2y$10$MOPpqWQuONFn2Wnf1zEeceCmB526JDO9uPr1FnMHR2MEvfyteNNP2', 'f', '01115111166', 'R (6).jpeg', 1, 0, 0, 1, 0, 303538, '2023-07-05 12:21:48'),
(162, 'Wael', 'Hussien', 'waelhussien@gmail.com', '$2y$10$F3hbYjSXI0Xb57.9RbNzYOVui3LV/snbJdKBY.u2I6fnpf.5hdGvC', 'm', '01237779977', 'OIP (2).jpeg', 1, 0, 0, 1, 1, 839771, '2023-07-05 12:34:06'),
(163, 'Jasmin', 'Adel', 'jasminadel@gmail.com', '$2y$10$9jq331Kinvku24ESuAod9eo8pevDAMrKMSOFYiY7FBDsP/WqRqUZy', 'f', '01248882282', 'image.jpg', 1, 0, 0, 1, 2, 742854, '2023-07-05 07:26:51'),
(166, 'Reem', 'Mostafa', 'reemmostafa@gmail.com', '$2y$10$2ig6z1O8zLFDLxZ9bVe2XOKXIqmlr5UbRJ8nZAZpVv89HWO4rXdem', 'f', '01232229933', 'R (14).jpeg', 1, 0, 0, 0, NULL, 656377, '2023-07-10 02:30:50'),
(167, 'Hana', 'Tamer', 'hanatamer@gmail.com', '$2y$10$26pH3fEr/JIQir.u58xMo.fmL.KVYfIfV0MWZ4sa4e9ussDc1l..i', 'f', '01112343215', 'R (14).jpeg', 1, 0, 0, 1, 0, 921817, '2023-07-07 14:38:10'),
(168, 'Yara', 'Gamal', 'yaragamal@gmail.com', '$2y$10$adQEDsPImaoleQ0TYQ1LVuqxRGmKUMjEQ1beBdmRMmLcSoUoeA2cK', 'f', '01218983454', 'AdminHome.jpeg', 1, 0, 0, 0, NULL, 201755, '2023-07-07 14:49:44'),
(177, 'Laila', 'Ahmed', 'lailaahmed@gmail.com', '$2y$10$TqWsBtVJYbYM4S8s4Q.HWu3m1OBIkag/4noxkJiWe5i8cs83gXQXy', 'f', '01112345654', 'laila.jpeg', 1, 0, 0, 0, NULL, 274435, '2023-07-10 02:13:05'),
(178, 'Salma', 'Ahmed', 'salmaahmed@gmail.com', '$2y$10$bJQNihDE.BgaHwtSB9zBmunKw0aZJr8/0kkDsQheN1x6Brc.5ZgwG', 'f', '01113456578', 'default.jpg', 1, 0, 0, 1, 2, 450637, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `veterinaries`
--

CREATE TABLE `veterinaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clinic_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `veterinaries`
--

INSERT INTO `veterinaries` (`id`, `clinic_id`, `user_id`) VALUES
(14, 14, 144),
(15, 15, 144),
(16, 16, 144),
(18, 18, 161),
(19, 19, 167),
(21, 21, 161);

-- --------------------------------------------------------

--
-- Table structure for table `vst_reservations`
--

CREATE TABLE `vst_reservations` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_provider_id` bigint(20) UNSIGNED NOT NULL,
  `come_at` datetime DEFAULT NULL,
  `leave_at` datetime DEFAULT NULL,
  `date` date DEFAULT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `clinic_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vst_reservations`
--

INSERT INTO `vst_reservations` (`id`, `user_id`, `service_provider_id`, `come_at`, `leave_at`, `date`, `total_price`, `clinic_id`) VALUES
(1, 145, 31, NULL, NULL, '2023-07-11', '0.00', NULL),
(2, 145, 31, NULL, NULL, '2023-07-21', '25.00', NULL),
(3, 145, 31, NULL, NULL, '2023-07-14', '25.00', NULL),
(4, 145, 31, NULL, NULL, '2023-07-19', '30.00', 16),
(5, 145, 31, NULL, NULL, '2023-07-05', '25.00', 15),
(6, 145, 31, NULL, NULL, '2023-07-07', '10.00', 14),
(7, 145, 29, '2023-07-05 14:53:00', '2023-07-05 18:53:00', NULL, '48.00', NULL),
(8, 145, 29, '2023-07-10 21:02:00', '2023-07-10 23:02:00', NULL, '24.00', NULL),
(9, 145, 19, '2023-07-07 15:12:00', '2023-07-07 18:12:00', NULL, '30.00', NULL),
(10, 145, 19, '2023-07-07 15:15:00', '2023-07-07 19:15:00', NULL, '40.00', NULL),
(11, 145, 29, '2023-07-10 15:28:00', '2023-07-10 20:28:00', NULL, '60.00', NULL),
(12, 145, 29, '2023-07-10 15:40:00', '2023-07-10 19:40:00', NULL, '48.00', NULL),
(13, 145, 29, '2023-07-10 15:40:00', '2023-07-10 19:40:00', NULL, '48.00', NULL),
(14, 166, 39, NULL, NULL, '2023-07-17', '120.00', 18),
(15, 166, 39, NULL, NULL, '2023-07-10', '120.00', 18),
(16, 166, 40, '2023-07-10 14:31:00', '2023-07-10 20:31:00', NULL, '900.00', NULL),
(17, 166, 40, '2023-07-16 14:32:00', '2023-07-16 14:37:00', NULL, '12.50', NULL),
(18, 166, 40, '2023-07-23 14:32:00', '2023-07-23 19:32:00', NULL, '750.00', NULL),
(19, 166, 33, '2023-07-14 01:38:00', '2023-07-14 05:39:00', NULL, '76.32', NULL),
(20, 166, 34, '2023-07-23 01:46:00', '2023-07-23 06:46:00', NULL, '105.00', NULL),
(21, 166, 34, '2023-07-16 01:52:00', '2023-07-16 04:53:00', NULL, '63.35', NULL),
(22, 166, 34, '2023-07-16 01:55:00', '2023-07-16 04:55:00', NULL, '63.00', NULL),
(23, 166, 40, '2023-07-16 02:01:00', '2023-07-16 06:01:00', NULL, '600.00', NULL),
(24, 166, 40, '2023-07-16 02:03:00', '2023-07-16 06:04:00', NULL, '602.50', NULL),
(25, 166, 35, '2023-07-17 02:25:00', '2023-07-17 05:26:00', NULL, '75.42', NULL),
(26, 166, 19, '2023-07-21 02:29:00', '2023-07-21 05:29:00', NULL, '30.00', NULL),
(27, 166, 19, '2023-07-16 02:38:00', '2023-07-16 06:38:00', NULL, '40.00', NULL),
(28, 166, 19, '2023-07-09 02:40:00', '2023-07-09 06:40:00', NULL, '40.00', NULL),
(29, 166, 19, '2023-07-16 02:41:00', '2023-07-16 05:41:00', NULL, '30.00', NULL),
(30, 166, 19, '2023-07-16 02:46:00', '2023-07-16 05:46:00', NULL, '30.00', NULL),
(31, 166, 19, '2023-07-16 02:54:00', '2023-07-16 05:54:00', NULL, '30.00', NULL),
(32, 166, 19, '2023-07-16 02:57:00', '2023-07-16 04:57:00', NULL, '20.00', NULL),
(33, 166, 19, '2023-07-09 02:58:00', '2023-07-09 04:58:00', NULL, '20.00', NULL),
(34, 166, 19, '2023-07-16 02:59:00', '2023-07-16 05:59:00', NULL, '30.00', NULL),
(35, 166, 19, '2023-07-16 03:02:00', '2023-07-16 05:02:00', NULL, '20.00', NULL),
(36, 166, 19, '2023-07-16 03:05:00', '2023-07-16 06:05:00', NULL, '30.00', NULL),
(37, 166, 40, '2023-07-16 03:06:00', '2023-07-16 07:06:00', NULL, '600.00', NULL),
(38, 166, 40, '2023-07-09 03:08:00', '2023-07-09 06:08:00', NULL, '450.00', NULL),
(39, 166, 40, '2023-07-09 03:16:00', '2023-07-09 06:17:00', NULL, '452.50', NULL),
(40, 166, 40, '2023-07-09 03:18:00', '2023-07-09 06:18:00', NULL, '450.00', NULL),
(41, 166, 40, '2023-07-09 03:19:00', '2023-07-09 07:19:00', NULL, '600.00', NULL),
(42, 166, 40, '2023-07-09 03:20:00', '2023-07-09 06:20:00', NULL, '450.00', NULL),
(43, 166, 40, '2023-07-09 03:23:00', '2023-07-09 06:23:00', NULL, '450.00', NULL),
(44, 166, 40, '2023-07-09 06:23:00', '2023-07-09 00:23:00', NULL, '-900.00', NULL),
(45, 166, 40, '2023-07-09 03:25:00', '2023-07-09 06:25:00', NULL, '450.00', NULL),
(46, 166, 33, '2023-07-10 03:29:00', '2023-07-10 10:29:00', NULL, '133.00', NULL),
(47, 166, 41, '2023-07-10 03:35:00', '2023-07-10 09:35:00', NULL, '300.00', NULL),
(50, 177, 34, '2023-07-16 04:14:00', '2023-07-16 07:14:00', NULL, '63.00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `address` (`address`),
  ADD KEY `addresses_regions_FK` (`user_id`);

--
-- Indexes for table `alarms`
--
ALTER TABLE `alarms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alarms_users_FK` (`user_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `carts_products_FK` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `clinics_addresses_FK` (`address_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_posts_FK` (`post_id`);

--
-- Indexes for table `favs`
--
ALTER TABLE `favs`
  ADD PRIMARY KEY (`user_id`,`product_id`);

--
-- Indexes for table `hotelmanagers`
--
ALTER TABLE `hotelmanagers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotelmanagers_hotels_FK` (`hotel_id`),
  ADD KEY `hotelmanagers_users_FK` (`user_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `hotels_addresses_FK` (`address_id`),
  ADD KEY `hotel_users_FK` (`user_id`);

--
-- Indexes for table `hotel_reservations`
--
ALTER TABLE `hotel_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_users_FK` (`user_id`),
  ADD KEY `reservations_serviceproviders_FK` (`service_provider_id`),
  ADD KEY `reservation_hotels_FK` (`hotel_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_chats_FK` (`chat_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_users_fk` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_addresses_FK` (`address_id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `o_p_p_FK` (`product_id`);

--
-- Indexes for table `petreports`
--
ALTER TABLE `petreports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pets_users` (`user_id`),
  ADD KEY `pets_categories_FK` (`category_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_users_FK` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`),
  ADD KEY `products_categories_FK` (`subcategory_id`),
  ADD KEY `products_categoriess_FK` (`category_id`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rates_users_FK` (`user_id`),
  ADD KEY `rates_providers_FK` (`service_provider_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `replies_comments_fk` (`comment_id`);

--
-- Indexes for table `serviceproviders`
--
ALTER TABLE `serviceproviders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serviceproviders_users_FK` (`user_id`);

--
-- Indexes for table `sitters`
--
ALTER TABLE `sitters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sitters_addresses_FK` (`address_id`),
  ADD KEY `sitters_users_FK` (`user_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_categories_FK` (`category_id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainers_addresses_FK` (`address_id`),
  ADD KEY `trainers_users_FK` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `veterinaries`
--
ALTER TABLE `veterinaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `veterinaries_clinics_FK` (`clinic_id`),
  ADD KEY `veterinaries_users_FK` (`user_id`);

--
-- Indexes for table `vst_reservations`
--
ALTER TABLE `vst_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vst_reservations_users_FK` (`user_id`),
  ADD KEY `vst_reservations_providers_FK` (`service_provider_id`),
  ADD KEY `vst_reservations_clinics_FK` (`clinic_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `alarms`
--
ALTER TABLE `alarms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `hotelmanagers`
--
ALTER TABLE `hotelmanagers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hotel_reservations`
--
ALTER TABLE `hotel_reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `petreports`
--
ALTER TABLE `petreports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `serviceproviders`
--
ALTER TABLE `serviceproviders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `sitters`
--
ALTER TABLE `sitters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `veterinaries`
--
ALTER TABLE `veterinaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `vst_reservations`
--
ALTER TABLE `vst_reservations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alarms`
--
ALTER TABLE `alarms`
  ADD CONSTRAINT `alarms_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_products_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clinics`
--
ALTER TABLE `clinics`
  ADD CONSTRAINT `clinics_addresses_FK` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_posts_FK` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hotelmanagers`
--
ALTER TABLE `hotelmanagers`
  ADD CONSTRAINT `hotelmanagers_hotels_FK` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hotelmanagers_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotel_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hotels_addresses_FK` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `hotel_reservations`
--
ALTER TABLE `hotel_reservations`
  ADD CONSTRAINT `reservation_hotels_FK` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_serviceproviders_FK` FOREIGN KEY (`service_provider_id`) REFERENCES `serviceproviders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_chats_FK` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_addresses_FK` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD CONSTRAINT `o_p_o_FK` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `o_p_p_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_categories_FK` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pets_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_categoriess_FK` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_subcategories_FK` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `rates_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_comments_FK` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `serviceproviders`
--
ALTER TABLE `serviceproviders`
  ADD CONSTRAINT `serviceproviders_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sitters`
--
ALTER TABLE `sitters`
  ADD CONSTRAINT `sitters_addresses_FK` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sitters_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_categories_FK` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trainers`
--
ALTER TABLE `trainers`
  ADD CONSTRAINT `trainers_addresses_FK` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `trainers_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `veterinaries`
--
ALTER TABLE `veterinaries`
  ADD CONSTRAINT `veterinaries_clinics_FK` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `veterinaries_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vst_reservations`
--
ALTER TABLE `vst_reservations`
  ADD CONSTRAINT `vst_reservations_clinics_FK` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vst_reservations_providers_FK` FOREIGN KEY (`service_provider_id`) REFERENCES `serviceproviders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vst_reservations_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
