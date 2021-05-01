<div class="modal fade" id="modalFormPerfil" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Datos</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form id="formPerfil" name="formPerfil" class="form-horizontal">
               <!-- <input type="hidden" name="idUsuario" id="idUsuario" value=""> -->
                <p class="text-primary">Todos los campos son obligatorios.</p>
                
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txtNombre">Nombres</label>
                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" value="<?= $_SESSION['userData']['nombre']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="txtUsuario">Usuario (Correo Institucional)</label>
                    <input type="text" class="form-control valid validEmail" id="txtUsuario" name="txtUsuario" value="<?= $_SESSION['userData']['usuario']; ?>" readonly disabled>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txtPassword">Password</label>
                    <input type="Password" class="form-control" id="txtPassword" name="txtPassword">
                  </div>
                   <div class="form-group col-md-6">
                    <label for="txtPassword"> Confirmar Password</label>
                    <input type="Password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm">
                  </div>
                </div>
                <div class="tile-footer">
                  <button id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;

                  <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>&nbsp;&nbsp;&nbsp;
                </div>
              </form>
      </div>
    </div>
  </div>
</div>
