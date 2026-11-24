<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLayanan = Layanan::count();
        $totalTransaksi = Transaksi::count();
        $transaksiProses = Transaksi::where('status_pengerjaan', 'Proses')->count();
        $transaksiSelesai = Transaksi::where('status_pengerjaan', 'Selesai')->count();
        
        $totalPendapatan = Transaksi::where('status_pembayaran', 'Lunas')->sum('total_harga');

        // 5 transaksi terbaru
        $transaksiTerbaru = Transaksi::with('layanan')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalLayanan',
            'totalTransaksi',
            'transaksiProses',
            'transaksiSelesai',
            'totalPendapatan',
            'transaksiTerbaru'
        ));
    }
}
