@php

if($form == 'create')
{
  $view = 'partials.form.create';
  $params = ['title' => $title, 'action' => route($resource.'.store')];
}
if($form == 'edit')
{
  $view = 'partials.form.edit';
  $params = ['title' => $title];
}

@endphp

@extends($view, $params)

@section('form_content')
  <div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <div class="form-group">
    <label for="status">Permisos</label>
    <br>
    @foreach($permissions as $permission)
      <!-- <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="permissions[]" id="{{ $permission->name }}" value="{{ $permission->id }}">
        <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->description }}</label>
      </div> -->
    @endforeach
    <div class="row">
        @foreach($permissions as $permission)
          <div class="col-6 col-sm-4 mb-1">
            <div class="form-check form-check-inline h-100">
              <input class="form-check-input" type="checkbox" name="permissions[]" id="{{ $permission->name }}" value="{{ $permission->id }}">
              <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->description }}</label>
            </div>
          </div>
        @endforeach
    </div>
  </div>
@stop