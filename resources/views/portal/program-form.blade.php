@extends('portal.layout')
@section('title', 'Formulir Pendaftaran Relawan - ' . $program->title)

@push('styles')
<style>
    .program-summary-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        padding: 16px 20px;
        margin-bottom: 22px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .skill-chip {
        border: 1.5px solid #d1d5db;
        background: #ffffff;
        border-radius: 12px;
        padding: 12px 14px;
        font-weight: 600;
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #1f2937;
        width: 100%;
        display: flex;
        align-items: center;
        gap: 8px;
        user-select: none;
    }
    .skill-chip:hover {
        border-color: #00C89D;
        background: #f0fdf9;
        transform: translateY(-2px);
    }
    .skill-chip.active {
        border-color: #0d5c38;
        background: #0d5c38;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(13, 92, 56, 0.2);
    }
    .btn-submit-pendaftaran {
        background-color: #00885a;
        color: white;
        transition: all 0.25s ease;
    }
    .btn-submit-pendaftaran:hover {
        background-color: #0b6c46;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 136, 90, 0.35);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- BREADCRUMB -->
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('portal.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('portal.volunteer.program.detail', $program->slug) }}" class="text-decoration-none text-muted">{{ Str::limit($program->title, 25) }}</a></li>
                    <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Form Pendaftaran</li>
                </ol>
            </nav>
        </div>

        <!-- 1. KARTU RINGKASAN PROGRAM (PERSIS SEPERTI SUMMARY CARD DI FORM DONASI) -->
        <div class="program-summary-card">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 72px; height: 54px; border-radius: 10px; overflow: hidden; flex-shrink: 0; background: #0d4223;">
                    @if($program->image && file_exists(public_path($program->image)))
                        <img src="{{ asset($program->image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <img src="{{ asset('website/assets/images/project/project-1-' . (($program->id % 3) + 1) . '.jpg') }}" alt="" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('images/volunteer/volunteer.jpg') }}'">
                    @endif
                </div>
                <div class="flex-grow-1">
                    <span class="badge {{ $program->category === 'Tanggap Bencana' ? 'bg-danger' : 'bg-primary' }} mb-1" style="font-size: 0.68rem;">
                        {{ $program->category }}
                    </span>
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.94rem;">{{ $program->title }}</h6>
                    <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $program->location }}</small>
                </div>
                <div>
                    <a href="{{ route('portal.volunteer.program.detail', $program->slug) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3" style="font-size: 0.74rem;">
                        Ganti Program
                    </a>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Mohon periksa isian formulir:</strong>
            <ul class="mb-0 mt-1 small">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- 2. FORMULIR PENDAFTARAN RELAWAN -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
            <form action="{{ route('portal.volunteer.program.register', $program->slug) }}" method="POST">
                @csrf

                <!-- SEKSI IDENTITAS -->
                <h6 class="fw-bold text-dark mb-3">
                    <i class="bi bi-person-circle text-success me-2"></i>Data Lengkap Relawan
                </h6>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" readonly style="background-color: #f8fafc; font-weight: 600;">
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nomor WhatsApp Aktif *</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" required>
                        <div class="form-text text-muted">Nomor ini akan didaftarkan ke grup koordinasi relawan.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kota / Domisili Saat Ini *</label>
                        <input type="text" class="form-control" name="domisili" value="{{ old('domisili', $user->domisili) }}" placeholder="Contoh: Bandung" required>
                        <div class="form-text text-muted">Mempermudah pemetaan logistik titik kumpul.</div>
                    </div>
                </div>

                <!-- SEKSI PILIHAN KEAHLIAN / PERAN (CHIPS CLICKABLE PERSIS NOMINAL DONASI) -->
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-2">
                        <i class="bi bi-stars text-warning me-2"></i>Pilih Peran / Keahlian Kontribusi *
                    </h6>
                    <p class="text-muted small mb-3">Klik salah satu bidang peran yang paling sesuai dengan kesiapan Anda di lapangan:</p>

                    @php
                        $roles = [
                            ['key' => 'Tim Medis / First Aid', 'icon' => 'bi-heart-pulse-fill text-danger', 'label' => 'Tim Medis / First Aid'],
                            ['key' => 'Dapur Umum & Distribusi Pangan', 'icon' => 'bi-cup-hot-fill text-warning', 'label' => 'Dapur Umum & Pangan'],
                            ['key' => 'Evakuasi & Logistik Lapangan', 'icon' => 'bi-box-seam-fill text-primary', 'label' => 'Logistik & Evakuasi'],
                            ['key' => 'Dokumentasi & Media', 'icon' => 'bi-camera-video-fill text-info', 'label' => 'Dokumentasi & Media'],
                            ['key' => 'Pendampingan Psikososial / Anak', 'icon' => 'bi-emoji-smile-fill text-success', 'label' => 'Pendampingan Anak/Dhuafa'],
                            ['key' => 'Relawan Umum & Lapangan Bebas', 'icon' => 'bi-person-walking text-secondary', 'label' => 'Relawan Umum & Lapangan'],
                        ];
                        $selectedRole = old('skills', 'Relawan Umum & Lapangan Bebas');
                    @endphp

                    <input type="hidden" name="skills" id="selectedRoleInput" value="{{ $selectedRole }}" required>

                    <div class="row g-2">
                        @foreach($roles as $r)
                        <div class="col-sm-6">
                            <div class="skill-chip {{ $selectedRole === $r['key'] ? 'active' : '' }}" onclick="selectSkill('{{ $r['key'] }}', this)">
                                <i class="bi {{ $r['icon'] }} fs-6"></i>
                                <span>{{ $r['label'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- SEKSI CATATAN -->
                <div class="mb-4">
                    <label class="form-label">Catatan Tambahan / Perlengkapan Pribadi (Opsional)</label>
                    <textarea class="form-control" name="notes" rows="3" placeholder="Tuliskan jika Anda membawa perlengkapan pribadi (jas hujan, rompi, motor trail, kamera), atau ketersediaan hari/jam aksi Anda...">{{ old('notes') }}</textarea>
                </div>

                <!-- TOMBOL SUBMIT CTA -->
                <button type="submit" class="btn btn-submit-pendaftaran btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center">
                    <span>Kirim Pendaftaran Relawan</span> <i class="bi bi-arrow-right ms-2"></i>
                </button>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i> Data Anda aman dan digunakan khusus untuk kebutuhan koordinasi aksi kemanusiaan.
                    </small>
                </div>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function selectSkill(skillKey, element) {
        document.querySelectorAll('.skill-chip').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('selectedRoleInput').value = skillKey;
    }
</script>
@endpush
@endsection

