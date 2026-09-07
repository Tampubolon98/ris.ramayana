@extends('layouts.master')

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

    {{-- Modal Add --}}
    <div class="modal fade" id="modal-add" data-mode="add" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title">Tambah Data Karyawan</h3>
                </div>
                <form action="{{ route('/master-employee.add-employee') }}" id="modal-form" method="post" enctype="multipart/form-data" class="form-horizontal">
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
                                <select id="new-store" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off"></select>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Perusahaan</label>
                                <select name="new-office" id="new-office" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off"></select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">No Handphone</label>
                                <input type="text" class="form-control form-control-sm" id="new-phone" name="new-phone" maxlength="12">
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
                                <input type="text" class="form-control" id="new-kk" name="new-kk" maxlength="16">
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">No KTP</label>
                                <input type="text" class="form-control" id="new-ktp" name="new-ktp" maxlength="16">
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
                    <button type="reset" class="btn-sm btn-danger" data-dismiss="modal" onclick="resetPage()"><i class="fa fa-times"></i>&nbsp; Batal</button>
                    <button type="button" class="btn-sm btn-primary" onclick="addData()" id="submit-add"><i class="fas fa-save"></i>&nbsp; Simpan</button>
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
                    <form id="form_upload" enctype="multipart/form-data" class="form-horizontal">
                        {{ csrf_field() }}
                        @if (Session::has('extension'))
                            <div class="alert alert-danger alert-dismissible" role="alert">This file not XLSX (Excel)!</div>
                        @endif
                        <div class="form-group {{ $errors->has('fileUpload') ? 'has-error' : '' }}">
                            <div class="row">
                                <label for="" class="col-sm-4 control-label">Choose File Excel</label>
                                <div class="col">
                                    <input type="file" class="form-control" name="file_excel" id="file
                                    UploadExcel">
                                    <small class="form-text text-muted">Format File XLSX, XLS.</small>
                                </div>
                            </div>

                            <div class="row">
                                <label for="" class="col-sm-4 control-label"></label>
                                <div class="col">
                                    <span style="margin-top: 5px;" class="btn btn-sm btn-info">
                                        <a onclick="downloadTemplate()" style="text-decoration: none; color: white;">TEMPLATE</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="uploadData()"><i class="fas fa-save"></i>&nbsp; Simpan</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- END --}}

    {{-- Modal Detail --}}
    <div class="modal inmodal bd-example-modal-lg" id="modal-detail" data-mode="detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight" style="max-height: calc(100vh - 100px); overflow-y: auto;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title">Detail Data Karyawan</h3>
                        <button type="button" id="close_modal" class="close float-right" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Nama</label>
                                <input type="text" id="new-name" class="form-control form-control-sm" disabled />
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Tanggal Lahir</label>
                                <div class="input-group input-group-sm date">
                                    <input type="text" class="form-control flatpickr-input" id="new-birthday" name="new-birthday" disabled>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="birthDay"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea id="new-address" name="new-address" class="form-control form-control-sm" disabled></textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Kode Toko</label>
                                <select id="new-store" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled></select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Perusahaan</label>
                                <select id="new-office" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>No Handphone</label>
                                <input type="text" class="form-control form-control-sm" id="new-phone" name="new-phone" disabled>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Tanggal Masuk</label>
                                <div class="input-group input-group-sm date">
                                    <input type="text" class="form-control flatpickr-input" id="new-join" name="new-join" disabled>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="joinDate"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="required" data-required="true">Nomor Kartu Keluarga</label>
                                <input type="text" class="form-control" id="new-kk" name="new-kk" maxlength="18" disabled>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label class="required" data-required="true">Nomor KTP</label>
                                <input type="text" class="form-control" id="new-ktp" name="new-ktp" maxlength="18" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="required" data-required="true">Jenis Kelamin</label>
                                <select id="new-gender" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled>
                                    <option value="">Select at item</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="required" data-required="true">Status</label>
                                <select id="new-status" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled>
                                    <option value="">Select at item</option>
                                    <option value="1">Belum Menikah</option>
                                    <option value="2">Menikah</option>
                                    <option value="3">Duda</option>
                                    <option value="4">Janda</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="table_details_info" class="table table-striped table-sm table-condensed table-bordered">
                            <thead>
                            <tr>
                                <th class='text-center'>Perusahaan</th>
                                <th class='text-center'>ID Karyawan</th>
                                <th class='text-center'>Kode Toko</th>
                                <th class='text-center'>Brand</th>
                                <th class='text-center'>Tanggal Masuk</th>
                                <th class='text-center'>Tanggal Keluar</th>
                            </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END --}}

    {{-- Modal Edit --}}
    <div class="modal fade" id="modal-edit" data-mode="edit" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title">Edit Data Karyawan</h3>
                </div>
                <form id="modalForm" class="form-horizontal" method="post" action="{{ route('/master-employee.edit') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="card-body">
                    <input type="hidden" id="idemployee" name="editFaktur">
                    <div class="form-group">
                        <label class="" data-required="true">Upload Foto</label>
                         <div id="previewImage">
                            <img src="" id="oldImagePreview" width="120" height="150" style="border:1px solid #ccc; border-radius:5px; margin-bottom: 5px;" />
                        </div>
                        <input type="file" class="form-control form-control-sm" id="new-image" name="newImage">
                    </div>

                    <div class="row">
                        <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Nama</label>
                        <input type="text" class="form-control form-control-sm" id="new-name" name="new-name">
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Tanggal Lahir</label>
                        <div class="input-group input-group-sm date">
                            <input type="text" class="form-control flatpickr-input" id="new-birthday" name="new-birthday">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="birthDay"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="required" data-required="true">Alamat</label>
                    <textarea id="new-address" name="new-address" class="form-control form-control-sm"></textarea>
                    </div>

                    <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Kode Toko</label>
                        <select id="editStoreCode" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off"></select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Perusahaan</label>
                        <select id="editOffice" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off"></select>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">No Handphone</label>
                        <input type="text" class="form-control form-control-sm" id="new-phone" name="new-phone">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Tanggal Masuk</label>
                        <div class="input-group input-group-sm date">
                            <input type="text" class="form-control flatpickr-input" id="new-join" name="new-join">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="joinDate"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>

                    </div>
                    </div>

                    <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Nomor Kartu Keluarga</label>
                        <input type="text" class="form-control" id="new-kk" name="new-kk">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Nomor KTP</label>
                        <input type="text" class="form-control" id="new-ktp" name="new-ktp">
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Jenis Kelamin</label>
                        <select id="new-gender" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off">
                            <option value="">Select at item</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Status</label>
                        <select id="new-status" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off">
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
                    <button type="reset" class="btn-sm btn-danger" data-dismiss="modal" onclick="resetPage()"><i class="fa fa-times"></i>&nbsp; Batal</button>
                    <button type="button" class="btn-sm btn-primary" onclick="editData()" id="submitadd"><i class="fas fa-save"></i>&nbsp; Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END --}}

    {{-- Modal Terminate --}}
    <div class="modal fade" id="modal-terminate" data-mode="terminate" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title">Terminate Data Karyawan</h3>
                </div>
                <form id="modalForm" class="form-horizontal" method="post" action="{{ route('/master-employee.terminate') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="card-body">
                    <input type="hidden" id="idemployee" name="editFaktur">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Nama</label>
                        <input type="text" class="form-control form-control-sm" id="new-name" name="new-name" disabled>
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Tanggal Lahir</label>
                        <div class="input-group input-group-sm date">
                            <input type="text" class="form-control flatpickr-input" id="new-birthday" name="new-birthday" disabled>
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="birthDay"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="required" data-required="true">Alamat</label>
                    <textarea id="new-address" name="new-address" class="form-control form-control-sm" disabled></textarea>
                    </div>

                    <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Kode Toko</label>
                        <select id="new-store" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled></select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Perusahaan</label>
                        <select id="new-office" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled></select>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">No Handphone</label>
                        <input type="text" class="form-control form-control-sm" id="new-phone" name="new-phone" maxlength="16" disabled>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Tanggal Masuk</label>
                        <div class="input-group input-group-sm date">
                            <input type="text" class="form-control flatpickr-input" id="new-join" name="new-join" disabled>
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="joinDate"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>

                    </div>
                    </div>

                    <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Nomor Kartu Keluarga</label>
                        <input type="text" class="form-control" id="new-kk" name="new-kk" maxlength="18" disabled>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Nomor KTP</label>
                        <input type="text" class="form-control" id="new-ktp" name="new-ktp" maxlength="18" disabled>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Jenis Kelamin</label>
                        <select id="new-gender" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled>
                            <option value="">Select at item</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Status</label>
                        <select id="new-status" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled>
                            <option value="">Select at item</option>
                            <option value="1">Belum Menikah</option>
                            <option value="2">Menikah</option>
                            <option value="3">Duda</option>
                            <option value="4">Janda</option>
                        </select>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label class="required" data-required="true">Tanggal Keluar</label>
                            <div class="input-group input-group-sm date">
                                <input type="text" class="form-control flatpickr-input" id="new-out" name="new-out">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="outDate"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="required" data-required="true">Catatan Kerja Karyawan</label>
                        <textarea id="new-note" name="new-note" class="form-control form-control-sm"></textarea>
                    </div>
                    
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn-sm btn-danger" data-dismiss="modal" onclick="resetPage()"><i class="fa fa-times"></i>&nbsp; Batal</button>
                    <button type="button" class="btn-sm btn-primary" onclick="terminateData()" id="submitadd"><i class="fas fa-save"></i>&nbsp; Terminate</button>
                </div>
                </form>
            </div>
        </div>
     </div>
    {{-- END --}}
