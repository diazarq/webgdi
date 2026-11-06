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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-2 mt-3 text-dark"></i>Monitoring Donasi Masuk</h4>
            <p class="text-muted small mb-0">Pantau seluruh transaksi donasi online.</p>
        </div>
    </div>

    <!-- 3 KARTU STATISTIK RINGKASAN DONASI -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success text-white ">
                <div class="inner">
                    <h4 class="fw-bold text-white mb-0">Rp {{ number_format($totalNominal, 0, ',', '.') }}</h4>
                    <p>Transaksi Donasi Masuk</p>
                </div>
                <div class="icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <a href="/admin/zakat" class="small-box-footer">
                    Lihat Transaksi <i class="bi bi-arrow-right-circle ms-1"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-primary">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Donasi Sukses / Lunas</span>
                        <h4 class="fw-bold text-primary mb-0">{{ $totalSukses }} <small class="text-muted fs-6">Transaksi</small></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-warning">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Menunggu Pembayaran</span>
                        <h4 class="fw-bold text-warning mb-0">{{ $totalPending }} <small class="text-muted fs-6">Pending</small></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER PENCARIAN -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-funnel me-1"></i>Filter Transaksi</h6>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label small text-muted">Rentang Waktu</label>
                <input type="text" name="dates" class="form-control daterange-input" placeholder="Pilih rentang tanggal"/>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Status Pembayaran</label>
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="complete">Selesai / Lunas</option>
                    <option value="pending">Menunggu Pembayaran (Pending)</option>
                </select>
            </div>
            <div class="col-md-3">
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
        <div class="table-responsive">
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
                    e.status = $('[name=status]').val();
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
                        return '<span class="badge bg-light text-dark border">' + (data || 'Midtrans Snap') + '</span>';
                    }
                },
                {
                    data: 'status',
                    render: function(data){
                        if (data === 'complete') {
                            return '<span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>Selesai</span>';
                        }
                        return '<span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-clock me-1"></i>Pending</span>';
                    }
                },
                { data: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        // Trigger filter tombol
        $('.btn-search').on('click', function(){
            table.draw();
        });

        // Tandai Donasi Selesai / Lunas secara Manual
        $(document).on('click', '.btn-update-donasi', function(){
            var id = $(this).data('id');

            swal({
                title: "Konfirmasi Pelunasan",
                text: "Apakah Anda yakin ingin menandai donasi ini telah lunas/selesai?",
                icon: "info",
                buttons: ["Batal", "Ya, Tandai Selesai"],
                dangerMode: false,
            })
            .then((willUpdate) => {
                if (willUpdate) {
                    $.get('/admin/donasi-masuk/' + id + '/update', function(res){
                        table.ajax.reload(false, null);
                        swal("Berhasil!", "Status transaksi donasi berhasil diselesaikan.", "success");
                    });
                }
            });
        });
    });
</script>
@endpush

