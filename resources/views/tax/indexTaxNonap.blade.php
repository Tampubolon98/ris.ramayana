@extends('layouts.master')

@section('title', 'Tax')

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
                                        <button type="button" class="btn btn-sm btn-success" onclick="openModal('add')"><i class="fa fa-plus"></i>&nbsp; Input Data</button>
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

    {{-- Modal Add --}}
    <div class="modal fade" id="modal-add" data-mode="add" data-backdrop="static">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Tambah Data Tax Non A/P</h3>
          </div>

          <form action="" id="modal-form" method="post" enctype="multipart/form-data" class="form-horizontal">
            @csrf
            <div class="modal-body">
              <div class="card-body">
                <input type="hidden" id="edit-faktur" name="edit-faktur">

                <div class="form-group">
                  <label for="" class="required" data-required="true">Supplier</label>
                  <select name="new-supplier" id="new-supplier" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off"></select>
                </div>

                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">Masa Pajak</label>
                    <div class="input-group input-group-sm date">
                      <input type="text" class="form-control flatpickr-input" id="new-masa" name="new-masa">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="pajakdate"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">NPWP</label>
                    <input type="text" class="form-control form-control-sm" id="new-npwp" name="new-npwp" maxlength="16">
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">Tanggal Penerimaan</label>
                    <div class="input-group input-group-sm date">
                      <input type="text" class="form-control flatpickr-input" id="new-penerimaan" name="new-penerimaan">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="datepenerimaan"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">Faktur</label>
                    <input type="text" class="form-control form-control-sm" id="new-faktur" name="new-faktur" maxlength="14">
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">Tax Date</label>
                    <div class="input-group input-group-sm date">
                      <input type="text" class="form-control flatpickr-input" id="new-taxdate" name="new-taxdate">
                      <div class="input-group-prepend">
                        <div class="input-group-text" id="taxdate"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">Tax Series</label>
                    <input type="text" class="form-control" id="new-taxseries" name="new-taxseries" maxlength="20" oninput="">
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">DPP</label>
                    <input type="text" class="form-control" id="new-dpp" name="new-dpp" maxlength="18">
                  </div>

                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">DPP Nilai Lain</label>
                    <input type="text" class="form-control" id="new-dppcomputed" name="new-dppcomputed" maxlength="18">
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">PPN</label>
                    <input type="text" class="form-control" id="new-ppn" name="new-ppn" maxlength="18">
                  </div>

                  <div class="col-sm-6 form-group">
                    <label for="" data-required="true" class="required">Release</label>
                    <input type="checkbox" class="form-control form-control-sm col-sm-1" id="new-release" name="new-release">
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" class="btn btn-secondary" data-dismiss="modal" onclick=""><i class="fa fa-times"></i>&nbsp; Batal</button>
              <button type="button" class="btn btn-primary" onclick="" id="save-button"><i class="fas fa-save"></i>&nbsp; Simpan</button>
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
    <script>
      function openModal(mode, row=null){
        if (mode == 'add'){
          $('#modal-add').attr('data-mode', 'add');
          $('#modal-title').text('Tambah Data Tax Non A/P');
          $('.form-group').show();
        }

        if (mode == 'edit' && row){
          $('#modal-add').attr('data-mode', 'edit');
          $('#modal-title').text('Edit Data Tax Non A/P')
          $('#modal-add').find('.required').removeClass('required');
          $('#new-supplier').closest('.form-group').hide()
          $('#new-masa').closest('.form-group').hide()
          $('#new-npwp').closest('.form-group').hide()
        }
        $('#modal-add').modal('show')
      }
    </script>
@stop