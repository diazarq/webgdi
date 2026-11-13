@extends('portal.layout')
@section('title', 'Dashboard Program Relawan')

@push('styles')
<style>
    /* HERO WELCOME BANNER */
    .hero-banner {
        background: linear-gradient(90deg, rgba(10, 60, 30, 0.90) 0%, rgba(13, 85, 42, 0.78) 50%, rgba(13, 85, 42, 0.60) 100%), url('{{ asset('images/volunteer/volunteer.jpg') }}') center center / cover no-repeat;
        border-radius: 18px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        padding: 88px 32px;
        box-shadow: 0 6px 20px rgba(13, 105, 49, 0.15);
    }
    .hero-banner h2 {
        font-size: 1.30rem !important;
        font-weight: 700;
        letter-spacing: -0.015em;
    }
    .hero-banner p {
        font-size: 0.82rem !important;
        line-height: 1.55;
    }
    .hero-banner::before {
        content: "";
        position: absolute;
        top: -40%;
        right: -10%;
        width: 360px;
        height: 360px;
        border-radius: 50%;
        border: 35px solid rgba(255, 255, 255, 0.05);
        pointer-events: none;
    }
    .hero-banner::after {
        content: "";
        position: absolute;
        bottom: -50%;
        right: 15%;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        border: 28px solid rgba(255, 255, 255, 0.03);
        pointer-events: none;
    }
    .hero-stat-badge {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        font-size: 0.74rem;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* MAIN NAV PILLS (TABS) */
    .dashboard-tabs {
        background: #ffffff;
        padding: 8px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        gap: 5px;
        margin-bottom: 20px;
    }
    .dashboard-tab-btn {
        border: none;
        background: transparent;
        color: #64748b;
        font-weight: 600;
        font-size: 0.82rem;
        padding: 8px 16px;
        border-radius: 10px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }
    .dashboard-tab-btn:hover {
        color: #0f7638;
        background: #f1f5f9;
    }
    .dashboard-tab-btn.active {
        background: #0f7638;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(15, 118, 56, 0.25);
    }
    .dashboard-tab-btn .badge-count {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        font-size: 0.70rem;
        padding: 2px 7px;
        border-radius: 20px;
    }
    .dashboard-tab-btn:not(.active) .badge-count {
        background: #e2e8f0;
        color: #475569;
    }

    /* KARTU PROGRAM PERSIS GAYA KATALOG DONASI */
    .donasi-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #edf2f7;
        background: #ffffff;
        display: flex;
        flex-direction: column;
    }
    .donasi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08) !important;
    }
    .donasi-card__img-wrapper {
        position: relative;
        aspect-ratio: 16/9;
        overflow: hidden;
        background: #0d4223;
        width: 100%;
        display: block;
    }
    .donasi-card__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
        display: block;
    }
    .donasi-card:hover .donasi-card__img {
        transform: scale(1.05);
    }
    .donasi-card__category {
        position: absolute;
        top: 12px;
        left: 12px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        border-radius: 20px;
        padding: 4px 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }
    .donasi-card__title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a202c;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 42px;
    }
    .donasi-card__organizer {
        font-size: 0.78rem;
        color: #64748b;
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

    /* RIWAYAT AKTIVITAS CARD */
    .history-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        margin-bottom: 14px;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .history-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
        border-color: #cbd5e1;
    }
    .history-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #16a34a;
    }
    .history-card.bencana::before {
        background: #dc2626;
    }

    /* FILTER BUTTONS */
    .filter-btn-pill {
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        font-size: 0.76rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .filter-btn-pill:hover {
        border-color: #0f7638;
        color: #0f7638;
    }
    .filter-btn-pill.active {
        background: #0f7638;
        border-color: #0f7638;
        color: #ffffff !important;
    }

    /* EMPTY STATE */
    .empty-state-box {
        background: #ffffff;
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
        padding: 40px 20px;
        text-align: center;
    }
    .empty-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: #f0fdf4;
        color: #16a34a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 12px;
        border: 1px solid #dcfce7;
    }
</style>
@endpush

@section('content')
<!-- 1. HERO BANNER WELCOME -->
<section class="hero-banner mb-4">
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-lg-8">
            <h2 class="fw-bold mb-1 text-white">Selamat Datang, {{ $user->name }}!</h2>
            <p class="text-white opacity-90 mb-3" style="max-width: 620px;">
                Pilih dan ikuti program aksi relawan Graha Dhuafa Indonesia. Tebarkan kebaikan, bantu sesama, dan berkoordinasi langsung dengan tim lapangan melalui WhatsApp koordinator.
            </p>
        </div>
        <div class="col-lg-4 text-center d-none d-lg-block">
            <div style="font-size: 3.8rem; color: rgba(255,255,255,0.3);">
                <i class="bi bi-hands-helping"></i>
            </div>
        </div>
    </div>
