@extends('layout.payment-layout', ['title' => 'Zakat'])

@section('content')
<div class="oc-card">
    <form id="formZakat">
        <input type="hidden" name="zakat_type" value="{{ @$jenis ? $jenis : 'profesi'}}"/>
        <input type="hidden" name="sapaan" required value=""/>
        <input type="hidden" name="payment_method" value="transfer bank"/>
        <input type="hidden" name="bank_id" required value=""/>
        <div class="oc-card-section oc-card-header">Pembayaran Zakat</div>
        <div class="oc-card-section">
            <div class="form-group">
                <label class="oc-text-title">Pilihan Zakat</label>

                <div class="oc-container">
                    <nav class="nav nav-pills nav-justified">
                        <a class="nav-link {{ @$jenis == 'profesi' || !@$jenis ? 'active' : '' }} get-zakat-type" data-value="profesi" aria-current="page" href="#profesi">Zakat Profesi</a>
                        <a class="nav-link {{ @$jenis == 'maal' ? 'active' : '' }} get-zakat-type" data-value="maal" href="#maal">Zakat Maal</a>
                        <a class="nav-link {{ @$jenis == 'fitrah' ? 'active' : '' }} get-zakat-type" data-value="fitrah" href="#fitrah">Zakat Fitrah</a>
                    </nav>
                </div>
            </div>

            <div class="form-group custom-input">
                <label>Nominal Zakat</label>
                <div class="oc-input-group input-group-lg mb-3">
                    <span class="input-group-text text-placeholder">Rp</span>
                    <input type="text" class="form-control money" inputmode="numeric" id="input_zakat_nominal" name="zakat_nominal" required placeholder="Nominal zakat" value="{{ @$nominal ? number_format($nominal, 0, ',', '.') : ''}}">
                </div>
            </div>

            <div class="alert alert-warning">
                <div class="oc-text-header mb-2"><i class="bi bi-calculator"></i> Kalkulator Zakat</div>
                <p class="mb-3" style="font-size: 13.5px;">Bingung menentukan nominal zakat Anda? Gunakan kalkulator zakat untuk mengetahui kewajiban dan menghitung nominal yang harus ditunaikan secara akurat.</p>
                <nav class="nav nav-pills flex-column flex-sm-row gap-2">
                    <a class="flex-sm-fill text-sm-center nav-link text-bg-outline-secondary" href="/app/zakat/informasi"><strong>Tentang Zakat</strong></a>
                    <a class="flex-sm-fill text-sm-center nav-link text-bg-success" href="/kalkulator-zakat"><strong><i class="bi bi-calculator me-1"></i> Buka Kalkulator Zakat</strong></a>
                </nav>
            </div>
        </div>

        <div class="oc-card-divider"></div>

        <div class="oc-card-section">
            <div class="form-group">
                <label class="oc-text-title">Data Diri</label>
            </div>
            <div class="form-group" id="sectionSapaan">
                <label>Sapaan</label>
                <div class="invalid-feedback-pronoun">Pilih salah satu</div>
                <div class="row">
                    <div class="col-3">
                        <div class="oc-radio-box sapaan" data-value="Pak">Pak</div>
                    </div>
                    <div class="col-3">
                        <div class="oc-radio-box sapaan" data-value="Bu">Bu</div>
                    </div>
                    <div class="col-3">
                        <div class="oc-radio-box sapaan" data-value="Mas">Mas</div>
                    </div>
                    <div class="col-3">
                        <div class="oc-radio-box sapaan" data-value="Mbak">Mbak</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" class="form-control" required name="name"/>
                <div class="form-check mt-1">
                    <input class="form-check-input" type="checkbox" value="1" name="anonim" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Sembunyikan nama saya (anonim)
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>Nomor Whatsapp/Email</label>
                <input type="text" class="form-control" required name="email_phone"/>
            </div>
        </div>

        <div class="oc-card-divider"></div>

        <div class="oc-card-section">
            <div class="form-group">
                <label class="oc-text-title">Metode Pembayaran</label>
                <div class="invalid-feedback-payment">Pilih Metode Pembayaran</div>
                <div class="oc-radio-box text-left payment-method-box" onclick="modalPayment()">
                    <div class="d-flex oc-bank justify-content-between">
                        <span id="payment-method">
                            <img src="{{ asset('website/assets/images/custom/card-icon.png') }}" width="30px"/>
                            <span class="oc-bank-item">Pilih Metode Pembayaran</span>
                        </span>
                        <span><i class="bi bi-chevron-down"></i> </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="oc-card-divider"></div>

        <div class="oc-card-section">
            <div class="alert alert-success text-center niat-non-fitrah" <?= @$jenis == 'fitrah' ? 'style="display: none"' : ''?>>
                <div class="oc-text-title">Doa Niat Zakat Maal/Profesi</div>

                <p class="arabic mt-3">نَوَيْتُ أَنْ اُخْرِجَ زَكَاتَ مَالِي فَرْضًا لِلَّهِ تَعَالَ</p>
                <p><i>Nawaitu an ukhrija zakata maali fardha llillahi ta’aala.</i></p>
                <p>"Saya berniat mengeluarkan zakat harta milikku karena Allah Ta’ala"</p>
            </div>
            <div class="alert alert-success text-center niat-fitrah" <?= @$jenis == 'fitrah' ? '' : 'style="display: none"'?>>
                <div class="oc-text-title">Doa Niat Zakat Fitrah</div>

                <p class="arabic mt-3">نَوَيْتُ أَنْ اُخْرِجَ زَكَاتَلْ ِفتْرِلِنَفِْس فَرْضًا لِلَّهِ تَعَالَ</p>
                <p><i>Nawaitu an ukhrija zakatal fitri linafsi fardha llillaahi ta’aala.</i></p>
                <p>"Saya berniat mengeluarkan zakat fitrah untuk diri saya karena Allah Ta’ala"</p>
            </div>
        </div>

        <div class="oc-card-divider"></div>

        <div class="oc-card-section">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Legalitas sebagai Pengelola Zakat
                    </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Graha Dhuafa Indonesia berdiri pada tahun 2016 dan bergerak dalam bidang sosial, kemanusiaan dan keagamaan dengan 
                            akta pendirian Endang Sosilowati SH. Nomor 01 tanggal 03 Oktober 2016 tentang pendirian Yayasan Graha Dhuafa Indonesia, serta 
                            mendapatkan izin operasional kantor lembaga amil zakat LAZ Graha Dhuafa Indonesia berdasarkan Nomor: 1913 tahun 2022 tanggal 
                            03 Oktober 2022.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="oc-card-divider"></div>
        <div class="oc-card-section d-grid">
            <button type="submit" class="btn btn-success btn-lg">Tunaikan Sekarang</button>
        </div>
    </form>
