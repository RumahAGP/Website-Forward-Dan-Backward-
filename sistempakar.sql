-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Nov 2025 pada 12.37
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistempakar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `diagnosa`
--

CREATE TABLE `diagnosa` (
  `id_diag` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tgl_diag` datetime DEFAULT current_timestamp(),
  `nm_pasien` varchar(100) DEFAULT NULL,
  `nm_penyakit` varchar(100) DEFAULT NULL,
  `gejala_dipilih` text DEFAULT NULL,
  `persentase` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `diagnosa`
--

INSERT INTO `diagnosa` (`id_diag`, `id_user`, `tgl_diag`, `nm_pasien`, `nm_penyakit`, `gejala_dipilih`, `persentase`) VALUES
(1, 2, '2025-11-21 17:24:23', 'Andika', 'Asam Lambung', 'G002, G005', '17%'),
(2, 2, '2025-11-21 17:25:03', 'Andika', 'Diare', 'G010, G022, G024, G031, G055', '100%'),
(3, 2, '2025-11-21 17:26:16', 'Andika', 'Hipertensi', 'G001, G002', '13%'),
(4, 2, '2025-11-21 17:26:42', 'Andika', 'ISPA', 'G004, G010', '20%'),
(5, 3, '2025-11-21 17:33:32', 'Budi Santoso', 'ISPA', 'G004, G010, G050', '100%'),
(6, 4, '2025-11-21 17:33:32', 'Siti Aminah', 'Demam Tifoid', 'G010, G012, G055', '100%'),
(7, 5, '2025-11-20 17:33:32', 'Rudi Hartono', 'DBD', 'G010, G052, G040', '100%'),
(8, 6, '2025-11-20 17:33:32', 'Dewi Persik', 'Diare', 'G012, G031', '100%'),
(9, 7, '2025-11-19 17:33:32', 'Agus Kotak', 'Hipertensi', 'G002, G053, G019', '100%'),
(10, 3, '2025-11-19 17:33:32', 'Budi Santoso', 'ISPA', 'G004, G009', '100%'),
(11, 4, '2025-11-16 17:33:32', 'Siti Aminah', 'Asam Lambung', 'G005, G031', '100%'),
(12, 5, '2025-11-15 17:33:32', 'Rudi Hartono', 'Malaria', 'G010, G042', '100%'),
(13, 6, '2025-11-14 17:33:32', 'Dewi Persik', 'ISPA', 'G050, G056', '100%'),
(14, 7, '2025-11-13 17:33:32', 'Agus Kotak', 'Diabetes', 'G008, G061', '100%'),
(15, 2, '2025-11-21 17:41:28', 'Andika', 'Hipertensi', 'G001,G002,G003', '13%'),
(16, 2, '2025-11-21 17:41:47', 'Andika', 'Asam Lambung', 'G004,G005,G006,G007,G008,G009,G010,G011', '33%'),
(17, 2, '2025-11-21 17:51:12', 'Andika', 'ISPA', 'G002,G003,G004', '10%'),
(18, 2, '2025-11-21 17:59:34', 'Andika', 'Hipertensi', 'G001,G002', '13%'),
(19, 2, '2025-11-21 17:59:43', 'Andika', 'ISPA', 'G009', '10%'),
(20, 2, '2025-11-21 17:59:50', 'Andika', 'Hipertensi', 'G001,G002', '13%'),
(21, 2, '2025-11-21 18:10:38', 'Andika', 'ISPA', 'G002,G003,G004', '10%'),
(22, 2, '2025-11-21 18:28:58', 'Andika', 'Demam Tifoid', 'G003,G005,G016', 'Backward: '),
(23, 2, '2025-11-21 18:29:47', 'Andika', 'DBD', '', 'Backward: '),
(24, 2, '2025-11-21 18:29:55', 'Andika', 'DBD', 'G010,G018', 'Backward: '),
(25, 2, '2025-11-21 18:30:44', 'Andika', 'DBD', 'G010,G018,G038,G063', 'Backward: '),
(26, 2, '2025-11-21 18:36:24', 'Andika', 'DBD', 'G010,G018,G038,G063', 'Backward: '),
(27, 2, '2025-11-21 18:36:50', 'Andika', 'DBD', 'G010,G018,G024,G031', 'Backward: ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `kd_gejala` varchar(10) NOT NULL,
  `nm_gejala` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`kd_gejala`, `nm_gejala`) VALUES
('G001', 'Ada darah dalam urine'),
('G002', 'Aritmia'),
('G003', 'BAB berdarah'),
('G004', 'Batuk'),
('G005', 'Batuk kering'),
('G006', 'Bau mulut'),
('G007', 'Berat badan menurun'),
('G008', 'Bercak-bercak hitam di sekitar leher, ketiak'),
('G009', 'Bersin'),
('G010', 'Demam'),
('G011', 'Detak jantung tidak teratur'),
('G012', 'Diare'),
('G013', 'Dingin di tangan dan kaki'),
('G014', 'Disfungsi ereksi atau impotensi'),
('G015', 'Gatal-gatal di kulit atau timbul prurigo'),
('G016', 'Halusinasi'),
('G017', 'Hidung meler atau tersumbat'),
('G018', 'Hilang nafsu makan'),
('G019', 'Kebingungan'),
('G020', 'Kelelahan dan kelemahan'),
('G021', 'Keringat berlebih'),
('G022', 'Kulit terasa kering'),
('G023', 'Kulit terlihat pucat atau kekuningan'),
('G024', 'Lelah dan lemas'),
('G025', 'Linglung atau mengigau'),
('G026', 'Luka menjadi lebih sulit sembuh'),
('G027', 'Menggigil dan berkeringat'),
('G028', 'Mengi'),
('G029', 'Merasa cemas'),
('G030', 'Mimisan'),
('G031', 'Mual dan/atau muntah'),
('G032', 'Mudah kenyang'),
('G033', 'Infeksi di gusi, kulit, vagina'),
('G034', 'Mulut kering'),
('G035', 'Muntah'),
('G036', 'Napas pendek'),
('G037', 'Nyeri dada'),
('G038', 'Nyeri di bagian belakang mata'),
('G039', 'Nyeri menelan'),
('G040', 'Nyeri otot atau sendi'),
('G041', 'Otot sakit'),
('G042', 'Panas dingin'),
('G043', 'Pembengkakan di perut'),
('G044', 'Pembesaran kelenjar getah bening'),
('G045', 'Penglihatan kabur'),
('G046', 'Penurunan berat badan'),
('G047', 'Penurunan massa otot'),
('G048', 'Perasaan tidak nyaman secara umum'),
('G049', 'Pernapasan cepat'),
('G050', 'Pilek'),
('G051', 'Rasa terbakar, kaku, dan nyeri pada kaki'),
('G052', 'Ruam kemerahan di kulit'),
('G053', 'Sakit kepala dan pusing'),
('G054', 'Sakit mata'),
('G055', 'Sakit perut'),
('G056', 'Sakit tenggorokan'),
('G057', 'Sembelit'),
('G058', 'Sering bersendawa dan suara menjadi serak'),
('G059', 'Sering buang air kecil pada malam hari'),
('G060', 'Sering mengantuk setelah makan'),
('G061', 'Sering merasa haus atau sangat lapar'),
('G062', 'Sesak napas'),
('G063', 'Suhu Badan 39-40 C'),
('G064', 'Sulit berkonsentrasi'),
('G065', 'Telinga berdengung'),
('G066', 'Urine mengandung keton');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_user` int(11) NOT NULL,
  `nm_lengkap` varchar(100) DEFAULT NULL,
  `nm_user` varchar(50) DEFAULT NULL,
  `nm_passwd` varchar(255) DEFAULT NULL,
  `akses` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_user`, `nm_lengkap`, `nm_user`, `nm_passwd`, `akses`) VALUES
(1, 'Administrator', 'admin', 'admin123', 'admin'),
(2, 'Andika', 'Andika', '123', 'user'),
(3, 'Budi Santoso', 'budi', '123', 'user'),
(4, 'Siti Aminah', 'siti', '123', 'user'),
(5, 'Rudi Hartono', 'rudi', '123', 'user'),
(6, 'Dewi Persik', 'dewi', '123', 'user'),
(7, 'Agus Kotak', 'agus', '123', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` varchar(10) NOT NULL,
  `nm_penyakit` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `nm_penyakit`) VALUES
