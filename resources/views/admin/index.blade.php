@extends('layouts.admin-base')

@section('content')
    @if (session('status'))
    <div class="card-body">
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
    </div>
    @endif
    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5">Hi {{ Auth::user()->user_first_name }}</h1>
          @can('editor-functions', auth()->user())
          <p class="lead">Edit options</p>
          <ul>
            @foreach($adminSections as $name => $route)
            <li>
              <a href="/{{ $route }}">{{ $name }}</a>
            </li>
            @endforeach
          </ul>
          @endcan
          @can('admin-functions', auth()->user())
          <p class="lead">Admin options</p>
          <ul>
            <li>
              <a href="/config">Global Configuration</a>
            </li>
            <li>
              <a href="/users">Manage Users</a>
            </li>         
          </ul>
          @endcan
          <p class="lead">Tools</p>
          <ul>
            <li>
              <a href="/logs">View Logs</a>
            </li>
          </ul>
         </div>
        </div>
      </div>
    </div>
@endsection
