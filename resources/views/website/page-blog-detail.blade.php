@extends('layout.layout-page')
@section('title', $pageTitle)

@section('style')
<style>
    /* ==========================================================
       EDITORIAL ARTICLE DETAIL (INSPIRASI FOLKATIVE + TEMA GDI)
       ========================================================== */
    .fk-detail-section {
        background: #081c15;
        color: #f1f5f9;
        padding: 55px 0 85px 0;
    }

    .fk-detail-container {
        max-width: 1180px;
    }

    /* CENTERED HEADER BLOCK */
    .fk-detail-header {
        text-align: center;
        max-width: 820px;
        margin: 0 auto 42px auto;
    }

    .fk-detail-badge {
        display: inline-block;
        background: #04120d;
        color: #2dd4a7;
        border: 1px solid rgba(45, 212, 167, 0.45);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        padding: 5px 14px;
        margin-bottom: 18px;
    }

    .fk-detail-title {
        font-size: 38px;
        font-weight: 800;
        line-height: 1.24;
        color: #ffffff;
        margin-bottom: 14px;
    }

    .fk-detail-date {
        font-size: 13px;
        color: #94a3b8;
        letter-spacing: 0.5px;
    }

    /* FEATURED IMAGE */
    .fk-detail-featured-img {
        width: 100%;
        aspect-ratio: 16 / 10;
        object-fit: cover;
        margin-bottom: 32px;
        background: #04120d;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* ARTICLE BODY TYPOGRAPHY */
    .fk-detail-content {
        font-size: 16px;
        line-height: 1.8;
        color: #e2e8f0;
        margin-bottom: 45px;
    }

    .fk-detail-content p {
        margin-bottom: 22px;
    }

    .fk-detail-content h2,
    .fk-detail-content h3,
    .fk-detail-content h4 {
        color: #ffffff;
        font-weight: 800;
        margin-top: 34px;
        margin-bottom: 16px;
    }

    .fk-detail-content a {
        color: #2dd4a7;
        text-decoration: underline;
    }

    .fk-detail-content img {
        max-width: 100%;
        height: auto;
        margin: 26px 0;
    }

    .fk-detail-content blockquote {
        border-left: 3px solid #2dd4a7;
        background: #04120d;
        padding: 18px 24px;
        margin: 26px 0;
        font-style: italic;
        color: #cbd5e1;
    }

    /* PREVIOUS / BACK NAVIGATION BLOCK */
    .fk-prev-post {
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        padding: 22px 0;
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 35px;
    }

    .fk-prev-post__thumb {
        width: 78px;
        height: 78px;
        flex-shrink: 0;
        overflow: hidden;
        background: #04120d;
    }

    .fk-prev-post__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .fk-prev-post__label {
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #2dd4a7;
        margin-bottom: 5px;
    }

    .fk-prev-post__title {
        font-size: 16px;
        font-weight: 700;
        line-height: 1.35;
        margin: 0;
    }

    .fk-prev-post__title a {
        color: #ffffff;
        text-decoration: none;
    }

    .fk-prev-post__title a:hover {
        color: #2dd4a7;
    }

    /* RIGHT SIDEBAR */
    .fk-sidebar-block {
        margin-bottom: 36px;
    }

    .fk-sidebar-heading {
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #ffffff;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        margin-bottom: 18px;
    }

    /* "Something Fresh" Overlay Card */
    .fk-fresh-card {
        position: relative;
        height: 240px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 20px;
        background: #04120d;
        margin-bottom: 18px;
    }

    .fk-fresh-card img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        z-index: 1;
    }

    .fk-fresh-card:hover img {
        transform: scale(1.05);
    }

    .fk-fresh-card__overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(4, 18, 13, 0.94) 0%,
            rgba(4, 18, 13, 0.45) 55%,
            rgba(4, 18, 13, 0.1) 100%
        );
        z-index: 2;
    }

    .fk-fresh-card__badge {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 3;
        background: #06301f;
        color: #2dd4a7;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 4px 10px;
    }

    .fk-fresh-card__body {
        position: relative;
        z-index: 3;
    }

    .fk-fresh-card__title {
        font-size: 18px;
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 6px;
    }

    .fk-fresh-card__title a {
        color: #ffffff;
        text-decoration: none;
    }

    .fk-fresh-card__title a:hover {
        color: #7ef0c0;
    }

    .fk-fresh-card__date {
        font-size: 11.5px;
        color: #cbd5e1;
    }

    /* Stacked Categories List */
    .fk-cat-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .fk-cat-list li {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .fk-cat-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: #04120d;
        color: #e2e8f0;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        text-decoration: none;
        transition: background 0.25s ease, color 0.25s ease;
    }

    .fk-cat-list a:hover {
        background: #1ab69d;
        color: #04120d;
    }

    @media (max-width: 767px) {
        .fk-detail-title {
            font-size: 26px;
        }
    }
</style>
@endsection

