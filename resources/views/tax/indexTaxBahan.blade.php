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
                              <a href="#custom-tabs-two-home" class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Bahan</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-two-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                          <div class="row">
                            <div class="col-md-12 p-2">
                              <label for="" class="control-label">Input Pajak Detail Bahan</label>
                              <hr style="margin-top:5px; margin-bottom: 15px; border-color: #DC3545;">
                              <form class="form-horizontal" method="post" action="{{ route('/search.tax_bahan') }}">
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
                                      <input type="text" readonly autocomplete="off" class="form-control form-control-sm" data-target="#endDate" name="endDate" id="endDates" value="{{ $arrParams['endDate'] }}" disabled />
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
                                          <th style="border-left: 1px solid #fff; text-align: center;">PPN</th>
                                          <th style="border-left: 1px solid #fff; text-align: center;">Release</th>
                                          <th style="border-left: 1px solid #fff; text-align: center;">Action</th>
                                        </tr>
                                      </thead>
                                      <tbody id="contentReport" style="font-size:12px;">
                                        <?php $no=1; ?>
                                        @foreach ($data as $item)
                                          <tr class="" data-faktur="{{$data['faktur']}}" data-supplier-name="{{ $data['supplier_name'] }}" data-npwp="{{ $data['npwp'] }}" data-count="{{ $data['dpp'] + $data['ppn'] }}" data-kode="{{ $data['kode'] }}" data-usercreate="{{ $data['user_create'] }}" data-usermodified="{{ $data['user_modified'] }}" data-datecreate="{{ $data['date_create'] }}" data-datemodified="{{ $data['date_modified'] }}" data-status="{{ $data['status_ap'] }}" id="input-form">
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
                                            <td align="right">
                                              <input type="text" value="{{ $item['ppn'] }}" class="form-control edit-tax ppn" style="text-align: right;" maxlength="15" data-field='ppn' oninput="validatePPN(this, '{{ $item['faktur'] }}', {{ $item['ppn'] }})" data-initial-value="{{ $item['ppn'] }}">
                                              <small class="text-danger error-message" id="error-ppn-{{ $item['faktur'] }}"></small>
                                            </td>
                                            <td align="center">
                                              <input type="checkbox" class="release-checkbox edit-tax" data-field="checkbox" {{ $item['checkbox'] >= 1 ? 'checked' : '' }}>
                                            </td>
                                            <td align="center" class="d-flex gap-2">
                                              <button type="button" class="btn btn-xs btn-success mr-1 edit-btn">
                                                <i class="far fa-edit"></i>
                                              </button>
                                              <button type="button" class="btn btn-xs btn-danger mr-1 cancel-btn" style="display: none;"><i class="fa fa-times"></i></button>
                                              <button type="button" class="btn btn-xs btn-danger mr-1 delete-btn"
                                              >
                                                <i class="fas fa-trash"></i>
                                              </button>
                                              <button type="button" class="btn btn-xs btn-primary save-tax"><i class="fa fa-check"></i></button>
                                            </td>
                                          </tr>
                                          <?php $no++; ?>
                                        @endforeach
                                      </tbody>
                                      <tfoot id="footReport"></tfoot>
                                    </table>

                                    <div>
                                      <p id="supplier-name-display"><strong></strong></p>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-6 col-sm-12 form-group">
                                        <div class="row g-3 align-items-center">
                                          <div class="col-auto">
                                            <label for=""><strong>NPWP:</strong></label>
                                          </div>
                                          <div class="col-auto">
                                            <input type="text" maxlength="16" value="" data-field='npwp' id="npwp" class="form-control input-npwp">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-6 col-sm-12 form-group d-flex justify-content-end">
                                        <div class="row g-3 align-items-center">
                                          <div class="col-auto">
                                            <label for=""><strong>Total DPP + PPN:</strong></label>
                                          </div>
                                          <div class="col-auto">
                                            <input type="text" id="total-external" maxlength="15" value="" class="form-control" disabled>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-3 col-sm-6 form-group">
                                        <div class="row g-3 align-items-center">
                                          <div class="col-auto">
                                            <label for=""><strong>Kode:</strong></label>
                                          </div>
                                          <div class="col-auto">
                                            <input type="text" value="" id="kode" class="form-control ml-2" disabled>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-3 col-sm-6 form-group">
                                        <div class="row g-3 align-items-center">
                                          <label for=""><strong>User Create:</strong></label>
                                          <div class="col-auto">
                                            <input type="text" id="user_create" value="" class="form-control form-control-sm" disabled>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-3 col-sm-6 form-group">
                                        <div class="row g-3 align-items-center">
                                          <label for=""><strong>User Modified:</strong></label>
                                          <div class="col-auto">
                                            <input type="text" id="user_modified" value="" class="form-control form-control-sm" disabled>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-3 col-sm-6 form-group d-flex justify-content-end">
                                        <div class="row g-3 align-items-center">
                                          <label for=""><strong>Status AP:</strong></label>
                                          <div class="col-auto">
                                            <input type="text" id="status-ap" value="" class="form-control" disabled>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-3 col-sm-6 form-group">
                                        <div class="row g-3 align-items-center">
                                          <div class="col-auto">
                                            <label for=""><strong>Bulan:</strong></label>
                                          </div>
                                          <div class="col-auto">
                                            <input type="text" autocomplete="off" class="form-control datetimepicker-input ml-1" name="month" id="month" disabled/>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-3 col-sm-6 form-group">
                                        <div class="row g-3 align-items-center">
                                          <label for=""><strong>Date Create:</strong></label>
                                          <div class="col-auto">
                                            <input type="text" autocomplete="off" class="form-control form-control-sm datetimepicker-input" name="date_create" id="date_create" disabled/>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-3 col-sm-6 form-group">
                                        <div class="row g-3 align-items-center">
                                          <label for=""><strong>Date Modified:</strong></label>
                                          <div class="col-auto">
                                            <input type="text" autocomplete="off" class="form-control form-control-sm datetimepicker-input" name="date_modified" id="date_modified" disabled/>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-3 col-sm-6 form-group d-flex justify-content-end">
                                        @php
                                          $totalDpp = 0;
                                          $totalPPn = 0;
                                          $total= 0;
                                        @endphp
        
                                        @foreach ($data as $item)
                                          @php
                                            $totalDpp += $item['dpp'];
                                            $totalPPn += $item['ppn'];
                                            $total += $item['dpp'] + $item['ppn'];
                                          @endphp
                                        @endforeach
                                        <div class="row g-3 align-items-center">
                                          <div class="col-auto">
                                            <label for=""><strong>Count:</strong></label>
                                          </div>
                                          <div class="col-auto">
                                            <input type="text" value="{{ number_format($total, 0, ',', '.') }}" class="form-control" disabled>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer"></div>
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
@stop

