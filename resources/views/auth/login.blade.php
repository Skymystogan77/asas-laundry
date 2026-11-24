<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LaundryKu</title>
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
            border-radius: 14px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            animation: cardAppear 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
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
        .form-control {
            border-radius: 8px;
            border-color: #cbd5e1;
            padding: 0.6rem 0.85rem;
        }
        .form-control:focus {
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
                    <i class="bi bi-droplet-half"></i>
                </div>
                <h4 class="fw-bold mb-1">Masuk ke Sistem</h4>
                <p class="text-muted small">Aplikasi Manajemen Laundry</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 bg-success-subtle text-success py-2 px-3 small rounded-3 mb-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 bg-danger-subtle text-danger py-2 px-3 small rounded-3 mb-3">
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
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small fw-semibold">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-muted" for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-4 pt-3 border-top text-center small text-muted">
                Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">Daftar Akun Baru</a>
            </div>

            <div class="mt-3 p-3 bg-light rounded-3 small text-muted">
                <div class="fw-semibold text-dark mb-1">Akun Demo Pengujian:</div>
                <div>Admin: <code>admin@laundry.test</code> / <code>admin123</code></div>
                <div>Kasir: <code>kasir@laundry.test</code> / <code>kasir123</code></div>
            </div>
        </div>
    </div>
</body>
</html>
