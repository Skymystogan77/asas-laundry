@extends('layouts.app')

@section('title', 'Tambah Order Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header-custom d-flex align-items-center gap-2">
                <i class="bi bi-cart-plus text-primary"></i>
                <span>Form Order Transaksi Baru</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="kode_invoice" class="form-label fw-semibold small">Nomor Faktur / Nota</label>
                            <input type="text" class="form-control bg-light" id="kode_invoice" name="kode_invoice" value="{{ old('kode_invoice', $autoInvoice) }}" readonly>
                            <div class="text-muted small" style="font-size: 0.75rem;">Otomatis dibuat oleh sistem.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="status_pembayaran" class="form-label fw-semibold small">Status Pembayaran</label>
                            <select class="form-select @error('status_pembayaran') is-invalid @enderror" id="status_pembayaran" name="status_pembayaran" required>
                                <option value="Lunas" {{ old('status_pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas (Bayar di Depan)</option>
                                <option value="Belum Lunas" {{ old('status_pembayaran') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas (Bayar Pas Ambil)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nama_pelanggan" class="form-label fw-semibold small">Nama Pelanggan</label>
                            <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" placeholder="Nama pemilik pakaian" required>
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-semibold small">Nomor WhatsApp / HP</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label for="layanan_id" class="form-label fw-semibold small">Pilih Paket Layanan</label>
                            <select class="form-select @error('layanan_id') is-invalid @enderror" id="layanan_id" name="layanan_id" required>
                                <option value="" data-harga="0">-- Pilih Paket Cuci --</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga_per_kg }}" {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }} (Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}/kg - {{ $layanan->durasi }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="berat" class="form-label fw-semibold small">Berat Cucian (Kg)</label>
                            <div class="input-group">
                                <input type="number" step="0.1" min="0.1" class="form-control @error('berat') is-invalid @enderror" id="berat" name="berat" value="{{ old('berat', 1) }}" placeholder="1.0" required>
                                <span class="input-group-text bg-light">Kg</span>
                            </div>
                        </div>
                    </div>

                    {{-- Kotak Kalkulasi Otomatis --}}
                    <div class="p-3 my-4 bg-primary-subtle border border-primary-subtle rounded-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-primary small d-block fw-medium">Total Tagihan Cuci:</span>
                                <span class="text-secondary small" id="detail_hitung">0 Kg &times; Rp 0</span>
                            </div>
                            <div>
                                <h3 class="fw-bold text-primary mb-0" id="tampilan_total">Rp 0</h3>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="form-label fw-semibold small">Catatan Tambahan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Contoh: Pisahkan kemeja putih, luntur, dll">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-custom">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Pesanan</button>
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
