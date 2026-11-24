<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::latest()->get();
        return view('layanan.index', compact('layanans'));
    }

    public function create()
    {
        // Hanya admin yang boleh menambah layanan baru
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('layanan.index')->with('error', 'Hanya Admin yang dapat menambah layanan.');
        }

        return view('layanan.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan');
        }

        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'harga_per_kg' => 'required|numeric|min:100',
            'durasi' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        Layanan::create($validated);

        return redirect()->route('layanan.index')->with('success', 'Paket layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('layanan.index')->with('error', 'Hanya Admin yang dapat mengedit layanan.');
        }

        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan');
        }

        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'harga_per_kg' => 'required|numeric|min:100',
            'durasi' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $layanan->update($validated);

        return redirect()->route('layanan.index')->with('success', 'Paket layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('layanan.index')->with('error', 'Hanya Admin yang dapat menghapus layanan.');
        }

        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Paket layanan berhasil dihapus.');
    }
}
