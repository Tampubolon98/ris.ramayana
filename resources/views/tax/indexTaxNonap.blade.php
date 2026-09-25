@extends('layouts.master')

@section('title', 'Tax')

@section('content_header')
    <style media="screen">
      #generatedTable tbody td {
        border: 1px solid #808080;
      }
      #viewTable thead th {
        border: none;
      }
      #generatedTable a, #optUnCheckAll, #optCheckAll, #checkAll, #unCheckAllAjax {
        cursor: pointer;
      }
      #generatedTable a:hover {
        text-decoration: underline;
        color: #0069D9;
      }
      .rev {
        background-color: #dd9;
      }
      .swal-modal {
        background-color: rgba(63,255,106,0.69);
        border: 3px solid white;
      }

      @media (max-width: 768px) {
        input.form-control {
          width: 100%;
        }
      }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
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
                              <form action="{{ route('/search.tax-nonap') }}" class="form-horizontal" method="post">
                                {!! csrf_field() !!}
                                <div class="row">
                                  <div class="form-group col-md-4">
                                    <label for="" class="control-label">Periode Awal</label>
                                    <div class="input-group date p-1" id="startDate" data-target-input="nearest">
                                      <input type="text" autocomplete="off" class="form-control form-control-sm datetimepicker-input" data-target="#startDate" name="startDate" id="startDates" value="{{ $arrParams['startDate'] }}" />
                                      <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group col-md-4">
                                    <label for="" class="control-label">Periode Akhir</label>
                                    <div class="input-group date p-1" id="endDate" data-target-input="nearest">
                                      <input type="text" readonly autocomplete="off" class="form-control form-control-sm" data-target="#endDate" name="endDate" id="endDates" value="{{ $arrParams['endDate'] }}" />
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
                                      <tbody id="contentReport" style="font-size:12px;">
                                        <?php $no = 1; ?>
                                        @foreach ($arrData as $item)
                                          <tr class="" data-faktur="{{ $item['faktur'] }}" data-supplier-name="{{ $item['supplier_name'] }}" data-npwp="{{ $item['npwp'] }}" data-count="{{ $item['dpp'] + $item['ppn'] }}" data-kode="{{ $item['kode'] }}" data-usercreate="{{ $item['user_create'] }}" data-usermodified="{{ $item['user_modified'] }}" data-datecreate="{{ $item['date_create'] }}" data-datemodified="{{ $item['date_modified'] }}" data-status="{{ $item['status_ap'] }}" id="input-form">
                                            <td>{{ $no }}</td>
                                            <td align="center">{{ $item['supplier'] }}</td>
                                            <td align="center">{{ $item['ms_pjk'] }}</td>
                                            <td align="center">{{ $item['rcv_date'] }}</td>
                                            <td style="width: 10%;">{{ $item['faktur'] }}</td>
                                            <td align="center">
                                              <input type="text" value="{{ $item['tax_series'] }}" class="form-control edit-tax tax_series" data-field="tax_series" style="text-align: center;" maxlength="20" oninput="formatTaxSeries(this)">
                                            </td>
                                            <td align="center">
                                              <input type="text" value="{{ $item['tax_date'] }}" class="form-control edit-tax" data-field="tax_date" style="text-align: center;" maxlength="10">
                                            </td>
                                            <td align="right" class="dpp">{{ $item['dpp'] }}</td>
                                            <td align="right" class="dpp-nilai-lain">{{ $item['dpp_nilai_lain'] }}</td>
                                            <td align="right">
                                              <input type="text" value="{{ $item['ppn'] }}" class="form-control edit-tax ppn" style="text-align: right;" maxlength="15" data-field='ppn' oninput="validatePPN(this, '{{ $item['faktur'] }}', {{ $item['ppn'] }})" data-initial-value="{{ $item['ppn'] }}">
                                              <small class="text-danger error-message" id="error-ppn-{{ $item['faktur'] }}"></small>
                                            </td>
                                            <td align="center">
                                              <input type="checkbox" class="release-checkbox edit-tax" data-field="checkbox" {{ $item['checkbox'] >= 1 ? 'checked' : '' }}>
                                            </td>
                                            <td align="center" class="d-flex gap-2">
                                              <button type="button" class="btn btn-xs btn-success mr-1 edit-btn" onclick="openModal('edit', this)"><i class="far fa-edit"></i></button>
                                              <button type="button" class="btn btn-xs btn-danger mr-1 delete-btn"><i class="fas fa-trash"></i></button>
                                            </td>
                                          </tr>
                                          <?php $no++; ?>
                                        @endforeach
                                      </tbody>
                                      <tfoot id="footReport"></tfoot>
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
      let startDate = $("#startDate").val();
      let endDate = $("#endDate").val();

      $('#startDate').datetimepicker({
        format : "DD-MM-YYYY",
        ignoreReadonly: true,
        allowInputToggle: true
      });

      $("#startDates").blur( () => {
        var startDate = $("input[name=startDate]").val();

        // Check if startDate is not empty
        if (startDate) {
            var parts = startDate.split("-");
            var year = parseInt(parts[2], 10);
            var month = parseInt(parts[1], 10);

            // Create a Date object for the last day of the month
            var lastDay = new Date(year, month, 0).getDate();

            // Format the last day as "DD-MM-YYYY"
            var lastDayFormatted =
            (lastDay < 10 ? "0" : "") + lastDay + "-"  + parts[1] + "-" + year;

            // Set the value of the endDate input field
            $("input[name=endDate]").val(lastDayFormatted);

            // Optionally, perform additional actions or validations
            checkValueSearch();
        }
      });

      $('#endDate').datetimepicker({
        format : "DD-MM-YYYY",
        ignoreReadonly: true,
        allowInputToggle: true
      });

      $("#endDates").blur(function() {
        checkValueSearch();
        var startDate = $("input[name=startDate]").val();
        var endDate = $("input[name=endDate]").val();

        var startDay = new Date(startDate.split("-"));
        var endDay = new Date(endDate.split("-"));
        var millisecondsPerDay = 1000 * 60 * 60 * 24;

        var millisBetween = endDay.getTime() - startDay.getTime();
        var days = millisBetween / millisecondsPerDay;
        var countDay = Math.floor(days);

        var monthStart = startDay.getMonth() + 1;
        var monthMax = endDay.getMonth() + 1;

        monthStart = monthStart < 10 ? '0' + monthStart : '' + monthStart;
        monthMax = monthMax < 10 ? '0' + monthMax : '' + monthMax;

        var monthDifference = (endDay.getFullYear() - startDay.getFullYear()) * 12 + (endDay.getMonth() - startDay.getMonth());

        if (/* monthDifference > 12 || */ startDay.getFullYear() !== endDay.getFullYear()) {
            Swal.fire({
                icon: 'info',
                title: 'Information!',
                text: 'Search period Hanya Boleh Dalam Tahun Yang Sama',
            }).then(function() {
                $("input[name=endDate]").val("");
                checkValueSearch();
                location.reload();
            });
        }


        if (countDay < 0) {
          Swal.fire({
            icon: 'info',
            title: 'Information!',
            text: 'Tanggal akhir tidak boleh kurang dari tanggal awal',
          });
          $("input[name=startDate]").val("");
          $("input[name=endDate]").val("");
          checkValueSearch();
        }

        if (countDay > 31) {
          // alert("Tanggal akhir hanya boleh 7 hari dari tanggal awal");
          swal("Information!", "Tanggal akhir hanya boleh 31 hari dari tanggal awal", "info");
          $("input[name=endDate]").val("");
          checkValueSearch();
        }
      });

      function checkValueSearch() {
        $("#startDates").val() == '' || $("#endDates").val() == '' ? $("#search").attr("hidden", true) : $("#search").attr("hidden", false);
      }

      function formatThousand(input) {
        return input.replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      function formatRibuan(value) {
        return parseFloat(value).toLocaleString('id-ID');
      }

      function getFormattedMonth() {
        let today = new Date();
        let day = String(today.getDate()).padStart(2, '0');
        let month = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        let year = today.getFullYear();
        return `${month}-${year}`;
      }

      function getFormattedDate() {
        let today = new Date();
        let day = String(today.getDate()).padStart(2, '0');
        let month = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        let year = today.getFullYear();
        return `${day}-${month}-${year}`;
      }

      const inputs = document.querySelectorAll('#input-form input');

      inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
          // Pindah ke input berikutnya jika panjang maksimum tercapai
          if (input.value.length >= input.maxLength || input.type === 'date') {
            const nextInput = inputs[index + 1];
            if (nextInput) {
              nextInput.focus();
            }
          }
        });

        // Otomatis pindah saat tanggal dipilih
        if (input.type === 'date') {
          input.addEventListener('change', () => {
            const nextInput = inputs[index + 1];
            if (nextInput) {
              nextInput.focus();
            }
          });
        }
      });

      function validatePPN(input, faktur, ppnDatabase) {
        let value = input.value.replace(/\./g, '').replace(/,/g, '.'); // Hapus titik pemisah ribuan, ubah koma ke titik desimal
        let errorMessage = document.getElementById(`error-ppn-${faktur}`);

        // Pastikan input tidak kosong sebelum validasi
        if (value.trim() === "") {
            errorMessage.textContent = "";
            input.classList.remove("is-invalid");
            disableReleaseCheckbox(faktur, true); // Nonaktifkan release checkbox jika input kosong
            return;
        }

        // Konversi nilai ke float
        let ppnInput = parseFloat(value);

        // Cegah validasi jika input bukan angka valid
        if (isNaN(ppnInput)) {
            errorMessage.textContent = "Masukkan angka yang valid!";
            input.classList.add("is-invalid");
            disableReleaseCheckbox(faktur, true); // Nonaktifkan release checkbox jika input tidak valid
            return;
        }

        // Hitung selisih input dengan PPN dari database
        let difference = Math.abs(ppnInput - ppnDatabase);

        if (difference >= 100) {
            errorMessage.textContent = "Nilai PPN tidak boleh lebih dari 100!";
            input.classList.add("is-invalid");
            disableReleaseCheckbox(faktur, true); // Nonaktifkan release checkbox jika selisih lebih dari 100
        } else {
            errorMessage.textContent = "";
            input.classList.remove("is-invalid");
            disableReleaseCheckbox(faktur, false); // Mengaktifkan release checkbox jika valid
        }
      }

      document.addEventListener("DOMContentLoaded", function(){ 
        let today = new Date();
        let month = ("0" + (today.getMonth() + 1)).slice(-2);
        let year = today.getFullYear();

        document.getElementById("month").value = month + "-" + year;
      })

      /**
       * Fungsi untuk mengecek apakah semua input telah diisi dan checkbox dicentang.
       */
      function checkInputs(row) {
        let allFilled = true;
        row.find(".edit-tax").each(function () {
            if ($(this).val().trim() === "") {
                allFilled = false;
            }
        });

        let isChecked = row.find(".release-checkbox").is(":checked");
        let npwpFilled = $(".input-npwp").val().trim() !== ""; // Cek jika NPWP terisi

        if (allFilled && isChecked && npwpFilled) {
            row.find(".save-tax").prop("disabled", false); // Aktifkan tombol save
        } else {
            row.find(".save-tax").prop("disabled", true); // Nonaktifkan tombol save
        }
      }

      function formatTaxSeries(input) {
        let value = input.value.replace(/\D/g, ''); // Hapus semua karakter non-digit
        let formattedValue = '';

        if (value.length > 0) {
            formattedValue = value.substring(0, 3);
        }
        if (value.length > 3) {
            formattedValue += '.' + value.substring(3, 6);
        }
        if (value.length > 6) {
            formattedValue += '.' + value.substring(6, 9);
        }
        if (value.length > 9) {
            formattedValue += '.' + value.substring(9, 17); // Batasi maksimal 17 digit tanpa titik
        }

        input.value = formattedValue;
      }

      // format uang ID
      function formatNumber(num){
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      function formatListNumber(){
        document.querySelectorAll(".dpp").forEach(function(el){
          el.textContent = formatNumber(el.textContent);
        })

        document.querySelectorAll(".ppn").forEach(function(el){
          el.textContent = formatNumber(el.textContent);
        })

        document.querySelectorAll(".ppn").forEach(function(input){
          input.value = formatNumber(input.value.replace(/\./g, "."));

          input.addEventListener("input", function(){
            let currentValue = this.value.replace(/\./g, "");
            this.value = formatNumber(currentValue);
          });
        });
      }

      document.addEventListener("DOMContentLoaded", function(){
        formatListNumber();
      })

      $(document).ready(function() {
        $('#viewTable').DataTable({
          responsive: true,
          destroy: true
        });

        $('[data-toggle="tooltip"]').tooltip();
      });

      $(document).ready(function(){
        $('#viewTable').DataTable({
          responsive: true,
          destroy: true, 
          columnDefs: [
            {orderable: false, targets: [0, 1, 2, 3, 6, 7, 8, 10, 11]},
            {orderable: true, targets: [4, 5, 9]}
          ]
        });

        $('[data-toggle="tooltip"]').tooltip();
      });

      let arrParams = <?php echo json_encode($arrParams); ?>;
      let generatedParams = <?php echo json_encode($generatedParams); ?>;
      let arrData = [];
      let arrData = <?php echo json_encode($arrData); ?>;

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