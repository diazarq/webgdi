  <!doctype html>
  <html lang="en">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
@stack('styles')
      @yield('meta')
      <link rel="icon" href="{{ asset('admin/assets/img/logo_gdi.png') }}"/>
      <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet"/>
      <link href="{{ asset('admin/assets/plugins/metismenu/metisMenu.min.css') }}" rel="stylesheet"/>
      <!--<link href="{{ asset('admin/assets/plugins/imperavi/article/article-editor.min.css') }}" rel="stylesheet"/>-->
      <link href="{{ asset('admin/assets/plugins/imperavi/redactorx/redactorx.min.css?build230') }}" rel="stylesheet"/>
      <link href="{{ asset('admin/assets/plugins/inputmask/css/inputmask.css') }}" rel="stylesheet"/>
      <link href="{{ asset('admin/assets/plugins/datepicker/daterangepicker.css') }}" rel="stylesheet"/>
      <link href="{{ asset('admin/assets/plugins/scss/custom.css') }}" rel="stylesheet"/>

      <title>@yield('title')</title>
    </head>
    <body>
      <div class="loader">
          <div class="spin">Loading
              <div class="blink blink1">.</div>
              <div class="blink blink2">.</div>
              <div class="blink blink3">.</div>
          </div>
      </div>

      <header class="cs-header">
        <div class="cs-toggle" data-open="false" ><i class="bi-list"></i></div>
        <div class="cs-title">CMS</div>
      </header>

      <div class="cs-left-bar" id="slide">
        <nav>
          @include('layout.app-menu', ['active' => $active ?? null])

        </nav>
      </div>

      <div class="cs-right-content">
        <div class="container">
          <!-- breadcrumbs -->
          <nav aria-label="breadcrumb">
            @yield('breadcrumb')
          </nav>

          <div class="cs-segment">
            @yield('content')
            
          </div>
        </div>
        
      </div>

      <script src="{{ asset('admin/assets/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

      <!-- plugins -->
      <script src="{{ asset('admin/assets/plugins/datatable/datatables.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/metismenu/metismenu.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/number/jquery.number.min.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/inputmask/dist/jquery.inputmask.bundle.min.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/datepicker/moment.min.js')}}"></script>
      <script src="{{ asset('admin/assets/plugins/datepicker/daterangepicker.js')}}"></script>

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!--
      <script src="{{ asset('admin/assets/plugins/imperavi/article/article-editor.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/imperavi/article/reorder.min.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/imperavi/article/inlineformat.min.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/imperavi/article/style.min.js') }}"></script>
      <script src="{{ asset('admin/assets/plugins/imperavi/article/imageposition.min.js') }}"></script>
      -->
      <script src="{{ asset('admin/assets/plugins/imperavi/redactorx/redactorx.js?build230') }}"></script>
      <script src="{{ asset('admin/assets/plugins/imperavi/redactorx/inlineformat.min.js?build230') }}"></script>
      <script src="{{ asset('admin/assets/plugins/imperavi/redactorx/imageposition.min.js?build230') }}"></script>
      <script src="{{ asset('admin/assets/js/main.js') }}"></script>
      
      <!-- Iconify Web Component Global -->
      <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

      @stack('scripts')

    </body>
  </html>