@extends('layouts.master')

@section('title', 'Master Employee')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-red card-tabs">
                    <div class="card-header p-0 pt-2 pb-2">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="card-title" style="color: white">&nbsp; Master Brand</li>
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
                                                <th class="text-center" style="background-color:#dc3545; color: white;">MD Code</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Brand</th>
                                                <th class="text-center" style="background-color:#dc3545; color: white;">Supplier Name</th>
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
                    <h3 class="modal-title" id="modal-title">Tambah Master Brand</h3>
                </div>
                <form action="{{ route('/master-brand.tambah') }}" id="modal-form" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" id="edit-faktur" name="edit-faktur">

                        <div class="form-group">
                            <label for="" data-required="true">MD Code</label>
                            <input type="text" class="form-control form-control-sm" id="new-md" name="new-md">
                        </div>

                        <div class="form-group">
                            <label for="" data-required="true">Brand</label>
                            <input type="text" class="form-control form-control-sm" id="new-brand" name="new-brand">
                        </div>

                        <div class="form-group">
                            <label for="" data-required="true">Supplier Name</label>
                            <input type="text" class="form-control form-control-sm" id="new-supplier" name="new-supplier">
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

    {{-- Modal Edit --}}
    <div class="modal fade" id="modal-edit" data-mode="edit" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title">Edit Master Brand</h3>
                </div>
                <form id="modalForm" class="form-horizontal" method="post" action="{{ route('/master-brand.edit') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" id="idbrand" name="editIDBrand">
                    
                        <div class="form-group">
                            <label class="required" data-required="true">MD Code</label>
                            <input type="text" class="form-control form-control-sm" id="editMD" name="editMD">
                        </div>

                        <div class="form-group">
                            <label class="required" data-required="true">Brand</label>
                            <input type="text" class="form-control form-control-sm" id="editBrand" name="editBrand">
                        </div>

                        <div class="form-group">
                            <label class="required" data-required="true">Supplier Name</label>
                            <input type="text" class="form-control form-control-sm" id="editSupplier" name="editSupplier">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn-sm btn-danger" data-dismiss="modal" onclick="resetPage()"><i class="fa fa-times"></i>&nbsp; Batal</button>
                    <button type="button" class="btn-sm btn-primary" onclick="editData()" id="submitadd"><i class="fas fa-save"></i>&nbsp; Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END --}}

    {{-- Modal Detail --}}
    <div class="modal inmodal bd-example-modal-lg" id="modal-detail" data-mode="detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight" style="max-height: calc(100vh - 100px); overflow-y: auto;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title">Detail Master Brand</h3>
                        <button type="button" id="close_modal" class="close float-right" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="hidden" id="idbrand" name="editIDBrand">
                        
                            <div class="form-group">
                                <label class="required" data-required="true">MD Code</label>
                                <input type="text" class="form-control form-control-sm" id="dtlMD" name="dtlMD" disabled>
                            </div>

                            <div class="form-group">
                                <label class="required" data-required="true">Brand</label>
                                <input type="text" class="form-control form-control-sm" id="dtlBrand" name="dtlBrand" disabled>
                            </div>

                            <div class="form-group">
                                <label class="required" data-required="true">Supplier Name</label>
                                <input type="text" class="form-control form-control-sm" id="dtlSupplier" name="dtlSupplier" disabled>
                            </div>
                        </div>
                    </div>
                </div>
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
                url: "{{ route('/master-brand.get-data') }}",
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
                                data: 'md',
                                name: 'a.md',
                                className: 'text-left'
                            },
                            {
                                data: 'detail_brand',
                                name: 'a.detail_brand',
                                className: 'text-left',
                                width: '200px'
                            },
                            {
                                data: 'nama_supplier',
                                name: 'a.nama_supplier',
                                className: 'text-left'
                            },
                            {
                                data: 'md',
                                name: 'a.md',
                                className: 'text-center',
                                width: '200px',
                                render: function(data, type, row) {
                                    return `
                                        <center>
                                            <div class="d-grid gap-2 d-md-flex justify-content-center">
                                                <span data-toggle="tooltip" title="Edit Data" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary mr-2 edit" 
                                                    data-target="#modal-edit" data-toggle="modal"
                                                    data-idbrand="${row.id_brand_emp}"
                                                    data-md="${row.md}"
                                                    data-brand="${row.detail_brand}"
                                                    data-supplier="${row.nama_supplier}">
                                                    <i class="fas fa-edit"></i>&nbsp Edit
                                                    </a>
                                                </span>

                                                <span title="Detail Data" data-toggle="tooltip" data-placement="bottom">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-info mr-2 detail" data-target="#modal-detail" data-toggle="modal"
                                                    data-md="${row.md}"
                                                    data-brand="${row.detail_brand}"
                                                    data-supplier="${row.nama_supplier}">
                                                        <i class="fas fa-eye"></i>&nbsp View
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
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Failed!',
                        text: 'Gagal mendapatkan data',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        $(document).ready(function() {
            getData();
            
            // Kode validasi form yang sudah ada
            $('#form-add').on('submit', function(e) {
                e.preventDefault();
            });
        });

        function resetPage() {
            document.querySelector('#modal-upload form').reset();
        }

        function addData() {
            // Ambil semua input
            const md = $('#new-md').val();
            const brand = $('#new-brand').val();
            const supplier = $('#new-supplier').val();

            if (!md || !brand || !supplier) {
                Swal.fire({
                    title: 'Error',
                    text: 'Semua field wajib diisi.',
                    icon: 'warning'
                });
                return;
            }

            let formData = new FormData();
            formData.append('md', md);
            formData.append('brand', brand);
            formData.append('supplier', supplier);

            $.ajax({
                url: "{{ route('/master-brand.tambah') }}",
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

        function editData() {
            // Ambil semua input
            const idbrand = $('#modal-edit #idbrand').val();
            const md = $('#modal-edit #editMD').val();
            const brand = $('#modal-edit #editBrand').val();
            const supplier = $('#modal-edit #editSupplier').val();

            // Validasi data
            if (!md || !brand || !supplier) {
                Swal.fire({
                    title: 'Error',
                    text: 'Semua field wajib diisi.',
                    icon: 'warning'
                });
                return;
            }

            // Buat objek data yang akan dikirim
            const data = {
                idbrand: idbrand,
                md: md,
                brand: brand,
                supplier: supplier,
                _token: "{{ csrf_token() }}"
            };

            $.ajax({
                url: "{{ route('/master-brand.edit') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Data berhasil diperbarui',
                            icon: 'success'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'Gagal memperbarui data',
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

        $(document).on('click', 'a.edit', function() {
            // Ambil data dari atribut data
            let md = $(this).data('md');
            let brand = $(this).data('brand');
            let supplier = $(this).data('supplier');
            let idbrand = $(this).data('idbrand');

            // Buka modal edit
            $('#modal-edit').modal('show');
            
            // Set nilai form
            $('#modal-edit #idbrand').val(idbrand);
            $('#modal-edit #editMD').val(md);
            $('#modal-edit #editBrand').val(brand);
            $('#modal-edit #editSupplier').val(supplier);

            
            // Simpan ID employee di form untuk keperluan update
            $('#modal-edit #editIDBrand').val(idbrand);
        });

        $(document).on('click', 'a.detail', function() {
            // Ambil data dari atribut data
            let idbrand = $(this).data('idbrand');
            let md = $(this).data('md');
            let brand = $(this).data('brand');
            let supplier = $(this).data('supplier');

            // Buka modal detail
            $('#modal-detail').modal('show');
            
            // Set nilai form
            $('#modal-detail #idbrand').val(idbrand);
            $('#modal-detail #dtlMD').val(md);
            $('#modal-detail #dtlBrand').val(brand);
            $('#modal-detail #dtlSupplier').val(supplier);
            
            // Simpan ID employee di form untuk keperluan update
            $('#modal-detail #editIDBrand').val(idbrand);
        });
    </script>
@stop