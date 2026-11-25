@extends('layout.layout-page', ['active' => $active])
@section('title', $pageTitle)

@section('style')
<style>
    .address__text{
        max-width: 200px;
        height: 6rem;
    }
    .address__text_branch{
        max-width: 400px;
        height: 7rem;
    }
    .google-map > iframe{
        width: 100%;
    }
</style>
@endsection

@section('breadcrumb')
<h2>{{ @$detail->title ? @$detail->title : $pageTitle }}</h2>
@endsection

@section('pageContact')
@php
    $contact = App\Helper::displayContact();
    $branch = App\Helper::displayBranch();
@endphp
<section class="contact-one">
    <div class="container">
        <div class="section-title text-center">
            <span class="section-title__tagline">Hubungi Kami</span>
            <h2 class="section-title__title">Konsultasikan perihal zakat, infaq, shodaqoh Anda pada kami</h2>
        </div>

        @if(Session::has('success') == true)
            <div class="alert alert-info" style="border-radius: 0px">
                Terima kasih sudah mengirimkan pesan kepada kami.<br/>
                Kami akan segera membalas pesan Anda melalui email atau nomor telepon yang Anda daftarkan.
            </div>
        @endif
        <div class="contact-one__form-box">
            <form action="/message/send" method="post" class="contact-one__form">
                @csrf
                <input type="hidden" name="slug" value="{{ $slug }}"/>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="contact-form__input-box">
                            <input type="text" placeholder="Nama Anda" name="name">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="contact-form__input-box">
                            <input type="email" placeholder="Email Anda" name="email">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="contact-form__input-box">
                            <input type="text" placeholder="No. HP Anda" name="phone">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="contact-form__input-box">
                            <input type="text" placeholder="Subjek Pesan" name="subject">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="contact-form__input-box text-message-box">
                            <textarea name="message" placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        <div class="contact-form__btn-box">
                            <button type="submit" class="thm-btn contact-form__btn">Kirim Pesan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!--Contact One End-->

<!--Address Start-->
<section class="address">
    <div class="container">
        <div class="row">
            <!--Address Single Start-->
            <div class="col-xl-4 col-lg-4">
                <div class="address__single">
                    <div class="address__title-box">
                        <h4 class="address__title">Instansi</h4>
                        <div class="address__icon">
                            <span class="icon-entrepreneur-1"></span>
                        </div>
                    </div>
                    <p class="address__text">Yayasan Graha Dhuafa Indonesia</p>
                </div>
            </div>
            <!--Address Single End-->
            <!--Address Single Start-->
            <div class="col-xl-4 col-lg-4">
                <div class="address__single">
                    <div class="address__title-box">
                        <h4 class="address__title">Alamat</h4>
                        <div class="address__icon">
                            <span class="icon-location"></span>
                        </div>
                    </div>
                    <p class="address__text">{{ $contact['inst_addr'] }}</p>
                </div>
            </div>
            <!--Address Single End-->
            <!--Address Single Start-->
            <div class="col-xl-4 col-lg-4">
                <div class="address__single">
                    <div class="address__title-box">
                        <h4 class="address__title">Kontak</h4>
                        <div class="address__icon">
                            <span class="icon-contact"></span>
                        </div>
                    </div>
                    <p class="address__text">
                        <a href="tel:{{ $contact['inst_telp'] }}" class="address__number">{{ $contact['inst_telp'] }}</a>
                        <a href="mailto:{{ $contact['inst_email'] }}" class="address__email">{{ $contact['inst_email'] }}</a>
                    </p>
                </div>
            </div>
            <!--Address Single End-->
        </div>
    </div>
</section>
<!--Address End-->

<!--Google Map Start-->
<section class="google-map">
{!! $contact['inst_map'] !!}
</section>

@if($branch)
<section class="address about-one">
    <div class="container">
        <div class="section-title text-center">
            <span class="section-title__tagline">Kantor Cabang</span>
        </div>
        
        <div class="row">
            @foreach($branch as $dt)
            <div class="col-xl-6 col-lg-6">
                <div class="address__single">
                    <div class="address__title-box">
                        <h4 class="address__title">{{ $dt['name'] }}</h4>
                        <div class="address__icon">
                            <span class="icon-location"></span>
                        </div>
                    </div>
                    <p class="address__text_branch">
                        {{ $dt['address'] }}
                        <br/>
                        Telp. {{ $dt['phone'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection