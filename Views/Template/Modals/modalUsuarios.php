<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form id="formUsuario" name="formUsuario" class="form-horizontal">
                <input type="hidden" name="idUsuario" id="idUsuario" value="">
                <p class="text-primary">Todos los campos son obligatorios.</p>
                
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txtNombre">Nombres</label>
                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txtUsuario">Usuario (Correo Institucional)</label>
                    <input type="text" class="form-control valid validEmail" id="txtUsuario" name="txtUsuario">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="txtPassword">Password</label>
                    <input type="Password" class="form-control" id="txtPassword" name="txtPassword">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="listRolid">Tipo usuario</label>
                    <select class="form-control" data-live-search="true" id="listRolid" name="listRolid">

                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="listStatus">Status</label>
                    <select class="form-control selectpicker" id="listStatus" name="listStatus">
                      <option value="1">Activo</option>
                      <option value="2">Inactivo</option>
                    </select>
                  </div>
                </div>

                <div class="tile-footer">
                  <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;

                  <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>&nbsp;&nbsp;&nbsp;
                </div>
              </form>
      </div>
    </div>
  </div>
</div>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>Nombres:</td>
                <td id="celNombre"></td>
              </tr>
              <tr>
                <td>Usuario:</td>
                <td id="celUsuario"></td>
              </tr>
              <tr>
                <td>Tipo Usuario:</td>
                <td id="celTipoUsuario"></td>
              </tr>
              <tr>
                <td>Estado:</td>
                <td id="celEstado"></td>
              </tr>
            </tbody>
          </table>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>