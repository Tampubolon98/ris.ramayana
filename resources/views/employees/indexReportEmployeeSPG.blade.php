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
                        <button class="btn btn-danger btn-m" onclick="downloadPDF()"><i class="fas fa-file-pdf"></i>&nbsp; Export PDF</button>
                        <button class="btn btn-success btn-m" onclick="downloadXLS()"><i class="fas fa-file-excel"></i>&nbsp; Export Excel</button>
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
      $(document).ready(function() {
        $('#storeCode').select2({
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
              data_lov.id = 'ALL';
              data_lov.text = '--ALL TOKO--';
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
      })

      function downloadPDF() 
      {
        var params = {}
        var kode_toko = $('#storeCode').val();
        var kategori = $('#categoryEmployee').val();

        params.kode_toko = kode_toko;
        params.kategori_karyawan = kategori;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: "{{ route('/report-employee.pdf') }}",
            data: params,
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: function() {
                showModalLoading();
            },
            success: function(data) {
                var currentDate = new Date();
                var filename = 'Report_Employee_SPG_' + currentDate.getTime() + '.pdf';
                
                var blobUrl = URL.createObjectURL(data);
                
                var link = document.createElement('a');
                link.href = blobUrl;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            complete: function() {
                hideModalLoading();
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Failed!',
                    text: xhr.responseJSON.message || 'Gagal memuat data',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
      }

      function downloadXLS() 
      {
        var params = {}
        var kode_toko = $('#storeCode').val();
        var kategori = $('#categoryEmployee').val();

        params.kode_toko = kode_toko;
        params.kategori_karyawan = kategori;

        $.ajax({
            method: 'get',
            url: "{{ route('/report-employee.xls') }}",
            data: params,
            xhr: function() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                if (xhr.readyState == 2) {
                    if (xhr.status == 200) {
                    xhr.responseType = "blob";
                    } else {
                    xhr.responseType = "text";
                    }
                }
                };
                return xhr;
            },
            beforeSend: function() {
                showModalLoading();
            },
            success: function(res) {
                var blob = new Blob([res]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);

                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                const day = String(currentDate.getDate()).padStart(2, '0');
                let now = year + '' + month + '' + day;

                link.download = `Report_Karyawan_SPG - ${now}.xlsx`;
                link.click();
            },
            complete: function() {
                hideModalLoading();
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Failed!',
                    text: xhr.responseJSON.message || 'Gagal memuat data',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
      }
    </script>
@stop