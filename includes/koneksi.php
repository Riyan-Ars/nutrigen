<?php
/**
 * NutriGen — Koneksi Database MySQL Native
 * Konfigurasi standar lokal Laragon
 */

// Konfigurasi Database
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'nutrigen';

// Inisialisasi koneksi MySQLi dengan pelaporan error yang aman
mysqli_report(MYSQLI_REPORT_OFF);

$koneksi = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$koneksi) {
    // Tangani kegagalan koneksi secara anggun tanpa membocorkan kredensial teknis
    $koneksi_error = 'Koneksi ke database MySQL gagal. Pastikan layanan MySQL di Laragon telah aktif dan database "nutrigen" telah diimpor.';
} else {
    $koneksi_error = null;
    mysqli_set_charset($koneksi, 'utf8mb4');
}
