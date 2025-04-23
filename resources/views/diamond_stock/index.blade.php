@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="breadcrumb">
        <h1>Diamond Stock</h1>
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
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="diamond_stock_table" class="table display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Cut</th>
                                        <th>Color</th>
                                        <th>Clarity</th>
                                        <th>Carat</th>
                                        <th>QTY</th>
                                        <th>Warehouse</th>
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
@endsection
@section('js')
@include('includes.datatable', [
'columns' => "
{data: 'diamond_type' , name: 'diamond_type' , 'sortable': false , searchable: false},
{data: 'diamond_cut' , name: 'diamond_cut' , 'sortable': false , searchable: false},
{data: 'diamond_color' , name: 'diamond_color' , 'sortable': false , searchable: false},
{data: 'diamond_clarity' , name: 'diamond_clarity' , 'sortable': false , searchable: false},
{data: 'total_carat' , name: 'total_carat' , 'sortable': false , searchable: false},
{data: 'total_qty' , name: 'total_qty' , 'sortable': false , searchable: false},
{data: 'warehouse' , name: 'warehouse' , 'sortable': false , searchable: false},
{data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
'route' => 'diamond-stock/data',
'buttons' => false,
'pageLength' => 10,
'class' => 'diamond_stock_table',
'variable' => 'diamond_stock_table',
])
@endsection