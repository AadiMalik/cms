@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="breadcrumb">
        <h1>Departments</h1>
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
                        @can('department_create')
                        <a class="btn btn-primary btn-md m-1" href="javascript:void(0)" id="createNewDepartment"><i
                                class="fa fa-plus text-white mr-2"></i> Add Department</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="department_table" class="table display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
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
@include('HRM/department/Modal/DepartmentForm')
@endsection
@section('js')
<script src="{{ asset('js/common-methods/toasters.js') }}" type="module"></script>
<script src="{{ asset('js/common-methods/http-requests.js') }}" type="module"></script>
<script src="{{ url('department/js/DepartmentForm.js') }}" type="module"></script>
<script type="text/javascript">
    var url_local = "{{ url('/') }}";
</script>
@include('includes.datatable', [
'columns' => "
{data: 'name' , name: 'name'},
{data: 'description' , name: 'description'},
{data: 'status' , name: 'status' , 'sortable': false , searchable: false},
{data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
'route' => 'department/data',
'buttons' => false,
'pageLength' => 10,
'class' => 'department_table',
'variable' => 'department_table',
])
@endsection