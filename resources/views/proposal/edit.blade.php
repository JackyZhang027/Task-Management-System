@extends('adminlte::page')

@section('title', 'Edit Proposal')

@section('content_header')
    <h1>Proposal - Edit</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-body">
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <form id="proposalForm" action="{{ route('proposal.update', $proposal->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Use PUT method for update -->

                    <!-- Add an input field for the proposal ID -->
                    <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="invoice_no">Invoice No</label>
                                <input type="text" class="form-control" id="invoice_no" name="invoice_no" value="{{ $proposal->invoice_no }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ $proposal->Date }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="company_id">Company</label>
                                <select id="company_id" name="company_id" class="form-control" required>
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
                                <select id="location_id" name="location_id" class="form-control" required>
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

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="services">Services</label>
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th style="width: 20px">#</th>
                                            <th style="width: 70%">Services</th>
                                            <th>Fee</th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="service-checkbox" name="services[{{$service->id}}]"
                                                        {{ $proposal->services->contains('service_id', $service->id) ? 'checked' : '' }}>
                                                </td>
                                                <td>{{ $service->name }}</td>
                                                <td>
                                                    @php
                                                        $serviceData = $proposal->services->firstWhere('service_id', $service->id);
                                                        $feeValue = $serviceData ? $serviceData->Fee : '';
                                                    @endphp
                                                    <input type="number" name="fees[{{$service->id}}]" class="form-control" value="{{ $feeValue }}">
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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