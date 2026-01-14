@extends('layouts.master')
@section('content')
    <div class="main-content pt-4">
        <div class="breadcrumb">
            <h1>Leave Types</h1>
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
                            @can('leave_type_create')
                                <a class="btn btn-primary btn-md m-1" href="javascript:void(0)" id="createNewLeaveType"><i
                                        class="fa fa-plus text-white mr-2"></i> Add Leave Type</a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="leave_type_table" class="table display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Days</th>
                                            <th>Is Paid</th>
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
    @include('HRM/leave_type/Modal/LeaveTypeForm')
@endsection
@section('js')
    <script src="{{ asset('js/common-methods/toasters.js') }}" type="module"></script>
    <script src="{{ asset('js/common-methods/http-requests.js') }}" type="module"></script>
    <script src="{{ url('leave-type/js/LeaveTypeForm.js') }}" type="module"></script>
    <script type="text/javascript">
        var url_local = "{{ url('/') }}";
    </script>
    @include('includes.datatable', [
        'columns' => "
    {data: 'name' , name: 'name'},
    {data: 'leaves' , name: 'leaves'},
    {data: 'is_paid' , name: 'is_paid' , 'sortable': false , searchable: false},
    {data: 'status' , name: 'status' , 'sortable': false , searchable: false},
    {data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
        'route' => 'leave-type/data',
        'buttons' => false,
        'pageLength' => 10,
        'class' => 'leave_type_table',
        'variable' => 'leave_type_table',
    ])

    <script>
        function isNumberKey(evt) {
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
@endsection
