@extends('portal.layout')
@section('title', $pageTitle)

@push('styles')
<style>
    /* =======================================================
       CARD & STEPPER WIZARD STYLES
       ======================================================= */
    .wizard-card-container {
        width: 100%;
        max-width: 920px;
        margin: 0 auto;
    }

    .wizard-card {
        background: #ffffff;
        border-radius: 26px;
        box-shadow: 0 12px 40px -10px rgba(15, 23, 42, 0.06);
        border: 1px solid #e8edea;
        padding: 36px 44px 40px 44px;
        position: relative;
    }

    /* TOP BAR */
    .btn-wizard-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        background: #ffffff;
        color: #334155;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-wizard-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #00885a;
        transform: translateX(-2px);
    }

    /* STEPPER TIMELINE */
    .wizard-stepper {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 18px 0 38px 0;
        position: relative;
    }

    .stepper-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        cursor: pointer;
        user-select: none;
    }

    .stepper-node {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.80rem;
        font-weight: 700;
        color: #94a3b8;
        transition: all 0.25s ease;
        z-index: 2;
    }

    .stepper-connector {
        width: 60px;
        height: 2.5px;
        background: #e2e8f0;
        margin: 0 4px;
        margin-bottom: 22px;
        transition: all 0.25s ease;
        z-index: 1;
    }

    /* STEP STATES */
    .stepper-item.completed .stepper-node {
        background: #e8f5ec;
        border-color: #00885a;
        color: #00885a;
    }

    .stepper-item.active .stepper-node {
        background: #00885a;
        border-color: #00885a;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(0, 136, 90, 0.2);
    }

    .stepper-connector.completed {
        background: #00885a;
    }

    .stepper-label {
        margin-top: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        color: #64748b;
        white-space: nowrap;
        text-align: center;
        transition: all 0.2s ease;
    }

    .stepper-item.active .stepper-label {
        color: #00885a;
        font-weight: 700;
    }

    .stepper-item.completed .stepper-label {
        color: #1e293b;
    }

    /* WIZARD PANELS */
    .wizard-step-panel {
        display: none;
        animation: fadeInStep 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .wizard-step-panel.active {
        display: block;
    }

    @keyframes fadeInStep {
        from {
            opacity: 0;
            transform: translateY(6px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* HEADER OF STEP */
    .step-header-area {
        margin-bottom: 26px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .step-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        background: #e8f5ec;
        color: #00885a;
        font-size: 0.74rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .step-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.3px;
        margin-bottom: 4px;
    }
    .step-subtitle {
        font-size: 0.84rem;
        color: #64748b;
        margin: 0;
    }

    /* 2-COLUMN ROW (Like reference image) */
    .wizard-form-row {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 28px;
        align-items: start;
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px solid #f8fafc;
    }
    .wizard-form-row:last-of-type {
        border-bottom: none;
        margin-bottom: 8px;
        padding-bottom: 0;
    }

    .row-label-wrap {
        padding-top: 4px;
    }
    .row-main-label {
        font-size: 0.86rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.35;
        margin-bottom: 4px;
    }
    .row-help-desc {
        font-size: 0.75rem;
        color: #94a3b8;
        line-height: 1.45;
        margin: 0;
    }

    .row-input-wrap {
        width: 100%;
    }

    /* INPUT CONTROLS */
    .wizard-input {
        width: 100%;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        padding: 10px 14px;
        font-size: 0.86rem;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
    }
    .wizard-input:focus {
        border-color: #00885a;
        box-shadow: 0 0 0 3px rgba(0, 136, 90, 0.12);
    }
    .wizard-input::placeholder {
        color: #94a3b8;
        font-size: 0.84rem;
    }

    .wizard-textarea {
        width: 100%;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        padding: 12px 14px;
        font-size: 0.86rem;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        resize: vertical;
        transition: all 0.2s ease;
        line-height: 1.55;
    }
    .wizard-textarea:focus {
        border-color: #00885a;
        box-shadow: 0 0 0 3px rgba(0, 136, 90, 0.12);
    }
    .wizard-textarea::placeholder {
        color: #94a3b8;
        font-size: 0.84rem;
    }

    /* RADIO LIST */
    .wizard-radio-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .wizard-radio-item {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        user-select: none;
        color: #334155;
        font-size: 0.84rem;
        font-weight: 500;
        margin: 0;
    }
    .wizard-radio-item input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #00885a;
        cursor: pointer;
        margin: 0;
    }

    /* SEGMENTED CARDS (1-20, 21-50, 50+) */
    .wizard-segmented-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        background: #ffffff;
    }
    .wizard-seg-card {
        padding: 14px 10px;
        text-align: center;
        cursor: pointer;
        border-right: 1.5px solid #e2e8f0;
        transition: all 0.18s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        background: #ffffff;
    }
    .wizard-seg-card:last-child {
        border-right: none;
    }
    .wizard-seg-card iconify-icon {
        font-size: 1.25rem;
        color: #64748b;
    }
    .wizard-seg-title {
        font-size: 0.82rem;
        font-weight: 600;
        color: #334155;
    }
    .wizard-seg-card.active {
        background: #e8f5ec;
        box-shadow: inset 0 0 0 1.5px #00885a;
        border-radius: 8px;
    }
    .wizard-seg-card.active iconify-icon,
    .wizard-seg-card.active .wizard-seg-title {
        color: #00885a;
        font-weight: 700;
    }

    /* ADDRESS STACK */
    .address-stack {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .address-grid-3 {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 10px;
    }

    /* UPLOAD DROPZONE */
    .wizard-upload-dropzone {
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 24px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .wizard-upload-dropzone:hover {
        border-color: #00885a;
        background: #f0fdf4;
    }

    /* REVIEW SUMMARY CARD ON STEP 5 */
    .review-summary-box {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 22px;
    }
    .review-item {
        display: flex;
        margin-bottom: 12px;
        font-size: 0.84rem;
    }
    .review-item:last-child {
        margin-bottom: 0;
    }
    .review-label {
        width: 180px;
        font-weight: 700;
        color: #475569;
        flex-shrink: 0;
    }
    .review-value {
        color: #0f172a;
        font-weight: 500;
        flex-grow: 1;
    }

    /* FOOTER BUTTONS BAR */
    .wizard-actions-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-step-prev {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        background: #ffffff;
        color: #475569;
        font-size: 0.86rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-step-prev:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .btn-step-next {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 28px;
        border: none;
        border-radius: 10px;
        background: #00885a;
        color: #ffffff;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(0, 136, 90, 0.25);
        transition: all 0.2s ease;
        margin-left: auto;
    }
    .btn-step-next:hover {
        background: #09724c;
        transform: translateY(-1.5px);
        box-shadow: 0 6px 18px rgba(0, 136, 90, 0.35);
        color: #ffffff;
    }
    .btn-step-next:active {
        transform: translateY(0);
    }

    .btn-step-submit {
        background: linear-gradient(135deg, #00885a 0%, #0d5c38 100%);
        padding: 12px 34px;
    }

    /* RESPONSIVE */
    @media (max-width: 767.98px) {
        .wizard-card {
            padding: 24px 18px;
            border-radius: 20px;
        }
        .wizard-form-row {
            grid-template-columns: 1fr;
            gap: 8px;
        }
        .address-grid-3 {
            grid-template-columns: 1fr;
        }
        .stepper-connector {
            width: 22px;
        }
        .stepper-label {
            display: none;
        }
        .review-item {
            flex-direction: column;
            gap: 4px;
        }
        .review-label {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="wizard-card-container">
    
    <div class="wizard-card shadow">

        <!-- TOP BAR: BACK TO DASHBOARD -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="fw-bold fs-3 mb-4 mt-2">
                Form Pelaporan Kegiatan Relawan
            </h2>
        </div>

        <!-- =======================================================
             HORIZONTAL STEPPER (Alur 5 Tahap seperti Gambar)
             ======================================================= -->
        <div class="wizard-stepper">
            <!-- Step 1 -->
            <div class="stepper-item active" id="stepperNode1" onclick="jumpToStep(1)">
                <div class="stepper-node">1</div>
                <span class="stepper-label">Informasi Aksi</span>
            </div>

            <div class="stepper-connector" id="stepperConn1"></div>

            <!-- Step 2 -->
            <div class="stepper-item" id="stepperNode2" onclick="jumpToStep(2)">
                <div class="stepper-node">2</div>
                <span class="stepper-label">Lokasi & Tim</span>
            </div>

            <div class="stepper-connector" id="stepperConn2"></div>

            <!-- Step 3 -->
            <div class="stepper-item" id="stepperNode3" onclick="jumpToStep(3)">
                <div class="stepper-node">3</div>
                <span class="stepper-label">Foto Aksi</span>
            </div>

            <div class="stepper-connector" id="stepperConn3"></div>

            <!-- Step 4 -->
            <div class="stepper-item" id="stepperNode4" onclick="jumpToStep(4)">
                <div class="stepper-node">4</div>
                <span class="stepper-label">Cerita Narasi</span>
            </div>

            <div class="stepper-connector" id="stepperConn4"></div>

            <!-- Step 5 -->
            <div class="stepper-item" id="stepperNode5" onclick="jumpToStep(5)">
                <div class="stepper-node">5</div>
                <span class="stepper-label">Review & Kirim</span>
            </div>
        </div>

        <!-- ERROR ALERTS -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-exclamation-circle-fill fs-5 text-danger mt-1"></i>
                    <div>
                        <strong>Mohon periksa isian formulir:</strong>
                        <ul class="mb-0 mt-1 ps-3 small">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- MAIN FORM WIZARD -->
        <form id="wizardForm" action="{{ $mode === 'edit' ? route('portal.berita.update', $detail->id) : route('portal.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- =======================================================
                 TAHAP 1: INFORMASI DASAR KEGIATAN
                 ======================================================= -->
            <div class="wizard-step-panel active" id="stepPanel1">
                <div class="step-header-area">
                    <h3 class="step-title">Informasi Dasar Kegiatan</h3>
                    <p class="step-subtitle">Tentukan judul liputan dan bidang program aksi kemanusiaan yang dilaksanakan.</p>
                </div>

                <!-- Judul Kegiatan -->
                <div class="wizard-form-row">
                    <div class="row-label-wrap">
                        <label class="row-main-label">Judul Berita / Kegiatan *</label>
                        <p class="row-help-desc">Tuliskan judul liputan aksi yang ringkas, jelas, dan menggambarkan kegiatan nyata.</p>
                    </div>
                    <div class="row-input-wrap">
                        <input type="text" 
                               class="wizard-input" 
                               name="title" 
                               id="inputTitle"
                               value="{{ old('title', @$detail->title) }}" 
                               placeholder="Contoh: Aksi Tanggap Banjir & Penyaluran 100 Paket Sembako Dhuafa" 
                               required>
                    </div>
                </div>

                <!-- Ringkasan Singkat -->
                <div class="wizard-form-row">
                    <div class="row-label-wrap">
                        <label class="row-main-label">Ringkasan & Latar Belakang</label>
                        <p class="row-help-desc">Gambaran singkat 1-2 paragraf mengenai latar belakang atau urgensi aksi sosial ini.</p>
                    </div>
                    <div class="row-input-wrap">
                        <textarea class="wizard-textarea" 
                                  name="ringkasan" 
                                  id="inputRingkasan"
                                  rows="3" 
                                  placeholder="Ceritakan secara singkat alasan diadakannya kegiatan ini...">{{ old('ringkasan') }}</textarea>
                    </div>
                </div>

                <!-- Kategori Program -->
                <div class="wizard-form-row">
                    <div class="row-label-wrap">
                        <label class="row-main-label">Bidang Program / Kategori *</label>
                        <p class="row-help-desc">Pilih kategori program kebaikan yang paling sesuai dengan misi kegiatan.</p>
                    </div>
                    <div class="row-input-wrap">
                        <div class="wizard-radio-list">
                            @php
                                $currentKat = old('kategori', @$detail->kategori ?? 'Tanggap Bencana Alam');
                                $defaultCategories = [
                                    'Tanggap Bencana Alam' => 'Tanggap Bencana Alam & Evakuasi Darurat',
                                    'Berbagi Pangan' => 'Berbagi Pangan & Sedekah Sembako Dhuafa',
                                    'Pendidikan & Dakwah' => 'Pendidikan, Dakwah & Bina Santri Yatim',
                                    'Santunan Yatim & Kesehatan' => 'Santunan Yatim & Layanan Kesehatan Dhuafa'
                                ];
                            @endphp

                            @foreach($defaultCategories as $val => $label)
                                <label class="wizard-radio-item">
                                    <input type="radio" 
                                           name="kategori" 
                                           value="{{ $val }}" 
                                           {{ $currentKat == $val ? 'checked' : '' }} 
                                           onchange="toggleNewKategori(false)">
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach

                            <label class="wizard-radio-item">
                                <input type="radio" 
                                       name="kategori" 
                                       value="__baru__" 
                                       id="radioKatBaru"
                                       {{ !in_array($currentKat, array_keys($defaultCategories)) && $currentKat ? 'checked' : '' }}
                                       onchange="toggleNewKategori(true)">
                                <span>Kategori Lainnya (Ketik Baru...)</span>
                            </label>

                            <div id="boxInputKategoriBaru" style="{{ !in_array($currentKat, array_keys($defaultCategories)) && $currentKat ? '' : 'display: none;' }}" class="mt-2">
                                <input type="text" 
                                       class="wizard-input" 
                                       name="kategori_baru" 
                                       id="inputKategoriBaru"
                                       value="{{ old('kategori_baru', !in_array($currentKat, array_keys($defaultCategories)) ? $currentKat : '') }}" 
                                       placeholder="Ketik nama kategori baru">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi Tahap 1 -->
                <div class="wizard-actions-bar">
                    <div></div>
                    <button type="button" class="btn-step-next" onclick="validateAndGoStep(1, 2)">
                        <span>Lanjutkan ke Lokasi & Tim</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- =======================================================
                 TAHAP 2: LOKASI & TIM RELAWAN
                 ======================================================= -->
            <div class="wizard-step-panel" id="stepPanel2">
                <div class="step-header-area">
                    <h3 class="step-title">Lokasi & Partisipasi Aksi</h3>
                    <p class="step-subtitle">Informasikan wilayah pelaksanaan dan perkiraan jumlah jiwa atau tim yang terlibat.</p>
                </div>

                <!-- Partisipasi (Segmented Cards 1-20, 21-49, 50+) -->
                <div class="wizard-form-row">
                    <div class="row-label-wrap">
                        <label class="row-main-label">Penerima Manfaat / Tim Terlibat</label>
                        <p class="row-help-desc">Estimasi jumlah warga atau relawan yang berpartisipasi dalam aksi ini.</p>
                    </div>
                    <div class="row-input-wrap">
                        <input type="hidden" name="estimasi_penerima" id="inputEstimasi" value="{{ old('estimasi_penerima', '1-20 Jiwa') }}">
                        
                        <div class="wizard-segmented-cards">
                            <div class="wizard-seg-card active" onclick="setEstimasi('1-20 Jiwa', this)">
                                <iconify-icon icon="lucide:user"></iconify-icon>
                                <span class="wizard-seg-title">1 - 20 Jiwa</span>
                            </div>
                            <div class="wizard-seg-card" onclick="setEstimasi('21-50 Jiwa', this)">
                                <iconify-icon icon="lucide:users"></iconify-icon>
                                <span class="wizard-seg-title">21 - 50 Jiwa</span>
                            </div>
                            <div class="wizard-seg-card" onclick="setEstimasi('50+ Jiwa', this)">
                                <iconify-icon icon="lucide:users-round"></iconify-icon>
                                <span class="wizard-seg-title">50+ Jiwa</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lokasi & Alamat Penyaluran -->
                <div class="wizard-form-row">
                    <div class="row-label-wrap">
                        <label class="row-main-label">Lokasi & Wilayah Aksi</label>
                        <p class="row-help-desc">Rincian tempat terlaksananya penyaluran bantuan atau posko aksi.</p>
                    </div>
                    <div class="row-input-wrap">
                        <div class="address-stack">
                            <select class="wizard-input" name="kota" id="inputKota">
                                <option value="">Pilih Kota / Kabupaten</option>
                                <option value="Kota Bandung" {{ old('kota') == 'Kota Bandung' ? 'selected' : '' }}>Kota Bandung</option>
                                <option value="Kabupaten Bandung" {{ old('kota') == 'Kabupaten Bandung' ? 'selected' : '' }}>Kabupaten Bandung</option>
                                <option value="Kota Cimahi" {{ old('kota') == 'Kota Cimahi' ? 'selected' : '' }}>Kota Cimahi</option>
                                <option value="Kabupaten Bandung Barat" {{ old('kota') == 'Kabupaten Bandung Barat' ? 'selected' : '' }}>Kabupaten Bandung Barat</option>
                                <option value="Kabupaten Sumedang" {{ old('kota') == 'Kabupaten Sumedang' ? 'selected' : '' }}>Kabupaten Sumedang</option>
                                <option value="Wilayah Bencana / Lainnya" {{ old('kota') == 'Wilayah Bencana / Lainnya' ? 'selected' : '' }}>Wilayah Bencana / Lainnya</option>
                            </select>

                            <input type="text" 
                                   class="wizard-input" 
                                   name="lokasi_line1" 
                                   id="inputLokasiLine1"
                                   value="{{ old('lokasi_line1') }}" 
                                   placeholder="Nama Titik Lokasi / Posko Penyaluran (Contoh: Posko Tanggap Banjir RW 04)">

                            <input type="text" 
                                   class="wizard-input" 
                                   name="lokasi_line2" 
                                   value="{{ old('lokasi_line2') }}" 
                                   placeholder="Detail Alamat / Nama Jalan / Dusun">

                            <div class="address-grid-3">
                                <input type="text" class="wizard-input" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Kecamatan">
                                <input type="text" class="wizard-input" name="kelurahan" value="{{ old('kelurahan') }}" placeholder="Kelurahan / Desa">
                                <input type="text" class="wizard-input" name="kodepos" value="{{ old('kodepos') }}" placeholder="Kode Pos">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi Tahap 2 -->
                <div class="wizard-actions-bar">
                    <button type="button" class="btn-step-prev" onclick="goStep(1)">
                        <i class="bi bi-arrow-left"></i>
                        <span>Sebelumnya</span>
                    </button>
                    <button type="button" class="btn-step-next" onclick="validateAndGoStep(2, 3)">
                        <span>Lanjutkan ke Foto Aksi</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- =======================================================
                 TAHAP 3: DOKUMENTASI FOTO KEGIATAN
                 ======================================================= -->
            <div class="wizard-step-panel" id="stepPanel3">
                <div class="step-header-area">
                    <h3 class="step-title">Dokumentasi Foto Lapangan</h3>
                    <p class="step-subtitle">Unggah foto dokumentasi kegiatan yang jernih sebagai bukti aksi nyata bagi para donatur.</p>
                </div>

                <div class="wizard-form-row">
                    <div class="row-label-wrap">
                        <label class="row-main-label">Foto Utama Kegiatan {{ $mode === 'edit' ? '(Opsional)' : '*' }}</label>
                        <p class="row-help-desc">Pilih foto terbaik berorientasi landscape (Maksimal 2 MB, format JPG/PNG/WEBP).</p>
                    </div>
                    <div class="row-input-wrap">
                        <label class="wizard-upload-dropzone d-block" for="inputFotoKegiatan">
                            <div class="d-flex flex-column align-items-center justify-content-center py-2">
                                <iconify-icon icon="solar:camera-minimalistic-bold-duotone" style="font-size: 2.6rem; color: #00885a;"></iconify-icon>
                                <span class="fw-bold mt-2 text-dark" style="font-size: 0.88rem;">Pilih Foto Dokumentasi Lapangan</span>
                                <span class="text-muted small mt-1">Klik di sini untuk upload foto kegiatan</span>
                            </div>
                            <input type="file" 
                                   id="inputFotoKegiatan" 
                                   class="d-none" 
                                   name="featured_img" 
                                   accept="image/*" 
                                   {{ $mode === 'edit' ? '' : 'required' }} 
                                   onchange="previewPhoto(this)">
                        </label>

                        <div id="boxPhotoPreview" class="mt-3 text-center" style="{{ @$detail->featured_img ? '' : 'display: none;' }}">
                            <img id="imgPreviewTarget" 
                                 src="{{ @$detail->featured_img ? asset($detail->featured_img) : '#' }}" 
                                 alt="Preview Dokumentasi" 
                                 style="max-height: 220px; width: 100%; object-fit: cover; border-radius: 12px; border: 1.5px solid #e2e8f0;">
                            <div class="small text-muted mt-1"><i class="bi bi-check-circle-fill text-success me-1"></i> Foto siap diunggah</div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi Tahap 3 -->
                <div class="wizard-actions-bar">
                    <button type="button" class="btn-step-prev" onclick="goStep(2)">
                        <i class="bi bi-arrow-left"></i>
                        <span>Sebelumnya</span>
                    </button>
                    <button type="button" class="btn-step-next" onclick="validateAndGoStep(3, 4)">
                        <span>Lanjutkan ke Cerita Narasi</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- =======================================================
                 TAHAP 4: LAPORAN & CERITA LENGKAP
                 ======================================================= -->
            <div class="wizard-step-panel" id="stepPanel4">
                <div class="step-header-area">
                    <h3 class="step-title">Cerita & Laporan Lengkap</h3>
                    <p class="step-subtitle">Tuangkan kronologi aksi, kehangatan suasana di lapangan, serta ucapan terima kasih bagi donatur.</p>
                </div>

                <!-- Konten Narasi -->
                <div class="wizard-form-row">
                    <div class="row-label-wrap">
                        <label class="row-main-label">Isi Cerita & Laporan *</label>
                        <p class="row-help-desc">Ceritakan kronologi, sambutan warga penerima manfaat, dan dampak positif kegiatan.</p>
                    </div>
                    <div class="row-input-wrap">
                        <textarea class="wizard-textarea" 
                                  name="content" 
                                  id="inputContent"
                                  rows="8" 
                                  placeholder="Ceritakan jalannya aksi secara detail, suasana haru di lapangan, bagaimana penyaluran bantuan dilakukan, dan ucapan syukur dari para penerima manfaat..." 
                                  required>{{ old('content', @$detail->content) }}</textarea>
                    </div>
                </div>

                <!-- Hashtag -->
                <div class="wizard-form-row">
                    <div class="row-label-wrap">
                        <label class="row-main-label">Hashtag / Kata Kunci</label>
                        <p class="row-help-desc">Gunakan hashtag untuk mengelompokkan dokumentasi aksi di website.</p>
                    </div>
                    <div class="row-input-wrap">
                        <input type="text" 
                               class="wizard-input" 
                               name="hashtag" 
                               id="inputHashtag"
                               value="{{ old('hashtag', @$detail->hashtag) }}" 
                               placeholder="#SahabatBaik #TanggapBencana #PeduliMenjagaGenerasi">
                    </div>
                </div>

                <!-- Tombol Navigasi Tahap 4 -->
                <div class="wizard-actions-bar">
                    <button type="button" class="btn-step-prev" onclick="goStep(3)">
                        <i class="bi bi-arrow-left"></i>
                        <span>Sebelumnya</span>
                    </button>
                    <button type="button" class="btn-step-next" onclick="validateAndGoStep(4, 5)">
                        <span>Review & Konfirmasi</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- =======================================================
                 TAHAP 5: REVIEW & KONFIRMASI KIRIM
                 ======================================================= -->
            <div class="wizard-step-panel" id="stepPanel5">
                <div class="step-header-area">
                    <h3 class="step-title">Review & Konfirmasi Laporan</h3>
                    <p class="step-subtitle">Periksa kembali ringkasan laporan kegiatan sebelum dikirimkan ke Admin Graha Dhuafa Indonesia.</p>
                </div>

                <!-- Box Pratinjau Ringkasan -->
                <div class="review-summary-box">
                    <div class="review-item">
                        <div class="review-label">Judul Kegiatan:</div>
                        <div class="review-value fw-bold text-dark" id="revTitle">-</div>
                    </div>
                    <div class="review-item">
                        <div class="review-label">Kategori Program:</div>
                        <div class="review-value" id="revKategori">-</div>
                    </div>
                    <div class="review-item">
                        <div class="review-label">Penerima / Partisipasi:</div>
                        <div class="review-value" id="revEstimasi">-</div>
                    </div>
                    <div class="review-item">
                        <div class="review-label">Lokasi Kegiatan:</div>
                        <div class="review-value" id="revLokasi">-</div>
                    </div>
                    <div class="review-item">
                        <div class="review-label">Status Draft:</div>
                        <div class="review-value text-success fw-bold">
                            <i class="bi bi-shield-lock-fill me-1"></i> Otomatis Masuk Draft Review Admin
                        </div>
                    </div>
                </div>

                <!-- Checkbox Konfirmasi Integritas Laporan -->
                <div class="mb-4 p-3 bg-light rounded-3 border">
                    <label class="d-flex align-items-center gap-2 cursor-pointer mb-0">
                        <input type="checkbox" name="pernyataan_valid" value="1" style="width: 18px; height: 18px; accent-color: #00885a;" required checked>
                        <span class="small fw-semibold text-secondary">
                            Saya menyatakan bahwa dokumentasi foto dan laporan ini adalah kegiatan nyata yang terlaksana secara amanah dan bertanggung jawab.
                        </span>
                    </label>
                </div>

                <!-- Tombol Navigasi Tahap 5 -->
                <div class="wizard-actions-bar">
                    <button type="button" class="btn-step-prev" onclick="goStep(4)">
                        <i class="bi bi-arrow-left"></i>
                        <span>Edit Cerita</span>
                    </button>
                    <button type="submit" class="btn-step-next btn-step-submit">
                        <i class="bi bi-send-check-fill"></i>
                        <span>{{ $mode === 'edit' ? 'Simpan Perubahan Laporan' : 'Kirim Laporan Kegiatan' }}</span>
                    </button>
                </div>
            </div>

        </form>

    </div>

</div>
@endsection

@push('scripts')
<script>
    let currentStep = 1;
    const totalSteps = 5;

    function goStep(step) {
        if (step < 1 || step > totalSteps) return;

        // Hide all panels
        document.querySelectorAll('.wizard-step-panel').forEach(panel => {
            panel.classList.remove('active');
        });

        // Show target panel
        const targetPanel = document.getElementById('stepPanel' + step);
        if (targetPanel) {
            targetPanel.classList.add('active');
        }

        // Update stepper nodes and connectors
        for (let i = 1; i <= totalSteps; i++) {
            const node = document.getElementById('stepperNode' + i);
            const conn = document.getElementById('stepperConn' + (i - 1));

            if (node) {
                node.classList.remove('active', 'completed');
                if (i < step) {
                    node.classList.add('completed');
                    node.querySelector('.stepper-node').innerHTML = '<i class="bi bi-check-lg text-success"></i>';
                } else if (i === step) {
                    node.classList.add('active');
                    node.querySelector('.stepper-node').innerText = i;
                } else {
                    node.querySelector('.stepper-node').innerText = i;
                }
            }

            if (conn) {
                if (i <= step) {
                    conn.classList.add('completed');
                } else {
                    conn.classList.remove('completed');
                }
            }
        }

        currentStep = step;

        // Populate Review Summary on Step 5
        if (step === 5) {
            populateReviewSummary();
        }

        // Scroll to card top smoothly
        document.querySelector('.wizard-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function validateAndGoStep(fromStep, toStep) {
        // Validate inputs in current step panel
        const panel = document.getElementById('stepPanel' + fromStep);
        const inputs = panel.querySelectorAll('input[required], select[required], textarea[required]');
        
        let isValid = true;
        for (let input of inputs) {
            if (!input.checkValidity()) {
                input.reportValidity();
                isValid = false;
                break;
            }
        }

        if (isValid) {
            goStep(toStep);
        }
    }

    function jumpToStep(step) {
        // Only allow jumping to previously completed steps or current step
        if (step <= currentStep) {
            goStep(step);
        }
    }

    function populateReviewSummary() {
        const title = document.getElementById('inputTitle').value || '-';
        document.getElementById('revTitle').innerText = title;

        // Selected Kategori
        let kat = '';
        const radioChecked = document.querySelector('input[name="kategori"]:checked');
        if (radioChecked) {
            if (radioChecked.value === '__baru__') {
                kat = document.getElementById('inputKategoriBaru').value || 'Kategori Baru';
            } else {
                kat = radioChecked.value;
            }
        }
        document.getElementById('revKategori').innerText = kat || '-';

        // Estimasi
        document.getElementById('revEstimasi').innerText = document.getElementById('inputEstimasi').value || '-';

        // Lokasi
        const kota = document.getElementById('inputKota').value;
        const line1 = document.getElementById('inputLokasiLine1').value;
        const lokasiArr = [line1, kota].filter(Boolean);
        document.getElementById('revLokasi').innerText = lokasiArr.join(', ') || 'Lokasi Belum Diisi';
    }

    function setEstimasi(val, el) {
        document.getElementById('inputEstimasi').value = val;
        document.querySelectorAll('.wizard-seg-card').forEach(card => card.classList.remove('active'));
        el.classList.add('active');
    }

    function toggleNewKategori(isCustom) {
        const box = document.getElementById('boxInputKategoriBaru');
        if (isCustom) {
            box.style.display = 'block';
            document.getElementById('inputKategoriBaru').focus();
        } else {
            box.style.display = 'none';
        }
    }

    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreviewTarget').src = e.target.result;
                document.getElementById('boxPhotoPreview').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
