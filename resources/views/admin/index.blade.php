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
          <h1 class="mt-5">Hi {{ Auth::user()->user_first_name }}</h1>
          <p class="lead">Please select an option:</p>
          <ul>
            @foreach($adminSections as $name => $route)
            <li>
              <a href="/{{ $route }}">{{ $name }}</a>
            </li>
            @endforeach
            {{-- This route is guarded, but don't even both showing the option for non-admins. --}}
            @if(Auth::user()->permission->permission_name === 'admin')
            <li>
              <a href="/users">Manage Users</a>
            </li>
            @endif
          </ul>
         </div>
        </div>
      </div>
    </div>
@endsection
