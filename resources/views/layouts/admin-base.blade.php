<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/admin.css') }}">

    <title>{{ $config->form_heading }}</title>
  </head>
  <body>

    @if ($errors->any())
    <div class="alert alert-danger alert-top" role="alert">
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
      <div class="alert alert-warning alert-top alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {!! session()->get('warning') !!}
      </div>
    @elseif (session()->has('success'))
      <div class="alert alert-success alert-top alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
        {!! session()->get('success') !!}
      </div>
    @endif

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark static-top">
      <div class="container">
        <a class="navbar-brand" href="/">{{ $config->form_heading }}</a>
        {{-- Only show nav items if logged in. --}}
        @if(Auth::check())
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="/admin">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
            {{-- Editor or higher access required for managing admin parameters. --}}
            @can('editor-functions', auth()->user())  


            @foreach($adminSections as $name => $route)
            <li class="nav-item">
              <a class="nav-link {{ Request::is($route) ? 'active' : '' }}" href="/{{ $route }}">{{ $name }}</a>
            </li>
            @endforeach
            @endcan
          {{-- Only admins can manage global config and users. --}}
            @can('admin-functions', auth()->user())            
            <li class="nav-item">
              <a class="nav-link {{ Request::is('config') ? 'active' : '' }}" href="/config">Global Config</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Request::is('users') ? 'active' : '' }}" href="/users">Manage Users</a>
            </li>
            @endcan
            {{-- Any logged in viewer can see logs. --}}
            <li class="nav-item">
              <a class="nav-link {{ Request::is('logs') ? 'active' : '' }}" href="/logs">View Logs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/logout">Log out</a>
            </li>
          </ul>
        </div>
        @endif
      </div>
    </nav>

    <div class="container container__main-container">
      @yield('content')
    </div>
  

    <!-- Bootstrap and jQuery -->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- App Scripts -->
    <script src="{{ URL::asset('js/admin.js') }}"></script>
  </body>
</html>