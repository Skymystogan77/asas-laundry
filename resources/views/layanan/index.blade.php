@extends('layouts.app')

@section('title', 'Data Layanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-1">Paket Layanan</h5>
        <div class="text-muted small">Daftar tarif dan durasi cuci pakaian per kilogram.</div>
    </div>
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('layanan.create') }}" class="btn-app-primary">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Layanan</span>
        </a>
    @else
        <span class="badge bg-light text-secondary border px-2 py-1 small">
            <i class="bi bi-eye me-1"></i> Mode Kasir (Lihat Saja)
        </span>
    @endif
</div>

<div class="row g-3">
    @forelse($layanans as $item)
        <div class="col-md-6 col-lg-4">
            <div class="app-card h-100 p-3 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="fw-bold text-dark mb-0">{{ $item->nama_layanan }}</h6>
                    <span class="status-chip chip-lunas">
                        <i class="bi bi-clock me-1"></i>{{ $item->durasi }}
                    </span>
                </div>

                <div class="my-2 p-2 bg-light rounded text-center">
                    <span class="fs-4 fw-bold text-dark">Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</span>
                    <span class="text-muted small">/ kg</span>
                </div>

                <p class="text-muted small flex-grow-1 mb-3" style="font-size: 0.82rem;">
                    {{ $item->deskripsi ?: 'Tidak ada keterangan khusus untuk paket ini.' }}
                </p>

                @if(Auth::user()->role === 'admin')
                    <div class="pt-2 border-top d-flex gap-2 justify-content-end">
                        <a href="{{ route('layanan.edit', $item->id) }}" class="btn-app-light btn-sm py-1 px-2" style="font-size: 0.8rem;">
                            <i class="bi bi-pencil me-1"></i> Ubah
                        </a>
                        <form action="{{ route('layanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2" style="font-size: 0.8rem;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="app-card p-4 text-center text-muted small">
                Belum ada data paket layanan.
            </div>
        </div>
    @endforelse
</div>
@endsection
