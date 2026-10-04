@extends('layouts.master')

@section('title', 'Master Employee')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-red card-tabs">
                    <div class="card-header p-0 pt-2 pb-2">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="card-title" style="color: white">&nbsp; Mutasi Employee</li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12" style="display: flex; justify-content: space-between;">
                                <div class="row ml-1">
                                    <div class="form-group">
                                        <a href="javascript:void(0)" class="btn btn-m btn-success mr-3" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i>&nbsp; Tambah Data</a>
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
                                                <th class="text-center" style="background-color: #dc3545; color: white;">Kategori Karyawan</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">Kode Toko</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">Supplier</th>
                                                <th class="text-center" style="background-color: #dc3545; color: white;">No KK</th>
                                                <th 
                                                class="text-center" style="background-color:#dc3545; color: white;">No KTP</th>
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
                    <h3 class="modal-title" id="modal-title">Tambah Mutasi Employee</h3>
                </div>
                <form action="{{ route('/mutasi-employee.tambah') }}" id="modalForm" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" id="edit-faktur" name="edit-faktur">

                        <div class="form-group">
                            <label for="" data-required="true">ID Employee</label>
                            <input type="text" class="form-control form-control-sm" id="idEmployee" name="idEmployee">
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Nama</label>
                                <input type="text" class="form-control form-control-sm" id="new-name" name="new-name">
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Tanggal Masuk</label>
                                <div class="input-group input-group-sm date">
                                    <input type="text" class="form-control flatpickr-input" id="new-join" name="new-join">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="joinDate"><i class="fa fa-calendar"></i></div>
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

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Kode Toko</label>
                                <select name="new-store" id="new-store" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off"></select>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="" data-required="true">Perusahaan</label>
                                <select name="new-office" id="new-office" class="form-control form-control-sm select2" style="width: 100%;" autocomplete="off"></select>
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
@stop

@section('content')
@stop

