-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05 Jan 2019 pada 08.01
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
-- Struktur dari tabel `item_pengurangan`
--

CREATE TABLE `item_pengurangan` (
  `id` int(11) NOT NULL,
  `no_nota` varchar(15) NOT NULL,
  `item_pengurangan` varchar(50) NOT NULL,
  `qty` decimal(10,0) NOT NULL COMMENT 'jumlah karung',
  `harga_satuan` decimal(12,0) NOT NULL COMMENT 'harga per kg',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `item_pengurangan`
--

INSERT INTO `item_pengurangan` (`id`, `no_nota`, `item_pengurangan`, `qty`, `harga_satuan`, `created_at`) VALUES
(5, '12311218001', 'tes 1', '1', '40000', '2018-12-31 15:47:21'),
(6, '12311218001', 'tes 1', '2', '40000', '2018-12-31 15:48:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_pengurangan`
--
ALTER TABLE `item_pengurangan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_pengurangan`
--
ALTER TABLE `item_pengurangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
