@extends('layouts.master')
@section('content')
    <div class="main-content pt-4">
        <div class="breadcrumb">
            <h1>Attendances</h1>
            <ul>
                <li>List</li>
                <li>All</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <!-- end of row -->
        <section class="contact-list">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card text-left">
                        <div class="card-header text-right bg-transparent">
                            @can('attendance_create')
                                <a class="btn btn-primary btn-md m-1" href="javascript:void(0)" id="createNewAttendance"><i
                                        class="fa fa-plus text-white mr-2"></i> Add Attendance</a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="attendance_table" class="table display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Employee</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end of col -->
                    </div>
                    <!-- end of row -->
                </div>
            </div>
        </section>
    </div>
    @include('HRM/attendance/Modal/AttendanceForm')
@endsection
@section('js')
    <script src="{{ asset('js/common-methods/toasters.js') }}" type="module"></script>
    <script src="{{ asset('js/common-methods/http-requests.js') }}" type="module"></script>
    <script src="{{ url('attendance/js/AttendanceForm.js') }}" type="module"></script>
    <script type="text/javascript">
        var url_local = "{{ url('/') }}";
        $(document).ready(function() {
            $('#employee_id').select2();
        });
    </script>
    @include('includes.datatable', [
        'columns' => "
            {data: 'attendance_date' , name: 'attendance_date'},
            {data: 'employee' , name: 'employee' , 'sortable': false , searchable: false},
            {data: 'check_in' , name: 'check_in'},
            {data: 'check_out' , name: 'check_out'},
            {data: 'duration' , name: 'duration' , 'sortable': false , searchable: false},
            {data: 'status' , name: 'status' , 'sortable': false , searchable: false},
            {data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
        'route' => 'attendance/data',
        'buttons' => false,
        'pageLength' => 10,
        'class' => 'attendance_table',
        'variable' => 'attendance_table',
    ])
@endsection
