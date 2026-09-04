@extends('layouts.master')

@section('title', 'Master Employee')

@section('content_header')
<div class="modal inmodal bd-example-modal-lg" id="modalViewInfo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated bounceInRight" style="max-height: calc(100vh - 100px); overflow-y: auto;">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>No TTD:</label>
              <input type="text" id="ttd_code_info" class="form-control form-control-sm" readonly />
            </div>
            <div class="form-group">
              <label>Store:</label>
              <input type="text" id="ttd_store_code_info" class="form-control form-control-sm" disabled>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Department:</label>
              <input type="text" id="ttd_dept_code_create_info" class="form-control form-control-sm" disabled>
            </div>
            <div class="form-group">
              <label>Created By:</label>
              <input type="text" id="ttd_created_by_info" class="form-control form-control-sm" readonly />
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table_details_info" class="table table-striped table-sm table-condensed table-bordered">
            <thead>
              <tr>
                <th class='text-center'>No GR</th>
                <th class='text-center'>No PCR</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('content')
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop