# NutriGen — Bersama Tuntaskan Stunting, Bangun Generasi Emas

Website edukasi gizi dan pencegahan stunting dinamis berbasis **PHP Native** dan **MySQL**, dirancang khusus untuk berjalan di lingkungan web server lokal **Laragon**.

---

## 📋 Deskripsi Proyek

NutriGen adalah platform edukasi interaktif yang bertujuan memberikan pemahaman mendalam mengenai pentingnya gizi seimbang, pemenuhan nutrisi balita dan ibu hamil, serta pencegahan stunting sejak 1000 Hari Pertama Kehidupan (HPK). 

Website ini telah dikembangkan dari HTML/CSS statis menjadi aplikasi web dinamis dengan fitur **CRUD (Create, Read, Update, Delete)** lengkap menggunakan **PHP Native** dan **MySQLi**, **100% bebas dari ketergantungan JavaScript** sesuai standar tugas mata kuliah Pemrograman Web.

---

## 🗂️ Struktur Folder Proyek

```text
nutrigen/
│
├── index.php                 # Halaman utama dengan integrasi artikel dinamis dari MySQL
├── artikel.php               # Halaman katalog artikel dan tabel manajemen data (CRUD Hub)
├── tambah.php                # Formulir & proses penambahan artikel baru (Create)
├── edit.php                  # Formulir & proses pengubahan artikel (Update)
├── hapus.php                 # Handler pemrosesan penghapusan artikel via POST (Delete)
├── detail.php                # Halaman baca lengkap artikel berdasarkan ID (Read Detail)
│
├── includes/
│   ├── koneksi.php           # Konfigurasi koneksi MySQLi Native & penanganan error aman
│   ├── header.php            # Kerangka HTML awal, Google Fonts, dan elemen header konsisten
│   ├── navbar.php            # Navigasi sticky dengan active status server-side PHP
│   ├── footer.php            # Elemen footer bersama dengan identitas pembuat (tanpa JS)
│   └── functions.php         # Fungsi pembantu (XSS escaper, CSRF token, format tanggal ID)
│
├── assets/
│   ├── css/
│   │   └── style.css         # Stylesheet utama (desain hijau bertema gizi & styling CRUD)
│   └── images/               # Direktori penyimpanan aset gambar lokal
│
├── database/
│   └── nutrigen.sql          # Skema database MySQL dan data awal edukasi stunting
│
└── README.md                 # Petunjuk instalasi, konfigurasi, dan panduan penggunaan
```

---

## 💻 Kebutuhan Sistem & Teknologi

