@php
$dollar_rate = DollarRate();
@endphp
@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="row pl-2">
        <div class="col-md-8 breadcrumb">
            <h1>Diamond Purchase</h1>
            @if (isset($diamond_purchase))
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
                value="{{ isset($diamond_purchase) ? $diamond_purchase->diamond_purchase_no : 'DPO-05102024-0009' }}"
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Purchase Date:<span
                                                style="color:red;">*</span></label>
                                        <input type="date" name="diamond_purchase_date" id="diamond_purchase_date"
                                            class="form-control"
                                            value="{{ isset($diamond_purchase) ? $diamond_purchase->diamond_purchase_date : old('diamond_purchase_date') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Bill No:<span style="color:red;">*</span></label>
                                        <input type="text" name="bill_no" id="bill_no" class="form-control"
                                            value="{{ isset($diamond_purchase) ? $diamond_purchase->bill_no : old('bill_no') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Purchase In:<span style="color:red;">*</span></label>
                                        <select id="is_pkr" name="is_pkr" class="form-control show-tick"
                                            required>
                                            <option value="1"
                                                @if (isset($diamond_purchase)) {{ $diamond_purchase->is_pkr == 1 ? 'selected' : '' }} @endif>
                                                PKR
                                            </option>
                                            <option value="0"
                                                @if (isset($diamond_purchase)) {{ $diamond_purchase->is_pkr == 0 ? 'selected' : '' }} @endif>
                                                Dollar
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Supplier:<span style="color:red;">*</span></label>
                                        <select id="supplier_id" name="supplier_id" class="form-control show-tick"
                                            required>
                                            <option value="" disabled selected>--Select Supplier--</option>
                                            @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($diamond_purchase)) {{ $diamond_purchase->supplier_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name ?? '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Warehouse:<span style="color:red;">*</span></label>
                                        <select id="warehouse_id" name="warehouse_id" class="form-control show-tick"
                                            required>
                                            <option value="" disabled selected>--Select Warehouse--</option>
                                            @foreach ($warehouses as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($diamond_purchase)) {{ $diamond_purchase->warehouse_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name ?? '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Purchase Account:<span
                                                style="color:red;">*</span></label>
                                        <select id="purchase_account_id" name="purchase_account_id"
                                            class="form-control show-tick" required>
                                            <option value="" disabled selected>--Select Account--</option>
                                            @foreach ($accounts as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($diamond_purchase)) {{ $diamond_purchase->purchase_account_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->code ?? '' }} - {{ $item->name ?? '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Reference:<span style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="reference" id="reference"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" class="form-control"
                                    value="{{ isset($diamond_purchase) ? $diamond_purchase->id : '' }}" id="id"
                                    name="id">
                                <div class="col-md-12">
                                    <hr class="mb-2 mt-2">
                                    <b>Add Purchase Detail:</b>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Diamond Type:<span class="text-danger">*</span></label>
                                        <select id="diamond_type_id" name="diamond_type_id"
                                            class="form-control show-tick" required>
                                            @foreach ($diamond_types as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($diamond_purchase)) {{ $diamond_purchase->diamond_type_id == $item->id ? 'selected' : '' }} @endif>
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
                                                @if (isset($diamond_purchase)) {{ $diamond_purchase->diamond_cut_id == $item->id ? 'selected' : '' }} @endif>
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
                                                @if (isset($diamond_purchase)) {{ $diamond_purchase->diamond_color_id == $item->id ? 'selected' : '' }} @endif>
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
                                                @if (isset($diamond_purchase)) {{ $diamond_purchase->diamond_clarity_id == $item->id ? 'selected' : '' }} @endif>
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
                                                    class="form-control" required
                                                    onkeypress="return isNumberKey(event)" maxlength="10">
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
                                                    class="form-control" required
                                                    onkeypress="return isNumberKey(event)" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Quantity:<span style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="qty" id="qty"
                                                    class="form-control" required
                                                    onkeypress="return isNumberKey(event)" maxlength="10">
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
                                                            value="{{ isset($diamond_purchase) ? $diamond_purchase->total : '0' }}"
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
                                                            value="{{ isset($diamond_purchase) ? $diamond_purchase->total_dollar : '0' }}"
                                                            id="grand_total_dollar" class="form-control font-weight-bold"
                                                            readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label font-weight-bold">Paid:</label>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" name="paid"
                                                            value="{{ isset($diamond_purchase) ? $diamond_purchase->paid : '0' }}"
                                                            id="paid" value="0"
                                                            class="form-control font-weight-bold">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Paid Account:</label>
                                                <select id="paid_account_id" name="paid_account_id"
                                                    class="form-control show-tick">
                                                    <option value="" disabled selected>--Select Account--
                                                    </option>
                                                    @foreach ($accounts as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if (isset($diamond_purchase)) {{ $diamond_purchase->paid_account_id == $item->id ? 'selected' : '' }} @endif>
                                                        {{ $item->code ?? '' }} - {{ $item->name ?? '' }}
                                                    </option>
                                                    @endforeach
                                                </select>
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
@endsection
@section('js')
<script src="{{ url('diamond-purchase/js/diamond_purchase.js') }}"></script>
<script type="text/javascript">
    var url_local = "{{ url('/') }}";
    var dollar_rate = "{{$dollar_rate->rate}}";
    var diamond_purchase_id = "{{ isset($diamond_purchase) ? $diamond_purchase->id : '' }}";
</script>

<script>
    $(document).ready(function() {
        $('#supplier_id').select2();
        $('#warehouse_id').select2();
        $('#purchase_account_id').select2();
        $('#diamond_type_id').select2();
        $('#diamond_cut_id').select2();
        $('#diamond_color_id').select2();
        $('#diamond_clarity_id').select2();
        $('#paid_account_id').select2();
        const diamond_purchase_date = document.getElementById("diamond_purchase_date");

        // ✅ Using the visitor's timezone
        diamond_purchase_date.value = formatDate();

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
        diamond_purchase_date.value = new Date().toISOString().split("T")[0];
    });
</script>
@endsection