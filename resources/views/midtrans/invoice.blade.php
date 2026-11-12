@extends('layout.layout-page')
@php
    $status = $payment->status;
    $isComplete = ($status === 'complete');
    $isPending = ($status === 'pending');
    $isFailed = in_array($status, ['failed', 'expire', 'deny', 'cancel']);
@endphp

@section('title', ($isComplete ? 'Bukti Donasi Berhasil' : ($isPending ? 'Instruksi Pembayaran Donasi' : 'Status Donasi')) . ' - Graha Dhuafa Indonesia')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .btn-pembayaran {
        background-color: #00885a !important;
        color: white !important;
        border: 2px solid #00885a !important;
        transition: all 0.3s ease-in-out;
    }

    .btn-pembayaran:hover {
        background: transparent !important;
        color: #00885a !important;
        border: 2px solid #00885a !important;
        transform: translateY(-2px);
    }
    .btn-pending {
        background: transparent !important;
        color: #017aff !important;
        border: 1.5px solid #017aff !important;
        transition: all 0.3s ease-in-out;
    }

    .btn-pending:hover {
        background-color: #017aff !important;
        color: white !important;
        border: 2px solid #017aff !important;
        transform: translateY(2px);
    }
</style>
@endpush

@section('breadcrumb')
<div class="text-center">
    <ul class="thm-breadcrumb list-unstyled">
        <li><a href="/">Beranda</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('donasi.index') }}">Donasi</a></li>
        <li><span>/</span></li>
        <li>{{ $isComplete ? 'Kuitansi Berhasil' : ($isPending ? 'Menunggu Pembayaran' : 'Status Pembayaran') }}</li>
    </ul>
    <h2>{{ $isComplete ? 'Kuitansi Donasi Berhasil' : ($isPending ? 'Instruksi Pembayaran Donasi' : 'Status Donasi') }}</h2>
</div>
@endsection

