@extends('layouts.admin-base')

@section('content')
<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="mt-5">Issue Types</h1>
				<h2 class="mt-5">Add New Issue Type</h2>
				<div class="card-body">
					{!! Form::open(['action' => ['IssueTypeController@store'], 'class' => 'form']) !!}
					<div class="form-group row required">
				      <label class="col-lg-3 col-form-label form-control-label">Add new Issue Type</label>
				      <div class="col-lg-9">
				          {{ Form::text('issue_name', null, ['class' => 'form-control', 'id' => 'issue_name', 'required']) }}
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
				<h2 class="mt-5">Manage Issue Types</h2>
				{!! Form::open(['action' => ['IssueTypeController@batchUpdate'], 'class' => 'form']) !!}
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Name</th>
							<th scope="col" class="text-center">Delete</th>
						</tr>
					</thead>
					@foreach($issueList as $index => $issue)
						<tr>
							<td>
								{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
								{{ Form::text('issue['. $index .'][id]', $issue->id, ['style' => 'display:none']) }}
								{{ Form::text('issue['. $index .'][original_value_issue_name]', $issue->issue_name, ['style' => 'display:none']) }}
								{{ Form::text('issue['. $index .'][issue_name]', $issue->issue_name, ['class' => 'form-control', 'id' => 'issue_name', 'required']) }}
							</td>
							<td class="text-center">
								<div class="form-check">
								{{-- There will either be a value or not in $_POST, so the actual value of the field set doesn't matter. --}}
								{{ Form::checkbox('issue['. $index .'][delete]', null, false, ['class' => 'form-check-input']) }}
								</div>
							</td>
						</tr>
					@endforeach
						<tr>
							<td colspan="2" class="text-right">
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
