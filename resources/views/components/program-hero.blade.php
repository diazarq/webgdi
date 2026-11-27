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

    /* Hilangkan baris baru paksa agar paragraf mengalir natural tanpa <br> */
    $cleanDescription = preg_replace('/\s+/u', ' ', trim((string) $description));
@endphp

@once
    @push('style')
        <link rel="stylesheet" href="{{ asset('website/assets/css/program-hero.css') }}?v=1.2.3" />
    @endpush
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
        <script src="{{ asset('website/assets/js/program-hero.js') }}?v=1.2.1"></script>
    @endpush
@endonce

<section class="program-hero"
         data-program-hero
         style="--accent: {{ $cleanAccent }}; --accent-rgb: {{ $accentRgb }};">

    {{-- Latar belakang: foto terlihat jelas + slow Ken Burns + parallax mouse halus + overlay hijau terang --}}
    <div class="program-hero__bg-stage" aria-hidden="true">
        <div class="program-hero__bg-parallax" data-ph-bg-parallax>
            <div class="program-hero__bg-photo"
                 style="background-image: url('{{ $background }}');"></div>
        </div>
        <div class="program-hero__overlay-shield"></div>
        <div class="program-hero__overlay-drift"></div>
    </div>

    {{-- Konten utama: sejajar kiri dengan logo navbar (padding 40px) --}}
    <div class="program-hero__inner">
        <div class="program-hero__content">
            <h1 class="program-hero__title" data-ph-title>{{ $title }}</h1>

            @if(trim((string) $subtitle) !== '')
                <p class="program-hero__subtitle" data-ph-subtitle>{{ $subtitle }}</p>
            @endif

            @if($cleanDescription !== '')
                <p class="program-hero__desc" data-ph-desc>{{ $cleanDescription }}</p>
            @endif
        </div>

        <div class="program-hero__visual" data-ph-visual>
            <div class="program-hero__stage">
                {{-- Floating idle pelan --}}
                <div class="program-hero__float">
                    {{-- Logo 3D bersih tanpa cincin/garis: kedalaman dari bayangan berlapis, shine kursor, & light sweep --}}
                    <div class="program-hero__tilt" data-ph-tilt>
                        <div class="program-hero__cast-shadow" aria-hidden="true"></div>
                        <div class="program-hero__disc" aria-hidden="true"></div>

                        @if(trim((string) $logo) !== '')
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

                        {{-- Kilau halus mengikuti kursor + light sweep tipis periodik di permukaan logo --}}
                        <div class="program-hero__surface-fx" aria-hidden="true">
                            <div class="program-hero__shine" data-ph-shine></div>
                            <div class="program-hero__light-sweep"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panah gulir halus tanpa titik dan tanpa garis --}}
    <a href="{{ $scrollTarget }}" class="program-hero__scroll" data-ph-scroll aria-label="Gulir ke konten program">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </a>
</section>
