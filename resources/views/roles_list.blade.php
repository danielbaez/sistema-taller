@extends('adminlte::page')

@section('title', '')

@section('content_header')
    @include('partials.message')
    <div class="row">
    	<div class="col-12">
	    	<h1>Ingresa con un Rol</h1> 
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
						<th scope="col" data-export="true">Rol</th>
						<!-- <th scope="col" data-export="true">Sucursal</th> -->
						<!-- <th scope="col" data-export="true">Estado</th> -->
						<th scope="col" data-export="false" data-orderable="false" data-searchable="false">Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					@foreach($user_accounts as $user_account)
						<tr>
							<th scope="row">{{ $user_account->id }}</th>
							<td>{{ $user_account->name }}</td>
							<td>
								<a href="{{ route('enterRol', ['user_account_id' => $user_account->id]) }}" class="btn btn-primary">Ingresar</a>
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