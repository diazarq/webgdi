@extends('layout.layout-page')
@section('title', 'Simulasi Zakat - Midtrans Payment Gateway')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush

@section('breadcrumb')
<div class="text-center">
    <ul class="thm-breadcrumb list-unstyled">
        <li><a href="/">Beranda</a></li>
        <li><span>/</span></li>
        <li>Simulasi Midtrans</li>
    </ul>
    <h2>Simulasi Pembayaran Zakat (Midtrans Sandbox)</h2>
</div>
@endsection

@section('content')
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <!-- Alert Sandbox Info -->
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center bg-white" role="alert">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; min-width: 48px;">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="alert-heading mb-0 fw-bold text-dark">Midtrans Sandbox Mode Aktif</h6>
                            <span class="badge bg-success px-2 py-1 rounded-pill small">Siap Uji Coba</span>
                        </div>
                        <small class="text-muted d-block mt-1">Pembayaran zakat menggunakan <strong>Midtrans Snap</strong> (QRIS Otomatis & Virtual Account). Untuk menguji pembayaran, Anda bisa gunakan simulator resmi di <a href="https://simulator.sandbox.midtrans.com" target="_blank" class="fw-bold text-success text-decoration-none">simulator.sandbox.midtrans.com <i class="bi bi-box-arrow-up-right"></i></a>.</small>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #06301f 0%, #0d5c38 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-1 text-white fw-bold">Tunaikan Zakat & Donasi</h4>
                                <p class="mb-0 text-white-50 small">Pembayaran instan dengan QRIS Dinamis & Virtual Account</p>
                            </div>
                            <span class="badge bg-primary px-3 py-2 rounded-pill fw-bold" style="letter-spacing: 0.5px;">MIDTRANS SNAP</span>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <form id="donationForm">
                            @csrf

                            <!-- 1. Data Donatur -->
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-fill text-success me-2"></i>Data Donatur / Muzakki</h6>
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
                                    <label class="form-label small text-muted">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Contoh: Ahmad Fauzi" value="Ahmad Fauzi" required>
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
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-cash-stack text-success me-2"></i>Program & Nominal Zakat</h6>
                            <div class="mb-3">
                                <label class="form-label small text-muted">Pilih Jenis Program</label>
                                <select name="type" class="form-select">
                                    <option value="zakat_penghasilan">Zakat Penghasilan / Profesi</option>
                                    <option value="zakat_maal">Zakat Maal (Harta & Emas)</option>
                                    <option value="infaq_yatim">Infaq Santunan Anak Yatim</option>
                                    <option value="fidyah">Fidyah & Tebus Puasa Dhuafa</option>
                                </select>
                            </div>

                            <!-- Pilihan Cepat Nominal -->
                            <div class="mb-3">
                                <label class="form-label small text-muted">Pilihan Nominal Cepat</label>
                                <div class="row g-2">
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
                                    <div class="col-4">
                                        <button type="button" class="btn btn-outline-success w-100 btn-nominal" data-val="1000000">Rp 1.000.000</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small text-muted">Nominal Pembayaran (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="number" id="input_nominal" name="nominal" class="form-control form-control-lg fw-bold text-success" value="50000" min="10000" required>
                                </div>
                                <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle"></i> Minimal donasi Rp 10.000</small>
                            </div>

                            <!-- Tombol Bayar -->
                            <button type="button" id="payButton" class="btn btn-success btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-shield-lock-fill me-2"></i> Bayar Sekarang via Midtrans Snap <i class="bi bi-arrow-right ms-2"></i>
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
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghubungkan ke Midtrans...';

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
                    alert('Pembayaran gagal atau terjadi kesalahan.');
                },
                onClose: function () {
                    alert('Anda menutup jendela pembayaran sebelum menyelesaikannya.');
                }
            });
        } else {
            alert('Gagal membuat token pembayaran Midtrans: ' + (data.message || 'Terjadi kesalahan sistem'));
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

