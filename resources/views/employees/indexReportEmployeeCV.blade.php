@extends('adminlte::page')

@section('title', 'Master Employee')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-red card-tabs">
                    <div class="card-header p-0 pt-2 pb-2">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="card-title" style="color: white">&nbsp; Report Employee CV</li>
                        </ul>
                    </div>

                    <div class="col-md-12 mt-2">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">ID Karyawan:</label>
                            <input type="text" id="idEmployee" class="form-control form-control-m">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <button class="btn btn-danger btn-m" onclick=""><i class="fas fa-file-pdf"></i>&nbsp; Export PDF</button>
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