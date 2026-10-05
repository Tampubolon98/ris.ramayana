@extends('layouts.master')

@section('title', 'Tax')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-red card-tabs">
                    <div class="card-header p-0 pt-2 pb-2">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="card-title" style="color: white">&nbsp; Input Pajak Keluaran</li>
                        </ul>
                    </div>

                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="required">Operating Unit</label>
                            <select name="operating_unit_list" id="operating_unit_list" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off">
                              <option value="">Select at item</option>
                              <option value="95">Fashion</option>
                              <option value="116">Supermarket</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="required">Store</label>
                            <input type="text" class="form-control form-control-sm" id="outlet_code" name="outlet_code" maxlength="4" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="" class="required">Invoice Date</label>
                            <div class="d-flex gap-2">
                              <div class="input-group date p-1">
                                <input type="text" class="form-control form-control-sm flatpickr-input" id="start_date" name="start_date">
                                <div class="input-group-append">
                                  <div class="input-group-text" id="startDate"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                              <span class="m-1">To</span>
                              <div class="input-group date p-1">
                                <input type="text" class="form-control form-control-sm flatpickr-input" id="end_date" name="end_date">
                                <div class="input-group-append">
                                  <div class="input-group-text" id="endDate"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="d-flex gap-2 required">Invoice No</label>
                            <input type="text" class="form-control form-control-sm" id="invoice_no" name="invoice_no" maxlength="20" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="d-flex gap-2 required">Supplier - <small id="supplier_name_label" class="form-text m-1"></small></label>
                            <input type="text" class="form-control form-control-sm" id="customer_id" name="customer_id" maxlength="10" autocomplete="off">
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="" class="required">Transaction Code</label>
                            <input type="text" class="form-control form-control-sm" id="tr_code" name="tr_code" maxlength="4" autocomplete="off">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          <div class="form-group">
                            <button class="btn btn-secondary btn-sm" onclick="save_data()"><i class="fa fa-sync mr-2"></i>Generate</button>
                          </div>
                        </div>
                      </div>

                        <div class="row" id="div_table">
                            <div class="col-md-12">
                                <div style="overflow-x: auto;">
                                    <table class="table table-sm table-condensed table-bordered" style="font-size: 90%" id="list_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Invoice Date</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Invoice No</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Contract No</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Customer Code</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Name</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">NPWP</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">Tax Series No</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">DPP</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">DPP Nilai Lain</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">PPN</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">Process Tax</th>
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

