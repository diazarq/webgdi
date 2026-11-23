@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item"><a href="/admin/role">Role</a></li>
        <li class="breadcrumb-item active" aria-current="page">User Privilege</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-3">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1 mt-2">User Privilege</h4>
            <p class="text-muted mb-0 small">Atur izin melihat, menambah, mengubah, dan menghapus untuk setiap peran</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Role Filter Selector -->
    <div class="card border-0 shadow-sm rounded-3 mb-3">
        <div class="card-body p-3">
            <form method="get" action="/admin/user-privilege" class="row align-items-center g-2">
                <div class="col-auto">
                    <label class="fw-bold text-dark">Pilih Role yang Ingin Diatur:</label>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="role" onchange="this.form.submit()">
                        @if(isset($roles) && count($roles) > 0)
                            @foreach($roles as $roleItem)
                                <option value="{{ $roleItem->name }}" {{ $selectedRole == $roleItem->name ? 'selected' : '' }}>
                                    {{ $roleItem->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="Superadmin" {{ $selectedRole == 'Superadmin' ? 'selected' : '' }}>Superadmin (Semua Akses)</option>
                            <option value="Admin (Pengurus)" {{ $selectedRole == 'Admin (Pengurus)' ? 'selected' : '' }}>Admin (Pengurus Operasional)</option>
                            <option value="Mitra" {{ $selectedRole == 'Mitra' ? 'selected' : '' }}>Mitra (Affiliate)</option>
                            <option value="Volunteer (Relawan)" {{ $selectedRole == 'Volunteer (Relawan)' ? 'selected' : '' }}>Volunteer (Relawan)</option>
                        @endif
                    </select>
                </div>
                <div class="col-auto">
                    <span class="badge bg-primary text-uppercase px-3 py-2">Role Terpilih: {{ $selectedRole }}</span>
                </div>
            </form>
        </div>
    </div>

    <!-- Matrix Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <form method="post" action="{{ route('admin.privilege.save') }}">
                @csrf
                <input type="hidden" name="role" value="{{ $selectedRole }}"/>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">Kategori</th>
                                <th width="35%">Modul / Menu</th>
                                <th class="text-center" width="10%">Lihat (View)</th>
                                <th class="text-center" width="10%">Tambah (Create)</th>
                                <th class="text-center" width="10%">Ubah (Edit)</th>
                                <th class="text-center" width="10%">Hapus (Delete)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $roleKey = strtolower($selectedRole);
                                $isSuper = str_contains($roleKey, 'superadmin');
                                $isAdmin = str_contains($roleKey, 'admin');
                                $isVol = str_contains($roleKey, 'volunteer') || str_contains($roleKey, 'relawan');
                                $isMit = str_contains($roleKey, 'mitra') || str_contains($roleKey, 'affiliate');
                                $hasSaved = !empty($rolePermissions) && is_array($rolePermissions);
                            @endphp
                            @foreach($modules as $idx => $m)
                                @php
                                    $modKey = $m['key'];
                                    if ($isSuper) {
                                        $canView = true;
                                        $canCreate = true;
                                        $canEdit = true;
                                        $canDelete = true;
                                    } elseif ($hasSaved) {
                                        // BACA LANGSUNG DARI DATABASE
                                        $canView = !empty($rolePermissions[$modKey]['view']);
                                        $canCreate = !empty($rolePermissions[$modKey]['create']);
                                        $canEdit = !empty($rolePermissions[$modKey]['edit']);
                                        $canDelete = !empty($rolePermissions[$modKey]['delete']);
                                    } else {
                                        // NILAI DEFAULT PERTAMA KALI JIKA BELUM PERNAH DISIMPAN
                                        $canView = ($isAdmin && !in_array($modKey, ['kelola_user', 'kelola_role', 'kelola_tema'])) || ($isVol && in_array($modKey, ['dashboard', 'blog', 'program'])) || ($isMit && in_array($modKey, ['dashboard', 'program', 'donasi']));
                                        $canCreate = ($isAdmin && !in_array($modKey, ['kelola_user', 'kelola_role', 'kelola_tema'])) || ($isVol && in_array($modKey, ['blog']));
                                        $canEdit = ($isAdmin && !in_array($modKey, ['kelola_user', 'kelola_role', 'kelola_tema']));
                                        $canDelete = ($isAdmin && in_array($modKey, ['blog', 'program', 'galeri']));
                                    }
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td><span class="badge bg-light text-secondary border">{{ $m['category'] }}</span></td>
                                    <td>
                                        <strong>{{ $m['name'] }}</strong>
                                        <br><small class="text-muted font-monospace">{{ $m['key'] }}</small>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="privileges[{{ $m['key'] }}][view]" value="1" {{ $canView ? 'checked' : '' }} {{ $isSuper ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="privileges[{{ $m['key'] }}][create]" value="1" {{ $canCreate ? 'checked' : '' }} {{ $isSuper ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="privileges[{{ $m['key'] }}][edit]" value="1" {{ $canEdit ? 'checked' : '' }} {{ $isSuper ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="privileges[{{ $m['key'] }}][delete]" value="1" {{ $canDelete ? 'checked' : '' }} {{ $isSuper ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white p-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        <i class="bi bi-info-circle me-1"></i> Perubahan privilege akan langsung berdampak saat user dengan role ini memuat ulang halaman.
                    </span>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Simpan Hak Akses
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
