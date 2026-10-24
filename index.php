<?php
/**
 * NutriGen — Halaman Utama
 * Menyajikan profil edukasi gizi dan daftar artikel terbaru dari MySQL
 */

require_once __DIR__ . '/includes/koneksi.php';
require_once __DIR__ . '/includes/functions.php';

$current_page = 'home';
$page_title = 'NutriGen — Bersama Tuntaskan Stunting, Bangun Generasi Emas';

// Ambil 3 artikel edukasi terbaru dari MySQL
$artikel_terbaru = [];
$ambil_error = null;

if (!empty($koneksi)) {
    $sql_terbaru = "SELECT id, judul, kategori, ringkasan, tanggal_dibuat FROM artikel ORDER BY tanggal_dibuat DESC, id DESC LIMIT 3";
    $result_terbaru = @mysqli_query($koneksi, $sql_terbaru);

    if ($result_terbaru) {
        while ($row = mysqli_fetch_assoc($result_terbaru)) {
            $artikel_terbaru[] = $row;
        }
        mysqli_free_result($result_terbaru);
    } else {
        $ambil_error = 'Tidak dapat mengambil artikel terbaru.';
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

    <!-- MAIN CONTENT -->
    <main>

        <?= render_flash() ?>

        <?php if (!empty($koneksi_error)): ?>
            <div class="alert alert-danger">
                <strong>Perhatian:</strong> <?= e($koneksi_error) ?>
            </div>
        <?php endif; ?>

        <!-- SECTION 1: TENTANG NUTRIGEN -->
        <section id="tentang">
            <div class="accent-bar"></div>
            <h2>Tentang NutriGen</h2>

            <p>
                NutriGen adalah sebuah konsep platform yang membantu pengguna
                mendapatkan informasi mengenai pola makan dan gaya hidup sehat.
                NutriGen dirancang agar informasi kesehatan dapat dipahami
                dengan lebih mudah oleh masyarakat.
            </p>

            <p>
                Dengan memahami kebutuhan nutrisi tubuh, seseorang dapat mulai
                membangun kebiasaan makan yang lebih baik dalam kehidupan
                sehari-hari.
            </p>

            <img
                class="hero-image"
                src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=1200&q=80"
                alt="Makanan sehat dan bergizi untuk pencegahan stunting"
            >

            <h3>Tujuan NutriGen</h3>

            <p>
                Tujuan NutriGen adalah memberikan informasi yang sederhana,
                praktis, dan mudah dipahami mengenai pentingnya menjaga pola
                makan serta menerapkan gaya hidup yang lebih sehat.
            </p>
        </section>

        <!-- SECTION 2: ARTIKEL EDUKASI DINAMIS DARI MYSQL -->
        <section id="artikel-terbaru">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 8px;">
                <div>
                    <div class="accent-bar"></div>
                    <h2>Artikel & Edukasi Gizi Terbaru</h2>
                </div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <a href="artikel.php" class="btn btn-outline btn-sm">Lihat Semua Artikel</a>
                    <a href="tambah.php" class="btn btn-primary btn-sm">+ Tulis Artikel</a>
                </div>
            </div>

            <p>
                Dapatkan wawasan terkini mengenai nutrisi penting, panduan tumbuh kembang anak, 
                serta strategi pencegahan stunting langsung dari database edukasi NutriGen.
            </p>

            <?php if (!empty($artikel_terbaru)): ?>
                <div class="article-grid">
                    <?php foreach ($artikel_terbaru as $item): ?>
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
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>Belum ada artikel edukasi yang dipublikasikan.</p>
                    <a href="tambah.php" class="btn btn-primary">+ Tambahkan Artikel Pertama</a>
                </div>
            <?php endif; ?>
        </section>

        <!-- SECTION 3: MANFAAT POLA MAKAN SEHAT -->
        <section id="manfaat">
            <div class="accent-bar"></div>
            <h2>Manfaat Pola Makan Sehat</h2>

            <p>
                Pola makan yang baik merupakan salah satu bagian penting dalam
                menjaga kebugaran tubuh. Mengonsumsi makanan dengan beragam
                kandungan nutrisi dapat membantu memenuhi kebutuhan tubuh.
            </p>

            <h3>Beberapa Kebiasaan Baik</h3>

            <!-- UNORDERED LIST -->
            <ul>
                <li>Mengonsumsi makanan yang beragam dan padat gizi.</li>
                <li>Memperbanyak konsumsi buah, sayuran, dan protein hewani.</li>
                <li>Minum air yang cukup dan menjaga hidrasi harian.</li>
                <li>Mengurangi konsumsi makanan olahan berlebihan.</li>
                <li>Menjaga jadwal makan secara teratur.</li>
            </ul>

            <h3>Kenapa Nutrisi Penting?</h3>

            <p>
                Nutrisi membantu tubuh mendapatkan energi dan mendukung berbagai
                fungsi tubuh. Oleh karena itu, memperhatikan makanan yang
                dikonsumsi merupakan langkah sederhana untuk memulai pola hidup
                yang lebih sehat.
            </p>
        </section>

        <!-- SECTION 4: CARA MEMULAI HIDUP SEHAT & TABEL MENU -->
        <section id="cara">
            <div class="accent-bar"></div>
            <h2>Cara Memulai Hidup Sehat</h2>

            <p>
                Memulai gaya hidup sehat tidak harus dilakukan secara langsung
                dalam perubahan besar. Kebiasaan kecil yang dilakukan secara
                konsisten dapat menjadi langkah awal yang baik.
            </p>

            <h3>Langkah-Langkah</h3>

            <!-- ORDERED LIST -->
            <ol>
                <li>Mulai memperhatikan makanan yang dikonsumsi setiap hari.</li>
                <li>Tambahkan buah dan sayuran dalam setiap menu harian.</li>
                <li>Pastikan tubuh mendapatkan cukup air putih bersih.</li>
                <li>Lakukan aktivitas fisik secara rutin minimal 30 menit.</li>
                <li>Evaluasi kebiasaan dan lakukan secara konsisten.</li>
            </ol>

            <h3>Contoh Menu Seimbang</h3>

            <!-- TABLE -->
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Contoh Menu</th>
                            <th>Kelompok Nutrisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sarapan</td>
                            <td>Telur, roti gandum, dan buah pepaya</td>
                            <td>Protein, karbohidrat, vitamin & serat</td>
                        </tr>
                        <tr>
                            <td>Makan Siang</td>
                            <td>Nasi, ayam panggang, sayur bening bayam</td>
                            <td>Karbohidrat, protein hewani, serat & zat besi</td>
                        </tr>
                        <tr>
                            <td>Camilan</td>
                            <td>Buah pisang atau kacang-kacangan rebus</td>
                            <td>Vitamin, mineral, lemak sehat</td>
                        </tr>
                        <tr>
                            <td>Makan Malam</td>
                            <td>Nasi, ikan kembung bumbu kuning, tumis buncis</td>
                            <td>Karbohidrat, omega-3, protein, serat</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 5: INFORMASI & KONTAK -->
        <section id="kontak">
            <div class="accent-bar"></div>
            <h2>Informasi & Kontak</h2>

            <p>
                Untuk mendapatkan informasi lebih lanjut mengenai pola hidup
                sehat dan pencegahan stunting, kamu dapat mengunjungi sumber informasi kesehatan
                terpercaya.
            </p>

            <h3>Link Informasi</h3>

            <p>
                Kunjungi
                <a
                    class="link"
                    href="https://www.who.int/"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    World Health Organization (WHO)
                </a>
                untuk mendapatkan informasi kesehatan global.
            </p>

            <p>
                Informasi kesehatan dan program penanganan stunting nasional dapat ditemukan melalui
                <a
                    class="link"
                    href="https://www.kemkes.go.id/"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Kementerian Kesehatan Republik Indonesia
                </a>.
            </p>
        </section>

    </main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
