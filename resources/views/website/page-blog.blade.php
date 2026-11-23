@extends('layout.layout-page')
@section('title', $pageTitle)

@section('style')
<style>
    .blog-grid-section {
        padding: 80px 0;
        background: #f8f9fa;
    }
    
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .blog-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    
    .blog-card__image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    
    .blog-card__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .blog-card:hover .blog-card__image img {
        transform: scale(1.05);
    }
    
    .blog-card__date-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #1ab69d;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .blog-card__content {
        padding: 25px;
    }
    
    .blog-card__category {
        display: inline-block;
        color: #1ab69d;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }
    
    .blog-card__title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.4;
    }
    
    .blog-card__title a {
        color: #1e1e1e;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .blog-card__title a:hover {
        color: #1ab69d;
    }
    
    .blog-card__excerpt {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 0;
    }
    
    .sidebar-widget {
        background: white;
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .sidebar-widget__title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #1ab69d;
    }
    
    .search-form {
        position: relative;
    }
    
    .search-form input {
        width: 100%;
        padding: 12px 50px 12px 20px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .search-form button {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 50px;
        border: none;
        background: #1ab69d;
        color: white;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
    }
    
    .latest-post-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .latest-post-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .latest-post-item__image {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .latest-post-item__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .latest-post-item__content h4 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
        line-height: 1.4;
    }
    
    .latest-post-item__content h4 a {
        color: #1e1e1e;
        text-decoration: none;
    }
    
    .latest-post-item__content h4 a:hover {
        color: #1ab69d;
    }
    
    .latest-post-item__meta {
        color: #999;
        font-size: 12px;
    }
    
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .category-list li {
        margin-bottom: 12px;
    }
    
    .category-list li:last-child {
        margin-bottom: 0;
    }
    
    .category-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #666;
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    
    .category-list a:hover,
    .category-list li.active a {
        background: #1ab69d;
        color: white;
    }
    
    .category-list .count {
        background: #f0f0f0;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 12px;
    }
    
    .category-list a:hover .count,
    .category-list li.active a .count {
        background: rgba(255,255,255,0.2);
        color: white;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 50px;
    }
    
    .pagination-wrapper a,
    .pagination-wrapper span {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        color: #666;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .pagination-wrapper a:hover,
    .pagination-wrapper .active {
        background: #1ab69d;
        color: white;
        border-color: #1ab69d;
    }
    
    .pagination-wrapper .disabled {
        opacity: 0.45;
        pointer-events: none;
    }
    
    .pagination-wrapper .dots {
        display: flex;
        align-items: center;
        color: #666;
        font-weight: 600;
    }
</style>
@endsection

@section('breadcrumb')
<ul class="thm-breadcrumb list-unstyled">
    <li><a href="/">Beranda</a></li>
    @if(@$parent)
    <li><span>/</span></li>
    <li><a href="/blog">{{ @$parent }}</a></li>
    @endif
    <li><span>/</span></li>
    <li>{{ @$detail->title ? @$detail->title : $pageTitle }}</li>
</ul>
<h2>{!! preg_replace('/^LAZ\s*(.+)$/i', 'LAZ <span class="font-banner">$1</span>', @$detail->title ? @$detail->title : $pageTitle) !!}</h2>
@endsection

@section('pageBlog')
<section class="blog-grid-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if(@$blog)
                    <div class="blog-grid">
                        @foreach($blog as $dt)
                            @php
                                $date = App\Helper::dateFormat(date('Y-m-d', strtotime($dt->date_publish)));
                                $slug = '/blog/'.$dt->slug;
                            @endphp
                            <div class="blog-card">
                                <div class="blog-card__image">
                                    <img src="{{ asset($dt->featured_img) }}" alt="{{ $dt->title }}">
                                    <div class="blog-card__date-badge">
                                        {{ date('d M, Y', strtotime($dt->date_publish)) }}
                                    </div>
                                </div>
                                <div class="blog-card__content">
                                    <span class="blog-card__category">{{ $dt->kategori ?? 'UNCATEGORIZED' }}</span>
                                    <h3 class="blog-card__title">
                                        <a href="{{ $slug }}">{{ $dt->title }}</a>
                                    </h3>
                                    <p class="blog-card__excerpt">
                                        @php
                                            $text = strip_tags($dt->content);
                                            echo substr($text, 0, 100).'...';
                                        @endphp
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="pagination-wrapper">
                        {{-- Pagination asli dari Laravel paginator --}}
                        @if($blog instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $blog->lastPage() > 1)
                            @php
                                $qs = $_GET; $qs['page'] = null;
                                $urlPage = function ($p) use ($qs) {
                                    $q = array_filter($qs); $q['page'] = $p;
                                    return '?' . http_build_query($q);
                                };
                                $mulai = max(1, $blog->currentPage() - 2);
                                $akhir = min($blog->lastPage(), $mulai + 4);
                                $mulai = max(1, $akhir - 4);
                            @endphp
                            <a href="{{ $urlPage($blog->currentPage() - 1) }}"
                               class="{{ $blog->onFirstPage() ? 'disabled' : '' }}" aria-label="Sebelumnya">&laquo;</a>
                            @if($mulai > 1)
                                <a href="{{ $urlPage(1) }}">1</a>
                                <span class="dots">...</span>
                            @endif
                            @for($p = $mulai; $p <= $akhir; $p++)
                                @if($p == $blog->currentPage())
                                    <span class="active">{{ $p }}</span>
                                @else
                                    <a href="{{ $urlPage($p) }}">{{ $p }}</a>
                                @endif
                            @endfor
                            @if($akhir < $blog->lastPage())
                                <span class="dots">...</span>
                                <a href="{{ $urlPage($blog->lastPage()) }}">{{ $blog->lastPage() }}</a>
                            @endif
                            <a href="{{ $urlPage($blog->currentPage() + 1) }}"
                               class="{{ $blog->hasMorePages() ? '' : 'disabled' }}" aria-label="Berikutnya">&raquo;</a>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning">Kategori tidak ditemukan</div>
                @endif
            </div>
            
            <div class="col-lg-4">
                <div class="sidebar-widget">
                    <h3 class="sidebar-widget__title">Search</h3>
                    <form action="#" class="search-form">
                        <input type="search" placeholder="Search">
                        <button type="submit"><i class="icon-magnifying-glass"></i></button>
                    </form>
                </div>
                
                <div class="sidebar-widget">
                    <h3 class="sidebar-widget__title">Latest Post</h3>
                    @php
                        $latestBlog = @$blogLatest ? @$blogLatest : @$blog;
                    @endphp
                    @if(@$latestBlog)
                        @php $no = 1; @endphp
                        @foreach($latestBlog as $dt)
                            @php
                                $tanggal = App\Helper::dateFormat(date('Y-m-d', strtotime($dt->date_publish)));
                            @endphp
                            <div class="latest-post-item">
                                <div class="latest-post-item__image">
                                    <img src="{{ asset($dt->featured_img) }}" alt="{{ $dt->title }}">
                                </div>
                                <div class="latest-post-item__content">
                                    <div class="latest-post-item__meta">
                                        <i class="fas fa-clock"></i> {{ $tanggal }}
                                    </div>
                                    <h4><a href="/blog/{{ $dt->slug }}">{{ $dt->title }}</a></h4>
                                </div>
                            </div>
                            @php
                                $no += 1;
                                if($no == 4) break;
                            @endphp
                        @endforeach
                    @endif
                </div>
                
                <div class="sidebar-widget">
                    <h3 class="sidebar-widget__title">Categories</h3>
                    @if(@$category)
                        <ul class="category-list">
                            <li class="{{ @$categoryKey == 'Uncategorized' ? 'active' : ''}}">
                                <a href="/blog/category/Uncategorized">
                                    <span>Uncategorized</span>
                                    <span class="count">(0)</span>
                                </a>
                            </li>
                            @foreach($category as $cat)
                            <li class="{{ @$categoryKey == $cat->kategori ? 'active' : ''}}">
                                <a href="/blog/category/{{ $cat->kategori }}">
                                    <span>{{ $cat->kategori }}</span>
                                    <span class="count">({{ $cat->total ?? 0 }})</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
  const slides = document.querySelectorAll('.blog-slide');
  const buttons = document.querySelectorAll('.page-btn');

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      slides.forEach(s => s.classList.remove('active'));
      buttons.forEach(b => b.classList.remove('active'));

      const index = btn.getAttribute('data-index');
      slides[index].classList.add('active');
      btn.classList.add('active');
    });
  });
});
</script>
@endpush