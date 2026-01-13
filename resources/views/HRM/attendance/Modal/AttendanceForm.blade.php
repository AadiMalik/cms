<div class="modal fade" id="ajaxModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="attendanceForm" name="attendanceForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Employee:<span
                                        style="color:red;">*</span></label>
                                <select name="employee_id" class="form-control" id="employee_id" required>
                                    <option value="" selected disabled>--Select Employee--</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Date:<span
                                        style="color:red;">*</span></label>
                                <input type="date" name="attendance_date" id="attendance_date"
                                    value="{{ date('Y-m-d') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Check In:<span
                                        style="color:red;">*</span></label>
                                <input type="time" name="check_in" id="check_in" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Check Out:<span
                                        style="color:red;">*</span></label>
                                <input type="time" name="check_out" id="check_out" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Status:<span
                                        style="color:red;">*</span></label>
                                <select name="status" class="form-control" id="status" required>
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                    <option value="Late">Late</option>
                                    <option value="Leave">Leave</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">note:</label>
                                <input type="text" name="note" id="note" class="form-control">
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