</div>

{{-- modal payment --}}
<div class="modal" tabindex="-1" id="payment-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Metode Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="oc-modal-payment mb-3">
            @php
                $emoney = [];
            @endphp
            <div class="card">
                <div class="card-header oc-card-header-other"><i class="bi bi-credit-card"></i> Transfer Bank</div>
                @if(@$bank)
                <ul class="list-group list-group-flush">
                    @foreach($bank as $dt)
                    @if($dt->type == 'bank')
                    <li class="list-group-item d-flex align-items-center oc-bank select-payment" data-value="{{$dt->id}}">
                        <img src="{{ url($dt->bank_img) }}" width="60px"/>
                        <span class="oc-bank-item">{{ $dt->bank_name }}</span>
                    </li>
                    @else
                        @php
                            $emoney[] = [
                                'id' => $dt->id,
                                'img' => $dt->bank_img,
                                'name' => $dt->bank_name,
                                'code' => $dt->code_image 
                            ];
                        @endphp
                    @endif
                    @endforeach
                </ul>
                @else
                    Daftar rekening tidak ditemukan.
                @endif
                
                @if($emoney)
                <div class="card-header oc-card-header-other"><i class="bi bi-qr-code-scan"></i> E-Money/E-Wallet</div>
                @foreach($emoney as $dt)
                    <li class="list-group-item d-flex align-items-center oc-bank select-payment" data-value="{{$dt['id'] }}">
                        <img src="{{ url($dt['img']) }}" width="60px"/>
                        <span class="oc-bank-item">{{ $dt['name'] }}</span>
                    </li>
                @endforeach
                @endif
            </div>
        </div>
        <div class="d-grid">
            <button type="button" class="btn btn-success btn-lg" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script src="{{ asset('website/assets/js/payment.js') }}"></script>
@endpush
