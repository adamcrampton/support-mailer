@extends('layouts.base')

@section('title', 'Support Mailer')

@section('content')

<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
      <div class="container">
        <a class="navbar-brand" href="#">Support Mailer</a>
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
        </div> --}}
      </div>
    </nav>

    @if ($errors->any())
    <div class="alert alert-danger">
        <p>Sorry, there was a problem submitting your form. Details:</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5">{{ $config->form_title }}</h1>
          <p class="lead">{!! $config->intro_html !!}</p>
         </div>
        <!-- Submission Form -->
        <div class="col-lg-12">
          <div class="card card-outline-secondary">
              <div class="card-header">
                  <h3 class="mb-0">Your Information</h3>
              </div>
              <div class="card-body">
                  {!! Form::open(['action' => 'SupportRequestController@store', 'class' => 'form']) !!}
                      {{-- Display select for providers if configured to do so. --}}
                      @if ($config->show_multiple_providers)
                       <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label" for="provider_list">Select a provider</label>
                        <div class="col-lg-9">
                          <select class="form-control" name="provider_list" id="provider_list">
                            <option selected="selected" value>Please select one:</option>
                            @foreach ($providers as $provider)
                              <option value="{{ $provider->id }}">{{ $provider->provider_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      @endif
                      {{-- Display either input fields or staff member select, depending on config option. --}}
                      @if ($config->use_staff_list)
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label" for="staff_list">Select your name (add your name in the Issue Details field if you can't find your name in the list)</label>
                        <div class="col-lg-9">
                          <select class="form-control" name="staff_list[]" id="staff_list">
                            <option selected="selected" value>Please select one:</option>
                            @foreach ($staffMembers as $staffMember)
                              <option value="[{{$staffMember->id}}, {{ $staffMember->staff_name }}, {{ $staffMember->staff_email }}]">{{ $staffMember->staff_name }}</option>
                            @endforeach
                            <option value="not_in_list">I'm not in this list</option>
                          </select>
                        </div>
                      </div>
                      @else
                      <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label">First name</label>
                          <div class="col-lg-9">
                              {{ Form::text('first_name', null, ['class' => 'form-control', 'id' => 'first_name']) }}
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label">Last name</label>
                          <div class="col-lg-9">
                            {{ Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name']) }}
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label">Email</label>
                          <div class="col-lg-9">
                              {{ Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) }}
                          </div>
                      </div>
                      @endif
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label" for="preferred_contact">Preferred contact method</label>
                        <div class="col-lg-9">
                          {{ Form::select('preferred_contact', ['email' => 'Email', 'phone' => 'Phone'], null, ['class' => 'form-control', 'id' => 'form-control', 'placeholder' => 'Choose an option:']) }}
                        </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label" for="phone_number">Phone number</label>
                          <div class="col-lg-9">
                              {{ Form::text('phone_number', null, ['class' => 'form-control', 'id' => 'phone_number']) }}
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label" for="issue_type">Select an issue type</label>
                        <div class="col-lg-9">
                          <select class="form-control" name="issue_type" id="issue_type">
                            <option selected="selected" value>Please select one:</option>
                            @foreach ($issueList as $issueType)
                              <option value="{{ $issueType->id }}">{{ $issueType->issue_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                       <label class="col-lg-3 col-form-label form-control-label">Issue Details</label>
                          <div class="col-lg-9">
                              {{ Form::textarea('issue_details', null, ['class' => 'form-control', 'id' => 'issue_details', 'rows' => '6']) }}
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label"></label>
                          <div class="col-lg-9">
                              <input type="reset" class="btn btn-secondary" value="Cancel">
                              {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                          </div>
                      </div>
                  {!! Form::close() !!}
              </div>
          </div>
        </div>
      </div>
    </div>
@endsection
