@extends('layout.layout-page')
@section('title', $pageTitle)

@section('style')
<style>
    /* ==========================================================
       EDITORIAL MAGAZINE LIST (INSPIRASI FOLKATIVE + TEMA GDI)
       Dipakai untuk LAZNews, LAZJourney, dan LAZSalam
       ========================================================== */
    .fk-editorial-section {
        background: #ffffff;
        color: #1e293b;
        padding: 45px 0 85px 0;
    }

    .fk-container {
        max-width: 1180px;
    }

    /* TOP HERO FEATURED BANNER (CENTERED) */
    .fk-hero-banner {
        position: relative;
        height: 410px;
        overflow: hidden;
        margin-bottom: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: #04120d;
        border: 1px solid #e2e8f0;
    }

    .fk-hero-banner__img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
        z-index: 1;
    }

    .fk-hero-banner:hover .fk-hero-banner__img {
        transform: scale(1.04);
    }

    .fk-hero-banner__overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(4, 18, 13, 0.55) 0%,
            rgba(4, 18, 13, 0.82) 100%
        );
        z-index: 2;
    }

    .fk-hero-banner__content {
        position: relative;
        z-index: 3;
        max-width: 760px;
        padding: 0 24px;
    }

    .fk-hero-pill {
        display: inline-block;
        background: #04120d;
        color: #2dd4a7;
        border: 1px solid rgba(45, 212, 167, 0.45);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        padding: 5px 14px;
        margin-bottom: 16px;
    }

    .fk-hero-title {
        font-size: 36px;
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
        margin-bottom: 14px;
    }

    .fk-hero-title a {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.25s ease;
    }

    .fk-hero-title a:hover {
        color: #7ef0c0;
    }

    .fk-hero-date {
        font-size: 13px;
        color: #cbd5e1;
        letter-spacing: 0.5px;
    }

    /* HORIZONTAL SPLIT CARDS (LEFT COLUMN) */
    .fk-article-list {
        display: flex;
        flex-direction: column;
        gap: 36px;
    }

    .fk-article-card {
        display: flex;
        gap: 28px;
        align-items: center;
        background: transparent;
    }

    .fk-article-card__thumb {
        width: 45%;
        flex-shrink: 0;
        aspect-ratio: 4 / 3;
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
    }

    .fk-article-card__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .fk-article-card:hover .fk-article-card__thumb img {
        transform: scale(1.05);
    }

    .fk-article-card__badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #00875A;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 4px 10px;
        z-index: 2;
    }

    .fk-article-card__body {
        flex: 1;
        min-width: 0;
    }

    .fk-article-card__title {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.32;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .fk-article-card__title a {
        color: #0f172a;
        text-decoration: none;
        transition: color 0.25s ease;
    }

    .fk-article-card__title a:hover {
        color: #00875A;
    }

    .fk-article-card__date {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 12px;
    }

    .fk-article-card__excerpt {
        font-size: 14px;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .fk-readmore-btn {
        display: inline-block;
        background: #06301f;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 9px 18px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .fk-readmore-btn:hover {
        background: #00875A;
        color: #ffffff;
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
        color: #0f172a;
        padding-bottom: 10px;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 16px;
    }

    /* Search box */
    .fk-search-form {
        display: flex;
    }

    .fk-search-form input {
        flex: 1;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        padding: 10px 14px;
        font-size: 13.5px;
    }

    .fk-search-form input:focus {
        outline: none;
        border-color: #00875A;
    }

    .fk-search-form button {
        background: #00875A;
        color: #ffffff;
        border: none;
        padding: 0 16px;
        font-weight: 700;
        cursor: pointer;
    }

    /* Stacked Categories List (Folkative style) */
    .fk-cat-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .fk-cat-list li {
        border-bottom: 1px solid #e2e8f0;
    }

    .fk-cat-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: #f8fafc;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        text-decoration: none;
        transition: background 0.25s ease, color 0.25s ease;
    }

    .fk-cat-list a:hover {
        background: #00875A;
        color: #ffffff;
    }

    .fk-cat-list li.active a {
        background: #00875A;
        color: #ffffff;
    }

    /* Sidebar Popular / Latest */
    .fk-popular-item {
        display: flex;
        gap: 14px;
        align-items: center;
        margin-bottom: 16px;
    }

    .fk-popular-item__thumb {
        width: 78px;
        height: 60px;
        flex-shrink: 0;
        overflow: hidden;
        background: #f1f5f9;
    }

    .fk-popular-item__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .fk-popular-item__title {
        font-size: 13.5px;
        font-weight: 700;
        line-height: 1.35;
        margin-bottom: 4px;
    }

    .fk-popular-item__title a {
        color: #0f172a;
        text-decoration: none;
    }

    .fk-popular-item__title a:hover {
        color: #00875A;
    }

    .fk-popular-item__date {
        font-size: 11px;
        color: #64748b;
    }

    /* Pagination */
    .fk-pagination {
        display: flex;
        gap: 6px;
        margin-top: 45px;
    }

    .fk-pagination a,
    .fk-pagination span {
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .fk-pagination .active {
        background: #00875A;
        border-color: #00875A;
        color: #ffffff;
    }

    .fk-pagination .disabled {
        opacity: 0.35;
        pointer-events: none;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .fk-hero-banner {
            height: 320px;
        }
        .fk-hero-title {
            font-size: 24px;
        }
        .fk-article-card {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
        }
        .fk-article-card__thumb {
            width: 100%;
        }
    }
</style>
@endsection

@php
    $jenisMetaMap = [
        'LAZNews' => [
            'bread' => 'LAZNews',
            'banner_first' => 'LAZ',
            'banner_second' => 'News',
            'slug' => 'laznews',
            'empty_title' => 'Belum ada berita LAZNews',
        ],
        'LAZJourney' => [
            'bread' => 'LAZJourney',
            'banner_first' => 'LAZ',
            'banner_second' => 'Journey',
            'slug' => 'lazjourney',
            'empty_title' => 'Belum ada catatan LAZJourney',
        ],
        'LAZSalam' => [
            'bread' => 'LAZSalam',
            'banner_first' => 'LAZ',
            'banner_second' => 'Salam',
            'slug' => 'lazsalam',
            'empty_title' => 'Belum ada artikel LAZSalam',
        ],
    ];
    $currentMeta = $jenisMetaMap[@$jenisLabel] ?? $jenisMetaMap['LAZJourney'];

    $getCleanImageUrl = function($rawPath) {
        if (empty($rawPath)) return asset('website/assets/images/blog/news-1-1.jpg');
        $clean = ltrim(str_replace('\\', '/', $rawPath), '/');
        return asset(implode('/', array_map('rawurlencode', explode('/', $clean))));
    };
@endphp

@section('breadcrumb')
<h2>{{ $currentMeta['banner_first'] }} <span class="font-banner">{{ $currentMeta['banner_second'] }}</span></h2>
@endsection

@section('pageBlog')
<section class="fk-editorial-section">
    <div class="container fk-container">
        @if(@$blog && count($blog) > 0)
            @php
                $heroPost = $blog->first();
                $listPosts = $blog;
            @endphp

            {{-- 2-COLUMN ASYMMETRIC SPLIT --}}
            <div class="row g-5">
                {{-- LEFT COLUMN: HORIZONTAL SPLIT CARDS STACK --}}
                <div class="col-lg-8">
                    <div class="fk-article-list">
                        @foreach($listPosts as $item)
                        <article class="fk-article-card">
                            <div class="fk-article-card__thumb">
                                <span class="fk-article-card__badge">{{ strtoupper($item->kategori ?: $currentMeta['bread']) }}</span>
                                <a href="/blog/{{ $item->slug }}">
                                    <img src="{{ $getCleanImageUrl($item->featured_img) }}" alt="{{ $item->title }}">
                                </a>
                            </div>
                            <div class="fk-article-card__body">
                                <h3 class="fk-article-card__title">
                                    <a href="/blog/{{ $item->slug }}">{{ $item->title }}</a>
                                </h3>
                                <div class="fk-article-card__date">
                                    {{ date('F j, Y', strtotime($item->date_publish ?? $item->created_at)) }}
                                </div>
                                <p class="fk-article-card__excerpt">
                                    {{ Str::limit(strip_tags($item->content), 115) }}
                                </p>
                                <a href="/blog/{{ $item->slug }}" class="fk-readmore-btn">Read More</a>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($blog instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $blog->lastPage() > 1)
                    <div class="fk-pagination">
                        <a href="{{ $blog->previousPageUrl() }}" class="{{ $blog->onFirstPage() ? 'disabled' : '' }}">&laquo;</a>
                        @for($p = 1; $p <= $blog->lastPage(); $p++)
                            @if($p == $blog->currentPage())
                                <span class="active">{{ $p }}</span>
                            @else
                                <a href="{{ $blog->url($p) }}">{{ $p }}</a>
                            @endif
                        @endfor
                        <a href="{{ $blog->nextPageUrl() }}" class="{{ $blog->hasMorePages() ? '' : 'disabled' }}">&raquo;</a>
                    </div>
                    @endif
                </div>

                {{-- RIGHT COLUMN: SIDEBAR --}}
                <div class="col-lg-4">

                    {{-- Popular / Latest Posts --}}
                    @if(@$blogLatest && count($blogLatest) > 0)
                    <div class="fk-sidebar-block">
                        <h4 class="fk-sidebar-heading">Latest Posts</h4>
                        @foreach($blogLatest->take(4) as $lp)
                        <div class="fk-popular-item">
                            <div class="fk-popular-item__thumb">
                                <a href="/blog/{{ $lp->slug }}">
                                    <img src="{{ $getCleanImageUrl($lp->featured_img) }}" alt="{{ $lp->title }}">
                                </a>
                            </div>
                            <div>
                                <h5 class="fk-popular-item__title">
                                    <a href="/blog/{{ $lp->slug }}">{{ Str::limit($lp->title, 52) }}</a>
                                </h5>
                                <div class="fk-popular-item__date">{{ date('M j, Y', strtotime($lp->date_publish ?? $lp->created_at)) }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <h4 class="text-dark mb-2">{{ $currentMeta['empty_title'] }}</h4>
                <p class="text-muted">Belum ada artikel yang dipublikasikan pada kategori ini.</p>
            </div>
        @endif
    </div>
</section>
@endsection
