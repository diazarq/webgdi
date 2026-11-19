@extends('layout.layout-page')

@section('title', 'Tentang Zakat | Yayasan Graha Dhuafa Indonesia')

@section('breadcrumb')
<ul class="thm-breadcrumb list-unstyled">
    <li><a href="{{ url('/') }}">Beranda</a></li>
    <li><span>Tentang Zakat</span></li>
</ul>
<h2>Tentang Zakat</h2>
@endsection

@section('content')
<section class="about-zakat-section py-5" style="background-color: #ffffff;">
    <div class="container py-lg-4">
        
        <!-- ================= BAGIAN 1: APA ITU ZAKAT? ================= -->
        <div class="row align-items-center g-4 g-lg-5 mb-5">
            <div class="col-lg-7">
                <div class="about-zakat__content">
                    <div class="gdi-accent-bar mb-3"></div>
                    <h2 class="fw-bold text-dark mb-4" style="font-size: 2.2rem; letter-spacing: -0.5px;">Apa itu Zakat?</h2>
                    
                    <p class="text-secondary leading-relaxed mb-3" style="font-size: 1.02rem; line-height: 1.8;">
                        Zakat adalah salah satu rukun Islam yang agung dan wajib ditunaikan oleh setiap Muslim yang telah memenuhi syarat kemampuan (mencapai nishab dan haul). Secara bahasa, zakat bermakna <em>menyucikan</em>, <em>membersihkan</em>, <em>menumbuhkan</em>, serta <em>mengalirkan keberkahan</em>. Penunaian zakat merupakan wujud nyata kepedulian sosial, keadilan ekonomi, dan upaya membersihkan harta dari hak-hak kaum dhuafa yang Allah SWT titipkan pada rezeki kita.
                    </p>
                    
                    <p class="text-secondary leading-relaxed mb-4" style="font-size: 1.02rem; line-height: 1.8;">
                        Dengan berzakat, kita tidak hanya membantu meringankan beban saudara-saudara kita yang membutuhkan, tetapi juga meraih ketenteraman batin, menyucikan jiwa dari sifat kikir, serta mengundang keberkahan dan keberlimpahan rezeki yang berlipat ganda dalam kehidupan dunia maupun akhirat.
                    </p>

                    <!-- Quote Ayat Al-Qur'an -->
                    <div class="zakat-quote-box p-3 p-md-4 rounded-4 d-flex align-items-start gap-3">
                        <div class="zakat-quote-icon flex-shrink-0">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div>
                            <blockquote class="mb-2 fst-italic text-dark fw-medium" style="font-size: 0.96rem; line-height: 1.65;">
                                "Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan dan menyucikan mereka dan mendoalah untuk mereka. Sesungguhnya doa kamu itu (menjadi) ketenteraman jiwa bagi mereka."
                            </blockquote>
                            <span class="fw-bold text-success" style="font-size: 0.90rem;">(QS. At-Taubah : 103)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gambar Visual Zakat -->
            <div class="col-lg-5">
                <div class="zakat-img-wrap position-relative">
                    <div class="zakat-img-card rounded-4 overflow-hidden shadow-sm" style="border-radius: 20px !important;">
                        <img src="{{ asset('images/blog/sedekah-ramadhan.jpg') }}" onerror="this.src='{{ asset('website/assets/images/backgrounds/main-slider-2-1.jpg') }}'" alt="Tentang Zakat" class="w-100 h-100" style="min-height: 360px; max-height: 420px; object-fit: cover;">
                    </div>
                    <!-- Aksen Daun Hijau Dekoratif -->
                    <div class="zakat-leaf-accent" aria-hidden="true">
                        <svg width="45" height="75" viewBox="0 0 45 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 10C25 15 45 40 40 70C30 50 15 35 5 10Z" fill="#15803d" opacity="0.85"/>
                            <path d="M0 45C15 50 30 65 25 75C18 68 8 60 0 45Z" fill="#22c55e" opacity="0.9"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= BAGIAN 2: JENIS-JENIS ZAKAT ================= -->
        <div class="mb-5 pt-3">
            <div class="gdi-accent-bar mb-3"></div>
            <h3 class="fw-bold text-dark mb-4" style="font-size: 1.75rem;">Jenis-Jenis Zakat</h3>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <!-- 1. Zakat Fitrah -->
                <div class="col">
                    <div class="zakat-card h-100 p-4 rounded-4 text-start">
                        <div class="zakat-card__icon mb-3">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2" style="font-size: 1.15rem;">Zakat Fitrah</h5>
                        <p class="text-secondary small mb-0" style="line-height: 1.65; font-size: 0.88rem;">
                            Zakat jiwa yang wajib dikeluarkan oleh setiap Muslim pada bulan suci Ramadan hingga sebelum salat Idulfitri untuk menyucikan diri dan membahagiakan kaum dhuafa.
                        </p>
                    </div>
                </div>

                <!-- 2. Zakat Maal -->
                <div class="col">
                    <div class="zakat-card h-100 p-4 rounded-4 text-start">
                        <div class="zakat-card__icon mb-3">
                            <i class="fas fa-coins"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2" style="font-size: 1.15rem;">Zakat Maal</h5>
                        <p class="text-secondary small mb-0" style="line-height: 1.65; font-size: 0.88rem;">
                            Zakat yang dikeluarkan dari kepemilikan harta simpanan seperti uang, emas, perak, surat berharga, atau hasil usaha yang telah mencapai nishab dan haul selama satu tahun.
                        </p>
                    </div>
                </div>

                <!-- 3. Zakat Ternak -->
                <div class="col">
                    <div class="zakat-card h-100 p-4 rounded-4 text-start">
                        <div class="zakat-card__icon mb-3">
                            <i class="fas fa-horse"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2" style="font-size: 1.15rem;">Zakat Ternak</h5>
                        <p class="text-secondary small mb-0" style="line-height: 1.65; font-size: 0.88rem;">
                            Zakat yang wajib dikeluarkan dari hasil pemeliharaan hewan ternak seperti sapi, kerbau, kambing, dan domba yang digembalakan dan telah mencapai ketentuan nishab syariat.
                        </p>
                    </div>
                </div>

                <!-- 4. Zakat Pertanian -->
                <div class="col">
                    <div class="zakat-card h-100 p-4 rounded-4 text-start">
                        <div class="zakat-card__icon mb-3">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2" style="font-size: 1.15rem;">Zakat Pertanian</h5>
                        <p class="text-secondary small mb-0" style="line-height: 1.65; font-size: 0.88rem;">
                            Zakat yang ditunaikan setiap kali masa panen dari hasil pertanian biji-bijian, padi, dan buah-buahan yang mencapai nishab 5 wasaq (sekitar 653 kg gabah).
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= BAGIAN 3: BANNER CTA MARI TULIS ZAKAT ================= -->
        <div class="zakat-cta-banner position-relative rounded-4 p-4 p-md-5 overflow-hidden text-white mt-4">
            <!-- Background Ornamen Siluet Masjid -->
            <div class="zakat-cta-silhouette" aria-hidden="true">
                <svg width="220" height="130" viewBox="0 0 220 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M110 10C100 30 75 40 75 80H145C145 40 120 30 110 10Z" fill="rgba(255, 255, 255, 0.12)"/>
                    <path d="M50 40C42 55 25 65 25 95H75C75 65 58 55 50 40Z" fill="rgba(255, 255, 255, 0.08)"/>
                    <path d="M170 40C162 55 145 65 145 95H195C195 65 178 55 170 40Z" fill="rgba(255, 255, 255, 0.08)"/>
                    <rect x="0" y="80" width="220" height="50" fill="rgba(255, 255, 255, 0.06)"/>
                </svg>
            </div>

            <div class="row align-items-center justify-content-between position-relative" style="z-index: 2;">
                <div class="col-lg-8 col-md-7 mb-3 mb-md-0">
                    <h3 class="fw-bold text-white mb-2" style="font-size: 1.7rem;">Mari Tunaikan Zakat Sekarang!</h3>
                    <p class="mb-0 text-white-50" style="font-size: 0.98rem; max-width: 600px; line-height: 1.6;">
                        Salurkan zakat Anda secara amanah, tepat sasaran, dan berdampak nyata melalui Graha Dhuafa Indonesia untuk membantu lebih banyak saudara kita yang membutuhkan.
                    </p>
                </div>
                <div class="col-lg-4 col-md-5 text-md-end">
                    <a href="{{ url('app/zakat') }}" class="btn zakat-btn-cta shadow-sm">
                        Zakat Sekarang <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@push('styles')
