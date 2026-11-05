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
