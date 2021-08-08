@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    @include('partials.message')
    @include('partials.header', ['title' => $title, 'resource' => $resource])
@stop

@section('content')
    @hasallpermissions($resource.'.index')
        @include('partials.search')
        @include('partials.table', ['url' => route($resource.'.index'), 'columns' => $columns])
    @endhasallpermissions
    @hasallpermissions($resource.'.create')
        @include($resource.'.create', ['form' => 'create', 'resource' => $resource, 'title' => $title_form])
    @endhasallpermissions
    @hasallpermissions($resource.'.index')
        @hasallpermissions($resource.'.edit')
            @include($resource.'.create', ['form' => 'edit', 'title' => $title_form])
        @endhasallpermissions
        @hasanypermission([$resource.'.activate', $resource.'.destroy'])
            @include('partials.form.activate_or_desactivate', ['title' => $title_form])
        @endhasanypermission
    @endhasallpermissions
@stop

@section('js')
    <script type="text/javascript">
        $(function () {
            dataTableServerSide(null, null, '{{ $title }}', '{{ $title }}', 'portrait', 'A4', false, true, true, true, true, true, true);
        });
    </script>
@stop