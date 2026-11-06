@extends('layout.app', ['active' => $active])

@section('meta')
    <meta name="csrf_token" id="csrf_token" content="{{ csrf_token() }}" />
@endsection

@section('title', ($pageTitle ?? 'Kelola Pilihan Donasi'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Donasi</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Tombol Tambah -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-megaphone-fill text-success me-2"></i>Kelola Pilihan Donasi (Campaign)
            </h4>
            <p class="text-muted small mb-0">
                Tambah pilihan donasi baru untuk musibah atau bencana alam, serta takedown pilihan donasi jika dana sudah terkumpul.
            </p>
        </div>
        <div class="mt-2 mt-md-0 d-flex gap-2">
            <a href="{{ route('donasi.index') }}" target="_blank" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Katalog Publik
            </a>
            <a href="{{ route('admin.campaign.add') }}" class="btn btn-success rounded-3 shadow-sm">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Donasi Baru
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 4 KARTU STATISTIK RINGKASAN -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-success">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-collection-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Total Pilihan Donasi</span>
                        <h4 class="fw-bold text-dark mb-0">{{ count($campaigns) }} <small class="text-muted fs-6">Program</small></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-primary">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Status Aktif (Tayang)</span>
                        <h4 class="fw-bold text-primary mb-0">{{ $totalActive }} <small class="text-muted fs-6">Program</small></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-warning">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-shield-lock-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Di-Takedown / Ditutup</span>
                        <h4 class="fw-bold text-warning mb-0">{{ $totalTakedown }} <small class="text-muted fs-6">Program</small></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-info">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-cash-stack fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Total Dana Terkumpul</span>
                        <h5 class="fw-bold text-success mb-0">Rp {{ number_format($totalCollected, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL DAFTAR CAMPAIGN DONASI -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-table me-2 text-primary"></i>Daftar Pilihan Program Donasi Bencana & Kebaikan
            </h6>
            <span class="badge bg-light text-muted border px-3 py-1">Penyimpanan Terintegrasi JSON Database</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4" style="width: 50px;">No</th>
                            <th style="width: 100px;">Cover</th>
                            <th>Judul Program & Kategori</th>
                            <th style="width: 220px;">Target & Terkumpul</th>
                            <th style="width: 120px;">Sisa Hari</th>
                            <th style="width: 130px;" class="text-center">Status</th>
                            <th style="width: 200px;" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campaigns as $index => $item)
                            @php
                                $percent = $item['target'] > 0 ? min(100, round(($item['collected'] / $item['target']) * 100)) : 0;
                                $isTakedown = ($item['status'] ?? 'active') === 'takedown';
                            @endphp
                            <tr class="{{ $isTakedown ? 'table-light text-muted' : '' }}">
                                <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="position-relative" style="width: 75px; height: 50px; border-radius: 8px; overflow: hidden; background: #e9ecef;">
                                        <img src="{{ asset($item['image']) }}" 
                                             alt="{{ $item['title'] }}" 
                                             style="width: 100%; height: 100%; object-fit: cover;"
                                             onerror="this.src='{{ asset('website/assets/images/backgrounds/main-slider-2-1.jpg') }}'">
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $item['category_badge'] ?? 'bg-success' }} mb-1 rounded-pill" style="font-size: 0.72rem;">
                                        {{ $item['category_label'] ?? $item['category'] }}
                                    </span>
                                    <a href="{{ route('donasi.detail', $item['slug']) }}" target="_blank" class="fw-bold d-block text-dark text-decoration-none text-truncate" style="max-width: 320px;" title="{{ $item['title'] }}">
                                        {{ $item['title'] }}
                                    </a>
                                    <small class="text-muted d-block">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $item['location'] ?? 'Indonesia' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center small mb-1">
                                        <span class="fw-bold text-success">Rp {{ number_format($item['collected'], 0, ',', '.') }}</span>
                                        <span class="text-muted">{{ $percent }}%</span>
                                    </div>
                                    <div class="progress" style="height: 6px; border-radius: 10px; background-color: #e9ecef;">
                                        <div class="progress-bar bg-success" style="width: {{ $percent }}%;"></div>
                                    </div>
                                    <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">
                                        Target: Rp {{ number_format($item['target'], 0, ',', '.') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        <i class="bi bi-clock-history me-1 text-primary"></i>{{ $item['days_left'] }} Hari
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($isTakedown)
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill fw-bold">
                                            <i class="bi bi-shield-lock-fill me-1"></i> Takedown
                                        </span>
                                    @else
                                        <span class="badge bg-success px-3 py-2 rounded-pill fw-bold">
                                            <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- Tombol Takedown / Pulihkan -->
                                        @if($isTakedown)
                                            <a href="{{ route('admin.campaign.takedown', $item['id']) }}" 
                                               class="btn btn-outline-success" 
                                               title="Aktifkan Kembali Program Ini"
                                               onclick="return confirm('Aktifkan kembali program donasi ini agar muncul di publik?')">
                                                <i class="bi bi-arrow-up-circle me-1"></i> Aktifkan
                                            </a>
                                        @else
                                            <a href="{{ route('admin.campaign.takedown', $item['id']) }}" 
                                               class="btn btn-outline-warning text-dark fw-semibold" 
                                               title="Takedown / Tutup Program Ini"
                                               onclick="return confirm('Apakah Anda yakin ingin men-takedown program ini? Donasi akan ditutup dari publik.')">
                                                <i class="bi bi-shield-x me-1"></i> Takedown
                                            </a>
                                        @endif

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.campaign.edit', $item['id']) }}" 
                                           class="btn btn-outline-primary" 
                                           title="Ubah Data Program">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <a href="{{ route('admin.campaign.delete', $item['id']) }}" 
                                           class="btn btn-outline-danger" 
                                           title="Hapus Program"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus program donasi ini secara permanen?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada pilihan donasi yang dibuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

