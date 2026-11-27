@extends('layout.layout-page', ['active' => @$active ?? []])

@section('title', 'Profil LAZ Graha Dhuafa Indonesia | #PeduliMenjagaGenerasi')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* ==========================================================================
       PROFIL LAZ GDI 2025 — CLEAN WHITE LIGHT-GLASSMORPHISM + GSAP
       Background putih bersih, kartu glassmorphism lembut, carousel 3 detik
       ========================================================================== */
    .lz-header-sub {
        max-width: 650px;
        margin: 12px auto 0;
        color: rgba(236, 253, 245, 0.86);
        font-size: 15.5px;
        line-height: 1.65;
    }

    .lz-canvas {
        position: relative;
        padding: 64px 0 84px;
        background-color: #ffffff;
        overflow: hidden;
        font-family: 'Manrope', sans-serif;
        color: #1e293b;
    }

    /* Cahaya pastel halus di atas latar putih agar efek frosted-glass terasa nyata */
    .lz-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(95px);
        pointer-events: none;
        z-index: 0;
    }

    .lz-orb--1 { width: 420px; height: 420px; top: -40px; right: -80px; background: rgba(16, 185, 129, 0.13); }
    .lz-orb--2 { width: 380px; height: 380px; top: 34%; left: -110px; background: rgba(251, 146, 60, 0.10); }
    .lz-orb--3 { width: 420px; height: 420px; bottom: 8%; right: -60px; background: rgba(20, 184, 166, 0.11); }

    .lz-container {
        max-width: 1200px;
        position: relative;
        z-index: 2;
    }

    .lz-block {
        margin-bottom: 80px;
    }

    .lz-block:last-child {
        margin-bottom: 0;
    }

    /* Typography */
    .lz-kicker {
        display: inline-block;
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #00875A;
        margin-bottom: 8px;
    }

    .lz-kicker--amber {
        color: #ea580c;
    }

    .lz-heading {
        font-size: 30px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        line-height: 1.25;
        margin-bottom: 10px;
    }

    .lz-subtext {
        font-size: 15px;
        line-height: 1.72;
        color: #64748b;
        max-width: 680px;
        margin-bottom: 0;
    }

    /* Light Glassmorphism Cards di atas background putih */
    .lz-glass {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.86) 0%, rgba(248, 250, 252, 0.68) 100%);
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-top-color: rgba(255, 255, 255, 0.95);
        border-radius: 22px;
        box-shadow:
            0 14px 36px rgba(15, 23, 42, 0.06),
            inset 0 1px 0 rgba(255, 255, 255, 0.90);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .lz-glass--hover:hover {
        transform: translateY(-5px);
        border-color: rgba(0, 135, 90, 0.32);
        box-shadow:
            0 20px 44px rgba(6, 48, 31, 0.10),
            inset 0 1px 0 rgba(255, 255, 255, 0.95);
    }

    .lz-glass--mint {
        background: linear-gradient(145deg, rgba(236, 253, 245, 0.85) 0%, rgba(255, 255, 255, 0.78) 100%);
        border-color: rgba(0, 135, 90, 0.22);
    }

    .lz-glass--amber {
        background: linear-gradient(145deg, rgba(255, 247, 237, 0.88) 0%, rgba(255, 255, 255, 0.78) 100%);
        border-color: rgba(234, 88, 12, 0.24);
    }

    .lz-icon-orb {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: rgba(0, 135, 90, 0.10);
        border: 1px solid rgba(0, 135, 90, 0.18);
        color: #00875A;
        font-size: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .lz-icon-orb--amber {
        background: rgba(234, 88, 12, 0.10);
        border-color: rgba(234, 88, 12, 0.20);
        color: #ea580c;
    }

    /* ==========================================================================
       1. HERO + CAROUSEL LANDASAN & DASAR HUKUM (PENGGANTI FOTO)
       ========================================================================== */
    .lz-hero-stage {
        padding: 34px;
    }

    .lz-hero-title {
        font-size: 34px;
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -0.5px;
        color: #0f172a;
        margin-bottom: 18px;
    }

    .lz-hero-title span {
        color: #00875A;
    }

    /* Carousel Landasan Hukum di sisi kanan Hero */
    .lz-law-carousel-box {
        height: 100%;
        padding: 26px;
        border-radius: 20px;
        background: linear-gradient(155deg, rgba(236, 253, 245, 0.82) 0%, rgba(255, 255, 255, 0.90) 60%, rgba(255, 247, 237, 0.75) 100%);
        backdrop-filter: blur(22px);
        -webkit-backdrop-filter: blur(22px);
        border: 1px solid rgba(0, 135, 90, 0.18);
        box-shadow: 0 16px 38px rgba(6, 48, 31, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.95);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .lz-law-viewport {
        overflow: hidden;
        width: 100%;
    }

    .lz-law-track {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: transform;
    }

    .lz-law-slide {
        min-width: 100%;
        padding: 6px 2px 12px;
    }

    .lz-law-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #00875A;
        background: rgba(0, 135, 90, 0.10);
        padding: 4px 12px;
        border-radius: 999px;
    }

    .lz-carousel-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1px solid rgba(15, 23, 42, 0.08);
        margin-top: 12px;
    }

    .lz-dots {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .lz-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        border: none;
        background: rgba(15, 23, 42, 0.18);
        padding: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .lz-dot.active {
        width: 26px;
        background: #00875A;
    }

    .lz-nav-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.90);
        border: 1px solid rgba(15, 23, 42, 0.12);
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.22s ease;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    }

    .lz-nav-btn:hover {
        background: #00875A;
        border-color: #00875A;
        color: #ffffff;
    }

    /* ==========================================================================
       2. SEJARAH SINGKAT & LEGALITAS (Minimalist Editorial Timeline)
       ========================================================================== */
    .lz-history-header {
        margin-bottom: 44px;
    }

    .lz-history-header .lz-heading {
        font-size: clamp(26px, 3.2vw, 36px);
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin-bottom: 10px;
    }

    .lz-history-header .lz-subtext {
        max-width: 520px;
        font-size: 14.5px;
        color: #475569;
        line-height: 1.65;
        margin-bottom: 0;
    }

    .lz-timeline-wrap {
        position: relative;
    }

    .lz-timeline-track {
        display: none;
    }

    @media (min-width: 992px) {
        .lz-timeline-track {
            display: block;
            position: absolute;
            top: 11px;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
            z-index: 1;
        }
        .lz-timeline-fill {
            width: 100%;
            height: 100%;
            background: #cbd5e1;
            transform-origin: left center;
        }
    }

    .lz-timeline-item {
        position: relative;
        z-index: 2;
        padding-right: 12px;
    }

    .lz-timeline-dot {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2.5px solid #00875A;
        background: #ffffff;
        margin-bottom: 18px;
        position: relative;
        z-index: 2;
    }

    .lz-timeline-dot--orange {
        background: #ea580c;
        border-color: #ea580c;
    }

    .lz-timeline-year {
        font-size: clamp(28px, 3vw, 34px);
        font-weight: 800;
        color: #00875A;
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin-bottom: 10px;
    }

    .lz-timeline-year--orange {
        color: #ea580c;
        font-size: clamp(22px, 2.25vw, 27px);
        line-height: 1.3;
        padding-top: 3px;
    }

    .lz-timeline-title {
        font-size: 15.5px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .lz-timeline-desc {
        font-size: 13.5px;
        color: #475569;
        line-height: 1.72;
        margin-bottom: 0;
    }

    .lz-legal-grid {
        margin-top: 56px;
    }

    .lz-legal-editorial {
        border-top: 1px solid #e2e8f0;
        padding-top: 20px;
        height: 100%;
    }

    .lz-legal-editorial h6 {
        font-size: 14.5px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .lz-legal-editorial p {
        font-size: 13.5px;
        color: #475569;
        line-height: 1.68;
        margin-bottom: 0;
    }

    /* ==========================================================================
       3. VISI, MISI & MANTAP
       ========================================================================== */
    .lz-misi-row {
        padding: 18px 22px;
        border-radius: 18px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .lz-mantap-letter {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        margin: 0 auto 14px;
        background: rgba(0, 135, 90, 0.10);
        border: 1px solid rgba(0, 135, 90, 0.18);
        color: #00875A;
        font-size: 18px;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ==========================================================================
       4. STRUKTUR ORGANISASI
       ========================================================================== */
    .lz-org-card {
        padding: 20px 16px;
        border-radius: 18px;
        text-align: center;
        height: 100%;
    }

    .lz-org-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        margin: 0 auto 11px;
        background: rgba(0, 135, 90, 0.10);
        border: 1px solid rgba(0, 135, 90, 0.22);
        color: #00875A;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lz-org-role {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #00875A;
        margin-top: 4px;
    }

    .lz-glass--mint .lz-org-role {
        color: #c2410c;
    }

    /* ==========================================================================
       5. INTERACTIVE GLASS TABS
       ========================================================================== */
    .lz-tabs-bar {
        display: inline-flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 6px;
        padding: 6px;
        border-radius: 999px;
        background: rgba(241, 245, 249, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(15, 23, 42, 0.08);
        margin-bottom: 32px;
    }

    .lz-tab-btn {
        border: none;
        background: transparent;
        color: #475569;
        font-size: 13.5px;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 999px;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .lz-tab-btn:hover {
        color: #00875A;
    }

    .lz-tab-btn.active {
        background: #00875A;
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(0, 135, 90, 0.24);
    }

    .lz-tab-pane {
        display: none;
    }

    .lz-tab-pane.active {
        display: block;
    }

    .lz-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        border-radius: 999px;
        background: rgba(0, 135, 90, 0.08);
        border: 1px solid rgba(0, 135, 90, 0.24);
        color: #00875A !important;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.22s ease;
    }

    .lz-btn-outline:hover {
        background: #00875A;
        color: #ffffff !important;
    }

    /* ==========================================================================
       6. FULL PETA INDONESIA INTERAKTIF (SEBARAN IMPLEMENTASI PROGRAM)
       ========================================================================== */
    .lz-map-shell {
        padding: 14px;
        border-radius: 26px;
        position: relative;
    }

    #indonesiaProgramMap {
        width: 100%;
        height: 470px;
        border-radius: 18px;
        z-index: 1;
        background: #eef6f4;
        border: 1px solid rgba(15, 23, 42, 0.08);
    }

    #indonesiaProgramMap .leaflet-tile-pane {
        filter: saturate(0.78) brightness(1.03);
    }

    /* Custom Pulsing Markers */
    .lz-pin-wrap {
        position: relative;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lz-pin-dot {
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: #00875A;
        border: 2.5px solid #ffffff;
        box-shadow: 0 3px 10px rgba(0, 135, 90, 0.45);
        position: relative;
        z-index: 2;
        transition: transform 0.2s ease;
    }

    .lz-pin-pulse {
        position: absolute;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: rgba(0, 135, 90, 0.30);
        animation: lzMapPulse 2.2s infinite ease-out;
        z-index: 1;
    }

    .lz-pin-wrap--office .lz-pin-dot {
        width: 15px;
        height: 15px;
        background: #f97316;
        box-shadow: 0 3px 12px rgba(249, 115, 22, 0.55);
    }

    .lz-pin-wrap--office .lz-pin-pulse {
        width: 30px;
        height: 30px;
        background: rgba(249, 115, 22, 0.34);
    }

    @keyframes lzMapPulse {
        0% { transform: scale(0.5); opacity: 0.9; }
        100% { transform: scale(1.7); opacity: 0; }
    }

    /* Leaflet Popup Styling */
    .leaflet-popup-content-wrapper {
        border-radius: 14px !important;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.14) !important;
        border: 1px solid rgba(15, 23, 42, 0.08);
        font-family: 'Manrope', sans-serif !important;
    }

    .leaflet-popup-content {
        margin: 12px 15px !important;
        min-width: 185px;
    }

    .lz-map-legend {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 14px 20px;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
    }

    .lz-legend-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .lz-map-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 16px;
        padding: 4px 2px 2px;
    }

    .lz-map-chip {
        border: 1px solid rgba(15, 23, 42, 0.10);
        background: rgba(255, 255, 255, 0.90);
        color: #334155;
        font-size: 12.5px;
        font-weight: 700;
        padding: 6px 13px;
        border-radius: 999px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .lz-map-chip:hover,
    .lz-map-chip.active {
        background: #00875A;
        border-color: #00875A;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .lz-map-chip--office:hover,
    .lz-map-chip--office.active {
        background: #f97316;
        border-color: #f97316;
        color: #ffffff;
    }

    @media (max-width: 991px) {
        .lz-hero-title { font-size: 26px; }
        .lz-heading { font-size: 24px; }
        .lz-hero-stage { padding: 24px; }
        .lz-tabs-bar { border-radius: 20px; }
        #indonesiaProgramMap { height: 370px; }
    }

    @media (max-width: 576px) {
        #indonesiaProgramMap { height: 320px; }
    }
</style>
@endsection

@section('breadcrumb')
<ul class="thm-breadcrumb list-unstyled">
    <li><a href="{{ url('/') }}">Beranda</a></li>
    <li><span>/</span></li>
    <li>LAZGDI</li>
</ul>
<h2>Lembaga Amil Zakat Graha Dhuafa Indonesia</h2>
<p class="lz-header-sub">
    Company Profile Resmi LAZ GDI — Mengelola zakat, infaq, sedekah, dan wakaf secara profesional, amanah, dan transparan demi kemandirian yatim & dhuafa.
</p>
@endsection

@section('content')
<section class="lz-canvas">
    <!-- Pastel Ambient Orbs di belakang kartu glassmorphism -->
    <div class="lz-orb lz-orb--1" aria-hidden="true"></div>
    <div class="lz-orb lz-orb--2" aria-hidden="true"></div>
    <div class="lz-orb lz-orb--3" aria-hidden="true"></div>

    <div class="container lz-container">

        <!-- ===============================================================
             1. HERO & LATAR BELAKANG + CAROUSEL LANDASAN HUKUM (PENGGANTI FOTO)
             =============================================================== -->
        <div class="lz-block">
            <div class="lz-glass lz-hero-stage gsap-hero">
                <div class="row g-4 align-items-stretch">
                    <!-- Kiri: Narasi Latar Belakang -->
                    <div class="col-lg-7 d-flex flex-column justify-content-center">
                        <span class="lz-kicker lz-kicker--amber">#PeduliMenjagaGenerasi</span>
                        <h1 class="lz-hero-title">
                            “Kesejahteraan Sosial adalah <span>Tanggung Jawab Kita Bersama.</span>”
                        </h1>
                        <p class="text-secondary mb-3" style="font-size: 15px; line-height: 1.8;">
                            <strong>Graha Dhuafa Indonesia</strong> berawal dari sebuah komunitas kecil yang melihat tingginya kesenjangan sosial di perkotaan maupun pedesaan — mulai dari kemiskinan, sulitnya akses pendidikan anak, hingga terbatasnya pelayanan kesehatan masyarakat.
                        </p>
                        <p class="text-secondary mb-0" style="font-size: 15px; line-height: 1.8;">
                            Melalui penguatan ilmu, iman, dan ekonomi umat, LAZ Graha Dhuafa Indonesia hadir menjadi perantara kebaikan bagi para <em>muzakki</em> agar dana zakat, infaq, dan sedekah tersalurkan tepat sasaran hingga para <em>mustahiq</em> berdaya dan mandiri.
                        </p>
                    </div>

                    <!-- Kanan: Carousel Landasan & Dasar Hukum (Otomatis geser tiap 3 detik) -->
                    <div class="col-lg-5">
                        <div class="lz-law-carousel-box" id="lawCarouselWrap">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="lz-kicker mb-0">Landasan & Dasar Hukum</span>
                                    <span class="small fw-bold text-muted" id="lawCounter">01 / 04</span>
                                </div>

                                <div class="lz-law-viewport">
                                    <div class="lz-law-track" id="lawTrack">
                                        <!-- Slide 1 -->
                                        <div class="lz-law-slide">
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <span class="lz-icon-orb"><i class="fas fa-shield-alt"></i></span>
                                                <span class="lz-law-badge">Landasan Konstitusi</span>
                                            </div>
                                            <h4 class="fw-bold text-dark mb-2">Pancasila Sila ke-5</h4>
                                            <p class="text-secondary small mb-0" style="line-height: 1.75; font-size: 14.5px;">
                                                “Keadilan sosial bagi seluruh rakyat Indonesia” menjadi pijakan moral Graha Dhuafa Indonesia dalam menghadirkan pemerataan kesejahteraan bagi masyarakat dhuafa.
                                            </p>
                                        </div>

                                        <!-- Slide 2 -->
                                        <div class="lz-law-slide">
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <span class="lz-icon-orb"><i class="fas fa-gavel"></i></span>
                                                <span class="lz-law-badge">Regulasi Negara</span>
                                            </div>
                                            <h4 class="fw-bold text-dark mb-2">UU No. 11 Tahun 2009</h4>
                                            <p class="text-secondary small mb-0" style="line-height: 1.75; font-size: 14.5px;">
                                                Tentang Kesejahteraan Sosial — menyelenggarakan upaya terarah, terpadu, dan berkelanjutan demi terpenuhinya kebutuhan dasar setiap warga negara.
                                            </p>
                                        </div>

                                        <!-- Slide 3 -->
                                        <div class="lz-law-slide">
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <span class="lz-icon-orb lz-icon-orb--amber"><i class="fas fa-balance-scale"></i></span>
                                                <span class="lz-law-badge" style="color: #c2410c; background: rgba(234, 88, 12, 0.12);">Penanganan Kemiskinan</span>
                                            </div>
                                            <h4 class="fw-bold text-dark mb-2">UU No. 13 Tahun 2011</h4>
                                            <p class="text-secondary small mb-0" style="line-height: 1.75; font-size: 14.5px;">
                                                Tentang Penanganan Fakir Miskin — partisipasi aktif lembaga filantropi dalam pengentasan kemiskinan dan pemberdayaan ekonomi masyarakat prasejahtera.
                                            </p>
                                        </div>

                                        <!-- Slide 4 -->
                                        <div class="lz-law-slide">
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <span class="lz-icon-orb"><i class="fas fa-award"></i></span>
                                                <span class="lz-law-badge">Legalitas LAZ</span>
                                            </div>
                                            <h4 class="fw-bold text-dark mb-2">SK Kemenag No. 1913 / 2022</h4>
                                            <p class="text-secondary small mb-0" style="line-height: 1.75; font-size: 14.5px;">
                                                Resmi memperoleh rekomendasi BAZNAS dan Izin Operasional LAZ Tingkat Kota Bandung dari Kemenag Prov. Jawa Barat pada 03 Oktober 2022.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lz-carousel-footer">
                                <div class="lz-dots" id="lawDots">
                                    <button type="button" class="lz-dot active" data-law-dot="0" aria-label="Slide 1"></button>
                                    <button type="button" class="lz-dot" data-law-dot="1" aria-label="Slide 2"></button>
                                    <button type="button" class="lz-dot" data-law-dot="2" aria-label="Slide 3"></button>
                                    <button type="button" class="lz-dot" data-law-dot="3" aria-label="Slide 4"></button>
                                </div>
                                <div class="d-inline-flex gap-2">
                                    <button type="button" class="lz-nav-btn" id="lawPrev" aria-label="Sebelumnya"><i class="fas fa-chevron-left"></i></button>
                                    <button type="button" class="lz-nav-btn" id="lawNext" aria-label="Berikutnya"><i class="fas fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===============================================================
             2. SEJARAH SINGKAT & LEGALITAS RESMI
             =============================================================== -->
        <div class="lz-block" id="sec-sejarah">
            <div class="lz-history-header gsap-reveal">
                <h2 class="lz-heading">Sejarah singkat LAZ Graha Dhuafa Indonesia</h2>
                <p class="lz-subtext">
                    Transformasi dari gerakan sosial pendidikan di kampus hingga menjadi Lembaga Amil Zakat resmi dan akuntabel.
                </p>
            </div>

            <div class="lz-timeline-wrap">
                <div class="lz-timeline-track" aria-hidden="true">
                    <div class="lz-timeline-fill" id="lzHistoryFill"></div>
                </div>
                <div class="row g-4 g-lg-5 position-relative" style="z-index: 2;">
                    <div class="col-lg-4 gsap-stagger-history">
                        <div class="lz-timeline-item">
                            <div class="lz-timeline-dot" aria-hidden="true"></div>
                            <div class="lz-timeline-year">2013</div>
                            <h5 class="lz-timeline-title">Komunitas Sosial Pendidikan</h5>
                            <p class="lz-timeline-desc">
                                Diinisiasi oleh salah satu dosen UNIKOM dan STT Telkom yang berfokus pada kegiatan berbagi serta mengajar anak-anak yatim dan dhuafa.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 gsap-stagger-history">
                        <div class="lz-timeline-item">
                            <div class="lz-timeline-dot" aria-hidden="true"></div>
                            <div class="lz-timeline-year">2016</div>
                            <h5 class="lz-timeline-title">Yayasan Graha Dhuafa Indonesia</h5>
                            <p class="lz-timeline-desc">
                                Resmi berdiri sebagai yayasan filantropi di bidang sosial, kemanusiaan, dan keagamaan agar manfaatnya semakin luas dan terlembaga.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 gsap-stagger-history">
                        <div class="lz-timeline-item">
                            <div class="lz-timeline-dot lz-timeline-dot--orange" aria-hidden="true"></div>
                            <div class="lz-timeline-year lz-timeline-year--orange">2021 – 3 Okt 2022</div>
                            <h5 class="lz-timeline-title">Izin Operasional LAZ No. 1913</h5>
                            <p class="lz-timeline-desc">
                                Mendapat rekomendasi BAZNAS dan diresmikan Kemenag Provinsi Jawa Barat sebagai LAZ Tingkat Kota Bandung untuk mengoptimalkan dana ZIS.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4 Dokumen Legalitas -->
            <div class="row gx-lg-5 gy-4 lz-legal-grid">
                <div class="col-md-6 gsap-stagger-legal">
                    <div class="lz-legal-editorial">
                        <h6>Akta Pendirian Yayasan</h6>
                        <p>
                            Notaris Endang Sosilowati, SH. Nomor 01 tanggal 3 Oktober 2016 tentang Pendirian Yayasan Graha Dhuafa Indonesia.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 gsap-stagger-legal">
                    <div class="lz-legal-editorial">
                        <h6>Akta Perubahan</h6>
                        <p>
                            Notaris Mohamad Juania, SH., M.Kn. Nomor 27 tanggal 18 Mei 2020. Akta Pernyataan Keputusan Pembina Yayasan.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 gsap-stagger-legal">
                    <div class="lz-legal-editorial">
                        <h6>Izin Operasional LAZ Tingkat Kota Bandung</h6>
                        <p>
                            Nomor 1913 Tahun 2022 tanggal 3 Oktober 2022 tentang Pemberian Izin Operasional Kantor LAZ Graha Dhuafa Indonesia.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 gsap-stagger-legal">
                    <div class="lz-legal-editorial">
                        <h6>Pengesahan Kemenkumham RI</h6>
                        <p>
                            Nomor AHU-0039586.AH.01.04. Tahun 2016 tentang Pengesahan Badan Hukum Yayasan Graha Dhuafa Indonesia.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===============================================================
             3. VISI, MISI & BUDAYA KERJA MANTAP
             =============================================================== -->
        <div class="lz-block" id="sec-visimisi">
            <div class="mb-4 gsap-reveal">
                <span class="lz-kicker">Arah & Nilai Lembaga</span>
                <h2 class="lz-heading">Visi, Misi & Budaya Kerja MANTAP</h2>
            </div>

            <div class="row g-4 align-items-stretch mb-4">
                <div class="col-lg-5 gsap-reveal">
                    <div class="lz-glass lz-glass--mint p-4 p-lg-5 h-100 d-flex flex-column justify-content-center">
                        <span class="lz-kicker lz-kicker--amber mb-2">Visi Lembaga</span>
                        <h3 class="fw-bold text-dark mb-3" style="font-size: 23px; line-height: 1.45;">
                            “Menjadi lembaga amil zakat nasional yang profesional, amanah dan transparan dalam membangun kemandirian yatim dan dhuafa.”
                        </h3>
                        <span class="small text-muted">LAZ Graha Dhuafa Indonesia</span>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="d-flex flex-column justify-content-between h-100 gap-3">
                        <div class="lz-glass lz-glass--hover lz-misi-row gsap-stagger-misi">
                            <span class="lz-icon-orb" style="width: 40px; height: 40px; font-size: 14px; font-weight: 800;">01</span>
                            <div>
                                <div class="fw-bold text-dark mb-1">Pengelolaan Sesuai Syariah & Manajemen Modern</div>
                                <div class="text-secondary small" style="line-height: 1.65;">
                                    Melaksanakan pengelolaan zakat, infaq, dan shodaqoh sesuai syariah dengan manajemen modern yang profesional dan amanah.
                                </div>
                            </div>
                        </div>
                        <div class="lz-glass lz-glass--hover lz-misi-row gsap-stagger-misi">
                            <span class="lz-icon-orb" style="width: 40px; height: 40px; font-size: 14px; font-weight: 800;">02</span>
                            <div>
                                <div class="fw-bold text-dark mb-1">Pemberdayaan Yatim & Dhuafa Mandiri</div>
                                <div class="text-secondary small" style="line-height: 1.65;">
                                    Memberdayakan anak-anak yatim dan masyarakat dhuafa secara berkelanjutan menuju masyarakat yang mandiri.
                                </div>
                            </div>
                        </div>
                        <div class="lz-glass lz-glass--hover lz-misi-row gsap-stagger-misi">
                            <span class="lz-icon-orb" style="width: 40px; height: 40px; font-size: 14px; font-weight: 800;">03</span>
                            <div>
                                <div class="fw-bold text-dark mb-1">Pelayanan Terbaik & Berkesinambungan</div>
                                <div class="text-secondary small" style="line-height: 1.65;">
                                    Memberikan pelayanan yang terbaik, responsif, dan berkesinambungan kepada seluruh masyarakat dan muzakki.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4 Nilai MANTAP -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                <div class="col gsap-stagger-mantap">
                    <div class="lz-glass lz-glass--hover p-4 h-100 text-center">
                        <div class="lz-mantap-letter">MAN</div>
                        <h5 class="fw-bold text-dark mb-2">Mandiri</h5>
                        <p class="text-secondary small mb-0">Mendorong kemandirian kelembagaan serta membina mustahiq agar berdaya.</p>
                    </div>
                </div>
                <div class="col gsap-stagger-mantap">
                    <div class="lz-glass lz-glass--hover p-4 h-100 text-center">
                        <div class="lz-mantap-letter">T</div>
                        <h5 class="fw-bold text-dark mb-2">Transparan</h5>
                        <p class="text-secondary small mb-0">Keterbukaan pelaporan dana zakat, infaq, dan sedekah yang terukur.</p>
                    </div>
                </div>
                <div class="col gsap-stagger-mantap">
                    <div class="lz-glass lz-glass--hover p-4 h-100 text-center">
                        <div class="lz-mantap-letter">A</div>
                        <h5 class="fw-bold text-dark mb-2">Amanah</h5>
                        <p class="text-secondary small mb-0">Menjaga kepercayaan donatur dengan penyaluran tepat sasaran sesuai syariat.</p>
                    </div>
                </div>
                <div class="col gsap-stagger-mantap">
                    <div class="lz-glass lz-glass--hover p-4 h-100 text-center">
                        <div class="lz-mantap-letter">P</div>
                        <h5 class="fw-bold text-dark mb-2">Profesional</h5>
                        <p class="text-secondary small mb-0">Dikelola oleh SDM amilin berkompeten dengan standar layanan unggul.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===============================================================
             4. STRUKTUR ORGANISASI
             =============================================================== -->
        <div class="lz-block" id="sec-struktur">
            <div class="text-center mb-5 gsap-reveal">
                <span class="lz-kicker">Tata Kelola & Amilin</span>
                <h2 class="lz-heading">Struktur Organisasi LAZ GDI</h2>
                <p class="lz-subtext mx-auto">
                    Pengawasan Dewan Syariah bersama pengurus dan tim pelaksana yang berkomitmen menjaga amanah umat.
                </p>
            </div>

            <!-- Dewan Syariah -->
            <div class="row justify-content-center g-3 mb-3">
                <div class="col-md-4 gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="lz-org-avatar">AM</div>
                        <div class="fw-bold text-dark">Ustadz Ahmad Muhajir, S.Ud, M.H</div>
                        <div class="lz-org-role">Dewan Syariah</div>
                    </div>
                </div>
                <div class="col-md-4 gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="lz-org-avatar">AA</div>
                        <div class="fw-bold text-dark">Ustadz Agus Adas</div>
                        <div class="lz-org-role">Dewan Syariah</div>
                    </div>
                </div>
                <div class="col-md-4 gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="lz-org-avatar">AU</div>
                        <div class="fw-bold text-dark">Ustadz Acep Utsman Arifin</div>
                        <div class="lz-org-role">Dewan Syariah</div>
                    </div>
                </div>
            </div>

            <!-- Ketua -->
            <div class="row justify-content-center my-3">
                <div class="col-md-5 col-lg-4 gsap-stagger-org">
                    <div class="lz-glass lz-glass--mint lz-org-card">
                        <div class="lz-org-avatar" style="width: 56px; height: 56px; font-size: 18px;">EK</div>
                        <div class="fw-bold text-dark" style="font-size: 16.5px;">Engkus Kusnadi, S.Pd., M.M.Pd</div>
                        <div class="lz-org-role">Ketua LAZ GDI</div>
                    </div>
                </div>
            </div>

            <!-- Pengurus Inti -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-3">
                <div class="col gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="lz-org-avatar">EZ</div>
                        <div class="fw-bold text-dark">Elsa Zullida, S.M</div>
                        <div class="lz-org-role">Sekretaris</div>
                    </div>
                </div>
                <div class="col gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="lz-org-avatar">ES</div>
                        <div class="fw-bold text-dark">Eti Setiati</div>
                        <div class="lz-org-role">Bendahara</div>
                    </div>
                </div>
                <div class="col gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="lz-org-avatar">WS</div>
                        <div class="fw-bold text-dark">Wulandari SAB</div>
                        <div class="lz-org-role">Program</div>
                    </div>
                </div>
                <div class="col gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="lz-org-avatar">NS</div>
                        <div class="fw-bold text-dark">Neni Sudiarni</div>
                        <div class="lz-org-role">Koord. Fundraising</div>
                    </div>
                </div>
            </div>

            <!-- Divisi Pelaksana -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 mb-4">
                <div class="col gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="fw-bold text-dark small">Mela Fitriyani, S.Tr.Kes</div>
                        <div class="lz-org-role">Kerelawanan</div>
                    </div>
                </div>
                <div class="col gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="fw-bold text-dark small">Hasan Baihaqi</div>
                        <div class="lz-org-role">Head Creative</div>
                    </div>
                </div>
                <div class="col gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="fw-bold text-dark small">Sansan Ridwan Syaifulloh</div>
                        <div class="lz-org-role">Desain Grafis</div>
                    </div>
                </div>
                <div class="col gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="fw-bold text-dark small">Rudi</div>
                        <div class="lz-org-role">Humas & Litbang</div>
                    </div>
                </div>
                <div class="col gsap-stagger-org">
                    <div class="lz-glass lz-glass--hover lz-org-card">
                        <div class="fw-bold text-dark small">Supriyatna</div>
                        <div class="lz-org-role">Operasional</div>
                    </div>
                </div>
            </div>

            <!-- Pimpinan Unit Layanan Daerah -->
            <div class="lz-glass lz-glass--mint p-4 gsap-stagger-org">
                <span class="lz-kicker lz-kicker--amber mb-3">Pimpinan Kantor & Unit Layanan Daerah</span>
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="small text-muted">Kantor GDI Jakarta</div>
                        <div class="fw-bold text-dark">apt. Yuda Achyarudani, S.Farm</div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="small text-muted">Kantor GDI Karawang</div>
                        <div class="fw-bold text-dark">Agung Saputro</div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="small text-muted">Unit Layanan Yogyakarta</div>
                        <div class="fw-bold text-dark">Nur Hanifah</div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="small text-muted">Unit Layanan Solo</div>
                        <div class="fw-bold text-dark">Chitalia Kusuma Putri, S.ST</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===============================================================
             5. PILAR, STRATEGI ZIS & PROGRAM (INTERACTIVE GLASS TABS)
             =============================================================== -->
        <div class="lz-block" id="sec-program">
            <div class="text-center mb-4 gsap-reveal">
                <span class="lz-kicker">Ekosistem Kebaikan</span>
                <h2 class="lz-heading">Pilar, Strategi & Program LAZ GDI</h2>
                <p class="lz-subtext mx-auto">
                    Seluruh program dirancang untuk membangun kemandirian pendidikan, kesehatan, dakwah, kemanusiaan, dan ekonomi umat.
                </p>
            </div>

            <div class="text-center">
                <div class="lz-tabs-bar" id="lzTabsNav">
                    <button type="button" class="lz-tab-btn active" data-tab="lz-tab-pilar">5 Pilar & Strategi ZIS</button>
                    <button type="button" class="lz-tab-btn" data-tab="lz-tab-unggulan">Program Unggulan</button>
                    <button type="button" class="lz-tab-btn" data-tab="lz-tab-impl">Budaya, CINTA & SENYUM</button>
                    <button type="button" class="lz-tab-btn" data-tab="lz-tab-event">Program Event</button>
                </div>
            </div>

            <!-- Tab 1 -->
            <div class="lz-tab-pane active" id="lz-tab-pilar">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3 mb-4">
                    <div class="col lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100 text-center">
                            <span class="lz-icon-orb mb-3"><i class="fas fa-graduation-cap"></i></span>
                            <h6 class="fw-bold text-dark mb-1">Pendidikan</h6>
                            <p class="text-secondary small mb-0">Beasiswa & pembinaan Qur'ani</p>
                        </div>
                    </div>
                    <div class="col lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100 text-center">
                            <span class="lz-icon-orb mb-3"><i class="fas fa-heartbeat"></i></span>
                            <h6 class="fw-bold text-dark mb-1">Kesehatan</h6>
                            <p class="text-secondary small mb-0">Layanan medis & ambulans</p>
                        </div>
                    </div>
                    <div class="col lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100 text-center">
                            <span class="lz-icon-orb mb-3"><i class="fas fa-mosque"></i></span>
                            <h6 class="fw-bold text-dark mb-1">Dakwah</h6>
                            <p class="text-secondary small mb-0">Syiar Islam & guru ngaji</p>
                        </div>
                    </div>
                    <div class="col lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100 text-center">
                            <span class="lz-icon-orb mb-3"><i class="fas fa-people-carry"></i></span>
                            <h6 class="fw-bold text-dark mb-1">Sosial Kemanusiaan</h6>
                            <p class="text-secondary small mb-0">Tanggap bencana & pangan</p>
                        </div>
                    </div>
                    <div class="col lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100 text-center">
                            <span class="lz-icon-orb mb-3"><i class="fas fa-store"></i></span>
                            <h6 class="fw-bold text-dark mb-1">Ekonomi</h6>
                            <p class="text-secondary small mb-0">Modal usaha & pelatihan</p>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 col-lg-3 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-kicker lz-kicker--amber">01 • Konsultan ZIS</span>
                            <p class="text-secondary small mb-0" style="line-height: 1.65;">
                                Fasilitas edukasi Zakat, Infaq, dan Shodaqoh beserta beragam kegiatan pendukung.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-kicker lz-kicker--amber">02 • Masjidku</span>
                            <p class="text-secondary small mb-0" style="line-height: 1.65;">
                                Pemberdayaan dan pengembangan masjid, SDM pengurus, serta potensi lingkungan sekitar.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-kicker lz-kicker--amber">03 • Mitra</span>
                            <p class="text-secondary small mb-0" style="line-height: 1.65;">
                                Sinergi lembaga, komunitas, maupun perusahaan untuk membangun kebermanfaatan bersama.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-kicker lz-kicker--amber">04 • Konsultasi Fiqh</span>
                            <p class="text-secondary small mb-0" style="line-height: 1.65;">
                                Edukasi Fiqh Asasi mulai dari thaharah, sholat, keluarga, maliyah, hingga pemulasaraan jenazah.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2 -->
            <div class="lz-tab-pane" id="lz-tab-unggulan">
                <div class="row g-4">
                    <div class="col-lg-4 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-icon-orb mb-3"><i class="fas fa-book-reader"></i></span>
                            <div class="lz-kicker">Program Pendidikan</div>
                            <h5 class="fw-bold text-dark mb-2">Beasiswa Tahfizh Yatim Dhuafa (PB-TYD)</h5>
                            <p class="text-secondary small mb-0" style="line-height: 1.7;">
                                Dukungan finansial sekaligus pendampingan holistik agar anak-anak yatim dhuafa dapat menghafal Al-Qur'an dan mengembangkan karakter terbaiknya.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-icon-orb mb-3"><i class="fas fa-box-open"></i></span>
                            <div class="lz-kicker">Program Dakwah – Advokasi</div>
                            <h5 class="fw-bold text-dark mb-2">Program Bantu Bahan Makanan (BBM)</h5>
                            <p class="text-secondary small mb-0" style="line-height: 1.7;">
                                Mengatasi kebutuhan pangan keluarga dhuafa lewat paket bahan pokok berkualitas, disertai edukasi dan pendataan penerima manfaat.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-icon-orb mb-3"><i class="fas fa-lightbulb"></i></span>
                            <div class="lz-kicker">Program Ekonomi</div>
                            <h5 class="fw-bold text-dark mb-2">Program Insan Kreatif (PIK)</h5>
                            <p class="text-secondary small mb-0" style="line-height: 1.7;">
                                Pemberdayaan individu melalui pelatihan keterampilan, kewirausahaan, dan modal usaha agar mandiri dan berkontribusi positif di masyarakat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3 -->
            <div class="lz-tab-pane" id="lz-tab-impl">
                <div class="row g-4">
                    <div class="col-lg-4 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="{{ asset('images/program-implementasi/budaya.png') }}" alt="Budaya" style="height: 46px; width: auto;" onerror="this.style.display='none'">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-0">BUDAYA</h5>
                                        <small class="text-success fw-semibold">Bangun Peradaban Berakhlak & Berkarya</small>
                                    </div>
                                </div>
                                <ul class="text-secondary small ps-3 mb-3" style="line-height: 1.75;">
                                    <li><strong>Wakaf & Hibah:</strong> Pembebasan tanah, pondok yatama, mobil ambulans, operasional & rescue.</li>
                                    <li><strong>Sedekah Al-Qur'an</strong> & <strong>Peace Qurban</strong> (olahan siap saji hingga NTT & Merauke).</li>
                                    <li><strong>Bandung Berdzikir</strong> & <strong>Hadiah Guru Ngaji/Honorer</strong>.</li>
                                </ul>
                            </div>
                            <a href="{{ url('/budaya') }}" class="lz-btn-outline align-self-start">
                                Detail Budaya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="{{ asset('images/program-implementasi/cinta.png') }}" alt="Cinta" style="height: 46px; width: auto;" onerror="this.style.display='none'">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-0">CINTA</h5>
                                        <small class="text-success fw-semibold">Cepat • Inisiatif • Tanggap</small>
                                    </div>
                                </div>
                                <ul class="text-secondary small ps-3 mb-3" style="line-height: 1.75;">
                                    <li><strong>Cinta Bersama:</strong> Pemulihan kesehatan masyarakat dhuafa.</li>
                                    <li><strong>Cinta Bersatu:</strong> Tanggap darurat korban bencana alam.</li>
                                    <li><strong>Cinta Bergerak</strong> (sembako) & <strong>Insan Kreatif</strong> (modal usaha).</li>
                                </ul>
                            </div>
                            <a href="{{ url('/cinta') }}" class="lz-btn-outline align-self-start">
                                Detail Cinta <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="{{ asset('images/program-implementasi/senyum.png') }}" alt="Senyum" style="height: 46px; width: auto;" onerror="this.style.display='none'">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-0">SENYUM</h5>
                                        <small class="text-success fw-semibold">Sedekah Anak Yatim Dhuafa Mandiri</small>
                                    </div>
                                </div>
                                <ul class="text-secondary small ps-3 mb-3" style="line-height: 1.75;">
                                    <li><strong>Senyum Bahagia:</strong> Bantuan pendidikan, kesehatan & kesejahteraan yatim dhuafa.</li>
                                    <li><strong>Senyum Taqwa:</strong> Beasiswa & pembinaan khusus adik-adik Tahfidz.</li>
                                    <li><strong>Jumat Berbagi:</strong> <em>Story telling</em>, hafalan surat, bingkisan & ATK.</li>
                                </ul>
                            </div>
                            <a href="{{ url('/senyum') }}" class="lz-btn-outline align-self-start">
                                Detail Senyum <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 4 -->
            <div class="lz-tab-pane" id="lz-tab-event">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-moon text-success me-2"></i>Ramadhan Inspiratif</h6>
                            <p class="text-secondary small mb-0">Kegiatan sepanjang Ramadhan untuk mengajak masyarakat aktif menebar kebaikan dan memaksimalkan ibadah.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-flag text-danger me-2"></i>Merdeka</h6>
                            <p class="text-secondary small mb-0">Semarak kemerdekaan bersama yatim, dhuafa & tahfizh lewat upacara, perlombaan, khitanan massal, dan santunan.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-fire text-warning me-2"></i>Sumpah Pemuda</h6>
                            <p class="text-secondary small mb-0">Program kepemudaan untuk memacu semangat para relawan berkontribusi aktif dalam misi kemanusiaan.</p>
                        </div>
                    </div>
                    <div class="col-md-6 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-gift text-success me-2"></i>Lebaran Yatim (Muharram)</h6>
                            <p class="text-secondary small mb-0">Penyaluran sembako dan beasiswa pendidikan spesial bulan Muharram bagi adik yatim, dhuafa, dan tahfizh.</p>
                        </div>
                    </div>
                    <div class="col-md-6 lz-tab-item">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-quran text-success me-2"></i>Kelas Tahfiz</h6>
                            <p class="text-secondary small mb-0">Pembinaan rutin dua minggu sekali untuk mendalami Al-Qur'an, setoran hafalan ayat, dan murojaah.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===============================================================
             6. FULL PETA INDONESIA SEBARAN PROGRAM & LOKASI KANTOR LAYANAN
             =============================================================== -->
        <div class="lz-block" id="sec-jangkauan">
            <div class="mb-5 gsap-reveal">
                <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-3">
                    <div>
                        <span class="lz-kicker lz-kicker--amber">Jangkauan Nasional</span>
                        <h2 class="lz-heading mb-1">Peta Sebaran Implementasi Program</h2>
                        <p class="lz-subtext">
                            Klik titik lokasi di peta Indonesia atau pilih kota di bawah untuk melihat wilayah penyaluran program LAZ Graha Dhuafa Indonesia.
                        </p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="lz-map-legend">
                            <span><span class="lz-legend-dot" style="background: #f97316;"></span>Kantor & Unit Layanan</span>
                            <span><span class="lz-legend-dot" style="background: #00875A;"></span>Wilayah Implementasi</span>
                        </div>
                        <button type="button" class="lz-btn-outline" id="btnResetMap">
                            <i class="fas fa-globe-asia"></i> Reset Peta
                        </button>
                    </div>
                </div>

                @php
                    $petaWilayah = [
                        ['nama' => 'Kota Bandung', 'ket' => 'Kantor Pusat LAZ GDI', 'desc' => 'Pusat koordinasi program Budaya, CINTA, SENYUM, Bandung Berdzikir & layanan zakat.', 'lat' => -6.9175, 'lng' => 107.6191, 'office' => true],
                        ['nama' => 'Kab. Bandung', 'ket' => 'Wilayah Implementasi • Jawa Barat', 'desc' => 'Penyaluran Beasiswa Tahfizh, BBM, sembako dhuafa & kelas tahfiz.', 'lat' => -7.0253, 'lng' => 107.5198, 'office' => false],
                        ['nama' => 'Kab. Bandung Barat', 'ket' => 'Wilayah Implementasi • Jawa Barat', 'desc' => 'Program pemberdayaan ekonomi Insan Kreatif & santunan yatim dhuafa.', 'lat' => -6.8652, 'lng' => 107.4920, 'office' => false],
                        ['nama' => 'Cimahi', 'ket' => 'Wilayah Implementasi • Jawa Barat', 'desc' => 'Program Jumat Berbagi, bantuan pangan & layanan ambulans dhuafa.', 'lat' => -6.8722, 'lng' => 107.5425, 'office' => false],
                        ['nama' => 'Sukabumi', 'ket' => 'Wilayah Implementasi • Jawa Barat', 'desc' => 'Distribusi Sedekah Al-Qur\'an, bantuan kemanusiaan & santunan.', 'lat' => -6.9277, 'lng' => 106.9300, 'office' => false],
                        ['nama' => 'Karawang', 'ket' => 'Kantor Daerah • Graha Tahfizh', 'desc' => 'Kantor GDI Karawang & pembinaan Graha Tahfizh Syamsul Bahri.', 'lat' => -6.3227, 'lng' => 107.3376, 'office' => true],
                        ['nama' => 'Jakarta', 'ket' => 'Kantor Daerah • DKI Jakarta', 'desc' => 'Kantor GDI Jakarta, layanan kemitraan & distribusi program sosial.', 'lat' => -6.2088, 'lng' => 106.8456, 'office' => true],
                        ['nama' => 'Tangerang', 'ket' => 'Wilayah Implementasi • Banten', 'desc' => 'Penyaluran paket sembako dhuafa & program sosial kemanusiaan.', 'lat' => -6.1783, 'lng' => 106.6319, 'office' => false],
                        ['nama' => 'Yogyakarta', 'ket' => 'Unit Layanan • DI Yogyakarta', 'desc' => 'Unit Layanan LAZ GDI Sleman Yogyakarta & pembinaan masyarakat.', 'lat' => -7.7956, 'lng' => 110.3695, 'office' => true],
                        ['nama' => 'Solo', 'ket' => 'Unit Layanan • Jawa Tengah', 'desc' => 'Unit Layanan Graha Dhuafa Solo & penyaluran program pendidikan.', 'lat' => -7.5755, 'lng' => 110.8243, 'office' => true],
                        ['nama' => 'Surabaya', 'ket' => 'Wilayah Implementasi • Jawa Timur', 'desc' => 'Implementasi program sosial, dakwah & jaringan relawan Jawa Timur.', 'lat' => -7.2575, 'lng' => 112.7521, 'office' => false],
                        ['nama' => 'Bali', 'ket' => 'Wilayah Implementasi • Bali', 'desc' => 'Distribusi Sedekah Al-Qur\'an & program kepedulian masyarakat.', 'lat' => -8.4095, 'lng' => 115.1889, 'office' => false],
                        ['nama' => 'NTB', 'ket' => 'Wilayah Implementasi • NTB', 'desc' => 'Aksi tanggap bencana, Peace Qurban & penyaluran bantuan pangan.', 'lat' => -8.5833, 'lng' => 116.1167, 'office' => false],
                        ['nama' => 'Kupang NTT', 'ket' => 'Wilayah Implementasi • NTT', 'desc' => 'Distribusi Peace Qurban siap saji & bantuan banjir/kemanusiaan NTT.', 'lat' => -10.1772, 'lng' => 123.6070, 'office' => false],
                        ['nama' => 'Makassar', 'ket' => 'Wilayah Implementasi • Sulsel', 'desc' => 'Implementasi program dakwah, pendidikan & santunan dhuafa.', 'lat' => -5.1477, 'lng' => 119.4327, 'office' => false],
                        ['nama' => 'Kalimantan Selatan', 'ket' => 'Wilayah Implementasi • Kalsel', 'desc' => 'Distribusi bantuan sosial & Sedekah Al-Qur\'an untuk pelosok.', 'lat' => -3.3194, 'lng' => 114.5908, 'office' => false],
                        ['nama' => 'Merauke', 'ket' => 'Wilayah Implementasi • Papua Selatan', 'desc' => 'Penyaluran Peace Qurban & misi kemanusiaan untuk saudara di Papua.', 'lat' => -8.4932, 'lng' => 140.4018, 'office' => false],
                    ];
                @endphp

                <div class="lz-glass lz-map-shell">
                    <div id="indonesiaProgramMap"></div>

                    <!-- Tombol Pintas Kota untuk Fokus di Peta -->
                    <div class="lz-map-chips" id="lzMapChips">
                        @foreach($petaWilayah as $mIdx => $w)
                            <button type="button"
                                    class="lz-map-chip {{ $w['office'] ? 'lz-map-chip--office' : '' }}"
                                    data-map-idx="{{ $mIdx }}">
                                <span style="width:7px;height:7px;border-radius:50%;background:{{ $w['office'] ? '#f97316' : '#00875A' }};display:inline-block;"></span>
                                {{ $w['nama'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- LOKASI KANTOR PUSAT & UNIT LAYANAN -->
            <div>
                <div class="mb-4 gsap-reveal">
                    <span class="lz-kicker">Lokasi Resmi</span>
                    <h3 class="lz-heading" style="font-size: 25px;">Kantor Pusat & Unit Layanan LAZ GDI</h3>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3 gsap-stagger-office">
                        <div class="lz-glass lz-glass--hover lz-glass--mint p-4 h-100">
                            <span class="lz-kicker lz-kicker--amber">Kantor Pusat</span>
                            <h6 class="fw-bold text-dark mb-2">Bandung</h6>
                            <p class="text-secondary small mb-3" style="line-height: 1.65;">
                                Jl. Cijagra No. 21, Cijagra, Kec. Lengkong, Kota Bandung, Jawa Barat 40286
                            </p>
                            <div class="small text-dark fw-semibold"><i class="fas fa-phone-alt text-success me-1"></i> 022-4572-6111</div>
                            <div class="small text-muted"><i class="fab fa-instagram text-danger me-1"></i> @pedulimenjaga.generasi</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 gsap-stagger-office">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-kicker">Kantor Daerah</span>
                            <h6 class="fw-bold text-dark mb-2">Karawang</h6>
                            <p class="text-secondary small mb-3" style="line-height: 1.65;">
                                Graha Tahfizh Syamsul Bahri — Kp. Lamaran RT 04 RW 05 No. 36, Kel. Palumbonsari, Karawang Timur
                            </p>
                            <div class="small text-muted"><i class="fab fa-instagram text-danger me-1"></i> @grahadhuafakrw</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 gsap-stagger-office">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-kicker">Unit Layanan</span>
                            <h6 class="fw-bold text-dark mb-2">Yogyakarta</h6>
                            <p class="text-secondary small mb-0" style="line-height: 1.65;">
                                Jl. Graha Sinduadi No. 14, Kutu Tegal, Sinduadi, Kec. Mlati, Kab. Sleman, DI Yogyakarta 55284
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 gsap-stagger-office">
                        <div class="lz-glass lz-glass--hover p-4 h-100">
                            <span class="lz-kicker">Unit Layanan</span>
                            <h6 class="fw-bold text-dark mb-2">Solo</h6>
                            <p class="text-secondary small mb-0" style="line-height: 1.65;">
                                Jl. Gentan Pelangi Indah Blok A3, Gentan, Kec. Baki, Kab. Sukoharjo, Jawa Tengah 57557
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. CAROUSEL LANDASAN & DASAR HUKUM (Bergeser otomatis tiap 3 detik)
        (function initLawCarousel() {
            const track = document.getElementById('lawTrack');
            const wrap = document.getElementById('lawCarouselWrap');
            const dots = document.querySelectorAll('#lawDots .lz-dot');
            const counter = document.getElementById('lawCounter');
            const prev = document.getElementById('lawPrev');
            const next = document.getElementById('lawNext');
            if (!track) return;

            const total = track.children.length;
            let idx = 0;
            let timer = null;

            function goTo(i) {
                idx = (i + total) % total;
                track.style.transform = 'translateX(-' + (idx * 100) + '%)';
                dots.forEach(function (d, k) { d.classList.toggle('active', k === idx); });
                if (counter) counter.textContent = '0' + (idx + 1) + ' / 0' + total;
            }

            function start() {
                stop();
                timer = setInterval(function () { goTo(idx + 1); }, 3000);
            }
            function stop() {
                if (timer) { clearInterval(timer); timer = null; }
            }

            if (prev) prev.addEventListener('click', function () { goTo(idx - 1); start(); });
            if (next) next.addEventListener('click', function () { goTo(idx + 1); start(); });
            dots.forEach(function (d) {
                d.addEventListener('click', function () {
                    goTo(parseInt(d.getAttribute('data-law-dot'), 10) || 0);
                    start();
                });
            });
            if (wrap) {
                wrap.addEventListener('mouseenter', stop);
                wrap.addEventListener('mouseleave', start);
            }
            start();
        })();

        // 2. FULL PETA INDONESIA INTERAKTIF (LEAFLET + 17 LOKASI IMPLEMENTASI)
        (function initIndonesiaMap() {
            const mapEl = document.getElementById('indonesiaProgramMap');
            if (!mapEl || !window.L) return;

            const locations = @json($petaWilayah ?? []);
            const defaultCenter = [-2.5, 118.0];
            const defaultZoom = window.innerWidth < 768 ? 4 : 5;

            const map = L.map('indonesiaProgramMap', {
                center: defaultCenter,
                zoom: defaultZoom,
                minZoom: 4,
                maxZoom: 13,
                scrollWheelZoom: false
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            const markers = [];
            locations.forEach(function (loc, idx) {
                const iconHtml =
                    '<div class="lz-pin-wrap ' + (loc.office ? 'lz-pin-wrap--office' : '') + '">' +
                        '<span class="lz-pin-pulse"></span>' +
                        '<span class="lz-pin-dot"></span>' +
                    '</div>';

                const customIcon = L.divIcon({
                    html: iconHtml,
                    className: 'lz-leaflet-custom-pin',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12],
                    popupAnchor: [0, -10]
                });

                const badgeColor = loc.office ? '#ea580c' : '#00875A';
                const badgeBg = loc.office ? '#fff7ed' : '#ecfdf5';
                const popupHtml =
                    '<div>' +
                        '<div style="display:inline-block;font-size:10.5px;font-weight:800;text-transform:uppercase;letter-spacing:0.6px;padding:3px 9px;border-radius:999px;background:' + badgeBg + ';color:' + badgeColor + ';margin-bottom:6px;">' + loc.ket + '</div>' +
                        '<div style="font-size:15px;font-weight:800;color:#0f172a;margin-bottom:4px;">' + loc.nama + '</div>' +
                        '<div style="font-size:12.5px;color:#475569;line-height:1.5;">' + loc.desc + '</div>' +
                    '</div>';

                const marker = L.marker([loc.lat, loc.lng], { icon: customIcon })
                    .addTo(map)
                    .bindPopup(popupHtml);

                marker.on('click', function () {
                    document.querySelectorAll('#lzMapChips .lz-map-chip').forEach(function (c, i) {
                        c.classList.toggle('active', i === idx);
                    });
                });

                markers.push(marker);
            });

            // Klik chip kota di bawah peta -> fokus & buka popup lokasi
            const chips = document.querySelectorAll('#lzMapChips .lz-map-chip');
            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    const i = parseInt(chip.getAttribute('data-map-idx'), 10);
                    const loc = locations[i];
                    if (!loc || !markers[i]) return;
                    chips.forEach(function (c) { c.classList.remove('active'); });
                    chip.classList.add('active');
                    map.flyTo([loc.lat, loc.lng], 9, { duration: 0.9 });
                    markers[i].openPopup();
                });
            });

            // Reset ke tampilan Full Indonesia
            const resetBtn = document.getElementById('btnResetMap');
            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    chips.forEach(function (c) { c.classList.remove('active'); });
                    map.closePopup();
                    map.flyTo(defaultCenter, defaultZoom, { duration: 0.9 });
                });
            }
        })();

        // 3. INTERACTIVE GLASS TABS + GSAP STAGGER
        const tabBtns = document.querySelectorAll('#lzTabsNav .lz-tab-btn');
        const tabPanes = document.querySelectorAll('.lz-tab-pane');

        tabBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const targetId = btn.getAttribute('data-tab');
                tabBtns.forEach(function (b) { b.classList.remove('active'); });
                tabPanes.forEach(function (p) { p.classList.remove('active'); });

                btn.classList.add('active');
                const pane = document.getElementById(targetId);
                if (pane) {
                    pane.classList.add('active');
                    if (window.gsap) {
                        gsap.fromTo(
                            pane.querySelectorAll('.lz-tab-item'),
                            { y: 18, opacity: 0 },
                            { y: 0, opacity: 1, duration: 0.45, stagger: 0.06, ease: 'power2.out', clearProps: 'transform,opacity' }
                        );
                    }
                }
            });
        });

        // 4. GSAP + SCROLLTRIGGER ANIMATIONS
        if (!window.gsap) return;
        if (window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        gsap.from('.gsap-hero', {
            y: 26, opacity: 0, duration: 0.75, ease: 'power3.out', clearProps: 'transform,opacity'
        });

        gsap.utils.toArray('.gsap-reveal').forEach(function (el) {
            gsap.from(el, {
                scrollTrigger: { trigger: el, start: 'top 86%', once: true },
                y: 22, opacity: 0, duration: 0.6, ease: 'power2.out', clearProps: 'transform,opacity'
            });
        });

        const fillLine = document.getElementById('lzHistoryFill');
        if (fillLine) {
            gsap.from(fillLine, {
                scrollTrigger: { trigger: '#sec-sejarah', start: 'top 76%', once: true },
                scaleX: 0, duration: 1.1, ease: 'power2.inOut'
            });
        }

        [
            ['.gsap-stagger-history', '#sec-sejarah', 0.12],
            ['.gsap-stagger-legal', '.gsap-stagger-legal', 0.09],
            ['.gsap-stagger-misi', '#sec-visimisi', 0.1],
            ['.gsap-stagger-mantap', '.gsap-stagger-mantap', 0.08],
            ['.gsap-stagger-org', '#sec-struktur', 0.05],
            ['.gsap-stagger-office', '.gsap-stagger-office', 0.09]
        ].forEach(function (cfg) {
            gsap.from(cfg[0], {
                scrollTrigger: { trigger: cfg[1], start: 'top 84%', once: true },
                y: 24, opacity: 0, duration: 0.55, stagger: cfg[2], ease: 'power2.out', clearProps: 'transform,opacity'
            });
        });
    });
</script>
@endpush
