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

    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <p>Sorry, there was a problem submitting your form. Details:</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @elseif (session()->has('warning'))
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {!! session()->get('warning') !!}
      </div>
    @elseif (session()->has('success'))
      <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
        {!! session()->get('success') !!}
      </div>
    @endif

    <!-- Navigation -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
      <div class="container">
        <a class="navbar-brand" href="/">{{ $config->form_heading }}</a>
        {{-- Only show nav items if logged in. --}}
        @if(Auth::check())
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
            <li class="nav-item">
              <a class="nav-link" href="/logout">Log out</a>
            </li>
          </ul>
        </div>
        @endif
      </div>
    </nav>

    <div class="container">
      @yield('content')
    </div>
  

    <!-- Bootstrap and jQuery -->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- App Scripts -->
    <script src="{{ URL::asset('js/admin.js') }}"></script>
  </body>
</html>