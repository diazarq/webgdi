@extends('layout.layout-page', ['active' => [], 'hidePageHeader' => true])

@section('title', $pageTitle)

@section('style')
<style>
    html {
        scroll-behavior: smooth;
    }

    /* Navbar: jangan menumpuk konten hero di halaman ini */
    .main-header-two {
        position: relative;
        background: linear-gradient(135deg, #04231a 0%, #06301f 50%, #0a4a2e 100%);
    }

    /* ================= Hero ================= */
    .budaya-hero {
        position: relative;
        z-index: 1;
        overflow: hidden;
        padding: 110px 0 140px;
        background: linear-gradient(135deg, #04231a 0%, #06301f 30%, #0a4a2e 65%, #0d5c38 100%);
        color: #fff;
    }

    .budaya-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1.2px, transparent 1.2px);
        background-size: 26px 26px;
        pointer-events: none;
        z-index: 2;
    }

    /* Foto latar: tampil penuh di hero & ikut bergulir, tidak terpotong saat di-scroll */
    .page-header .page-header-bg,
    .budaya-hero .page-header-bg {
        background-attachment: scroll;
    }

    /* ---- Aurora blobs: cahaya lembut beranimasi ---- */
    .budaya-hero__blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
        z-index: 1;
    }

    .budaya-hero__blob--1 {
        width: 520px;
        height: 520px;
        top: -180px;
        right: -100px;
        background: radial-gradient(circle, rgba(45, 212, 167, 0.50), transparent 65%);
        animation: budayaFloat 9s ease-in-out infinite alternate;
    }

    .budaya-hero__blob--2 {
        width: 460px;
        height: 460px;
        bottom: -200px;
        left: -140px;
        background: radial-gradient(circle, rgba(255, 138, 61, 0.32), transparent 65%);
        animation: budayaFloat 12s ease-in-out infinite alternate-reverse;
    }

    @keyframes budayaFloat {
        from { transform: translate(0, 0) scale(1); }
        to   { transform: translate(50px, 35px) scale(1.1); }
    }

    @media (prefers-reduced-motion: reduce) {
        .budaya-hero__blob--1,
        .budaya-hero__blob--2 {
            animation: none;
        }
    }

    .budaya-hero__inner {
        position: relative;
        z-index: 3;
        max-width: none;
        padding: 0 40px; /* sejajar dengan logo Graha Dhuafa Indonesia di navbar (padding 40px) */
    }

    /* ===== Blok konten: logo kiri + nama & tagline di sebelahnya ===== */
    .budaya-hero__brand {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    /* Badge glass "Program Unggulan" */
    .budaya-hero__badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 9px 20px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        font-size: 13.5px;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #bff0dc;
        margin-bottom: 32px;
    }

    .budaya-hero__badge .budaya-hero__badge-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #2dd4a7;
        animation: budayaPulse 2s infinite;
    }

    @keyframes budayaPulse {
        0%   { box-shadow: 0 0 0 0 rgba(45, 212, 167, 0.55); }
        70%  { box-shadow: 0 0 0 10px rgba(45, 212, 167, 0); }
        100% { box-shadow: 0 0 0 0 rgba(45, 212, 167, 0); }
    }

    /* Susunan vertikal: logo di atas, nama & tagline di bawah, semuanya center */
    .budaya-hero__brand-top {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 26px;
        margin-bottom: 18px;
    }

    /* Logo bulat dengan ring bercahaya */
    .budaya-hero__logo {
        width: 140px;
        height: 140px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #ffffff;
        overflow: hidden;
        border: 4px solid rgba(255, 255, 255, 0.35);
        box-shadow:
            0 24px 60px rgba(0, 0, 0, 0.40),
            0 0 70px rgba(45, 212, 167, 0.35);
    }

    .budaya-hero__logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top;
        display: block;
    }

    /* Kolom teks di bawah logo */
    .budaya-hero__brand-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .budaya-hero__brand-name {
        font-size: clamp(56px, 7vw, 92px);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: 0.01em;
        background: linear-gradient(90deg, #ffffff 35%, #a9f2d3 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        filter: drop-shadow(0 6px 24px rgba(0, 0, 0, 0.35));
    }

    .budaya-hero__brand-sub {
        font-size: clamp(20px, 2.2vw, 28px);
        font-weight: 600;
        color: #7ef0c0;
        line-height: 1.45;
        margin-bottom: 0;
    }

    .budaya-hero__brand-desc {
        font-size: 19px;
        line-height: 1.85;
        color: rgba(255, 255, 255, 0.92);
        text-shadow: 0 2px 10px rgba(4, 35, 26, 0.55);
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 38px;
    }

    /* ===== Tombol CTA ===== */
    .budaya-hero__cta {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px;
    }

    .budaya-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 18px 40px;
        border-radius: 999px;
        font-size: 16.5px;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-decoration: none !important;
        transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
    }

    .budaya-btn svg {
        width: 20px;
        height: 20px;
        transition: transform 0.25s ease;
    }

    .budaya-btn--primary {
        background: linear-gradient(90deg, #ff8a3d, #ff6600);
        color: #ffffff !important;
        box-shadow: 0 14px 34px rgba(255, 102, 0, 0.35);
    }

    .budaya-btn--primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 44px rgba(255, 102, 0, 0.45);
        color: #ffffff !important;
    }

    .budaya-btn--primary:hover svg {
        transform: translateX(4px);
    }

    .budaya-btn--ghost {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.30);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #ffffff !important;
    }

    .budaya-btn--ghost:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.16);
        color: #ffffff !important;
    }

    /* Scroll indicator */
    .budaya-hero__scroll {
        position: absolute;
        left: 50%;
        bottom: 24px;
        transform: translateX(-50%);
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, 0.65);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        text-decoration: none !important;
    }

    .budaya-hero__scroll-line {
        width: 2px;
        height: 34px;
        border-radius: 999px;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.7), transparent);
        animation: budayaScroll 1.8s ease-in-out infinite;
    }

    @keyframes budayaScroll {
        0%, 100% { transform: scaleY(0.6); opacity: 0.5; }
        50%      { transform: scaleY(1); opacity: 1; }
    }

    /* ================= Section umum ================= */
    .budaya-section {
        padding: 80px 0;
    }

    .budaya-section--alt {
        background: #f6fbf8;
    }

    .budaya-section__head {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 46px;
    }

    .budaya-section__hint {
        display: block;
        margin-top: 14px;
        font-size: 14.5px;
        color: #5b6b66;
    }

    .budaya-section__hint svg {
        width: 15px;
        height: 15px;
        vertical-align: -2px;
        margin-right: 4px;
        color: #1a8b4c;
    }

    .budaya-section__tagline {
        display: inline-block;
        color: #ff6600;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        background: rgba(255, 102, 0, 0.08);
        border: 1px solid rgba(255, 102, 0, 0.25);
        padding: 7px 18px;
        border-radius: 999px;
        margin-bottom: 14px;
    }

    .budaya-section__title {
        font-size: 30px;
        font-weight: 800;
        color: #143a2c;
        line-height: 1.35;
    }

    .budaya-section__title::after {
        content: "";
        display: block;
        width: 68px;
        height: 4px;
        border-radius: 999px;
        margin: 16px auto 0;
        background: linear-gradient(90deg, #ff8a3d, #1a8b4c);
    }

    /* ================= Galeri ================= */
    .budaya-galeri {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 15px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }

    .budaya-galeri__item {
        position: relative;
        display: block;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(20, 58, 44, 0.12);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .budaya-galeri__item:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 44px rgba(20, 58, 44, 0.2);
    }

    /* Lapisan hover: ajakan "lihat detail" di atas foto */
    .budaya-galeri__item .budaya-galeri__hover {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: rgba(4, 35, 26, 0.62);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .budaya-galeri__item:hover .budaya-galeri__hover {
        opacity: 1;
    }

    .budaya-galeri__hover-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        color: #ffffff;
        transition: transform 0.3s ease;
    }

    .budaya-galeri__item:hover .budaya-galeri__hover-icon {
        transform: scale(1.08);
    }

    .budaya-galeri__hover-icon svg {
        width: 22px;
        height: 22px;
    }

    .budaya-galeri__hover-text {
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #ffffff;
    }

    .budaya-galeri__item img {
        width: 100%;
        height: 240px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    .budaya-galeri__item:hover img {
        transform: scale(1.06);
    }

    .budaya-galeri__item::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(6, 48, 31, 0.55), transparent 55%);
        pointer-events: none;
    }

    .budaya-galeri__caption {
        position: absolute;
        left: 18px;
        bottom: 14px;
        z-index: 1;
        color: #ffffff;
        font-weight: 700;
        font-size: 15px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }

    .budaya-galeri__tag {
        position: absolute;
        top: 14px;
        left: 18px;
        z-index: 1;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #ffffff;
        background: rgba(255, 102, 0, 0.85);
        padding: 4px 12px;
        border-radius: 999px;
    }

    /* ================= Statistik ================= */
    .budaya-stat {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .budaya-stat__card {
        background: #ffffff;
        border: 1px solid #e6efe9;
        border-radius: 16px;
        box-shadow: 0 10px 28px rgba(20, 58, 44, 0.08);
        padding: 26px 18px;
        text-align: center;
    }

    .budaya-stat__icon {
        display: block;
        font-size: 32px;
        line-height: 1;
        margin-bottom: 12px;
    }

    .budaya-stat__icon img {
        max-height: 42px;
        width: auto;
    }

    .budaya-stat__value {
        display: block;
        color: #143a2c;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
    }

    .budaya-stat__label {
        display: block;
        color: #5b6b66;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.08em;
        margin-top: 6px;
        text-transform: uppercase;
    }

    /* ================= Manfaat ================= */
    .budaya-manfaat {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .budaya-manfaat__card {
        background: #ffffff;
        border: 1px solid #e6efe9;
        border-radius: 16px;
        box-shadow: 0 10px 28px rgba(20, 58, 44, 0.08);
        height: 100%;
        padding: 28px 24px;
    }

    .budaya-manfaat__icon {
        align-items: center;
        background: rgba(26, 139, 76, 0.1);
        border-radius: 12px;
        color: #1a8b4c;
        display: inline-flex;
        height: 46px;
        justify-content: center;
        margin-bottom: 16px;
        width: 46px;
    }

    .budaya-manfaat__icon svg {
        height: 24px;
        width: 24px;
    }

    .budaya-manfaat__title {
        color: #143a2c;
        font-size: 17px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .budaya-manfaat__desc {
        color: #5b6b66;
        font-size: 14.5px;
        line-height: 1.7;
        margin: 0;
    }

    /* ================= FAQ ================= */
    .budaya-faq {
        margin: 0 auto;
        max-width: 820px;
        padding: 0 15px;
    }

    .budaya-faq .accordion-item {
        background: #ffffff;
        border: 1px solid #e6efe9;
        border-radius: 12px;
        margin-bottom: 12px;
        overflow: hidden;
    }

    .budaya-faq .accordion-button {
        background: #ffffff;
        color: #143a2c;
        box-shadow: none;
        font-size: 15px;
        font-weight: 700;
        padding: 18px 20px;
    }

    .budaya-faq .accordion-button:not(.collapsed) {
        background: #eef8f1;
        color: #0a4a2e;
    }

    .budaya-faq .accordion-button:focus {
        border-color: #cfe6d7;
        box-shadow: none;
    }

    .budaya-faq .accordion-body {
        color: #5b6b66;
        font-size: 14.5px;
        line-height: 1.75;
        padding: 0 20px 20px;
    }

    @media (max-width: 991px) {
        .budaya-stat {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .budaya-manfaat {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575px) {
        .budaya-stat {
            grid-template-columns: 1fr;
        }
    }

    /* ================= Responsive ================= */
    @media (max-width: 991px) {
        .budaya-hero {
            padding: 60px 0 90px;
        }

        .budaya-hero__inner {
            padding: 0 20px;
        }

        .budaya-hero__blob--1 {
            width: 340px;
            height: 340px;
            top: -120px;
            right: -120px;
        }

        .budaya-hero__blob--2 {
            width: 300px;
            height: 300px;
            bottom: -140px;
            left: -120px;
        }

        /* Di HP: blok brand (logo + judul) tampil paling atas & tetap di tengah */
        .budaya-hero__brand {
            order: -1;
            text-align: center;
            width: auto;
            margin-left: 0;
        }

        .budaya-hero__badge {
            font-size: 11px;
            padding: 8px 16px;
        }

        .budaya-hero__brand-top {
            gap: 18px;
        }

        .budaya-hero__brand-text {
            align-items: center;
        }

        .budaya-hero__brand-name {
            font-size: 40px;
        }

        .budaya-hero__brand-sub {
            font-size: 16px;
        }

        .budaya-hero__logo {
            width: 110px;
            height: 110px;
        }

        .budaya-hero__brand-desc {
            margin-left: auto;
            margin-right: auto;
            font-size: 15.5px;
        }

        .budaya-hero__cta {
            justify-content: center;
        }

        .budaya-btn {
            padding: 13px 26px;
            font-size: 14px;
        }

        .budaya-hero__scroll {
            display: none;
        }

        .budaya-galeri {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('breadcrumb')
<h2>Program {{ $pilar['title'] }}</h2>
@endsection

@section('pageGeneral')

<!-- ====== Hero Program ====== -->
@php
    /* fallback ke data default per program bila data hero belum diisi di admin */
    $heroSlug        = @$landing->slug ?: $pilar['title'];
    $heroBadge       = @$landing->badge_text ?: $pilar['badge'];
    $heroLogo        = @$landing->logo_image ? asset($landing->logo_image) : asset($pilar['logo']);
    $heroTitle       = @$landing->title ?: $pilar['title'];
    $heroTagline     = @$landing->tagline ?: $pilar['tagline'];
    $heroDescription = @$landing->description ?: $pilar['description'];
    $heroBackground  = @$landing->background_image ? asset($landing->background_image) : asset($pilar['background']);
@endphp
<section class="budaya-hero">
    <div class="page-header-bg" style="background-image: url({{ $heroBackground }})"></div>
    <div class="page-header-overlay" aria-hidden="true"></div>

    <div class="budaya-hero__blob budaya-hero__blob--1" aria-hidden="true"></div>
    <div class="budaya-hero__blob budaya-hero__blob--2" aria-hidden="true"></div>

    <div class="budaya-hero__inner">
        <div class="budaya-hero__brand">
            @if(trim($heroBadge) !== '')
            <span class="budaya-hero__badge">
                <span class="budaya-hero__badge-dot"></span>
                {{ $heroBadge }}
            </span>
            @endif

            <div class="budaya-hero__brand-top">
                <div class="budaya-hero__logo">
                    <img src="{{ $heroLogo }}" alt="Logo Program {{ $heroTitle }}"/>
                </div>
                <div class="budaya-hero__brand-text">
                    <span class="budaya-hero__brand-name">{{ $heroTitle }}</span>
                    @if(trim($heroTagline) !== '')
                    <p class="budaya-hero__brand-sub">{{ $heroTagline }}</p>
                    @endif
                </div>
            </div>

            @if(trim($heroDescription) !== '')
            <p class="budaya-hero__brand-desc">{!! nl2br(e($heroDescription)) !!}</p>
            @endif

            {{-- Tombol "Lihat Galeri Kegiatan" dihilangkan sementara --}}
            {{--
            <div class="budaya-hero__cta">
                <a href="#galeri" class="budaya-btn budaya-btn--primary">
                    Lihat Galeri Kegiatan
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </a>
            </div>
            --}}
        </div>
    </div>

    <a href="#galeri" class="budaya-hero__scroll" aria-label="Scroll ke bawah">
        <span class="budaya-hero__scroll-line"></span>
        Scroll
    </a>
</section>

<!-- ====== Galeri Kegiatan ====== -->
<section class="budaya-section budaya-section--alt" id="galeri">
    <div class="budaya-section__head">
        <span class="budaya-section__tagline">Dokumentasi</span>
        <h2 class="budaya-section__title">{{ $pilar['section_title'] }}</h2>
        <span class="budaya-section__hint">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            Arahkan kursor ke foto untuk melihat informasi lebih lanjut terkait kegiatan di gambarnya
        </span>
    </div>

    <div class="budaya-galeri">
        @foreach($dokumentasi as $g)
            @if(!empty($g['url']))
                <a class="budaya-galeri__item" href="{{ $g['url'] }}" target="_blank" rel="noopener">
            @else
                <div class="budaya-galeri__item" tabindex="0">
            @endif
                <img src="{{ $g['src'] }}" alt="{{ $g['alt'] }}"/>
                <span class="budaya-galeri__tag">{{ $g['tag'] }}</span>
                <span class="budaya-galeri__caption">{{ $g['caption'] }}</span>

                <div class="budaya-galeri__hover" aria-hidden="true">
                    <span class="budaya-galeri__hover-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            @if(!empty($g['url']))
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                <polyline points="15 3 21 3 21 9"/>
                                <line x1="10" y1="14" x2="21" y2="3"/>
                            @else
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                <line x1="11" y1="8" x2="11" y2="14"/>
                                <line x1="8" y1="11" x2="14" y2="11"/>
                            @endif
                        </svg>
                    </span>
                    <span class="budaya-galeri__hover-text">@if(!empty($g['url']))Buka Halaman {{ $g['tag'] }}@else Lihat Detail Kegiatan @endif</span>
                </div>
            @if(!empty($g['url']))
                </a>
            @else
                </div>
            @endif
        @endforeach
    </div>
</section>

<!-- ====== Statistik Program ====== -->
@if($statistik->count())
<section class="budaya-section" id="statistik">
    <div class="budaya-section__head">
        <span class="budaya-section__tagline">Statistik</span>
        <h2 class="budaya-section__title">Statistik Program {{ $pilar['title'] }}</h2>
    </div>

    <div class="budaya-stat">
        @foreach($statistik as $stat)
            @php
                $iconVal     = trim($stat->icon ?? '');
                $isImageIcon = $iconVal !== '' && strpos($iconVal, '/') !== false;
                $isHtmlIcon  = strpos($iconVal, '<') !== false;
            @endphp
            <div class="budaya-stat__card">
                <span class="budaya-stat__icon" aria-hidden="true">
                    @if($isImageIcon)
                        <img src="{{ asset($iconVal) }}" alt="{{ $stat->label_judul }}"/>
                    @elseif($isHtmlIcon)
                        {!! $iconVal !!}
                    @else
                        {{ $iconVal }}
                    @endif
                </span>
                <span class="budaya-stat__value">{{ $stat->angka_nilai }}</span>
                <span class="budaya-stat__label">{{ $stat->label_judul }}</span>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- ====== Manfaat Program ====== -->
@if(count($manfaat))
<section class="budaya-section budaya-section--alt" id="manfaat">
    <div class="budaya-section__head">
        <span class="budaya-section__tagline">Manfaat</span>
        <h2 class="budaya-section__title">Manfaat Program {{ $pilar['title'] }}</h2>
    </div>

    <div class="budaya-manfaat">
        @php
            $manfaatIcons = [
                '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
                '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
                '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
            ];
        @endphp
        @foreach($manfaat as $i => $m)
            <div class="budaya-manfaat__card">
                <span class="budaya-manfaat__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        {!! $manfaatIcons[$i % count($manfaatIcons)] !!}
                    </svg>
                </span>
                <h3 class="budaya-manfaat__title">{{ $m['title'] }}</h3>
                <p class="budaya-manfaat__desc">{{ $m['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- ====== FAQ Program ====== -->
@if(count($faq))
<section class="budaya-section" id="faq">
    <div class="budaya-section__head">
        <span class="budaya-section__tagline">Tanya Jawab</span>
        <h2 class="budaya-section__title">FAQ Program {{ $pilar['title'] }}</h2>
    </div>

    <div class="accordion budaya-faq" id="budayaFaqAccordion">
        @foreach($faq as $i => $q)
            <div class="accordion-item">
                <h3 class="accordion-header" id="budayaFaqHeading{{ $i }}">
                    <button class="accordion-button {{ $i === 0 ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#budayaFaqCollapse{{ $i }}"
                            aria-expanded="{{ $i === 0 ? 'true' : 'false' }}" aria-controls="budayaFaqCollapse{{ $i }}">
                        {{ $q['question'] }}
                    </button>
                </h3>
                <div id="budayaFaqCollapse{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                     aria-labelledby="budayaFaqHeading{{ $i }}" data-bs-parent="#budayaFaqAccordion">
                    <div class="accordion-body">{{ $q['answer'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

@endsection
