-- ============================================
-- DATABASE: db_bukutamu
-- Aplikasi Buku Tamu Digital Sekolah
-- ============================================

CREATE DATABASE IF NOT EXISTS db_bukutamu
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_bukutamu;

-- ============================================
-- Tabel: buku_tamu
-- ============================================
CREATE TABLE IF NOT EXISTS buku_tamu (
  id        INT          NOT NULL AUTO_INCREMENT,
  nama      VARCHAR(100) NOT NULL,
  instansi  VARCHAR(150) NOT NULL,
  tujuan    TEXT         NOT NULL,
  tanggal   DATE         NOT NULL,
  waktu     TIME         NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Contoh Data 
-- ============================================
INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) VALUES
  ('Budi Santoso',   'Dinas Pendidikan Kota',   'Kunjungan pengawas rutin semester genap',      '2026-06-01', '08:30:00'),
  ('Sari Dewi',      'Universitas Nusantara',    'Penelitian skripsi bidang manajemen sekolah',  '2026-06-02', '10:00:00'),
  ('Ahmad Fauzi',    'Komite Sekolah',           'Rapat koordinasi program kerja komite',        '2026-06-03', '13:15:00'),
  ('Rina Marlina',   'Puskesmas Kecamatan',      'Sosialisasi program kesehatan remaja',         '2026-06-04', '09:45:00'),
  ('Teguh Prakoso',  'Perusahaan Mitra Magang',  'Penandatanganan MoU program magang siswa',     '2026-06-05', '11:00:00');
