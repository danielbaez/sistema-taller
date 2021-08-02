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
    <label for="status">Roles</label>
    <br>
    @foreach($roles as $rol)
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="roles[]" id="{{ $rol->name }}" value="{{ $rol->id }}">
        <label class="form-check-label" for="{{ $rol->name }}">{{ $rol->name }}</label>
      </div>
    @endforeach
  </div>
@stop