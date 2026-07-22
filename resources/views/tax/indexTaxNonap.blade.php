@extends('adminlte::page')

@section('title', 'Tax')
@extends('icon')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card card-red card-tabs">
                    <div class="card-header p-0 pt-2">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="card-title pt-2 px-3" style="color: white">&nbsp; Input Pajak</li>
                            <li class="nav-item">
                              <a href="#custom-tabs-two-home" class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Non A/P</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-two-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                          <div class="row">
                            <div class="col-md-12 p-2">
                              <label for="" class="control-label">Input Pajak Detail Non A/P</label>
                              <hr style="margin-top:5px; margin-bottom: 15px; border-color: #DC3545;">
                              <form action="" class="form-horizontal" method="post">
                                {!! csrf_field() !!}
                                <div class="row">
                                  <div class="form-group col-md-4">
                                    <label for="" class="control-label">Periode Awal</label>
                                    <div class="input-group date p-1" id="startDate" data-target-input="nearest">
                                      <input type="text" autocomplete="off" class="form-control form-control-sm datetimepicker-input" data-target="#startDate" name="startDate" id="startDates" value="" />
                                      <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group col-md-4">
                                    <label for="" class="control-label">Periode Akhir</label>
                                    <div class="input-group date p-1" id="endDate" data-target-input="nearest">
                                      <input type="text" readonly autocomplete="off" class="form-control form-control-sm" data-target="#endDate" name="endDate" id="endDates" value="" />
                                      <div class="input-group-append" data-target="#endDate">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group col-md-4">
                                    <label for="" class="control-label">&nbsp;</label><br>
                                    <div class="input-group p-1">
                                      <button type="submit" name="button" id="search" class="btn btn-xs btn-outline-info pl-5 pr-5 pt-1 pb-1" data-toggle="tooltip" title="Tampilkan Data"><i class="fa fa-search-plus text-default pl-3 pr-4"></i>[ : . . T A M P I L K A N &nbsp;&nbsp; D A T A . . : ]</button>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <div class="card" style="border: 1px solid #DC3545;">
                                <div class="card-body">
                                  <div class="table-responsive">
                                    <div class="row-d-flex justify-content-end">
                                      <div class="col-auto mb-2">
                                        <button type="button" class="btn btn-sm btn-success" onclick=""><i class="fa fa-plus"></i>&nbsp; Input Data</button>
                                      </div>
                                    </div>

                                    <table class="table table-lg" align="center" style="width: 100%; border: 2px solid #808080;" id="viewTable">
                                      <thead id="headReport" style="font-size:14px; background-color: grey; color: white;">
                                        <tr>
                                          <th style="vertical-align:bottom;">#</th>
                                          <th style="border-left:1px solid #fff; text-align: center;">Supplier #</th>
                                          <th style="border-left: 1px solid #fff; text-align: center;"><span style="color: grey;"></span>Masa Pajak<span style="color: grey;"></span></th>
                                          <th style="border-left: 1px solid #fff; text-align: center;">Tanggal Penerimaan</th>
                                          <th style="border-left: 1px solid #fff; text-align: center;">Faktur #</th>
                                          <th style="border-left: 1px solid #fff; text-align: center;">Tax Series</th>
                                          <th style="border-left: 1px solid #fff; text-align: center;"><span style="color: grey"></span>Tax Date<span style="color: grey"></span></th>
                                          <th style="border-left: 1px solid #fff; text-align: center;">DPP</th>
                                          <th style="border-left: 1px solid #DC3545; text-align: center;">DPP Nilai Lain</th>
                                          <th style="border-left: 1px solid #fff; text-align: center;">PPN</th>
                                          <th style="border-left: 1px solid #fff; text-align: center;">Release</th>
                                          <th style="border-left: 1px solid #fff; text-align: center;">Action</th>
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