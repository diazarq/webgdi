@extends('layout.layout-page', ['active' => @$active ?? []])
@section('title', ($pageTitle ?? 'KabarLAZ') . ' | Yayasan Graha Dhuafa Indonesia')

@section('style')
<style>
    /* ==========================================================================
       KABARLAZ GENERAL PAGE — LUXURY AURORA GLASSMORPHISM
       Hanya sampai Sorotan Utama (tanpa daftar artikel bawah)
       ========================================================================== */
    /* Hilangkan garis border atas footer khusus halaman ini agar menyatu mulus */
    body .page-wrapper footer.site-footer {
        border-top: none !important;
    }

    .kl-glass-canvas {
        position: relative;
        padding: 60px 0 135px;
        margin-bottom: -2px;
        background:
            radial-gradient(650px 420px at 8% 12%, rgba(45, 212, 167, 0.28), transparent 65%),
            radial-gradient(580px 400px at 92% 18%, rgba(56, 189, 248, 0.20), transparent 62%),
            radial-gradient(620px 440px at 50% 76%, rgba(251, 146, 60, 0.16), transparent 62%),
            linear-gradient(180deg, #052b1c 0%, #073b26 40%, #0a4e33 70%, #063824 100%);
        overflow: hidden;
        font-family: 'Manrope', sans-serif;
        color: #ffffff;
    }

    /* Tekstur titik halus di belakang kaca agar efek blur terlihat nyata */
    .kl-glass-canvas::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        background-size: 28px 28px;
        mask-image: linear-gradient(to bottom, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.2) 75%, transparent 100%);
        -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.2) 75%, transparent 100%);
        pointer-events: none;
        z-index: 1;
    }

    /* Gradasi bawah menyatu mulus ke warna footer (#00885a) tanpa garis pembatas */
    .kl-glass-canvas::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 175px;
        background: linear-gradient(
            to bottom,
            rgba(6, 56, 36, 0) 0%,
            rgba(3, 88, 58, 0.35) 35%,
            rgba(1, 116, 77, 0.75) 70%,
            #00885a 100%
        );
        pointer-events: none;
        z-index: 1;
    }

    /* Cahaya Ambient Mengambang (Bokeh Orbs) */
    .kl-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(85px);
        pointer-events: none;
        z-index: 1;
    }

    .kl-orb--mint {
        width: 340px;
        height: 340px;
        top: 40px;
        left: -80px;
        background: rgba(52, 211, 153, 0.32);
    }

    .kl-orb--cyan {
        width: 320px;
        height: 320px;
        top: 160px;
        right: -70px;
        background: rgba(45, 212, 191, 0.26);
    }

    .kl-orb--amber {
        width: 380px;
        height: 380px;
        bottom: -90px;
        left: 28%;
        background: rgba(251, 146, 60, 0.22);
    }

    .kl-container {
        max-width: 1220px;
        position: relative;
        z-index: 2;
    }

    /* Header Banner Subtitle */
    .kl-hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.28);
        color: #a7f3d0;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 999px;
        margin-bottom: 12px;
    }

    .kl-hero-subtitle {
        max-width: 650px;
        margin: 12px auto 0;
        color: rgba(236, 253, 245, 0.85);
        font-size: 15.5px;
        line-height: 1.65;
    }

    /* Section Headings */
    .kl-sec-title {
        font-size: 28px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.4px;
        margin-bottom: 6px;
        text-shadow: 0 2px 14px rgba(0, 0, 0, 0.22);
    }

    .kl-sec-desc {
        font-size: 15px;
        color: rgba(226, 232, 240, 0.82);
        margin-bottom: 0;
        max-width: 680px;
    }

    /* ==========================================================================
       1. TIGA KARTU KATEGORI BACAAN (PRISMATIC GLASS CARDS)
       ========================================================================== */
    .kl-topic-card {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        padding: 28px 26px;
        border-radius: 24px;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.16) 0%, rgba(255, 255, 255, 0.05) 100%);
        backdrop-filter: blur(22px) saturate(175%);
        -webkit-backdrop-filter: blur(22px) saturate(175%);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-top-color: rgba(255, 255, 255, 0.45);
        border-left-color: rgba(255, 255, 255, 0.34);
        box-shadow:
            0 18px 40px rgba(0, 0, 0, 0.24),
            inset 0 1px 0 rgba(255, 255, 255, 0.30);
        text-decoration: none !important;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Kilau warna di sudut kartu kaca */
    .kl-topic-card::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        top: -45px;
        right: -45px;
        border-radius: 50%;
        filter: blur(36px);
        opacity: 0.45;
        transition: opacity 0.35s ease, transform 0.35s ease;
        pointer-events: none;
    }

    .kl-topic-card--news::before { background: #34d399; }
    .kl-topic-card--journey::before { background: #38bdf8; }
    .kl-topic-card--salam::before { background: #fb923c; }

    .kl-topic-card:hover {
        transform: translateY(-7px);
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.22) 0%, rgba(255, 255, 255, 0.09) 100%);
        border-color: rgba(255, 255, 255, 0.48);
        box-shadow:
            0 26px 52px rgba(0, 0, 0, 0.34),
            inset 0 1px 0 rgba(255, 255, 255, 0.45);
    }

    .kl-topic-card:hover::before {
        opacity: 0.75;
        transform: scale(1.18);
    }

    .kl-topic-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        background: rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.32);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.35);
    }

    .kl-topic-card--news .kl-topic-icon { color: #6ee7b7; }
    .kl-topic-card--journey .kl-topic-icon { color: #7dd3fc; }
    .kl-topic-card--salam .kl-topic-icon { color: #fdba74; }

    .kl-topic-count {
        font-size: 11.5px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.92);
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.24);
        padding: 5px 13px;
        border-radius: 999px;
        backdrop-filter: blur(8px);
    }

    .kl-topic-subtag {
        display: inline-block;
        margin-top: 18px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .kl-topic-card--news .kl-topic-subtag { color: #6ee7b7; }
    .kl-topic-card--journey .kl-topic-subtag { color: #7dd3fc; }
    .kl-topic-card--salam .kl-topic-subtag { color: #fdba74; }

    .kl-topic-title {
        font-size: 23px;
        font-weight: 800;
        color: #ffffff;
        margin: 4px 0 10px;
        letter-spacing: -0.3px;
    }

    .kl-topic-desc {
        font-size: 14px;
        line-height: 1.65;
        color: rgba(241, 245, 249, 0.82);
        margin-bottom: 22px;
    }

    .kl-topic-cta {
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 11px 16px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.10);
        border: 1px solid rgba(255, 255, 255, 0.20);
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.25s ease;
    }

    .kl-topic-card--news:hover .kl-topic-cta {
        background: #2dd4a7;
        border-color: #2dd4a7;
        color: #042417;
    }

    .kl-topic-card--journey:hover .kl-topic-cta {
        background: #38bdf8;
        border-color: #38bdf8;
        color: #042417;
    }

    .kl-topic-card--salam:hover .kl-topic-cta {
        background: #fb923c;
        border-color: #fb923c;
        color: #042417;
    }

    /* ==========================================================================
       2. SOROTAN UTAMA — SPLIT GLASSMORPHISM STAGE + INTERACTIVE DOCK
       ========================================================================== */
    .kl-stage-shell {
        border-radius: 28px;
        padding: 18px;
        background: linear-gradient(140deg, rgba(255, 255, 255, 0.17) 0%, rgba(255, 255, 255, 0.06) 100%);
        backdrop-filter: blur(26px) saturate(180%);
        -webkit-backdrop-filter: blur(26px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.26);
        border-top-color: rgba(255, 255, 255, 0.48);
        border-left-color: rgba(255, 255, 255, 0.38);
        box-shadow:
            0 28px 65px rgba(0, 0, 0, 0.34),
            inset 0 1px 1px rgba(255, 255, 255, 0.35);
    }

    .kl-stage-slides {
        position: relative;
        min-height: 390px;
    }

    .kl-stage-slide {
        display: none;
        animation: klFadeSlide 0.45s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .kl-stage-slide.active {
        display: block;
    }

    @keyframes klFadeSlide {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .kl-stage-photo-wrap {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        height: 100%;
        min-height: 370px;
        display: block;
        border: 1px solid rgba(255, 255, 255, 0.24);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.25);
    }

    .kl-stage-photo-wrap img {
        width: 100%;
        height: 100%;
        min-height: 370px;
        object-fit: cover;
        transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .kl-stage-photo-wrap:hover img {
        transform: scale(1.05);
    }

    /* Floating Glass Date Badge di atas foto */
    .kl-photo-glass-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        border-radius: 999px;
        background: rgba(6, 48, 31, 0.72);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.30);
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
    }

    .kl-photo-glass-badge i {
        color: #fbbf24;
    }

    /* Panel Kanan Sorotan Utama */
    .kl-stage-content {
        padding: 22px 26px 22px 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    .kl-cat-glass-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(45, 212, 167, 0.16);
        border: 1px solid rgba(110, 231, 183, 0.40);
        color: #a7f3d0;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    .kl-stage-title {
        font-size: 28px;
        font-weight: 800;
        line-height: 1.3;
        margin: 16px 0 14px;
        letter-spacing: -0.4px;
    }

    .kl-stage-title a {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .kl-stage-title a:hover {
        color: #6ee7b7;
    }

    .kl-stage-excerpt {
        font-size: 15px;
        line-height: 1.72;
        color: rgba(241, 245, 249, 0.84);
        margin-bottom: 24px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .kl-stage-footer {
        margin-top: auto;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.16);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .kl-author-chip {
        display: inline-flex;
        align-items: center;
        gap: 11px;
    }

    .kl-author-orb {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(52, 211, 153, 0.35), rgba(255, 255, 255, 0.15));
        border: 1px solid rgba(255, 255, 255, 0.38);
        color: #ffffff;
        font-weight: 800;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
    }

    .kl-read-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        border-radius: 999px;
        background: linear-gradient(135deg, #2dd4a7 0%, #10b981 100%);
        color: #042417 !important;
        font-size: 13.5px;
        font-weight: 800;
        text-decoration: none !important;
        box-shadow: 0 10px 24px rgba(45, 212, 167, 0.32);
        transition: all 0.25s ease;
    }

    .kl-read-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(45, 212, 167, 0.46);
        background: linear-gradient(135deg, #6ee7b7 0%, #2dd4a7 100%);
    }

    /* Bottom Interactive Glass Dock (Pilihan Sorotan 01 / 02 / 03) */
    .kl-stage-dock {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .kl-dock-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.14);
        cursor: pointer;
        text-align: left;
        transition: all 0.25s ease;
        color: #ffffff;
    }

    .kl-dock-item:hover {
        background: rgba(255, 255, 255, 0.13);
        border-color: rgba(255, 255, 255, 0.30);
    }

    .kl-dock-item.active {
        background: linear-gradient(135deg, rgba(45, 212, 167, 0.24) 0%, rgba(255, 255, 255, 0.10) 100%);
        border-color: #2dd4a7;
        box-shadow: 0 8px 22px rgba(45, 212, 167, 0.20);
    }

    .kl-dock-thumb {
        width: 54px;
        height: 46px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid rgba(255, 255, 255, 0.22);
    }

    .kl-dock-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .kl-dock-meta {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #6ee7b7;
        margin-bottom: 2px;
    }

    .kl-dock-title {
        font-size: 13px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0;
    }

    @media (max-width: 991px) {
        .kl-stage-photo-wrap,
        .kl-stage-photo-wrap img {
            min-height: 260px;
        }
        .kl-stage-content {
            padding: 22px 10px 10px;
        }
        .kl-stage-title {
            font-size: 22px;
        }
        .kl-stage-dock {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@php
    $bulanIndo = [
        '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
        '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
        '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
    ];

    $formatTgl = function ($tgl) use ($bulanIndo) {
        if (empty($tgl)) return '-';
        $ts = strtotime($tgl);
        if (!$ts) return '-';
        return date('d', $ts) . ' ' . ($bulanIndo[date('m', $ts)] ?? date('M', $ts)) . ' ' . date('Y', $ts);
    };

    $cleanImg = function ($rawPath) {
        if (empty($rawPath)) {
            return asset('images/blog/sedekah-ramadhan.jpg');
        }
        $clean = ltrim(str_replace('\\', '/', $rawPath), '/');
        if (str_starts_with($clean, 'public/')) {
            $clean = 'storage/' . substr($clean, 7);
        }
        $parts = explode('/', $clean);
        return asset(implode('/', array_map('rawurlencode', $parts)));
    };

    $readMinutes = function ($html) {
        $words = str_word_count(strip_tags($html ?? ''));
        return max(2, (int) ceil($words / 180)) . ' Menit Baca';
    };

    $makeExcerpt = function ($html, $limit = 185) {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags($html ?? '')));
        if ($text === '') {
            return 'Simak informasi lengkap liputan kegiatan, cerita perjalanan relawan, dan inspirasi kebaikan bersama Yayasan Graha Dhuafa Indonesia.';
        }
        return mb_strlen($text) > $limit ? mb_substr($text, 0, $limit) . '...' : $text;
    };

    $resolveTopicLabel = function ($item) {
        $j = strtolower(trim($item->jenis ?? ''));
        $k = strtolower(trim($item->kategori ?? ''));
        if (in_array($j, ['lazjourney', 'journey']) || str_contains($k, 'journey')) {
            return 'LAZJourney';
        }
        if (in_array($j, ['lazsalam', 'salam', 'edukasi']) || str_contains($k, 'salam')) {
            return 'LAZSalam';
        }
        if (in_array($j, ['laznews', 'kegiatan', 'news', 'berita']) || str_contains($k, 'news') || str_contains($k, 'kegiatan')) {
            return 'LAZNews';
        }
        return $item->kategori ?: 'Kabar GDI';
    };

    $highlights = collect(@$blogLatest ?? []);
    if ($highlights->isEmpty() && isset($blog)) {
        $highlights = $blog instanceof \Illuminate\Contracts\Pagination\Paginator
            ? collect($blog->items())
            : collect($blog);
    }
    if ($highlights->isEmpty() && isset($featuredBlog) && $featuredBlog) {
        $highlights = collect([$featuredBlog]);
    }
    $highlights = $highlights->take(3)->values();

    $counts = $rubricCounts ?? [
        'laznews' => 0,
        'lazjourney' => 0,
        'lazsalam' => 0,
    ];
@endphp

@section('breadcrumb')
<ul class="thm-breadcrumb list-unstyled">
    <li><a href="{{ url('/') }}">Beranda</a></li>
    <li><span>/</span></li>
    <li>{{ @$detail->title ?: ($pageTitle ?? 'KabarLAZ') }}</li>
</ul>
<h2>{{ @$detail->title ?: 'KabarLAZ' }}</h2>
<p class="kl-hero-subtitle">
    {{ @$detail->subtitle ?: 'Ikuti kabar penyaluran amanah donatur, kisah perjalanan relawan di lapangan, serta pesan kebaikan Islami bersama Graha Dhuafa Indonesia.' }}
</p>
@endsection

@section('pageBlog')
<section class="kl-glass-canvas">
    <!-- Ambient Bokeh Orbs untuk kedalaman Glassmorphism -->
    <div class="kl-orb kl-orb--mint" aria-hidden="true"></div>
    <div class="kl-orb kl-orb--cyan" aria-hidden="true"></div>
    <div class="kl-orb kl-orb--amber" aria-hidden="true"></div>

    <div class="container kl-container">

        <!-- ================= 1. PILIHAN KATEGORI BACAAN ================= -->
        <div class="mb-5">
            <div class="mb-4">
                <h3 class="kl-sec-title">Jelajahi Kategori KabarLAZ</h3>
                <p class="kl-sec-desc">
                    Pilih topik informasi yang ingin Anda baca — mulai dari berita kegiatan, cerita perjalanan relawan, hingga kajian Islami.
                </p>
            </div>

            <div class="row g-4">
                <!-- Kategori 1: LAZNews -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('/blog/jenis/laznews') }}" class="kl-topic-card kl-topic-card--news">
                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="kl-topic-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <span class="kl-topic-count">{{ $counts['laznews'] ?? 0 }} Artikel</span>
                            </div>
                            <span class="kl-topic-subtag">Berita & Liputan Kegiatan</span>
                            <h4 class="kl-topic-title">LAZNews</h4>
                            <p class="kl-topic-desc">
                                Kabar terbaru penyaluran zakat, infak, sedekah, bantuan kemanusiaan, serta aksi sosial nyata untuk masyarakat.
                            </p>
                        </div>
                        <div class="kl-topic-cta">
                            <span>Buka Halaman LAZNews</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Kategori 2: LAZJourney -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('/blog/jenis/lazjourney') }}" class="kl-topic-card kl-topic-card--journey">
                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="kl-topic-icon">
                                    <i class="fas fa-route"></i>
                                </div>
                                <span class="kl-topic-count">{{ $counts['lazjourney'] ?? 0 }} Artikel</span>
                            </div>
                            <span class="kl-topic-subtag">Cerita & Jejak Perjalanan</span>
                            <h4 class="kl-topic-title">LAZJourney</h4>
                            <p class="kl-topic-desc">
                                Kisah menyentuh dari lapangan saat tim amil dan relawan menyapa saudara-saudara penerima manfaat di berbagai daerah.
                            </p>
                        </div>
                        <div class="kl-topic-cta">
                            <span>Buka Halaman LAZJourney</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Kategori 3: LAZSalam -->
                <div class="col-lg-4 col-md-12">
                    <a href="{{ url('/blog/jenis/lazsalam') }}" class="kl-topic-card kl-topic-card--salam">
                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="kl-topic-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <span class="kl-topic-count">{{ $counts['lazsalam'] ?? 0 }} Artikel</span>
                            </div>
                            <span class="kl-topic-subtag">Kajian & Pesan Kebaikan</span>
                            <h4 class="kl-topic-title">LAZSalam</h4>
                            <p class="kl-topic-desc">
                                Artikel edukasi seputar zakat, wakaf, tanya-jawab keislaman, dan nasihat penyejuk hati untuk keluarga Muslim.
                            </p>
                        </div>
                        <div class="kl-topic-cta">
                            <span>Buka Halaman LAZSalam</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- ================= 2. SOROTAN UTAMA (GLASSMORPHISM STAGE) ================= -->
        @if($highlights->count() > 0)
        <div class="pt-2" id="klSorotanWrap">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
                <div>
                    <h3 class="kl-sec-title">Sorotan Utama</h3>
                    <p class="kl-sec-desc">Berita dan cerita pilihan terbaru yang kami rangkum khusus untuk Anda.</p>
                </div>
            </div>

            <div class="kl-stage-shell">
                <div class="kl-stage-slides">
                    @foreach($highlights as $idx => $post)
                        @php
                            $postUrl = url('/blog/' . $post->slug);
                            $postAuthor = !empty($post->author) ? $post->author : 'Redaksi GDI';
                            $authorInitial = strtoupper(mb_substr(trim($postAuthor), 0, 1));
                            $topicLabel = $resolveTopicLabel($post);
                            $imgUrl = $cleanImg($post->featured_img);
                        @endphp
                        <div class="kl-stage-slide {{ $idx === 0 ? 'active' : '' }}" data-slide-index="{{ $idx }}">
                            <div class="row g-4 align-items-stretch">
                                <!-- Foto Berita -->
                                <div class="col-lg-6">
                                    <a href="{{ $postUrl }}" class="kl-stage-photo-wrap">
                                        <img src="{{ $imgUrl }}"
                                             onerror="this.src='{{ asset('images/blog/sedekah-ramadhan.jpg') }}'"
                                             alt="{{ $post->title }}">
                                        <span class="kl-photo-glass-badge">
                                            <i class="fas fa-star"></i> {{ $formatTgl($post->date_publish) }}
                                        </span>
                                    </a>
                                </div>

                                <!-- Detail Konten Kaca -->
                                <div class="col-lg-6">
                                    <div class="kl-stage-content">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span class="kl-cat-glass-pill">
                                                {{ $topicLabel }}
                                            </span>
                                            <span class="small ms-1" style="color: rgba(236, 253, 245, 0.80);">
                                                <i class="far fa-clock me-1"></i>{{ $readMinutes($post->content) }}
                                            </span>
                                        </div>

                                        <h2 class="kl-stage-title">
                                            <a href="{{ $postUrl }}">{{ $post->title }}</a>
                                        </h2>

                                        <p class="kl-stage-excerpt">
                                            {{ $makeExcerpt($post->content, 200) }}
                                        </p>

                                        <div class="kl-stage-footer">
                                            <div class="kl-author-chip">
                                                <span class="kl-author-orb">{{ $authorInitial }}</span>
                                                <div>
                                                    <div class="fw-bold text-white" style="font-size: 14px;">{{ $postAuthor }}</div>
                                                    <div style="font-size: 11.5px; color: rgba(226, 232, 240, 0.72);">Tim Publikasi LAZ GDI</div>
                                                </div>
                                            </div>

                                            <a href="{{ $postUrl }}" class="kl-read-btn">
                                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($highlights->count() > 1)
                <!-- Dock Pilihan Sorotan di Bawah Frame Kaca -->
                <div class="kl-stage-dock">
                    @foreach($highlights as $dIdx => $dPost)
                        <button type="button"
                                class="kl-dock-item {{ $dIdx === 0 ? 'active' : '' }}"
                                data-dock-target="{{ $dIdx }}">
                            <div class="kl-dock-thumb">
                                <img src="{{ $cleanImg($dPost->featured_img) }}"
                                     onerror="this.src='{{ asset('images/blog/sedekah-ramadhan.jpg') }}'"
                                     alt="{{ $dPost->title }}">
                            </div>
                            <div class="min-w-0">
                                <div class="kl-dock-meta">Sorotan 0{{ $dIdx + 1 }} • {{ $formatTgl($dPost->date_publish) }}</div>
                                <p class="kl-dock-title">{{ $dPost->title }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>
</section>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.kl-stage-slide');
        const docks = document.querySelectorAll('.kl-dock-item');
        const wrap = document.getElementById('klSorotanWrap');

        if (slides.length <= 1 || !docks.length) return;

        let current = 0;
        let timer = null;
        const INTERVAL_MS = 4500;

        function activateSlide(index) {
            current = (index + slides.length) % slides.length;
            slides.forEach(function (s, i) {
                s.classList.toggle('active', i === current);
            });
            docks.forEach(function (d, i) {
                d.classList.toggle('active', i === current);
            });
        }

        function startAuto() {
            stopAuto();
            timer = setInterval(function () {
                activateSlide(current + 1);
            }, INTERVAL_MS);
        }

        function stopAuto() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        docks.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const idx = parseInt(btn.getAttribute('data-dock-target'), 10) || 0;
                activateSlide(idx);
                startAuto();
            });
        });

        if (wrap) {
            wrap.addEventListener('mouseenter', stopAuto);
            wrap.addEventListener('mouseleave', startAuto);
        }

        startAuto();
    });
</script>
@endpush
