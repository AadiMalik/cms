@extends('layouts.master')
@section('content')
    <div class="main-content pt-4">
        <div class="breadcrumb">
            <h1>Leave Requests</h1>
            <ul>
                <li>List</li>
                <li>All</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="row mb-4">
            <div class="col-md-12 mb-3">
                <div class="card text-left">
                    <div class="card-header text-right bg-transparent">
                        @can('leave_request_create')
                            <a class="btn btn-primary btn-md m-1" href="{{ url('leave-requests/create') }}"><i
                                    class="fa fa-plus text-white mr-2"></i> Add Request</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="leave_request_table" class="table table-striped display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th scope="col">Employee</th>
                                        <th scope="col">Leave Type</th>
                                        <th scope="col">From Date</th>
                                        <th scope="col">To Date</th>
                                        <th scope="col">Days</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of col-->
        </div>
        <!-- end of row-->
    </div>
@endsection
@section('js')
    @include('includes.datatable', [
        'columns' => "
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'employee' , name: 'employee', orderable: false, searchable: false},
                        {data: 'leave_type' , name: 'leave_type', orderable: false, searchable: false},
                        {data: 'from_date' , name: 'from_date'},
                        {data: 'to_date' , name: 'to_date'},
                        {data: 'no_of_days' , name: 'no_of_days'},
                        {data: 'status' , name: 'status' , 'sortable': false , searchable: false},
                        {data: 'reason' , name: 'reason'},
                        {data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
        'route' => 'leave-requests/data',
        'buttons' => false,
        'pageLength' => 10,
        'class' => 'leave_request_table',
        'variable' => 'leave_request_table',
    ])

    <script>
        function errorMessage(message) {

            toastr.error(message, "Error", {
                showMethod: "slideDown",
                hideMethod: "slideUp",
                timeOut: 2e3,
            });

        }

        function successMessage(message) {

            toastr.success(message, "Success", {
                showMethod: "slideDown",
                hideMethod: "slideUp",
                timeOut: 2e3,
            });

        }
        $('body').on('change', '.change-status', function() {

            let selectBox = $(this);
            let oldValue = 'Pending'; // default
            let status = selectBox.val();
            let id = selectBox.data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "Once approved or rejected, it cannot be changed!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update status",
                cancelButtonText: "Cancel"
            }).then((result) => {

                // ❌ Cancel → revert dropdown
                if (!result.isConfirmed) {
                    selectBox.val(oldValue);
                    return;
                }

                // ✅ Confirm → AJAX hit
                $.ajax({
                    url: "{{ url('leave-requests/status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    success: function(res) {
                        if (res.Success) {
                            successMessage(res.Message);
                            initDataTableleave_request_table(); // reload table
                        } else {
                            errorMessage(res.Message);
                            selectBox.val(oldValue);
                        }
                    },
                    error: function() {
                        errorMessage('Something went wrong');
                        selectBox.val(oldValue);
                    }
                });
            });
        });
    </script>
@endsection
