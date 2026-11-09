@extends('layout.layout-page')
@section('title', 'Bukti Donasi Berhasil - Graha Dhuafa Indonesia')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush

@section('breadcrumb')
<div class="text-center">
    <ul class="thm-breadcrumb list-unstyled">
        <li><a href="/">Beranda</a></li>
        <li><span>/</span></li>
        <li>Bukti Donasi</li>
    </ul>
    <h2>Kuitansi Donasi Berhasil</h2>
</div>
@endsection

@section('content')
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white print-area">
                    <!-- Header Kartu -->
                    <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #06301f 0%, #0d5c38 100%);">
                        @if($payment->status == 'complete')
                            <div class="mb-3">
                                <span class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 76px; height: 76px;">
                                    <i class="bi bi-check-lg text-success" style="font-size: 38px; line-height: 1;"></i>
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-white">Alhamdulillah, Donasi Berhasil!</h4>
                            <p class="mb-0 text-white-50 small">Terima kasih atas kepedulian dan donasi yang Anda tunaikan</p>
                        @else
                            <div class="mb-3">
                                <span class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 76px; height: 76px;">
                                    <i class="bi bi-clock-fill text-warning" style="font-size: 34px; line-height: 1;"></i>
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-white">Menunggu Pembayaran</h4>
                            <p class="mb-0 text-white-50 small">Silahkan selesaikan pembayaran donasi sesuai petunjuk</p>
                        @endif
                    </div>

                    <!-- Detail Invoice -->
                    <div class="p-4 p-md-5">
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                            <div>
                                <small class="text-muted d-block">Nomor Donasi (Order ID)</small>
                                <span class="fw-bold fs-6 font-monospace text-dark">{{ $payment->transcode }}</span>
                            </div>
                            @if($payment->status == 'complete')
                                <span class="badge bg-success px-3 py-2 rounded-pill fs-6 fw-bold">
                                    <i class="bi bi-check-circle-fill me-1"></i> LUNAS
                                </span>
                            @else
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6 fw-bold">
                                    <i class="bi bi-hourglass-split me-1"></i> PENDING
                                </span>
                            @endif
                        </div>

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
                                        <td class="text-end fw-semibold pe-0 py-2 text-capitalize">{{ str_replace('_', ' ', $payment->type) }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted ps-0 py-2">Metode Pembayaran</td>
                                        <td class="text-end fw-semibold pe-0 py-2">
                                            @php
                                                $method = $payment->payment_method ?: 'VA BCA';
                                                if (stripos($method, 'snap') !== false || strtolower($method) === 'midtrans') {
                                                    $method = 'VA BCA';
                                                }
                                            @endphp
                                            <span class="badge bg-light text-dark border px-2 py-1 d-inline-flex align-items-center">
                                                <img src="{{ asset('images/midtrans-logo.png') }}" alt="Midtrans" style="height: 14px; width: auto; object-fit: contain;" class="me-1">
                                                {{ $method }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted ps-0 py-2">Waktu Donasi</td>
                                        <td class="text-end fw-semibold pe-0 py-2">{{ $payment->updated_at ? $payment->updated_at->format('d M Y, H:i') : date('d M Y, H:i') }} WIB</td>
                                    </tr>
                                    <tr class="bg-light rounded-3">
                                        <td class="ps-3 py-3 fw-bold text-dark fs-5">Total Donasi</td>
                                        <td class="text-end pe-3 py-3 fw-bold text-success fs-4">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Doa Donatur -->
                        <div class="card bg-light border-0 p-3 rounded-3 text-center mb-4">
                            <p class="fst-italic text-muted mb-0 small">
                                "Semoga Allah membalas kebaikan Anda dengan pahala yang berlipat ganda, memberkahi rezeki keluarga Anda, dan menjadikan donasi ini sebagai amal jariyah yang terus mengalir."
                            </p>
                        </div>

                        <!-- Aksi Tombol -->
                        <div class="d-flex flex-column flex-sm-row gap-2 no-print">
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
                        <div class="text-center mt-3 no-print">
                            <a href="{{ route('donasi.index') }}" class="text-decoration-none fw-semibold small" style="color: #0d5c38;">
                                <i class="bi bi-grid-fill me-1"></i> Lihat Program Donasi & Bencana Lainnya
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
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
