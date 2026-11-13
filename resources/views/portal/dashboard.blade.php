@extends('portal.layout')
@section('title', 'Dashboard')

@section('content')
<!-- WELCOME BANNER -->
<div class="card border-0 text-white mb-4 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #117a37 0%, #0c5c29 100%); border-radius: 16px;">
    <div class="card-body p-4 p-md-5 position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-white text-success fw-bold px-3 py-1 mb-2 rounded-pill text-uppercase" style="font-size: 0.75rem;">
                    Portal {{ $user->isAdmin() ? 'Administrator' : ($user->isVolunteer() ? 'Sahabat Baik' : 'Mitra GDI') }}
                </span>
                <h3 class="fw-bold mb-2">Selamat Datang, {{ $user->name }}!</h3>
                <p class="mb-3 opacity-90">
                    Terima kasih atas dedikasi dan kontribusi nyata Anda bersama Graha Dhuafa Indonesia. Salurkan kabar kebaikan dan dokumentasi kegiatan aksi sosial Anda di portal ini.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('portal.berita.create') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-pencil-square me-1"></i> Tulis Berita Kegiatan Baru
                    </a>
                    <a href="{{ route('portal.berita.index') }}" class="btn btn-outline-light px-3 py-2 rounded-pill">
                        <i class="bi bi-journal-text me-1"></i> Lihat Berita Saya
                    </a>
                </div>
            </div>
            <div class="col-md-4 text-center text-md-end d-none d-md-block">
                <i class="bi bi-megaphone-fill display-1 opacity-25"></i>
            </div>
        </div>
    </div>
</div>

@if($user->isAffiliate())
<!-- CARD KHUSUS LINK & KODE AFILIASI MITRA -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%); border-left: 6px solid #f58220 !important;">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <span class="badge bg-warning text-dark fw-bold px-2 py-1 mb-1"><i class="bi bi-link-45deg"></i> LINK AFILIASI MITRA</span>
                <h5 class="fw-bold text-dark mb-0">Tautan & Kode Donasi Khusus: {{ $user->instansi ?? $user->name }}</h5>
                <small class="text-muted">Sebarkan tautan atau kode referral ini kepada jamaah, komunitas, atau donatur Anda.</small>
            </div>
            <div class="mt-2 mt-md-0">
                <span class="badge bg-light text-dark border p-2">
                    <span class="text-muted small">Kode Referral:</span> <strong class="text-primary fs-6">{{ strtoupper($user->username) }}</strong>
                </span>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-lg-8">
                <label class="form-label small fw-semibold text-secondary mb-1">Tautan Afiliasi Donasi GDI:</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-globe text-warning"></i></span>
                    <input type="text" class="form-control bg-white fw-semibold text-dark" id="inputAffiliateLink" value="{{ url('/donasi?ref=' . $user->username) }}" readonly>
                    <button class="btn btn-warning fw-bold px-3" type="button" onclick="copyAffiliateLink()">
                        <i class="bi bi-clipboard me-1" id="copyIcon"></i> <span id="copyText">Salin Link</span>
                    </button>
                </div>
            </div>
            <div class="col-lg-4 d-flex align-items-end">
                @php
                    $waText = urlencode("Bismillah, mari salurkan kepedulian dan sedekah terbaik Anda bersama " . ($user->instansi ?? $user->name) . " melalui Yayasan Graha Dhuafa Indonesia. Salurkan melalui tautan resmi: " . url('/donasi?ref=' . $user->username));
                @endphp
                <a href="https://api.whatsapp.com/send?text={{ $waText }}" target="_blank" class="btn btn-success fw-bold w-100 py-2">
                    <i class="bi bi-whatsapp me-1"></i> Bagikan ke WhatsApp
                </a>
            </div>
        </div>

        <div class="mt-3 p-3 bg-white rounded border border-warning-subtle small text-muted d-flex align-items-center gap-2">
            <i class="bi bi-info-circle-fill text-warning fs-5 flex-shrink-0"></i>
            <div>
                Setiap donatur yang berdonasi melalui tautan ini akan otomatis terhubung dengan kemitraan <strong>{{ $user->instansi ?? $user->name }}</strong>.
            </div>
        </div>
    </div>
</div>
@endif

