@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    @include('partials.message')
    <div class="row">
    	<div class="col-12">
	    	<h1>Dashboard</h1> 
	    </div>
    </div>
@stop

@include('partials.change_profile')

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop