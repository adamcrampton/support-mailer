@extends('layouts.admin-base')

@section('content')
<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12 mt-5">
				<h2 class="float-md-left">Restore Deleted Issue Types</h2>
				<div class="float-md-right">
					<a href="issue_types" class="btn btn-primary btn-right">Go Back</a>
				</div>
				{!! Form::open(['action' => ['IssueTypeController@batchUpdate'], 'class' => 'form']) !!}
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Name</th>
							<th scope="col" class="text-center">Restore</th>
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
								{{ Form::checkbox('issue['. $index .'][restore]', null, false, ['class' => 'form-check-input']) }}
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
