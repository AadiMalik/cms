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
                <h1>Metal Tagging</h1>
                <ul>
                    <li>Create</li>
                    <li>Save</li>
                </ul>
            </div>
            <div class="col-md-4">
                <input type="text" id="tag_no_text" style="border:none; background:none; font-size:20px; font-weight:bold;"
                    class="form-control text-center bg-light">
                <input type="text" id="parent_tag_no_text" value="{{ $parent_tag }}"
                    style="display:none; border:none; background:none; font-size:20px; font-weight:bold;"
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

                        <form id="finish_productForm" action="#" method="POST" enctype="multipart/form-data">
                            <div class="card-body" style="font-size: 14px;">
                                @csrf
                                <input type="hidden" name="tag_no" id="tag_no" value="">
                                <input type="hidden" name="metal_purchase_id" id="metal_purchase_id" value="">
                                <input type="hidden" name="metal_purchase_detail_id" id="metal_purchase_detail_id"
                                    value="">
                                {{-- <input type="hidden" name="job_purchase_id" id="job_purchase_id" value="">
                                <input type="hidden" name="job_purchase_detail_id" id="job_purchase_detail_id" value=""> --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="switch pr-5 switch-primary mr-3"><span>Is Parent</span>
                                                <input type="checkbox" name="is_parent" id="is_parent"><span
                                                    class="slider"></span>
                                            </label>
                                        </div>
                                        <div class="card card-tabs" id="purchase_div">
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
                                            <div class="col-md-6" id="product_div">
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

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Metal:<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="metal" name="metal" class="form-control" required readonly/>
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
                                            <div class="col-md-4" id="parent_div">
                                                <div class="form-group">
                                                    <label class="form-label">Parent:</label>
                                                    <select id="parent_id" name="parent_id"
                                                        class="form-control show-tick" required>
                                                        <option value="0" selected="selected" disabled>--Select
                                                            Parent--
                                                        </option>
                                                        @foreach ($parents as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->tag_no ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="scale_div">
                                                <div class="form-group">
                                                    <label class="form-label">Scale Weight:<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="scale_weight" name="scale_weight"
                                                        class="form-control" value="0"
                                                        onkeypress="return isNumberKey(event)" required readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="net_weight_div">
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
                                <div class="row mt-2" id="product_detail_div">
                                    <div class="col-md-12">
                                        <h6 class="font-weight-bold">Purchase Detail:</h6>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Bead Weight:<span class="text-danger">*</span>
                                                <a href="javascript:void(0)" id="BeadWeightButton"
                                                    style="border: 1px solid #000; border-radius: 50%;padding: 3px 5px 3px 5px;"
                                                    class="btn-primary"><i class="fa fa-eye text-white"></i></a>
                                            </label>
                                            <input type="text" id="bead_weight" name="bead_weight"
                                                class="form-control" onkeypress="return isNumberKey(event)"
                                                value="0" readonly required min="0" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Stone Weight:<span class="text-danger">*</span>
                                                <a href="javascript:void(0)" id="StonesWeightButton"
                                                    style="border: 1px solid #000; border-radius: 50%;padding: 3px 5px 3px 5px;"
                                                    class="btn-primary"><i class="fa fa-eye text-white"></i></a>
                                            </label>
                                            <input type="text" id="stones_weight" name="stones_weight"
                                                class="form-control" value="0" readonly
                                                onkeypress="return isNumberKey(event)" required min="0" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Diamond Weight:<span class="text-danger">*</span>
                                                <a href="javascript:void(0)" id="DiamondCaratButton"
                                                    style="border: 1px solid #000; border-radius: 50%;padding: 3px 5px 3px 5px;"
                                                    class="btn-primary"><i class="fa fa-eye text-white"></i></a>
                                            </label>
                                            <input type="text" id="diamond_weight" name="diamond_weight"
                                                class="form-control" readonly value="0"
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
                                            <label class="form-label">Purity:<span class="text-danger">*</span></label>
                                            <input type="text" id="purity" name="purity" class="form-control"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Metal Rate:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="metal_rate" name="metal_rate" class="form-control"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Metal Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="total_metal_amount" name="total_metal_amount"
                                                class="form-control" readonly value="0"
                                                onkeypress="return isNumberKey(event)" required min="0" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Bead Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="total_bead_amount" name="total_bead_amount"
                                                class="form-control" readonly value="0"
                                                onkeypress="return isNumberKey(event)" required min="0" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Stones Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="total_stones_amount" name="total_stones_amount"
                                                class="form-control" readonly value="0"
                                                onkeypress="return isNumberKey(event)" required min="0" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Diamond Amount:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="total_diamond_amount" name="total_diamond_amount"
                                                class="form-control" readonly value="0"
                                                onkeypress="return isNumberKey(event)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Other Charges:<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="other_charges" name="other_charges"
                                                class="form-control" value="0"
                                                onkeypress="return isNumberKey(event)" required min="0" />
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
                                    <button class="btn btn-primary" id="submit" accesskey="s">SAVE</button>
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

    @include('metal_product/Modal/BeadModal')
    @include('metal_product/Modal/DiamondModal')
    @include('metal_product/Modal/StonesModal')
@endsection
@section('js')
    <script src="{{ url('metal-product/js/metalProduct.js') }}"></script>
    <script src="{{ url('metal-product/js/beadWeight.js') }}"></script>
    <script src="{{ url('metal-product/js/stoneWeight.js') }}"></script>
    <script src="{{ url('metal-product/js/diamondCarat.js') }}"></script>
    <script type="text/javascript">
        var url_local = "{{ url('/') }}";
        var gold_rate = "{{ $gold_rate->rate_tola ?? 0 }}";
    </script>

    <script>
        $(document).ready(function() {
            $('#warehouse_id').select2();
            $('#product_id').select2();
            $('#parent_id').select2();
            $('#supplier_id').select2();
            $('#is_parent').change(function() {
                if ($(this).is(':checked')) {
                    $("#purchase_div").hide();
                    $("#parent_div").hide();
                    $("#product_div").hide();
                    $("#scale_div").hide();
                    $("#net_weight_div").hide();
                    $("#product_detail_div").hide();
                    $("#tag_no").val('{{ $parent_tag }}');
                    $("#tag_no_text").hide();
                    $("#parent_tag_no_text").show();
                } else {
                    $("#purchase_div").show();
                    $("#parent_div").show();
                    $("#product_div").show();
                    $("#scale_div").show();
                    $("#net_weight_div").show();
                    $("#product_detail_div").show();
                    $("#tag_no").val();
                    $("#tag_no_text").show();
                    $("#parent_tag_no_text").hide();
                }
            });
        });
    </script>
@endsection
