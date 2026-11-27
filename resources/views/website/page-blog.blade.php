@extends('layout.layout-page')
@section('title', $pageTitle)

@section('style')
<style>
    .gdi-blog-section {
        padding: 45px 0 75px 0;
        background: linear-gradient(135deg, #06301f 0%, #0a4a2e 55%, #0d5c38 100%);
        position: relative;
        overflow: hidden;
    }

    .gdi-blog-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(520px 320px at 12% 18%, rgba(45, 212, 167, 0.24), transparent 62%),
            radial-gradient(480px 320px at 88% 22%, rgba(126, 240, 192, 0.18), transparent 60%),
            radial-gradient(500px 320px at 78% 85%, rgba(45, 212, 167, 0.2), transparent 60%);
        pointer-events: none;
        z-index: 1;
    }

    .gdi-blog-container {
        max-width: 1240px;
        position: relative;
        z-index: 2;
    }

    /* LEFT HERO CARD (GLASSMORPHISM FRAME) */
    .gdi-hero-card {
        position: relative;
        border-radius: 22px;
        overflow: hidden;
        min-height: 460px;
        height: 100%;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.32), inset 0 1px 0 rgba(255, 255, 255, 0.28);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-top-color: rgba(255, 255, 255, 0.35);
    }

    .gdi-hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.55s ease, transform 0.55s ease;
        transform: scale(1.02);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 45px 50px;
        z-index: 1;
    }

    .gdi-hero-slide.active {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
        z-index: 2;
    }

    .gdi-hero-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        z-index: 1;
        transition: transform 6s ease-out;
    }

    .gdi-hero-slide.active .gdi-hero-img {
        transform: scale(1.04);
    }

    /* Gradient Overlay dari kiri ke kanan agar teks tajam & foto kanan jelas */
    .gdi-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to right,
            rgba(6, 48, 31, 0.95) 0%,
            rgba(6, 48, 31, 0.78) 46%,
            rgba(6, 48, 31, 0.15) 100%
        ),
        linear-gradient(
            to top,
            rgba(6, 48, 31, 0.75) 0%,
            transparent 50%
        );
        z-index: 2;
    }

    .gdi-hero-content {
        position: relative;
        z-index: 3;
        max-width: 540px;
    }

    /* Category Glass Pill */
    .gdi-category-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 30px;
        margin-bottom: 18px;
    }

    .gdi-category-pill::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #2dd4a7;
        display: inline-block;
    }

    /* Headline Title */
    .gdi-hero-title {
        font-size: 36px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.22;
        margin-bottom: 16px;
        letter-spacing: -0.3px;
        text-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
    }

    .gdi-hero-title a {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.25s ease;
    }

    .gdi-hero-title a:hover {
        color: #7ef0c0;
    }

    .gdi-hero-title em {
        font-style: italic;
        font-weight: 700;
        color: #7ef0c0;
    }

    /* Garis aksen hijau kecil di bawah judul */
    .gdi-title-divider {
        width: 38px;
        height: 3px;
        background: #2dd4a7;
        border-radius: 2px;
        margin-bottom: 16px;
    }

    /* Meta Info */
    .gdi-hero-meta {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: rgba(236, 253, 245, 0.85);
    }

    .gdi-hero-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .gdi-hero-meta .sep {
        opacity: 0.4;
    }

    /* CTA Button "Baca Selengkapnya ->" */
    .gdi-hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        padding: 10px 22px;
        border-radius: 30px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .gdi-hero-btn:hover {
        background: #2dd4a7;
        border-color: #2dd4a7;
        color: #06301f;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 212, 167, 0.35);
    }

    /* RIGHT COLUMN (UNIFORM GLASSMORPHISM CARDS) */
    .gdi-playlist-col {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 16px;
        height: 100%;
    }

    .gdi-side-card {
        flex: 1;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.14) 0%, rgba(255, 255, 255, 0.04) 100%);
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-top-color: rgba(255, 255, 255, 0.35);
        border-left-color: rgba(255, 255, 255, 0.28);
        border-radius: 20px;
        padding: 14px;
        display: flex;
        align-items: center;
        gap: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.22);
    }

    .gdi-side-card:hover {
        border-color: rgba(45, 212, 167, 0.75);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.22) 0%, rgba(255, 255, 255, 0.08) 100%);
        transform: translateX(4px);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.26), inset 0 1px 0 rgba(255, 255, 255, 0.32);
    }

    .gdi-side-card.active {
        border: 1.5px solid #2dd4a7;
        box-shadow: 0 10px 30px rgba(45, 212, 167, 0.28), inset 0 1px 0 rgba(255, 255, 255, 0.35);
        background: linear-gradient(135deg, rgba(45, 212, 167, 0.24) 0%, rgba(255, 255, 255, 0.08) 100%);
    }

    .gdi-side-thumb {
        width: 130px;
        height: 92px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .gdi-side-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .gdi-side-card:hover .gdi-side-thumb img {
        transform: scale(1.05);
    }

    .gdi-side-body {
        flex-grow: 1;
        min-width: 0;
    }

    .gdi-side-title {
        font-size: 15px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.38;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }

    .gdi-side-meta {
        font-size: 11px;
        font-weight: 600;
        color: rgba(236, 253, 245, 0.78);
        letter-spacing: 0.8px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .gdi-hero-card {
            min-height: 400px;
            margin-bottom: 20px;
        }

        .gdi-hero-slide {
            padding: 30px 24px;
        }

        .gdi-hero-title {
            font-size: 26px;
        }
    }

    @media (max-width: 576px) {
        .gdi-side-thumb {
            width: 100px;
            height: 75px;
        }

        .gdi-side-title {
            font-size: 13.5px;
        }
    }
</style>
@endsection

@section('breadcrumb')
<h2>{!! preg_replace('/^LAZ\s*(.+)$/i', 'LAZ <span class="font-banner">$1</span>', @$detail->title ? @$detail->title : $pageTitle) !!}</h2>
@endsection

@section('pageBlog')
@php
    $heroItems = collect(@$heroBlogs && count($heroBlogs) > 0 ? $heroBlogs : (isset($blog) ? $blog->take(3) : []));
    if ($heroItems->count() < 3) {
        $extra = \App\Models\Blog::where('status', 'publish')->orderBy('date_publish', 'desc')->take(3)->get();
        if ($extra->count() > $heroItems->count()) {
            $heroItems = $extra;
        }
    } else {
        $heroItems = $heroItems->take(3);
    }

    // Helper sanitasi URL gambar
    $getCleanImageUrl = function($rawPath) {
        if (empty($rawPath)) {
            return asset('website/assets/images/blog/news-1-1.jpg');
        }
        $clean = str_replace('\\', '/', $rawPath);
        $clean = ltrim($clean, '/');
        $parts = explode('/', $clean);
        $encodedParts = array_map('rawurlencode', $parts);
        return asset(implode('/', $encodedParts));
    };

    $formatEditorialTitle = function($rawTitle) {
        $words = explode(' ', trim($rawTitle));
        if (count($words) >= 4) {
            $italicIdx = min(2, count($words) - 2);
            $words[$italicIdx] = '<em>' . e($words[$italicIdx]) . '</em>';
            return implode(' ', $words);
        }
        return e($rawTitle);
    };

    $calcReadTime = function($content) {
        $wordCount = str_word_count(strip_tags($content ?? ''));
        $minutes = max(3, (int) ceil($wordCount / 180));
        return $minutes . ' MIN READ';
    };

    $getAuthorName = function($item) {
        if (!empty($item->author)) return $item->author;
        if ($item->user && !empty($item->user->name)) return $item->user->name;
        return 'REDAKSI GDI';
    };

    $sliderData = [];
    foreach ($heroItems as $k => $item) {
        $sliderData[] = [
            'index' => $k,
            'title' => $item->title,
            'formattedTitle' => $formatEditorialTitle($item->title),
            'category' => strtoupper($item->jenis ?: ($item->kategori ?: 'KABAR GDI')),
            'img' => $getCleanImageUrl($item->featured_img),
            'url' => '/blog/' . $item->slug,
            'readTime' => $calcReadTime($item->content),
            'author' => strtoupper($getAuthorName($item)),
        ];
    }
@endphp

@if(count($sliderData) > 0)
<section class="gdi-blog-section">
    <div class="container gdi-blog-container">
        <div class="row g-4 align-items-stretch" id="gdiShowcaseWrap">
            <!-- LEFT COLUMN: MAIN HERO SLIDE (~65% width) -->
            <div class="col-lg-8">
                <div class="gdi-hero-card" id="gdiHeroCard">
                    @foreach($sliderData as $sIdx => $slide)
                    <div class="gdi-hero-slide {{ $sIdx === 0 ? 'active' : '' }}" id="gdiSlide-{{ $sIdx }}">
                        <img class="gdi-hero-img" src="{{ $slide['img'] }}" alt="{{ $slide['title'] }}">
                        <div class="gdi-hero-overlay"></div>
                        
                        <div class="gdi-hero-content">
                            <span class="gdi-category-pill">{{ $slide['category'] }}</span>
                            <h1 class="gdi-hero-title">
                                <a href="{{ $slide['url'] }}">{!! $slide['formattedTitle'] !!}</a>
                            </h1>
                            <div class="gdi-title-divider"></div>
                            <div class="gdi-hero-meta">
                                <span><i class="far fa-clock"></i> {{ $slide['readTime'] }}</span>
                                <span class="sep">|</span>
                                <span><i class="far fa-user"></i> BY {{ $slide['author'] }}</span>
                            </div>

                            <a href="{{ $slide['url'] }}" class="gdi-hero-btn">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT COLUMN: 3 UNIFORM GLASSMORPHISM CARDS (TANPA ARROW) -->
            <div class="col-lg-4">
                <div class="gdi-playlist-col">
                    @foreach($sliderData as $pIdx => $item)
                    <div class="gdi-side-card {{ $pIdx === 0 ? 'active' : '' }}" id="gdiSide-{{ $pIdx }}" onclick="changeSlide({{ $pIdx }})">
                        <div class="gdi-side-thumb">
                            <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}">
                        </div>
                        <div class="gdi-side-body">
                            <h4 class="gdi-side-title">{{ $item['title'] }}</h4>
                            <div class="gdi-side-meta">
                                <i class="far fa-clock"></i> {{ $item['readTime'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = @json($sliderData);
        const total = slides.length;
        if (total === 0) return;

        // =========================================================================
        // PENGATURAN DURASI AUTOPLAY SLIDER
        // Ubah angka di bawah ini (dalam milidetik: 1000 = 1 detik, 5000 = 5 detik)
        // =========================================================================
        const SLIDE_DURATION_MS = 3000; 

        let current = 0;
        let timer = null;
        const wrap = document.getElementById('gdiShowcaseWrap');

        window.changeSlide = function (idx) {
            if (idx >= total) idx = 0;
            if (idx < 0) idx = total - 1;
            current = idx;

            // 1. Update left hero slides
            document.querySelectorAll('.gdi-hero-slide').forEach((slide, i) => {
                slide.classList.toggle('active', i === current);
            });

            // 2. Update right side cards active border
            document.querySelectorAll('.gdi-side-card').forEach(card => {
                card.classList.toggle('active', card.id === 'gdiSide-' + current);
            });

            resetTimer();
        };

        function startTimer() {
            stopTimer();
            timer = setInterval(function () {
                window.changeSlide((current + 1) % total);
            }, SLIDE_DURATION_MS);
        }

        function stopTimer() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        function resetTimer() {
            stopTimer();
            startTimer();
        }

        startTimer();

        // Pause saat mouse diarahkan ke area showcase
        if (wrap) {
            wrap.addEventListener('mouseenter', stopTimer);
            wrap.addEventListener('mouseleave', startTimer);
        }
    });
</script>
@endpush
