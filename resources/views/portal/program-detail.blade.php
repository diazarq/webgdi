@extends('portal.layout')
@section('title', $program->title)

@push('styles')
<style>
    .program-banner-lg {
        width: 100%;
        border-radius: 18px;
        aspect-ratio: 16/9;
        object-fit: cover;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }
    .program-card-sticky {
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        padding: 24px;
        position: sticky;
        top: 85px;
    }
    .progress-bar-gdi {
        background: linear-gradient(90deg, #00C89D 0%, #0d5c38 100%);
        border-radius: 10px;
    }
    .btn-daftar-cta {
        background: #00885a;
        color: #ffffff !important;
        transition: all 0.25s ease;
    }
    .btn-daftar-cta:hover {
        background: #0b6c46;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 136, 90, 0.35);
    }
</style>
@endpush

@section('content')
<!-- BREADCRUMB -->
<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small mb-1">
            <li class="breadcrumb-item"><a href="{{ route('portal.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portal.dashboard', ['tab' => 'programs']) }}" class="text-decoration-none text-muted">Program Relawan</a></li>
            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">{{ Str::limit($program->title, 35) }}</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <!-- ========================================== -->
    <!-- KOLOM KIRI: FOTO UTAMA & CERITA DETAIL     -->
    <!-- ========================================== -->
    <div class="col-lg-7">
        <!-- Foto Banner Program -->
        <div class="mb-4">
            @if($program->image && file_exists(public_path($program->image)))
                <img src="{{ asset($program->image) }}" alt="{{ $program->title }}" class="program-banner-lg">
            @else
                <img src="{{ asset('website/assets/images/project/project-1-' . (($program->id % 3) + 1) . '.jpg') }}" alt="{{ $program->title }}" class="program-banner-lg" onerror="this.src='{{ asset('images/volunteer/volunteer.jpg') }}'">
            @endif
        </div>

        <!-- Judul & Kategori -->
        <div class="mb-4">
            <span class="badge {{ $program->category === 'Tanggap Bencana' ? 'bg-danger' : 'bg-primary' }} px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                {{ $program->category }}
            </span>
            <h3 class="fw-bold text-dark mt-2" style="line-height: 1.35; font-size: 1.45rem;">
                {{ $program->title }}
            </h3>

            <!-- Koordinator & Lokasi -->
            <div class="d-flex align-items-center gap-3 mt-3 text-muted small">
                <div class="d-flex align-items-center">
                    <span class="fw-semibold text-dark">{{ $program->coordinator_name ?: 'Koordinator GDI' }}</span>
                    <i class="bi bi-patch-check-fill text-primary ms-1" title="Koordinator Terverifikasi"></i>
                </div>
                <span>&bull;</span>
                <div>
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $program->location ?: 'Indonesia' }}
                </div>
            </div>
        </div>

        <!-- Deskripsi Lengkap Program -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="border: 1px solid #e2e8f0 !important;">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-card-text text-success me-2"></i>Tentang Program Aksi Ini</h5>
            <div class="text-secondary" style="line-height: 1.7; font-size: 0.88rem;">
                <p>{{ $program->description }}</p>

                <h6 class="fw-bold text-dark mt-4 mb-2">Peran & Bidang Relawan yang Dibutuhkan:</h6>
                <ul class="mb-3 ps-3">
                    <li><strong>Tim Medis / First Aid:</strong> Penanganan pertolongan pertama, cek kesehatan pengungsi/dhuafa.</li>
                    <li><strong>Dapur Umum & Distribusi Pangan:</strong> Pengolahan dan pembagian paket konsumsi bergizi.</li>
                    <li><strong>Evakuasi & Logistik Lapangan:</strong> Sortir logistik bantuan, pengangkutan, serta pendistribusian tepat sasaran.</li>
                    <li><strong>Dokumentasi & Media:</strong> Peliputan foto, video kabar lapangan, dan publikasi transparansi amanah donatur.</li>
                    <li><strong>Relawan Lapangan Umum:</strong> Pendampingan warga, kesiapan armada, dan mobilitas aksi.</li>
                </ul>

                <div class="alert alert-light border rounded-3 p-3 mt-3 small">
                    <i class="bi bi-info-circle-fill text-success me-2"></i>
                    <strong>Penting:</strong> Seluruh relawan yang terdaftar wajib masuk ke grup koordinasi WhatsApp untuk mematuhi arahan SOP keselamatan dan briefing teknis dari koordinator lapangan.
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- KOLOM KANAN: STICKY CARD DAFTAR RELAWAN    -->
    <!-- ========================================== -->
    <div class="col-lg-5">
        <div class="program-card-sticky">
            <h6 class="fw-bold text-dark mb-3">Status Kesiapan Aksi Relawan</h6>

            <!-- Kuota Progress Bar -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-muted small">Kuota Relawan Terkumpul</span>
                    <strong class="text-dark small">{{ $program->registrations_count }} / {{ $program->quota }} Relawan</strong>
                </div>
                <div class="progress" style="height: 9px; border-radius: 10px; background-color: #edf2f7;">
                    <div class="progress-bar progress-bar-gdi" 
                         role="progressbar" 
                         style="width: {{ $percent }}%;" 
                         aria-valuenow="{{ $percent }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100"></div>
                </div>
                <div class="text-muted small mt-1 text-end" style="font-size: 0.72rem;">
                    {{ $percent }}% dari target personil terpenuhi
                </div>
            </div>

            <!-- Detail Pelaksanaan -->
            <div class="bg-light p-3 rounded-3 mb-4 small" style="border: 1px solid #edf2f7;">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Kategori Aksi:</span>
                    <span class="fw-semibold text-dark">{{ $program->category }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Lokasi Lapangan:</span>
                    <span class="fw-semibold text-dark text-truncate" style="max-width: 170px;">{{ $program->location }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Koordinator:</span>
                    <span class="fw-semibold text-dark">{{ $program->coordinator_name }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Status Pendaftaran:</span>
                    <span class="badge bg-success-subtle text-success border border-success">Terbuka</span>
                </div>
            </div>

            <!-- Tombol CTA Persis Donasi -->
            @if($isRegistered)
                <div class="d-grid gap-2">
                    <div class="alert alert-success border-0 small py-2 px-3 rounded-3 text-center mb-1">
                        <i class="bi bi-check-circle-fill me-1"></i> Anda Sudah Terdaftar di Program Ini
                    </div>
                    <a href="{{ route('portal.volunteer.program.join-group', $myRegistration->id) }}" target="_blank" class="btn btn-success btn-lg py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center justify-content-center text-white" style="font-size: 0.88rem;">
                        <i class="bi bi-whatsapp me-2 fs-5"></i> Gabung Grup WhatsApp Sekarang
                    </a>
                    <a href="{{ route('portal.dashboard', ['tab' => 'riwayat']) }}" class="btn btn-light rounded-pill py-2 text-muted small mt-1">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat Aktivitasmu
                    </a>
                </div>
            @else
                <div class="d-grid gap-2">
                    <a href="{{ route('portal.volunteer.program.form', $program->slug) }}" class="btn btn-daftar-cta btn-lg py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center justify-content-center text-white" style="font-size: 0.90rem;">
                        <span>Daftar Menjadi Relawan</span> <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    <a href="{{ route('portal.dashboard') }}" class="btn btn-light rounded-pill py-2 text-muted small">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Program
                    </a>
                </div>
            @endif

            <!-- Info Keamanan & Layanan -->
            <div class="mt-4 pt-3 border-top text-muted small">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-shield-check text-success fs-5 me-2"></i>
                    <span>Aksi Resmi Yayasan Graha Dhuafa Indonesia</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-chat-dots-fill text-primary fs-5 me-2"></i>
                    <span>Terhubung langsung ke WhatsApp Koordinator</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

