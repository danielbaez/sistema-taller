<div class="row">
    <div class="col-12">
        <h1>
            {{ $title }}
            @rolpermission($resource.'.create')
                <button type="button" class="btn btn-primary pl-4 pr-4" data-toggle="modal" data-target="#modalCreate">
                    <i class="fas fa-plus-circle icon-c"></i> Crear
                </button>
            @endrolpermission
        </h1>
    </div>
</div>