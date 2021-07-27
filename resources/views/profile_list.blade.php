{{-- @extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12">
			<h3>INGRESA A TU PERFIL DE USUARIO</h3>
		</div>
		<div class="col-12">
			<table class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th scope="col">#</th>
						<th scope="col">Perfil</th>
						<th scope="col">Sucursal</th>
						<th scope="col">Estado</th>
						<th scope="col">Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					@foreach($user_accounts as $user_account)
						<tr>
							<th scope="row">{{ $user_account->id }}</th>
							<td>{{ $user_account->profile->name }}</td>
							<td>{{ $user_account->profile_id == 2 ? $user_account->branch->name : '---' }}</td>
							<td>{{ $user_account->status }}</td>
							<td>
								@if($user_account->status == 'Activo')
									<a href="{{ route('enterProfile', ['user_account_id' => $user_account->id]) }}" class="btn btn-primary">Ingresar</a>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
 --}}

@extends('adminlte::page')

@section('title', '')

@section('content_header')
    @include('partials.message')
    <div class="row">
    	<div class="col-12">
	    	<h1>Ingresa a tu Perfil de Usuario</h1> 
	    </div>
    </div>
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered table-striped table-hover bg-white" id="my-table">
				<thead>
					<tr class="text-center">
						<th scope="col" data-export="true">#</th>
						<th scope="col" data-export="true">Perfil</th>
						<th scope="col" data-export="true">Sucursal</th>
						<th scope="col" data-export="true">Estado</th>
						<th scope="col" data-export="false" data-orderable="false" data-searchable="false">Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					@foreach($user_accounts as $user_account)
						<tr>
							<th scope="row">{{ $user_account->id }}</th>
							<td>{{ $user_account->profile->name }}</td>
							<td>{{ $user_account->profile_id == 2 ? $user_account->branch->name : '---' }}</td>
							<td>{{ $user_account->status_name }}</td>
							<td>
								@if($user_account->profile->status == 1 && $user_account->is_active)
									<a href="{{ route('enterProfile', ['user_account_id' => $user_account->id]) }}" class="btn btn-primary">Ingresar</a>
								@else
									Perfil desactivado
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('js')
	<script>
		/*$('#my-table').DataTable({
		    responsive: true
		});*/
		dataTableClientSide(null, null, 'perfiles', 'PERFILES', 'portrait', 'A4', false, true, true, true, false, false, true);
	</script>
@stop