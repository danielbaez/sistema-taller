<div class="modal fade modal-form" id="modalEdit" data-backdrop="static" tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-{{ !empty($size) ? $size : 'md' }}" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="staticBackdropLabel">Editar {{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form @if($enctype) method="POST" enctype="multipart/form-data" @else method="PUT" @endif autocomplete="off">
          @yield('form_content')
          <div class="modal-footer">
            @yield('form_button', view('partials.form.edit_button'))
          </div>
        </form>
      </div>
    </div>
  </div>
</div>