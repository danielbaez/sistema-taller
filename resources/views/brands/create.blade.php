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
@stop