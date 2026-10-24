<?php
/**
 * NutriGen — Detail Baca Artikel Edukasi
 * Menampilkan isi lengkap artikel gizi berdasarkan ID
 */

require_once __DIR__ . '/includes/koneksi.php';
require_once __DIR__ . '/includes/functions.php';

$current_page = 'artikel';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$artikel = null;
$error_pesan = null;

if ($id <= 0) {
    $error_pesan = 'ID artikel tidak valid.';
} elseif (empty($koneksi)) {
    $error_pesan = 'Koneksi database tidak tersedia. Pastikan Laragon MySQL aktif.';
} else {
    $sql = "SELECT id, judul, kategori, ringkasan, isi, tanggal_dibuat FROM artikel WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($koneksi, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $artikel = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        if (!$artikel) {
            $error_pesan = 'Artikel dengan ID #' . $id . ' tidak ditemukan di database NutriGen.';
        }
    } else {
        $error_pesan = 'Terjadi kesalahan sistem dalam pengambilan data artikel.';
    }
}

$page_title = $artikel ? ($artikel['judul'] . ' — NutriGen') : 'Artikel Tidak Ditemukan — NutriGen';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

    <main>

        <?= render_flash() ?>

        <?php if ($error_pesan || !$artikel): ?>
            <section class="card-box">
                <div class="empty-state">
                    <h2 style="justify-content: center; border-bottom: none; margin-bottom: 12px;">Artikel Tidak Ditemukan</h2>
                    <p><?= e($error_pesan ?? 'Data artikel yang Anda cari tidak tersedia.') ?></p>
                    <div style="margin-top: 24px;">
                        <a href="artikel.php" class="btn btn-primary">&larr; Kembali ke Daftar Artikel</a>
                        <a href="index.php" class="btn btn-secondary">Menuju Halaman Utama</a>
                    </div>
                </div>
            </section>
        <?php else: ?>

            <article class="card-box">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #edf1ee; gap: 16px; flex-wrap: wrap;">
                    <div>
                        <div class="accent-bar"></div>
                        <span class="badge-category"><?= e($artikel['kategori']) ?></span>
                        <h2 style="margin-top: 10px; margin-bottom: 4px;"><?= e($artikel['judul']) ?></h2>
                    </div>
                    <div>
                        <a href="artikel.php#kelola-artikel" class="btn btn-secondary btn-sm">&larr; Kembali ke Daftar</a>
                    </div>
                </div>

                <div class="article-detail-meta">
                    <span class="date">
                        Dipublikasikan pada: <strong><?= e(format_tanggal_indonesia($artikel['tanggal_dibuat'])) ?></strong>
                    </span>
                    <span style="color: #cbd5e1;">|</span>
                    <span class="date">Kategori: <strong><?= e($artikel['kategori']) ?></strong></span>
                </div>

                <!-- Box Ringkasan Penting -->
                <div style="background-color: #f6faf7; border-left: 4px solid #2e7d5b; padding: 18px 22px; border-radius: 8px; margin-bottom: 28px;">
                    <strong style="color: #1a5638; display: block; margin-bottom: 6px;">Ringkasan Edukasi:</strong>
                    <p style="margin-bottom: 0; font-size: 15.5px; color: #2c3e34; font-style: italic;">
                        <?= e($artikel['ringkasan']) ?>
                    </p>
                </div>

                <!-- Isi Lengkap Artikel -->
                <div class="article-detail-content">
                    <?php
                    // Pisahkan teks isi berdasarkan baris ganda atau baris baru untuk memformat paragraf secara semantik dan aman
                    $paragraf_list = explode("\n", str_replace(["\r\n", "\r"], "\n", $artikel['isi']));
                    foreach ($paragraf_list as $paragraf):
                        $paragraf = trim($paragraf);
                        if ($paragraf === '') continue;
                    ?>
                        <p><?= e($paragraf) ?></p>
                    <?php endforeach; ?>
                </div>

                <!-- Tombol Navigasi & Aksi Pengelolaan CRUD -->
                <div class="form-actions" style="justify-content: space-between;">
                    <a href="artikel.php#kelola-artikel" class="btn btn-secondary">&larr; Semua Artikel</a>

                    <div class="action-buttons">
                        <a href="edit.php?id=<?= (int)$artikel['id'] ?>" class="btn btn-primary">Edit Artikel Ini</a>

                        <!-- Form POST Hapus dengan Token CSRF (Tanpa JavaScript) -->
                        <form action="hapus.php" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int)$artikel['id'] ?>">
                            <button type="submit" class="btn btn-danger">Hapus Artikel</button>
                        </form>
                    </div>
                </div>
            </article>

        <?php endif; ?>

    </main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
