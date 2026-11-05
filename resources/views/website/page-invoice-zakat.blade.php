@extends('layout.payment-layout', ['title' => 'Pembayaran Zakat'])

@section('content')
<div class="oc-card">
    <form>
        <div class="oc-card-section oc-card-header oc-cursor oc-back" data-url="{{ url('app/zakat') }}"><i class="bi-arrow-left"></i> Lembar Pembayaran</div>
        <div class="oc-card-section">
            <div class="alert alert-warning">
                Mohon tunaikan zakat Anda sebelum tanggal <strong>{{ @$expire }}</strong> atau ajuan zakat Anda akan dibatalkan
            </div>

            <div class="form-group">
                <label class="oc-text-title">Zakat Anda</label>

                <div class="oc-container oc-bank d-flex justify-content-between align-items-center">
                    <span class="oc-nominal-big">
                        {{ 'Rp '.number_format($detail->nominal + $detail->digit, 0, ',', '.') }}
                    </span>
                    @php
                        $nominal = $detail->nominal + $detail->digit;
                    @endphp
                    <span class="oc-cursor" title="Salin" onclick="copy('{{ $nominal }}')"><i class="bi-clipboard"></i></span>
                </div>
            </div>
            <div class="alert alert-success">
                Pembayaran harus disertakan kode unik (tiga digit terakhir)
            </div>

            <div class="form-group">
                <label class="oc-text-title">{{ $bank->type == 'bank' ? 'Nomor Rekening' : 'Scan QR Code' }}</label>

                <div class="oc-bank oc-container <?= $bank->type == 'bank' ? 'd-flex justify-content-between' : ''?>">
                    @if($bank->type == 'emoney')
                    <span id="payment-method">
                        <img src="{{ url($bank->bank_img) }}" width="100px"/>
                    </span>
                    <div class="oc-qr-code mt-3">
                        <img src="{{ url($bank->code_image) }}" class="mb-3" width="100%"/>

                        <div class="text">{{ $bank->bank_user }}</div>
                    </div>
                    @else
                    <span id="payment-method">
                        <img src="{{ url($bank->bank_img) }}" width="100px"/>
                        <span class="oc-text-header d-flex" style="padding-top: 10px">
                            {{$bank->bank_account}}<br/>
                            An. {{$bank->bank_user}}
                        </span>
                    </span>
                    @php
                        $bankAccount = str_replace(' ','',$bank->bank_account);
                    @endphp
                    <span class="oc-cursor" title="Salin" onclick="copy('{{ $bankAccount }}')"><i class="bi-clipboard"></i> </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="oc-card-divider"></div>

        <div class="oc-card-section">
            <div class="form-group">
                <label>Kode Pembayaran</label>

                <div class="d-flex oc-bank oc-container justify-content-between align-items-center">
                    <span class="oc-nominal-medium">
                        {{ '#'.$detail->transcode }}
                    </span>
                    <span class="oc-cursor" title="Salin" onclick="copy('{{ '#'.$detail->transcode }}')"><i class="bi-clipboard"></i></span>
                </div>
            </div>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Rincian Zakat Anda
                    </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <p class="oc-text-header">{{ $detail->name }} 
                                    {!! ($detail->anonim == true ? '*<br/><small>Anda memutuskan untuk Anonim</small>' : '') !!}
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Nomor Whatsapp/Email</label>
                                <p class="oc-text-header">{{ $detail->email ? $detail->email : $detail->notelp }}</p>
                            </div>
                            <div class="form-group">
                                <label>Jenis Zakat</label>
                                <p class="oc-text-header">
                                    @php
                                        switch($detail->type){
                                            case 'profesi':
                                                echo 'Zakat Profesi';
                                                break;
                                            case 'maal':
                                                echo 'Zakat Maal';
                                                break;
                                            case 'fitrah':
                                                echo 'Zakat Fitrah';
                                                break;
                                        }
                                    @endphp
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Nominal Zakat</label>
                                <p class="oc-text-header">Rp {{ number_format($nominal, 0, ',', '.') }}</p>
                            </div>
                            <div class="form-group">
                                <label>Waktu</label>
                                <p class="oc-text-header">{{ $created }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-success text-center niat-non-fitrah mt-3" <?= $detail->type == 'fitrah' ? 'style="display: none"' : ''?>>
                <div class="oc-text-title">Doa Niat Zakat Maal/Profesi</div>

                <p class="arabic mt-3">نَوَيْتُ أَنْ اُخْرِجَ زَكَاتَ مَالِي فَرْضًا لِلَّهِ تَعَالَ</p>
                <p><i>Nawaitu an ukhrija zakata maali fardha llillahi ta’aala.</i></p>
                <p>"Saya berniat mengeluarkan zakat harta milikku karena Allah Ta’ala"</p>
            </div>
            <div class="alert alert-success text-center niat-fitrah mt-3" <?= $detail->type == 'fitrah' ? '' : 'style="display: none"'?>>
                <div class="oc-text-title">Doa Niat Zakat Fitrah</div>

                <p class="arabic mt-3">نَوَيْتُ أَنْ اُخْرِجَ زَكَاتَلْ ِفتْرِلِنَفِْس فَرْضًا لِلَّهِ تَعَالَ</p>
                <p><i>Nawaitu an ukhrija zakatal fitri linafsi fardha llillaahi ta’aala.</i></p>
                <p>"Saya berniat mengeluarkan zakat fitrah untuk diri saya karena Allah Ta’ala"</p>
            </div>
        </div>

        <div class="oc-card-divider"></div>

        <div class="oc-card-section d-grid">
            <button type="button" class="btn btn-success btn-lg btn-confirm" onclick="next('{{ $detail->transcode }}')">Konfirmasi Pembayaran</button>
        </div>
    </form>
</div>
@endsection

@push('script')
<script>
    function copy(value){
        document.execCommand(value);
        navigator.clipboard.writeText(value)
    }

    function next(code){
        window.location.href = '/app/zakat/detail/'+code
    }
    
    $(function(){
        $('.oc-back').click(function(){
            window.location.href = $(this).data('url')
        })
    })
</script>
@endpush

