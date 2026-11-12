<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ @$title }}</title>
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('website/assets/images/custom/logo_gdi.png') }}" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('website/assets/images/custom/logo_gdi.png') }}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('website/assets/images/custom/logo_gdi.png') }}" />
        <meta name="description" content="Website Yayasan Graha Dhuafa Indonesia" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="{{ asset('website/assets/css/payment.css') }}" rel="stylesheet"/>
        @yield('style')
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-md-5 ">
                    @yield('content')
                    
                </div>
            </div>
        </div>
        <script src="{{ asset('website/assets/vendors/jquery/jquery-3.6.0.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
        
        <!-- Iconify Web Component Global -->
        <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

        @stack('script')
    </body>
</html>
