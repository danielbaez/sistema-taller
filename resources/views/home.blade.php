@extends('adminlte::page')

@section('title', 'Perfiles')

@section('content_header')
    @include('partials.message')
    <div class="row">
        <div class="col-12">
            <h1>Usuarios <a href="{{-- route('profiles.create') --}}" class="btn btn-primary pl-4 pr-4">Crear</a></h1> 
        </div>
    </div>
@stop

{{--@include('partials.change_profile')--}}

@section('content')
    <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 mb-4 filters">
            <div class="row">
                <div class="col-8 text-center">
                    <input type="text" name="search" data-filter-export class="form-control search" placeholder="">    
                </div>
                <div class="col-4 text-center">
                    <button class="btn btn-success btn-block searchBtn"><i class="fas fa-search"></i> Buscar</button>
                </div>
                <br>
                <br>
            </div>
        </div>
        <div class="col-12">
            <table class="table table-bordered table-striped table-hover bg-white" id="my-table" data-url="{{ route('users.index') }}">
                <thead>
                    <tr class="text-center">
                        <th scope="col" data-data="id">#</th>
                        <th scope="col" data-data="name" data-export="{'data': 'name'}">Nombre</th>
                        <th scope="col" data-data="email">Email</th>
                        <th scope="col" data-data="action" data-export="false" data-orderable="false" data-searchable="false">Acción</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br>
@stop

@section('css')
@stop

@section('js')
    <script type="text/javascript">
        $(function () {
            //var tableId = 'my-table';

            /*var tableColumns = [
                {
                    data: 'id',
                    export: true
                },
                {
                    data: 'name',
                    export: {data: 'id'}
                    //export: true
                },
                {
                    data: 'email',
                    export: true
                },
                {
                    data: 'action',
                    export: false,
                    orderable: false,
                    searchable: false
                }
            ];*/

            //overwriteExport();
            dataTableServerSide(null, null, 'perfiles', 'PERFILES', 'portrait', 'A4', false, true, true, true);
        });
    </script>
@stop