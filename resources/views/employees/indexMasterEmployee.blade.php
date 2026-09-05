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
        
    </script>
@stop