@section('content')
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">

                <!-- Alert Notifikasi Realtime Check -->
                @if(session('status_msg'))
                    <div class="alert alert-{{ session('status_msg.type') == 'error' ? 'danger' : session('status_msg.type') }} alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            @if(session('status_msg.type') == 'success')
                                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                            @elseif(session('status_msg.type') == 'error')
                                <i class="bi bi-x-circle-fill fs-5 me-2 text-danger"></i>
                            @else
                                <i class="bi bi-info-circle-fill fs-5 me-2 text-primary"></i>
                            @endif
                            <span>{{ session('status_msg.text') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white print-area">
                    
                    <!-- ========================================== -->
                    <!-- KOP SURAT RESMI YAYASAN GRAHA DHUAFA       -->
                    <!-- ========================================== -->
                    <div class="kuitansi-kop-header p-3 p-md-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('website/assets/images/custom/logo_gdi.png') }}" alt="Graha Dhuafa Indonesia" style="height: 50px; width: auto; object-fit: contain;" class="me-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.2px; font-size: 1.05rem;">YAYASAN GRAHA DHUAFA INDONESIA</h5>
                                <small class="text-muted d-block" style="font-size: 0.74rem; line-height: 1.35;">
                                    Lembaga Filantropi & Pengelolaan Program Donasi Ummat<br>
                                    SK Kemenkumham RI No. AHU-0010959.AH.01.04.Tahun 2021 &bull; info@grahadhuafa.org
                                </small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 fs-6 fw-bold">
                                KUITANSI RESMI
                            </span>
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Dokumen Sah Digital</small>
                        </div>
                    </div>
                    
                    <!-- ========================================== -->
                    <!-- HEADER STATUS KARTU (BANNER)              -->
                    <!-- ========================================== -->
                    @if($isComplete)
                        <!-- 1. STATUS LUNAS / BERHASIL (HIJAU) -->
<<<<<<< Updated upstream
                        <div class="kuitansi-status-banner py-3 px-4 text-center text-white" style="background: linear-gradient(135deg, #06301f 0%, #0d5c38 100%);">
                            <div class="mb-2">
                                <span class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 58px; height: 58px;">
                                    <!-- Ikon Centang SVG Native: Selalu tampil tajam di print/PDF -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#00885a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
=======
                        <div class="p-4 text-center text-white invoice-card-header" style="background: linear-gradient(135deg, #06301f 0%, #0d5c38 100%);">
                            <div class="mb-3">
                                <span class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center success-badge-pulse" style="width: 76px; height: 76px;">
                                    <iconify-icon id="successIcon" icon="line-md:circle-to-confirm-circle-transition" class="d-print-none" style="font-size: 52px; color: #198754;"></iconify-icon>
                                    <!-- Icon Cetak Khusus Print / PDF (Anti Hilang) -->
                                    <svg class="d-none d-print-inline-block" width="46" height="46" viewBox="0 0 24 24" fill="none" stroke="#198754" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
>>>>>>> Stashed changes
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-white" style="font-size: 1.25rem;">Alhamdulillah, Donasi Berhasil!</h4>
                            <p class="mb-0 text-white-50" style="font-size: 0.85rem;">Terima kasih atas kepedulian dan donasi yang Anda tunaikan</p>
                        </div>

                    @elseif($isPending)
                        <!-- 2. STATUS MENUNGGU PEMBAYARAN (KUNING / ORANYE) -->
                        <div class="kuitansi-status-banner py-3 px-4 text-center text-white" style="background: linear-gradient(135deg, #78350f 0%, #d97706 100%);">
                            <div class="mb-2">
                                <span class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 58px; height: 58px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-white" style="font-size: 1.25rem;">Menunggu Pembayaran Donasi</h4>
                            <p class="mb-0 text-white-50" style="font-size: 0.85rem;">Silakan selesaikan pembayaran sebelum transaksi berakhir</p>
                        </div>

                    @else
                        <!-- 3. STATUS GAGAL / KADALUWARSA / CANCEL (MERAH) -->
                        <div class="kuitansi-status-banner py-3 px-4 text-center text-white" style="background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 100%);">
                            <div class="mb-2">
                                <span class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 58px; height: 58px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-white" style="font-size: 1.25rem;">Pembayaran Donasi Tidak Berhasil</h4>
                            <p class="mb-0 text-white-50" style="font-size: 0.85rem;">Transaksi telah dibatalkan, ditolak, atau waktu pembayaran kedaluwarsa</p>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- DETAIL TRANSAKSI                           -->
                    <!-- ========================================== -->
                    <div class="p-4 p-md-4 kuitansi-body-content">

                        <!-- Pesan Khusus Pending / Gagal -->
                        @if($isPending)
                            <div class="alert alert-warning border-warning bg-light p-3 rounded-3 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-exclamation-triangle-fill text-warning fs-5 me-2 mt-1"></i>
                                    <div>
                                        <div class="fw-bold text-dark mb-1">Transaksi Belum Selesai</div>
                                        <small class="text-muted d-block" style="line-height: 1.4;">
                                            Jika Anda tadi menutup jendela pembayaran, Anda dapat mengklik tombol <strong>Lanjutkan Pembayaran</strong> di bawah untuk membuka kembali instruksi nomor VA / QRIS, atau klik <strong>Cek Status Pembayaran</strong> jika Anda sudah mentransfer.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @elseif($isFailed)
                            <div class="alert alert-danger border-danger bg-light p-3 rounded-3 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-x-octagon-fill text-danger fs-5 me-2 mt-1"></i>
                                    <div>
                                        <div class="fw-bold text-dark mb-1">Donasi Belum Terpotong</div>
                                        <small class="text-muted d-block" style="line-height: 1.4;">
                                            Pembayaran donasi ini tidak berhasil diselesaikan. Jangan khawatir, saldo Anda tidak terpotong. Anda dapat mengulangi donasi dengan menekan tombol di bawah.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Nomor Order & Badge Status -->
                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.78rem;">Nomor Donasi (Order ID)</small>
                                <span class="fw-bold font-monospace text-dark" style="font-size: 0.95rem;">{{ $payment->transcode }}</span>
                            </div>
                            @if($isComplete)
                                <span class="badge bg-success px-3 py-1 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                    <i class="bi bi-check-circle-fill me-1"></i> LUNAS
                                </span>
                            @elseif($isPending)
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                    <i class="bi bi-hourglass-split me-1"></i> PENDING
                                </span>
                            @else
                                <span class="badge bg-danger px-3 py-1 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                    <i class="bi bi-x-circle-fill me-1"></i> GAGAL / EXPIRED
                                </span>
                            @endif
                        </div>

                        <!-- Rincian Tabel Donasi -->
                        <div class="table-responsive mb-3">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    <tr class="border-bottom">
                                        <td class="text-muted ps-0 py-2" style="width: 38%;">Nama Donatur</td>
                                        <td class="text-end fw-semibold pe-0 py-2">{{ $payment->name }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted ps-0 py-2">No. WhatsApp / HP</td>
                                        <td class="text-end fw-semibold pe-0 py-2">{{ $payment->notelp ?: '-' }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted ps-0 py-2">Program Donasi</td>
                                        <td class="text-end fw-semibold pe-0 py-2 text-capitalize">
                                            @if(!empty($campaign))
                                                @php
                                                    $cTitle = is_array($campaign) ? ($campaign['title'] ?? '') : ($campaign->title ?? '');
                                                    $cSlug = is_array($campaign) ? ($campaign['slug'] ?? '') : ($campaign->slug ?? '');
                                                @endphp
                                                <a href="{{ route('donasi.detail', $cSlug) }}" class="text-decoration-none fw-bold text-success">
                                                    {{ $cTitle }}
                                                </a>
                                            @else
                                                {{ str_replace('-', ' ', str_replace('_', ' ', $payment->type)) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted ps-0 py-2">Metode Pembayaran</td>
                                        <td class="text-end fw-semibold pe-0 py-2">
                                            @php
                                                $method = $payment->payment_method ?: 'Midtrans Online';
                                                if (stripos($method, 'snap') !== false || strtolower($method) === 'midtrans') {
                                                    $method = 'Midtrans Gateway';
                                                }
                                            @endphp
                                            <span class="badge bg-light text-dark border px-2 py-1 d-inline-flex align-items-center">
                                                <img src="{{ asset('images/midtrans-logo.png') }}" alt="Midtrans" style="height: 14px; width: auto; object-fit: contain;" class="me-1">
                                                {{ $method }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted ps-0 py-2">Waktu Transaksi</td>
                                        <td class="text-end fw-semibold pe-0 py-2">{{ $payment->updated_at ? $payment->updated_at->format('d M Y, H:i') : date('d M Y, H:i') }} WIB</td>
                                    </tr>
                                    <tr class="bg-light rounded-3">
                                        <td class="ps-3 py-2 fw-bold text-dark fs-6">Total Donasi</td>
                                        <td class="text-end pe-3 py-2 fw-bold text-success fs-5">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Doa Donatur (Hanya jika lunas) -->
                        @if($isComplete)
                            <div class="kuitansi-doa-box card bg-light border-0 p-2 px-3 rounded-3 text-center mb-3">
                                <p class="fst-italic text-muted mb-0 small" style="font-size: 0.78rem; line-height: 1.4;">
                                    "Semoga Allah membalas kebaikan Anda dengan pahala yang berlipat ganda, memberkahi rezeki keluarga Anda, dan menjadikan donasi ini sebagai amal jariyah yang terus mengalir."
                                </p>
                            </div>
                        @endif

                        <!-- Pengesahan / Footer Kuitansi Resmi -->
                        @if($isComplete)
                            <div class="kuitansi-official-footer border-top pt-2 mb-3">
                                <div class="row align-items-center g-2">
                                    <div class="col-7">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-shield-check text-success fs-4 me-2 mt-0"></i>
                                            <div>
                                                <small class="fw-bold text-dark d-block" style="font-size: 0.8rem;">Penyaluran Sah & Amanah</small>
                                                <small class="text-muted d-block" style="font-size: 0.7rem; line-height: 1.3;">
                                                    Donasi ini telah diverifikasi otomatis oleh payment gateway dan tercatat resmi di database Yayasan Graha Dhuafa Indonesia untuk disalurkan sesuai amanah.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5 text-end">
                                        <small class="text-muted d-block mb-1" style="font-size: 0.72rem;">Bandung, {{ $payment->updated_at ? $payment->updated_at->format('d F Y') : date('d F Y') }}</small>
                                        <small class="fw-bold text-dark d-block" style="font-size: 0.74rem;">Pengurus Yayasan GDI</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- ========================================== -->
                        <!-- AKSI TOMBOL BERDASARKAN STATUS              -->
                        <!-- ========================================== -->
                        <div class="no-print">

                            @if($isComplete)
                                <!-- KONDISI 1: SUKSES / LUNAS -->
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button onclick="window.print()" class="btn btn-outline-success w-100 py-2 fw-semibold">
                                        <i class="bi bi-printer me-1"></i> Cetak Bukti Donasi (PDF)
                                    </button>
                                    @if(!empty($campaignSlug))
                                        <a href="{{ route('donasi.detail', $campaignSlug) }}" class="btn btn-success w-100 py-2 fw-semibold">
                                            <i class="bi bi-arrow-repeat me-1"></i> Donasi Lagi
                                        </a>
                                    @else
                                        <a href="{{ route('donasi.index') }}" class="btn btn-success w-100 py-2 fw-semibold">
                                            <i class="bi bi-arrow-repeat me-1"></i> Donasi Lagi
                                        </a>
                                    @endif
                                </div>

                            @elseif($isPending)
                                <!-- KONDISI 2: PENDING (TOMBOL INTERAKTIF NYATA) -->
                                <div class="d-grid gap-3">
                                    @if(!empty($payment->snap_token))
                                        <!-- Tombol Lanjutkan Pembayaran (Buka Popup Midtrans Lagi) -->
                                        <button type="button" 
                                                id="btnPayNow" 
                                                class="btn btn-pembayaran btn-lg py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center justify-content-center"
                                                >
                                            <iconify-icon icon="keyline-icons:hand-coins-duotone" class="me-2"></iconify-icon> Lanjutkan Pembayaran Sekarang
                                        </button>
                                    @endif

                                    <!-- Tombol Cek Status Realtime -->
                                    <a href="{{ route('donasi.check-status', $payment->transcode) }}" 
                                       class="btn btn-pending py-3 fw-semibold rounded-pill d-flex align-items-center justify-content-center">
                                        <iconify-icon icon="fa:repeat" class="me-2"></iconify-icon> Cek Status Pembayaran
                                    </a>

                                    <!-- Tombol Batalkan Pembayaran -->
                                    <button type="button" 
                                            class="btn btn-link text-danger text-decoration-none small text-center"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalBatalPembayaran">
                                        <i class="bi bi-x-circle me-1"></i> Batalkan Pembayaran Ini
                                    </button>
                                </div>

                            @else
                                <!-- KONDISI 3: GAGAL / KADALUWARSA -->
                                <div class="d-grid gap-2">
                                    <a href="{{ !empty($campaignSlug) ? route('donasi.form', $campaignSlug) : route('donasi.index') }}" 
                                       class="btn btn-success btn-lg py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center justify-content-center"
                                       style="background: #00885a; border: none;">
                                        <i class="bi bi-arrow-repeat me-2 fs-5"></i> Ulangi Donasi Sekarang
                                    </a>
                                    <a href="{{ route('donasi.index') }}" class="btn btn-outline-secondary py-2 fw-semibold rounded-pill text-center">
                                        <i class="bi bi-grid-fill me-1"></i> Pilih Program Donasi Lainnya
                                    </a>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

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
                        <a href="{{ !empty($campaignSlug) ? route('donasi.form', $campaignSlug) : route('donasi.index') }}" id="btnKonfirmasiBatalYa" class="btn btn-outline-danger w-100 py-2 fw-bold rounded-pill text-decoration-none d-flex align-items-center justify-content-center">
                            Ya
                        </a>
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

<style>
@media print {
<<<<<<< Updated upstream
    @page {
        size: A4 portrait;
        margin: 8mm 10mm;
    }

    /* 1. Sembunyikan elemen web, navigasi, breadcrumb, footer, kursor tema, dan tombol */
    .no-print, 
    header, 
    footer, 
    .site-footer,
    .main-header-two,
    .stricky-header,
    .thm-breadcrumb, 
    .page-header, 
    .alert-dismissible,
    .btn,
    nav,
    .scroll-to-target,
    .scroll-to-top,
    .mobile-nav__wrapper,
    .preloader,
    .custom-cursor__cursor,
    .custom-cursor__cursor-two {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
    }

    html, body {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        background-color: #ffffff !important;
        background: #ffffff !important;
        color: #111827 !important;
        font-size: 9.5pt !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        height: auto !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .page-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        background: #ffffff !important;
    }

    section.py-5 {
        padding: 0 !important;
        margin: 0 !important;
        background-color: #ffffff !important;
=======
    /* 1. Paksa Browser Mencetak Warna & Background (Tidak Pudar/Putih) */
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    body {
        background-color: #ffffff !important;
    }

    .no-print, header, footer, .page-header, .thm-breadcrumb, .alert {
        display: none !important;
    }

    .py-5 {
        padding: 0 !important;
>>>>>>> Stashed changes
    }

    .container {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
<<<<<<< Updated upstream
        margin: 0 auto !important;
    }

    .row {
        margin: 0 !important;
        padding: 0 !important;
    }

    .col-lg-7, .col-md-9 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* 2. Format Kotak Kuitansi 1 Lembar Pas A4 */
    .print-area {
        box-shadow: none !important;
        border: 2px solid #00885a !important;
        border-radius: 10px !important;
        margin: 0 auto !important;
        background: #ffffff !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
        overflow: hidden !important;
        width: 100% !important;
    }

    .kuitansi-kop-header {
        border-bottom: 2px solid #00885a !important;
        display: flex !important;
        background-color: #ffffff !important;
        padding: 12px 18px !important;
    }

    .kuitansi-kop-header img {
        height: 44px !important;
    }

    .kuitansi-status-banner {
        padding: 12px 18px !important;
        background: #00885a !important;
        background: linear-gradient(135deg, #06301f 0%, #0d5c38 100%) !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .kuitansi-status-banner .rounded-circle {
        width: 48px !important;
        height: 48px !important;
    }

    .kuitansi-status-banner svg {
        width: 28px !important;
        height: 28px !important;
    }

    .kuitansi-status-banner h4 {
        font-size: 1.15rem !important;
        margin-bottom: 2px !important;
    }

    .kuitansi-body-content {
        padding: 14px 20px !important;
    }

    .table {
        font-size: 9.5pt !important;
        margin-bottom: 10px !important;
    }

    .table td {
        padding: 5px 2px !important;
    }

    .kuitansi-doa-box {
        padding: 8px 12px !important;
        margin-bottom: 10px !important;
        font-size: 8pt !important;
    }

    .kuitansi-official-footer {
        display: block !important;
        border-top: 1.5px dashed #00885a !important;
        margin-top: 10px !important;
        padding-top: 8px !important;
        margin-bottom: 0 !important;
=======
    }

    .print-area {
        box-shadow: none !important;
        border: 1px solid #d1d5db !important;
        border-radius: 12px !important;
        max-width: 580px !important;
        margin: 0 auto !important;
        overflow: hidden !important;
    }

    /* Pastikan Header Kuitansi Tetap Berwarna Hijau Saat Dicetak */
    .invoice-card-header {
        background: #0d5c38 !important;
        background-color: #0d5c38 !important;
        color: #ffffff !important;
    }

    .invoice-card-header h4,
    .invoice-card-header p {
        color: #ffffff !important;
    }

    .d-print-inline-block {
        display: inline-block !important;
>>>>>>> Stashed changes
    }
}
</style>
@endsection

@push('scripts')
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

@if($isPending && !empty($payment->snap_token))
<!-- Midtrans Snap JS untuk memunculkan kembali popup pembayaran jika donatur ingin melanjutkan -->
<script src="{{ (config('services.midtrans.is_production') ?? false) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    function triggerSnapPayment() {
        if (!window.snap) return;

        window.snap.pay('{{ $payment->snap_token }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('donasi.finish') }}?order_id={{ $payment->transcode }}&transaction_status=settlement&status_code=200";
            },
            onPending: function(result) {
                window.location.reload();
            },
            onError: function(result) {
                window.location.href = "{{ route('donasi.finish') }}?order_id={{ $payment->transcode }}&transaction_status=deny";
            },
            onClose: function() {
                // Munculkan popup konfirmasi apakah ingin membatalkan pembayaran
                var modalEl = document.getElementById('modalBatalPembayaran');
                if (modalEl && window.bootstrap) {
                    var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modalInstance.show();
                }
            }
        });
    }

    var btnPay = document.getElementById('btnPayNow');
    if (btnPay) {
        btnPay.addEventListener('click', function(e) {
            e.preventDefault();
            triggerSnapPayment();
        });
    }

    // Tombol "Tidak" pada Modal (Tidak Batal -> Lanjutkan Pembayaran)
    var btnTidak = document.getElementById('btnKonfirmasiBatalTidak');
    if (btnTidak) {
        btnTidak.addEventListener('click', function() {
            var modalEl = document.getElementById('modalBatalPembayaran');
            if (modalEl && window.bootstrap) {
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            }

            setTimeout(function() {
                triggerSnapPayment();
            }, 250);
        });
    }
</script>
@endif
@endpush
