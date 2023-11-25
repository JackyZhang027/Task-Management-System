@extends('adminlte::page')

@section('title', 'Services Mapping - Add New')

@section('content_header')
    <h1>Services Mapping - Add New</h1>
@stop

@section('content')
<div class="container-fluid">
	<div class="card border-0 shadow-sm rounded">
		<div class="card-body">
			<form action="{{ route('documents.store') }}" method="POST">
				@csrf
				<div class="form-group">
					<label for="name">Service</label>
					<select id="service_id" name="service_id" class="form-control" required>
						<option value="">Select One</option>
						@foreach ($services as $id => $name)
							<option value="{{ $id }}">{{ $name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="name">Process Step</label>
					<select id="process_id" name="process_id" class="form-control" required>
						<option value="">Select One</option>
						@foreach ($categories as $id => $name)
							<option value="{{ $id }}">{{ $name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" id="name" name="name">
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<textarea class="form-control" id="description" name="description"></textarea>
				</div>
				<div class="form-group">
					<label for="name">Sequence No</label>
					<input type="number" class="form-control" id="sequence_no" name="sequence_no">
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
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