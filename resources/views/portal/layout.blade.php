<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Sahabat Baik & Mitra') | GDI</title>

    <!-- Bootstrap 5, Icons, Fonts -->
    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('admin/assets/img/logo_gdi.png') }}">

    <style>
        :root {
            --portal-green: #117a37;
            --portal-green-dark: #0c5c29;
            --portal-orange: #f58220;
            --portal-bg: #f8fafc;
        }
        body {
            background-color: var(--portal-bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            color: #1e293b;
        }
        .portal-navbar {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        .portal-sidebar {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid #edf2f7;
            padding: 20px 15px;
        }
        .portal-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 6px;
            transition: all 0.2s ease;
        }
        .portal-nav-link:hover {
            background-color: #f1f5f9;
            color: var(--portal-green);
            transform: translateX(3px);
        }
        .portal-nav-link.active {
            background: linear-gradient(135deg, var(--portal-green) 0%, var(--portal-green-dark) 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(17, 122, 55, 0.25);
        }
        .portal-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #edf2f7;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }
        .avatar-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #117a37 0%, #0c5c29 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- TOP NAVBAR -->
<nav class="portal-navbar">
    <div class="container-fluid px-lg-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('portal.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('admin/assets/img/logo_gdi.png') }}" alt="GDI" style="height: 40px;">
                <div class="d-none d-sm-block">
                    <span class="fw-bold text-dark d-block lh-1" style="font-size: 0.95rem;">GRAHA DHUAFA INDONESIA</span>
                    <small class="text-success fw-semibold" style="font-size: 0.75rem;">PORTAL RELAWAN & MITRA</small>
                </div>
            </a>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="/" target="_blank" class="btn btn-outline-secondary btn-sm d-none d-md-inline-flex align-items-center gap-1">
                <i class="bi bi-globe"></i> Website Publik
            </a>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                    <div class="avatar-circle" style="width: 38px; height: 38px; font-size: 0.95rem;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="text-start d-none d-sm-block">
                        <span class="fw-bold small d-block lh-1 text-truncate" style="max-width: 140px;">{{ Auth::user()->name }}</span>
                        @if(Auth::user()->isAdmin())
                            <span class="badge bg-danger" style="font-size: 0.68rem;">Administrator</span>
                        @elseif(Auth::user()->isVolunteer())
                            <span class="badge bg-success" style="font-size: 0.68rem;">Sahabat Baik</span>
                        @else
                            <span class="badge bg-warning text-dark" style="font-size: 0.68rem;">Mitra GDI</span>
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                        <div class="small text-muted">{{ Auth::user()->email }}</div>
                    </li>
                    <li><a class="dropdown-item py-2" href="{{ route('portal.profile') }}"><i class="bi bi-person me-2"></i> Profil Akun</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('portal.berita.index') }}"><i class="bi bi-journal-text me-2"></i> Berita Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 text-danger" href="{{ route('portal.logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT WRAPPER -->
<div class="container-fluid px-lg-4 py-4">
    <div class="row g-4">
        <!-- SIDEBAR -->
        <div class="col-lg-3 col-md-4">
            <div class="portal-sidebar">
                <!-- USER BRIEF CARD -->
                <div class="text-center pb-3 border-bottom mb-3">
                    <div class="avatar-circle mx-auto mb-2" style="width: 56px; height: 56px; font-size: 1.4rem;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <h6 class="fw-bold mb-1">{{ Auth::user()->name }}</h6>
                    @if(Auth::user()->isAdmin())
                        <div class="badge bg-danger mb-2">
                            <i class="bi bi-shield-lock-fill me-1"></i> Administrator GDI
                        </div>
                    @elseif(Auth::user()->isVolunteer())
                        <div class="badge bg-success mb-2">
                            <i class="bi bi-heart-fill me-1"></i> Relawan Sahabat Baik
                        </div>
                    @else
                        <div class="badge bg-warning text-dark mb-2">
                            <i class="bi bi-briefcase-fill me-1"></i> Mitra / Amil Zakat
                        </div>
                    @endif
                    <div class="text-muted small">
                        <i class="bi bi-geo-alt"></i> {{ Auth::user()->domisili ?? 'Indonesia' }}
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-success-subtle text-success border border-success px-2 py-1" style="font-size: 0.72rem;">
                            <i class="bi bi-check-circle-fill me-1"></i> Akun Terverifikasi
                        </span>
                    </div>
                    @if(Auth::user()->isAffiliate())
                        <div class="mt-2 p-2 bg-warning-subtle rounded border border-warning small">
                            <span class="text-muted d-block" style="font-size: 0.72rem;">Kode Afiliasi:</span>
                            <strong class="text-dark">{{ strtoupper(Auth::user()->username) }}</strong>
                        </div>
                    @endif
                </div>

                <!-- NAVIGATION LINKS -->
                <nav class="nav flex-column">
                    <a href="{{ route('portal.dashboard') }}" class="portal-nav-link {{ request()->routeIs('portal.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid fs-5"></i> Dashboard
                    </a>
                    <a href="{{ route('portal.berita.create') }}" class="portal-nav-link {{ request()->routeIs('portal.berita.create') ? 'active' : '' }}">
                        <i class="bi bi-pencil-square fs-5"></i> Tulis Berita Kegiatan
                    </a>
                    <a href="{{ route('portal.berita.index') }}" class="portal-nav-link {{ request()->routeIs('portal.berita.index*') && !request()->routeIs('portal.berita.create') ? 'active' : '' }}">
                        <i class="bi bi-newspaper fs-5"></i> Daftar Berita Saya
                    </a>
                    <a href="{{ route('portal.profile') }}" class="portal-nav-link {{ request()->routeIs('portal.profile') ? 'active' : '' }}">
                        <i class="bi bi-person-gear fs-5"></i> Profil & Pengaturan
                    </a>
                    <hr class="my-2 text-muted">
                    <a href="{{ route('portal.logout') }}" class="portal-nav-link text-danger">
                        <i class="bi bi-door-open fs-5"></i> Logout
                    </a>
                </nav>

                <div class="mt-4 p-3 bg-light rounded text-center small text-muted">
                    <i class="bi bi-shield-lock-fill text-success d-block mb-1 fs-5"></i>
                    Semua berita kiriman relawan otomatis masuk <strong>Draft</strong> untuk dikurasi Admin GDI sebelum tayang.
                </div>
            </div>
        </div>

        <!-- MAIN BODY -->
        <div class="col-lg-9 col-md-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@stack('scripts')
</body>
</html>

