<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Masuk ke Portal Relawan Sahabat Baik | GDI' }}</title>

    <!-- Google Fonts: Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('admin/assets/img/logo_gdi.png') }}">

    <style>
        :root {
            --gdi-primary: #117a37;
            --gdi-primary-dark: #0c5c29;
            --gdi-primary-light: #e8f5e9;
            --gdi-dark: #0f172a;
            --gdi-dark-surface: #1e293b;
            --gdi-muted: #64748b;
            --gdi-border: #e2e8f0;
            --font-family: 'Manrope', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family) !important;
            background-color: #f6f7f9;
            background-image: 
                radial-gradient(at 10% 10%, rgba(17, 122, 55, 0.05) 0px, transparent 50%),
                radial-gradient(at 90% 90%, rgba(245, 130, 32, 0.04) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 18px;
            color: #1e293b;
            margin: 0;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 1140px;
            background: #ffffff;
            border-radius: 36px;
            box-shadow: 0 20px 60px -15px rgba(15, 23, 42, 0.07), 0 0 1px 1px rgba(0, 0, 0, 0.02);
            padding: 24px;
            overflow: hidden;
        }

        .auth-container {
            display: flex;
            align-items: stretch;
            min-height: 640px;
        }

        /* LEFT COLUMN: FORM */
        .auth-form-col {
            flex: 1 1 48%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 44px 20px 24px;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
            text-decoration: none;
        }

        .brand-logo-img {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

        .brand-name {
            font-size: 0.96rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.2px;
            line-height: 1.2;
            margin: 0;
        }

        .brand-name span {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--gdi-muted);
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .auth-title-area {
            margin-bottom: 26px;
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.8px;
            margin-bottom: 6px;
        }

        .auth-subtitle {
            font-size: 0.84rem;
            color: var(--gdi-muted);
            margin: 0;
        }

        /* INPUTS */
        .form-group-custom {
            margin-bottom: 18px;
        }

        .form-label-custom {
            display: block;
            font-size: 0.80rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 7px;
            letter-spacing: -0.1px;
        }

        .input-box-custom {
            position: relative;
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .input-box-custom:focus-within {
            border-color: #00885a;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.08);
        }

        .input-box-custom .input-icon {
            padding-left: 14px;
            color: #94a3b8;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            pointer-events: none;
        }

        .input-box-custom .form-control-custom {
            width: 100%;
            border: none;
            background: transparent;
            padding: 12px 14px;
            font-size: 0.86rem;
            color: #0f172a;
            outline: none;
            font-family: inherit;
        }

        .input-box-custom .form-control-custom::placeholder {
            color: #94a3b8;
            font-size: 0.84rem;
        }

        .input-box-custom .btn-toggle-eye {
            border: none;
            background: transparent;
            padding-right: 14px;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.15s ease;
            display: flex;
            align-items: center;
        }

        .input-box-custom .btn-toggle-eye:hover {
            color: #334155;
        }

        /* REMEMBER & FORGOT */
        .auth-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 6px;
            margin-bottom: 22px;
            font-size: 0.80rem;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
            color: #475569;
            margin: 0;
            font-weight: 500;
        }

        .custom-checkbox input[type="checkbox"] {
            width: 17px;
            height: 17px;
            border-radius: 5px;
            accent-color: #0f172a;
            cursor: pointer;
        }

        .forgot-link {
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.15s;
        }

        .forgot-link:hover {
            color: #0f172a;
            text-decoration: underline;
        }

        /* PRIMARY BUTTON */
        .btn-signin-primary {
            width: 100%;
            background: #0f172a;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 13px 20px;
            font-size: 0.88rem;
            font-weight: 700;
            letter-spacing: 0.2px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.18);
        }

        .btn-signin-primary:hover {
            background: #1e293b;
            color: #ffffff;
            transform: translateY(-1.5px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.25);
        }

        .btn-signin-primary:active {
            transform: translateY(0);
        }

        /* SIGN UP FOOTER */
        .auth-signup-text {
            font-size: 0.82rem;
            color: #64748b;
            text-align: center;
            margin-top: 18px;
            margin-bottom: 12px;
        }

        .auth-signup-text a {
            color: var(--gdi-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-signup-text a:hover {
            color: var(--gdi-primary-dark);
            text-decoration: underline;
        }

        /* SOCIAL / SHORTCUT ICONS */
        .social-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-top: 10px;
            padding-top: 14px;
            border-top: 1px solid #f1f5f9;
        }

        .social-circle-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            color: #475569;
            font-size: 1.15rem;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .social-circle-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }

        .social-circle-btn.google:hover {
            color: #ea4335;
            border-color: #fca5a5;
            background: #fff5f5;
        }

        .social-circle-btn.whatsapp:hover {
            color: #25d366;
            border-color: #86efac;
            background: #f0fdf4;
        }

        .social-circle-btn.web:hover {
            color: var(--gdi-primary);
            border-color: #86efac;
            background: #f0fdf4;
        }

        /* RIGHT COLUMN: HERO BANNER */
        .auth-banner-col {
            flex: 1 1 52%;
            position: relative;
            border-radius: 30px;
            overflow: hidden;
            background-image: url('{{ asset('images/login_volunteer/bg_login.jpg') }}');
            background-size: cover;
            background-position: center center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 38px 36px 32px 36px;
        }

        /* OVERLAY & VIGNETTE EFFECT (Subtle & tidak terlalu bold) */
        .auth-banner-overlay {
            position: absolute;
            inset: 0;
            background: 
                /* Efek vignette halus melingkar di pinggir foto */
                radial-gradient(ellipse at 50% 50%, transparent 45%, rgba(0, 0, 0, 0.35) 80%, rgba(0, 0, 0, 0.65) 100%),
                /* Gradasi halus ke bawah agar teks tetap terbaca jelas */
                linear-gradient(180deg, rgba(0, 0, 0, 0.05) 0%, rgba(0, 0, 0, 0.25) 50%, rgba(0, 0, 0, 0.78) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .banner-content-inner {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        /* WATERMARK LOGO TOP */
        .banner-watermark-symbol {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 24px;
        }

        .banner-watermark-symbol svg {
            width: 90px;
            height: 90px;
            opacity: 0.35;
            filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.5));
            transition: opacity 0.3s ease;
        }

        .banner-watermark-symbol:hover svg {
            opacity: 0.55;
        }

        /* BANNER TEXT SECTION */
        .banner-intro-area {
            margin-bottom: 26px;
        }

        .banner-brand-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 30px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #cbd5e1;
            margin-bottom: 14px;
            backdrop-filter: blur(8px);
        }

        .banner-brand-pill .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #22c55e;
            box-shadow: 0 0 8px #22c55e;
        }

        .banner-headline {
            font-size: 1.85rem;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.6px;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .banner-desc {
            font-size: 0.84rem;
            line-height: 1.6;
            color: #cbd5e1;
            margin-bottom: 14px;
            max-width: 440px;
        }

        .banner-stat {
            font-size: 0.76rem;
            font-weight: 600;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .banner-stat i {
            color: #38bdf8;
        }

        /* FLOATING ACTION CARD (Matching Reference Image) */
        .banner-floating-card {
            background: rgba(30, 41, 59, 0.78);
            border: 1px solid rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 22px;
            padding: 22px 24px;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.45);
        }

        .floating-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.35;
            margin-bottom: 8px;
            letter-spacing: -0.2px;
        }

        .floating-card-text {
            font-size: 0.78rem;
            color: #94a3b8;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .floating-card-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .badge-volunteer-type {
            font-size: 0.70rem;
            font-weight: 700;
            background: rgba(17, 122, 55, 0.35);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, 0.4);
            padding: 4px 10px;
            border-radius: 8px;
            letter-spacing: 0.3px;
        }

        /* AVATAR STACK (Matching Reference Image) */
        .avatar-stack {
            display: flex;
            align-items: center;
        }

        .avatar-stack-item {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid #1e293b;
            margin-left: -9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.70rem;
            font-weight: 800;
            color: #ffffff;
            object-fit: cover;
            background-color: #334155;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }

        .avatar-stack-item:first-child {
            margin-left: 0;
        }

        .avatar-stack-item.av-1 { background: linear-gradient(135deg, #10b981, #047857); }
        .avatar-stack-item.av-2 { background: linear-gradient(135deg, #f59e0b, #b45309); }
        .avatar-stack-item.av-3 { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .avatar-stack-item.av-count {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
            font-size: 0.68rem;
            letter-spacing: -0.3px;
        }

        /* ALERTS */
        .alert-custom {
            border-radius: 12px;
            font-size: 0.82rem;
            padding: 12px 14px;
            margin-bottom: 18px;
            border: none;
        }

        /* RESPONSIVE */
        @media (max-width: 991.98px) {
            .auth-wrapper {
                padding: 16px;
                border-radius: 26px;
            }
            .auth-container {
                flex-direction: column-reverse;
                min-height: auto;
            }
            .auth-form-col {
                padding: 24px 10px 10px 10px;
            }
            .auth-banner-col {
                min-height: 400px;
                padding: 28px 24px 24px 24px;
            }
            .banner-watermark-symbol {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper shadow">
    <div class="auth-container ">
        
        <!-- ==========================================
             LEFT COLUMN: LOGIN FORM
             ========================================== -->
        <div class="auth-form-col">
            <div>
                <!-- Brand Header -->
                <a href="{{ url('/') }}" class="brand-header">
                    <img src="{{ asset('admin/assets/img/logo_gdi.png') }}" alt="Logo GDI" class="brand-logo-img">
                    <h1 class="brand-name">
                        Graha Dhuafa Indonesia
                        <span>Portal Sahabat Baik & Relawan</span>
                    </h1>
                </a>

                <!-- Title & Subtitle -->
                <div class="auth-title-area">
                    <h2 class="auth-title">Sign in</h2>
                    <p class="auth-subtitle">Silakan masukkan akun Anda untuk masuk ke portal relawan.</p>
                </div>

                <!-- ALERTS: Pendaftaran Sukses -->
                @if(session('registered_success'))
                    <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            <div>
                                <strong>Pendaftaran Diterima!</strong>
                                <div class="mt-1">{{ session('registered_success.message') }}</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- ALERTS: Pending Verifikasi -->
                @if(session('pending_notice'))
                    <div class="alert alert-warning alert-custom alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-hourglass-split text-warning fs-5"></i>
                            <div>
                                <strong>{{ session('pending_notice.title') }}</strong>
                                <div class="mt-1">{!! session('pending_notice.message') !!}</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- ALERTS: Error Validasi -->
                @if($errors->any())
                    <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-circle-fill fs-5"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- FORM LOGIN -->
                <form action="{{ route('portal.login.post') }}" method="POST">
                    @csrf

                    <!-- Email / Username Input -->
                    <div class="form-group-custom">
                        <label for="login" class="form-label-custom">Email Address</label>
                        <div class="input-box-custom">
                            <span class="input-icon">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="text" 
                                   class="form-control-custom" 
                                   id="login" 
                                   name="login" 
                                   value="{{ old('login') }}" 
                                   placeholder="johndoe@gmail.com atau username" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="form-group-custom">
                        <label for="password" class="form-label-custom">Password</label>
                        <div class="input-box-custom">
                            <span class="input-icon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" 
                                   class="form-control-custom" 
                                   id="password" 
                                   name="password" 
                                   placeholder="••••••••" 
                                   required>
                            <button type="button" class="btn-toggle-eye" onclick="togglePasswordVisibility()" aria-label="Lihat Password">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Options: Remember Me & Forgot Password -->
                    <div class="auth-options">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember me</span>
                        </label>
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin%20GDI,%20saya%20lupa%20password%20akun%20portal%20relawan" target="_blank" class="forgot-link">
                            Forgot Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-signin-primary">
                        <span>Sign in</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <!-- Sign Up Text -->
                <div class="auth-signup-text">
                    Don't have an account? 
                    <a href="{{ route('portal.volunteer.register') }}">Sign up Relawan</a>
                    <span class="mx-1 text-muted">•</span>
                    <a href="{{ route('portal.affiliate.register') }}" class="text-secondary fw-semibold">Daftar Mitra</a>
                </div>
            </div>

            <!-- Social / Quick Shortcuts at Bottom -->
            <div>
                <div class="social-row">
                    <!-- Website Utama -->
                    <a href="{{ url('/') }}" class="social-circle-btn web" title="Website Utama Graha Dhuafa Indonesia">
                        <i class="bi bi-globe2"></i>
                    </a>
                    <!-- WhatsApp Admin -->
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20GDI,%20saya%20ingin%20bertanya%20seputar%20Relawan%20Sahabat%20Baik" target="_blank" class="social-circle-btn whatsapp" title="Hubungi Admin WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <!-- Google / Portal Bantuan -->
                    <a href="{{ route('portal.volunteer.register') }}" class="social-circle-btn google" title="Gabung Sebagai Relawan Baru">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- ==========================================
             RIGHT COLUMN: HERO BANNER (Design from Reference)
             ========================================== -->
        <div class="auth-banner-col">
            <div class="auth-banner-overlay"></div>

            <div class="banner-content-inner">
                <!-- Mid Text Content -->
                <div class="banner-intro-area">
                    <h3 class="banner-headline">Welcome to Sahabat Baik</h3>
                    <p class="banner-desc">
                        Graha Dhuafa Indonesia senantiasa berkomitmen untuk terus ambil peran dalam menjaga generasi pelanjut. Jadilah bagian dari aksi kemanusiaan dan kepedulian bersama kami.
                    </p>
                    <div class="banner-stat">
                        <i class="bi bi-people-fill"></i>
                        More than 500+ volunteers joined us, it's your turn
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Show / Hide Password Script -->
<script>
    function togglePasswordVisibility() {
        const passInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        
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
