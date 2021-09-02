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
					@foreach($usersAccounts as $userAccount)
						<tr>
							<th scope="row">{{ $userAccount->id }}</th>
							<td>{{ $userAccount->role->name }}</td>
							<td>{{ $userAccount->role_id == 2 ? $userAccount->branch->name : '---' }}</td>
							<td>{{ $userAccount->status }}</td>
							<td>
								@if($userAccount->status == 'Activo')
									<a href="{{ route('enterRole', ['userAccountId' => $userAccount->id]) }}" class="btn btn-primary">Ingresar</a>
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
	    	<h1>Ingresa a tu Rol de Usuario</h1> 
	    </div>
    </div>
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered table-striped table-hover bg-white d-none" id="my-table">
				<thead>
					<tr class="text-center">
						<th scope="col" data-export="true">#</th>
						<th scope="col" data-export="true">Rol</th>
						<th scope="col" data-export="true">Sucursal</th>
						<th scope="col" data-export="true">Estado</th>
						<th scope="col" data-export="false" data-orderable="false" data-searchable="false">Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					@foreach($usersAccounts as $userAccount)
						<tr>
							<th scope="row">{{ $userAccount->id }}</th>
							<td>{{ $userAccount->role->name }}</td>
							<td>{{ $userAccount->role_id == 2 ? $userAccount->branch->name : '---' }}</td>
							<td>{{ $userAccount->status_name }}</td>
							<td>
								@if($userAccount->role->status === 1 && $userAccount->is_active)
									<a href="{{ route('enterRole', ['userAccountId' => $userAccount->id]) }}" class="btn btn-primary">Ingresar</a>
								@elseif($userAccount->role->status === 0)
									Rol desactivado
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
		dataTableClientSide(null, null, 'roles', 'ROLES', 'portrait', 'A4', false, true, true, true, false, false, true);
	</script>
@stop