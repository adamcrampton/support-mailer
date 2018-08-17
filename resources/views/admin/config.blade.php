@extends('layouts.admin-base')

@section('content')
    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5">Global Configuration</h1>
          	<div class="card-body">
				{!! Form::open(['action' => ['ConfigController@update', $config->id], 'class' => 'form']) !!}
				{{ method_field('PATCH') }}
				  <div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Form Heading</label>
				      <div class="col-lg-9">
				          {{ Form::text('form_heading', $config->form_heading, ['class' => 'form-control', 'id' => 'form_heading', 'required']) }}
				      </div>
				  </div>
				  <div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Form Title</label>
				      <div class="col-lg-9">
				          {{ Form::text('form_title', $config->form_title, ['class' => 'form-control', 'id' => 'form_title', 'required']) }}
				      </div>
				  </div>
				  <div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Intro HTML</label>
				      <div class="col-lg-9">
				          {{ Form::textarea('intro_html', $config->intro_html, ['class' => 'form-control', 'id' => 'intro_html', 'required']) }}
				      </div>
				  </div>
				  <div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Default Provider</label>
					<div class="col-lg-9">
				      <select class="form-control" name="provider_list" id="provider_list" required>
				        <option value required>Please select one:</option>
				        @foreach ($providerList as $provider)
				          <option value="{{ $provider->id }}" {{ ($provider->id == $config->default_provider_fk) ? 'selected' : '' }}>{{ $provider->provider_name }}</option>
				        @endforeach
				      </select>
					</div>
				  </div>
				  <div class="form-group row required">
				      {{-- Select --}}
				      <label class="col-lg-3 col-form-label form-control-label">Show Multiple Providers</label>
				      <div class="col-lg-9">
						<select class="form-control" name="show_multiple_providers" id="show_multiple_providers" required>
							<option value="{{ $config->show_multiple_providers }}">{{ $config->show_multiple_providers ? 'Yes' : 'No' }}</option>
						</select>
				      </div>	      
				  </div>
				  <div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Use Staff List</label>
				      <div class="col-lg-9">
				      	<select class="form-control" name="use_staff_list" id="use_staff_list" required>
							<option value="{{ $config->use_staff_list }}">{{ $config->use_staff_list ? 'Yes' : 'No' }}</option>
						</select>
				      </div>
				      {{-- Select --}}
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
    </div>
@endsection
