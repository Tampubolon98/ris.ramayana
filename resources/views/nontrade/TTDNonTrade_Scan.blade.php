<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-md-6 col-12">
            <div class="form-group">
              <label class="">No TTD:</label>
              <input type="text" id="ds_no_ttd" name="ds_no_ttd" class="form-control form-control-sm" required="" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-danger btn-sm" onclick="get_list_scan()"><i class="fas fa-search mr-2"></i>SEARCH</button>
        </div>
      </div>
      <div class="col-sm-12" id="div_scan_table" style="display: none;">
        <div style="overflow-x:auto;">
          <table class="table table-sm table-condensed table-bordered" align="center" style="min-width:100%; font-size:90%" id="scan_table">
              <thead>
              <tr>
                <th class='text-center' style="background-color:#dc3545;color:white">No TTD</th>
                <th class='text-center' style="background-color:#dc3545;color:white">No GR</th>
                <th class='text-center' style="background-color:#dc3545;color:white">No AP</th>
                <th class='text-center' style="background-color:#dc3545;color:white">No PCR</th>
                <th class='text-center' style="background-color:#dc3545;color:white"><input type="checkbox" id="select_all_hd_status_ttd" onclick="select_all_hd_status_ttd();"></th>
              </tr>
              </thead>
              <tfoot align="right"></tfoot>
          </table>
        </div>
      </div>
    </div>
    <div class="form-group" id="save_button_container" style="display: none;">
      <center><button class="btn btn-primary" id="save_form_hd_status_ttd" style="background: #1862a9" onclick="save_hd_status_ttd()"><i class="fa fa-save mr-2"></i>SAVE</button></center>
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