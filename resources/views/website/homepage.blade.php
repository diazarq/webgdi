@extends('layout.layout')

@section('title', $pageTitle)

@section('style')
<link rel="stylesheet" href="{{ asset('website/assets/css/custom.css') }}">
<style>
    .section-desc p{
        color: #fff;
        margin-bottom: 20px
    }
    .about-one__text > p{
        margin-bottom: 20px
    }

    /* Nonaktifkan sticky header agar tidak menimpa konten saat scroll */
    .stricky-header {
        display: none !important;
    }


    /* Rapikan jarak section informasi/berita: padding bawaan template terlalu besar (120px/90px) */
    .news-one {
        padding: 45px 0 20px;
    }

    .news-one .section-title {
        margin-bottom: 35px;
    }

    /* ============================================================
       GDI Hero Slider — khusus homepage (scope: .gdi-hero)
       ============================================================ */
    .gdi-hero {
        position: relative;
        padding-top: 100px; /* ruang navbar transparan di atas hero */
        background: #071a12;
    }

    .gdi-hero .gdi-hero__swiper,
    .gdi-hero__swiper {
        position: relative;
    }

    .gdi-hero__slide {
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        min-height: 80vh;
        background-color: #071a12;
    }

    .gdi-hero__slide .container {
        position: relative;
        z-index: 5;
        padding-top: 130px;
        padding-bottom: 110px;
    }

    /* Foto hero: ken-burns zoom saat slide aktif */
    .gdi-hero__image {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center right;
        transform: scale(1.03);
        transition: transform 7000ms ease;
    }

    .gdi-hero .swiper-slide-active .gdi-hero__image {
        transform: scale(1.14);
    }

    /* Overlay tipis: gelap di kiri untuk teks, kanan tetap terang seperti referensi */
    .gdi-hero__overlay {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 2;
        background:
            linear-gradient(90deg, rgba(8, 12, 10, 0.82) 0%, rgba(8, 12, 10, 0.58) 32%, rgba(8, 12, 10, 0.18) 58%, rgba(8, 12, 10, 0) 84%),
            linear-gradient(180deg, rgba(8, 12, 10, 0.3) 0%, rgba(8, 12, 10, 0) 38%, rgba(8, 12, 10, 0.42) 100%);
        pointer-events: none;
    }

    .gdi-hero__content {
        position: relative;
        max-width: 760px;
    }

    /* Tagline kuning di atas judul (persis referensi) */
    .gdi-hero__sub {
        margin: 0 0 18px;
        color: #f2c115;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        opacity: 0;
        transform: translateY(18px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .gdi-hero .swiper-slide-active .gdi-hero__sub {
        opacity: 1;
        transform: none;
        transition-delay: 150ms;
    }

    /* Judul: reveal per kata */
    .gdi-hero__title {
        margin: 0 0 20px;
        font-size: clamp(38px, 5.6vw, 78px);
        line-height: 1.05;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #fff;
        text-shadow: 0 18px 45px rgba(0, 0, 0, 0.35);
    }

    .gdi-hero__word {
        display: inline-block;
        overflow: hidden;
        vertical-align: bottom;
        padding-bottom: 0.12em;
        margin-bottom: -0.12em;
    }

    .gdi-hero__word > span {
        display: inline-block;
        transform: translateY(115%) rotate(4deg);
        opacity: 0;
        transition: transform 0.85s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease;
    }

    .gdi-hero .swiper-slide-active .gdi-hero__word > span {
        transform: translateY(0) rotate(0);
        opacity: 1;
        transition-delay: calc(0.3s + var(--wi, 0) * 60ms);
    }

    /* Deskripsi singkat */
    .gdi-hero__desc {
        max-width: 480px;
        margin: 0 0 34px;
        color: rgba(255, 255, 255, 0.78);
        font-size: 15px;
        line-height: 1.7;
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .gdi-hero .swiper-slide-active .gdi-hero__desc {
        opacity: 1;
        transform: none;
        transition-delay: 0.75s;
    }

    /* Tombol aksi */
    .gdi-hero__cta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        opacity: 0;
        transform: translateY(26px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .gdi-hero .swiper-slide-active .gdi-hero__cta {
        opacity: 1;
        transform: none;
        transition-delay: 0.9s;
    }

    /* Tombol kuning kotak + panah diagonal ↗ seperti referensi */
    .gdi-hero__btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        border-radius: 4px;
        background-color: #f2c115;
        color: #101512;
        font-size: 14px;
        font-weight: 800;
        padding: 17px 32px;
    }

    .gdi-hero__btn:hover {
        background-color: #ff6600;
        color: white;
    }

    .gdi-hero__btn i {
        font-size: 14px;
        transform: rotate(-45deg);
        transition: transform 0.35s ease;
    }

    .gdi-hero__btn:hover i {
        transform: rotate(-45deg) translateX(3px);
    }

    /* Panah navigasi kotak gelap di sisi kanan (seperti referensi) */
    .gdi-hero__nav {
        position: absolute;
        top: 50%;
        right: 40px;
        z-index: 20;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        transform: translateY(-50%);
    }

    .gdi-hero__arrow {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: none;
        border-radius: 2px;
        background: rgba(45, 50, 47, 0.92);
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.35s ease;
    }

    .gdi-hero__arrow:hover {
        background: #f2c115;
        color: #101512;
    }

    .gdi-hero__pagination {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
    }

    .gdi-hero__pagination .swiper-pagination-bullet {
        width: 7px;
        height: 7px;
        margin: 0 !important;
        background: rgba(255, 255, 255, 0.5);
        opacity: 1;
        transition: all 0.35s ease;
    }

    .gdi-hero__pagination .swiper-pagination-bullet-active {
        height: 22px;
        border-radius: 999px;
        background: #f2c115;
        box-shadow: 0 0 0 3px rgba(242, 193, 21, 0.2);
    }

    /* Responsif */
    @media (max-width: 991px) {
        .gdi-hero__slide {
            min-height: 0;
        }

        .gdi-hero__slide .container {
            padding-top: 140px;
            padding-bottom: 120px;
        }

        .gdi-hero__nav {
            right: 16px;
        }
    }

    @media (max-width: 767px) {
        .gdi-hero {
            padding-top: 84px;
        }

        .gdi-hero__slide .container {
            padding-top: 110px;
            padding-bottom: 100px;
        }

        .gdi-hero__overlay {
            background:
                linear-gradient(90deg, rgba(8, 12, 10, 0.85) 0%, rgba(8, 12, 10, 0.6) 55%, rgba(8, 12, 10, 0.25) 100%),
                linear-gradient(180deg, rgba(8, 12, 10, 0.35) 0%, rgba(8, 12, 10, 0.1) 40%, rgba(8, 12, 10, 0.5) 100%);
        }

        .gdi-hero__nav {
            right: 12px;
        }

        .gdi-hero__arrow {
            width: 40px;
            height: 40px;
            font-size: 13px;
        }

        .gdi-hero__desc {
            font-size: 15px;
        }
    }
</style>
@endsection

@section('homeSlider')
@php
    $hasSlider = @$slider && count($slider) > 0;
@endphp
<section class="gdi-hero">

    @if($hasSlider)
    <div class="swiper-container thm-swiper__slider gdi-hero__swiper" data-swiper-options='{
        "slidesPerView": 1,
        "loop": true,
        "speed": 900,
        "effect": "fade",
        "fadeEffect": { "crossFade": true },
        "grabCursor": true,
        "keyboard": { "enabled": true },
        "pagination": {
            "el": ".gdi-hero__pagination",
            "type": "bullets",
            "clickable": true
        },
        "navigation": {
            "nextEl": ".gdi-hero__next",
            "prevEl": ".gdi-hero__prev"
        },
        "autoplay": {
            "delay": 6000,
            "disableOnInteraction": false
        }
    }'>
        <div class="swiper-wrapper">
            @foreach($slider as $dt)
                @php
                    $url       = preg_replace('/\\\\/', '/', $dt->image_upload);
                    $btn       = json_decode($dt->button);
                    $words     = array_values(array_filter(preg_split('/\s+/', trim(strip_tags($dt->title ?? '')))));
                    /* Selalu tampilkan teks kecil di bawah judul; pakai kalimat brand GDI jika admin belum mengisi deskripsi */
                    $desc      = trim(strip_tags(@$dt->description)) !== ''
                        ? strip_tags($dt->description)
                        : 'Graha Dhuafa Indonesia senantiasa berkomitmen untuk terus ambil peran dalam menjaga generasi pelanjut. #PeduliMenjagaGenerasi';
                @endphp
                <div class="swiper-slide gdi-hero__slide">
                    <div class="gdi-hero__image" style="background-image: url('{{ $url }}');"></div>
                    <div class="gdi-hero__overlay" aria-hidden="true"></div>

                    <div class="container">
                        <div class="gdi-hero__content">
                            @if(trim(strip_tags($dt->subtitle ?? '')) !== '')
                            <p class="gdi-hero__sub">{{ $dt->subtitle }}</p>
                            @endif

                            <h2 class="gdi-hero__title">
                                @foreach($words as $i => $word)
                                    <span class="gdi-hero__word" style="--wi: {{ $i }}"><span>{{ $word }}</span></span>
                                @endforeach
                            </h2>

                            <div class="gdi-hero__desc">{{ $desc }}</div>

                            @if($btn && count($btn))
                            <div class="gdi-hero__cta">
                                <a href="{{ $btn[0]->url }}" class="thm-btn gdi-hero__btn">
                                    {{ $btn[0]->text }} <i class="fas fa-arrow-right gdi-hero__btn-icon"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigasi + pagination -->
        <div class="gdi-hero__nav">
            <button type="button" class="gdi-hero__arrow gdi-hero__prev" aria-label="Slide sebelumnya">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" class="gdi-hero__arrow gdi-hero__next" aria-label="Slide berikutnya">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="gdi-hero__pagination"></div>
        </div>
    </div>
    @else
    {{-- Fallback (DB belum punya slider): konten persis dari webgdi.sql, swiper tetap jalan --}}
    @php
        $fallbackSlides = [
            [
                'image'    => 'images/slider/slider1.jpeg',
                'subtitle' => 'Yayasan Graha Dhuafa Indonesia',
                'title'    => 'Bangun Peradaban Berakhlak dan Berkarya',
                'desc'     => 'Graha Dhuafa Indonesia senantiasa berkomitmen untuk terus ambil peran dalam menjaga generasi pelanjut. #PeduliMenjagaGenerasi',
                'text'     => 'Tunaikan Sekarang',
                'url'      => '/app/zakat',
            ],
            [
                'image'    => 'images/slider/slider2.jpeg',
                'subtitle' => 'Yayasan Graha Dhuafa Indonesia',
                'title'    => 'Sedekah Anak Yatim Dhuafa Mandiri',
                'desc'     => 'Sedekah terbaik Anda untuk anak yatim dan dhuafa mandiri — dikelola amanah, tepat sasaran, dan berdampak nyata. #PeduliMenjagaGenerasi',
                'text'     => 'Tunaikan Sekarang',
                'url'      => '/app/zakat',
            ],
            [
                'image'    => 'images/slider/slider3.jpeg',
                'subtitle' => 'Yayasan Graha Dhuafa Indonesia',
                'title'    => 'Siapkah diri Anda untuk menjadi volunteer selanjutnya?',
                'desc'     => 'Bergabung menjadi relawan Graha Dhuafa Indonesia dan ambil peran nyata dalam menjaga generasi pelanjut. #PeduliMenjagaGenerasi',
                'text'     => '',
                'url'      => '',
            ],
        ];
    @endphp
    <div class="swiper-container thm-swiper__slider gdi-hero__swiper" data-swiper-options='{
        "slidesPerView": 1,
        "loop": true,
        "speed": 900,
        "effect": "fade",
        "fadeEffect": { "crossFade": true },
        "grabCursor": true,
        "keyboard": { "enabled": true },
        "pagination": {
            "el": ".gdi-hero__pagination",
            "type": "bullets",
            "clickable": true
        },
        "navigation": {
            "nextEl": ".gdi-hero__next",
            "prevEl": ".gdi-hero__prev"
        },
        "autoplay": {
            "delay": 6000,
            "disableOnInteraction": false
        }
    }'>
        <div class="swiper-wrapper">
            @foreach($fallbackSlides as $fd)
                @php
                    $words = array_values(array_filter(preg_split('/\s+/', trim($fd['title']))));
                @endphp
                <div class="swiper-slide gdi-hero__slide">
                    <div class="gdi-hero__image" style="background-image: url('{{ asset($fd['image']) }}');"></div>
                    <div class="gdi-hero__overlay" aria-hidden="true"></div>

                    <div class="container">
                        <div class="gdi-hero__content">
                            <p class="gdi-hero__sub">{{ $fd['subtitle'] }}</p>
                            <h2 class="gdi-hero__title">
                                @foreach($words as $i => $word)
                                    <span class="gdi-hero__word" style="--wi: {{ $i }}"><span>{{ $word }}</span></span>
                                @endforeach
                            </h2>

                            @if(trim($fd['desc']) !== '')
                            <div class="gdi-hero__desc">{{ $fd['desc'] }}</div>
                            @endif

                            @if(trim($fd['text']) !== '')
                            <div class="gdi-hero__cta">
                                <a href="{{ url($fd['url']) }}" class="thm-btn gdi-hero__btn">
                                    {{ $fd['text'] }} <i class="fas fa-arrow-right gdi-hero__btn-icon"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigasi + pagination (selalu tampil) -->
        <div class="gdi-hero__nav">
            <button type="button" class="gdi-hero__arrow gdi-hero__prev" aria-label="Slide sebelumnya">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" class="gdi-hero__arrow gdi-hero__next" aria-label="Slide berikutnya">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="gdi-hero__pagination"></div>
        </div>
    </div>
    @endif
</section>
@endsection

@section('homeProgram')
<!--
<section class="project-two">
    <div class="project-two-shape-1 float-bob-x">
        <img src="{{ asset('website/assets/images/shapes/project-two-shape-1.png') }}" alt="">
    </div>
    <div class="container">
        <div class="section-title text-center">
            <span class="section-title__tagline">Program Yayasan</span>
            <h2 class="section-title__title">Telusuri program donasi</h2>
        </div>
        @if(@$program)
        <div class="row">
            @php
                $no = 0;
            @endphp
            @foreach($program as $pg)
            @php
                $no += 100;
                $percentage = ($pg->donasi / $pg->target_nominal) * 100;
                $days = Helper::totalDays($pg->date_end);
            @endphp
            <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="{{ $no.'ms'}}">
                <div class="project-one__single">
                    <div class="project-one__img-box">
                        <div class="project-one__img">
                            <img src="{{ asset($pg->image_upload) }}" alt="">
                        </div>
                        <div class="project-one__icon">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                    <div class="project-one__content">
                        <div class="project-one__tag">
                            <p>{{ $pg->category }}</p>
                        </div>
                        <h3 class="project-one__title" style="height: 70px"><a href="/program/donasi/{{ $pg->slug }}">{{ $pg->title }}</a></h3>
                        <div class="project-one__remaing">
                            <div class="icon">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div class="text">
                                <p>{{ $days >= 0 ? $days.' Hari Lagi' : 'Program Berakhir' }}</p>
                            </div>
                        </div>
                        <div class="progress-levels">
                            <div class="progress-box">
                                <div class="inner count-box">
                                    <div class="text">Target</div>
                                    <div class="bar">
                                        <div class="bar-innner">
                                            <div class="skill-percent">
                                                <span class="count-text" data-speed="3000"
                                                    data-stop="{{ $percentage }}">0</span>
                                                <span class="percent">%</span>
                                            </div>
                                            <div class="bar-fill" data-percent="{{ $percentage }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="project-one__goals">
                            <p class="project-one__goals-one" style="text-align: left">Terkumpul:<br/><span>Rp. {{ number_format($pg->donasi) }}</span></p>
                            <p class="project-one__goals-one" style="text-align: right">Target Pencapaian:<br/><span>Rp. {{ number_format($pg->target_nominal) }}</span></p>
                        </div>
                        <br/>
                        <a href="/program/donasi/{{ $pg->slug }}" class="thm-btn">Donasi Sekarang</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
-->
@include('website.partials.program-unggulan')

    


<section class="program-yayasan">
  <div class="container">
    <!-- Judul -->
    <div class="program-yayasan__title text-center">
      <p class="subtitle">PROGRAM IMPLEMENTASI GRAHA DHUAFA INDONESIA</p>
      <h2>
        Graha Dhuafa Indonesia senantiasa berkomitmen untuk terus ambil peran
        dalam menjaga generasi pelanjut.
        <span class="program-yayasan__hashtag">#PeduliMenjagaGenerasi</span>
      </h2>
    </div>

    <!-- Isi Program (dinamis dari tabel program_implementasi) -->
    <div class="row justify-content-center">
      @php
        /* fallback: kalau DB kosong, tampilkan 3 tile bawaan agar homepage tidak kosong */
        $implList = (@$programImplementasi && count($programImplementasi) > 0) ? $programImplementasi : [
            (object) ['nama_program' => 'Budaya', 'logo_image' => 'images/program-implementasi/budaya.png', 'url_program' => '/budaya'],
            (object) ['nama_program' => 'Cinta',  'logo_image' => 'images/program-implementasi/cinta.png',  'url_program' => '/cinta'],
            (object) ['nama_program' => 'Senyum', 'logo_image' => 'images/program-implementasi/senyum.png', 'url_program' => '/senyum'],
        ];
      @endphp
      @foreach($implList as $impl)
      @php
        /* URL tujuan hanya dari kolom url_program; tile tanpa URL tidak bisa diklik (anti-404).
           Otomatis tambahkan '/' di depan bila admin menulis tanpa slash, URL lengkap dibiarkan apa adanya. */
        $rawUrl  = trim((string) @$impl->url_program);
        $implUrl = $rawUrl !== ''
            ? ((preg_match('#^https?://#i', $rawUrl) || substr($rawUrl, 0, 1) === '/') ? $rawUrl : '/' . $rawUrl)
            : null;
      @endphp
      <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
        <div class="program-card" @if($implUrl) onclick="link('{{ $implUrl }}')" @endif>
          <img src="{{ asset($impl->logo_image ?: 'website/assets/images/custom/' . strtolower($impl->nama_program) . '.png') }}" alt="{{ $impl->nama_program }}"/>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
<style>
.program-yayasan {
  padding: 60px 0;
  text-align: center;
}

.program-yayasan__title .subtitle {
  display: inline-block;
  color: #ff6600; /* warna oranye mirip di ss */
  font-weight: 700;
  font-size: 14px;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  background: rgba(255, 102, 0, 0.08);
  border: 1px solid rgba(255, 102, 0, 0.25);
  padding: 7px 18px;
  border-radius: 999px;
  margin-bottom: 16px;
}

.program-yayasan__title h2 {
  max-width: 760px;
  margin: 0 auto 40px;
  font-size: 26px;
  font-weight: 700;
  color: #1a8b4c; /* hijau utama */
  line-height: 1.55;
}

/* Garis aksen kecil di bawah judul */
.program-yayasan__title h2::after {
  content: "";
  display: block;
  width: 68px;
  height: 4px;
  border-radius: 999px;
  margin: 18px auto 0;
  background: linear-gradient(90deg, #ff8a3d, #1a8b4c);
}

/* Highlight hashtag sebagai aksen oranye */
.program-yayasan__hashtag {
  display: inline-block;
  margin-left: 6px;
  padding: 3px 14px;
  border-radius: 999px;
  background: rgba(255, 102, 0, 0.10);
  color: #ff6600;
  font-weight: 800;
  white-space: nowrap;
}

@media (max-width: 575px) {
  .program-yayasan__title h2 {
    font-size: 21px;
  }

  .program-yayasan__title .subtitle {
    font-size: 12px;
    letter-spacing: 0.1em;
    padding: 6px 14px;
  }
}

.program-card {
  cursor: pointer;
  transition: transform 0.3s ease;
}

.program-card img {
  width: 80%;         /* biar gak full 100% dan lebih proporsional */
  max-width: 280px;   /* batas maksimal biar gak terlalu gede */
  margin: auto;
  display: block;
}

.program-card:hover {
  transform: scale(1.05);
}
</style>



@include('website.partials.slider-pilar')

<section class="faq-one">
    <div class="faq-one-bg" style="background-image: url('website/assets/images/backgrounds/faq-one-bg.png')"></div>
    <div class="container">
        <div class="section-title text-center">
            <span class="section-title__tagline">Peta Sebaran</span>
            <h2 class="section-title__title">Program Graha Dhuafa</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <img src="{{ asset('website/assets/images/custom/peta_sebaran.svg') }}" width="100%"/>

                <div class="mt-5 text-center">
                    <p>Wilayah Sebaran Manfaat Graha Dhuafa Indonesia</p>
                    <h4>Jakarta, Jawa Barat, Jawa Tengah, Jawa Timur, NTB, NTT,<br/>Sulawesi Barat, Sumatra Barat, Bali, Kalimantan Selatan</h4>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Section: Berdampak Lebih Luas (statistik donasi + peta oranye) --}}
