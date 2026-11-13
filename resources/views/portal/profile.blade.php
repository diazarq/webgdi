@extends('portal.layout')
@section('title', 'Profil & Pengaturan Akun')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1"><i class="bi bi-person-gear text-success me-2"></i>Profil & Pengaturan Akun</h4>
    <p class="text-muted small mb-0">Perbarui data diri, kontak WhatsApp, dan kata sandi akun Anda.</p>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
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
        <div class="portal-card p-4 text-center">
            <div class="avatar-circle mx-auto mb-3" style="width: 72px; height: 72px; font-size: 1.8rem;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <div class="text-muted small mb-2">@<span>{{ $user->username }}</span></div>

            @if($user->isAdmin())
                <span class="badge bg-danger px-3 py-2 mb-3">
                    <i class="bi bi-shield-lock-fill me-1"></i> Administrator GDI
                </span>
            @elseif($user->isVolunteer())
                <span class="badge bg-success px-3 py-2 mb-3">
                    <i class="bi bi-heart-fill me-1"></i> Relawan Sahabat Baik
                </span>
            @else
                <span class="badge bg-warning text-dark px-3 py-2 mb-3">
                    <i class="bi bi-briefcase-fill me-1"></i> Mitra / Amil Zakat
                </span>
            @endif

            <div class="bg-light p-3 rounded text-start small mb-3">
                <div class="mb-2"><strong>Email:</strong><br>{{ $user->email }}</div>
                <div class="mb-2"><strong>WhatsApp:</strong><br>{{ $user->phone ?? '-' }}</div>
                <div class="mb-2"><strong>Kota:</strong><br>{{ $user->domisili ?? '-' }}</div>
                <div class="mb-2"><strong>Bidang / Instansi:</strong><br>{{ $user->isAdmin() ? 'Administrator Pusat' : ($user->isVolunteer() ? ($user->volunteer_type ?? 'Umum') : ($user->instansi ?? '-')) }}</div>
                <div><strong>Bergabung Sejak:</strong><br>{{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}</div>
            </div>

            <div class="badge bg-success-subtle text-success border border-success p-2 w-100">
                <i class="bi bi-shield-check me-1"></i> Akun Terverifikasi Admin GDI
            </div>
        </div>
    </div>

    <!-- FORM EDIT PROFIL & PASSWORD -->
    <div class="col-lg-8">
        <div class="portal-card p-4 p-md-5">
            <form action="{{ route('portal.profile.update') }}" method="POST">
                @csrf

                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-pencil me-2 text-success"></i>Perbarui Data Diri</h5>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nama Lengkap *</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nomor WhatsApp Aktif *</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Kota / Domisili *</label>
                        <input type="text" class="form-control" name="domisili" value="{{ old('domisili', $user->domisili) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Email (Tidak dapat diubah)</label>
                        <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled readonly>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Catatan Pengalaman / Rencana Kemitraan</label>
                        <textarea class="form-control" name="organisasi" rows="3">{{ old('organisasi', $user->organisasi) }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-key me-2 text-warning"></i>Ubah Password</h5>
                <p class="text-muted small">Kosongkan jika tidak ingin mengubah kata sandi login Anda.</p>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Password Baru</label>
                        <input type="password" class="form-control" name="password" placeholder="Minimal 6 karakter">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Ulangi Password Baru</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi password">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

