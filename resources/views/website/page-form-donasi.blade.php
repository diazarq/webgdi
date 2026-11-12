@extends('layout.layout-page')
@section('title', 'Formulir Donasi - ' . $campaign['title'])

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .btn-pembayaran {
        background-color: #00885a;
        color: white;
        transition: ease 0.3s;
    }

    .btn-pembayaran:hover {
        background: transparent;
        border: 1.5px solid #00885a;
        transform: translateY(-4px);
        color: #00885a;
    }

    .nominal-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 8px;
    }
    @media (max-width: 768px) {
        .nominal-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
    }
    @media (max-width: 400px) {
        .nominal-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .nominal-chip {
        border: 1.5px solid #d1d5db;
        background: #ffffff;
        border-radius: 12px;
        padding: 10px 4px;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #1f2937;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        user-select: none;
    }
    .nominal-chip:hover {
        border-color: #00C89D;
        background: #f0fdf9;
        transform: translateY(-2px);
    }
    .nominal-chip.active {
        border-color: #0d5c38;
        background: #0d5c38;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(13, 92, 56, 0.25);
    }
    .form-section-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
    }
    .campaign-summary-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        position: sticky;
        top: 100px;
    }
    .summary-banner {
        width: 100%;
        height: 190px;
        object-fit: cover;
    }
    .progress-bar-kitabisa {
        background: linear-gradient(90deg, #00C89D 0%, #0d5c38 100%);
        border-radius: 10px;
    }
    .form-control, .form-select {
        border: 1.5px solid #d1d5db;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: 0.98rem;
    }
    .form-control:focus {
        border-color: #0d5c38;
        box-shadow: 0 0 0 0.25rem rgba(13, 92, 56, 0.15);
    }
    /* Trigger Box (Rumah Zakat Style) */
    .payment-trigger-box {
        border: 1.5px solid #d1d5db;
        border-radius: 12px;
        padding: 14px 18px;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }
    .payment-trigger-box:hover {
        border-color: #00885a;
        background: #fbfdfc;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }
    .payment-trigger-box.has-selected {
        border-color: #00885a !important;
        background: #f0fdf9 !important;
        box-shadow: 0 0 0 1px #00885a;
    }
    .payment-trigger-box.is-invalid {
        border-color: #ef4444 !important;
        background: #fff5f5 !important;
        box-shadow: 0 0 0 1px #ef4444;
    }

    /* Style Accordion / Dropdown Kelompok Metode Pembayaran (Rumah Zakat style) */
    .payment-group-card {
        transition: all 0.25s ease;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 14px;
        background: #ffffff;
    }
    .payment-group-card:hover {
        border-color: #cbd5e1 !important;
    }
    .payment-group-card.has-selected {
        border-color: #00885a !important;
        box-shadow: 0 4px 14px rgba(0, 136, 90, 0.08);
    }
    .payment-group-header {
        cursor: pointer;
        user-select: none;
        transition: background-color 0.2s ease;
        background-color: #ffffff;
    }
    .payment-group-header:hover {
        background-color: #f8fafc;
    }
    .payment-group-header .group-chevron {
        transition: transform 0.25s ease;
        display: inline-block;
    }
    .payment-group-card.expanded .payment-group-header .group-chevron {
        transform: rotate(180deg);
        color: #00885a !important;
    }
    .payment-group-content {
        transition: all 0.3s ease;
    }
    .payment-group-card:not(.expanded) .payment-group-content {
        display: none !important;
    }

    .payment-method-card {
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 12px;
        min-height: 64px;
    }
    .payment-method-card:hover {
        border-color: #00885a !important;
        background: #f0fdf9;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
    }
    .payment-method-card:has(input:checked),
    .payment-method-card.active {
        border-color: #00885a !important;
        background: #f0fdf9 !important;
        box-shadow: 0 0 0 1.5px #00885a;
    }
    .payment-method-card input[type="radio"]:checked {
        background-color: #00885a;
        border-color: #00885a;
    }
    .payment-logo-box {
        width: 72px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-shrink: 0;
    }
    .payment-logo {
        max-width: 64px;
        max-height: 26px;
        object-fit: contain;
    }

    .btn-back {
        border: 1.5px solid #00885a;
        color: #00885a;
        transition: ease-in-out 0.4s;
    }

    .btn-back:hover {
        background-color: #00885a;
        color: white;
        transform: translateX(-4px);
    }

    .btn-back:hover i {
        color: white;
        transform: translateX(-4px);
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
        <li><a href="{{ route('donasi.detail', ['slug' => $campaign['slug']]) }}">{{ Str::limit($campaign['title'], 30) }}</a></li>
        <li><span>/</span></li>
        <li>Formulir Donasi</li>
    </ul>
    <h2>Formulir Donasi</h2>
</div>
@endsection

@section('content')
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">

        <!-- Tombol Navigasi Kembali -->
        <div class="mb-4">
            <a href="{{ route('donasi.detail', ['slug' => $campaign['slug']]) }}" class="btn btn-back rounded-pill px-4 py-2 fw-semibold btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Donasi
            </a>
        </div>

        <div class="row g-4">

            <div class="col-lg-8">
                <div class="form-section-card">
                    <div class="border-bottom pb-3 mb-4">
                        <h4 class="fw-bold text-dark mb-1">
                        Tunaikan Donasi Anda
                        </h4>
                        <p class="text-muted small mb-0">
                            Silakan isi nominal dan data donatur Anda. Donasi Anda akan disalurkan penuh amanah langsung ke lapangan.
                        </p>
                    </div>

                    <form id="campaignDonationForm">
                        @csrf
                        <input type="hidden" name="campaign_id" value="{{ $campaign['id'] }}">
                        <input type="hidden" name="campaign_slug" value="{{ $campaign['slug'] }}">
                        <input type="hidden" name="campaign_title" value="{{ $campaign['title'] }}">

                        <!-- 1. Pilihan Nominal Cepat -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-2">Pilih Nominal Donasi Cepat (Rp)</label>
                            <div class="nominal-grid">
                                <div class="nominal-chip" data-nominal="10000">10.000</div>
                                <div class="nominal-chip active" data-nominal="25000">25.000</div>
                                <div class="nominal-chip" data-nominal="50000">50.000</div>
                                <div class="nominal-chip" data-nominal="100000">100.000</div>
                                <div class="nominal-chip" data-nominal="250000">250.000</div>
                                <div class="nominal-chip" data-nominal="500000">500.000</div>
                            </div>
                        </div>

                        <!-- 2. Nominal Manual Lainnya -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Nominal Donasi Lainnya (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold text-muted px-3">Rp</span>
                                <input type="number" 
                                       id="inputNominal" 
                                       name="nominal" 
                                       class="form-control fw-bold" 
                                       value="25000" 
                                       min="10000" 
                                       placeholder="Contoh: 100000" 
                                       required>
                            </div>
                            <small class="text-muted" style="font-size: 0.8rem;">Minimal nominal donasi adalah Rp 10.000</small>
                        </div>

                        <hr class="my-3 text-muted">

                        <!-- 3. Data Lengkap Donatur -->
                        <h5 class="fw-bold text-dark mb-3">
                          Data Donatur
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6" id="groupDonaturName">
                                <label class="form-label fw-bold text-dark small">
                                    Nama Lengkap Donatur <span class="text-danger" id="nameRequiredStar">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="inputDonaturName" 
                                       class="form-control" 
                                       placeholder="Masukkan nama lengkap Anda" 
                                       value="Ahmad Fauzi" 
                                       required>
                                <small id="anonimHelperText" class="text-muted d-none mt-1 d-block" style="font-size: 0.8rem;">
                                    <i class="bi bi-shield-check text-success me-1"></i>Nama Anda disembunyikan sebagai <strong>Hamba Allah</strong>.
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">
                                    Nomor WhatsApp / HP <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="notelp" 
                                       class="form-control" 
                                       placeholder="Contoh: 081234567890" 
                                       value="081234567890" 
                                       required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small">Email (Untuk Bukti Kuitansi & Laporan Donasi)</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control" 
                                       placeholder="email@gmail.com" 
                                       value="donatur@gmail.com">
                            </div>
                        </div>

                        <!-- 4. Pilihan Anonim (Hamba Allah) -->
                        <div class="form-check form-switch my-3 p-3 bg-light rounded-3 border">
                            <input class="form-check-input ms-0 me-3" type="checkbox" name="anonim" id="anonimCheck" value="Y" style="width: 2.3em; height: 1.25em;">
                            <label class="form-check-label fw-semibold text-dark" for="anonimCheck">
                                Sembunyikan nama saya dari daftar publik (Donasi sebagai Hamba Allah)
                            </label>
                        </div>

                        <!-- 5. Doa / Pesan Kebaikan -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Doa & Pesan Kebaikan (Opsional)</label>
                            <textarea name="doa" class="form-control" rows="3" placeholder="Tuliskan doa atau pesan dukungan Anda untuk saudara-saudara kita..."></textarea>
                        </div>

                        <!-- 6. Pilihan Metode Pembayaran (Trigger Box & Popup Modal) -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small mb-2">
                                Pilih Metode Pembayaran <span class="text-danger">*</span>
                            </label>

                            <!-- Hidden Input untuk kirim nilai metode pembayaran ke server -->
                            <input type="hidden" name="payment_method" id="selectedPaymentMethodInput" value="">

                            <!-- Trigger Box -->
                            <div id="btnTriggerPaymentModal" 
                                 class="payment-trigger-box border rounded-3 p-3 d-flex align-items-center justify-content-between cursor-pointer bg-white" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#modalPaymentMethod">
                                <div class="d-flex align-items-center flex-grow-1 overflow-hidden me-2">
                                    <div id="placeholderPaymentIcon" class="d-inline-flex align-items-center justify-content-center flex-shrink-0 me-2 text-muted">
                                        <iconify-icon icon="ion:card" class="fs-4 align-middle lh-1"></iconify-icon>
                                    </div>
                                    <div id="selectedPaymentLogoContainer" class="payment-logo-box justify-content-center flex-shrink-0 me-2 d-none">
                                        <img src="" alt="" id="selectedPaymentLogoImg" class="payment-logo">
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fw-semibold text-secondary text-truncate" id="selectedPaymentLabel">
                                            Klik dan pilih metode pembayaran
                                        </div>
                                        <small class="text-muted d-none" id="selectedPaymentSublabel"></small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-shrink-0 text-muted">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle me-2 d-none" id="badgeSelectedReady">
                                        <iconify-icon icon="material-symbols:check-circle" class="align-middle lh-1 me-1"></iconify-icon>Terpilih
                                    </span>
                                    <i class="bi bi-chevron-right fs-6"></i>
                                </div>
                            </div>

                            <small id="paymentValidationMsg" class="text-danger d-none mt-1 fw-medium d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>Mohon Pilih Metode Pembayaran Anda
                            </small>
                        </div>

                        <!-- 7. Tombol Submit Bayar -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="button" 
                                    id="btnSubmitDonasi" 
                                    class="btn btn-pembayaran btn-lg py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center justify-content-center mb-3">
                                <iconify-icon icon="keyline-icons:hand-coins-duotone" class="me-2" style="font-size: 1.45rem; vertical-align: middle;"></iconify-icon> Lanjutkan Pembayaran
                            </button>
                        </div>

                        <div class="text-center mt-3 text-muted small d-flex align-items-center justify-content-center">
                           <iconify-icon icon="material-symbols-light:shield-locked"
                           class="text-success me-1" width="24"></iconify-icon>
                            <span>Transaksi Kami Jamin Aman & Terenkripsi.</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- KOLOM KANAN: RINGKASAN PROGRAM DONASI      -->
            <!-- ========================================== -->
            @php
                $percent = min(100, round(($campaign['collected'] / $campaign['target']) * 100));
            @endphp
            <div class="col-lg-4">
                <div class="campaign-summary-card">
                    <img src="{{ asset($campaign['image']) }}" 
                         alt="{{ $campaign['title'] }}" 
                         class="summary-banner"
                         onerror="this.src='{{ asset('website/assets/images/backgrounds/main-slider-2-1.jpg') }}'">
                    
                    <div class="p-4">
                        <span class="badge {{ $campaign['category_badge'] }} px-3 py-1 rounded-pill fw-bold text-uppercase mb-2" style="font-size: 0.72rem;">
                            {{ $campaign['category_label'] }}
                        </span>

                        <h5 class="fw-bold text-dark mb-2" style="line-height: 1.4;">
                            {{ $campaign['title'] }}
                        </h5>

                        <div class="small text-muted mb-3 d-flex align-items-center">
                            <span>Oleh: <strong class="text-dark">{{ $campaign['organizer'] }}</strong></span>
                            <i class="bi bi-patch-check-fill text-primary ms-1" title="Penggalang Terverifikasi"></i>
                        </div>

                        <!-- Progress Dana -->
                        <div class="p-3 bg-light rounded-3 border mb-3">
                            <div class="d-flex justify-content-between align-items-baseline mb-1">
                                <span class="text-muted small">Dana Terkumpul</span>
                                <span class="fw-bold text-success">{{ $percent }}%</span>
                            </div>
                            <h4 class="fw-bold text-success mb-2" style="color: #0d5c38 !important;">
                                Rp {{ number_format($campaign['collected'], 0, ',', '.') }}
                            </h4>

                            <div class="progress my-2" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar progress-bar-kitabisa" 
                                     role="progressbar" 
                                     style="width: {{ $percent }}%;" 
                                     aria-valuenow="{{ $percent }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"></div>
                            </div>

                            <div class="d-flex justify-content-between text-muted small mt-2">
                                <div>Target: <strong class="text-dark">Rp {{ number_format($campaign['target'], 0, ',', '.') }}</strong></div>
                                <div><strong class="text-dark">{{ $campaign['donatur_count'] }}</strong> Donatur</div>
                            </div>
                        </div>

                        <!-- Fitur Keamanan -->
                        <div class="text-muted small">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>Penyaluran 100% amanah & transparan</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/midtrans-logo.png') }}" alt="Midtrans" style="height: 20px; width: auto; object-fit: contain;" class="me-2">
                                <span>Didukung oleh <strong>Midtrans Payment Gateway</strong></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Modal Popup: Metode Pembayaran (Style Rumah Zakat) -->
<div class="modal fade" id="modalPaymentMethod" tabindex="-1" aria-labelledby="modalPaymentMethodLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" style="max-width: 760px;">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-bottom py-3 px-4 bg-white sticky-top d-flex align-items-center">
                <h5 class="modal-title fw-bold text-dark fs-5 mb-0" id="modalPaymentMethodLabel">
                    Metode Pembayaran
                </h5>
                <button type="button" class="btn-close ms-auto shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-3 p-md-4" style="background-color: #f8fafc;">
                <div class="payment-groups-wrapper d-flex flex-column gap-3">
                    
                    <!-- 1. KELOMPOK QRIS -->
                    <div class="payment-group-card expanded overflow-hidden shadow-sm" id="card-group-qris">
                        <div class="payment-group-header p-3 d-flex align-items-center justify-content-between cursor-pointer" data-target="group-qris">
                            <div class="flex-grow-1 pe-2">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="fw-bold text-dark fs-6">QRIS</span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle selected-indicator d-none" id="badge-qris" style="font-size: 0.7rem;">
                                        <i class="bi bi-check2-circle me-1"></i><span class="selected-text">QRIS</span>
                                    </span>
                                </div>
                                <div class="text-muted small mt-1" style="font-size: 0.78rem;">
                                    (Minimal Transaksi 10.000) 
                                </div>
                            </div>
                            <div class="d-flex align-items-center ms-2 flex-shrink-0">
                                <div class="d-none d-sm-flex align-items-center gap-1 me-2">
                                    <img src="{{ asset('images/payment/QRIS.svg') }}" alt="QRIS" style="height: 34px; max-width: 35px; object-fit: contaiain;">
                                </div>
                                <i class="bi bi-chevron-down group-chevron text-muted fs-5"></i>
                            </div>
                        </div>
                        
                        <div class="payment-group-content border-top p-3 bg-light-subtle" id="group-qris">
                            <div class="row g-2">
                                <!-- 1. QRIS (Semua Pembayaran) -->
                                <div class="col-12">
                                    <label class="payment-method-card d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="QRIS" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">QRIS</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Scan barcode via GoPay, ShopeePay, Dana, OVO, LinkAja, BCA, dll.</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/QRIS.svg') }}" alt="QRIS" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                
                            </div>
                        </div>
                    </div>

                    <!-- 2. KELOMPOK VIRTUAL ACCOUNT (10 Bank Simulator Midtrans) -->
                    <div class="payment-group-card overflow-hidden shadow-sm" id="card-group-va">
                        <div class="payment-group-header p-3 d-flex align-items-center justify-content-between cursor-pointer" data-target="group-va">
                            <div class="flex-grow-1 pe-2">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="fw-bold text-dark fs-6">Virtual Account</span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle selected-indicator d-none" id="badge-va" style="font-size: 0.7rem;">
                                        <i class="bi bi-check2-circle me-1"></i><span class="selected-text"></span>
                                    </span>
                                </div>
                                <div class="text-muted small mt-1" style="font-size: 0.78rem;">
                                    (Minimal Transaksi 10.000)
                                </div>
                            </div>
                            <div class="d-flex align-items-center ms-2 flex-shrink-0">
                                <div class="d-none d-sm-flex align-items-center gap-1 me-2">
                                    <img src="{{ asset('images/payment/bca.png') }}" alt="BCA" style="height: 15px; max-width: 30px; object-fit: contain;">
                                    <img src="{{ asset('images/payment/bri.png') }}" alt="BRI" style="height: 15px; max-width: 30px; object-fit: contain;">
                                    <img src="{{ asset('images/payment/bni.png') }}" alt="BNI" style="height: 15px; max-width: 30px; object-fit: contain;">
                                    <img src="{{ asset('images/payment/Mandiri.svg') }}" alt="Mandiri" style="height: 15px; max-width: 32px; object-fit: contain;">
                                </div>
                                <i class="bi bi-chevron-down group-chevron text-muted fs-5"></i>
                            </div>
                        </div>
                        
                        <div class="payment-group-content border-top p-3 bg-light-subtle" id="group-va">
                            <div class="row g-2">
                                <!-- 1. BCA VA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="BCA VA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">BCA VA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer m-BCA, KlikBCA, ATM BCA</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/bca.png') }}" alt="BCA VA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 2. BRI VA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="BRI VA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">BRI VA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer BRImo, ATM BRI (BRIVA)</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/bri.png') }}" alt="BRI VA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 3. BNI VA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="BNI VA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">BNI VA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer BNI Mobile Banking, ATM</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/bni.png') }}" alt="BNI VA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 4. Permata VA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="Permata VA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">Permata VA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer PermataMobile X, ATM</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/permata.svg') }}" alt="Permata VA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 5. CIMB VA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="CIMB VA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">CIMB VA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer OCTO Mobile, ATM CIMB</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/cimb.svg') }}" alt="CIMB VA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 6. Mandiri Bill -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="Mandiri Bill" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">Mandiri Bill</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer Livin' by Mandiri, ATM (Bill)</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/Mandiri.svg') }}" alt="Mandiri Bill" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 7. Danamon VA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="Danamon VA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">Danamon VA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer D-Bank PRO, ATM Danamon</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/danamon.svg') }}" alt="Danamon VA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 8. BSI VA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="BSI VA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">BSI VA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer BSI Mobile, ATM BSI</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/bsi.png') }}" alt="BSI VA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 9. SeaBank VA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="SeaBank VA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">SeaBank VA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer SeaBank App, Shopee</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/seabank.svg') }}" alt="SeaBank VA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 10. Saqu VA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="Saqu VA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">Saqu VA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer Bank Saqu App (Astra)</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/saqu.svg') }}" alt="Saqu VA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. KELOMPOK EWALLET -->
                    <div class="payment-group-card overflow-hidden shadow-sm" id="card-group-ewallet">
                        <div class="payment-group-header p-3 d-flex align-items-center justify-content-between cursor-pointer" data-target="group-ewallet">
                            <div class="flex-grow-1 pe-2">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="fw-bold text-dark fs-6">eWallet</span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle selected-indicator d-none" id="badge-ewallet" style="font-size: 0.7rem;">
                                        <i class="bi bi-check2-circle me-1"></i><span class="selected-text"></span>
                                    </span>
                                </div>
                                <div class="text-muted small mt-1" style="font-size: 0.78rem;">
                                    (Minimal Transaksi 10.000)
                                </div>
                            </div>
                            <div class="d-flex align-items-center ms-2 flex-shrink-0">
                                <div class="d-none d-sm-flex align-items-center gap-2 me-2">
                                    <img src="{{ asset('images/payment/Gopay.svg') }}" alt="GoPay" style="height: 15px; max-width: 32px; object-fit: contain;">
                                    <img src="{{ asset('images/payment/ovo.svg') }}" alt="OVO" style="height: 15px; max-width: 32px; object-fit: contain;">
                                    <img src="{{ asset('images/payment/shopeepay.svg') }}" alt="ShopeePay" style="height: 15px; max-width: 32px; object-fit: contain;">
                                </div>
                                <i class="bi bi-chevron-down group-chevron text-muted fs-5"></i>
                            </div>
                        </div>
                        
                        <div class="payment-group-content border-top p-3 bg-light-subtle" id="group-ewallet">
                            <div class="row g-2">
                                <!-- 2. GoPay -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="QRIS GoPay" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">GoPay</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Scan via aplikasi Gojek & GoPay</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/Gopay.svg') }}" alt="GoPay" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 3. ShopeePay -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="QRIS ShopeePay" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">ShopeePay</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Scan via aplikasi ShopeePay & Shopee</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/shopeepay.svg') }}" alt="ShopeePay" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 4. Dana -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="QRIS Dana" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">Dana</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Scan via dompet digital DANA</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/dana.svg') }}" alt="Dana" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 5. OVO -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="QRIS OVO" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">OVO</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Scan via aplikasi OVO & Grab</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/ovo.svg') }}" alt="OVO" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- 6. LinkAja -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="modal_payment_radio" value="QRIS LinkAja" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small method-title" style="line-height: 1.3;">LinkAja</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Scan via aplikasi LinkAja</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/linkaja.svg') }}" alt="LinkAja" class="payment-logo">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Batal Pembayaran -->
