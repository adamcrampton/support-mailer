@extends('layouts.base')

@section('title', 'Support Mailer')

@section('content')

<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
      <div class="container">
        <a class="navbar-brand" href="#">{{ $config->form_heading }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/admin">Admin Login
                <span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
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
    @elseif (session()->has('warning'))
      <div class="alert alert-warning">
        {!! session()->get('warning') !!}
      </div>
    @elseif (session()->has('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
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
                  {!! Form::open(['action' => 'SupportRequestController@store', 'files' => 'true', 'class' => 'form']) !!}
                      {{-- Display select for providers if configured to do so. --}}
                      @if ($config->show_multiple_providers)
                       <div class="form-group row required">
                        <label class="col-lg-3 col-form-label form-control-label" for="provider_list">Select a provider</label>
                        <div class="col-lg-9">
                          <select class="form-control" name="provider_list" id="provider_list" required>
                            <option selected="selected" value required>Please select one:</option>
                            @foreach ($providers as $provider)
                              <option value="{{ $provider->id }}" {{ (old('provider_list') == $provider->id) ? 'selected' : '' }}>{{ $provider->provider_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      @endif
                      {{-- Display either input fields or staff member select, depending on config option. --}}
                      @if ($config->use_staff_list)
                      <div class="form-group row required">
                        <label class="col-lg-3 col-form-label form-control-label" for="staff_list">Select your name</label>
                        <div class="col-lg-9">
                          <select class="form-control" name="staff_list" id="staff_list" required>
                            <option selected="selected" value>Please select one:</option>
                            @foreach ($staffMembers as $staffMember)
                              <option value="{{$staffMember->id}}" {{ old('staff_list') == $staffMember->id ? 'selected' : '' }}>{{ $staffMember->staff_first_name }} {{ $staffMember->staff_last_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      @else
                      <div class="form-group row required">
                          <label class="col-lg-3 col-form-label form-control-label">First name</label>
                          <div class="col-lg-9">
                              {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'id' => 'first_name', 'required']) }}
                          </div>
                      </div>
                      <div class="form-group row required">
                          <label class="col-lg-3 col-form-label form-control-label">Last name</label>
                          <div class="col-lg-9">
                            {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'id' => 'last_name', 'required']) }}
                          </div>
                      </div>
                      <div class="form-group row required">
                          <label class="col-lg-3 col-form-label form-control-label">Email</label>
                          <div class="col-lg-9">
                              {{ Form::email('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'required']) }}
                          </div>
                      </div>
                      @endif
                      <div class="form-group row required">
                        <label class="col-lg-3 col-form-label form-control-label" for="preferred_contact">Preferred contact method</label>
                        <div class="col-lg-9">
                          {{ Form::select('preferred_contact', ['email' => 'Email', 'phone' => 'Phone'], old('preferred_contact'), ['class' => 'form-control', 'id' => 'preferred_contact', 'placeholder' => 'Choose an option:', 'required']) }}
                        </div>
                      </div>
                      {{-- Visibility and required attributes toggled by JS --}}
                      <div class="form-group row" id="phone_number_row" style="display:none;">
                          <label class="col-lg-3 col-form-label form-control-label" for="phone_number">Phone number</label>
                          <div class="col-lg-9">
                              {{ Form::text('phone_number', old('phone_number'), ['class' => 'form-control', 'id' => 'phone_number']) }}
                          </div>
                      </div>
                      <div class="form-group row required">
                        <label class="col-lg-3 col-form-label form-control-label" for="issue_type">Select an issue type</label>
                        <div class="col-lg-9">
                          <select class="form-control" name="issue_type" id="issue_type" required>
                            <option selected="selected" value>Please select one:</option>
                            @foreach ($issueList as $issueType)
                              <option value="{{ $issueType->id }}" {{ (old('issue_type') == $issueType->id) ? 'selected' : '' }}>{{ $issueType->issue_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group row required">
                       <label class="col-lg-3 col-form-label form-control-label">Issue details</label>
                          <div class="col-lg-9">
                              {{ Form::textarea('issue_details', old('issue_details'), ['class' => 'form-control', 'id' => 'issue_details', 'rows' => '6', 'required']) }}
                          </div>
                      </div>
                      <div class="form-group row required">
                       <label class="col-lg-3 col-form-label form-control-label">Upload files (optional)</label>
                          <div class="col-lg-9">
                              {{ Form::file('uploaded_files[]', ['multiple' => true, 'class' => 'form-control-file']) }}
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
