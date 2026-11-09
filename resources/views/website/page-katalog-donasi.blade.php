@extends('layout.layout-page')
@section('title', 'Pilih Program Kebaikan - LAZ Graha Dhuafa Indonesia')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .btn-donasi-card {
        border: 1.5px solid #0d5c38;
        color: #0d5c38;
        background-color: transparent;
        transition: all 0.25s ease;
    }

    .btn-donasi-card:hover {
        background-color: #00885a !important;
        border-color: #00885a !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 92, 56, 0.25);
    }

    .btn-donasi-card:hover i {
        transform: translateX(4px);
        transition: transform 0.4s ease;
    }

    .donasi-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #edf2f7;
        background: #ffffff;
    }
    .donasi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08) !important;
    }
    .donasi-card__img-wrapper {
        position: relative;
        aspect-ratio: 16/9;
        overflow: hidden;
        background: #e2e8f0;
    }
    .donasi-card__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .donasi-card:hover .donasi-card__img {
        transform: scale(1.04);
    }
    .donasi-card__category {
        position: absolute;
        top: 12px;
        left: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-radius: 20px;
        padding: 5px 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }
    .donasi-card__title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1a202c;
        line-height: 1.45;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 46px;
    }
    .donasi-card__organizer {
        font-size: 0.8rem;
        color: #718096;
    }
    .donasi-card__progress {
        height: 7px;
        border-radius: 10px;
        background-color: #edf2f7;
    }
    .donasi-card__progress-bar {
        background: linear-gradient(90deg, #00C89D 0%, #0d5c38 100%);
        border-radius: 10px;
        transition: width 0.6s ease;
    }
    .category-filter-btn {
        border-radius: 30px;
        padding: 8px 20px;
        font-size: 0.9rem;
        font-weight: 600;
        color: #4a5568;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
    }
    .category-filter-btn i {
        margin-right: 6px;
        font-size: 1rem;
        line-height: 1;
        transition: color 0.2s ease;
    }
    .category-filter-btn:hover, .category-filter-btn.active {
        background: #0d5c38;
        color: #ffffff !important;
        border-color: #0d5c38;
        box-shadow: 0 4px 12px rgba(13, 92, 56, 0.25);
    }
    .category-filter-btn:hover i, .category-filter-btn.active i {
        color: #ffffff !important;
    }
    .filter-scroll-wrapper {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 8px;
        -webkit-overflow-scrolling: touch;
    }
    .filter-scroll-wrapper::-webkit-scrollbar {
        height: 4px;
    }
    .filter-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }
</style>
@endpush

@section('breadcrumb')
<div class="text-center">
    <ul class="thm-breadcrumb list-unstyled">
        <li><a href="/">Beranda</a></li>
        <li><span>/</span></li>
        <li>Katalog Donasi</li>
    </ul>
    <h2>Satu Bantuan, Sejuta Harapan.</h2>
    <p class="text-white-50 mt-2 mb-0" style="max-width: 650px; margin: 0 auto; font-size: 0.95rem;">
        Sedikit uluran tanganmu adalah napas baru bagi mereka. Salurkan kepedulian sekarang!
    </p>
</div>
@endsection

