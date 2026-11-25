@extends('layout.layout-page', ['active' => [], 'hidePageHeader' => true, 'minimalFooter' => true])

@section('title', $pageTitle)

@section('style')
<style>
    /* Navbar hijau solid mengikuti tema */
    .main-header-two {
        position: relative;
        background: linear-gradient(135deg, #04231a 0%, #06301f 50%, #0a4a2e 100%);
    }

    /* ================= Hero (gaya cerah ala landing kampanye) ================= */
    .wakaf-hero {
        position: relative;
        z-index: 1;
        overflow: hidden;
        padding: 80px 0 90px;
        background-color: #faf8f1;
        color: #1f2a24;
    }

    .wakaf-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(0, 135, 90, 0.10) 1.2px, transparent 1.2px);
        background-size: 26px 26px;
        pointer-events: none;
        z-index: 0;
    }

    .wakaf-hero__inner {
        position: relative;
        z-index: 2;
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 40px;
        display: flex;
        align-items: center;
        gap: 48px;
    }

    .wakaf-hero__content {
        flex: 1 1 54%;
        min-width: 0;
    }

    .wakaf-hero__visual {
        flex: 1 1 46%;
        position: relative;
        display: flex;
        justify-content: center;
        padding: 30px 0 10px;
    }

    /* Brand hijau ala tulisan tangan + kilau */
    .wakaf-hero__brand {
        position: relative;
        display: inline-block;
        transform: rotate(-2deg);
        font-size: clamp(38px, 4.2vw, 54px);
        font-weight: 800;
        font-style: italic;
        line-height: 1.05;
        letter-spacing: 0.01em;
        color: #1a8b4c;
        text-shadow: 2px 2px 0 rgba(45, 212, 167, 0.25);
        margin-bottom: 18px;
    }

    .wakaf-hero__brand-sparkle {
        position: absolute;
        top: -16px;
        right: -30px;
        font-size: 0.5em;
        font-style: normal;
        transform: rotate(12deg);
    }

    /* Pill tagline hijau muda (italic) */
    .wakaf-hero__tagline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: 12px;
        background: #eef5ea;
        border: 1px solid #dcead8;
        color: #2f7d3b;
        font-size: 17px;
        font-weight: 700;
        font-style: italic;
        margin-bottom: 20px;
    }

    /* Judul besar: baris kedua hijau dengan garis bergelombang */
    .wakaf-hero__title {
        font-size: clamp(38px, 4.8vw, 60px);
        font-weight: 800;
        line-height: 1.12;
        color: #20242b;
        margin-bottom: 22px;
    }

    .wakaf-hero__title-accent {
        position: relative;
        display: inline-block;
        color: #1a8b4c;
    }

    .wakaf-hero__squiggle {
        position: absolute;
        left: 0;
        bottom: -14px;
        width: 100%;
        height: 12px;
    }

    .wakaf-hero__desc {
        font-size: 17.5px;
        line-height: 1.8;
        color: #46534c;
        max-width: 520px;
        margin-bottom: 26px;
    }

    /* Chip pill ber-emoji */
    .wakaf-hero__chips {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        max-width: 520px;
    }

    .wakaf-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #e3e9e5;
        box-shadow: 0 3px 10px rgba(20, 58, 44, 0.07);
        font-size: 14.5px;
        font-weight: 600;
        color: #26332c;
    }

    .wakaf-hero__cta {
        margin-top: 30px;
    }

    /* ===== Visual kanan: maskot + starburst + balon chat ===== */
    .wakaf-hero__mascot {
        position: relative;
        width: min(400px, 100%);
        text-align: center;
    }

    .wakaf-hero__burst {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 105%;
        height: auto;
        transform: translate(-50%, -52%);
        animation: wakafSpin 26s linear infinite;
    }

    @keyframes wakafSpin {
        from { transform: translate(-50%, -52%) rotate(0deg); }
        to   { transform: translate(-50%, -52%) rotate(360deg); }
    }

    .wakaf-hero__mascot-img {
        position: relative;
        z-index: 1;
        width: 100%;
        display: block;
        filter: drop-shadow(0 22px 26px rgba(20, 58, 44, 0.22));
        animation: wakafFloat 3.8s ease-in-out infinite alternate;
    }

    @keyframes wakafFloat {
        from { transform: translateY(0); }
        to   { transform: translateY(-12px); }
    }

    @media (prefers-reduced-motion: reduce) {
        .wakaf-hero__burst,
        .wakaf-hero__mascot-img {
            animation: none;
        }
    }

    .wakaf-hero__mascot-shadow {
        width: 62%;
        height: 26px;
        margin: 10px auto 0;
        border-radius: 50%;
        background: radial-gradient(50% 50% at 50% 50%, rgba(20, 58, 44, 0.20), transparent 70%);
    }

    .wakaf-hero__bubble {
        position: absolute;
        top: -18px;
        right: -16px;
        z-index: 2;
        max-width: 210px;
        padding: 14px 18px;
        border-radius: 16px;
        background: #14532d;
        color: #ffffff;
        font-size: 14.5px;
        font-weight: 700;
        line-height: 1.55;
        text-align: left;
        box-shadow: 0 16px 30px rgba(20, 58, 44, 0.28);
    }

    .wakaf-hero__bubble::after {
        content: "";
        position: absolute;
        left: 26px;
        bottom: -10px;
        width: 22px;
        height: 12px;
        background: #14532d;
        clip-path: polygon(0 0, 100% 0, 22% 100%);
    }

    .wakaf-hero__sparkle {
        position: absolute;
        z-index: 2;
        font-size: 26px;
        pointer-events: none;
    }

    .wakaf-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 17px 38px;
        border-radius: 999px;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none !important;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .wakaf-btn svg {
        width: 20px;
        height: 20px;
        transition: transform 0.25s ease;
    }

    .wakaf-btn--primary {
        background: linear-gradient(90deg, #ff8a3d, #ff6600);
        color: #ffffff !important;
        box-shadow: 0 14px 34px rgba(255, 102, 0, 0.35);
    }

    .wakaf-btn--primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 44px rgba(255, 102, 0, 0.45);
        color: #ffffff !important;
    }

    .wakaf-btn--primary:hover svg {
        transform: translateX(4px);
    }

    .wakaf-btn--green {
        background: linear-gradient(135deg, #0f7a3d, #1a8b4c);
        color: #ffffff !important;
        box-shadow: 0 14px 34px rgba(15, 122, 61, 0.30);
    }

    .wakaf-btn--green:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 44px rgba(15, 122, 61, 0.40);
        color: #ffffff !important;
    }

    .wakaf-btn--green:hover svg {
        transform: translateX(4px);
    }

    .wakaf-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 17px 38px;
        border-radius: 999px;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none !important;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .wakaf-btn svg {
        width: 20px;
        height: 20px;
        transition: transform 0.25s ease;
    }

    .wakaf-btn--primary {
        background: linear-gradient(90deg, #ff8a3d, #ff6600);
        color: #ffffff !important;
        box-shadow: 0 14px 34px rgba(255, 102, 0, 0.35);
    }

    .wakaf-btn--primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 44px rgba(255, 102, 0, 0.45);
        color: #ffffff !important;
    }

    .wakaf-btn--primary:hover svg {
        transform: translateX(4px);
    }

    /* ================= Terima kasih (badge + tanggal) ================= */
    .wakaf-thanks {
        position: relative;
        z-index: 1;
        overflow: hidden;
        padding: 70px 0 80px;
        text-align: center;
        background-color: #356e20;
        color: #ffffff;
    }

    .wakaf-thanks::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.09) 1.2px, transparent 1.2px);
        background-size: 26px 26px;
        pointer-events: none;
    }

    .wakaf-thanks__inner {
        position: relative;
        z-index: 1;
        max-width: 760px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .wakaf-thanks__badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 22px;
        border-radius: 999px;
        background: #7c2d12;
        color: #ffffff;
        font-size: 12.5px;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.22);
        margin-bottom: 22px;
    }

    .wakaf-thanks__title {
        font-size: clamp(30px, 4vw, 46px);
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
        margin-bottom: 30px;
    }

    .wakaf-thanks__title-accent {
        position: relative;
        display: inline-block;
        color: #a3e635;
    }

    .wakaf-thanks__squiggle {
        position: absolute;
        left: 0;
        bottom: -12px;
        width: 100%;
        height: 10px;
    }

    .wakaf-thanks__date {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 13px 28px;
        border-radius: 999px;
        background: #ffffff;
        color: #1f5c14;
        font-size: 17px;
        font-weight: 800;
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.25);
    }

    /* ================= Tentang program ================= */
    .wakaf-about {
        position: relative;
        z-index: 1;
        padding: 80px 0 90px;
        text-align: center;
        background-color: #f7f6f1;
        color: #1f2a24;
    }

    .wakaf-about::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(0, 135, 90, 0.07) 1.2px, transparent 1.2px);
        background-size: 26px 26px;
        pointer-events: none;
    }

    .wakaf-about__inner {
        position: relative;
        z-index: 1;
        max-width: 1080px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .wakaf-about__tagline {
        display: block;
        color: #2f7d3b;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .wakaf-about__title {
        font-size: clamp(30px, 4vw, 44px);
        font-weight: 800;
        color: #20242b;
        margin-bottom: 18px;
    }

    .wakaf-about__desc {
        font-size: 16.5px;
        line-height: 1.85;
        color: #46534c;
        max-width: 620px;
        margin: 0 auto 44px;
    }

    .wakaf-about__grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
    }

    .wakaf-stat {
        background: #ffffff;
        border-radius: 16px;
        padding: 30px 18px 26px;
        box-shadow: 0 10px 26px rgba(20, 58, 44, 0.10);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .wakaf-stat:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 44px rgba(26, 139, 76, 0.18);
    }

    .wakaf-stat__emoji {
        display: block;
        font-size: 36px;
        line-height: 1;
        margin-bottom: 14px;
    }

    .wakaf-stat__emoji img {
        height: 40px;
        width: auto;
    }

    .wakaf-stat__value {
        display: block;
        font-size: 30px;
        font-weight: 800;
        color: #1a8b4c;
        line-height: 1.2;
        margin-bottom: 8px;
    }

    .wakaf-stat__label {
        display: block;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #5b6b66;
    }

    /* ================= Kotak Tujuan / Sasaran / Asnaf ================= */
    .wakaf-about__pillars {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
        margin-top: 26px;
    }

    .wakaf-pillar {
        background: #ffffff;
        border: 1px solid #e3ede6;
        border-top: 4px solid #1a8b4c;
        border-radius: 16px;
        padding: 30px 26px 28px;
        box-shadow: 0 10px 26px rgba(20, 58, 44, 0.10);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .wakaf-pillar:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 44px rgba(26, 139, 76, 0.18);
    }

    .wakaf-pillar__emoji {
        display: block;
        font-size: 36px;
        line-height: 1;
        margin-bottom: 14px;
    }

    .wakaf-pillar__title {
        font-size: 20px;
        font-weight: 800;
        color: #1a8b4c;
        margin-bottom: 10px;
    }

    .wakaf-pillar__desc {
        font-size: 14.5px;
        line-height: 1.75;
        color: #5b6b66;
        margin-bottom: 0;
    }

    /* ================= Section umum ================= */
    .wakaf-section {
        padding: 80px 0;
    }

    .wakaf-section--alt {
        background: #f6fbf8;
    }

    .wakaf-section__head {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 46px;
    }

    .wakaf-section__tagline {
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

    .wakaf-section__title {
        font-size: 30px;
        font-weight: 800;
        color: #143a2c;
        line-height: 1.35;
    }

    .wakaf-section__title::after {
        content: "";
        display: block;
        width: 68px;
        height: 4px;
        border-radius: 999px;
        margin: 16px auto 0;
        background: linear-gradient(90deg, #ff8a3d, #1a8b4c);
    }

    /* ================= Manfaat ================= */
    .wakaf-manfaat {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 15px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
    }

    .wakaf-manfaat-card {
        background: #ffffff;
        border: 1px solid #e5eef0;
        border-radius: 18px;
        padding: 32px 28px;
        box-shadow: 0 8px 24px rgba(20, 58, 44, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .wakaf-manfaat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 44px rgba(26, 139, 76, 0.16);
        border-color: #bfe8d4;
    }

    .wakaf-manfaat-card__icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        color: #1a8b4c;
        background: linear-gradient(135deg, rgba(45, 212, 167, 0.16), rgba(26, 139, 76, 0.12));
        border: 1px solid rgba(26, 139, 76, 0.18);
        margin-bottom: 18px;
    }

    .wakaf-manfaat-card__icon svg {
        width: 26px;
        height: 26px;
    }

    .wakaf-manfaat-card__title {
        font-size: 19px;
        font-weight: 700;
        color: #143a2c;
        margin-bottom: 10px;
    }

    .wakaf-manfaat-card__desc {
        font-size: 14.5px;
        color: #5b6b66;
        line-height: 1.75;
        margin-bottom: 0;
    }

    /* ================= Galeri ================= */
    .wakaf-galeri {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 15px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }

    .wakaf-galeri__item {
        position: relative;
        display: flex;
        flex-direction: column;
        background: #ffffff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(20, 58, 44, 0.12);
    }

    .wakaf-galeri__media {
        position: relative;
    }

    .wakaf-galeri__media img {
        width: 100%;
        height: 240px;
        object-fit: cover;
        display: block;
    }

    .wakaf-galeri__media::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(6, 48, 31, 0.55), transparent 55%);
        pointer-events: none;
    }

    .wakaf-galeri__judul {
        position: absolute;
        left: 18px;
        right: 18px;
        bottom: 14px;
        z-index: 1;
        color: #ffffff;
        font-weight: 700;
        font-size: 15px;
        line-height: 1.35;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }

    .wakaf-galeri__caption {
        margin: 0;
        padding: 13px 18px 16px;
        color: #5b6b66;
        font-size: 13.5px;
        font-weight: 400;
        line-height: 1.6;
    }

    /* ================= CTA bawah ================= */
    .wakaf-cta {
        max-width: 1180px;
        margin: 0 auto;
        padding: 54px 40px;
        border-radius: 26px;
        text-align: center;
        color: #ffffff;
        background:
            radial-gradient(600px 300px at 15% 0%, rgba(45, 212, 167, 0.25), transparent 60%),
            radial-gradient(500px 260px at 90% 100%, rgba(255, 138, 61, 0.20), transparent 55%),
            linear-gradient(135deg, #04231a 0%, #06301f 45%, #0a4a2e 100%);
        box-shadow: 0 30px 70px rgba(4, 35, 26, 0.35);
    }

    .wakaf-cta h2 {
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .wakaf-cta p {
        font-size: 16.5px;
        color: rgba(255, 255, 255, 0.85);
        max-width: 560px;
        margin: 0 auto 28px;
    }

    /* ================= Responsive ================= */
    @media (max-width: 991px) {
        .wakaf-hero {
            padding: 60px 0 70px;
        }

        .wakaf-hero__inner {
            flex-direction: column;
            align-items: stretch;
            gap: 44px;
            padding: 0 20px;
        }

        .wakaf-hero__desc,
        .wakaf-hero__chips {
            max-width: none;
        }

        .wakaf-hero__bubble {
            right: 0;
        }

        .wakaf-about__grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .wakaf-about__pillars {
            grid-template-columns: 1fr;
        }

        .wakaf-manfaat,
        .wakaf-galeri {
            grid-template-columns: 1fr;
        }

        .wakaf-cta {
            margin: 0 20px;
            padding: 40px 24px;
        }
    }

    @media (max-width: 575px) {
        .wakaf-about__grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('breadcrumb')
<h2>Wakaf &amp; Hibah</h2>
@endsection

@section('pageGeneral')

<!-- ====== Hero Wakaf & Hibah ====== -->
@php
    /* data hero dari database (admin: Program > Hero Landing), fallback ke hardcode */
    $heroBadge       = @$landing->badge_text ?: 'Wakaf & Hibah';
    $heroTagline     = @$landing->tagline ?: 'Pahala Mengalir, Manfaat Berkelanjutan 🌱';
    $heroTitle       = @$landing->title ?: 'Salurkan Wakaf & Hibah';
    $heroDescription = @$landing->description ?: "Salurkan wakaf dan hibah terbaik Anda untuk menopang operasional serta\npengembangan program dakwah & sosial Graha Dhuafa Indonesia.\nPahalanya mengalir, manfaatnya berkelanjutan.";
@endphp
<section class="wakaf-hero">
    <div class="wakaf-hero__inner">
        <div class="wakaf-hero__content">
            <div class="wakaf-hero__brand">
                {{ $heroBadge }}
                <span class="wakaf-hero__brand-sparkle" aria-hidden="true">✨</span>
            </div>

            <span class="wakaf-hero__tagline">{{ $heroTagline }}</span>

            <h1 class="wakaf-hero__title">
                {{ $heroTitle }}
                <span class="wakaf-hero__title-accent">
                    Terbaik Anda
                    <svg class="wakaf-hero__squiggle" viewBox="0 0 220 14" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M3 9 Q 16 3 29 9 T 55 9 T 81 9 T 107 9 T 133 9 T 159 9 T 185 9 T 211 9"
                              fill="none" stroke="#2eaf5e" stroke-width="5" stroke-linecap="round"/>
                    </svg>
                </span>
            </h1>

            <p class="wakaf-hero__desc">
                {!! nl2br(e($heroDescription)) !!}
            </p>

            <div class="wakaf-hero__chips">
                <span class="wakaf-chip">📜 Pahala Berkelanjutan</span>
                <span class="wakaf-chip">🤝 Amanah &amp; Transparan</span>
                <span class="wakaf-chip">🕌 Menopang Dakwah</span>
                <span class="wakaf-chip">🏫 Mendukung Sosial</span>
            </div>

            <div class="wakaf-hero__cta">
                <a href="#manfaat" class="wakaf-btn wakaf-btn--green">
                    Pelajari Manfaatnya
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="wakaf-hero__visual">
            <div class="wakaf-hero__mascot">
                <span class="wakaf-hero__bubble">Hai kawan! Yuk salurkan wakaf &amp; hibah terbaikmu! 🤲✨</span>

                <svg class="wakaf-hero__burst" viewBox="0 0 120 120" aria-hidden="true">
                    <defs>
                        <linearGradient id="wakafBurstGrad" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" stop-color="#4cc47f"/>
                            <stop offset="1" stop-color="#1a8b4c"/>
                        </linearGradient>
                    </defs>
                    <polygon fill="url(#wakafBurstGrad)" points="118,60 98.6,70.4 110.2,89 88.3,88.3 89,110.2 70.4,98.6 60,118 49.6,98.6 31,110.2 31.7,88.3 9.8,89 21.4,70.4 2,60 21.4,49.6 9.8,31 31.7,31.7 31,9.8 49.6,21.4 60,2 70.4,21.4 89,9.8 88.3,31.7 110.2,31 98.6,49.6"/>
                </svg>

                <img class="wakaf-hero__mascot-img"
                     src="{{ asset('website/assets/images/custom/logo_gdi.png') }}"
                     alt="Logo Graha Dhuafa Indonesia"/>

                <div class="wakaf-hero__mascot-shadow" aria-hidden="true"></div>

                <span class="wakaf-hero__sparkle" style="top: 6%; left: -4%;" aria-hidden="true">✨</span>
                <span class="wakaf-hero__sparkle" style="bottom: 22%; right: -5%;" aria-hidden="true">✨</span>
            </div>
        </div>
    </div>
</section>

<!-- ====== Terima Kasih + Tanggal ====== -->
<section class="wakaf-thanks">
    <div class="wakaf-thanks__inner">
        <span class="wakaf-thanks__badge">🔒🔔 Pendaftaran Resmi Ditutup</span>

        <h2 class="wakaf-thanks__title">
            Terima Kasih atas Antusiasme yang
            <span class="wakaf-thanks__title-accent">
                Luar Biasa!
                <svg class="wakaf-thanks__squiggle" viewBox="0 0 220 14" preserveAspectRatio="none" aria-hidden="true">
                    <path d="M3 9 Q 16 3 29 9 T 55 9 T 81 9 T 107 9 T 133 9 T 159 9 T 185 9 T 211 9"
                          fill="none" stroke="#65a30d" stroke-width="5" stroke-linecap="round"/>
                </svg>
            </span>
        </h2>

        <span class="wakaf-thanks__date">📅 11 – 12 Juli 2026</span>
    </div>
</section>

<!-- ====== Tentang Program ====== -->
<section class="wakaf-about">
    <div class="wakaf-about__inner">
        <span class="wakaf-about__tagline">Tentang Program</span>

        <h2 class="wakaf-about__title">Apa itu Wakaf &amp; Hibah?</h2>

        <p class="wakaf-about__desc">
            <strong>Wakaf &amp; Hibah Graha Dhuafa Indonesia</strong> adalah program
            pendanaan untuk menopang operasional serta pengembangan program dakwah
            dan sosial. Setiap penyaluran dikelola secara amanah dan transparan,
            sehingga manfaatnya nyata dan pahalanya terus mengalir.
        </p>

        @php
            /* statistik dari database (admin: Program > Kelola Statistik Program), fallback ke hardcode */
            $statistikItems = @$statistik;
            if (!$statistikItems || $statistikItems->count() == 0) {
                $statistikItems = collect([
                    (object) ['icon' => '🤲', 'angka_nilai' => '1000+', 'label_judul' => 'Wakif & Donatur'],
                    (object) ['icon' => '🕌', 'angka_nilai' => '3+',    'label_judul' => 'Program Terbantu'],
                    (object) ['icon' => '🎁', 'angka_nilai' => '100+',  'label_judul' => 'Penyaluran Wakaf'],
                    (object) ['icon' => '🌱', 'angka_nilai' => '∞',     'label_judul' => 'Pahala Berkelanjutan'],
                ]);
            }
        @endphp
        <div class="wakaf-about__grid">
            @foreach($statistikItems as $stat)
                @php
                    $iconVal = trim($stat->icon ?? '');
                    $isImageIcon = $iconVal !== '' && strpos($iconVal, '/') !== false;
                    $isHtmlIcon  = strpos($iconVal, '<') !== false;
                @endphp
                <div class="wakaf-stat">
                    <span class="wakaf-stat__emoji" aria-hidden="true">
                        @if($isImageIcon)
                            <img src="{{ asset($iconVal) }}" alt="{{ $stat->label_judul }}"/>
                        @elseif($isHtmlIcon)
                            {!! $iconVal !!}
                        @else
                            {{ $iconVal }}
                        @endif
                    </span>
                    <span class="wakaf-stat__value">{{ $stat->angka_nilai }}</span>
                    <span class="wakaf-stat__label">{{ $stat->label_judul }}</span>
                </div>
            @endforeach
        </div>

        {{-- Tujuan / Sasaran / Asnaf: dikelola di admin (form Dokumentasi Program) --}}
        @php
            $tujuanText = @$dokumentasi->tujuan
                ?: 'Menopang operasional serta pengembangan program dakwah & sosial Graha Dhuafa Indonesia agar manfaatnya terus mengalir dan berkelanjutan.';
            $sasaranText = @$dokumentasi->sasaran
                ?: 'Masyarakat dhuafa, anak yatim, serta program dakwah & sosial yang membutuhkan pendanaan secara berkesinambungan.';
            $ashnafText = @$dokumentasi->ashnaf
                ?: 'Fakir, miskin, fisabilillah, dan kelompok berhak lain yang menerima manfaat penyaluran wakaf & hibah secara tepat sasaran.';
        @endphp
        <div class="wakaf-about__pillars">
            <div class="wakaf-pillar">
                <span class="wakaf-pillar__emoji" aria-hidden="true">🎯</span>
                <h3 class="wakaf-pillar__title">Tujuan</h3>
                <p class="wakaf-pillar__desc">{!! nl2br(e($tujuanText)) !!}</p>
            </div>

            <div class="wakaf-pillar">
                <span class="wakaf-pillar__emoji" aria-hidden="true">👥</span>
                <h3 class="wakaf-pillar__title">Sasaran</h3>
                <p class="wakaf-pillar__desc">{!! nl2br(e($sasaranText)) !!}</p>
            </div>

            <div class="wakaf-pillar">
                <span class="wakaf-pillar__emoji" aria-hidden="true">🤲</span>
                <h3 class="wakaf-pillar__title">Asnaf</h3>
                <p class="wakaf-pillar__desc">{!! nl2br(e($ashnafText)) !!}</p>
            </div>
        </div>
    </div>
</section>

{{-- ====== Manfaat Wakaf & Hibah ====== --}}
<section class="wakaf-section" id="manfaat">
    <div class="wakaf-section__head">
        <span class="wakaf-section__tagline">Manfaat</span>
        <h2 class="wakaf-section__title">Keutamaan Wakaf &amp; Hibah</h2>
    </div>

    <div class="wakaf-manfaat">
        @php
            $manfaatIcons = [
                '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
                '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
                '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
            ];
        @endphp
        @foreach($manfaat as $i => $m)
            <div class="wakaf-manfaat-card">
                <span class="wakaf-manfaat-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        {!! $manfaatIcons[$i % count($manfaatIcons)] !!}
                    </svg>
                </span>
                <h3 class="wakaf-manfaat-card__title">{{ $m['title'] }}</h3>
                <p class="wakaf-manfaat-card__desc">{{ $m['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ====== Galeri Penyaluran Wakaf & Hibah ====== --}}
<section class="wakaf-section wakaf-section--alt" id="galeri">
    <div class="wakaf-section__head">
        <span class="wakaf-section__tagline">Galeri</span>
        <h2 class="wakaf-section__title">Galeri Penyaluran Wakaf &amp; Hibah</h2>
    </div>

    <div class="wakaf-galeri">
        @foreach($galeri as $g)
            <div class="wakaf-galeri__item">
                <div class="wakaf-galeri__media">
                    <img src="{{ $g['src'] }}" alt="{{ $g['alt'] }}"/>
                    @if(!empty($g['judul']))
                        <span class="wakaf-galeri__judul">{{ $g['judul'] }}</span>
                    @endif
                </div>
                @if(!empty($g['caption']))
                    <p class="wakaf-galeri__caption">{{ $g['caption'] }}</p>
                @endif
            </div>
        @endforeach
    </div>
</section>

{{-- Timeline Jadwal Kegiatan + FAQ (partial sama dengan homepage) + section keistimewaan di bawah timeline
    (section harus dideklarasikan SEBELUM include agar terbaca oleh @yield di partial) --}}
@section('after_timeline')
    @include('website.partials.keistimewaan-wakaf')
    @include('website.partials.cta-wakaf')
@endsection
{{-- FAQ jadwal kegiatan: diambil dari admin (data kegiatan Wakaf & Hibah, lalu level program) --}}
@include('website.partials.timeline', ['timelineFaq' => !empty($faq) ? $faq : null])

@endsection
