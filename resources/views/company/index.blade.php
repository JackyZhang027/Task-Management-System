
@extends('adminlte::page')

@section('title', 'Company')

@section('content_header')
    <h1>Companies</h1>
@stop

@section('content')
<div class="container-fluid">
		<div class="card border-0 shadow-sm rounded">
			<div class="card-body">
				<a href="{{ route('company.create') }}" class="btn btn-md btn-success mb-3">
					<i class="fa fa-plus"></i> Add New Company
				</a>
				
				@if ($message = Session::get('success'))
					<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<p>{{ $message }}</p>
					</div>
				@endif

				<table class="table table-bordered">
					<thead class="bg-primary text-white text-center datatable	">
						<tr>
							<th scope="col">Name</th>
							<th scope="col">Address</th>
							<th scope="col">Active</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						@forelse ($companies as $company)
						<tr>
							<td>{{ $company->name }}</td>
							<td>{!! $company->address !!}</td>
							<td class="text-center"><input type="checkbox" {{ $company->is_active == 1 ? 'checked' : '' }} disabled></td>
							<td class="text-right">
								<form onsubmit="return confirm('Are you Sure want to delete this record?');" action="{{ route('company.destroy', $company->id) }}" method="POST">
									<a href="{{ route('company.edit', $company->id) }}" class="btn btn-sm btn-primary">Edit</a>
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
					{{ $companies->links() }}
				</div>
		</div>
	</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop