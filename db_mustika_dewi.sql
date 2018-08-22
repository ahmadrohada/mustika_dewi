-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22 Agu 2018 pada 05.26
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
-- Struktur dari tabel `bayar_hutang`
--

CREATE TABLE `bayar_hutang` (
  `id` int(11) NOT NULL,
  `nota_id` int(11) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `jumlah_bayar` decimal(12,0) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayar_piutang`
--

CREATE TABLE `bayar_piutang` (
  `id` int(11) NOT NULL,
  `nota_id` int(11) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `jumlah_bayar` decimal(12,0) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga_beras`
--

CREATE TABLE `harga_beras` (
  `id` int(11) NOT NULL,
  `jenis_beras_id` int(11) NOT NULL,
  `harga_jual` decimal(12,0) NOT NULL,
  `harga_beli` decimal(12,0) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_transaksi`
--

CREATE TABLE `item_transaksi` (
  `id` int(11) NOT NULL,
  `no_nota` varchar(15) NOT NULL,
  `jenis_transaksi` enum('pembelian','penjualan') NOT NULL,
  `jenis_beras_id` int(11) NOT NULL,
  `pembelian_id` int(11) NOT NULL,
  `nama_karung` varchar(20) NOT NULL,
  `qty` decimal(10,0) NOT NULL COMMENT 'jumlah karung',
  `tonase` decimal(10,1) NOT NULL COMMENT 'tonase per karung',
  `harga` decimal(12,0) NOT NULL COMMENT 'harga per kg',
  `upah_kuli` decimal(12,0) NOT NULL COMMENT 'rupiah kali tonasee',
  `komisi` decimal(10,0) NOT NULL COMMENT 'pengurangan terhadap harga ',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_beras`
--

CREATE TABLE `jenis_beras` (
  `id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_beras`
--

INSERT INTO `jenis_beras` (`id`, `label`, `keterangan`) VALUES
(8, 'IR42', ''),
(9, 'IR64', ''),
(10, 'Pandan Wangi', ''),
(11, 'Ketan', ''),
(12, 'Ketan Item', ''),
(13, 'Beras Merah', ''),
(14, 'Muncul', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_tlp` varchar(15) NOT NULL,
  `info_lain` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `alamat`, `no_tlp`, `info_lain`) VALUES
(1, 'Cash', 'Karawang', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int(11) NOT NULL,
  `no_nota` varchar(12) NOT NULL,
  `tgl_nota` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_harga` decimal(12,0) NOT NULL,
  `total_upah_kuli` decimal(12,0) NOT NULL,
  `type_bayar` enum('1','2') NOT NULL COMMENT '1:cash, 2:hutang',
  `jumlah_dp` decimal(12,0) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `no_nota` varchar(12) NOT NULL,
  `tgl_nota` datetime NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_belanja` decimal(12,0) NOT NULL,
  `total_komisi` decimal(12,0) NOT NULL,
  `total_tambahan` decimal(12,0) NOT NULL,
  `bayar` decimal(12,0) NOT NULL,
  `type_bayar` enum('1','2') NOT NULL COMMENT '1:cash, 2:hutang',
  `jatuh_tempo` date NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_tlp` varchar(15) NOT NULL,
  `info_lain` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `no_tlp`, `info_lain`) VALUES
(1, 'Cash', 'Karawang', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_tambahan`
--

CREATE TABLE `tmp_tambahan` (
  `id` int(11) NOT NULL,
  `no_nota` varchar(15) NOT NULL,
  `item_tambahan` varchar(50) NOT NULL,
  `qty` decimal(10,0) NOT NULL COMMENT 'jumlah karung',
  `harga_satuan` decimal(12,0) NOT NULL COMMENT 'harga per kg',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_transaksi`
--

CREATE TABLE `tmp_transaksi` (
  `id` int(11) NOT NULL,
  `no_nota` varchar(15) NOT NULL,
  `jenis_transaksi` enum('pembelian','penjualan') NOT NULL,
  `jenis_beras_id` int(11) NOT NULL,
  `pembelian_id` int(11) NOT NULL COMMENT 'yaitu menunjukan id terhadap item beras pembelian',
  `nama_karung` varchar(20) NOT NULL,
  `qty` decimal(10,0) NOT NULL COMMENT 'jumlah karung',
  `tonase` decimal(10,1) NOT NULL COMMENT 'tonase per karung',
  `harga` decimal(12,0) NOT NULL COMMENT 'harga per kg',
  `upah_kuli` decimal(12,0) NOT NULL COMMENT 'rupiah kali tonasee',
  `komisi` decimal(10,0) NOT NULL COMMENT 'pengurangan terhadap harga ',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('admin','pegawai') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'pegawai', 'pegawai', '047aeeb234644b9e2d4138ed3bc7976a', 'pegawai', '1', NULL, NULL),
(2, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '1', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bayar_hutang`
--
ALTER TABLE `bayar_hutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bayar_piutang`
--
ALTER TABLE `bayar_piutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harga_beras`
--
ALTER TABLE `harga_beras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_tambahan`
--
ALTER TABLE `item_tambahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_transaksi`
--
ALTER TABLE `item_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_beras`
--
ALTER TABLE `jenis_beras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `tmp_tambahan`
--
ALTER TABLE `tmp_tambahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_transaksi`
--
ALTER TABLE `tmp_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nip` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bayar_hutang`
--
ALTER TABLE `bayar_hutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bayar_piutang`
--
ALTER TABLE `bayar_piutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `harga_beras`
--
ALTER TABLE `harga_beras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_tambahan`
--
ALTER TABLE `item_tambahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_transaksi`
--
ALTER TABLE `item_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jenis_beras`
--
ALTER TABLE `jenis_beras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tmp_tambahan`
--
ALTER TABLE `tmp_tambahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tmp_transaksi`
--
ALTER TABLE `tmp_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
