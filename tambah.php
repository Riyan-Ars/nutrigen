<?php
/**
 * NutriGen — Tambah Artikel Edukasi Baru (CREATE)
 */

require_once __DIR__ . '/includes/koneksi.php';
require_once __DIR__ . '/includes/functions.php';

$current_page = 'artikel';
$page_title = 'Tambah Artikel Baru — NutriGen';

$errors = [];
$judul = '';
$kategori = '';
$ringkasan = '';
$isi = '';

// Proses formulir saat metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Verifikasi CSRF Token
    if (!csrf_verify()) {
        $errors[] = 'Token keamanan tidak valid atau sesi telah berakhir. Silakan ulangi.';
    }

    // 2. Ambil dan bersihkan input
    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $ringkasan = trim($_POST['ringkasan'] ?? '');
    $isi = trim($_POST['isi'] ?? '');

    // 3. Validasi input wajib
    if ($judul === '') {
        $errors[] = 'Judul artikel wajib diisi.';
    } elseif (mb_strlen($judul) > 150) {
        $errors[] = 'Judul artikel maksimal 150 karakter.';
    }

    if ($kategori === '') {
        $errors[] = 'Kategori wajib diisi.';
    } elseif (mb_strlen($kategori) > 100) {
        $errors[] = 'Kategori maksimal 100 karakter.';
    }

    if ($ringkasan === '') {
        $errors[] = 'Ringkasan wajib diisi.';
    } elseif (mb_strlen($ringkasan) > 255) {
        $errors[] = 'Ringkasan maksimal 255 karakter.';
    }

    if ($isi === '') {
        $errors[] = 'Isi artikel wajib diisi.';
    }

    // 4. Simpan ke database jika validasi lolos
    if (empty($errors)) {
        if (empty($koneksi)) {
            $errors[] = 'Koneksi database tidak tersedia. Pastikan Laragon MySQL aktif.';
        } else {
            $sql = "INSERT INTO artikel (judul, kategori, ringkasan, isi) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssss', $judul, $kategori, $ringkasan, $isi);
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);

                    set_flash('sukses', 'Artikel berhasil ditambahkan.');
                    header('Location: artikel.php');
                    exit;
                } else {
                    $errors[] = 'Gagal menyimpan artikel: ' . mysqli_stmt_error($stmt);
                    mysqli_stmt_close($stmt);
                }
            } else {
                $errors[] = 'Terjadi kesalahan sistem pada database.';
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

    <main>

        <section class="card-box form-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #edf1ee;">
                <div>
                    <div class="accent-bar"></div>
                    <h2>Tambah Artikel Baru</h2>
                </div>
                <a href="artikel.php#kelola-artikel" class="btn btn-secondary btn-sm">&larr; Kembali</a>
            </div>

            <!-- Tampilkan Pesan Kesalahan Validasi -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <strong>Peringatan:</strong>
                    <ul style="margin: 8px 0 0 16px; padding: 0;">
                        <?php foreach ($errors as $err): ?>
                            <li><?= e($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Formulir Tambah Artikel (Sederhana & Rapi) -->
            <form action="tambah.php" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="judul" class="form-label">Judul Artikel <span class="required">*</span></label>
                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        class="form-control"
                        maxlength="150"
                        placeholder="Masukkan judul artikel"
                        value="<?= e($judul) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="kategori" class="form-label">Kategori <span class="required">*</span></label>
                    <input
                        type="text"
                        list="daftar-kategori"
                        id="kategori"
                        name="kategori"
                        class="form-control"
                        maxlength="100"
                        placeholder="Masukkan kategori artikel"
                        value="<?= e($kategori) ?>"
                        required
                    >
                    <datalist id="daftar-kategori">
                        <?php foreach (daftar_kategori() as $kat): ?>
                            <option value="<?= e($kat) ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-group">
                    <label for="ringkasan" class="form-label">Ringkasan <span class="required">*</span></label>
                    <textarea
                        id="ringkasan"
                        name="ringkasan"
                        class="form-control"
                        rows="3"
                        maxlength="255"
                        placeholder="Masukkan ringkasan artikel"
                        required
                    ><?= e($ringkasan) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="isi" class="form-label">Isi Artikel <span class="required">*</span></label>
                    <textarea
                        id="isi"
                        name="isi"
                        class="form-control"
                        rows="10"
                        placeholder="Masukkan isi lengkap artikel"
                        required
                    ><?= e($isi) ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                    <a href="artikel.php#kelola-artikel" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </section>

    </main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
