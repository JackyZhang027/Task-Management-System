@extends('adminlte::page')

@section('title', 'Services Mapping - Edit')

@section('content_header')
    <h1>Services Mapping - Edit</h1>
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
                <form action="{{ route('documents.update',$documents->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
					<label for="name">Service</label>
                        <select id="service_id" name="service_id" class="form-control" required>
                            <option value="">Select One</option>
                            @foreach ($services as $id => $name)
                                <option value="{{ $id }}" {{ $id == $documents->service_id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Process Step</label>
                        <select id="process_id" name="process_id" class="form-control" required>
                            <option value="">Select One</option>
                            @foreach ($categories as $id => $name)
                                <option value="{{ $id }}" {{ $id == $documents->process_id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" value="{{ $documents->name }}" >
					</div>
					<div class="form-group">
						<label for="description">Description</label>
                        <textarea class="form-control" name="description">{{ $documents->description }}</textarea>
					</div>
                    <div class="form-group">
                        <label for="name">Sequence No</label>
                        <input type="number" class="form-control" id="sequence_no" name="sequence_no" value="{{ $documents->sequence_no }}">
                    </div>
                    
					<div class="form-group">
                        <input type="checkbox" name="is_active"  {{ $documents->is_active == 1 ? 'checked' : '' }} >
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