<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f5f9;
            font-family: system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-auth {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 460px;
        }
    </style>
</head>
<body class="p-3">
    <div class="card card-auth bg-white">
        <div class="card-body p-4 p-sm-5">
            <div class="text-center mb-4">
                <div class="d-inline-flex p-3 bg-primary bg-opacity-10 text-primary rounded-circle mb-2">
                    <i class="bi bi-person-plus fs-2"></i>
                </div>
                <h4 class="fw-bold mb-1">Registrasi Akun Baru</h4>
                <p class="text-muted small">Pendaftaran Pengguna Sistem Laundry</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 small mb-3">
                    @foreach($errors->all() as $err)
                        <div>{{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label small fw-semibold">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Siti Aisyah">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label small fw-semibold">Pilih Role / Hak Akses</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir (Transaksi & Lihat Layanan)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Kelola Layanan, Transaksi, Laporan)</option>
                    </select>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-sm-6">
                        <label for="password" class="form-label small fw-semibold">Kata Sandi</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="col-sm-6">
                        <label for="password_confirmation" class="form-label small fw-semibold">Konfirmasi Sandi</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi sandi">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    Daftar Akun
                </button>
            </form>

            <div class="mt-4 pt-3 border-top text-center small text-muted">
                Sudah memiliki akun? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Kembali ke Login</a>
            </div>
        </div>
    </div>
</body>
</html>
