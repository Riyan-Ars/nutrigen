<?php
/**
 * NutriGen — Header Template
 * Struktur awal HTML, font, dan elemen header dengan motif daun elegan
 */

if (!isset($page_title)) {
    $page_title = 'NutriGen — Bersama Tuntaskan Stunting, Bangun Generasi Emas';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?></title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Stylesheet Utama NutriGen -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- HEADER ELEGAN NUTRIGEN DENGAN MOTIF DAUN -->
    <header id="home" class="main-header">
        <!-- Siluet Daun di Kiri dan Kanan -->
        <div class="leaf-pattern-left" aria-hidden="true"></div>
        <div class="leaf-pattern-right" aria-hidden="true"></div>

        <div class="header-inner">
            <div class="brand-logo-group">
                <!-- Ikon Daun di Atas Tulisan NutriGen -->
                <svg class="brand-leaf-icon" viewBox="0 0 42 28" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M18 25C18 25 10 23 8 16C6 8 14 3 20 2C20 6 19 14 16 19C14.5 21.2 18 25 18 25Z" fill="#78c99b"/>
                    <path d="M21 25C21 25 29 21 32 15C35 9 30 2 25 1.5C24 5 25 13 28 18C29 20 21 25 21 25Z" fill="#b1e6c7"/>
                </svg>
                <h1 class="brand-name">NutriGen</h1>
            </div>
            <p class="brand-tagline">Bersama Tuntaskan Stunting, Bangun Generasi Emas</p>
        </div>
    </header>
