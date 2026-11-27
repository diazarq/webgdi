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

    /* ================= Section umum & Hero Stacked Card ================= */
    .program-hero {
        position: relative;
        z-index: 1;
        transform-origin: center top;
        will-change: transform, opacity;
    }

    .budaya-section {
        position: relative;
        z-index: 10;
        padding: 80px 0;
        background: #ffffff;
    }

    .budaya-section--alt {
        background: #f6fbf8;
    }

    .site-footer {
        position: relative;
        z-index: 10;
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
        z-index: 10;
        background: white;
        padding: 76px 0 84px;
        border-radius: 28px 28px 0 0;
        box-shadow: 0 -24px 60px rgba(4, 35, 26, 0.25);
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

    /* ================= Statistik (Modern Architectural Impact Cards) ================= */
    .stat-showcase {
        position: relative;
        padding: 88px 0 92px;
        background: linear-gradient(180deg, #ffffff 0%, #f4f9f6 52%, #ffffff 100%);
        overflow: hidden;
    }

    .stat-showcase__container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .stat-showcase__header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 28px;
        margin-bottom: 44px;
    }

    .stat-showcase__header-left {
        max-width: 560px;
    }

    .stat-showcase__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Manrope', sans-serif;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #0d7a4e;
        margin-bottom: 10px;
    }

    .stat-showcase__eyebrow-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #fd7f4b;
        display: inline-block;
    }

    .stat-showcase__title {
        margin: 0;
        font-family: 'Manrope', sans-serif;
        font-size: clamp(28px, 3.2vw, 38px);
        font-weight: 800;
        line-height: 1.18;
        letter-spacing: -0.025em;
        color: #0e2c1f;
    }

    .stat-showcase__subtitle {
        margin: 0;
        max-width: 400px;
        font-family: 'Manrope', sans-serif;
        font-size: 14.5px;
        line-height: 1.68;
        color: #5a6b63;
    }

    .stat-showcase__grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 22px;
    }

    .stat-card {
        position: relative;
        background: #ffffff;
        border: 1px solid rgba(14, 60, 41, 0.09);
        border-radius: 22px;
        padding: 30px 26px 28px;
        box-shadow:
            0 14px 36px -16px rgba(10, 48, 32, 0.09),
            0 2px 6px rgba(10, 48, 32, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition:
            transform 0.35s cubic-bezier(0.22, 1, 0.36, 1),
            box-shadow 0.35s cubic-bezier(0.22, 1, 0.36, 1),
            border-color 0.35s ease;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        border-color: rgba(13, 122, 78, 0.28);
        box-shadow:
            0 24px 48px -18px rgba(10, 58, 38, 0.16),
            0 4px 12px rgba(10, 58, 38, 0.05);
    }

    .stat-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 26px;
    }

    .stat-card__icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 15px;
        background: linear-gradient(135deg, rgba(13, 122, 78, 0.12) 0%, rgba(13, 122, 78, 0.04) 100%);
        border: 1px solid rgba(13, 122, 78, 0.15);
        color: #0d7a4e;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition:
            background 0.32s ease,
            color 0.32s ease,
            transform 0.32s cubic-bezier(0.22, 1, 0.36, 1),
            border-color 0.32s ease;
    }

    .stat-card:hover .stat-card__icon-wrap {
        background: linear-gradient(135deg, #0a5c3a 0%, #0d7a4e 100%);
        border-color: #0a5c3a;
        color: #ffffff;
        transform: scale(1.06);
    }

    .stat-card__icon-wrap svg {
        width: 25px;
        height: 25px;
        stroke: currentColor;
    }

    .stat-card__icon-wrap img {
        width: 26px;
        height: 26px;
        object-fit: contain;
    }

    .stat-card__index {
        font-family: 'Manrope', sans-serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.06em;
        color: #c2d1c9;
        font-variant-numeric: tabular-nums;
    }

    .stat-card__value {
        display: flex;
        align-items: baseline;
        gap: 2px;
        font-family: 'Manrope', sans-serif;
        font-size: clamp(34px, 3.4vw, 44px);
        font-weight: 800;
        line-height: 1.08;
        letter-spacing: -0.03em;
        color: #0b2b1e;
        font-variant-numeric: tabular-nums;
    }

    .stat-card__suffix {
        color: #fd7f4b;
        font-weight: 800;
    }

    .stat-card__infinity-svg {
        width: 48px;
        height: 26px;
        stroke: #0b2b1e;
        display: inline-block;
        vertical-align: middle;
    }

    .stat-card__infinity-svg path {
        stroke-dasharray: 180;
        stroke-dashoffset: 180;
        transition: stroke-dashoffset 1.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .stat-card.is-counted .stat-card__infinity-svg path {
        stroke-dashoffset: 0;
    }

    .stat-card__divider {
        position: relative;
        height: 1px;
        background: rgba(14, 60, 41, 0.08);
        margin: 18px 0 13px;
        overflow: hidden;
    }

    .stat-card__divider::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, #0d7a4e, #fd7f4b);
        transform: scaleX(0.24);
        transform-origin: left center;
        transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .stat-card:hover .stat-card__divider::after {
        transform: scaleX(1);
    }

    .stat-card__label {
        display: block;
        font-family: 'Manrope', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #4f6259;
        line-height: 1.45;
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
        .stat-showcase {
            padding: 68px 0 72px;
        }

        .stat-showcase__header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 32px;
        }

        .stat-showcase__subtitle {
            max-width: 540px;
        }

        .stat-showcase__grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .budaya-manfaat {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575px) {
        .stat-showcase__container {
            padding: 0 18px;
        }

        .stat-showcase__grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .stat-card {
            padding: 24px 22px;
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
@php
    $statSvgMap = [
        'hand-heart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><path d="M11 14h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 16"/><path d="m7 20 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 15 6 6"/><path d="M19.5 8.5c.7-.7 1.5-1.6 1.5-2.7A2.73 2.73 0 0 0 16 4a2.78 2.78 0 0 0-5 1.8c0 1.2.8 2 1.5 2.8L16 12Z"/></svg>',
        'mosque'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3c-2.8 2.2-5 4.6-5 7.5h10C17 7.6 14.8 5.2 12 3Z"/><path d="M12 2v1"/><path d="M5 10.5h14v9.5H5z"/><path d="M10 20v-4a2 2 0 0 1 4 0v4"/><path d="M3 20h18"/><path d="M3 13.5v6.5"/><path d="M21 13.5v6.5"/><path d="M3 11.5v.01"/><path d="M21 11.5v.01"/></svg>',
        'gift'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13"/><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/></svg>',
        'sprout'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>',
        'heart'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>',
        'book'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
        'coins'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18"/><path d="M7 6h1v4"/><path d="m16.71 13.88.7.71-2.82 2.82"/></svg>',
        'users'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'sparkles'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>',
        'infinity'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12c-2-2.67-4-4-6-4a4 4 0 1 0 0 8c2 0 4-1.33 6-4Zm0 0c2 2.67 4 4 6 4a4 4 0 0 0 0-8c-2 0-4 1.33-6 4Z"/></svg>',
    ];

    $emojiToKey = [
        '🤲' => 'hand-heart',
        '🙏' => 'hand-heart',
        '🕌' => 'mosque',
        '🕋' => 'mosque',
        '🏫' => 'mosque',
        '🎁' => 'gift',
        '🌱' => 'sprout',
        '❤️' => 'heart',
        '❤'  => 'heart',
        '💚' => 'heart',
        '📚' => 'book',
        '💰' => 'coins',
        '🤝' => 'users',
        '✨' => 'sparkles',
        '⭐' => 'sparkles',
        '∞'  => 'infinity',
    ];
@endphp
<section class="stat-showcase" id="statistik">
    <div class="stat-showcase__container">
        <div class="stat-showcase__header">
            <div class="stat-showcase__header-left">
                <span class="stat-showcase__eyebrow">
                    <span class="stat-showcase__eyebrow-dot" aria-hidden="true"></span>
                    Dampak &amp; Capaian
                </span>
                <h2 class="stat-showcase__title">Statistik Program {{ $pilar['title'] }}</h2>
            </div>
            <p class="stat-showcase__subtitle">
                Jejak kebermanfaatan yang dikelola secara amanah dan berkelanjutan bersama para wakif serta donatur.
            </p>
        </div>

        <div class="stat-showcase__grid">
            @foreach($statistik as $idx => $stat)
                @php
                    $iconVal     = trim($stat->icon ?? '');
                    $isImageIcon = $iconVal !== '' && strpos($iconVal, '/') !== false;
                    $isHtmlIcon  = strpos($iconVal, '<') !== false;

                    $resolvedKey = $emojiToKey[$iconVal] ?? null;
                    if (!$resolvedKey) {
                        $lblLower = strtolower($stat->label_judul ?? '');
                        if (strpos($lblLower, 'wakif') !== false || strpos($lblLower, 'donatur') !== false) {
                            $resolvedKey = 'hand-heart';
                        } elseif (strpos($lblLower, 'program') !== false || strpos($lblLower, 'masjid') !== false) {
                            $resolvedKey = 'mosque';
                        } elseif (strpos($lblLower, 'salur') !== false || strpos($lblLower, 'paket') !== false || strpos($lblLower, 'sembako') !== false) {
                            $resolvedKey = 'gift';
                        } elseif (strpos($lblLower, 'pahala') !== false || strpos($lblLower, 'lanjut') !== false) {
                            $resolvedKey = 'sprout';
                        } elseif (strpos($lblLower, 'yatim') !== false || strpos($lblLower, 'penerima') !== false) {
                            $resolvedKey = 'users';
                        } elseif (strpos($lblLower, 'beasiswa') !== false || strpos($lblLower, 'pendidikan') !== false) {
                            $resolvedKey = 'book';
                        } else {
                            $fallbackOrder = ['hand-heart', 'mosque', 'gift', 'sprout'];
                            $resolvedKey = $fallbackOrder[$idx % count($fallbackOrder)];
                        }
                    }

                    $rawValue = trim((string) $stat->angka_nilai);
                    $hasNumber = preg_match('/^([^\d]*?)([\d.,]+)(.*)$/u', $rawValue, $numParts) === 1;
                    $prefix = $hasNumber ? $numParts[1] : '';
                    $digitsOnly = $hasNumber ? preg_replace('/[^\d]/', '', $numParts[2]) : '';
                    $useDotSep = $hasNumber && strpos($numParts[2], '.') !== false;
                    $suffix = $hasNumber ? $numParts[3] : '';
                    $targetInt = $digitsOnly !== '' ? (int) $digitsOnly : 0;
                    $isInfinity = !$hasNumber && ($rawValue === '∞' || stripos($rawValue, 'tak terhingga') !== false);
                @endphp
                <div class="stat-card" data-stat-card>
                    <div class="stat-card__top">
                        <span class="stat-card__icon-wrap" aria-hidden="true">
                            @if($isImageIcon)
                                <img src="{{ asset($iconVal) }}" alt="{{ $stat->label_judul }}"/>
                            @elseif($isHtmlIcon)
                                {!! $iconVal !!}
                            @else
                                {!! $statSvgMap[$resolvedKey] !!}
                            @endif
                        </span>
                        <span class="stat-card__index">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div>
                        <div class="stat-card__value" aria-label="{{ $rawValue }}">
                            @if($hasNumber && $targetInt > 0)
                                @if($prefix !== '')<span>{{ $prefix }}</span>@endif<span
                                    data-stat-counter="{{ $targetInt }}"
                                    data-stat-sep="{{ $useDotSep ? 'dot' : 'none' }}">1</span>@if($suffix !== '')<span class="stat-card__suffix">{{ $suffix }}</span>@endif
                            @elseif($isInfinity)
                                <svg class="stat-card__infinity-svg" viewBox="0 0 48 24" fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M24 12c-4.2-5.5-8.2-8-12.5-8a8 8 0 1 0 0 16c4.3 0 8.3-2.5 12.5-8Zm0 0c4.2 5.5 8.2 8 12.5 8a8 8 0 0 0 0-16c-4.3 0-8.3 2.5-12.5 8Z"/>
                                </svg>
                            @else
                                <span>{{ $rawValue }}</span>
                            @endif
                        </div>
                        <div class="stat-card__divider" aria-hidden="true"></div>
                        <span class="stat-card__label">{{ $stat->label_judul }}</span>
                    </div>
                </div>
            @endforeach
        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/lenis@1.1.18/dist/lenis.min.js"></script>
<script>
(function () {
    /* ===== Stacked Card Scroll Animation + Smooth Inertia ("Mahal") ===== */
    var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var heroEl = document.querySelector('[data-program-hero]');
    var galeriEl = document.getElementById('galeri');

    if (!prefersReduced && window.gsap && window.ScrollTrigger) {
        gsap.registerPlugin(ScrollTrigger);

        if (window.Lenis) {
            document.documentElement.style.scrollBehavior = 'auto';
            var lenis = new Lenis({
                duration: 1.45,
                easing: function (t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); },
                smoothWheel: true,
                wheelMultiplier: 0.85
            });
            lenis.on('scroll', ScrollTrigger.update);
            gsap.ticker.add(function (time) {
                lenis.raf(time * 1000);
            });
            gsap.ticker.lagSmoothing(0);
        }

        if (heroEl && galeriEl) {
            ScrollTrigger.create({
                trigger: heroEl,
                start: 'top top',
                end: function () {
                    return '+=' + galeriEl.offsetHeight;
                },
                pin: true,
                pinSpacing: false,
                invalidateOnRefresh: true
            });

            gsap.to(heroEl, {
                scale: 0.93,
                opacity: 0.45,
                ease: 'none',
                scrollTrigger: {
                    trigger: galeriEl,
                    start: 'top bottom',
                    end: 'top top',
                    scrub: 1.4,
                    invalidateOnRefresh: true
                }
            });

            window.addEventListener('load', function () {
                ScrollTrigger.refresh();
            });
        }
    }
})();
</script>
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
            + '<span class="dok-item__open-btn" data-dok-open-detail="1" title="Lihat Detail"><iconify-icon icon="' + icon + '"></iconify-icon></span>'
            + '<span class="dok-item__open-label">Lihat Detail</span>'
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

/* ====== Animasi Angka Statistik (Berjalan dari 1 sampai target saat di-scroll) ====== */
(function () {
    var statSection = document.getElementById('statistik');
    if (!statSection) return;

    var cards = statSection.querySelectorAll('[data-stat-card]');
    var counters = statSection.querySelectorAll('[data-stat-counter]');
    var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var hasAnimated = false;

    function formatNumber(num, sepMode) {
        var n = Math.round(num);
        if (sepMode === 'dot') {
            return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
        return String(n);
    }

    function runCounters() {
        if (hasAnimated) return;
        hasAnimated = true;

        cards.forEach(function (card, idx) {
            setTimeout(function () {
                card.classList.add('is-counted');
            }, idx * 110);
        });

        if (!prefersReduced && window.gsap) {
            gsap.fromTo(cards,
                { opacity: 0, y: 24 },
                { opacity: 1, y: 0, duration: 0.7, stagger: 0.1, ease: 'power3.out', clearProps: 'transform' }
            );
        }

        counters.forEach(function (el) {
            var target = parseInt(el.getAttribute('data-stat-counter'), 10) || 0;
            var sepMode = el.getAttribute('data-stat-sep') || 'none';

            if (prefersReduced || target <= 1) {
                el.textContent = formatNumber(target, sepMode);
                return;
            }

            var startVal = 1;
            var durationMs = target >= 500 ? 1850 : (target >= 50 ? 1500 : 1100);
            var startTime = null;

            el.textContent = formatNumber(startVal, sepMode);

            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                var progress = Math.min((timestamp - startTime) / durationMs, 1);
                /* Easing easeOutExpo agar cepat di awal dan mulus melambat menjelang angka akhir */
                var eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                var current = startVal + (target - startVal) * eased;

                el.textContent = formatNumber(current, sepMode);

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    el.textContent = formatNumber(target, sepMode);
                }
            }

            window.requestAnimationFrame(step);
        });
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    runCounters();
                    io.disconnect();
                }
            });
        }, { threshold: 0.25 });
        io.observe(statSection);
    } else {
        runCounters();
    }
})();
</script>
@endpush
