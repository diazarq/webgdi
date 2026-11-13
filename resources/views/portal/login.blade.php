<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Login Portal Sahabat Baik & Mitra | GDI' }}</title>

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
        }
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #e6f4ea 50%, #fdf8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            padding: 20px 10px;
        }
        .portal-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(17, 122, 55, 0.12), 0 5px 15px rgba(0,0,0,0.04);
            overflow: hidden;
            background: #ffffff;
            width: 100%;
            max-width: 480px;
        }
        .portal-header {
            background: linear-gradient(135deg, var(--gdi-green) 0%, var(--gdi-green-dark) 100%);
            padding: 30px 25px 25px;
            text-align: center;
            color: #ffffff;
            position: relative;
        }
        .portal-header::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            border-left: 14px solid transparent;
            border-right: 14px solid transparent;
            border-top: 14px solid var(--gdi-green-dark);
        }
        .portal-header img {
            max-height: 58px;
            background: #ffffff;
            padding: 6px 12px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            margin-bottom: 12px;
        }
        .portal-body {
            padding: 35px 30px 25px;
        }
        .form-floating label {
            color: #6c757d;
        }
        .form-control:focus {
            border-color: var(--gdi-green);
            box-shadow: 0 0 0 0.25rem rgba(17, 122, 55, 0.2);
        }
        .btn-gdi-login {
            background: linear-gradient(135deg, var(--gdi-green) 0%, var(--gdi-green-dark) 100%);
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.25s ease;
        }
        .btn-gdi-login:hover {
            background: linear-gradient(135deg, var(--gdi-green-dark) 0%, #08401c 100%);
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(17, 122, 55, 0.3);
            transform: translateY(-1px);
        }
        .badge-portal {
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.3);
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            padding: 5px 12px;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #94a3b8;
            font-size: 0.85rem;
            margin: 22px 0 16px;
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
            border-radius: 12px;
            padding: 12px 14px;
            text-decoration: none;
            color: #334155;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
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
        <h4 class="fw-bold mb-1">PORTAL RELAWAN & MITRA</h4>
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

        <div class="text-center mt-3">
            <a href="/" class="text-decoration-none small text-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Website Utama GDI
            </a>
        </div>
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

