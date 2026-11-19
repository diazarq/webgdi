@extends('portal.layout')
@section('title', 'Profil & Pengaturan Akun')

@push('styles')
<style>
    .avatar-wrapper {
        position: relative;
        width: 104px;
        height: 104px;
        margin: 0 auto 16px auto;
        border-radius: 50%;
    }
    .avatar-circle-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #0f7638;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.3rem;
        font-weight: 800;
        overflow: hidden;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 14px rgba(0,0,0,0.12);
    }
    .avatar-circle-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    /* Overlay saat kursor diarahkan ke foto profil */
    .avatar-hover-overlay {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: rgba(15, 118, 56, 0.75);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        backdrop-filter: blur(2px);
    }
    .avatar-wrapper:hover .avatar-hover-overlay {
        opacity: 1;
    }
    /* Badge Tombol Pensil Edit */
    .avatar-badge-edit {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #0f7638;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 3;
    }
    .avatar-badge-edit:hover {
        background: #0a5728;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1"><i class="bi bi-person-gear text-success me-2"></i>Profil & Pengaturan Akun</h4>
    <p class="text-muted small mb-0">Perbarui data diri atau ubah kata sandi akun Anda.</p>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4">
        <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-1 small">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    <!-- INFO RINGKAS AKUN -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center" style="border: 1px solid #e8edea !important;">
            
            <!-- AVATAR DENGAN HOVER PENSIL EDIT -->
            <div class="avatar-wrapper">
                <div class="avatar-circle-img">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>

                <!-- Overlay saat kursor di-hover -->
                <label for="profilePhotoInput" class="avatar-hover-overlay" title="Klik untuk ubah foto profil">
                    <i class="bi bi-camera-fill fs-5 mb-1"></i>
                    <span style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Ubah Foto</span>
                </label>

                <!-- Tombol Pensil Edit di pojok -->
                <label for="profilePhotoInput" class="avatar-badge-edit" title="Ubah foto profil">
                    <i class="bi bi-pencil-fill" style="font-size: 0.78rem;"></i>
                </label>

                <!-- Form Upload Foto Otomatis (Hidden) -->
                <form id="formUpdatePhoto" action="{{ route('portal.profile.photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="profilePhotoInput" name="profile_photo" accept="image/png, image/jpeg, image/jpg, image/webp" class="d-none" onchange="document.getElementById('formUpdatePhoto').submit();">
                </form>
            </div>

            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <div class="text-muted small mb-2">@<span>{{ $user->username }}</span></div>

            @if($user->isAdmin())
                <span class="badge bg-danger px-3 py-2 mb-3 rounded-pill">
                    <i class="bi bi-shield-lock-fill me-1"></i> Administrator GDI
                </span>
            @elseif($user->isVolunteer())
                <span class="badge bg-success-subtle text-success border border-success px-3 py-2 mb-3 rounded-pill fw-semibold">
                    <i class="bi bi-heart-fill me-1"></i> Relawan Sahabat Baik
                </span>
            @else
                <span class="badge bg-white text-warning border border-warning px-3 py-2 mb-3 rounded-pill fw-semibold">
                    <i class="bi bi-briefcase-fill me-1"></i> Mitra / Amil Zakat
                </span>
            @endif

            <div class="bg-light p-3 rounded-4 text-start small mb-3">
                <div class="mb-2"><strong>Email:</strong><br>{{ $user->email }}</div>
                <div class="mb-2"><strong>WhatsApp:</strong><br>{{ $user->phone ?? '-' }}</div>
                <div class="mb-2"><strong>Kota Domisili:</strong><br>{{ $user->domisili ?? '-' }}</div>
                <div class="mb-2"><strong>Bidang / Instansi:</strong><br>{{ $user->isAdmin() ? 'Administrator Pusat' : ($user->isVolunteer() ? ($user->volunteer_type ?? 'Umum') : ($user->instansi ?? '-')) }}</div>
                <div><strong>Bergabung Sejak:</strong><br>{{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}</div>
            </div>

            <div class="badge bg-success-subtle text-success border border-success p-2 w-100 rounded-pill">
                <i class="bi bi-check-circle me-1"></i> Akun Terverifikasi Admin GDI
            </div>
        </div>
    </div>

    <!-- FORM EDIT PROFIL & PASSWORD -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="border: 1px solid #e8edea !important;">
            <form action="{{ route('portal.profile.update') }}" method="POST">
                @csrf

                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-pencil me-2 text-success"></i>Perbarui Data Diri</h5>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nama Lengkap *</label>
                        <input type="text" class="form-control rounded-3" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nomor WhatsApp Aktif *</label>
                        <input type="text" class="form-control rounded-3" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Kota / Domisili *</label>
                        <input type="text" class="form-control rounded-3" name="domisili" value="{{ old('domisili', $user->domisili) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Email (Tidak dapat diubah)</label>
                        <input type="email" class="form-control rounded-3 bg-light" value="{{ $user->email }}" disabled readonly>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Catatan Pengalaman / Rencana Kemitraan</label>
                        <textarea class="form-control rounded-3" name="organisasi" rows="3">{{ old('organisasi', $user->organisasi) }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-key me-2 text-warning"></i>Ubah Password</h5>
                <p class="text-muted small">Kosongkan jika tidak ingin mengubah kata sandi login Anda.</p>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Password Baru</label>
                        <input type="password" class="form-control rounded-3" name="password" placeholder="Minimal 6 karakter">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Ulangi Password Baru</label>
                        <input type="password" class="form-control rounded-3" name="password_confirmation" placeholder="Konfirmasi password">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection