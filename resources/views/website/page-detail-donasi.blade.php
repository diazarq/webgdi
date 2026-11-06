@extends('layout.layout-page')
@section('title', $campaign['title'])

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    /* Kitabisa Detail Styling */
    .campaign-banner {
        width: 100%;
        border-radius: 20px;
        aspect-ratio: 16/9;
        object-fit: cover;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    .campaign-card-sticky {
        position: sticky;
        top: 100px;
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
        font-size: 1.02rem;
        color: #4a5568;
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
                        <span class="badge bg-success bg-opacity-10 text-success fs-6 px-3 py-1 rounded-pill fw-bold">
                            {{ $percent }}%
                        </span>
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
                        <div><i class="bi bi-people-fill me-1 text-primary"></i><strong class="text-dark">{{ $campaign['donatur_count'] }}</strong> Donasi</div>
                        <div><i class="bi bi-clock-fill me-1 text-warning"></i><strong class="text-dark">{{ $campaign['days_left'] }}</strong> Hari Lagi</div>
                    </div>
                </div>

                <!-- Cerita Lengkap Musibah & Peristiwa -->
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
                    <h4 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                        <i class="bi bi-journal-text text-success me-2"></i>Kisah & Kronologi Peristiwa
                    </h4>
                    <div class="story-content">
                        {!! $campaign['story'] !!}
                    </div>
                </div>

                <!-- Doa & Dukungan Orang Baik (Kitabisa Feature) -->
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="bi bi-chat-heart text-danger me-2"></i>Doa & Dukungan Donatur
                        </h4>
                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">Doa Terbaru</span>
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
                            <strong class="text-dark">Keluarga Budi Santoso</strong>
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
            <!-- KOLOM KANAN: FORMULIR DONASI (MIDTRANS SNAP)-->
            <!-- ========================================== -->
            <div class="col-lg-5">
                @if(($campaign['status'] ?? 'active') === 'takedown')
                    <div class="card campaign-card-sticky p-4 text-center border-0 shadow-sm rounded-4 bg-white" id="formDonasiCard">
                        <div class="mb-3">
                            <span class="badge bg-secondary px-3 py-2 rounded-pill fw-bold text-uppercase fs-6">
                                <i class="bi bi-check-circle-fill me-1"></i> Penggalangan Ditutup
                            </span>
                        </div>
                        <div class="p-4 my-2 rounded-4 bg-light border">
                            <i class="bi bi-shield-lock-fill text-warning fs-1 d-block mb-3"></i>
                            <h5 class="fw-bold text-dark mb-2">Donasi Telah Selesai / Ditutup</h5>
                            <p class="small text-muted mb-0" style="line-height: 1.6;">
                                Penggalangan dana untuk program ini telah di-takedown oleh Admin karena target donasi telah terpenuhi atau masa penggalangan telah selesai. Seluruh donasi sedang dalam proses penyaluran ke lapangan.
                            </p>
                        </div>
                        <a href="{{ route('donasi.index') }}" class="btn btn-success rounded-pill fw-bold py-2 mt-3 shadow-sm">
                            <i class="bi bi-heart me-1"></i> Donasi Program Kebaikan Lainnya
                        </a>
                    </div>
                @else
                <div class="card campaign-card-sticky p-4 p-md-4" id="formDonasiCard">

                    <div class="text-center mb-3">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold small mb-2">
                            Pembayaran Aman & Otomatis
                        </span>
                        <h4 class="fw-bold text-dark mb-1">Tunaikan Donasi Anda</h4>
                        <p class="text-muted small mb-0">Didukung oleh <strong>Midtrans Payment Gateway</strong></p>
                    </div>

                    <form id="campaignDonationForm">
                        @csrf
                        <input type="hidden" name="campaign_slug" value="{{ $campaign['slug'] }}">
                        <input type="hidden" name="campaign_title" value="{{ $campaign['title'] }}">

                        <!-- 1. Pilihan Nominal Cepat -->
                        <label class="form-label fw-bold text-dark small mb-2">Pilih Nominal Cepat (Rp)</label>
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <div class="nominal-chip" data-nominal="10000">10.000</div>
                            </div>
                            <div class="col-4">
                                <div class="nominal-chip active" data-nominal="25000">25.000</div>
                            </div>
                            <div class="col-4">
                                <div class="nominal-chip" data-nominal="50000">50.000</div>
                            </div>
                            <div class="col-4">
                                <div class="nominal-chip" data-nominal="100000">100.000</div>
                            </div>
                            <div class="col-4">
                                <div class="nominal-chip" data-nominal="250000">250.000</div>
                            </div>
                            <div class="col-4">
                                <div class="nominal-chip" data-nominal="500000">500.000</div>
                            </div>
                        </div>

                        <!-- 2. Nominal Manual -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Nominal Donasi Lainnya (Rp)</label>
                            <input type="number" 
                                   id="inputNominal" 
                                   name="nominal" 
                                   class="form-control custom-nominal-input" 
                                   value="25000" 
                                   min="10000" 
                                   required>
                            <small class="text-muted" style="font-size: 0.78rem;">Minimal donasi Rp 10.000</small>
                        </div>

                        <!-- 3. Data Donatur -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Nama Lengkap Donatur <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3 py-2" placeholder="Nama Anda" value="Ahmad Fauzi" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                            <input type="text" name="notelp" class="form-control rounded-3 py-2" placeholder="08xxxxxxxxxx" value="081234567890" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Email (Kirim Bukti Donasi)</label>
                            <input type="email" name="email" class="form-control rounded-3 py-2" placeholder="email@gmail.com" value="donatur@gmail.com">
                        </div>

                        <!-- 4. Pilihan Anonim (Hamba Allah) -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="anonim" id="anonimCheck" value="Y">
                            <label class="form-check-label small fw-semibold text-secondary" for="anonimCheck">
                                Sembunyikan nama saya (Hamba Allah)
                            </label>
                        </div>

                        <!-- 5. Doa / Pesan Kebaikan -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Doa / Dukungan untuk Korban (Opsional)</label>
                            <textarea name="doa" class="form-control rounded-3" rows="2" placeholder="Tuliskan doa kebaikan Anda di sini..."></textarea>
                        </div>

                        <!-- Tombol Submit Bayar -->
                        <button type="button" 
                                id="btnBayarMidtrans" 
                                class="btn btn-success btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm"
                                style="background: linear-gradient(135deg, #00C89D 0%, #0d5c38 100%); border: none;">
                            <i class="bi bi-heart-fill me-2"></i> Lanjut Pembayaran Donasi
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-shield-check text-success me-1"></i> Mendukung QRIS, BCA, Mandiri, BRI, BNI, GoPay & ShopeePay
                            </small>
                        </div>
                    </form>

                </div>
                @endif
            </div>

        </div>
    </div>
</section>

<!-- Script Midtrans Snap Sandbox -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

@push('scripts')
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

// Submit Form Donasi via Midtrans Snap
document.getElementById('btnBayarMidtrans').addEventListener('click', function(e) {
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
            // Tampilkan popup pembayaran Midtrans Snap
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    window.location.href = "{{ route('donasi.finish') }}?order_id=" + data.order_id + "&transaction_status=settlement&status_code=200";
                },
                onPending: function(result) {
                    window.location.href = "{{ route('donasi.finish') }}?order_id=" + data.order_id + "&transaction_status=pending";
                },
                onError: function(result) {
                    alert('Pembayaran donasi gagal atau terjadi kesalahan.');
                },
                onClose: function() {
                    alert('Anda menutup jendela pembayaran sebelum menyelesaikannya.');
                }
            });
        } else {
            alert('Gagal membuat transaksi Midtrans: ' + (data.message || 'Terjadi kesalahan sistem'));
        }
    })
    .catch(error => {
        btn.disabled = false;
        btn.innerHTML = originalText;
        console.error('Error:', error);
        alert('Terjadi kesalahan koneksi ke server.');
    });
});
</script>
@endpush
@endsection

