<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Daftar Relawan Sahabat Baik | Graha Dhuafa Indonesia' }}</title>

    <!-- Fonts: Manrope (Sesuai dengan font website utama GDI) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('admin/assets/img/logo_gdi.png') }}">

    <style>
        :root {
            --gdi-green: #117a37;
            --gdi-green-dark: #0c5c29;
            --gdi-orange: #f58220;
        }
        body, input, button, select, textarea {
            font-family: 'Manrope', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #e6f7ed 50%, #fdf8f0 100%);
            min-height: 100vh;
            padding: 24px 15px;
            font-size: 0.84rem;
            line-height: 1.5;
        }
        .register-container {
            max-width: 680px;
            margin: 0 auto;
        }
        .card-register {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(17, 122, 55, 0.10);
            overflow: hidden;
            background: #ffffff;
        }
        .header-banner {
            background: linear-gradient(135deg, var(--gdi-green) 0%, var(--gdi-green-dark) 100%);
            color: #ffffff;
            padding: 22px 20px;
            position: relative;
        }
        .header-banner h3 {
            font-size: 1.20rem !important;
            font-weight: 700;
        }
        .header-banner p {
            font-size: 0.80rem !important;
        }
        .header-banner img {
            max-height: 44px;
            background: #ffffff;
            padding: 4px 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .btn-register-submit {
            background: linear-gradient(135deg, var(--gdi-green) 0%, var(--gdi-green-dark) 100%);
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 0.86rem;
            transition: all 0.25s ease;
        }
        .btn-register-submit:hover {
            background: linear-gradient(135deg, var(--gdi-green-dark) 0%, #063416 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(17, 122, 55, 0.3);
            transform: translateY(-1px);
        }
        .form-section-title {
            font-size: 0.80rem;
            font-weight: 700;
            color: var(--gdi-green);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-section-title::after {
            content: '';
            flex: 1;
            border-bottom: 1px dashed #d1fae5;
        }
        .form-label {
            font-size: 0.80rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 4px;
        }
        .form-control, .form-select {
            font-size: 0.84rem;
            padding: 7px 12px;
            border-radius: 8px;
        }
        .interest-card {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 0.82rem;
            cursor: pointer;
            transition: all 0.2s ease;
            height: 100%;
        }
        .interest-card:hover {
            border-color: var(--gdi-green);
            background: #f0fdf4;
        }
        .interest-card input[type="radio"]:checked + label {
            color: var(--gdi-green);
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="text-center mb-3">
        <a href="/" class="text-decoration-none text-secondary small">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda GDI
        </a>
    </div>

    <div class="card card-register">
        <div class="header-banner text-center">
            <img src="{{ asset('admin/assets/img/logo_gdi.png') }}" alt="GDI">
            <h3 class="fw-bold mb-1">Pendaftaran Relawan "Sahabat Baik"</h3>
            <p class="mb-0 opacity-90 small">Mari bersama melangkah, menghadirkan senyum dan kebaikan untuk sesama dhuafa.</p>
        </div>

        <div class="card-body p-4 p-md-5">
            

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Periksa kembali data formulir:</strong>
                    <ul class="mb-0 mt-1 small">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('portal.volunteer.register.post') }}" method="POST">
                @csrf

                <!-- SEKSI 1: PILIHAN RELAWAN -->
                <div class="form-section-title">
                    <i class="bi bi-compass-fill"></i> 1. Bidang Minat Relawan
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="interest-card d-flex align-items-center gap-2">
                            <input type="radio" name="volunteer_type" value="Tanggap Bencana Alam" class="form-check-input mt-0" {{ old('volunteer_type', 'Tanggap Bencana Alam') == 'Tanggap Bencana Alam' ? 'checked' : '' }} required>
                            <div>
                                <strong class="d-block text-dark">Tanggap Bencana Alam</strong>
                                <span class="small text-muted">Evakuasi, dapur umum, & logistik darurat.</span>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="interest-card d-flex align-items-center gap-2">
                            <input type="radio" name="volunteer_type" value="Berbagi Pangan & Sosial" class="form-check-input mt-0" {{ old('volunteer_type') == 'Berbagi Pangan & Sosial' ? 'checked' : '' }}>
                            <div>
                                <strong class="d-block text-dark">Berbagi Pangan & Sosial</strong>
                                <span class="small text-muted">Santunan dhuafa, yatim, & sembako berkah.</span>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="interest-card d-flex align-items-center gap-2">
                            <input type="radio" name="volunteer_type" value="Dokumenter & Publikasi Media" class="form-check-input mt-0" {{ old('volunteer_type') == 'Dokumenter & Publikasi Media' ? 'checked' : '' }}>
                            <div>
                                <strong class="d-block text-dark">Dokumenter & Media</strong>
                                <span class="small text-muted">Foto, video liputan, & penulisan berita aksi.</span>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="interest-card d-flex align-items-center gap-2">
                            <input type="radio" name="volunteer_type" value="Pendidikan & Dakwah" class="form-check-input mt-0" {{ old('volunteer_type') == 'Pendidikan & Dakwah' ? 'checked' : '' }}>
                            <div>
                                <strong class="d-block text-dark">Pendidikan & Dakwah</strong>
                                <span class="small text-muted">Bimbingan belajar anak dhuafa & pemberdayaan.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- SEKSI 2: DATA DIRI -->
                <div class="form-section-title">
                    <i class="bi bi-person-badge-fill"></i> 2. Identitas Diri
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nama Lengkap *</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Contoh: Muhammad Fatih" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nomor WhatsApp Aktif *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-whatsapp text-success"></i></span>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Alamat Email *</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email@gmail.com" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Kota / Domisili Saat Ini *</label>
                        <input type="text" class="form-control" name="domisili" value="{{ old('domisili') }}" placeholder="Contoh: Bandung / Cimahi" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Pengalaman Organisasi & Keahlian Relawan *</label>
                        <textarea class="form-control" name="organisasi" rows="3" placeholder="Ceritakan pengalaman kepanitiaan, komunitas, PMI, Pramuka, pecinta alam, atau keahlian spesifik Anda (desain, medis, logistik, dll.)." required>{{ old('organisasi') }}</textarea>
                    </div>
                </div>

                <!-- SEKSI 3: AKUN LOGIN -->
                <div class="form-section-title">
                    <i class="bi bi-shield-lock-fill"></i> 3. Akun Login Portal
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Username Login *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">@</span>
                            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="username_kamu" required>
                        </div>
                     
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Password *</label>
                        <input type="password" class="form-control" name="password" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Konfirmasi Password *</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-register-submit">
                        <i class="bi bi-send-check me-2"></i> Kirim Pendaftaran Sahabat Baik
                    </button>
                </div>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <span class="text-muted small">Sudah memiliki akun terdaftar?</span>
                <a href="{{ route('portal.login') }}" class="fw-bold text-success text-decoration-none ms-1">
                    Masuk
                </a>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

