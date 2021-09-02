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
    <label for="name">Nombres y Apellidos</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <div class="form-group">
    <label for="document_id">Documento</label>
    <select class="form-control" id="document_id" name="document_id">
      <option value="">Seleccione</option>
      @foreach($documents as $document)
      <option value="{{ $document->id }}">{{ $document->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="document_number">Nro Documento</label>
    <input type="text" class="form-control" id="document_number" name="document_number">
  </div>
  <div class="form-group d-none div-company-id">
    <label for="company_name">Razón Social</label>
    <input type="text" class="form-control" id="company_name" name="company_name">
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
    <label for="phone">Email</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>
@stop