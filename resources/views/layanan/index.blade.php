@extends('layouts.app')

@section('title', 'Data Layanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">Daftar Paket Layanan</h4>
        <p class="text-muted small mb-0">Kelola daftar pilihan paket laundry beserta tarif harga per kilogram.</p>
    </div>
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('layanan.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Layanan Baru</span>
        </a>
    @else
        <span class="badge bg-secondary p-2">
            <i class="bi bi-info-circle me-1"></i> Mode Kasir (Hanya Melihat)
        </span>
    @endif
</div>

<div class="row g-3">
    @forelse($layanans as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 bg-white">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold text-dark mb-0">{{ $item->nama_layanan }}</h5>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                            <i class="bi bi-clock me-1"></i>{{ $item->durasi }}
                        </span>
                    </div>
                    
                    <div class="my-3">
                        <span class="fs-4 fw-bold text-primary">Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</span>
                        <span class="text-muted small">/ kg</span>
                    </div>

                    <p class="text-muted small flex-grow-1">
                        {{ $item->deskripsi ?: 'Tidak ada keterangan tambahan untuk paket ini.' }}
                    </p>

                    @if(Auth::user()->role === 'admin')
                        <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                            <a href="{{ route('layanan.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square me-1"></i> Ubah
                            </a>
                            <form action="{{ route('layanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini? Data transaksi terkait mungkin terpengaruh.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card bg-white p-4 text-center text-muted">
                <i class="bi bi-inbox fs-1 mb-2"></i>
                <p>Belum ada data paket layanan yang tersedia.</p>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('layanan.create') }}" class="btn btn-primary btn-sm mx-auto">Tambah Layanan Pertama</a>
                @endif
            </div>
        </div>
    @endforelse
</div>
@endsection
