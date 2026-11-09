@extends('layout.app', ['active' => $active])

@section('meta')
    <meta name="csrf_token" id="csrf_token" content="{{ csrf_token() }}" />
@endsection

@section('title', ($pageTitle ?? 'Form Pilihan Donasi'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.campaign.index') }}">Kelola Donasi</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $mode }} Donasi</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-pencil-square text-success me-2"></i>{{ $mode }} Pilihan Donasi (Campaign)
            </h4>
            <p class="text-muted small mb-0">Isi detail informasi musibah, bencana, atau program kebaikan.</p>
        </div>
        <a href="{{ route('admin.campaign.index') }}" class="btn btn-outline-secondary rounded-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">
            <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-octagon-fill me-2"></i>Terjadi Kesalahan Pengisian:</h6>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.campaign.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ @$campaign['id'] }}">
        <input type="hidden" name="existing_image" value="{{ @$campaign['image'] }}">

        <div class="row g-4">
            <!-- KOLOM KIRI: INFORMASI UTAMA -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-4">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>Informasi Pokok Program
                    </h6>

                    <!-- Judul Program -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Judul Program / Peristiwa Musibah <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="title" 
                               class="form-control form-control-lg fs-6 rounded-3" 
                               placeholder="Contoh: Tanggap Bencana Gempa Bumi & Longsor Cianjur"
                               value="{{ old('title', @$campaign['title']) }}" 
                               required>
                        <small class="text-muted">Gunakan judul yang jelas, menyentuh, dan menggambarkan kondisi musibah.</small>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Kategori Program -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Kategori Donasi <span class="text-danger">*</span></label>
                            <select name="category" class="form-select rounded-3" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="bencana-alam" {{ old('category', @$campaign['category']) == 'bencana-alam' ? 'selected' : '' }}>Bencana Alam (Gempa, Banjir, Longsor)</option>
                                <option value="medis" {{ old('category', @$campaign['category']) == 'medis' ? 'selected' : '' }}>Bantuan Medis & Kesehatan</option>
                                <option value="yatim-dhuafa" {{ old('category', @$campaign['category']) == 'yatim-dhuafa' ? 'selected' : '' }}>Yatim & Dhuafa</option>
                                <option value="infrastruktur" {{ old('category', @$campaign['category']) == 'infrastruktur' ? 'selected' : '' }}>Wakaf & Air Bersih</option>
                                <option value="pendidikan" {{ old('category', @$campaign['category']) == 'pendidikan' ? 'selected' : '' }}>Pendidikan & Beasiswa</option>
                                <option value="kemanusiaan" {{ old('category', @$campaign['category']) == 'kemanusiaan' ? 'selected' : '' }}>Kemanusiaan Umum</option>
                            </select>
                        </div>

                        <!-- Lokasi -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Lokasi Kejadian / Penyaluran</label>
                            <input type="text" 
                                   name="location" 
                                   class="form-control rounded-3" 
                                   placeholder="Contoh: Kab. Cianjur, Jawa Barat"
                                   value="{{ old('location', @$campaign['location'] ?: 'Indonesia') }}">
                        </div>
                    </div>

                    <!-- Deskripsi Singkat -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Deskripsi Singkat (Ringkasan Kartu) <span class="text-danger">*</span></label>
                        <textarea name="short_desc" 
                                  class="form-control rounded-3" 
                                  rows="2" 
                                  placeholder="Deskripsi singkat yang tampil di kartu katalog publik..." 
                                  required>{{ old('short_desc', @$campaign['short_desc']) }}</textarea>
                    </div>

                    <!-- Cerita Lengkap & Kronologi Musibah -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Kisah & Kronologi Lengkap Musibah (HTML / Teks) <span class="text-danger">*</span></label>
                        <textarea name="story" 
                                  class="form-control rounded-3" 
                                  rows="10" 
                                  placeholder="Ceritakan kondisi para korban, kebutuhan mendesak di lapangan, dan rencana penyaluran donasi..." 
                                  required>{{ old('story', @$campaign['story']) }}</textarea>
                        <small class="text-muted">Bisa menulis teks biasa atau tag HTML seperti &lt;p&gt;, &lt;h5&gt;, &lt;ul&gt;, &lt;li&gt; untuk format rapi.</small>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: TARGET NOMINAL, COVER, STATUS -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-4">
                        <i class="bi bi-wallet2 text-success me-2"></i>Target & Durasi Donasi
                    </h6>

                    <!-- Target Nominal -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Target Nominal (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">Rp</span>
                            <input type="number" 
                                   name="target" 
                                   class="form-control rounded-end-3" 
                                   placeholder="Contoh: 100000000"
                                   value="{{ old('target', @$campaign['target'] ?: 50000000) }}" 
                                   min="100000" 
                                   required>
                        </div>
                        <small class="text-muted">Nominal target yang ingin dikumpulkan.</small>
                    </div>

                    <!-- Dana Terkumpul Awal -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Dana Terkumpul Awal (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">Rp</span>
                            <input type="number" 
                                   name="collected" 
                                   class="form-control rounded-end-3" 
                                   placeholder="0"
                                   value="{{ old('collected', @$campaign['collected'] ?: 0) }}" 
                                   min="0">
                        </div>
                        <small class="text-muted">Jumlah donasi yang telah terkumpul saat ini.</small>
                    </div>

                    <!-- Sisa Hari -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Durasi Sisa Hari <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" 
                                   name="days_left" 
                                   class="form-control" 
                                   placeholder="30"
                                   value="{{ old('days_left', @$campaign['days_left'] ?: 30) }}" 
                                   min="1" 
                                   required>
                            <span class="input-group-text bg-light">Hari</span>
                        </div>
                    </div>

                    <!-- Status Program -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Status Tayang Program</label>
                        <select name="status" class="form-select rounded-3">
                            <option value="active" {{ old('status', @$campaign['status'] ?: 'active') == 'active' ? 'selected' : '' }}>
                                ✅ Aktif (Buka Donasi di Publik)
                            </option>
                            <option value="takedown" {{ old('status', @$campaign['status']) == 'takedown' ? 'selected' : '' }}>
                                🛑 Takedown (Tutup Donasi / Selesai)
                            </option>
                        </select>
                        <small class="text-muted">Jika di-Takedown, donatur tidak lagi bisa mengirimkan uang ke program ini.</small>
                    </div>
                </div>

                <!-- KARTU UPLOAD COVER GAMBAR -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-3 mb-4">
                        <i class="bi bi-image text-warning me-2"></i>Foto Cover / Dokumentasi
                    </h6>

                    <div class="mb-3 text-center">
                        @php
                            $previewImg = @$campaign['image'] ? asset(@$campaign['image']) : asset('images/blog/sedekah-ramadhan.jpg');
                        @endphp
                        <div class="mb-3 rounded-3 overflow-hidden border bg-light position-relative" style="height: 180px;">
                            <img id="previewCover" 
                                 src="{{ $previewImg }}" 
                                 alt="Preview" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.src='{{ asset('website/assets/images/backgrounds/main-slider-2-1.jpg') }}'">
                        </div>
                        <label class="form-label fw-bold text-dark d-block text-start small">Upload Foto Baru (JPG, PNG, WebP maks 2MB)</label>
                        <input type="file" 
                               name="image_file" 
                               id="imageFileInput" 
                               class="form-control form-control-sm rounded-3" 
                               accept="image/*"
                               onchange="previewImage(this)">
                    </div>
                </div>

                <!-- TOMBOL SIMPAN -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg py-3 rounded-pill fw-bold shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Simpan Pilihan Donasi
                    </button>
                    <a href="{{ route('admin.campaign.index') }}" class="btn btn-light rounded-pill py-2">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>

</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewCover').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
