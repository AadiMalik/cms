@php
$dollar_rate = DollarRate();
@endphp
@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="row pl-2">
        <div class="col-md-8 breadcrumb">
            <h1>Metal Purchase</h1>
            @if (isset($metal_purchase))
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
            <input type="text" name="metal_purchase_no" id="metal_purchase_no"
                value="{{ isset($metal_purchase) ? $metal_purchase->metal_purchase_no : '0' }}"
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

                    <form id="metalPurchaseForm" action="#" method="POST" enctype="multipart/form-data">
                        <div class="card-body" style="font-size: 14px;">
                            {{-- Edit Form  --}}
                            @csrf
                            <div class="row">

                                <!-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Purchase Order:</label>
                                        <select id="purchase_order_id" name="purchase_order_id" class="form-control show-tick"
                                            tabindex="3">
                                            <option value="0" selected="selected" disabled>--Select
                                                Purchase Order--
                                            </option>
                                            @foreach ($purchase_orders as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($metal_purchase)) {{ $metal_purchase->purchase_order_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->purchase_order_no ?? '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Purchase Date:<span
                                                style="color:red;">*</span></label>
                                        <input type="date" name="purchase_date" id="purchase_date"
                                            class="form-control"
                                            value="{{ isset($metal_purchase) ? $metal_purchase->purchase_date : old('purchase_date') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Supplier/Karigar:</label>
                                        <select id="supplier_id" name="supplier_id" class="form-control show-tick"
                                            tabindex="3">
                                            <option value="0" selected="selected" disabled>--Select
                                                Supplier/Karigar--
                                            </option>
                                            @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($metal_purchase)) {{ $metal_purchase->supplier_id == $item->id ? 'selected' : '' }} @endif>
                                                {{ $item->name ?? '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-group">
                                            <label class="form-label">Reference:<span
                                                    style="color:red;">*</span></label>
                                            <input type="text" class="form-control"
                                                value="{{ isset($metal_purchase) ? $metal_purchase->reference : '' }}"
                                                id="reference" maxlength="255" name="reference" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-group">
                                            <label class="form-label">Pictures:</label>
                                            <input class="form-control" type="file" name="pictures[]" id="pictures"
                                                accept=".jpg, .jpeg, .png" multiple />
                                        </div>
                                    </div>
                                </div>
                                @if (isset($metal_purchase) && $metal_purchase->pictures!=null)
                                <div class="col-md-12 form-group mb-3">
                                    <b>Old Pictures <small>(if add then change)</small></b><br>
                                    @php
                                    $images = json_decode($metal_purchase->pictures, true);;
                                    @endphp

                                    @foreach ($images as $image)
                                    <a href="{{ asset($image) }}" target="_blank"><img
                                            src="{{ asset($image) }}" style="width:100px; height: 100px;"
                                            alt="Pictures"></a>
                                    @endforeach
                                </div>
                                @endif
                                <input type="hidden" class="form-control"
                                    value="{{ isset($metal_purchase) ? $metal_purchase->id : '' }}" id="id"
                                    name="id">
                                <div class="col-md-12">
                                    <hr class="mb-2 mt-2">
                                    <b>Add Purchase Detail:</b>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <label class="form-label">Purduct:<span style="color:red;">*</span></label>
                                        <div class="form-line">
                                            <select class="form-control" id="product_id" name="product_id" required>
                                                <option value="0" selected="selected" disabled>--Select Product--
                                                </option>
                                                @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ $product->name == $product->id ? 'selected' : '' }}>
                                                    {{ $product->prefix ?? '' }} - {{ $product->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <label class="form-label">Metal:<span style="color:red;">*</span></label>
                                        <div class="form-line">
                                            <select class="form-control" id="metal" name="metal" required>
                                                <option value="0" selected="selected" disabled>--Select Metal--
                                                </option>
                                                <option value="Immitation">Immitation</option>
                                                <option value="Silver">Silver</option>
                                                <option value="Palladium">Palladium</option>
                                                <option value="Platinum">Platinum</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Metal Purity (%):<span
                                                style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="purity" id="purity"
                                                    class="form-control" required
                                                    onkeypress="return isNumberKey(event)"
                                                    maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Scale Weight:<span
                                                style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="scale_weight" id="scale_weight"
                                                    class="form-control" required
                                                    onkeypress="return isNumberKey(event)"
                                                    maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Net Weight:</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="net_weight" id="net_weight"
                                                    class="form-control" min="0" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Rate per Gram:<span
                                                style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="metal_rate" required
                                                    id="metal_rate" class="form-control" value="0" onkeypress="return isNumberKey(event)"
                                                    maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Beads Weight:
                                            <a href="javascript:void(0)" id="BeadWeightButton"
                                                style="border: 1px solid #000; border-radius: 50%;padding: 3px 5px 3px 5px;"
                                                class="btn-primary"><i class="fa fa-plus text-white"></i></a>
                                        </label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="bead_weight" id="bead_weight"
                                                    class="form-control" min="0" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Stones Weight:
                                            <a href="javascript:void(0)" id="StonesWeightButton"
                                                style="border: 1px solid #000; border-radius: 50%;padding: 3px 5px 3px 5px;"
                                                class="btn-primary"><i class="fa fa-plus text-white"></i></a>
                                        </label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="stone_weight" id="stone_weight"
                                                    class="form-control" min="0" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Diamond Carat:
                                            <a href="javascript:void(0)" id="DiamondCaratButton"
                                                style="border: 1px solid #000; border-radius: 50%;padding: 3px 5px 3px 5px;"
                                                class="btn-primary"><i class="fa fa-plus text-white"></i></a>
                                        </label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="diamond_carat" id="diamond_carat"
                                                    class="form-control" min="0" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Total Metal Amount:</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="total_metal_amount"
                                                    id="total_metal_amount" readonly class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Total Bead Amount:</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="total_bead_amount"
                                                    id="total_bead_amount" readonly class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Total Stones Amount:</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="total_stones_amount"
                                                    id="total_stones_amount" value="0" readonly class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Total Diamond Amount:</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="total_diamond_amount"
                                                    id="total_diamond_amount" value="0" readonly class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Other Charge:</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="other_charges"
                                                    id="other_charges" class="form-control"
                                                    onkeypress="return isNumberKey(event)" value="0" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Total($):</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="total_dollar" id="total_dollar"
                                                    class="form-control" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Total(PKR):</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="total_amount" id="total_amount"
                                                    class="form-control" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Description:<span
                                                style="color:red;">*</span></label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="description" id="description"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-2 mt-4">
                                    <a class="btn btn-primary waves-effect text-center text-white" style="width:100%;"
                                        onclick="addProductRequest()">
                                        <i class="fa fa-plus"></i> Add
                                    </a>
                                </div>

                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="example"
                                        class="table table-striped table-hover dataTable js-exportable mb-3">
                                        <thead>
                                            <tr>
                                                <th>Sr.</th>
                                                <th>Product</th>
                                                <th>Metal</th>
                                                <th>Purity(%)</th>
                                                <th>Description</th>
                                                <th>Scale Wt</th>
                                                <th>Beads Wt</th>
                                                <th>Stones Wt</th>
                                                <th>Diamond Carat</th>
                                                <th>Net Wt</th>
                                                <th>Metal Rate</th>
                                                <th>Other Charge</th>
                                                <th>Total($)</th>
                                                <th>Total(PKR)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">Grand Total($):</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="grand_total_dollar"
                                                    value="{{ isset($metal_purchase) ? $metal_purchase->total_dollar : '0' }}"
                                                    id="grand_total_dollar" class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">Grand Total(PKR):</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="total"
                                                    value="{{ isset($metal_purchase) ? $metal_purchase->total : '0' }}"
                                                    id="total" class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">Paid($):</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="paid_dollar"
                                                    value="{{ isset($metal_purchase) ? $metal_purchase->paid_dollar : '0' }}"
                                                    id="paid_dollar" class="form-control font-weight-bold"
                                                    onkeypress="return isNumberKey(event)" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">Paid(PKR):</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="paid"
                                                    value="{{ isset($metal_purchase) ? $metal_purchase->paid : '0' }}"
                                                    id="paid" class="form-control font-weight-bold"
                                                    onkeypress="return isNumberKey(event)" maxlength="10">
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

    @include('purchases/metal_purchase/Modal/BeadModal')
    @include('purchases/metal_purchase/Modal/DiamondModal')
    @include('purchases/metal_purchase/Modal/StonesModal')
</div>
@endsection
@section('js')
<script type="text/javascript">
    var url_local = "{{ url('/') }}";
    var metal_purchase_id = "{{ isset($metal_purchase) ? $metal_purchase->id : '' }}";
    var dollar_rate = "{{$dollar_rate->rate}}";
</script>
<script src="{{ url('metal-purchase/js/metalPurchase.js') }}"></script>
<script src="{{ url('metal-purchase/js/beadWeight.js') }}"></script>
<script src="{{ url('metal-purchase/js/stoneWeight.js') }}"></script>
<script src="{{ url('metal-purchase/js/diamondCarat.js') }}"></script>

<script>
    $(document).ready(function() {
        // $('#purchase_order_id').select2();
        $('#purchase_account').select2();
        $('#product_id').select2();
        $('#supplier_id').select2();
        $('#metal').select2();
        $('#paid_account').select2();
        $('#paid_account_dollar').select2();


        var beadData = [];
        var stoneData = [];
        var diamondData = [];

        const purchase_date = document.getElementById("purchase_date");

        // ✅ Using the visitor's timezone
        purchase_date.value = formatDate();

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
        purchase_date.value = new Date().toISOString().split("T")[0];
    });
    $("#product_id").on("change", function() {
        beadData = [];
        stoneData = [];
        diamondData = [];
    });

    function removeSpaces(input) {
        if (input && typeof input === 'string') {
            return input.replace(/[^\w-]/g, '');
        } else {
            console.error("Input is invalid:", input);
            return ''; // Return a safe default
        }
    }
</script>
@endsection