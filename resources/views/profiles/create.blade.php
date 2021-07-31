@php

if($form == 'create')
{
  $view = 'partials.form.create';
  $params = ['resource' => 'Perfil', 'action' => route('profiles.store')];
}
if($form == 'edit')
{
  $view = 'partials.form.edit';
  $params = ['resource' => 'Perfil'];
}

@endphp

@extends($view, $params)

@section('form_content')
  <div class="form-group">
    <label for="name">Perfil</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
@stop