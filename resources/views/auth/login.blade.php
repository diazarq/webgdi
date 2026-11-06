<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CMS | YGDI">
    <meta name="author" content="Iskandar Ocha">
    <meta name="generator" content="Iskandar Ocha">
    <title>Login | CMS</title>

    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/scss/custom.css') }}" rel="stylesheet"/>

    <!-- Favicons -->
    <!--
    <link rel="apple-touch-icon" href="/docs/5.2/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.2/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.2/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">
    -->


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="{{ asset('admin/assets/css/login.css') }}" rel="stylesheet">
    
  </head>
  <body>
    
    <main class="form-signin w-100 m-auto">
        <form method="post" action="/q/login">
            @csrf

            <div class="text-center">
              <img class="mb-4" src="{{ asset('admin/assets/img/logo_gdi.png') }}" alt="" width="72">
              <h1 class="h3 mb-3 fw-normal"><strong>YGDI ADMIN</strong><br/><small>Content Management System</small></h1>
            </div>

            <div class="alert alert-danger" style="{{ @$errors->first('error') ? 'display: block' : 'display: none'}}">{{ @$errors->first('error') }}</div>
            <div class="mb-3">
                <label for="username" class="form-label">Username *</label>
                <input type="text" class="form-control" name="username" id="username" required>
                <div class="invalid-feedback">Username tidak boleh kosong!</div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password *</label>
              <input type="password" class="form-control" name="password" id="password" required>
              <div class="invalid-feedback">Password tidak boleh kosong!</div>
            </div>
            <button class="w-100 btn btn-lg btn-primary" name="submit" value="submit" type="submit">Login</button>

            <div>
              <p class="mt-3 mb-3"><a href="#forget-pass" id="fpass">Lupa password?</a></p>
            </div>
        </form>
        <div class="text-center">
          <p class="mt-5 mb-3 text-muted">&copy; YGDI 2026</p>
        </div>
    </main>

    <script src="{{ asset('admin/assets/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- custom -->
    <script src="{{ asset('admin/assets/plugins/custom/bp-modal-alert.js') }}"></script>

    <script src="{{ asset('admin/assets/js/login.js') }}"></script>
    
    <script>
        
    </script>
  </body>
</html>
