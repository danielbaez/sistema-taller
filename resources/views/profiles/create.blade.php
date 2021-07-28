<div class="modal fade" id="modalCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Crear Perfil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="form" action="{{ route('profiles.store') }}">
          <div class="form-group">
            <label for="name">Perfil</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="">
          </div>
          <div class="form-group">
            <label for="status">Estado</label>
            <br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" id="activo" value="1">
              <label class="form-check-label" for="activo">Activo</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" id="inactivo" value="0">
              <label class="form-check-label" for="inactivo">Inactivo</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-submit-create btn-primary m-auto pl-5 pr-5">Crear</button>
          </div>
        </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Crear</button>
      </div> -->
    </div>
  </div>
</div>