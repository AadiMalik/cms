<div class="modal fade" id="tagPrintModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading">New Tag Print</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body">
                        <div class="row">
                              <div class="col-md-12">
                                    <b>Filter</b>
                              </div>
                              <div class="col-md-4">
                                    <div class="form-group">
                                          <label for="start_date">Start Date:<span style="color:red;">*</span></label>
                                          <input type="date" class="form-control" id="start_date" value="{{date('Y-m-d')}}">
                                    </div>
                              </div>
                              <div class="col-md-4">
                                    <div class="form-group">
                                          <label for="end_date">Start Date:<span style="color:red;">*</span></label>
                                          <input type="date" class="form-control" id="end_date" value="{{date('Y-m-d')}}">
                                    </div>
                              </div>
                              <div class="col-md-4">
                                    <div class="form-group">
                                          <button id="search_tag" class="btn btn-primary mt-4">Search</button>
                                    </div>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="name">Tag Product:<span style="color:red;">*</span></label>
                                          <select name="tag_products[]" class="form-control" id="tag_products" required multiple style="width:100%;">
                                                
                                          </select>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button type="submit" id="printBtn" class="btn btn-primary" value="create">Submit</button>
                  </div>
            </div>
      </div>
</div>