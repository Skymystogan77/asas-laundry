<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Laundry') - LaundryKu</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #2b303a;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
        }
        .nav-link {
            color: #4b5563;
            font-weight: 500;
            padding: 0.65rem 1rem;
            border-radius: 6px;
            margin-bottom: 3px;
        }
        .nav-link:hover {
            color: #0d6efd;
            background-color: #f0f4ff;
        }
        .nav-link.active {
            color: #0d6efd;
            background-color: #e7efff;
            font-weight: 600;
        }
        .card {
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-radius: 8px;
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #edf2f7;
            font-weight: 600;
        }
        .badge-proses {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        .badge-selesai {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .badge-lunas {
            background-color: #cce5ff;
            color: #004085;
            border: 1px solid #b8daff;
        }
        .badge-belum {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <!-- Navbar Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm py-2">
        <div class="container-fluid px-3">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <i class="bi bi-water fs-4"></i>
                <span>LaundryKu</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active text-white' : 'text-white-50' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('layanan.*') ? 'active text-white' : 'text-white-50' }}" href="{{ route('layanan.index') }}">
                            <i class="bi bi-tags me-1"></i> Data Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transaksi.*') ? 'active text-white' : 'text-white-50' }}" href="{{ route('transaksi.index') }}">
                            <i class="bi bi-receipt me-1"></i> Rekap Transaksi
                        </a>
                    </li>
                </ul>
                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="text-light small text-end d-none d-sm-block">
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                        <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-success' }}">
                            {{ strtoupper(Auth::user()->role) }}
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" onclick="return confirm('Yakin ingin logout?')">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="d-none d-md-inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Desktop -->
            <aside class="col-lg-2 col-md-3 d-none d-md-block sidebar py-3 px-2">
                <div class="px-3 mb-3 pb-2 border-bottom">
                    <div class="text-muted small">Login sebagai:</div>
                    <div class="fw-semibold text-truncate">{{ Auth::user()->name }}</div>
                    <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-success' }} mt-1">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
                <ul class="nav nav-pills flex-column px-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}" href="{{ route('layanan.index') }}">
                            <i class="bi bi-tags me-2"></i> Data Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                            <i class="bi bi-receipt me-2"></i> Rekap Transaksi
                        </a>
                    </li>
                </ul>
            </aside>

            <!-- Main Content Area -->
            <main class="col-lg-10 col-md-9 ms-auto px-md-4 py-4">
                {{-- Alert Notifikasi --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Perhatian:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
