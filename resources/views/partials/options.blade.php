@canany([$resource.'.edit', $resource.'.activate', $resource.'.destroy'])
	@php
		$aaa = false;
	@endphp
	@can($resource.'.edit')
		@php
			$aaa = true;
		@endphp
	@else
		@if($row->status == 1)
			@can($resource.'.destroy')
				@php
					$aaa = true;
				@endphp
			@endcan
		@endif
		@if($row->status == 0)
			@can($resource.'.activate')
				@php
					$aaa = true;
				@endphp
			@endcan
		@endif
	@endcan

	@if($aaa)
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
			<div class="btn-group" role="group">
				<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Opciones
				</button>
				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
					@can($resource.'.edit')
			  			<a class="dropdown-item" data-url-show="{{ route($resource.'.show', $row->id) }}" data-url-update="{{ route($resource.'.update', $row->id) }}" href="" id="edit">Editar</a>
			  		@endcan
			  		@if($row->status == 1)
			  			@can($resource.'.destroy')
			  				<a class="dropdown-item" data-status="{{ $row->status == 1 ? 0 : 1 }}" data-url-destroy="{{ route($resource.'.destroy', $row->id) }}" href="" id="activeOrDesactivate">{{ $row->status == 1 ? "Desactivar" : "Activar" }}</a>
			  			@endcan
			  		@endif
			  		@if($row->status == 0)
			  			@can($resource.'.activate')
			  				<a class="dropdown-item" data-status="{{ $row->status == 1 ? 0 : 1 }}" data-url-destroy="{{ route($resource.'.destroy', $row->id) }}" href="" id="activeOrDesactivate">{{ $row->status == 1 ? "Desactivar" : "Activar" }}</a>
			  			@endcan
			  		@endif
				</div>
			</div>
		</div>
	@endif
@endcanany