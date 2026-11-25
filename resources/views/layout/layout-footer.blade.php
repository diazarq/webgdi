

    
<style>
    .site-footer {
        border-top: 4px solid rgba(45, 212, 167, 0.55) !important;

    }

    .site-footer__bottom-text {
        font-size: 14px;
        line-height: 22px;
    }

    
    .site-footer__bottom-inner {
        text-align: left !important;
    }


    .site-footer__top .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-right: -15px;
        margin-left: -15px;
    }

    .site-footer__top .row > [class*="col-"] {
        padding-left: 15px;
        padding-right: 15px;
    }

   
    .site-footer__top .footer-widget__about,
    .site-footer__top .footer-widget__Explore,
    .site-footer__top .footer-widget__Fundraising,
    .site-footer__top .footer-widget__Contact {
        margin-right: 0;
    }

    /* Penyelarasan sejajar Kolom Profil/Logo dengan kolom-kolom menu lainnya */
    .site-footer__top .footer-widget__about {
        margin-top: 0 !important;
    }

    .site-footer__top .footer-widget__logo {
        height: 40px;
        display: flex;
        align-items: center;
        margin-bottom: 22px;
    }

    .site-footer__top .footer-widget__logo img {
        max-height: 120px;
        width: auto;
    }

    .site-footer__top .footer-widget__about-text-box {
        padding-top: 0 !important;
        padding-bottom: 18px;
    }

   
    .site-footer__top .footer-widget__Contact-list li {
        align-items: flex-start;
    }

    .site-footer__top .footer-widget__Contact-list li .icon {
        margin-top: 7px;
    }


    .site-footer__top .footer-widget__Explore-list li+li,
    .site-footer__top .footer-widget__Contact-list li+li {
        margin-top: 12px;
    }


    .site-footer__top .footer-widget__title-box {
        margin-bottom: 22px;
    }
</style>
<div class="site-footer__top">
    <div class="site-footer__shape-1 float-bob-x">
        <img src="{{ asset('website/assets/images/shapes/site-footer-shape-1.png') }}" alt="">
    </div>
    @php
        $quickLinks = App\Helper::displayFooterMenu('quick_link');
        $programLinks = App\Helper::displayFooterMenu('program_link');
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                <div class="footer-widget__column footer-widget__about">
                    <div class="footer-widget__logo">
                        <a href="#"><img src="{{ asset('website/assets/images/custom/logo_gdi_long.png') }}" alt=""></a>
                    </div>
                    <div class="footer-widget__about-text-box">
                        <p class="footer-widget__about-text">Menjadi lembaga global yang profesional untuk peduli menjaga generasi mandiri dan unggul</p>
                    </div>

                </div>
            </div>
            <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                <div class="footer-widget__column footer-widget__Explore">
                    <div class="footer-widget__title-box">
                        <h3 class="footer-widget__title">Quick Links</h3>
                    </div>
                    <ul class="footer-widget__Explore-list list-unstyled">
                        @if($quickLinks && $quickLinks->count() > 0)
                            @foreach($quickLinks as $q)
                                <li><a href="{{ Str::startsWith($q->url, ['http://', 'https://']) ? $q->url : url(ltrim($q->url, '/')) }}">{{ $q->title }}</a></li>
                            @endforeach
                        @else
                            <li><a href="{{ url('/') }}">Beranda</a></li>
                            <li><a href="{{ url('/tentang-zakat') }}">Tentang Zakat</a></li>
                            <li><a href="{{ url('/kalkulator-zakat') }}">Kalkulator Zakat</a></li>
                            <li><a href="{{ url('/zakat-online') }}">Zakat Online</a></li>
                            <li><a href="{{ url('/blog') }}">Berita & Artikel</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                <div class="footer-widget__column footer-widget__Fundraising">
                    <div class="footer-widget__title-box">
                        <h3 class="footer-widget__title">Program</h3>
                    </div>
                    <ul class="footer-widget__Explore-list list-unstyled">
                        @if($programLinks && $programLinks->count() > 0)
                            @foreach($programLinks as $p)
                                <li><a href="{{ Str::startsWith($p->url, ['http://', 'https://']) ? $p->url : url(ltrim($p->url, '/')) }}">{{ $p->title }}</a></li>
                            @endforeach
                        @else
                            <li><a href="{{ url('budaya') }}">Budaya</a></li>
                            <li><a href="{{ url('cinta') }}">Cinta</a></li>
                            <li><a href="{{ url('senyum') }}">Senyum</a></li>   
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                <div class="footer-widget__column footer-widget__Contact">
                    <div class="footer-widget__title-box">
                        <h3 class="footer-widget__title">Kontak</h3>
                    </div>
                    @php
                        $contact = App\Helper::displayContact();
                    @endphp
                    <ul class="footer-widget__Contact-list list-unstyled">
                        @if($contact['inst_telp'])
                        <li>
                            <div class="icon">
                                <span class="icon-telephone"></span>
                            </div>
                            <div class="text">
                                <p><a href="tel:{{ $contact['inst_telp'] }}">{{ $contact['inst_telp'] }}</a></p>
                            </div>
                        </li>
                        @endif

                        @if($contact['inst_email'])
                        <li>
                            <div class="icon">
                                <span class="icon-email"></span>
                            </div>
                            <div class="text">
                                <p><a href="mailto:{{ $contact['inst_email'] }}">{{ $contact['inst_email'] }}</a></p>
                            </div>
                        </li>
                        @endif

                        @if($contact['inst_addr'])
                        <li>
                            <div class="icon">
                                <span class="icon-pin"></span>
                            </div>
                            <div class="text">
                                <p>{{ $contact['inst_addr'] }}</p>
                            </div>
                        </li>
                        @endif
                    </ul>

                    @php
                        $socialMedia = App\Helper::displaySocialMedia();
                    @endphp
                    @if($socialMedia)
                    <div class="site-footer__social">
                        @foreach($socialMedia as $dt)
                            <a href="{{ $dt->url }}"><i class="{{ $dt->classname }}"></i></a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-footer__bottom">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="site-footer__bottom-inner d-flex flex-wrap justify-content-between align-items-center">
                    <p class="site-footer__bottom-text mb-0">© copyright {{ date('Y') }} by <a href="#">Yayasan Graha Dhuafa Indonesia</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>