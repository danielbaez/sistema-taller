<!-- <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
	<div class="btn-group" role="group">
		<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  Opciones
		</button>
		<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
	  		<a class="dropdown-item" href="{{-- route($resource.'.edit', $row->id) --}}">Editar</a>
		  		{!! Form::open(['route' => [$resource.'.index', $row], 'style' => 'display:inline']) !!}
			        <input type="hidden" name="_method" value="DELETE">
			        <input type="hidden" name="status" value="{{ $row->status == 1 ? 0 : 1 }}">
			        <button onClick="return confirm('Está seguro que desea {{ $row->status == 1 ? "desactivar" : "activar" }} este registro?')" class="dropdown-item">
			            {{ $row->status == 1 ? "Desactivar" : "Activar" }}
			        </button>
	  			{!! Form::close() !!}
		</div>
	</div>
</div> -->

<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
	<div class="btn-group" role="group">
		<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  Opciones
		</button>
		<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
	  		<a class="dropdown-item" href="{{-- route($resource.'.edit', $row->id) --}}" data-toggle="modal" data-target="#modalEdit">Editar</a>
		</div>
	</div>
</div>