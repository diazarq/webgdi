@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/nestable/jquery.nestable.css') }}">
    <style>
        .menu-builder-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            border: 1px solid #e9ecef;
            padding: 24px;
        }
        .dd-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 6px;
            transition: all 0.2s ease;
        }
        .dd-content:hover {
            border-color: #0d6efd;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.12);
        }
        .dd-handle {
            cursor: grab;
            padding: 6px 10px;
            margin-right: 10px;
            border-radius: 6px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
        }
        .dd-handle:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .dd-handle:active {
            cursor: grabbing;
        }
        .menu-title-text {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
        }
        .menu-badge-group {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 4px;
        }
        .nav-pills .nav-link {
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 18px;
        }
        .btn-indent, .btn-outdent {
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 6px;
        }
    </style>
@endpush

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Menu</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-list-nested me-2 text-primary"></i>Manajemen Menu Website</h4>
            <p class="text-muted small mb-0">Atur susunan urutan dan hierarki menu (sub-menu) website dengan drag & drop atau tombol cepat.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="/admin/menu/add" class="btn btn-primary d-inline-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-plus-circle"></i> Tambah Menu
            </a>
            <button type="button" id="btn_save_order" class="btn btn-success d-inline-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-check2-circle"></i> <span>Simpan Struktur & Urutan</span>
            </button>
        </div>
    </div>

    <!-- Alert notifikasi perubahan -->
    <div id="save_indicator" class="alert alert-warning alert-dismissible fade show d-none mb-3 py-2 px-3 d-flex align-items-center justify-content-between" role="alert">
        <div>
            <i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i>
            <strong>Ada perubahan posisi menu!</strong> Jangan lupa klik tombol hijau <strong>"Simpan Struktur & Urutan"</strong> untuk menerapkan ke website publik.
        </div>
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-pills mb-4" id="menuTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active d-inline-flex align-items-center gap-2" id="dragdrop-tab" data-bs-toggle="pill" data-bs-target="#dragdrop-view" type="button" role="tab" aria-controls="dragdrop-view" aria-selected="true">
                <i class="bi bi-arrows-move"></i> Mode Drag & Drop (Hierarki Menu)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-inline-flex align-items-center gap-2" id="table-tab" data-bs-toggle="pill" data-bs-target="#table-view" type="button" role="tab" aria-controls="table-view" aria-selected="false">
                <i class="bi bi-table"></i> Mode Tabel Data
            </button>
        </li>
    </ul>

    <div class="tab-content" id="menuTabsContent">
        <!-- TAB 1: DRAG & DROP HIERARCHY -->
        <div class="tab-pane fade show active" id="dragdrop-view" role="tabpanel" aria-labelledby="dragdrop-tab">
            <div class="row g-4">
                <div class="col-12">
                    <div class="menu-builder-card">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <span class="text-muted small fw-semibold text-uppercase">STRUKTUR NAVIGASI AKTIF</span>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btn_expand_all">
                                    <i class="bi bi-arrows-expand"></i> Expand Semua
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btn_collapse_all">
                                    <i class="bi bi-arrows-collapse"></i> Collapse Semua
                                </button>
                            </div>
                        </div>

                        <div class="dd" id="nestable_menu">
                            @if(!empty($list_menu) && count($list_menu) > 0)
                                <ol class="dd-list">
                                    @foreach($list_menu as $menu)
                                        <li class="dd-item" data-id="{{ $menu['id'] }}">
                                            <div class="dd-content">
                                                <div class="d-flex align-items-center">
                                                    <span class="dd-handle" title="Tahan dan geser">
                                                        <i class="bi bi-grip-vertical fs-5"></i>
                                                    </span>
                                                    <div>
                                                        <div class="menu-title-text">{{ $menu['title'] }}</div>
                                                        <div class="menu-badge-group">
                                                            <span class="badge bg-light text-dark border">{{ $menu['page_type'] }}</span>
                                                            <span class="badge bg-light text-dark border">{{ $menu['menu_type'] }}</span>
                                                            @if(strtolower($menu['status_display']) == 'draft')
                                                                <span class="badge bg-secondary">Draft</span>
                                                            @else
                                                                <span class="badge bg-success">Publish</span>
                                                            @endif
                                                            @if($menu['footer_display'] == 'Ya')
                                                                <span class="badge bg-info text-dark">Footer: Ya</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-1">
                                                    {{-- Tombol Cepat Jadikan Sub-Menu / Menu Utama --}}
                                                    <button type="button" class="btn btn-outline-primary btn-indent dd-nodrag" title="Jadikan Sub-menu (geser ke dalam di bawah menu sebelumnya)">
                                                        <i class="bi bi-arrow-right"></i> Submenu
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn-outdent dd-nodrag" title="Kembalikan Jadi Menu Utama (geser keluar)">
                                                        <i class="bi bi-arrow-left"></i> Utama
                                                    </button>
                                                    <a href="/admin/menu/{{ $menu['id'] }}/edit" class="btn btn-sm btn-outline-primary dd-nodrag ms-1" title="Edit Menu">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-del dd-nodrag" data-id="{{ $menu['id'] }}" title="Hapus Menu">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Child Level 1 --}}
                                            @if(!empty($menu['child_items']) && count($menu['child_items']) > 0)
                                                <ol class="dd-list">
                                                    @foreach($menu['child_items'] as $ch)
                                                        <li class="dd-item" data-id="{{ $ch['id'] }}">
                                                            <div class="dd-content">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="dd-handle" title="Tahan dan geser">
                                                                        <i class="bi bi-grip-vertical fs-5"></i>
                                                                    </span>
                                                                    <div>
                                                                        <div class="menu-title-text">
                                                                            <i class="bi bi-arrow-return-right text-primary me-1"></i>
                                                                            {{ $ch['title'] }}
                                                                        </div>
                                                                        <div class="menu-badge-group">
                                                                            <span class="badge bg-light text-dark border">{{ $ch['page_type'] }}</span>
                                                                            <span class="badge bg-light text-dark border">{{ $ch['menu_type'] }}</span>
                                                                            @if(strtolower($ch['status_display']) == 'draft')
                                                                                <span class="badge bg-secondary">Draft</span>
                                                                            @else
                                                                                <span class="badge bg-success">Publish</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center gap-1">
                                                                    <button type="button" class="btn btn-outline-primary btn-indent dd-nodrag" title="Jadikan Sub-menu">
                                                                        <i class="bi bi-arrow-right"></i> Submenu
                                                                    </button>
                                                                    <button type="button" class="btn btn-outline-secondary btn-outdent dd-nodrag" title="Kembalikan Jadi Menu Utama">
                                                                        <i class="bi bi-arrow-left"></i> Utama
                                                                    </button>
                                                                    <a href="/admin/menu/{{ $ch['id'] }}/edit" class="btn btn-sm btn-outline-primary dd-nodrag ms-1" title="Edit Menu">
                                                                        <i class="bi bi-pencil-square"></i>
                                                                    </a>
                                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-del dd-nodrag" data-id="{{ $ch['id'] }}" title="Hapus Menu">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            {{-- Child Level 2 (Sub-submenu) --}}
                                                            @if(!empty($ch['sub_child']) && count($ch['sub_child']) > 0)
                                                                <ol class="dd-list">
                                                                    @foreach($ch['sub_child'] as $sub)
                                                                        <li class="dd-item" data-id="{{ $sub->id }}">
                                                                            <div class="dd-content">
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="dd-handle" title="Tahan dan geser">
                                                                                        <i class="bi bi-grip-vertical fs-5"></i>
                                                                                    </span>
                                                                                    <div>
                                                                                        <div class="menu-title-text">
                                                                                            <i class="bi bi-arrow-return-right text-success me-1"></i>
                                                                                            {{ $sub->title }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-center gap-1">
                                                                                    <button type="button" class="btn btn-outline-secondary btn-outdent dd-nodrag" title="Geser Keluar">
                                                                                        <i class="bi bi-arrow-left"></i> Keluar
                                                                                    </button>
                                                                                    <a href="/admin/menu/{{ $sub->id }}/edit" class="btn btn-sm btn-outline-primary dd-nodrag ms-1" title="Edit Menu">
                                                                                        <i class="bi bi-pencil-square"></i>
                                                                                    </a>
                                                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-del dd-nodrag" data-id="{{ $sub->id }}" title="Hapus Menu">
                                                                                        <i class="bi bi-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ol>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                    Belum ada data menu. Klik tombol <strong>Tambah Menu</strong> di atas.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: TABLE VIEW -->
        <div class="tab-pane fade" id="table-view" role="tabpanel" aria-labelledby="table-tab">
            <div class="menu-builder-card">
                <table id="datatable" class="table table-hover align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No.</th>
                            <th>Menu</th>
                            <th>Page Type</th>
                            <th>Menu Type</th>
                            <th>Footer Display</th>
                            <th>Status</th>
                            <th width="12%" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($list_menu)
                            @php $no = 1; @endphp
                            @foreach($list_menu as $menu)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><strong>{{ $menu['title'] }}</strong></td>
                                    <td>{{ $menu['page_type'] }}</td>
                                    <td>{{ $menu['menu_type'] }}</td>
                                    <td>{{ $menu['footer_display'] }}</td>
                                    <td>{!! (strtolower($menu['status_display']) == 'draft' ? '<span class="badge bg-secondary">Draft</span>' : '<span class="badge bg-success">Publish</span>') !!}</td>
                                    <td class="text-end">
                                        <a href="/admin/menu/{{ $menu['id'] }}/edit" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil-square"></i></a> 
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-del" data-id="{{ $menu['id'] }}" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>

                                @php
                                    $child = json_decode($menu['child'], TRUE);
                                @endphp
                                @if($child)
                                    @foreach($child as $ch)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td><span class="ps-3"><i class="bi bi-arrow-return-right text-primary me-1"></i> {{ $ch['title'] }}</span></td>
                                        <td>{{ $pageType[$ch['page_type']] ?? ($ch['page_type'] ? ucfirst($ch['page_type']) : '-') }}</td>
                                        <td>{{ ucfirst($ch['menu_type']) }}</td>
                                        <td>{{ $ch['footer_display'] == 'A' ? 'Ya' : 'Tidak' }}</td>
                                        <td>{!! (strtolower($ch['status_display']) == 'draft' ? '<span class="badge bg-secondary">Draft</span>' : '<span class="badge bg-success">Publish</span>') !!}</td>
                                        <td class="text-end">
                                            <a href="/admin/menu/{{ $ch['id'] }}/edit" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil-square"></i></a> 
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-del" data-id="{{ $ch['id'] }}" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/plugins/nestable/jquery.nestable.js') }}"></script>
    <script>
        $(document).ready(function(){
            // Inisialisasi DataTable untuk Tab Tabel
            var table = $('#datatable').DataTable({
                paging: false,
                order: false
            });

            // Inisialisasi Nestable
            var $nestable = $('#nestable_menu');
            $nestable.nestable({
                maxDepth: 3,
                threshold: 25
            });

            // Tampilkan indikator perubahan saat drag & drop atau indent terjadi
            $nestable.on('change', function(){
                $('#save_indicator').removeClass('d-none');
            });

            // Tombol Cepat: Jadikan Submenu (➡️)
            $(document).on('click', '.btn-indent', function(e){
                e.preventDefault();
                e.stopPropagation();
                var item = $(this).closest('li.dd-item');
                var success = $nestable.nestable('indentItem', item);
                if(success){
                    $('#save_indicator').removeClass('d-none');
                } else {
                    swal('Info', 'Menu ini tidak bisa dijadikan submenu (pastikan ada menu lain di atasnya atau batas maksimal 3 tingkat tercapai).', 'info');
                }
            });

            // Tombol Cepat: Jadikan Menu Utama (⬅️)
            $(document).on('click', '.btn-outdent', function(e){
                e.preventDefault();
                e.stopPropagation();
                var item = $(this).closest('li.dd-item');
                var success = $nestable.nestable('outdentItem', item);
                if(success){
                    $('#save_indicator').removeClass('d-none');
                } else {
                    swal('Info', 'Menu ini sudah berada pada tingkat utama.', 'info');
                }
            });

            // Tombol Expand & Collapse
            $('#btn_expand_all').on('click', function(){
                $nestable.nestable('expandAll');
            });
            $('#btn_collapse_all').on('click', function(){
                $nestable.nestable('collapseAll');
            });

            // Tombol Simpan Struktur & Urutan
            $('#btn_save_order').on('click', function(){
                var $btn = $(this);
                var originalHtml = $btn.html();
                var hierarchy = $nestable.nestable('serialize');

                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');

                $.ajax({
                    url: '{{ route("admin.menu.reorder") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        hierarchy: JSON.stringify(hierarchy)
                    },
                    success: function(res){
                        $btn.prop('disabled', false).html(originalHtml);
                        $('#save_indicator').addClass('d-none');

                        swal({
                            title: 'Berhasil!',
                            text: res.message || 'Struktur dan urutan menu berhasil diperbarui!',
                            icon: 'success'
                        });
                    },
                    error: function(xhr){
                        $btn.prop('disabled', false).html(originalHtml);
                        var errMsg = 'Terjadi kesalahan saat menyimpan susunan menu.';
                        if(xhr.responseJSON && xhr.responseJSON.message){
                            errMsg = xhr.responseJSON.message;
                        }
                        swal({
                            title: 'Gagal!',
                            text: errMsg,
                            icon: 'error'
                        });
                    }
                });
            });

            // Hapus Menu
            $(document).on('click', '.btn-del', function(){
                const id = $(this).data('id');

                swal({
                    title: "Peringatan!",
                    text: "Menghapus menu ini akan berdampak pada submenu di bawahnya dan navigasi website. Anda yakin?",
                    icon: "warning",
                    buttons: ["Batal", "Ya, Hapus"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.get('/admin/menu/'+id+'/delete', function(){
                            swal({
                                title: 'Berhasil!',
                                text: 'Menu telah dihapus!',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = '/admin/menu';
                            });
                        });
                    }
                });
            });
        });
    </script>
@endpush
