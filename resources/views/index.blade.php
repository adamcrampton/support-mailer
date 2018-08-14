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
  <ul>
    <li>Intro HTML is: {{ $config->intro_html }}</li>
    <li>Default provider fk is: {{ $config->default_provider_fk }}</li>
    <li>Show multiple providers? {{ $config->show_multiple_providers }}</li>
    <li>Use staff list? {{ $config->use_staff_list }}</li>
  </ul>
    <!-- Bootstrap and jQuery -->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  </body>
</html>