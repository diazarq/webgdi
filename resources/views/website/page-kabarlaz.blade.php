@extends('layout.layout-page', ['active' => @$active ?? []])
@section('title', ($pageTitle ?? 'KabarLAZ') . ' | Yayasan Graha Dhuafa Indonesia')

@section('style')
<style>
    /* ==========================================================================
       KABARLAZ GENERAL PAGE — CLEAN WHITE & GDI EMERALD THEME
       ========================================================================== */
    .kl-glass-canvas {
        position: relative;
        padding: 60px 0 85px;
        background: #ffffff;
        overflow: hidden;
        font-family: 'Manrope', sans-serif;
        color: #0f172a;
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
        color: #06301f;
        letter-spacing: -0.4px;
        margin-bottom: 6px;
    }

    .kl-sec-desc {
        font-size: 15px;
        color: #64748b;
        margin-bottom: 0;
        max-width: 680px;
    }

    /* ==========================================================================
       1. TIGA KARTU KATEGORI BACAAN (CLEAN ELEVATED CARDS)
       ========================================================================== */
    .kl-topic-card {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        padding: 28px 26px;
        border-radius: 22px;
        background: linear-gradient(145deg, #ffffff 0%, #f5fbf8 100%);
        border: 1px solid #e2ece8;
        box-shadow: 0 12px 32px rgba(6, 48, 31, 0.06);
        text-decoration: none !important;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .kl-topic-card::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        top: -45px;
        right: -45px;
        border-radius: 50%;
        filter: blur(42px);
        opacity: 0.16;
        transition: opacity 0.35s ease, transform 0.35s ease;
        pointer-events: none;
    }

    .kl-topic-card--news::before { background: #10b981; }
    .kl-topic-card--journey::before { background: #0ea5e9; }
    .kl-topic-card--salam::before { background: #f59e0b; }

    .kl-topic-card:hover {
        transform: translateY(-6px);
        background: #ffffff;
        border-color: #1ab69d;
        box-shadow: 0 22px 45px rgba(6, 48, 31, 0.12);
    }

    .kl-topic-card:hover::before {
        opacity: 0.28;
        transform: scale(1.18);
    }

    .kl-topic-icon {
        position: absolute;
        right: -12px;
        bottom: -18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        box-shadow: none;
        color: #00875A;
        font-size: 160px;
        line-height: 1;
        opacity: 0.10;
        pointer-events: none;
        z-index: 1;
        transform: rotate(-20deg);
        transition: all 0.35s ease;
    }

    .kl-topic-card--news .kl-topic-icon { color: #00875A; }
    .kl-topic-card--journey .kl-topic-icon { color: #0284c7; }
    .kl-topic-card--salam .kl-topic-icon { color: #d97706; }

    .kl-topic-icon iconify-icon,
    .kl-topic-icon svg {
        display: block;
        width: 1em;
        height: 1em;
    }

    .kl-topic-card:hover .kl-topic-icon {
        opacity: 0.18;
        transform: rotate(-6deg) scale(1.20);
    }

    .kl-topic-card > div:not(.kl-topic-icon) {
        position: relative;
        z-index: 2;
    }

    .kl-topic-count {
        font-size: 11.5px;
        font-weight: 700;
        color: #065f46;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        padding: 5px 13px;
        border-radius: 999px;
    }

    .kl-topic-subtag {
        display: inline-block;
        margin-top: 6px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .kl-topic-card--news .kl-topic-subtag { color: #00875A; }
    .kl-topic-card--journey .kl-topic-subtag { color: #0284c7; }
    .kl-topic-card--salam .kl-topic-subtag { color: #d97706; }

    .kl-topic-title {
        font-size: 23px;
        font-weight: 800;
        color: #06301f;
        margin: 4px 0 10px;
        letter-spacing: -0.3px;
    }

    .kl-topic-desc {
        font-size: 14px;
        line-height: 1.65;
        color: #475569;
        margin-bottom: 0;
    }

    .kl-topic-cta {
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 11px 16px;
        border-radius: 14px;
        background: #f0fdf9;
        border: 1px solid #ccfbf1;
        color: #06301f;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.25s ease;
    }

    /* ==========================================================================
       2. SOROTAN UTAMA — 3D ROTATING CAROUSEL
       ========================================================================== */
    .kl-carousel-nav {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .kl-nav-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: 1px solid #d1e7dd;
        background: #ffffff;
        color: #06301f;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(6, 48, 31, 0.06);
        transition: all 0.25s ease;
    }

    .kl-nav-btn:hover {
        background: #00875A;
        border-color: #00875A;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 135, 90, 0.22);
    }

    .kl-stage-viewport {
        position: relative;
        overflow: hidden;
        padding: 12px 0;
    }

    .kl-stage-slides {
        position: relative;
        height: 620px;
    }

    .kl-stage-slide {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 92%;
        max-width: 900px;
        height: 330px;
        border-radius: 24px;
        padding: 18px;
        background: #ffffff;
        border: 1px solid #e2ece8;
        box-shadow: 0 16px 42px rgba(6, 48, 31, 0.08);
        will-change: transform, opacity;
        transition:
            transform 0.78s cubic-bezier(0.22, 1, 0.36, 1),
            opacity 0.65s ease,
            box-shadow 0.65s ease;
        transform: translate(-50%, -50%) scale(0.5);
        opacity: 0;
        visibility: hidden;
        z-index: 1;
        pointer-events: none;
        overflow: hidden;
    }

    .kl-stage-slide > .row {
        height: 100%;
    }

    .kl-stage-slide.is-active {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
        visibility: visible;
        z-index: 5;
        pointer-events: auto;
        box-shadow: 0 24px 55px rgba(6, 48, 31, 0.14);
        border-color: #b7e4d4;
    }

    .kl-stage-slide.is-next {
        transform: translate(-50%, 2%) scale(0.76);
        opacity: 0.42;
        visibility: visible;
        z-index: 3;
        pointer-events: auto;
        cursor: pointer;
    }

    .kl-stage-slide.is-prev {
        transform: translate(-50%, -102%) scale(0.76);
        opacity: 0.42;
        visibility: visible;
        z-index: 3;
        pointer-events: auto;
        cursor: pointer;
    }

    .kl-stage-slide.is-next:hover,
    .kl-stage-slide.is-prev:hover {
        opacity: 0.75;
    }

    .kl-stage-slide.is-next a,
    .kl-stage-slide.is-prev a {
        pointer-events: none;
    }

    /* Indikator Pill di Bawah Carousel */
    .kl-carousel-dots {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 8px;
    }

    .kl-carousel-dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        border: none;
        padding: 0;
        background: #cbd5e1;
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .kl-carousel-dot:hover {
        background: #6ee7b7;
    }

    .kl-carousel-dot.active {
        width: 34px;
        background: linear-gradient(90deg, #06301f, #00875A);
    }

    .kl-stage-photo-wrap {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        height: 100%;
        min-height: 292px;
        max-height: 292px;
        display: block;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 26px rgba(6, 48, 31, 0.10);
    }

    .kl-stage-photo-wrap img {
        width: 100%;
        height: 100%;
        min-height: 292px;
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
        gap:6px;
        padding: 4px 14px;
        border-radius: 999px;
        background: rgba(6, 48, 31, 0.78);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
    }

    .kl-photo-glass-badge i {
        color: #fbbf24;
    }

    /* Panel Kanan Sorotan Utama */
    .kl-stage-content {
        padding: 22px 24px 22px 16px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    .kl-cat-glass-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 4px 20px;
        border-radius: 999px;
        background: #00875A;
        border: 1px solid #a7f3d0;
        color: white;
        font-size: 11px;
        font-weight: 800;

    }

    .kl-stage-title {
        font-size: 24px;
        font-weight: 800;
        line-height: 1.3;
        margin: 14px 0 10px;
        letter-spacing: -0.4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .kl-stage-title a {
        color: #06301f;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .kl-stage-title a:hover {
        color: #00875A;
    }

    .kl-stage-excerpt {
        font-size: 14.5px;
        line-height: 1.65;
        color: #475569;
        margin-bottom: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .kl-stage-footer {
        margin-top: auto;
        padding-top: 14px;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .kl-author-chip {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .kl-author-orb {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        border-radius: 50%;
        background-color: #00875A;
        color: #ffffff;
        font-weight: 800;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .kl-author-name {
        font-size: 16px;
        font-weight: 800;
        line-height: 1.2;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .kl-author-role {
        font-size: 11px;
        line-height: 1.2;
        margin-top: 2px;
        color: #64748b;
        white-space: nowrap;
    }

    .kl-read-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        background-color: #00875A;
        color: #ffffff !important;
        font-size: 12.5px;
        font-weight: 800;
        white-space: nowrap;
        flex-shrink: 0;
        text-decoration: none !important;
        box-shadow: 0 8px 20px rgba(0, 135, 90, 0.25);
        transition: all 0.25s ease;
    }

    .kl-read-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(0, 135, 90, 0.35);
        background: linear-gradient(135deg, #00875A 0%, #1ab69d 100%);
    }

    /* Bottom Interactive Dock (Pilihan Sorotan 01 / 02 / 03) */
    .kl-stage-dock {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #e2ece8;
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
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        text-align: left;
        transition: all 0.25s ease;
        color: #0f172a;
    }

    .kl-dock-item:hover {
        background: #f0fdf9;
        border-color: #99f6e4;
    }

    .kl-dock-item.active {
        background: #ecfdf5;
        border-color: #00875A;
        box-shadow: 0 6px 18px rgba(0, 135, 90, 0.12);
    }

    .kl-dock-thumb {
        width: 54px;
        height: 46px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid #e2e8f0;
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
        color: #00875A;
        margin-bottom: 2px;
    }

    .kl-dock-title {
        font-size: 13px;
        font-weight: 700;
        color: #06301f;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0;
    }

    @media (max-width: 991px) {
        .kl-glass-canvas {
            padding: 36px 0 60px;
        }
        .kl-sec-title {
            font-size: 22px;
        }
        .kl-sec-desc {
            font-size: 13.5px;
        }
        .kl-topic-card {
            padding: 22px 20px;
            border-radius: 18px;
        }
        .kl-topic-icon {
            font-size: 115px;
            right: -10px;
            bottom: -14px;
        }
        .kl-topic-title {
            font-size: 20px;
        }
        .kl-topic-desc br {
            display: none;
        }

        /* Carousel Mobile: tetap animasi Vertical Wheel utuh & proporsional */
        .kl-stage-viewport {
            padding: 10px 0;
            overflow: hidden;
        }
        .kl-stage-slides {
            height: 690px;
        }
        .kl-stage-slide {
            width: 94%;
            max-width: 440px;
            height: 460px;
            padding: 15px;
            border-radius: 20px;
        }
        .kl-stage-slide.is-active {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
            visibility: visible;
            z-index: 5;
        }
        .kl-stage-slide.is-next {
            transform: translate(-50%, -14%) scale(0.76);
            opacity: 0.42;
            visibility: visible;
            z-index: 3;
        }
        .kl-stage-slide.is-prev {
            transform: translate(-50%, -86%) scale(0.76);
            opacity: 0.42;
            visibility: visible;
            z-index: 3;
        }
        .kl-stage-slide > .row {
            height: 100%;
            --bs-gutter-y: 0.75rem;
        }
        .kl-stage-photo-wrap,
        .kl-stage-photo-wrap img {
            min-height: 180px;
            max-height: 180px;
            height: 180px;
        }
        .kl-stage-content {
            padding: 6px 4px 2px;
            height: 240px;
            justify-content: flex-start;
        }
        .kl-stage-title {
            font-size: 18px;
            margin: 8px 0 6px;
        }
        .kl-stage-excerpt {
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 10px;
        }
        .kl-stage-footer {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            padding-top: 10px;
        }
        .kl-read-btn {
            width: 100%;
            justify-content: center;
            padding: 9px 16px;
            font-size: 12.5px;
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
    $highlights = $highlights->take(5)->values();

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
    {{ @$detail->subtitle ?: 'Ikuti kabar penyaluran amanah, kisah perjalanan yang membuat haru, serta pesan kebaikan Islami bersama Graha Dhuafa Indonesia.' }}
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
            </div>

            <div class="row g-4">
                <!-- Kategori 1: LAZNews -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('/blog/jenis/laznews') }}" class="kl-topic-card kl-topic-card--news justify-content-center">
                        <div class="kl-topic-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M18 4v3h3a1 1 0 0 1 1 1v10a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1m2 14a1 1 0 1 1-2 0V9h2zM6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1m2 4a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <span class="kl-topic-subtag">Berita & Liputan Kegiatan</span>
                            <h4 class="kl-topic-title">LAZNews</h4>
                            <p class="kl-topic-desc">
                                Kabar terbaru penyaluran zakat, <br>
                                 infak, sedekah, bantuan kemanusiaan, <br> 
                                 serta aksi sosial nyata untuk masyarakat.
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Kategori 2: LAZJourney -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('/blog/jenis/lazjourney') }}" class="kl-topic-card kl-topic-card--journey justify-content-center">
                        <div class="kl-topic-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M424.188 85.594c.33.05-.86.094-3.313.094c-18.512 0-35.78 20.06-35.78 47.5c0 13.83 4.712 26.208 11.624 34.78l10.217 12.626l-16.062 2.47c-10.56 1.617-17.663 6.432-23.625 14.342s-10.344 19.18-13.25 32.344c-5.186 23.492-5.59 52.425-5.625 78.156h30.438l.593 8.72l7.094 106.593h65.813l8.03-106.69l.657-8.624h32c-.24-25.383-1.62-53.933-7.344-77.25c-3.213-13.086-7.783-24.354-13.687-32.375c-5.905-8.02-12.7-12.85-22.064-14.593l-15.72-2.937l10.283-12.25c7.228-8.623 12.186-21.138 12.186-35.313c0-25.74-15.5-45.406-32.28-47.562l-.188-.03zm-244.75 3.375c-45.9.006-99.844 5.373-161.625 17.905V126c268.018-37.648 341.545 38.15 226.25 79.344c-117.327 41.92-210.503 252.258 159.406 270.594c4.362.438 8.85.687 13.436.687c22.28 0 42.34-5.452 56.125-13.594c13.787-8.14 20.595-18.14 20.595-27.905s-6.808-19.764-20.594-27.906c-.23-.138-.482-.272-.717-.408l-2 26.47l-.657 8.656H369l-.563-8.75l-3.28-49.5c-128.194 2.8-163.256-100.51-80.094-130.47c20.385-7.344 37.086-15.836 50.187-25.03c.17-.822.32-1.655.5-2.47c3.262-14.774 8.256-28.498 16.594-39.562c4.946-6.563 11.24-12.07 18.72-15.97c-3.124-42.547-68.335-81.236-191.627-81.217z"/></svg>
                        </div>
                        <div>
                            <span class="kl-topic-subtag">Cerita & Jejak Perjalanan</span>
                            <h4 class="kl-topic-title">LAZJourney</h4>
                            <p class="kl-topic-desc">
                                Kisah menyentuh dari lapangan <br>
                                saat tim amil dan relawan menyapa <br> saudara-saudara penerima manfaat <br>
                                di berbagai daerah.
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Kategori 3: LAZSalam -->
                <div class="col-lg-4 col-md-12">
                    <a href="{{ url('/blog/jenis/lazsalam') }}" class="kl-topic-card kl-topic-card--salam justify-content-center">
                        <div class="kl-topic-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M11.43 9.67c.04.11.07.21.07.33v5.22c0 .5-.19.98-.53 1.35l-2.79 3.05l-3.4-3.4L6 15L8.8 2.86a1.114 1.114 0 0 1 2.2.25v4.96a2 2 0 0 0-.5-.07c-1.1 0-2 .9-2 2v3c0 .28.22.5.5.5s.5-.22.5-.5v-3c0-.55.45-1 1-1c.19 0 .35.07.5.16c.12.07.21.16.3.26c.03.04.06.08.08.13c.02.04.04.08.05.12M2 19l4 3l1.17-1.27l-3.45-3.45zm16-4L15.2 2.86a1.114 1.114 0 0 0-2.2.25v4.96c.16-.04.33-.07.5-.07c1.1 0 2 .9 2 2v3c0 .28-.22.5-.5.5s-.5-.22-.5-.5v-3c0-.55-.45-1-1-1c-.19 0-.35.07-.5.16c-.12.07-.21.16-.29.26c-.03.04-.07.08-.09.13c-.02.04-.04.08-.05.12c-.04.11-.07.21-.07.33v5.22c0 .5.19.98.53 1.35l2.79 3.05l3.4-3.4zm2.28 2.28l-3.45 3.45L18 22l4-3z"/></svg>
                        </div>
                        <div>
                            <span class="kl-topic-subtag">Kajian & Pesan Kebaikan</span>
                            <h4 class="kl-topic-title">LAZSalam</h4>
                            <p class="kl-topic-desc">
                                Artikel edukasi seputar zakat, wakaf, <br>
                                tanya-jawab keislaman, dan nasihat <br> 
                                penyejuk hati untuk keluarga Muslim.
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- ================= 2. SOROTAN UTAMA (3D ROTATING CAROUSEL) ================= -->
        @if($highlights->count() > 0)
        <div class="pt-2" id="klSorotanWrap">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
                <div>
                    <h3 class="kl-sec-title">Kabar Utama</h3>
                    <p class="kl-sec-desc">Baca kabar pilihan terbaru yang kami rangkum khusus untuk Anda.</p>
                </div>
            </div>

            <div class="kl-stage-viewport">
                <div class="kl-stage-slides" id="klStageSlides">
                    @foreach($highlights as $idx => $post)
                        @php
                            $postUrl = url('/blog/' . $post->slug);
                            $postAuthor = !empty($post->author) ? $post->author : 'Redaksi GDI';
                            $authorInitial = strtoupper(mb_substr(trim($postAuthor), 0, 1));
                            $topicLabel = $resolveTopicLabel($post);
                            $imgUrl = $cleanImg($post->featured_img);
                        @endphp
                        <div class="kl-stage-slide {{ $idx === 0 ? 'is-active' : '' }}" data-slide-index="{{ $idx }}">
                            <div class="row g-4 align-items-stretch">
                                <!-- Foto Berita -->
                                <div class="col-lg-6">
                                    <a href="{{ $postUrl }}" class="kl-stage-photo-wrap">
                                        <img src="{{ $imgUrl }}"
                                             onerror="this.src='{{ asset('images/blog/sedekah-ramadhan.jpg') }}'"
                                             alt="{{ $post->title }}">
                                        <span class="kl-photo-glass-badge">
                                            <iconify-icon icon="keyline-icons:calendar-fill" class="fs-6 align-middle"></iconify-icon> {{ $formatTgl($post->date_publish) }}
                                        </span>
                                    </a>
                                </div>

                                <!-- Detail Konten -->
                                <div class="col-lg-6">
                                    <div class="kl-stage-content">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span class="kl-cat-glass-pill">
                                                {{ $topicLabel }}
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
                                                    <div class="kl-author-name">{{ $postAuthor }}</div>
                                                    <div class="kl-author-role">Tim Publikasi LAZ GDI</div>
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
            </div>

            @if($highlights->count() > 1)
            <div class="kl-carousel-dots" id="klCarouselDots">
                @foreach($highlights as $dIdx => $dPost)
                    <button type="button"
                            class="kl-carousel-dot {{ $dIdx === 0 ? 'active' : '' }}"
                            data-dot-index="{{ $dIdx }}"
                            aria-label="Sorotan {{ $dIdx + 1 }}"></button>
                @endforeach
            </div>
            @endif
        </div>
        @endif

    </div>
</section>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = Array.from(document.querySelectorAll('.kl-stage-slide'));
        const dots = Array.from(document.querySelectorAll('.kl-carousel-dot'));
        const wrap = document.getElementById('klSorotanWrap');
        const stageSlides = document.getElementById('klStageSlides');

        if (slides.length === 0) return;

        // Durasi putar otomatis (dalam milidetik: 5000 = 5 detik)
        const INTERVAL_MS = 4000;
        let current = 0;
        let timer = null;
        let wheelLocked = false;

        function renderCarousel() {
            const total = slides.length;
            const prevIdx = (current - 1 + total) % total;
            const nextIdx = (current + 1) % total;

            slides.forEach(function (slide, idx) {
                slide.classList.remove('is-active', 'is-prev', 'is-next');
                if (idx === current) {
                    slide.classList.add('is-active');
                } else if (total > 1 && idx === nextIdx) {
                    slide.classList.add('is-next');
                } else if (total > 2 && idx === prevIdx) {
                    slide.classList.add('is-prev');
                }
            });

            dots.forEach(function (dot, idx) {
                dot.classList.toggle('active', idx === current);
            });
        }

        function goTo(index) {
            current = (index + slides.length) % slides.length;
            renderCarousel();
        }

        function startAuto() {
            if (slides.length <= 1) return;
            stopAuto();
            timer = setInterval(function () {
                goTo(current + 1);
            }, INTERVAL_MS);
        }

        function stopAuto() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        // Klik pada kartu atas/bawah langsung memutarnya ke tengah
        slides.forEach(function (slide, idx) {
            slide.addEventListener('click', function () {
                if (idx !== current) {
                    goTo(idx);
                    startAuto();
                }
            });
        });

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                const idx = parseInt(dot.getAttribute('data-dot-index'), 10) || 0;
                goTo(idx);
                startAuto();
            });
        });

        // Kontrol Scroll Mouse Wheel di area kartu carousel
        if (stageSlides && slides.length > 1) {
            stageSlides.addEventListener('wheel', function (e) {
                e.preventDefault();
                if (wheelLocked) return;

                if (Math.abs(e.deltaY) > 10) {
                    wheelLocked = true;
                    if (e.deltaY > 0) {
                        goTo(current + 1);
                    } else {
                        goTo(current - 1);
                    }
                    startAuto();
                    setTimeout(function () {
                        wheelLocked = false;
                    }, 550);
                }
            }, { passive: false });
        }

        // Pause hanya saat kursor benar-benar di atas fisik card (bukan area kosong sekitarnya)
        slides.forEach(function (slide) {
            slide.addEventListener('mouseenter', stopAuto);
            slide.addEventListener('mouseleave', startAuto);
        });

        // Support Touch Swipe Vertikal (Atas/Bawah) di Mobile
        let touchStartY = 0;
        if (stageSlides) {
            stageSlides.addEventListener('touchstart', function (e) {
                touchStartY = e.changedTouches[0].screenY;
            }, { passive: true });

            stageSlides.addEventListener('touchend', function (e) {
                const diff = e.changedTouches[0].screenY - touchStartY;
                if (diff < -40) {
                    goTo(current + 1);
                    startAuto();
                } else if (diff > 40) {
                    goTo(current - 1);
                    startAuto();
                }
            }, { passive: true });
        }

        renderCarousel();
        startAuto();
    });
</script>
@endpush
