@extends('layout.layout-page', ['active' => [], 'hidePageHeader' => true])

@section('title', $pageTitle)

@section('style')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300;1,400;1,500&family=Playfair+Display:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
<style>
    html {
        scroll-behavior: smooth;
    }

    /* Navbar: jangan menumpuk konten hero di halaman ini */
    .main-header-two {
        position: relative;
        background: linear-gradient(135deg, #04231a 0%, #06301f 50%, #0a4a2e 100%);
    }

    /* ================= Section umum ================= */
    .budaya-section {
        padding: 80px 0;
    }

    .budaya-section--alt {
        background: #ffffff;
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

    /* ================= Dokumentasi Editorial Showcase ================= */
    .dok-editorial {
        --dok-side-w: 215px;
        --dok-side-h: 275px;
        --dok-center-w: 370px;
        --dok-center-h: 470px;
        --dok-gap: 16px;
        position: relative;
        background: white;
        padding: 76px 0 84px;
        overflow: hidden;
        user-select: none;
    }

    /* Giant Two-Tone Editorial Typography */
    .dok-editorial__display-wrap {
        position: relative;
        z-index: 1;
        text-align: center;
        padding: 0 24px;
        pointer-events: none;
    }

    .dok-editorial__display {
        display: inline-block;
        position: relative;
        margin: 0 0 0.38em;
        font-size: clamp(36px, 7.5vw, 122px);
        line-height: 0.94;
        font-weight: 400;
        white-space: nowrap;
        letter-spacing: -0.025em;
    }

      @font-face {
        font-family: 'Handflair';
        src: url('{{ asset("website/assets/fonts/Handflair.ttf") }}?v={{ time() }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    .dok-editorial__word-serif {
        position: relative;
        z-index: 1;
        font-weight: 800;
        color: #3f3d3a;
    }

    .dok-editorial__word-script {
        display: inline-block;
        position: relative;
        z-index: 2;
        top: 0.42em;
        margin-left: -56px;
        font-family: 'Handflair', 'Playfair Display', Georgia, serif;
        font-style: italic;
        font-weight: 500;
        font-size: 1.14em;
        color: #fd7f4b;
        letter-spacing: -0.01em;
        margin-bottom: 80px;
    }

    /* Sub-header Bar (Centered: Section Title) */
    .dok-subbar {
        position: relative;
        z-index: 5;
        max-width: 1420px;
        margin: 18px auto 28px;
        padding: 0 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 20px;
        pointer-events: none;
    }

    .dok-subbar__left,
    .dok-subbar__right {
        pointer-events: auto;
    }

    .dok-subbar__title {
        font-family: 'Manrope', sans-serif;
        font-size: 18px;
        font-weight: 500;
        color: #353330;
        margin: 0 0 6px;
        letter-spacing: -0.01em;
        line-height: 1.3;
    }

    .dok-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: none;
        border: none;
        padding: 0;
        font-family: 'Manrope', sans-serif;
        font-size: 12.5px;
        font-weight: 400;
        color: #6e6a63;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .dok-filter-btn:hover,
    .dok-filter-btn.is-open {
        color: #262422;
    }

    .dok-filter-btn svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
    }

    /* Collapsible Filter Pills */
    .dok-filter-drawer {
        position: relative;
        z-index: 6;
        max-width: 1420px;
        margin: -16px auto 24px;
        padding: 0 48px;
        display: none;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
    }

    .dok-filter-drawer.is-open {
        display: flex;
    }

    .dok-filter-pill {
        appearance: none;
        border: 1px solid rgba(53, 51, 48, 0.2);
        background: rgba(145, 255, 0, 0.45);
        color: #4a4743;
        font-family: 'Manrope', sans-serif;
        font-size: 12px;
        font-weight: 500;
        padding: 5px 14px;
        border-radius: 999px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .dok-filter-pill:hover {
        background: rgba(255, 255, 255, 0.85);
        color: #1f1e1c;
    }

    .dok-filter-pill.is-active {
        background: #353330;
        border-color: #353330;
        color: #ffffff;
    }

    /* Right View Switcher: Carousel | Cards */
    .dok-subbar__right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .dok-view-tab {
        appearance: none;
        background: none;
        border: none;
        border-bottom: 1.5px solid transparent;
        padding: 0 0 3px;
        font-family: 'Manrope', sans-serif;
        font-size: 13px;
        font-weight: 400;
        color: #8f8a83;
        cursor: pointer;
        transition: color 0.22s ease, border-color 0.22s ease;
    }

    .dok-view-tab:hover {
        color: #353330;
    }

    .dok-view-tab.is-active {
        color: #2b2927;
        font-weight: 500;
        border-bottom-color: #2b2927;
    }

    /* Center-Spotlight Carousel Viewport */
    .dok-carousel-viewport {
        position: relative;
        z-index: 3;
        width: 100%;
        padding-top: 16px;
        margin-top: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .dok-carousel-viewport[hidden] {
        display: none !important;
    }

    .dok-carousel-track {
        display: flex;
        align-items: flex-end;
        gap: var(--dok-gap);
        will-change: transform;
        pointer-events: auto;
        cursor: grab;
    }

    .dok-carousel-track.is-dragging {
        cursor: grabbing;
    }

    .dok-item {
        flex: 0 0 auto;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        text-decoration: none !important;
        color: inherit !important;
        -webkit-tap-highlight-color: transparent;
    }

    .dok-item__media {
        position: relative;
        width: var(--dok-side-w);
        height: var(--dok-side-h);
        overflow: hidden;
        background: #dcd7cf;
    }

    .dok-item.is-center .dok-item__media {
        width: var(--dok-center-w);
        height: var(--dok-center-h);
        box-shadow: 0 24px 60px rgba(32, 30, 26, 0.16);
    }

    .dok-item__media::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        background: linear-gradient(to top, rgba(10, 28, 20, 0.82) 0%, rgba(10, 28, 20, 0.30) 42%, transparent 74%);
        pointer-events: none;
        transition: opacity 0.32s ease;
    }

    .dok-item__media img,
    .dok-grid-card__media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        display: block;
        pointer-events: none;
        transition: transform 0.65s cubic-bezier(0.22, 1, 0.36, 1), filter 0.45s ease;
    }

    .dok-item:hover .dok-item__media img,
    .dok-grid-card:hover .dok-grid-card__media img {
        transform: scale(1.06);
    }

    /* Teks Kegiatan di Dalam Gambar (Hilang Saat Hover) */
    .dok-item__overlay-text {
        position: absolute;
        left: 14px;
        right: 14px;
        bottom: 14px;
        z-index: 2;
        pointer-events: none;
        transition:
            opacity 0.3s ease,
            transform 0.32s cubic-bezier(0.22, 1, 0.36, 1),
            left 0.4s ease,
            right 0.4s ease,
            bottom 0.4s ease;
    }

    .dok-item.is-center .dok-item__overlay-text {
        left: 22px;
        right: 22px;
        bottom: 22px;
    }

    .dok-item__tag {
        display: inline-block;
        font-family: 'Manrope', sans-serif;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.82);
        background: rgba(255, 115, 51, 1);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        padding: 3px 9px;
        border-radius: 999px;
        margin-bottom: 6px;
    }

    .dok-item__caption {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-family: 'Manrope', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.32;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
        transition: font-size 0.4s ease;
    }

    .dok-item.is-center .dok-item__caption {
        font-size: 20px;
    }

    /* Lapisan Hover: Berubah Jadi Icon Membuka Detail */
    .dok-item__hover-detail {
        position: absolute;
        inset: 0;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: rgba(8, 34, 23, 0.52);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.32s ease;
    }

    .dok-item__open-btn {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
        transform: scale(0.82);
        transition: transform 0.34s cubic-bezier(0.22, 1, 0.36, 1), background 0.25s ease;
        box-shadow: 0 10px 26px rgba(0, 0, 0, 0.22);
    }

    .dok-item.is-center .dok-item__open-btn {
        width: 58px;
        height: 58px;
    }

    .dok-item__open-btn iconify-icon {
        font-size: 21px;
        line-height: 1;
        display: inline-flex;
    }

    .dok-item.is-center .dok-item__open-btn iconify-icon {
        font-size: 24px;
    }

    .dok-item__open-label {
        font-family: 'Manrope', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #ffffff;
        transform: translateY(6px);
        transition: transform 0.34s cubic-bezier(0.22, 1, 0.36, 1);
    }

    /* Efek Saat Di-hover: Teks Menghilang -> Icon Buka Detail Muncul */
    .dok-item:hover .dok-item__overlay-text,
    .dok-grid-card:hover .dok-item__overlay-text {
        opacity: 0;
        transform: translateY(10px);
    }

    .dok-item:hover .dok-item__hover-detail,
    .dok-grid-card:hover .dok-item__hover-detail {
        opacity: 1;
        pointer-events: auto;
    }

    .dok-item:hover .dok-item__open-btn,
    .dok-grid-card:hover .dok-item__open-btn {
        transform: scale(1);
    }

    .dok-item__open-btn:hover {
        background: rgba(255, 255, 255, 0.32);
    }

    .dok-item:hover .dok-item__open-label,
    .dok-grid-card:hover .dok-item__open-label {
        transform: translateY(0);
    }

    /* Cards Grid Mode */
    .dok-cards-grid {
        position: relative;
        z-index: 4;
        max-width: 1320px;
        margin: 12px auto 0;
        padding: 0 48px;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 28px 20px;
    }

    .dok-cards-grid[hidden] {
        display: none !important;
    }

    .dok-grid-card {
        display: flex;
        flex-direction: column;
        text-decoration: none !important;
        color: inherit !important;
        cursor: pointer;
    }

    .dok-grid-card__media {
        position: relative;
        width: 100%;
        aspect-ratio: 4 / 5;
        overflow: hidden;
        background: #dcd7cf;
    }

    .dok-grid-card__media::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        background: linear-gradient(to top, rgba(10, 28, 20, 0.82) 0%, rgba(10, 28, 20, 0.30) 42%, transparent 74%);
        pointer-events: none;
    }

    /* Editorial Lightbox Preview */
    .dok-lightbox {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(24, 23, 21, 0.86);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .dok-lightbox.is-open {
        display: flex;
    }

    .dok-lightbox__dialog {
        position: relative;
        max-width: 680px;
        width: 100%;
        background: #ebe7e0;
        padding: 18px 18px 20px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.45);
    }

    .dok-lightbox__close {
        position: absolute;
        top: -42px;
        right: 0;
        background: none;
        border: none;
        color: #ffffff;
        font-family: 'Manrope', sans-serif;
        font-size: 13px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        cursor: pointer;
        padding: 6px 4px;
    }

    .dok-lightbox__img {
        width: 100%;
        max-height: 72vh;
        object-fit: contain;
        display: block;
        background: #dedad2;
    }

    .dok-lightbox__meta {
        padding-top: 14px;
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 12px;
    }

    .dok-lightbox__title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 20px;
        color: #2b2927;
        margin: 0;
    }

    .dok-lightbox__tag {
        font-family: 'Manrope', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #5c5852;
    }

    @media (max-width: 1199px) {
        .dok-editorial {
            --dok-side-w: 185px;
            --dok-side-h: 240px;
            --dok-center-w: 320px;
            --dok-center-h: 410px;
            --dok-gap: 14px;
        }

        .dok-cards-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {
        .dok-editorial {
            --dok-side-w: 160px;
            --dok-side-h: 210px;
            --dok-center-w: 275px;
            --dok-center-h: 355px;
            --dok-gap: 12px;
            padding: 58px 0 64px;
        }

        .dok-subbar,
        .dok-filter-drawer,
        .dok-cards-grid {
            padding: 0 24px;
        }

        .dok-subbar {
            margin: 14px auto 22px;
        }

        .dok-cards-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .dok-editorial {
            --dok-side-w: 124px;
            --dok-side-h: 168px;
            --dok-center-w: 216px;
            --dok-center-h: 286px;
            --dok-gap: 10px;
            padding: 48px 0 56px;
        }

        .dok-editorial__display {
            font-size: clamp(32px, 9.2vw, 52px);
        }

        .dok-subbar {
            margin: 12px auto 18px;
            padding: 0 18px;
            align-items: center;
        }

        .dok-filter-drawer {
            margin: -120px auto 125px;
            padding: 0 18px;
        }

        .dok-editorial.is-cards-mode .dok-subbar {
            margin-bottom: 22px;
        }

        .dok-editorial.is-cards-mode .dok-filter-drawer {
            margin: -10px auto 20px;
        }

        .dok-subbar__title {
            font-size: 15px;
        }

        .dok-cards-grid {
            padding: 0 18px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px 12px;
        }
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
        .budaya-galeri {
            grid-template-columns: 1fr;
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
    }
</style>
@endsection

@section('breadcrumb')
<h2>Program {{ $pilar['title'] }}</h2>
@endsection

@section('pageGeneral')

<!-- ====== Hero Program (Komponen Reusable) ====== -->
@php
    /* fallback ke data default per program bila data hero belum diisi di admin */
    $heroLogo        = @$landing->logo_image ? asset($landing->logo_image) : asset($pilar['logo']);
    $heroTitle       = @$landing->title ?: $pilar['title'];
    $heroTagline     = @$landing->tagline ?: $pilar['tagline'];
    $heroDescription = @$landing->description ?: $pilar['description'];
    $heroBackground  = @$landing->background_image ? asset($landing->background_image) : asset($pilar['background']);
    $heroAccent      = $pilar['accent'] ?? '#eab308';
@endphp

<x-program-hero
    :background="$heroBackground"
    :logo="$heroLogo"
    :title="$heroTitle"
    :subtitle="$heroTagline"
    :description="$heroDescription"
    :accent="$heroAccent"
    scroll-target="#galeri"
/>

<!-- ====== Dokumentasi Kegiatan (Editorial Showcase) ====== -->
@php
    $currentCleanUrl = rtrim(url()->current(), '/');
    $dokItems = collect($dokumentasi)->map(function ($g) use ($currentCleanUrl) {
        $rawUrl = !empty($g['url']) ? trim($g['url']) : '';
        $cleanTarget = $rawUrl !== '' ? rtrim($rawUrl, '/') : '';
        $hasDistinctUrl = $cleanTarget !== '' && $cleanTarget !== $currentCleanUrl;

        return [
            'src'      => $g['src'] ?? '',
            'alt'      => $g['alt'] ?? ($g['caption'] ?? 'Dokumentasi Kegiatan'),
            'caption'  => $g['caption'] ?? 'Dokumentasi Kegiatan',
            'tag'      => $g['tag'] ?? 'Program',
            'url'      => $hasDistinctUrl ? $rawUrl : '',
        ];
    })->values()->all();

    $dokTags = collect($dokItems)->pluck('tag')->filter()->unique()->values()->all();
@endphp

<section class="dok-editorial" id="galeri" data-dok-items='@json($dokItems)'>
    <!-- Giant Two-Tone Editorial Display Heading -->
    <div class="dok-editorial__display-wrap">
        <h2 class="dok-editorial__display">
            <span class="dok-editorial__word-serif">Program</span><span class="dok-editorial__word-script">{{ $heroTitle }}</span>
        </h2>
    </div>

    <!-- Mode 1: Full-Bleed Center-Spotlight Carousel -->
    <div class="dok-carousel-viewport" id="dokCarouselViewport">
        <div class="dok-carousel-track" id="dokCarouselTrack"></div>
    </div>

    <!-- Mode 2: Editorial Cards Grid -->
    <div class="dok-cards-grid" id="dokCardsGrid" hidden>
        @foreach($dokItems as $idx => $g)
            @if($g['url'] !== '')
                <a class="dok-grid-card" href="{{ $g['url'] }}" data-dok-card-tag="{{ $g['tag'] }}" data-dok-card-title="{{ $g['caption'] }}">
            @else
                <div class="dok-grid-card" tabindex="0" role="button"
                     data-dok-lightbox-src="{{ $g['src'] }}"
                     data-dok-lightbox-title="{{ $g['caption'] }}"
                     data-dok-lightbox-tag="{{ $g['tag'] }}"
                     data-dok-card-tag="{{ $g['tag'] }}"
                     data-dok-card-title="{{ $g['caption'] }}">
            @endif
                <div class="dok-grid-card__media">
                    <img src="{{ $g['src'] }}" alt="{{ $g['alt'] }}" loading="lazy"/>
                    <div class="dok-item__overlay-text">
                        <span class="dok-item__tag">{{ $g['tag'] }}</span>
                        <span class="dok-item__caption">{{ $g['caption'] }}</span>
                    </div>
                    <div class="dok-item__hover-detail" aria-hidden="true">
                        <span class="dok-item__open-btn">
                            @if($g['url'] !== '')
                                <iconify-icon icon="proicons:open"></iconify-icon>
                            @else
                                <iconify-icon icon="material-symbols:open-in-full-rounded"></iconify-icon>
                            @endif
                        </span>
                        <span class="dok-item__open-label">Lihat Detail</span>
                    </div>
                </div>
            @if($g['url'] !== '')
                </a>
            @else
                </div>
            @endif
        @endforeach
    </div>

    <!-- Lightbox Modal for Photos without Separate Page URL -->
    <div class="dok-lightbox" id="dokLightbox" aria-hidden="true">
        <div class="dok-lightbox__dialog" role="dialog" aria-modal="true" aria-labelledby="dokLightboxTitle">
            <button type="button" class="dok-lightbox__close" id="dokLightboxClose">Tutup ✕</button>
            <img class="dok-lightbox__img" id="dokLightboxImg" src="" alt=""/>
            <div class="dok-lightbox__meta">
                <h4 class="dok-lightbox__title" id="dokLightboxTitle"></h4>
                <span class="dok-lightbox__tag" id="dokLightboxTag"></span>
            </div>
        </div>
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

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
(function () {
    var section = document.getElementById('galeri');
    if (!section || !window.gsap) return;

    var items = [];
    try { items = JSON.parse(section.getAttribute('data-dok-items') || '[]') || []; } catch (e) {}
    if (!items.length) return;

    var viewport = document.getElementById('dokCarouselViewport');
    var track = document.getElementById('dokCarouselTrack');
    var lightbox = document.getElementById('dokLightbox');
    var lightboxImg = document.getElementById('dokLightboxImg');
    var lightboxTitle = document.getElementById('dokLightboxTitle');
    var lightboxTag = document.getElementById('dokLightboxTag');
    var lightboxClose = document.getElementById('dokLightboxClose');

    var n = items.length;
    var copies = Math.max(7, Math.ceil(25 / n));
    if (copies % 2 === 0) copies += 1;

    var activeIndex = Math.floor(copies / 2) * n;
    var currentX = 0;
    var isHovered = false;
    var isDragging = false;
    var pointerDown = false;
    var startX = 0;
    var deltaX = 0;
    var clickedCard = null;
    var clickedOpenBtn = null;
    var autoCall = null;

    var esc = function (s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    };

    var metrics = function () {
        var cs = getComputedStyle(section);
        return {
            sideW: parseFloat(cs.getPropertyValue('--dok-side-w')) || 215,
            sideH: parseFloat(cs.getPropertyValue('--dok-side-h')) || 275,
            centerW: parseFloat(cs.getPropertyValue('--dok-center-w')) || 370,
            centerH: parseFloat(cs.getPropertyValue('--dok-center-h')) || 470,
            gap: parseFloat(cs.getPropertyValue('--dok-gap')) || 16,
            viewW: viewport.clientWidth || window.innerWidth
        };
    };

    var targetX = function (idx) {
        var m = metrics();
        return (m.viewW / 2) - (idx * (m.sideW + m.gap) + m.centerW / 2);
    };

    /* Render track items */
    var html = '';
    for (var i = 0; i < copies * n; i++) {
        var it = items[i % n];
        var icon = it.url ? 'proicons:open' : 'material-symbols:open-in-full-rounded';
        html += '<div class="dok-item" data-dok-idx="' + i + '" role="button" tabindex="0">'
            + '<div class="dok-item__media">'
            + '<img src="' + esc(it.src) + '" alt="' + esc(it.alt) + '" draggable="false"/>'
            + '<div class="dok-item__overlay-text">'
            + '<span class="dok-item__tag">' + esc(it.tag) + '</span>'
            + '<span class="dok-item__caption">' + esc(it.caption) + '</span>'
            + '</div>'
            + '<div class="dok-item__hover-detail" aria-hidden="true">'
            + '<span class="dok-item__open-btn" data-dok-open-detail="1" title="Buka Detail"><iconify-icon icon="' + icon + '"></iconify-icon></span>'
            + '<span class="dok-item__open-label">Buka Detail</span>'
            + '</div>'
            + '</div></div>';
    }
    track.innerHTML = html;

    function goTo(newIdx, instant) {
        var nodes = track.children;
        activeIndex = Math.max(0, Math.min(nodes.length - 1, newIdx));
        currentX = targetX(activeIndex);
        var m = metrics();
        var dur = instant ? 0 : 0.7;

        gsap.killTweensOf(track);
        gsap.to(track, {
            x: currentX,
            duration: dur,
            ease: 'power3.out',
            onComplete: function () {
                var minSafe = 2 * n;
                var maxSafe = (copies - 2) * n - 1;
                if (!instant && (activeIndex < minSafe || activeIndex > maxSafe)) {
                    var mid = Math.floor(copies / 2) * n + (((activeIndex % n) + n) % n);
                    goTo(mid, true);
                }
            }
        });

        for (var i = 0; i < nodes.length; i++) {
            var isC = i === activeIndex;
            nodes[i].classList.toggle('is-center', isC);
            gsap.to(nodes[i].firstElementChild, {
                width: isC ? m.centerW : m.sideW,
                height: isC ? m.centerH : m.sideH,
                duration: dur,
                ease: 'power3.out',
                overwrite: 'auto'
            });
        }
    }

    function openItem(idx) {
        var it = items[((idx % n) + n) % n];
        if (!it) return;
        if (it.url) { window.location.href = it.url; return; }
        lightboxImg.src = it.src || '';
        lightboxTitle.textContent = it.caption || '';
        lightboxTag.textContent = it.tag || '';
        lightbox.classList.add('is-open');
    }

    function scheduleAuto() {
        if (autoCall) autoCall.kill();
        autoCall = gsap.delayedCall(3.2, function () {
            if (!document.hidden && !isHovered && !pointerDown && !lightbox.classList.contains('is-open')) {
                goTo(activeIndex + 1, false);
            }
            scheduleAuto();
        });
    }

    /* Drag & Click */
    track.addEventListener('pointerdown', function (e) {
        if (e.pointerType === 'mouse' && e.button !== 0) return;
        pointerDown = true; isDragging = false; startX = e.clientX; deltaX = 0;
        clickedCard = e.target.closest('.dok-item');
        clickedOpenBtn = e.target.closest('[data-dok-open-detail]');
    });

    window.addEventListener('pointermove', function (e) {
        if (!pointerDown) return;
        deltaX = e.clientX - startX;
        if (!isDragging && Math.abs(deltaX) > 8) {
            isDragging = true;
            track.classList.add('is-dragging');
            gsap.killTweensOf(track);
        }
        if (isDragging) gsap.set(track, { x: currentX + deltaX });
    });

    window.addEventListener('pointerup', function () {
        if (!pointerDown) return;
        pointerDown = false;
        if (isDragging) {
            track.classList.remove('is-dragging');
            var m = metrics();
            var steps = Math.abs(deltaX) > 36 ? Math.round(-deltaX / (m.sideW + m.gap)) || (deltaX < 0 ? 1 : -1) : 0;
            goTo(activeIndex + steps, false);
            isDragging = false;
        } else if (clickedCard) {
            var idx = parseInt(clickedCard.getAttribute('data-dok-idx'), 10);
            if (idx === activeIndex || clickedOpenBtn) openItem(idx);
            else goTo(idx, false);
        }
        clickedCard = clickedOpenBtn = null;
    });

    /* Hover Pause hanya di atas foto */
    track.addEventListener('mouseover', function (e) { if (e.target.closest('.dok-item__media')) isHovered = true; });
    track.addEventListener('mouseout', function (e) {
        if (!e.relatedTarget || !e.relatedTarget.closest || !e.relatedTarget.closest('.dok-item__media')) isHovered = false;
    });

    /* Lightbox & Resize */
    if (lightboxClose) lightboxClose.addEventListener('click', function () { lightbox.classList.remove('is-open'); });
    if (lightbox) lightbox.addEventListener('click', function (e) { if (e.target === lightbox) lightbox.classList.remove('is-open'); });
    window.addEventListener('resize', function () { goTo(activeIndex, true); });

    goTo(activeIndex, true);
    scheduleAuto();
})();
</script>
@endpush
