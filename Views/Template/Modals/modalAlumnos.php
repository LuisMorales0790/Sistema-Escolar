<!-- Modal -->
<div class="modal fade" id="modalFormAlumno" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Alumno</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form id="formAlumno" name="formAlumno" class="form-horizontal">
                <input type="hidden" name="idAlumno" id="idAlumno" value="">
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
                    <label for="txtCedula">Cedula</label>
                    <input type="text" class="form-control valid" id="txtCedula" name="txtCedula">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="txtDireccion">Direccion</label>
                    <input type="text" class="form-control" id="txtDireccion" name="txtDireccion">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="txtTelefono">Telefono</label>
                    <input type="text" class="form-control valid" id="txtTelefono" name="txtTelefono">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="txtFechaReg">Fecha de Registro</label>
                    <input type="date" class="form-control" id="txtFechaReg" name="txtFechaReg">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="txtFechaNac">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="txtFechaNac" name="txtFechaNac">
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
<div class="modal fade" id="modalViewAlumno" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Alumno</h5>
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
                <td>Cedula:</td>
                <td id="celCedula"></td>
              </tr>
               <tr>
                <td>Direccion:</td>
                <td id="celDireccion"></td>
              </tr>
              <tr>
                <td>Telefono:</td>
                <td id="celTelefono"></td>
              </tr>
              <tr>
                <td>Fecha de Registro:</td>
                <td id="celFechaReg"></td>
              </tr>
              <tr>
                <td>Fecha de Nacimiento:</td>
                <td id="celFechaNac"></td>
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