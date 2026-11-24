@extends('layouts.app')

@section('title', 'Order Cucian Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        {{-- Card Header --}}
        <div class="app-card mb-4">
            <div class="app-card-header bg-light">
                <div class="d-flex align-items-center gap-2">
                    <div class="brand-badge" style="width:28px;height:28px;font-size:0.9rem;">
                        <i class="bi bi-cart-plus-fill text-white"></i>
                    </div>
                    <div>
                        <div class="fw-bold mb-0">Form Pemesanan Cucian</div>
                        <div class="text-muted" style="font-size: 0.75rem;">
                            @guest
                                Pesan cuci langsung tanpa login. Cukup isi nama dan no telepon Anda!
                            @else
                                Input transaksi pesanan masuk kasir / admin
                            @endguest
                        </div>
                    </div>
                </div>
                @guest
                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.72rem;">
                        <i class="bi bi-lightning-fill"></i> Order Cepat Tanpa Login
                    </span>
                @endguest
            </div>

            <div class="app-card-body p-4">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf

                    {{-- Info Pelanggan: Nama & No HP paling atas dan jelas --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nama_pelanggan" class="form-label fw-bold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" placeholder="Contoh: Budi Santoso" required autofocus>
                            </div>
                            @error('nama_pelanggan')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-bold">
                                Nomor WhatsApp / HP <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-whatsapp"></i></span>
                                <input type="tel" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required>
                            </div>
                            @error('no_hp')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Paket Layanan & Berat --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label for="layanan_id" class="form-label fw-bold">
                                Pilih Paket Layanan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('layanan_id') is-invalid @enderror" id="layanan_id" name="layanan_id" required>
                                <option value="" data-harga="0">-- Pilih Jenis Cucian --</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga_per_kg }}" {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }} (Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}/kg • {{ $layanan->durasi }})
                                    </option>
                                @endforeach
                            </select>
                            @error('layanan_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5">
                            <label for="berat" class="form-label fw-bold">
                                Estimasi / Berat Cucian
                            </label>
                            <div class="input-group">
                                <input type="number" step="0.1" min="0.1" class="form-control @error('berat') is-invalid @enderror" id="berat" name="berat" value="{{ old('berat', 1.0) }}" placeholder="1.0" required>
                                <span class="input-group-text bg-light">Kg</span>
                            </div>
                            <div class="text-muted" style="font-size: 0.72rem;">*Bisa estimasi dulu, kasir akan menimbang ulang saat pakaian diterima.</div>
                        </div>
                    </div>

                    {{-- No Faktur & Pembayaran --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="kode_invoice" class="form-label fw-semibold small text-muted">Nomor Faktur Nota (Auto)</label>
                            <input type="text" class="form-control bg-light font-monospace small" id="kode_invoice" name="kode_invoice" value="{{ old('kode_invoice', $autoInvoice) }}" readonly>
                        </div>
                        <div class="col-md-6">
                            @auth
                                <label for="status_pembayaran" class="form-label fw-semibold small">Status Pembayaran</label>
                                <select class="form-select" id="status_pembayaran" name="status_pembayaran">
                                    <option value="Lunas" {{ old('status_pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas (Bayar Sekarang)</option>
                                    <option value="Belum Lunas" {{ old('status_pembayaran') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas (Bayar Pas Ambil)</option>
                                </select>
                            @else
                                <label class="form-label fw-semibold small text-muted">Metode Pembayaran</label>
                                <input type="hidden" name="status_pembayaran" value="Belum Lunas">
                                <div class="form-control bg-light text-muted small d-flex align-items-center gap-2">
                                    <i class="bi bi-wallet2 text-primary"></i>
                                    <span>Bayar Tunai / Transfer saat cucian selesai diambil</span>
                                </div>
                            @endauth
                        </div>
                    </div>

                    {{-- Kotak Kalkulasi Otomatis --}}
                    <div class="p-3 my-3 bg-primary-subtle border border-primary-subtle rounded-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <span class="text-primary small d-block fw-semibold">Estimasi Total Biaya Cuci:</span>
                                <span class="text-secondary small font-monospace" id="detail_hitung">1 Kg &times; Rp 0</span>
                            </div>
                            <div>
                                <h3 class="fw-bold text-primary mb-0" id="tampilan_total">Rp 0</h3>
                            </div>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-4">
                        <label for="catatan" class="form-label fw-semibold small">Catatan Tambahan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Contoh: Pisahkan pakaian putih, ada noda di kerah kemeja, dll.">{{ old('catatan') }}</textarea>
                    </div>

                    {{-- Action buttons --}}
                    <div class="d-flex justify-content-between align-items-center border-top pt-3 flex-wrap gap-2">
                        @auth
                            <a href="{{ route('transaksi.index') }}" class="btn btn-app-light">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-app-light">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login Petugas
                            </a>
                        @endauth

                        <button type="submit" class="btn btn-app-primary px-4 fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i> Kirim Pesanan Cucian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectLayanan = document.getElementById('layanan_id');
        const inputBerat = document.getElementById('berat');
        const detailHitung = document.getElementById('detail_hitung');
        const tampilanTotal = document.getElementById('tampilan_total');

        function hitungTotal() {
            const selectedOption = selectLayanan.options[selectLayanan.selectedIndex];
            const harga = parseFloat(selectedOption ? selectedOption.getAttribute('data-harga') : 0) || 0;
            const berat = parseFloat(inputBerat.value) || 0;

            const total = Math.round(harga * berat);

            detailHitung.textContent = `${berat} Kg x Rp ${harga.toLocaleString('id-ID')}`;
            tampilanTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        selectLayanan.addEventListener('change', hitungTotal);
        inputBerat.addEventListener('input', hitungTotal);

        hitungTotal();
    });
</script>
@endpush
