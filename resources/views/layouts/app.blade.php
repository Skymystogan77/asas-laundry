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

        /* =============================================
           WASHING MACHINE LOGO ANIMATION
           ============================================= */
        .brand-badge {
            width: 36px;
            height: 36px;
            background: var(--app-primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(29, 78, 216, 0.35);
        }

        /* Mesin cuci SVG inline di dalam brand badge */
        .wm-icon {
            width: 22px;
            height: 22px;
            position: relative;
            z-index: 2;
        }

        /* Drum porthole spinning */
        .wm-drum {
            animation: drumSpin 2.4s linear infinite;
            transform-origin: center;
        }

        @keyframes drumSpin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* Bubble float animation */
        .wm-bubble1 {
            animation: bubbleFloat1 2.4s ease-in-out infinite;
        }
        .wm-bubble2 {
            animation: bubbleFloat2 2.4s ease-in-out 0.6s infinite;
        }
        .wm-bubble3 {
            animation: bubbleFloat3 2.4s ease-in-out 1.2s infinite;
        }

        @keyframes bubbleFloat1 {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.9; }
            50%       { transform: translateY(-3px) scale(1.1); opacity: 0.6; }
        }
        @keyframes bubbleFloat2 {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.7; }
            50%       { transform: translateY(-2px) scale(1.15); opacity: 0.4; }
        }
        @keyframes bubbleFloat3 {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.8; }
            50%       { transform: translateY(-4px) scale(0.9); opacity: 0.5; }
        }

        /* =============================================
           PAGE LOAD OVERLAY — kek loading mesin cuci
           ============================================= */
        #pageLoader {
            position: fixed;
            inset: 0;
            background: #fff;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            transition: opacity 0.35s ease;
        }
        #pageLoader.hidden {
            opacity: 0;
            pointer-events: none;
        }
        .loader-machine {
            width: 72px;
            height: 72px;
            position: relative;
        }
        /* Outer drum ring */
        .loader-ring {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 4px solid #e2e8f0;
            border-top-color: var(--app-primary);
            border-right-color: var(--app-primary);
            animation: loaderSpin 1s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
            position: absolute;
            top: 0; left: 0;
        }
        /* Inner porthole */
        .loader-inner {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 3px solid #e0e7ff;
            border-top-color: #6366f1;
            animation: loaderSpin 1.6s linear infinite reverse;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }
        /* Center dot */
        .loader-dot {
            width: 10px;
            height: 10px;
            background: var(--app-primary);
            border-radius: 50%;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation: dotPulse 1s ease-in-out infinite;
        }
        @keyframes loaderSpin {
            to { transform: rotate(360deg); }
        }
        @keyframes dotPulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50%       { transform: translate(-50%, -50%) scale(1.4); }
        }
        .loader-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--app-muted);
            letter-spacing: 0.04em;
        }
        /* Foam bubbles below loader */
        .loader-bubbles {
            display: flex;
            gap: 6px;
            align-items: flex-end;
        }
        .lb {
            border-radius: 50%;
            background: #bfdbfe;
            animation: lbPop 1.2s ease-in-out infinite;
        }
        .lb:nth-child(1) { width:8px; height:8px; animation-delay: 0s; }
        .lb:nth-child(2) { width:11px; height:11px; animation-delay: 0.15s; background:#a5b4fc; }
        .lb:nth-child(3) { width:7px; height:7px; animation-delay: 0.3s; }
        .lb:nth-child(4) { width:9px; height:9px; animation-delay: 0.45s; background:#93c5fd; }
        .lb:nth-child(5) { width:6px; height:6px; animation-delay: 0.6s; }
        @keyframes lbPop {
            0%, 100% { transform: scaleY(1); opacity: 0.7; }
            50%       { transform: scaleY(1.6) scaleX(0.85); opacity: 1; }
        }

        /* =============================================
           TRANSITION OVERLAY (antar halaman)
           ============================================= */
        #pageTransition {
            position: fixed;
            inset: 0;
            background: var(--app-primary);
            z-index: 8888;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.76, 0, 0.24, 1);
        }
        #pageTransition.slide-in  { transform: translateX(0); }
        #pageTransition.slide-out { transform: translateX(100%); }

        /* =============================================
           TOP BAR
           ============================================= */
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
            gap: 10px;
            text-decoration: none;
        }
        .brand-title span { letter-spacing: -0.01em; }

        /* =============================================
           SIDEBAR
           ============================================= */
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
            transition: background 0.15s, color 0.15s, transform 0.15s;
        }
        .sidebar-menu a:hover {
            background: #f1f5f9;
            color: var(--app-text);
            transform: translateX(3px);
        }
        .sidebar-menu a.active {
            background: #eff6ff;
            color: var(--app-primary);
            font-weight: 600;
        }
        .sidebar-menu a.active i { color: var(--app-primary); }
        .sidebar-menu a i {
            transition: transform 0.2s;
        }
        .sidebar-menu a:hover i {
            transform: scale(1.15);
        }

        /* =============================================
           MAIN CONTENT — staggered entry
           ============================================= */
        .main-content {
            flex: 1;
            padding: 1.5rem 2rem;
            max-width: 1300px;
            animation: fadeInPage 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes fadeInPage {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* =============================================
           STAT BOXES — cascade slide-up
           ============================================= */
        .app-card {
            background: var(--app-surface);
            border: 1px solid var(--app-border);
            border-radius: 10px;
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .app-card:hover { border-color: #cbd5e1; }
        .app-card-header {
            padding: 0.9rem 1.25rem;
            border-bottom: 1px solid var(--app-border);
            font-weight: 600;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .app-card-body { padding: 1.25rem; }

        .stat-box {
            background: var(--app-surface);
            border: 1px solid var(--app-border);
            border-radius: 8px;
            padding: 1rem 1.15rem;
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.22s ease;
            /* cascade animation diset inline per card */
            opacity: 0;
            animation: slideUpCard 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .stat-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px -4px rgba(15, 23, 42, 0.1);
            border-color: #93c5fd;
        }
        .stat-box:nth-child(1) { animation-delay: 0.05s; }
        .stat-box:nth-child(2) { animation-delay: 0.12s; }
        .stat-box:nth-child(3) { animation-delay: 0.19s; }
        .stat-box:nth-child(4) { animation-delay: 0.26s; }

        @keyframes slideUpCard {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
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
        /* Animated stat icon */
        .stat-icon {
            width: 38px; height: 38px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            transition: transform 0.3s;
        }
        .stat-box:hover .stat-icon {
            animation: iconWobble 0.5s ease;
        }
        @keyframes iconWobble {
            0%,100% { transform: rotate(0deg) scale(1); }
            25%      { transform: rotate(-8deg) scale(1.1); }
            75%      { transform: rotate(8deg) scale(1.1); }
        }

        /* =============================================
           TABLE — row entry animation
           ============================================= */
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
        .app-table tbody tr {
            transition: background-color 0.12s ease, transform 0.12s ease;
            animation: rowSlideIn 0.35s ease both;
        }
        .app-table tbody tr:hover {
            background-color: #f0f7ff;
            transform: scale(1.002);
        }
        .app-table tbody tr:nth-child(1)  { animation-delay: 0.05s; }
        .app-table tbody tr:nth-child(2)  { animation-delay: 0.09s; }
        .app-table tbody tr:nth-child(3)  { animation-delay: 0.13s; }
        .app-table tbody tr:nth-child(4)  { animation-delay: 0.17s; }
        .app-table tbody tr:nth-child(5)  { animation-delay: 0.21s; }
        .app-table tbody tr:nth-child(6)  { animation-delay: 0.25s; }
        .app-table tbody tr:nth-child(7)  { animation-delay: 0.29s; }
        .app-table tbody tr:nth-child(8)  { animation-delay: 0.33s; }
        .app-table tbody tr:nth-child(9)  { animation-delay: 0.37s; }
        .app-table tbody tr:nth-child(10) { animation-delay: 0.41s; }
        @keyframes rowSlideIn {
            from { opacity: 0; transform: translateX(-8px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .app-table tbody td {
            padding: 0.8rem 1rem;
            font-size: 0.875rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        /* =============================================
           STATUS CHIPS
           ============================================= */
        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: transform 0.12s ease, opacity 0.12s ease;
        }
        button.status-chip:hover  { opacity: 0.88; transform: scale(0.98); }
        button.status-chip:active { transform: scale(0.93); }
        .chip-proses { background: #fef3c7; color: #92400e; }
        .chip-selesai { background: #dcfce7; color: #166534; }
        .chip-lunas { background: #e0e7ff; color: #3730a3; }
        .chip-belum { background: #fee2e2; color: #991b1b; }

        /* =============================================
           FORM ELEMENTS
           ============================================= */
        .form-control, .form-select {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, transform 0.15s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.12);
            transform: scale(1.005);
        }
        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 4px;
        }

        /* =============================================
           BUTTONS
           ============================================= */
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
            transition: background-color 0.15s ease, transform 0.12s ease, box-shadow 0.15s ease;
        }
        .btn-app-primary:hover {
            background: var(--app-primary-hover);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.25);
        }
        .btn-app-primary:active { transform: translateY(0) scale(0.97); }

        .btn-app-light {
            background: #ffffff;
            color: #334155;
            border: 1px solid var(--app-border);
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.45rem 0.85rem;
            transition: background-color 0.15s ease, color 0.15s ease, border-color 0.15s ease, transform 0.12s ease;
        }
        .btn-app-light:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }
        .btn-app-light:active { transform: scale(0.97); }

        /* =============================================
           ALERT SUCCESS/ERROR
           ============================================= */
        .alert {
            animation: alertPop 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes alertPop {
            from { opacity: 0; transform: translateY(-10px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* =============================================
           SPINNING INDICATOR (mini, di sidebar bottom)
           ============================================= */
        .spin-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.5rem 0.75rem;
            margin-top: auto;
            font-size: 0.75rem;
            color: #94a3b8;
        }
        .spin-ring-sm {
            width: 14px; height: 14px;
            border: 2px solid #e2e8f0;
            border-top-color: var(--app-primary);
            border-radius: 50%;
            animation: drumSpin 1.4s linear infinite;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .main-content { padding: 1rem; }
        }
    </style>
</head>
<body>

    <!-- ===== PAGE LOADER ===== -->
    <div id="pageLoader">
        <div class="loader-machine">
            <div class="loader-ring"></div>
            <div class="loader-inner"></div>
            <div class="loader-dot"></div>
        </div>
        <div class="loader-bubbles">
            <div class="lb"></div>
            <div class="lb"></div>
            <div class="lb"></div>
            <div class="lb"></div>
            <div class="lb"></div>
        </div>
        <div class="loader-label">LaundryKu memuat…</div>
    </div>

    <!-- ===== PAGE TRANSITION LAYER ===== -->
    <div id="pageTransition"></div>

    <!-- Topbar Header -->
    <header class="topbar sticky-top d-flex align-items-center justify-content-between px-3 px-md-4">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-md-none p-0 border-0 text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                <i class="bi bi-list fs-3"></i>
            </button>
            <a href="{{ route('dashboard') }}" class="brand-title">
                <div class="brand-badge">
                    <!-- Washing machine SVG icon -->
                    <svg class="wm-icon" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Body -->
                        <rect x="2" y="2" width="18" height="18" rx="3" fill="white" fill-opacity="0.15" stroke="white" stroke-width="1.2"/>
                        <!-- Panel top -->
                        <rect x="4" y="4" width="14" height="4" rx="1.5" fill="white" fill-opacity="0.2"/>
                        <!-- Buttons on panel -->
                        <circle cx="6.5" cy="6" r="1" fill="white" opacity="0.8"/>
                        <circle cx="9.5" cy="6" r="1" fill="white" opacity="0.6"/>
                        <!-- Porthole ring -->
                        <circle cx="11" cy="14" r="4.5" stroke="white" stroke-width="1.3" fill="none"/>
                        <!-- Spinning drum (inner porthole) -->
                        <g class="wm-drum">
                            <circle cx="11" cy="14" r="2.8" stroke="white" stroke-opacity="0.5" stroke-width="1" fill="none"/>
                            <circle cx="11" cy="11.2" r="0.8" fill="white" opacity="0.9"/>
                        </g>
                        <!-- Bubbles -->
                        <circle class="wm-bubble1" cx="15.5" cy="10" r="0.9" fill="white" opacity="0.7"/>
                        <circle class="wm-bubble2" cx="17" cy="12" r="0.6" fill="white" opacity="0.5"/>
                        <circle class="wm-bubble3" cx="16" cy="8.5" r="0.5" fill="white" opacity="0.6"/>
                    </svg>
                </div>
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
                <button type="submit" class="btn btn-app-light btn-sm">
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
        <aside class="sidebar d-none d-md-flex flex-column">
            <div>
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
                    <a href="{{ route('transaksi.create') }}" style="color: var(--app-primary);">
                        <i class="bi bi-plus-circle"></i> Order Cucian Baru
                    </a>
                </div>
            </div>

            <!-- Mini spin indicator di bawah sidebar -->
            <div class="spin-indicator mt-auto pb-2">
                <div class="spin-ring-sm"></div>
                <span>Sistem aktif</span>
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

    <script>
        // === Page Loader: hilang setelah konten siap ===
        window.addEventListener('load', function () {
            const loader = document.getElementById('pageLoader');
            setTimeout(function () {
                loader.classList.add('hidden');
                setTimeout(function () { loader.style.display = 'none'; }, 400);
            }, 600);
        });

        // === Page Transition on navigation ===
        const overlay = document.getElementById('pageTransition');
        document.querySelectorAll('a[href]').forEach(function (link) {
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript') || href.startsWith('mailto') || link.target === '_blank') return;
            link.addEventListener('click', function (e) {
                const dest = link.href;
                if (!dest || dest === window.location.href) return;
                e.preventDefault();
                overlay.classList.add('slide-in');
                setTimeout(function () { window.location = dest; }, 300);
            });
        });

        // === Jika balik (back button), hapus overlay ===
        window.addEventListener('pageshow', function (e) {
            if (e.persisted) {
                overlay.classList.remove('slide-in');
                overlay.classList.remove('slide-out');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
