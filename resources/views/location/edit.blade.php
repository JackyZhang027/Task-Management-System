@extends('adminlte::page')

@section('title', 'Location')

@section('content_header')
    <h1>Location - Edit</h1>
@stop

@section('content')
<div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
		<div class="card border-0 shadow-sm rounded">
			<div class="card-body">
                <form action="{{ route('location.update', $location->id) }}" method="POST">
                    @csrf
                    @method('PUT')
            
					<div class="form-group">
						<label for="name">Name{{$location->id}}</label>
						<input type="text" class="form-control" name="name" value="{{ $location->name }}" >
					</div>                    
					<div class="form-group">
                        <input type="checkbox" name="is_active"  {{ $location->is_active == 1 ? 'checked' : '' }} >
						<label for="is_active">Is Active ?</label>
					</div>


					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
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