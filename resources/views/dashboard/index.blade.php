@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Hero Banner dengan Animasi Mesin Cuci Interaktif --}}
<div class="wm-hero-card mb-4">
    <div class="row align-items-center g-4">
        {{-- Kiri: Teks & Aksi --}}
        <div class="col-12 col-md-7 col-lg-8 text-center text-md-start">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 wm-pill">
                <span class="wm-live-dot"></span>
                <span class="small fw-semibold text-white">SISTEM OPERASIONAL AKTIF • <span class="live-wib-clock">{{ now()->timezone('Asia/Jakarta')->format('H:i') }} WIB</span></span>
            </div>
            <h3 class="fw-bold text-white mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
            <p class="text-white text-opacity-80 mb-3" style="font-size: 0.93rem; max-width: 530px; line-height: 1.6;">
                Saat ini sistem mendeteksi <span class="badge bg-warning text-dark px-2 py-1 fw-bold">{{ $transaksiProses }} pesanan aktif</span> yang sedang berjalan di mesin cuci. 
                Pantau proses pengerjaan pakaian, timbang order baru, atau cetak nota digital secara langsung.
            </p>
            <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-center justify-content-md-start gap-2">
                <a href="{{ route('transaksi.create') }}" class="btn btn-light fw-bold text-primary px-3 py-2 shadow-sm d-inline-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem; border-radius: 10px;">
                    <i class="bi bi-plus-circle-fill text-primary"></i> Order Cucian Baru
                </a>
                <a href="{{ route('transaksi.index', ['status' => 'Proses']) }}" class="btn btn-outline-light px-3 py-2 fw-medium d-inline-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem; border-radius: 10px; background: rgba(255,255,255,0.08);">
                    <i class="bi bi-arrow-repeat"></i> Cucian Diproses ({{ $transaksiProses }})
                </a>
            </div>
        </div>

        {{-- Kanan: Mesin Cuci Muter Keren dalam Showcase Bay --}}
        <div class="col-12 col-md-5 col-lg-4 d-flex justify-content-center justify-content-md-end">
            <div class="wm-machine-bay">
                <div class="wm-machine-wrap">
                    <div class="wm-machine">
                        {{-- Panel Atas Mesin --}}
                        <div class="wm-panel">
                            <div class="wm-disp" title="Waktu Indonesia Barat (WIB)">
                                <span class="wm-disp-text" id="wmDispTime">{{ now()->timezone('Asia/Jakarta')->format('H:i') }}</span>
                                <span class="wm-disp-wib">WIB</span>
                            </div>
                            <div class="wm-controls">
                                <div class="wm-led" title="Power ON"></div>
                                <div class="wm-led-spin" title="Spin Active"></div>
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
                                    {{-- Baju 4 (Hijau) --}}
                                    <div class="wm-cloth wm-cloth-green"></div>
                                    {{-- Busa & Gelembung --}}
                                    <div class="wm-foam f1"></div>
                                    <div class="wm-foam f2"></div>
                                    <div class="wm-foam f3"></div>
                                    <div class="wm-foam f4"></div>
                                    <div class="wm-foam f5"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Garis laci sabun bawah & kaki mesin --}}
                        <div class="wm-bottom">
                            <div class="wm-drawer"></div>
                            <div class="wm-feet f-left"></div>
                            <div class="wm-feet f-right"></div>
                        </div>
                    </div>
                </div>

                {{-- Badge Status di bawah mesin --}}
                <div class="wm-badge-live">
                    <i class="bi bi-arrow-repeat wm-badge-spin"></i>
                    <span>Mesin Aktif • 1200 RPM</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 4 Stat Boxes Modern SaaS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Total Layanan</span>
                <div class="stat-icon-sq" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);">
                    <i class="bi bi-tags-fill"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalLayanan }}</div>
            <a href="{{ route('layanan.index') }}" class="small text-decoration-none text-muted fw-medium d-inline-flex align-items-center gap-1">
                Paket tersedia <i class="bi bi-arrow-right small"></i>
            </a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Dalam Proses</span>
                <div class="stat-icon-sq" style="background: linear-gradient(135deg, #ea580c 0%, #f59e0b 100%);">
                    <i class="bi bi-arrow-repeat" style="animation: drumSpin 1.8s linear infinite;"></i>
                </div>
            </div>
            <div class="stat-value text-warning">{{ $transaksiProses }}</div>
            <a href="{{ route('transaksi.index', ['status' => 'Proses']) }}" class="small text-decoration-none text-muted fw-medium d-inline-flex align-items-center gap-1">
                Cucian aktif <i class="bi bi-arrow-right small"></i>
            </a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Selesai Cuci</span>
                <div class="stat-icon-sq" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>
            <div class="stat-value text-success">{{ $transaksiSelesai }}</div>
            <a href="{{ route('transaksi.index', ['status' => 'Selesai']) }}" class="small text-decoration-none text-muted fw-medium d-inline-flex align-items-center gap-1">
                Siap ambil <i class="bi bi-arrow-right small"></i>
            </a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="stat-label">Pendapatan Lunas</span>
                <div class="stat-icon-sq" style="background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);">
                    <i class="bi bi-wallet2"></i>
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
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-receipt text-primary"></i>
            <span>Transaksi Cucian Terkini</span>
            <span class="badge bg-light text-muted border small">5 Terbaru</span>
        </div>
        <a href="{{ route('transaksi.index') }}" class="btn-app-light btn-sm py-1 px-3 d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
            Lihat Semua Rekap <i class="bi bi-arrow-right small"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table app-table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-3">No. Nota & Waktu</th>
                    <th>Pelanggan</th>
                    <th>Paket Layanan</th>
                    <th>Berat</th>
                    <th>Total Biaya</th>
                    <th>Status Cucian</th>
                    <th>Pembayaran</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $trx)
                    <tr>
                        <td class="ps-3">
                            <a href="{{ route('transaksi.show', $trx->id) }}" class="invoice-chip mb-1">
                                <i class="bi bi-receipt"></i>
                                <span>{{ $trx->kode_invoice }}</span>
                            </a>
                            <div class="text-muted" style="font-size: 0.72rem;">{{ $trx->created_at->format('d/m/Y H:i') }} WIB</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle" style="background: #e0e7ff; color: #3730a3;">
                                    {{ strtoupper(substr($trx->nama_pelanggan, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark" style="font-size: 0.88rem;">{{ $trx->nama_pelanggan }}</div>
                                    <div class="text-muted d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-telephone text-muted"></i>
                                        <span>{{ $trx->no_hp }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1 fw-medium" style="border-radius: 6px;">
                                {{ $trx->layanan->nama_layanan ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $trx->berat }}</span> <span class="text-muted small">kg</span>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            @if($trx->status_pengerjaan === 'Proses')
                                <span class="status-chip chip-proses">
                                    <i class="bi bi-arrow-repeat" style="animation: drumSpin 1.5s linear infinite; display:inline-block;"></i>
                                    Sedang Dicuci
                                </span>
                            @else
                                <span class="status-chip chip-selesai">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Siap Diambil
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($trx->status_pembayaran === 'Lunas')
                                <span class="status-chip chip-lunas">
                                    <i class="bi bi-check2"></i> Lunas
                                </span>
                            @else
                                <span class="status-chip chip-belum">
                                    <i class="bi bi-clock"></i> Belum Lunas
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('transaksi.show', $trx->id) }}" class="btn-app-light btn-sm py-1 px-2 d-inline-flex align-items-center gap-1" style="font-size: 0.78rem;">
                                Detail <i class="bi bi-chevron-right small"></i>
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