<div class="modal fade" id="modalBatalPembayaran" tabindex="-1" aria-labelledby="modalBatalPembayaranLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content rounded-4 border-0 shadow-lg text-center p-3">
            <div class="modal-body py-4 px-3">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle bg-warning-subtle text-warning" style="width: 72px; height: 72px;">
                    <i class="bi bi-exclamation-triangle-fill fs-1 text-warning"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2" id="modalBatalPembayaranLabel">
                    Batalkan Pembayaran?
                </h5>
                <p class="text-secondary small mb-4 px-2" style="font-size: 0.95rem; line-height: 1.5;">
                    Apakah Anda ingin membatalkan pembayaran?
                </p>
                <div class="row g-2">
                    <div class="col-6">
                        <button type="button" id="btnKonfirmasiBatalYa" class="btn btn-outline-danger w-100 py-2 fw-bold rounded-pill">
                            Ya
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" id="btnKonfirmasiBatalTidak" class="btn btn-success w-100 py-2 fw-bold rounded-pill" style="background-color: #00885a; border-color: #00885a;">
                            Tidak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Iconify JS CDN -->
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
<!-- Midtrans Snap JS SDK -->
<script src="{{ ($isProduction ?? false) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $clientKey }}"></script>

<script>
// Interaksi Pilihan Chip Nominal
document.querySelectorAll('.nominal-chip').forEach(function(chip) {
    chip.addEventListener('click', function() {
        document.querySelectorAll('.nominal-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('inputNominal').value = this.getAttribute('data-nominal');
    });
});

document.getElementById('inputNominal').addEventListener('input', function() {
    var val = this.value;
    document.querySelectorAll('.nominal-chip').forEach(function(chip) {
        if (chip.getAttribute('data-nominal') === val) {
            chip.classList.add('active');
        } else {
            chip.classList.remove('active');
        }
    });
});

// Interaksi Toggle Anonim (Hamba Allah)
var anonimCheck = document.getElementById('anonimCheck');
var inputDonaturName = document.getElementById('inputDonaturName');
var nameRequiredStar = document.getElementById('nameRequiredStar');
var anonimHelperText = document.getElementById('anonimHelperText');
var previousName = inputDonaturName ? inputDonaturName.value : '';

if (anonimCheck && inputDonaturName) {
    anonimCheck.addEventListener('change', function() {
        if (this.checked) {
            if (inputDonaturName.value && inputDonaturName.value !== 'Hamba Allah') {
                previousName = inputDonaturName.value;
            }
            inputDonaturName.value = 'Hamba Allah';
            inputDonaturName.readOnly = true;
            inputDonaturName.classList.add('bg-light', 'text-muted');
            inputDonaturName.removeAttribute('required');
            if (nameRequiredStar) nameRequiredStar.classList.add('d-none');
            if (anonimHelperText) anonimHelperText.classList.remove('d-none');
        } else {
            inputDonaturName.readOnly = false;
            inputDonaturName.classList.remove('bg-light', 'text-muted');
            inputDonaturName.value = (previousName && previousName !== 'Hamba Allah') ? previousName : '';
            inputDonaturName.setAttribute('required', 'required');
            if (nameRequiredStar) nameRequiredStar.classList.remove('d-none');
            if (anonimHelperText) anonimHelperText.classList.add('d-none');
            inputDonaturName.focus();
        }
    });
}

// Interaksi Dropdown/Accordion Kelompok Metode Pembayaran (Style Rumah Zakat)
function updatePaymentGroupStates() {
    document.querySelectorAll('.payment-group-card').forEach(function(group) {
        var groupRadio = group.querySelector('input[name="modal_payment_radio"]:checked');
        var badge = group.querySelector('.selected-indicator');
        var badgeText = group.querySelector('.selected-text');
        
        if (groupRadio) {
            group.classList.add('has-selected');
            if (badge) badge.classList.remove('d-none');
            var card = groupRadio.closest('.payment-method-card');
            var titleEl = card ? card.querySelector('.method-title') : null;
            if (badgeText && titleEl) {
                badgeText.textContent = titleEl.textContent.trim();
            }
        } else {
            group.classList.remove('has-selected');
            if (badge) badge.classList.add('d-none');
        }
    });

    document.querySelectorAll('.payment-method-card').forEach(function(card) {
        var r = card.querySelector('input[name="modal_payment_radio"]');
        if (r && r.checked) {
            card.classList.add('active');
        } else {
            card.classList.remove('active');
        }
    });
}

// Click Header Toggle Accordion di dalam Modal
document.querySelectorAll('.payment-group-header').forEach(function(header) {
    header.addEventListener('click', function(e) {
        e.stopPropagation();
        var groupCard = this.closest('.payment-group-card');
        if (groupCard) {
            groupCard.classList.toggle('expanded');
        }
    });
});

// Pemilihan Saluran Pembayaran di dalam Modal
document.querySelectorAll('.payment-method-card').forEach(function(card) {
    card.addEventListener('click', function(e) {
        var radio = this.querySelector('input[name="modal_payment_radio"]');
        if (radio) {
            radio.checked = true;
            var val = radio.value;
            var titleEl = this.querySelector('.method-title');
            var title = titleEl ? titleEl.textContent.trim() : val;
            var smallEl = this.querySelector('small');
            var sublabel = smallEl ? smallEl.textContent.trim() : '';
            var logoEl = this.querySelector('.payment-logo');

            // 1. Set hidden input pada form utama
            var hiddenInput = document.getElementById('selectedPaymentMethodInput');
            if (hiddenInput) hiddenInput.value = val;

            // 2. Update tampilan Trigger Box pada form
            var labelEl = document.getElementById('selectedPaymentLabel');
            if (labelEl) {
                labelEl.textContent = title;
                labelEl.classList.remove('text-secondary');
                labelEl.classList.add('text-dark', 'fw-bold');
            }

            var sublabelEl = document.getElementById('selectedPaymentSublabel');
            if (sublabelEl && sublabel) {
                sublabelEl.textContent = sublabel;
                sublabelEl.classList.remove('d-none');
            }

            var placeholderIcon = document.getElementById('placeholderPaymentIcon');
            var logoContainer = document.getElementById('selectedPaymentLogoContainer');
            var logoImg = document.getElementById('selectedPaymentLogoImg');

            if (logoEl && logoImg && logoContainer) {
                logoImg.src = logoEl.src;
                logoImg.alt = logoEl.alt || title;
                logoContainer.classList.remove('d-none');
                if (placeholderIcon) placeholderIcon.classList.add('d-none');
            }

            var badgeReady = document.getElementById('badgeSelectedReady');
            if (badgeReady) badgeReady.classList.remove('d-none');

            var triggerBox = document.getElementById('btnTriggerPaymentModal');
            if (triggerBox) {
                triggerBox.classList.add('has-selected');
                triggerBox.classList.remove('is-invalid');
            }

            var valMsg = document.getElementById('paymentValidationMsg');
            if (valMsg) valMsg.classList.add('d-none');

            updatePaymentGroupStates();

            // 3. Tutup Modal dengan transisi halus
            var modalEl = document.getElementById('modalPaymentMethod');
            if (modalEl && window.bootstrap) {
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    setTimeout(function() {
                        modalInstance.hide();
                    }, 180);
                }
            }
        }
    });
});

