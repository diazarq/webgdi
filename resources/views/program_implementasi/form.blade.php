@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Program</a></li>
        <li class="breadcrumb-item"><a href="/admin/program/implementasi">Program Implementasi</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $mode }}</li>
    </ol>
@endsection

@section('content')
<div class="container">
    <h5>Form {{ $mode }} Program Implementasi</h5>
    <a href="/admin/program/implementasi" class="btn btn-primary"><i class="bi-arrow-left-square"></i> Kembali</a>
    <hr/>

    <div class="row">
        <div class="col-md-8">
            <form method="post" action="/admin/program/implementasi/add" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ @$detail->id }}"/>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Nama Program *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" required name="nama_program" value="{{ old('nama_program', @$detail->nama_program) }}" placeholder="eg. Budaya">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">URL Program</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="url_program" value="{{ old('url_program', @$detail->url_program) }}" placeholder="eg. /budaya atau https://...">
                        <small class="text-muted">Halaman tujuan saat tile diklik di homepage (mis. <code>/budaya</code>). Jika dikosongkan saat tambah baru, otomatis dibuat dari nama program.</small>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Tampil di Homepage</label>
                    <div class="col-sm-5">
                        @php $curStatus = old('status', @$detail->status ?? 'A'); @endphp
                        <select class="form-control" name="status">
                            <option value="A" {{ $curStatus === 'A' ? 'selected' : '' }}>Tampil di Homepage (Aktif)</option>
                            <option value="N" {{ $curStatus === 'N' ? 'selected' : '' }}>Sembunyikan (Nonaktif)</option>
                        </select>
                        <small class="text-muted">Atur apakah kartu program ini ditampilkan di Homepage atau disembunyikan.</small>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Logo Image *</label>
                    <div class="col-sm-9">
                        {{-- kotak preview: logo tampil utuh (tidak terpotong) --}}
                        <div class="logo-preview-box">
                            @php
                                $imgUrl = @$detail->logo_image ? asset(@$detail->logo_image) : asset('admin/assets/img/setting/_img.jpg');
                            @endphp
                            <img id="logo_image" src="{{ $imgUrl }}" alt="Preview Logo"/>
                        </div>

                        {{-- teks rekomendasi + tombol upload tersusun vertikal --}}
                        <div class="logo-upload-actions">
                            <div class="logo-upload-hint">Ukuran yang disarankan: 280 x 280 px (png)</div>
                            <input type="file" name="logo_image" style="display: none" id="logoImg" accept="image/png,image/jpeg,image/jpg,image/gif,image/svg+xml,image/webp"/>
                            <label class="btn btn-primary btn-upload" for="logoImg"><i class="bi-upload"></i> Upload</label>
                        </div>
                    </div>
                </div>

                <hr class="my-4"/>
                <h6 class="text-muted mb-3">Pengaturan Hero Halaman Program <span class="fw-normal">(Opsional — tampil di banner atas halaman program)</span></h6>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Teks Kecil (Badge)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="badge_text" value="{{ old('badge_text', @$landing->badge_text) }}" placeholder="eg. Program Unggulan">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Sub Judul (Tagline)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="tagline" value="{{ old('tagline', @$landing->tagline) }}" placeholder="eg. Bangun Peradaban, Berakhlak & Berkarya">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Deskripsi Hero</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="description" rows="3" placeholder="Deskripsi singkat yang tampil di bagian atas halaman program...">{{ old('description', @$landing->description) }}</textarea>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Background Hero</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" name="background_image" accept="image/png,image/jpeg,image/jpg,image/webp"/>
                        @if(@$landing->background_image)
                            <small class="text-success d-block mt-1"><i class="bi-check-circle"></i> Background saat ini sudah terpasang. Upload file baru jika ingin mengganti.</small>
                        @else
                            <small class="text-muted d-block mt-1">Opsional (1920x1080 px). Kosongkan untuk memakai gradien hijau bawaan.</small>
                        @endif
                    </div>
                </div>

                <hr/>
                <button type="submit" class="btn btn-success"><i class="bi-save"></i> Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* kotak preview logo: dinamis, fleksibel, logo tampil penuh tanpa terpotong */
    .logo-preview-box {
        width: 100%;
        max-width: 280px;
        aspect-ratio: 1 / 1;
        padding: 16px;
        background: #ffffff;
        border: 1px solid #e6ebe8;
        border-radius: 14px;
        box-shadow: 0 1px 5px rgba(23, 58, 42, .08);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .logo-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    /* teks rekomendasi + tombol upload tersusun vertikal dengan jarak proporsional */
    .logo-upload-actions {
        margin-top: 16px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .logo-upload-hint {
        color: #6b7a75;
        font-size: 13px;
    }
</style>
@endpush

@push('scripts')
    <script>
        /* preview gambar saat memilih file (pola sama dengan form slider) */
        $('#logoImg').change(function(){
            const file = this.files[0];
            if(file){
                $('#logo_image').attr('src', URL.createObjectURL(file));
            }
        });
    </script>
@endpush