@section('js')
    <script>
      function getFormattedDate() {
        let today = new Date();
        let day = String(today.getDate()).padStart(2, '0');
        let month = String(today.getMonth() + 1).padStart(2, '0'); 
        let year = today.getFullYear();
        return `${day}-${month}-${year}`;
      }

      var startDatePicker = flatpickr("#start_date", {
        dateFormat: "d-m-Y", 
        allowInput: true, 
        clickOpens: true,
        defaultDate: getFormattedDate()
      });

      var endDatePicker = flatpickr("#end_date", {
        dateFormat: "d-m-Y",
        allowInput: true, 
        clickOpens: true,
        defaultDate: getFormattedDate()
      });

      document.getElementById("startDate").addEventListener("click", function () {
        startDatePicker.open();
      });

      document.getElementById("endDate").addEventListener("click", function () {
        endDatePicker.open();
      });

      document.querySelectorAll("#outlet_code, #tr_code").forEach(function(input) {
        input.addEventListener("input", function() {
          this.value = this.value.toUpperCase();
        });
      });

      $('#customer_id').on('keyup', function () {
        let customerId = $(this).val().trim();

        if (customerId.length > 0) {
          $.ajax({
            url: "{{ route('get.tax_out') }}",
            type: "GET",
            data: { customer_id: customerId },
            dataType: 'json',
            success: function (response) {
                $('#supplier_name_label').text(response.supplier_name).css('color', 'black');
            },
            error: function (xhr) {
                $('#supplier_name_label').text('Supplier tidak ditemukan').css('color', 'red');
            }
          });
        } else {
          $('#supplier_name_label').text('');
        }
      });

      function formatDate(dateStr) {
        let parts = dateStr.split('-'); 
        return `${parts[2]}-${parts[1]}-${parts[0]}`; 
      } 

      function alertMessage(icon, title, text)
      {
        Swal.fire({
          icon: icon,
          title: title,
          title: text,
          showConfirmButton: true,
        })
      }

      function save_data() {
        var outlet_code = $('#outlet_code').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var invoice_no = $('#invoice_no').val();
        var customer_id = $('#customer_id').val();
        var tr_code = $('#tr_code').val();
        var operating_unit_list = $('#operating_unit_list').val();

        start_date = start_date ? formatDate(start_date) : null;
        end_date = end_date ? formatDate(end_date) : null;

        if (!outlet_code) {
          alertMessage('error', 'Error', "Store tidak boleh kosong!");
          return false;
        }
        if (!start_date || !end_date) {
          alertMessage('error', 'Error', "Start Date dan End Date tidak boleh kosong!");
          return false;
        }

        var datasend = {
          'outlet_code': outlet_code,
          'start_date': start_date,
          'end_date': end_date,
          'invoice_no': invoice_no,
          'customer_id': customer_id,
          'tr_code': tr_code,
          'operating_unit_list': operating_unit_list
        };

        $.ajax({
          url: "{{ route('save.tax_out') }}",
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          method: "post",
          data: datasend,
          beforeSend: function() { showModalLoading(); },
          success: function(response) {
            if (response.data.length === 0) {
              alertMessage('info', 'Info', 'Tidak ada data baru yang di tambah.');
              return;
            }

            let adaDataBaru = false;
            const now = new Date();

            // Kurangi 50 detik
            now.setSeconds(now.getSeconds() - 50);

            // Setelah dikurangi baru diformat
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, "0");
            const day = String(now.getDate()).padStart(2, "0");
            const hours = String(now.getHours()).padStart(2, "0");
            const minutes = String(now.getMinutes()).padStart(2, "0");
            const seconds = String(now.getSeconds()).padStart(2, "0");
            const dateNow = `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;

            response.getData.forEach(item => {
              if (item.date_create >= dateNow) { 
                adaDataBaru = true;
              }
            });

            if ($.fn.DataTable.isDataTable('#list_table')) {
              $('#list_table').DataTable().clear().destroy(); 
            }

            $('#list_table').removeAttr("hidden");
            var table = $('#list_table').DataTable({
              "processing": true,
              "serverSide": false,
              "lengthMenu": [[5, 10, 25, 50, 100, 250, 500], [5, 10, 25, 50, 100, 250, 500]],
              "data": response.data,
              "columns": [
                { "data": "invoice_date", className: 'text-center' },
                { "data": "invoice_no", className: 'text-center' },
                { "data": "agreement_no", className: 'text-center' },
                { "data": "customer_id", className: 'text-center' },
                { "data": "name", className: 'text-left' },
                { "data": "npwp", className: 'text-center' },
                { "data": "tax_series_no", className: 'text-center' },
                { "data": "dpp", className: 'text-right', render: function(data) {
                  return formatNumber(Number(data));
                }},
                { "data": "dpp", className: 'text-right', render: function(data) {
                  let dppnilailain = Math.round(data * (11 / 12));
                  return formatNumber(Number(dppnilailain));
                }},
                { "data": "ppn", className: 'text-right', render: function(data) {
                  return formatNumber(Number(data));
                }},
                { 
                  "data": "process_tax_out", 
                  className: 'text-center', 
                  render: function (data) {
                    let checked = (data >= 1) ? "checked" : "";
                    return `<input type="checkbox" class="release-checkbox" data-field="checkbox" ${checked} disabled />`;
                  } 
                },
                {
                  "title": "Action", 
                  "data": "company_code", 
                  className: 'text-center', 
                  render: function (data, type, row) {
                    let isDisabled = row.process_tax_out >= 1 ? 'disabled style="pointer-events: none; opacity: 0.5;"' : '';

                    let disabledPDF = row.process_tax_out == 0 ? 'disabled style="pointer-events: none; opacity: 0.5;"' : '';

                    let printButton = row.tr_code === 'DOUT' ? `
                        <span class="mr-2" title="Print Data">
                            <a href="javascript:void(0)" class="btn btn-outline-danger" onclick="downloadFile('${row.invoice_no}')" ${disabledPDF}>
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </span>
                    ` : '';

                    return `
                    <center>
                      <div class="d-grid gap-2 d-md-flex justify-content-center">
                        ${printButton}
                        <span data-toggle="tooltip" title="Edit Data" data-placement="bottom">
                          <a href="javascript:void(0)" 
                            class="btn btn-xs btn-outline-success edit" 
                            data-customerid="${row.customer_id}"  
                            data-operating="${row.operating_unit_list}"
                            data-npwp="${row.npwp}" 
                            data-company="${row.company_code}" 
                            data-store="${row.outlet_code}" 
                            data-invoicedate="${row.invoice_date}" 
                            data-name="${row.name}" 
                            data-address="${row.address}" 
                            data-kota="${row.city_nm}" 
                            data-kodepos="${row.postcode}" 
                            data-invoiceno="${row.invoice_no}" 
                            data-pkp="${row.status_ap}" 
                            data-sk="${row.kwitansi_no}" 
                            data-usercreate="${row.user_create}" 
                            data-datecreate="${row.date_create}" 
                            data-usermodified="${row.user_modified}" 
                            data-datemodified="${row.date_modified}" 
                            data-tanggal="${row.tgl_input}" 
                            data-invtaxdate="${row.inv_tax_date}" 
                            data-taxseries="${row.tax_series_no}" 
                            data-tr="${row.tax_series_no}" 
                            data-release="${row.process_tax_out}" 
                            data-toggle="modal" 
                            data-target="#modal-edit"
                            ${isDisabled}>
                            <i class="far fa-edit"></i>
                          </a> 
                        </span>
                      </div>
                    </center>`;
                  }
                }
              ],
              "createdRow": function(row, data, dataIndex) {
                $(row).attr('data-invoiceno', data.invoice_no);
              }
            });

            if (adaDataBaru) {
              Swal.fire({
                title: 'Success',
                text: 'Data Pajak Keluaran berhasil disimpan',
                icon: 'success',
                confirmButtonText: 'Oke'
              });
            }
          },
          error: function(xhr) {
            if(xhr.status === 404){
              if ($.fn.DataTable.isDataTable('#list_table')) {
                $('#list_table').DataTable().clear().destroy();
              }

              $('#list_table').DataTable({});
            } 
            alertMessage("error", "ERROR", xhr.responseJSON.message);
          },
          complete: function() {
            hideModalLoading();
          }
        });
      }
    </script>
@stop