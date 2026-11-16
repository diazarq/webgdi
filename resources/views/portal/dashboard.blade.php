@extends('portal.layout')
@section('title', $user->isAffiliate() ? 'Dashboard Kemitraan & Afiliasi' : 'Dashboard Program Relawan')

@push('styles')
<style>
    /* HERO WELCOME BANNER (VOLUNTEER) */
    .hero-banner {
        background: linear-gradient(90deg, rgba(10, 60, 30, 0.90) 0%, rgba(13, 85, 42, 0.78) 50%, rgba(13, 85, 42, 0.60) 100%), url('{{ asset('images/volunteer/volunteer.jpg') }}') center center / cover no-repeat;
        border-radius: 18px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        padding: 56px 32px;
        box-shadow: 0 6px 20px rgba(13, 105, 49, 0.15);
    }
    
    /* HERO BANNER (MITRA / AFILIASI) */
    .hero-banner-mitra {
        background: linear-gradient(90deg, rgba(10, 42, 22, 0.94) 0%, rgba(13, 75, 40, 0.86) 55%, rgba(10, 42, 22, 0.92) 100%), url('{{ asset('images/mitra/handshake.jpg') }}') center center / cover no-repeat;
        border-radius: 18px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        padding: 50px 32px;
        box-shadow: 0 6px 20px rgba(10, 42, 22, 0.20);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .hero-banner h2, .hero-banner-mitra h2 {
        font-size: 1.45rem !important;
        font-weight: 700;
        letter-spacing: -0.015em;
    }
    .hero-banner p, .hero-banner-mitra p {
        font-size: 0.88rem !important;
        line-height: 1.6;
    }
    .hero-banner::before, .hero-banner-mitra::before {
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

    /* STAT CARDS FOR MITRA */
    .stat-card-affiliate {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }
    .stat-card-affiliate:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }
    .stat-icon-wrapper {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }
    .stat-val {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .stat-label {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 600;
    }

    /* MAIN NAV PILLS (TABS RELAWAN) */
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

@if($user->isAffiliate())
    <!-- ============================================================== -->
    <!-- DASHBOARD KHUSUS MITRA / LEMBAGA / AFILIASI DONASI             -->
    <!-- (MITRA TIDAK IKUT MENJADI RELAWAN LAPANGAN)                   -->
    <!-- ============================================================== -->

    <!-- 1. HERO BANNER KEMITRAAN -->
    <section class="hero-banner-mitra mb-4">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold" style="font-size: 0.72rem;">
                        <i class="bi bi-patch-check-fill me-1"></i> MITRA RESMI GDI
                    </span>
                    <span class="badge bg-light text-dark px-3 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        ID Ref: {{ strtoupper($user->username) }}
                    </span>
                </div>
                <h2 class="fw-bold mb-2 text-white">Selamat Datang, {{ $user->name }}!</h2>
                <p class="text-white opacity-90 mb-0" style="max-width: 650px;">
                    Portal kemitraan resmi <strong>{{ $user->instansi ?? $user->name }}</strong> bersama Yayasan Graha Dhuafa Indonesia. Pantau perolehan donasi dari jamaah dan komunitas Anda secara transparan, akuntabel, dan real-time.
                </p>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div style="font-size: 4rem; color: rgba(255, 255, 255, 0.25);">
                    <i class="bi bi-handshake-fill"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. CARD TAUTAN & KODE DONASI AFILIASI -->
    <section class="card border-0 shadow-sm mb-4" style="border-radius: 20px; background: #ffffff; border: 1.5px solid #fed7aa !important; overflow: hidden;">
        <div class="p-4" style="background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%); border-bottom: 1px solid #fed7aa;">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="bi bi-link-45deg"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.7rem;">PROGRAM AFILIASI & PENGGALANGAN DANA</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-0 mt-1">Tautan Donasi Resmi: {{ $user->instansi ?? $user->name }}</h5>
                        <small class="text-muted">Sebarkan tautan referral ini kepada jamaah masjid, alumni, relasi komunitas, atau media sosial Anda.</small>
                    </div>
                </div>
                <div>
                    <div class="p-2 px-3 bg-white rounded-4 border border-warning-subtle d-inline-flex align-items-center gap-2 shadow-sm">
                        <span class="text-muted small fw-semibold">Kode Referral:</span>
                        <strong class="text-primary fs-5">{{ strtoupper($user->username) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <label class="form-label small fw-bold text-secondary mb-1">Tautan Donasi Afiliasi Anda:</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-globe text-warning"></i></span>
                        <input type="text" class="form-control bg-light border-start-0 border-end-0 fw-semibold text-dark" id="inputAffiliateLink" value="{{ url('/donasi?ref=' . $user->username) }}" readonly>
                        <button class="btn btn-warning fw-bold px-4 rounded-end-3" type="button" onclick="copyAffiliateLink()">
                            <i class="bi bi-clipboard me-1" id="copyIcon"></i> <span id="copyText">Salin Link</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-end">
                    @php
                        $waText = urlencode("Bismillah, mari salurkan sedekah dan kepedulian terbaik Anda bersama " . ($user->instansi ?? $user->name) . " melalui Yayasan Graha Dhuafa Indonesia. Tautan resmi: " . url('/donasi?ref=' . $user->username));
                    @endphp
                    <a href="https://api.whatsapp.com/send?text={{ $waText }}" target="_blank" class="btn btn-success fw-bold w-100 py-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-whatsapp fs-5"></i> Bagikan ke WhatsApp
                    </a>
                </div>
            </div>

            <div class="mt-3 p-3 bg-light rounded-3 small text-muted d-flex align-items-center gap-2">
                <i class="bi bi-info-circle-fill text-warning fs-5 flex-shrink-0"></i>
                <div>
                    Setiap donasi yang masuk melalui tautan di atas akan otomatis tercatat di bawah naungan kemitraan <strong>{{ $user->instansi ?? $user->name }}</strong> secara transparan.
                </div>
            </div>
        </div>
    </section>

    <!-- 3. METRIK UTAMA HASIL AFILIASI DONASI (4 KARTU) -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Donasi Terhimpun -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-affiliate">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="stat-label mb-1">TOTAL DONASI TERHIMPUN</div>
                        <div class="stat-val text-success">
                            Rp {{ number_format($affiliateStats['total_collected'] ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="stat-icon-wrapper" style="background: #dcfce7; color: #16a34a;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <div class="small text-muted border-top pt-2 mt-2">
                    <i class="bi bi-check-circle-fill text-success me-1"></i> Terverifikasi masuk & lunas
                </div>
            </div>
        </div>

        <!-- 2. Total Donatur Masuk -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-affiliate">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="stat-label mb-1">TOTAL DONATUR BERGABUNG</div>
                        <div class="stat-val text-primary">
                            {{ number_format($affiliateStats['total_donors'] ?? 0) }} <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Orang</span>
                        </div>
                    </div>
                    <div class="stat-icon-wrapper" style="background: #e0f2fe; color: #0284c7;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="small text-muted border-top pt-2 mt-2">
                    <i class="bi bi-arrow-up-right-circle text-primary me-1"></i> Donasi via referral Anda
                </div>
            </div>
        </div>

        <!-- 3. Donasi Bulan Ini -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-affiliate">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="stat-label mb-1">DONASI BULAN INI ({{ date('M Y') }})</div>
                        <div class="stat-val text-warning-emphasis">
                            Rp {{ number_format($affiliateStats['this_month_collected'] ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="stat-icon-wrapper" style="background: #fef3c7; color: #d97706;">
                        <i class="bi bi-calendar2-check-fill"></i>
                    </div>
                </div>
                <div class="small text-muted border-top pt-2 mt-2">
                    <i class="bi bi-calendar-range text-warning me-1"></i> Periode berjalan saat ini
                </div>
            </div>
        </div>

        <!-- 4. Estimasi Hak Amil / Bagi Hasil Kemitraan -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-affiliate">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="stat-label mb-1">ESTIMASI HAK AMIL (10%)</div>
                        <div class="stat-val" style="color: #7c3aed;">
                            Rp {{ number_format($affiliateStats['estimated_ujrah'] ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="stat-icon-wrapper" style="background: #f3e8ff; color: #9333ea;">
                        <i class="bi bi-award-fill"></i>
                    </div>
                </div>
                <div class="small text-muted border-top pt-2 mt-2">
                    <i class="bi bi-shield-check text-purple me-1"></i> Hak amil / konversi sembako binaan
                </div>
            </div>
        </div>
    </div>

    <!-- 4. TABEL RIWAYAT DONASI AFILIASI MASUK -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-journal-check text-success me-2"></i>Riwayat Donatur Melalui Afiliasi Kemitraan
                </h6>
                <span class="small text-muted">Daftar transaksi donatur yang menyalurkan donasi via link referral Anda</span>
            </div>
            <div>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill small">
                    Total: {{ $affiliateDonations->count() }} Transaksi Terbaru
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            @if($affiliateDonations->isEmpty())
                <div class="empty-state-box border-0 my-4">
                    <div class="empty-icon" style="background: #fef3c7; color: #d97706; border-color: #fde68a;">
                        <i class="bi bi-inbox-fill"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Belum Ada Donasi Masuk</h6>
                    <p class="text-muted small mb-3" style="max-width: 460px; margin: 0 auto;">
                        Belum ada donatur yang menyelesaikan donasi melalui tautan afiliasi Anda. Ayo bagikan tautan kemitraan Anda ke WhatsApp atau media sosial jamaah!
                    </p>
                    <button class="btn btn-warning fw-bold px-4 py-2 rounded-pill shadow-sm" style="font-size: 0.82rem;" onclick="copyAffiliateLink()">
                        <i class="bi bi-link-45deg me-1"></i> Salin Link Donasi Sekarang
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4 py-3" style="width: 50px;">#</th>
                                <th class="py-3">Waktu Transaksi</th>
                                <th class="py-3">Kode Transaksi</th>
                                <th class="py-3">Nama Donatur</th>
                                <th class="py-3">Program Donasi</th>
                                <th class="py-3 text-end">Nominal</th>
                                <th class="py-3 text-center pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($affiliateDonations as $index => $donation)
                            <tr>
                                <td class="ps-4 text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 0.82rem;">
                                        {{ $donation->created_at ? $donation->created_at->format('d M Y') : '-' }}
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.72rem;">
                                        {{ $donation->created_at ? $donation->created_at->format('H:i') . ' WIB' : '' }}
                                    </div>
                                </td>
                                <td>
                                    <code class="text-primary fw-semibold" style="font-size: 0.78rem;">
                                        {{ $donation->transcode ?? '-' }}
                                    </code>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 30px; height: 30px; border-radius: 50%; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                                            {{ strtoupper(substr($donation->anonim ? 'H' : ($donation->name ?? 'D'), 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 0.82rem;">
                                                {{ $donation->anonim ? 'Hamba Allah (Anonim)' : ($donation->name ?: 'Donatur') }}
                                            </div>
                                            @if(!$donation->anonim && $donation->notelp)
                                                <div class="small text-muted" style="font-size: 0.70rem;">
                                                    {{ substr($donation->notelp, 0, 4) . '****' . substr($donation->notelp, -3) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-medium px-2 py-1" style="font-size: 0.75rem;">
                                        {{ $donation->type ?: 'Donasi Umum / Infak' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <strong class="text-success" style="font-size: 0.88rem;">
                                        Rp {{ number_format($donation->nominal, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td class="text-center pe-4">
                                    @if($donation->status === 'complete')
                                        <span class="badge bg-success-subtle text-success border border-success px-2 py-1" style="font-size: 0.72rem;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Berhasil
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning px-2 py-1" style="font-size: 0.72rem;">
                                            <i class="bi bi-clock-history me-1"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- 5. CARD EDUKASI KONSEP HASIL AFILIASI & SINERGI PROGRAM -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0 !important;">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #0f7638; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                <i class="bi bi-lightbulb-fill"></i>
            </div>
            <div>
                <h5 class="fw-bold text-dark mb-0">Bagaimana Konsep & Pengelolaan Hasil Afiliasi Ini?</h5>
                <small class="text-muted">Prinsip transparansi syariah dan sinergi kemitraan kemanusiaan bersama Graha Dhuafa Indonesia</small>
            </div>
        </div>

        <div class="row g-3">
            <!-- Skema 1: Hak Amil Ujrah -->
            <div class="col-md-6">
                <div class="p-3 bg-white rounded-3 border h-100 shadow-xs">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill" style="font-size: 0.7rem;">PILIHAN 1</span>
                        <h6 class="fw-bold text-dark mb-0">Hak Amil Operasional (Bagi Hasil Ujrah 10%)</h6>
                    </div>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Sesuai kaidah syariah, mitra lembaga/DKM berhak atas bagian <strong>Hak Amil hingga 10%</strong> dari total donasi terkumpul sebagai kompensasi operasional lembaga kemitraan, uang kas dakwah masjid, atau sarana operasional penggalangan.
                    </p>
                </div>
            </div>

            <!-- Skema 2: Sinergi Paket Sembako / Binaan -->
            <div class="col-md-6">
                <div class="p-3 bg-white rounded-3 border h-100 shadow-xs">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded-pill" style="font-size: 0.7rem;">PILIHAN 2 (REKOMENDASI)</span>
                        <h6 class="fw-bold text-dark mb-0">Program Sembako & Santunan Lingkungan Mitra</h6>
                    </div>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Mitra dapat memilih agar <strong>100% donasi dialihkan menjadi paket pangan/sembako beras</strong> yang dibagikan langsung kepada warga dhuafa di wilayah binaan mitra dengan branding kolaborasi bersama <em>(GDI x {{ $user->instansi ?? $user->name }})</em>.
                    </p>
                </div>
            </div>
        </div>
    </div>

@else
    <!-- ============================================================== -->
    <!-- DASHBOARD KHUSUS RELAWAN (SAHABAT BAIK)                        -->
    <!-- ============================================================== -->

    <!-- 1. HERO BANNER WELCOME RELAWAN -->
    <section class="hero-banner mb-4">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-2 text-white">Selamat Datang, {{ $user->name }}!</h2>
                <p class="text-white opacity-90 mb-3" style="max-width: 620px;">
                    Terima kasih atas dedikasi dan kontribusi nyata Anda bersama Graha Dhuafa Indonesia. Salurkan kabar kebaikan dan dokumentasi kegiatan aksi sosial Anda di portal ini.
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

    <!-- 3. TABS NAVIGASI UTAMA DASHBOARD RELAWAN -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div class="dashboard-tabs">
            <a href="{{ route('portal.dashboard', ['tab' => 'programs']) }}" class="dashboard-tab-btn {{ $activeTab !== 'riwayat' ? 'active' : '' }}">
                <i class="bi bi-compass"></i> Daftar Program Relawan
                <span class="badge-count">{{ $programs->count() }}</span>
            </a>
            <a href="{{ route('portal.dashboard', ['tab' => 'riwayat']) }}" class="dashboard-tab-btn {{ $activeTab === 'riwayat' ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Aktivitasmu
                <span class="badge-count">{{ $myRegistrations->count() }}</span>
            </a>
        </div>
    </div>

    <!-- TAB 1: DAFTAR PROGRAM RELAWAN -->
    @if($activeTab !== 'riwayat')
    <div class="row g-4">
        @forelse($programs as $p)
        @php
            $isRegistered = in_array($p->id, $registeredProgramIds);
            $myReg = $myRegistrations->firstWhere('volunteer_program_id', $p->id);
            $isBencana = ($p->category === 'Tanggap Bencana');
        @endphp
        <div class="col-lg-4 col-md-6">
            <div class="card donasi-card h-100 shadow-sm">
                <!-- Cover Image -->
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

                <!-- Konten Card -->
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="donasi-card__title mb-2">
                            <a href="{{ route('portal.volunteer.program.detail', $p->slug) }}" class="text-decoration-none text-dark">
                                {{ $p->title }}
                            </a>
                        </h3>

                        <div class="donasi-card__organizer d-flex align-items-center mb-1">
                            <span class="text-truncate" style="max-width: 200px;">{{ $p->coordinator_name ?: 'Koordinator GDI' }}</span>
                            <i class="bi bi-patch-check-fill text-primary ms-1" title="Terverifikasi"></i>
                        </div>

                        <div class="small text-muted mb-3" style="font-size: 0.74rem;">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $p->location ?: 'Indonesia' }}
                        </div>
                    </div>

                    <div>
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

    <!-- TAB 2: RIWAYAT AKTIVITASMU -->
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
@endif

@endsection

@push('scripts')
<script>
    function copyAffiliateLink() {
        var copyInput = document.getElementById("inputAffiliateLink");
        if (!copyInput) return;

        copyInput.select();
        copyInput.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyInput.value).then(function() {
            var btnText = document.getElementById("copyText");
            var btnIcon = document.getElementById("copyIcon");
            if (btnText && btnIcon) {
                btnText.innerText = "✓ Tersalin!";
                btnIcon.classList.remove("bi-clipboard");
                btnIcon.classList.add("bi-check2");
                setTimeout(function() {
                    btnText.innerText = "Salin Link";
                    btnIcon.classList.remove("bi-check2");
                    btnIcon.classList.add("bi-clipboard");
                }, 2000);
            }
        });
    }
</script>
@endpush
