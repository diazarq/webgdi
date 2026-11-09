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
    .payment-method-card {
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        border: 1.5px solid #e5e7eb !important;
        border-radius: 12px;
        min-height: 70px;
    }
    .payment-method-card:hover {
        border-color: #00C89D !important;
        background: #f0fdf9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .payment-method-card:has(input:checked),
    .payment-method-card.active {
        border-color: #0d5c38 !important;
        background: #f0fdf9;
        box-shadow: 0 0 0 1.5px #0d5c38;
    }
    .payment-method-card input[type="radio"]:checked {
        background-color: #0d5c38;
        border-color: #0d5c38;
    }
    .payment-logo-box {
        width: 72px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
    .payment-logo {
        max-width: 100%;
        max-height: 100%;
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

            <!-- ========================================== -->
            <!-- KOLOM KIRI: FORMULIR UTAMA DONASI (LEBAR)   -->
            <!-- ========================================== -->
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

                        <!-- 6. Pilihan Metode Pembayaran -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small mb-2">
                                <i class="bi bi-wallet2 text-success me-1"></i>Pilih Metode Pembayaran <span class="text-danger">*</span>
                            </label>
                            
                            <div class="row g-2 g-md-3">
                                <!-- QRIS -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="payment_method" value="QRIS" class="form-check-input me-3 my-0 flex-shrink-0" checked>
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small" style="line-height: 1.3;">QRIS (Semua Pembayaran)</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">GoPay, OVO, Dana, ShopeePay, BCA, dll.</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/qris.png') }}" alt="QRIS" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- VA BCA -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="payment_method" value="VA BCA" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small" style="line-height: 1.3;">Virtual Account BCA</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer m-BCA, KlikBCA, ATM</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/bca.png') }}" alt="BCA" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- VA Mandiri -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="payment_method" value="VA Mandiri" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small" style="line-height: 1.3;">Virtual Account Mandiri</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer Livin' by Mandiri, ATM</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/Mandiri.svg') }}" alt="Mandiri" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- VA BNI -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="payment_method" value="VA BNI" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small" style="line-height: 1.3;">Virtual Account BNI</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer BNI Mobile Banking, ATM</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/bni.png') }}" alt="BNI" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- VA BRI -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="payment_method" value="VA BRI" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small" style="line-height: 1.3;">Virtual Account BRI (BRIVA)</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Transfer BRImo, ATM BRI</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/bri.png') }}" alt="BRI" class="payment-logo">
                                        </div>
                                    </label>
                                </div>

                                <!-- GoPay -->
                                <div class="col-12 col-md-6">
                                    <label class="payment-method-card h-100 d-flex align-items-center p-3 w-100 mb-0">
                                        <input type="radio" name="payment_method" value="GoPay" class="form-check-input me-3 my-0 flex-shrink-0">
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-bold text-dark small" style="line-height: 1.3;">GoPay / E-Wallet</div>
                                            <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.3;">Aplikasi Gojek & QRIS E-Wallet</small>
                                        </div>
                                        <div class="payment-logo-box ms-auto flex-shrink-0">
                                            <img src="{{ asset('images/payment/Gopay.svg') }}" alt="GoPay" class="payment-logo">
                                        </div>
                                    </label>
                                </div>
                            </div>
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

// Interaksi Active State Metode Pembayaran
document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('active'));
        if (this.checked) {
            var card = this.closest('.payment-method-card');
            if (card) card.classList.add('active');
        }
    });
});
var initialRadio = document.querySelector('input[name="payment_method"]:checked');
if (initialRadio) {
    var initialCard = initialRadio.closest('.payment-method-card');
    if (initialCard) initialCard.classList.add('active');
}

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
                var invoiceUrl = data.invoice_url;
                var orderId = data.order_id;

                // Panggil Popup Snap Midtrans
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('donasi.finish') }}?order_id=" + orderId + "&transaction_status=settlement&status_code=200";
                    },
                    onPending: function(result) {
                        // Donatur telah memilih metode pembayaran (misal VA / QRIS)
                        window.location.href = "{{ route('donasi.finish') }}?order_id=" + orderId + "&transaction_status=pending";
                    },
                    onError: function(result) {
                        // Transaksi gagal atau ditolak
                        window.location.href = "{{ route('donasi.finish') }}?order_id=" + orderId + "&transaction_status=deny";
                    },
                    onClose: function() {
                        // Donatur sengaja menutup popup pembayaran sebelum menyelesaikannya
                        if (confirm('Anda menutup jendela pembayaran.\n\nKlik OK untuk menuju ke halaman instruksi pembayaran (Anda dapat melanjutkannya kapan saja), atau Cancel untuk tetap di formulir.')) {
                            window.location.href = invoiceUrl;
                        } else {
                            btn.disabled = false;
                            btn.innerHTML = originalText;
                        }
                    }
                });
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
</script>
@endpush
