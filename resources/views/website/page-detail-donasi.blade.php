@extends('layout.layout-page')
@section('title', $campaign['title'])

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .campaign-banner {
        width: 100%;
        border-radius: 20px;
        aspect-ratio: 16/9;
        object-fit: cover;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    .campaign-card-sticky {
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }
    .nominal-chip {
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 12px;
        padding: 10px 8px;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #2d3748;
    }
    .nominal-chip:hover {
        border-color: #00C89D;
        background: #f0fdf9;
    }
    .nominal-chip.active {
        border-color: #0d5c38;
        background: #0d5c38;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(13, 92, 56, 0.2);
    }
    .custom-nominal-input {
        font-size: 1.4rem;
        font-weight: 700;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 18px;
        color: #1a202c;
    }
    .custom-nominal-input:focus {
        border-color: #00C89D;
        box-shadow: 0 0 0 4px rgba(0, 200, 157, 0.15);
    }
    .progress-kitabisa {
        height: 10px;
        border-radius: 10px;
        background-color: #edf2f7;
    }
    .progress-bar-kitabisa {
        background: linear-gradient(90deg, #00C89D 0%, #0d5c38 100%);
        border-radius: 10px;
    }
    .story-content {
        line-height: 1.8;
        font-size: 1rem;
        color: #4a5568;
    }

    .story-content .lead {
        font-size: 1rem;
        font-weight: 400;
    }
    
    .story-content p {
        margin-bottom: 1.25rem;
    }
    .story-content ul, .story-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.25rem;
    }
    .story-content li {
        margin-bottom: 0.5rem;
    }
    .doa-card {
        background: #f8fafc;
        border-radius: 14px;
        padding: 16px;
        border: 1px solid #edf2f7;
        margin-bottom: 12px;
    }
</style>
@endpush

@section('breadcrumb')
<div class="text-center">
    <ul class="thm-breadcrumb list-unstyled">
        <li><a href="/">Beranda</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('donasi.index') }}">Katalog Donasi</a></li>
        <li><span>/</span></li>
        <li>{{ $campaign['category_label'] }}</li>
    </ul>
    <h2>Detail Musibah & Penggalangan Dana</h2>
</div>
@endsection

