@extends('portal.layout')
@section('title', 'Daftar Berita Saya')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-newspaper text-success me-2"></i>Daftar Berita & Liputan Saya</h4>
        <p class="text-muted small mb-0">Kelola liputan kegiatan dan informasi yang telah Anda kirimkan.</p>
    </div>
    <a href="{{ route('portal.berita.create') }}" class="btn btn-success fw-semibold">
        <i class="bi bi-plus-lg me-1"></i> Tulis Berita Baru
    </a>
</div>

<!-- TABS STATUS -->
<div class="portal-card mb-3">
    <div class="card-body p-2">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link {{ $currentStatus === 'all' ? 'active' : '' }}" href="{{ route('portal.berita.index', ['status' => 'all']) }}">
                    Semua Berita
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentStatus === 'draft' ? 'active' : '' }}" href="{{ route('portal.berita.index', ['status' => 'draft']) }}">
                    <i class="bi bi-hourglass-split me-1 text-warning"></i> Menunggu ACC / Draft ({{ $countDraft }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentStatus === 'publish' ? 'active' : '' }}" href="{{ route('portal.berita.index', ['status' => 'publish']) }}">
                    <i class="bi bi-check2-circle me-1 text-success"></i> Sudah Terbit ({{ $countPublish }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentStatus === 'bin' ? 'active' : '' }}" href="{{ route('portal.berita.index', ['status' => 'bin']) }}">
                    <i class="bi bi-trash me-1 text-secondary"></i> Masuk Bin / Ditolak ({{ $countBin }})
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- TABEL BERITA -->
<div class="portal-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="4%">No</th>
                        <th width="80px">Foto</th>
                        <th>Judul & Ringkasan</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $index => $item)
                        <tr>
                            <td>{{ $blogs->firstItem() + $index }}</td>
                            <td>
                                @if($item->featured_img)
                                    <img src="{{ asset($item->featured_img) }}" alt="" style="width: 70px; height: 50px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="width: 70px; height: 50px; border-radius: 8px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->title }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 380px;">
                                    {{ Str::limit(strip_tags($item->content), 90) }}
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
                            <td class="small">{{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}</td>
                            <td class="text-center">
                                @if($item->status === 'draft' && !$item->trashed())
                                    <a href="{{ route('portal.berita.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Ubah Draft">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                @elseif($item->status === 'publish' && !$item->trashed())
                                    <a href="{{ route('website.blog.detail', $item->slug) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Lihat di Web">
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
                                <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada berita pada status ini.
                                <div class="mt-2">
                                    <a href="{{ route('portal.berita.create') }}" class="btn btn-sm btn-success">
                                        <i class="bi bi-plus-lg me-1"></i> Tulis Berita Baru Sekarang
                                    </a>
                                </div>
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

