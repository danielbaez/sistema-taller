<!-- @if(session('message'))
	<div class="row">
		<div class="col-12">
	    	<div class="alert alert-{{ session('message')[0] == 1 ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
			  {{ session('message')[1] }}
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
	    </div>
	</div>
@endif -->

<div class="row d-none" id="alert-message">
	<div class="col-12">
    	<div class="alert" role="alert">
		</div>
    </div>
</div>

@if(session('message'))
	<div class="row" id="alert-message-refresh">
		<div class="col-12">
	    	<div class="alert alert-{{ session('message')[0] == 1 ? 'success' : 'danger' }}">
			  <i class="fas fa-check icon-c"></i> {{ session('message')[1] }}
			</div>
	    </div>
	</div>
@endif