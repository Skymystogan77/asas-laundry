@extends('layouts.app')

@section('title', 'Tambah Layanan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card bg-white">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold text-secondary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Paket Layanan Laundry
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('layanan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_layanan" class="form-label fw-semibold small">Nama Layanan</label>
                        <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan') }}" placeholder="Contoh: Reguler / Kilat 1 Hari" required>
                        @error('nama_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="harga_per_kg" class="form-label fw-semibold small">Harga Per Kilogram (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga_per_kg') is-invalid @enderror" id="harga_per_kg" name="harga_per_kg" value="{{ old('harga_per_kg') }}" placeholder="7000" min="100" required>
                            </div>
                            @error('harga_per_kg')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="durasi" class="form-label fw-semibold small">Estimasi Durasi Pengerjaan</label>
                            <input type="text" class="form-control @error('durasi') is-invalid @enderror" id="durasi" name="durasi" value="{{ old('durasi') }}" placeholder="Contoh: 3-4 hari / 5 jam" required>
                            @error('durasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-semibold small">Keterangan / Deskripsi Layanan (Opsional)</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Informasi singkat paket ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('layanan.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Layanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
