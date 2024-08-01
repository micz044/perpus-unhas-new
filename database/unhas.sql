-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2024 at 07:54 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unhas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(6, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pending_users`
--

CREATE TABLE `pending_users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(52) NOT NULL,
  `nip` varchar(60) NOT NULL,
  `jabatan` varchar(44) NOT NULL,
  `email` varchar(69) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id` int(11) NOT NULL,
  `nama` varchar(59) NOT NULL,
  `nidn` varchar(60) NOT NULL,
  `nip` varchar(44) NOT NULL,
  `department` varchar(69) NOT NULL,
  `status` varchar(55) NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `riwayat`
--

INSERT INTO `riwayat` (`id`, `nama`, `nidn`, `nip`, `department`, `status`, `deleted_at`) VALUES
(5, 'rarararar', '1241414', '141414', 'dadad', 'Aktif', '2024-07-29 17:14:05'),
(6, 'afafafafa', '41241414', '441242', 'dasdada', 'Non-Aktif', '2024-07-29 17:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_penghapusan`
--

CREATE TABLE `riwayat_penghapusan` (
  `id` int(11) NOT NULL,
  `nama_dosen` varchar(59) NOT NULL,
  `nidn` varchar(60) NOT NULL,
  `nip` varchar(44) NOT NULL,
  `department` varchar(90) NOT NULL,
  `status` varchar(55) NOT NULL,
  `tgl_penghapusan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabelll`
--

CREATE TABLE `tabelll` (
  `id` int(11) NOT NULL,
  `nama` varchar(66) NOT NULL,
  `nidn` varchar(60) NOT NULL,
  `nip` varchar(44) NOT NULL,
  `department` varchar(69) NOT NULL,
  `status` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabelll`
--

INSERT INTO `tabelll` (`id`, `nama`, `nidn`, `nip`, `department`, `status`) VALUES
(1, 'Dr. Asri Usman, SE.,M.Si.Ak.', '0018106501', '196510181994121001', 'AKUNTANSI', 'Aktif'),
(2, 'Dr. Syamsuddin, SE.Ak.,M.Si.', '0014046701', '196704141994121001', 'AKUNTANSI', 'Aktif'),
(3, 'Nadhirah Nagu, SE.,M.Si.Akt.', '0006027409', '197402062008122001', 'AKUNTANSI', 'Aktif'),
(4, 'Rahmawati HS., SE.Ak.,M.Si', '0005117605', '197611052007012001', 'AKUNTANSI', 'Aktif'),
(5, 'Muhammad Irdam Ferdiansah, SE.,M.Acc.', '0024028105', '198102242010121002', 'AKUNTANSI', 'Aktif'),
(6, 'Drs. Yulianus Sampe, M.Si.Ak.', '0022075601', '195607221987021001', 'AKUNTANSI', 'Aktif'),
(7, 'Dr. Darmawati, SE.Ak.,M.Si.', '0018056702', '196705181998022001', 'AKUNTANSI', 'Aktif'),
(8, 'Afdal, S.E., M.Sc.,Ak.', '0909018801', '198801092015041001', 'AKUNTANSI', 'Aktif'),
(32, 'Dr. Alimuddin, MM.,Ak.', '0008125902', '195912081986011003', 'AKUNTANSI', 'Aktif'),
(34, 'jqwrjqrjqrqj', '42141414', '42342424242', 'dadad', 'Non-Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tabell_admin`
--

CREATE TABLE `tabell_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(59) NOT NULL,
  `nidn` varchar(60) NOT NULL,
  `nip` varchar(44) NOT NULL,
  `department` varchar(69) NOT NULL,
  `status` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabell_admin`
--

INSERT INTO `tabell_admin` (`id`, `nama`, `nidn`, `nip`, `department`, `status`) VALUES
(1, 'ay', '1414141', '535353543', '313131', 'aktif'),
(2, 'ayam', '4242423', '8420942948', 'jdajd', 'jdaj'),
(3, 'jafjafjaf', '424240924', 'ja984184', 'ujda', 'kda'),
(4, 'ayam292', '42429840184184', '842904242842', 'idaidaid', 'akdakd'),
(5, 'jdjadjad', '41414', '42424', 'djadj', 'da'),
(6, '41414', 'dasdad', '3131', 'dasd', 'dasd'),
(7, 'uya', '41414141464646', '414141414535363', 'adadj', 'Aktif'),
(8, 'dadadmad', '84914184', '4819481498', 'udauduaid', 'Aktif'),
(10, 'dadadmad', '84914184', '4819481498', 'udauduaid', 'Aktif'),
(11, 'afafafafa', '41241414', '441242', 'dasdada', 'Non-Aktif'),
(12, 'afafafafa', '41241414', '441242', 'dasdada', 'Non-Aktif'),
(13, 'rarararar', '1241414', '141414', 'dadad', 'Aktif'),
(14, 'afafafafa', '41241414', '441242', 'dasdada', 'Non-Aktif'),
(15, 'jqwrjqrjqrqj', '42141414', '42342424242', 'dadad', 'Non-Aktif'),
(16, 'jqwrjqrjqrqj', '42141414', '42342424242', 'dadad', 'Non-Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `table_prodi`
--

CREATE TABLE `table_prodi` (
  `id` int(11) NOT NULL,
  `kode_prodi` varchar(44) NOT NULL,
  `nama_prodi` varchar(60) NOT NULL,
  `strata` varchar(44) NOT NULL,
  `akreditasi` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_prodi`
--

INSERT INTO `table_prodi` (`id`, `kode_prodi`, `nama_prodi`, `strata`, `akreditasi`) VALUES
(1, '63001', 'ADMINISTRASI', 'S3', 'A'),
(2, '11001', 'ILMU KEDOKTERAN', 'S3', 'A'),
(3, '11106', 'ILMU BIOMEDIK', 'S2', 'B'),
(4, '11201', 'KEDOKTERAN', 'S1', 'A'),
(5, '11202', 'FISIOTERAPI', 'S1', 'B'),
(6, '11409', 'KESEHATAN DAERAH TERPENCIL', 'D3', '-'),
(7, '11701', 'ILMU PENYAKIT MATA', 'Sp-1', 'A'),
(8, '11702', 'ILMU PENYAKIT DALAM', 'Sp-1', 'A'),
(9, '11703', 'NEUROLOGI', 'Sp-1', 'A'),
(10, '11704', 'DERMATOLOGI DAN VENEREOLOGI', 'Sp-1', 'A'),
(11, '11704', 'ILMU PENYAKIT KULIT DAN KELAMIN', 'SP-1', 'A'),
(12, '11705', 'ILMU PENYAKIT THT', 'SP-1', 'A'),
(13, '11706', 'ANESTESIOLOGI', 'SP-1', 'A'),
(14, '11707', 'ILMU BEDAH', 'SP-1', 'A'),
(15, '11708', 'ILMU KEBIDANAN DAN PENYAKIT KANDUNGAN', 'SP-1', 'A'),
(16, '11709', 'PULMONOLOGI DAN KEDOKTERAN RESPIRASI', 'SP-1', '-'),
(17, '11710', 'ILMU KEDOKTERAN FORENSIK', 'SP-1', 'B'),
(18, '11711', 'ILMU KESEHATAN ANAK', 'SP-1', 'A'),
(19, '11712', 'ILMU BEDAH ORTHOPAEDI', 'SP-1', 'A'),
(20, '11715', 'ILMU PENYAKIT JANTUNG DAN PEMBULUH DARAH', 'SP-1', 'A'),
(21, '123241414', 'dakdakdakda', 'jdajdajd', 'mamdada'),
(22, '41414141', 'dasdada', 'rwarara', 'fsafafaf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Rinaba', 'Rinaba77');

-- --------------------------------------------------------

--
-- Table structure for table `users_register`
--

CREATE TABLE `users_register` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(59) NOT NULL,
  `nip` int(50) NOT NULL,
  `jabatan` varchar(44) NOT NULL,
  `email` varchar(69) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_register`
--

INSERT INTO `users_register` (`id`, `nama_lengkap`, `nip`, `jabatan`, `email`, `username`, `password`) VALUES
(28, 'kakdakdkadk', 2147483647, 'jdjadjadj', 'idaidiaz22@gmail.com', 'pubg', 'pubg23'),
(29, 'djadadah', 0, 'jdakdhadhjad', 'jdakjdakj@jjjgagmail.com', 'Bebekl', 'Bebekl34'),
(30, 'jdakjdakjdjklad', 2147483647, 'hdhdhdh', 'dkdkjd44@gmail.com', 'Auga', 'Auga55'),
(31, 'dadadadadladal', 46464, 'ml', 'dadjadjadjajd33@gmail.com', 'Gigi', 'Gigi123'),
(32, 'Zohrah Djohan', 2147483647, 'Pustakawan', 'zohradjohan38@gmail.com', 'Rinaba', 'Rinaba77'),
(33, '', 0, '', '', '', ''),
(34, 'jshajkdhajd', 728198129, 'hdhs', 'jadjajdja@gmail.com', 'Adada', 'Adada12'),
(35, 'maman', 2147483647, 'penjoki', 'jdajdjadjadj@gmail.com', 'Iaiaia', 'Iaiaia87'),
(36, 'jdajdjadjadjk', 2147483647, 'jsadjajda', 'idiadiadaid@gmail.com', 'Idiadi', 'Idiadi231'),
(37, 'hhjadadhk', 2147483647, 'dada', 'dadada@gmail.com', 'Llilili', 'Llilili66'),
(38, 'dvdfvdgfdbgd', 2147483647, 'hwshwhwh', 'gggss@gmail.com', 'Bsts', 'Bsts34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_users`
--
ALTER TABLE `pending_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_penghapusan`
--
ALTER TABLE `riwayat_penghapusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabelll`
--
ALTER TABLE `tabelll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabell_admin`
--
ALTER TABLE `tabell_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_prodi`
--
ALTER TABLE `table_prodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_register`
--
ALTER TABLE `users_register`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `riwayat_penghapusan`
--
ALTER TABLE `riwayat_penghapusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabelll`
--
ALTER TABLE `tabelll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tabell_admin`
--
ALTER TABLE `tabell_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `table_prodi`
--
ALTER TABLE `table_prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_register`
--
ALTER TABLE `users_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
