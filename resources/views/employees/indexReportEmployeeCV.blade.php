@extends('layouts.master')

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
                        <button class="btn btn-danger btn-m" onclick="downloadPDF()"><i class="fas fa-file-pdf"></i>&nbsp; Export PDF</button>
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
      function downloadPDF() 
      {
        var params = {}
        var id_employee = $('#idEmployee').val();

        params.id_employee = id_employee;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: "{{ route('/report-employee.pdf-cv') }}",
            data: params,
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: function() {
                showModalLoading();
            },
            success: function(data) {
                var currentDate = new Date();
                let day = String(currentDate.getDate()).padStart(2, '0');
                let month = String(currentDate.getMonth() + 1).padStart(2, '0');
                let year = currentDate.getFullYear();
                let date = `${day}${month}${year}`;
                var filename = 'Report_CV_' + date + '.pdf';
                
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
    </script>
@stop