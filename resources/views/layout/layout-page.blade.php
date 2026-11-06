<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('website/assets/images/custom/logo_gdi.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('website/assets/images/custom/logo_gdi.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('website/assets/images/custom/logo_gdi.png') }}" />
    <!--<link rel="manifest" href="{{ asset('website/assets/images/favicons/site.webmanifest') }}" />-->
    <meta name="description" content="Website Yayasan Graha Dhuafa Indonesia" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('website/assets/vendors/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/animate/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/animate/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/jarallax/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/nouislider/nouislider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/nouislider/nouislider.pips.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/odometer/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/swiper/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/qrowd-icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/tiny-slider/tiny-slider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/reey-font/stylesheet.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/owl-carousel/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/bxslider/jquery.bxslider.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/bootstrap-select/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/vegas/vegas.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/vendors/timepicker/timePicker.css') }}" />

    <!-- template styles -->
    <link rel="stylesheet" href="{{ asset('website/assets/css/qrowd.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/assets/css/qrowd-responsive.css') }}" />

    @yield('style')
    @stack('style')
    @stack('styles')
</head>

<body class="custom-cursor">

    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>





    <div class="preloader">
        <div class="preloader__image"></div>
    </div>
    <!-- /.preloader -->


    <div class="page-wrapper">
        <header class="main-header-two">
            @include('layout.layout-header-about', ['active' => @$active ?? []])
        </header>

        <div class="stricky-header stricked-menu main-menu main-menu-two">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

        <!--Page Header Start-->
        @if(empty($hidePageHeader) && App\Helper::getThemeSetting('show_page_header', true))
        <section class="page-header">
            <div class="page-header-bg" style="background-image: url({{ asset('website/assets/images/backgrounds/page-header-bg-3.jpeg') }})">
            </div>
            <div class="page-header-overlay" aria-hidden="true"></div>
            <div class="container">
                <div class="page-header__inner">
                    @yield('breadcrumb')
                </div>
            </div>
        </section>
        @endif
        <!--Page Header End-->

        <style>
            /* === GDI Custom: samakan gaya page-header dengan tema hijau header === */
            .page-header {
                background: linear-gradient(135deg, #06301f 0%, #0a4a2e 55%, #0d5c38 100%);
                overflow: hidden;
                padding: 135px 0 65px;
            }

           .page-header__inner {
    text-align: center; 
}
.page-header__inner h2 {
    color: #ffffff;
    font-size: 38px;
    line-height: 48px;
    margin-top: 6px;
    text-align: center; 
}

            @media (max-width: 767px) {
                .page-header {
                    padding: 100px 0 45px;
                }
                .page-header__inner h2 {
                    font-size: 28px;
                    line-height: 36px;
                }
            }

            .page-header-bg {
                opacity: 0.25;
                mix-blend-mode: luminosity;
            }

            .page-header-overlay {
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(600px 260px at 10% 0%, rgba(45, 212, 167, 0.25), transparent 60%),
                    radial-gradient(500px 240px at 92% 20%, rgba(255, 138, 61, 0.18), transparent 55%);
                pointer-events: none;
            }

            .page-header__inner .subtitle {
                color: #7ef0c0;
            }

            .thm-breadcrumb li a,
            .thm-breadcrumb li span {
                color: rgba(255, 255, 255, 0.75);
            }

            .thm-breadcrumb li + li::before {
                color: rgba(255, 255, 255, 0.4);
            }
        </style>

        <!--General Page Start-->
        @yield('pageGeneral')
        @yield('content')
        <!--General Page End-->

        @yield('pageProgram')

        @yield('pageBlog')

        @yield('pageGallery')

        @yield('pageContact')

        <!--Site Footer Start-->
        <footer class="site-footer">
            @if(!empty($minimalFooter))
                {{-- Footer ringkas khusus halaman tertentu (mis. Wakaf & Hibah) --}}
                @include('layout.layout-footer-minimal')
            @else
                @include('layout.layout-footer')
            @endif
        </footer>
        <!--Site Footer End-->


    </div><!-- /.page-wrapper -->


    <div class="mobile-nav__wrapper">
        @include('layout.layout-footer-mobile')
    </div>
    <!-- /.mobile-nav__wrapper -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="icon-right-arrow"></i></a>


    <script src="{{ asset('website/assets/vendors/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/jarallax/jarallax.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/jquery-appear/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/odometer/odometer.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/swiper/swiper.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/tiny-slider/tiny-slider.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/wnumb/wNumb.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/wow/wow.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/isotope/isotope.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/countdown/countdown.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/bxslider/jquery.bxslider.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/vegas/vegas.min.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/timepicker/timePicker.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/circleType/jquery.circleType.js') }}"></script>
    <script src="{{ asset('website/assets/vendors/circleType/jquery.lettering.min.js') }}"></script>




    <!-- template js -->
    <script src="{{ asset('website/assets/js/qrowd.js') }}"></script>

    @stack('script')
    @stack('scripts')
    @yield('script')
    @yield('scripts')
</body>

</html> 