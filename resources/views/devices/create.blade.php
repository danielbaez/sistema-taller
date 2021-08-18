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
    <label for="category_id">Categoría</label>
    <select class="form-control" id="category_id" name="category_id">
      <option value="">Seleccione</option>
      @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="brand_id">Marca</label>
    <select class="form-control" id="brand_id" name="brand_id">
      <option value="">Seleccione</option>
      @foreach($brands as $brand)
      <option value="{{ $brand->id }}">{{ $brand->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="model_id">Modelo</label>
    <select class="form-control" id="model_id" name="model_id">
      <option value="">Seleccione</option>
      @foreach($models as $model)
      <option value="{{ $model->id }}">{{ $model->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="serial_number">Nro Serie</label>
    <input type="text" class="form-control" id="serial_number" name="serial_number">
  </div>
@stop