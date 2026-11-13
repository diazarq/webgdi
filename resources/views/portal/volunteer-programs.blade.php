@extends('portal.layout')
@section('title', 'Daftar Program Aksi Relawan')

@section('content')
<div class="card border-0 text-white mb-4 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); border-radius: 16px;">
    <div class="card-body p-3 p-md-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-warning text-dark fw-bold px-2 py-1 mb-2 rounded-pill text-uppercase" style="font-size: 0.68rem;">
                    AKSI SAHABAT BAIK GDI
                </span>
                <h3 class="fw-bold mb-1">Daftar Program & Aksi Relawan</h3>
                <p class="mb-0 opacity-90 small">
                    Pilih program aksi kerelawanan yang sesuai dengan panggilan jiwa dan keahlian Anda, mulai dari respon darurat bencana hingga aksi berbagi pangan dhuafa.
                </p>
            </div>
            <div class="col-md-4 text-center text-md-end d-none d-md-block">
                <i class="bi bi-compass fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

@if(session('pendaftaran_sukses'))
<div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm p-4 mb-4" role="alert" style="background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%); border-left: 6px solid #16a34a !important;">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-2 text-success me-3"></i>
            <div>
                <h5 class="fw-bold text-success mb-1">Konfirmasi Terdaftar: {{ session('pendaftaran_sukses.program_title') }}</h5>
                <div class="text-dark small">{{ session('pendaftaran_sukses.message') }}</div>
            </div>
        </div>
        <a href="{{ route('portal.volunteer.program.join-group', session('pendaftaran_sukses.registration_id')) }}" target="_blank" class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm">
            <i class="bi bi-whatsapp me-2"></i> Gabung Grup Koordinasi Sekarang
        </a>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<!-- FILTER KATEGORI PROGRAM -->
<div class="portal-card p-3 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="fw-bold text-dark">
            <i class="bi bi-funnel-fill text-success me-1"></i> Filter Kategori Aksi:
        </div>
        <div class="btn-group flex-wrap" role="group">
            <a href="{{ route('portal.volunteer.programs', ['category' => 'all']) }}" class="btn btn-sm {{ $selectedCategory == 'all' ? 'btn-success' : 'btn-outline-secondary' }}">Semua Program</a>
            <a href="{{ route('portal.volunteer.programs', ['category' => 'Tanggap Bencana']) }}" class="btn btn-sm {{ $selectedCategory == 'Tanggap Bencana' ? 'btn-danger' : 'btn-outline-danger' }}">
                <i class="bi bi-shield-shaded me-1"></i> Tanggap Bencana
            </a>
            <a href="{{ route('portal.volunteer.programs', ['category' => 'Berbagi']) }}" class="btn btn-sm {{ $selectedCategory == 'Berbagi' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-heart-fill me-1"></i> Berbagi Pangan & Sosial
            </a>
        </div>
    </div>
</div>

