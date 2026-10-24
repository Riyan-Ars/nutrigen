<?php
/**
 * NutriGen — Navbar Template
 * Navigasi utama dengan anchor cerdas dan status aktif murni PHP & CSS tanpa JavaScript
 */

$is_home = (isset($current_page) && $current_page === 'home');
$is_artikel = (isset($current_page) && in_array($current_page, ['artikel', 'tambah', 'edit', 'detail']));
?>
    <!-- NAVIGATION -->
    <nav>
        <a href="<?= $is_home ? '#home' : 'index.php#home' ?>" class="<?= $is_home ? 'active' : '' ?>">Home</a>
        <a href="<?= $is_home ? '#tentang' : 'index.php#tentang' ?>">Tentang</a>
        <a href="<?= $is_home ? '#manfaat' : 'index.php#manfaat' ?>">Manfaat</a>
        <a href="<?= $is_home ? '#cara' : 'index.php#cara' ?>">Cara Memulai</a>
        <a href="<?= $is_home ? '#kontak' : 'index.php#kontak' ?>">Kontak</a>
        <a href="artikel.php" class="<?= $is_artikel ? 'active' : '' ?>">Artikel</a>
    </nav>
