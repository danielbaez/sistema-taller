<div class="modal fade modal-form" id="modalActiveOrDesactivate" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><span class="text-status"></span> {{ $title_form }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="DELETE">
          <p class="text-center">¿Está seguro que desea <span class="text-status"></span>?</p>
          <input type="hidden" name="status">
          <div class="modal-footer">
            <button type="submit" class="btn btn-submit-status btn-primary m-auto pl-5 pr-5"></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>