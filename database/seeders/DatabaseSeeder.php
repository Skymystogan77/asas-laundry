<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. User Admin & Kasir
        $admin = User::firstOrCreate(
            ['email' => 'admin@laundry.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $kasir = User::firstOrCreate(
            ['email' => 'kasir@laundry.test'],
            [
                'name' => 'Siti Kasir',
                'password' => Hash::make('kasir123'),
                'role' => 'kasir',
            ]
        );

        // 2. Layanan sesuai soal docx
        $layananReguler = Layanan::firstOrCreate(
            ['nama_layanan' => 'Reguler'],
            [
                'harga_per_kg' => 7000,
                'durasi' => '3-4 hari',
                'deskripsi' => 'Cuci bersih, setrika wangi, estimasi santai 3 sampai 4 hari.',
            ]
        );

        $layananEkspres = Layanan::firstOrCreate(
            ['nama_layanan' => 'Ekspres'],
            [
                'harga_per_kg' => 12000,
                'durasi' => '1-2 hari',
                'deskripsi' => 'Prioritas cuci cepat dan rapi, selesai dalam 1-2 hari.',
            ]
        );

        $layananSuperkilat = Layanan::firstOrCreate(
            ['nama_layanan' => 'Superkilat'],
            [
                'harga_per_kg' => 25000,
                'durasi' => '5 jam',
                'deskripsi' => 'Layanan darurat kilat, selesai hanya dalam kurun waktu 5 jam.',
            ]
        );

        // 3. Transaksi awal contoh
        Transaksi::firstOrCreate(
            ['kode_invoice' => 'TRX-20261124-001'],
            [
                'nama_pelanggan' => 'Budi Santoso',
                'no_hp' => '081234567890',
                'layanan_id' => $layananReguler->id,
                'berat' => 3.5,
                'total_harga' => 3.5 * 7000,
                'status_pengerjaan' => 'Proses',
                'status_pembayaran' => 'Lunas',
                'catatan' => 'Pakaian kantor, harap pisahkan kemeja putih.',
                'user_id' => $kasir->id,
            ]
        );

        Transaksi::firstOrCreate(
            ['kode_invoice' => 'TRX-20261124-002'],
            [
                'nama_pelanggan' => 'Rina Wijaya',
                'no_hp' => '085712349988',
                'layanan_id' => $layananEkspres->id,
                'berat' => 2.0,
                'total_harga' => 2.0 * 12000,
                'status_pengerjaan' => 'Selesai',
                'status_pembayaran' => 'Lunas',
                'catatan' => 'Dikerjakan kemarin sore.',
                'user_id' => $admin->id,
            ]
        );

        Transaksi::firstOrCreate(
            ['kode_invoice' => 'TRX-20261124-003'],
            [
                'nama_pelanggan' => 'Dimas Pratama',
                'no_hp' => '087899887766',
                'layanan_id' => $layananSuperkilat->id,
                'berat' => 1.5,
                'total_harga' => 1.5 * 25000,
                'status_pengerjaan' => 'Proses',
                'status_pembayaran' => 'Belum Lunas',
                'catatan' => 'Baju seragam olahraga mau dipakai nanti malam.',
                'user_id' => $kasir->id,
            ]
        );
    }
}
