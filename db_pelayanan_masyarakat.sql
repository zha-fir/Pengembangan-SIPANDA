-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Nov 2025 pada 11.41
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
-- Database: `db_pelayanan_masyarakat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_11_15_131913_create_tabel_dusun_table', 1),
(2, '2025_11_15_131914_create_tabel_kk_table', 1),
(3, '2025_11_15_132929_create_tabel_users_table', 1),
(4, '2025_11_15_132929_create_tabel_warga_table', 1),
(5, '2025_11_15_132930_create_tabel_jenis_surat_table', 1),
(6, '2025_11_15_132930_create_tabel_pejabat_desa_table', 1),
(7, '2025_11_15_132931_create_tabel_ajuan_surat_table', 1),
(8, '2025_11_15_132937_create_tabel_pengumuman_table', 1),
(9, '2025_11_15_142809_create_sessions_table', 1),
(10, '2025_11_19_145518_add_data_tambahan_to_tabel_ajuan_surat', 1),
(11, '2025_11_20_082253_add_nip_tgl_lahir_to_pejabat_desa', 1),
(12, '2025_11_20_085210_add_pejabat2_to_ajuan_surat_table', 1),
(13, '2025_11_22_104011_add_id_dusun_to_users_table', 1),
(14, '2025_11_23_085237_add_status_keluarga_to_tabel_warga', 2),
(15, '2025_11_23_092028_make_nama_kepala_nullable_in_kk', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('G3FVbwb9ZyQ14LqRv8Wr1bALwWKLoVppCxL0qneV', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSHRBWkhDMkJPZVFDb0RYdnoyNTZHbmVaUTFJZnlpdG5odmtLcExMVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hanVhbi1zdXJhdCI7czo1OiJyb3V0ZSI7czoxNzoiYWp1YW4tc3VyYXQuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1764498213),
('J40mt5EVuZBErKsJPiO8GqJXm1OZAzrep2q6caWj', 30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXVyNnBLSFZSZTJ2TmNPSGJkT0NSOFdmV0dSQkRqczlSdW5BUFZoVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC93YXJnYS9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6IndhcmdhLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjMwO30=', 1764497957);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_ajuan_surat`
--

