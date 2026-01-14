@extends('layouts.master')
@section('content')
    <div class="main-content pt-4">
        <div class="breadcrumb">
            <h1>Leave Request</h1>
            @if (isset($leave_request))
                <ul>
                    <li>Update</li>
                    <li>Edit</li>
                </ul>
            @else
                <ul>
                    <li>Create</li>
                    <li>Add</li>
                </ul>
            @endif
        </div>
        <div class="separator-breadcrumb border-top"></div>
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <form action="{{ url('leave-requests/store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ isset($leave_request) ? $leave_request->id : '' }}" />
                                <div class="col-md-6 form-group mb-3">
                                    <label for="employee_id">Employee<span class="text-danger">*</span> </label>
                                    <select name="employee_id" class="form-control" id="employee_id" style="width: 100%;">
                                        <option value="" selected disabled>--Select Employee--</option>
                                        @foreach ($employees as $item)
                                            <option value="{{ $item->id }}"
                                                {{ isset($leave_request) && $leave_request->employee_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->employee_id ?? '' }} - {{ $item->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="leave_type_id">Leave Type<span class="text-danger">*</span> </label>
                                    <select name="leave_type_id" class="form-control" id="leave_type_id" style="width: 100%;">
                                        <option value="" selected disabled>--Select Leave Type--</option>
                                        @foreach ($leave_types as $item)
                                            <option value="{{ $item->id }}"
                                                {{ isset($leave_request) && $leave_request->leave_type_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('leave_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="from_date">From Date<span class="text-danger">*</span> </label>
                                    <input class="form-control" type="date" name="from_date"
                                        value="{{ isset($leave_request) ? $leave_request->from_date : old('from_date') }}"  required />
                                    @error('from_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="to_date">To Date<span class="text-danger">*</span> </label>
                                    <input class="form-control" type="date" name="to_date"
                                        value="{{ isset($leave_request) ? $leave_request->to_date : old('to_date') }}"  required />
                                    @error('to_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label for="reason">Reason</label>
                                    <textarea class="form-control" type="date" name="reason">{{ isset($leave_request) ? $leave_request->reason : old('reason') }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ url('leave-requests') }}" class="btn btn-danger">Cancel</a>
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- end of main-content -->
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#employee_id').select2();
            $('#leave_type_id').select2();
        });

        function isNumberKey(evt) {
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
@endsection
