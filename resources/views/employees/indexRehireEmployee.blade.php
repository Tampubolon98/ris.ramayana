@extends('layouts.master')

@section('title', 'Rehire Employee')

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
                            <input type="text" class="form-control form-control-sm" id="new-name" name="new-name">
                          </div>

                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Tanggal Lahir</label>
                            <div class="input-group input-group-sm date">
                              <input type="text" class="form-control flatpickr-input" id="new-birthday" name="new-birthday">
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
                          <select name="new-category" id="new-category" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off">
                            <option value="">Select at item</option>
                            <option value="PKL">PKL</option>
                            <option value="SPG">SPG</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="" class="required" data-required="true">Alamat</label>
                          <textarea name="new-address" id="new-address" class="form-control form-control-sm"></textarea>
                        </div>

                        <div class="row">
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">No KK</label>
                            <input type="text" class="form-control" id="new-kk" name="new-kk" maxlength="16">
                          </div>
  
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">No KTP</label>
                            <input type="text" class="form-control" id="new-ktp" name="new-ktp" maxlength="16">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Jenis Kelamin</label>
                            <select name="new-gender" id="new-gender" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off">
                              <option value="">Select at item</option>
                              <option value="L">Laki-laki</option>
                              <option value="P">Perempuan</option>
                            </select>
                          </div>
  
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Status</label>
                            <select name="new-status" id="new-status" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off">
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
                          <textarea name="work-notes" id="work-notes" class="form-control form-control-sm"></textarea>
                        </div>

                        <div class="row">
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Kode Toko</label>
                            <select name="new-store" id="new-store" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off"></select>
                          </div>
  
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Perusahaan</label>
                            <select name="new-office" id="new-office" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off"></select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">No Handphone</label>
                            <input type="text" class="form-control form-control-sm" id="new-phone" name="new-phone" maxlength="12">
                          </div>
  
                          <div class="col-sm-6 form-group">
                            <label for="" class="required" data-required="true">Tanggal Masuk</label>
                            <div class="input-group input-group-sm date">
                              <input type="text" class="form-control flatpickr-input" id="new-join" name="new-join">
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
                      <button type="button" class="btn-sm btn-primary" onclick="addData()" id="submitadd">
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

@section('js')
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

    document.getElementById('birthDay').addEventListener('click', function() {
        tglLahir.open();
    });

    let tglMasuk = flatpickr("#new-join", {
        dateFormat: 'd-m-Y',
        allowInput: true,
        defaultDate: getFormattedDate()
    });

    document.getElementById('joinDate').addEventListener('click', function() {
        tglMasuk.open();
    });

    $(document).ready(function () {
      $('#new-office').select2({
        placeholder: 'Select an item',
        ajax: {
            url: "{{ route('/master-employee.get-supplier') }}",
            dataType: 'json',
            delay: 250,
            data: function (data) {
            return {
                searchTerm: data.term
            };
            },
            processResults: function (response) {
            var lov = [];
            var data_lov = {};
            data_lov.id = '0';
            data_lov.text = 'Select an Item';
            lov.push(data_lov);

            for(var i=0; i<response.length; i++) {
                data_lov = {};
                data_lov.id = response[i].md;
                data_lov.md = response[i].md;
                data_lov.detail_brand = response[i].detail_brand;
                data_lov.nama_supplier = response[i].nama_supplier;
                data_lov.text = response[i].md + " - " + response[i].detail_brand + " - " + response[i].nama_supplier;

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
            data: function (data) {
            return {
                searchTerm: data.term
            };
            },
            processResults: function (response) {
            var lov = [];
            var data_lov = {};
            data_lov.id = '0';
            data_lov.text = 'Select an Item';
            lov.push(data_lov);

            for(var i=0; i<response.length; i++) {
                data_lov = {};
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

      function getEmployeeData() {
        let noktp = $('#searchKTP').val();
        
        if (!noktp) {
            return;
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: "{{ route('rehire-employee.get') }}",
            data: {
                'no_ktp': noktp
            },
            success: function(data) {
                if (data.length > 0) {
                    let today = new Date(data[0].tanggal_lahir);
                    let day = String(today.getDate()).padStart(2, '0');
                    let month = String(today.getMonth() + 1).padStart(2, '0');
                    let year = today.getFullYear();
                    let tglLahir = `${day}-${month}-${year}`;

                    $('#new-name').val(data[0].nama);
                    $('#new-birthday').val(tglLahir);
                    $('#new-category').val(data[0].kategori_karyawan).trigger('change');
                    $('#new-address').val(data[0].alamat);
                    $('#new-kk').val(data[0].no_kk);
                    $('#new-ktp').val(data[0].no_ktp);
                    $('#new-gender').val(data[0].jenis_kelamin).trigger('change');
                    $('#new-status').val(data[0].status).trigger('change');
                    $('#work-notes').val(data[0].keterangan);
                } else {
                    Swal.fire({
                        title: 'Info',
                        text: 'Data karyawan tidak ditemukan',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: xhr.responseJSON.message || 'Terjadi kesalahan saat mengambil data',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
      }

      $('#searchKTP').on('input', function() {
          if ($(this).val().length === 16) {
              getEmployeeData();
          }
      });
    });

    function addData() 
    {
      // Ambil semua input
      const name = $('#new-name').val();
      const birthday = $('#new-birthday').val();
      const address = $('#new-address').val();
      const category = $('#new-category').val();
      const store = $('#new-store').val();
      const office = $('#new-office').select2('data')[0];
      const noHandphone = $('#new-phone').val();
      const joinDate = $('#new-join').val();
      const kk = $('#new-kk').val();
      const ktp = $('#new-ktp').val();
      const gender = $('#new-gender').val();
      const status = $('#new-status').val();

      // Jika valid, lanjut buat FormData
      let formData = new FormData();
      formData.append('name', name);
      formData.append('birthday', birthday);
      formData.append('address', address);
      formData.append('category', category);
      formData.append('store', store);
      formData.append('md', office.md);
      formData.append('detail_brand', office.detail_brand);
      formData.append('nama_supplier', office.nama_supplier);
      formData.append('noHandphone', noHandphone);
      formData.append('joinDate', joinDate);
      formData.append('kk', kk);
      formData.append('ktp', ktp);
      formData.append('gender', gender);
      formData.append('status', status);

      $.ajax({
          url: "{{ route('rehire-employee.tambah') }}",
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          type: "post",
          data: formData,
          processData: false,  
          contentType: false,  
          success: function(response) {
              if(response.success) {
                  Swal.fire({
                      title: 'Success',
                      text: 'Data berhasil disimpan',
                      icon: 'success'
                  }).then(() => location.reload());
              } else {
                  Swal.fire({
                      title: 'Error',
                      text: 'Gagal menyimpan data',
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
                  text: xhr.responseJSON.message || 'Terjadi kesalahan',
                  icon: 'error'
              });
          },
          complete: function() {
              hideModalLoading();
          }
      });
    } 
  </script>
@stop