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

    {{-- Modal Add --}}
    <div class="modal fade" id="modal-add" data-mode="add" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title">Tambah Data Karyawan</h3>
                </div>
                <form action="" id="modal-form" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" id="edit-faktur" name="edit-faktur">

                        <div class="form-group">
                            <label for="" data-required="true">Upload Foto</label>
                            <input type="file" class="form-control form-control-sm" id="new-image" name="new-image">
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Nama</label>
                                <input type="text" class="form-control form-control-sm" id="new-name" name="new-name">
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Tanggal Lahir</label>
                                <div class="input-group input-group-sm date">
                                    <input type="text" class="form-control flatpickr-input" id="new-birthday" name="new-birthday">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="birthday"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" data-required="true">Kategori</label>
                            <select name="new-category" id="new-category" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off">
                                <option value="">Select at item</option>
                                <option value="PKL">PKL</option>
                                <option value="SPG">SPG</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="" data-required="true">Alamat</label>
                            <textarea name="new-address" id="new-address" class="form-control form-control-sm"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Kode Toko</label>
                                <select name="new-store" id="new-store" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off"></select>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Perusahaan</label>
                                <select name="new-office" id="new-office" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off"></select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">No Handphone</label>
                                <input type="text" class="form-control form-control-sm" id="new-phone" name="new-phone" maxlength="16">
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Tanggal Masuk</label>
                                <div class="input-group input-group-sm date">
                                    <input type="text" class="form-control flatpickr-input" id="new-join" name="new-join">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="joindate"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">No KK</label>
                                <input type="text" class="form-control" id="new-kk" name="new-kk" maxlength="18">
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">No KTP</label>
                                <input type="text" class="form-control" id="new-ktp" name="new-ktp" maxlength="18">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Jenis Kelamin</label>
                                <select name="new-gender" id="new-gender" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off">
                                    <option value="">Select at item</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Status</label>
                                <select name="new-status" id="new-status" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off">
                                    <option value="">Select at item</option>
                                    <option value="1">Belum Menikah</option>
                                    <option value="2">Menikah</option>
                                    <option value="3">Duda</option>
                                    <option value="4">Janda</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn-sm btn-danger" data-dismiss="modal" onclick=""><i class="fa fa-times"></i>&nbsp; Batal</button>
                    <button type="button" class="btn-sm btn-primary" onclick="" id="submit-add"><i class="fas fa-save"></i>&nbsp; Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END --}}

    {{-- Modal Upload --}}
    <div class="modal fade" id="modal-upload" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="form-upload" enctype="multipart/form-data" class="form-horizontal">
                        {{ csrf_field() }}
                        @if (Session::has('extension'))
                            <div class="alert alert-danger alert-dismissible" role="alert">This file not XLSX (Excel)!</div>
                        @endif
                        <div class="form-group {{ $errors->has('fileUpload') ? 'has-error' : '' }}">
                            <div class="row">
                                <label for="" class="col-sm-4 control-label">Choose File Excel</label>
                                <div class="col">
                                    <input type="file" class="form-control" name="file-excel" id="file-upload-excel">
                                    <small class="form-text text-muted">Format File XLSX, XLS.</small>
                                </div>
                            </div>

                            <div class="row">
                                <label for="" class="col-sm-4 control-label"></label>
                                <div class="col">
                                    <span style="margin-top: 5px;" class="btn btn-sm btn-info">
                                        <a onclick="" style="text-decoration: none; color: white;">TEMPLATE</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick=""><i class="fas fa-save"></i>&nbsp; Simpan</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- END --}}
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