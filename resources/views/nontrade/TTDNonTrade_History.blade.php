<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-12">
        <div style="overflow-x:auto;">
          <table class="table table-sm table-condensed table-bordered" align="center" style="width:100%; font-size:90%" id="table_list">
            <thead>
              <tr>
                <th class='text-center' style="background-color:#dc3545;color:white">No TTD</th>
                <th class='text-center' style="background-color:#dc3545;color:white">Attribute</th>
                <th class='text-center' style="background-color:#dc3545;color:white">Remark</th>
                <th class='text-center' style="background-color:#dc3545;color:white">Department ID</th>
                <th class='text-center' style="background-color:#dc3545;color:white">Store Code</th>
                <th class='text-center' style="background-color:#dc3545;color:white">Created By</th>
                <th class='text-center' style="background-color:#dc3545;color:white">Created Date</th>
                <th class='text-center' style="background-color:#dc3545;color:white">Updated By</th>
                <th class='text-center' style="background-color:#dc3545;color:white">Updated Date</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
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