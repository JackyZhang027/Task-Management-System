@extends('adminlte::page')

@section('title', 'Location')

@section('content_header')
    <h1>Location - Add New</h1>
@stop

@section('content')
<div class="container-fluid">
		<div class="card border-0 shadow-sm rounded">
			<div class="card-body">
				<form action="{{ route('location.store') }}" method="POST">
					@csrf
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" name="name">
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
@stop

@section('css')

@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop