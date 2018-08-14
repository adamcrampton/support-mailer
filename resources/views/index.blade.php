<!doctype html>
<html lang="en">
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap/css/bootstrap.min.css') }}">

    <title>Support Mailer</title>
  </head>
  <body>
    
  <!-- Front end test -->
  <p>Config:</p>

  <ul>
    <li>Intro HTML is: {{ $config->intro_html }}</li>
    <li>Default provider is: {{ $config->provider->provider_name }}</li>
    <li>Show multiple providers? {{ $config->show_multiple_providers }}</li>
    <li>Use staff list? {{ $config->use_staff_list }}</li>
  </ul>

  @if ($config->show_multiple_providers)
    <p>Provider List (if enabled):</p>
    <ul>
    @foreach ($providers as $provider)
      <li>{{ $provider->provider_name }}</li>
    @endforeach
    </ul>
  @endif

    <!-- Bootstrap and jQuery -->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  </body>
</html>