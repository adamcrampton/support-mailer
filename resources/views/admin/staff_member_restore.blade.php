@extends('layouts.admin-base')

@section('content')

<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12 mt-5">
				<h2 class="float-md-left">Restore Deleted Staff Members</h2>
				<div class="float-md-right">
					<a href="staff_members" class="btn btn-primary btn-right">Go Back</a>
				</div>
				{!! Form::open(['action' => ['StaffMemberController@batchUpdate'], 'class' => 'form', 'id' => 'update_form']) !!}
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">First Name</th>
							<th scope="col">Last Name</th>
							<th scope="col">Email</th>
							<th scope="col" class="text-center">Restore</th>
						</tr>
					</thead>
					@foreach($staffList as $index => $staff)
						<tr data-update-row="{{ $index }}">
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('staff['. $index .'][id]', $staff->id, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][original_value_staff_first_name]', $staff->staff_first_name, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][staff_first_name]', $staff->staff_first_name, ['class' => 'form-control first_name', 'data-input-type' => 'staff_first_name', 'required']) }}
							</td>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('staff['. $index .'][original_value_staff_last_name]', $staff->staff_last_name, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][staff_last_name]', $staff->staff_last_name, ['class' => 'form-control last_name', 'data-input-type' => 'staff_last_name', 'required']) }}

								{{-- Hidden fields for concatenating first + last names - updates automatically via JS --}}
								{{ Form::text('staff['. $index .'][original_value_staff_name]', $staff->staff_name, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][staff_name]', $staff->staff_name, [ 'data-input-type' => 'staff_name', 'class' => 'name', 'style' => 'display:none']) }}
							</td>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('staff['. $index .'][original_value_staff_email]', $staff->staff_email, ['style' => 'display:none']) }}
								{{ Form::text('staff['. $index .'][staff_email]', $staff->staff_email, ['class' => 'form-control', 'id' => 'staff_email', 'required']) }}
							</td>
							<td class="text-center">
								<div class="form-check">
								{{-- There will either be a value or not in $_POST, so the actual value of the field set doesn't matter. --}}
								{{ Form::checkbox('staff['. $index .'][restore]', null, false, ['class' => 'form-check-input']) }}
								</div>
							</td>
						</tr>
					@endforeach
						<tr>
							<td colspan="4" class="text-right">
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
