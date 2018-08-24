@extends('layouts.admin-base')

@section('content')

<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12 mt-5">
				<h2 class="float-md-left">Restore Deleted Providers</h2>
				<div class="float-md-right">
					<a href="providers" class="btn btn-primary btn-right">Go Back</a>
				</div>
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
								{{ Form::checkbox('provider['. $index .'][restore]', null, false, ['class' => 'form-check-input']) }}
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
