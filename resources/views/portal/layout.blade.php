<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Sahabat Baik & Mitra') | Graha Dhuafa Indonesia</title>

    <!-- Google Font: Manrope & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5, Icons -->
    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('admin/assets/img/logo_gdi.png') }}">

    <style>
        :root {
            --gdi-primary: #0f7638;
            --gdi-primary-dark: #0a5728;
            --gdi-primary-light: #e8f5ec;
            --gdi-accent-orange: #f59e0b;
            --gdi-bg-page: #f1f5f3;
            --gdi-text-main: #1e293b;
            --gdi-text-muted: #64748b;
            --gdi-card-radius: 20px;
        }

        body {
            background-color: var(--gdi-bg-page);
            font-family: 'Manrope', 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--gdi-text-main);
            min-height: 100vh;
            font-size: 0.84rem;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Headings: proporsional, rapi dan tidak terlalu besar */
        h1, .h1 { font-size: 1.45rem !important; font-weight: 700; letter-spacing: -0.015em; }
        h2, .h2 { font-size: 1.25rem !important; font-weight: 700; letter-spacing: -0.015em; }
        h3, .h3 { font-size: 1.10rem !important; font-weight: 600; letter-spacing: -0.01em; }
        h4, .h4 { font-size: 1.00rem !important; font-weight: 600; }
        h5, .h5 { font-size: 0.90rem !important; font-weight: 600; }
        h6, .h6 { font-size: 0.82rem !important; font-weight: 600; }

        /* Form elements */
        .form-label {
            font-size: 0.80rem;
            font-weight: 600;
            margin-bottom: 4px;
            color: #334155;
        }
        .form-control, .form-select {
            font-size: 0.84rem;
            padding: 7px 12px;
            border-radius: 8px;
            color: #1e293b;
        }
        .form-control-lg {
            font-size: 0.88rem !important;
            padding: 9px 14px !important;
        }
        .form-text, .text-muted.small, .small {
            font-size: 0.76rem !important;
        }

        /* Buttons */
        .btn {
            font-size: 0.80rem;
            font-weight: 600;
            padding: 6px 14px;
        }
        .btn-sm {
            font-size: 0.74rem;
            padding: 4px 10px;
        }
        .btn-lg {
            font-size: 0.86rem;
            padding: 8px 18px;
        }

        /* Badges */
        .badge {
            font-size: 0.70rem;
            font-weight: 600;
            padding: 4px 9px;
            letter-spacing: 0.2px;
        }

        /* Clean Table */
        .table th {
            font-size: 0.70rem !important;
            letter-spacing: 0.5px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .table td {
            font-size: 0.80rem !important;
        }

        /* TOP NAVBAR */
        .portal-topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5ebe7;
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .gdi-logo-badge {
            width: 44px;
            height: 44px;
            background: #0f7638;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 800;
            font-size: 15px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(15, 118, 56, 0.2);
        }
        .btn-top-web {
            border: 1px solid #e2e8f0;
            border-radius: 30px;
            padding: 6px 14px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #475569;
            background: #ffffff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        .btn-top-web:hover {
            background: #f8fafc;
            color: var(--gdi-primary);
            border-color: #cbd5e1;
        }
        .btn-top-bell {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            background: #ffffff;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-top-bell:hover {
            color: var(--gdi-primary);
            border-color: #cbd5e1;
        }
        .user-top-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--gdi-text-main);
            padding: 4px 8px;
            border-radius: 30px;
            transition: all 0.2s;
        }
        .top-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #0f7638;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.88rem;
        }

        /* SIDEBAR CARDS */
        .sidebar-profile-card {
            background: #ffffff;
            border-radius: var(--gdi-card-radius);
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
            border: 1px solid #e8edea;
            overflow: hidden;
            text-align: center;
            margin-bottom: 16px;
        }
        .sidebar-profile-header {
            height: 70px;
            background: linear-gradient(135deg, #117a37 0%, #15803d 100%);
            position: relative;
        }
        .sidebar-profile-avatar-wrap {
            margin-top: -38px;
            position: relative;
            z-index: 2;
        }
        .sidebar-avatar-circle {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: #0f7638;
            color: #ffffff;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            font-weight: 800;
        }
        .badge-role-pill {
            background: #e8f5ec;
            color: #0f7638;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-verified-pill {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            font-size: 0.74rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            width: 90%;
            justify-content: center;
            margin: 12px auto 16px;
        }

        /* NAVIGATION MENU CARD */
        .sidebar-nav-card {
            background: #ffffff;
            border-radius: var(--gdi-card-radius);
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
            border: 1px solid #e8edea;
            padding: 10px;
            margin-bottom: 16px;
        }
        .portal-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 10px;
            color: #334155;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.82rem;
            margin-bottom: 3px;
            transition: all 0.2s ease;
        }
        .portal-nav-item:hover {
            background-color: #f1f5f9;
            color: #0f7638;
        }
        .portal-nav-item.active {
            background: #0f7638;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(15, 118, 56, 0.28);
        }
        .portal-nav-item.logout {
            color: #dc2626;
            margin-top: 8px;
            border-top: 1px solid #f1f5f9;
            padding-top: 14px;
        }
        .portal-nav-item.logout:hover {
            background-color: #fef2f2;
            color: #b91c1c;
        }

        /* TIP / NOTICE CARD */
        .sidebar-tip-card {
            background: #ffffff;
            border-radius: var(--gdi-card-radius);
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
            border: 1px solid #e8edea;
            padding: 18px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .tip-icon-box {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #e8f5ec;
            color: #0f7638;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }
        .tip-text {
            font-size: 0.78rem;
            line-height: 1.45;
            color: #64748b;
            margin: 0;
        }
        .tip-text strong {
            color: #334155;
        }

        /* MAIN CONTENT CARD */
        .content-card {
            background: #ffffff;
            border-radius: var(--gdi-card-radius);
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
            border: 1px solid #e8edea;
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- TOP NAVBAR -->
<header class="portal-topbar">
    <div class="container-fluid px-lg-4 d-flex justify-content-between align-items-center">
        <!-- BRAND LOGO -->
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('portal.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('website/assets/images/custom/logo_gdi.png') }}" alt="Graha Dhuafa Indonesia" style="height: 44px; width: auto; object-fit: contain;">
                <div>
                    <span class="fw-bold text-dark d-block lh-1" style="font-size: 0.92rem;">GRAHA DHUAFA INDONESIA</span>
                    <small class="text-success fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.5px;">PORTAL RELAWAN</small>
                </div>
            </a>
        </div>

        <!-- RIGHT ACTIONS -->
        <div class="d-flex align-items-center gap-3">

           

            <!-- USER DROPDOWN -->
            <div class="dropdown">
                <a href="#" class="user-top-profile dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="top-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="text-start d-none d-sm-block">
                        <div class="fw-bold text-dark" style="font-size: 0.88rem;">{{ Auth::user()->name }}</div>
                        <span class="text-success fw-semibold" style="font-size: 0.72rem;">
                            {{ Auth::user()->isVolunteer() ? 'Sahabat Baik' : (Auth::user()->isAffiliate() ? 'Mitra GDI' : 'Administrator') }}
                        </span>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-4 p-2">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                        <div class="small text-muted">{{ Auth::user()->email }}</div>
                    </li>
                    <li><a class="dropdown-item py-2 rounded-3 mt-1" href="{{ route('portal.profile') }}"><i class="bi bi-person me-2"></i> Profil & Pengaturan</a></li>
                    <li><a class="dropdown-item py-2 rounded-3" href="{{ route('portal.berita.index') }}"><i class="bi bi-journal-text me-2"></i> Berita Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 text-danger rounded-3" href="{{ route('portal.logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<!-- MAIN WRAPPER -->
<main class="container-fluid px-lg-4 py-4">
    <div class="row g-4">
        <!-- LEFT SIDEBAR -->
        <div class="col-lg-3 col-md-4">
            

            <!-- 2. NAVIGATION MENU CARD -->
            <div class="sidebar-nav-card">
                <nav class="nav flex-column">
                    <a href="{{ route('portal.dashboard', ['tab' => 'programs']) }}" class="portal-nav-item {{ request()->routeIs('portal.dashboard') && request('tab') !== 'riwayat' ? 'active' : '' }}">
                        <i class="bi bi-compass-fill fs-5"></i> Program Relawan
                    </a>
                    <a href="{{ route('portal.dashboard', ['tab' => 'riwayat']) }}" class="portal-nav-item {{ request()->routeIs('portal.dashboard') && request('tab') === 'riwayat' ? 'active' : '' }}">
                        <i class="bi bi-clock-history fs-5"></i> Riwayat Aktivitasmu
                    </a>
                    <a href="{{ route('portal.berita.create') }}" class="portal-nav-item {{ request()->routeIs('portal.berita.create') ? 'active' : '' }}">
                        <i class="bi bi-pencil-square fs-5"></i> Tulis Berita Kegiatan
                    </a>
                    <a href="{{ route('portal.berita.index') }}" class="portal-nav-item {{ request()->routeIs('portal.berita.index*') && !request()->routeIs('portal.berita.create') ? 'active' : '' }}">
                        <i class="bi bi-journal-text fs-5"></i> Daftar Berita Saya
                    </a>
                    <a href="{{ route('portal.profile') }}" class="portal-nav-item {{ request()->routeIs('portal.profile') ? 'active' : '' }}">
                        <i class="bi bi-person-gear fs-5"></i> Profil & Pengaturan
                    </a>
                    <a href="{{ route('portal.logout') }}" class="portal-nav-item logout">
                        <i class="bi bi-box-arrow-right fs-5"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- 3. TIP / NOTICE CARD -->
            <div class="sidebar-tip-card">
                <div class="tip-icon-box">
                    <i class="bi bi-shield-check"></i>
                </div>
                <p class="tip-text">
                    Semua berita kiriman relawan otomatis masuk <strong>Draft</strong> untuk dikurasi Admin GDI sebelum tayang.
                </p>
            </div>
        </div>

        <!-- RIGHT MAIN CONTENT -->
        <div class="col-lg-9 col-md-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</main>

<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@stack('scripts')
</body>
</html>