@stop

@section('content')
@stop

@section('js')
    {{--
        Library global (jQuery, DataTables, Select2, SweetAlert2, Flatpickr,
        modal loading, dan fungsi helper) sudah dimuat otomatis oleh
        layouts.master. Di sini cukup script khusus halaman ini saja.
    --}}
    <script>
        function getFormattedDate() {
            let today = new Date();
            let day = String(today.getDate()).padStart(2, '0');
            let month = String(today.getMonth() + 1).padStart(2, '0');
            let year = today.getFullYear();
            return `${day}-${month}-${year}`;
        }

        let tglLahir = flatpickr("#new-birthday", {
            dateFormat: 'd-m-Y',
            allowInput: true,
            defaultDate: getFormattedDate()
        });

        document.getElementById('birthday').addEventListener('click', function() {
            tglLahir.open();
        });

        let tglMasuk = flatpickr("#new-join", {
            dateFormat: 'd-m-Y',
            allowInput: true,
            defaultDate: getFormattedDate()
        });

        document.getElementById('joindate').addEventListener('click', function() {
            tglMasuk.open();
        });

        $('#new-category').on('change', function() {
            if ($(this).val() === 'PKL') {
                $('#new-office').empty().append(
                    new Option('021 - RAMAYANA - RAMAYANA LESTARI SENTOSA PT', '021', true, true)
                ).trigger('change');
            } else {
                $('#new-office').val(null).trigger('change');
            }
        });

        function downloadTemplate(){
            showModalLoading();
            let type_emp = $('#type').val();

            $.ajax({
                method: 'get',
                url: `{{ route('/master-employee.template') }}`,
                data: {
                    'type': type_emp
                },
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function(){
                    showModalLoading();
                },
                success: function(res){
                    var blob = new Blob([res], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Template_Upload_MasterData.xlsx";
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                complete: function(){
                    hideModalLoadingV2();
                },
                error: function(e) {
                    hideModalLoadingV2();
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Download Failed!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        function getDataEmp(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'get',
                url: "{{ route('/master-employee.get-employee') }}",
                success: function(response){
                    if ($.fn.DataTable.isDataTable('#list_table')) {
                        $('#list_table').DataTable().destroy();
                    }

                    $('#list_table').DataTable({
                        order: [],
                        processing: true,
                        pageLength: 10,
                        data: response.data,
                        columns: [
                            {
                                data: 'id_employee',
                                name: 'a.id_employee',
                                className: 'text-left'
                            },
                            {
                                data: 'nama',
                                name: 'a.nama',
                                className: 'text-left',
                                width: '200px'
                            },
                            {
                                data: 'tanggal_masuk',
                                name: 'a.tanggal_masuk',
                                className: 'text-center',
                                render: function(data) {
                                    let today = new Date(data);
                                    let day = String(today.getDate()).padStart(2, '0');
                                    let month = String(today.getMonth() + 1).padStart(2, '0');
                                    let year = today.getFullYear();
                                    return `${day}-${month}-${year}`;
                                }
                            },
                            {
                                data: 'kode_toko',
                                name: 'a.kode_toko',
                                className: 'text-center',
                                render: function(data, type, row) {
                                    let store = row.store !== null ? row.store : row.kode_toko;

                                    return store;
                                }
                            },
                            {
                                data: 'md_emp',
                                name: 'a.md_emp',
                                className: 'text-left',
                                width: '200px',
                                render: function(data, type, row) {
                                    return row.md_emp + ' - ' + row.brand_emp + ' - ' + row.supplier;
                                }
                            },
                            {
                                data: 'kode_toko',
                                name: 'a.kode_toko',
                                className: 'text-center',
                                width: '200px',
                                render: function(data, type, row) {
                                    let md = row.md !== null ? row.md : row.md_emp;
                                    let brand = row.brand !== null ? row.brand : row.brand_emp;
                                    let supplier = row.detail_brand !== null ? row.detail_brand : row.supplier;
                                    let store = row.store !== null ? row.store : row.kode_toko;
                                    let storeName = row.store_name !== null ? row.store_name : row.homebase;
                                    let tglKeluar = row.out_date !== null ? row.out_date : row.tanggal_keluar;
                                    let tglMasuk = row.join_date !== null ? row.join_date : row.tanggal_masuk;
                                    let kk = row.kk !== null ? row.kk : row.no_kk;
                                    let ktp = row.ktp !== null ? row.ktp : row.no_ktp;
                                    return `
                                        <center>
                                            <div class="d-grid gap-2 d-md-flex justify-content-center">
                                                <span data-toggle="tooltip" title="Edit Data" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary mr-2 edit" 
                                                    data-target="#modal-edit" data-toggle="modal"
                                                    data-idemployee="${row.id_employee}"
                                                    data-image="${row.image_employee}"
                                                    data-nama="${row.nama}"
                                                    data-tgllahir="${row.tanggal_lahir}"
                                                    data-alamat="${row.alamat}"
                                                    data-kodetoko="${store}"
                                                    data-homebase="${storeName}"
                                                    data-perusahaan="${supplier}"
                                                    data-brand="${brand}"
                                                    data-md="${md}"
                                                    data-handphone="${row.no_handphone}"
                                                    data-tglmasuk="${tglMasuk}"
                                                    data-nokk="${kk}"
                                                    data-noktp="${ktp}"
                                                    data-jeniskelamin="${row.jenis_kelamin}"
                                                    data-status="${row.status}"
                                                    data-note="${row.keterangan}">
                                                    <i class="fas fa-edit"></i>&nbsp Edit
                                                    </a>
                                                </span>

                                                <span title="Detail Data" data-toggle="tooltip" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-info mr-2 detail" data-target="#modal-detail" data-toggle="modal"
                                                    data-idemployee="${row.id_employee}"
                                                    data-nama="${row.nama}"
                                                    data-tgllahir="${row.tanggal_lahir}"
                                                    data-alamat="${row.alamat}"
                                                    data-kodetoko="${store}"
                                                    data-homebase="${storeName}"
                                                    data-perusahaan="${supplier}"
                                                    data-md="${md}"
                                                    data-brand="${brand}"
                                                    data-handphone="${row.no_handphone}"
                                                    data-tglmasuk="${tglMasuk}"
                                                    data-nokk="${kk}"
                                                    data-noktp="${ktp}"
                                                    data-jeniskelamin="${row.jenis_kelamin}"
                                                    data-status="${row.status}"
                                                    data-note="${row.keterangan}">
                                                        <i class="fas fa-eye"></i>&nbsp View
                                                    </a>
                                                </span>

                                                <span data-toggle="tooltip" title="Delete Data" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger mr-2 terminate" 
                                                    data-target="#modal-terminate" data-toggle="modal"
                                                    data-idemployee="${row.id_employee}"
                                                    data-nama="${row.nama}"
                                                    data-tgllahir="${row.tanggal_lahir}"
                                                    data-alamat="${row.alamat}"
                                                    data-kodetoko="${store}"
                                                    data-homebase="${storeName}"
                                                    data-perusahaan="${supplier}"
                                                    data-md="${md}"
                                                    data-brand="${brand}"
                                                    data-handphone="${row.no_handphone}"
                                                    data-tglmasuk="${tglMasuk}"
                                                    data-nokk="${kk}"
                                                    data-noktp="${ktp}"
                                                    data-jeniskelamin="${row.jenis_kelamin}"
                                                    data-status="${row.status}"
                                                    data-tglkeluar="${row.tanggal_terminate}"
                                                    data-note="${row.keterangan}">
                                                    <i class="fas fa-trash"></i>&nbsp Terminate
                                                    </a>
                                                </span>
                                            </div>
                                        </center>
                                    `;
                                }
                            }
                        ]
                    });
                },
                error: function(xhr, status, error){
                    Swal.fire({
                        title: 'Failed!',
                        text: 'Gagal Mendapatkan Data',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        $(document).on('click', 'a.detail', function() {
            // Ambil data dari atribut data
            let idEmployee = $(this).data('idemployee');
            let nama = $(this).data('nama');
            let tgllahir = $(this).data('tgllahir');
            let alamat = $(this).data('alamat');
            let kodetoko = $(this).data('kodetoko');
            let homebase = $(this).data('homebase');
            let perusahaan = $(this).data('perusahaan');
            let md = $(this).data('md');
            let brand = $(this).data('brand');
            let handphone = $(this).data('handphone');
            let tglmasuk = $(this).data('tglmasuk');
            let nokk = $(this).data('nokk');
            let noktp = $(this).data('noktp');
            let jeniskelamin = $(this).data('jeniskelamin');
            let status = $(this).data('status');
            let tglkeluar = $(this).data('tglkeluar');
            let note = $(this).data('note');

            function formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            }

            // Buka modal detail
            $('#modal-detail').modal('show');
            getHistoryData(noktp);
            
            // Set nilai form
            $('#modal-detail #idemployee').val(idEmployee);
            $('#modal-detail #new-name').val(nama);
            $('#modal-detail #new-birthday').val(formatDate(tgllahir));
            $('#modal-detail #new-address').val(alamat);
            $('#modal-detail #new-phone').val(handphone);
            $('#modal-detail #new-join').val(formatDate(tglmasuk));
            $('#modal-detail #new-kk').val(nokk);
            $('#modal-detail #new-ktp').val(noktp);
            $('#modal-detail #new-out').val(formatDate(tglkeluar));
            $('#modal-detail #new-note').val(note);
            $('#modal-detail #new-gender').val(jeniskelamin).trigger('change');
            $('#modal-detail #new-status').val(status).trigger('change');

            if (tglkeluar) {
                $('#modal-detail #new-out').val(formatDate(tglkeluar));
                tglKeluar.setDate(formatDate(tglkeluar));
            } else {
                $('#modal-detail #new-out').val(getFormattedDate());
                tglKeluar.setDate(getFormattedDate());
            }
            
            // Handle select2 untuk kode toko
            if(kodetoko) {
                var $storeSelect = $('#modal-detail #new-store');
                $storeSelect.empty();
                var newOption = new Option(kodetoko + " || " + homebase, kodetoko, true, true);
                $storeSelect.append(newOption).trigger('change');
            }
            
            // Handle select2 untuk perusahaan
            if(perusahaan) {
                var $officeSelect = $('#modal-detail #new-office');
                $officeSelect.empty();
                var newOption = new Option(md + ' - ' + brand + " - " + perusahaan, perusahaan, true, true);
                $officeSelect.append(newOption).trigger('change');
            }
            
            // Simpan ID employee di form untuk keperluan update
            $('#modal-detail #editFaktur').val(idEmployee);
        });

        function getHistoryData(noKtp) 
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'get',
                url: "{{ route('/master-employee.history', ['noKtp' => 'KTP_PLACEHOLDER']) }}"
                    .replace('KTP_PLACEHOLDER', noKtp),
                beforeSend: function() {
                    showModalLoading();
                },
                success: function(response) {
                    // Destroy DataTable jika sudah ada
                    if ($.fn.DataTable.isDataTable('#table_details_info')) {
                        $('#table_details_info').DataTable().destroy();
                    }
                    
                    // Inisialisasi DataTable baru
                    $('#table_details_info').DataTable({
                        order: [],
                        processing: true,
                        pageLength: 10,
                        data: response,
                        columns: [
                            {
                                data: 'supplier',
                                name: 'supplier',
                                className: 'text-left'
                            },
                            {
                                data: 'id_employee',
                                name: 'id_employee',
                                className: 'text-left'
                            },
                            {
                                data: 'kode_toko',
                                name: 'kode_toko',
                                className: 'text-center'
                            },
                            {
                                data: 'md_emp',
                                name: 'md_emp',
                                className: 'text-left',
                                render: function(data, type, row) {
                                    return row.md_emp + ' - ' + row.brand_emp + ' - ' + row.supplier;
                                }
                            },
                            {
                                data: 'tanggal_masuk',
                                name: 'tanggal_masuk',
                                className: 'text-center',
                                render: function(data) {
                                    if (!data) return '';
                                    let date = new Date(data);
                                    let day = String(date.getDate()).padStart(2, '0');
                                    let month = String(date.getMonth() + 1).padStart(2, '0');
                                    let year = date.getFullYear();
                                    return `${day}-${month}-${year}`;
                                }
                            },
                            {
                                data: 'tanggal_keluar',
                                name: 'tanggal_keluar',
                                className: 'text-center',
                                render: function(data) {
                                    if (!data) return '';
                                    let date = new Date(data);
                                    let day = String(date.getDate()).padStart(2, '0');
                                    let month = String(date.getMonth() + 1).padStart(2, '0');
                                    let year = date.getFullYear();
                                    return `${day}-${month}-${year}`;
                                }
                            }
                        ]
                    });
                },
                complete: function() {
                    hideModalLoading();
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal memuat data history',
                        icon: 'error'
                    });
                }
            });
        }

        $(document).on('click', 'a.edit', function() {
            // Ambil data dari atribut data
            let idEmployee = $(this).data('idemployee');
            let image = $(this).data('image');
            let nama = $(this).data('nama');
            let tgllahir = $(this).data('tgllahir');
            let alamat = $(this).data('alamat');
            let kodetoko = $(this).data('kodetoko');
            let perusahaan = $(this).data('perusahaan');
            let handphone = $(this).data('handphone');
            let tglmasuk = $(this).data('tglmasuk');
            let nokk = $(this).data('nokk');
            let noktp = $(this).data('noktp');
            let jeniskelamin = $(this).data('jeniskelamin');
            let status = $(this).data('status');
            let tglkeluar = $(this).data('tglkeluar');
            let note = $(this).data('note');
            let brand = $(this).data('brand');
            let homebase = $(this).data('homebase');
            let md = $(this).data('md');

            function formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            }

            // Buka modal edit
            $('#modal-edit').modal('show');
            
            // Set nilai form
            $('#modal-edit #idemployee').val(idEmployee);

            // Di bagian yang menampilkan gambar di modal edit, tambahkan cache busting
            $('#modal-edit #oldImagePreview').attr('src', image ? image + '?t=' + new Date().getTime() : '/images/no-image.png?t=' + new Date().getTime());

            $('#modal-edit #new-name').val(nama);
            $('#modal-edit #new-birthday').val(formatDate(tgllahir));
            $('#modal-edit #new-address').val(alamat);
            $('#modal-edit #new-phone').val(handphone);
            $('#modal-edit #new-join').val(formatDate(tglmasuk));
            $('#modal-edit #new-kk').val(nokk);
            $('#modal-edit #new-ktp').val(noktp);
            $('#modal-edit #new-out').val(formatDate(tglkeluar));
            $('#modal-edit #new-note').val(note);
            $('#modal-edit #new-gender').val(jeniskelamin).trigger('change');
            $('#modal-edit #new-status').val(status).trigger('change');

            var $storeSelect = $('#modal-edit #editStoreCode');
            $storeSelect.select2({
                placeholder: 'Select a store',
                ajax: {
                    url: "{{ route('/master-employee.get-toko') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term,
                            limit: 50
                        };
                    },
                    processResults: function(response) {
                        var options = [];
                        for(var i=0; i<response.length; i++) {
                            options.push({
                                id: response[i].homebase_terminal_id,
                                homebase_terminal_id: response[i].homebase_terminal_id,
                                homebase: response[i].homebase,
                                text: response[i].homebase_terminal_id + " || " + response[i].homebase
                            });
                        }
                        return {
                            results: options
                        };
                    },
                    cache: true
                }
            });

            // Set nilai awal untuk kode toko
            if(kodetoko) {
                var newOption = new Option(kodetoko + " || " + homebase, kodetoko, true, true);
                $storeSelect.append(newOption).trigger('change');
            }

            // Inisialisasi Select2 untuk perusahaan dengan data yang sesuai
            var $officeSelect = $('#modal-edit #editOffice');
            $officeSelect.select2({
                placeholder: 'Select a supplier',
                ajax: {
                    url: "{{ route('/master-employee.get-supplier') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term,
                            limit: 50
                        };
                    },
                    processResults: function(response) {
                        var options = [];
                        for(var i=0; i<response.length; i++) {
                            options.push({
                                id: response[i].md,
                                md: response[i].md,
                                detail_brand: response[i].detail_brand,
                                nama_supplier: response[i].nama_supplier,
                                text: response[i].md + " - " + response[i].detail_brand + ' - ' + response[i].nama_supplier
                            });
                        }
                        return {
                            results: options
                        };
                    },
                    cache: true
                }
            });

            // Set nilai awal untuk perusahaan
            if(perusahaan) {
                var newOption = new Option(md + ' - ' + brand + " - " + perusahaan, md, true, true);
                $officeSelect.append(newOption).trigger('change');
            }

            if (tglkeluar) {
                $('#modal-edit #new-out').val(formatDate(tglkeluar));
                tglKeluar.setDate(formatDate(tglkeluar));
            } else {
                $('#modal-edit #new-out').val(getFormattedDate());
                tglKeluar.setDate(getFormattedDate());
            }
            
            // Simpan ID employee di form untuk keperluan update
            $('#modal-edit #editFaktur').val(idEmployee);
        });

        $(document).on('click', 'a.terminate', function() {
            // Ambil data dari atribut data
            let idEmployee = $(this).data('idemployee');
            let nama = $(this).data('nama');
            let tgllahir = $(this).data('tgllahir');
            let alamat = $(this).data('alamat');
            let kodetoko = $(this).data('kodetoko');
            let homebase = $(this).data('homebase');
            let perusahaan = $(this).data('perusahaan');
            let md = $(this).data('md');
            let brand = $(this).data('brand');
            let handphone = $(this).data('handphone');
            let tglmasuk = $(this).data('tglmasuk');
            let nokk = $(this).data('nokk');
            let noktp = $(this).data('noktp');
            let jeniskelamin = $(this).data('jeniskelamin');
            let status = $(this).data('status');
            let tglkeluar = $(this).data('tglkeluar');
            let note = $(this).data('note');

            function formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date();
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            }

            // Buka modal terminate
            $('#modal-terminate').modal('show');
            
            // Set nilai form
            $('#modal-terminate #idemployee').val(idEmployee);
            $('#modal-terminate #new-name').val(nama);
            $('#modal-terminate #new-birthday').val(formatDate(tgllahir));
            $('#modal-terminate #new-address').val(alamat);
            $('#modal-terminate #new-phone').val(handphone);
            $('#modal-terminate #new-join').val(formatDate(tglmasuk));
            $('#modal-terminate #new-kk').val(nokk);
            $('#modal-terminate #new-ktp').val(noktp);
            $('#modal-terminate #new-out').val(formatDate(tglkeluar));
            $('#modal-terminate #new-note').val(note);
            $('#modal-terminate #new-gender').val(jeniskelamin).trigger('change');
            $('#modal-terminate #new-status').val(status).trigger('change');

            if (tglkeluar) {
                $('#modal-terminate #new-out').val(formatDate(tglkeluar));
                tglKeluar.setDate(formatDate(tglkeluar));
            } else {
                $('#modal-terminate #new-out').val(getFormattedDate());
                tglKeluar.setDate(getFormattedDate());
            }
            
            // Handle select2 untuk kode toko
            if(kodetoko) {
                var $storeSelect = $('#modal-terminate #new-store');
                $storeSelect.empty();
                var newOption = new Option(kodetoko + " || " + homebase, kodetoko, true, true);
                $storeSelect.append(newOption).trigger('change');
            }
            
            // Handle select2 untuk perusahaan
            if(perusahaan) {
                var $officeSelect = $('#modal-terminate #new-office');
                $officeSelect.empty();
                var newOption = new Option(md + ' - ' + brand + " - " + perusahaan, perusahaan, true, true);
                $officeSelect.append(newOption).trigger('change');
            }
            
            // Simpan ID employee di form untuk keperluan update
            $('#modal-terminate #editFaktur').val(idEmployee);
        });

        $(document).ready(function() {
            // Panggil getData() saat halaman pertama kali dimuat
            getDataEmp();
            
            // Kode validasi form yang sudah ada
            $('#form-add').on('submit', function(e) {
                e.preventDefault();
            });
        });

        function resetPage() {
            document.querySelector('#modal-upload form').reset();

            tglLahir.setDate(getFormattedDate(), true);
            tglMasuk.setDate(getFormattedDate(), true);
            $('#new-image').val(null);
            $('#new-name').val(null);
            $('#new-category').val(null).trigger('change');
            $('#new-address').val(null);
            $('#new-store').val(null).trigger('change');
            $('#new-phone').val(null);
            $('#new-kk').val(null);
            $('#new-ktp').val(null);
            $('#new-office').val(null).trigger('change');
            $('#new-gender').val(null).trigger('change');
            $('#new-status').val(null).trigger('change');
        }

        function addData() {
            // Ambil semua input
            const name = $('#new-name').val();
            const birthday = $('#new-birthday').val();
            const address = $('#new-address').val();
            const category = $('#new-category').val();
            const store = $('#new-store').val();
            const officeValue = $('#new-office').val();
            const officeText = $('#new-office').select2('data')[0]?.text || '';
            const noHandphone = $('#new-phone').val();
            const joinDate = $('#new-join').val();
            const kk = $('#new-kk').val();
            const ktp = $('#new-ktp').val();
            const gender = $('#new-gender').val();
            const status = $('#new-status').val();
            const imageFile = $('#new-image')[0].files[0];

            if (!name || !birthday || !address || !category || !store || !officeValue || !noHandphone || !joinDate || !kk || !ktp || !gender || !status) {
                Swal.fire({
                    title: 'Error',
                    text: 'Semua field wajib diisi.',
                    icon: 'warning'
                });
                return;
            }

            let formData = new FormData();
            formData.append('name', name);
            formData.append('birthday', birthday);
            formData.append('address', address);
            formData.append('category', category);
            formData.append('store', store);
            formData.append('noHandphone', noHandphone);
            formData.append('joinDate', joinDate);
            formData.append('kk', kk);
            formData.append('ktp', ktp);
            formData.append('gender', gender);
            formData.append('status', status);
            formData.append('image', imageFile);

            if (category === 'PKL') {
                formData.append('md', '021');
                formData.append('detail_brand', 'RAMAYANA');
                formData.append('nama_supplier', 'RAMAYANA LESTARI SENTOSA PT');
            } else {
                const office = $('#newOffice').select2('data')[0];
                formData.append('md', office.md);
                formData.append('detail_brand', office.detail_brand);
                formData.append('nama_supplier', office.nama_supplier);
            }

            // AJAX call
            $.ajax({
                url: "{{ route('/master-employee.add-employee') }}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: "post",
                data: formData,
                processData: false,  
                contentType: false,  
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Data berhasil ditambahkan',
                            icon: 'success'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'Gagal menambahkan data',
                            icon: 'error'
                        });
                    }
                },
                beforeSend: function() {
                    showModalLoading();
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errorMessages = [];
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            errorMessages.push(messages.join(', '));
                        });

                        Swal.fire({
                            title: 'Error',
                            html: errorMessages.join('<br>'),
                            icon: 'error'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server',
                            icon: 'error'
                        });
                    }
                },
                complete: function() {
                    hideModalLoading();
                }
            });
        }

        // validasi form input
        $(document).ready(function () {
            $('#form-add').on('submit', function (e) {
                e.preventDefault();

                let isValid = true;

                $('#form-add input, select').removeClass('is-invalid');

                $('#form-add input, select').each(function () {
                    if ($.trim($(this).val()) === '') {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    }
                });

                if (isValid) {
                    this.submit(); 
                } 
            });

            $('#storeCode').select2({
                placeholder: 'Select an store code',
                ajax: {
                    url: "{{ route('/master-employee.get-toko') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (data) {
                    return {
                        searchTerm: data.term,
                        limit: 50
                    };
                    },
                    processResults: function (response) {
                    var lov = [];

                    for(var i=0; i<response.length; i++) {
                        var data_lov = {};
                        data_lov.id = response[i].homebase_terminal_id;
                        data_lov.text = response[i].homebase_terminal_id + " || " + response[i].homebase;

                        lov.push(data_lov);
                    }
                    
                    return {
                        results: lov
                    };
                    },
                    cache: true
                }
            });

            $('#new-store').select2({
                placeholder: 'Select an item',
                ajax: {
                    url: "{{ route('/master-employee.get-toko') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params){
                        return {
                            searchTerm: params.term,
                            limit: 50
                        };
                    },
                    processResults: function(response){
                        let lov = [];
                        let data_lov = {};
                        data_lov.id = '0';
                        data_lov.text = 'Select an Item';
                        lov.push(data_lov);

                        for(let i=0; i<response.length; i++){
                            data_lov = {};
                            data_lov.id = response[i].homebase_terminal_id,
                            data_lov.text = response[i].homebase_terminal_id + " || " + response[i].homebase;

                            lov.push(data_lov);
                        }

                        return {
                            results: lov
                        };
                    },
                    cache: true
                }
            });

            $('#new-office').select2({
                placeholder: 'Select at item',
                dropdownParent: $('#modal-add'),
                ajax: {
                    url: "{{ route('/master-employee.get-supplier') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params){
                        return{
                            searchTerm: params.term,
                            limit: 50
                        };
                    },
                    processResults: function(response){
                        let lov = [];
                        let data_lov = {};
                        data_lov.id = '0';
                        data_lov.text = 'Select at item';
                        lov.push(data_lov);

                        for(let i=0; i<response.length; i++){
                            data_lov = {};
                            data_lov.id = response[i].md;
                            data_lov.md = response[i].md;
                            data_lov.detail_brand = response[i].detail_brand;
                            data_lov.nama_supplier = response[i].nama_supplier;
                            data_lov.text = response[i].md + " - " + response[i].detail_brand + " - " + response[i].nama_supplier;

                            lov.push(data_lov);
                        }

                        return{
                            results: lov
                        };
                    },
                    cache: true
                }
            });
        });

        function uploadData() {
            let formData = new FormData($('form#form_upload')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                processData: false,
                contentType: false,
                cache: false,
                url: "{{ route('/master-employee.upload') }}",
                data: formData,
                success: function(data) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Data Berhasil Disimpan',
                        icon: 'success'
                    }).then(() => location.reload());
                },
                beforeSend: function() {
                    showModalLoading();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Failed!',
                        text: 'Gagal Memproses Data',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                },
                complete: function() {
                    hideModalLoading();
                }
            });
        }

        function editData() {
            const name = $('#modal-edit #new-name').val();
            const birthday = $('#modal-edit #new-birthday').val();
            const address = $('#modal-edit #new-address').val();
            const store = $('#modal-edit #editStoreCode').val();
            const officeValue = $('#modal-edit #editOffice').val();
            const officeText = $('#modal-edit #editOffice').select2('data')[0]?.text || '';
            const noHandphone = $('#modal-edit #new-phone').val();
            const joinDate = $('#modal-edit #new-join').val();
            const kk = $('#modal-edit #new-kk').val();
            const ktp = $('#modal-edit #new-ktp').val();
            const gender = $('#modal-edit #new-gender').val();
            const status = $('#modal-edit #new-status').val();
            const idEmployee = $('#modal-edit #idemployee').val();
            const imageFile = $('#modal-edit #new-image')[0].files[0];

            if (!name || !birthday || !address || !store || !officeValue || !noHandphone || !joinDate || 
                !kk || !ktp || !gender || !status || !idEmployee) {
                Swal.fire({
                    title: 'Error',
                    text: 'Semua field wajib diisi.',
                    icon: 'warning'
                });
                return;
            }

            let formData = new FormData();
            formData.append('id_employee', idEmployee);
            if (imageFile) {
                formData.append('image', imageFile);
            }
            formData.append('nama', name);
            formData.append('tanggal_lahir', birthday);
            formData.append('alamat', address);

            const stores = $('#modal-edit #editStoreCode').select2('data')[0];
            if (stores) {
                let parts = stores.text.split(" || ");
                formData.append('homebase', parts[0] || '');
                formData.append('homebase_terminal_id', parts[1] || '');
            }

            formData.append('no_handphone', noHandphone);
            formData.append('tanggal_masuk', joinDate);
            formData.append('no_kk', kk);
            formData.append('no_ktp', ktp);
            formData.append('jenis_kelamin', gender);
            formData.append('status', status);

            const office = $('#modal-edit #editOffice').select2('data')[0];
            if (office) {
                let parts = office.text.split(" - ");
                formData.append('md', parts[0] || '');
                formData.append('detail_brand', parts[1] || '');
                formData.append('nama_supplier', parts[2] || '');
            }

            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('/master-employee.edit') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Data berhasil diperbarui',
                            icon: 'success'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'Gagal memperbarui data',
                            icon: 'error'
                        });
                    }
                },
                beforeSend: function() {
                    showModalLoading();
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                        icon: 'error'
                    });
                },
                complete: function() {
                    hideModalLoading();
                }
            });
        }

        function terminateData() {
            let tglkeluar = $('#modal-terminate #new-out').val();
            let note = $('#modal-terminate #new-note').val();
            let idemployee = $('#modal-terminate #idemployee').val();

            $.ajax({
                url: "{{ route('/master-employee.terminate') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggal_keluar: tglkeluar,
                    note: note,
                    id_employee: idemployee
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message || 'Data berhasil diterminate',
                            icon: 'success'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            title: 'Failed',
                            text: response.message || "Terjadi kesalahan saat menyimpan data",
                            icon: 'error'
                        });
                    }
                },
                beforeSend: function() {
                    showModalLoading();
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal menyimpan data. Silahkan coba lagi.',
                        icon: 'error'
                    });
                },
                complete: function() {
                    hideModalLoading();
                }
            });
        }

        function get_search_data() 
        {
            var params = {};
            var kode_toko = $('#storeCode').val();
            var kategori = $('#categoryEmployee').val();

            if (kode_toko) {
                params.kode_toko = kode_toko;
            }
            
            if (kategori) {
                params.kategori_karyawan = kategori;
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'get',
                url: "{{ route('/master-employee.search') }}",
                data: params,
                beforeSend: function() {
                    showModalLoading();
                },
                success: function(data) {
                    if ($.fn.DataTable.isDataTable('#list_table')) {
                        $('#list_table').DataTable().destroy();
                    }
                    
                    // Inisialisasi DataTable baru
                    $('#list_table').DataTable({
                        order: [],
                        destroy: true,
                        processing: true,
                        pageLength: 10,
                        data: data,
                        columns: [
                            {
                                data: 'id_employee',
                                name: 'a.id_employee',
                                className: 'text-left'
                            },
                            {
                                data: 'nama',
                                name: 'a.nama',
                                className: 'text-left'
                            },
                            {
                                data: 'tanggal_masuk',
                                name: 'a.tanggal_masuk',
                                className: 'text-center',
                                render: function(data) {
                                    if (!data) return '';
                                    let today = new Date(data);
                                    let day = String(today.getDate()).padStart(2, '0');
                                    let month = String(today.getMonth() + 1).padStart(2, '0');
                                    let year = today.getFullYear();
                                    return `${day}-${month}-${year}`;
                                }
                            },
                            {
                                data: 'kode_toko',
                                name: 'a.kode_toko',
                                className: 'text-center'
                            },
                            {
                                data: 'supplier',
                                name: 'a.supplier',
                                className: 'text-left',
                                render: function(data, type, row) {
                                    return row.md_emp + ' - ' + row.brand_emp + ' - ' + row.supplier;
                                }
                            },
                            {
                                data: 'kode_toko',
                                name: 'a.kode_toko',
                                className: 'text-center',
                                width: '200px',
                                render: function(data, type, row) {
                                    let md = row.md !== null ? row.md : row.md_emp;
                                    let brand = row.brand !== null ? row.brand : row.brand_emp;
                                    let supplier = row.detail_brand !== null ? row.detail_brand : row.supplier;
                                    let store = row.store !== null ? row.store : row.kode_toko;
                                    let storeName = row.store_name !== null ? row.store_name : row.homebase;
                                    let tglMasuk = row.join_date !== null ? row.join_date : row.tanggal_masuk;
                                    let tglKeluar = row.out_date !== null ? row.out_date : row.tanggal_keluar;
                                    let kk = row.kk !== null ? row.kk : row.no_kk;
                                    let ktp = row.ktp !== null ? row.ktp : row.no_ktp;
                                    return `
                                        <center>
                                            <div class="d-grid gap-2 d-md-flex justify-content-center">
                                                @if ($access_create)
                                                <span data-toggle="tooltip" title="Edit Data" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary mr-2 edit" 
                                                    data-target="#modal-edit" data-toggle="modal"
                                                    data-idemployee="${row.id_employee}"
                                                    data-nama="${row.nama}"
                                                    data-tgllahir="${row.tanggal_lahir}"
                                                    data-alamat="${row.alamat}"
                                                    data-kodetoko="${store}"
                                                    data-homebase="${storeName}"
                                                    data-perusahaan="${supplier}"
                                                    data-brand="${brand}"
                                                    data-md="${md}"
                                                    data-handphone="${row.no_handphone}"
                                                    data-tglmasuk="${tglMasuk}"
                                                    data-nokk="${kk}"
                                                    data-noktp="${ktp}"
                                                    data-jeniskelamin="${row.jenis_kelamin}"
                                                    data-status="${row.status}"
                                                    data-note="${row.keterangan}">
                                                    <i class="fas fa-edit"></i>&nbsp Edit
                                                    </a>
                                                </span>

                                                <span title="Detail Data" data-toggle="tooltip" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-info mr-2 detail" data-target="#modal-detail" data-toggle="modal"
                                                    data-idemployee="${row.id_employee}"
                                                    data-nama="${row.nama}"
                                                    data-tgllahir="${row.tanggal_lahir}"
                                                    data-alamat="${row.alamat}"
                                                    data-kodetoko="${store}"
                                                    data-homebase="${storeName}"
                                                    data-perusahaan="${supplier}"
                                                    data-brand="${brand}"
                                                    data-md="${md}"
                                                    data-handphone="${row.no_handphone}"
                                                    data-tglmasuk="${tglMasuk}"
                                                    data-nokk="${kk}"
                                                    data-noktp="${ktp}"
                                                    data-jeniskelamin="${row.jenis_kelamin}"
                                                    data-status="${row.status}"
                                                    data-note="${row.keterangan}">
                                                        <i class="fas fa-eye"></i>&nbsp View
                                                    </a>
                                                </span>

                                                <span data-toggle="tooltip" title="Delete Data" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger mr-2 terminate" 
                                                    data-target="#modal-terminate" data-toggle="modal"
                                                    data-idemployee="${row.id_employee}"
                                                    data-nama="${row.nama}"
                                                    data-tgllahir="${row.tanggal_lahir}"
                                                    data-alamat="${row.alamat}"
                                                    data-kodetoko="${store}"
                                                    data-homebase="${storeName}"
                                                    data-perusahaan="${supplier}"
                                                    data-brand="${brand}"
                                                    data-md="${md}"
                                                    data-handphone="${row.no_handphone}"
                                                    data-tglmasuk="${tglMasuk}"
                                                    data-nokk="${kk}"
                                                    data-noktp="${ktp}"
                                                    data-jeniskelamin="${row.jenis_kelamin}"
                                                    data-status="${row.status}"
                                                    data-tglkeluar="${tglKeluar}"
                                                    data-note="${row.keterangan}">
                                                    <i class="fas fa-trash"></i>&nbsp Delete
                                                    </a>
                                                </span>
                                                @else
                                                <span title="Detail Data" data-toggle="tooltip" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-info mr-2 detail" data-target="#modal-detail" data-toggle="modal"
                                                    data-idemployee="${row.id_employee}"
                                                    data-nama="${row.nama}"
                                                    data-tgllahir="${row.tanggal_lahir}"
                                                    data-alamat="${row.alamat}"
                                                    data-kodetoko="${store}"
                                                    data-homebase="${storeName}"
                                                    data-perusahaan="${supplier}"
                                                    data-brand="${brand}"
                                                    data-md="${md}"
                                                    data-handphone="${row.no_handphone}"
                                                    data-tglmasuk="${tglMasuk}"
                                                    data-nokk="${kk}"
                                                    data-noktp="${ktp}"
                                                    data-jeniskelamin="${row.jenis_kelamin}"
                                                    data-status="${row.status}"
                                                    data-note="${row.keterangan}">
                                                        <i class="fas fa-eye"></i>&nbsp View
                                                    </a>
                                                </span>
                                                @endif
                                            </div>
                                        </center>
                                    `;
                                }
                            }
                        ]
                    });

                    $('#div_table').show();
                },
                complete: function() {
                    hideModalLoading();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Failed!',
                        text: xhr.responseJSON?.message || 'Gagal memuat data',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
        
    </script>
@stop