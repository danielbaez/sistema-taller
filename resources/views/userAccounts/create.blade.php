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
    <label for="user_id">Usuario</label>
    <select class="form-control" id="user_id" name="user_id">
      <option value="">Seleccione</option>
      @foreach($users as $user)
      <option value="{{ $user->id }}">{{ $user->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="role_id">Rol</label>
    <select class="form-control" id="role_id" name="role_id">
      <option value="">Seleccione</option>
      @foreach($roles as $rol)
      <option value="{{ $rol->id }}">{{ $rol->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group div-brand-id d-none">
    <label for="branch_id">Sucursal</label>
    <select class="form-control" id="branch_id" name="branch_id">
      <option value="">Seleccione</option>
      @foreach($branches as $branch)
      <option value="{{ $branch->id }}">{{ $branch->name }}</option>
      @endforeach
    </select>
  </div>
@stop