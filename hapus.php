<?php
/**
 * NutriGen — Hapus Artikel Edukasi (DELETE Handler)
 * Memproses permintaan penghapusan artikel HANYA melalui metode POST dan validasi CSRF
 */

require_once __DIR__ . '/includes/koneksi.php';
require_once __DIR__ . '/includes/functions.php';

// Pastikan permintaan HANYA melalui metode POST (tolak metode GET)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash('error', 'Metode permintaan tidak valid. Penghapusan artikel hanya dapat dilakukan melalui metode POST demi keamanan data.');
    header('Location: artikel.php');
    exit;
}

// Validasi Token CSRF
if (!csrf_verify()) {
    set_flash('error', 'Token keamanan (CSRF) tidak valid atau sesi telah kedaluwarsa. Operasi penghapusan dibatalkan.');
    header('Location: artikel.php');
    exit;
}

// Validasi ID artikel
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    set_flash('error', 'ID artikel tidak valid.');
    header('Location: artikel.php');
    exit;
}

if (empty($koneksi)) {
    set_flash('error', 'Koneksi database terputus. Tidak dapat menghapus artikel.');
    header('Location: artikel.php');
    exit;
}

// Ambil judul artikel terlebih dahulu untuk konfirmasi notifikasi ramah
$judul_artikel = '';
$sql_cek = "SELECT judul FROM artikel WHERE id = ? LIMIT 1";
$stmt_cek = mysqli_prepare($koneksi, $sql_cek);
if ($stmt_cek) {
    mysqli_stmt_bind_param($stmt_cek, 'i', $id);
    mysqli_stmt_execute($stmt_cek);
    mysqli_stmt_bind_result($stmt_cek, $judul_artikel);
    mysqli_stmt_fetch($stmt_cek);
    mysqli_stmt_close($stmt_cek);
}

if (empty($judul_artikel)) {
    set_flash('error', 'Artikel dengan ID #' . $id . ' tidak ditemukan atau sudah dihapus sebelumnya.');
    header('Location: artikel.php');
    exit;
}

// Eksekusi penghapusan dengan Prepared Statement
$sql_delete = "DELETE FROM artikel WHERE id = ?";
$stmt_delete = mysqli_prepare($koneksi, $sql_delete);

if ($stmt_delete) {
    mysqli_stmt_bind_param($stmt_delete, 'i', $id);
    if (mysqli_stmt_execute($stmt_delete)) {
        mysqli_stmt_close($stmt_delete);
        set_flash('sukses', 'Artikel "' . $judul_artikel . '" berhasil dihapus dari database.');
    } else {
        $error_msg = mysqli_stmt_error($stmt_delete);
        mysqli_stmt_close($stmt_delete);
        set_flash('error', 'Gagal menghapus artikel: ' . $error_msg);
    }
} else {
    set_flash('error', 'Terjadi kesalahan sistem saat mempersiapkan penghapusan.');
}

header('Location: artikel.php#kelola-artikel');
exit;