@include('website.partials.peta-dampak')

@include('website.partials.timeline')

@endsection

@section('homeBlog')
<section class="news-one news-two">
    <div class="container">
        <div class="section-title text-center">
            <span class="section-title__tagline">Informasi Yayasan</span>
            <h2 class="section-title__title">Ikuti perkembangan informasi terkait<br/>program dan donasi</h2>
        </div>
        @if(@$blog)
        <div class="row">
            @php 
                $no = 0;
            @endphp
            @foreach($blog as $dt)
            @php 
                $no += 100;
                $tanggal = Helper::dateFormat(date('Y-m-d', strtotime($dt->date_publish)));
            @endphp
            <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="{{ $no.'ms'}}">
                <!--News One Single Start-->
                <div class="news-one__single">
                    <div class="news-one__img-box">
                        <div class="news-one__img">
                            <img src="{{ asset($dt->featured_img) }}" alt="" style="width: 100%; height: 250px; object-fit: cover">
                            <a href="/blog/{{ $dt->slug }}">
                                <span class="news-one__plus"></span>
                            </a>
                        </div>
                        <!--
                        <div class="news-one__date">
                            <p>28</p>
                            <span>july</span>
                        </div>
                        -->
                    </div>
                    <div class="news-one__content">
                        <ul class="news-one__meta list-unstyled">
                            <li>
                                <a href="/"><i class="fas fa-user-circle"></i>by {{ $dt->author }}</a>
                            </li>
                            <li>
                                <a href="/"><i class="fas fa-clock"></i>{{ $tanggal }}</a>
                            </li>
                        </ul>
                        <h3 class="news-one__title"><a href="/blog/{{ $dt->slug }}">{{ $dt->title }}</a></h3>
                        <p>{{ $dt->kategori }}</p>
                        <div class="news-one__bottom">
                            <div class="news-one__button">
                                <a href="/blog/{{ $dt->slug }}">Read more</a>
                            </div>
                            <div class="news-one__arrow">
                                <a href="/blog/{{ $dt->slug }}"><span class="icon-right-arrow"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--News One Single Start-->
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- Section Berita Baru --}}
@include('website.partials.berita')
@endsection








