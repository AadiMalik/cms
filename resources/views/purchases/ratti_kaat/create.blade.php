@extends('layouts.master')
@section('content')
    <div class="main-content pt-4">
        <div class="row pl-2">
            <div class="col-md-8 breadcrumb">
                <h1>Ratti Kaat</h1>
                @if (isset($ratti_kaat))
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
                <input type="text" name="ratti_kaat_no" id="ratti_kaat_no"
                    value="{{ isset($ratti_kaat) ? $ratti_kaat->ratti_kaat_no : '0' }}"
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
                        <div class="card-body" style="font-size: 14px;">
                            {{-- Edit Form  --}}
                            <form id="form_validation" action="#" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Purchase Date:<span
                                                    style="color:red;">*</span></label>
                                            <input type="date" name="purchase_date" id="purchase_date"
                                                class="form-control"
                                                value="{{ isset($ratti_kaat) ? $ratti_kaat->purchase_date : old('purchase_date') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Supplier/Karigar:</label>
                                            <select id="supplier_id" name="supplier_id" class="form-control show-tick"
                                                tabindex="3">
                                                <option value="" selected="selected" disabled>--Select
                                                    Supplier/Karigar--
                                                </option>
                                                @foreach ($suppliers as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if (isset($ratti_kaat)) {{ $ratti_kaat->supplier_id == $item->id ? 'selected' : '' }} @endif>
                                                        {{ $item->name ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Purchase Account:<span style="color:red;">*</span></label>
                                            <select id="purchase_account" name="purchase_account"
                                                class="form-control show-tick" data-live-search="true" required
                                                tabindex="9">
                                                <option value="0" selected>--Select Account--</option>
                                                @foreach ($accounts as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->code }} {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-float">
                                            <div class="form-group">
                                                <label class="form-label">Reference:<span
                                                        style="color:red;">*</span></label>
                                                <input type="text" class="form-control"
                                                    value="{{ isset($ratti_kaat) ? $ratti_kaat->reference : '' }}"
                                                    id="reference" maxlength="255" name="reference" required>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control"
                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->id : '' }}" id="id"
                                        name="id">
                                    <div class="col-md-12">
                                        <hr class="mb-2 mt-2">
                                        <b>Add Purchase Detail:</b>
                                    </div>

                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Scale Weight:<span style="color:red;">*</span></label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="scale_weight"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->scale_weight : '0' }}"
                                                        id="scale_weight" class="form-control" required
                                                        onkeypress="return isNumberKey(event)" maxlength="10">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Description:<span style="color:red;">*</span></label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="description"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->description : old('description') }}"
                                                        id="description" class="form-control" required>
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
                                                    <input type="text" name="beads_weight"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->beads_weight : '25.69' }}"
                                                        id="beads_weight" class="form-control" min="0">
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
                                                    <input type="text" name="stones_weight"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->stones_weight : '3.485' }}"
                                                        id="stones_weight" class="form-control" min="0">
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
                                                    <input type="text" name="diamond_carat"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->diamond_carat : '0' }}"
                                                        id="diamond_carat" class="form-control" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Net Weight:</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="net_weight"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->net_weight : '71.181' }}"
                                                        id="net_weight" class="form-control" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Ratti Kaat:
                                                <a href="javascript:void(0)" id="ChangeKaatButton"
                                                    style="border: 1px solid #000; border-radius: 50%;padding: 3px 5px 3px 5px;"
                                                    class="btn-primary"><i class="fa fa-refresh text-white"></i></a>
                                            </label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="ratti_kaat"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->ratti_kaat : '4' }}"
                                                        id="ratti_kaat" class="form-control" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Kaat:</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="kaat"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->kaat : '5.19' }}"
                                                        id="kaat" class="form-control" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Pure Payable:</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="pure_payable"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->pure_payable : '65.991' }}"
                                                        id="pure_payable" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Other Charge:</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="other_charge"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->other_charge : '0' }}"
                                                        id="other_charge" class="form-control"
                                                        onkeypress="return isNumberKey(event)" maxlength="10">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Bead Amount:</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="total_bead_amount" value="0"
                                                        id="total_bead_amount" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Stones Amount:</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="total_stones_amount" value="0"
                                                        id="total_stones_amount" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total diamond Amount:</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="total_diamond_amount" value="0"
                                                        id="total_diamond_amount" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Amount:</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="total_amount"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->total_amount : '0' }}"
                                                        id="total_amount" class="form-control" value="0">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Grand Total:</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" name="total"
                                                        value="{{ isset($ratti_kaat) ? $ratti_kaat->total : '0' }}"
                                                        id="total" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" class="form-control" id="poId" name="poId"
                                        value="">
                                    <div class="table-responsive">
                                        <table id="example"
                                            class="table table-striped table-hover dataTable js-exportable mb-3">
                                            <thead>
                                                <tr>
                                                    <th>Sr.</th>
                                                    <th>Product</th>
                                                    <th>Description</th>
                                                    <th>Scale Wt</th>
                                                    <th>Beads Wt</th>
                                                    <th>Stones Wt</th>
                                                    <th>diamond Carat</th>
                                                    <th>Net Wt</th>
                                                    <th>Ratti Kaat</th>
                                                    <th>Kaat</th>
                                                    <th>Pure Payable</th>
                                                    <th>Other Charge</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="col-md-12 mb-5">
                                        {{-- <a class="btn btn-primary waves-effect text-left" data-toggle="modal"
                                        data-target="#New-Entry-Modal" tabindex="5" accesskey="+"
                                        style="float: left;" id="NewProduct">
                                        <i class="i-Add text-white"></i> Add
                                    </a> --}}
                                        {{-- <div class="text-right">
                                            <b>Total Tax:</b><input type="text" id="tax_total"
                                                style="font-weight: bold; border:none;" value="0">
                                        </div> --}}
                                        {{-- <div class="text-right">
                                            <b>Total:</b><input type="text" id="purchase_total"
                                                style="font-weight: bold; border:none;" value="0">
                                        </div> --}}

                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" id="submit" accesskey="s"
                                            tabindex="10">SUBMIT</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!-- end of col -->
                </div>
                <!-- end of row -->
            </div>
        </section>

        @include('purchases/ratti_kaat/Modal/BeadModal')
        @include('purchases/ratti_kaat/Modal/diamondModal')
        @include('purchases/ratti_kaat/Modal/ChangeKaatModal')
        @include('purchases/ratti_kaat/Modal/StonesModal')
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        var url_local = "{{ url('/') }}";
        var ratti_kaat_id = "{{ isset($ratti_kaat) ? $ratti_kaat->id : '' }}";

        function isNumberKey(evt) {
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
    <script src="{{ url('ratti-kaats/js/rattiKaat.js') }}"></script>
    <script src="{{ url('ratti-kaats/js/beadWeight.js') }}"></script>
    <script src="{{ url('ratti-kaats/js/stoneWeight.js') }}"></script>
    <script src="{{ url('ratti-kaats/js/diamondCarat.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#purchase_account').select2();
            $('#product_id').select2();
            $('#supplier_id').select2();
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
    </script>
@endsection
