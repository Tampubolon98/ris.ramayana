<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-6 col-12">
        <div class="form-group">
          <label for="exampleInputPassword1" class="required">Periode Start - End</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            </div>
            <input readonly type="text" class="form-control float-right form-control-sm" id="date_range_ttd" name="dtbRange">
          </div>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="form-group">
          <label>Transaction No:</label>
          <input type="text" class="form-control form-control-sm" id="hd_no_ttd_list" onkeypress="clear_filter()" onkeydown="clear_filter()" autocomplete="off" >
        </div>
      </div>
      <div class="col-md-12 col-12">
        <div class="form-group">
          <button class='btn btn-danger btn-sm' onclick='clear_filter_list()'>Clear Filter</button>
          <button class='btn btn-danger btn-sm' onclick='get_list()'>Search</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <input hidden type="number" id="row_count" name="row_count" class="form-control" style="text-align:right" value="0">
    <div style="overflow-x:auto;">
      <table class="table table-sm table-condensed table-bordered" align="center" style="min-width:100%; font-size:90%" id="list_tableDataTTD">
        <thead>
          <tr>
            <th class='text-center' style="background-color:#dc3545;color:white">No TTD</th>
            <th class='text-center' style="background-color:#dc3545;color:white">Attribute</th>
            <th class='text-center' style="background-color:#dc3545;color:white">Store Code</th>
            <th class='text-center' style="background-color:#dc3545;color:white">Department</th>
            <th class='text-center' style="background-color:#dc3545;color:white">Remark</th>
            <th class='text-center' style="background-color:#dc3545;color:white">Created By</th>
            <th class='text-center' style="background-color:#dc3545;color:white">Created Date</th>
          </tr>
        </thead>
        <tfoot align="right"></tfoot>
      </table>
    </div>
  </div>
</div>

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        .nav-tabs {
            border-bottom: none !important;
        }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop