<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
	<div class="btn-group" role="group">
		<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  Opciones
		</button>
		<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
	  		<a class="dropdown-item" data-url-show="{{ route($resource.'.show', $row->id) }}" data-url-update="{{ route($resource.'.update', $row->id) }}" href="" id="edit">Editar</a>
	  		<a class="dropdown-item" data-status="{{ $row->status == 1 ? 0 : 1 }}" data-url-destroy="{{ route($resource.'.destroy', $row->id) }}" href="" id="activeOrDesactivate">{{ $row->status == 1 ? "Desactivar" : "Activar" }}</a>
		</div>
	</div>
</div>