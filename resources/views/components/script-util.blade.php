{{--
| Kumpulan fungsi helper javascript yang dipakai di semua halaman fitur.
| Komponen ini dipanggil SEKALI saja dari resources/views/layouts/master.blade.php,
| jadi jangan di-include lagi per halaman.
--}}
<script>

  /** fungsi untuk mendapatkan sort pada datatables serverside */
  function sort_datatables_serverside(request) {
    //mndapatkan data nama kolom
    let column_name = [];
    for (let i=0; i<request.columns.length; i++) {
      column_name[i] = request.columns[i].name;
    }

    //cek sort
    var order = request.order;
    if(order !== undefined) {
      let order_by = [];
      for(i=0; i <order.length; i++) {
        let column_no = 0;
        let column_sort = "asc";

        //cek nama kolom
        if(order[i].column !== undefined) {
          if(column_name[order[i].column] !== undefined && column_name[order[i].column] !== "") {
            column_no = column_name[order[i].column];
          }
        }
        if(order[i].dir !== undefined) column_sort = order[i].dir;

        order_by.push([column_no, column_sort]);
      }

      return order_by;
    }
    return undefined;
  }

  /** fungsi untuk set cookie */
  function setCookie_js(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  /** fungsi untuk get cookie */
  function getCookie_js(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  /** fungsi untuk cek input form kosong */
  function check_input_global(variable) {
    if(
      (variable!==undefined && variable!==null && variable.trim() === '') ||
      variable === undefined ||
      variable === null ||
      variable === "null"
    ) return false;
    else return true;
  }

  /** fungsi untuk mencari selisih dari 2 tanggal */
  function getDaysBetween(date1String, date2String) {
    // Create Date objects from the YYYY-MM-DD strings.
    // JavaScript treats YYYY-MM-DD strings as UTC by default if no time is provided,
    // which helps in consistency.
    const date1 = new Date(date1String);
    const date2 = new Date(date2String);

    // Use Date.UTC() to get the number of milliseconds since the Unix epoch
    // for a specific UTC date, effectively stripping out time zone effects.
    const utcDate1 = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
    const utcDate2 = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());

    // Calculate the difference in milliseconds.
    const diffInMilliseconds = Math.abs(utcDate2 - utcDate1); // Use Math.abs for a positive result

    // Convert milliseconds to days.
    // (1000ms * 60s * 60m * 24h) = 86400000 milliseconds in a day.
    const millisecondsPerDay = 1000 * 60 * 60 * 24;

    const diffInDays = Math.floor(diffInMilliseconds / millisecondsPerDay);

    return diffInDays;
  }

  /** fungsi untuk ubah format tanggal menjadi yyyy-mm-dd */
  function dateformat_global(data) {
    var date = data.split("/");
    var str = date[2];
    var tahun = str.replace(' ','');

    return tahun+'-'+date[1]+'-'+date[0];
  }

  /** fungsi untuk ubah format tanggal menjadi dd mmm yyyy */
  function dateformat_global_2(value) {
    let date = new Date(value);
    const day = date.toLocaleString('default', { day: '2-digit' });
    const month = date.toLocaleString('default', { month: 'short' });
    const year = date.toLocaleString('default', { year: 'numeric' });
    return day + ' ' + month + ' ' + year;
  }

  /** fungsi untuk format tanggal
   * YYYY-MM-DD to MM-DD-YYYY
   */
  function dateformatA_global(data) {
    var date = data.split("-");
    var str = date[0];
    var tahun = str.replace(' ','');

    return date[1] + '-' + date[2] + '-'+tahun;
  }

  /** fungsi untuk format currency dengan 2 digit desimal setelah koma */
  const formatter_global = new Intl.NumberFormat('en-US', {
    maximumFractionDigits: 2,
  });

  /** fungsi untuk format currency dengan 4 digit desimal setelah koma */
  const formatter_global_4 = new Intl.NumberFormat('en-US', {
    maximumFractionDigits: 4,
  });

  /** fungsi untuk merubah format dari currency (symbol .,) menjadi number (tanpa symbol) */
  function Currency2Number_global(val) {
    return val.replace(/[^0-9\.-]+/g,'');
  }

  /** fungsi untuk mengubah nilai menjadi currency
   * hitung ulang */
  function currency_format_global(id_input) {
    const input = document.getElementById(id_input);
    if(input === null) return;

    input.addEventListener('keyup', function(e) {
      var val = this.value;
      if(val.substr(val.length - 1)!=='.' && val.substr(val.length - 2)!=='.0') {
        val = Currency2Number_global(val);
        val = formatter_global.format(val);
        if(val==='0') val = '';
      }

      return this.value = val;
    });
  }

  /** fungsi untuk handle error javascript */
  function handle_error_json(xhr, status, error) {
    const obj = JSON.parse(xhr.responseText);
    const errMsg = obj.error;

    Swal.fire({
      title: 'Failed!',
      text: errMsg === undefined ? 'Data error' : errMsg,
      icon: 'error',
      confirmButtonText: 'Oke'
    })
  }

  /** fungsi untuk handle error javascript */
  function handle_error_json_V2(xhr) {
    let errMsg = "ERROR'S";
    const obj = JSON.parse(xhr.responseText);
    if(obj.msg !== undefined) errMsg = obj.msg;

    Swal.fire({
      title: 'Failed!',
      text: errMsg === undefined ? 'Data error' : errMsg,
      icon: 'error',
      confirmButtonText: 'Oke'
    })
  }

  /** fungsi untuk handle error javascript for array */
  function handle_error_json_array(xhr) {
    let errMsg = "";
    const obj = JSON.parse(xhr.responseText);
    if(obj.msg !== undefined) {
      for(i=0; i<obj.msg.length; i++) {
        if(errMsg!=="") errMsg += "<br>";
        errMsg += obj.msg[i];
      }
    }
    else errMsg = "ERROR'S";

    Swal.fire({
      title: 'Failed!',
      html: errMsg === undefined ? 'Data error' : errMsg,
      icon: 'error',
      confirmButtonText: 'Oke'
    })
  }

  /** Fungsi untuk menampilkan pesan error */
  function alertMessage_global(icon, title, text){
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
        showConfirmButton: true,
    })
  }

  // ============ START MESSAGING =============

    //message component mandatory
    function messageMandatory(){
        $(document).Toasts('create', {
            class: 'bg-warning',
            title: 'Information',
            body: '<b>Yang bertandakan * tidak boleh dikosongkan</b>'
          })
    }

    //penjelasan penggunaan
    //1. apabila loading digunakan pada modal pertama showModalLoading - complete_ajax_V2 atau showModalLoadingV2 - complete_ajax_V4

    //show modal loading page
    function showModalLoading(){
      $('#modalLoading').modal('show');
    }

    // show modal loading page
    // apabila ingin menampilkan loading dan menutupnya berkali-kali
    // maka fungsi ini lebih baik
    function showModalLoadingV2(){
      $('#modalLoading').addClass("in");
      $('#modalLoading').css("display", "block");
      $('#modalLoading').modal('show');
    }

    //close modal loading page
    function hideModalLoading(){
      $("#modalLoading").removeClass("show");
      $('.modal-backdrop').remove();
      $("#modalLoading").modal('hide');
      $('#modalLoading').hide();
    }

    //close modal loading page add another attribute
    function hideModalLoadingV2(){
      $("#modalLoading").removeClass("show");
      $("#modalLoading").removeClass("in");
      $(".modal-backdrop").remove();
      $('body').removeClass('modal-open');
      $('body').css('padding-right', '');
      $("#modalLoading").modal('hide');
      $("#modalLoading").hide();
    }

    //close modal loading page add another attribute
    //fungsi ini akan membuat modal yang sebelumnya sudah eksis, tidak bisa scroll down ketika loading tertutup
    function hideModalLoadingV3() {
      $("#modalLoading").removeClass("in");
      $(".modal-backdrop").remove();
      $("#modalLoading").hide();

      $("body").removeClass("modal-open")
    }

    //close modal loading page add another attribute
    //status set true if open modal with loading
    function hideModalLoadingV4() {
      $("#modalLoading").removeClass("in");
      $(".modal-backdrop").remove();
      $('#modalLoading').css("display", "none");
      $("#modalLoading").hide();
    }

    /** fungsi untuk hide modal loading khusus ajax */
    function complete_ajax(callback) {
      setTimeout(function() {
        if(callback===undefined || callback===null) hideModalLoadingV3();

        if(callback!==undefined && callback!==null) {
          setTimeout(function() {
            callback();
          }, 1000);
        }
      }, 1000);
    }

    /** fungsi untuk hide modal loading khusus ajax */
    function complete_ajax_V4(callback) {
      setTimeout(function() {
        if(callback===undefined || callback===null) hideModalLoadingV4();

        if(callback!==undefined && callback!==null) {
          setTimeout(function() {
            callback();
          }, 1000);
        }
      }, 1000);
    }

    /** fungsi untuk hide modal loading khusus ajax */
    function complete_ajax_V2(callback) {
      setTimeout(function() {
        if(callback===undefined || callback===null) hideModalLoadingV2();

        if(callback!==undefined && callback!==null) {
          setTimeout(function() {
            callback();
          }, 1000);
        }
      }, 1000);
    }

    function showLoadingWithCancel(){
        $('#modalLoadingV3').modal('show');
    }

    function hideLoadingWithCancel() {
      $("#modalLoadingV3").modal('hide');
    }

  // ============ END MESSAGING =============


  // ============ START FORMAT =============

    // number format
    function number_format(num){
         stringNum = num.toString();
         stringNum = stringNum.split("");
         c = 0;
         if (stringNum.length>3) {
           for (i=stringNum.length; i>-1; i--) {
             if ( (c==3) && ((stringNum.length-i)!=stringNum.length) ) {
               stringNum.splice(i, 0, ",");
               c=0;
             }
             c++
           }
           return stringNum;
         }
         return num;
    }

  // ============ END FORMAT =============


  // ============ START INISIALISASI PLUGIN GLOBAL =============
  // Dijalankan setelah DOM siap, dan hanya kalau plugin & elemennya ada,
  // supaya halaman yang tidak memakai plugin tersebut tidak error.

  $(function () {

    // select 2
    // :not(.select2-hidden-accessible) supaya select2 yang sudah di-inisialisasi manual
    // dengan config khusus (misal ajax) di script halaman tidak di-destroy dan diganti
    // dengan select2 polos oleh inisialisasi global ini.
    if ($.fn.select2) $('.select2:not(.select2-hidden-accessible)').select2();

    //Datemask dd/mm/yyyy
    if ($.fn.inputmask) {
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    }

    if ($.fn.datetimepicker) {

      // datepicker month
      $('#datemonth').datetimepicker({
          viewMode: "months",
          format : 'MM',
          ignoreReadonly: true,
          allowInputToggle: true
      });

      // datepicker years
      $('#dateyear').datetimepicker({
         viewMode: 'years',
         format: 'YYYY',
         ignoreReadonly: true,
         allowInputToggle: true
      });

      // datepicker yearsmonth
      $('#dateyearmonth').datetimepicker({
          viewMode: 'years',
          format: 'YYYYMM',
          ignoreReadonly: true,
          allowInputToggle: true
      });

      //datepicker format DD-MMM-YY
      $('#datepicker').datetimepicker({
         defaultDate:new Date(),
         format : "DD-MMM-YY",
         ignoreReadonly: true,
         allowInputToggle: true
      });

      //datepicker format YYYYMMDD
      $('#datepicker2').datetimepicker({
         defaultDate:new Date(),
         format : "YYYYMMDD",
         ignoreReadonly: true,
         allowInputToggle: true
      });

      //datepicker format YYYYMMDD
      $('#datepicker3').datetimepicker({
         defaultDate:new Date(),
         format : "YYYYMMDD",
         ignoreReadonly: true,
         allowInputToggle: true
      });

      //datepicker format DD/MM/YYYY
      $('#datepicker4').datetimepicker({
         defaultDate:new Date(),
         format : "DD/MM/YYYY",
         ignoreReadonly: true,
         allowInputToggle: true
      });

      //datepicker range date format
      $('#reservationdate').datetimepicker({
          format: 'L'
      });

      //datepickertime range datetime
      $('#timepicker').datetimepicker({
        format: 'LT'
      });
    }

    if ($.fn.daterangepicker) {

      //datepicker range date
      $('#reservation').daterangepicker();

      //datepickertime range datetime format
      $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY hh:mm A'
          }
      });

      //datepickertime button
      if (typeof moment !== 'undefined') {
        $('#daterange-btn').daterangepicker(
          {
            ranges   : {
              'Today'       : [moment(), moment()],
              'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month'  : [moment().startOf('month'), moment().endOf('month')],
              'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
          },
          function (start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          }
        );
      }
    }

    // notifikasi flash message dari controller
    @if(Session::has('message'))
        Swal.fire({
           icon: 'success',
           title: "Sukses",
           text: @json(Session::get('message')),
           showConfirmButton: true,
         })
    @endif

    @if(Session::has('messagefail'))
        Swal.fire({
           icon: 'error',
           title: 'Gagal',
           text: @json(Session::get('messagefail')),
           showConfirmButton: true,
         })
    @endif
  });

  // ============ END INISIALISASI PLUGIN GLOBAL =============
</script>