<!-- STATS COUNTERS -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="portal-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Total Berita</span>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalBerita }}</h3>
                </div>
                <div class="fs-2 text-primary opacity-75"><i class="bi bi-newspaper"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="portal-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Sudah Terbit</span>
                    <h3 class="fw-bold text-success mb-0">{{ $totalPublish }}</h3>
                </div>
                <div class="fs-2 text-success opacity-75"><i class="bi bi-check-circle-fill"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="portal-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Menunggu Review</span>
                    <h3 class="fw-bold text-warning mb-0">{{ $totalDraft }}</h3>
                </div>
                <div class="fs-2 text-warning opacity-75"><i class="bi bi-clock-history"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="portal-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Masuk Bin</span>
                    <h3 class="fw-bold text-secondary mb-0">{{ $totalBin }}</h3>
                </div>
                <div class="fs-2 text-secondary opacity-75"><i class="bi bi-trash"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- BERITA TERBARU -->
<div class="portal-card mb-4">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="bi bi-journal-richtext text-success me-2"></i>Berita & Liputan Terbaru Saya</h5>
        <a href="{{ route('portal.berita.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Foto</th>
                        <th>Judul Berita</th>
                        <th>Kategori</th>
                        <th>Status Kurasi</th>
                        <th>Tanggal Kirim</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBlogs as $idx => $b)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>
                                @if($b->featured_img)
                                    <img src="{{ asset($b->featured_img) }}" alt="" style="width: 50px; height: 40px; object-fit: cover; border-radius: 6px;">
                                @else
                                    <span class="badge bg-light text-secondary"><i class="bi bi-image"></i></span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 280px;">{{ $b->title }}</div>
                                <span class="small text-muted">{{ Str::limit(strip_tags($b->content), 60) }}</span>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $b->kategori ?? 'Umum' }}</span></td>
                            <td>
                                @if($b->status === 'publish')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Tayang Publik</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Draft (Menunggu ACC)</span>
                                @endif
                            </td>
                            <td class="small">{{ $b->created_at ? $b->created_at->format('d M Y') : '-' }}</td>
                            <td class="text-center">
                                @if($b->status === 'draft')
                                    <a href="{{ route('portal.berita.edit', $b->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Draft">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @else
                                    <a href="{{ route('website.blog.detail', $b->slug) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Lihat di Web">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-text fs-1 d-block mb-2 text-secondary"></i>
                                Belum ada berita kegiatan yang Anda buat.
                                <div class="mt-2">
                                    <a href="{{ route('portal.berita.create') }}" class="btn btn-sm btn-success">
                                        <i class="bi bi-plus-lg me-1"></i> Buat Liputan Kegiatan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- INFORMASI ALUR KURASI -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="portal-card p-4 h-100">
            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-lightbulb-fill text-warning me-2"></i>Panduan Penulisan Liputan</h6>
            <ul class="small text-muted mb-0 ps-3">
                <li class="mb-2">Gunakan foto asli hasil dokumentasi lapangan kegiatan sosial/bencana.</li>
                <li class="mb-2">Sertakan detail tanggal, lokasi kegiatan, dan jumlah penerima manfaat.</li>
                <li>Bahasa yang digunakan santun, informatif, dan menginspirasi semangat berbagi.</li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portal-card p-4 h-100">
            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-shield-check text-success me-2"></i>Alur Moderasi Konten</h6>
            <p class="small text-muted mb-0">
                Semua artikel berita yang Anda simpan akan masuk status <strong>DRAFT</strong> terlebih dahulu. Tim Admin Graha Dhuafa Indonesia akan mengevaluasi liputan tersebut. Jika lolos review, tulisan Anda akan langsung tayang pada website publik GDI.
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyAffiliateLink() {
        var copyInput = document.getElementById("inputAffiliateLink");
        if (!copyInput) return;

        copyInput.select();
        copyInput.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyInput.value).then(function() {
            var btnText = document.getElementById("copyText");
            var btnIcon = document.getElementById("copyIcon");
            if (btnText && btnIcon) {
                btnText.innerText = "✓ Tersalin!";
                btnIcon.classList.remove("bi-clipboard");
                btnIcon.classList.add("bi-check2");
                setTimeout(function() {
                    btnText.innerText = "Salin Link";
                    btnIcon.classList.remove("bi-check2");
                    btnIcon.classList.add("bi-clipboard");
                }, 2000);
            }
        });
    }
</script>
@endpush

