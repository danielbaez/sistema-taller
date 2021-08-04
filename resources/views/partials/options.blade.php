@rolpermissionany([$resource.'.edit', $resource.'.activate', $resource.'.destroy'])
	@php
		$show_options = false;
	@endphp
	@rolpermission($resource.'.edit')
		@php
			$show_options = true;
		@endphp
	@else
		@if($row->status === 1)
			@rolpermission($resource.'.destroy')
				@php
					$show_options = true;
				@endphp
			@endrolpermission
		@endif
		@if($row->status === 0)
			@rolpermission($resource.'.activate')
				@php
					$show_options = true;
				@endphp
			@endrolpermission
		@endif
	@endrolpermission

	@if($show_options)
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
			<div class="btn-group" role="group">
				<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Opciones
				</button>
				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
					@rolpermission($resource.'.edit')
			  			<a class="dropdown-item" data-url-show="{{ route($resource.'.show', $row->id) }}" data-url-update="{{ route($resource.'.update', $row->id) }}" href="" id="edit">Editar</a>
			  		@endrolpermission
			  		@if($row->status === 1)
			  			@rolpermission($resource.'.destroy')
			  				<a class="dropdown-item" data-status="{{ $row->status === 1 ? 0 : 1 }}" data-url-destroy="{{ route($resource.'.destroy', $row->id) }}" href="" id="activeOrDesactivate">{{ $row->status === 1 ? "Desactivar" : "Activar" }}</a>
			  			@endrolpermission
			  		@endif
			  		@if($row->status === 0)
			  			@rolpermission($resource.'.activate')
			  				<a class="dropdown-item" data-status="{{ $row->status === 1 ? 0 : 1 }}" data-url-destroy="{{ route($resource.'.destroy', $row->id) }}" href="" id="activeOrDesactivate">{{ $row->status === 1 ? "Desactivar" : "Activar" }}</a>
			  			@endrolpermission
			  		@endif
				</div>
			</div>
		</div>
	@endif
@endrolpermissionany