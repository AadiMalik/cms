<div class="modal fade" id="ajaxModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="retainerForm" name="retainerForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title" class="control-label">Title:<span
                                        style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter Title" maxlength="190" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" class="control-label">Day Of Month:<span
                                        class="text-danger">*</span></label>
                                <select id="day_of_month" name="day_of_month"
                                    class="form-control" required style="width:100%;">
                                    <option value="" selected="selected" disabled>--Select
                                        Day Of Month--
                                    </option>
                                    @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}
                                    </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" class="control-label">Jounral:<span
                                        class="text-danger">*</span></label>
                                <select id="journal_id" name="journal_id"
                                    class="form-control" required style="width:100%;">
                                    <option value="" selected="selected" disabled>--Select
                                        Journal--
                                    </option>
                                    @foreach ($journals as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name ?? '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" class="control-label">Debit Account:<span
                                        class="text-danger">*</span></label>
                                <select id="debit_account_id" name="debit_account_id"
                                    class="form-control" required style="width:100%;">
                                    <option value="" selected="selected" disabled>--Select
                                        Debit Account--
                                    </option>
                                    @foreach ($accounts as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name ?? '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" class="control-label">Credit Account:<span
                                        class="text-danger">*</span></label>
                                <select id="credit_account_id" name="credit_account_id"
                                    class="form-control" required style="width:100%;">
                                    <option value="" selected="selected" disabled>--Select
                                        Credit Account--
                                    </option>
                                    @foreach ($accounts as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name ?? '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" class="control-label">Currency:<span
                                        class="text-danger">*</span></label>
                                <select id="currency" name="currency"
                                    class="form-control" required style="width:100%;">
                                    <option value="" selected="selected" disabled>--Select
                                        Currency--
                                    </option>
                                    <option value="0">PKR</option>
                                    <option value="1">Gold (AU)</option>
                                    <option value="2">Dollar ($)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount" class="control-label">Amount:<span
                                        style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    placeholder="Enter Amount" value="0" required onkeypress="return isNumberKey(event)">
                            </div>
                        </div>
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