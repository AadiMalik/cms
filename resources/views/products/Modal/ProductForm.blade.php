<div class="modal fade" id="ajaxModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="productForm" name="productForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Journal Name" maxlength="50" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="prefix" class="col-sm-2 control-label">Prefix:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="prefix" name="prefix"
                                placeholder="Enter Journal Prefix" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary" value="create">Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>
