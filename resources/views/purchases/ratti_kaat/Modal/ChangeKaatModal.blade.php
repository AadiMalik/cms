<div class="modal fade" id="changeKaatModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Change Ratti Kaat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="changeKaatForm" name="changeKaatForm" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Email:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Enter permission email" maxlength="50" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kaat" class="col-sm-2 control-label">Kaat:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="kaat" name="kaat"
                                placeholder="Enter kaat" required onkeypress="return isNumberKey(event)" maxlength="10">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary" value="create">Save Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
