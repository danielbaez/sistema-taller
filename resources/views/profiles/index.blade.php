@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    @include('partials.message')
    @include('partials.header', ['title' => $title, 'resource' => $resource])
@stop

@section('content')
    @rolpermission($resource.'.index')
        @include('partials.search')
        @include('partials.table', ['url' => route($resource.'.index'), 'columns' => $columns])
    @endrolpermission
    @rolpermission($resource.'.create')
        @include($resource.'.create', ['form' => 'create', 'resource' => $resource, 'title' => $title_form])
    @endrolpermission
    @rolpermission($resource.'.index')
        @rolpermission($resource.'.edit')
            @include($resource.'.create', ['form' => 'edit', 'title' => $title_form])
        @endrolpermission
        @rolpermissionany([$resource.'.activate', $resource.'.destroy'])
            @include('partials.form.activate_or_desactivate', ['title' => $title_form])
        @endrolpermissionany
    @endrolpermission
@stop

@section('js')
    <script type="text/javascript">
        $(function () {
            dataTableServerSide(null, null, '{{ $title }}', '{{ $title }}', 'portrait', 'A4', false, true, true, true, true, true, true);
        });
    </script>
@stop