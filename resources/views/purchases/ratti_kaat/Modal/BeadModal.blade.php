<div class="modal fade" id="beadWeightModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Bead Weight</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="beadWeightForm" name="beadWeightForm" class="form-horizontal">
                    <input type="hidden" name="bead_weight_product_id" id="bead_weight_product_id">
                    <input type="hidden" name="bead_weight_ratti_kaat_id" id="bead_weight_ratti_kaat_id"
                        value="{{ isset($ratti_kaat) ? $ratti_kaat->id : '' }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Type:<span style="color:red;">*</span></label>
                                <select name="type" class="form-control" name="type" id="type" required>
                                    <option value="" selected disabled>--Select Type--</option>
                                    @foreach ($bead_types as $item)
                                        <option value="{{ $item->name ?? '' }}">{{ $item->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Bead QTY:<span style="color:red;">*</span></label>

                                <input type="text" class="form-control" id="beads" name="beads"
                                    placeholder="Enter beads" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Gram:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="bead_gram" name="bead_gram"
                                    placeholder="Enter bead gram" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Carat:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="bead_carat" name="bead_carat"
                                    placeholder="Enter bead carat" onkeypress="return isNumberKey(event)" maxlength="10"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Rate/Gram:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="bead_gram_rate" name="bead_gram_rate"
                                    placeholder="Enter bead gram rate" onkeypress="return isNumberKey(event)"
                                    maxlength="10" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Rate/Carat:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="bead_carat_rate" name="bead_carat_rate"
                                    placeholder="Enter bead carat rate" onkeypress="return isNumberKey(event)"
                                    maxlength="10" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Total PKR:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="bead_total" name="bead_total"
                                    placeholder="Enter bead total" onkeypress="return isNumberKey(event)"
                                    maxlength="10" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mt-4">
                                <button id="beadSave" style="width: 100%;" class="btn btn-primary"
                                    value="create">Add</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Type</th>
                                    <th>Bead QTY</th>
                                    <th>Gram</th>
                                    <th>Carat</th>
                                    <th>Rate/Gram</th>
                                    <th>Rate/Carat</th>
                                    <th>Total</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="beadTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
