-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jul 2025 pada 12.53
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
-- Database: `db_pkl`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_pkl`
--

CREATE TABLE `absensi_pkl` (
  `id_absensi` int(11) NOT NULL,
  `id_penempatan` int(11) NOT NULL,
  `tanggal_absensi` date NOT NULL,
  `status_absensi` enum('hadir','sakit','izin','alpa') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ajuan_pkl`
--

CREATE TABLE `ajuan_pkl` (
  `id_ajuan` int(11) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `id_dudi` int(11) DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `status_kakomli` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `status_verifikasi` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `surat_permohonan` varchar(255) DEFAULT NULL,
  `catatan_kakomli` text DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `alur_pkl`
--

CREATE TABLE `alur_pkl` (
  `id_alur` int(11) NOT NULL,
  `judul_alur` varchar(255) NOT NULL,
  `deskripsi_alur` text DEFAULT NULL,
  `urutan` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alur_pkl`
--

INSERT INTO `alur_pkl` (`id_alur`, `judul_alur`, `deskripsi_alur`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Pendaftaran Akun', 'Siswa membuat akun baru di sistem informasi PKL.', 1, '2025-07-04 10:07:44', '2025-07-04 10:07:44'),
(2, 'Pengajuan PKL', 'Siswa mengajukan permohonan PKL dan memilih DU/DI tujuan.', 2, '2025-07-04 10:07:44', '2025-07-04 10:07:44'),
(3, 'Verifikasi & Penempatan', 'Ajuan diverifikasi oleh Kakomli dan Admin, lalu siswa ditempatkan.', 3, '2025-07-04 10:07:44', '2025-07-04 10:07:44'),
(4, 'Pelaksanaan & Pelaporan', 'Siswa menjalani PKL di DU/DI dan membuat laporan harian/mingguan.', 4, '2025-07-04 10:07:44', '2025-07-04 10:07:44'),
(5, 'Penilaian & Sertifikasi', 'Siswa menerima penilaian dari industri dan guru pembimbing, lalu mendapatkan sertifikat.', 5, '2025-07-04 10:07:44', '2025-07-04 10:07:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dudi`
--

CREATE TABLE `dudi` (
  `id_dudi` int(11) NOT NULL,
  `nama_dudi` varchar(255) NOT NULL,
  `alamat_dudi` text DEFAULT NULL,
  `telepon_dudi` varchar(20) DEFAULT NULL,
  `email_dudi` varchar(255) DEFAULT NULL,
  `referensi_jurusan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dudi`
--

INSERT INTO `dudi` (`id_dudi`, `nama_dudi`, `alamat_dudi`, `telepon_dudi`, `email_dudi`, `referensi_jurusan`, `created_at`, `updated_at`) VALUES
(1, 'PT. Inovasi Digital', 'Jl. Teknologi No. 1, Jakarta', '021-1234567', 'info@inovasidigital.com', 'Rekayasa Perangkat Lunak, Multimedia', '2025-07-04 10:07:44', '2025-07-04 10:07:44'),
(2, 'CV. Jaringan Solusi', 'Jl. Komputer No. 22, Bandung', '022-9876543', 'kontak@jaringansolusi.com', 'Teknik Komputer Jaringan', '2025-07-04 10:07:44', '2025-07-04 10:07:44'),
(3, 'Studio Kreatif Media', 'Jl. Seni No. 8, Surabaya', '031-7654321', 'halo@studiokreatif.com', 'Multimedia, Desain Grafis', '2025-07-04 10:07:44', '2025-07-04 10:07:44'),
(4, 'PT. Cyber Security Indonesia', 'Jl. Keamanan No. 3, Jakarta', '021-5555555', 'csi@example.com', 'Teknik Komputer Jaringan, Rekayasa Perangkat Lunak', '2025-07-04 10:07:44', '2025-07-04 10:07:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_unduh`
--

CREATE TABLE `file_unduh` (
  `id_file` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi_file` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `file_unduh`
--

INSERT INTO `file_unduh` (`id_file`, `nama_file`, `deskripsi`, `lokasi_file`, `created_at`, `updated_at`) VALUES
(1, 'Panduan PKL', 'Dokumen panduan lengkap untuk siswa PKL', 'panduan_pkl.pdf', '2025-07-04 09:56:49', '2025-07-04 09:56:49'),
(2, 'Panduan PKL Lengkap', 'Dokumen panduan berisi semua informasi penting untuk pelaksanaan PKL.', 'panduan_pkl_lengkap.pdf', '2025-07-04 10:07:44', '2025-07-04 10:07:44'),
(3, 'Form Penilaian Industri', 'Formulir yang harus diisi oleh pihak industri untuk penilaian siswa PKL.', 'form_penilaian_industri.docx', '2025-07-04 10:07:44', '2025-07-04 10:07:44'),
(4, 'Template Laporan Harian', 'Template untuk laporan harian siswa selama PKL.', 'template_laporan_harian.doc', '2025-07-04 10:07:44', '2025-07-04 10:07:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru_pembimbing`
--

CREATE TABLE `guru_pembimbing` (
  `id_guru` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `bidang_keahlian` varchar(100) DEFAULT NULL,
  `no_hp_guru` varchar(20) DEFAULT NULL,
  `email_guru` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru_pembimbing`
--

INSERT INTO `guru_pembimbing` (`id_guru`, `id_user`, `nip`, `nama_guru`, `bidang_keahlian`, `no_hp_guru`, `email_guru`, `created_at`, `updated_at`) VALUES
(2, NULL, '198502022010022002', 'Bpk. Joko Susilo, M.T.', 'Teknik Komputer Jaringan', '081344556677', 'joko.susilo@example.com', '2025-07-04 10:07:44', '2025-07-04 10:07:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(255) NOT NULL,
  `singkatan` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`, `singkatan`, `created_at`, `updated_at`) VALUES
(1, 'Pengembangan Perangkat Lunak dan Gim', 'PPLG', '2025-07-04 13:00:23', '2025-07-04 13:00:23'),
(2, 'Teknik Jaringan Komputer dan Informatika', 'TJKT', '2025-07-04 13:00:23', '2025-07-04 13:00:23'),
(3, 'Pemasaran', 'PMS', '2025-07-04 13:00:23', '2025-07-04 13:00:23'),
(4, 'Akuntansi Keuangan Lembaga', 'AKL', '2025-07-04 13:00:23', '2025-07-04 13:00:23'),
(5, 'Teknik Otomotif', 'TO', '2025-07-04 13:00:23', '2025-07-04 13:00:23'),
(6, 'Agribisnis Tanaman', 'AT', '2025-07-04 13:00:23', '2025-07-04 13:00:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `tingkat` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `tingkat`, `created_at`, `updated_at`) VALUES
(1, 'X PPLG 1', '10', '2025-07-04 13:00:23', '2025-07-04 14:13:22'),
(2, 'XII PPLG 1', '12', '2025-07-04 13:00:23', '2025-07-04 14:15:45'),
(3, 'XII PPLG 2', '12', '2025-07-04 13:00:23', '2025-07-04 14:15:53'),
(4, 'XII TJKT 1', '12', '2025-07-04 13:00:23', '2025-07-04 14:15:59'),
(5, 'XII TJKT 2', '12', '2025-07-04 13:00:23', '2025-07-04 14:16:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `id_penempatan` int(11) NOT NULL,
  `jenis_laporan` enum('harian','mingguan','akhir') NOT NULL,
  `tanggal_laporan` date NOT NULL,
  `isi_laporan` text DEFAULT NULL,
  `status_verifikasi_guru` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `catatan_guru` text DEFAULT NULL,
  `file_laporan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_pkl`
--

CREATE TABLE `nilai_pkl` (
  `id_nilai` int(11) NOT NULL,
  `id_penempatan` int(11) NOT NULL,
  `nilai_industri` decimal(5,2) DEFAULT NULL,
  `nilai_pembimbing` decimal(5,2) DEFAULT NULL,
  `nilai_akhir` decimal(5,2) DEFAULT NULL,
  `catatan_pembimbing` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penempatan_pkl`
--

CREATE TABLE `penempatan_pkl` (
  `id_penempatan` int(11) NOT NULL,
  `id_ajuan` int(11) NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `tanggal_mulai_pkl` date DEFAULT NULL,
  `tanggal_selesai_pkl` date DEFAULT NULL,
  `status_penempatan` enum('belum_mulai','berjalan','selesai') DEFAULT 'belum_mulai',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sertifikat`
--

CREATE TABLE `sertifikat` (
  `id_sertifikat` int(11) NOT NULL,
  `id_penempatan` int(11) NOT NULL,
  `nomor_sertifikat` varchar(100) DEFAULT NULL,
  `tanggal_terbit` date DEFAULT NULL,
  `file_sertifikat` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `nisn` varchar(20) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `alamat_siswa` text DEFAULT NULL,
  `no_hp_siswa` varchar(20) DEFAULT NULL,
  `email_siswa` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`nisn`, `id_user`, `nama_siswa`, `kelas`, `jurusan`, `alamat_siswa`, `no_hp_siswa`, `email_siswa`, `created_at`, `updated_at`) VALUES
('0012345678', 8, 'Budi Santoso', 'XII RPL 1', 'Pengembangan Perangkat Lunak dan Gim', 'Jl. Merdeka No. 10, Jakarta', '081234567890', 'budi.santoso@example.com', '2025-07-04 10:07:44', '2025-07-04 10:11:29'),
('0012345679', NULL, 'Citra Dewi', 'XII TKJ 2', 'Pengembangan Perangkat Lunak dan Gim', 'Jl. Sudirman No. 25, Bandung', '081298765432', 'citra.dewi@example.com', '2025-07-04 10:07:44', '2025-07-04 14:04:48'),
('0012345680', NULL, 'Dewi Lestari', 'XII RPL 2', 'Pengembangan Perangkat Lunak dan Gim', 'Jl. Gatot Subroto No. 5, Surabaya', '085712345678', 'dewi.lestari@example.com', '2025-07-04 10:07:44', '2025-07-04 14:15:07'),
('0012345681', 7, 'Eko Prasetyo', 'XII TKJ 1', 'Teknik Komputer Jaringan', 'Jl. Diponegoro No. 15, Yogyakarta', '087811223344', 'eko.prasetyo@example.com', '2025-07-04 10:07:44', '2025-07-04 10:05:20'),
('0062126164', 6, 'Kholik', 'XII PPLG 1', 'Pengembangan Perangkat Lunak dan Gim', 'KP. CEMPEH RT. 003 RT. 005', '083812314467', 'kholikq@gmail.com', '2025-07-04 06:47:13', '2025-07-04 09:50:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','guru','siswa') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `level`, `created_at`, `updated_at`) VALUES
(1, 'admin_pkl', '$2y$10$jpkItIFhuhZ9VmpFFLNFBO2Qr/psgzR84xIFt3wYqAdpOzsibGgAq', 'admin', '2025-07-04 10:07:44', '2025-07-05 15:32:29'),
(2, 'guru_pembimbing1', '$2y$10$jpkItIFhuhZ9VmpFFLNFBO2Qr/psgzR84xIFt3wYqAdpOzsibGgAq', 'guru', '2025-07-04 10:07:44', '2025-07-05 16:00:20'),
(6, '0062126164', '$2y$10$EBSDvCTKGAW.hL1CLWQkoePEwT4wCowSRSoJWo4DX8lRL65PIMXJa', 'siswa', '2025-07-04 09:50:41', '2025-07-04 09:50:41'),
(7, '0012345681', '$2y$10$hCSDSq.hByKjP2psW16Xl.fvEqWXTZ.Y0g56u7hcPcKu5RwpMRVSu', 'siswa', '2025-07-04 10:05:20', '2025-07-04 10:05:20'),
(8, '0012345678', '$2y$10$3XkgiZ9ZSmd662W9JjuNN.s/CcRCb7GOofdoRj8X5GKdgRjqsw5IW', 'siswa', '2025-07-04 10:11:29', '2025-07-04 10:11:29');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi_pkl`
--
ALTER TABLE `absensi_pkl`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_penempatan` (`id_penempatan`);

--
-- Indeks untuk tabel `ajuan_pkl`
--
ALTER TABLE `ajuan_pkl`
  ADD PRIMARY KEY (`id_ajuan`),
  ADD KEY `nisn` (`nisn`),
  ADD KEY `id_dudi` (`id_dudi`);

--
-- Indeks untuk tabel `alur_pkl`
--
ALTER TABLE `alur_pkl`
  ADD PRIMARY KEY (`id_alur`);

--
-- Indeks untuk tabel `dudi`
--
ALTER TABLE `dudi`
  ADD PRIMARY KEY (`id_dudi`);

--
-- Indeks untuk tabel `file_unduh`
--
ALTER TABLE `file_unduh`
  ADD PRIMARY KEY (`id_file`);

--
-- Indeks untuk tabel `guru_pembimbing`
--
ALTER TABLE `guru_pembimbing`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`),
  ADD UNIQUE KEY `nama_jurusan` (`nama_jurusan`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD UNIQUE KEY `nama_kelas` (`nama_kelas`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_penempatan` (`id_penempatan`);

--
-- Indeks untuk tabel `nilai_pkl`
--
ALTER TABLE `nilai_pkl`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_penempatan` (`id_penempatan`);

--
-- Indeks untuk tabel `penempatan_pkl`
--
ALTER TABLE `penempatan_pkl`
  ADD PRIMARY KEY (`id_penempatan`),
  ADD KEY `id_ajuan` (`id_ajuan`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD PRIMARY KEY (`id_sertifikat`),
  ADD KEY `id_penempatan` (`id_penempatan`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nisn`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi_pkl`
--
ALTER TABLE `absensi_pkl`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ajuan_pkl`
--
ALTER TABLE `ajuan_pkl`
  MODIFY `id_ajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `alur_pkl`
--
ALTER TABLE `alur_pkl`
  MODIFY `id_alur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `dudi`
--
ALTER TABLE `dudi`
  MODIFY `id_dudi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `file_unduh`
--
ALTER TABLE `file_unduh`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `guru_pembimbing`
--
ALTER TABLE `guru_pembimbing`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_pkl`
--
ALTER TABLE `nilai_pkl`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penempatan_pkl`
--
ALTER TABLE `penempatan_pkl`
  MODIFY `id_penempatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `id_sertifikat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi_pkl`
--
ALTER TABLE `absensi_pkl`
  ADD CONSTRAINT `absensi_pkl_ibfk_1` FOREIGN KEY (`id_penempatan`) REFERENCES `penempatan_pkl` (`id_penempatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ajuan_pkl`
--
ALTER TABLE `ajuan_pkl`
  ADD CONSTRAINT `ajuan_pkl_ibfk_1` FOREIGN KEY (`nisn`) REFERENCES `siswa` (`nisn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ajuan_pkl_ibfk_2` FOREIGN KEY (`id_dudi`) REFERENCES `dudi` (`id_dudi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `guru_pembimbing`
--
ALTER TABLE `guru_pembimbing`
  ADD CONSTRAINT `guru_pembimbing_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_penempatan`) REFERENCES `penempatan_pkl` (`id_penempatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_pkl`
--
ALTER TABLE `nilai_pkl`
  ADD CONSTRAINT `nilai_pkl_ibfk_1` FOREIGN KEY (`id_penempatan`) REFERENCES `penempatan_pkl` (`id_penempatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penempatan_pkl`
--
ALTER TABLE `penempatan_pkl`
  ADD CONSTRAINT `penempatan_pkl_ibfk_1` FOREIGN KEY (`id_ajuan`) REFERENCES `ajuan_pkl` (`id_ajuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penempatan_pkl_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `guru_pembimbing` (`id_guru`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD CONSTRAINT `sertifikat_ibfk_1` FOREIGN KEY (`id_penempatan`) REFERENCES `penempatan_pkl` (`id_penempatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
