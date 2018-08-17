<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    <title>{{ $config->form_heading }}</title>
  </head>
  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
      <div class="container">
        <a class="navbar-brand" href="/">{{ $config->form_heading }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/admin">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            @foreach($adminSections as $name => $route)
            <li class="nav-item">
              <a class="nav-link" href="/{{ $route }}">{{ $name }}</a>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      @yield('content')
    </div>
  

    <!-- Bootstrap and jQuery -->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- App Scripts -->
    <script src="{{ URL::asset('js/app.js') }}"></script>
  </body>
</html>