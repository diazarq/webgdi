@extends('portal.layout')
@section('title', $pageTitle)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square text-success me-2"></i>{{ $pageTitle }}</h4>
        <p class="text-muted small mb-0">Bagikan dokumentasi aksi nyata, penyaluran amanah, atau kabar kemitraan.</p>
    </div>
    <a href="{{ route('portal.berita.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Berita
    </a>
</div>

<div class="alert alert-warning d-flex align-items-center mb-4 rounded-4 shadow-sm border-0" style="background: #fffbeb; border: 1px solid #fef08a !important;">
    <i class="bi bi-info-circle-fill fs-4 me-3 flex-shrink-0 text-warning"></i>
    <div class="small">
        <strong>Pemberitahuan Sistem:</strong> Setiap berita yang Anda kirimkan akan otomatis berstatus <strong>DRAFT (Menunggu Persetujuan Admin)</strong>. Tim admin Graha Dhuafa Indonesia akan mengevaluasi liputan ini terlebih dahulu. Jika disetujui, berita akan langsung tayang pada website publik GDI.
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4">
        <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Mohon lengkapi isian form berikut:</strong>
        <ul class="mb-0 mt-1 small">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="border: 1px solid #e8edea !important;">
    <form action="{{ $mode === 'edit' ? route('portal.berita.update', $detail->id) : route('portal.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <!-- JUDUL -->
            <div class="col-12">
                <label class="form-label fw-bold">Judul Berita / Liputan Kegiatan *</label>
                <input type="text" class="form-control form-control-lg rounded-3" name="title" value="{{ old('title', @$detail->title) }}" placeholder="Contoh: Penyaluran Paket Sembako & Dapur Umum untuk Korban Banjir" required>
            </div>

            <!-- KATEGORI -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Pilih Kategori *</label>
                <select class="form-select rounded-3" name="kategori" id="selectKategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}" {{ old('kategori', @$detail->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                    <option value="__baru__" {{ old('kategori') == '__baru__' ? 'selected' : '' }}>+ Tulis Kategori Baru...</option>
                </select>
            </div>

            <!-- KATEGORI BARU (CONDITIONAL) -->
            <div class="col-md-6" id="kategoriBaruBox" style="{{ old('kategori') == '__baru__' ? '' : 'display: none;' }}">
                <label class="form-label fw-bold">Nama Kategori Baru</label>
                <input type="text" class="form-control rounded-3" name="kategori_baru" value="{{ old('kategori_baru') }}" placeholder="Ketik nama kategori baru">
            </div>

            <!-- FOTO UTAMA -->
            <div class="col-12">
                <label class="form-label fw-bold">Foto Utama Kegiatan (Featured Image) {{ $mode === 'edit' ? '(Opsional jika tidak ganti)' : '*' }}</label>
                <input type="file" class="form-control rounded-3" name="featured_img" accept="image/*" {{ $mode === 'edit' ? '' : 'required' }} onchange="previewImage(this)">
                <div class="form-text small text-muted">Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB. Gunakan foto dokumentasi yang jernih dan berorientasi landscape.</div>

                <div class="mt-2" id="imagePreviewContainer" style="{{ @$detail->featured_img ? '' : 'display: none;' }}">
                    <img id="imgPreview" src="{{ @$detail->featured_img ? asset($detail->featured_img) : '#' }}" alt="Preview" style="max-height: 180px; border-radius: 10px; border: 1px solid #ddd; object-fit: cover;">
                </div>
            </div>

            <!-- KONTEN BERITA -->
            <div class="col-12">
                <label class="form-label fw-bold">Isi Cerita & Laporan Liputan Kegiatan *</label>
                <textarea class="form-control rounded-3" name="content" id="contentEditor" rows="12" placeholder="Ceritakan jalannya kegiatan, lokasi, waktu pelaksanaan, suasana di lapangan, serta ungkapan rasa syukur atau testimoni dari penerima manfaat..." required>{{ old('content', @$detail->content) }}</textarea>
                <div class="form-text small text-muted">Tuliskan narasi secara lengkap dan detail agar mempermudah tim Admin dalam melakukan verifikasi penerbitan.</div>
            </div>

            <!-- HASHTAG -->
            <div class="col-12">
                <label class="form-label fw-bold">Hashtag / Kata Kunci (Opsional)</label>
                <input type="text" class="form-control rounded-3" name="hashtag" value="{{ old('hashtag', @$detail->hashtag) }}" placeholder="Contoh: #SahabatBaik #TanggapBencana #ZakatMemberdayakan">
            </div>

            <div class="col-12 border-top pt-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('portal.berita.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                <button type="submit" class="btn btn-success rounded-pill btn-lg px-4 fw-bold">
                    <i class="bi bi-send-check me-2"></i> {{ $mode === 'edit' ? 'Simpan Perubahan Draft' : 'Kirim Berita untuk Direview Admin' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('selectKategori').addEventListener('change', function() {
        var box = document.getElementById('kategoriBaruBox');
        if (this.value === '__baru__') {
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreview').src = e.target.result;
                document.getElementById('imagePreviewContainer').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
