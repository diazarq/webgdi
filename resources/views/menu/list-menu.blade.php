@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Menu</li>
    </ol>
@endsection

@section('content')
<div class="container">
    <h5>Daftar Menu Website</h5>
    <a href="/admin/menu/add" class="btn btn-primary"><i class="bi-plus-square"></i> Tambah Menu</a>
    <hr/>

    <table id="datatable" class="table" style="width:100%">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th>Menu</th>
                <!--<th>Parent</th>-->
                <th>Page Type</th>
                <th>Menu Type</th>
                <th>Footer Display</th>
                <th>Status</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @if($list_menu)
                @php 
                    $no = 1;
                @endphp
                @foreach($list_menu as $menu)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $menu['title'] }}</td>
                        <td>{{ $menu['page_type'] }}</td>
                        <td>{{ $menu['menu_type'] }}</td>
                        <td>{{ $menu['footer_display'] }}</td>
                        <td>{!! (strtolower($menu['status_display']) == 'draft' ? '<span class="badge bg-secondary">Draft</span>' : '<span class="badge bg-primary">Publish</span>') !!}</td>
                        <td>
                            <a href="/admin/menu/{{ $menu['id'] }}/edit" class="btn btn-sm btn-primary"><i class="bi-pencil-square"></i></a> 
                            <button type="button" class="btn btn-sm btn-danger btn-del" data-id="{{ $menu['id'] }}"><i class="bi-trash"></i></button>
                        </td>
                    </tr>

                    @php
                        $child = json_decode($menu['child'], TRUE);
                    @endphp
                    @if($child)
                        @foreach($child as $ch)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td><span style="padding-right: 10px"><i class="bi-arrow-right"></i></span> {{ $ch['title'] }}</td>
                            <td>{{ $pageType[$ch['page_type']] ?? ($ch['page_type'] ? ucfirst($ch['page_type']) : '-') }}</td>
                            <td>{{ ucfirst($ch['menu_type']) }}</td>
                            <td>{{ $ch['footer_display'] == 'A' ? 'Ya' : 'Tidak' }}</td>
                            <td>{!! (strtolower($ch['status_display']) == 'draft' ? '<span class="badge bg-secondary">Draft</span>' : '<span class="badge bg-primary">Publish</span>') !!}</td>
                            <td>
                                <a href="/admin/menu/{{ $ch['id'] }}/edit" class="btn btn-sm btn-primary"><i class="bi-pencil-square"></i></a> 
                                <button type="button" class="btn btn-sm btn-danger btn-del" data-id="{{ $ch['id'] }}"><i class="bi-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            var table = $('#datatable').DataTable({
                paging: false,
                order: false
            });
            /*
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ '/admin/menu/table' }}",
                columns: [
                    { 
                        data: 'DT_RowIndex',
                        orderable: false, searchable: false
                    },
                    { data: 'title' },
                    { data: 'parent_id' }, //sementara -> nanti diganti sama title menu yang menjadi parentnya, jika tidak punya parent_id, maka dikosongkan saja/null
                    { data: 'page_type' },
                    { data: 'menu_type' },
                    { 
                        data: 'footer_display',
                        render: function(data, type, row, meta){
                            return (data == 'A' ? 'Ya' : 'Tidak');
                        }
                    },
                    {
                        data: 'status_display',
                        render: function(data, type, row, meta){
                            return '<span class="badge rounded-pill bg-primary">'+data+'</span>';
                        }
                        
                    },
                    { 
                        data: 'action',
                        orderable: false, searchable: false
                    },
                ],
            });
            */

            $(document).on('click', '.btn-del', function(){
                const id = $(this).data('id');

                swal({
                    title: "Peringatan!",
                    text: "Menghapus data berikut akan berdampak pada fungsi lainnya. Anda yakin akan menghapus data yang bersangkutan?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.get('/admin/menu/'+id+'/delete', function(){
                            //table.ajax.reload(false, null);
                            //swal('Berhasil!', 'Data telah dihapus!', 'success');

                            swal({
                                title: 'Berhasil!',
                                text: 'Data telah dihapus!',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = '/admin/menu';
                            })
                        });
                    }
                });
            })
        })
    </script>
@endpush
