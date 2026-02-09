
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Sistem Manajemen Keanggotaan & Streaming Klub

Aplikasi berbasis web yang dibangun menggunakan **Laravel** untuk mengelola keanggotaan klub, jadwal pertandingan, dan layanan streaming berbayar. Sistem ini dirancang untuk memudahkan administrasi klub dalam mengelola anggota, pembayaran, dan konten eksklusif.

## 🚀 Fitur Utama

### 1. Manajemen Keanggotaan (Membership)
- **Registrasi & Verifikasi**: Pengguna dapat mendaftar dan melakukan verifikasi akun.
- **Kartu Anggota Digital**: Pembuatan dan unduh kartu anggota otomatis.
- **Tipe Keanggotaan**: Pengelolaan berbagai jenis keanggotaan.
- **Perpanjangan (Extension)**: Formulir perpanjangan masa aktif keanggotaan.
- **Ekspor Data**: Ekspor data anggota ke format PDF dan Excel.

### 2. Manajemen Pertandingan (Fixtures) & Klub
- **Jadwal Pertandingan**: Admin dapat mengelola jadwal pertandingan klub.
- **Data Klub**: Pengelolaan data klub lawan dan detail pertandingan.
- **Akses Streaming**: Anggota dengan langganan aktif dapat menonton pertandingan secara langsung atau on-demand.

### 3. Layanan Streaming & Langganan
- **Paket Streaming**: Pilihan paket langganan untuk akses konten streaming.
- **Verifikasi Pembayaran**: Sistem verifikasi bukti pembayaran manual atau otomatis (tergantung konfigurasi).
- **Pembatasan Akses**: Middleware untuk memastikan hanya pengguna yang berlangganan yang dapat mengakses konten tertentu.

### 4. Laporan & Keuangan
- **Laporan Pendapatan**: Rekapitulasi pendapatan dari pendaftaran dan langganan.
- **Laporan Keanggotaan**: Statistik pertumbuhan anggota.
- **Ekspor Laporan**: Fitur unduh laporan dalam format PDF dan Ecxel.

### 5. Role & Hak Akses
Aplikasi ini memiliki beberapa role pengguna:
- **Super Admin**: Akses penuh ke seluruh sistem, termasuk manajemen admin.
- **Admin**: Mengelola anggota, konten, dan laporan.
- **Member**: Mengakses dashboard member, riwayat pembayaran, dan konten streaming.

### 6. Fitur Tambahan
- **Pengumuman**: Sistem pengumuman untuk member.
- **Merchandise**: Katalog dan manajemen merchandise klub.
- **Manajemen User**: Reset password dan update email pengguna oleh admin.

## 🛠️ Teknologi yang Digunakan

- **Backend Framework**: [Laravel](https://laravel.com)
- **Frontend**: Blade Templates dengan [Tailwind CSS](https://tailwindcss.com)
- **Database**: MySQL
- **Build Tool**: Vite
- **Libraries Utama**:
    - `spatie/laravel-permission` (Manajemen Role)
    - `barryvdh/laravel-dompdf` (Generate PDF)
    - `maatwebsite/excel` (Ekspor Excel)

## ⚙️ Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lokal komputer Anda:

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/repository-anda.git
   cd repository-anda
   ```

2. **Install Dependencies**
   Pastikan Anda telah menginstal PHP dan Composer.
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database**
   Jalankan migrasi untuk membuat tabel database.
   ```bash
   php artisan migrate
   ```
   *(Opsional) Jika ada seeder:*
   ```bash
   php artisan db:seed
   ```

6. **Jalankan Aplikasi**
   Jalankan server lokal Laravel dan Vite secara bersamaan.
   ```bash
   php artisan serve
   npm run dev
   ```

7. **Akses Aplikasi**
   Buka browser dan kunjungi `http://localhost:8000`.

## 📄 Lisensi

Aplikasi ini bersifat open-source dan dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).
