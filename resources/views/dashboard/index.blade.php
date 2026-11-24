@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Ikhtisar</h4>
        <p class="text-muted small mb-0">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong> (Role: {{ ucfirst(Auth::user()->role) }})</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-plus-circle"></i>
            <span>Order Baru</span>
        </a>
    </div>
</div>

{{-- Ringkasan Kartu Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small">Total Layanan</span>
                    <h3 class="fw-bold my-1">{{ $totalLayanan }}</h3>
                    <a href="{{ route('layanan.index') }}" class="text-primary text-decoration-none small">Lihat daftar &rarr;</a>
                </div>
                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded">
                    <i class="bi bi-tags fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small">Dalam Proses</span>
                    <h3 class="fw-bold my-1 text-warning">{{ $transaksiProses }}</h3>
                    <a href="{{ route('transaksi.index', ['status' => 'Proses']) }}" class="text-warning text-decoration-none small">Perlu dikerjakan &rarr;</a>
                </div>
                <div class="p-3 bg-warning bg-opacity-10 text-warning rounded">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small">Selesai Dicuci</span>
                    <h3 class="fw-bold my-1 text-success">{{ $transaksiSelesai }}</h3>
                    <a href="{{ route('transaksi.index', ['status' => 'Selesai']) }}" class="text-success text-decoration-none small">Siap diambil &rarr;</a>
                </div>
                <div class="p-3 bg-success bg-opacity-10 text-success rounded">
                    <i class="bi bi-check-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small">Pendapatan Lunas</span>
                    <h4 class="fw-bold my-1 text-primary">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                    <span class="text-muted small">{{ $totalTransaksi }} total nota</span>
                </div>
                <div class="p-3 bg-info bg-opacity-10 text-info rounded">
                    <i class="bi bi-cash-stack fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel 5 Transaksi Terbaru --}}
<div class="card bg-white">
    <div class="card-header d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold text-secondary">
            <i class="bi bi-clock-history me-1"></i> Transaksi Terbaru
        </h6>
        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Rekap</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted small text-uppercase">
                <tr>
                    <th class="ps-3">No. Invoice</th>
                    <th>Pelanggan</th>
                    <th>Paket Layanan</th>
                    <th>Berat</th>
                    <th>Total Biaya</th>
                    <th>Status Pengerjaan</th>
                    <th>Pembayaran</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $trx)
                    <tr>
                        <td class="ps-3">
                            <span class="fw-semibold text-primary">{{ $trx->kode_invoice }}</span>
                            <div class="text-muted small">{{ $trx->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $trx->nama_pelanggan }}</div>
                            <div class="text-muted small">{{ $trx->no_hp }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $trx->layanan->nama_layanan ?? '-' }}</span>
                        </td>
                        <td>{{ $trx->berat }} kg</td>
                        <td class="fw-semibold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @if($trx->status_pengerjaan === 'Proses')
                                <span class="badge badge-proses px-2 py-1">Sedang Proses</span>
                            @else
                                <span class="badge badge-selesai px-2 py-1">Selesai</span>
                            @endif
                        </td>
                        <td>
                            @if($trx->status_pembayaran === 'Lunas')
                                <span class="badge badge-lunas px-2 py-1">Lunas</span>
                            @else
                                <span class="badge badge-belum px-2 py-1">Belum Lunas</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada transaksi yang dicatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
