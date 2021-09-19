<div class="modal fade modal-form" id="modalCreate" data-backdrop="static" tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-{{ !empty($size) ? $size : 'md' }}" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="staticBackdropLabel">Crear {{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ $action }}" @if($enctype) enctype="multipart/form-data" @endif autocomplete="off">
          @yield('form_content')
          <div class="modal-footer">
            @yield('form_button', view('partials.form.create_button'))
          </div>
        </form>
      </div>
    </div>
  </div>
</div>