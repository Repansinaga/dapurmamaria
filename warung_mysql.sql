-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2025 at 03:42 PM
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
-- Database: `warung_mysql`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$lhXEfxI4Fk7L.3Y0RQePleqgjwMAsVgaC5YvdXreP.MrHU4E/oDi6'),
(2, 'admin 2', 'admin2@gmail.com', '$2y$10$aac.z8m6zsX6c2s7QF6e0.CwGBObQQ5F.Icpsnq/82NOFrBhWJWqO'),
(3, 'admintampan', 'admintampan123@gmail.com', '$2y$10$4CBwRrYaSf1TiG20tTxRPOdiWk/gKy3CZ5s8UN.1syZ6CUbtljU2O'),
(4, 'superadmin', 'superadmin@gmail.com', '$2y$10$Mw1l9McDjP7Ky2DZqEkOZuPd4wznaUVDb5812wIeGJPtemGqp6mJa');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` enum('Makanan','Minuman') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(1, 'Makanan'),
(2, 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `keuangan`
--

CREATE TABLE `keuangan` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `sumber` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keuangan`
--

INSERT INTO `keuangan` (`id`, `admin_id`, `sumber`, `nominal`, `tanggal`) VALUES
(2, 3, 'pemasukan', 250000, '2025-05-14'),
(3, 3, 'pengeluaran', 100000, '2025-05-12'),
(5, 4, 'pemasukan', 200000, '2025-01-17'),
(8, 3, 'pemasukan', 21535, '2023-08-23'),
(9, 3, 'pemasukan', 21857, '2023-01-02'),
(10, 3, 'pengeluaran', 17161, '2024-02-03'),
(11, 3, 'pemasukan', 82766, '2024-02-25'),
(12, 3, 'pemasukan', 57994, '2023-08-15'),
(13, 3, 'pengeluaran', 84850, '2023-08-08'),
(14, 3, 'pemasukan', 22214, '2024-04-24'),
(15, 3, 'pengeluaran', 46156, '2023-10-10'),
(16, 3, 'pengeluaran', 52764, '2023-05-23'),
(17, 3, 'pengeluaran', 24910, '2023-05-10'),
(18, 3, 'pemasukan', 48185, '2024-11-22'),
(19, 3, 'pemasukan', 52298, '2024-12-04'),
(20, 3, 'pemasukan', 22874, '2023-12-28'),
(21, 3, 'pemasukan', 77912, '2024-04-03'),
(22, 3, 'pengeluaran', 55420, '2024-10-11'),
(23, 3, 'pengeluaran', 99960, '2023-05-24'),
(24, 3, 'pengeluaran', 40529, '2024-06-22'),
(25, 3, 'pengeluaran', 23453, '2024-06-16'),
(26, 3, 'pemasukan', 81932, '2023-10-23'),
(27, 3, 'pengeluaran', 91335, '2024-04-18'),
(28, 3, 'pengeluaran', 74668, '2024-12-26'),
(29, 3, 'pengeluaran', 17430, '2024-12-12'),
(30, 3, 'pengeluaran', 28385, '2023-04-16'),
(31, 3, 'pemasukan', 20209, '2023-06-24'),
(32, 3, 'pengeluaran', 60370, '2023-06-19'),
(33, 3, 'pemasukan', 74015, '2023-03-23'),
(34, 3, 'pemasukan', 81248, '2024-05-12'),
(35, 3, 'pemasukan', 21438, '2024-01-24'),
(36, 3, 'pemasukan', 81371, '2023-04-07'),
(37, 3, 'pemasukan', 10878, '2023-05-30'),
(38, 3, 'pengeluaran', 43259, '2024-09-17'),
(39, 3, 'pemasukan', 37008, '2024-12-15'),
(40, 3, 'pengeluaran', 12649, '2023-05-03'),
(41, 3, 'pengeluaran', 32710, '2023-01-06'),
(42, 3, 'pemasukan', 45333, '2023-03-24'),
(43, 3, 'pemasukan', 63482, '2024-08-15'),
(44, 3, 'pemasukan', 94626, '2024-10-01'),
(45, 3, 'pengeluaran', 26092, '2023-06-02'),
(46, 3, 'pengeluaran', 92473, '2023-02-10'),
(47, 3, 'pengeluaran', 53348, '2024-08-20'),
(48, 3, 'pengeluaran', 81072, '2023-01-01'),
(49, 3, 'pengeluaran', 25380, '2024-11-24'),
(50, 3, 'pemasukan', 41479, '2023-01-21'),
(51, 3, 'pemasukan', 43109, '2024-02-19'),
(52, 3, 'pengeluaran', 98775, '2024-06-07'),
(53, 3, 'pengeluaran', 98083, '2023-01-12'),
(54, 3, 'pemasukan', 69725, '2024-10-12'),
(55, 3, 'pemasukan', 69752, '2024-10-30'),
(56, 3, 'pengeluaran', 27654, '2023-06-06'),
(57, 3, 'pemasukan', 79055, '2023-10-13'),
(58, 3, 'pengeluaran', 17772, '2023-12-15'),
(59, 3, 'pemasukan', 27305, '2024-03-05'),
(60, 3, 'pemasukan', 14592, '2023-05-02'),
(61, 3, 'pengeluaran', 90150, '2023-11-03'),
(62, 3, 'pemasukan', 88005, '2023-02-12'),
(63, 3, 'pengeluaran', 36423, '2023-10-09'),
(64, 3, 'pemasukan', 17759, '2023-07-27'),
(65, 3, 'pemasukan', 97323, '2023-09-18'),
(66, 3, 'pengeluaran', 36347, '2024-09-09'),
(67, 3, 'pemasukan', 30096, '2023-02-13'),
(68, 3, 'pengeluaran', 96291, '2024-10-27'),
(69, 3, 'pengeluaran', 70733, '2023-08-28'),
(70, 3, 'pengeluaran', 18832, '2024-04-12'),
(71, 3, 'pengeluaran', 66796, '2023-11-05'),
(72, 3, 'pemasukan', 85220, '2024-01-12'),
(73, 3, 'pemasukan', 84160, '2024-10-16'),
(74, 3, 'pemasukan', 41900, '2024-06-29'),
(75, 3, 'pengeluaran', 19726, '2024-01-24'),
(76, 3, 'pemasukan', 16817, '2023-10-02'),
(77, 3, 'pengeluaran', 22785, '2024-06-29'),
(78, 3, 'pemasukan', 38780, '2024-04-27'),
(79, 3, 'pemasukan', 77260, '2024-05-24'),
(80, 3, 'pemasukan', 23740, '2023-01-11'),
(81, 3, 'pengeluaran', 13250, '2023-08-31'),
(82, 3, 'pengeluaran', 79033, '2023-05-10'),
(83, 3, 'pengeluaran', 44881, '2023-05-17'),
(84, 3, 'pengeluaran', 36664, '2023-05-03'),
(85, 3, 'pengeluaran', 31335, '2023-09-07'),
(86, 3, 'pengeluaran', 96928, '2024-09-01'),
(87, 3, 'pemasukan', 88237, '2024-01-17'),
(88, 3, 'pemasukan', 51943, '2023-08-14'),
(89, 3, 'pemasukan', 83066, '2024-03-25'),
(90, 3, 'pengeluaran', 42864, '2024-10-18'),
(91, 3, 'pemasukan', 36329, '2023-07-16'),
(92, 3, 'pemasukan', 59025, '2023-08-16'),
(93, 3, 'pengeluaran', 71146, '2024-04-04'),
(94, 3, 'pemasukan', 68008, '2024-10-21'),
(95, 3, 'pengeluaran', 29692, '2023-09-03'),
(96, 3, 'pemasukan', 19217, '2023-11-22'),
(97, 3, 'pengeluaran', 35727, '2024-04-22'),
(98, 3, 'pemasukan', 19352, '2023-07-24'),
(99, 3, 'pemasukan', 63583, '2024-06-06'),
(100, 3, 'pengeluaran', 84174, '2024-06-22'),
(101, 3, 'pemasukan', 87186, '2024-04-16'),
(102, 3, 'pengeluaran', 42220, '2024-08-15'),
(103, 3, 'pengeluaran', 53628, '2023-12-11'),
(104, 3, 'pengeluaran', 20289, '2024-09-14'),
(105, 3, 'pengeluaran', 15225, '2024-01-15'),
(106, 3, 'pemasukan', 60197, '2024-01-14'),
(107, 3, 'pengeluaran', 14729, '2023-12-29'),
(135, 1, 'pemasukan', 55000, '2025-06-19'),
(136, 1, 'pengeluaran', 26000, '2025-06-19');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `images` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `admin_id`, `nama_menu`, `kategori_id`, `deskripsi`, `harga`, `images`) VALUES
(50, 1, 'Soto Ayam', 1, 'Soto Ayam adalah salah satu hidangan tradisional Indonesia yang terdiri dari kuah kaldu ayam dengan ciri khas warna kuning dari kunyit, berisi suwiran ayam, mi, dan berbagai bahan tambahan seperti telur rebus, sayuran, dan rempah-rempah.', 14000, '1750264034-64f899b3fc57d7880d211c2e18e3bee6.jpg'),
(53, 1, 'Bakso Sapi Tanggung', 1, 'Bakso Tanggung adalah bakso berukuran sedang yang menawarkan keseimbangan sempurna antara rasa, tekstur, dan kepuasan. Dibuat dari daging sapi pilihan yang diolah dengan bumbu khas.', 18000, '1750302781-4352f102cbca4497566b0e14b875d89c.jpg'),
(54, 1, 'Kopi ', 1, 'Rasakan kehangatan dan kenikmatan sejati dari Kopi Pilihan Warung kami. Disajikan dari biji kopi berkualitas tinggi yang diproses dengan cermat, menghasilkan secangkir kopi dengan karakter kuat dan aroma khas yang memikat. Pilihan tepat bagi para pencinta', 5000, '1750301758-823ccdbe458671645391be12b4373c70.jpeg'),
(55, 1, 'Ayam Geprek ', 1, 'Ayam geprek adalah hidangan ayam goreng renyah yang digeprek (dihancurkan) dan dicampur dengan sambal bawang pedas..', 10000, '1750301985-1d3a9e376e12f9f36a34d6ca5395a0fd.jpg'),
(56, 1, 'Nasi Rawon ', 1, 'Nikmati kelezatan Rawon Khas Jawa Timur kami, sajian berkuah hitam pekat yang kaya rempah dengan irisan daging sapi empuk. Disajikan hangat di atas nasi putih pulen, dilengkapi dengan taburan tauge segar, telur asin gurih, dan sambal cabai merah yang meng', 18000, '1750302733-13666b08277532ede00bc385fe55e938.jpg'),
(57, 1, 'Bakso Sapi Kerikil', 1, 'Nikmati kelezatan Bakso Sapi Kerikil kami! Bakso sapi berukuran kecil-kecil yang kenyal dan penuh rasa, disajikan dalam kuah kaldu bening nan gurih. Ditambah dengan mie kuning dan bihun yang lembut, cocok untuk menghangatkan tubuh dan memanjakan lidah.', 18000, '1750302597-c262700dd2b1fd2ef5178ff031411606.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `profil_website`
--

CREATE TABLE `profil_website` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `nama_profil` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telepon` varchar(255) NOT NULL,
  `jam_buka` varchar(255) NOT NULL,
  `jam_tutup` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` enum('kg','buah','butir','gram','ml','liter') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`id`, `admin_id`, `nama_barang`, `jumlah`, `satuan`) VALUES