* **Web Server**: Apache 2.4+ (tersedia bawaan di Laragon)
* **Database Server**: MySQL 5.7+ atau MariaDB 10.3+
* **PHP Engine**: PHP 7.4 / 8.0 / 8.1 / 8.2 / 8.3 Native (ekstensi `mysqli` dan `session` aktif)
* **Lingkungan Pengembangan**: [Laragon](https://laragon.org/) for Windows
* **Database Manager**: phpMyAdmin atau HeidiSQL (bawaan Laragon)
* **Batasan Teknologi**: **Tanpa JavaScript**, tanpa library/framework CSS/JS eksternal, tanpa framework PHP.

---

## 🚀 Panduan Instalasi & Menjalankan di Laragon

Ikuti langkah-langkah mudah berikut untuk menjalankan proyek NutriGen di komputer Anda:

### 1. Penempatan Folder Proyek
Pastikan folder proyek berada pada direktori web root Laragon:
```text
C:\laragon\www\nutrigen\
```

### 2. Jalankan Laragon
* Buka aplikasi **Laragon**.
* Klik tombol **Start All** untuk mengaktifkan service **Apache** dan **MySQL**.

### 3. Impor Database MySQL
Pilih salah satu metode berikut (phpMyAdmin atau HeidiSQL):

#### Opsi A: Menggunakan HeidiSQL (Aplikasi Bawaan Laragon)
1. Pada jendela Laragon, klik tombol **Database** (akan membuka HeidiSQL).
2. Klik tombol **Open** (koneksi default Laragon: Host `127.0.0.1`, User `root`, Password kosong).
3. Klik menu **File** &rarr; **Load SQL file...** (atau tekan `Ctrl + O`).
4. Cari dan pilih file `database/nutrigen.sql` dari folder proyek:
   ```text
   C:\laragon\www\nutrigen\database\nutrigen.sql
   ```
5. Tekan tombol **Execute SQL** (ikon segitiga biru atau tombol `F9`).
6. Database `nutrigen` beserta tabel `artikel` dan 4 data artikel awal berhasil dibuat!

#### Opsi B: Menggunakan phpMyAdmin (Jika Terpasang di Browser)
1. Buka browser dan akses alamat: `http://localhost/phpmyadmin/`
2. Klik tab **Import** pada menu atas.
3. Klik **Choose File** / **Pilih File**, lalu arahkan ke `database/nutrigen.sql`.
4. Gulir ke bawah dan klik tombol **Import** / **Kirim**.
5. Database `nutrigen` akan otomatis terbuat dan terisi.

### 4. Periksa Konfigurasi Database
Secara default, Laragon menggunakan konfigurasi berikut pada file `includes/koneksi.php`:
* **Host**: `localhost`
* **Username**: `root`
* **Password**: `""` (kosong)
* **Database**: `nutrigen`

Jika MySQL Anda memiliki kata sandi kustom, sesuaikan pada baris berikut di `includes/koneksi.php`:
```php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'password_anda';
$db_name = 'nutrigen';
```

### 5. Akses Website di Browser
Buka browser favorit Anda dan kunjungi URL berikut:
```text
http://localhost/nutrigen/
```
atau jika fitur Pretty URL Laragon aktif:
```text
http://nutrigen.test/
```

---

## 🛠️ Fitur & Pengujian CRUD

Semua operasi CRUD telah diuji dan berfungsi secara penuh:

| Operasi | Halaman | Deskripsi & Validasi |
|---|---|---|
| **READ (Utama)** | `index.php` | Menampilkan 3 artikel edukasi terbaru dari MySQL secara dinamis. |
| **READ (Katalog)** | `artikel.php` | Menampilkan grid kartu artikel serta tabel manajemen seluruh data. |
| **READ (Detail)** | `detail.php?id=X` | Membaca isi lengkap artikel berdasarkan ID dengan penanganan ID tidak ditemukan. |
| **CREATE** | `tambah.php` | Formulir tambah artikel dengan validasi server-side, perlindungan CSRF, dan prepared statements. |
| **UPDATE** | `edit.php?id=X` | Memuat data lama ke dalam form, memvalidasi input, dan memperbarui MySQL. |
| **DELETE** | `hapus.php` | Menghapus artikel secara aman **hanya via metode POST** dilengkapi token CSRF (mencegah penghapusan via GET). |

---

## 🛡️ Aspek Keamanan yang Diterapkan

1. **Prepared Statements (MySQLi Parameterized Queries)**: Seluruh query `SELECT`, `INSERT`, `UPDATE`, dan `DELETE` yang menerima masukan pengguna menggunakan prepared statements untuk mencegah serangan **SQL Injection**.
2. **Sanitasi Output XSS**: Seluruh output yang ditampilkan ke browser dibersihkan menggunakan fungsi `htmlspecialchars($teks, ENT_QUOTES, 'UTF-8')` melalui helper `e()`.
3. **Proteksi CSRF (Cross-Site Request Forgery)**: Formulir tambah, edit, dan hapus dilindungi dengan token acak 32-byte berbasis PHP Session (`csrf_token()` dan `csrf_verify()`).
4. **Metode POST untuk Mutasi Data**: Operasi perubahan data tidak dapat dieksekusi melalui URL `GET`. Tombol hapus menggunakan form POST khusus.
5. **Penanganan Error Aman**: Kesalahan koneksi basis data ditangani secara elegan tanpa memperlihatkan nama pengguna, kata sandi, atau struktur query internal kepada pengunjung website.
6. **Validasi Server-Side Ketat**: Panjang karakter, tipe data integer ID, dan kelengkapan field divalidasi langsung di sisi server PHP.

---

## 🎨 Karakteristik Desain Visual NutriGen

* **Palet Warna**: Gradasi hijau botol (`#1a5638` ke `#0c2d1c`), aksen hijau daun (`#2e7d5b`), dan latar belakang netral abu-abu lembut (`#f5f5f7`).
* **Tipografi**: Menggunakan kombinasi font modern Google Fonts **Plus Jakarta Sans** (teks judul) dan **Inter** (bacaan teks tubuh).
* **Navigasi Sticky**: Tetap berada di bagian atas layar saat pengguna menggulir halaman, dilengkapi status tautan aktif server-side.
* **Komponen Card & Table**: Sudut membulat (*rounded corners*), elevasi bayangan lembut, dan tabel data berheader gradasi hijau tua.
* **Responsif**: Tampilan tetap proporsional dan nyaman diakses baik pada perangkat desktop, tablet, maupun layar ponsel (mobile).
* **Zero JavaScript**: Seluruh interaktivitas tombol, formulir, alert, dan tabel berjalan murni dengan HTML5 dan CSS3.

---

## 👤 Identitas Pembuat

* **Nama**: RIYAN ARYA SYAHPUTRA
* **Program Studi**: Teknologi Informasi
* **Mata Kuliah**: Pemrograman Web
* **Tahun**: 2026
* **Hak Cipta**: &copy; 2026 NutriGen. All Rights Reserved.
