@extends('adminlte::page')

@section('title', 'Master Employee')

@section('content_header')
    <h1>Master Employee</h1>
@stop

@section('content')
    <p>Halaman utama untuk menampilkan ui master employee</p>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop