@extends('layout.payment-layout', ['title' => 'Kalkulator Zakat'])

@section('content')
<div class="oc-card">
    <form>
        <input type="hidden" name="zakat_type" value="profesi"/>
        <input type="hidden" id="opsi_nisab" value="emas"/>
        <div class="oc-card-section oc-card-header oc-back oc-cursor" data-url="{{ url('app/zakat') }}">
            <i class="bi-arrow-left"></i> Kalkulator Zakat
        </div>
        <div class="oc-card-section">
            <div class="form-group">
                <label class="oc-text-title">Pilihan Zakat</label>
                <p>Kalkulator zakat memudahkan Anda dalam mengetahui status wajib zakat dan menghitung nominal zakat yang wajib dikeluarkan.</p>
                <div class="oc-container">
                    <nav class="nav nav-pills nav-justified">
                        <a class="nav-link active get-zakat-type" data-value="profesi" aria-current="page" href="javascript:void(0)">Zakat Profesi</a>
                        <a class="nav-link get-zakat-type" data-value="maal" href="javascript:void(0)">Zakat Maal</a>
                        <a class="nav-link get-zakat-type" data-value="fitrah" href="javascript:void(0)">Zakat Fitrah</a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="oc-card-divider"></div>

        <div class="oc-card-section">
            <div class="form-group">
                <div class="nishab-profesi">
                    <label class="oc-text-title">Nishab Zakat Profesi</label>
                    <ul class="mb-2">
                        <li>Nishab adalah batas minimal pendapatan wajib zakat.</li>
                        <li>Nishab zakat profesi sebesar <strong>85 gram emas/tahun</strong> atau seperduabelas dari 85 gram emas/bulan (Fatwa MUI no. 3 tahun 2003).</li>
                    </ul>
                </div>
                <div class="nishab-maal" style="display: none">
                    <label class="oc-text-title">Nishab & Haul Zakat Maal</label>
                    <ul class="mb-2">
                        <li>Nishab zakat maal sebesar <strong>85 gram emas</strong>.</li>
                        <li>Haul merupakan kepemilikan harta yang telah mencapai <strong>1 tahun penuh</strong>.</li>
                    </ul>
                </div>
                <div class="nishab-fitrah" style="display: none">
                    <label class="oc-text-title">Ketentuan Zakat Fitrah</label>
                    <ul class="mb-2">
                        <li>Zakat fitrah wajib bagi setiap jiwa muslim yang hidup pada bulan Ramadhan.</li>
                        <li>Besaran zakat fitrah setara <strong>2,5 kg atau 3,5 liter beras</strong> per jiwa (atau senilai uang).</li>
                    </ul>
                </div>
                
                <div class="nishab-emas-group">
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Harga Emas per Gram saat ini</label>
                        <div class="oc-input-group-sm mb-3">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money" inputmode="numeric" id="harga_emas" value="1.450.000" onkeyup="nisab_emas(); hitung_zakat()" name="gold_price" required placeholder="0">
                        </div>
                    </div>
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Nilai Nishab Tahunan (85 gr emas)</label>
                        <div class="oc-input-group-sm mb-1">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money disabled" inputmode="numeric" data-value="" id="nisab" readonly name="nilai_nishab" required placeholder="0">
                            <input type="hidden" id="nisab_float" value="123250000" />
                        </div>
                        <small class="text-muted"><i>Perhitungan nishab setara 85 gram emas murni</i></small>
                    </div>
                </div>
            </div>
        </div>

        <div class="oc-card-divider"></div>

        <div class="oc-card-section">
            <div class="form-group">
                <label class="oc-text-title">Perhitungan Zakat</label>
                <p class="desc-profesi">Zakat profesi dihitung 2,5% dari penghasilan bersih bulanan yang telah mencapai nishab.</p>
                <p class="desc-maal" style="display: none">Zakat maal dihitung 2,5% dari total harta bersih yang telah mencapai nishab dan haul 1 tahun.</p>
                <p class="desc-fitrah" style="display: none">Zakat fitrah dihitung dari perkalian jumlah jiwa dengan harga beras per jiwa.</p>
                
                <!-- Form Maal -->
                <div class="form-maal" style="display: none">
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Nilai harta dalam bentuk tabungan / kas / deposito</label>
                        <div class="oc-input-group-sm mb-3">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money" inputmode="numeric" name="value_treasure_saving" onkeyup="hitung_zakat()" placeholder="0">
                        </div>
                    </div>
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Nilai harta dalam bentuk emas / perhiasan / logam mulia</label>
                        <div class="oc-input-group-sm mb-3">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money" inputmode="numeric" name="value_treasure_gold" onkeyup="hitung_zakat()" placeholder="0">
                        </div>
                    </div>
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Nilai harta lainnya (saham, surat berharga, piutang lancar)</label>
                        <div class="oc-input-group-sm mb-3">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money" inputmode="numeric" name="value_treasure_other" onkeyup="hitung_zakat()" placeholder="0">
                        </div>
                    </div>
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Hutang / cicilan jatuh tempo saat haul 1 tahun</label>
                        <div class="oc-input-group-sm mb-3">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money" inputmode="numeric" name="value_treasure_debt" onkeyup="hitung_zakat()" placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Form Profesi -->
                <div class="form-profesi">
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Penghasilan / Gaji per Bulan</label>
                        <div class="oc-input-group-sm mb-3">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money" inputmode="numeric" name="value_income" onkeyup="hitung_zakat()" placeholder="0">
                        </div>
                    </div>
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Penghasilan Tambahan per Bulan (Bonus, THR, dll)</label>
                        <div class="oc-input-group-sm mb-3">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money" inputmode="numeric" name="value_bonus" onkeyup="hitung_zakat()" placeholder="0">
                        </div>
                    </div>
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Cicilan / Hutang Kebutuhan Pokok per Bulan</label>
                        <div class="oc-input-group-sm mb-3">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money" inputmode="numeric" name="value_debt" onkeyup="hitung_zakat()" placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Form Fitrah -->
                <div class="form-fitrah" style="display: none">
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Besaran Harga Beras per Jiwa (2,5 kg)</label>
                        <div class="oc-input-group-sm mb-3">
                            <span class="input-group-text text-placeholder">Rp</span>
                            <input type="text" class="form-control money" inputmode="numeric" id="fitrah_harga_beras" value="45.000" onkeyup="hitung_zakat()" placeholder="45.000">
                        </div>
                    </div>
                    <div class="form-group custom-input">
                        <label class="oc-text-grey">Jumlah Jiwa yang Dizakati</label>
                        <div class="mb-3">
                            <input type="number" min="1" max="100" class="form-control" id="fitrah_jiwa" value="1" oninput="hitung_zakat()" placeholder="1">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="oc-card-divider"></div>

        <div class="oc-card-section">
            <div id="zakat-alert"></div>
            <div class="alert alert-success">
                <div class="mb-2">Kewajiban Anda membayar zakat sebesar:</div>
                <div class="oc-text-big text-success" id="zakat-total" data-value="0">Rp 0</div>
            </div>
        </div>
        
        <div class="oc-card-divider"></div>

        <div class="oc-card-section d-grid gap-2">
            <button type="button" class="btn btn-success btn-lg btn-confirm" onclick="next()">Tunaikan Zakat</button>
            <a href="{{ url('app/zakat') }}" class="btn btn-outline-secondary">Kembali ke Pembayaran Zakat</a>
        </div>
    </form>
</div>
<div id="payment-modal"></div>
@endsection

@push('script')
<script src="{{ asset('website/assets/js/payment.js') }}"></script>
<script src="{{ asset('website/assets/js/calc.zakat.js') }}"></script>
<script>
    function next(){
        var jenis = document.getElementsByName('zakat_type')[0].value;
        var zakat = document.getElementById('zakat-total').dataset.value || 0;
        window.location.href = '/app/zakat/tunaikan?jenis='+jenis+'&nominal='+zakat;
    }
    
    $(function(){
        $('.oc-back').click(function(){
            window.location.href = $(this).data('url');
        });
        if (typeof nisab_emas === 'function') {
            nisab_emas();
            hitung_zakat();
        }
    });
</script>
@endpush
