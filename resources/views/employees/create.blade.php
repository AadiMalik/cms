@extends('layouts.master')
@section('css')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 45px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection
@section('content')
    <div class="main-content pt-4">
        <div class="breadcrumb">
            <h1>Employee</h1>
            @if (isset($employee))
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
                    <form action="{{ url('employees/store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ isset($employee) ? $employee->id : '' }}" />
                                <div class="col-md-3 form-group mb-3">
                                    <label for="employee">Employee ID<span class="text-danger">*</span> </label>
                                    <input class="form-control" type="text" name="employee_id"
                                        value="{{ isset($employee) ? $employee->employee_id : old('employee_id') }}"
                                        maxlength="191" placeholder="Enter employee id" required />
                                    @error('employee_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="name">Full Name<span class="text-danger">*</span> </label>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ isset($employee) ? $employee->name : old('name') }}" maxlength="191"
                                        placeholder="Enter name" required />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="cnic">CNIC<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="cnic"
                                        value="{{ isset($employee) ? $employee->cnic : old('cnic') }}" maxlength="191"
                                        placeholder="Enter CNIC" required />
                                    @error('cnic')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="contact">Contact<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="contact"
                                        value="{{ isset($employee) ? $employee->contact : old('contact') }}" maxlength="191"
                                        placeholder="Enter contact" required />
                                    @error('contact')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ isset($employee) ? $employee->email : old('email') }}" maxlength="191"
                                        placeholder="Enter email" required />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="gender">Gender<span class="text-danger">*</span></label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Shemale">Shemale</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="date_of_birth">Date of Birth<span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="date_of_birth"
                                        value="{{ isset($employee) ? $employee->date_of_birth : old('date_of_birth') }}"
                                        required />
                                    @error('date_of_birth')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="address">Address<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ isset($employee) ? $employee->address : old('address') }}"
                                        maxlength="191" placeholder="Enter address" required />
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="emergency_name">Emergency Contact Name<span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="emergency_name"
                                        value="{{ isset($employee) ? $employee->emergency_name : old('emergency_name') }}"
                                        maxlength="191" placeholder="Enter emergency contact name" required />
                                    @error('emergency_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="emergency_contact">Emergency Contact<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="emergency_contact"
                                        value="{{ isset($employee) ? $employee->emergency_contact : old('emergency_contact') }}"
                                        maxlength="191" placeholder="Enter emergency contact" required />
                                    @error('emergency_contact')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="emergency_relation">Emergency Relation<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="emergency_relation"
                                        value="{{ isset($employee) ? $employee->emergency_relation : old('emergency_relation') }}"
                                        maxlength="191" placeholder="Enter emergency relation" required />
                                    @error('emergency_relation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="designation_id">Designation<span class="text-danger">*</span></label>
                                    <select name="designation_id" id="designation_id" class="form-control" required>
                                        <option value="" selected>--Select Designation--</option>
                                        @foreach ($designations as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($employee)) {{ $employee->designation_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('designation_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="department_id">Department<span class="text-danger">*</span> </label>
                                    <select name="department_id" id="department_id" class="form-control" required>
                                        <option value="" selected>--Select Department--</option>
                                        @foreach ($departments as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($employee)) {{ $employee->department_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="employee_type">Employee Type<span class="text-danger">*</span> </label>
                                    <select name="employee_type" id="employee_type" class="form-control" required>
                                        <option value="" selected>--Select Employee Type--</option>
                                        @foreach (config('enum.employee_type') as $item)
                                            <option value="{{ $item }}"
                                                @if (isset($employee)) {{ $employee->employee_type == $item ? 'selected' : '' }} @endif>
                                                {{ $item ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="shift">Shift<span class="text-danger">*</span> </label>
                                    <select name="shift" id="shift" class="form-control" required>
                                        <option value="" selected>--Select Shift--</option>
                                        @foreach (config('enum.shift') as $item)
                                            <option value="{{ $item }}"
                                                @if (isset($employee)) {{ $employee->shift == $item ? 'selected' : '' }} @endif>
                                                {{ $item ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="date_of_joining">Date of Joining<span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="date_of_joining"
                                        value="{{ isset($employee) ? $employee->date_of_joining : old('date_of_joining') }}"
                                        required />
                                    @error('date_of_joining')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="salary">Salary<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="salary"
                                        value="{{ isset($employee) ? $employee->salary : old('salary') }}"
                                        onkeypress="return isNumberKey(event)" maxlength="10" placeholder="Enter salary"
                                        required />
                                    @error('salary')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="payment_method">Payment Method<span class="text-danger">*</span> </label>
                                    <select name="payment_method" id="payment_method" class="form-control" required>
                                        <option value="" selected>--Select Payment Method--</option>
                                        @foreach (config('enum.payment_method') as $item)
                                            <option value="{{ $item }}"
                                                @if (isset($employee)) {{ $employee->payment_method == $item ? 'selected' : '' }} @endif>
                                                {{ $item ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="bank_name">Bank Name</label>
                                    <input class="form-control" type="text" name="bank_name"
                                        value="{{ isset($employee) ? $employee->bank_name : old('bank_name') }}"
                                        maxlength="191" placeholder="Enter bank name" />
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="account_title">Account Title</label>
                                    <input class="form-control" type="text" name="account_title"
                                        value="{{ isset($employee) ? $employee->account_title : old('account_title') }}"
                                        maxlength="191" placeholder="Enter account title" />
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="account_no">Account No</label>
                                    <input class="form-control" type="text" name="account_no"
                                        value="{{ isset($employee) ? $employee->account_no : old('account_no') }}"
                                        maxlength="16" placeholder="Enter account no" />
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="is_overtime">Over Time<span class="text-danger">*</span> </label>
                                    <select name="is_overtime" id="is_overtime" class="form-control" required>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    @error('is_overtime')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="account_id">Account (COA)</label>
                                    <select class="form-control select2" name="account_id" id="account_id"
                                        style="width: 100%;">
                                        <option value="">--Select Account--</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}"
                                                {{ isset($employee) && $employee->account_id == $account->id ? 'selected' : '' }}>
                                                {{ $account->code ?? '' }} - {{ $account->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="picture">Picture<span class="text-danger">*</span> </label>
                                    <input class="form-control" type="file" name="picture"
                                        accept=".jpg, .jpeg, .png" />
                                    @error('picture')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if (isset($employee))
                                    <div class="col-md-12 form-group mb-3">
                                        <b>Picture <small>(if add then change)</small></b><br>
                                        <a href="{{ asset($employee->picture) }}" target="_blank"><img
                                                src="{{ asset($employee->picture) }}" style="width:100px; height: 100px;"
                                                alt="Image"></a>
                                    </div>
                                @endif
                                @if(!isset($employee))
                                <div class="col-md-12 mt-3">
                                    <h5 class="mb-2">Allowed Leaves</h5>

                                    <div class="row">
                                        @foreach ($leave_types as $type)
                                            <div class="col-md-4 mb-2">
                                                <div
                                                    class="d-flex justify-content-between align-items-center border p-2 rounded">
                                                    <span><b>{{ $type->name }}</b> ({{ $type->leaves }})</span>

                                                    <label class="switch mb-0">
                                                        <input type="checkbox" name="leave_types[]"
                                                            value="{{ $type->id }}" checked>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>


                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ url('employees') }}" class="btn btn-danger">Cancel</a>
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
            $('#account_id').select2();
        });

        function isNumberKey(evt) {
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
@endsection
