@extends('portal.layout')
@section('title', 'Dashboard')

@push('styles')
<style>
    /* HERO WELCOME BANNER */
    .hero-banner {
        background: linear-gradient(135deg, #0d6931 0%, #15803d 50%, #16a34a 100%);
        border-radius: 24px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        padding: 38px 42px;
        box-shadow: 0 8px 24px rgba(13, 105, 49, 0.18);
    }
    .hero-banner::before {
        content: "";
        position: absolute;
        top: -40%;
        right: -10%;
        width: 480px;
        height: 480px;
        border-radius: 50%;
        border: 45px solid rgba(255, 255, 255, 0.06);
        pointer-events: none;
    }
    .hero-banner::after {
        content: "";
        position: absolute;
        bottom: -50%;
        right: 15%;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        border: 35px solid rgba(255, 255, 255, 0.04);
        pointer-events: none;
    }
    .tag-portal-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(8, 60, 28, 0.45);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        padding: 5px 14px;
        border-radius: 30px;
        text-transform: uppercase;
    }
    .tag-dot-glow {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #f59e0b;
        box-shadow: 0 0 8px #f59e0b;
    }
    .btn-hero-action-orange {
        background: #f59e0b;
        color: #1c1917;
        font-weight: 700;
        font-size: 0.88rem;
        padding: 10px 22px;
        border-radius: 30px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
    }
    .btn-hero-action-orange:hover {
        background: #d97706;
        color: #ffffff;
        transform: translateY(-2px);
    }
    .btn-hero-action-glass {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.35);
        font-weight: 600;
        font-size: 0.88rem;
        padding: 10px 22px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-hero-action-glass:hover {
        background: rgba(255, 255, 255, 0.22);
        color: #ffffff;
    }
    .megaphone-box {
        position: relative;
        display: inline-block;
    }
    .megaphone-icon-wrapper {
        width: 110px;
        height: 110px;
        border-radius: 28px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 3.5rem;
        transform: rotate(-10deg);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .megaphone-float-dot {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 22px;
        height: 22px;
        background: #f59e0b;
        border: 3px solid #15803d;
        border-radius: 50%;
    }

    /* STATS METRIC CARDS */
    .metric-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e8edea;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        padding: 20px 22px;
        height: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .metric-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
    }
    .metric-card.blue::before { background: #3b82f6; }
    .metric-card.green::before { background: #22c55e; }
    .metric-card.orange::before { background: #f59e0b; }
    .metric-card.gray::before { background: #94a3b8; }

    .metric-icon-circle {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .metric-icon-circle.blue { background: #eff6ff; color: #3b82f6; }
    .metric-icon-circle.green { background: #f0fdf4; color: #22c55e; }
    .metric-icon-circle.orange { background: #fffbeb; color: #f59e0b; }
    .metric-icon-circle.gray { background: #f8fafc; color: #94a3b8; }

    .metric-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.6px;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 2px;
    }
    .metric-number {
        font-size: 2.1rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.1;
        margin-bottom: 2px;
    }
    .metric-sub {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* TABLE SECTION CARD */
    .table-section-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #e8edea;
        box-shadow: 0 2px 12px rgba(0,0,0,0.03);
        overflow: hidden;
        margin-bottom: 24px;
    }
    .table-section-header {
        padding: 20px 26px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-section-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .header-icon-box {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #e8f5ec;
        color: #0f7638;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    .table-section-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .link-see-all {
        color: #475569;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }
    .link-see-all:hover {
        color: #0f7638;
        transform: translateX(2px);
    }

    .table-clean th {
        background-color: #f8fafc;
        color: #64748b;
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 14px 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-clean td {
        padding: 16px 20px;
        font-size: 0.88rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* EMPTY STATE */
    .empty-state-wrapper {
        text-align: center;
        padding: 48px 20px 52px;
    }
    .empty-icon-card {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: #f0fdf4;
        color: #16a34a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 16px;
        border: 1px solid #dcfce7;
    }
    .empty-text {
        font-size: 0.92rem;
        color: #64748b;
        margin-bottom: 18px;
    }
    .btn-create-first {
        background: #0f7638;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 10px 24px;
        border-radius: 30px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(15, 118, 56, 0.25);
    }
    .btn-create-first:hover {
        background: #0a5728;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* BOTTOM GUIDELINES CARDS */
    .guide-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #e8edea;
        box-shadow: 0 2px 12px rgba(0,0,0,0.03);
        padding: 26px 28px;
        height: 100%;
    }
    .guide-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }
    .guide-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.84rem;
        color: #475569;
        margin-bottom: 12px;
        line-height: 1.5;
    }
    .check-circle-green {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #dcfce7;
        color: #15803d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        flex-shrink: 0;
        margin-top: 3px;
    }
    .flow-step-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 20px;
    }
    .flow-step-pill.draft {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .flow-step-pill.review {
        background: #fefce8;
        color: #a16207;
        border: 1px solid #fef08a;
    }
    .flow-step-pill.publish {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }
</style>
@endpush

@section('content')
<!-- 1. HERO WELCOME BANNER -->
<section class="hero-banner mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="mb-3">
                <span class="tag-portal-pill">
                    <span class="tag-dot-glow"></span>
                    {{ $user->isVolunteer() ? 'PORTAL SAHABAT BAIK' : ($user->isAffiliate() ? 'PORTAL MITRA AMIL ZAKAT' : 'PORTAL ADMINISTRATOR') }}
                </span>
            </div>
            <h2 class="fw-bold mb-2 text-white">Selamat Datang, {{ $user->name }}!</h2>
            <p class="text-white opacity-90 mb-4" style="font-size: 0.95rem; line-height: 1.6; max-width: 620px;">
                Terima kasih atas dedikasi dan kontribusi nyata Anda bersama Graha Dhuafa Indonesia. Salurkan kabar kebaikan dan dokumentasi kegiatan aksi sosial Anda di portal ini.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('portal.berita.create') }}" class="btn-hero-action-orange">
                    <i class="bi bi-pencil-square"></i> Tulis Berita Kegiatan Baru
                </a>
                <a href="{{ route('portal.berita.index') }}" class="btn-hero-action-glass">
                    <i class="bi bi-journal-text"></i> Lihat Berita Saya
                </a>
            </div>
        </div>
        <div class="col-lg-4 text-center d-none d-lg-block">
            <div class="megaphone-box">
                <div class="megaphone-icon-wrapper">
                    <i class="bi bi-megaphone"></i>
                </div>
                <div class="megaphone-float-dot"></div>
            </div>
        </div>
    </div>
</section>

@if($user->isAffiliate())
<!-- CARD KHUSUS PROGRAM AFILIASI MITRA -->
<section class="card border-0 shadow-sm mb-4" style="border-radius: 22px; background: #ffffff; border: 1.5px solid #fed7aa !important; overflow: hidden;">
    <div class="p-4" style="background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%); border-bottom: 1px solid #fed7aa;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="bi bi-link-45deg"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.7rem;">PROGRAM AFILIASI MITRA</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-0 mt-1">Tautan & Kode Donasi Afiliasi: {{ $user->instansi ?? $user->name }}</h5>
                    <small class="text-muted">Sebarkan tautan referral donasi ini untuk jamaah, komunitas, atau donatur Anda.</small>
                </div>
            </div>
            <div>
                <div class="p-2 px-3 bg-white rounded-4 border border-warning-subtle d-inline-flex align-items-center gap-2 shadow-sm">
                    <span class="text-muted small fw-semibold">Kode Referral:</span>
                    <strong class="text-primary fs-5">{{ strtoupper($user->username) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="p-4">
        <div class="row g-3 align-items-center">
            <div class="col-lg-8">
                <label class="form-label small fw-bold text-secondary mb-1">Tautan Donasi Resmi GDI Anda:</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-globe text-warning"></i></span>
                    <input type="text" class="form-control bg-light border-start-0 border-end-0 fw-semibold text-dark" id="inputAffiliateLink" value="{{ url('/donasi?ref=' . $user->username) }}" readonly>
                    <button class="btn btn-warning fw-bold px-4 rounded-end-3" type="button" onclick="copyAffiliateLink()">
                        <i class="bi bi-clipboard me-1" id="copyIcon"></i> <span id="copyText">Salin Link</span>
                    </button>
                </div>
            </div>
            <div class="col-lg-4 d-flex align-items-end">
                @php
                    $waText = urlencode("Bismillah, mari salurkan sedekah dan kepedulian terbaik Anda bersama " . ($user->instansi ?? $user->name) . " melalui Yayasan Graha Dhuafa Indonesia. Tautan resmi: " . url('/donasi?ref=' . $user->username));
                @endphp
                <a href="https://api.whatsapp.com/send?text={{ $waText }}" target="_blank" class="btn btn-success fw-bold w-100 py-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-whatsapp fs-5"></i> Bagikan ke WhatsApp
                </a>
            </div>
        </div>

        <div class="mt-3 p-3 bg-light rounded-3 small text-muted d-flex align-items-center gap-2">
            <i class="bi bi-info-circle-fill text-warning fs-5 flex-shrink-0"></i>
            <div>
                Setiap donatur yang berdonasi melalui tautan ini akan otomatis terdata di bawah naungan kemitraan <strong>{{ $user->instansi ?? $user->name }}</strong>.
            </div>
        </div>
    </div>
</section>
@endif

<!-- 2. STATS 4 COUNTERS -->
<section class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card blue">
            <div>
                <div class="metric-label">TOTAL BERITA</div>
                <div class="metric-number">{{ $totalBerita }}</div>
                <div class="metric-sub">Semua liputan Anda</div>
            </div>
            <div class="metric-icon-circle blue">
                <i class="bi bi-newspaper"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card green">
            <div>
                <div class="metric-label">SUDAH TERBIT</div>
                <div class="metric-number">{{ $totalPublish }}</div>
                <div class="metric-sub">Tayang di website</div>
            </div>
            <div class="metric-icon-circle green">
                <i class="bi bi-check-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card orange">
            <div>
                <div class="metric-label">MENUNGGU REVIEW</div>
                <div class="metric-number">{{ $totalDraft }}</div>
                <div class="metric-sub">Dikurasi Admin GDI</div>
            </div>
            <div class="metric-icon-circle orange">
                <i class="bi bi-clock-history"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card gray">
            <div>
                <div class="metric-label">MASUK BIN</div>
                <div class="metric-number">{{ $totalBin }}</div>
                <div class="metric-sub">Dihapus sementara</div>
            </div>
            <div class="metric-icon-circle gray">
                <i class="bi bi-trash"></i>
            </div>
        </div>
    </div>
</section>

<!-- 3. TABLE: BERITA & LIPUTAN TERBARU SAYA -->
<section class="table-section-card">
    <div class="table-section-header">
        <div class="table-section-title-wrap">
            <div class="header-icon-box">
                <i class="bi bi-journal-text"></i>
            </div>
            <h5 class="table-section-title">Berita & Liputan Terbaru Saya</h5>
        </div>
        <a href="{{ route('portal.berita.index') }}" class="link-see-all">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-clean mb-0">
            <thead>
                <tr>
                    <th width="5%">NO</th>
                    <th width="10%">FOTO</th>
                    <th>JUDUL BERITA</th>
                    <th>KATEGORI</th>
                    <th>STATUS KURASI</th>
                    <th>TANGGAL KIRIM</th>
                    <th width="10%" class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBlogs as $idx => $b)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>
                            @if($b->featured_img)
                                <img src="{{ asset($b->featured_img) }}" alt="" style="width: 58px; height: 44px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="width: 58px; height: 44px; border-radius: 8px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark text-truncate" style="max-width: 280px;">{{ $b->title }}</div>
                            <span class="small text-muted">{{ Str::limit(strip_tags($b->content), 55) }}</span>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $b->kategori ?? 'Umum' }}</span></td>
                        <td>
                            @if($b->status === 'publish')
                                <span class="badge bg-success-subtle text-success border border-success fw-semibold"><i class="bi bi-check-circle me-1"></i> Tayang Publik</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning fw-semibold"><i class="bi bi-hourglass-split me-1"></i> Draft (Menunggu ACC)</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $b->created_at ? $b->created_at->format('d M Y') : '-' }}</td>
                        <td class="text-center">
                            @if($b->status === 'draft')
                                <a href="{{ route('portal.berita.edit', $b->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1" title="Edit Draft">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                            @else
                                <a href="{{ route('website.blog.detail', $b->slug) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1" title="Lihat di Web">
                                    <i class="bi bi-box-arrow-up-right"></i> Lihat
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-0 border-0">
                            <div class="empty-state-wrapper">
                                <div class="empty-icon-card">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <div class="empty-text">Belum ada berita kegiatan yang Anda buat.</div>
                                <a href="{{ route('portal.berita.create') }}" class="btn-create-first">
                                    <i class="bi bi-plus-lg"></i> Buat Liputan Kegiatan Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<!-- 4. BOTTOM GUIDELINES CARDS -->
<section class="row g-4">
    <!-- PANDUAN PENULISAN LIPUTAN -->
    <div class="col-md-6">
        <div class="guide-card">
            <h6 class="guide-title">
                <span class="text-warning fs-5"><i class="bi bi-lightbulb-fill"></i></span> Panduan Penulisan Liputan
            </h6>
            <div class="guide-item">
                <div class="check-circle-green"><i class="bi bi-check"></i></div>
                <div>Gunakan foto asli hasil dokumentasi lapangan kegiatan sosial/bencana.</div>
            </div>
            <div class="guide-item">
                <div class="check-circle-green"><i class="bi bi-check"></i></div>
                <div>Sertakan detail tanggal, lokasi kegiatan, dan jumlah penerima manfaat.</div>
            </div>
            <div class="guide-item mb-0">
                <div class="check-circle-green"><i class="bi bi-check"></i></div>
                <div>Bahasa yang digunakan santun, informatif, dan menginspirasi semangat berbagi.</div>
            </div>
        </div>
    </div>

    <!-- ALUR MODERASI KONTEN -->
    <div class="col-md-6">
        <div class="guide-card">
            <h6 class="guide-title">
                <span class="text-success fs-5"><i class="bi bi-shield-check"></i></span> Alur Moderasi Konten
            </h6>
            <p class="small text-muted mb-3" style="line-height: 1.6;">
                Semua artikel berita yang Anda simpan akan masuk status <strong>DRAFT</strong> terlebih dahulu. Tim Admin Graha Dhuafa Indonesia akan mengevaluasi liputan tersebut. Jika lolos review, tulisan Anda akan langsung tayang pada website publik GDI.
            </p>
            <div class="d-flex align-items-center flex-wrap gap-2 pt-1">
                <span class="flow-step-pill draft"><i class="bi bi-pencil"></i> Draft</span>
                <i class="bi bi-arrow-right text-muted small"></i>
                <span class="flow-step-pill review"><i class="bi bi-eye"></i> Review Admin</span>
                <i class="bi bi-arrow-right text-muted small"></i>
                <span class="flow-step-pill publish"><i class="bi bi-globe"></i> Tayang</span>
            </div>
        </div>
    </div>
</section>
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
