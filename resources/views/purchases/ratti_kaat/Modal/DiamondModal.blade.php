<div class="modal fade" id="diamondCaratModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Diamond Carat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="diamondCaratForm" name="diamondCaratForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="diamond_carat_product_id" id="diamond_carat_product_id">
                    <input type="hidden" name="diamond_carat_ratti_kaat_id" id="diamond_carat_ratti_kaat_id"
                        value="{{ isset($ratti_kaat) ? $ratti_kaat->id : '' }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Diamond:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="diamonds" name="diamonds"
                                    placeholder="Enter diamond" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Type:<span style="color:red;">*</span></label>
                                <select name="type" class="form-control" name="type" id="type" required>
                                    <option value="" selected disabled>--Select Type--</option>
                                    @foreach (config('enum.type') as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Cut:<span style="color:red;">*</span></label>
                                <select name="cut" class="form-control" name="cut" id="cut" required>
                                    <option value="" selected disabled>--Select Cut--</option>
                                    @foreach (config('enum.cut') as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Color:<span style="color:red;">*</span></label>
                                <select name="color" class="form-control" name="color" id="color" required>
                                    <option value="" selected disabled>--Select Color--</option>
                                    @foreach (config('enum.color') as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Clarity:<span style="color:red;">*</span></label>
                                <select name="clarity" class="form-control" name="clarity" id="clarity" required>
                                    <option value="" selected disabled>--Select Clarity--</option>
                                    @foreach (config('enum.clarity') as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Carat:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="carat" name="carat"
                                    placeholder="Enter diamond carat" value="0" onkeypress="return isNumberKey(event)"
                                    maxlength="10" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Rate/Carat:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="carat_rate" name="carat_rate"
                                    placeholder="Enter diamond carat rate" value="0" onkeypress="return isNumberKey(event)"
                                    maxlength="10" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Total PKR:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="diamond_total" name="diamond_total"
                                    placeholder="Enter diamond total" value="0" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Total $:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="diamond_total_dollar" name="diamond_total_dollar"
                                    placeholder="Enter diamond total dollar" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mt-4">
                                <button id="beadSave" style="width: 100%;" class="btn btn-primary"
                                    value="create">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>Diamonds</th>
                                        <th>Type</th>
                                        <th>Cut</th>
                                        <th>Color</th>
                                        <th>Clarity</th>
                                        <th>Carat</th>
                                        <th>Rate/Carat</th>
                                        <th>Total(PKR)</th>
                                        <th>Total($)</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="diamondTable">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
