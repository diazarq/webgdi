@extends('layout.layout-page')
@section('title', 'Simulasi Donasi Online - Midtrans Payment Gateway')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush

@section('breadcrumb')
<div class="text-center">
    <ul class="thm-breadcrumb list-unstyled">
        <li><a href="/">Beranda</a></li>
        <li><span>/</span></li>
        <li>Simulasi Donasi</li>
    </ul>
    <h2>Simulasi Donasi Online</h2>
</div>
@endsection

@section('content')
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header text-white p-5 text-center" style="background: linear-gradient(135deg, #06301f 0%, #0d5c38 100%);">
                        <h4 class="mb-1 text-white fw-bold">Ayo Berdonasi!</h4>
                        <p class="mb-0 text-white-50 small">"Kebaikan kecilmu hari ini adalah alasan seseorang bisa bertahan esok hari."</p>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <form id="donationForm">
                            @csrf

                            <!-- 1. Data Donatur -->
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-fill text-success me-2"></i>Data Donatur</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Sapaan</label>
                                    <select name="pronoun" class="form-select">
                                        <option value="Bapak">Bapak</option>
                                        <option value="Ibu">Ibu</option>
                                        <option value="Sdr">Sdr/Sdri</option>
                                    </select>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label small text-muted">Nama Lengkap Donatur <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">No. WhatsApp / HP</label>
                                    <input type="text" name="notelp" class="form-control" placeholder="08xxxxxxxxxx" value="081234567890">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Alamat Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="donatur@gmail.com">
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- 2. Program Donasi & Nominal -->
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-box2-heart-fill text-success me-2"></i>Pilihan Program Donasi</h6>
                            <div class="mb-3">
                                <label class="form-label small text-muted">Pilih Program Kebaikan</label>
                                <select name="type" class="form-select">
                                    <option value="donasi_yatim">Donasi Santunan Anak Yatim & Piatu</option>
                                    <option value="donasi_pendidikan_dhuafa">Donasi Pendidikan Anak Dhuafa</option>
                                    <option value="donasi_pangan_dhuafa">Donasi Pangan & Sembako Dhuafa</option>
                                    <option value="donasi_tanggap_bencana">Donasi Tanggap Bencana & Kemanusiaan</option>
                                    <option value="donasi_umum_operasional">Donasi Umum / Sedekah Subuh</option>
                                </select>
                            </div>

                            <!-- Pilihan Cepat Nominal -->
                            <div class="mb-3">
                                <label class="form-label small text-muted">Pilihan Nominal Cepat</label>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-success w-100 btn-nominal" data-val="10000">Rp 10.000</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-success w-100 btn-nominal" data-val="25000">Rp 25.000</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-success w-100 btn-nominal active" data-val="50000">Rp 50.000</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-success w-100 btn-nominal" data-val="100000">Rp 100.000</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-success w-100 btn-nominal" data-val="250000">Rp 250.000</button>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-success w-100 btn-nominal" data-val="500000">Rp 500.000</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small text-muted">Nominal Donasi (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="number" id="input_nominal" name="nominal" class="form-control form-control-lg fw-bold text-success" value="50000" min="10000" required>
                                </div>
                                <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle"></i> Minimal donasi Rp 10.000</small>
                            </div>

                            <!-- Tombol Bayar -->
                            <button type="button" id="payButton" class="btn btn-success btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm">
                                Donasi Sekarang<i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Script Midtrans Snap Sandbox -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

@push('scripts')
<script>
// Pilihan nominal cepat
document.querySelectorAll('.btn-nominal').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.btn-nominal').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('input_nominal').value = this.dataset.val;
    });
});

// Tombol Bayar via Midtrans Snap
document.getElementById('payButton').addEventListener('click', function (e) {
    e.preventDefault();

    var btn = this;
    var originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Tunggu Sebentar...';

    var form = document.getElementById('donationForm');
    var formData = new FormData(form);

    fetch("{{ route('midtrans.token') }}", {
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
            // Munculkan popup Midtrans Snap
            window.snap.pay(data.snap_token, {
                onSuccess: function (result) {
                    window.location.href = "{{ route('midtrans.finish') }}?order_id=" + data.order_id + "&transaction_status=settlement&status_code=200";
                },
                onPending: function (result) {
                    window.location.href = "{{ route('midtrans.finish') }}?order_id=" + data.order_id + "&transaction_status=pending";
                },
                onError: function (result) {
                    alert('Pembayaran donasi gagal atau terjadi kesalahan.');
                },
                onClose: function () {
                    alert('Anda menutup jendela pembayaran donasi sebelum menyelesaikannya.');
                }
            });
        } else {
            alert('Gagal membuat token donasi Midtrans: ' + (data.message || 'Terjadi kesalahan sistem'));
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
