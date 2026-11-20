<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Daftar Relawan Sahabat Baik | Graha Dhuafa Indonesia' }}</title>

    <!-- Google Fonts: Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('admin/assets/img/logo_gdi.png') }}">

    <!-- Iconify Web Component -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

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
            padding: 40px 18px;
            color: #1e293b;
            margin: 0;
        }

        /* WRAPPER KARTU DENGAN HEADER GAMBAR DI ATAS */
        .auth-wrapper {
            width: 100%;
            max-width: 960px;
            background: #ffffff;
            border-radius: 36px;
            box-shadow: 0 25px 70px -15px rgba(15, 23, 42, 0.09), 0 0 1px 1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        /* ===================================================
           TOP HERO BANNER DENGAN FOTO & EFEK VIGNETTE
           =================================================== */
        .auth-top-banner {
            position: relative;
            background-image: url('{{ asset('images/login_volunteer/bg_login.jpg') }}');
            background-size: cover;
            background-position: center 38%;
            padding: 44px 44px 38px 44px;
            color: #ffffff;
            min-height: 290px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* EFEK VIGNETTE & GRADASI GELAP SINEMATIK */
        .auth-banner-overlay {
            position: absolute;
            inset: 0;
            background: 
                /* Efek Vignette Radial: pinggir gelap artistik */
                radial-gradient(ellipse at 50% 50%, rgba(0, 0, 0, 0.20) 25%, rgba(0, 0, 0, 0.65) 75%, rgba(0, 0, 0, 0.90) 100%),
                /* Gradasi Gelap ke Bawah untuk teks */
                linear-gradient(180deg, rgba(0, 0, 0, 0.40) 0%, rgba(0, 0, 0, 0.50) 50%, rgba(15, 23, 42, 0.96) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .banner-content-inner {
            position: relative;
            z-index: 2;
        }

        .banner-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .brand-header-banner {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo-img {
            height: 44px;
            width: auto;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.95);
            padding: 4px 8px;
            border-radius: 10px;
        }

        .brand-name-banner {
            font-size: 1.0rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.25;
            margin: 0;
        }

        .brand-name-banner span {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: #cbd5e1;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .banner-top-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            background: rgba(15, 23, 42, 0.60);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 30px;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #ffffff;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .banner-top-pill .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #22c55e;
            box-shadow: 0 0 10px #22c55e;
        }

        .banner-headline {
            font-size: 2.10rem;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.6px;
            color: #ffffff;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .banner-desc {
            font-size: 0.90rem;
            line-height: 1.6;
            color: #e2e8f0;
            margin-bottom: 16px;
            max-width: 680px;
            text-shadow: 0 1px 6px rgba(0, 0, 0, 0.4);
        }

        .banner-stat {
            font-size: 0.80rem;
            font-weight: 600;
            color: #cbd5e1;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.20);
            padding: 7px 15px;
            border-radius: 12px;
        }

        .banner-stat i {
            color: #38bdf8;
            font-size: 0.95rem;
        }

        /* ===================================================
           FORM BODY DI BAWAH BANNER GAMBAR
           =================================================== */
        .auth-form-body {
            padding: 38px 48px 34px 48px;
        }

        .auth-title-area {
            margin-bottom: 26px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .auth-title {
            font-size: 1.85rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.6px;
            margin-bottom: 6px;
        }

        .auth-subtitle {
            font-size: 0.88rem;
            color: var(--gdi-muted);
            margin: 0;
            line-height: 1.5;
        }

        /* SECTION SUBHEADERS */
        .section-label-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--gdi-primary);
            background: #eef9f2;
            padding: 6px 14px;
            border-radius: 8px;
            margin-bottom: 14px;
            margin-top: 6px;
        }

        /* RADIO CARDS FOR VOLUNTEER TYPE */
        .volunteer-types-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .type-radio-card {
            position: relative;
            cursor: pointer;
            margin: 0;
        }

        .type-radio-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .type-card-body {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 15px 16px;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            transition: all 0.2s ease;
            height: 100%;
        }

        .type-card-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f1f5f9;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .type-card-title {
            font-size: 0.84rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 3px;
            line-height: 1.3;
        }

        .type-card-desc {
            font-size: 0.74rem;
            color: #64748b;
            line-height: 1.4;
        }

        .type-radio-card:hover .type-card-body {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .type-radio-card input[type="radio"]:checked + .type-card-body {
            border-color: #117a37;
            background: #f0fdf4;
            box-shadow: 0 0 0 3px rgba(17, 122, 55, 0.12);
        }

        .type-radio-card input[type="radio"]:checked + .type-card-body .type-card-icon {
            background: #117a37;
            color: #ffffff;
        }

        .type-radio-card input[type="radio"]:checked + .type-card-body .type-card-title {
            color: #0c5c29;
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
            font-size: 0.94rem;
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

        /* FOOTER */
        .auth-signup-text {
            font-size: 0.84rem;
            color: #64748b;
            text-align: center;
            margin-top: 22px;
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

        /* ALERTS */
        .alert-custom {
            border-radius: 14px;
            font-size: 0.84rem;
            padding: 14px 16px;
            margin-bottom: 22px;
            border: none;
        }

        /* RESPONSIVE */
        @media (max-width: 767.98px) {
            body {
                padding: 16px 10px;
            }
            .auth-wrapper {
                border-radius: 26px;
            }
            .auth-top-banner {
                padding: 28px 22px;
                min-height: 240px;
            }
            .banner-top-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .auth-form-body {
                padding: 26px 18px;
            }
            .volunteer-types-grid {
                grid-template-columns: 1fr;
            }
            .banner-headline {
                font-size: 1.70rem;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    
    <!-- ==========================================
         TOP: HERO BANNER DENGAN FOTO & EFEK VIGNETTE
         ========================================== -->
    <div class="auth-top-banner">
        <!-- VIGNETTE OVERLAY -->
        <div class="auth-banner-overlay"></div>

        <div class="banner-content-inner">
            <!-- Brand & Pill -->
            <div class="banner-top-row">
                <a href="{{ url('/') }}" class="brand-header-banner">
                    <img src="{{ asset('admin/assets/img/logo_gdi.png') }}" alt="Logo GDI" class="brand-logo-img">
                    <h1 class="brand-name-banner">
                        Graha Dhuafa Indonesia
                        <span>Portal Sahabat Baik & Relawan</span>
                    </h1>
                </a>
            </div>

            <!-- Headline & Narasi -->
            <div>
                <h2 class="banner-headline">Welcome to Sahabat Baik</h2>
                <p class="banner-desc">
                    Graha Dhuafa Indonesia senantiasa berkomitmen untuk terus ambil peran dalam menjaga generasi pelanjut. Jadilah bagian dari aksi kemanusiaan dan kepedulian bersama kami.
                </p>
                <div class="banner-stat">
                    <i class="bi bi-people-fill"></i>
                    <span>More than 500+ volunteers joined us, it's your turn</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ==========================================
         BOTTOM: FORMULIR PENDAFTARAN RELAWAN
         ========================================== -->
    <div class="auth-form-body">
        
        <!-- Header Judul Form -->
        <div class="auth-title-area">
            <h3 class="auth-title">Formulir Pendaftaran Relawan</h3>
            <p class="auth-subtitle">Silakan lengkapi formulir di bawah ini dengan data yang valid untuk memulai aksi kebaikan bersama GDI.</p>
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

        <!-- FORM PENDAFTARAN -->
        <form action="{{ route('portal.volunteer.register.post') }}" method="POST">
            @csrf

            <!-- 1. BIDANG MINAT RELAWAN -->
            <div class="mb-4">
                <span class="section-label-chip">
                    <i class="bi bi-compass-fill"></i> 1. Bidang Minat Relawan
                </span>
                <div class="volunteer-types-grid">
                    <!-- Bencana -->
                    <label class="type-radio-card">
                        <input type="radio" name="volunteer_type" value="Tanggap Bencana Alam" {{ old('volunteer_type', 'Tanggap Bencana Alam') == 'Tanggap Bencana Alam' ? 'checked' : '' }} required>
                        <div class="type-card-body">
                            <div class="type-card-icon">
                                <i class="bi bi-life-preserver"></i>
                            </div>
                            <div>
                                <div class="type-card-title">Tanggap Bencana Alam</div>
                                <div class="type-card-desc">Evakuasi, dapur umum & logistik darurat</div>
                            </div>
                        </div>
                    </label>

                    <!-- Sosial & Pangan -->
                    <label class="type-radio-card">
                        <input type="radio" name="volunteer_type" value="Berbagi Pangan & Sosial" {{ old('volunteer_type') == 'Berbagi Pangan & Sosial' ? 'checked' : '' }}>
                        <div class="type-card-body">
                            <div class="type-card-icon">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                            <div>
                                <div class="type-card-title">Berbagi Pangan & Sosial</div>
                                <div class="type-card-desc">Santunan dhuafa, yatim & sembako</div>
                            </div>
                        </div>
                    </label>

                    <!-- Dokumenter -->
                    <label class="type-radio-card">
                        <input type="radio" name="volunteer_type" value="Dokumenter & Publikasi Media" {{ old('volunteer_type') == 'Dokumenter & Publikasi Media' ? 'checked' : '' }}>
                        <div class="type-card-body">
                            <div class="type-card-icon">
                                <i class="bi bi-camera-reels-fill"></i>
                            </div>
                            <div>
                                <div class="type-card-title">Dokumenter & Media</div>
                                <div class="type-card-desc">Foto, video liputan & berita aksi</div>
                            </div>
                        </div>
                    </label>

                    <!-- Pendidikan -->
                    <label class="type-radio-card">
                        <input type="radio" name="volunteer_type" value="Pendidikan & Dakwah" {{ old('volunteer_type') == 'Pendidikan & Dakwah' ? 'checked' : '' }}>
                        <div class="type-card-body">
                            <div class="type-card-icon">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <div>
                                <div class="type-card-title">Pendidikan & Dakwah</div>
                                <div class="type-card-desc">Bimbel anak dhuafa & pembinaan</div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 2. IDENTITAS DIRI -->
            <div class="mb-4">
                <span class="section-label-chip">
                    <i class="bi bi-person-badge-fill"></i> 2. Identitas Diri
                </span>

                <div class="row g-3">
                    <!-- Nama Lengkap -->
                    <div class="col-md-6 form-group-custom">
                        <label for="name" class="form-label-custom">Nama Lengkap *</label>
                        <div class="input-box-custom">
                            <span class="input-icon">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control-custom" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Muhammad Fatih" required>
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

                    <!-- Email -->
                    <div class="col-md-6 form-group-custom">
                        <label for="email" class="form-label-custom">Alamat Email *</label>
                        <div class="input-box-custom">
                            <span class="input-icon">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control-custom" id="email" name="email" value="{{ old('email') }}" placeholder="email@gmail.com" required>
                        </div>
                    </div>

                    <!-- Kota / Domisili -->
                    <div class="col-md-6 form-group-custom">
                        <label for="domisili" class="form-label-custom">Kota Domisili Saat Ini *</label>
                        <div class="input-box-custom">
                            <span class="input-icon">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <input type="text" class="form-control-custom" id="domisili" name="domisili" value="{{ old('domisili') }}" placeholder="Contoh: Bandung / Cimahi" required>
                        </div>
                    </div>

                    <!-- Pengalaman Organisasi & Keahlian -->
                    <div class="col-12 form-group-custom">
                        <label for="organisasi" class="form-label-custom">Pengalaman Organisasi & Keahlian Relawan *</label>
                        <div class="input-box-custom align-items-start pt-1">
                            <span class="input-icon pt-2">
                                <i class="bi bi-pencil-square"></i>
                            </span>
                            <textarea class="form-control-custom" id="organisasi" name="organisasi" rows="3" placeholder="Ceritakan pengalaman kepanitiaan, komunitas, PMI/Pramuka, atau keahlian spesifik Anda (desain, dokumentasi, medis, logistik, dll)." required>{{ old('organisasi') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. AKUN LOGIN PORTAL -->
            <div class="mb-4">
                <span class="section-label-chip">
                    <i class="bi bi-shield-lock-fill"></i> 3. Akun Login Portal
                </span>

                <div class="row g-3">
                    <!-- Username -->
                    <div class="col-12 form-group-custom">
                        <label for="username" class="form-label-custom">Username Login *</label>
                        <div class="input-box-custom">
                            <span class="input-icon">
                                <i class="bi bi-at"></i>
                            </span>
                            <input type="text" class="form-control-custom" id="username" name="username" value="{{ old('username') }}" placeholder="username_pilihan (huruf & angka tanpa spasi)" required>
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
                <span>Ajukan Pendaftaran Relawan</span>
                <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        <!-- Footer Sign In Link -->
        <div class="auth-signup-text">
            Sudah punya akun? 
            <a href="{{ route('portal.login') }}">Masuk ke Portal Relawan</a>
            <span class="mx-1 text-muted">•</span>
            <a href="{{ route('portal.affiliate.register') }}" class="text-secondary fw-semibold">Daftar Sebagai Mitra</a>
        </div>

        <!-- Social / Shortcuts at Bottom -->
        <div class="social-row">
            <!-- Website Utama -->
            <a href="{{ url('/') }}" class="social-circle-btn web" title="Website Utama Graha Dhuafa Indonesia">
                <i class="bi bi-globe2"></i>
            </a>
            <!-- WhatsApp Admin -->
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20GDI,%20saya%20ingin%20bertanya%20seputar%20Relawan%20Sahabat%20Baik" target="_blank" class="social-circle-btn whatsapp" title="Hubungi Admin WhatsApp">
                <i class="bi bi-whatsapp"></i>
            </a>
            <!-- Portal Bantuan / Program -->
            <a href="{{ url('/') }}" class="social-circle-btn google" title="Kembali ke Beranda">
                <i class="bi bi-heart-pulse-fill"></i>
            </a>
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
