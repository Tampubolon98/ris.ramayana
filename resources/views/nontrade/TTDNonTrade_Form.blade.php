<div class="row">
  <div class="col-md-12">
    <div class="">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label class="required">Date:</label>
            <div class="input-group date" id="datepicker4" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input form-control-sm" data-target="#datepicker2" name="periode" id="periode" / readonly="">
              <div class="input-group-append" data-target="#datepicker2" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="required">Department:</label>
            <select id="ttd_dept_code_to" class="form-control select2 form-control-sm" style="width: 100%;" required="" autocomplete="off">            <option value="">Select an item</option>
              {{-- @foreach($dept_list as $val)
                <option value="{{$val->department_code}}">{{$val->department_code}} || {{$val->department_name}}</option>
              @endforeach --}}
            </select>
          </div>
          <div class="form-group">
            <label class="required">Jenis Pembayaran:</label>
            <select id="hd_payment_type_fr" class="form-control form-control-sm" style="width: 100%;" required="" autocomplete="off">
              <option value="cash">Petty cash (cash)</option>
              <option value="cashless">Petty cash (cashless)</option>
            </select>
          </div>
          <div class="form-group">
            <label>Note:</label>
            <textarea type="text" cols="15" rows="3" class="form-control" id="prah_note" size="10" required></textarea>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label class="required">Details GR :</label>
            <div class="card card-red">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 col-12">
                    <div class="form-group">
                      <div style="overflow-x:auto;">
                        <table class="table table-sm table-condensed table-bordered" align="center" style="min-width:100%; font-size:90%" id="tableDataTTD">
                          <thead>
                            <tr>
                              <th width="25px"><input type="checkbox" id="select_all_gr" onclick="select_all_gr();"></th>
                              <th class='text-center'>No GR</th>
                              <th class='text-center'>No PO</th>
                              <th class='text-center'>No AP</th>
                              <th class='text-center'>No PCR</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <center><button class="btn btn-primary btn-sm" id="save_button" style="background: #1862a9" onclick="validation_save()"><i class="fa fa-save mr-2"></i>SAVE</button></center>
      </div>
    </div>
  </div>
</div>

