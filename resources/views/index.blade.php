@extends('layouts.base')

@section('title', 'Support Mailer')

@section('content')

<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
      <div class="container">
        <a class="navbar-brand" href="#">Support Mailer</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Menu Link 1</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Menu Link 2</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Menu Link 3</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5">Log your support ticket here!</h1>
          <p class="lead">{!! $config->intro_html !!}</p>
         </div>
         <div class="col-lg-12">
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

            <p>List of issue types in database:</p>
            <ul>
              @foreach ($issueList as $issue)
                <li>{{ $issue->issue_name }}</li>
              @endforeach
              </ul>

            @if ($config->use_staff_list)
              <p>Staff List (if enabled):</p>
              <ul>
              @foreach ($staffMembers as $staffMember)
                <li>{{ $staffMember->staff_name }}, {{ $staffMember->staff_email }}</li>
              @endforeach
              </ul>
            @endif
         </div>
        </div>
      </div>
    </div>
@endsection
