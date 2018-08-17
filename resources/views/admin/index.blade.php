@extends('layouts.base')

@section('title', 'Support Mailer')

@section('content')

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

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5">Admin Section</h1>
          <p class="lead">Select an option:</p>
          <ul>
            @foreach($adminSections as $name => $route)
            <li>
              <a href="/{{ $route }}">{{ $name }}</a>
            </li>
            @endforeach
          </ul>
         </div>
        </div>
      </div>
    </div>
@endsection
