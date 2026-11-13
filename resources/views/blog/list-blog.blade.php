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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Daftar Blog/Berita</h5>
        <a href="/admin/blog/add" class="btn btn-primary"><i class="bi-plus-square"></i> Tambah Blog</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body p-2">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <button class="nav-link active btn-filter" data-filter="">Semua Berita</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn-filter text-warning fw-semibold" data-filter="draft"><i class="bi-clock-history"></i> Menunggu ACC (Draft)</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn-filter text-info fw-semibold" data-filter="mitra_volunteer"><i class="bi-people"></i> Kiriman Relawan & Mitra</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn-filter text-success" data-filter="publish"><i class="bi-check2"></i> Sudah Publish</button>
                </li>
            </ul>
        </div>
    </div>
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
            var activeFilter = '';

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ '/admin/blog/table' }}",
                    data: function(d) {
                        d.filter_status = activeFilter;
                    }
                },
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

            $('.btn-filter').on('click', function(){
                $('.btn-filter').removeClass('active');
                $(this).addClass('active');
                activeFilter = $(this).data('filter');
                table.ajax.reload();
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
