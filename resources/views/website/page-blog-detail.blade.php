@extends('layout.layout-page')
@section('title', $pageTitle)

@section('style')
<style>
    :root {
        --color-primary: #014D34;
        --color-primary-light: #028A5F;
        --color-accent: #E89C3D;
        --color-bg: #F9F9F9;
        --color-text: #333333;
        --color-muted: #666666;
        --card-shadow: rgba(0, 0, 0, 0.08);
        --card-shadow-hover: rgba(0, 0, 0, 0.15);
    }
    body {
        background-color: var(--color-bg);
        color: var(--color-text);
    }
    .blog-detail-section {
        padding: 80px 0;
    }

    .blog-detail__featured-image {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 16px;
        margin-bottom: 35px;
        box-shadow: 0 8px 28px var(--card-shadow);
    }

    .blog-detail__header {
        margin-bottom: 40px;
    }
    .blog-detail__category {
        display: inline-block;
        color: white;
        background: var(--color-accent);
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 18px;
        padding: 8px 18px;
        border-radius: 6px;
    }
    .blog-detail__title {
        font-size: 38px;
        font-weight: 700;
        margin-bottom: 22px;
        line-height: 1.3;
        color: var(--color-text);
    }
    .blog-detail__meta {
        display: flex;
        align-items: center;
        gap: 24px;
        font-size: 15px;
        color: var(--color-muted);
        margin-bottom: 35px;
        padding-bottom: 25px;
        border-bottom: 2px solid #e5e5e5;
    }
    .blog-detail__meta i {
        color: var(--color-primary);
        margin-right: 8px;
    }

    .blog-detail__content {
        font-size: 17px;
        line-height: 1.9;
        color: var(--color-text);
        margin-bottom: 50px;
    }
    .blog-detail__content h2,
    .blog-detail__content h3,
    .blog-detail__content h4 {
        color: var(--color-primary);
        margin-top: 35px;
        margin-bottom: 18px;
        font-weight: 700;
    }
    .blog-detail__content h2 {
        font-size: 30px;
    }
    .blog-detail__content h3 {
        font-size: 24px;
    }
    .blog-detail__content h4 {
        font-size: 20px;
    }
    .blog-detail__content p {
        margin-bottom: 22px;
    }
    .blog-detail__content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 28px 0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    .blog-detail__content ul,
    .blog-detail__content ol {
        margin: 20px 0;
        padding-left: 30px;
    }
    .blog-detail__content li {
        margin-bottom: 10px;
    }
    .blog-detail__content blockquote {
        border-left: 4px solid var(--color-accent);
        padding: 20px 25px;
        margin: 28px 0;
        background: #f8f8f8;
        border-radius: 0 8px 8px 0;
        font-style: italic;
        color: var(--color-muted);
    }

    /* SIDEBAR */
    .sidebar-section {
        position: sticky;
        top: 100px;
    }

    .sidebar-widget {
        background: white;
        border-radius: 12px;
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 2px 12px var(--card-shadow);
    }
    .sidebar-widget__title {
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 22px;
        padding-bottom: 12px;
        border-bottom: 3px solid var(--color-accent);
        color: var(--color-text);
    }

    .search-form {
        position: relative;
    }
    .search-form input {
        width: 100%;
        padding: 14px 50px 14px 18px;
        border: 2px solid #e5e5e5;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .search-form input:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(1, 77, 52, 0.1);
    }
    .search-form button {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 50px;
        border: none;
        background: var(--color-primary);
        color: white;
        border-radius: 0 8px 8px 0;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    .search-form button:hover {
        background: var(--color-primary-light);
    }

    .latest-post-item {
        display: flex;
        gap: 14px;
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid #f0f0f0;
    }
    .latest-post-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .latest-post-item__image {
        flex-shrink: 0;
        width: 75px;
        height: 75px;
        border-radius: 8px;
        overflow: hidden;
    }
    .latest-post-item__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .latest-post-item:hover .latest-post-item__image img {
        transform: scale(1.1);
    }
    .latest-post-item__content {
        flex: 1;
    }
    .latest-post-item__content h4 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 6px;
        line-height: 1.4;
    }
    .latest-post-item__content h4 a {
        color: var(--color-text);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .latest-post-item__content h4 a:hover {
        color: var(--color-primary);
    }
    .latest-post-item__meta {
        color: var(--color-muted);
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .latest-post-item__meta i {
        color: var(--color-accent);
        font-size: 11px;
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .category-list li {
        margin-bottom: 8px;
    }
    .category-list li:last-child {
        margin-bottom: 0;
    }
    .category-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--color-text);
        text-decoration: none;
        padding: 11px 14px;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 14px;
        border: 1px solid transparent;
    }
    .category-list a:hover,
    .category-list li.active a {
        background: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
        transform: translateX(4px);
    }
    .category-list .count {
        background: #f0f0f0;
        padding: 3px 9px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        color: var(--color-muted);
    }
    .category-list a:hover .count,
    .category-list li.active a .count {
        background: rgba(255,255,255,0.25);
        color: white;
    }

    .widget-empty-state {
        text-align: center;
        padding: 20px;
        color: var(--color-muted);
        font-size: 13px;
    }

    .no-posts-alert {
        background: #fff3cd;
        border: 1px solid #ffe8a1;
        color: #856404;
        padding: 50px 30px;
        border-radius: 12px;
        text-align: center;
        font-size: 16px;
    }
    .no-posts-alert i {
        font-size: 52px;
        margin-bottom: 18px;
        display: block;
        opacity: 0.6;
    }

    @media (max-width: 991px) {
        .blog-detail__title {
            font-size: 30px;
        }
        .blog-detail__featured-image {
            height: 350px;
        }
    }
</style>
@endsection

@section('breadcrumb')
<ul class="thm-breadcrumb list-unstyled">
    <li><a href="/">Beranda</a></li>
    <li><span>/</span></li>
    <li><a href="/blog">Blog</a></li>
    <li><span>/</span></li>
    <li class="active"><span>{{ $pageTitle }}</span></li>
</ul>
<h2>{{ $pageTitle }}</h2>
@endsection

@section('pageBlog')
<section class="blog-detail-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @if(isset($blog) && $blog)
                    {{-- Featured Image --}}
                    <img src="{{ $blog->featured_img ? asset($blog->featured_img) : 'https://picsum.photos/1200/600?random=' . $blog->id }}" alt="{{ $blog->title }}" class="blog-detail__featured-image">

                    {{-- Header --}}
                    <div class="blog-detail__header">
                        <span class="blog-detail__category">{{ $blog->kategori ?? 'BERITA' }}</span>
                        <h1 class="blog-detail__title">{{ $blog->title }}</h1>
                        <div class="blog-detail__meta">
                            <span><i class="fas fa-user-circle"></i> {{ $blog->author }}</span>
                            <span><i class="fas fa-calendar-alt"></i> {{ App\Helper::dateFormat(date('Y-m-d', strtotime($blog->date_publish))) }}</span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="blog-detail__content">
                        {!! $blog->content !!}
                    </div>
                @else
                    <div class="no-posts-alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p style="margin: 0; font-weight: 600;">Artikel tidak ditemukan</p>
                    </div>
                @endif
            </div>

            <div class="col-lg-3">
                <div class="sidebar-section">
                    {{-- Widget Pencarian --}}
                    <div class="sidebar-widget">
                        <h3 class="sidebar-widget__title">Cari Artikel</h3>
                        <form action="/blog" method="GET" class="search-form">
                            <input type="search" name="search" placeholder="Cari artikel..." value="{{ request('search') }}">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    {{-- Widget Artikel Terbaru --}}
                    <div class="sidebar-widget">
                        <h3 class="sidebar-widget__title">Artikel Terbaru</h3>
                        @if(@$blogLatest && count($blogLatest) > 0)
                            @php $no = 1; @endphp
                            @foreach($blogLatest as $dt)
                                @php
                                    $tanggal = App\Helper::dateFormat(date('Y-m-d', strtotime($dt->date_publish)));
                                @endphp
                                <div class="latest-post-item">
                                    <div class="latest-post-item__image">
                                        <img src="{{ $dt->featured_img ? asset($dt->featured_img) : 'https://picsum.photos/80/80?random=' . $dt->id }}" alt="{{ $dt->title }}">
                                    </div>
                                    <div class="latest-post-item__content">
                                        <h4><a href="/blog/{{ $dt->slug }}">{{ Str::limit($dt->title, 50) }}</a></h4>
                                        <div class="latest-post-item__meta">
                                            <i class="fas fa-calendar-alt"></i> {{ date('d M, Y', strtotime($dt->date_publish)) }}
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $no++;
                                    if($no > 4) break;
                                @endphp
                            @endforeach
                        @else
                            <p class="widget-empty-state">Belum ada artikel terbaru</p>
                        @endif
                    </div>

                    {{-- Widget Kategori --}}
                    <div class="sidebar-widget">
                        <h3 class="sidebar-widget__title">Kategori</h3>
                        @if(@$category)
                            <ul class="category-list">
                                <li class="{{ !isset($categoryKey) || $categoryKey == '' ? 'active' : ''}}">
                                    <a href="/blog">
                                        <span>Semua Artikel</span>
                                        <span class="count">{{ $totalAllPosts ?? 0 }}</span>
                                    </a>
                                </li>
                                @foreach($category as $cat)
                                <li class="{{ @$categoryKey == $cat->kategori ? 'active' : ''}}">
                                    <a href="/blog/category/{{ $cat->kategori }}">
                                        <span>{{ $cat->kategori }}</span>
                                        <span class="count">{{ $cat->total ?? 0 }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    {{-- Widget Berita Realisasi --}}
                    <div class="sidebar-widget">
                        <h3 class="sidebar-widget__title">Berita Realisasi</h3>
                        @if(@$blogRealisasi && count($blogRealisasi) > 0)
                            @foreach($blogRealisasi->take(3) as $dt)
                            @php
                                $tanggal = App\Helper::dateFormat(date('Y-m-d', strtotime($dt->date_publish)));
                            @endphp
                            <div class="latest-post-item">
                                <div class="latest-post-item__image">
                                    <img src="{{ $dt->featured_img ? asset($dt->featured_img) : 'https://picsum.photos/80/80?random=' . $dt->id }}" alt="{{ $dt->title }}">
                                </div>
                                <div class="latest-post-item__content">
                                    <h4><a href="/blog/{{ $dt->slug }}">{{ Str::limit($dt->title, 50) }}</a></h4>
                                    <div class="latest-post-item__meta">
                                        <i class="fas fa-calendar-alt"></i> {{ date('d M, Y', strtotime($dt->date_publish)) }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="widget-empty-state">Belum ada berita realisasi</p>
                        @endif
                    </div>

                    {{-- Widget Salam Dewan Syariah --}}
                    <div class="sidebar-widget">
                        <h3 class="sidebar-widget__title">Salam Dewan Syariah</h3>
                        @if(@$blogDewanSyariah && count($blogDewanSyariah) > 0)
                            @foreach($blogDewanSyariah->take(3) as $dt)
                            @php
                                $tanggal = App\Helper::dateFormat(date('Y-m-d', strtotime($dt->date_publish)));
                            @endphp
                            <div class="latest-post-item">
                                <div class="latest-post-item__image">
                                    <img src="{{ $dt->featured_img ? asset($dt->featured_img) : 'https://picsum.photos/80/80?random=' . $dt->id }}" alt="{{ $dt->title }}">
                                </div>
                                <div class="latest-post-item__content">
                                    <h4><a href="/blog/{{ $dt->slug }}">{{ Str::limit($dt->title, 50) }}</a></h4>
                                    <div class="latest-post-item__meta">
                                        <i class="fas fa-calendar-alt"></i> {{ date('d M, Y', strtotime($dt->date_publish)) }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="widget-empty-state">Belum ada salam dari dewan syariah</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection