@extends('layout.layout-page', ['active' => $active])

@section('title', $pageTitle)

@section('style')
<link href="{{ asset('website/assets/css/page.css') }}" rel="stylesheet"/>
<style>
    .calc-zakat-section {
        padding: 60px 0 80px;
        background: #f8faf9;
    }
    .calc-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(10, 74, 46, 0.08);
        border: 1px solid #e1ece6;
        overflow: hidden;
    }
    .calc-card-header {
        background: linear-gradient(135deg, #06301f 0%, #0d5c38 100%);
        color: #ffffff;
        padding: 24px 30px;
    }
    .calc-card-body {
        padding: 35px 30px;
    }
    .calc-tabs {
        display: flex;
        gap: 10px;
        background: #edf5f0;
        padding: 6px;
        border-radius: 12px;
        margin-bottom: 30px;
    }
    .calc-tab-item {
        flex: 1;
        text-align: center;
        padding: 12px 16px;
        border-radius: 9px;
        font-weight: 700;
        font-size: 14px;
        color: #2b5742;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .calc-tab-item.active {
        background: #0d5c38;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(13, 92, 56, 0.25);
    }
    .calc-tab-item:hover:not(.active) {
        background: rgba(13, 92, 56, 0.08);
    }
    .form-calc-label {
        font-weight: 600;
        font-size: 13.5px;
        color: #2c3e50;
        margin-bottom: 6px;
        display: block;
    }
    .calc-input-group {
        position: relative;
        margin-bottom: 18px;
    }
    .calc-input-group .prefix {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #7f8c8d;
        font-weight: 600;
        font-size: 14px;
        z-index: 5;
        pointer-events: none;
    }
    .calc-input-group .form-control {
        padding: 11px 16px 11px 45px;
        border-radius: 10px;
        border: 1px solid #d4e3dc;
        font-size: 14px;
        font-weight: 600;
        color: #1e272e;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .calc-input-group .form-control:focus {
        border-color: #0d5c38;
        box-shadow: 0 0 0 3px rgba(13, 92, 56, 0.15);
        outline: none;
    }
    .calc-help-text {
        font-size: 12px;
        color: #636e72;
        margin-top: -12px;
        margin-bottom: 16px;
    }
    .calc-result-box {
        background: #f1f8f4;
        border: 2px dashed #a3d9bc;
        border-radius: 14px;
        padding: 24px;
        margin-top: 10px;
    }
    .calc-result-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #576574;
        margin-bottom: 12px;
    }
    .calc-total-amount {
        font-size: 32px;
        font-weight: 800;
        color: #0d5c38;
        line-height: 1.2;
        margin-bottom: 15px;
    }
    .calc-status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12.5px;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .badge-wajib {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .badge-belum {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }
    .badge-waiting {
        background: #e2e3e5;
        color: #383d41;
    }
    .btn-tunaikan {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 14px 20px;
        background: linear-gradient(135deg, #10b981 0%, #0d5c38 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 15px;
        border-radius: 10px;
        border: none;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 15px rgba(13, 92, 56, 0.25);
    }
    .btn-tunaikan:hover {
        background: linear-gradient(135deg, #0d5c38 0%, #06301f 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 92, 56, 0.35);
    }
    .btn-tunaikan:disabled {
        background: #bdc3c7;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }
    .info-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 22px;
        border: 1px solid #e1ece6;
        margin-top: 25px;
    }
    .info-card h5 {
        color: #0d5c38;
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 12px;
    }
    .info-card ul {
        padding-left: 20px;
        margin-bottom: 0;
        font-size: 13.5px;
        color: #4b6584;
        line-height: 1.7;
    }
</style>
@endsection

@section('breadcrumb')
<ul class="thm-breadcrumb list-unstyled">
    <li><a href="/">Beranda</a></li>
    <li><span>/</span></li>
    <li>{{ @$detail->title ?? 'Kalkulator Zakat' }}</li>
</ul>
<h2>{{ @$detail->title ?? 'Kalkulator Zakat' }}</h2>
@endsection

@section('pageGeneral')
<section class="calc-zakat-section">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="text-uppercase fw-bold" style="color: #0d5c38; font-size: 13px; letter-spacing: 1px;">Kalkulator Zakat GDI</span>
                <h3 class="fw-bold mt-1 mb-2" style="color: #1e272e;">Hitung Kewajiban Zakat Anda</h3>
                <p class="text-muted" style="font-size: 14.5px;">
                    Ketahui status kewajiban dan hitung nominal zakat Anda secara akurat sesuai nishab dan haul berdasarkan Fatwa MUI.
                </p>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Form Kalkulator (Kiri) -->
            <div class="col-lg-7">
                <div class="calc-card">
                    <div class="calc-card-header">
                        <h4 class="mb-1 text-white fw-bold" style="font-size: 18px;"><i class="fa fa-calculator me-2"></i> Formulir Perhitungan</h4>
                        <small class="text-white-50">Pilih jenis zakat dan isi data finansial Anda</small>
                    </div>

                    <div class="calc-card-body">
                        <!-- Pilihan Tab Jenis Zakat -->
                        <div class="calc-tabs">
                            <button type="button" class="calc-tab-item active" data-type="profesi">
                                <i class="fa fa-briefcase me-1"></i> Zakat Profesi
                            </button>
                            <button type="button" class="calc-tab-item" data-type="maal">
                                <i class="fa fa-coins me-1"></i> Zakat Maal
                            </button>
                            <button type="button" class="calc-tab-item" data-type="fitrah">
                                <i class="fa fa-users me-1"></i> Zakat Fitrah
                            </button>
                        </div>

                        <!-- 1. Form Zakat Profesi -->
                        <div id="tab-calc-profesi" class="calc-tab-content">
                            <div class="alert alert-light border mb-4" style="font-size: 13px; background: #fafdfb;">
                                <strong>Ketentuan Nishab Profesi:</strong> Setara <strong>85 gram emas/tahun</strong> atau seperduabelas dari 85 gram emas/bulan (Fatwa MUI No. 3 Th 2003). Kadar zakat yang wajib dikeluarkan sebesar <strong>2,5%</strong> dari penghasilan bersih.
                            </div>

                            <label class="form-calc-label">Harga Emas per Gram Saat Ini</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="p_harga_emas" value="1.450.000">
                            </div>
                            <div class="calc-help-text">
                                Nilai Nishab Bulanan: <strong class="text-dark" id="p_nisab_text">Rp 10.270.833</strong> (85 gr emas ÷ 12)
                            </div>

                            <label class="form-calc-label">Penghasilan / Gaji Pokok per Bulan</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="p_gaji" placeholder="0">
                            </div>

                            <label class="form-calc-label">Penghasilan Tambahan (Bonus, THR, Komisi, dll)</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="p_bonus" placeholder="0">
                            </div>

                            <label class="form-calc-label">Pengeluaran Rutin / Cicilan Kebutuhan Pokok per Bulan</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="p_hutang" placeholder="0">
                            </div>
                            <div class="calc-help-text">Pengeluaran untuk kebutuhan pokok hidup sehari-hari / cicilan wajib.</div>
                        </div>

                        <!-- 2. Form Zakat Maal -->
                        <div id="tab-calc-maal" class="calc-tab-content" style="display: none;">
                            <div class="alert alert-light border mb-4" style="font-size: 13px; background: #fafdfb;">
                                <strong>Ketentuan Zakat Maal:</strong> Harta yang dimiliki telah mencapai nishab setara <strong>85 gram emas</strong> dan telah tersimpan/dimiliki selama <strong>1 tahun penuh (haul)</strong>. Zakat yang dikeluarkan sebesar <strong>2,5%</strong>.
                            </div>

                            <label class="form-calc-label">Harga Emas per Gram Saat Ini</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="m_harga_emas" value="1.450.000">
                            </div>
                            <div class="calc-help-text">
                                Nilai Nishab Tahunan: <strong class="text-dark" id="m_nisab_text">Rp 123.250.000</strong> (setara 85 gr emas)
                            </div>

                            <label class="form-calc-label">Nilai Tabungan / Kas / Deposito</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="m_tabungan" placeholder="0">
                            </div>

                            <label class="form-calc-label">Nilai Emas / Logam Mulia / Perhiasan Tersimpan</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="m_emas" placeholder="0">
                            </div>

                            <label class="form-calc-label">Nilai Aset Lancar Lainnya (Saham, Piutang Lancar, Surat Berharga)</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="m_aset" placeholder="0">
                            </div>

                            <label class="form-calc-label">Hutang / Cicilan Jatuh Tempo Saat Haul 1 Tahun</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="m_hutang" placeholder="0">
                            </div>
                        </div>

                        <!-- 3. Form Zakat Fitrah -->
                        <div id="tab-calc-fitrah" class="calc-tab-content" style="display: none;">
                            <div class="alert alert-light border mb-4" style="font-size: 13px; background: #fafdfb;">
                                <strong>Ketentuan Zakat Fitrah:</strong> Wajib ditunaikan bagi setiap jiwa muslim pada bulan Ramadhan hingga menjelang shalat Idul Fitri senilai <strong>2,5 kg atau 3,5 liter beras</strong> per jiwa (atau senilai uang).
                            </div>

                            <label class="form-calc-label">Harga Beras per Jiwa (setara 2,5 kg)</label>
                            <div class="calc-input-group">
                                <span class="prefix">Rp</span>
                                <input type="text" class="form-control money-input calc-field" id="f_harga_beras" value="45.000">
                            </div>
                            <div class="calc-help-text">Standar BAZNAS / LAZ: ± Rp 45.000 / jiwa.</div>

                            <label class="form-calc-label">Jumlah Jiwa yang Ditunaikan Zakatnya</label>
                            <div class="calc-input-group">
                                <input type="number" min="1" max="100" class="form-control calc-field ps-3" id="f_jiwa" value="1">
                            </div>
                            <div class="calc-help-text">Termasuk diri sendiri dan anggota keluarga yang menjadi tanggungan.</div>
                        </div>

                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-sm btn-link text-muted text-decoration-none" id="btnResetCalc">
                                <i class="fa fa-undo me-1"></i> Reset Nilai Input
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Hasil & CTA (Kanan) -->
            <div class="col-lg-5">
                <div class="calc-result-box">
                    <div class="calc-result-title"><i class="fa fa-chart-pie me-1"></i> Ringkasan Perhitungan</div>
                    
                    <div class="mb-3">
                        <span id="res_badge" class="calc-status-badge badge-waiting">Menunggu Input Data</span>
                    </div>

                    <div id="res_desc" class="text-secondary small mb-3" style="line-height: 1.6;">
                        Silakan masukkan rincian penghasilan atau harta Anda pada formulir di sebelah kiri.
                    </div>

                    <hr style="border-color: #c0decb;">

                    <div class="mb-1 text-muted" style="font-size: 13px; font-weight: 600;">Kewajiban Zakat Anda:</div>
                    <div class="calc-total-amount" id="res_total_zakat">Rp 0</div>

                    <button type="button" class="btn-tunaikan" id="btnPayZakat" disabled>
                        <i class="fa fa-hand-holding-heart me-2"></i> Tunaikan Zakat Sekarang
                    </button>
                    <div class="text-center mt-2">
                        <small class="text-muted" style="font-size: 11.5px;">
                            <i class="fa fa-shield-alt text-success me-1"></i> Amanah, tepat sasaran, & berizin resmi Kemenag
                        </small>
                    </div>
                </div>

                <!-- Card Informasi Tambahan -->
                <div class="info-card">
                    <h5><i class="fa fa-info-circle me-1"></i> Kenapa Membayar Zakat?</h5>
                    <ul>
                        <li>Membersihkan harta dan menyucikan jiwa muzakki.</li>
                        <li>Mempererat tali silaturahmi & kepedulian sosial bagi kaum dhuafa.</li>
                        <li>Membantu 8 golongan mustahik yang berhak menerima zakat.</li>
                    </ul>
                    <div class="mt-3 pt-2 border-top">
                        <a href="{{ url('app/zakat/informasi') }}" class="small text-success fw-bold text-decoration-none">
                            Pelajari selengkapnya tentang zakat &raquo;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
$(function(){
    var currentType = 'profesi';

    function formatRupiah(num) {
        if (isNaN(num)) return '0';
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function parseRupiah(val) {
        if (!val) return 0;
        var clean = val.toString().replace(/\D/g, '');
        return clean ? parseFloat(clean) : 0;
    }

    // Format input angka ribuan saat mengetik
    $(document).on('keyup', '.money-input', function(){
        var clean = parseRupiah($(this).val());
        if (clean > 0) {
            $(this).val(formatRupiah(clean));
        } else {
            $(this).val('');
        }
    });

    function updateNisabPreview() {
        var emasP = parseRupiah($('#p_harga_emas').val()) || 1450000;
        var nisabBulan = Math.round((85 * emasP) / 12);
        $('#p_nisab_text').text('Rp ' + formatRupiah(nisabBulan));

        var emasM = parseRupiah($('#m_harga_emas').val()) || 1450000;
        var nisabTahun = 85 * emasM;
        $('#m_nisab_text').text('Rp ' + formatRupiah(nisabTahun));
    }

    function hitung() {
        updateNisabPreview();
        var zakat = 0;
        var isWajib = false;

        if (currentType === 'profesi') {
            var emasP = parseRupiah($('#p_harga_emas').val()) || 1450000;
            var nisabBulan = Math.round((85 * emasP) / 12);
            var gaji = parseRupiah($('#p_gaji').val());
            var bonus = parseRupiah($('#p_bonus').val());
            var hutang = parseRupiah($('#p_hutang').val());
            var net = (gaji + bonus) - hutang;

            if (gaji === 0 && bonus === 0) {
                $('#res_badge').attr('class', 'calc-status-badge badge-waiting').text('Menunggu Input Data');
                $('#res_desc').html('Masukkan nominal penghasilan bulanan Anda pada formulir.');
                zakat = 0;
                isWajib = false;
            } else if (net >= nisabBulan) {
                zakat = Math.round(net * 0.025);
                $('#res_badge').attr('class', 'calc-status-badge badge-wajib').html('<i class="fa fa-check-circle me-1"></i> Wajib Zakat');
                $('#res_desc').html('Alhamdulillah, penghasilan bersih Anda sebesar <strong>Rp ' + formatRupiah(net) + '</strong> telah mencapai nishab bulanan (Rp ' + formatRupiah(nisabBulan) + '). Anda wajib menunaikan zakat profesi sebesar <strong>2,5%</strong>.');
                isWajib = true;
            } else {
                zakat = 0;
                $('#res_badge').attr('class', 'calc-status-badge badge-belum').html('<i class="fa fa-info-circle me-1"></i> Belum Wajib Zakat');
                var sisa = net > 0 ? 'Penghasilan bersih Anda (Rp ' + formatRupiah(net) + ')' : 'Penghasilan Anda';
                $('#res_desc').html(sisa + ' belum mencapai batas nishab bulanan (Rp ' + formatRupiah(nisabBulan) + '). Anda belum wajib zakat, namun tetap disunnahkan untuk berinfaq dan bersedekah.');
                isWajib = false;
            }
        } else if (currentType === 'maal') {
            var emasM = parseRupiah($('#m_harga_emas').val()) || 1450000;
            var nisabTahun = 85 * emasM;
            var tabungan = parseRupiah($('#m_tabungan').val());
            var emasHarta = parseRupiah($('#m_emas').val());
            var aset = parseRupiah($('#m_aset').val());
            var hutangM = parseRupiah($('#m_hutang').val());
            var totalHarta = (tabungan + emasHarta + aset) - hutangM;

            if (tabungan === 0 && emasHarta === 0 && aset === 0) {
                $('#res_badge').attr('class', 'calc-status-badge badge-waiting').text('Menunggu Input Data');
                $('#res_desc').html('Masukkan nilai tabungan, emas, atau aset lancar Anda.');
                zakat = 0;
                isWajib = false;
            } else if (totalHarta >= nisabTahun) {
                zakat = Math.round(totalHarta * 0.025);
                $('#res_badge').attr('class', 'calc-status-badge badge-wajib').html('<i class="fa fa-check-circle me-1"></i> Wajib Zakat');
                $('#res_desc').html('Alhamdulillah, total harta bersih Anda sebesar <strong>Rp ' + formatRupiah(totalHarta) + '</strong> telah mencapai nishab tahunan (Rp ' + formatRupiah(nisabTahun) + ') dan haul 1 tahun. Anda wajib menunaikan zakat maal sebesar <strong>2,5%</strong>.');
                isWajib = true;
            } else {
                zakat = 0;
                $('#res_badge').attr('class', 'calc-status-badge badge-belum').html('<i class="fa fa-info-circle me-1"></i> Belum Wajib Zakat');
                var sisaM = totalHarta > 0 ? 'Total harta bersih Anda (Rp ' + formatRupiah(totalHarta) + ')' : 'Harta Anda';
                $('#res_desc').html(sisaM + ' belum mencapai batas nishab tahunan (Rp ' + formatRupiah(nisabTahun) + '). Anda belum wajib zakat maal.');
                isWajib = false;
            }
        } else if (currentType === 'fitrah') {
            var beras = parseRupiah($('#f_harga_beras').val()) || 45000;
            var jiwa = parseInt($('#f_jiwa').val()) || 1;
            zakat = jiwa * beras;
            $('#res_badge').attr('class', 'calc-status-badge badge-wajib').html('<i class="fa fa-check-circle me-1"></i> Wajib Zakat Fitrah');
            $('#res_desc').html('Zakat fitrah untuk <strong>' + jiwa + ' jiwa</strong> (' + jiwa + ' × Rp ' + formatRupiah(beras) + '). Wajib ditunaikan bagi setiap jiwa yang hidup pada bulan Ramadhan.');
            isWajib = true;
        }

        $('#res_total_zakat').text('Rp ' + formatRupiah(zakat)).data('raw', zakat);
        $('#btnPayZakat').prop('disabled', !isWajib || zakat <= 0);
    }

    // Switch tab
    $('.calc-tab-item').click(function(){
        var type = $(this).data('type');
        currentType = type;
        $('.calc-tab-item').removeClass('active');
        $(this).addClass('active');

        $('.calc-tab-content').hide();
        $('#tab-calc-' + type).fadeIn(200);

        hitung();
    });

    // Realtime input listener
    $(document).on('keyup input change', '.calc-field', function(){
        hitung();
    });

    // Tombol Tunaikan Zakat Sekarang
    $('#btnPayZakat').click(function(){
        var rawZakat = $('#res_total_zakat').data('raw') || 0;
        if (rawZakat > 0) {
            window.location.href = '/app/zakat/tunaikan?jenis=' + currentType + '&nominal=' + rawZakat;
        }
    });

    // Reset Form
    $('#btnResetCalc').click(function(){
        $('.calc-tab-content input').not('#p_harga_emas, #m_harga_emas, #f_harga_beras, #f_jiwa').val('');
        hitung();
    });

    // Inisialisasi awal
    hitung();
});
</script>
@endpush

