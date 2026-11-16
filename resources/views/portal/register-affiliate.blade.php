<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Pendaftaran Kemitraan & Amil Zakat | Graha Dhuafa Indonesia' }}</title>

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
            --gdi-orange: #f58220;
            --gdi-orange-dark: #d96f12;
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
                radial-gradient(at 10% 10%, rgba(245, 130, 32, 0.05) 0px, transparent 50%),
                radial-gradient(at 90% 90%, rgba(17, 122, 55, 0.04) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            color: #1e293b;
            margin: 0;
        }

        /* WRAPPER LEBAR DAN MEWAH (SAMA DENGAN RELAWAN) */
        .auth-wrapper {
            width: 96%;
            max-width: 1360px;
            background: #ffffff;
            border-radius: 40px;
            box-shadow: 0 25px 70px -15px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(0, 0, 0, 0.02);
            padding: 30px;
            overflow: hidden;
        }

        /* CONTAINER 2 KOLOM DENGAN GAP 32PX */
        .auth-container {
            display: flex;
            align-items: stretch;
            gap: 32px;
            min-height: 760px;
        }

        /* LEFT COLUMN: FORM KEMITRAAN */
        .auth-form-col {
            flex: 1 1 56%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 28px 18px 24px;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
            text-decoration: none;
        }

        .brand-logo-img {
            height: 46px;
            width: auto;
            object-fit: contain;
        }

        .brand-name {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.2px;
            line-height: 1.25;
            margin: 0;
        }

        .brand-name span {
            display: block;
            font-size: 0.74rem;
            font-weight: 600;
            color: var(--gdi-muted);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .auth-title-area {
            margin-bottom: 26px;
        }

        .auth-title {
            font-size: 2.15rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.8px;
            margin-bottom: 8px;
        }

        .auth-subtitle {
            font-size: 0.88rem;
            color: var(--gdi-muted);
            margin: 0;
            line-height: 1.6;
        }

        /* SECTION SUBHEADERS */
        .section-label-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.76rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #b45309;
            background: #fef3c7;
            padding: 6px 14px;
            border-radius: 8px;
            margin-bottom: 14px;
            margin-top: 8px;
        }

        /* INPUTS LAPANG & NYAMAN */
        .form-group-custom {
            margin-bottom: 18px;
        }

        .form-label-custom {
            display: block;
            font-size: 0.80rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
            letter-spacing: -0.1px;
        }

        .input-box-custom {
            position: relative;
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            min-height: 48px;
        }

        .input-box-custom:focus-within {
            border-color: #0f172a;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.08);
        }

        .input-box-custom .input-icon {
            padding-left: 16px;
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
            padding: 13px 16px;
            font-size: 0.86rem;
            color: #0f172a;
            outline: none;
            font-family: inherit;
        }

        .input-box-custom textarea.form-control-custom {
            resize: vertical;
            min-height: 86px;
            line-height: 1.5;
        }

        .input-box-custom .form-control-custom::placeholder {
            color: #94a3b8;
            font-size: 0.84rem;
        }

        .input-box-custom .btn-toggle-eye {
            border: none;
            background: transparent;
            padding-right: 16px;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.15s ease;
            display: flex;
            align-items: center;
            font-size: 1.05rem;
        }

        .input-box-custom .btn-toggle-eye:hover {
            color: #334155;
        }

        /* PRIMARY BUTTON */
        .btn-signin-primary {
            width: 100%;
            background: #0f172a;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 15px 24px;
            font-size: 0.92rem;
            font-weight: 700;
            letter-spacing: 0.2px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.18);
            margin-top: 14px;
        }

        .btn-signin-primary:hover {
            background: #1e293b;
            color: #ffffff;
            transform: translateY(-1.5px);
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.25);
        }

        .btn-signin-primary:active {
            transform: translateY(0);
        }

        /* FOOTER TEXT */
        .auth-signup-text {
            font-size: 0.84rem;
            color: #64748b;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 12px;
        }

        .auth-signup-text a {
            color: #d97706;
            font-weight: 700;
            text-decoration: none;
        }

        .auth-signup-text a:hover {
            color: #b45309;
            text-decoration: underline;
        }

        /* SOCIAL / SHORTCUT ICONS */
        .social-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 10px;
            padding-top: 16px;
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

        /* ===================================================
           RIGHT COLUMN: HERO BANNER DENGAN MOCKUP DASHBOARD
           (Mengikuti referensi visual yang diberikan)
           =================================================== */
        .auth-banner-col {
            flex: 1 1 44%;
            position: relative;
            border-radius: 32px;
            overflow: hidden;
            background: linear-gradient(145deg, #0b3d1f 0%, #0d2818 45%, #081a10 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px 38px 36px 38px;
            color: #ffffff;
        }

        /* EFEK VIGNETTE & AMBIENT GLOW */
        .auth-banner-overlay {
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(ellipse at 50% 30%, rgba(34, 197, 94, 0.12) 0%, transparent 60%),
                radial-gradient(ellipse at 50% 50%, transparent 40%, rgba(0, 0, 0, 0.40) 75%, rgba(0, 0, 0, 0.85) 100%),
                linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.45) 60%, rgba(0, 0, 0, 0.90) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .banner-content-inner {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .banner-top-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 30px;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #ffffff;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            align-self: flex-start;
            margin-bottom: 18px;
        }

        .banner-top-pill .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #f59e0b;
            box-shadow: 0 0 10px #f59e0b;
        }

        .banner-headline {
            font-size: 2.10rem;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.6px;
            color: #ffffff;
            margin-bottom: 12px;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.45);
        }

        .banner-desc {
            font-size: 0.88rem;
            line-height: 1.65;
            color: #cbd5e1;
            margin-bottom: 24px;
            max-width: 480px;
        }

        /* FLOATING DASHBOARD MOCKUP CARD (Sesuai Referensi Gambar) */
        .mockup-dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
            color: #1e293b;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(16px);
        }

        .mockup-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 14px;
        }

        .mockup-title {
            font-size: 0.82rem;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .mockup-badge {
            font-size: 0.68rem;
            font-weight: 700;
            background: #dcfce7;
            color: #15803d;
            padding: 3px 8px;
            border-radius: 6px;
        }

        .mockup-stats-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 14px;
        }

        .mockup-stat-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 12px;
        }

        .mockup-stat-label {
            font-size: 0.68rem;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .mockup-stat-val {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
        }

        .mockup-ref-box {
            background: #fffbeb;
            border: 1px dashed #fcd34d;
            border-radius: 10px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.74rem;
        }

        .mockup-ref-link {
            font-family: monospace;
            color: #92400e;
            font-weight: 700;
        }

        /* PARTNER TRUST LOGOS AT BOTTOM */
        .partner-trust-section {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
        }

        .partner-trust-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            margin-bottom: 12px;
        }

        .partner-trust-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .trust-pill {
            font-size: 0.72rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 5px 12px;
            border-radius: 8px;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .trust-pill i {
            color: #38bdf8;
        }

        /* ALERTS */
        .alert-custom {
            border-radius: 14px;
            font-size: 0.84rem;
            padding: 14px 16px;
            margin-bottom: 20px;
            border: none;
        }

        /* RESPONSIVE */
        @media (max-width: 1199.98px) {
            .auth-wrapper {
                width: 98%;
                padding: 24px;
            }
            .auth-container {
                gap: 24px;
            }
            .auth-form-col {
                padding: 16px;
            }
        }

        @media (max-width: 991.98px) {
            body {
                padding: 18px 12px;
            }
            .auth-wrapper {
                padding: 18px;
                border-radius: 28px;
            }
            .auth-container {
                flex-direction: column-reverse;
                gap: 20px;
                min-height: auto;
            }
            .auth-form-col {
                padding: 16px 8px 8px 8px;
            }
            .auth-banner-col {
                min-height: 440px;
                padding: 32px 24px 28px 24px;
                border-radius: 24px;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper shadow">
    <div class="auth-container">
        
        <!-- ==========================================
             LEFT COLUMN: REGISTER MITRA / AMIL FORM
             ========================================== -->
        <div class="auth-form-col">
            <div>
                <!-- Brand Header -->
                <a href="{{ url('/') }}" class="brand-header">
                    <img src="{{ asset('admin/assets/img/logo_gdi.png') }}" alt="Logo GDI" class="brand-logo-img">
                    <h1 class="brand-name">
                        Graha Dhuafa Indonesia
                        <span>Portal Kemitraan & Amil Zakat</span>
                    </h1>
                </a>

                <!-- Title & Subtitle -->
                <div class="auth-title-area">
                    <h2 class="auth-title">Daftar Mitra</h2>
                    <p class="auth-subtitle">Daftarkan lembaga, DKM masjid, komunitas, atau instansi Anda untuk kolaborasi program kebaikan bersama GDI.</p>
                </div>

                <!-- ALERTS: Error Validasi -->
                @if($errors->any())
                    <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-exclamation-triangle-fill fs-5 mt-1 text-danger"></i>
                            <div>
                                <strong>Mohon periksa formulir pendaftaran:</strong>
                                <ul class="mb-0 mt-1 ps-3" style="font-size: 0.82rem;">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- FORM PENDAFTARAN MITRA -->
                <form action="{{ route('portal.affiliate.register.post') }}" method="POST">
                    @csrf

                    <!-- 1. IDENTITAS INSTANSI & PIC -->
                    <div class="mb-4">
                        <span class="section-label-chip">
                            <i class="bi bi-building"></i> 1. Lembaga / Instansi Kemitraan
                        </span>

                        <div class="row g-3">
                            <!-- Nama Instansi / Lembaga -->
                            <div class="col-md-6 form-group-custom">
                                <label for="instansi" class="form-label-custom">Nama Lembaga / Komunitas / DKM *</label>
                                <div class="input-box-custom">
                                    <span class="input-icon">
                                        <i class="bi bi-building"></i>
                                    </span>
                                    <input type="text" class="form-control-custom" id="instansi" name="instansi" value="{{ old('instansi') }}" placeholder="Contoh: DKM Masjid Al-Ikhlas / Yayasan Peduli" required>
                                </div>
                            </div>

                            <!-- Nama PIC -->
                            <div class="col-md-6 form-group-custom">
                                <label for="name" class="form-label-custom">Nama Lengkap Penanggung Jawab (PIC) *</label>
                                <div class="input-box-custom">
                                    <span class="input-icon">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" class="form-control-custom" id="name" name="name" value="{{ old('name') }}" placeholder="Nama PIC Kemitraan" required>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="col-md-6 form-group-custom">
                                <label for="phone" class="form-label-custom">Nomor WhatsApp Aktif *</label>
                                <div class="input-box-custom">
                                    <span class="input-icon text-success">
                                        <i class="bi bi-whatsapp"></i>
                                    </span>
                                    <input type="text" class="form-control-custom" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                                </div>
                            </div>

                            <!-- Email Resmi -->
                            <div class="col-md-6 form-group-custom">
                                <label for="email" class="form-label-custom">Alamat Email Resmi *</label>
                                <div class="input-box-custom">
                                    <span class="input-icon">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control-custom" id="email" name="email" value="{{ old('email') }}" placeholder="mitra@lembaga.com" required>
                                </div>
                            </div>

                            <!-- Kota / Wilayah Kemitraan -->
                            <div class="col-12 form-group-custom">
                                <label for="domisili" class="form-label-custom">Kota / Wilayah Operasional Kemitraan *</label>
                                <div class="input-box-custom">
                                    <span class="input-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <input type="text" class="form-control-custom" id="domisili" name="domisili" value="{{ old('domisili') }}" placeholder="Contoh: Bandung, Cimahi, dan Jawa Barat" required>
                                </div>
                            </div>

                            <!-- Rencana Kerjasama / Profil Ringkas -->
                            <div class="col-12 form-group-custom">
                                <label for="organisasi" class="form-label-custom">Rencana Program Kerjasama & Profil Singkat *</label>
                                <div class="input-box-custom align-items-start pt-1">
                                    <span class="input-icon pt-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </span>
                                    <textarea class="form-control-custom" id="organisasi" name="organisasi" rows="3" placeholder="Jelaskan bidang kerjasama yang diharapkan (misal: Unit Pengumpul Zakat, Penyaluran Sembako Beras, DKM Masjid, CSR Perusahaan, atau Komunitas Donasi)." required>{{ old('organisasi') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. AKUN AKSES PORTAL -->
                    <div class="mb-4">
                        <span class="section-label-chip">
                            <i class="bi bi-shield-lock-fill"></i> 2. Akun Akses Portal Mitra
                        </span>

                        <div class="row g-3">
                            <!-- Username -->
                            <div class="col-12 form-group-custom">
                                <label for="username" class="form-label-custom">Username Login *</label>
                                <div class="input-box-custom">
                                    <span class="input-icon">
                                        <i class="bi bi-at"></i>
                                    </span>
                                    <input type="text" class="form-control-custom" id="username" name="username" value="{{ old('username') }}" placeholder="username_mitra (huruf & angka tanpa spasi)" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 form-group-custom">
                                <label for="password" class="form-label-custom">Password *</label>
                                <div class="input-box-custom">
                                    <span class="input-icon">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control-custom" id="password" name="password" placeholder="Minimal 6 karakter" required>
                                    <button type="button" class="btn-toggle-eye" onclick="togglePassVisibility('password', 'togglePassIcon1')" aria-label="Lihat Password">
                                        <i class="bi bi-eye" id="togglePassIcon1"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 form-group-custom">
                                <label for="password_confirmation" class="form-label-custom">Konfirmasi Password *</label>
                                <div class="input-box-custom">
                                    <span class="input-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </span>
                                    <input type="password" class="form-control-custom" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                                    <button type="button" class="btn-toggle-eye" onclick="togglePassVisibility('password_confirmation', 'togglePassIcon2')" aria-label="Lihat Password">
                                        <i class="bi bi-eye" id="togglePassIcon2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-signin-primary">
                        <span>Ajukan Pendaftaran Kemitraan</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <!-- Footer Sign In Link -->
                <div class="auth-signup-text">
                    Sudah memiliki akun mitra? 
                    <a href="{{ route('portal.login') }}">Masuk ke Portal Mitra</a>
                    <span class="mx-1 text-muted">•</span>
                    <a href="{{ route('portal.volunteer.register') }}" class="text-secondary fw-semibold">Daftar Relawan Lapangan</a>
                </div>
            </div>

            <!-- Social / Shortcuts at Bottom -->
            <div>
                <div class="social-row">
                    <!-- Website Utama -->
                    <a href="{{ url('/') }}" class="social-circle-btn web" title="Website Utama Graha Dhuafa Indonesia">
                        <i class="bi bi-globe2"></i>
                    </a>
                    <!-- WhatsApp Admin -->
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20GDI,%20saya%20ingin%20bertanya%20seputar%20Kemitraan%20dan%20Amil%20Zakat" target="_blank" class="social-circle-btn whatsapp" title="Hubungi Admin Kemitraan">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <!-- Portal Bantuan / Program -->
                    <a href="{{ url('/') }}" class="social-circle-btn google" title="Kembali ke Beranda">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- ==========================================
             RIGHT COLUMN: HERO BANNER DENGAN MOCKUP DASHBOARD
             (Layout referensi visual modern dengan vignette & showcase)
             ========================================== -->
        <div class="auth-banner-col">
            <!-- VIGNETTE OVERLAY -->
            <div class="auth-banner-overlay"></div>

            <div class="banner-content-inner">
                <!-- Top Section: Badge & Headline -->
                <div>
                    <div class="banner-top-pill">
                        <span class="pulse-dot"></span>
                        <span>Program Sinergi Kemitraan GDI</span>
                    </div>

                    <h3 class="banner-headline">Kolaborasi Kebaikan Bersama Graha Dhuafa Indonesia</h3>
                    <p class="banner-desc">
                        Wadah sinergi bagi lembaga, DKM masjid, komunitas, dan korporasi untuk memperluas jangkauan penghimpunan zakat, infak, sedekah, dan aksi kepedulian yang transparan.
                    </p>
                </div>

                <!-- Mid Section: Dashboard Preview Mockup Card (Sesuai Visual Reference) -->
                <div class="mockup-dashboard-card">
                    <div class="mockup-header">
                        <div class="mockup-title">
                            <i class="bi bi-grid-fill text-success"></i>
                            <span>Portal Mitra & Afiliasi GDI</span>
                        </div>
                        <span class="mockup-badge">
                            <i class="bi bi-check-circle-fill me-1"></i> Terverifikasi
                        </span>
                    </div>

                    <div class="mockup-stats-row">
                        <div class="mockup-stat-box">
                            <div class="mockup-stat-label">Total Donasi Terhimpun</div>
                            <div class="mockup-stat-val text-success">Rp 18.750.000</div>
                        </div>
                        <div class="mockup-stat-box">
                            <div class="mockup-stat-label">Aksi Sosial Bersama</div>
                            <div class="mockup-stat-val text-dark">14 Program</div>
                        </div>
                    </div>

                    <div class="mockup-ref-box">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-link-45deg text-warning fs-5"></i>
                            <div>
                                <span class="d-block" style="font-size: 0.65rem; color: #78350f;">Link Donasi Khusus Mitra:</span>
                                <span class="mockup-ref-link">gdi.or.id/donasi?ref=lembaga_anda</span>
                            </div>
                        </div>
                        <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 0.65rem; border-radius: 6px;">Siap Pakai</span>
                    </div>
                </div>

                <!-- Bottom Section: Partner Trust Badges (Sesuai Referensi Visual) -->
                <div class="partner-trust-section">
                    <div class="partner-trust-label">Jaringan Mitra & Kolaborator Kebaikan:</div>
                    <div class="partner-trust-pills">
                        <span class="trust-pill"><i class="bi bi-building"></i> DKM Masjid</span>
                        <span class="trust-pill"><i class="bi bi-heart-fill"></i> Komunitas Amal</span>
                        <span class="trust-pill"><i class="bi bi-award-fill"></i> Lembaga Zakat</span>
                        <span class="trust-pill"><i class="bi bi-briefcase-fill"></i> CSR Perusahaan</span>
                        <span class="trust-pill"><i class="bi bi-mortarboard-fill"></i> Kampus & Sekolah</span>
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
    function togglePassVisibility(inputId, iconId) {
        const passInput = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
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