// Submit Form Donasi via Midtrans Snap Popup
var btnSubmit = document.getElementById('btnSubmitDonasi');
if (btnSubmit) {
    btnSubmit.addEventListener('click', function(e) {
        e.preventDefault();

        var btn = this;
        var originalText = btn.innerHTML;
        var form = document.getElementById('campaignDonationForm');

        // Validasi Form sederhana
        var nominal = parseInt(document.getElementById('inputNominal').value) || 0;
        if (nominal < 10000) {
            alert('Mohon masukkan nominal donasi minimal Rp 10.000');
            return;
        }

        // Jika tidak anonim dan nama kosong, beri peringatan
        if (anonimCheck && !anonimCheck.checked && (!inputDonaturName.value || !inputDonaturName.value.trim())) {
            alert('Mohon isi nama lengkap Anda atau centang Sembunyikan nama (Hamba Allah).');
            inputDonaturName.focus();
            return;
        }

        // Validasi Pilihan Metode Pembayaran
        var selectedMethod = document.getElementById('selectedPaymentMethodInput') ? document.getElementById('selectedPaymentMethodInput').value : '';
        if (!selectedMethod) {
            var valMsg = document.getElementById('paymentValidationMsg');
            if (valMsg) valMsg.classList.remove('d-none');
            var triggerBox = document.getElementById('btnTriggerPaymentModal');
            if (triggerBox) {
                triggerBox.classList.add('is-invalid');
                triggerBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            // Otomatis buka modal pilihan pembayaran
            var modalEl = document.getElementById('modalPaymentMethod');
            if (modalEl && window.bootstrap) {
                var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                modalInstance.show();
            }
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghubungkan ke Midtrans...';

        var formData = new FormData(form);

        fetch("{{ route('donasi.snap-token') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = originalText;

            if (data.status === 'success' && data.snap_token) {
                currentSnapToken = data.snap_token;
                currentOrderId = data.order_id;
                currentInvoiceUrl = data.invoice_url;

                // Buka Popup Snap Midtrans
                openSnapPayment(currentSnapToken, currentOrderId);
            } else {
                alert('Pemberitahuan: ' + (data.message || 'Gagal memproses donasi ke Midtrans.'));
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = originalText;
            console.error('Error:', error);
            alert('Terjadi kesalahan koneksi ke server.');
        });
    });
}

// State untuk menyimpan token aktif transaksi
var currentSnapToken = null;
var currentOrderId = null;
var currentInvoiceUrl = null;

// Fungsi untuk membuka Popup Midtrans Snap
function openSnapPayment(snapToken, orderId) {
    if (!window.snap) {
        alert('Midtrans Snap SDK belum siap. Silakan refresh halaman.');
        return;
    }

    window.snap.pay(snapToken, {
        onSuccess: function(result) {
            window.location.href = "{{ route('donasi.finish') }}?order_id=" + orderId + "&transaction_status=settlement&status_code=200";
        },
        onPending: function(result) {
            window.location.href = "{{ route('donasi.finish') }}?order_id=" + orderId + "&transaction_status=pending";
        },
        onError: function(result) {
            window.location.href = "{{ route('donasi.finish') }}?order_id=" + orderId + "&transaction_status=deny";
        },
        onClose: function() {
            // Ketika donatur menutup popup sebelum selesai, bersihkan style overflow dari Snap
            restorePageScroll();

            // Munculkan modal konfirmasi pembatalan
            var modalBatalEl = document.getElementById('modalBatalPembayaran');
            if (modalBatalEl && window.bootstrap) {
                var modalBatal = bootstrap.Modal.getOrCreateInstance(modalBatalEl);
                modalBatal.show();
            }
        }
    });
}

// Fungsi Helper: Mengembalikan scroll halaman jika tertahan oleh Midtrans Snap / Bootstrap Modal
function restorePageScroll() {
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('overflow');
    document.body.style.removeProperty('padding-right');
    document.documentElement.style.removeProperty('overflow');
    
    // Hapus sisa-sisa backdrop gelap yang tertinggal
    document.querySelectorAll('.modal-backdrop').forEach(function(el) {
        el.remove();
    });

    // Bersihkan iframe snap jika masih ada
    var snapContainer = document.getElementById('snap-midtrans');
    if (snapContainer) {
        snapContainer.style.display = 'none';
    }
}

// Pasang listener saat modal ditutup agar scroll halaman selalu normal kembali
var modalBatalEl = document.getElementById('modalBatalPembayaran');
if (modalBatalEl) {
    modalBatalEl.addEventListener('hidden.bs.modal', function() {
        restorePageScroll();
    });
}
var modalPaymentEl = document.getElementById('modalPaymentMethod');
if (modalPaymentEl) {
    modalPaymentEl.addEventListener('hidden.bs.modal', function() {
        restorePageScroll();
    });
}

// Tombol "Ya" pada Popup Konfirmasi (Batalkan -> Balik ke Tampilan Form Pembayaran)
var btnBatalYa = document.getElementById('btnKonfirmasiBatalYa');
if (btnBatalYa) {
    btnBatalYa.addEventListener('click', function() {
        var modalBatalEl = document.getElementById('modalBatalPembayaran');
        if (modalBatalEl && window.bootstrap) {
            var modalBatal = bootstrap.Modal.getInstance(modalBatalEl);
            if (modalBatal) modalBatal.hide();
        }

        // Pulihkan scroll halaman secara instan dan setelah animasi modal selesai
        restorePageScroll();
        setTimeout(restorePageScroll, 350);

        var btn = document.getElementById('btnSubmitDonasi');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<iconify-icon icon="keyline-icons:hand-coins-duotone" class="me-2" style="font-size: 1.45rem; vertical-align: middle;"></iconify-icon> Lanjutkan Pembayaran';
        }
    });
}

// Tombol "Tidak" pada Popup Konfirmasi (Tidak Batal -> Lanjut Pembayarannya)
var btnBatalTidak = document.getElementById('btnKonfirmasiBatalTidak');
if (btnBatalTidak) {
    btnBatalTidak.addEventListener('click', function() {
        var modalBatalEl = document.getElementById('modalBatalPembayaran');
        if (modalBatalEl && window.bootstrap) {
            var modalBatal = bootstrap.Modal.getInstance(modalBatalEl);
            if (modalBatal) modalBatal.hide();
        }

        // Buka kembali jendela pembayaran Midtrans Snap
        if (currentSnapToken && currentOrderId) {
            setTimeout(function() {
                openSnapPayment(currentSnapToken, currentOrderId);
            }, 250);
        }
    });
}
</script>
@endpush
