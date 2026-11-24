@extends('layouts.app')

@section('title', 'Rekap Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-1">Rekap Transaksi</h5>
        <div class="text-muted small">Catatan seluruh transaksi cucian pelanggan.</div>
    </div>
    <a href="{{ route('transaksi.create') }}" class="btn-app-primary">
        <i class="bi bi-plus-lg"></i>
        <span>Order Baru</span>
    </a>
</div>

{{-- Filter Box --}}
<div class="app-card mb-3 p-3">
    <form action="{{ route('transaksi.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" name="cari" value="{{ request('cari') }}" placeholder="Cari nama, invoice, no hp...">
            </div>
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status Pengerjaan</option>
                <option value="Proses" {{ request('status') === 'Proses' ? 'selected' : '' }}>Dalam Proses</option>
                <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai Cuci</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-app-primary btn-sm w-100 justify-content-center">Cari</button>
            @if(request()->hasAny(['cari', 'status']))
                <a href="{{ route('transaksi.index') }}" class="btn btn-app-light btn-sm" title="Reset">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Tabel Data --}}
<div class="app-card">
    <div class="table-responsive">
        <table class="table app-table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-3">Nota & Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Paket & Berat</th>
                    <th>Total</th>
                    <th>Status Cucian</th>
                    <th>Pembayaran</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $trx)
                    <tr>
                        <td class="ps-3">
                            <span class="fw-semibold text-primary font-monospace">{{ $trx->kode_invoice }}</span>
                            <div class="text-muted" style="font-size: 0.72rem;">{{ $trx->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td>
                            <div class="fw-medium text-dark">{{ $trx->nama_pelanggan }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $trx->no_hp }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $trx->layanan->nama_layanan ?? '-' }}</span>
                            <div class="text-muted" style="font-size: 0.72rem;">{{ $trx->berat }} kg &times; Rp {{ number_format($trx->layanan->harga_per_kg ?? 0, 0, ',', '.') }}</div>
                        </td>
                        <td class="fw-semibold text-dark">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>
                        <td>
                            <form action="{{ route('transaksi.update-status', $trx->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                @if($trx->status_pengerjaan === 'Proses')
                                    <input type="hidden" name="status_pengerjaan" value="Selesai">
                                    <button type="submit" class="btn p-0 border-0 status-chip chip-proses" title="Klik untuk selesaikan" onclick="return confirm('Ubah status jadi SELESAI?')">
                                        Proses &rarr; Selesaikan
                                    </button>
                                @else
                                    <input type="hidden" name="status_pengerjaan" value="Proses">
                                    <button type="submit" class="btn p-0 border-0 status-chip chip-selesai" title="Klik untuk kembalikan">
                                        <i class="bi bi-check2"></i> Selesai
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
                                    <button type="submit" class="btn p-0 border-0 status-chip chip-lunas">
                                        Lunas
                                    </button>
                                @else
                                    <input type="hidden" name="status_pembayaran" value="Lunas">
                                    <button type="submit" class="btn p-0 border-0 status-chip chip-belum">
                                        Belum Lunas &rarr; Lunasi
                                    </button>
                                @endif
                            </form>
                        </td>
                        <td class="text-end pe-3">
                            <div class="btn-group">
                                <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-app-light btn-sm py-1 px-2" style="font-size: 0.78rem;">
                                    Nota
                                </a>
                                @if(Auth::user()->role === 'admin')
                                    <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2" style="font-size: 0.78rem;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted small">
                            Tidak ada data transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transaksis->hasPages())
        <div class="p-3 border-top">
            {{ $transaksis->links() }}
        </div>
    @endif
</div>
@endsection
