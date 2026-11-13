

    
<style>
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
        $quickLinks = App\Helper::displayFooterMenu();
        $hasQuickLinks = $quickLinks && count($quickLinks) > 0;
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                <div class="footer-widget__column footer-widget__about">
                    <div class="footer-widget__logo">
                        <a href="#"><img src="{{ asset('website/assets/images/custom/logo_gdi_long.png') }}" alt=""></a>
                    </div>
                    <div class="footer-widget__about-text-box">
                        <p class="footer-widget__about-text">Menjadi lembaga global yang profesional untuk peduli menjaga generasi mandiri dan unggul</p>
                    </div>
                    <a href="{{ url('app/zakat') }}" class="thm-btn main-slider-two__btn">Zakat Sekarang</a>
                    <!--
                    <form class="footer-widget__subscribe-box">
                        <div class="footer-widget__subscribe-input-box">
                            <input type="email" placeholder="Email address" name="email">
                            <button type="submit" class="footer-widget__subscribe-btn"><img
                                    src="{{ asset('website/assets/images/icon/paper-plan.png') }}" alt=""></button>
                        </div>
                    </form>-->
                </div>
            </div>
            @if($hasQuickLinks)
            <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                <div class="footer-widget__column footer-widget__Explore">
                    <div class="footer-widget__title-box">
                        <h3 class="footer-widget__title">Quick Links</h3>
                    </div>
                    <ul class="footer-widget__Explore-list list-unstyled">
                        @foreach($quickLinks as $q)
                            <li><a href="{{ $q->slug }}">{{ $q->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <div class="col-xl-{{ $hasQuickLinks ? 2 : 3 }} col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                <div class="footer-widget__column footer-widget__Fundraising">
                    <div class="footer-widget__title-box">
                        <h3 class="footer-widget__title">Program</h3>
                    </div>
                    <ul class="footer-widget__Explore-list list-unstyled">
                        <li><a href="{{ url('budaya') }}">Budaya</a></li>
                        <li><a href="{{ url('cinta') }}">Cinta</a></li>
                        <li><a href="{{ url('senyum') }}">Senyum</a></li>
                        <li><a href="{{ url('volunteer/daftar') }}" style="color: #86efac;"><i class="fa fa-heart me-1"></i> Jadi Relawan</a></li>
                        <li><a href="{{ url('mitra/daftar') }}" style="color: #fde047;"><i class="fa fa-handshake me-1"></i> Jadi Mitra/Amil</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-{{ $hasQuickLinks ? 3 : 4 }} col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
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
                    <p class="site-footer__bottom-text mb-0">© copyright 2026 by <a href="#">Yayasan Graha Dhuafa Indonesia</a></p>
                    <div class="site-footer__bottom-links" style="font-size: 13px;">
                        <a href="{{ url('volunteer/daftar') }}" style="color: #94a3b8; margin-right: 15px;">Sahabat Baik</a>
                        <a href="{{ url('mitra/daftar') }}" style="color: #94a3b8; margin-right: 15px;">Mitra Amil Zakat</a>
                        <a href="{{ url('z/login') }}" style="color: #facc15;"><i class="fa fa-sign-in-alt me-1"></i> Portal Relawan (/z/login)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>