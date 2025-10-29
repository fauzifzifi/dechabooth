-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2025 at 03:02 AM
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
-- Database: `decha_booth`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi_beli`
--

CREATE TABLE `detail_transaksi_beli` (
  `id_detail_transaksi_beli` char(10) NOT NULL,
  `metode_transaksi_beli` varchar(25) DEFAULT NULL,
  `id_transaksi_beli` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi_beli`
--

INSERT INTO `detail_transaksi_beli` (`id_detail_transaksi_beli`, `metode_transaksi_beli`, `id_transaksi_beli`) VALUES
('1111', 'Tunai', 'TB01'),
('1112', 'Tunai', 'TB02'),
('1113', 'Tunai', 'TB03'),
('1114', 'Tunai', 'TB04'),
('1115', 'Tunai', 'TB05');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi_jual`
--

CREATE TABLE `detail_transaksi_jual` (
  `id_detail_transaksi_jual` char(10) NOT NULL,
  `metode_transaksi_jual` varchar(25) DEFAULT NULL,
  `id_transaksi_jual` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi_jual`
--

INSERT INTO `detail_transaksi_jual` (`id_detail_transaksi_jual`, `metode_transaksi_jual`, `id_transaksi_jual`) VALUES
('1111', 'Tunai', 'TJ01'),
('1112', 'Tunai', 'TJ02'),
('1113', 'Tunai', 'TJ03'),
('1114', 'Tunai', 'TJ04'),
('1115', 'Tunai', 'TJ05');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang_beli`
--

CREATE TABLE `jenis_barang_beli` (
  `jenis_barang` varchar(25) DEFAULT NULL,
  `id_detail_transaksi_beli` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_barang_beli`
--

INSERT INTO `jenis_barang_beli` (`jenis_barang`, `id_detail_transaksi_beli`) VALUES
('Konsumsi', '1111'),
('Konsumsi', '1112'),
('Konsumsi', '1113'),
('Konsumsi', '1114'),
('Konsumsi', '1115');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang_jual`
--

CREATE TABLE `jenis_barang_jual` (
  `jenis_barang` varchar(25) DEFAULT NULL,
  `id_detail_transaksi_jual` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_barang_jual`
--

INSERT INTO `jenis_barang_jual` (`jenis_barang`, `id_detail_transaksi_jual`) VALUES
('Konsumsi', '1111'),
('Konsumsi', '1112'),
('Konsumsi', '1113'),
('Konsumsi', '1114'),
('Konsumsi', '1115');

-- --------------------------------------------------------

--
-- Table structure for table `jumlah_transaksi_beli`
--

