# Taman Pemakaman Mount Carmel — Sistem Manajemen Operasional & Transaksi

Sistem Informasi Manajemen Operasional Taman Pemakaman **Mount Carmel** adalah aplikasi berbasis web yang dirancang khusus untuk memfasilitasi seluruh alur bisnis penjualan, pemesanan, verifikasi pembayaran, administrasi pemakaman, hingga penerbitan sertifikat lahan secara terintegrasi.

Aplikasi ini dibangun menggunakan framework **Laravel 12** dengan antarmuka pengguna premium menggunakan **Tailwind CSS** dan **Alpine.js**.

---

## 👥 Hak Akses & Fitur Utama

Sistem ini memiliki 5 (lima) peran pengguna (*roles*) dengan tanggung jawab spesifik:

### 1. Pembeli (Customer / End-User)
*   **Browsing Lahan & Cluster**: Melihat katalog zona cluster pemakaman (Muslim & Non-Muslim) beserta unit lahan yang tersedia secara real-time.
*   **Pemesanan Online**: Melakukan reservasi unit lahan secara langsung dengan mengunggah KTP pemesan dan memilih skema pembayaran (Tunai atau Cicilan).
*   **Input Data Jenazah**: Mengisi data jenazah (nama, tanggal pemakaman, dan nomor slot) secara mandiri untuk lahan yang sudah dipesan.
*   **Konfirmasi Pembayaran**: Mengunggah bukti transfer bank untuk pembayaran Uang Muka (DP), cicilan berkala, maupun pelunasan tunai.
*   **Tanda Tangan Elektronik**: Membubuhkan tanda tangan digital pada profil pribadi untuk verifikasi dokumen sertifikat lahan.

### 2. Marketing
*   **Manajemen Pelanggan**: Mengelola basis data Pembeli (CRUD Akun Pembeli).
*   **Pendaftaran Pemesanan**: Membantu pembeli melakukan reservasi unit lahan secara offline/melalui bantuan agen marketing.
*   **Manajemen Cluster**: Mengelola pembagian wilayah zona cluster pemakaman (Muslim / Non-Muslim).
*   **Laporan Reservasi**: Memantau perkembangan status reservasi dan status pembayaran terintegrasi pelanggan.
*   **Dokumen Sertifikat**: Mengunggah berkas sertifikat lahan untuk kemudian diserahkan kepada Manajer untuk ditandatangani.

### 3. Manajer (Manager)
*   **Monitoring Eksekutif**: Memantau performa penjualan, ketersediaan sisa kavling lahan, dan distribusi pemakaman.
*   **Approval & Tanda Tangan Sertifikat**: Melakukan verifikasi dan memberikan tanda tangan digital persetujuan pada Sertifikat Lahan yang diunggah oleh Marketing.
*   **Pusat Laporan PDF**: Mencetak laporan rekapitulasi komprehensif (Laporan Lahan, Laporan Pembeli, Laporan Cluster, Laporan Reservasi, Laporan Jenazah) ke format PDF.

### 4. Accounting
*   **Kelola Lahan & Harga (CRUD)**: Mengelola master data unit lahan pemakaman, termasuk menambah unit baru, memperbarui ukuran/kapasitas, menetapkan harga jual resmi, hingga menghapus unit lahan.
*   **Verifikasi Pembayaran**: Melakukan validasi bukti transfer bank yang diunggah oleh Pembeli (menyetujui atau menolak transaksi).
*   **Input Pembayaran Langsung**: Menginput transaksi pembayaran secara manual (misal pembayaran via kasir kantor) yang secara otomatis akan langsung disetujui (*Lunas*) dan memperbarui sisa tagihan serta status unit lahan.
*   **Laporan Keuangan**: Mengakses Laporan Pembayaran Masuk dan Laporan Reservasi serta mengekspornya ke berkas cetak PDF.

### 5. Koordinator Lapangan (Field Coordinator)
*   **CRUD Cluster & Lahan**: Mengelola daftar cluster dan unit lahan fisik di lapangan (tanpa fitur unggah foto progres).
*   **Validasi Ketersediaan Fisik**: Memeriksa dan mengonfirmasi secara fisik apakah unit lahan yang dipesan pembeli berstatus *Tersedia* (dapat digunakan) atau *Tidak Tersedia* (mengalami kendala geografis/teknis di lapangan).

---

## 🛠️ Spesifikasi Teknologi

*   **Backend**: PHP >= 8.2 & Laravel 12.x
*   **Frontend**: Blade Templating, Tailwind CSS, Alpine.js
*   **Database**: MySQL / MariaDB
*   **PDF Engine**: Barryvdh Laravel DomPDF (Wrapper `dompdf` untuk ekspor laporan & cetak invoice)
*   **OTP Server**: Sistem verifikasi kode OTP berbasis sesi/log (untuk otentikasi pendaftaran akun pembeli)

---

## 🚀 Panduan Instalasi & Pengembangan

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

### 1. Klon Repositori
```bash
git clone <url-repository>
cd mount-carmel
```

### 2. Instalasi Dependensi PHP & JS
Gunakan Composer untuk menginstal paket dependensi backend, dan NPM untuk frontend:
```bash
composer install
npm install
```

### 3. Konfigurasi Environment File
Salin file konfigurasi `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Sesuaikan konfigurasi koneksi database Anda di dalam file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mount_carmel
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Migrasi & Seeding Database
Jalankan migrasi tabel database beserta seeder bawaan untuk membuat data awal dan akun demo:
```bash
php artisan migrate --seed
```

### 6. Jalankan Server Lokal
Jalankan server pengembangan Laravel dan compile aset frontend:
```bash
# Terminal 1: Menjalankan Laravel server
php artisan serve

# Terminal 2: Menjalankan Vite bundler
npm run dev
```
Aplikasi sekarang dapat diakses melalui browser di alamat `http://127.0.0.1:8000`.

---

## 🧪 Menjalankan Pengujian (Testing)

Proyek ini dilengkapi dengan suite pengujian otomatis menggunakan **Pest PHP**. Untuk menjalankan test:
```bash
php artisan test
```
Untuk menguji modul spesifik (misalnya modul Koordinator Lapangan):
```bash
php artisan test --filter=KoordinatorLapangan
```

---

## 📄 Lisensi

Sistem Informasi Mount Carmel ini dilisensikan secara internal untuk keperluan operasional **PT Taman Pemakaman Mount Carmel**.
