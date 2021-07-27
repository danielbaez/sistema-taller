@if(session('message'))
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
@endif