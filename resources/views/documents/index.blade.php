@extends('adminlte::page')

@section('title', 'Services Mapping')

@section('content_header')
    <h1>Services Mapping</h1>
@stop

@section('content')
<div class="container-fluid">
		<div class="card border-0 shadow-sm rounded">
			<div class="card-body">
				<a href="{{ route('documents.create') }}" class="btn btn-md btn-success mb-3">
					<i class="fa fa-plus"></i> Add New Document
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
							<th scope="col">#</th>
							<th scope="col" class="text-left">Service</th>
							<th scope="col" class="text-left">Process Step</th>
							<th scope="col" class="text-left">Document Name</th>
							<th scope="col" class="text-left">Description</th>
							<th scope="col">Sequence No.</th>
							<th scope="col">Active</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						@php
							$sequenceNumber = 1;
						@endphp
						@forelse ($documents as $document)
						<tr>
							<td class="text-center">{{ $sequenceNumber }}</td>
							<td>{{ $document->service->name }}</td>
							<td>{{ $document->category->name }}</td>
							<td>{{ $document->name }}</td>
							<td>{!! $document->description !!}</td>
							<td class="text-center">{{ $document->sequence_no }}</td>
							<td class="text-center"><input type="checkbox" {{ $document->is_active == 1 ? 'checked' : '' }} disabled></td>
							<td class="text-right">
								<form onsubmit="return confirm('Are you Sure want to delete this record?');" action="{{ route('documents.destroy', $document->id) }}" method="POST">
									<a href="{{ route('documents.edit', $document->id) }}" class="btn btn-sm btn-primary">Edit</a>
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-danger">Delete</button>
								</form>
							</td>
						</tr>
						@php
							$sequenceNumber++;
						@endphp
						@empty
						<tr>
							<td colspan="6">No Data Available</td>
						</tr>
						@endforelse
					</tbody>
				</table>  
				<div class="d-flex justify-content-left">
					{{ $documents->links() }}
				</div>
			</div>
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