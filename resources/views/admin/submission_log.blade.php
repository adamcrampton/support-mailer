@extends('layouts.admin-base')

@section('content')
<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="mt-5">Submission Log</h1>
			</div>
		</div>
		<div class="row">
			
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Date</th>
							<th scope="col">Email Sent</th>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Phone Number</th>
							<th scope="col">Provider</th>
							<th scope="col">Contact Method</th>
							<th scope="col">Issue Type</th>
						</tr>
					</thead>
					@foreach($logData as $data)
						<tr>
							<td>{{ $data->created_at }}</td>
							<td>{{ $data->email_sent }}</td>
							<td>{{ $data->staff_name }}</td>
							<td>{{ $data->staff_email }}</td>
							<td>{{ $data->staff_phone }}</td>
							<td>{{ $data->provider_name_fk }}</td>
							<td>{{ $data->contact_method }}</td>
							<td>{{ $data->issue_type_fk }}</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
@endsection
