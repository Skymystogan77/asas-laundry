<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;

// Preview helper untuk tangkapan layar
require __DIR__.'/preview.php';

// Halaman utama: jika sudah login ke dashboard, jika pelanggan umum langsung ke form order
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('transaksi.create');
});

// Autentikasi Pengguna
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Modul Order Publik & Nota (Bisa Diakses Langsung Tanpa Perlu Login)
Route::get('/order', [TransaksiController::class, 'create'])->name('order.public');
Route::get('/transaksi/baru', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');

// Area Khusus Petugas Kasir & Admin (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Internal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Modul Data Layanan (CRUD Master)
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/create', [LayananController::class, 'create'])->name('layanan.create');
    Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
    Route::get('/layanan/{layanan}/edit', [LayananController::class, 'edit'])->name('layanan.edit');
    Route::put('/layanan/{layanan}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{layanan}', [LayananController::class, 'destroy'])->name('layanan.destroy');

    // Modul Rekap Transaksi & Pengawasan Status (Internal)
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::patch('/transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.update-status');
    Route::patch('/transaksi/{transaksi}/pembayaran', [TransaksiController::class, 'updatePembayaran'])->name('transaksi.update-pembayaran');
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
});
