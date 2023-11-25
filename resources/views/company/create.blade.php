@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Company - Add New</h1>
@stop

@section('content')
<div class="container-fluid">
		<div class="card border-0 shadow-sm rounded">
			<div class="card-body">
				<form action="{{ route('company.store') }}" method="POST">
					@csrf
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" name="name">
					</div>
					<div class="form-group">
						<label for="address">Address</label>
						<textarea class="form-control" id="address" name="address"></textarea>
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