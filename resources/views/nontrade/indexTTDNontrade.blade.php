@extends('adminlte::page')

@section('title', 'Non Trade')
@extends('icon')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card card-red card-tabs">
                <div class="card-header p-0 pt-2">
                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                        <li class="card-title" style="color: white">&nbsp; TTD NonTrade &nbsp;</li>
                        <li class="nav-item">
                          <a href="#custom-tabs-two-form" class="nav-link active" id="custom-tabs-two-form-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-form" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a href="#custom-tabs-two-list" class="nav-link" id="custom-tabs-two-list-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-list" aria-selected="false">List</a>
                        </li>
                        <li class="nav-item">
                          <a href="#custom-tabs-three-scan" class="nav-link" id="custom-tabs-three-scan-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-three-scan" aria-selected="false">Scan</a>
                        </li>
                        <li class="nav-item">
                          <a href="#custom-tabs-four-history" class="nav-link" id="custom-tabs-four-history-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-four-history" aria-selected="false">History</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="tab-pane fade show-active" id="custom-tabs-two-form" role="tabpanel" aria-labelledby="custom-tabs-two-form-tab">
                      @include('nontrade/TTDNonTrade_Form')
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-list" role="tabpanel" aria-labelledby="custom-tabs-two-list-tab">
                      @include('nontrade/TTDNonTrade_List')
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-scan" role="tabpanel" aria-labelledby="custom-tabs-three-scan-tab">
                      @include('nontrade/TTDNonTrade_Scan')
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-history" role="tabpanel" aria-labelledby="custom-tabs-four-history-tab">
                      @include('nontrade/TTDNonTrade_History')
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- @include('nontrade.TTDNonTrade_Info') --}}
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