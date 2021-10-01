@extends('errors::illustrated-layout')

@section('code', '404')
@section('title', __('Página no encontrada.'))

@section('image')
    @include('errors.imagen')
@endsection

@section('message', __('No hemos encontrado la página que buscas.'))