@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    @include('partials.message')
    @include('partials.header', ['title' => 'Dashboard'])
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop