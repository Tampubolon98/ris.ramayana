{{--
|--------------------------------------------------------------------------
| Layout dasar untuk SEMUA halaman fitur
|--------------------------------------------------------------------------
|
| Cara pakai pada file fitur:
|
|   @extends('layouts.master')
|
|   @section('title', 'Nama Halaman')
|
|   @section('content_header')
|       ... isi halaman ...
|   @stop
|
|   @section('js')
|       <script>
|           ... script khusus halaman ini saja ...
|       </script>
|   @stop
|
| Yang sudah otomatis tersedia di semua halaman (TIDAK perlu ditulis ulang):
|   - Favicon
|   - jQuery + Bootstrap (bawaan AdminLTE)
|   - Plugin global: Moment, TempusDominus, DateRangePicker, InputMask,
|     Select2, DataTables, SweetAlert2, Flatpickr (lihat config/adminlte.php)
|   - Modal loading (<x-loading/>) -> showModalLoading() / hideModalLoading()
|   - Kumpulan fungsi helper (<x-script-util/>) -> dateformat_global(), dll.
|
| JANGAN menambahkan lagi <script src="https://cdn..."> atau jQuery di file
| fitur. Kalau butuh plugin tambahan, daftarkan sekali di config/adminlte.php
| bagian 'plugins'.
--}}

@extends('adminlte::page')

{{-- Favicon aplikasi --}}
@section('meta_tags')
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
@stop

{{-- Style global semua halaman fitur --}}
@push('css')
    <style>
        .nav-tabs {
            border-bottom: none !important;
        }
    </style>
@endpush

{{--
| Dimuat sebelum @yield('js') milik halaman, sehingga semua fungsi helper
| dan modal loading sudah siap dipakai oleh script halaman.
--}}
@push('js')
    <x-loading/>
    <x-script-util/>
@endpush
