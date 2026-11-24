@extends('layouts.app')

@section('title', 'Tambah Transaksi Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card bg-white">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold text-secondary">
                    <i class="bi bi-cart-plus me-1"></i> Form Order Transaksi Baru
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="kode_invoice" class="form-label fw-semibold small">Nomor Nota / Invoice</label>
                            <input type="text" class="form-control bg-light" id="kode_invoice" name="kode_invoice" value="{{ old('kode_invoice', $autoInvoice) }}" readonly>
                            <div class="form-text small">Nomor faktur terbuat otomatis oleh sistem.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="status_pembayaran" class="form-label fw-semibold small">Status Pembayaran</label>
                            <select class="form-select @error('status_pembayaran') is-invalid @enderror" id="status_pembayaran" name="status_pembayaran" required>
                                <option value="Lunas" {{ old('status_pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas (Bayar Langsung)</option>
                                <option value="Belum Lunas" {{ old('status_pembayaran') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas (Bayar Saat Ambil)</option>
                            </select>
                            @error('status_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nama_pelanggan" class="form-label fw-semibold small">Nama Pelanggan</label>
                            <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" placeholder="Nama pemilik pakaian" required>
                            @error('nama_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-semibold small">Nomor WhatsApp / HP</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label for="layanan_id" class="form-label fw-semibold small">Pilih Paket Layanan</label>
                            <select class="form-select @error('layanan_id') is-invalid @enderror" id="layanan_id" name="layanan_id" required>
                                <option value="" data-harga="0">-- Pilih Jenis Layanan --</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga_per_kg }}" {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }} (Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}/kg - {{ $layanan->durasi }})
                                    </option>
                                @endforeach
                            </select>
                            @error('layanan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="berat" class="form-label fw-semibold small">Berat Cucian (Kg)</label>
                            <div class="input-group">
                                <input type="number" step="0.1" min="0.1" class="form-control @error('berat') is-invalid @enderror" id="berat" name="berat" value="{{ old('berat', 1) }}" placeholder="1.0" required>
                                <span class="input-group-text">Kg</span>
                            </div>
                            @error('berat')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Kotak Kalkulasi Otomatis --}}
                    <div class="p-3 my-4 bg-light border rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block">Estimasi Total Biaya:</span>
                                <span class="text-muted small" id="detail_hitung">0 Kg &times; Rp 0</span>
                            </div>
                            <div>
                                <h3 class="fw-bold text-primary mb-0" id="tampilan_total">Rp 0</h3>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="form-label fw-semibold small">Catatan Tambahan (Opsional)</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="2" placeholder="Contoh: Ada baju putih tolong dipisah, luntur, dll">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Order</button>
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

        // Hitung saat reload / load awal
        hitungTotal();
    });
</script>
@endpush
