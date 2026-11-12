@extends('layout.app', ['active' => $active])

@section('meta')
    <meta name="csrf_token" id="csrf_token" content="{{ csrf_token() }}" />
@endsection

@section('title', ($pageTitle ?? 'Kelola Pilihan Donasi'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi bi-house"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Donasi</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Card Wrapper -->
    <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
        
        <!-- Header Judul -->
        <h5 class="fw-bold text-dark mb-3">Kelola Donasi (Campaign)</h5>

        <!-- Tombol Tambah Donasi Baru (Biru sesuai gambar) -->
        <div class="mb-4">
            <a href="{{ route('admin.campaign.add') }}" class="btn btn-primary px-3 py-2 rounded-2 fw-semibold">
                <i class="bi bi-plus-square me-1"></i> Tambah Donasi Baru
            </a>
        </div>

        <!-- Alert Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-2 border-0 mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabel  -->
        <div class="table-responsive">
            <table id="campaignTable" class="table table-bordered table-hover align-middle mb-0" style="width: 100%;">
                <thead class="table-light">
                    <tr class="text-secondary small">
                        <th style="width: 50px;" class="text-center">No.</th>
                        <th style="width: 70px;" class="text-center">Cover</th>
                        <th>Judul Program</th>
                        <th style="width: 240px;">Target & Terkumpul</th>
                        <th style="width: 90px;" class="text-center">Persentase</th>
                        <th style="width: 100px;">Sisa Hari</th>
                        <th style="width: 90px;" class="text-center">Status</th>
                        <th style="width: 120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaigns as $index => $item)
                        @php
                            $target = $item['target'] ?? 1;
                            $collected = $item['collected'] ?? 0;
                            $percent = $target > 0 ? min(100, round(($collected / $target) * 100)) : 0;
                            $isTakedown = ($item['status'] ?? 'active') === 'takedown';
                            $daysLeft = (int) ($item['days_left'] ?? 0);
                        @endphp
                        <tr>
                            <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                            
                            <!-- Cover Icon / Image -->
                            <td class="text-center">
                                <div class="d-inline-flex align-items-center justify-content-center bg-light border rounded" style="width: 48px; height: 36px; overflow: hidden;">
                                    @if(!empty($item['image']))
                                        <img src="{{ asset($item['image']) }}" 
                                             alt="{{ $item['title'] }}" 
                                             style="width: 100%; height: 100%; object-fit: cover;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                                        <i class="bi bi-image text-secondary fs-5" style="display: none;"></i>
                                    @else
                                        <i class="bi bi-image text-secondary fs-5"></i>
                                    @endif
                                </div>
                            </td>

                            <!-- Judul Program -->
                            <td>
                                <a href="{{ route('donasi.detail', $item['slug']) }}" target="_blank" class="fw-semibold text-dark text-decoration-none d-block">
                                    {{ $item['title'] }}
                                </a>
                            </td>

                            <!-- Target & Terkumpul -->
                            <td>
                                <div class="small fw-semibold text-muted mb-1">
                                    Rp {{ number_format($collected, 0, ',', '.') }} / <span class="text-secondary">Rp {{ number_format($target, 0, ',', '.') }}</span>
                                </div>
                                <div class="progress" style="height: 5px; background-color: #e9ecef; border-radius: 4px;">
                                    <div class="progress-bar bg-success" style="width: {{ $percent }}%;"></div>
                                </div>
                            </td>

                            <!-- Persentase -->
                            <td class="text-center">
                                <span class="badge {{ $percent >= 100 ? 'bg-success' : ($percent >= 50 ? 'bg-primary' : 'bg-light text-dark border') }} fw-bold px-2 py-1 rounded-2">
                                    {{ $percent }}%
                                </span>
                            </td>

                            <!-- Sisa Hari -->
                            <td class="text-center">
                                @if($daysLeft <= 0)
                                    <span class="badge bg-danger text-white px-2 py-1 rounded-2 fw-bold">
                                        <i class="bi bi-x-circle me-1"></i> Berakhir
                                    </span>
                                @elseif($daysLeft <= 5)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2 py-2 rounded-2 fw-bold" title="Waktu segera berakhir!">
                                        <i class="bi bi-hourglass-split me-1"></i> {{ $daysLeft }} Hari
                                    </span>
                                @else
                                    <span class="text-muted fw-semibold">
                                        {{ $daysLeft }} Hari
                                    </span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="text-center">
                                @if($isTakedown)
                                    <span class="text-warning fw-semibold">Takedown</span>
                                @else
                                    <span class="text-dark fw-semibold">Aktif</span>
                                @endif
                            </td>

                            <!-- Aksi (3 tombol: Orange Takedown, Biru Edit, Merah Hapus persis gambar) -->
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- Tombol Takedown (Orange) -->
                                    <a href="{{ route('admin.campaign.takedown', $item['id']) }}" 
                                       class="btn btn-warning text-white btn-sm" 
                                       title="{{ $isTakedown ? 'Aktifkan Kembali' : 'Takedown Program' }}"
                                       onclick="return confirm('{{ $isTakedown ? 'Aktifkan program ini kembali?' : 'Takedown/sembunyikan program ini dari publik?' }}')">
                                        <i class="bi bi-slash-circle"></i>
                                    </a>

                                    <!-- Tombol Edit (Biru) -->
                                    <a href="{{ route('admin.campaign.edit', $item['id']) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="Edit Program">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <!-- Tombol Hapus (Merah) -->
                                    <a href="{{ route('admin.campaign.delete', $item['id']) }}" 
                                       class="btn btn-danger btn-sm" 
                                       title="Hapus Program"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#campaignTable').DataTable({
        pageLength: 10,
        ordering: true,
        columnDefs: [
            { orderable: false, targets: [1, 7] }
        ],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                previous: "Previous",
                next: "Next"
            }
        }
    });
});
</script>
@endpush
