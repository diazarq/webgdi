@extends('portal.layout')
@section('title', 'Daftar Berita Saya')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-newspaper text-success me-2"></i>Daftar Berita & Liputan Saya</h4>
        <p class="text-muted small mb-0">Kelola liputan kegiatan dan informasi yang telah Anda kirimkan.</p>
    </div>
    <a href="{{ route('portal.berita.create') }}" class="btn btn-success fw-semibold rounded-pill px-4 py-2">
        <i class="bi bi-plus-lg me-1"></i> Tulis Berita Baru
    </a>
</div>

<!-- TABS STATUS -->
<div class="card border-0 shadow-sm mb-3 rounded-4" style="border: 1px solid #e8edea !important;">
    <div class="card-body p-2">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 {{ $currentStatus === 'all' ? 'active bg-success' : 'text-secondary' }}" href="{{ route('portal.berita.index', ['status' => 'all']) }}">
                    Semua Berita
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 {{ $currentStatus === 'draft' ? 'active bg-warning text-dark' : 'text-warning-emphasis' }}" href="{{ route('portal.berita.index', ['status' => 'draft']) }}">
                    <i class="bi bi-hourglass-split me-1"></i> Menunggu ACC / Draft ({{ $countDraft }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 {{ $currentStatus === 'publish' ? 'active bg-success' : 'text-success' }}" href="{{ route('portal.berita.index', ['status' => 'publish']) }}">
                    <i class="bi bi-check2-circle me-1"></i> Sudah Terbit ({{ $countPublish }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 {{ $currentStatus === 'bin' ? 'active bg-secondary' : 'text-secondary' }}" href="{{ route('portal.berita.index', ['status' => 'bin']) }}">
                    <i class="bi bi-trash me-1"></i> Masuk Bin / Ditolak ({{ $countBin }})
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- TABEL BERITA -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid #e8edea !important;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="ps-3">NO</th>
                        <th width="85px">FOTO</th>
                        <th>JUDUL & RINGKASAN</th>
                        <th>KATEGORI</th>
                        <th>STATUS</th>
                        <th>TANGGAL DIBUAT</th>
                        <th width="12%" class="text-center pe-3">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $index => $item)
                        <tr>
                            <td class="ps-3">{{ $blogs->firstItem() + $index }}</td>
                            <td>
                                @if($item->featured_img)
                                    <img src="{{ asset($item->featured_img) }}" alt="" style="width: 70px; height: 50px; object-fit: cover; border-radius: 10px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="width: 70px; height: 50px; border-radius: 10px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->title }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 380px;">
                                    {{ Str::limit(strip_tags($item->content), 80) }}
                                </div>
                                @if($item->admin_notes)
                                    <div class="mt-1 small text-danger"><i class="bi bi-info-circle me-1"></i> Catatan Admin: {{ $item->admin_notes }}</div>
                                @endif
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $item->kategori ?? 'Umum' }}</span></td>
                            <td>
                                @if($item->trashed())
                                    <span class="badge bg-danger"><i class="bi bi-trash"></i> Masuk Bin (Ditolak)</span>
                                @elseif($item->status === 'publish')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Terbit</span>
                                    <div class="small text-muted" style="font-size: 0.72rem;">{{ $item->date_publish ? date('d M Y', strtotime($item->date_publish)) : '' }}</div>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Menunggu ACC</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}</td>
                            <td class="text-center pe-3">
                                @if($item->status === 'draft' && !$item->trashed())
                                    <a href="{{ route('portal.berita.edit', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Ubah Draft">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                @elseif($item->status === 'publish' && !$item->trashed())
                                    <a href="{{ route('website.blog.detail', $item->slug) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3" title="Lihat di Web">
                                        <i class="bi bi-box-arrow-up-right"></i> Lihat
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Diarsipkan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="mb-3">
                                    <i class="bi bi-journal-x fs-1 text-secondary opacity-50"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Tidak ada berita pada status ini</h6>
                                <p class="small text-muted mb-3">Mulai tulis dokumentasi atau liputan kegiatan lapangan Anda.</p>
                                <a href="{{ route('portal.berita.create') }}" class="btn btn-success rounded-pill px-4">
                                    <i class="bi bi-plus-lg me-1"></i> Tulis Berita Baru Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($blogs->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $blogs->links() }}
        </div>
    @endif
</div>
@endsection
