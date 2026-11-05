@extends('layout.app', ['active' => $active])

@section('title', ($pageTitle ?? 'Kelola Tema'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Tema</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-4 mt-5 ms-4 text-black fw-bold">Kelola Tema & Tampilan Website</h4>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-2"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.theme.save') }}">
        @csrf

        <div class="row g-4">
            <!-- 1. HEADER & NAVIGASI -->
                <div class="ps-5 pe-5">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                        <h6 class="mb-0 fs-4 text-dark">Header & Navigasi Website</h6>
                    </div>
                    <div class="card-body p-4">
                        <!-- Topbar Info Kontak -->
                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                            <div class="pe-3">
                                <label class="fw-bold text-dark mb-1" for="show_topbar" style="cursor: pointer;">
                                    Tampilkan Top Bar Info Kontak
                                </label>
                                <div class="text-muted small">Menampilkan baris hijau paling atas berisi alamat instansi, email, dan ikon media sosial.</div>
                            </div>
                            <div class="form-check fs-4">
                                <input class="form-check-input" type="checkbox" id="show_topbar" name="show_topbar" value="1" {{ $settings['show_topbar'] ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Sticky Navbar -->
                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                            <div class="pe-3">
                                <label class="fw-bold text-dark mb-1" for="sticky_navbar" style="cursor: pointer;">
                                    Aktifkan Navbar Sticky
                                </label>
                                <div class="text-muted small">Menu navigasi selalu menempel di bagian atas layar ketika pengunjung menggulir (scroll) halaman ke bawah.</div>
                            </div>
                            <div class="form-check fs-4">
                                <input class="form-check-input" type="checkbox" id="sticky_navbar" name="sticky_navbar" value="1" {{ $settings['sticky_navbar'] ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Tombol CTA Zakat Sekarang -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pe-3">
                                <label class="fw-bold text-dark mb-1" for="show_navbar_cta" style="cursor: pointer;">
                                    Tampilkan Tombol "Zakat Sekarang"
                                </label>
                                <div class="text-muted small">Menampilkan tombol oranye aksi cepat di sebelah kanan menu navigasi untuk akses langsung donasi zakat.</div>
                            </div>
                            <div class="form-check fs-4">
                                <input class="form-check-input" type="checkbox" id="show_navbar_cta" name="show_navbar_cta" value="1" {{ $settings['show_navbar_cta'] ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
            

            <!-- 2. BERANDA & HALAMAN LAINNYA -->
                <div class="pe-5 ps-5">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                        <h6 class="mb-0 fs-4 text-dark">Konten Halaman & Banner</h6>
                    </div>
                    <div class="card-body p-4">
                        <!-- Slider Utama di Beranda -->
                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                            <div class="pe-3">
                                <label class="fw-bold text-dark mb-1" for="show_slider" style="cursor: pointer;">
                                    Tampilkan Slider Utama di Beranda
                                </label>
                                <div class="text-muted small">Menampilkan carousel banner/slider gambar bergerak di halaman utama (homepage).</div>
                            </div>
                            <div class="form-check fs-4">
                                <input class="form-check-input" type="checkbox" id="show_slider" name="show_slider" value="1" {{ $settings['show_slider'] ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Banner Header Halaman Dalam (Page Header) -->
                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                            <div class="pe-3">
                                <label class="fw-bold text-dark mb-1" for="show_page_header" style="cursor: pointer;">
                                    Tampilkan Banner Page Header
                                </label>
                                <div class="text-muted small">Menampilkan bagian banner foto hijau di atas judul pada halaman sub-page (Tentang Zakat, Program, Blog, Kontak, dll).</div>
                            </div>
                            <div class="form-check fs-4">
                                <input class="form-check-input" type="checkbox" id="show_page_header" name="show_page_header" value="1" {{ $settings['show_page_header'] ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Slot Iklan / Kampanye -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pe-3">
                                <label class="fw-bold text-dark mb-1" for="show_ads" style="cursor: pointer;">
                                    Tampilkan Slot Iklan / Kampanye
                                </label>
                                <div class="text-muted small">Menampilkan banner ajakan kebaikan / donasi di halaman beranda.</div>
                            </div>
                            <div class="form-check fs-4">
                                <input class="form-check-input" type="checkbox" id="show_ads" name="show_ads" value="1" {{ $settings['show_ads'] ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
        
            <!-- Tombol Simpan -->
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <span class="text-muted small">Perubahan akan langsung diterapkan ke tampilan website publik setelah Anda menekan tombol simpan.</span>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary px-4 py-3 fw-bold shadow-sm border-0 rounded-3">
                        <i class="bi bi-save-fill"></i> Simpan Pengaturan Tema
                    </button>
                </div>
            </div>
    </form>
</div>
@endsection
