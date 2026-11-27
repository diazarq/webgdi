@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Program</a></li>
        <li class="breadcrumb-item active" aria-current="page">Hero Landing</li>
    </ol>
@endsection

@section('content')
<div class="container">
    <h5>Daftar Hero Landing Program</h5>
    <p class="text-muted">Data Hero Landing otomatis terhubung dengan <strong><a href="/admin/program/implementasi">Program Implementasi</a></strong>. Mengubah nama atau logo program akan otomatis tersinkron di kedua menu.</p>
    <p class="text-muted"><i class="bi-info-circle"></i> Klik ikon <i class="bi-list"></i> pada kolom Urutan untuk membuka halaman pengaturan urutan tampil.</p>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="/admin/program/landing/add" class="btn btn-primary"><i class="bi-plus-square"></i> Tambah Hero Landing</a>
        <a href="/admin/program/implementasi" class="btn btn-outline-secondary"><i class="bi-box-arrow-up-right"></i> Buka Program Implementasi</a>
    </div>
    <hr/>

    <table id="datatable" class="table" style="width:100%">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="8%">Logo</th>
                <th>Judul Hero</th>
                <th>Program Terhubung</th>
                <th width="8%">Urutan</th>
                <th width="10%">Status</th>
                <th width="10%">&nbsp;</th>
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
                ajax: "{{ '/admin/program/landing/table' }}",
                columnDefs: [
                    { className: 'align-middle', targets: '_all' }
                ],
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false },
                    { data: 'logo', name: 'logo_image', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'program_name', name: 'slug' },
                    { data: 'drag_handle', name: 'drag_handle', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            $(document).on('click', '.btn-del', function(){
                const id = $(this).data('id');

                swal({
                    title: "Peringatan!",
                    text: "Hero landing yang dihapus akan mengembalikan tampilan default di halaman terkait. Anda yakin akan menghapus data yang bersangkutan?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.get('/admin/program/landing/'+id+'/delete', function(){
                            table.ajax.reload(null, false);
                            swal('Berhasil!', 'Data telah dihapus!', 'success');
                        });
                    }
                });
            })
        })
    </script>
@endpush
