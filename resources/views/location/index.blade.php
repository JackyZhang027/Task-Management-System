
@extends('adminlte::page')

@section('title', 'Location')

@section('content_header')
    <h1>Locations</h1>
@stop

@section('content')
<div class="container-fluid">
		<div class="card border-0 shadow-sm rounded">
			<div class="card-body">
				<a href="{{ route('location.create') }}" class="btn btn-md btn-success mb-3">
					<i class="fa fa-plus"></i> Add New Location
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
							<th scope="col">Active</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						@forelse ($locations as $location)
						<tr>
							<td>{{ $location->name }}</td>
							<td class="text-center"><input type="checkbox" {{ $location->is_active == 1 ? 'checked' : '' }} disabled></td>
							<td class="text-right">
								<form onsubmit="return confirm('Are you Sure want to delete this record?');" action="{{ route('location.destroy', $location->id) }}" method="POST">
									<a href="{{ route('location.edit', $location->id) }}" class="btn btn-sm btn-primary">Edit</a>
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
					{{ $locations->links() }}
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