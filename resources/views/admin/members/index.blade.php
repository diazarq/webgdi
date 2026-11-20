@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Kelola Pengguna</a></li>
        <li class="breadcrumb-item active" aria-current="page">Relawan & Mitra</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1 mt-2"><iconify-icon icon="mingcute:group-3-fill" class="me-2 ms-1 align-middle fs-4"></iconify-icon>Persetujuan Volunteer & Mitra</h4>
            <p class="text-muted small mb-0">Verifikasi dan kurasi calon pendaftar relawan atau amil zakat sebelum diberikan akses login.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- STATS CARDS (SMALL-BOX STYLE) -->
    <div class="row g-3 mb-4">
        <!-- 1. Menunggu ACC -->
        <div class="col-lg-3 col-md-6 col-12">
            <div class="small-box bg-warning text-dark h-100 mb-0 shadow-sm">
                <div class="inner p-3">
                    <h3 class="fw-bold mb-1">{{ $countPending }}</h3>
                    <p class="mb-0 text-dark opacity-75 fw-semibold">Menunggu ACC</p>
                </div>
                <div class="icon">
                    <iconify-icon icon="uis:clock"></iconify-icon>
                </div>
            </div>
        </div>

        <!-- 2. Relawan Sahabat Baik -->
        <div class="col-lg-3 col-md-6 col-12">
            <div class="small-box bg-success text-white h-100 mb-0 shadow-sm">
                <div class="inner p-3">
                    <h3 class="fw-bold text-white mb-1">{{ $countVolunteer }}</h3>
                    <p class="mb-0 text-white-50">Relawan Sahabat Baik</p>
                </div>
                <div class="icon">
                    <iconify-icon icon="mdi:charity"></iconify-icon>
                </div>
            </div>
        </div>

        <!-- 3. Mitra / Affiliate -->
        <div class="col-lg-3 col-md-6 col-12">
            <div class="small-box bg-primary text-white h-100 mb-0 shadow-sm">
                <div class="inner p-3">
                    <h3 class="fw-bold text-white mb-1">{{ $countAffiliate }}</h3>
                    <p class="mb-0 text-white-50">Mitra / Affiliate (Amil)</p>
                </div>
                <div class="icon">
                    <iconify-icon icon="mdi:handshake"></iconify-icon>
                </div>
            </div>
        </div>

        <!-- 4. Telah Disetujui -->
        <div class="col-lg-3 col-md-6 col-12">
            <div class="small-box bg-secondary text-white h-100 mb-0 shadow-sm">
                <div class="inner p-3">
                    <h3 class="fw-bold text-white mb-1">{{ $countApproved }}</h3>
                    <p class="mb-0 text-white-50">Telah Disetujui</p>
                </div>
                <div class="icon">
                    <iconify-icon icon="mdi:check-decagram"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    <!-- TABS FILTER -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link {{ $currentStatus == 'pending' ? 'active' : '' }}" href="{{ route('admin.members.index', ['status' => 'pending', 'role' => $currentRole]) }}">
                        <i class="bi bi-hourglass-split me-1"></i> Menunggu ACC ({{ $countPending }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentStatus == 'approved' ? 'active' : '' }}" href="{{ route('admin.members.index', ['status' => 'approved', 'role' => $currentRole]) }}">
                        <i class="bi bi-check2-circle me-1"></i> Disetujui ({{ $countApproved }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentStatus == 'rejected' ? 'active' : '' }}" href="{{ route('admin.members.index', ['status' => 'rejected', 'role' => $currentRole]) }}">
                        <i class="bi bi-x-circle me-1"></i> Ditolak ({{ $countRejected }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentStatus == 'all' ? 'active' : '' }}" href="{{ route('admin.members.index', ['status' => 'all', 'role' => $currentRole]) }}">
                        Semua Status
                    </a>
                </li>
            </ul>

            <div class="btn-group btn-group-sm">
                <a href="{{ route('admin.members.index', ['status' => $currentStatus, 'role' => 'all']) }}" class="btn btn-outline-secondary {{ $currentRole == 'all' ? 'active' : '' }}">Semua Tipe</a>
                <a href="{{ route('admin.members.index', ['status' => $currentStatus, 'role' => 'volunteer']) }}" class="btn btn-outline-success {{ $currentRole == 'volunteer' ? 'active' : '' }}">Relawan Saja</a>
                <a href="{{ route('admin.members.index', ['status' => $currentStatus, 'role' => 'affiliate']) }}" class="btn btn-outline-primary {{ $currentRole == 'affiliate' ? 'active' : '' }}">Mitra Saja</a>
            </div>
        </div>
    </div>

    <!-- TABEL PENDAFTAR -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="4%">No</th>
                            <th>Nama & Kontak</th>
                            <th>Tipe & Minat / Lembaga</th>
                            <th>Kota Domisili</th>
                            <th>Pengalaman / Catatan</th>
                            <th>Tgl Daftar</th>
                            <th>Status</th>
                            <th width="15%" class="text-center">Aksi Moderasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $index => $item)
                            <tr>
                                <td>{{ $members->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->name }}</div>
                                    <div class="small text-muted">@<span>{{ $item->username }}</span></div>
                                    <div class="mt-1">
                                        @if($item->phone)
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $item->phone)) }}" target="_blank" class="badge bg-success text-decoration-none">
                                                <i class="bi bi-whatsapp"></i> {{ $item->phone }}
                                            </a>
                                        @endif
                                        <span class="badge bg-light text-dark">{{ $item->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($item->role_type === 'volunteer')
                                        <span class="badge bg-success-subtle text-success border border-success fw-semibold"><i class="bi bi-heart me-1"></i> Relawan Sahabat Baik</span>
                                        <div class="small text-dark mt-1 fw-bold">{{ $item->volunteer_type ?? 'Umum' }}</div>
                                    @else
                                        <span class="badge bg-primary-subtle text-primary border border-primary fw-semibold"><i class="bi bi-briefcase me-1"></i> Mitra / Amil Zakat</span>
                                        <div class="small text-dark mt-1 fw-bold">{{ $item->instansi ?? '-' }}</div>
                                    @endif
                                </td>
                                <td>{{ $item->domisili ?? '-' }}</td>
                                <td>
                                    @if($item->organisasi)
                                        <button type="button" class="btn btn-sm btn-outline-info py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}">
                                            <i class="bi bi-eye"></i> Lihat Profil
                                        </button>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="small">{{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}</td>
                                <td>
                                    @if($item->status_approval === 'pending')
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Pending</span>
                                    @elseif($item->status_approval === 'approved')
                                        <span class="badge bg-success"><i class="bi bi-check2"></i> Disetujui</span>
                                    @else
                                        <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if($item->status_approval !== 'approved')
                                            <a href="{{ route('admin.members.approve', $item->id) }}" class="btn btn-success" onclick="return confirm('ACC dan aktifkan akun {{ $item->name }}?')">
                                                <i class="bi bi-check-lg"></i> ACC
                                            </a>
                                        @endif

                                        @if($item->status_approval !== 'rejected')
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $item->id }}">
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </button>
                                        @endif

                                        <a href="{{ route('admin.members.delete', $item->id) }}" class="btn btn-outline-secondary" onclick="return confirm('Hapus data pendaftar ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>

                                    <!-- MODAL DETAIL -->
                                    <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light">
                                                    <h6 class="modal-title fw-bold">Detail Pengalaman: {{ $item->name }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <p class="mb-2"><strong>Bidang/Lembaga:</strong> {{ $item->role_type === 'volunteer' ? $item->volunteer_type : $item->instansi }}</p>
                                                    <p class="mb-2"><strong>Kota Domisili:</strong> {{ $item->domisili }}</p>
                                                    <div class="bg-light p-3 rounded border">
                                                        <strong class="d-block mb-1 text-secondary">Pengalaman Organisasi / Rencana Kemitraan:</strong>
                                                        <div style="white-space: pre-wrap;">{{ $item->organisasi }}</div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                                    @if($item->status_approval !== 'approved')
                                                        <a href="{{ route('admin.members.approve', $item->id) }}" class="btn btn-success btn-sm">
                                                            <i class="bi bi-check-lg"></i> ACC Pendaftar Ini
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL TOLAK -->
                                    <div class="modal fade" id="modalTolak{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.members.reject', $item->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header bg-danger text-white">
                                                        <h6 class="modal-title fw-bold">Tolak Pendaftaran: {{ $item->name }}</h6>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-semibold">Alasan Penolakan (Catatan):</label>
                                                            <textarea name="rejection_note" class="form-control" rows="3" placeholder="Contoh: Belum memenuhi syarat usia / data nomor WA tidak aktif / dll."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger btn-sm">Tolak Pendaftar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                    Tidak ada data calon relawan atau mitra pada filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($members->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* Small Box Cards Style (Sama seperti Monitoring Donasi Masuk) */
.small-box {
    border-radius: 8px;
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
    margin: 0 0 4px 0;
    white-space: nowrap;
    padding: 0;
}
.small-box .inner p {
    font-size: 0.92rem;
    margin-bottom: 0;
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
.small-box .icon i,
.small-box .icon iconify-icon {
    font-size: 60px;
    width: 60px;
    height: 60px;
    display: inline-block;
    line-height: 1;
}
.small-box:hover .icon i,
.small-box:hover .icon iconify-icon {
    font-size: 68px;
    width: 68px;
    height: 68px;
    color: rgba(0, 0, 0, 0.22);
}
</style>
@endpush

