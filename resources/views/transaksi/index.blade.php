@extends('layouts.app')

@section('title', 'Rekap Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">Rekap Transaksi Cucian</h4>
        <p class="text-muted small mb-0">Daftar seluruh nota pesanan laundry pelanggan yang masuk, diproses, dan selesai.</p>
    </div>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
        <i class="bi bi-plus-lg"></i>
        <span>Tambah Order Baru</span>
    </a>
</div>

{{-- Filter dan Pencarian --}}
<div class="card bg-white mb-4">
    <div class="card-body p-3">
        <form action="{{ route('transaksi.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control" name="cari" value="{{ request('cari') }}" placeholder="Cari nama pelanggan, nomor nota, atau HP...">
                </div>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status Pengerjaan</option>
                    <option value="Proses" {{ request('status') === 'Proses' ? 'selected' : '' }}>Sedang Proses</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai Dicuci</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-secondary w-100">Filter Data</button>
                @if(request()->hasAny(['cari', 'status']))
                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Transaksi --}}
<div class="card bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted small text-uppercase">
                <tr>
                    <th class="ps-3">Nota & Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Layanan & Berat</th>
                    <th>Total Biaya</th>
                    <th>Status Pengerjaan</th>
                    <th>Pembayaran</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $trx)
                    <tr>
                        <td class="ps-3">
                            <span class="fw-semibold text-primary">{{ $trx->kode_invoice }}</span>
                            <div class="text-muted small">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $trx->nama_pelanggan }}</div>
                            <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $trx->no_hp }}</div>
                        </td>
                        <td>
                            <div><span class="badge bg-light text-dark border">{{ $trx->layanan->nama_layanan ?? '-' }}</span></div>
                            <div class="text-muted small mt-1">{{ $trx->berat }} kg &times; Rp {{ number_format($trx->layanan->harga_per_kg ?? 0, 0, ',', '.') }}</div>
                        </td>
                        <td>
                            <span class="fw-bold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <form action="{{ route('transaksi.update-status', $trx->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                @if($trx->status_pengerjaan === 'Proses')
                                    <input type="hidden" name="status_pengerjaan" value="Selesai">
                                    <button type="submit" class="btn btn-sm badge badge-proses border-0 py-2 px-2" title="Klik untuk ubah menjadi Selesai" onclick="return confirm('Tandai cucian ini sudah SELESAI?')">
                                        <i class="bi bi-hourglass-split me-1"></i> Proses &rarr; Klik Selesai
                                    </button>
                                @else
                                    <input type="hidden" name="status_pengerjaan" value="Proses">
                                    <button type="submit" class="btn btn-sm badge badge-selesai border-0 py-2 px-2" title="Klik jika ingin kembalikan ke Proses">
                                        <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                    </button>
                                @endif
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('transaksi.update-pembayaran', $trx->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                @if($trx->status_pembayaran === 'Lunas')
                                    <input type="hidden" name="status_pembayaran" value="Belum Lunas">
                                    <button type="submit" class="btn btn-sm badge badge-lunas border-0 py-2 px-2" title="Klik untuk ubah status pembayaran">
                                        Lunas
                                    </button>
                                @else
                                    <input type="hidden" name="status_pembayaran" value="Lunas">
                                    <button type="submit" class="btn btn-sm badge badge-belum border-0 py-2 px-2" title="Klik untuk menandai Lunas">
                                        Belum Lunas &rarr; Lunasi
                                    </button>
                                @endif
                            </form>
                        </td>
                        <td class="text-end pe-3">
                            <div class="btn-group">
                                <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-secondary">
                                    Nota
                                </a>
                                @if(Auth::user()->role === 'admin')
                                    <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Hapus nota transaksi ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-x fs-2 d-block mb-2"></i>
                            Tidak ada data transaksi yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transaksis->hasPages())
        <div class="card-footer bg-white border-top py-3">
            {{ $transaksis->links() }}
        </div>
    @endif
</div>
@endsection
