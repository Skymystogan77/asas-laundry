<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Laundry</title>
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
            max-width: 420px;
        }
    </style>
</head>
<body class="p-3">
    <div class="card card-auth bg-white">
        <div class="card-body p-4 p-sm-5">
            <div class="text-center mb-4">
                <div class="d-inline-flex p-3 bg-primary bg-opacity-10 text-primary rounded-circle mb-2">
                    <i class="bi bi-water fs-2"></i>
                </div>
                <h4 class="fw-bold mb-1">Masuk ke Sistem</h4>
                <p class="text-muted small">Aplikasi Manajemen Laundry</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success py-2 small mb-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger py-2 small mb-3">
                    @foreach($errors->all() as $err)
                        <div>{{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small fw-semibold">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-muted" for="remember">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-4 pt-3 border-top text-center small text-muted">
                Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Daftar Akun Baru</a>
            </div>

            <div class="mt-3 p-2 bg-light border rounded small text-muted">
                <div class="fw-semibold text-secondary mb-1">Akun Demo Pengujian:</div>
                <div>Admin: <code>admin@laundry.test</code> / <code>admin123</code></div>
                <div>Kasir: <code>kasir@laundry.test</code> / <code>kasir123</code></div>
            </div>
        </div>
    </div>
</body>
</html>
