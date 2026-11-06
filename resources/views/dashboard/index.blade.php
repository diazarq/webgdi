@extends('layout.app')
@section('title', 'Dashboard Lembaga Zakat - CMS Admin')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="bi bi-house"></i> Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-0 dashboard-wrapper">

    <!-- ============================================================== -->
    <!-- SECTION 1: HEADER JUDUL DASHBOARD & BREADCRUMB               -->
    <!-- ============================================================== -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0 fw-bold text-dark">Dashboard Lembaga Zakat</h4>
            <small class="text-muted">Ikhtisar Pengelolaan Zakat, Infaq & Sedekah Yayasan Graha Dhuafa Indonesia</small>
        </div>
        <span class="text-muted small">Home / Dashboard</span>
    </div>

    <!-- ============================================================== -->
    <!-- SECTION 2: 4 KOTAK STATISTIK ZISWAF (SMALL BOXES)              -->
    <!-- ============================================================== -->
    <div class="row g-3 mb-4">
        <!-- Box 1: Biru (Transaksi Zakat & Donasi Masuk) -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary text-white">
                <div class="inner">
                    <h3>{{ $totalTransaksi ?? 150 }}</h3>
                    <p>Transaksi Zakat Masuk</p>
                </div>
                <div class="icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <a href="/admin/zakat" class="small-box-footer">
                    Lihat Transaksi <i class="bi bi-arrow-right-circle ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Box 2: Hijau (Tingkat Penyaluran Mustahik) -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success text-white">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Penyaluran ke Mustahik</p>
                </div>
                <div class="icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <a href="/admin/program" class="small-box-footer">
                    Kelola Penyaluran <i class="bi bi-arrow-right-circle ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Box 3: Kuning (Muzakki & Donatur Terdaftar) -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning text-dark">
                <div class="inner">
                    <h3 class="text-dark">{{ $totalDonatur ?? 44 }}</h3>
                    <p class="text-dark">Muzakki & Donatur</p>
                </div>
                <div class="icon text-dark">
                    <i class="bi bi-people-fill"></i>
                </div>
                <a href="/admin/user" class="small-box-footer text-dark">
                    Data Donatur <i class="bi bi-arrow-right-circle ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Box 4: Merah (Pesan, Konsultasi & Doa) -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger text-white">
                <div class="inner">
                    <h3>{{ $totalPesan ?? 65 }}</h3>
                    <p>Pesan & Doa Muzakki</p>
                </div>
                <div class="icon">
                    <i class="bi bi-chat-heart-fill"></i>
                </div>
                <a href="/admin/message" class="small-box-footer">
                    Kotak Pesan <i class="bi bi-arrow-right-circle ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- SECTION 3: DUA GRAFIK UTAMA (LINE CHART & BAR CHART)           -->
    <!-- ============================================================== -->
    <div class="row g-3 mb-4">
        <!-- Grafik Kiri: Kunjungan Calon Muzakki (Line Chart) -->
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm border-0 h-100 bg-white rounded-3">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center pt-3 px-3">
                    <h6 class="card-title mb-0 fw-semibold text-dark">Aktivitas Calon Muzakki Website</h6>
                    <div class="d-flex align-items-center gap-3">
                        <a href="/admin/zakat" class="text-primary text-decoration-none small fw-semibold">Lihat Laporan</a>
                        <a href="javascript:void(0)" class="text-muted"><i class="bi bi-download"></i></a>
                        <a href="javascript:void(0)" class="text-muted"><i class="bi bi-list"></i></a>
                    </div>
                </div>
                <div class="card-body px-3 pb-3">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <div>
                            <h3 class="fw-bold mb-0 text-dark">820</h3>
                            <small class="text-muted">Kunjungan Kalkulator & Form Zakat</small>
                        </div>
                        <div class="text-success fw-semibold small">
                            <i class="bi bi-arrow-up"></i> 12.5% <span class="text-muted fw-normal ms-1">dibanding pekan lalu</span>
                        </div>
                    </div>
                    <div class="chart-container" style="position: relative; height: 240px;">
                        <canvas id="visitorsChart"></canvas>
                    </div>
                    <div class="d-flex justify-content-end align-items-center gap-3 mt-2 small text-muted">
                        <span><span class="badge bg-primary me-1">&nbsp;</span> Pekan Ini</span>
                        <span><span class="badge bg-secondary me-1" style="background-color: #ced4da !important;">&nbsp;</span> Pekan Lalu</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Kanan: Penghimpunan Dana ZISWAF (Bar Chart) -->
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm border-0 h-100 bg-white rounded-3">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center pt-3 px-3">
                    <h6 class="card-title mb-0 fw-semibold text-dark">Penghimpunan Dana ZIS Bulanan</h6>
                    <div class="d-flex align-items-center gap-3">
                        <a href="/admin/zakat" class="text-primary text-decoration-none small fw-semibold">Lihat Laporan</a>
                        <a href="javascript:void(0)" class="text-muted"><i class="bi bi-download"></i></a>
                        <a href="javascript:void(0)" class="text-muted"><i class="bi bi-list"></i></a>
                    </div>
                </div>
                <div class="card-body px-3 pb-3">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <div>
                            <h3 class="fw-bold mb-0 text-dark">Rp 182.230.000</h3>
                            <small class="text-muted">Total Penerimaan Dana Tahun 2026</small>
                        </div>
                        <div class="text-success fw-semibold small">
                            <i class="bi bi-arrow-up"></i> 33.1% <span class="text-muted fw-normal ms-1">dibanding tahun lalu</span>
                        </div>
                    </div>
                    <div class="chart-container" style="position: relative; height: 240px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                    <div class="d-flex justify-content-end align-items-center gap-3 mt-2 small text-muted">
                        <span><span class="badge bg-primary me-1">&nbsp;</span> Zakat Mal & Profesi</span>
                        <span><span class="badge me-1" style="background-color: #20c997 !important;">&nbsp;</span> Infaq & Sedekah</span>
                        <span><span class="badge bg-warning me-1">&nbsp;</span> Fidyah & Kafarat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- SECTION 4: PROGRAM ZISWAF UNGGULAN & IKHTISAR LEMBAGA          -->
    <!-- ============================================================== -->
    <div class="row g-3">
        <!-- Kartu Kiri: Program ZISWAF Unggulan (Tabel) -->
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm border-0 h-100 bg-white rounded-3">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center pt-3 px-3">
                    <h6 class="card-title mb-0 fw-semibold text-dark">Program ZISWAF Unggulan</h6>
                    <div class="d-flex align-items-center gap-2 text-muted">
                        <a href="javascript:void(0)" class="text-muted"><i class="bi bi-download"></i></a>
                        <a href="javascript:void(0)" class="text-muted"><i class="bi bi-list"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-table">
                            <thead>
                                <tr class="text-dark fw-bold border-bottom">
                                    <th class="ps-3 py-2">Program Kebaikan</th>
                                    <th class="py-2">Rata-rata</th>
                                    <th class="py-2">Penyaluran</th>
                                    <th class="py-2 text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Row 1 -->
                                <tr>
                                    <td class="ps-3 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="program-thumb me-2 bg-primary text-white">
                                                <i class="bi bi-cash-stack"></i>
                                            </div>
                                            <span class="fw-semibold text-dark">Zakat Penghasilan & Profesi</span>
                                        </div>
                                    </td>
                                    <td class="text-dark fw-semibold">Rp 250.000</td>
                                    <td>
                                        <span class="text-success fw-bold"><i class="bi bi-arrow-up"></i> 12%</span>
                                        <span class="text-dark ms-1">1.200 Muzakki</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/zakat" class="text-muted"><i class="bi bi-search"></i></a>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr>
                                    <td class="ps-3 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="program-thumb me-2 bg-info text-white">
                                                <i class="bi bi-heart-fill"></i>
                                            </div>
                                            <span class="fw-semibold text-dark">Infaq Santunan Anak Yatim</span>
                                        </div>
                                    </td>
                                    <td class="text-dark fw-semibold">Rp 50.000</td>
                                    <td>
                                        <span class="text-info fw-bold" style="color: #17a2b8 !important;"><i class="bi bi-arrow-down"></i> 0.5%</span>
                                        <span class="text-dark ms-1">12.324 Donasi</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/program" class="text-muted"><i class="bi bi-search"></i></a>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr>
                                    <td class="ps-3 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="program-thumb me-2 bg-warning text-white">
                                                <i class="bi bi-building"></i>
                                            </div>
                                            <span class="fw-semibold text-dark">Wakaf Asrama Tahfidz Quran</span>
                                        </div>
                                    </td>
                                    <td class="text-dark fw-semibold">Rp 1.250.000</td>
                                    <td>
                                        <span class="text-danger fw-bold"><i class="bi bi-arrow-down"></i> 3%</span>
                                        <span class="text-dark ms-1">198 Pewakaf</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/program" class="text-muted"><i class="bi bi-search"></i></a>
                                    </td>
                                </tr>

                                <!-- Row 4 -->
                                <tr>
                                    <td class="ps-3 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="program-thumb me-2 bg-success text-white">
                                                <i class="bi bi-box2-heart"></i>
                                            </div>
                                            <span class="fw-semibold text-dark me-2">Fidyah & Kafarat Pangan</span>
                                            <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 10px; font-weight: 700;">BARU</span>
                                        </div>
                                    </td>
                                    <td class="text-dark fw-semibold">Rp 35.000</td>
                                    <td>
                                        <span class="text-success fw-bold"><i class="bi bi-arrow-up"></i> 63%</span>
                                        <span class="text-dark ms-1">870 Porsi</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/program" class="text-muted"><i class="bi bi-search"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Kanan: Ikhtisar Kinerja Lembaga (Indikator Rate) -->
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm border-0 h-100 bg-white rounded-3">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center pt-3 px-3">
                    <h6 class="card-title mb-0 fw-semibold text-dark">Ikhtisar Kinerja Yayasan</h6>
                    <div class="d-flex align-items-center gap-2 text-muted">
                        <a href="javascript:void(0)" class="text-muted"><i class="bi bi-download"></i></a>
                        <a href="javascript:void(0)" class="text-muted"><i class="bi bi-list"></i></a>
                    </div>
                </div>
                <div class="card-body px-4 py-3 d-flex flex-column justify-content-around">
                    <!-- Item 1: CONVERSION RATE (Tingkat Penyaluran) -->
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <i class="bi bi-arrow-repeat text-success" style="font-size: 32px;"></i>
                        </div>
                        <div class="text-end">
                            <div class="text-success fw-bold" style="font-size: 1.15rem;">
                                <i class="bi bi-graph-up-arrow small"></i> 12%
                            </div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.8px;">
                                TINGKAT PENYALURAN MUSTAHIK
                            </div>
                        </div>
                    </div>

                    <!-- Item 2: DONATION RATE (Pertumbuhan Dana) -->
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <i class="bi bi-wallet2 text-info" style="font-size: 32px; color: #17a2b8 !important;"></i>
                        </div>
                        <div class="text-end">
                            <div class="text-info fw-bold" style="font-size: 1.15rem; color: #17a2b8 !important;">
                                <i class="bi bi-graph-up-arrow small"></i> 0.8%
                            </div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.8px;">
                                PERTUMBUHAN DANA ZIS
                            </div>
                        </div>
                    </div>

                    <!-- Item 3: REGISTRATION RATE (Muzakki Baru) -->
                    <div class="d-flex justify-content-between align-items-center py-3">
                        <div>
                            <i class="bi bi-people text-danger" style="font-size: 32px; color: #e83e8c !important;"></i>
                        </div>
                        <div class="text-end">
                            <div class="text-danger fw-bold" style="font-size: 1.15rem; color: #dc3545 !important;">
                                <i class="bi bi-graph-down-arrow small"></i> 1%
                            </div>
                            <div class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.8px;">
                                PENDAFTARAN MUZAKKI BARU
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ============================================================== -->
<!-- CSS ADMINLTE 3 PENYESUAIAN                                    -->
<!-- ============================================================== -->
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
document.addEventListener('DOMContentLoaded', function () {
    // ---------------------------------------------------------------
    // 1. Line Chart: Aktivitas Calon Muzakki (Pekan Ini vs Pekan Lalu)
    // ---------------------------------------------------------------
    var ctxVisitors = document.getElementById('visitorsChart');
    if (ctxVisitors) {
        new Chart(ctxVisitors.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Ahad'],
                datasets: [
                    {
                        label: 'Pekan Ini',
                        data: [100, 120, 170, 167, 180, 177, 160],
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.05)',
                        borderWidth: 2.5,
                        tension: 0.35,
                        pointBackgroundColor: '#007bff',
                        pointBorderColor: '#007bff',
                        pointRadius: 4,
                        fill: false
                    },
                    {
                        label: 'Pekan Lalu',
                        data: [60, 80, 70, 67, 80, 77, 100],
                        borderColor: '#ced4da',
                        backgroundColor: 'transparent',
                        borderWidth: 2.5,
                        tension: 0.35,
                        pointBackgroundColor: '#ced4da',
                        pointBorderColor: '#ced4da',
                        pointRadius: 4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        min: 60,
                        max: 180,
                        ticks: {
                            stepSize: 20
                        },
                        grid: {
                            color: '#f8f9fa'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // ---------------------------------------------------------------
    // 2. Bar Chart: Penghimpunan Dana ZIS Bulanan
    // ---------------------------------------------------------------
    var ctxSales = document.getElementById('salesChart');
    if (ctxSales) {
        new Chart(ctxSales.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
                datasets: [
                    {
                        label: 'Zakat Mal & Profesi',
                        data: [43, 55, 57, 56, 61, 58, 63, 60, 65],
                        backgroundColor: '#007bff',
                        borderRadius: 2
                    },
                    {
                        label: 'Infaq & Sedekah',
                        data: [75, 84, 101, 98, 86, 105, 90, 112, 92],
                        backgroundColor: '#20c997',
                        borderRadius: 2
                    },
                    {
                        label: 'Fidyah & Kafarat',
                        data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
                        backgroundColor: '#ffc107',
                        borderRadius: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        min: 0,
                        max: 120,
                        ticks: {
                            stepSize: 20,
                            callback: function(val) {
                                return val + ' Jt';
                            }
                        },
                        grid: {
                            color: '#f8f9fa'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
