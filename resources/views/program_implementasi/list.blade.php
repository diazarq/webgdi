@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Program</a></li>
        <li class="breadcrumb-item active" aria-current="page">Program Implementasi</li>
    </ol>
@endsection

@section('content')
<div class="container">
    <h5>Daftar Program Implementasi</h5>
    <p class="text-muted">Klik baris atau ikon daftar pada kolom <strong>Dokumentasi</strong> untuk mengelola dokumentasi kegiatan program yang bersangkutan.</p>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="/admin/program/implementasi/add" class="btn btn-primary"><i class="bi-plus-square"></i> Tambah Program Implementasi</a>
    </div>
    <hr/>

    <table id="datatable" class="table" style="width:100%">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="12%">Logo</th>
                <th>Nama Program</th>
                <th width="16%">Status Homepage</th>
                <th width="14%">Dibuat Oleh</th>
                <th width="14%">Dokumentasi</th>
                <th width="12%">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ '/admin/program/implementasi/table' }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false },
                    { data: 'logo', name: 'logo_image', orderable: false, searchable: false },
                    { data: 'nama_program', name: 'nama_program' },
                    { data: 'status_badge', name: 'status', orderable: false, searchable: false },
                    { data: 'create_user', name: 'create_user' },
                    { data: 'dokumentasi', name: 'dokumentasi', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                columnDefs: [
                    { className: 'align-middle', targets: '_all' },
                    { className: 'text-center', targets: [3, 5, 6] },
                ]
            });

            /* klik baris untuk langsung membuka kelola dokumentasi program */
            $('#datatable tbody').on('click', 'tr', function(e){
                if ($(e.target).closest('a, button').length) {
                    return;
                }
                var href = $(this).find('.btn-docs').attr('href');
                if (href) {
                    window.location.href = href;
                }
            });

            /* hapus program implementasi */
            $(document).on('click', '.btn-del', function(e){
                e.stopPropagation();
                var id = $(this).data('id');
                if (confirm('Yakin ingin menghapus program implementasi ini?')) {
                    $.get('/admin/program/implementasi/' + id + '/delete', function(){
                        table.ajax.reload(null, false);
                    });
                }
            });
        })
    </script>
@endpush
