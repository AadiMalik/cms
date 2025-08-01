<div class="modal fade" id="usedGoldModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Used Gold</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="usedGoldForm" name="usedGoldForm" class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Gold Type:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="used_gold_type" name="used_gold_type"
                                    placeholder="Enter gold type" maxlength="191"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Weight:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="used_weight" name="used_weight"
                                    placeholder="Enter weight" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Kaat:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="used_kaat" name="used_kaat"
                                    placeholder="Enter kaat" value="0" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Pure Weight:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="used_pure_weight" name="used_pure_weight"
                                    readonly value="0" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Karrat:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="used_karat" name="used_karat"
                                    placeholder="Enter karat" value="0" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Rate:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="used_rate" name="used_rate"
                                    placeholder="Enter rate" value="0" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Amount:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="used_amount" name="used_amount"
                                    readonly value="0" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Description:</label>
                                <input type="text" class="form-control" id="used_description" name="used_description"
                                placeholder="Enter description" value="" maxlength="191">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mt-4">
                                <a class="btn btn-primary waves-effect text-center text-white" style="width:100%;"
                                            onclick="addUsedGold()">
                                            <i class="fa fa-plus"></i> Add
                                        </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" id="usedGoldTable">
                                <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>Gold Type</th>
                                        <th>Weight</th>
                                        <th>Kaat</th>
                                        <th>Pure Weight</th>
                                        <th>Karat</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>

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
