-- =============================================
-- JALANKAN QUERY INI DI phpMyAdmin LARAGON
-- Database: nvcnetwork
-- =============================================

USE nvcnetwork;

-- 1. Tambah kolom ke tabel paket_wifi (jika belum ada)
ALTER TABLE `paket_wifi` 
  ADD COLUMN IF NOT EXISTS `deskripsi` TEXT NULL AFTER `harga`,
  ADD COLUMN IF NOT EXISTS `bandwidth` VARCHAR(20) NULL AFTER `deskripsi`,
  ADD COLUMN IF NOT EXISTS `is_featured` TINYINT(1) DEFAULT 0 AFTER `bandwidth`;

-- 2. Update data paket yang sudah ada dengan bandwidth default
UPDATE paket_wifi SET bandwidth='20 Mbps', is_featured=0 WHERE nama_paket='Internet Broadband only' AND bandwidth IS NULL;
UPDATE paket_wifi SET bandwidth='30 Mbps', is_featured=1 WHERE nama_paket='Internet Broadband Fast' AND bandwidth IS NULL;
UPDATE paket_wifi SET bandwidth='40 Mbps', is_featured=0 WHERE nama_paket='Internet Broadband High' AND bandwidth IS NULL;

-- 3. Buat tabel coverage_area
CREATE TABLE IF NOT EXISTS `coverage_area` (
  `id_coverage` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_kota` VARCHAR(100) NOT NULL,
  `daftar_area` TEXT NOT NULL COMMENT 'Pisahkan tiap area dengan koma',
  `urutan` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Insert data coverage default (hanya jika tabel kosong)
INSERT INTO `coverage_area` (`nama_kota`, `daftar_area`, `urutan`)
SELECT 'Banyuwangi', 'Kalipuro,Giri,Gombengsari,Suko,Kacangan,Lerek,Kelir,Telemung,Bulusari,Kenjo,Paspan,Tamansuruh,Kampung Anyar,Gumuk,Pendarungan,Dan Area Sekitarnya...', 1
WHERE NOT EXISTS (SELECT 1 FROM coverage_area LIMIT 1);

SELECT 'Setup selesai!' AS Status;
