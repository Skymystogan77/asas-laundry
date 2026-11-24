@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-1">Dashboard</h5>
        <div class="text-muted small">Ringkasan aktivitas operasional laundry hari ini.</div>
    </div>
    <a href="{{ route('transaksi.create') }}" class="btn-app-primary">
        <i class="bi bi-plus-lg"></i>
        <span>Order Baru</span>
    </a>
</div>

{{-- 4 Stat Boxes --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Total Layanan</span>
                <i class="bi bi-tags text-primary"></i>
            </div>
            <div class="stat-value">{{ $totalLayanan }}</div>
            <a href="{{ route('layanan.index') }}" class="small text-decoration-none text-muted">Paket tersedia &rarr;</a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Dalam Proses</span>
                <i class="bi bi-hourglass-split text-warning"></i>
            </div>
            <div class="stat-value text-warning">{{ $transaksiProses }}</div>
            <a href="{{ route('transaksi.index', ['status' => 'Proses']) }}" class="small text-decoration-none text-muted">Cucian aktif &rarr;</a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Selesai Cuci</span>
                <i class="bi bi-check-circle text-success"></i>
            </div>
            <div class="stat-value text-success">{{ $transaksiSelesai }}</div>
            <a href="{{ route('transaksi.index', ['status' => 'Selesai']) }}" class="small text-decoration-none text-muted">Siap ambil &rarr;</a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Pendapatan Lunas</span>
                <i class="bi bi-wallet2 text-primary"></i>
            </div>
            <div class="stat-value text-primary fs-5 mt-1 mb-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <span class="small text-muted">{{ $totalTransaksi }} nota pesanan</span>
        </div>
    </div>
</div>

{{-- Tabel Transaksi Terkini --}}
<div class="app-card">
    <div class="app-card-header">
        <span>Transaksi Terbaru</span>
        <a href="{{ route('transaksi.index') }}" class="btn-app-light btn-sm py-1 px-2" style="font-size: 0.8rem;">
            Lihat Semua
        </a>
    </div>
    <div class="table-responsive">
        <table class="table app-table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-3">No. Nota</th>
                    <th>Nama Pelanggan</th>
                    <th>Paket</th>
                    <th>Berat</th>
                    <th>Total</th>
                    <th>Status Cucian</th>
                    <th>Pembayaran</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $trx)
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
                        </td>
                        <td>{{ $trx->berat }} kg</td>
                        <td class="fw-semibold text-dark">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @if($trx->status_pengerjaan === 'Proses')
                                <span class="status-chip chip-proses">Proses</span>
                            @else
                                <span class="status-chip chip-selesai">Selesai</span>
                            @endif
                        </td>
                        <td>
                            @if($trx->status_pembayaran === 'Lunas')
                                <span class="status-chip chip-lunas">Lunas</span>
                            @else
                                <span class="status-chip chip-belum">Belum Lunas</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('transaksi.show', $trx->id) }}" class="btn-app-light btn-sm py-1 px-2" style="font-size: 0.78rem;">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted small">Belum ada transaksi yang tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
