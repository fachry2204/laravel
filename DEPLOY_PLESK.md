# Panduan Installasi Tokomasivers di Plesk Hosting

Berikut adalah langkah-langkah lengkap untuk menginstall aplikasi Laravel Tokomasivers di panel hosting Plesk.

## 1. Persiapan File
Pastikan Anda memiliki semua file source code. Anda bisa menguploadnya nanti menggunakan Git (Rekomendasi) atau ZIP via File Manager.

## 2. Setup Domain & Document Root
1. Login ke **Plesk Panel**.
2. Masuk ke menu **Websites & Domains**.
3. Klik **Hosting Settings** pada domain yang ingin digunakan.
4. Ubah **Document Root** agar mengarah ke folder `public`.
   * Contoh: `httpdocs/tokomasivers/public` (jika install di subfolder) atau `httpdocs/public` (jika root).
   * **PENTING**: Laravel harus dijalankan dari folder `public` demi keamanan.

## 3. Upload File
Ada dua cara umum:

### Cara A: Menggunakan Git (Direkomendasikan)
1. Di Plesk, klik menu **Git**.
2. Tambahkan repository remote (GitHub/GitLab) Anda.
3. Plesk akan menarik (pull) kode terbaru ke server.

### Cara B: Upload ZIP (Manual)
1. Compress folder project `tokomasivers` di komputer Anda menjadi `.zip`.
2. Di Plesk, buka **File Manager**.
3. Upload file `.zip` ke folder tujuan (misal `httpdocs`).
4. Extract file tersebut.

## 4. Install Dependencies (Composer)
1. Di Plesk, buka menu **PHP Composer**.
2. Klik **Scan** jika project belum terdeteksi.
3. Setelah terdeteksi, klik **Install** atau **Update** untuk mengunduh library di folder `vendor`.
   * *Jika menu PHP Composer tidak ada*:
     1. Buka menu **Terminal** (SSH) di Plesk.
     2. Masuk ke direktori project: `cd httpdocs/tokomasivers`
     3. Jalankan: `composer install --optimize-autoloader --no-dev`

## 5. Konfigurasi Database
1. Buka menu **Databases** di Plesk.
2. Klik **Add Database**.
3. Buat database baru (misal: `tokomasivers_db`) dan user database (misal: `tokomasivers_user`).
4. Catat nama database, username, dan password.
5. Klik **Import Dump** untuk mengupload struktur database jika Anda sudah memilikinya, ATAU gunakan migration nanti.

## 6. Konfigurasi Environment (.env)
1. Di File Manager, cari file `.env.example`.
2. Rename menjadi `.env` (atau copy menjadi file baru bernama `.env`).
3. Edit file `.env` dan sesuaikan konfigurasi:
   ```env
   APP_NAME=Tokomasivers
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domain-anda.com

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=nama_database_plesk_anda
   DB_USERNAME=user_database_plesk_anda
   DB_PASSWORD=password_database_plesk_anda
   
   # Konfigurasi RajaOngkir & Tripay
   RAJAONGKIR_API_KEY=key_anda
   TRIPAY_API_KEY=key_anda
   ```

## 7. Setup Akhir via Terminal (SSH)
Buka menu **Terminal** di Plesk dan jalankan perintah berikut di dalam folder project:

1. **Generate Key Aplikasi**:
   ```bash
   php artisan key:generate
   ```

2. **Jalankan Migrasi Database** (Membuat tabel):
   ```bash
   php artisan migrate --force
   ```
   *Opsional: Tambahkan `--seed` jika ingin mengisi data awal (admin default).*

3. **Symlink Storage** (Agar gambar bisa diakses publik):
   ```bash
   php artisan storage:link
   ```

4. **Cache Configuration** (Untuk performa):
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## 8. Troubleshooting Umum
*   **Permission Error**: Pastikan folder `storage` dan `bootstrap/cache` memiliki permission `775` atau `777`. Di File Manager Plesk, klik kanan folder -> **Change Permissions**.
*   **500 Server Error**: Cek file `storage/logs/laravel.log` untuk detail error. Biasanya karena `.env` salah konfigurasi.
*   **PHP Version**: Pastikan versi PHP di Plesk (Hosting Settings) sesuai dengan `composer.json` (minimal PHP 8.2 untuk Laravel 11/12).

Selamat! Tokomasivers seharusnya sudah online.
