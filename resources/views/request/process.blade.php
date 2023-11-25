@extends('adminlte::page')

@section('title', 'Process Data')

@section('content_header')
    <h1>Process Data</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-body">
                @if ($message = Session::get('error'))
                    <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <form method="post" action="{{ route('request.update.transactions') }}">
                    @csrf
                    @method('patch')
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Add an input field for the proposal ID -->
                    <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="invoice_no">Invoice No</label>
                                <input type="text" class="form-control" id="invoice_no" name="invoice_no" value="{{ $proposal->invoice_no }}" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ $proposal->Date }}" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="company_id">Company</label>
                                <select id="company_id" name="company_id" class="form-control" readonly>
                                    <option value="">Select One</option>
                                    @foreach ($companies as $id => $name)
                                        <option value="{{ $id }}" {{ $id == $proposal->company_id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="location_id">Location</label>
                                <select id="location_id" name="location_id" class="form-control" readonly>
                                    <option value="">Select One</option>
                                    @foreach ($locations as $id => $name)
                                        <option value="{{ $id }}" {{ $id == $proposal->location_id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    @foreach ($proposal->services as $service)
                        <!-- Consider if the hidden input is necessary -->
                        <input type="hidden" name="services[{{$service->service->id}}]" value="{{ $proposal->id }}">
                        
                        <h5 class="text-primary font-weight-bolder">{{$service->service->name}}</h5>
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th style="width:10px;">#</th>
                                    <th>Documents</th>
                                    <th>Has been processed</th>
                                    <th>Remark</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($proposal->proposal_transaction->where('service_id', $service->service->id)->where('proposal_id', $proposal->id) as $transaction)
                                @if ($transaction->mapping->process_id == 2)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $transaction->mapping->name }}</td>
                                    <td>
                                        <input type="checkbox" name="transactions[{{ $transaction->id }}][is_checked]" 
                                            {{ $transaction->is_checked ? 'checked' : '' }}>
                                        
                                        @if($transaction->is_checked)
                                            Received By <strong>{{$transaction->checkedByUser->name}}</strong> on 
                                            <strong>{{$transaction->checked_date}}       
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="transactions[{{ $transaction->id }}][remark]" 
                                            value="{{ $transaction->remark }}"/>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @endforeach                    
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop


@section('js')
    <script>
        // Function to validate the form
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('proposalForm').addEventListener('submit', function (event) {
                var selectedServices = document.querySelectorAll('.service-checkbox:checked');
                var valid = false;

                for (var i = 0; i < selectedServices.length; i++) {
                    var serviceId = selectedServices[i].getAttribute('data-id');
                    var feeInput = document.querySelector('input[name="fees[' + serviceId + ']"]');
                    if (feeInput.value.trim() === '' || feeInput.value === null) {
                        alert('Please provide a fee for the selected services.');
                        valid = false;
                        event.preventDefault(); // Prevent form submission
                        break;
                    } else {
                        valid = true;
                    }
                }

                if (selectedServices.length < 1) {
                    alert('Please select at least one service.');
                    valid = false;
                    event.preventDefault(); // Prevent form submission
                }

                return valid;
            });
        });


    </script>
@stop