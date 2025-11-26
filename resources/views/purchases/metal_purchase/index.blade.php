@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="breadcrumb">
        <h1>Metal Purchase</h1>
        <ul>
            <li>List</li>
            <li>All</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    @if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif
    <!-- end of row -->
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header text-right bg-transparent">
                        @can('metal_purchase_create')
                        <a class="btn btn-primary btn-md m-1" href="{{ url('metal-purchase/create') }}"><i
                                class="fa fa-plus text-white mr-2"></i> Add Metal Purchase</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <h4 class="card-inside-title mt-2">Filters</h4>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">From:<span class="text-danger">*</span></label>
                                    <input type="date" id="start_date" name="start_date" class="form-control date" value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                                </div>
                            </div>
                            <div class="col-md-2" id="div_end_date">
                                <div class="form-group">
                                    <label for="">To:<span class="text-danger">*</span></label>
                                    <input type="date" id="end_date" name="end_date" class="form-control date" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-3" id="div_vendor">
                                <div class="form-group">
                                    <label for="">Supplier/Karigar</label>
                                    <select id="supplier_id" name="supplier_id" class="form-control">
                                        <option value="">--Select Supplier/Karigar--</option>
                                        @foreach ($suppliers as $item)
                                        <option value="{{ $item->id }}">{{ $item->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select id="posted" name="posted" class="form-control">
                                        <option value="">All</option>
                                        <option value="0">Unposted</option>
                                        <option value="1">Posted</option>
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
                        <div class="row">
                            <div class="col-md-12">
                                <hr class="mt-2 mb-2">
                            </div>
                            <div class="col-md-8" id="div_post_metal_purchase">
                                <a class="btn btn-info" style="color:#fff;" type="button" id="selectAll">Check
                                    All</a>
                                <a class="btn btn-danger" style="color:#fff;" type="button" id="unselectAll">Uncheck
                                    All</a>
                                @can('metal_purchase_post')
                                <a class="btn btn-primary" style="color:#fff;" type="button"
                                    id="post_metal_purchase">Post</a>
                                @endcan
                            </div>
                        </div>
                        <div class="row mt-2" id="metal_purchase_account" style="display: none;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Purchase Account<span style="color: red;">*</span> </label>
                                    <select id="purchase_account_id" name="purchase_account_id" class="form-control"
                                        style="width:100%;">
                                        <option value="0" disabled selected="selected">--Select Purchase
                                            Account--</option>
                                        @foreach ($accounts as $item)
                                        <option value="{{ $item->id }}"
                                            {{ (isset($setting) && $setting->purchase_account_id == $item->id) ? 'selected' : '' }}>
                                            {{ $item->code ?? '' }} -
                                            {{ $item->name ?? '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Paid Account (PKR)<span style="color: red;">*</span> </label>
                                    <select id="paid_account_id" name="paid_account_id" class="form-control"
                                        style="width:100%;">
                                        <option value="0" disabled selected="selected">--Select Paid
                                            Account--</option>
                                        @foreach ($accounts as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->code ?? '' }} -
                                            {{ $item->name ?? '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Paid Account ($)<span style="color: red;">*</span>
                                    </label>
                                    <select id="paid_account_dollar_id" name="paid_account_dollar_id" class="form-control"
                                        style="width:100%;">
                                        <option value="0" disabled selected="selected">--Select
                                            Paid
                                            Account--</option>
                                        @foreach ($accounts as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->code ?? '' }} -
                                            {{ $item->name ?? '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="metal_purchase_pagination_table" class="display table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Sr#</th>
                                            <th>Date</th>
                                            <th>Metal Purchase#</th>
                                            <th>Supplier/Karigar</th>
                                            <th>Purchase Account</th>
                                            <th>Total (PKR)</th>
                                            <th>Total ($)</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end of col -->
                </div>
                <!-- end of row -->
            </div>
        </div>
    </section>
</div>
@include('journal_entries/Modal/JVs')
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/momenttimezone/0.5.31/moment-timezone-with-data-2012-2022.min.js">
</script>
<script src="{{ asset('js/common-methods/toasters.js') }}" type="module"></script>
@include('includes.datatable', [
'columns' => "
{data: 'check_box', name: 'check_box', name: 'DT_RowIndex', orderable: false, searchable: false},
{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
{data: 'purchase_date', name: 'purchase_date', orderable: false, searchable: false},
{data: 'metal_purchase_no', name: 'metal_purchase_no', orderable: false, searchable: false},
{data: 'supplier',name: 'supplier', orderable: false, searchable: false},
{data: 'purchase_account',name: 'purchase_account', orderable: false, searchable: false},
{data: 'total',name: 'total', orderable: false, searchable: false},
{data: 'total_dollar',name: 'total_dollar', orderable: false, searchable: false},
{data: 'posted',name: 'posted', orderable: false, searchable: false},
{data: 'action',name: 'action','sortable': false,searchable: false}",
'route' => 'metal-purchase/data',
'buttons' => false,
'pageLength' => 50,
'class' => 'metal_purchase_pagination_table',
'variable' => 'metal_purchase_pagination_table',
'datefilter' => true,
'params' => "supplier_id:$('#supplier_id').val(),posted:$('#posted').val()",
'rowCallback' => ' rowCallback: function (row, data) {
if(data.posted.includes("Unposted"))
$(row).css("background-color", "Pink");
}',
])
<script>
    $(document).ready(function() {
        $('#supplier_id').select2();
        $("#purchase_account_id").select2();
        $("#paid_account_dollar_id").select2();
        $("#paid_account_id").select2();

        $("#metal_purchase_account").hide();
        $("#unselectAll").hide();
        $("#selectAll").click(function() {
            $("input[type=checkbox]").prop('checked', 'checked');
            $("#selectAll").hide();
            $("#unselectAll").show();
            $("#metal_purchase_account").show();
        });
        $("#unselectAll").click(function() {
            $("input[type=checkbox]").prop('checked', '');
            $("#selectAll").show();
            $("#unselectAll").hide();
            $("#metal_purchase_account").hide();
        })
    });

    function isNumberKey(evt) {
        var charCode = evt.which ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
<script type="text/javascript">
    $('#search_button').click(function() {
        initDataTablemetal_purchase_pagination_table();
        $("#div_post_metal_purchase").show();
    });

    function error(message) {
        toastr.error(message, "Error!", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3,
        });
    }

    function success(message) {
        toastr.success(message, "Success!", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3,
        });
    }

    $("body").on("keyup", "#search", function(event) {
        var url = $('#form_search').attr('action');
        var data = $('#form_search').serializeArray();
        var get = $('#form_search').attr('method');
        var search = $('#search').val();
        var stdate = $('#start_date').val();
        var eddate = $('#end_date').val();
        if (stdate > eddate) {
            error('wrong dates selected');
            $("#preloader").hide();
            return false;
        }
        $.ajax({
            type: get,
            url: url,
            data: data,
        }).done(function(data) {
            $('.result').html(data);
            $("#div_post_metal_purchase").show();
        });

    });
    $("#post_metal_purchase").click(function() {
        $("#preloader").show();
        var metal_purchases = [];
        $(".sub_chk:checked").each(function() {

            metal_purchases.push($(this).val());
        });
        if ($("#purchase_account_id").find(":selected").val() == 0 || $("#purchase_account_id").find(":selected").val() == '') {
            error("Please Select Purchase Account!");
            $("#purchase_account_id").focus();
            return false;
        }
        if ($("#paid_account_dollar_id").find(":selected").val() === '' || $("#paid_account_dollar_id").find(":selected").val() === '') {
            error("Please select paid ($) account!");
            $("#paid_account_dollar").focus();
            return false;
        }
        if ($("#paid_account_id").find(":selected").val() === '' || $("#paid_account_id").find(":selected").val() === '') {
            error("Please select paid (PKR) account!");
            $("#paid_account_id").focus();
            return false;
        }
        var data = {};
        data.metal_purchase = metal_purchases;
        data.purchase_account_id= $("#purchase_account_id").find(":selected").val();
        data.paid_account_id= $("#paid_account_id").find(":selected").val();
        data.paid_account_dollar_id= $("#paid_account_dollar_id").find(":selected").val();
        if (metal_purchases.length <= 0) {
            $("#preloader").hide();
            error("Please select Rows!");
        } else {
            $.ajax({
                url: "{{ url('metal-purchase/post-metal-purchase') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: data,
                dataType: "json",

                success: function(data) {
                    if ((data.Success = true)) {
                        $("#preloader").hide();
                        success(data.Message)
                        initDataTablemetal_purchase_pagination_table();
                    }
                },
            });
        }
    });
    $("body").on("click", "#unpost", function() {
        $("#preloader").show();
        var metal_purchase_id = $(this).data("id");

        $.ajax({
            url: "{{ url('metal-purchase/unpost-metal-purchase') }}/" + metal_purchase_id,
            type: "Get",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",

            success: function(data) {
                if ((data.Success = true)) {
                    $("#preloader").hide();
                    success(data.Message)
                    initDataTablemetal_purchase_pagination_table();
                }
            },
        });
    });
    // Delete metal_purchase Code

    $("body").on("click", "#deleteMetalPurchase", function() {
        var metal_purchase_id = $(this).data("id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                        type: "get",
                        url: "{{ url('metal-purchase/destroy') }}/" + metal_purchase_id,
                    }).done(function(data) {
                        if ((data.Success = true)) {
                            $("#preloader").hide();
                            success(data.Message)
                            initDataTablemetal_purchase_pagination_table();
                        } else {
                            error(data.Message);
                        }

                    })
                    .catch(function(err) {
                        error(err.Message);
                    });
            }
        });
    });

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

    $("body").on("click", ".sub_chk", function() {
            if ($("input[type=checkbox]").is(':checked')) {
                $("#metal_purchase_account").show();
            } else {
                $("#metal_purchase_account").hide();
            }
        });
</script>
@endsection