<!-- GRID PROGRAM AKSI -->
<div class="row g-4">
    @forelse($programs as $prog)
    @php
        $isRegistered = in_array($prog->id, $registeredProgramIds);
        $myReg = $myRegistrations->firstWhere('volunteer_program_id', $prog->id);
    @endphp
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative" style="background: #ffffff; border: 1.5px solid #e5e7eb !important;">
            <div style="height: 180px; background-color: #0d5c38; position: relative; overflow: hidden;">
                @if($prog->image)
                    <img src="{{ asset($prog->image) }}" alt="{{ $prog->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white opacity-50">
                        <i class="bi bi-heart-pulse-fill fs-1"></i>
                    </div>
                @endif
                <span class="badge position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill {{ $prog->category == 'Tanggap Bencana' ? 'bg-danger' : 'bg-primary' }}">
                    {{ $prog->category }}
                </span>
                @if($isRegistered)
                    <span class="badge position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill bg-success">
                        <i class="bi bi-check2-circle me-1"></i> Terdaftar
                    </span>
                @endif
            </div>

            <div class="card-body p-3 p-md-4 d-flex flex-column">
                <h5 class="fw-bold text-dark mb-1">{{ $prog->title }}</h5>
                <small class="text-muted mb-2 d-flex align-items-center gap-1">
                    <i class="bi bi-geo-alt-fill text-danger"></i> {{ $prog->location ?: 'Indonesia' }}
                </small>
                <p class="text-secondary small mb-3 flex-grow-1" style="line-height: 1.5;">
                    {{ $prog->description }}
                </p>

                <div class="p-2 bg-light rounded-3 small mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Relawan Terdaftar:</span>
                        <span class="fw-bold text-dark">{{ $prog->registrations->count() }} / {{ $prog->quota }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Koordinator:</span>
                        <span class="fw-semibold text-truncate" style="max-width: 160px;">{{ $prog->coordinator_name ?: 'Tim GDI' }}</span>
                    </div>
                </div>

                @if($isRegistered)
                    <div class="d-grid gap-2">
                        <span class="badge bg-success-subtle text-success border border-success py-2 rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i> Terdaftar (Peran: {{ $myReg->skills ?? 'Relawan' }})
                        </span>
                        <a href="{{ route('portal.volunteer.program.join-group', $myReg->id) }}" target="_blank" class="btn btn-success fw-bold rounded-pill py-2 shadow-sm">
                            <i class="bi bi-whatsapp me-2 fs-5 align-middle"></i> Gabung Grup Koordinasi
                        </a>
                    </div>
                @else
                    <button type="button" class="btn btn-success fw-bold w-100 rounded-pill py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDaftarAksi{{ $prog->id }}">
                        <i class="bi bi-pencil-square me-1"></i> Daftar Program Aksi Ini
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL PENDAFTARAN PROGRAM -->
    <div class="modal fade" id="modalDaftarAksi{{ $prog->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom py-3 px-4 bg-light">
                    <div>
                        <span class="badge {{ $prog->category == 'Tanggap Bencana' ? 'bg-danger' : 'bg-primary' }} mb-1">{{ $prog->category }}</span>
                        <h5 class="modal-title fw-bold text-dark mb-0">Daftar: {{ $prog->title }}</h5>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('portal.volunteer.program.register', $prog->id) }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="alert alert-info border-info-subtle small p-3 rounded-3 mb-3">
                            <i class="bi bi-info-circle-fill me-1 text-primary"></i> Data akun Anda otomatis terisi. Pastikan nomor WhatsApp aktif untuk dimasukkan ke grup koordinasi relawan.
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap Relawan</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">No. WhatsApp</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Kota Domisili</label>
                                <input type="text" name="domisili" class="form-control" value="{{ old('domisili', $user->domisili) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Keahlian / Peran di Lapangan <span class="text-danger">*</span></label>
                            <select name="skills" class="form-select" required>
                                <option value="">-- Pilih Peran Aksi --</option>
                                <option value="Tim Medis & P3K">Tim Medis & P3K</option>
                                <option value="Logistik & Distribusi">Logistik & Distribusi</option>
                                <option value="Dapur Umum & Masak">Dapur Umum & Masak</option>
                                <option value="Driver & Transportasi">Driver & Transportasi</option>
                                <option value="Dokumenter & Publikasi Media">Dokumenter & Publikasi Media</option>
                                <option value="Relawan Lapangan Umum">Relawan Lapangan Umum</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Catatan Kesiapan / Motivasi (Opsional)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Tuliskan jika ada keahlian khusus atau waktu kesiapan Anda."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-3 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold rounded-pill px-4">
                            <i class="bi bi-send-check me-1"></i> Kirim Pendaftaran Aksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
        Tidak ada program aksi yang tersedia untuk kategori ini saat ini.
    </div>
    @endforelse
</div>
@endsection

