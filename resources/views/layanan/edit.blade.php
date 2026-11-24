@extends('layouts.app')

@section('title', 'Ubah Layanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card bg-white">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold text-secondary">
                    <i class="bi bi-pencil-square me-1"></i> Edit Paket Layanan
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('layanan.update', $layanan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama_layanan" class="form-label fw-semibold small">Nama Layanan</label>
                        <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                        @error('nama_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="harga_per_kg" class="form-label fw-semibold small">Harga Per Kilogram (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga_per_kg') is-invalid @enderror" id="harga_per_kg" name="harga_per_kg" value="{{ old('harga_per_kg', $layanan->harga_per_kg) }}" min="100" required>
                            </div>
                            @error('harga_per_kg')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="durasi" class="form-label fw-semibold small">Estimasi Durasi Pengerjaan</label>
                            <input type="text" class="form-control @error('durasi') is-invalid @enderror" id="durasi" name="durasi" value="{{ old('durasi', $layanan->durasi) }}" required>
                            @error('durasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-semibold small">Keterangan / Deskripsi Layanan</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('layanan.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Perbarui Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