@section('breadcrumb')
@php
    $jenisRaw = strtolower(trim($blog->jenis ?? ''));
    if (in_array($jenisRaw, ['laznews', 'kegiatan', 'news', 'berita'])) {
        $bannerHtml = 'LAZ <span class="font-banner">News</span>';
    } elseif (in_array($jenisRaw, ['lazjourney', 'journey'])) {
        $bannerHtml = 'LAZ <span class="font-banner">Journey</span>';
    } elseif (in_array($jenisRaw, ['lazsalam', 'salam', 'edukasi'])) {
        $bannerHtml = 'LAZ <span class="font-banner">Salam</span>';
    } elseif (!empty($blog->kategori) && strtolower($blog->kategori) !== 'uncategorized') {
        $bannerHtml = e($blog->kategori);
    } else {
        $bannerHtml = 'Kabar <span class="font-banner">LAZ</span>';
    }
@endphp
<h2>{!! $bannerHtml !!}</h2>
@endsection

@section('pageBlog')
@php
    $getCleanImageUrl = function($rawPath) {
        if (empty($rawPath)) return asset('website/assets/images/blog/news-1-1.jpg');
        $clean = ltrim(str_replace('\\', '/', $rawPath), '/');
        return asset(implode('/', array_map('rawurlencode', explode('/', $clean))));
    };
@endphp

<section class="fk-detail-section">
    <div class="container fk-detail-container">
        @if(isset($blog) && $blog)
            {{-- CENTERED HEADER BLOCK --}}
            <div class="fk-detail-header">
                <span class="fk-detail-badge">{{ strtoupper($blog->jenis ?: ($blog->kategori ?: 'KABAR GDI')) }}</span>
                <h1 class="fk-detail-title">{{ $blog->title }}</h1>
                <div class="fk-detail-date">
                    {{ date('F j, Y', strtotime($blog->date_publish ?? $blog->created_at)) }}
                </div>
            </div>

            {{-- 2-COLUMN ASYMMETRIC SPLIT --}}
            <div class="row g-5">
                {{-- LEFT COLUMN: FEATURED IMAGE + ARTICLE CONTENT --}}
                <div class="col-lg-8">
                    <img src="{{ $getCleanImageUrl($blog->featured_img) }}" alt="{{ $blog->title }}" class="fk-detail-featured-img">

                    <div class="fk-detail-content">
                        {!! $blog->content !!}
                    </div>

                    {{-- Previous / Other Post Block --}}
                    @if(@$blogLatest && count($blogLatest) > 0)
                        @php $prevPost = $blogLatest->where('id', '!=', $blog->id)->first(); @endphp
                        @if($prevPost)
                        <div class="fk-prev-post">
                            <div class="fk-prev-post__thumb">
                                <a href="/blog/{{ $prevPost->slug }}">
                                    <img src="{{ $getCleanImageUrl($prevPost->featured_img) }}" alt="{{ $prevPost->title }}">
                                </a>
                            </div>
                            <div>
                                <div class="fk-prev-post__label">Baca Juga</div>
                                <h4 class="fk-prev-post__title">
                                    <a href="/blog/{{ $prevPost->slug }}">{{ $prevPost->title }}</a>
                                </h4>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>

                {{-- RIGHT COLUMN: SIDEBAR --}}
                <div class="col-lg-4">
                    {{-- "Something Fresh" Overlay Cards (tampil hingga 3 artikel terbaru) --}}
                    @if(@$blogLatest && count($blogLatest) > 0)
                        @php
                            $freshPosts = $blogLatest->where('id', '!=', $blog->id)->take(3);
                            if ($freshPosts->isEmpty()) {
                                $freshPosts = $blogLatest->take(3);
                            }
                        @endphp
                        <div class="fk-sidebar-block">
                            <h4 class="fk-sidebar-heading">Something Fresh</h4>
                            @foreach($freshPosts as $freshPost)
                            <div class="fk-fresh-card">
                                <span class="fk-fresh-card__badge">{{ strtoupper($freshPost->jenis ?: ($freshPost->kategori ?: 'TERBARU')) }}</span>
                                <img src="{{ $getCleanImageUrl($freshPost->featured_img) }}" alt="{{ $freshPost->title }}">
                                <div class="fk-fresh-card__overlay"></div>
                                <div class="fk-fresh-card__body">
                                    <h5 class="fk-fresh-card__title">
                                        <a href="/blog/{{ $freshPost->slug }}">{{ $freshPost->title }}</a>
                                    </h5>
                                    <div class="fk-fresh-card__date">
                                        {{ date('F j, Y', strtotime($freshPost->date_publish ?? $freshPost->created_at)) }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        @else
            <div class="text-center py-5">
                <h4 class="text-white mb-2">Artikel tidak ditemukan</h4>
                <a href="/blog" class="btn btn-outline-light mt-2">Kembali ke Kabar LAZ</a>
            </div>
        @endif
    </div>
</section>
@endsection
