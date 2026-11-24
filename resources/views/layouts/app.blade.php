<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Laundry') - LaundryKu</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --app-primary: #1d4ed8;
            --app-primary-hover: #1e40af;
            --app-bg: #f8fafc;
            --app-surface: #ffffff;
            --app-border: #e2e8f0;
            --app-text: #0f172a;
            --app-muted: #64748b;
        }

        body {
            background-color: var(--app-bg);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--app-text);
            -webkit-font-smoothing: antialiased;
        }

        /* Top Bar */
        .topbar {
            background: var(--app-surface);
            border-bottom: 1px solid var(--app-border);
            height: 60px;
        }
        .brand-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--app-text);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .brand-badge {
            width: 32px;
            height: 32px;
            background: #eff6ff;
            color: var(--app-primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: var(--app-surface);
            border-right: 1px solid var(--app-border);
            min-height: calc(100vh - 60px);
            padding: 1rem 0.75rem;
        }
        .sidebar-heading {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            padding: 0 0.75rem 0.5rem;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.55rem 0.75rem;
            border-radius: 6px;
            color: #475569;
            font-weight: 500;
            font-size: 0.88rem;
            text-decoration: none;
            margin-bottom: 2px;
            transition: all 0.1s ease;
        }
        .sidebar-menu a:hover {
            background: #f1f5f9;
            color: var(--app-text);
        }
        .sidebar-menu a.active {
            background: #eff6ff;
            color: var(--app-primary);
            font-weight: 600;
        }
        .sidebar-menu a.active i {
            color: var(--app-primary);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 1.5rem 2rem;
            max-width: 1300px;
        }

        /* Cards & Tables */
        .app-card {
            background: var(--app-surface);
            border: 1px solid var(--app-border);
            border-radius: 10px;
        }
        .app-card-header {
            padding: 0.9rem 1.25rem;
            border-bottom: 1px solid var(--app-border);
            font-weight: 600;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .app-card-body {
            padding: 1.25rem;
        }

        /* Stat Card */
        .stat-box {
            background: var(--app-surface);
            border: 1px solid var(--app-border);
            border-radius: 8px;
            padding: 1rem 1.15rem;
        }
        .stat-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--app-muted);
            margin-bottom: 4px;
        }
        .stat-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--app-text);
            line-height: 1.2;
            margin-bottom: 2px;
        }

        /* Clean Table */
        .app-table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #64748b;
            background: #f8fafc;
            border-bottom: 1px solid var(--app-border);
            padding: 0.75rem 1rem;
            letter-spacing: 0.02em;
        }
        .app-table tbody td {
            padding: 0.8rem 1rem;
            font-size: 0.875rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Status Badges */
        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .chip-proses { background: #fef3c7; color: #92400e; }
        .chip-selesai { background: #dcfce7; color: #166534; }
        .chip-lunas { background: #e0e7ff; color: #3730a3; }
        .chip-belum { background: #fee2e2; color: #991b1b; }

        /* Form elements */
        .form-control, .form-select {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.15);
        }
        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 4px;
        }

        /* Clean buttons */
        .btn-app-primary {
            background: var(--app-primary);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.45rem 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-app-primary:hover {
            background: var(--app-primary-hover);
            color: #ffffff;
        }
        .btn-app-light {
            background: #ffffff;
            color: #334155;
            border: 1px solid var(--app-border);
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.45rem 0.85rem;
        }
        .btn-app-light:hover {
            background: #f8fafc;
            color: #0f172a;
        }
    </style>
</head>
<body>

    <!-- Topbar Header -->
    <header class="topbar sticky-top d-flex align-items-center justify-content-between px-3 px-md-4">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-md-none p-0 border-0 text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                <i class="bi bi-list fs-3"></i>
            </button>
            <a href="{{ route('dashboard') }}" class="brand-title">
                <div class="brand-badge"><i class="bi bi-droplet-half"></i></div>
                <span>LaundryKu</span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-sm-block">
                <div class="fw-semibold small lh-1 mb-1">{{ Auth::user()->name }}</div>
                <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-success-subtle text-success border border-success-subtle' }}" style="font-size: 0.68rem; font-weight: 600;">
                    {{ strtoupper(Auth::user()->role) }}
                </span>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                @csrf
                <button type="submit" class="btn btn-app-light btn-sm" onclick="return confirm('Keluar dari aplikasi?')">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    <span class="d-none d-sm-inline">Keluar</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Mobile Nav Collapse -->
    <div class="collapse d-md-none bg-white border-bottom p-3" id="mobileNav">
        <div class="sidebar-heading">Menu Aplikasi</div>
        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="{{ route('layanan.index') }}" class="{{ request()->routeIs('layanan.*') ? 'active' : '' }}">
                <i class="bi bi-tag"></i> Data Layanan
            </a>
            <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Rekap Transaksi
            </a>
        </div>
    </div>

    <!-- Main Workspace -->
    <div class="d-flex">
        <!-- Sidebar Desktop -->
        <aside class="sidebar d-none d-md-block">
            <div class="sidebar-heading">Menu</div>
            <div class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
                <a href="{{ route('layanan.index') }}" class="{{ request()->routeIs('layanan.*') ? 'active' : '' }}">
                    <i class="bi bi-tag"></i> Data Layanan
                </a>
                <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> Rekap Transaksi
                </a>
            </div>

            <div class="sidebar-heading mt-4">Pintasan</div>
            <div class="sidebar-menu">
                <a href="{{ route('transaksi.create') }}" class="text-primary">
                    <i class="bi bi-plus-circle"></i> Order Cucian Baru
                </a>
            </div>
        </aside>

        <!-- Page View Body -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success border-0 bg-success-subtle text-success-emphasis py-2 px-3 small rounded-2 mb-3" role="alert">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 bg-danger-subtle text-danger-emphasis py-2 px-3 small rounded-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