CREATE TABLE `jumlah_transaksi_beli` (
  `jumlah` varchar(25) DEFAULT NULL,
  `id_detail_transaksi_beli` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jumlah_transaksi_beli`
--

INSERT INTO `jumlah_transaksi_beli` (`jumlah`, `id_detail_transaksi_beli`) VALUES
('10', '1111'),
('15', '1112'),
('8', '1113'),
('12', '1114'),
('20', '1115'),
('10', '1111'),
('15', '1112'),
('8', '1113'),
('12', '1114'),
('20', '1115');

-- --------------------------------------------------------

--
-- Table structure for table `jumlah_transaksi_jual`
--

CREATE TABLE `jumlah_transaksi_jual` (
  `jumlah` varchar(25) DEFAULT NULL,
  `id_detail_transaksi_jual` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jumlah_transaksi_jual`
--

INSERT INTO `jumlah_transaksi_jual` (`jumlah`, `id_detail_transaksi_jual`) VALUES
('7', '1111'),
('10', '1112'),
('5', '1113'),
('8', '1114'),
('12', '1115'),
('7', '1111'),
('10', '1112'),
('5', '1113'),
('8', '1114'),
('12', '1115'),
('7', '1111'),
('10', '1112'),
('5', '1113'),
('8', '1114'),
('12', '1115'),
('7', '1111'),
('10', '1112'),
('5', '1113'),
('8', '1114'),
('12', '1115');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` char(10) NOT NULL,
  `nama_menu` varchar(50) DEFAULT NULL,
  `harga` varchar(25) DEFAULT NULL,
  `kategori` varchar(25) DEFAULT NULL,
  `id_detail_transaksi_beli` char(10) NOT NULL,
  `id_detail_transaksi_jual` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `kategori`, `id_detail_transaksi_beli`, `id_detail_transaksi_jual`) VALUES
('111', 'Mie Jebew', '5000', 'Makanan', '1111', '1111'),
('112', 'Basreng Chilli Oil', '5000', 'Snack', '1112', '1112'),
('113', 'Otak-Otak Chilli Oil', '5000', 'Makanan', '1113', '1113'),
('114', 'Bakso Sapi Goreng', '5000', 'Makanan', '1114', '1114'),
('115', 'Mie Instan', '7000', 'Makanan', '1115', '1115');

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `id_pembeli` char(10) NOT NULL,
  `nama_pembeli` varchar(70) DEFAULT NULL,
  `alamat_pembeli` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`id_pembeli`, `nama_pembeli`, `alamat_pembeli`) VALUES
('11', 'Rizky', 'Jl. Sudirman No.10, Bojonegoro'),
('12', 'Fauzi', 'Jl. Werungotok V, Nganjuk'),
('13', 'Shofi', 'Jl. Diponegoro No.22,  Bojonegoro'),
('14', 'Afif', 'Jl. Jintel No.5, Rejoso'),
('15', 'Uaryl', 'Jl. Ngujung No.48, Gondang'),
('16', 'Deva', 'Jl. Pandan No.20, Nganjuk');

-- --------------------------------------------------------

--
-- Table structure for table `penjual`
--

CREATE TABLE `penjual` (
  `id_penjual` char(10) NOT NULL,
  `nama_penjual` varchar(70) DEFAULT NULL,
  `alamat_penjual` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjual`
--

INSERT INTO `penjual` (`id_penjual`, `nama_penjual`, `alamat_penjual`) VALUES
('21', 'Decha', 'Rejoso');

-- --------------------------------------------------------

--
-- Table structure for table `stok_menu`
--

CREATE TABLE `stok_menu` (
  `stok` varchar(25) DEFAULT NULL,
  `id_menu` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_menu`
--

INSERT INTO `stok_menu` (`stok`, `id_menu`) VALUES
('25', '111'),
('35', '112'),
('30', '113'),
('20', '114'),
('20', '115');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` char(10) NOT NULL,
  `nama_supplier` varchar(70) DEFAULT NULL,
  `alamat_supplier` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat_supplier`) VALUES
('1', 'PT Jaya Sentosa', 'J1. Sudirman No.10, Nganjuk'),
('2', 'PT Sumber Rezeki', 'J1. Merdeka No.15, Nganjuk'),
('3', 'UD Makmur Sentosa', 'J1. Diponegoro No.22, Nganjuk'),
('4', 'CV Berkah Abadi', 'Jl. Raya Baron No.5, Nganjuk'),
('5', 'PT Mitra Usaha', 'J1. Gatot Subroto No.8, Nganjuk');

-- --------------------------------------------------------

--
-- Table structure for table `telp_pembeli`
--

CREATE TABLE `telp_pembeli` (
  `no_telp` int(11) DEFAULT NULL,
  `id_pembeli` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `telp_pembeli`
--

INSERT INTO `telp_pembeli` (`no_telp`, `id_pembeli`) VALUES
(812345671, '11'),
(812345672, '12'),
(812345673, '13'),
(812345674, '14'),
(812345675, '15'),
(812345676, '16'),
(897662772, '11');

-- --------------------------------------------------------

--
-- Table structure for table `telp_penjual`
--

CREATE TABLE `telp_penjual` (
  `no_penjual` varchar(11) DEFAULT NULL,
  `id_penjual` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `telp_penjual`
--

INSERT INTO `telp_penjual` (`no_penjual`, `id_penjual`) VALUES
('82336881878', '21');

-- --------------------------------------------------------

--
-- Table structure for table `telp_supplier`
--

CREATE TABLE `telp_supplier` (
  `no_telp` int(11) DEFAULT NULL,
  `id_supplier` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `telp_supplier`
--

INSERT INTO `telp_supplier` (`no_telp`, `id_supplier`) VALUES
(876543211, '1'),
(87654322, '2'),
(87654323, '3'),
(87654324, '4'),
(87654325, '5');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_beli`
--

CREATE TABLE `transaksi_beli` (
  `id_transaksi_beli` char(10) NOT NULL,
  `tgl_transaksi_beli` date DEFAULT NULL,
  `id_supplier` char(10) NOT NULL,
  `id_penjual` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_beli`
--

INSERT INTO `transaksi_beli` (`id_transaksi_beli`, `tgl_transaksi_beli`, `id_supplier`, `id_penjual`) VALUES
('TB01', '2025-10-21', '1', '21'),
('TB02', '2025-10-21', '2', '21'),
('TB03', '2025-10-21', '3', '21'),
('TB04', '2025-10-21', '4', '21'),
('TB05', '2025-10-21', '5', '21');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_jual`
--

CREATE TABLE `transaksi_jual` (
  `id_transaksi_jual` char(10) NOT NULL,
  `tgl_transaksi_jual` date DEFAULT NULL,
  `id_pembeli` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_jual`
--

INSERT INTO `transaksi_jual` (`id_transaksi_jual`, `tgl_transaksi_jual`, `id_pembeli`) VALUES
('TJ01', '2025-10-21', '11'),
('TJ02', '2025-10-21', '12'),
('TJ03', '2025-10-21', '13'),
('TJ04', '2025-10-21', '14'),
('TJ05', '2025-10-21', '15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi_beli`
--
ALTER TABLE `detail_transaksi_beli`
  ADD PRIMARY KEY (`id_detail_transaksi_beli`),
  ADD KEY `fk_id_transaksi_beli` (`id_transaksi_beli`);

--
-- Indexes for table `detail_transaksi_jual`
--
ALTER TABLE `detail_transaksi_jual`
  ADD PRIMARY KEY (`id_detail_transaksi_jual`),
  ADD KEY `fk_id_transaksi_jual` (`id_transaksi_jual`);

--
-- Indexes for table `jenis_barang_beli`
--
ALTER TABLE `jenis_barang_beli`
  ADD KEY `fk_id_detail_transaksi_beli` (`id_detail_transaksi_beli`);

--
-- Indexes for table `jenis_barang_jual`
--
ALTER TABLE `jenis_barang_jual`
  ADD KEY `fk_id_detail_transaksi_jual2` (`id_detail_transaksi_jual`);

--
-- Indexes for table `jumlah_transaksi_beli`
--
ALTER TABLE `jumlah_transaksi_beli`
  ADD KEY `fk_id_detail_transaksi_beli2` (`id_detail_transaksi_beli`);

--
-- Indexes for table `jumlah_transaksi_jual`
--
ALTER TABLE `jumlah_transaksi_jual`
  ADD KEY `fk_id_detail_transaksi_jual3` (`id_detail_transaksi_jual`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `fk_id_detail_transaksi_beli3` (`id_detail_transaksi_beli`),
  ADD KEY `fk_id_detail_transaksi_jual` (`id_detail_transaksi_jual`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`id_pembeli`);

--
-- Indexes for table `penjual`
--
ALTER TABLE `penjual`
  ADD PRIMARY KEY (`id_penjual`);

--
-- Indexes for table `stok_menu`
--
ALTER TABLE `stok_menu`
  ADD KEY `fk_id_menu` (`id_menu`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `telp_penjual`
--
ALTER TABLE `telp_penjual`
  ADD KEY `fk_id_penjual2` (`id_penjual`);

--
-- Indexes for table `telp_supplier`
--
ALTER TABLE `telp_supplier`
  ADD KEY `fk_id_supplier` (`id_supplier`);

--
-- Indexes for table `transaksi_beli`
--
ALTER TABLE `transaksi_beli`
  ADD PRIMARY KEY (`id_transaksi_beli`),
  ADD KEY `fk_id_supplier2` (`id_supplier`),
  ADD KEY `fk_id_penjual` (`id_penjual`);

--
-- Indexes for table `transaksi_jual`
--
ALTER TABLE `transaksi_jual`
  ADD PRIMARY KEY (`id_transaksi_jual`),
  ADD UNIQUE KEY `id_pembeli` (`id_pembeli`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi_beli`
--
ALTER TABLE `detail_transaksi_beli`
  ADD CONSTRAINT `fk_id_transaksi_beli` FOREIGN KEY (`id_transaksi_beli`) REFERENCES `transaksi_beli` (`id_transaksi_beli`);

--
-- Constraints for table `detail_transaksi_jual`
--
ALTER TABLE `detail_transaksi_jual`
  ADD CONSTRAINT `fk_id_transaksi_jual` FOREIGN KEY (`id_transaksi_jual`) REFERENCES `transaksi_jual` (`id_transaksi_jual`);

--
-- Constraints for table `jenis_barang_beli`
--
ALTER TABLE `jenis_barang_beli`
  ADD CONSTRAINT `fk_id_detail_transaksi_beli` FOREIGN KEY (`id_detail_transaksi_beli`) REFERENCES `detail_transaksi_beli` (`id_detail_transaksi_beli`);

--
-- Constraints for table `jenis_barang_jual`
--
ALTER TABLE `jenis_barang_jual`
  ADD CONSTRAINT `fk_id_detail_transaksi_jual2` FOREIGN KEY (`id_detail_transaksi_jual`) REFERENCES `detail_transaksi_jual` (`id_detail_transaksi_jual`);

--
-- Constraints for table `jumlah_transaksi_beli`
--
ALTER TABLE `jumlah_transaksi_beli`
  ADD CONSTRAINT `fk_id_detail_transaksi_beli2` FOREIGN KEY (`id_detail_transaksi_beli`) REFERENCES `detail_transaksi_beli` (`id_detail_transaksi_beli`);

--
-- Constraints for table `jumlah_transaksi_jual`
--
ALTER TABLE `jumlah_transaksi_jual`
  ADD CONSTRAINT `fk_id_detail_transaksi_jual3` FOREIGN KEY (`id_detail_transaksi_jual`) REFERENCES `detail_transaksi_jual` (`id_detail_transaksi_jual`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_id_detail_transaksi_beli3` FOREIGN KEY (`id_detail_transaksi_beli`) REFERENCES `detail_transaksi_beli` (`id_detail_transaksi_beli`),
  ADD CONSTRAINT `fk_id_detail_transaksi_jual` FOREIGN KEY (`id_detail_transaksi_jual`) REFERENCES `detail_transaksi_jual` (`id_detail_transaksi_jual`);

--
-- Constraints for table `stok_menu`
--
ALTER TABLE `stok_menu`
  ADD CONSTRAINT `fk_id_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Constraints for table `telp_pembeli`
--
ALTER TABLE `telp_pembeli`
  ADD CONSTRAINT `fk_id_pembeli` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`id_pembeli`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `telp_penjual`
--
ALTER TABLE `telp_penjual`
  ADD CONSTRAINT `fk_id_penjual2` FOREIGN KEY (`id_penjual`) REFERENCES `penjual` (`id_penjual`);

--
-- Constraints for table `telp_supplier`
--
ALTER TABLE `telp_supplier`
  ADD CONSTRAINT `fk_id_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`);

--
-- Constraints for table `transaksi_beli`
--
ALTER TABLE `transaksi_beli`
  ADD CONSTRAINT `fk_id_penjual` FOREIGN KEY (`id_penjual`) REFERENCES `penjual` (`id_penjual`),
  ADD CONSTRAINT `fk_id_supplier2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`);

--
-- Constraints for table `transaksi_jual`
--
ALTER TABLE `transaksi_jual`
  ADD CONSTRAINT `fk_id_pembeli2` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`id_pembeli`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
