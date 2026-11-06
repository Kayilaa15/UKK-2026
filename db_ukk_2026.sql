-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Nov 2026 pada 08.18
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ukk_2026`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_guru`
--

CREATE TABLE `t_guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_guru`
--

INSERT INTO `t_guru` (`id`, `nip`, `nama`, `email`, `status_aktif`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '197106172021011917', 'Wawan Kurniawan, S.Pd.I', 'wawan.kurniawan@gmail.com', 1, 2, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, '198710182018122246', 'Ai Nuryaidah, S.Pd', 'ai.nuryaidah@gmail.com', 1, 3, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(3, '196810032008101461', 'Maya Permata Endah, S.Pd', 'maya.permata.endah@gmail.com', 1, 4, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(4, '196811162015032258', 'Dody Jaenudin, S.Pd', 'dody.jaenudin@gmail.com', 1, 5, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(5, '197906262017012092', 'Dedi Kardiman, S.Pd', 'dedi.kardiman@gmail.com', 1, 6, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(6, '198509102014121898', 'Uca Musa Yusenda, S.Pd', 'uca.musa.yusenda@gmail.com', 1, 7, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(7, '198812232014012373', 'Drs. Ahmad Nur Mukhlis', 'ahmad.nur.mukhlis@gmail.com', 1, 8, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(8, '198207032017121436', 'Drs. Heri', 'heri@gmail.com', 1, 9, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(9, '198410162017102578', 'Asep Bastaman', 'asep.bastaman@gmail.com', 1, 10, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(10, '198309172005031838', 'H. Encep Maemun, S.T., M.Pd', 'encep.maemun@gmail.com', 1, 11, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(11, '196912172008122146', 'Opik', 'opik@gmail.com', 1, 12, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(12, '198304282008122732', 'Ida Farida, S.Pd', 'ida.farida@gmail.com', 1, 13, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(13, '198505182017102825', 'Idah Mahmudah, S.Pd', 'idah.mahmudah@gmail.com', 1, 14, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(14, '199607142011102010', 'Drs. Muhamad Ali', 'muhamad.ali@gmail.com', 1, 15, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(15, '196903212019122944', 'Helmi Ali Akbar, S.Pd.I', 'helmi.ali.akbar@gmail.com', 1, 16, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(16, '197405232020122828', 'Syeni Suswarini, S.Pd', 'syeni.suswarini@gmail.com', 1, 17, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(17, '198109222006102469', 'Wiwid Yulianti, S.Pd', 'wiwid.yulianti@gmail.com', 1, 18, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(18, '199302152021102945', 'Ansor Muhajir, S.T', 'ansor.muhajir@gmail.com', 1, 19, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(19, '197307272020012925', 'Ogi Gaosun Gias, S.Pd.I', 'ogi.gaosun.gias@gmail.com', 1, 20, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(20, '198306042011121461', 'Sandi Mulyana, S.Pd', 'sandi.mulyana@gmail.com', 1, 21, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(21, '196802012019011254', 'Erna Suryani, S.Pd', 'erna.suryani@gmail.com', 1, 22, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(22, '197110022022102159', 'Ai Wahidah, S.Ag', 'ai.wahidah@gmail.com', 1, 23, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(23, '196806222020031485', 'Chandra Aditya Yusup, S.Pd', 'chandra.aditya.yusup@gmail.com', 1, 24, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(24, '198603202021101428', 'Arif Kusmawan, S.Pd', 'arif.kusmawan@gmail.com', 1, 25, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(25, '198903052014122828', 'Asep Taufiq Hidayat, S.Kom', 'asep.taufiq.hidayat@gmail.com', 1, 26, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(26, '197209262011121982', 'Rendy Ichsan Kusumah, S.T', 'rendy.ichsan.kusumah@gmail.com', 1, 27, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(27, '197107032006102957', 'Feri Rahmawan, S.Pd', 'feri.rahmawan@gmail.com', 1, 28, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(28, '199201012021122700', 'Ari Sandriana, S.Kom', 'ari.sandriana@gmail.com', 1, 29, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(29, '197708112008122586', 'Yaneu Nurdian, S.Pd, M.Pd', 'yaneu.nurdian@gmail.com', 1, 30, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(30, '198703052021032639', 'Ucu Muhammad Khoer N, S.Pd', 'ucu.muhammad.khoer.n@gmail.com', 1, 31, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(31, '197808202012012035', 'Mira Dwi Rahmawati, S.Ag', 'mira.dwi.rahmawati@gmail.com', 1, 32, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(32, '197411062006012889', 'Aldi Maulana, S.Pd', 'aldi.maulana@gmail.com', 1, 33, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(33, '199211072020011662', 'Eli Rosliah, S.Pd', 'eli.rosliah@gmail.com', 1, 34, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(34, '198404262021031678', 'Isni Nur Fitriani, S.Pd', 'isni.nur.fitriani@gmail.com', 1, 35, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(35, '199503132013122889', 'Aanisah Putri Nur Aini, S.Pd', 'aanisah.putri.nur.aini@gmail.com', 1, 36, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(36, '197007102010101270', 'Yusi Luthfiani, S.Sos.I', 'yusi.luthfiani@gmail.com', 1, 37, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(37, '198208252018102182', 'Lilis Rustandy Mawardi, S.Pd., M.Pd', 'lilis.rustandy.mawardi@gmail.com', 1, 38, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(38, '197809162019012836', 'Yusrin Noer Sabrina, S.Pd', 'yusrin.noer.sabrina@gmail.com', 1, 39, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(39, '197104082005012662', 'Senny Indayani, S.Pd', 'senny.indayani@gmail.com', 1, 40, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(40, '197807182010012867', 'Ilma Amalia, S.Pd', 'ilma.amalia@gmail.com', 1, 41, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(41, '197306182022031636', 'Alvira Sofwatunnisa, S.Pd', 'alvira.sofwatunnisa@gmail.com', 1, 42, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(42, '199005182011102687', 'Risna Andriyani, S.Pd', 'risna.andriyani@gmail.com', 1, 43, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(43, '198503042013012176', 'Dra. Tintin Noerhayati', 'tintin.noerhayati@gmail.com', 1, 44, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(44, '197111022016031519', 'Rizkia Fahira, S.Pd', 'rizkia.fahira@gmail.com', 1, 45, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(45, '197805192007102166', 'Frasetio', 'frasetio@gmail.com', 1, 46, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(46, '197605032005122425', 'Ratnaningsih Hatil Aeni, S.Pd.', 'ratnaningsih.hatil.aeni@gmail.com', 1, 47, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(47, '196801042012012126', 'Dheny Darajatul Hasani, S.Pd.', 'dheny.darajatul.hasani@gmail.com', 1, 48, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(48, '197111182016102622', 'Fahrullah, S.Pd', 'fahrullah@gmail.com', 1, 49, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(49, '198811232006122623', 'Aan Andriana, S.T', 'aan.andriana@gmail.com', 1, 50, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(50, '197410152018012882', 'Fitri Fauziah, S.T', 'fitri.fauziah@gmail.com', 1, 51, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(51, '198411092017102060', 'Nida Aulia, S.Pd', 'nida.aulia@gmail.com', 1, 52, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(52, '199112142005102297', 'Sri Nurrizki Putri Krisnadi, S.Pd', 'sri.nurrizki.putri.krisnadi@gmail.com', 1, 53, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(53, '199102102018101556', 'Riesy Putri Navia, S.Kom', 'riesy.putri.navia@gmail.com', 1, 54, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(54, '197804182006011634', 'Rurry Febriani Maryadi, S.Pd', 'rurry.febriani.maryadi@gmail.com', 1, 55, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(55, '197102022009102030', 'Irvan Rizal, S.Pd', 'irvan.rizal@gmail.com', 1, 56, '2026-07-01 01:00:00', '2026-07-01 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tingkat` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kelas`
--

INSERT INTO `t_kelas` (`id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'XII RPL 1', 'XII', 'RPL', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, 'XII RPL 2', 'XII', 'RPL', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas_siswa`
--

CREATE TABLE `t_kelas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kelas_siswa`
--

INSERT INTO `t_kelas_siswa` (`id`, `siswa_id`, `tahun_ajaran_id`, `kelas_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, 2, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(3, 3, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(4, 4, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(5, 5, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(6, 6, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(7, 7, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(8, 8, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(9, 9, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(10, 10, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(11, 11, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(12, 12, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(13, 13, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(14, 14, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(15, 15, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(16, 16, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(17, 17, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(18, 18, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(19, 19, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(20, 20, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(21, 21, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(22, 22, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(23, 23, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(24, 24, 2, 1, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(25, 25, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(26, 26, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(27, 27, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(28, 28, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(29, 29, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(30, 30, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(31, 31, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(32, 32, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(33, 33, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(34, 34, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(35, 35, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(36, 36, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(37, 37, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(38, 38, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(39, 39, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(40, 40, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(41, 41, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(42, 42, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(43, 43, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(44, 44, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(45, 45, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(46, 46, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(47, 47, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(48, 48, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(49, 49, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(50, 50, 2, 2, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran`
--

CREATE TABLE `t_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `kode` varchar(30) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `poin` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran`
--

INSERT INTO `t_pelanggaran` (`id`, `pelanggaran_kategori_id`, `kode`, `nama`, `poin`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'PG-001', 'Meninggalkan kelas tanpa izin', 5, 'Siswa meninggalkan kelas tanpa izin guru.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, 1, 'PG-002', 'Tidak mengerjakan tugas', 3, 'Siswa tidak mengerjakan atau mengumpulkan tugas.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(3, 2, 'PG-003', 'Tidak memakai seragam sesuai ketentuan', 5, 'Seragam tidak sesuai jadwal atau ketentuan sekolah.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(4, 2, 'PG-004', 'Tidak memakai atribut lengkap', 3, 'Topi, dasi, atau badge tidak lengkap.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(5, 2, 'PG-005', 'Rambut tidak sesuai aturan', 5, 'Rambut panjang atau diwarnai.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(6, 3, 'PG-006', 'Terlambat datang ke sekolah', 2, 'Datang setelah bel masuk.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(7, 3, 'PG-007', 'Tidak masuk tanpa keterangan', 10, 'Alpa tanpa surat keterangan.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(8, 4, 'PG-008', 'Membuat gaduh di kelas', 3, 'Mengganggu proses pembelajaran.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(9, 4, 'PG-009', 'Membuang sampah sembarangan', 2, 'Tidak menjaga kebersihan lingkungan.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(10, 5, 'PG-010', 'Tidak sopan kepada guru', 15, 'Bersikap atau berbicara tidak sopan kepada guru.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(11, 6, 'PG-011', 'Membawa rokok atau vape', 30, 'Membawa atau menggunakan rokok/vape di sekolah.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(12, 6, 'PG-012', 'Menggunakan HP saat pembelajaran', 5, 'Memakai HP tanpa izin saat jam pelajaran.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_kategori`
--

CREATE TABLE `t_pelanggaran_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Kedisiplinan', 'Pelanggaran terkait tata tertib dan kedisiplinan', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, 'Kerapian', 'Pelanggaran terkait seragam, rambut, dan atribut', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(3, 'Kehadiran', 'Pelanggaran terkait kehadiran dan keterlambatan', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(4, 'Ketertiban', 'Pelanggaran terkait ketertiban di kelas dan lingkungan sekolah', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(5, 'Sikap', 'Pelanggaran terkait sikap dan tata krama', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(6, 'Barang Terlarang', 'Pelanggaran terkait membawa atau menggunakan barang terlarang', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_siswa`
--

CREATE TABLE `t_pelanggaran_siswa` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `nama_siswa` varchar(150) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `pelanggaran_id` int(11) DEFAULT NULL,
  `nama_pelanggaran` varchar(150) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `nama_guru` varchar(150) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text NOT NULL,
  `poin` int(11) NOT NULL,
  `tindakan` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran_siswa`
--

INSERT INTO `t_pelanggaran_siswa` (`id`, `tahun_ajaran_id`, `siswa_id`, `nama_siswa`, `kelas_id`, `nama_kelas`, `pelanggaran_id`, `nama_pelanggaran`, `pelanggaran_kategori_id`, `guru_id`, `nama_guru`, `tanggal`, `keterangan`, `poin`, `tindakan`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 39, 'Rakha Muhammad Haykal', 2, 'XII RPL 2', 2, 'Tidak mengerjakan tugas', 1, 3, 'Maya Permata Endah, S.Pd', '2026-09-14', 'Pencatatan pelanggaran siswa', 3, 'Teguran lisan', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, 2, 44, 'Sahira Firaj', 2, 'XII RPL 2', 1, 'Meninggalkan kelas tanpa izin', 1, 13, 'Idah Mahmudah, S.Pd', '2026-10-24', 'Pencatatan pelanggaran siswa', 5, 'Pembinaan oleh wali kelas', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(3, 2, 11, 'Kayila Nur Fadilah', 1, 'XII RPL 1', 9, 'Membuang sampah sembarangan', 4, 16, 'Syeni Suswarini, S.Pd', '2026-09-22', 'Pencatatan pelanggaran siswa', 2, 'Teguran lisan', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(4, 2, 46, 'Shahaidan Nizzar', 2, 'XII RPL 2', 11, 'Membawa rokok atau vape', 6, 23, 'Chandra Aditya Yusup, S.Pd', '2026-09-12', 'Pencatatan pelanggaran siswa', 30, 'Pemanggilan orang tua dan skorsing', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(5, 2, 20, 'Raditya Jeti Prasetya', 1, 'XII RPL 1', 6, 'Terlambat datang ke sekolah', 3, 40, 'Ilma Amalia, S.Pd', '2026-09-09', 'Pencatatan pelanggaran siswa', 2, 'Teguran lisan', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(6, 2, 6, 'Azril Akbar Fawji Abdillah', 1, 'XII RPL 1', 8, 'Membuat gaduh di kelas', 4, 22, 'Ai Wahidah, S.Ag', '2026-09-02', 'Pencatatan pelanggaran siswa', 3, 'Teguran lisan', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(7, 2, 37, 'Nazril Ilham', 2, 'XII RPL 2', 11, 'Membawa rokok atau vape', 6, 33, 'Eli Rosliah, S.Pd', '2026-08-01', 'Pencatatan pelanggaran siswa', 30, 'Pemanggilan orang tua dan skorsing', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(8, 2, 27, 'Anisa Amirulla', 2, 'XII RPL 2', 8, 'Membuat gaduh di kelas', 4, 53, 'Riesy Putri Navia, S.Kom', '2026-09-09', 'Pencatatan pelanggaran siswa', 3, 'Teguran lisan', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(9, 2, 34, 'Muhammad Adnan Syaeful Islami', 2, 'XII RPL 2', 8, 'Membuat gaduh di kelas', 4, 14, 'Drs. Muhamad Ali', '2026-09-09', 'Pencatatan pelanggaran siswa', 3, 'Teguran lisan', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(10, 2, 38, 'Puspita Dewi', 2, 'XII RPL 2', 9, 'Membuang sampah sembarangan', 4, 55, 'Irvan Rizal, S.Pd', '2026-10-13', 'Pencatatan pelanggaran siswa', 2, 'Teguran lisan', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(11, 2, 36, 'Nadia Zulfa Soraya', 2, 'XII RPL 2', 5, 'Rambut tidak sesuai aturan', 2, 15, 'Helmi Ali Akbar, S.Pd.I', '2026-10-02', 'Pencatatan pelanggaran siswa', 5, 'Pembinaan oleh wali kelas', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(12, 2, 9, 'Ilma Najya', 1, 'XII RPL 1', 7, 'Tidak masuk tanpa keterangan', 3, 6, 'Uca Musa Yusenda, S.Pd', '2026-10-24', 'Pencatatan pelanggaran siswa', 10, 'Pemanggilan siswa', 'tercatat', '2026-07-01 01:00:00', '2026-07-01 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_siswa`
--

CREATE TABLE `t_siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(10) DEFAULT NULL,
  `nisn` varchar(10) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_siswa`
--

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '102410520', '0051553823', 'Alfin Rahadian', 'L', '2009-10-05', 'Jl. Siliwangi No. 54, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, '102410521', '0029469554', 'Alisa Ramadhani', 'P', '2009-04-25', 'Jl. Rumah Sakit Umum No. 85, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(3, '102410522', '0096269914', 'Alma Aura Livia', 'P', '2008-03-18', 'Jl. Pendidikan No. 85, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(4, '102410523', '0003135594', 'Anis Khoerunnisa Nur Ramadani', 'P', '2009-05-26', 'Jl. HZ Mustofa No. 30, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(5, '102410524', '0035408799', 'Azmil Amira', 'P', '2008-05-18', 'Jl. Cihideung No. 54, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(6, '102410525', '0024065539', 'Azril Akbar Fawji Abdillah', 'L', '2009-03-21', 'Jl. Tamansari No. 12, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(7, '102410527', '0035597600', 'Erlangga Saputra Hidayat', 'L', '2008-11-28', 'Jl. Ir. H. Juanda No. 105, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(8, '102410528', '0088297510', 'Hilma Humma Tunnajah', 'P', '2009-11-17', 'Jl. Siliwangi No. 8, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(9, '102410529', '0029774682', 'Ilma Najya', 'P', '2008-11-08', 'Jl. Cihideung No. 8, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(10, '102410531', '0048309143', 'Julianda Dharma Pangestu', 'L', '2008-12-28', 'Jl. Rumah Sakit Umum No. 91, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(11, '102410532', '0026974998', 'Kayila Nur Fadilah', 'P', '2008-09-27', 'Jl. RE Martadinata No. 44, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(12, '102410533', '0063627612', 'Moza Dina Nabillah', 'P', '2009-06-15', 'Jl. Cihideung No. 71, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(13, '102410534', '0065076364', 'Muhamad Alfarizi', 'L', '2009-04-06', 'Jl. Rumah Sakit Umum No. 20, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(14, '102410535', '0054804706', 'Muhamad Fahrin Adam', 'L', '2008-06-27', 'Jl. Ir. H. Juanda No. 90, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(15, '102410536', '0050035545', 'Muhammad Zidane Maulidan', 'L', '2008-11-06', 'Jl. Sutisna Senjaya No. 39, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(16, '102410537', '0002463223', 'Muhammad Zulfan Nuralfansyah', 'L', '2009-03-23', 'Jl. Sutisna Senjaya No. 116, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(17, '102410538', '0005991890', 'Natiya Nur Azkiya', 'P', '2008-12-19', 'Jl. RE Martadinata No. 74, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(18, '102410539', '0086442492', 'Novita Puspitasari', 'P', '2009-07-18', 'Jl. Ir. H. Juanda No. 104, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(19, '102410540', '0098324676', 'Nucky Andreas Febrian', 'L', '2008-09-04', 'Jl. Sutisna Senjaya No. 19, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(20, '102410743', '0005581926', 'Raditya Jeti Prasetya', 'L', '2009-06-18', 'Jl. RE Martadinata No. 40, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(21, '102410541', '0038329736', 'Rangga Ramadiyanto Nurhakim', 'L', '2008-03-10', 'Jl. RE Martadinata No. 70, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(22, '102410542', '0084532675', 'Risqi Muhamad Ihwani', 'L', '2009-03-13', 'Jl. Dr. Soekardjo No. 96, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(23, '102410753', '0047735624', 'Salwa Sabilatul Barkah', 'P', '2008-10-21', 'Jl. Cihideung No. 55, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(24, '102410543', '0042234585', 'Tazkia Zahra', 'P', '2008-12-17', 'Jl. Pendidikan No. 23, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(25, '102410544', '0089617544', 'Adittia Nur Lantip', 'L', '2008-03-01', 'Jl. Sutisna Senjaya No. 66, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(26, '102410545', '0029016711', 'Agnia Rosya Noerillah', 'P', '2008-06-03', 'Jl. Siliwangi No. 39, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(27, '102410546', '0014263193', 'Anisa Amirulla', 'P', '2008-10-20', 'Jl. Dr. Soekardjo No. 17, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(28, '102410547', '0035241709', 'Aradea Kandi', 'L', '2009-08-04', 'Jl. Sutisna Senjaya No. 49, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(29, '102410548', '0066941011', 'Arfa Diesa Okmaleliza', 'P', '2009-11-04', 'Jl. Siliwangi No. 61, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(30, '102410549', '0048140861', 'Fitri Nur Syiami', 'P', '2008-09-17', 'Jl. Dr. Soekardjo No. 107, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(31, '102410550', '0011793294', 'Junita Putri Nur Rahman', 'P', '2009-10-12', 'Jl. Sutisna Senjaya No. 9, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(32, '102410551', '0043621033', 'Mohammad Atalarik Ali Syahbana', 'L', '2009-05-09', 'Jl. Dr. Soekardjo No. 22, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(33, '102410552', '0097153310', 'Muhamad Fahril Fahrurozi', 'L', '2009-09-18', 'Jl. Siliwangi No. 42, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(34, '102410750', '0062143747', 'Muhammad Adnan Syaeful Islami', 'L', '2009-07-11', 'Jl. HZ Mustofa No. 26, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(35, '102410553', '0079170107', 'Muhammad Zahru Aqila Fikri', 'L', '2008-12-12', 'Jl. Siliwangi No. 53, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(36, '102410554', '0076043714', 'Nadia Zulfa Soraya', 'P', '2009-04-05', 'Jl. Cihideung No. 96, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(37, '102410555', '0015817033', 'Nazril Ilham', 'L', '2008-07-09', 'Jl. Siliwangi No. 107, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(38, '102410556', '0019510197', 'Puspita Dewi', 'P', '2009-05-27', 'Jl. Cihideung No. 34, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(39, '102410558', '0016540483', 'Rakha Muhammad Haykal', 'L', '2009-04-11', 'Jl. HZ Mustofa No. 72, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(40, '102410559', '0053854172', 'Rani Meilani', 'P', '2009-05-19', 'Jl. Cihideung No. 82, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(41, '102410560', '0054983661', 'Reihan Muzaki', 'L', '2009-01-18', 'Jl. Siliwangi No. 87, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(42, '102410561', '0091026737', 'Resa Juliansah', 'L', '2009-02-22', 'Jl. Cihideung No. 117, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(43, '102410562', '0053655345', 'Rizki Permata Sugianto', 'L', '2008-07-12', 'Jl. Siliwangi No. 8, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(44, '102410563', '0033846223', 'Sahira Firaj', 'P', '2008-01-09', 'Jl. Ir. H. Juanda No. 90, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(45, '102410564', '0063879958', 'Sendi Mardian', 'L', '2008-06-19', 'Jl. Tamansari No. 54, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(46, '102410755', '0029510600', 'Shahaidan Nizzar', 'L', '2009-06-01', 'Jl. Pendidikan No. 97, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(47, '102410565', '0002387473', 'Sherly Satriani', 'P', '2008-11-28', 'Jl. RE Martadinata No. 42, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(48, '102410566', '0084579966', 'Sofi Nurjanah', 'P', '2008-08-17', 'Jl. RE Martadinata No. 80, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(49, '102410567', '0001529160', 'Suraiya Salsabila Azzahra', 'P', '2009-02-18', 'Jl. Dr. Soekardjo No. 69, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(50, '102410568', '0027698636', 'Toni Antonio', 'L', '2008-03-11', 'Jl. Dr. Soekardjo No. 60, Tasikmalaya', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '2025/2026', '2025-07-01', '2026-06-30', 0, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, '2026/2027', '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_users`
--

CREATE TABLE `t_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_users`
--

INSERT INTO `t_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(2, 'Wawan Kurniawan, S.Pd.I', 'wawan.kurniawan@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(3, 'Ai Nuryaidah, S.Pd', 'ai.nuryaidah@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(4, 'Maya Permata Endah, S.Pd', 'maya.permata.endah@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(5, 'Dody Jaenudin, S.Pd', 'dody.jaenudin@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(6, 'Dedi Kardiman, S.Pd', 'dedi.kardiman@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(7, 'Uca Musa Yusenda, S.Pd', 'uca.musa.yusenda@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(8, 'Drs. Ahmad Nur Mukhlis', 'ahmad.nur.mukhlis@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(9, 'Drs. Heri', 'heri@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(10, 'Asep Bastaman', 'asep.bastaman@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(11, 'H. Encep Maemun, S.T., M.Pd', 'encep.maemun@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(12, 'Opik', 'opik@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(13, 'Ida Farida, S.Pd', 'ida.farida@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(14, 'Idah Mahmudah, S.Pd', 'idah.mahmudah@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(15, 'Drs. Muhamad Ali', 'muhamad.ali@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(16, 'Helmi Ali Akbar, S.Pd.I', 'helmi.ali.akbar@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(17, 'Syeni Suswarini, S.Pd', 'syeni.suswarini@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(18, 'Wiwid Yulianti, S.Pd', 'wiwid.yulianti@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(19, 'Ansor Muhajir, S.T', 'ansor.muhajir@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(20, 'Ogi Gaosun Gias, S.Pd.I', 'ogi.gaosun.gias@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(21, 'Sandi Mulyana, S.Pd', 'sandi.mulyana@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(22, 'Erna Suryani, S.Pd', 'erna.suryani@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(23, 'Ai Wahidah, S.Ag', 'ai.wahidah@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(24, 'Chandra Aditya Yusup, S.Pd', 'chandra.aditya.yusup@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(25, 'Arif Kusmawan, S.Pd', 'arif.kusmawan@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(26, 'Asep Taufiq Hidayat, S.Kom', 'asep.taufiq.hidayat@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(27, 'Rendy Ichsan Kusumah, S.T', 'rendy.ichsan.kusumah@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(28, 'Feri Rahmawan, S.Pd', 'feri.rahmawan@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(29, 'Ari Sandriana, S.Kom', 'ari.sandriana@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(30, 'Yaneu Nurdian, S.Pd, M.Pd', 'yaneu.nurdian@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(31, 'Ucu Muhammad Khoer N, S.Pd', 'ucu.muhammad.khoer.n@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(32, 'Mira Dwi Rahmawati, S.Ag', 'mira.dwi.rahmawati@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(33, 'Aldi Maulana, S.Pd', 'aldi.maulana@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(34, 'Eli Rosliah, S.Pd', 'eli.rosliah@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(35, 'Isni Nur Fitriani, S.Pd', 'isni.nur.fitriani@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(36, 'Aanisah Putri Nur Aini, S.Pd', 'aanisah.putri.nur.aini@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(37, 'Yusi Luthfiani, S.Sos.I', 'yusi.luthfiani@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(38, 'Lilis Rustandy Mawardi, S.Pd., M.Pd', 'lilis.rustandy.mawardi@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(39, 'Yusrin Noer Sabrina, S.Pd', 'yusrin.noer.sabrina@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(40, 'Senny Indayani, S.Pd', 'senny.indayani@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(41, 'Ilma Amalia, S.Pd', 'ilma.amalia@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(42, 'Alvira Sofwatunnisa, S.Pd', 'alvira.sofwatunnisa@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(43, 'Risna Andriyani, S.Pd', 'risna.andriyani@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(44, 'Dra. Tintin Noerhayati', 'tintin.noerhayati@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(45, 'Rizkia Fahira, S.Pd', 'rizkia.fahira@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(46, 'Frasetio', 'frasetio@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(47, 'Ratnaningsih Hatil Aeni, S.Pd.', 'ratnaningsih.hatil.aeni@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(48, 'Dheny Darajatul Hasani, S.Pd.', 'dheny.darajatul.hasani@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(49, 'Fahrullah, S.Pd', 'fahrullah@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(50, 'Aan Andriana, S.T', 'aan.andriana@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(51, 'Fitri Fauziah, S.T', 'fitri.fauziah@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(52, 'Nida Aulia, S.Pd', 'nida.aulia@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(53, 'Sri Nurrizki Putri Krisnadi, S.Pd', 'sri.nurrizki.putri.krisnadi@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(54, 'Riesy Putri Navia, S.Kom', 'riesy.putri.navia@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(55, 'Rurry Febriani Maryadi, S.Pd', 'rurry.febriani.maryadi@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(56, 'Irvan Rizal, S.Pd', 'irvan.rizal@gmail.com', '2026-07-01 01:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCk0s3ZQmQxK9v7l3M6', '', 'guru', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(57, 'Administrator', 'admin@gmail.com', '2026-11-04 05:34:38', '$2y$10$c.yQVl80pjwZirclK.ZpY.vWwodpJdaOepVeRXNR6lpGp6Y9y6DHy', '', 'admin', '2026-11-04 05:34:38', '2026-11-04 05:34:38'),
(58, 'Guru', 'guru@gmail.com', '2026-11-04 05:34:38', '$2y$10$u.8AmNPu/NkkpR1pZIt7XeSEYIYAlyrxP37XchcPekcHU6bitjyLq', '', 'guru', '2026-11-04 05:34:38', '2026-11-04 05:34:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_wali_kelas`
--

CREATE TABLE `t_wali_kelas` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_wali_kelas`
--

INSERT INTO `t_wali_kelas` (`id`, `tahun_ajaran_id`, `kelas_id`, `guru_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 28, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, 2, 2, 32, '2026-07-01', '2027-06-30', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indeks untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`);

--
-- Indeks untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `pelanggaran_id` (`pelanggaran_id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indeks untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  ADD CONSTRAINT `t_guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `t_users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD CONSTRAINT `t_kelas_siswa_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_3` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD CONSTRAINT `t_pelanggaran_ibfk_1` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`),
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_2` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_4` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_5` FOREIGN KEY (`pelanggaran_id`) REFERENCES `t_pelanggaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_6` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD CONSTRAINT `t_wali_kelas_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_3` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
