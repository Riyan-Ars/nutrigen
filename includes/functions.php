<?php
/**
 * NutriGen — Fungsi Pendukung & Utilitas Aplikasi
 */

// Mulai sesi jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Sanitasi output HTML untuk mencegah XSS
 */
function e(?string $teks): string {
    return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Format tanggal dan waktu ke bahasa Indonesia
 */
function format_tanggal_indonesia(?string $datetime): string {
    if (!$datetime) {
        return '-';
    }

    $timestamp = strtotime($datetime);
    if ($timestamp === false) {
        return $datetime;
    }

    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $hari = date('j', $timestamp);
    $bulan_index = (int)date('n', $timestamp);
    $tahun = date('Y', $timestamp);
    $jam = date('H:i', $timestamp);

    $nama_bulan = $bulan[$bulan_index] ?? '';

    return "{$hari} {$nama_bulan} {$tahun}, {$jam} WIB";
}

/**
 * Buat dan ambil token CSRF
 */
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Cetak input tersembunyi CSRF untuk formulir
 */
function csrf_field(): string {
    $token = csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . e($token) . '">';
}

/**
 * Validasi token CSRF dari permintaan POST
 */
function csrf_verify(): bool {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return false;
    }
    $token_post = $_POST['csrf_token'] ?? '';
    $token_session = $_SESSION['csrf_token'] ?? '';
    if (empty($token_post) || empty($token_session)) {
        return false;
    }
    return hash_equals($token_session, $token_post);
}

/**
 * Simpan pesan flash notifikasi
 */
function set_flash(string $tipe, string $pesan): void {
    $_SESSION['flash_message'] = [
        'tipe' => $tipe, // 'sukses' atau 'error'
        'pesan' => $pesan
    ];
}

/**
 * Tampilkan notifikasi flash message jika tersedia
 */
function render_flash(): string {
    if (empty($_SESSION['flash_message'])) {
        return '';
    }

    $flash = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);

    $tipe_class = ($flash['tipe'] === 'sukses') ? 'alert-success' : 'alert-danger';
    $label = ($flash['tipe'] === 'sukses') ? 'Berhasil: ' : 'Perhatian: ';

    return '<div class="alert ' . $tipe_class . '"><strong>' . e($label) . '</strong>' . e($flash['pesan']) . '</div>';
}

/**
 * Daftar kategori standar edukasi gizi dan stunting
 */
function daftar_kategori(): array {
    return [
        'Pencegahan Stunting',
        'Nutrisi Anak & Balita',
        'Pola Makan Sehat',
        'Gizi Ibu Hamil',
        'Gaya Hidup & Kebugaran'
    ];
}
