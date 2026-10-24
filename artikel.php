<?php
/**
 * NutriGen — Halaman Daftar & Manajemen Artikel (READ & CRUD Hub)
 */

require_once __DIR__ . '/includes/koneksi.php';
require_once __DIR__ . '/includes/functions.php';

$current_page = 'artikel';
$page_title = 'Artikel Edukasi Gizi — NutriGen';

$daftar_artikel = [];
$error_db = null;

if (!empty($koneksi)) {
    $sql = "SELECT id, judul, kategori, ringkasan, tanggal_dibuat FROM artikel ORDER BY tanggal_dibuat DESC, id DESC";
    $result = @mysqli_query($koneksi, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $daftar_artikel[] = $row;
        }
        mysqli_free_result($result);
    } else {
        $error_db = 'Gagal memuat data artikel dari database.';
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

    <main>

        <?= render_flash() ?>

        <?php if (!empty($koneksi_error)): ?>
            <div class="alert alert-danger">
                <strong>Perhatian:</strong> <?= e($koneksi_error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_db)): ?>
            <div class="alert alert-danger">
                <strong>Kesalahan:</strong> <?= e($error_db) ?>
            </div>
        <?php endif; ?>

        <!-- SECTION DAFTAR ARTIKEL DENGAN HERO BANNER SESUAI REFERENSI -->
        <section>
            <div class="card-hero-banner">
                <div class="card-hero-content">
                    <div class="accent-bar"></div>
                    <h2>Artikel Edukasi Gizi</h2>
                    <p>
                        Temukan berbagai informasi dan tips seputar gizi, pola makan sehat, 
                        dan pencegahan stunting untuk membangun generasi yang lebih sehat.
                    </p>
                    <div style="margin-top: 18px;">
                        <a href="tambah.php" class="btn btn-primary">+ Tulis Artikel Baru</a>
                    </div>
                </div>
                <img 
                    src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80" 
                    alt="Makanan Sehat dan Sayuran Segar" 
                    class="card-hero-image"
                >
            </div>

            <?php if (empty($daftar_artikel)): ?>
                <div class="empty-state">
                    <p>Belum ada artikel yang tersimpan di dalam database.</p>
                    <a href="tambah.php" class="btn btn-primary">+ Tambah Artikel Pertama</a>
                </div>
            <?php else: ?>

                <!-- Grid Kartu Artikel Edukasi -->
                <div class="article-grid">
                    <?php foreach ($daftar_artikel as $item): ?>
                        <article class="article-card">
                            <div class="article-card-header">
                                <span class="badge-category"><?= e($item['kategori']) ?></span>
                                <span class="article-card-date"><?= e(format_tanggal_indonesia($item['tanggal_dibuat'])) ?></span>
                                <h3 class="article-card-title">
                                    <a href="detail.php?id=<?= (int)$item['id'] ?>"><?= e($item['judul']) ?></a>
                                </h3>
                            </div>
                            <p class="article-card-summary">
                                <?= e($item['ringkasan']) ?>
                            </p>
                            <div class="article-card-footer">
                                <a href="detail.php?id=<?= (int)$item['id'] ?>" class="link">Baca Selengkapnya &rarr;</a>
                                <div class="action-buttons">
                                    <a href="edit.php?id=<?= (int)$item['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- Tabel Manajemen Data Artikel (CRUD Hub) -->
                <div id="kelola-artikel" style="margin-top: 48px;">
                    <div class="accent-bar"></div>
                    <h3>Kelola Data Artikel</h3>
                    <p>Tabel interaktif untuk melihat, memperbarui, atau menghapus artikel terdaftar.</p>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 50px; text-align: center;">No</th>
                                    <th>Judul Artikel</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Dibuat</th>
                                    <th style="text-align: center; width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($daftar_artikel as $art): ?>
                                    <tr>
                                        <td style="text-align: center; font-weight: normal;"><?= $no++ ?></td>
                                        <td>
                                            <a href="detail.php?id=<?= (int)$art['id'] ?>" class="link" style="font-weight: 600;">
                                                <?= e($art['judul']) ?>
                                            </a>
                                        </td>
                                        <td><span class="badge-category"><?= e($art['kategori']) ?></span></td>
                                        <td><?= e(format_tanggal_indonesia($art['tanggal_dibuat'])) ?></td>
                                        <td>
                                            <div class="action-buttons" style="justify-content: center;">
                                                <a href="detail.php?id=<?= (int)$art['id'] ?>" class="btn btn-outline btn-sm">Lihat</a>
                                                <a href="edit.php?id=<?= (int)$art['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                                
                                                <!-- Form POST Hapus dengan Token CSRF -->
                                                <form action="hapus.php" method="POST">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="id" value="<?= (int)$art['id'] ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php endif; ?>

        </section>

    </main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
