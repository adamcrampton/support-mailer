@extends('layouts.admin-base')

@section('content')

<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="mt-5 float-md-left">Restore Deleted Users</h2>
				<div class="float-md-right">
					<a href="user" class="btn btn-primary btn-right">Go Back</a>
				</div>
				{!! Form::open(['action' => ['UserController@batchUpdate'], 'class' => 'form', 'id' => 'update_form']) !!}
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">First Name</th>
							<th scope="col">Last Name</th>
							<th scope="col">Email</th>
							<th scope="col">Permission Level</th>
							<th scope="col" class="text-center">Delete</th>
						</tr>
					</thead>
					@foreach($userList as $index => $user)
						<tr>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('user['. $index .'][id]', $user->id, ['style' => 'display:none']) }}
								{{ Form::text('user['. $index .'][original_value_user_first_name]', $user->user_first_name, ['style' => 'display:none']) }}
								{{ Form::text('user['. $index .'][user_first_name]', $user->user_first_name, ['class' => 'form-control first_name', 'data-input-type' => 'user_first_name', 'data-update-row' => $index, 'required']) }}
							</td>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('user['. $index .'][original_value_user_last_name]', $user->user_last_name, ['style' => 'display:none']) }}
								{{ Form::text('user['. $index .'][user_last_name]', $user->user_last_name, ['class' => 'form-control last_name', 'data-input-type' => 'user_last_name', 'data-update-row' => $index, 'required']) }}

								{{-- Hidden fields for concatenating first + last names - updates automatically via JS --}}
								{{ Form::text('user['. $index .'][original_value_user_name]', $user->user_name, ['style' => 'display:none']) }}
								{{ Form::text('user['. $index .'][user_name]', $user->user_name, [ 'data-update-row' => $index, 'data-input-type' => 'user_name', 'class' => 'name', 'style' => 'display:none']) }}
							</td>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('user['. $index .'][original_value_user_email]', $user->user_email, ['style' => 'display:none']) }}
								{{ Form::text('user['. $index .'][user_email]', $user->user_email, ['class' => 'form-control', 'id' => 'user_email', 'required']) }}
							</td>
							<td>								
								<div class="form-group row required">
									<div class="col-lg-9">
										<select class="form-control" name="permission_list" id="permission_list" required>
								        <option value required>Please select one:</option>
								        @foreach ($permissionList as $permission)
								          <option value="{{ $permission->id }}" {{ ($permission->id == $user->permission_fk) ? 'selected' : '' }}>{{ $permission->permission_name }}</option>
								        @endforeach
								      </select>
									</div>
								</div>
							</td>
							<td class="text-center">
								<div class="form-check">
								{{-- There will either be a value or not in $_POST, so the actual value of the field set doesn't matter. --}}
								{{ Form::checkbox('user['. $index .'][restore]', null, false, ['class' => 'form-check-input']) }}
								</div>
							</td>
						</tr>
					@endforeach
						<tr>
							<td colspan="5" class="text-right">
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
