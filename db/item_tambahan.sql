-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05 Jan 2019 pada 08.02
-- Versi Server: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mustika_dewi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_tambahan`
--

CREATE TABLE `item_tambahan` (
  `id` int(11) NOT NULL,
  `no_nota` varchar(15) NOT NULL,
  `item_tambahan` varchar(50) NOT NULL,
  `qty` decimal(10,0) NOT NULL COMMENT 'jumlah karung',
  `harga_satuan` decimal(12,0) NOT NULL COMMENT 'harga per kg',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `item_tambahan`
--

INSERT INTO `item_tambahan` (`id`, `no_nota`, `item_tambahan`, `qty`, `harga_satuan`, `created_at`) VALUES
(2, '12261018001', 'bau bon tanggal 24/10/18', '1', '300000', '2018-10-26 08:11:35'),
(3, '12261018003', 'hendra bon 24/10/18', '1', '700000', '2018-10-26 10:14:39'),
(4, '12261018003', 'bau bon 24/10', '1', '300000', '2018-10-26 10:14:39'),
(5, '12261018004', 'HENDRA BON', '1', '1900000', '2018-10-26 10:58:52'),
(6, '12271018001', 'bon uang tanggal 26/10/18', '1', '1000000', '2018-10-27 11:02:22'),
(7, '12301018001', 'BAU BON 27/10/18', '1', '500000', '2018-10-30 07:37:18'),
(8, '12301018001', 'KARUNG 23/10/18', '1', '500000', '2018-10-30 07:37:18'),
(9, '12301018003', 'KARUNG', '1', '630000', '2018-10-30 11:49:02'),
(10, '12311018001', 'KARUNG', '1', '150000', '2018-10-31 11:46:52'),
(12, '12011118007', 'HENDRA BON', '1', '1900000', '2018-11-01 14:03:26'),
(13, '12021118009', 'SETOR BON', '1', '2000000', '2018-11-02 09:28:51'),
(15, '12021118012', 'KOREKSI HARGA 5X50X100', '1', '25000', '2018-11-02 10:35:35'),
(16, '12031118001', 'SISA BON', '1', '236387000', '2018-11-03 06:39:35'),
(19, '12031118006', 'SISA BON', '1', '23500000', '2018-11-03 07:24:38'),
(20, '12031118030', '10 PLASTIK', '1', '10000', '2018-11-03 12:59:12'),
(21, '12061118035', 'ONGKIR', '1', '200000', '2018-11-06 12:08:54'),
(22, '12071118009', 'ONGKIR', '1', '40000', '2018-11-07 07:05:32'),
(23, '12071118020', 'KARUNG', '1', '655000', '2018-11-07 09:27:55'),
(24, '12071118023', 'ONGKIR', '1', '80000', '2018-11-07 09:34:32'),
(25, '12081118030', 'BAU BON', '1', '1000000', '2018-11-08 12:39:06'),
(26, '12091118007', 'TUNAI', '1', '200000', '2018-11-09 07:04:20'),
(27, '12091118015', 'KARUNG', '1', '180000', '2018-11-09 09:01:50'),
(28, '12091118015', 'BAU BON 7/11/18', '1', '500000', '2018-11-09 09:01:50'),
(29, '12101118041', 'KARUNG', '1', '225000', '2018-11-10 11:06:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_tambahan`
--
ALTER TABLE `item_tambahan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_tambahan`
--
ALTER TABLE `item_tambahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
