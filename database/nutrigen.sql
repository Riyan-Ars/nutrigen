-- ===================================================
-- Database: nutrigen
-- Proyek: NutriGen — Bersama Tuntaskan Stunting, Bangun Generasi Emas
-- Kompatibel dengan: MySQL 5.7+ / MariaDB 10.3+ / phpMyAdmin / HeidiSQL (Laragon)
-- ===================================================

CREATE DATABASE IF NOT EXISTS `nutrigen` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nutrigen`;

-- --------------------------------------------------------
-- Struktur Tabel: artikel
-- --------------------------------------------------------

DROP TABLE IF EXISTS `artikel`;
CREATE TABLE `artikel` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(150) NOT NULL,
  `kategori` VARCHAR(100) NOT NULL,
  `ringkasan` VARCHAR(255) NOT NULL,
  `isi` TEXT NOT NULL,
  `tanggal_dibuat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Data Awal: artikel edukasi gizi dan pencegahan stunting
-- --------------------------------------------------------

INSERT INTO `artikel` (`id`, `judul`, `kategori`, `ringkasan`, `isi`, `tanggal_dibuat`) VALUES
(1, 
 'Pentingnya 1000 Hari Pertama Kehidupan dalam Mencegah Stunting', 
 'Pencegahan Stunting', 
 '1000 Hari Pertama Kehidupan (HPK) adalah masa emas pertumbuhan anak mulai dari masa kehamilan hingga usia dua tahun untuk mencegah stunting.', 
 'Periode 1000 Hari Pertama Kehidupan (HPK) merupakan jendela kesempatan kritis dalam menentukan masa depan kesehatan dan kecerdasan seorang anak. Fase ini dihitung sejak awal pembuahan di dalam kandungan (270 hari) hingga anak berusia 2 tahun (730 hari).\r\n\r\nPada periode ini, otak anak berkembang dengan sangat pesat hingga mencapai 80% dari kapasitas otak dewasa. Kekurangan gizi kronis pada masa ini dapat memicu stunting, yaitu kondisi gagal tumbuh pada anak akibat kekurangan gizi dalam waktu lama sehingga tinggi badan anak lebih pendek dari standar usianya.\r\n\r\nLangkah pencegahan utama meliputi pemenuhan nutrisi ibu hamil (asam folat, zat besi, kalsium), pemberian ASI Eksklusif selama 6 bulan pertama, serta Makanan Pendamping ASI (MPASI) yang kaya protein hewani seperti telur, ikan, dan daging setelah usia 6 bulan.', 
 '2026-10-20 08:30:00'),

(2, 
 'Protein Hewani: Kunci Utama Nutrisi Tumbuh Kembang Optimal Anak', 
 'Nutrisi Anak & Balita', 
 'Kandungan asam amino esensial lengkap pada protein hewani terbukti efektif membantu pertambahan tinggi badan dan daya tahan tubuh balita.', 
 'Protein merupakan zat pembangun jaringan tubuh yang krusial bagi balita yang sedang dalam masa pertumbuhan pesat. Dibandingkan protein nabati, protein hewani memiliki profil asam amino esensial yang lebih lengkap dan daya cerna yang lebih tinggi.\r\n\r\nSumber protein hewani yang mudah didapat dan terjangkau antara lain telur ayam, hati ayam, ikan kembung, lele, serta susu. Telur misalnya, kaya akan kolin yang sangat dibutuhkan untuk perkembangan fungsi kognitif otak anak.\r\n\r\nKementerian Kesehatan RI menganjurkan pemberian minimal satu porsi sumber protein hewani pada setiap jadwal makan anak untuk membantu mencegah risiko gagal tumbuh dan anemia defisiensi besi.', 
 '2026-10-21 09:15:00'),

(3, 
 'Panduan Menu "Isi Piringku": Porsi Gizi Seimbang Keluarga Sehat', 
 'Pola Makan Sehat', 
 'Mengenal konsep Isi Piringku dari Kementerian Kesehatan sebagai panduan praktis porsi makan sehari-hari untuk seluruh anggota keluarga.', 
 'Konsep "Isi Piringku" menggantikan slogan lama 4 Sehat 5 Sempurna dengan penekanan pada proporsi porsi makan yang seimbang dalam satu piring saji.\r\n\r\nDalam satu piring makan, komposisi yang dianjurkan adalah:\r\n- 2/3 dari setengah piring berupa makanan pokok (karbohidrat seperti nasi, jagung, atau ubi).\r\n- 1/3 dari setengah piring berupa lauk-pauk (sumber protein hewani dan nabati).\r\n- 2/3 dari setengah piring lainnya berupa sayur-sayuran aneka warna.\r\n- 1/3 dari setengah piring lainnya berupa buah-buahan segar.\r\n\r\nSelain pembagian porsi, Isi Piringku juga menekankan pentingnya mencuci tangan pakai sabun, membatasi gula, garam, lemak (GGL), meminum air putih yang cukup (minimal 8 gelas sehari), dan beraktivitas fisik minimal 30 menit setiap hari.', 
 '2026-10-22 10:00:00'),

(4, 
 'Menjaga Kesehatan Ibu Hamil demi Generasi Bebas Stunting', 
 'Gizi Ibu Hamil', 
 'Kesehatan dan status gizi calon ibu memegang peranan penting dalam melahirkan generasi yang sehat, cerdas, dan bebas dari risiko stunting.', 
 'Kesehatan calon ibu dan ibu hamil merupakan fondasi utama pencegahan stunting sebelum bayi dilahirkan. Ibu hamil yang mengalami Kurang Energi Kronis (KEK) atau anemia memiliki risiko lebih tinggi melahirkan bayi dengan Berat Badan Lahir Rendah (BBLR).\r\n\r\nUntuk menjaga kehamilan yang sehat, ibu hamil disarankan untuk:\r\n1. Melakukan pemeriksaan kehamilan (ANC) secara rutin minimal 6 kali ke fasilitas kesehatan.\r\n2. Mengonsumsi Tablet Tambah Darah (TTD) minimal 90 tablet selama masa kehamilan.\r\n3. Memperhatikan asupan makanan dengan gizi seimbang dan ekstra kalori yang sehat.\r\n4. Menghindari paparan asap rokok dan menjaga kesehatan sanitasi lingkungan tempat tinggal.\r\n\r\nDengan menjaga kesehatan ibu sejak masa pra-konsepsi hingga masa menyusui, kita bersama-sama mewujudkan generasi emas Indonesia yang unggul dan berdaya saing.', 
 '2026-10-23 11:20:00');
