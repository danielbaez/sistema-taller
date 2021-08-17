@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    @include('partials.message')
    @include('partials.header', ['title' => $title, 'resource' => $resource])
@stop

@section('content')
    @hasallpermissions($resource.'.index')
        @include('partials.table', ['url' => route($resource.'.index'), 'columns' => $columns])
        @include('partials.form.image')
    @endhasallpermissions
    @hasallpermissions($resource.'.index')
        @hasallpermissions($resource.'.edit')
            @include($resource.'.edit', ['form' => 'edit', 'title' => $titleForm, 'enctype' => true])
        @endhasallpermissions
        @hasanypermission([$resource.'.activate', $resource.'.destroy'])
            @include('partials.form.activate_or_desactivate', ['title' => $titleForm])
        @endhasanypermission
    @endhasallpermissions
@stop

@section('css')
    <style>
        .custom-file-input ~ .custom-file-label::after {
            content: "Elegir";
        }
    </style>
@stop

@section('js')
    <script type="text/javascript">
        $(function () {
            dataTableServerSide(null, null, '{{ $title }}', '{{ $title }}', 'portrait', 'A4', false, true, true, true, true, false, true);
        });
    </script>
@stop