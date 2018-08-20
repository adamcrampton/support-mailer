@extends('layouts.admin-base')

@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
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
