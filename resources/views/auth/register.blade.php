<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - LaundryKu</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f172a;
        }
        .card-auth {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 460px;
            background: #ffffff;
        }
        .brand-icon-big {
            width: 48px;
            height: 48px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
            border-radius: 10px;
            font-weight: 600;
            padding: 0.65rem 1rem;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border-color: #cbd5e1;
            padding: 0.6rem 0.85rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
    </style>
</head>
<body class="p-3">
    <div class="card card-auth">
        <div class="card-body p-4 p-sm-5">
            <div class="text-center mb-4">
                <div class="brand-icon-big">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h4 class="fw-bold mb-1">Registrasi Akun</h4>
                <p class="text-muted small">Daftar Pengguna Baru LaundryKu</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 bg-danger-subtle text-danger py-2 px-3 small rounded-3 mb-3">
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
                    <label for="role" class="form-label small fw-semibold">Role Pengguna</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir (Transaksi & Lihat Tarif)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Kelola Paket Layanan & Rekap)</option>
                    </select>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-sm-6">
                        <label for="password" class="form-label small fw-semibold">Kata Sandi</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="col-sm-6">
                        <label for="password_confirmation" class="form-label small fw-semibold">Ulangi Sandi</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi sandi">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Daftar Akun
                </button>
            </form>

            <div class="mt-4 pt-3 border-top text-center small text-muted">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">Kembali ke Login</a>
            </div>
        </div>
    </div>
</body>
</html>
