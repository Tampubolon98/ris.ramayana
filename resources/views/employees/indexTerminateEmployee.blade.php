@extends('layouts.master')

@section('title', 'Master Employee')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-red card-tabs">
                    <div class="card-header p-0 pt-2 pb-2">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="card-title" style="color: white">&nbsp; Terminate Employee</li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="row" id="div_table">
                            <div class="col-md-12">
                                <div style="overflow-x: auto;">
                                    <table class="table table-sm table-condensed table-bordered" style="font-size: 90%" id="list_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">ID Karyawan</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Nama Karyawan</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Tanggal Keluar</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Kode Toko</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Supplier</th>
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

    {{-- Modal Detail --}}
    <div class="modal fade" id="modal-detail" data-mode="detail" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title">Detail Terminate Karyawan</h3>
                </div>
                <form id="modalForm" class="form-horizontal" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="card-body">
                    <input type="hidden" id="idemployee" name="editFaktur">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Nama</label>
                        <input type="text" class="form-control form-control-sm" id="new-name" name="new-name" disabled>
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Tanggal Lahir</label>
                        <div class="input-group input-group-sm date">
                            <input type="text" class="form-control flatpickr-input" id="new-birthday" name="new-birthday" disabled>
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="birthDay"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="required" data-required="true">Alamat</label>
                    <textarea id="new-address" name="new-address" class="form-control form-control-sm" disabled></textarea>
                    </div>

                    <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Kode Toko</label>
                        <select id="new-store" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled></select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Perusahaan</label>
                        <select id="new-office" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled></select>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">No Handphone</label>
                        <input type="text" class="form-control form-control-sm" id="new-phone" name="new-phone" disabled>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Tanggal Masuk</label>
                        <div class="input-group input-group-sm date">
                            <input type="text" class="form-control flatpickr-input" id="new-join" name="new-join" disabled>
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="joinDate"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>

                    </div>
                    </div>

                    <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Nomor Kartu Keluarga</label>
                        <input type="text" class="form-control" id="new-kk" name="new-kk" disabled>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Nomor KTP</label>
                        <input type="text" class="form-control" id="new-ktp" name="new-ktp" disabled>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Jenis Kelamin</label>
                        <select id="new-gender" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled>
                            <option value="">Select at item</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Status</label>
                        <select id="new-status" class="form-control form-control-sm select2" style="width: 100%;" required="" autocomplete="off" disabled>
                            <option value="">Select at item</option>
                            <option value="1">Belum Menikah</option>
                            <option value="2">Menikah</option>
                            <option value="3">Duda</option>
                            <option value="4">Janda</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="required" data-required="true">Tanggal Keluar</label>
                        <div class="input-group input-group-sm date">
                            <input type="text" class="form-control flatpickr-input" id="new-out" name="new-out" disabled>
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="outDate"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="required" data-required="true">Catatan Kerja Karyawan</label>
                    <textarea id="new-note" name="new-note" class="form-control form-control-sm" disabled></textarea>
                </div>
                    
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn-sm btn-danger" data-dismiss="modal" onclick="resetPage()"><i class="fa fa-times"></i>&nbsp; Batal</button>
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
        function getData() 
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'get',
                url: "{{ route('terminate-employee.get') }}",
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
                                className: 'text-left',
                                render: function(data, type, row, meta) {
                                    return `<span title="Detail Data" data-toggle="tooltip" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="detail" data-target="#modal-detail" data-toggle="modal"
                                                    data-idemployee="${row.id_employee}"
                                                    data-nama="${row.nama}"
                                                    data-tgllahir="${row.tanggal_lahir}"
                                                    data-alamat="${row.alamat}"
                                                    data-kodetoko="${row.kode_toko}"
                                                    data-homebase="${row.homebase}"
                                                    data-perusahaan="${row.supplier}"
                                                    data-md="${row.md_emp}"
                                                    data-brand="${row.brand_emp}"
                                                    data-handphone="${row.no_handphone}"
                                                    data-tglmasuk="${row.tanggal_masuk}"
                                                    data-nokk="${row.no_kk}"
                                                    data-noktp="${row.no_ktp}"
                                                    data-jeniskelamin="${row.jenis_kelamin}"
                                                    data-status="${row.status}"
                                                    data-tglkeluar="${row.tanggal_selesai}"
                                                    data-note="${row.keterangan}"> ${row.id_employee} </a>
                                                </span>`
                                }
                            },
                            {
                                data: 'nama',
                                name: 'a.nama',
                                className: 'text-left'
                            },
                            {
                                data: 'tanggal_selesai',
                                name: 'a.tanggal_selesai',
                                className: 'text-left',
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
                                className: 'text-left'
                            },
                            {
                                data: 'supplier',
                                name: 'a.supplier',
                                className: 'text-left',
                                width: '300px',
                                render: function(data, type, row, meta) {
                                    return row.md_emp + ' - ' + row.brand_emp + ' - ' + row.supplier;
                                }
                            }
                        ]
                    });
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

        $(document).ready(function() {
            getData();
        });

        $(document).on('click', 'a.detail', function() {
            // Ambil data dari atribut data
            let idEmployee = $(this).data('idemployee');
            let nama = $(this).data('nama');
            let tgllahir = $(this).data('tgllahir');
            let alamat = $(this).data('alamat');
            let kodetoko = $(this).data('kodetoko');
            let homebase = $(this).data('homebase');
            let perusahaan = $(this).data('perusahaan');
            let md = $(this).data('md');
            let brand = $(this).data('brand');
            let handphone = $(this).data('handphone');
            let tglmasuk = $(this).data('tglmasuk');
            let nokk = $(this).data('nokk');
            let noktp = $(this).data('noktp');
            let jeniskelamin = $(this).data('jeniskelamin');
            let status = $(this).data('status');
            let tglkeluar = $(this).data('tglkeluar');
            let note = $(this).data('note');

            function formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            }

            // Buka modal detail
            $('#modal-detail').modal('show');
            
            // Set nilai form
            $('#modal-detail #idemployee').val(idEmployee);
            $('#modal-detail #new-name').val(nama);
            $('#modal-detail #new-birthday').val(formatDate(tgllahir));
            $('#modal-detail #new-address').val(alamat);
            $('#modal-detail #new-phone').val(handphone);
            $('#modal-detail #new-join').val(formatDate(tglmasuk));
            $('#modal-detail #new-kk').val(nokk);
            $('#modal-detail #new-ktp').val(noktp);
            $('#modal-detail #new-out').val(formatDate(tglkeluar));
            $('#modal-detail #new-note').val(note);
            $('#modal-detail #new-gender').val(jeniskelamin).trigger('change');
            $('#modal-detail #new-status').val(status).trigger('change');
            
            // Handle select2 untuk kode toko
            if(kodetoko) {
                var $storeSelect = $('#modal-detail #new-store');
                $storeSelect.empty();
                var newOption = new Option(kodetoko + ' || ' + homebase, kodetoko, true, true);
                $storeSelect.append(newOption).trigger('change');
            }
            
            // Handle select2 untuk perusahaan
            if(perusahaan) {
                var $officeSelect = $('#modal-detail #new-office');
                $officeSelect.empty();
                var newOption = new Option(md + ' - ' + brand + " - " + perusahaan, perusahaan, true, true);
                $officeSelect.append(newOption).trigger('change');
            }
            
            // Simpan ID employee di form untuk keperluan update
            $('#modal-detail #editFaktur').val(idEmployee);
        });
    </script>
@stop