@section('content')
<section class="py-5" style="background-color: #f7fafc;">
    <div class="container">

        <!-- Kategori Filter Tabs -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-dark">Kategori Donasi</h5>
            </div>
            <div class="filter-scroll-wrapper">
                <a href="{{ route('donasi.index', ['kategori' => 'semua']) }}" 
                   class="category-filter-btn {{ $currentCategory == 'semua' ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i> Semua Donasi
                </a>
                <a href="{{ route('donasi.index', ['kategori' => 'bencana-alam']) }}" 
                   class="category-filter-btn {{ $currentCategory == 'bencana-alam' ? 'active' : '' }}">
                    <i class="bi bi-globe-americas"></i> Bencana Alam
                </a>
                <a href="{{ route('donasi.index', ['kategori' => 'medis']) }}" 
                   class="category-filter-btn {{ $currentCategory == 'medis' ? 'active' : '' }}">
                    <i class="bi bi-heart-pulse-fill text-danger"></i> Bantuan Medis
                </a>
                <a href="{{ route('donasi.index', ['kategori' => 'yatim-dhuafa']) }}" 
                   class="category-filter-btn {{ $currentCategory == 'yatim-dhuafa' ? 'active' : '' }}">
                    <i class="bi bi-people-fill text-primary"></i> Yatim & Dhuafa
                </a>
                <a href="{{ route('donasi.index', ['kategori' => 'infrastruktur']) }}" 
                   class="category-filter-btn {{ $currentCategory == 'infrastruktur' ? 'active' : '' }}">
                    <i class="bi bi-droplet-fill text-info"></i> Wakaf & Air Bersih
                </a>
                <a href="{{ route('donasi.index', ['kategori' => 'pendidikan']) }}" 
                   class="category-filter-btn {{ $currentCategory == 'pendidikan' ? 'active' : '' }}">
                    <i class="bi bi-mortarboard-fill text-warning"></i> Pendidikan
                </a>
            </div>
        </div>

        <!-- Grid Kartu Donasi -->
        <div class="row g-4">
            @forelse($campaigns as $item)
                @php
                    $percent = min(100, round(($item['collected'] / $item['target']) * 100));
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="card donasi-card h-100 shadow-sm">
                        <!-- Gambar Cover -->
                        <div class="donasi-card__img-wrapper position-relative">
                            <img src="{{ asset($item['image']) }}" 
                                 alt="{{ $item['title'] }}" 
                                 class="donasi-card__img"
                                 onerror="this.src='{{ asset('website/assets/images/backgrounds/main-slider-2-1.jpg') }}'">
                            @if(($item['status'] ?? 'active') === 'takedown')
                                <span class="badge bg-dark bg-opacity-75 text-white position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm fw-bold" style="font-size: 0.75rem;">
                                    <i class="bi bi-check2-circle me-1 text-warning"></i> Selesai / Ditutup
                                </span>
                            @endif
                        </div>

                        <!-- Konten Card -->
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <h3 class="donasi-card__title mb-2" title="{{ $item['title'] }}">
                                    <a href="{{ route('donasi.detail', $item['slug']) }}" class="text-decoration-none text-dark">
                                        {{ $item['title'] }}
                                    </a>
                                </h3>

                                <!-- Penggalang Dana Terverifikasi -->
                                <div class="donasi-card__organizer d-flex align-items-center mb-3">
                                    <span class="text-truncate">{{ $item['organizer'] }}</span>
                                    <i class="bi bi-patch-check-fill text-primary ms-1" title="Terverifikasi"></i>
                                </div>
                            </div>

                            <div>
                                <!-- Progress Bar Kitabisa -->
                                <div class="progress donasi-card__progress mb-2">
                                    <div class="progress-bar donasi-card__progress-bar" 
                                         role="progressbar" 
                                         style="width: {{ $percent }}%;" 
                                         aria-valuenow="{{ $percent }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100"></div>
                                </div>

                                <!-- Statistik Dana & Sisa Hari -->
                                <div class="d-flex justify-content-between align-items-end mb-3">
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 0.78rem;">Terkumpul</small>
                                        <strong class="text-dark" style="font-size: 0.95rem;">Rp {{ number_format($item['collected'], 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block" style="font-size: 0.78rem;">Sisa Hari</small>
                                        <strong class="text-muted" style="font-size: 0.85rem;">{{ $item['days_left'] }} Hari</strong>
                                    </div>
                                </div>

                                <!-- Tombol Donasi Cepat -->
                                @if(($item['status'] ?? 'active') === 'takedown')
                                    <a href="{{ route('donasi.detail', $item['slug']) }}" 
                                       class="btn btn-secondary w-100 rounded-pill py-2 fw-semibold d-flex justify-content-center align-items-center opacity-75">
                                        <i class="bi bi-lock-fill me-1"></i> Donasi Telah Ditutup
                                    </a>
                                @else
                                    <a href="{{ route('donasi.detail', $item['slug']) }}" 
                                    class="btn btn-donasi-card w-100 rounded-pill py-2 fw-bold d-flex justify-content-center align-items-center">
                                    <span>Donasi Sekarang</span>
                                    <i class="bi bi-arrow-right-short fs-4 ms-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <h5 class="fw-bold mt-3 text-secondary">Belum ada campaign untuk kategori ini</h5>
                    <p class="text-muted small">Silakan pilih kategori lainnya atau kembali ke semua campaign.</p>
                    <a href="{{ route('donasi.index', ['kategori' => 'semua']) }}" class="btn btn-success rounded-pill px-4">
                        Lihat Semua Kebaikan
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</section>
@endsection

