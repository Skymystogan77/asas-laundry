@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Hero Banner dengan Animasi Mesin Cuci Interaktif --}}
<div class="wm-hero-card mb-4">
    <div class="row align-items-center g-3">
        {{-- Kiri: Teks & Aksi --}}
        <div class="col-12 col-md-7 col-lg-8 text-center text-md-start">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 wm-pill">
                <span class="wm-live-dot"></span>
                <span class="small fw-semibold text-white">Sistem Operasional Aktif • <span class="live-wib-clock">{{ now()->timezone('Asia/Jakarta')->format('H:i') }} WIB</span></span>
            </div>
            <h4 class="fw-bold text-white mb-2">Halo, {{ Auth::user()->name }}! 👋</h4>
            <p class="text-white text-opacity-75 mb-3" style="font-size: 0.92rem; max-width: 520px; line-height: 1.5;">
                Saat ini ada <strong class="text-white text-decoration-underline">{{ $transaksiProses }} pesanan cucian</strong> yang lagi jalan di mesin cuci. 
                Pantau proses cuci, timbang order baru, atau cetak nota langsung dari sini.
            </p>
            <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-center justify-content-md-start gap-2">
                <a href="{{ route('transaksi.create') }}" class="btn btn-light fw-bold text-primary px-3 py-2 shadow-sm text-center" style="font-size: 0.85rem; border-radius: 8px;">
                    <i class="bi bi-plus-circle-fill me-1 text-primary"></i> Order Cucian Baru
                </a>
                <a href="{{ route('transaksi.index', ['status' => 'Proses']) }}" class="btn btn-outline-light px-3 py-2 fw-medium text-center" style="font-size: 0.85rem; border-radius: 8px; backdrop-filter: blur(4px);">
                    <i class="bi bi-arrow-repeat me-1"></i> Cucian Diproses ({{ $transaksiProses }})
                </a>
            </div>
        </div>

        {{-- Kanan: Mesin Cuci Muter Keren --}}
        <div class="col-12 col-md-5 col-lg-4 d-flex justify-content-center justify-content-md-end mt-3 mt-md-0">
            <div class="wm-machine-wrap">
                <div class="wm-machine">
                    {{-- Panel Atas Mesin --}}
                    <div class="wm-panel">
                        <div class="wm-disp" title="Waktu Indonesia Barat (WIB)">
                            <span class="wm-disp-text" id="wmDispTime">{{ now()->timezone('Asia/Jakarta')->format('H:i') }}</span>
                            <span class="wm-disp-wib">WIB</span>
                        </div>
                        <div class="wm-controls">
                            <div class="wm-led"></div>
                            <div class="wm-dial"></div>
                        </div>
                    </div>

                    {{-- Pintu Drum Mesin Cuci --}}
                    <div class="wm-door">
                        <div class="wm-glass">
                            {{-- Kilauan Kaca --}}
                            <div class="wm-shine"></div>

                            {{-- Drum Berputar dengan Baju --}}
                            <div class="wm-rotor">
                                {{-- Baju 1 (Biru) --}}
                                <div class="wm-cloth wm-cloth-blue"></div>
                                {{-- Baju 2 (Kuning/Orange) --}}
                                <div class="wm-cloth wm-cloth-orange"></div>
                                {{-- Baju 3 (Putih) --}}
                                <div class="wm-cloth wm-cloth-white"></div>
                                {{-- Busa & Gelembung --}}
                                <div class="wm-foam f1"></div>
                                <div class="wm-foam f2"></div>
                                <div class="wm-foam f3"></div>
                                <div class="wm-foam f4"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Garis laci sabun bawah --}}
                    <div class="wm-bottom">
                        <div class="wm-drawer"></div>
                        <div class="wm-feet f-left"></div>
                        <div class="wm-feet f-right"></div>
                    </div>
                </div>

                {{-- Badge Status di bawah mesin --}}
                <div class="wm-badge-live">
                    <i class="bi bi-arrow-repeat wm-badge-spin"></i>
                    <span>Mesin Cuci Berputar</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 4 Stat Boxes --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Total Layanan</span>
                <div class="stat-icon" style="background:#eff6ff;">
                    <i class="bi bi-tags text-primary"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalLayanan }}</div>
            <a href="{{ route('layanan.index') }}" class="small text-decoration-none text-muted">Paket tersedia &rarr;</a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Dalam Proses</span>
                <div class="stat-icon" style="background:#fffbeb;">
                    <i class="bi bi-arrow-repeat text-warning" style="animation: drumSpin 1.8s linear infinite; display:inline-block;"></i>
                </div>
            </div>
            <div class="stat-value text-warning">{{ $transaksiProses }}</div>
            <a href="{{ route('transaksi.index', ['status' => 'Proses']) }}" class="small text-decoration-none text-muted">Cucian aktif &rarr;</a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Selesai Cuci</span>
                <div class="stat-icon" style="background:#f0fdf4;">
                    <i class="bi bi-check-circle text-success"></i>
                </div>
            </div>
            <div class="stat-value text-success">{{ $transaksiSelesai }}</div>
            <a href="{{ route('transaksi.index', ['status' => 'Selesai']) }}" class="small text-decoration-none text-muted">Siap ambil &rarr;</a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Pendapatan Lunas</span>
                <div class="stat-icon" style="background:#eff6ff;">
                    <i class="bi bi-wallet2 text-primary"></i>
                </div>
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
                                <span class="status-chip chip-proses">
                                    <i class="bi bi-arrow-repeat" style="animation: drumSpin 1.5s linear infinite; display:inline-block;"></i>
                                    Proses
                                </span>
                            @else
                                <span class="status-chip chip-selesai">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Selesai
                                </span>
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