<style>
    /* Aksen Bar Hijau */
    .gdi-accent-bar {
        width: 38px;
        height: 5px;
        background: #0f7638;
        border-radius: 4px;
    }

    /* Box Kutipan Ayat */
    .zakat-quote-box {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        transition: all 0.25s ease;
    }
    .zakat-quote-box:hover {
        background-color: #ecfdf5;
        border-color: #86efac;
    }
    .zakat-quote-icon {
        width: 44px;
        height: 44px;
        background-color: #0f7638;
        color: #ffffff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Kartu Gambar Zakat */
    .zakat-img-wrap {
        padding-right: 18px;
    }
    .zakat-img-card {
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    .zakat-leaf-accent {
        position: absolute;
        bottom: 25px;
        right: -8px;
        z-index: 3;
    }

    /* Kartu 4 Jenis Zakat */
    .zakat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .zakat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(15, 118, 56, 0.1);
        border-color: #86efac;
    }
    .zakat-card__icon {
        width: 50px;
        height: 50px;
        background-color: #f0fdf4;
        color: #0f7638;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        transition: all 0.25s ease;
    }
    .zakat-card:hover .zakat-card__icon {
        background-color: #0f7638;
        color: #ffffff;
    }

    /* Banner Hijau CTA */
    .zakat-cta-banner {
        background: linear-gradient(135deg, #0e6b33 0%, #15803d 100%);
        border: 1px solid #166534;
        box-shadow: 0 10px 30px rgba(15, 118, 56, 0.25);
    }
    .zakat-cta-silhouette {
        position: absolute;
        bottom: 0;
        left: 0;
        opacity: 0.9;
        pointer-events: none;
    }
    .zakat-btn-cta {
        background-color: #FF6B35;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.96rem;
        padding: 12px 28px;
        border-radius: 50px;
        border: none;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
    }
    .zakat-btn-cta:hover {
        background-color: #e85924;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 107, 53, 0.55);
    }
</style>
@endpush
@endsection