@section('homeAds')
@if(@$ads)
@php
    $btn = json_decode(@$ads->button);
    $image = preg_replace('/\\\\/', '/', @$ads->image_upload);
@endphp
<section class="ready-one">
    <div class="container">
        <div class="ready-one__inner" <?= @$ads->image_upload ? 'style="background-image: url('. $image .'); background-size: cover"' : '' ?>>
            <div class="ready-one-shape-1 float-bob-x">
                <img src="{{ asset('website/assets/images/shapes/ready-one-shape-1.png') }}" alt="">
            </div>
            <div class="ready-one__big-icon float-bob-y-2">
                <span class="icon-fundraiser"></span>
            </div>
            <div class="ready-one__left">
                <div class="icon">
                    <span class="icon-fundraiser"></span>
                </div>
                <div class="content">
                    <p>{{ @$ads->title }}</p>
                    <h3>{{ @$ads->subtitle }}</h3>
                </div>
            </div>
            @if($btn)
            <div class="ready-one__right">
                <a href="{{ @$btn[0]->url }}" class="thm-btn ready-one__btn">{{ @$btn[0]->text }}</a>
            </div>
            @endif
        </div>
    </div>
</section>
@endif
@endsection

@section('homeInfo')
@if(@$info)
@php
    $btn2 = json_decode(@$info->button);
    $imageGen = preg_replace('/\\\\/', '/', @$info->image_upload);