CREATE TABLE `tabel_ajuan_surat` (
  `id_ajuan` bigint(20) UNSIGNED NOT NULL,
  `id_warga` bigint(20) UNSIGNED NOT NULL,
  `id_jenis_surat` bigint(20) UNSIGNED DEFAULT NULL,
  `keperluan` text DEFAULT NULL,
  `data_tambahan` text DEFAULT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `id_pejabat_desa` bigint(20) UNSIGNED DEFAULT NULL,
  `id_pejabat_desa_2` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('BARU','SELESAI','DITOLAK') NOT NULL DEFAULT 'BARU',
  `catatan_penolakan` text DEFAULT NULL,
  `tanggal_ajuan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tabel_ajuan_surat`
--

INSERT INTO `tabel_ajuan_surat` (`id_ajuan`, `id_warga`, `id_jenis_surat`, `keperluan`, `data_tambahan`, `nomor_surat`, `id_pejabat_desa`, `id_pejabat_desa_2`, `status`, `catatan_penolakan`, `tanggal_ajuan`) VALUES
(1, 6, 5, 'contoh', '{\"penghasilan\":\"Rp. 1.000.000\"}', 'PDG/XXI/35761395691', 1, 2, 'SELESAI', NULL, '2025-11-29 09:48:41'),
(2, 6, 6, 'yahahaha', NULL, 'PDG/XXI/35761395691976', 2, 4, 'SELESAI', NULL, '2025-11-29 09:51:51'),
(3, 6, 4, 'coba', '{\"bidang_usaha\":\"Pertanian\",\"nama_usaha\":\"Penjualan rempah-rempah\",\"lokasi_usaha\":\"Desa Panggulo\"}', 'PDG/XXI/35761395691764', 4, 1, 'SELESAI', NULL, '2025-11-29 09:53:13'),
(4, 1, NULL, 'apa saja', '{\"penghasilan\":\"Rp. 300.000\"}', 'PDG/XXI/357613956', 1, NULL, 'SELESAI', NULL, '2025-11-30 09:12:01'),
(5, 1, NULL, 'coba', '{\"penghasilan\":\"Rp. 1.000.000\"}', 'PDG/XXI/3576139569', 1, NULL, 'SELESAI', NULL, '2025-11-30 09:27:54'),
(6, 1, NULL, 'p', '{\"penghasilan\":\"Rp. 300.000\"}', 'PDG/XXI/357613956917', 1, NULL, 'SELESAI', NULL, '2025-11-30 09:30:39'),
(7, 1, NULL, 'u', '{\"penghasilan\":\"Rp. 1.000.000\"}', 'PDG/XXI/357613', 1, NULL, 'SELESAI', NULL, '2025-11-30 09:33:44'),
(8, 1, 12, 'pp', '{\"penghasilan\":\"Rp. 1.500.000\"}', 'PDG/XXI/3576139569177', 1, NULL, 'SELESAI', NULL, '2025-11-30 09:36:02'),
(9, 1, 7, 'coba', '{\"nama_pemilik_rumah\":\"asep\"}', 'PDG/XXI/35761395691', 1, 3, 'SELESAI', NULL, '2025-11-30 10:05:08'),
(10, 1, 5, 'mencoba', '{\"penghasilan\":\"Rp. 300.000\"}', NULL, NULL, NULL, 'BARU', NULL, '2025-11-30 10:18:55'),
(11, 1, 4, 'contoh', '{\"bidang_usaha\":\"Pertanian\",\"nama_usaha\":\"Penjualan rempah-rempah\",\"lokasi_usaha\":\"Desa Panggulo\"}', NULL, NULL, NULL, 'BARU', NULL, '2025-11-30 10:19:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_dusun`
--

CREATE TABLE `tabel_dusun` (
  `id_dusun` bigint(20) UNSIGNED NOT NULL,
  `nama_dusun` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tabel_dusun`
--

INSERT INTO `tabel_dusun` (`id_dusun`, `nama_dusun`) VALUES
(1, 'Dusun Mawar'),
(2, 'Dusun Melati'),
(3, 'Dusun Anggrek');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_jenis_surat`
--

CREATE TABLE `tabel_jenis_surat` (
  `id_jenis_surat` bigint(20) UNSIGNED NOT NULL,
  `nama_surat` varchar(150) NOT NULL,
  `kode_surat` varchar(20) DEFAULT NULL,
  `template_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tabel_jenis_surat`
--

INSERT INTO `tabel_jenis_surat` (`id_jenis_surat`, `nama_surat`, `kode_surat`, `template_file`) VALUES
(4, 'Surat Keterangan Usaha', 'SKU', 'SKU_1763983565.docx'),
(5, 'Surat Keterangan Tidak Mampu', 'SKTM', 'SKTM_1763983762.docx'),
(6, 'Surat Keterangan Kelakuan Baik', 'SKKB', 'SKKB_1763983781.docx'),
(7, 'Surat Pernyataan Menumpang', 'SPM', 'SPM_1763985914.docx'),
(12, 'Surat Keterangan Tidak Mampu (Keluarga)', 'SKTM-KEL', 'SKTM-KEL_1764495337.docx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_kk`
--

CREATE TABLE `tabel_kk` (
  `id_kk` bigint(20) UNSIGNED NOT NULL,
  `no_kk` varchar(16) NOT NULL,
  `nama_kepala_keluarga` varchar(100) DEFAULT NULL,
  `alamat_kk` text NOT NULL,
  `rt` varchar(3) DEFAULT NULL,
  `rw` varchar(3) DEFAULT NULL,
  `id_dusun` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tabel_kk`
--

INSERT INTO `tabel_kk` (`id_kk`, `no_kk`, `nama_kepala_keluarga`, `alamat_kk`, `rt`, `rw`, `id_dusun`) VALUES
(1, '7777000011110001', NULL, 'Jl. Mawar Merah No. 10', '1', '1', 1),
(2, '7777000011110002', NULL, 'Jl. Mawar Putih No. 12', '2', '1', 1),
(3, '8888000022220003', NULL, 'Gg. Melati Indah', '1', '2', 2),
(4, '8888000022220004', NULL, 'Jl. Raya Melati', '2', '2', 2),
(5, '9999000033330005', NULL, 'Komp. Anggrek Permai', '1', '3', 3),
(6, '1122334455667788', NULL, 'suwawa', '01', '02', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_pejabat_desa`
--

CREATE TABLE `tabel_pejabat_desa` (
  `id_pejabat_desa` bigint(20) UNSIGNED NOT NULL,
  `nama_pejabat` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tabel_pejabat_desa`
--

INSERT INTO `tabel_pejabat_desa` (`id_pejabat_desa`, `nama_pejabat`, `jabatan`, `nip`, `tanggal_lahir`) VALUES
(1, 'Bpk. Hartono', 'KEPALA DESA', '19750101200001', '1975-01-01'),
(2, 'Bpk. Asep', 'KADUS MAWAR', NULL, '1980-05-20'),
(3, 'Bpk. Joko', 'KADUS MELATI', NULL, '1982-08-17'),
(4, 'Bpk. Dedi', 'KADUS ANGGREK', NULL, '1985-12-12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_pengumuman`
--

CREATE TABLE `tabel_pengumuman` (
  `id_pengumuman` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_pengumuman` text NOT NULL,
  `tanggal_post` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user_admin` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_users`
--

CREATE TABLE `tabel_users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('warga','admin','kades','kadus') NOT NULL,
  `id_dusun` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tabel_users`
--

INSERT INTO `tabel_users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`, `id_dusun`) VALUES
(1, 'admin', '$2y$12$hB2IzNbONVycX8aMHjGOQeF4lPAEvkkwU2ByqPgr2nh1kkP.ixewy', 'Administrator Utama', 'admin', NULL),
(5, '1234567812345678', '$2y$12$jowHMjSLw0P2YwmajJ/a1egwWdMsTmQ.J3dMnJM9HrVSiDm8BGJxC', 'Safira', 'warga', NULL),
(7, '1234567887654321', '$2y$12$RpteM.Lmf.4te2..Qw2tMOX1WZF56MpxMu1Yuj6MfWOJZ0SjoghGS', 'Syarief', 'warga', NULL),
(8, '7571020106060001', '$2y$12$5LBHGqu.FkPyXX3I8Oitm.T4K.X6PxYPKgvd3sgD9MzY07nR4rh8.', 'Zhafir', 'warga', NULL),
(9, '8877665544332211', '$2y$12$yqEO0RPLhPuv9lOWsFHxuuB5fy8L9/PYt2KGSdCWGZe1YWFYi5fcS', 'Zhafir Bachri Muhammad', 'warga', NULL),
(11, '8765432187654321', '$2y$12$Nj4kc6R.5FYPKpG5TIoLzefBiQ.e0GEEPe6u5oRxQam6twoXDoF5m', 'Desrinta', 'warga', NULL),
(12, '0011223344556677', '$2y$12$jbGg8rSLx2tg2fqotcH2Du6FCtSow5rqtOjf2N4tQjVEEuwiFvk3O', 'Zhafir Bachri Muhammad', 'warga', NULL),
(14, '3201010101900000', '$2y$12$7G8mMhii1mZtnmzHQb9Yve8NPboZ722lc61jg5prkqcGmiEUZc/ea', 'Ahmad Supriyadi', 'warga', NULL),
(15, '3201010202920000', '$2y$12$p68WESa3DGSVhVpA/cozY.Q1IS6FtscMseBVwr9MpoyMkBd9OgDby', 'Siti Aminah', 'warga', NULL),
(16, '3201010303150000', '$2y$12$xSgTzGNS2aHJ.Xe8XB68PuY3YyQRwGmd1u5VFxsfqJRQD7mjDODz2', 'Budi Santoso', 'warga', NULL),
(17, '3201020404850000', '$2y$12$mbV/RcVeNv6VZaeFgi6SHOCb9hcnhZBXxbwM7BKV3/Q7Cdc70ZSwy', 'Citra Lestari', 'warga', NULL),
(18, '3201020505600000', '$2y$12$H/.xWKNmVXPkB6xbOooOKeBq4YO8J/YvYhowzoBAU0z6SclFA27Gq', 'Darmawan', 'warga', NULL),
(20, 'kades', '$2y$12$IYkRz1Sq0DMTErhA.lzsw.Lq3Vb.vKIHIFkdIpThrkN/RF6RyK0LO', 'Bpk. Hartono', 'kades', NULL),
(21, 'kadus_mawar', '$2y$12$0vW5ah.gwRLGC7cWq.YRuOiqsnVm.gMwmQSnoHv9nE27cqMRdaPJC', 'Bpk. Asep', 'kadus', 1),
(22, 'kadus_melati', '$2y$12$xhswsaUiGumud9cQtQzohuhANPs9lrDsunWQiyJtVvPfX1Z.9RfJa', 'Bpk. Joko', 'kadus', 2),
(23, 'kadus_anggrek', '$2y$12$VfTcQ90cKXnAFLFMrok.6uZ45dTm5/0LuNYn1OgYc2q1Cpn/fqxC6', 'Bpk. Dedi', 'kadus', 3),
(27, '1000000000000000', '$2y$12$TfZHHTa5/CjHTY.g2G/yTeEIOUxKk40iSA7Tf.3G8Qs2cIcvKCFQ2', 'Eka Pratama', 'warga', NULL),
(28, '2000000000000000', '$2y$12$6sOBVSEiywDv070DiGxEV.NUCs1pH4ZDqA5m/jqe32JHjTVIC7T/i', 'Luna Maya', 'warga', NULL),
(29, '3000000000000000', '$2y$12$s9M3UNFhKtZloiMWWuAa5erfRqhe6HTbYUJ.PFem8qFouxYWnAgZ2', 'Opick Tombo', 'warga', NULL),
(30, '1100110011000001', '$2y$12$nCA.q1Bo6qgzT229Ac1g8ehjHpFCBEU1VoYkkWD5cBHqg5C4fJ3A6', 'Asep Sunandar', 'warga', NULL),
(31, '1100110011000002', '$2y$12$YNlyrMdrMAJXpt2bEf.Q9OtYOnPkqBNopiIU.ziKrl4tAvH5/J96C', 'Lilis Suryani', 'warga', NULL),
(32, '1100110011000003', '$2y$12$J9h/zMzH.XB5vuh5CPwgfOTZ0Vz9OY.aM3LynHyyf4tWDxxUelJJW', 'Ujang Permana', 'warga', NULL),
(33, '1100110011000004', '$2y$12$kygKENMznOh/HnOhBbYKXerJqKsfypkCJKJ/QiAVEiBK2Ovx9eD1G', 'Bambang Pamungkas', 'warga', NULL),
(34, '1100110011000005', '$2y$12$.P8R3ZOKUO5HUjou8HEDU.amcOT6j7wXdqe/yG4EaFynscozH3QsC', 'Sri Wahyuni', 'warga', NULL),
(35, '2200220022000001', '$2y$12$JS2qOXFBCMdkS/FRQe9WOe3plZgJCUUHB7oqHLcLULb0W.PPfY1AG', 'Charles Xavier', 'warga', NULL),
(36, '2200220022000002', '$2y$12$x5p0/2mfxB3S1uPMiRsXP.O9smD2bBvz64PUWdy.9PNth01d/FyR6', 'Erik Lensherr', 'warga', NULL),
(37, '2200220022000003', '$2y$12$1HV1TRuAkO7YPAtIGeA2GuGESjD7Wm12O4VWq9cfBXPg9k59VtzsW', 'Jean Grey', 'warga', NULL),
(38, '2200220022000004', '$2y$12$KqG.JKPkTvc0Hh9Np4D4DuEGZIkFZOkJUSYAe.hXMK9XRB5pg59VS', 'Dewi Sartika', 'warga', NULL),
(39, '2200220022000005', '$2y$12$adlf28HrnRcnqzgStoFCqu4vusX/X5GJXahcOb8Wvgh.Nwql680bC', 'Raden Saleh', 'warga', NULL),
(40, '2200220022000006', '$2y$12$Yv8vOvTafW6fde6iiKYGz.raJi4aypfcVtOFaQp4OGPrWDo40cRzy', 'Kartini', 'warga', NULL),
(41, '3300330033000001', '$2y$12$C/KfodTZLg4XyBK1iCIjkeDHdnRpDr2l8OLusYktYI40a1Ejm5vUC', 'I Wayan Sudirta', 'warga', NULL),
(42, '3300330033000002', '$2y$12$bqsjs9fyicJ0rx/2TVSza.JUQapWBNQjqODWcCnt9yUiR0RCzf89S', 'Ni Made Ayu', 'warga', NULL),
(43, '3300330033000003', '$2y$12$i5uJD6lk5wLl35O7cRwUpuOXVS6ANp4EwsoBb0yNw.miVMSw72FOm', 'I Ketut Gede', 'warga', NULL),
(44, '3300330033000004', '$2y$12$mKXeb2mksVIDFFCCCjHzt.h4shbf2lUCJwmAzChpo.0aPqddL9sfa', 'Nyoman Rai', 'warga', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_warga`
--

CREATE TABLE `tabel_warga` (
  `id_warga` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `id_kk` bigint(20) UNSIGNED DEFAULT NULL,
  `status_dalam_keluarga` enum('KEPALA KELUARGA','ISTRI','ANAK','FAMILI LAIN') NOT NULL DEFAULT 'FAMILI LAIN',
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('LAKI-LAKI','PEREMPUAN') DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `status_perkawinan` varchar(50) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `kewarganegaraan` varchar(50) NOT NULL DEFAULT 'WNI'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tabel_warga`
--

INSERT INTO `tabel_warga` (`id_warga`, `nik`, `nama_lengkap`, `id_kk`, `status_dalam_keluarga`, `id_user`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `status_perkawinan`, `pekerjaan`, `kewarganegaraan`) VALUES
(1, '1100110011000001', 'Asep Sunandar', 1, 'KEPALA KELUARGA', 30, 'Bandung', '1980-01-01', 'LAKI-LAKI', 'ISLAM', 'KAWIN', 'WIRASWASTA', 'WNI'),
(2, '1100110011000002', 'Lilis Suryani', 1, 'ISTRI', 31, 'Bandung', '1982-05-10', 'PEREMPUAN', 'ISLAM', 'KAWIN', 'IRT', 'WNI'),
(3, '1100110011000003', 'Ujang Permana', 1, 'ANAK', 32, 'Jakarta', '2010-08-17', 'LAKI-LAKI', 'ISLAM', 'BELUM KAWIN', 'PELAJAR', 'WNI'),
(4, '1100110011000004', 'Bambang Pamungkas', 2, 'KEPALA KELUARGA', 33, 'Semarang', '1990-02-02', 'LAKI-LAKI', 'ISLAM', 'KAWIN', 'BURUH', 'WNI'),
(5, '1100110011000005', 'Sri Wahyuni', 2, 'ISTRI', 34, 'Solo', '1995-03-03', 'PEREMPUAN', 'ISLAM', 'KAWIN', 'PEDAGANG', 'WNI'),
(6, '2200220022000001', 'Charles Xavier', 3, 'KEPALA KELUARGA', 35, 'Manado', '1975-12-25', 'LAKI-LAKI', 'KRISTEN', 'CERAI MATI', 'PENSIUNAN', 'WNI'),
(7, '2200220022000002', 'Erik Lensherr', 3, 'ANAK', 36, 'Surabaya', '2000-01-01', 'LAKI-LAKI', 'KRISTEN', 'BELUM KAWIN', 'MAHASISWA', 'WNI'),
(8, '2200220022000003', 'Jean Grey', 3, 'FAMILI LAIN', 37, 'Jakarta', '1998-05-05', 'PEREMPUAN', 'KRISTEN', 'BELUM KAWIN', 'PERAWAT', 'WNI'),
(9, '2200220022000004', 'Dewi Sartika', 4, 'KEPALA KELUARGA', 38, 'Yogyakarta', '1985-04-21', 'PEREMPUAN', 'ISLAM', 'CERAI HIDUP', 'GURU', 'WNI'),
(10, '2200220022000005', 'Raden Saleh', 4, 'ANAK', 39, 'Yogyakarta', '2012-06-01', 'LAKI-LAKI', 'ISLAM', 'BELUM KAWIN', 'PELAJAR', 'WNI'),
(11, '2200220022000006', 'Kartini', 4, 'ANAK', 40, 'Yogyakarta', '2015-04-21', 'PEREMPUAN', 'ISLAM', 'BELUM KAWIN', 'PELAJAR', 'WNI'),
(12, '3300330033000001', 'I Wayan Sudirta', 5, 'KEPALA KELUARGA', 41, 'Denpasar', '1988-09-09', 'LAKI-LAKI', 'HINDU', 'KAWIN', 'NELAYAN', 'WNI'),
(13, '3300330033000002', 'Ni Made Ayu', 5, 'ISTRI', 42, 'Gianyar', '1990-10-10', 'PEREMPUAN', 'HINDU', 'KAWIN', 'PETANI', 'WNI'),
(14, '3300330033000003', 'I Ketut Gede', 5, 'ANAK', 43, 'Denpasar', '2018-11-11', 'LAKI-LAKI', 'HINDU', 'BELUM KAWIN', 'BELUM SEKOLAH', 'WNI'),
(15, '3300330033000004', 'Nyoman Rai', 5, 'FAMILI LAIN', 44, 'Tabanan', '1960-01-01', 'PEREMPUAN', 'HINDU', 'CERAI MATI', 'TIDAK BEKERJA', 'WNI'),
(16, '0011223344556677', 'Zhafir Bachri Muhammad', 6, 'KEPALA KELUARGA', 12, 'gorontalo', '2025-11-29', 'LAKI-LAKI', 'ISLAM', 'BELUM KAWIN', 'pelajar/mahasiswa', 'WNI');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tabel_ajuan_surat`
--
ALTER TABLE `tabel_ajuan_surat`
  ADD PRIMARY KEY (`id_ajuan`),
  ADD KEY `tabel_ajuan_surat_id_warga_foreign` (`id_warga`),
  ADD KEY `tabel_ajuan_surat_id_jenis_surat_foreign` (`id_jenis_surat`),
  ADD KEY `tabel_ajuan_surat_id_pejabat_desa_foreign` (`id_pejabat_desa`),
  ADD KEY `tabel_ajuan_surat_id_pejabat_desa_2_foreign` (`id_pejabat_desa_2`);

--
-- Indeks untuk tabel `tabel_dusun`
--
ALTER TABLE `tabel_dusun`
  ADD PRIMARY KEY (`id_dusun`);

--
-- Indeks untuk tabel `tabel_jenis_surat`
--
ALTER TABLE `tabel_jenis_surat`
  ADD PRIMARY KEY (`id_jenis_surat`);

--
-- Indeks untuk tabel `tabel_kk`
--
ALTER TABLE `tabel_kk`
  ADD PRIMARY KEY (`id_kk`),
  ADD UNIQUE KEY `tabel_kk_no_kk_unique` (`no_kk`),
  ADD KEY `tabel_kk_id_dusun_foreign` (`id_dusun`);

--
-- Indeks untuk tabel `tabel_pejabat_desa`
--
ALTER TABLE `tabel_pejabat_desa`
  ADD PRIMARY KEY (`id_pejabat_desa`);

--
-- Indeks untuk tabel `tabel_pengumuman`
--
ALTER TABLE `tabel_pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `tabel_pengumuman_id_user_admin_foreign` (`id_user_admin`);

--
-- Indeks untuk tabel `tabel_users`
--
ALTER TABLE `tabel_users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `tabel_users_username_unique` (`username`),
  ADD KEY `tabel_users_id_dusun_foreign` (`id_dusun`);

--
-- Indeks untuk tabel `tabel_warga`
--
ALTER TABLE `tabel_warga`
  ADD PRIMARY KEY (`id_warga`),
  ADD UNIQUE KEY `tabel_warga_nik_unique` (`nik`),
  ADD UNIQUE KEY `tabel_warga_id_user_unique` (`id_user`),
  ADD KEY `tabel_warga_id_kk_foreign` (`id_kk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tabel_ajuan_surat`
--
ALTER TABLE `tabel_ajuan_surat`
  MODIFY `id_ajuan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tabel_dusun`
--
ALTER TABLE `tabel_dusun`
  MODIFY `id_dusun` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tabel_jenis_surat`
--
ALTER TABLE `tabel_jenis_surat`
  MODIFY `id_jenis_surat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tabel_kk`
--
ALTER TABLE `tabel_kk`
  MODIFY `id_kk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tabel_pejabat_desa`
--
ALTER TABLE `tabel_pejabat_desa`
  MODIFY `id_pejabat_desa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tabel_pengumuman`
--
ALTER TABLE `tabel_pengumuman`
  MODIFY `id_pengumuman` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tabel_users`
--
ALTER TABLE `tabel_users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `tabel_warga`
--
ALTER TABLE `tabel_warga`
  MODIFY `id_warga` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tabel_ajuan_surat`
--
ALTER TABLE `tabel_ajuan_surat`
  ADD CONSTRAINT `tabel_ajuan_surat_id_jenis_surat_foreign` FOREIGN KEY (`id_jenis_surat`) REFERENCES `tabel_jenis_surat` (`id_jenis_surat`) ON DELETE SET NULL,
  ADD CONSTRAINT `tabel_ajuan_surat_id_pejabat_desa_2_foreign` FOREIGN KEY (`id_pejabat_desa_2`) REFERENCES `tabel_pejabat_desa` (`id_pejabat_desa`) ON DELETE SET NULL,
  ADD CONSTRAINT `tabel_ajuan_surat_id_pejabat_desa_foreign` FOREIGN KEY (`id_pejabat_desa`) REFERENCES `tabel_pejabat_desa` (`id_pejabat_desa`) ON DELETE SET NULL,
  ADD CONSTRAINT `tabel_ajuan_surat_id_warga_foreign` FOREIGN KEY (`id_warga`) REFERENCES `tabel_warga` (`id_warga`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tabel_kk`
--
ALTER TABLE `tabel_kk`
  ADD CONSTRAINT `tabel_kk_id_dusun_foreign` FOREIGN KEY (`id_dusun`) REFERENCES `tabel_dusun` (`id_dusun`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tabel_pengumuman`
--
ALTER TABLE `tabel_pengumuman`
  ADD CONSTRAINT `tabel_pengumuman_id_user_admin_foreign` FOREIGN KEY (`id_user_admin`) REFERENCES `tabel_users` (`id_user`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tabel_users`
--
ALTER TABLE `tabel_users`
  ADD CONSTRAINT `tabel_users_id_dusun_foreign` FOREIGN KEY (`id_dusun`) REFERENCES `tabel_dusun` (`id_dusun`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tabel_warga`
--
ALTER TABLE `tabel_warga`
  ADD CONSTRAINT `tabel_warga_id_kk_foreign` FOREIGN KEY (`id_kk`) REFERENCES `tabel_kk` (`id_kk`) ON DELETE SET NULL,
  ADD CONSTRAINT `tabel_warga_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tabel_users` (`id_user`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
