@props([
    'background'   => '',
    'logo'         => '',
    'title'        => '',
    'subtitle'     => '',
    'description'  => '',
    'accent'       => '#eab308',
    'scrollTarget' => '#galeri',
])

@php
    $rawAccent = trim((string) ($accent ?: '#eab308'));
    $hex = ltrim($rawAccent, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    if (preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $cleanAccent = '#' . strtolower($hex);
        $accentRgb = "{$r}, {$g}, {$b}";
    } else {
        $cleanAccent = '#eab308';
        $accentRgb = '234, 179, 8';
    }
@endphp

@once
    @push('style')
        <link rel="stylesheet" href="{{ asset('website/assets/css/program-hero.css') }}?v=1.1.0" />
    @endpush
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
        <script src="{{ asset('website/assets/js/program-hero.js') }}?v=1.1.0"></script>
    @endpush
@endonce

<section class="program-hero"
         data-program-hero
         style="--accent: {{ $cleanAccent }}; --accent-rgb: {{ $accentRgb }};">

    {{-- Latar belakang: parallax mouse + scroll + slow Ken Burns zoom --}}
    <div class="program-hero__bg-stage" aria-hidden="true">
        <div class="program-hero__bg-parallax" data-ph-bg-parallax>
            <div class="program-hero__bg-photo"
                 style="background-image: url('{{ $background }}');"></div>
        </div>
        <div class="program-hero__overlay-shield"></div>
        <div class="program-hero__overlay-drift"></div>

        {{-- Partikel bokeh hangat & halus (hanya transform & opacity) --}}
        <div class="program-hero__bokeh">
            <span class="program-hero__particle program-hero__particle--1"></span>
            <span class="program-hero__particle program-hero__particle--2"></span>
            <span class="program-hero__particle program-hero__particle--3"></span>
            <span class="program-hero__particle program-hero__particle--4"></span>
            <span class="program-hero__particle program-hero__particle--5"></span>
            <span class="program-hero__particle program-hero__particle--6"></span>
            <span class="program-hero__particle program-hero__particle--7"></span>
            <span class="program-hero__particle program-hero__particle--8"></span>
        </div>
    </div>

    {{-- Konten utama: Desktop 2 kolom proporsional | Tablet & Mobile 1 kolom (logo atas, teks bawah) --}}
    <div class="program-hero__inner">
        <div class="program-hero__content">
            <h1 class="program-hero__title" data-ph-title aria-label="{{ $title }}">{{ $title }}</h1>

            @if(trim((string) $subtitle) !== '')
                <div class="program-hero__subtitle-row" data-ph-subtitle-wrap>
                    <span class="program-hero__accent-line" data-ph-line aria-hidden="true"></span>
                    <p class="program-hero__subtitle" data-ph-subtitle>{{ $subtitle }}</p>
                </div>
            @endif

            @if(trim((string) $description) !== '')
                <p class="program-hero__desc" data-ph-desc>{!! nl2br(e($description)) !!}</p>
            @endif
        </div>

        <div class="program-hero__visual" data-ph-visual>
            <div class="program-hero__stage">
                {{-- Glow hangat berlapis di belakang logo --}}
                <div class="program-hero__aura" aria-hidden="true"></div>

                {{-- Cincin orbit berperspektif 3D yang berputar pelan di belakang logo --}}
                <div class="program-hero__orbit-plane program-hero__orbit-plane--1" aria-hidden="true">
                    <div class="program-hero__ring program-hero__ring--outer">
                        <span class="program-hero__ring-node"></span>
                    </div>
                </div>
                <div class="program-hero__orbit-plane program-hero__orbit-plane--2" aria-hidden="true">
                    <div class="program-hero__ring program-hero__ring--inner"></div>
                </div>
                <div class="program-hero__ring-halo" aria-hidden="true"></div>

                {{-- Wrapper idle floating --}}
                <div class="program-hero__float">
                    {{-- Medali 3D besar dengan sudut perspektif ruang (menghadap serong ke arah teks) --}}
                    <div class="program-hero__tilt" data-ph-tilt>
                        <div class="program-hero__cast-shadow" aria-hidden="true"></div>
                        <div class="program-hero__extrude-back" aria-hidden="true"></div>
                        <div class="program-hero__rim-plate" aria-hidden="true"></div>
                        <div class="program-hero__disc" aria-hidden="true"></div>

                        @if(trim((string) $logo) !== '')
                            {{-- Bayangan kedalaman internal agar PNG datar tampak timbul secara 3D --}}
                            <div class="program-hero__logo-shadow" aria-hidden="true">
                                <img src="{{ $logo }}" alt="" loading="eager" decoding="async" />
                            </div>
                            <div class="program-hero__logo-layer">
                                <img src="{{ $logo }}"
                                     alt="Logo Program {{ $title }}"
                                     loading="eager"
                                     decoding="async" />
                            </div>
                        @endif

                        {{-- Kilau kaca (specular shine) mengikuti kursor --}}
                        <div class="program-hero__shine-mask" aria-hidden="true">
                            <div class="program-hero__shine" data-ph-shine></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Indikator scroll: ikon mouse + panah bergerak naik-turun halus --}}
    <a href="{{ $scrollTarget }}" class="program-hero__scroll" data-ph-scroll aria-label="Gulir ke konten program">
        <span class="program-hero__mouse" aria-hidden="true">
            <span class="program-hero__mouse-wheel"></span>
        </span>
        <span class="program-hero__scroll-chevron" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                 stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </span>
    </a>
</section>
