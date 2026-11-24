<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['layanan', 'user'])->latest();

        // Filter status jika ada
        if ($request->filled('status')) {
            $query->where('status_pengerjaan', $request->status);
        }

        // Pencarian pelanggan atau nomor invoice
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('nama_pelanggan', 'like', "%{$cari}%")
                  ->orWhere('kode_invoice', 'like', "%{$cari}%")
                  ->orWhere('no_hp', 'like', "%{$cari}%");
            });
        }

        $transaksis = $query->paginate(10)->withQueryString();

        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $layanans = Layanan::all();
        if ($layanans->isEmpty()) {
            if (Auth::check()) {
                return redirect()->route('layanan.index')->with('error', 'Silakan buat data layanan terlebih dahulu.');
            }
            return redirect()->route('login')->with('error', 'Layanan laundry belum tersedia.');
        }

        // Generate nomor invoice otomatis TRX-YYYYMMDD-XXXX
        $today = date('Ymd');
        $countToday = Transaksi::whereDate('created_at', today())->count() + 1;
        $autoInvoice = 'TRX-' . $today . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT);

        return view('transaksi.create', compact('layanans', 'autoInvoice'));
    }

    public function store(Request $request)
    {
        // Jika kode invoice kosong (order publik), generate otomatis
        if (!$request->filled('kode_invoice')) {
            $today = date('Ymd');
            $countToday = Transaksi::whereDate('created_at', today())->count() + 1;
            $request->merge([
                'kode_invoice' => 'TRX-' . $today . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT)
            ]);
        }

        $validated = $request->validate([
            'kode_invoice' => 'required|string|unique:transaksis,kode_invoice',
            'nama_pelanggan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'layanan_id' => 'required|exists:layanans,id',
            'berat' => 'nullable|numeric|min:0.1',
            'status_pembayaran' => 'nullable|in:Lunas,Belum Lunas',
            'catatan' => 'nullable|string|max:255',
        ]);

        $layanan = Layanan::findOrFail($validated['layanan_id']);
        $berat = isset($validated['berat']) ? (float)$validated['berat'] : 1.0;
        $totalHarga = (int) round($berat * $layanan->harga_per_kg);
        
        // Pelanggan umum default bayar saat ambil cucian (Belum Lunas)
        $statusPembayaran = $validated['status_pembayaran'] ?? 'Belum Lunas';

        $transaksi = Transaksi::create([
            'kode_invoice' => $validated['kode_invoice'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'no_hp' => $validated['no_hp'],
            'layanan_id' => $layanan->id,
            'berat' => $berat,
            'total_harga' => $totalHarga,
            'status_pengerjaan' => 'Proses', // Default transaksi baru: Proses
            'status_pembayaran' => $statusPembayaran,
            'catatan' => $validated['catatan'] ?? null,
            'user_id' => Auth::id(), // Null jika dibuat oleh tamu/pelanggan
        ]);

        if (Auth::check()) {
            return redirect()->route('transaksi.index')->with('success', 'Order transaksi baru berhasil dicatat.');
        }

        return redirect()->route('transaksi.show', $transaksi->id)->with('success', 'Pesanan cucian Anda berhasil dibuat! Simpan nomor faktur untuk bukti pengambilan.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['layanan', 'user']);
        return view('transaksi.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'status_pengerjaan' => 'required|in:Proses,Selesai',
        ]);

        $transaksi->update([
            'status_pengerjaan' => $validated['status_pengerjaan'],
        ]);

        return back()->with('success', "Status cucian {$transaksi->kode_invoice} berhasil diubah menjadi {$validated['status_pengerjaan']}.");
    }

    public function updatePembayaran(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas',
        ]);

        $transaksi->update([
            'status_pembayaran' => $validated['status_pembayaran'],
        ]);

        return back()->with('success', "Status pembayaran {$transaksi->kode_invoice} berhasil diperbarui.");
    }

    public function destroy(Transaksi $transaksi)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Hanya Admin yang dapat menghapus data transaksi.');
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil dihapus.');
    }
}