@endphp
<section class="every-step">
    <div class="every-step__wrap">
        <div class="every-step__left" style="min-height: 693px">
            <div class="every-step-shape-1 float-bob-x">
                <img src="{{ asset('website/assets/images/shapes/every-step-shape-1.png') }}" alt="">
            </div>
            <div class="every-step__content">
                <div class="section-title text-left">
                    <span class="section-title__tagline">{{ @$info->subtitle }}</span>
                    <h2 class="section-title__title">{{ @$info->title}}</h2>
                </div>
                
                <div class="section-desc">
                    {!! @$info->description !!}
                </div>

                @if($btn2)
                <div>
                    <a href="{{ @$btn2[0]->url }}" class="thm-btn ready-one__btn">{{ @$btn2[0]->text }}</a>
                </div>    
                @endif
            </div>
        </div>
        <div class="every-step__right">
            <div class="every-step__bg"
                style="background-image: url({{$imageGen}});">
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('homeAbout')
@if(@$about)
@php
    $imageArr = json_decode($about->image_upload);
    $imgAbout1 = '';
    $imgAbout2 = '';
    if($imageArr){
        foreach($imageArr as $dt){
            if($dt->id == '1'){
                $imgAbout1 = preg_replace('/\\\\/', '/', $dt->path);
            }else{
                $imgAbout2 = preg_replace('/\\\\/', '/', $dt->path);
            }
        }
    }
