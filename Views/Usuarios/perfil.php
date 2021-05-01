<?php
   headerAdmin($data);
    getModal('modalPerfil',$data);
  ?>
  <main class="app-content">
      <div class="row user">
        <div class="col-md-12">
          <div class="profile">
            <div class="info"><img class="user-img" src="<?= media();?>/images/uploads/io.png">
              <?php 
                 dep($_SESSION['userData']); //variables de
               ?>
              <h4><?= $_SESSION['userData']['nombre']; ?></h4>
              <p><?= $_SESSION['userData']['nombre_rol']; ?></p>
            </div>
            <div class="cover-image"></div>
          </div>
        </div>
      <!--  <div class="col-md-3">
          <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
              <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Datos personales</a></li>
              <li class="nav-item"><a class="nav-link" href="#user-settings" data-toggle="tab">Datos fiscales</a></li>
              <li class="nav-item"><a class="nav-link" href="#datos" data-toggle="tab">Pagos</a></li>
            </ul>
          </div>
        </div> -->
        <div class="col-md-12">
          <div class="tab-content">
            <div class="tab-pane active" id="user-timeline">
              <div class="timeline-post">
                <div class="post-media">
                  <div class="content">
                    <h5>DATOS PERSONALES <button class="btn btn-sm btn-info" type="button" onclick="openModalPerfil();"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button></h5>
                  </div>
                </div>
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Nombres:</td>
                      <td><?= $_SESSION['userData']['nombre']; ?></td>
                    </tr>
                    <tr>
                      <td>Usuario:</td>
                      <td><?= $_SESSION['userData']['usuario']; ?></td>
                    </tr>
                    <tr>
                      <td>Tipo de usuario:</td>
                      <td><?= $_SESSION['userData']['nombre_rol']; ?></td>
                    </tr>
                    <tr>
                      <td>Estado:</td>
                      <?php 
                         $estado = $_SESSION['userData']['estado'] == 1 ? 
                         '<span class="badge badge-success">Activo</span>' :
                         '<span class="badge badge-danger">Inactivo</span>';
                       ?>
                      <td><?= $estado; ?></td>
                    </tr> 
                  </tbody>
                </table>
                </div>
            </div>
            <div class="tab-pane fade" id="datos">
              <div class="title user-settings">
                <p>Pagos</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php footerAdmin($data); ?>