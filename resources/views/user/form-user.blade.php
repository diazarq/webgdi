@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item"><a href="/admin/user">Kelola User</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $mode }}</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">{{ $mode }} User</h5>
                    <a href="/admin/user" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="post" action="/admin/user/add">
                        @csrf
                        <input type="hidden" name="id" value="{{ @$detail->id }}"/>

                        <!-- Row 1: Nama Lengkap & Email -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" required 
                                       placeholder="contoh: Siti Aminah" 
                                       value="{{ old('name', @$detail->name) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" required 
                                       placeholder="contoh: siti@mail.com" 
                                       value="{{ old('email', @$detail->email) }}">
                            </div>
                        </div>

                        <!-- Row 2: Password & Konfirmasi Password -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Password {!! !@$detail->id ? '<span class="text-danger">*</span>' : '' !!}
                                </label>
                                <input type="password" class="form-control" name="password" id="password"
                                       {{ !@$detail->id ? 'required' : '' }} 
                                       placeholder="{{ @$detail->id ? 'Kosongkan jika tidak diubah' : 'Minimal 6 karakter' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                                       placeholder="Ulangi password di atas">
                                <div id="pass-match-feedback" class="small mt-1" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Row 3: Role & Status -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                <select class="form-select" name="role_type" required>
                                    <option value="">-- Pilih role --</option>
                                    @php
                                        $currentRole = old('role_type', @$detail->role_type);
                                        if(!$currentRole && @$detail->level == 1) $currentRole = 'admin';
                                        if(!$currentRole && @$detail->level == 2) $currentRole = 'volunteer';
                                        if(!$currentRole && @$detail->level == 3) $currentRole = 'mitra';
                                    @endphp
                                    @foreach($roles as $roleKey => $roleLabel)
                                        <option value="{{ $roleKey }}" {{ $currentRole == $roleKey ? 'selected' : '' }}>
                                            {{ $roleLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="A" {{ old('status', @$detail->status) == 'A' ? 'selected' : '' }}>Aktif</option>
                                    <option value="NA" {{ old('status', @$detail->status) == 'NA' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Info Callout (Sesuai Wireframe Image 2) -->
                        <div class="alert alert-primary border-0 d-flex align-items-center mb-4" style="background-color: #e7f1ff; color: #0c63e4;">
                            <i class="bi bi-info-circle-fill fs-5 me-2"></i>
                            <div class="small">
                                Role Admin hanya bisa dipilih oleh Superadmin. Saat Anda mengedit user, kosongkan kolom password jika tidak ingin mengubah password akun.
                            </div>
                        </div>

                        <!-- Buttons: Batal & Simpan -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/admin/user" class="btn btn-outline-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        // Validasi kesamaan konfirmasi password
        $('#password_confirmation, #password').on('keyup', function () {
            var pass = $('#password').val();
            var confirm = $('#password_confirmation').val();
            var feedback = $('#pass-match-feedback');

            if (confirm.length > 0) {
                feedback.show();
                if (pass === confirm) {
                    feedback.html('<span class="text-success"><i class="bi bi-check-circle"></i> Password cocok</span>');
                } else {
                    feedback.html('<span class="text-danger"><i class="bi bi-x-circle"></i> Password belum cocok</span>');
                }
            } else {
                feedback.hide();
            }
        });
    });
</script>
@endpush
