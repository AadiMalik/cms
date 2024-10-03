@php
    $gold_rate = GoldRate();
@endphp
@extends('layouts.master')
@section('css')
    <style>
        .purchase_active {
            background: green;
            font-weight: bold;
            font-size: 16px;
            color: #fff;

        }
    </style>
@endsection
@section('content')
    <div class="main-content pt-4">
        <div class="row pl-2">
            <div class="col-md-8 breadcrumb">
                <h1>Finish Product</h1>
                <ul>
                    <li>Create</li>
                    <li>Save</li>
                </ul>
            </div>
            <div class="col-md-4">
                <input type="text" id="tag_no_text" style="border:none; background:none; font-size:20px; font-weight:bold;"
                    class="form-control text-center bg-light">
            </div>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- end of row -->
        <section class="contact-list">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-transparent text-right">

                        </div>

                        <form id="finish_productForm" action="{{ url('finish-product/store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body" style="font-size: 14px;">
                                @csrf
                                <input type="hidden" name="tag_no" id="tag_no" value="">
                                <input type="hidden" name="ratti_kaat_id" id="ratti_kaat_id" value="">
                                <input type="hidden" name="ratti_kaat_detail_id" id="ratti_kaat_detail_id" value="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-tabs">
                                            <div class="card-content" style="padding: 8px;">
                                                <div class="card-title">
                                                    <b>Purchases</b>
                                                    <hr style="margin:0px;">
                                                </div>
                                                <div class="row" style="height: 110px; overflow: auto;">
                                                    <div class="col s12">
                                                        <table id="purchases">

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Product:<span
                                                            class="text-danger">*</span></label>
                                                    <select id="product_id" name="product_id" class="form-control show-tick"
                                                        required>
                                                        <option value="0" selected="selected" disabled>--Select
                                                            Product--
                                                        </option>
                                                        @foreach ($products as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Warehouse:<span
                                                            class="text-danger">*</span></label>
                                                    <select id="warehouse_id" name="warehouse_id"
                                                        class="form-control show-tick" required>
                                                        <option value="0" selected="selected" disabled>--Select
                                                            Warehouse--
                                                        </option>
                                                        @foreach ($warehouses as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Picture:<span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" name="picture" id="picture"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Gold Karat:<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="gold_carat" name="gold_carat" value="24"
                                                        class="form-control" onkeypress="return isNumberKey(event)"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Scale Weight:<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="scale_weight" name="scale_weight"
                                                        class="form-control" value="0"
                                                        onkeypress="return isNumberKey(event)" required readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Net Weight:<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="net_weight" name="net_weight"
                                                        class="form-control" value="0"
                                                        onkeypress="return isNumberKey(event)" required readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <h6 class="font-weight-bold">Purchase Detail:</h6>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Bead Weight:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="bead_weight" name="bead_weight"
                                                class="form-control" onkeypress="return isNumberKey(event)"
                                                value="0" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Bead Price:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="bead_price" name="bead_price" class="form-control"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Stone Weight:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="stones_weight" name="stones_weight"
                                                class="form-control" value="0" readonly
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Stone Price:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="stones_price" name="stones_price"
                                                class="form-control" onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Diamond Weight:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="diamond_weight" name="diamond_weight"
                                                class="form-control" readonly value="0"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Diamond Price:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="diamond_price" name="diamond_price"
                                                class="form-control" onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Waste (%):<span class="text-danger">*</span></label>
                                            <input type="text" id="waste_per" name="waste_per" class="form-control"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Waste:<span class="text-danger">*</span></label>
                                            <input type="text" id="waste" name="waste" class="form-control"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Gross Weight:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="gross_weight" name="gross_weight"
                                                class="form-control" readonly value="0"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Laker:<span class="text-danger">*</span></label>
                                            <input type="text" id="laker" name="laker" class="form-control"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Making/Gram:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="making_gram" name="making_gram"
                                                class="form-control" onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Making:<span class="text-danger">*</span></label>
                                            <input type="text" id="making" name="making" class="form-control"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Bead Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="total_bead_price" name="total_bead_price"
                                                class="form-control" readonly value="0"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Stones Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="total_stones_price" name="total_stones_price"
                                                class="form-control" readonly value="0"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Diamond Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="total_diamond_price" name="total_diamond_price"
                                                class="form-control" readonly value="0"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Other Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="other_amount" name="other_amount"
                                                class="form-control" value="0"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Gold Rate/Gram:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" value="{{ $gold_rate->rate_gram }}" id="gold_rate"
                                                name="gold_rate" class="form-control"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Gold Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" value="0" id="total_gold_price"
                                                name="total_gold_price" class="form-control"
                                                onkeypress="return isNumberKey(event)" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="total_amount" name="total_amount"
                                                class="form-control" value="0" readonly
                                                onkeypress="return isNumberKey(event)" required />
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
    <script src="{{ url('finish-product/js/finishProduct.js') }}"></script>
    <script type="text/javascript">
        var url_local = "{{ url('/') }}";
        var gold_rate = "{{ $gold_rate->rate_tola ?? 0 }}";
    </script>

    <script>
        $(document).ready(function() {
            $('#warehouse_id').select2();
            $('#product_id').select2();
            $('#supplier_id').select2();
            $('#paid_account').select2();
            $('#paid_account_dollar').select2();
            $('#paid_account_au').select2();

        });
    </script>
@endsection
