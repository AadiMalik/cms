<div class="modal fade" id="ajaxModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="supplierPaymentForm" name="supplierForm" class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="id" name="id" readonly>
                        <div class="col-md-6">
                            <label for="supplier_id">Supplier/Karigar:<span style="color:red;">*</span></label>
                            <div class="form-group">
                                <select class="form-control" name="supplier_id" id="supplier_id" required style="width: 100%;">
                                    <option selected disabled>--Select supplier/karigar--</option>
                                    @if (isset($suppliers))
                                    @foreach ($suppliers as $item)
                                    <option value="{{ $item->id }}">{{ $item->name ?? '' }} </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="account_id">Credit Account:</label>
                            <div class="form-group">
                                <select class="form-control" name="account_id" id="account_id" style="width: 100%;">
                                    <option value="" selected disabled>--Select Account--</option>
                                    @if (isset($accounts))
                                    @foreach ($accounts as $item)
                                    <option value="{{ $item->id }}">{{ $item->code }} {{ $item->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Currency:<span style="color:red;">*</span></label>
                            <div class="form-group">
                                <select id="currency" name="currency" class="form-control show-tick" required>
                                    <option value="0">PKR</option>
                                    <option value="1">Gold (AU)</option>
                                    <option value="2">Dollar ($)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_date">Date:<span style="color:red;">*</span></label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="payment_date" id="payment_date"
                                    placeholder="Enter Payment Date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="cheque_ref">Cheque Ref:</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="cheque_ref" id="cheque_ref"
                                    placeholder="Enter Cheque Reference">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="sub_total">Amount:<span style="color:red;">*</span></label>
                            <div class="form-group">
                                <input type="number" step="any" class="form-control" name="sub_total"
                                    id="sub_total" placeholder="Enter Amount">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="total">Total Amount:</label>
                            <div class="form-group">
                                <input type="number" step="any" class="form-control" readonly name="total"
                                    id="total" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tax">Tax(%):</label>
                            <div class="form-group">
                                <input type="number" step="any" class="form-control" value="0" name="tax"
                                    id="tax" placeholder="Enter Tax">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tax_amount">Tax Amount:</label>
                            <div class="form-group">
                                <input type="text" step="any" class="form-control" readonly name="tax_amount"
                                    id="tax_amount" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="select_branch">Tax Account:</label>
                            <div class="form-group">
                                <select class="form-control" name="tax_account_id" id="tax_account_id" style="width: 100%;">
                                    <option selected disabled>--Select Account--</option>
                                    @if (isset($accounts))
                                    @foreach ($accounts as $item)
                                    <option value="{{ $item->id }}">{{ $item->code }} {{ $item->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" style="display: none;">
                            <div class="form-group mt-4">
                                <input type="checkbox" name="is_consumed" id="is_consumed">
                                <label for="tax_amount">Is Consumed:</label>
                            </div>
                        </div>
                        <div class="col-md-6" style="display: none;">
                            <label for="select_branch">Product:<span style="color:red;">*</span></label>
                            <div class="form-group">
                                <select class="form-control" name="other_product_id" id="other_product_id" style="width: 100%;" required>
                                    <option selected disabled>--Select Product--</option>
                                    @if (isset($other_products))
                                    @foreach ($other_products as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" style="display: none;">
                            <label for="select_branch">Warehouse:<span style="color:red;">*</span></label>
                            <div class="form-group">
                                <select class="form-control" name="warehouse_id" id="warehouse_id" style="width: 100%;" required>
                                    <option selected disabled>--Select Warehouse--</option>
                                    @if (isset($warehouses))
                                    @foreach ($warehouses as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"
                        id="close">Close</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary" value="create">Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>