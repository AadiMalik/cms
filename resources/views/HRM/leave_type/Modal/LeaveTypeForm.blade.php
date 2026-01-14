<div class="modal fade" id="ajaxModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="leaveTypeForm" name="leaveTypeForm" class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" id="id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Leave Type" maxlength="150" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="leaves">Days:<span style="color:red;">*</span></label>

                                <input type="text" class="form-control" id="leaves" name="leaves" value="0"
                                    onkeypress="return isNumberKey(event)" maxlength="2" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="switch pr-5 switch-primary mr-3"><span>Is Paid</span> <span
                                        class="text-danger">*</span>
                                    <input type="checkbox" name="is_paid" id="is_paid" checked><span
                                        class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary" value="create">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
