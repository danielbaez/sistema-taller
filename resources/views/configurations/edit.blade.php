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
    <label for="company">Empresa</label>
    <input type="text" class="form-control" id="company" name="company">
  </div>
  <div class="form-group">
    <label for="document_number">RUC</label>
    <input type="text" class="form-control" id="document_number" name="document_number">
  </div>
  <div class="form-group">
    <label for="address">Dirección</label>
    <input type="text" class="form-control" id="address" name="address">
  </div>
  <div class="form-group">
    <label for="phone">Teléfono</label>
    <input type="text" class="form-control" id="phone" name="phone">
  </div>
  <div class="form-group">
    <label for="logo">Logo</label>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="logo" name="logo">
      <label class="custom-file-label" for="logo">Elegir archivo</label>
    </div>
  </div>
@stop