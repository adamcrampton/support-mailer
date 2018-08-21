@extends('layouts.admin-base')

@section('content')

<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="mt-5">Staff Members</h1>
				<h2 class="mt-5">Add New Staff Member</h2>
				<div class="card-body">
					{!! Form::open(['action' => ['StaffMemberController@store'], '`class' => 'form']) !!}
					<div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Staff Member First Name</label>
				      <div class="col-lg-9">
				          {{ Form::text('first_name', null, ['class' => 'form-control', 'id' => 'first_name', 'required']) }}
					  </div>
					</div>
					<div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Staff Member Last Name</label>
				      <div class="col-lg-9">
				          {{ Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name', 'required']) }}
					  </div>
					</div>
					<div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Staff Member Email</label>
				      <div class="col-lg-9">
				          {{ Form::text('staff_email', null, ['class' => 'form-control', 'id' => 'email', 'required']) }}
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
				<h2 class="mt-5">Manage Staff Members</h2>
				{!! Form::open(['action' => ['StaffMemberController@batchUpdate'], 'class' => 'form']) !!}
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">First Name</th>
							<th scope="col">Last Name</th>
							<th scope="col">Email</th>
							<th scope="col" class="text-center">Delete</th>
						</tr>
					</thead>
					@foreach($staffList as $index => $staff)
						<tr>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('staff['. $index .'][id]', $staff->id, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][original_value_first_name]', $staff->staff_first_name, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][first_name]', $staff->staff_first_name, ['class' => 'form-control', 'id' => 'first_name', 'required']) }}
							</td>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('staff['. $index .'][id]', $staff->id, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][original_value_last_name]', $staff->staff_last_name, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][last_name]', $staff->staff_last_name, ['class' => 'form-control', 'id' => 'last_name', 'required']) }}
							</td>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('staff['. $index .'][original_value_email]', $staff->staff_email, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][email]', $staff->staff_email, ['class' => 'form-control', 'id' => 'email', 'required']) }}
							</td>
							<td class="text-center">
								<div class="form-check">
								{{-- There will either be a value or not in $_POST, so the actual value of the field set doesn't matter. --}}
								{{ Form::checkbox('staff['. $index .'][delete]', null, false, ['class' => 'form-check-input']) }}
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
