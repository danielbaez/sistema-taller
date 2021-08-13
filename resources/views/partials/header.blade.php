@include('partials.change_role')
<div class="row">
    <div class="col-12">
        <h1>
            {{ $title }}
            @isset($resource)
                @hasallpermissions($resource.'.create')
                    <button type="button" class="btn btn-primary pl-4 pr-4" data-toggle="modal" data-target="#modalCreate" id="create">
                        <i class="fas fa-plus-circle icon-c"></i> Crear
                    </button>
                @endhasallpermissions
            @endisset
        </h1>
    </div>
</div>