</section>

<!-- 2. NOTIFIKASI PENDAFTARAN BERHASIL (JIKA ADA) -->
@if(session('pendaftaran_sukses'))
<div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm p-3 mb-4" role="alert" style="background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%); border-left: 6px solid #16a34a !important;">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-2 text-success me-3"></i>
            <div>
                <h6 class="fw-bold text-success mb-1">Pendaftaran Berhasil: {{ session('pendaftaran_sukses.program_title') }}</h6>
                <div class="text-dark small">{{ session('pendaftaran_sukses.message') }}</div>
            </div>
        </div>
        <a href="{{ route('portal.volunteer.program.join-group', session('pendaftaran_sukses.registration_id')) }}" target="_blank" class="btn btn-success fw-bold px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.82rem;">
            <i class="bi bi-whatsapp me-1"></i> Gabung Grup WhatsApp Sekarang
        </a>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<!-- 3. TABS NAVIGASI UTAMA DASHBOARD -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div class="dashboard-tabs">
        <a href="{{ route('portal.dashboard', ['tab' => 'programs']) }}" class="dashboard-tab-btn {{ $activeTab !== 'riwayat' ? 'active' : '' }}">
            <i class="bi bi-compass"></i> Daftar Program
            <span class="badge-count">{{ $programs->count() }}</span>
        </a>
        <a href="{{ route('portal.dashboard', ['tab' => 'riwayat']) }}" class="dashboard-tab-btn {{ $activeTab === 'riwayat' ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Riwayat Aktivitasmu
            <span class="badge-count">{{ $myRegistrations->count() }}</span>
        </a>
    </div>
</div>

<!-- ============================================================== -->
<!-- TAB 1: DAFTAR PROGRAM RELAWAN (PERSIS FLOW KATALOG DONASI)     -->
<!-- ============================================================== -->
@if($activeTab !== 'riwayat')
<div class="row g-4">
    @forelse($programs as $p)
    @php
        $isRegistered = in_array($p->id, $registeredProgramIds);
        $myReg = $myRegistrations->firstWhere('volunteer_program_id', $p->id);
        $isBencana = ($p->category === 'Tanggap Bencana');
        $percent = min(100, round(($p->registrations_count / max(1, $p->quota)) * 100));
    @endphp
    <div class="col-lg-4 col-md-6">
        <div class="card donasi-card h-100 shadow-sm">
            <!-- Gambar Cover 16:9 di bagian atas (TIDAK GEPENG!) -->
            <div class="donasi-card__img-wrapper position-relative">
                @if($p->image && file_exists(public_path($p->image)))
                    <img src="{{ asset($p->image) }}" alt="{{ $p->title }}" class="donasi-card__img">
                @else
                    <img src="{{ asset('website/assets/images/project/project-1-' . (($p->id % 3) + 1) . '.jpg') }}" alt="{{ $p->title }}" class="donasi-card__img" onerror="this.src='{{ asset('images/volunteer/volunteer.jpg') }}'">
                @endif

                

                @if($isRegistered)
                    <span class="badge bg-success position-absolute top-0 end-0 m-2 px-2 py-1 rounded-pill" style="font-size: 0.68rem; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                        <i class="bi bi-check-circle-fill me-1"></i> Terdaftar
                    </span>
                @endif
            </div>

            <!-- Konten Card Persis Donasi -->
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div>
                    <h3 class="donasi-card__title mb-2">
                        <a href="{{ route('portal.volunteer.program.detail', $p->slug) }}" class="text-decoration-none text-dark">
                            {{ $p->title }}
                        </a>
                    </h3>

                    <!-- Koordinator Lapangan Terverifikasi -->
                    <div class="donasi-card__organizer d-flex align-items-center mb-1">
                        <span class="text-truncate" style="max-width: 200px;">{{ $p->coordinator_name ?: 'Koordinator GDI' }}</span>
                        <i class="bi bi-patch-check-fill text-primary ms-1" title="Terverifikasi"></i>
                    </div>

                    <!-- Lokasi Aksi -->
                    <div class="small text-muted mb-3" style="font-size: 0.74rem;">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $p->location ?: 'Indonesia' }}
                    </div>
                </div>

                <div>

                    <!--  (Mengarahkan ke Halaman Detail & Daftar) -->
                    @if($isRegistered)
                        <a href="{{ route('portal.volunteer.program.join-group', $myReg->id) }}" target="_blank" class="btn btn-success w-100 rounded-pill py-2 fw-semibold d-flex justify-content-center align-items-center shadow-sm" style="font-size: 0.80rem;">
                            <i class="bi bi-whatsapp me-1"></i> Gabung Grup WhatsApp
                        </a>
                    @else
                        <a href="{{ route('portal.volunteer.program.detail', $p->slug) }}" class="btn btn-donasi-card w-100 rounded-pill py-2 fw-semibold d-flex justify-content-center align-items-center" style="font-size: 0.80rem;">
                            Lihat Detail & Daftar <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state-box">
            <div class="empty-icon"><i class="bi bi-compass"></i></div>
            <h6 class="fw-bold text-dark mb-1">Belum Ada Program Aksi Terbuka</h6>
            <p class="text-muted small mb-0">Program aksi kerelawanan baru akan segera diumumkan oleh tim Graha Dhuafa Indonesia.</p>
        </div>
    </div>
    @endforelse
