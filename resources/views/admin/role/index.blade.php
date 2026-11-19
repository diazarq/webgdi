@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manajemen Role</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-3">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">Manajemen Role</h4>
            <p class="text-muted mb-0 small">Daftar peran pengguna dan wewenang operasional sistem</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary px-3 shadow-sm" onclick="alert('Fitur tambah role custom siap dihubungkan ke database roles.')">
                <i class="bi-plus-lg me-1"></i> Tambah Role Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Cards List -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle w-100 mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="20%">Nama Role</th>
                            <th>Deskripsi Wewenang</th>
                            <th class="text-center" width="15%">Jumlah User</th>
                            <th class="text-center" width="22%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $idx => $r)
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td>
                                <strong>{{ $r['name'] }}</strong>
                                <br><small class="text-muted font-monospace">{{ $r['slug'] }}</small>
                            </td>
                            <td>{{ $r['description'] }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $r['user_count'] }} Pengguna</span>
                            </td>
                            <td class="text-center">
                                <a href="/admin/user-privilege?role={{ $r['slug'] }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-key-fill me-1"></i> Atur Privilege
                                </a>
                                @if(!$r['is_system'])
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Role sistem terlindungi.')"><i class="bi bi-trash"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 mt-3 d-flex align-items-center shadow-sm" style="background-color: #e3f2fd; color: #0d47a1;">
        <i class="bi-shield-check fs-4 me-2 text-primary"></i>
        <div class="small">
            <strong>Struktur Role:</strong> Superadmin dan Admin merupakan role sistem bawaan. Anda dapat mengatur matriks izin setiap role melalui menu <strong><a href="/admin/user-privilege" class="alert-link">User Privilege</a></strong>.
        </div>
    </div>
</div>
@endsection