@endphp
<section class="about-one">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="about-one__left">
                    <div class="about-one__img-box wow slideInLeft" data-wow-delay="100ms"
                        data-wow-duration="2500ms">
                        <div class="about-one__img-1">
                            <img src="{{ asset($imgAbout1) }}" alt="" style="width: 100%; height: 500px; object-fit: cover">
                        </div>
                        <div class="about-one__img-2">
                            <img src="{{ asset($imgAbout2) }}" alt="" style="width: 50%; float:right">
                        </div>
                        <!--
                        <div class="about-one__experience">
                            <div class="about-one__experience-inner">
                                <h3>30</h3>
                                <p>Years of <br> Experience</p>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="about-one__right">
                    <div class="section-title text-left">
                        <span class="section-title__tagline">Selayang Pandang</span>
                        <h2 class="section-title__title">{{ @$about->title }}</h2>
                    </div>
                    <div class="about-one__text">
                        {!! @$about->description !!}
                    </div>
                    <!--
                    <div class="about-one__person">
                        <div class="about-one__person-img">
                            <img src="{{ asset('website/assets/images/resources/about-1-3.jpg') }}" alt="">
                        </div>
                        <div class="about-one__person-content">
                            <p class="about-one__person-name">Kevin Martin</p>
                            <p class="about-one__person-foundation">CEO Foundation</p>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<script>
    function link(link){
        window.location.href = link
    }
</script>

@endsection