@section('js')
    <script>
        $(document).ready(function() {
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

            getDataMutasi();
        });

        function resetPage() {
            document.querySelector('#modal-add form').reset();
            $('#new-office').val(null).trigger('change');
            $('#new-store').val(null).trigger('change');
            $('#new-category').val(null).trigger('change');
            tglMasuk.setDate(getFormattedDate(), true);
        }

        function getFormattedDate() {
            let today = new Date();
            let day = String(today.getDate()).padStart(2, '0');
            let month = String(today.getMonth() + 1).padStart(2, '0');
            let year = today.getFullYear();
            return `${day}-${month}-${year}`;
        }

        let tglMasuk = flatpickr("#new-join", {
            dateFormat: 'd-m-Y',
            allowInput: true,
            defaultDate: getFormattedDate()
        });

        document.getElementById('joinDate').addEventListener('click', function() {
            tglMasuk.open();
        });

        function getDataMutasi() 
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'get',
                url: "{{ route('/mutasi-employee.get-mutasi') }}",
                success: function(response) {
                    // Destroy DataTable jika sudah ada
                    if ($.fn.DataTable.isDataTable('#list_table')) {
                        $('#list_table').DataTable().destroy();
                    }

                    // Inisialisasi DataTable baru
                    $('#list_table').DataTable({
                        order: [],
                        processing: true,
                        pageLength: 10,
                        data: response,
                        columns: [
                            {
                                data: 'id_employee',
                                name: 'a.id_employee',
                                className: 'text-center'
                            },
                            {
                                data: 'nama',
                                name: 'a.nama',
                                className: 'text-left',
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
                                data: 'kategori_karyawan',
                                name: 'a.kategori_karyawan',
                                className: 'text-center'
                            },
                            {
                                data: 'kode_toko',
                                name: 'a.kode_toko',
                                className: 'text-center',
                            },
                            {
                                data: 'md_emp',
                                name: 'a.md_emp',
                                className: 'text-left',
                                render: function(data, type, row) {
                                    return row.md_emp + ' - ' + row.brand_emp + ' - ' + row.supplier;
                                }
                            },
                            {
                                data: 'no_kk',
                                name: 'a.no_kk',
                                className: 'text-center'
                            },
                            {
                                data: 'no_ktp',
                                name: 'a.no_ktp',
                                className: 'text-center'
                            }
                        ]
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Failed!',
                        text: 'Gagal memuat data',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        function getData() {
            let idemployee = $('#idEmployee').val();
            
            if (!idemployee) {
                return;
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: "{{ route('/mutasi-employee.get') }}",
                data: {
                    'id_employee': idemployee
                },
                success: function(data) {
                    if (data.length > 0) {
                        // tanggal masuk dari table master_employee_spg
                        let today = new Date(data[0].tanggal_masuk);
                        let dayMasuk = String(today.getDate()).padStart(2, '0');
                        let monthMasuk = String(today.getMonth() + 1).padStart(2, '0');
                        let yearMasuk = today.getFullYear();
                        let date = `${dayMasuk}-${monthMasuk}-${yearMasuk}`;

                        // tanggal masuk dari table mutasi_emp
                        let joinToday = new Date(data[0].join_date);
                        let day = String(joinToday.getDate()).padStart(2, '0');
                        let month = String(joinToday.getMonth() + 1).padStart(2, '0');
                        let year = joinToday.getFullYear();
                        let join = `${day}-${month}-${year}`;

                        let tglMasuk = data[0].join_date !== null ? join : date;

                        var $storeSelect = $('#new-store');
                        $storeSelect.select2({
                            placeholder: 'Select a store',
                            ajax: {
                                url: "{{ route('/master-employee.get-toko') }}",
                                dataType: 'json',
                                delay: 250,
                                data: function(params) {
                                    return {
                                        searchTerm: params.term,
                                        limit: 50
                                    };
                                },
                                processResults: function(response) {
                                    var options = [];
                                    for(var i=0; i<response.length; i++) {
                                        options.push({
                                            id: response[i].homebase_terminal_id,
                                            homebase_terminal_id: response[i].homebase_terminal_id,
                                            homebase: response[i].homebase,
                                            text: response[i].homebase_terminal_id + " || " + response[i].homebase
                                        });
                                    }
                                    return {
                                        results: options
                                    };
                                },
                                cache: true
                            }
                        });

                        // Set nilai awal dari data employee
                        if(data[0].store !== null) {
                            var newOption = new Option(
                                data[0].store + " || " + data[0].store_name,
                                data[0].store,
                                true,
                                true
                            );

                            $(newOption).data({
                                homebase_terminal_id: data[0].store,
                                homebase: data[0].store_name
                            });

                            $storeSelect.append(newOption).trigger('change');
                        } else {
                            if (data[0].kode_toko) {
                                var newOption = new Option(
                                    data[0].kode_toko + " || " + data[0].homebase,
                                    data[0].kode_toko,
                                    true,
                                    true
                                );
        
                                $(newOption).data({
                                    homebase_terminal_id: data[0].kode_toko,
                                    homebase: data[0].homebase
                                });
        
                                $storeSelect.append(newOption).trigger('change');
                            }
                        }

                        var $officeSelect = $('#new-office'); 
                        $officeSelect.select2({
                            placeholder: 'Select a supplier',
                            ajax: {
                                url: "{{ route('/master-employee.get-supplier') }}",
                                dataType: 'json',
                                delay: 250,
                                data: function(params) {
                                    return {
                                        searchTerm: params.term,
                                        limit: 50
                                    };
                                },
                                processResults: function(response) {
                                    var options = [];
                                    for(var i=0; i<response.length; i++) {
                                        options.push({
                                            id: response[i].md,
                                            md: response[i].md,
                                            detail_brand: response[i].detail_brand,
                                            nama_supplier: response[i].nama_supplier,
                                            text: response[i].md + " - " + response[i].detail_brand + ' - ' + response[i].nama_supplier
                                        });
                                    }
                                    return {
                                        results: options
                                    };
                                },
                                cache: true
                            }
                        });

                        if(data[0].detail_brand !== null) {
                            var newOption = new Option(
                                data[0].md + " - " + data[0].brand + " - " + data[0].detail_brand,
                                data[0].md,
                                true,
                                true
                            );

                            $(newOption).data({
                                md: data[0].md_emp,
                                detail_brand: data[0].brand_emp,
                                nama_supplier: data[0].supplier
                            });

                            $officeSelect.append(newOption).trigger('change');
                        } else {
                            if (data[0].supplier) {
                                var newOption = new Option(
                                    data[0].md_emp + " - " + data[0].brand_emp + " - " + data[0].supplier,
                                    data[0].md_emp,
                                    true,
                                    true
                                );
        
                                $(newOption).data({
                                    md: data[0].md_emp,
                                    detail_brand: data[0].brand_emp,
                                    nama_supplier: data[0].supplier
                                });
        
                                $officeSelect.append(newOption).trigger('change');
                            }
                        }

                        $('#new-name').val(data[0].nama);
                        $('#new-join').val(tglMasuk);
                        $('#new-category').val(data[0].kategori_karyawan).trigger('change');

                        let kk = data[0].kk !== null ? data[0].kk : data[0].no_kk;
                        let ktp = data[0].ktp !== null ? data[0].ktp : data[0].no_ktp;

                        $('#new-kk').val(kk);
                        $('#new-ktp').val(ktp);

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

        $('#idEmployee').on('input', function() {
            if ($(this).val().length > 0) {
                getData();
            }
        });

        function addData() {
            // Ambil semua input
            const idemployee = $('#idEmployee').val();
            const name = $('#new-name').val();
            const date = $('#new-join').val();
            const category = $('#new-category').val();
            const supplier = $('#new-office').val();
            const kk = $('#new-kk').val();
            const ktp = $('#new-ktp').val();
            const office = $('#new-office').select2('data');
            const storeSelect = $('#new-store').select2('data')[0];

            if (!idemployee || !name || !date || !category || !storeSelect || !supplier || !kk || !ktp) {
                Swal.fire({
                    title: 'Error',
                    text: 'Semua field wajib diisi.',
                    icon: 'warning'
                });
                return;
            }

            const homebase = storeSelect.homebase;
            const homebase_terminal_id = storeSelect.homebase_terminal_id;

            const md = office[0].id;
            const brand = office[0].detail_brand;
            const namaSupplier = office[0].nama_supplier;

            let formData = new FormData();
            formData.append('idemployee', idemployee);
            formData.append('name', name);
            formData.append('date', date);
            formData.append('category', category);
            formData.append('supplier', supplier);
            formData.append('kk', kk);
            formData.append('ktp', ktp);
            formData.append('md', md);
            formData.append('detail_brand', brand);
            formData.append('nama_supplier', namaSupplier);
            formData.append('homebase_terminal_id', homebase_terminal_id);
            formData.append('homebase', homebase);

            $.ajax({
                url: "{{ route('/mutasi-employee.tambah') }}",
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
                            text: response.message || 'Gagal menyimpan data',
                            icon: 'error'
                        });
                    }
                },
                beforeSend: function() {
                    showModalLoading();
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        Swal.fire({
                            title: 'Error',
                            html: xhr.responseJSON.message,
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
    </script>
@stop