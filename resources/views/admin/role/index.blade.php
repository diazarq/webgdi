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
            <h4 class="fw-bold mb-1 mt-2">Manajemen Role</h4>
            <p class="text-muted mb-0 small">Daftar peran pengguna dan wewenang operasional sistem Yayasan Graha Dhuafa Indonesia</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary px-3 shadow-sm btn-add-role">
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
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
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
                            <th width="22%">Nama Role</th>
                            <th>Deskripsi Wewenang</th>
                            <th class="text-center" width="15%">Jumlah User</th>
                            <th class="text-center" width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $idx => $r)
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td>
                                <strong>{{ $r->name }}</strong>
                            </td>
                            <td>{{ $r->description ?: '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $r->user_count }} Pengguna</span>
                            </td>
                            <td class="text-center">
                                <a href="/admin/user-privilege?role={{ urlencode($r->name) }}" class="btn btn-sm btn-outline-primary me-1" title="Atur Hak Akses Modul">
                                    <iconify-icon icon="heroicons-solid:key" class="me-1 fs-6 align-middle"></iconify-icon> Privilege
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-warning text-dark me-1 btn-edit-role"
                                        data-id="{{ $r->id }}"
                                        data-name="{{ $r->name }}"
                                        data-description="{{ $r->description }}"
                                        data-issystem="{{ $r->is_system ? 1 : 0 }}"
                                        title="Edit Role">
                                    <i class="bi-pencil-square"></i>
                                </button>
                                @if(!$r->is_system)
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-del-role" 
                                            data-id="{{ $r->id }}" 
                                            data-name="{{ $r->name }}"
                                            title="Hapus Role">
                                        <i class="bi-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada role di database.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 mt-3 d-flex align-items-center shadow-sm" style="background-color: #e3f2fd; color: #0d47a1;">
        <i class="bi-shield-check fs-4 me-2 text-primary"></i>
        <div class="small">
            <strong>Note:</strong> Hanya SuperAdmin dapat mengatur wewenang setiap menu melalui tombol <strong>Privilege</strong>.
        </div>
    </div>
</div>

<!-- MODAL TAMBAH / EDIT ROLE -->
<div class="modal fade" id="modalRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom">
                <h5 class="modal-title fw-bold" id="modalRoleTitle">Tambah Role Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.role.store') }}" id="formRole">
                @csrf
                <input type="hidden" name="id" id="role_id" value="">
                
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Role <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="role_name" required placeholder="Contoh: Editor Konten">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi Wewenang</label>
                        <textarea class="form-control" name="description" id="role_desc" rows="3" placeholder="Jelaskan peran dan tugas pengguna dengan role ini..."></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi-save me-1"></i> Simpan Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        var modalRole = new bootstrap.Modal(document.getElementById('modalRole'));

        // Tombol Tambah Role Baru
        $('.btn-add-role').click(function(){
            $('#modalRoleTitle').text('Tambah Role Baru');
            $('#role_id').val('');
            $('#role_name').val('');
            $('#role_desc').val('');
            modalRole.show();
        });

        // Tombol Edit Role
        $('.btn-edit-role').click(function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var desc = $(this).data('description');

            $('#modalRoleTitle').text('Edit Role: ' + name);
            $('#role_id').val(id);
            $('#role_name').val(name);
            $('#role_desc').val(desc);

            modalRole.show();
        });

        // Tombol Hapus Role (SweetAlert)
        $('.btn-del-role').click(function(){
            var id = $(this).data('id');
            var name = $(this).data('name');

            swal({
                title: "Hapus Role?",
                text: "Apakah Anda yakin ingin menghapus role '" + name + "'?",
                icon: "warning",
                buttons: ["Batal", "Ya, Hapus"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '/admin/role/' + id + '/delete',
                        type: 'GET',
                        success: function(res) {
                            if (res.status === 'success') {
                                swal("Berhasil!", res.message, "success").then(() => {
                                    location.reload();
                                });
                            } else {
                                swal("Gagal!", res.message, "error");
                            }
                        },
                        error: function(err) {
                            var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : "Gagal menghapus role.";
                            swal("Gagal!", msg, "error");
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
