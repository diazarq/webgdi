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