(5, 3, 'Beras', 7, 'kg');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_rugi_laba`
-- (See below for the actual view)
--
CREATE TABLE `view_rugi_laba` (
`No` bigint(21)
,`tanggal` date
,`Rugi` decimal(33,0)
,`Laba` decimal(33,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `_prisma_migrations`
--

CREATE TABLE `_prisma_migrations` (
  `id` varchar(36) NOT NULL,
  `checksum` varchar(64) NOT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `migration_name` varchar(255) NOT NULL,
  `logs` text DEFAULT NULL,
  `rolled_back_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `applied_steps_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure for view `view_rugi_laba`
--
DROP TABLE IF EXISTS `view_rugi_laba`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_rugi_laba`  AS SELECT row_number() over ( order by `daily_summary`.`tanggal`) AS `No`, `daily_summary`.`tanggal` AS `tanggal`, CASE WHEN coalesce(`daily_summary`.`pemasukan`,0) > coalesce(`daily_summary`.`pengeluaran`,0) THEN 0 ELSE coalesce(`daily_summary`.`pengeluaran`,0) - coalesce(`daily_summary`.`pemasukan`,0) END AS `Rugi`, CASE WHEN coalesce(`daily_summary`.`pemasukan`,0) > coalesce(`daily_summary`.`pengeluaran`,0) THEN coalesce(`daily_summary`.`pemasukan`,0) - coalesce(`daily_summary`.`pengeluaran`,0) ELSE 0 END AS `Laba` FROM (select `keuangan`.`tanggal` AS `tanggal`,sum(case when `keuangan`.`sumber` = 'pemasukan' then `keuangan`.`nominal` else 0 end) AS `pemasukan`,sum(case when `keuangan`.`sumber` = 'pengeluaran' then `keuangan`.`nominal` else 0 end) AS `pengeluaran` from `keuangan` group by `keuangan`.`tanggal`) AS `daily_summary` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `profil_website`
--
ALTER TABLE `profil_website`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `_prisma_migrations`
--
ALTER TABLE `_prisma_migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `profil_website`
--
ALTER TABLE `profil_website`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keuangan`
--
ALTER TABLE `keuangan`
  ADD CONSTRAINT `keuangan_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profil_website`
--
ALTER TABLE `profil_website`
  ADD CONSTRAINT `profil_website_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `profil_website_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
