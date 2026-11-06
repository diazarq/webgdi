@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Navigasi</a></li>
        <li class="breadcrumb-item active" aria-current="page">Blog</li>
    </ol>
@endsection

@section('content')
<div class="container">
    <h5>Daftar Blog/Berita</h5>
    <a href="/admin/blog/add" class="btn btn-primary"><i class="bi-plus-square"></i> Tambah Blog</a>
    <hr/>

    <table id="datatable" class="table" style="width:100%">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th>Judul Blog</th>
                <th>Author</th>
                <th>Kategori</th>
                <th>Jenis Blog</th>
                <th>Status</th>
                <th>Tanggal Publish</th>
                <th>&nbsp;</th>
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
                ajax: "{{ '/admin/blog/table' }}",
                columns: [
                    { 
                        data: 'DT_RowIndex',
                        orderable: false, searchable: false
                    },
                    { data: 'title' },
                    { data: 'author' },
                    { data: 'kategori' },
                    { 
                        data: 'jenis',
                        defaultContent: '-',
                        render: function(data){
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'status',
                        render: function(data, type, row, meta){
                            return (data == 'draft' ? '<span class="badge bg-secondary">Draft</span>' : '<span class="badge bg-primary">Publish</span>');
                        }
                    },
                    { data: 'date_publish'},
                    { 
                        data: 'action',
                        orderable: false, searchable: false
                    },
                ],
            });

            $(document).on('click', '.btn-del', function(){
                const id = $(this).data('id');

                swal({
                    title: "Peringatan!",
                    text: "Anda yakin akan menghapus data berikut?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.get('/admin/blog/'+id+'/delete', function(){
                            table.ajax.reload(false, null);
                            swal('Berhasil!', 'Data telah dihapus!', 'success');
                        });
                    }
                });
            })
        })
    </script>
@endpush
