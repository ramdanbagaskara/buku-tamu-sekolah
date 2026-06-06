<?php
// ============================================
// koneksi.php — Konfigurasi Koneksi Database
// Aplikasi Buku Tamu Digital Sekolah
// ============================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Ganti sesuai username MySQL kamu
define('DB_PASS', '');           // Ganti sesuai password MySQL kamu
define('DB_NAME', 'db_bukutamu');

$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$koneksi) {
    die('<div style="font-family:sans-serif;padding:2rem;color:#c0392b;">
            <h3>&#9888; Koneksi Database Gagal</h3>
            <p>Error: ' . mysqli_connect_error() . '</p>
            <p>Pastikan MySQL sudah berjalan dan konfigurasi di <code>koneksi.php</code> sudah benar.</p>
         </div>');
}

mysqli_set_charset($koneksi, 'utf8mb4');
?>
