@extends('adminlte::page')

@section('title', 'Master Employee')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-red card-tabs">
                    <div class="card-header p-0 pt-2 pb-2">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="card-title" style="color: white">&nbsp; Master Data Karyawan</li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12" style="display: flex; justify-content: space-between;">
                                <div class="row ml-1">
                                    <div class="form-group">
                                        <a href="javascript:void(0)" class="btn btn-m btn-success mr-3" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i>&nbsp; Tambah Data</a>
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:void(0)" class="btn btn-m btn-info" data-toggle="modal" data-target="#modal-upload"><i class="fas fa-upload"></i>&nbsp; Upload</a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <select name="storeCode" id="storeCode" class="form-control form-control-sm select2" style="width:20rem;" required="" autocomplete="off"></select>
                                    </div>
                                    <div class="form-group ml-2">
                                        <select name="categoryEmployee" id="categoryEmployee" class="form-control form-control-sm select2" style="width: 20rem;" required="" autocomplete="off">
                                            <option value="">Select at item</option>
                                            <option value="ALL">ALL</option>
                                            <option value="PKL">PKL</option>
                                            <option value="SPG">SPG</option>
                                        </select>
                                    </div>
                                    <div class="form-group mr-2">
                                        <button class="btn btn-danger btn-flat btn-sm" onclick="">SEARCH</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="div_table">
                            <div class="col-md-12">
                                <div style="overflow-x: auto;">
                                    <table class="table table-sm table-condensed table-bordered" style="font-size: 90%" id="list_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">ID Karyawan</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Nama Karyawan</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Tanggal Masuk</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Kode Toko</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Supplier</th>
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