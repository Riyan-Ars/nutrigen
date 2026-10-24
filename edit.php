<?php
/**
 * NutriGen — Ubah Artikel Edukasi (UPDATE)
 */

require_once __DIR__ . '/includes/koneksi.php';
require_once __DIR__ . '/includes/functions.php';

$current_page = 'artikel';
$page_title = 'Edit Artikel — NutriGen';

$errors = [];
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

if ($id <= 0) {
    set_flash('error', 'ID artikel tidak valid.');
    header('Location: artikel.php');
    exit;
}

// Ambil data artikel yang ada dari database
$artikel = null;
if (!empty($koneksi)) {
    $sql_cari = "SELECT id, judul, kategori, ringkasan, isi FROM artikel WHERE id = ? LIMIT 1";
    $stmt_cari = mysqli_prepare($koneksi, $sql_cari);
    if ($stmt_cari) {
        mysqli_stmt_bind_param($stmt_cari, 'i', $id);
        mysqli_stmt_execute($stmt_cari);
        $res = mysqli_stmt_get_result($stmt_cari);
        $artikel = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt_cari);
    }
}

if (!$artikel) {
    set_flash('error', 'Artikel tidak ditemukan.');
    header('Location: artikel.php');
    exit;
}

$judul = $artikel['judul'];
$kategori = $artikel['kategori'];
$ringkasan = $artikel['ringkasan'];
$isi = $artikel['isi'];

// Proses pembaruan saat formulir dikirim via POST
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

    // 3. Validasi
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

    // 4. Update data jika validasi lolos
    if (empty($errors)) {
        if (empty($koneksi)) {
            $errors[] = 'Koneksi database tidak tersedia.';
        } else {
            $sql_update = "UPDATE artikel SET judul = ?, kategori = ?, ringkasan = ?, isi = ? WHERE id = ?";
            $stmt_update = mysqli_prepare($koneksi, $sql_update);

            if ($stmt_update) {
                mysqli_stmt_bind_param($stmt_update, 'ssssi', $judul, $kategori, $ringkasan, $isi, $id);
                if (mysqli_stmt_execute($stmt_update)) {
                    mysqli_stmt_close($stmt_update);

                    set_flash('sukses', 'Perubahan artikel berhasil disimpan.');
                    header('Location: detail.php?id=' . $id);
                    exit;
                } else {
                    $errors[] = 'Gagal memperbarui artikel: ' . mysqli_stmt_error($stmt_update);
                    mysqli_stmt_close($stmt_update);
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
                    <h2>Edit Artikel</h2>
                </div>
                <a href="detail.php?id=<?= (int)$id ?>" class="btn btn-secondary btn-sm">&larr; Kembali</a>
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

            <!-- Formulir Edit Artikel (Sederhana & Rapi) -->
            <form action="edit.php?id=<?= (int)$id ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int)$id ?>">

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
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="detail.php?id=<?= (int)$id ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </section>

    </main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