@section('content')
@stop

@section('js')
    <script>
      $('#startDate').datetimepicker({
        format : "DD-MM-YYYY",
        ignoreReadonly: true,
        allowInputToggle: true
      });

      $('#endDate').datetimepicker({
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
            console.log('date', lastDayFormatted)

            // Set the value of the endDate input field
            $("input[name=endDate]").val(lastDayFormatted);

            // Optionally, perform additional actions or validations
            checkValueSearch();
        }
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

      $(document).ready(function() {
        $('#viewTable').DataTable({
          responsive: true,
          destroy: true
        });

        $('[data-toggle="tooltip"]').tooltip();
      });

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

      function validatePPN(input, faktur, ppnDatabase) 
      {
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
        console.log('selisih', difference)

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

      $(document).ready(function() {
        $('#viewTable').DataTable({
          responsive: true,
          destroy: true,
          columnDefs: [
                { orderable: false, targets: [0, 1, 2, 3, 6, 7, 9, 10] }, // Nonaktifkan sort untuk kolom lain
                { orderable: true, targets: [4, 5, 8] } // Aktifkan sort untuk kolom Faktur (4), Tax Series (5), dan PPN (8)
            ]
        });

        $('[data-toggle="tooltip"]').tooltip();
      });

      function formatListNumber(){
        document.querySelectorAll(".dpp").forEach(function(el){
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

      function formatNumber(num){
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      function formatTaxSeries(input) 
      {
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

      document.addEventListener("DOMContentLoaded", function () {
        let npwpInput = document.getElementById("npwp");

        document.querySelectorAll("tr[data-faktur]").forEach(row => {
          row.addEventListener("click", function () {
            let supplierName = this.getAttribute("data-supplier-name") || "";
            let npwp = this.getAttribute("data-npwp") || ""; // Bisa kosong
            let kode = this.getAttribute("data-kode") || "";
            let userCreate = this.getAttribute("data-usercreate") || "";
            let dateCreate = this.getAttribute("data-datecreate") || "";
            let userModified = this.getAttribute("data-usermodified") || "";
            let dateModified = this.getAttribute("data-datemodified") || "";
            let statusAp = this.getAttribute("data-status") || "";
            let count = this.getAttribute("data-count") || "0";

            // Tampilkan nama supplier
            document.getElementById("supplier-name-display").innerHTML = `<strong>${supplierName}</strong>`;

            // Pastikan NPWP selalu diperbarui sesuai row yang diklik setelah Cancel ditekan
            if (!npwpInput.dataset.userEdited || npwpInput.dataset.userEdited === "false") {
                npwpInput.value = npwp;
            }

            // Perbarui input lainnya
            document.getElementById("total-external").value = formatNumber(count);
            document.getElementById("kode").value = kode;
            document.getElementById("user_create").value = userCreate;
            document.getElementById("date_create").value = dateCreate;
            document.getElementById("user_modified").value = userModified == 0 ? "-" : userModified;
            document.getElementById("date_modified").value = dateModified;
            document.getElementById("status-ap").value = statusAp;
            document.getElementById("count").value = formatNumber(count);
          });
        });

        // Tambahkan event listener untuk mendeteksi perubahan oleh user
        npwpInput.addEventListener("input", function () {
            this.dataset.userEdited = "true"; // Tandai bahwa user telah mengedit
        });

        // Ketika tombol Cancel diklik, reset input NPWP dan izinkan row table memperbaruinya
        $(".cancel-btn").click(function () {
            let row = $(this).closest("tr");

            row.find(".edit-tax").prop("disabled", true);
            $(".input-npwp").prop("disabled", true).val(""); // Kosongkan input NPWP
            row.find(".tax_series").val("");
            row.find(".ppn").val(formatNumber(row.find(".ppn").data("initial-value")));

            row.find(".edit-btn").show(); // Tampilkan kembali tombol edit
            row.find(".cancel-btn").hide(); // Sembunyikan tombol cancel
            row.find(".save-tax").prop("disabled", true); // Nonaktifkan tombol save

            // Hapus flag userEdited agar input NPWP bisa diperbarui saat klik row tabel
            npwpInput.dataset.userEdited = "false";
        });
      });

      document.addEventListener("DOMContentLoaded", function(){ 
        let today = new Date();
        let month = ("0" + (today.getMonth() + 1)).slice(-2);
        let year = today.getFullYear();

        document.getElementById("month").value = month + "-" + year;
      })

      $(document).ready(function () {
        $(".edit-tax, .save-tax, .input-npwp").prop("disabled", true); // Semua input, checkbox, tombol save, dan NPWP disabled

        // Nonaktifkan tombol edit jika release == 1
        $(".edit-btn, .delete-btn").each(function () {
            let row = $(this).closest("tr");
            let isChecked = row.find('input[type="checkbox"]').prop("checked"); // Ambil status checkbox
            console.log('Checkbox status:', isChecked);

            if (isChecked) { // Jika checkbox dicentang, disable tombol edit
                $(this).prop("disabled", true);
            }
        });
        
        $(".edit-btn").click(function () {
            let row = $(this).closest("tr");
            row.find(".edit-tax").prop("disabled", false); // Aktifkan input di dalam tabel
            $(".input-npwp").prop("disabled", false); // Aktifkan input NPWP di luar tabel
            row.find(".edit-btn").hide(); // Sembunyikan tombol edit
            row.find(".cancel-btn").show(); // Tampilkan tombol cancel
            checkInputs(row); // Cek apakah tombol save bisa diaktifkan
        });

        $(".edit-tax, .input-npwp").on("input change", function () {
            let row = $(this).closest("tr");
            checkInputs(row); // Cek apakah tombol save bisa diaktifkan
        });

        $(".cancel-btn").hide(); // Sembunyikan tombol cancel saat pertama kali
      });

      function checkValueSearch() {
        $("#startDates").val() == '' || $("#endDates").val() == '' ? $("#search").attr("hidden", true) : $("#search").attr("hidden", false);
      }

      let arrParams = <?php echo json_encode($arrParams); ?>;
      let generatedParams = <?php echo json_encode($generate_params); ?>;
      let startDate = $("#startDate").val();
      let endDate = $("#endDate").val();
      let data = [];
      let imgLoader = "{{asset('images/loader.gif')}}";
    </script>
@stop