('P01', 'ISPA'),
('P02', 'Demam Tifoid'),
('P03', 'Diare'),
('P04', 'Anemia'),
('P05', 'DBD'),
('P06', 'Hipertensi'),
('P07', 'Malaria'),
('P08', 'Asam Lambung'),
('P09', 'Diabetes'),
('P10', 'Flu Influenza');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rule`
--

CREATE TABLE `rule` (
  `id_rule` int(11) NOT NULL,
  `id_penyakit` varchar(10) DEFAULT NULL,
  `kd_gejala` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rule`
--

INSERT INTO `rule` (`id_rule`, `id_penyakit`, `kd_gejala`) VALUES
(1, 'P01', 'G004'),
(2, 'P01', 'G009'),
(3, 'P01', 'G010'),
(4, 'P01', 'G017'),
(5, 'P01', 'G024'),
(6, 'P01', 'G028'),
(7, 'P01', 'G039'),
(8, 'P01', 'G044'),
(9, 'P01', 'G050'),
(10, 'P01', 'G053'),
(11, 'P02', 'G003'),
(12, 'P02', 'G005'),
(13, 'P02', 'G007'),
(14, 'P02', 'G012'),
(15, 'P02', 'G016'),
(16, 'P02', 'G018'),
(17, 'P02', 'G021'),
(18, 'P02', 'G024'),
(19, 'P02', 'G025'),
(20, 'P02', 'G027'),
(21, 'P02', 'G040'),
(22, 'P02', 'G043'),
(23, 'P02', 'G052'),
(24, 'P02', 'G053'),
(25, 'P02', 'G055'),
(26, 'P02', 'G057'),
(27, 'P02', 'G063'),
(28, 'P02', 'G064'),
(29, 'P03', 'G010'),
(30, 'P03', 'G022'),
(31, 'P03', 'G024'),
(32, 'P03', 'G031'),
(33, 'P03', 'G055'),
(34, 'P04', 'G011'),
(35, 'P04', 'G013'),
(36, 'P04', 'G023'),
(37, 'P04', 'G024'),
(38, 'P04', 'G036'),
(39, 'P04', 'G037'),
(40, 'P04', 'G053'),
(41, 'P04', 'G060'),
(42, 'P05', 'G010'),
(43, 'P05', 'G018'),
(44, 'P05', 'G024'),
(45, 'P05', 'G031'),
(46, 'P05', 'G038'),
(47, 'P05', 'G040'),
(48, 'P05', 'G052'),
(49, 'P05', 'G053'),
(50, 'P05', 'G063'),
(51, 'P06', 'G001'),
(52, 'P06', 'G002'),
(53, 'P06', 'G019'),
(54, 'P06', 'G020'),
(55, 'P06', 'G029'),
(56, 'P06', 'G030'),
(57, 'P06', 'G031'),
(58, 'P06', 'G037'),
(59, 'P06', 'G041'),
(60, 'P06', 'G045'),
(61, 'P06', 'G048'),
(62, 'P06', 'G049'),
(63, 'P06', 'G053'),
(64, 'P06', 'G062'),
(65, 'P06', 'G065'),
(66, 'P07', 'G004'),
(67, 'P07', 'G010'),
(68, 'P07', 'G011'),
(69, 'P07', 'G012'),
(70, 'P07', 'G020'),
(71, 'P07', 'G031'),
(72, 'P07', 'G040'),
(73, 'P07', 'G042'),
(74, 'P07', 'G048'),
(75, 'P07', 'G053'),
(76, 'P07', 'G055'),
(77, 'P07', 'G062'),
(78, 'P08', 'G005'),
(79, 'P08', 'G006'),
(80, 'P08', 'G031'),
(81, 'P08', 'G032'),
(82, 'P08', 'G056'),
(83, 'P08', 'G058'),
(84, 'P09', 'G008'),
(85, 'P09', 'G014'),
(86, 'P09', 'G015'),
(87, 'P09', 'G024'),
(88, 'P09', 'G026'),
(89, 'P09', 'G033'),
(90, 'P09', 'G034'),
(91, 'P09', 'G045'),
(92, 'P09', 'G046'),
(93, 'P09', 'G047'),
(94, 'P09', 'G051'),
(95, 'P09', 'G059'),
(96, 'P09', 'G061'),
(97, 'P09', 'G066'),
(98, 'P10', 'G010'),
(99, 'P10', 'G012'),
(100, 'P10', 'G017'),
(101, 'P10', 'G020'),
(102, 'P10', 'G027'),
(103, 'P10', 'G035'),
(104, 'P10', 'G041'),
(105, 'P10', 'G053'),
(106, 'P10', 'G054'),
(107, 'P10', 'G056'),
(108, 'P10', 'G062');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `diagnosa`
--
ALTER TABLE `diagnosa`
  ADD PRIMARY KEY (`id_diag`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`kd_gejala`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `nm_user` (`nm_user`);

--
-- Indeks untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indeks untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id_rule`),
  ADD KEY `id_penyakit` (`id_penyakit`),
  ADD KEY `kd_gejala` (`kd_gejala`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `diagnosa`
--
ALTER TABLE `diagnosa`
  MODIFY `id_diag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `rule`
--
ALTER TABLE `rule`
  MODIFY `id_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `diagnosa`
--
ALTER TABLE `diagnosa`
  ADD CONSTRAINT `diagnosa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `pengguna` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD CONSTRAINT `rule_ibfk_1` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE,
  ADD CONSTRAINT `rule_ibfk_2` FOREIGN KEY (`kd_gejala`) REFERENCES `gejala` (`kd_gejala`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
