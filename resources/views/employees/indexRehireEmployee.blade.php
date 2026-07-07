@extends('adminlte::page')

@section('title', 'Rehire Employee')
@extends('icon')

@section('content_header')
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card card-red card-tabs">
          <div class="card-header p-0 pt-2 pb-2">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
              <li class="pt-2 px-3"></li>
            </ul>
          </div>

          <div class="card-body">
            <div class="row" id="">
              <div class="col-md-12">
                <div style="overflow-x: auto;">
                  <div>
                    <div class="modal-header">
                      <h3 class="modal-title" id="modal-title">Rehire Employee</h3>
                    </div>
                    <form action="" id="modalForm" class="form-horizontal" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                      <div class="card-body">
                        <input type="hidden" id="editFaktur" name="editFaktur">
                        <input type="hidden" id="newKategori" name="newKategori">

                        <div class="form-group">
                          <label for="" class="required" data-required="true">Masukan Nomor KTP</label>
                          <input type="text" id="searchKTP" name="searchKTP" class="form-control" maxlength="18">
                        </div>

                        <div class="row">
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Nama</label>
                            <input type="text" class="form-control form-control-sm" id="newName" name="newName">
                          </div>

                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Tanggal Lahir</label>
                            <div class="input-group input-group-sm date">
                              <input type="text" class="form-control flatpickr-input" id="newBirthday" name="newBirthday">
                              <div class="input-group-prepend">
                                <div class="input-group-text" id="birthDay">
                                  <i class="fa fa-calendar"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="required" data-required="true">Kategori</label>
                          <select name="newCategory" id="newCategory" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off">
                            <option value="">Select at item</option>
                            <option value="PKL">PKL</option>
                            <option value="SPG">SPG</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="" class="required" data-required="true">Alamat</label>
                          <textarea name="newAddress" id="newAddress" class="form-control form-control-sm"></textarea>
                        </div>

                        <div class="row">
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">No KK</label>
                            <input type="text" class="form-control" id="newKK" name="newKK" maxlength="18">
                          </div>
  
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">No KTP</label>
                            <input type="text" class="form-control" id="newKTP" name="newKTP" maxlength="18">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Jenis Kelamin</label>
                            <select name="newGender" id="newGender" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off">
                              <option value="">Select at item</option>
                              <option value="L">Laki-laki</option>
                              <option value="P">Perempuan</option>
                            </select>
                          </div>
  
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Status</label>
                            <select name="newStatus" id="newStatus" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off">
                              <option value="">Select at item</option>
                              <option value="1">Belum Menikah</option>
                              <option value="2">Menikah</option>
                              <option value="3">Duda</option>
                              <option value="4">Janda</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="required" data-required="true">Catatan Kerja Karyawan</label>
                          <textarea name="workNotes" id="workNotes" class="form-control form-control-sm"></textarea>
                        </div>

                        <div class="row">
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Kode Toko</label>
                            <select name="newStoreCode" id="newStoreCode" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off"></select>
                          </div>
  
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Perusahaan</label>
                            <select name="newOffice" id="newOffice" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off"></select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">No Handphone</label>
                            <input type="text" class="form-control form-control-sm" id="newHandphone" name="newHandphone" maxlength="16">
                          </div>
  
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Tanggal Masuk</label>
                            <div class="input-group input-group-sm date">
                              <input type="text" class="form-control flatpickr-input" id="newJoindate" name="newJoindate">
                              <div class="input-group-prepend">
                                <div class="input-group-text" id="joinDate">
                                  <i class="fa fa-calendar"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn-sm btn-primary" onclick="" id="submitadd">
                        <i class="fas fa-save"></i>&nbsp; Simpan
                      </button>
                    </div>
                    </form>
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
  <style>
    .nav-tabs {
      border-bottom: none !important;
    }
  </style>
@stop

@section('js')

@stop