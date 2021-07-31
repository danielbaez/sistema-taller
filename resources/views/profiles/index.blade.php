@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    @include('partials.message')
    @include('partials.header', ['title' => $title])
@stop

{{--@include('partials.change_profile')--}}

@section('content')
    @include('profiles.create', ['form' => 'create'])
    @include('profiles.create', ['form' => 'edit'])
    @include('partials.form.activate_or_desactivate')
    @include('partials.search')
    @include('partials.table', ['url' => route('profiles.index'), 'columns' => $columns])
@stop

@section('js')
    <script type="text/javascript">
        $(function () {
            dataTableServerSide(null, null, '{{ $title }}', '{{ $title }}', 'portrait', 'A4', false, true, true, true, true, true, true);
        });
    </script>
@stop