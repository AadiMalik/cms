@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="breadcrumb">
        <h1>Retainers</h1>
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
                        {{-- @can('retainer_create') --}}
                        <a class="btn btn-primary btn-md m-1" href="javascript:void(0)" id="createNewRetainer"><i
                                class="fa fa-plus text-white mr-2"></i> Add Retainer</a>
                        {{-- @endcan --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="retainer_table" class="table display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Day of Month</th>
                                        <th>Currency</th>
                                        <th>Journal</th>
                                        <th>Debit Account</th>
                                        <th>Credit Account</th>
                                        <th>Amount</th>
                                        <th>JV Number</th>
                                        <th>Active</th>
                                        <th>Status</th>
                                        <th>Created At</th>
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
@include('retainer/Modal/RetainerForm')
@endsection
@section('js')
<script src="{{ asset('js/common-methods/toasters.js') }}" type="module"></script>
<script src="{{ asset('js/common-methods/http-requests.js') }}" type="module"></script>
<script src="{{ url('retainer/js/RetainerForm.js') }}" type="module"></script>
<script type="text/javascript">
    var url_local = "{{ url('/') }}";

    function isNumberKey(evt) {
        var charCode = evt.which ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    $(document).ready(function() {
        $('#journal_id').select2();
        $('#currency').select2();
        $('#debit_account_id').select2();
        $('#credit_account_id').select2();
        $('#day_of_month').select2();
    });

    $("body").on('change', '#status', function() {
        let itemId = $(this).data('id');
        let status = $(this).val();

        // Send AJAX request to update the location
        $.ajax({
            url: "{{ url('retainer/status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: itemId,
                status: status
            },
            success: function(data) {
                if (data.Success) {
                    successMessage(data.Message);
                    initDataTableretainer_table();
                } else {
                    errorMessage(data.Message);
                }
            }
        });
    });
</script>
@include('includes.datatable', [
'columns' => "
{data: 'title' , name: 'title'},
{data: 'day_of_month' , name: 'day_of_month'},
{data: 'currency' , name: 'currency', 'sortable': false , searchable: false},
{data: 'journal' , name: 'journal', 'sortable': false , searchable: false},
{data: 'debit_account' , name: 'debit_account', 'sortable': false , searchable: false},
{data: 'credit_account' , name: 'credit_account', 'sortable': false , searchable: false},
{data: 'amount' , name: 'amount'},
{data: 'jv' , name: 'jv', 'sortable': false , searchable: false},
{data: 'is_active' , name: 'is_active', 'sortable': false , searchable: false},
{data: 'status' , name: 'status' , 'sortable': false , searchable: false},
{data: 'created_at' , name: 'created_at'},
{data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
'route' => 'retainer/data',
'buttons' => false,
'pageLength' => 10,
'class' => 'retainer_table',
'variable' => 'retainer_table',
])
@endsection