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
-- Struktur dari tabel `retur_pembelian`
--

CREATE TABLE `retur_pembelian` (
  `id` int(11) NOT NULL,
  `no_nota` varchar(20) NOT NULL,
  `total_retur` decimal(12,0) NOT NULL,
  `user_id` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `retur_pembelian`
--

INSERT INTO `retur_pembelian` (`id`, `no_nota`, `total_retur`, `user_id`, `keterangan`, `created_at`) VALUES
(3, '11251218004', '1515750', 1, '', '2019-01-05 00:00:00'),
(4, '11311218001', '1185000', 1, 'tes ajah', '2019-01-05 13:39:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `retur_pembelian`
--
ALTER TABLE `retur_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `retur_pembelian`
--
ALTER TABLE `retur_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
