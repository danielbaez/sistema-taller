@extends('errors::illustrated-layout')

@section('code', '403')
@section('title', __('Página no autorizada.'))

@section('image')
    @include('errors.imagen')
@endsection

@section('message', __('No está autorizado para realizar esta acción.'))