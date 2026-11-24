# Aplikasi Sistem Informasi Manajemen Laundry (LaundryKu)
Proyek Ujian Asesmen Akhir Semester (ASAS) Konsentrasi Keahlian Rekayasa Perangkat Lunak (RPL) Kelas XII.

## Fitur Aplikasi
- **Autentikasi & Multi-Role:** Sistem Login dan Register dengan pemisahan peran hak akses **Admin** dan **Kasir**.
- **Dashboard Ringkasan:** Statistik jumlah layanan, cucian dalam proses, cucian selesai, estimasi total pendapatan, serta 5 transaksi terkini.
- **CRUD Paket Layanan:** Pengelolaan daftar paket cuci (Reguler Rp 7.000/kg, Ekspres Rp 12.000/kg, Superkilat Rp 25.000/kg). Khusus role Admin untuk modifikasi data.
- **Pencatatan Order Baru:** Pembuatan nomor nota otomatis, pemilihan paket layanan, input berat, serta kalkulasi harga otomatis.
- **Rekap Transaksi:** Filter status (Proses / Selesai), pencarian pelanggan/nota, dan tombol update status cepat satu kali klik.
- **Cetak Nota Pelanggan:** Halaman detail nota yang siap cetak (print ready).
- **Desain Responsif:** Tampilan adaptif untuk layar Komputer/Laptop (Desktop), Tablet, dan Smartphone (Mobile).

## Persyaratan Sistem
- PHP >= 8.2
- Composer
- Ekstensi SQLite / MySQL aktif

## Cara Menjalankan Aplikasi
1. Buka terminal pada folder proyek:
   ```bash
   cd app-laundry
   ```
2. Salin environment file (jika belum ada):
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```
3. Jalankan migration dan seeder database:
   ```bash
   php artisan migrate:fresh --seed
   ```
4. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
5. Buka di browser: `http://localhost:8000`

## Akun Demo Pengujian
- **Akun Admin:**
  - Email: `admin@laundry.test`
  - Password: `admin123`
- **Akun Kasir:**
  - Email: `kasir@laundry.test`
  - Password: `kasir123`
