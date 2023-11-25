@extends('adminlte::page')

@section('title', 'Proposal')

@section('content_header')
    <h1>Proposal</h1>
@stop

@section('content')
<div class="container-fluid">
	<div class="card border-0 shadow-sm rounded">
		<div class="card-body">
			<a href="{{ route('proposal.create') }}" class="btn btn-md btn-success mb-3">
				<i class="fa fa-plus"></i> Add New Proposal
			</a>
			
			@if ($message = Session::get('success'))
				<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<p>{{ $message }}</p>
				</div>
			@endif

			<table class="table table-bordered">
				<thead class="bg-primary text-white text-center">
					<tr>
						<th scope="col">Invoice No</th>
						<th scope="col">Date</th>
						<th scope="col">Company</th>
						<th scope="col">Location</th>
						<th scope="col">Total Fee</th>
						<th scope="col">Current Process</th>
						<th scope="col">State</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					@forelse ($proposals as $proposal)
					<tr>
						<td>{{ $proposal->invoice_no }}</td>
						<td>{{ $proposal->Date }}</td>
						<td>{{ $proposal->company->name }}</td>
						<td>{{ $proposal->location->name }}</td>
						<td class="text-right">{{ number_format($proposal->totalFee, 0, '.', ',')}}</td>
						<td>{{ $proposal->process->name }}</td>
						<td>{{ $proposal->process_state->state }}</td>
						<td class="text-right">
							<form onsubmit="return confirm('Are you sure you want to delete this record?');" action="{{ route('proposal.destroy', $proposal->id) }}" method="POST">
								@if ($proposal->process->id == 1)
									<a href="{{ route('proposal.request_data', $proposal->id) }}" class="btn btn-sm btn-info">Request Data</a>
								@endif
								@if ($proposal->process->id == 2)
									<a href="{{ route('proposal.process_data', $proposal->id) }}" class="btn btn-sm btn-info">Process Data</a>
								@endif
								<a href="{{ route('proposal.edit', $proposal->id) }}" class="btn btn-sm btn-primary">Edit</a>
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-sm btn-danger">Delete</button>
							</form>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="4">No Data Available</td>
					</tr>
					@endforelse
				</tbody>
			</table>  
			<div class="d-flex justify-content-left">
				{{ $proposals->links() }}
			</div>
		</div>
	</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop