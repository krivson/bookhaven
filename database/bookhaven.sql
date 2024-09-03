-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 01:30 PM
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
-- Database: `bookhaven`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `publication_year` int(11) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `page_count` int(11) NOT NULL,
  `language` varchar(50) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `publication_year`, `genre`, `isbn`, `page_count`, `language`, `publisher`, `image`, `description`, `stock`, `price`) VALUES
(1, 'Jujutsu Kaisen 05', 'Gege Akutami', 2022, 'Fiction', '9786230029783', 200, 'English', 'Elex Media Komputindo', 'Jujutsu Kaisen 05.jpg', 'Semua orang terkejut ketika mereka mengetahui Itadori masih hidup, tetapi tidak ada waktu untuk reuni yang mengharukan ketika Jujutsu High berada di tengah-tengah persaingan ketat dengan saingan mereka dari Kyoto! Tapi sportifitas yang baik tampaknya tidak ada dalam kartu begitu pihak berwenang memutuskan untuk menghilangkan ancaman Sukuna sekali dan untuk selamanya.\r\n\r\nDalam pergantian peristiwa yang tidak terduga, Aoi sangat menyukai Yuji. Yakin bahwa mereka adalah sahabat, Aoi bahkan melontarkan rencana timnya sendiri untuk membunuh Yuji. Sementara itu, Megumi dan yang lainnya mulai mengejar rival Kyoto mereka untuk melindungi Yuji juga.\r\n\r\nTim Tokyo dapat mengetahui skema Tim Kyoto. Megumi dan Maki kembali untuk melindungi Yuji, menghadapi saingan mereka karena mencoba membunuhnya. Sementara itu, Aoi menyadari potensi Yuji, dan memutuskan untuk membantu membawanya ke level berikutnya.\r\n\r\nSaat duel Yuji dengan Aoi, Todo mencapai klimaksnya, dia belajar apa artinya mencapai potensinya. Dengan keahlian membimbing Aoi, Yuji mulai tumbuh menuju tingkat kekuatan baru. Sementara itu, Mechamaru mendukung Momo dalam konfrontasinya dengan Nobara dan Panda.', 0, 32000.00),
(2, 'Melangkah', 'J. S Khairen', 2020, 'Non-Fiction', '9786020523316', 368, 'English', 'Gramedia Widiasarana Indonesia', '9786020523316_Melangkah_UV_Spot_R4-1__w150_hauto.jpg', 'Listrik padam di seluruh Jawa dan Bali secara misterius. Ancaman nyata kekuatan baru yang hendak menaklukkan Nusantara.\r\n\r\nSaat yang sama, empat sahabat mendarat di Sumba, hanya untuk mendapati nasib ratusan juta manusia ada di tangan mereka! Empat mahasiswa ekonomi ini, harus bertarung melawan pasukan berkuda yang bisa melontarkan listrik! Semua dipersulit oleh seorang buronan tingkat tinggi bertopeng pahlawan yang punya rencana mengerikan.\r\n\r\nTernyata pesan arwah nenek moyang itu benar-benar terwujud. “Akan datang kegelapan yang berderap, bersama ribuan kuda raksasa di kala malam. Mereka bangun setelah sekian lama, untuk menghancurkan Nusantara. Seorang lelaki dan seorang perempuan ditakdirkan membaurkan air di lautan dan api di pegunungan. Menyatukan tanah yang menghujam, dan udara yang terhampar.”\r\n\r\nKisah tentang persahabatan, tentang jurang ego anak dan orangtua, tentang menyeimbangkan logika dan perasaan. Juga tentang melangkah menuju masa depan. Bahwa, apa pun yang menjadi luka masa lalu, biarlah mengering bersama waktu.', 48, 74400.00);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `total_products` varchar(535) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(9) NOT NULL DEFAULT 'Process',
  `delivery_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `name`, `email`, `address`, `phone`, `city`, `zip_code`, `total_products`, `order_date`, `total_amount`, `status`, `delivery_date`) VALUES
(1, 1, 'Farel Aranta', 'farelaranta@gmail.com', 'Jawa Barat, Bekasi, Tambun Selatan', '082110773354', 'Bekasi', '17750', 'Jujutsu Kaisen 05(2), Melangkah(2)', '2023-12-14', 212800.00, 'Arrived', '2023-12-15'),
(2, 1, 'Farel Aranta', 'farelaranta@gmail.com', 'Jawa Barat, Bekasi, Tambun Selatan', '08123456789', 'Bekasi', '17750', 'Jujutsu Kaisen 05(98)', '2023-12-15', 3136000.00, 'Arrived', '2023-12-15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `address` text NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `type` varchar(6) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `address`, `created_date`, `type`) VALUES
(1, 'Farel Aranta', 'farelaranta@gmail.com', '$2y$10$qsFFUB02pCPymbYvEy/qY.TZC63LlKwQuTHDS6Oj9yPK47K6J7zZ6', 'Jawa Barat, Bekasi, Tambun Selatan', '2023-12-13', 'user'),
(2, 'Admin', 'admin@gmail.com', '$2y$10$sJsvL/sUOg.koyVIbjqhnOjLo38X2dxaRl06GUoWbZdWluNcehYFG', 'Bekasi', '2023-12-13', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
