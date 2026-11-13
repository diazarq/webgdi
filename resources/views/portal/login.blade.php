<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Login Portal Sahabat Baik & Mitra | GDI' }}</title>

    <!-- Fonts: Manrope (Sesuai dengan font website utama GDI) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('admin/assets/img/logo_gdi.png') }}">

    <style>
        :root {
            --gdi-green: #117a37;
            --gdi-green-dark: #0c5c29;
            --gdi-orange: #f58220;
            --gdi-orange-dark: #d96f12;
            --font-family-base: 'Manrope', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        body, input, button, select, textarea {
            font-family: 'Manrope', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #e6f4ea 50%, #fdf8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 10px;
            font-size: 0.84rem;
            line-height: 1.5;
        }
        .portal-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(17, 122, 55, 0.10), 0 4px 12px rgba(0,0,0,0.04);
            overflow: hidden;
            background: #ffffff;
            width: 100%;
            max-width: 440px;
        }
        .portal-header {
            background: linear-gradient(135deg, var(--gdi-green) 0%, var(--gdi-green-dark) 100%);
            padding: 24px 20px 20px;
            text-align: center;
            color: #ffffff;
            position: relative;
        }
        .portal-header h4 {
            font-size: 1.15rem !important;
            font-weight: 700;
        }
        .portal-header h5 {
            font-size: 0.84rem !important;
            font-weight: 500;
            opacity: 0.92;
        }
        .portal-header::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-left: 12px solid transparent;
            border-right: 12px solid transparent;
            border-top: 12px solid var(--gdi-green-dark);
        }
        .portal-header img {
            max-height: 48px;
            background: #ffffff;
            padding: 5px 10px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.12);
            margin-bottom: 10px;
        }
        .portal-body {
            padding: 24px 24px 20px;
        }
        .form-floating label {
            color: #6c757d;
            font-size: 0.80rem;
        }
        .form-floating > .form-control {
            font-size: 0.84rem;
        }
        .form-control:focus {
            border-color: var(--gdi-green);
            box-shadow: 0 0 0 0.2rem rgba(17, 122, 55, 0.18);
        }
        .btn-gdi-login {
            background: linear-gradient(135deg, var(--gdi-green) 0%, var(--gdi-green-dark) 100%);
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 10px;
            font-size: 0.84rem;
            border-radius: 8px;
            transition: all 0.25s ease;
        }
        .btn-gdi-login:hover {
            background: linear-gradient(135deg, var(--gdi-green-dark) 0%, #08401c 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(17, 122, 55, 0.25);
            transform: translateY(-1px);
        }
        .badge-portal {
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.3);
            font-size: 0.70rem;
            letter-spacing: 0.4px;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #94a3b8;
            font-size: 0.78rem;
            margin: 18px 0 14px;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        .divider::before { margin-right: .8em; }
        .divider::after { margin-left: .8em; }
        .reg-link-card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 12px;
            text-decoration: none;
            color: #334155;
            font-size: 0.80rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }
        .reg-link-card:hover {
            border-color: var(--gdi-green);
            background: #f0fdf4;
            color: var(--gdi-green-dark);
            transform: translateX(3px);
        }
        .reg-link-card.mitra:hover {
            border-color: var(--gdi-orange);
            background: #fffaf0;
            color: var(--gdi-orange-dark);
        }
    </style>
</head>
<body>

<div class="portal-card">
    <div class="portal-header">
        <img src="{{ asset('admin/assets/img/logo_gdi.png') }}" alt="Graha Dhuafa Indonesia">
        <h4 class="fw-bold mb-1 mt-2">Selamat Datang, Sahabat Baik!</h4>
        <p class="text-white">Siap Menebar Kebaikan Hari Ini?</p>
      </div>

    <div class="portal-body">
        <!-- NOTIFIKASI REGISTRASI SUKSES -->
        @if(session('registered_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bi bi-check-circle-fill fs-4 me-2 flex-shrink-0 text-success"></i>
                    <div>
                        <strong>Pendaftaran {{ session('registered_success.type') }} Diterima!</strong>
                        <div class="small mt-1">{{ session('registered_success.message') }}</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- NOTIFIKASI PENDING VERIFIKASI -->
        @if(session('pending_notice'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bi bi-hourglass-split fs-4 me-2 flex-shrink-0 text-warning"></i>
                    <div>
                        <strong>{{ session('pending_notice.title') }}</strong>
                        <div class="small mt-1">{!! session('pending_notice.message') !!}</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- ERROR VALIDASI -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('portal.login.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="login" class="form-label small fw-semibold text-secondary">Username atau Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-secondary"></i></span>
                    <input type="text" class="form-control border-start-0" id="login" name="login" value="{{ old('login') }}" placeholder="Masukkan username atau email" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="password" class="form-label small fw-semibold text-secondary mb-0">Password</label>
                </div>
                <div class="input-group mt-1">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-secondary"></i></span>
                    <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="••••••••" required>
                    <button class="btn btn-light border border-start-0" type="button" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
    </div>
            </div>

            <button type="submit" class="btn btn-gdi-login w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Portal
            </button>
        </form>

        <div class="divider">Belum Punya Akun? Daftar Disini</div>

        <!-- TOMBOL DAFTAR RELAWAN -->
        <a href="{{ route('portal.volunteer.register') }}" class="reg-link-card">
            <div class="me-3 fs-3 text-success"><i class="bi bi-heart-pulse-fill"></i></div>
            <div class="flex-grow-1">
                <div class="fw-bold text-success small">Daftar Relawan "Sahabat Baik"</div>
                <div class="text-muted" style="font-size: 0.76rem;">Bencana alam, berbagi pangan, sosial, & dokumenter</div>
            </div>
            <i class="bi bi-chevron-right text-muted"></i>
        </a>

        <!-- TOMBOL DAFTAR MITRA -->
        <a href="{{ route('portal.affiliate.register') }}" class="reg-link-card mitra">
            <div class="me-3 fs-3 text-warning"><i class="bi bi-briefcase-fill"></i></div>
            <div class="flex-grow-1">
                <div class="fw-bold text-warning-emphasis small">Daftar Mitra / Amil Zakat</div>
                <div class="text-muted" style="font-size: 0.76rem;">Kemitraan lembaga, komunitas, & program kebaikan</div>
            </div>
            <i class="bi bi-chevron-right text-muted"></i>
        </a>
    </div>
</div>

<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    function togglePassword() {
        const passInput = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
</body>
</html>

