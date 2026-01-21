@extends('layouts.master')
@section('content')
    <div class="main-content pt-4">
        <div class="breadcrumb">
            <h1>Leave Balance</h1>
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
                        <div class="card-body">
                            <h4 class="card-inside-title mt-2">Filters</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Employee</label>
                                        <select id="employee_id" name="employee_id" class="form-control">
                                            <option value="">--Select Employee--</option>
                                            @foreach ($employees as $item)
                                                <option value="{{ $item->id }}">{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mt-4">
                                        <button class="btn btn-primary waves-effect" id="search_button"
                                            type="submit">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="leave_balance_table" class="table display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>Total</th>
                                            <th>Used</th>
                                            <th>Balance</th>
                                            <th>Year</th>
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
@endsection
@section('js')
    @include('includes.datatable', [
        'columns' => "
                {data: 'DT_RowIndex',name: 'DT_RowIndex',orderable: false,searchable: false},
                        {data: 'employee' , name: 'employee' , 'sortable': false , searchable: false},
                        {data: 'leave_type' , name: 'leave_type' , 'sortable': false , searchable: false},
                        {data: 'total' , name: 'total'},
                        {data: 'used' , name: 'used'},
                        {data: 'remaining' , name: 'remaining'},
                        {data: 'year' , name: 'year' , 'sortable': false , searchable: false},",
        'route' => 'leave-balance/data',
        'buttons' => false,
        'pageLength' => 10,
        'class' => 'leave_balance_table',
        'variable' => 'leave_balance_table',
        'datefilter' => true,
        'params' => "employee_id:$('#employee_id').val()",
    ])

    <script>
        $('#search_button').click(function() {
            $("#preloader").show();
            initDataTableleave_balance_table();
            $("#preloader").hide();
        });
    </script>
@endsection
