@extends('layout.app', ['active' => $active])
@section('meta')
    <meta name="csrf_token" id="csrf_token" content="{{ csrf_token() }}" />
@endsection
@section('title', ($pageTitle ?? 'Monitoring Donasi Masuk'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
        <li class="breadcrumb-item active" aria-current="page">Donasi Masuk</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 mt-2 text-dark"><i class="bi bi-wallet2 text-success me-2"></i>Monitoring Donasi Masuk</h4>
            <p class="text-muted small mb-0">Pantau seluruh donasi yang masuk dan unduh rekapan ke Excel/Spreadsheet.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" id="btnExportExcel" class="btn btn-success fw-bold shadow-sm px-3 py-2 d-inline-flex align-items-center rounded-3">
                <i class="bi bi-file-earmark-excel-fill me-2 fs-5"></i> Unduh Rekapan Excel
            </button>
        </div>
    </div>

    <!-- 3 KARTU STATISTIK RINGKASAN DONASI -->
    <div class="row g-2 mb-4">
        <div class="col-lg-6 col-md-4 col-12">
            <div class="small-box bg-success text-white h-100 mb-0">
                <div class="inner p-3">
                    <h4 class="fw-bold text-white mb-1">Rp {{ number_format($totalNominal, 0, ',', '.') }}</h4>
                    <p class="mb-0 text-white-50">Total Donasi Terkumpul</p>
                </div>
                <div class="icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-4 col-12">
            <div class="small-box bg-primary text-white h-100 mb-0">
                <div class="inner p-3">
                    <h4 class="fw-bold text-white mb-1">{{ $totalSukses }}</h4>
                    <p class="mb-0 text-white-50">Donasi Sukses (Lunas)</p>
                </div>
                <div class="icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER PENCARIAN -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-funnel me-1"></i>Filter Transaksi Donasi Masuk</h6>
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label small text-muted">Rentang Tanggal</label>
                <input type="text" name="dates" class="form-control daterange-input" placeholder="Pilih rentang tanggal"/>
            </div>
            <div class="col-md-5">
                <label class="form-label small text-muted">Kode Donasi (Order ID)</label>
                <input type="text" name="transcode" class="form-control" placeholder="Contoh: MID-2611..."/>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-primary w-100 btn-search py-2">
                    <i class="bi-search me-1"></i> Filter
                </button>
            </div>
        </div>
    </div>

    <!-- TABEL DATA TRANSAKSI DONASI -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="thead-dark">
            <table id="datatableDonasi" class="table table-hover align-middle" style="width:100%">  
                <thead class="table-light">
                    <tr>
                        <th width="4%">No.</th>
                        <th>Tanggal</th>
                        <th>Kode Donasi</th>
                        <th>Nama Donatur</th>
                        <th>No. WhatsApp</th>
                        <th>Program / Musibah</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th width="8%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- CSS -->

<style>
/* Pastikan kontainer segmen transparan agar kartu menonjol di latar abu-abu */
.cs-segment {
    background: transparent !important;
    padding: 0 !important;
    box-shadow: none !important;
    border: none !important;
}

/* Small Box Cards */
.small-box {
    border-radius: 6px;
    position: relative;
    display: block;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 2px 4px rgba(0,0,0,.08);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.small-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
}
.small-box .inner {
    padding: 16px 20px;
}
.small-box .inner h3 {
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0 0 6px 0;
    white-space: nowrap;
    padding: 0;
}
.small-box .inner p {
    font-size: 0.95rem;
    margin-bottom: 0;
    opacity: 0.95;
    font-weight: 500;
}
.small-box .icon {
    color: rgba(0, 0, 0, 0.15);
    z-index: 0;
    position: absolute;
    right: 15px;
    top: 10px;
    transition: all .3s linear;
}
.small-box .icon i {
    font-size: 68px;
}
.small-box:hover .icon {
    font-size: 73px;
    color: rgba(0, 0, 0, 0.25);
}
.small-box-footer {
    position: relative;
    text-align: center;
    padding: 6px 0;
    color: rgba(255, 255, 255, 0.88);
    display: block;
    z-index: 10;
    background: rgba(0, 0, 0, 0.12);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s;
}
.small-box-footer:hover {
    color: #fff;
    background: rgba(0, 0, 0, 0.22);
}
.bg-warning .small-box-footer {
    color: rgba(0, 0, 0, 0.8);
    background: rgba(0, 0, 0, 0.08);
}
.bg-warning .small-box-footer:hover {
    color: #000;
    background: rgba(0, 0, 0, 0.15);
}

/* Thumbnail Program Donasi */
.program-thumb {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
}

/* Tabel Kustom */
.custom-table tbody tr {
    border-bottom: 1px solid #f1f1f1;
}
.custom-table tbody tr:last-child {
    border-bottom: none;
}
</style>
@endsection


@push('scripts')
<script>
    function formatTanggal(dateStr) {
        if (!dateStr) return '-';
        var d = new Date(dateStr);
        var month = d.getMonth() + 1;
        return d.getDate() + '/' + (month < 10 ? '0' + month : month) + '/' + d.getFullYear() + ' ' + 
               (d.getHours() < 10 ? '0' + d.getHours() : d.getHours()) + ':' + 
               (d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes());
    }

    $(document).ready(function(){
        var headerToken = $('#csrf_token').attr('content');

        var table = $('#datatableDonasi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.donasi.table') }}",
                type: 'POST',
                data: function(e){
                    e._token = headerToken;
                    e.dates = $('[name=dates]').val();
                    e.transcode = $('[name=transcode]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { 
                    data: 'created_at',
                    render: function(data){
                        return '<small class="text-muted">' + formatTanggal(data) + '</small>';
                    }
                },
                { 
                    data: 'transcode',
                    render: function(data){
                        return '<span class="font-monospace fw-bold text-dark">' + data + '</span>';
                    }
                },
                { 
                    data: 'name',
                    render: function(data, type, row){
                        if (row.anonim == 1 || data === 'Hamba Allah') {
                            return '<span class="badge bg-secondary me-1">Anonim</span> Hamba Allah';
                        }
                        return '<span class="fw-semibold text-dark">' + (data || '-') + '</span>';
                    }
                },
                { 
                    data: 'notelp',
                    render: function(data){
                        return data ? '<span class="small">' + data + '</span>' : '-';
                    }
                },
                { 
                    data: 'type',
                    render: function(data){
                        return '<span class="text-truncate d-inline-block" style="max-width: 220px;" title="' + data + '">' + (data || 'Donasi Kebaikan') + '</span>';
                    }
                },
                { 
                    data: 'nominal',
                    render: function(data){
                        return '<strong class="text-success">Rp ' + (new Intl.NumberFormat('id-ID').format(data)) + '</strong>';
                    }
                },
                { 
                    data: 'payment_method',
                    render: function(data){
                        var val = data || 'VA BCA';
                        if (val.toLowerCase().includes('midtrans snap') || val.toLowerCase() === 'midtrans') {
                            val = 'VA BCA';
                        }
                        var badgeClass = 'bg-primary text-white';
                        if (val.includes('QRIS')) badgeClass = 'bg-success text-white';
                        else if (val.includes('GoPay') || val.includes('Shopee')) badgeClass = 'bg-info text-dark';
                        else if (val.includes('Mandiri')) badgeClass = 'bg-warning text-dark';
                        else if (val.includes('BCA')) badgeClass = 'bg-primary text-white';
                        else if (val.includes('BNI') || val.includes('BRI')) badgeClass = 'bg-secondary text-white';
                        return '<span class="badge ' + badgeClass + ' px-2 py-1">' + val + '</span>';
                    }
                },
                {
                    data: 'status',
                    render: function(data){
                        return '<span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>Selesai / Lunas</span>';
                    }
                },
                { data: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        // Trigger filter tombol
        $('.btn-search').on('click', function(){
            table.draw();
        });

        // Unduh Rekapan Excel/Spreadsheet Donasi Masuk
        $('#btnExportExcel').on('click', function(e){
            e.preventDefault();
            var btn = $(this);
            var originalHtml = btn.html();
            var dates = $('[name=dates]').val() || '';
            var transcode = $('[name=transcode]').val() || '';

            btn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyiapkan Excel...').prop('disabled', true);

            var exportUrl = "{{ route('admin.donasi.export') }}?dates=" + encodeURIComponent(dates) + "&transcode=" + encodeURIComponent(transcode);
            window.location.href = exportUrl;

            setTimeout(function(){
                btn.html(originalHtml).prop('disabled', false);
            }, 3000);
        });

        // Hapus / Drop Transaksi Donasi
        $(document).on('click', '.btn-delete-donasi', function(){
            var id = $(this).data('id');

            swal({
                title: "Hapus Transaksi Donasi?",
                text: "Apakah Anda yakin ingin menghapus data donasi ini secara permanen?",
                icon: "warning",
                buttons: ["Batal", "Ya, Hapus"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '/admin/donasi-masuk/' + id + '/delete',
                        type: 'GET',
                        success: function(res){
                            table.ajax.reload(false, null);
                            swal("Berhasil!", "Data transaksi donasi berhasil dihapus.", "success");
                        },
                        error: function(){
                            swal("Gagal!", "Gagal menghapus data transaksi donasi.", "error");
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

