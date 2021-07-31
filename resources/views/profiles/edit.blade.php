@extends('partials.form.edit', ['resource' => 'Perfil'])

@section('form_content')
  <div class="form-group">
    <label for="name">Perfil</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
@stop