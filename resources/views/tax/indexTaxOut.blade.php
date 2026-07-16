@extends('adminlte::page')

@section('title', 'Master Employee')
@extends('icon')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-red card-tabs">
                    <div class="card-header p-0 pt-2 pb-2">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="card-title" style="color: white">&nbsp; Input Pajak Keluaran</li>
                        </ul>
                    </div>

                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="required">Operating Unit</label>
                            <select name="operating_unit_list" id="operating_unit_list" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off">
                              <option value="">Select at item</option>
                              <option value="95">Fashion</option>
                              <option value="116">Supermarket</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="required">Store</label>
                            <input type="text" class="form-control form-control-sm" id="outlet_code" name="outlet_code" maxlength="4" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="" class="required">Invoice Date</label>
                            <div class="d-flex gap-2">
                              <div class="input-group date p-1">
                                <input type="text" class="form-control form-control-sm flatpickr-input" id="start_date" name="start_date">
                                <div class="input-group-append">
                                  <div class="input-group-text" id="startDate"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                              <span class="m-1">To</span>
                              <div class="input-group date p-1">
                                <input type="text" class="form-control form-control-sm flatpickr-input" id="end_date" name="end_date">
                                <div class="input-group-append">
                                  <div class="input-group-text" id="endDate"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="d-flex gap-2 required">Invoice No</label>
                            <input type="text" class="form-control form-control-sm" id="invoice_no" name="invoice_no" maxlength="20" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="d-flex gap-2 required">Supplier - <small id="supplier_name_label" class="form-text m-1"></small></label>
                            <input type="text" class="form-control form-control-sm" id="customer_id" name="customer_id" maxlength="10" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="required">Transaction Code</label>
                            <input type="text" class="form-control form-control-sm" id="tr_code" name="tr_code" maxlength="4" autocomplete="off">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          <div class="form-group">
                            <button class="btn btn-secondary btn-sm" onclick=""><i class="fa fa-sync mr-2"></i>Generate</button>
                          </div>
                        </div>
                      </div>

                        <div class="row" id="div_table">
                            <div class="col-md-12">
                                <div style="overflow-x: auto;">
                                    <table class="table table-sm table-condensed table-bordered" style="font-size: 90%" id="list_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Invoice Date</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Invoice No</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Contract No</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Customer Code</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Name</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">NPWP</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">Tax Series No</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">DPP</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">DPP Nilai Lain</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">PPN</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">Process Tax</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot align="right"></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
@stop

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