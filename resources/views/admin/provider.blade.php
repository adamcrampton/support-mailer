@extends('layouts.admin-base')

@section('content')
<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="mt-5">Providers</h1>
				<h2 class="mt-5">Add New Provider</h2>
				<div class="card-body">
					{!! Form::open(['action' => ['ProviderController@store'], 'class' => 'form']) !!}
					<div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Provider Name</label>
				      <div class="col-lg-9">
				          {{ Form::text('provider_name', null, ['class' => 'form-control', 'id' => 'provider_name', 'required']) }}
					  </div>
					</div>
					<div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Provider Email</label>
				      <div class="col-lg-9">
				          {{ Form::text('provider_email', null, ['class' => 'form-control', 'id' => 'provider_email', 'required']) }}
					  </div>
					</div>
					<div class="form-group row text-right">
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
		<div class="row">
			<div class="col-lg-12">
				<h2 class="mt-5">Manage Providers</h2>
				{!! Form::open(['action' => ['ProviderController@batchUpdate'], 'class' => 'form']) !!}
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col" class="text-center">Delete</th>
						</tr>
					</thead>
					@foreach($providerList as $index => $provider)
						<tr>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('provider['. $index .'][id]', $provider->id, ['style' => 'display:none']) }}
								{{ Form::text('provider['. $index .'][original_value_provider_name]', $provider->provider_name, ['style' => 'display:none']) }}
								{{ Form::text('provider['. $index .'][provider_name]', $provider->provider_name, ['class' => 'form-control', 'id' => 'provider_name', 'required']) }}
							</td>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('provider['. $index .'][original_value_provider_email]', $provider->provider_email, ['style' => 'display:none']) }}
								{{ Form::text('provider['. $index .'][provider_email]', $provider->provider_email, ['class' => 'form-control', 'id' => 'provider_email', 'required']) }}
							</td>
							<td class="text-center">
								<div class="form-check">
								{{-- There will either be a value or not in $_POST, so the actual value of the field set doesn't matter. --}}
								{{ Form::checkbox('provider['. $index .'][delete]', null, false, ['class' => 'form-check-input']) }}
								</div>
							</td>
						</tr>
					@endforeach
						<tr>
							<td colspan="3" class="text-right">
								<input type="reset" class="btn btn-secondary" value="Cancel">
								{!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
							</td>
						</tr>
				</table>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection
