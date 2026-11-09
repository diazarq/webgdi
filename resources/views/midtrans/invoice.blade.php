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
                    <!-- HEADER STATUS KARTU                       -->
                    <!-- ========================================== -->
                    @if($isComplete)
                        <!-- 1. STATUS LUNAS / BERHASIL (HIJAU) -->
                        <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #06301f 0%, #0d5c38 100%);">
                            <div class="mb-3">
                                <span class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center success-badge-pulse" style="width: 76px; height: 76px;">
                                    <iconify-icon id="successIcon" icon="line-md:circle-to-confirm-circle-transition" style="font-size: 52px; color: #198754;"></iconify-icon>
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-white">Alhamdulillah, Donasi Berhasil!</h4>
                            <p class="mb-0 text-white-50 small">Terima kasih atas kepedulian dan donasi yang Anda tunaikan</p>
                        </div>

                    @elseif($isPending)
                        <!-- 2. STATUS MENUNGGU PEMBAYARAN (KUNING / ORANYE) -->
                        <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #78350f 0%, #d97706 100%);">
                            <div class="mb-3">
                                <span class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 76px; height: 76px;">
                                    <iconify-icon icon="line-md:loading-twotone-loop" style="font-size: 46px; color: #d97706;"></iconify-icon>
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-white">Menunggu Pembayaran Donasi</h4>
                            <p class="mb-0 text-white-50 small">Silakan selesaikan pembayaran sebelum transaksi berakhir</p>
                        </div>

                    @else
                        <!-- 3. STATUS GAGAL / KADALUWARSA / CANCEL (MERAH) -->
                        <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 100%);">
                            <div class="mb-3">
                                <span class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 76px; height: 76px;">
                                    <i class="bi bi-x-circle-fill text-danger" style="font-size: 44px; line-height: 1;"></i>
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-white">Pembayaran Donasi Tidak Berhasil</h4>
                            <p class="mb-0 text-white-50 small">Transaksi telah dibatalkan, ditolak, atau waktu pembayaran kedaluwarsa</p>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- DETAIL TRANSAKSI                           -->
                    <!-- ========================================== -->
                    <div class="p-4 p-md-5">

                        <!-- Pesan Khusus Pending / Gagal -->
                        @if($isPending)
                            <div class="alert alert-warning border-warning bg-light p-3 rounded-3 mb-4">
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
                            <div class="alert alert-danger border-danger bg-light p-3 rounded-3 mb-4">
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
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                            <div>
                                <small class="text-muted d-block">Nomor Donasi (Order ID)</small>
                                <span class="fw-bold fs-6 font-monospace text-dark">{{ $payment->transcode }}</span>
                            </div>
                            @if($isComplete)
                                <span class="badge bg-success px-3 py-2 rounded-pill fs-6 fw-bold">
                                    <i class="bi bi-check-circle-fill me-1"></i> LUNAS
                                </span>
                            @elseif($isPending)
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6 fw-bold">
                                    <i class="bi bi-hourglass-split me-1"></i> PENDING
                                </span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill fs-6 fw-bold">
                                    <i class="bi bi-x-circle-fill me-1"></i> GAGAL / EXPIRED
                                </span>
                            @endif
                        </div>

                        <!-- Rincian Tabel Donasi -->
                        <div class="table-responsive mb-4">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    <tr class="border-bottom">
                                        <td class="text-muted ps-0 py-2">Nama Donatur</td>
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
                                        <td class="ps-3 py-3 fw-bold text-dark fs-5">Total Donasi</td>
                                        <td class="text-end pe-3 py-3 fw-bold text-success fs-4">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Doa Donatur (Hanya jika lunas) -->
                        @if($isComplete)
                            <div class="card bg-light border-0 p-3 rounded-3 text-center mb-4">
                                <p class="fst-italic text-muted mb-0 small">
                                    "Semoga Allah membalas kebaikan Anda dengan pahala yang berlipat ganda, memberkahi rezeki keluarga Anda, dan menjadikan donasi ini sebagai amal jariyah yang terus mengalir."
                                </p>
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

<style>
/* Animasi Loop Berdenyut (Pulse Ring) Untuk Ikon Sukses */
.success-badge-pulse {
    animation: successPulse 2.2s ease-in-out infinite;
    position: relative;
}

@keyframes successPulse {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7), 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: scale(1);
    }
    50% {
        box-shadow: 0 0 0 16px rgba(255, 255, 255, 0), 0 6px 16px rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0), 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: scale(1);
    }
}

@media print {
    .no-print, header, footer, .page-header {
        display: none !important;
    }
    .print-area {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
}
</style>
@endsection

@push('scripts')
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

@if($isComplete)
<script>
    // Loop animasi stroke gambar icon sukses setiap 4.5 detik
    setInterval(function() {
        var icon = document.getElementById('successIcon');
        if (icon) {
            var iconName = icon.getAttribute('icon');
            icon.setAttribute('icon', '');
            setTimeout(function() {
                icon.setAttribute('icon', iconName);
            }, 50);
        }
    }, 4500);
</script>
@endif

@if($isPending && !empty($payment->snap_token))
<!-- Midtrans Snap JS untuk memunculkan kembali popup pembayaran jika donatur ingin melanjutkan -->
<script src="{{ (config('services.midtrans.is_production') ?? false) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    var btnPay = document.getElementById('btnPayNow');
    if (btnPay) {
        btnPay.addEventListener('click', function(e) {
            e.preventDefault();
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
                    console.log('Popup pembayaran ditutup kembali.');
                }
            });
        });
    }
</script>
@endif
@endpush