</div>
@endif

<!-- ============================================================== -->
<!-- TAB 2: RIWAYAT AKTIVITASMU (PROGRAM YANG PERNAH DIIKUTI)        -->
<!-- ============================================================== -->
@if($activeTab === 'riwayat')
<div id="contentRiwayat">
    @if($myRegistrations->isEmpty())
    <div class="empty-state-box">
        <div class="empty-icon">
            <i class="bi bi-calendar-heart"></i>
        </div>
        <h6 class="fw-bold text-dark mb-1">Belum Ada Riwayat Aktivitas Relawan</h6>
        <p class="text-muted small mb-3" style="max-width: 480px; margin: 0 auto;">
            Anda belum pernah mendaftar pada program aksi relawan. Yuk pilih aksi sosial kemanusiaan yang sedang membutuhkan relawan di tab <strong>Daftar Program Relawan</strong>.
        </p>
        <a href="{{ route('portal.dashboard', ['tab' => 'programs']) }}" class="btn btn-success rounded-pill px-4 py-2 fw-semibold" style="font-size: 0.82rem;">
            <i class="bi bi-compass me-1"></i> Lihat Daftar Program Aksi
        </a>
    </div>
    @else
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history text-success me-2"></i>Riwayat Program Relawan Yang Anda Ikuti</h6>
                <span class="small text-muted">Berikut adalah daftar program kemanusiaan yang telah Anda daftarkan.</span>
            </div>
            <a href="{{ route('portal.dashboard', ['tab' => 'programs']) }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Aksi Baru
            </a>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="row g-3">
                @foreach($myRegistrations as $reg)
                @php
                    $prog = $reg->program;
                    $isBencana = ($prog && $prog->category === 'Tanggap Bencana');
                @endphp
                <div class="col-12">
                    <div class="history-card {{ $isBencana ? 'bencana' : '' }}">
                        <div class="row align-items-center g-3">
                            <!-- Info Program -->
                            <div class="col-md-5">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-none d-sm-block">
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; border: 1px solid #e2e8f0;">
                                            <i class="bi {{ $isBencana ? 'bi-shield-shaded text-danger' : 'bi-heart-fill text-primary' }} fs-4"></i>
                                        </div>
                                    </div>
                                    <div>

                                        <h6 class="fw-bold text-dark mb-1">
                                            @if($prog)
                                                <a href="{{ route('portal.volunteer.program.detail', $prog->slug) }}" class="text-decoration-none text-dark">
                                                    {{ $prog->title }}
                                                </a>
                                            @else
                                                Program Aksi GDI
                                            @endif
                                        </h6>
                                        <div class="small text-muted d-flex align-items-center gap-1">
                                            <i class="bi bi-geo-alt-fill text-danger"></i> {{ $prog->location ?? 'Indonesia' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Pendaftaran -->
                            <div class="col-md-4">
                                <div class="small text-muted mb-1">
                                    <i class="bi bi-calendar-event me-1"></i> Terdaftar: <strong class="text-dark">{{ $reg->created_at->format('d M Y, H:i') }} WIB</strong>
                                </div>
                                <div class="small text-muted mb-1">
                                    <i class="bi bi-person-workspace me-1"></i> Peran: <span class="badge bg-light text-dark border">{{ $reg->skills ?: 'Relawan Umum' }}</span>
                                </div>
                                <div>
                                    @if($reg->joined_group_at)
                                        <span class="badge bg-success-subtle text-success border border-success">
                                            <i class="bi bi-check-circle-fill me-1"></i> Tergabung di WhatsApp
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu Masuk Grup
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Tombol WhatsApp Koordinator -->
                            <div class="col-md-3 text-md-end">
                                <a href="{{ route('portal.volunteer.program.join-group', $reg->id) }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 py-2 fw-semibold shadow-sm w-100 w-md-auto" style="font-size: 0.78rem;">
                                    <i class="bi bi-whatsapp me-1 fs-6 align-middle"></i> Gabung Grup Koordinasi
                                </a>
                                @if($reg->joined_group_at)
                                    <div class="text-muted mt-1" style="font-size: 0.70rem;">
                                        Diakses: {{ $reg->joined_group_at->format('d M, H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endif

@endsection
