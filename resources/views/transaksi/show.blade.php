@extends('layouts.app')

@section('title', 'Detail Nota ' . $transaksi->kode_invoice)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Rekap
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="bi bi-printer me-1"></i> Cetak Nota
            </button>
        </div>

        <div class="card bg-white p-4" id="area-nota">
            <div class="text-center pb-3 border-bottom mb-4">
                <h4 class="fw-bold mb-0">LAUNDRYKU</h4>
                <p class="text-muted small mb-0">Layanan Cuci Bersih, Rapi & Wangi</p>
                <p class="text-muted small">Jl. Pendidikan No. 12 - Telp / WA: 0812-3456-7890</p>
            </div>

            <div class="row mb-4">
                <div class="col-sm-6 mb-2">
                    <span class="text-muted small d-block">Nomor Nota:</span>
                    <strong class="fs-6">{{ $transaksi->kode_invoice }}</strong>
                    <div class="text-muted small">Tanggal: {{ $transaksi->created_at->format('d/m/Y H:i') }} WIB</div>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <span class="text-muted small d-block">Pelanggan:</span>
                    <strong>{{ $transaksi->nama_pelanggan }}</strong>
                    <div class="text-muted small">{{ $transaksi->no_hp }}</div>
                </div>
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Item / Paket Layanan</th>
                            <th class="text-center">Berat</th>
                            <th class="text-end">Tarif / Kg</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>{{ $transaksi->layanan->nama_layanan ?? 'Paket Kustom' }}</strong>
                                <div class="text-muted small">Estimasi: {{ $transaksi->layanan->durasi ?? '-' }}</div>
                            </td>
                            <td class="text-center">{{ $transaksi->berat }} Kg</td>
                            <td class="text-end">Rp {{ number_format($transaksi->layanan->harga_per_kg ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">TOTAL TAGIHAN:</th>
                            <th class="text-end fs-6 text-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row g-2 mb-4 p-3 bg-light rounded">
                <div class="col-sm-6">
                    <div class="small text-muted">Status Pengerjaan:</div>
                    @if($transaksi->status_pengerjaan === 'Proses')
                        <span class="badge badge-proses px-2 py-1">Sedang Dikerjakan</span>
                    @else
                        <span class="badge badge-selesai px-2 py-1">Selesai & Siap Diambil</span>
                    @endif
                </div>
                <div class="col-sm-6">
                    <div class="small text-muted">Status Pembayaran:</div>
                    @if($transaksi->status_pembayaran === 'Lunas')
                        <span class="badge badge-lunas px-2 py-1">LUNAS</span>
                    @else
                        <span class="badge badge-belum px-2 py-1">BELUM LUNAS</span>
                    @endif
                </div>
                @if($transaksi->catatan)
                    <div class="col-12 mt-2 pt-2 border-top">
                        <div class="small text-muted">Catatan Khusus:</div>
                        <div class="small fst-italic">{{ $transaksi->catatan }}</div>
                    </div>
                @endif
            </div>

            <div class="text-center pt-3 border-top text-muted small">
                <p class="mb-1">Terima kasih atas kepercayaan Anda.</p>
                <p class="mb-0">Kasir: {{ $transaksi->user->name ?? 'Admin' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
