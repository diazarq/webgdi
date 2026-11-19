@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola User</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-3">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">Kelola User</h4>
            <p class="text-muted mb-0 small">Pengaturan akun pengguna dan role Yayasan Graha Dhuafa Indonesia</p>
        </div>
        <div>
            <a href="/admin/user/add" class="btn btn-primary px-3 shadow-sm">
                <i class="bi-plus-lg me-1"></i> Tambah User
            </a>
        </div>
    </div>

    <!-- Alert Success / Error jika ada session flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="datatable-user" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Status</th>
                            <th>Dibuat</th>
                            <th class="text-center" width="18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Note Box (Sesuai Wireframe) -->
    <div class="alert alert-warning border-0 mt-3 d-flex align-items-center shadow-sm" style="background-color: #fff8e1; color: #856404;">
        <i class="bi-info-circle-fill fs-5 me-2 text-warning"></i>
        <div class="small">
            <strong>Catatan Otoritas:</strong> Hanya Superadmin yang bisa membuat user Admin. Role menentukan menu sidebar dan batasan aksi yang tampil saat user login.
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        var table = $('#datatable-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ '/admin/user/table' }}",
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false, 
                    className: 'text-center' 
                },
                { 
                    data: 'name', 
                    name: 'name',
                    render: function(data, type, row) {
                        return '<strong>' + (data || '-') + '</strong>' + 
                               (row.username ? '<br><small class="text-muted">@' + row.username + '</small>' : '');
                    }
                },
                { data: 'email', name: 'email' },
                { data: 'role_badge', name: 'role_type' },
                { data: 'status_badge', name: 'status', className: 'text-center' },
                { data: 'created_date', name: 'created_at' },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false, 
                    className: 'text-center' 
                },
            ],
            language: {
                search: "Cari nama / email...",
                searchPlaceholder: "Ketik kata kunci...",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Tidak ada data user yang sesuai",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: '<i class="bi bi-chevron-right"></i>',
                    previous: '<i class="bi bi-chevron-left"></i>'
                }
            }
        });

        $(document).on('click', '.btn-del', function(){
            var id = $(this).data('id');
            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin ingin menghapus user ini?",
                icon: "warning",
                buttons: ["Batal", "Ya, Hapus"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '/admin/user/' + id + '/delete',
                        type: 'GET',
                        success: function(res) {
                            swal("Berhasil!", "User berhasil dihapus.", "success");
                            table.ajax.reload();
                        },
                        error: function(err) {
                            var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : "Gagal menghapus user.";
                            swal("Gagal!", msg, "error");
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
