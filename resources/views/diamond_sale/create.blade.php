@php
$dollar_rate = DollarRate();
@endphp
@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="row pl-2">
        <div class="col-md-8 breadcrumb">
            <h1>Diamond Sale</h1>
            @if (isset($diamond_sale))
            <ul>
                <li>Edit</li>
                <li>Update</li>
            </ul>
            @else
            <ul>
                <li>Create</li>
                <li>Save</li>
            </ul>
            @endif
        </div>
        <div class="col-md-4">
            <input type="text" name="sale_no" id="sale_no"
                value="{{ isset($diamond_sale) ? $diamond_sale->diamond_sale_no : 'DSL-05102024-0009' }}"
                style="border:none; background:none; font-size:20px; font-weight:bold;"
                class="form-control text-center bg-light">
        </div>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <!-- end of row -->
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-transparent text-right">

                    </div>

                    <form id="saleForm" action="#" method="POST" enctype="multipart/form-data">
                        <div class="card-body" style="font-size: 14px;">
                            {{-- Edit Form  --}}
                            @csrf
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Sale Date:<span
                                                        style="color:red;">*</span></label>
                                                <input type="date" name="diamond_sale_date" id="diamond_sale_date"
                                                    class="form-control"
                                                    value="{{ isset($diamond_sale) ? $diamond_sale->diamond_sale_date : old('diamond_sale_date') }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Customer: <span class="text-danger">*</span>
                                                    <a href="javascript:void(0)" id="CustomerButton"
                                                        style="border: 1px solid #000; border-radius: 50%;padding: 3px 5px 3px 5px;"
                                                        class="btn-primary"><i class="fa fa-plus text-white"></i></a>
                                                </label>
                                                <select id="customer_id" name="customer_id"
                                                    class="form-control show-tick">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Warehouse:</label>
                                                <select id="warehouse_id" name="warehouse_id"
                                                    class="form-control show-tick">
                                                    @foreach ($warehouses as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if (isset($diamond_sale)) {{ $diamond_sale->warehouse_id == $item->id ? 'selected' : '' }} @endif>
                                                        {{ $item->name ?? '' }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Sale In:<span style="color:red;">*</span></label>
                                                <select id="is_pkr" name="is_pkr" class="form-control show-tick"
                                                    required>
                                                    <option value="1"
                                                        @if (isset($diamond_sale)) {{ $diamond_sale->is_pkr == 1 ? 'selected' : '' }} @endif>
                                                        PKR
                                                    </option>
                                                    <option value="0"
                                                        @if (isset($diamond_sale)) {{ $diamond_sale->is_pkr == 0 ? 'selected' : '' }} @endif>
                                                        Dollar
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card" style="border-radius:0px;">
                                        <div class="card-header bg-transparent"
                                            style="border-radius:0px; padding: 6px;">
                                            <b>Customer Detail</b>
                                        </div>
                                        <div class="card-body" style="min-height: 60px; overflow: auto; padding: 8px;"
                                            id="customer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" class="form-control"
                                    value="{{ isset($diamond_sale) ? $diamond_sale->id : '' }}" id="id"
                                    name="id">
                                <div class="col-md-12">
                                    <hr class="mb-2 mt-2">
                                    <b>Add Sale Detail:</b>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Diamond Type:<span class="text-danger">*</span></label>
                                        <select id="diamond_type_id" name="diamond_type_id"
                                            class="form-control show-tick" required>
                                            @foreach ($diamond_types as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($diamond_sale)) {{ $diamond_sale->diamond_type_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name ?? '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Diamond Cut:<span class="text-danger">*</span></label>
                                        <select id="diamond_cut_id" name="diamond_cut_id"
                                            class="form-control show-tick" required>
                                            @foreach ($diamond_cuts as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($diamond_sale)) {{ $diamond_sale->diamond_cut_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name ?? '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Diamond Color:<span class="text-danger">*</span></label>
                                        <select id="diamond_color_id" name="diamond_color_id"
                                            class="form-control show-tick" required>
                                            @foreach ($diamond_colors as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($diamond_sale)) {{ $diamond_sale->diamond_color_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name ?? '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Diamond Clarity:<span class="text-danger">*</span></label>
                                        <select id="diamond_clarity_id" name="diamond_clarity_id"
                                            class="form-control show-tick" required>
                                            @foreach ($diamond_clarity as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($diamond_sale)) {{ $diamond_sale->diamond_clarity_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name ?? '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Carat:<span style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="carat" id="carat"
                                                    class="form-control" required onkeypress="return isNumberKey(event)"
                                                    maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Carat Price:<span style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="carat_price" id="carat_price"
                                                    class="form-control" required onkeypress="return isNumberKey(event)"
                                                    maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Quantity:<span style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="qty" id="qty" class="form-control"
                                                    required onkeypress="return isNumberKey(event)" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Total Amount:<span
                                                style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="total_amount" id="total_amount"
                                                    class="form-control" required
                                                    onkeypress="return isNumberKey(event)" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Total Dollar:<span
                                                style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="total_dollar" id="total_dollar"
                                                    class="form-control" required
                                                    onkeypress="return isNumberKey(event)" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 mt-4">
                                    <a class="btn btn-primary waves-effect text-center text-white" style="width:100%;"
                                        onclick="addProduct()">
                                        <i class="fa fa-plus"></i> Add
                                    </a>
                                </div>

                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table style="min-height: 200px;"
                                        class="table table-striped table-hover dataTable js-exportable mb-3">
                                        <thead>
                                            <tr>
                                                <th>Sr.</th>
                                                <th>Type</th>
                                                <th>Cut</th>
                                                <th>Color</th>
                                                <th>Clarity</th>
                                                <th>Carat</th>
                                                <th>Carat Price</th>
                                                <th>Quantity</th>
                                                <th>Total(PKR)</th>
                                                <th>Total($)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="diamond_products">

                                        </tbody>

                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label font-weight-bold">Grand Total(PKR):<span
                                                        class="text-danger">*</span> </label>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" name="grand_total"
                                                            value="{{ isset($diamond_sale) ? $diamond_sale->total : '0' }}"
                                                            id="grand_total" class="form-control font-weight-bold"
                                                            readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label font-weight-bold">Grand Total($):<span
                                                        class="text-danger">*</span> </label>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" name="grand_total_dollar"
                                                            value="{{ isset($diamond_sale) ? $diamond_sale->total_dollar : '0' }}"
                                                            id="grand_total_dollar" class="form-control font-weight-bold"
                                                            readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label font-weight-bold">Cash Payment:</label>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" name="cash_amount"
                                                            value="{{ isset($diamond_sale) ? $diamond_sale->cash_amount : '0' }}"
                                                            id="cash_amount" class="form-control font-weight-bold">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label font-weight-bold">Bank Transafer:</label>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" name="bank_transfer_amount"
                                                            value="{{ isset($diamond_sale) ? $diamond_sale->bank_transfer_amount : '0' }}"
                                                            id="bank_transfer_amount"
                                                            class="form-control font-weight-bold">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label font-weight-bold">Card Payment:</label>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" name="card_amount"
                                                            value="{{ isset($diamond_sale) ? $diamond_sale->card_amount : '0' }}"
                                                            id="card_amount" class="form-control font-weight-bold">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label font-weight-bold">Advance Payment:</label>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" name="advance_amount"
                                                            value="{{ isset($diamond_sale) ? $diamond_sale->advance_amount : '0' }}"
                                                            id="advance_amount" class="form-control font-weight-bold">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="submit" accesskey="s"
                                    tabindex="10">SAVE</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
    </section>

</div>
@include('diamond_sale/Modal/CustomerModal')
@endsection
@section('js')
<script src="{{ url('diamond-sale/js/diamond_sale.js') }}"></script>
<script type="text/javascript">
    var url_local = "{{ url('/') }}";
    var dollar_rate = "{{$dollar_rate->rate}}";
    var diamond_sale_id = "{{ isset($diamond_sale) ? $diamond_sale->id : '' }}";
</script>

<script>
    $(document).ready(function() {
        $('#customer_id').select2();
        $('#warehouse_id').select2();
        $('#diamond_type_id').select2();
        $('#diamond_cut_id').select2();
        $('#diamond_color_id').select2();
        $('#diamond_clarity_id').select2();
        getCustomer();
        const diamond_sale_date = document.getElementById("diamond_sale_date");

        // ✅ Using the visitor's timezone
        diamond_sale_date.value = formatDate();

        console.log(formatDate());

        function padTo2Digits(num) {
            return num.toString().padStart(2, "0");
        }

        function formatDate(date = new Date()) {
            return [
                padTo2Digits(date.getMonth() + 1),
                padTo2Digits(date.getDate()),
                date.getFullYear(),
            ].join("/");
        }
        diamond_sale_date.value = new Date().toISOString().split("T")[0];
    });
</script>
@endsection