@section('content')
<section class="py-5" style="background-color: #f7fafc;">
    <div class="container">
        <div class="row g-4">

            <!-- ========================================== -->
            <!-- KOLOM KIRI: FOTO MUSIBAH & CERITA DETAIL   -->
            <!-- ========================================== -->
            <div class="col-lg-7">

                <!-- Foto Utama Musibah -->
                <div class="mb-4">
                    <img src="{{ asset($campaign['image']) }}" 
                         alt="{{ $campaign['title'] }}" 
                         class="campaign-banner"
                         onerror="this.src='{{ asset('website/assets/images/backgrounds/main-slider-2-1.jpg') }}'">
                </div>

                <!-- Judul Musibah & Badge -->
                <div class="mb-4">
                    <span class="badge {{ $campaign['category_badge'] }} px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                        {{ $campaign['category_label'] }}
                    </span>
                    <h2 class="fw-bold text-dark mt-2" style="line-height: 1.35; font-size: 1.85rem;">
                        {{ $campaign['title'] }}
                    </h2>

                    <!-- Penggalang & Lokasi -->
                    <div class="d-flex align-items-center gap-3 mt-3 text-muted small">
                        <div class="d-flex align-items-center">
                            <span class="fw-semibold text-dark">{{ $campaign['organizer'] }}</span>
                            <i class="bi bi-patch-check-fill text-primary ms-1" title="Penggalang Dana Terverifikasi"></i>
                        </div>
                        <span>&bull;</span>
                        <div><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $campaign['location'] }}</div>
                    </div>
                </div>

                <!-- Progress Bar Card di Tampilan Mobile & Tablet -->
                @php
                    $percent = min(100, round(($campaign['collected'] / $campaign['target']) * 100));
                @endphp
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <div>
                            <span class="text-muted small">Dana Terkumpul</span>
                            <h3 class="fw-bold text-success mb-0" style="color: #0d5c38 !important;">
                                Rp {{ number_format($campaign['collected'], 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>

                    <div class="progress progress-kitabisa my-3">
                        <div class="progress-bar progress-bar-kitabisa" 
                             role="progressbar" 
                             style="width: {{ $percent }}%;" 
                             aria-valuenow="{{ $percent }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100"></div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center text-muted small">
                        <div>Target: <strong class="text-dark">Rp {{ number_format($campaign['target'], 0, ',', '.') }}</strong></div>
                        <div><i class="bi bi-people-fill me-1 text-primary"></i><strong class="text-dark">{{ $campaign['donatur_count'] }}</strong> Donatur</div>
                        <div><i class="bi bi-clock-fill me-1 text-warning"></i><strong class="text-dark">{{ $campaign['days_left'] }}</strong> Hari Lagi</div>
                    </div>
                </div>

                <!-- Cerita Lengkap Musibah & Peristiwa -->
                <div class="card border-0 shadow-sm rounded-5 p-4 p-md-5 mb-4 bg-white">
                    <h5 class="fw-bold text-dark mb-4 pb-2 border- bottom">
                        <i class="bi bi-postcard-heart-fill me-2 text-success"></i>
                        Cerita Penggalangan Dana
                    </h5>
                    <div class="story-content">
                        {!! $campaign['story'] !!}
                    </div>
                </div>

                <!-- Doa & Dukungan Orang Baik -->
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="bi bi-chat-quote-fill text-success me-2"></i>Doa & Dukungan Donatur
                        </h4>
                       
                    </div>

                    <div class="doa-card">
                        <div class="d-flex justify-content-between mb-1">
                            <strong class="text-dark">Hamba Allah</strong>
                            <small class="text-muted">15 menit yang lalu</small>
                        </div>
                        <small class="text-success fw-bold d-block mb-2">Berdonasi Rp 100.000</small>
                        <p class="mb-0 text-muted small fst-italic">"Semoga para korban senantiasa diberikan ketabahan dan kekuatan menghadapi musibah ini. Amin ya rabbal alamin."</p>
                    </div>

                    <div class="doa-card">
                        <div class="d-flex justify-content-between mb-1">
                            <strong class="text-dark">Keluarga Tatang</strong>
                            <small class="text-muted">1 jam yang lalu</small>
                        </div>
                        <small class="text-success fw-bold d-block mb-2">Berdonasi Rp 250.000</small>
                        <p class="mb-0 text-muted small fst-italic">"Bismillah, sedikit rezeki semoga bermanfaat dan segera meringankan duka saudara-saudara kita."</p>
                    </div>

                    <div class="doa-card">
                        <div class="d-flex justify-content-between mb-1">
                            <strong class="text-dark">Sahabat Kebaikan</strong>
                            <small class="text-muted">3 jam yang lalu</small>
                        </div>
                        <small class="text-success fw-bold d-block mb-2">Berdonasi Rp 50.000</small>
                        <p class="mb-0 text-muted small fst-italic">"Semoga Allah membalas dengan kebaikan dan keselamatan bagi para relawan yang bertugas di lapangan."</p>
                    </div>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- KOLOM KANAN: KARTU RINGKASAN & ACTION DONASI-->
            <!-- ========================================== -->
            @php
                $isFull = ($campaign['collected'] >= $campaign['target']) || ($percent >= 100);
                $isTakedown = (($campaign['status'] ?? 'active') === 'takedown');
                $isClosed = $isFull || $isTakedown;
            @endphp
            <div class="col-lg-5">
                <div class="card campaign-card-sticky p-4 p-md-4 border-0 shadow-sm rounded-4 bg-white" id="actionDonasiCard">


                    <!-- Judul Singkat Card -->
                    <h5 class="fw-bold text-dark mb-3" style="line-height: 1.4;">
                        {{ $campaign['title'] }}
                    </h5>

                    <!-- Info Dana & Progress Bar -->
                    <div class="p-3 bg-light rounded-4 mb-3 border">
                        <div class="d-flex justify-content-between align-items-baseline mb-1">
                            <span class="text-muted small">Dana Terkumpul</span>
                            <span class="fw-bold fs-6 {{ $isFull ? 'text-success' : 'text-primary' }}">{{ $percent }}%</span>
                        </div>
                        <h3 class="fw-bold text-success mb-2" style="color: #0d5c38 !important;">
                            Rp {{ number_format($campaign['collected'], 0, ',', '.') }}
                        </h3>

                        <!-- Progress Bar -->
                        <div class="progress progress-kitabisa my-2" style="height: 9px; border-radius: 10px;">
                            <div class="progress-bar progress-bar-kitabisa {{ $isFull ? 'bg-success' : '' }}" 
                                 role="progressbar" 
                                 style="width: {{ $percent }}%;" 
                                 aria-valuenow="{{ $percent }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"></div>
                        </div>

                        <div class="d-flex justify-content-between text-muted small mt-2">
                            <div>Target: <strong class="text-dark">Rp {{ number_format($campaign['target'], 0, ',', '.') }}</strong></div>
                            <div><i class="bi bi-people-fill me-1 text-primary"></i><strong class="text-dark">{{ $campaign['donatur_count'] }}</strong> Donatur</div>
                        </div>
                    </div>

                    <!-- KONDISI JIKA PROGRESS SUDAH FULL (100%) -->
                    @if($isFull)
                        <div class="alert alert-success border-0 rounded-4 p-4 text-center my-2 shadow-sm bg-success bg-opacity-10">
                            <i class="bi bi-patch-check-fill text-success fs-1 d-block mb-2"></i>
                            <h5 class="fw-bold text-white mb-2">Alhamdulillah, Target Tercapai 100%!</h5>
                            <p class="small text-white mb-3" style="line-height: 1.6;">
                                Dana donasi sebesar <strong>Rp {{ number_format($campaign['target'], 0, ',', '.') }}</strong> telah terpenuhi berkat kepedulian para Orang Baik. Penggalangan dana ini resmi ditutup dan amanah sedang disalurkan ke lapangan.
                            </p>
                            <a href="{{ route('donasi.index') }}" class="btn btn-success rounded-pill fw-bold py-2 px-4 w-100 shadow-sm">
                                <i class="bi bi-heart me-1"></i> Donasi Program Kebaikan Lain
                            </a>
                        </div>

                    <!-- KONDISI JIKA DI-TAKEDOWN OLEH ADMIN -->
                    @elseif($isTakedown)
                        <div class="alert alert-secondary border-0 rounded-4 p-4 text-center my-2 shadow-sm">
                            <i class="bi bi-shield-lock-fill text-secondary fs-1 d-block mb-2"></i>
                            <h5 class="fw-bold text-dark mb-2">Penggalangan Dana Ditutup</h5>
                            <p class="small text-muted mb-3" style="line-height: 1.6;">
                                Penggalangan dana untuk program ini telah di-takedown oleh Admin. Terima kasih atas dukungan yang telah diberikan.
                            </p>
                            <a href="{{ route('donasi.index') }}" class="btn btn-outline-success rounded-pill fw-bold py-2 px-4 w-100">
                                <i class="bi bi-arrow-left me-1"></i> Lihat Program Lainnya
                            </a>
                        </div>

                    <!-- KONDISI AKTIF: TOMBOL DONASI SEKARANG (REDIRECT KE HALAMAN FORM) -->
                    @else
                        <div class="d-grid gap-2 my-2">
                            <a href="{{ route('donasi.form', ['slug' => $campaign['slug']]) }}" 
                               class="btn btn-success btn-lg py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center justify-content-center text-white"
                               style="background: linear-gradient(135deg, #00C89D 0%, #0d5c38 100%); border: none; font-size: 1.15rem;">
                                <span>Donasi Sekarang</span>
                            </a>

                            <button type="button" 
                                    class="btn btn-outline-secondary rounded-pill py-2 fw-semibold mt-1" 
                                    onclick="shareCampaign()">
                                <i class="bi bi-share me-1"></i> Bagikan Program Ini
                            </button>
                        </div>

                        <!-- Info Keamanan & Layanan -->
                        <div class="mt-4 pt-3 border-top text-muted small">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-shield-check text-success fs-5 me-2"></i>
                                <span>Donasi 100% amanah & transparan</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/midtrans-logo.png') }}" alt="Midtrans" style="height: 20px; width: auto; object-fit: contain;" class="me-2">
                                <span>Didukung oleh <strong>Midtrans Payment Gateway</strong></span>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
// Fungsi Bagikan Link Program
function shareCampaign() {
    if (navigator.share) {
        navigator.share({
            title: "{{ $campaign['title'] }}",
            text: "Mari bersama kita bantu saudara kita melalui program donasi ini: {{ $campaign['title'] }}",
            url: window.location.href
        }).catch(err => console.log('Share dibatalkan'));
    } else {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Tautan program donasi berhasil disalin ke clipboard!');
        });
    }
}
</script>
@endpush
@endsection

