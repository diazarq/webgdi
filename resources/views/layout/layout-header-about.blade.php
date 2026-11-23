@if(App\Helper::getThemeSetting('show_topbar', true))
<div class="main-header-two__top">
    <div class="main-header-two__top-inner">
        <div class="main-header-two__top-left">
            @php
                $contact = App\Helper::displayContact();
            @endphp
            <ul class="list-unstyled main-header-two__contact-list">
                @if($contact['inst_addr'])
                <li>
                    <div class="icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="text">
                        <p>{{$contact['inst_addr']}}</p>
                    </div>
                </li>
                @endif

                @if($contact['inst_email'])
                <li>
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="text">
                        <p><a href="mailto:{{ $contact['inst_email'] }}">{{ $contact['inst_email'] }}</a></p>
                    </div>
                </li>
                @endif
            </ul>
        </div>
        <div class="main-header-two__top-right">
            @php
                $socialMedia = App\Helper::displaySocialMedia();
            @endphp

            @if($socialMedia)
            <div class="main-header-two__social">
                @foreach($socialMedia as $sm)
                    <a href="{{ $sm->url }}"><i class="{{ $sm->classname }}"></i></a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endif
<nav class="main-menu main-menu-two">
    <div class="main-menu-two__wrapper">
        <div class="main-menu-two__wrapper-inner d-flex justify-content-between align-items-center">
            <!-- Logo Graha Dhuafa Indonesia: pojok kiri -->
            <div class="main-menu-two__left">
                <div class="main-menu-two__logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('website/assets/images/custom/logo_gdi_long.png') }}" alt=""></a>
                </div>
            </div>
            <!-- Menu nav + tombol Zakat Sekarang: pojok kanan, sejajar tengah -->
            <div class="main-menu-two__main-menu-box ms-auto d-flex align-items-center">
                @include('layout.layout-menu');
            </div>
        </div>
    </div>
</nav>

<style>
    /* === LAZ GDI Custom: unifikasi warna header, topbar & sidebar hijau === */
    .main-header-two__top,
    .main-menu-two,
    .stricky-header.main-menu-two,
    .mobile-nav__content {
        background-color: #00875A;
    }

    @font-face {
        font-family: 'Handflair';
        src: url('{{ asset("website/assets/fonts/Handflair.ttf") }}?v={{ time() }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: 'Black';
        src: url('{{ asset("website/assets/fonts/Motterdam.otf") }}?v={{ time() }}') format('opentype'),
             url('{{ asset("website/assets/fonts/Motterdam.otf") }}?v={{ time() }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }


    .main-menu .main-menu__list > li > ul > li > a .font-handflair,
    .mobile-nav__content .font-handflair,
    .font-handflair {
        font-family: 'Black', cursive !important;
        font-size: 25px !important;    
        font-weight: normal !important;   
        display: inline-block;
        margin-left: 3px;
        color: #00875A;
    }

    .page-header__inner h2 .font-banner,
    .page-header h2 .font-banner {
        font-family: 'Handflair', cursive !important;
        font-size: 50px !important;       
        font-weight: normal !important;
        color: #ffffff !important;
        display: inline-block;
        margin-left: -12px;
        color: #fc804c !important;
        vertical-align: middle;
    }

        .mobile-nav__content .font-handflair {
        color: #ffffff !important;  
        font-size: 24px !important;  
        margin-left: 4px !important;
    }

    .mobile-nav__content .main-menu__list li a {
        justify-content: flex-start !important;
        gap: 6px !important;
    }
    .mobile-nav__content .main-menu__list li a button {
        margin-left: auto !important;
    }

    /* === LAZ GDI Custom: Navbar Sticky (selalu menempel di atas saat scroll) === */
    @if(App\Helper::getThemeSetting('sticky_navbar', true))
    .main-header-two {
        position: sticky;
        top: 0;
        z-index: 999;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    @endif

    /* Nonaktifkan clone stricky-header bawaan template agar tidak tumpang tindih */
    .stricky-header {
        display: none !important;
    }

    /* === LAZ GDI Custom: header lebih ramping agar tidak menutupi konten === */
    .main-header-two__top-inner {
        padding: 5px 40px;
    }
    .main-menu-two__wrapper-inner {
        padding: 6px 40px;
    }
    .main-menu-two__logo {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .main-menu-two .main-menu__list > li,
    .stricky-header .main-menu__list > li {
        padding-top: 8px;
        padding-bottom: 8px;
    }
    .main-menu-two .main-menu__list > li + li,
    .stricky-header .main-menu__list > li + li {
        margin-left: 32px;
    }
    .main-menu-two .main-menu__list > li.button .thm-btn {
        padding: 10px 24px;
        font-size: 13px;
    }
    .main-menu-two__main-menu-box {
        margin-left: auto;
        display: flex;
        align-items: center;
    }
</style>
