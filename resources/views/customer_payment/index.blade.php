<?php
$gold_rate = GoldRate();
$dollar_rate = DollarRate();
?>
@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="breadcrumb">
        <h1>Customer Payments</h1>

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
                        @can('customer_payment_create')
                        <a type="button" href="javascript:void(0)" id="createNewPayment"
                            class="btn btn-primary btn-md m-1"><i class="fa fa-plus text-white mr-2"></i> Add Payment</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <b>Filter</b>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Start Date:<span class="text-danger">*</span></label>
                                    <div class="form-line">
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            required value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">End Date:<span class="text-danger">*</span></label>
                                    <div class="form-line">
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            required value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Customer:</label>
                                    <div class="form-line">
                                        <select name="customer" class="form-control" id="customer">
                                            <option value="">All</option>
                                            @foreach ($customers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mt-4">
                                <div class="form-group">
                                    <button class="btn btn-primary" id="search">Search</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr style="margin:0px;">
                            </div>
                        </div>
                        <div class="table-responsive mt-4">
                            <table id="customer_payment_table" class="table display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Convert Currency</th>
                                        <th>Currency</th>
                                        <th>Type</th>
                                        <th>Convert Amount</th>
                                        <th>Amount</th>
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
@include('customer_payment/Modal/CustomerPaymentForm')

@include('journal_entries/Modal/JVs')
@endsection
@section('js')
<script src="{{ asset('js/common-methods/toasters.js') }}" type="module"></script>
<script src="{{ asset('js/common-methods/http-requests.js') }}" type="module"></script>
<script src="{{ url('customer-payment/js/CustomerPaymentForm.js') }}" type="module"></script>
<script type="text/javascript">
    var url_local = "{{ url('/') }}";
    $(document).on('click', '#search', function() {
        initDataTablecustomer_payment_table();
    });
</script>
@include('includes.datatable', [
'columns' => "
{data: 'customer' , name: 'customer'},
{data: 'date' , name: 'date'},
{data: 'convert_currency' , name: 'convert_currency'},
{data: 'currency' , name: 'currency'},
{data: 'type' , name: 'type'},
{data: 'convert_amount' , name: 'convert_amount'},
{data: 'sub_total' , name: 'sub_total'},
{data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
'route' => 'customer-payment/data',
'buttons' => false,
'pageLength' => 10,
'class' => 'customer_payment_table',
'variable' => 'customer_payment_table',
'datefilter' => true,
'params' => "customer_id:$('#customer').val()",
])

<script>
    $("body").on("click", "#Ref", function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        var jvs = $(this).data("filter");
        $("#preloader").show();

        $.ajax({
            type: "get",
            url: "{{ url('journal-entries/all-jvs') }}?" + jvs,
        }).done(function(response) {
            $('#result').html('');
            $('#result').html(response);
            $("#jvs_modalHeading").html("Journal Entry");
            $("#jvs_modal").modal("show");
            $("#preloader").hide();
        });
    });
</script>
<script>
    function errorMessage(message) {

        toastr.error(message, "Error", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3,
        });

    }
    let usdRate = "{{$dollar_rate->rate}}"; // 1 USD = 280 PKR
    let goldRate = "{{$gold_rate->rate_gram}}"; // 1g AU = 2500 PKR
    let conversionRates = {
        PKR: {
            USD: +(1 / usdRate).toFixed(6), // ≈ 0.003571
            AU: +(1 / goldRate).toFixed(6), // ≈ 0.0004
        },
        USD: {
            PKR: usdRate, // 280
            AU: +(usdRate / goldRate).toFixed(6), // ≈ 0.112
        },
        AU: {
            PKR: goldRate, // 2500
            USD: +(goldRate / usdRate).toFixed(6), // ≈ 8.928571
        }
    };

    function getCurrencyLabel(val) {
        switch (val) {
            case '0':
                return 'PKR';
            case '1':
                return 'AU';
            case '2':
                return 'USD';
            default:
                return '';
        }
    }

    function convertCurrency() {
        let from = getCurrencyLabel($('#currency').val());
        let to = getCurrencyLabel($('#convert_currency').val());
        let amount = parseFloat($('#sub_total').val());

        // If both currencies are the same, alert and stop
        if (from && to && from === to) {
            errorMessage('Base and convert currency must be different!');
            $('#convert_currency').val(''); // Reset
            $('#convert_amount').val(''); // Clear amount
            return;
        }

        if (!from || !to || isNaN(amount)) {
            $('#convert_amount').val('');
            return;
        }

        let rate = conversionRates[from]?.[to] ?? 0;
        let converted = (rate * amount).toFixed(2);
        $('#convert_amount').val(converted);
    }


    $(document).ready(function() {
        $('#currency, #convert_currency, #sub_total').on('change keyup', convertCurrency);
    });
</script>

@endsection