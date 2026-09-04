@extends('layouts.master')

@section('title', 'Master Employee')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-red card-tabs">
                    <div class="card-header p-0 pt-2 pb-2">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="card-title" style="color: white">&nbsp; Report Employee SPG</li>
                        </ul>
                    </div>

                    <div class="col-md-12 mt-2">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Kode Toko:</label>
                            <select name="storeCode" id="storeCode" class="form-control form-control-m select2" style="width:100%;" required="" autocomplete="off"></select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Kategori:</label>
                            <select name="categoryEmployee" id="categoryEmployee" class="form-control form-control-m select2" style="width: 100%;" required="" autocomplete="off">
                              <option value="">Select at item</option>
                              <option value="ALL">ALL</option>
                              <option value="PKL">PKL</option>
                              <option value="SPG">SPG</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <button class="btn btn-danger btn-m" onclick=""><i class="fas fa-file-pdf"></i>&nbsp; Export PDF</button>
                        <button class="btn btn-success btn-m" onclick=""><i class="fas fa-file-excel"></i>&nbsp; Export Excel</button>
                      </div>
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