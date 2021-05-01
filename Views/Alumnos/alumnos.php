<?php
  headerAdmin($data); 
  getModal('modalAlumnos',$data);
   //  dep($_SESSION['permisos']); //para restringir el menu
   // dep($_SESSION['permisosMod']); //para restringir R-W-U-D
?> 
<main class="app-content">
    <div class="app-title">
    <div>
      <h1><i class="app-menu__icon fas fa-book-reader"></i> <?= $data['page_title'];  ?>
          <?php if(!empty($_SESSION['permisosMod']['w'])){ ?>
             <button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nuevo</button>
           <?php } ?>
      </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/alumnos"><?= $data['page_title'];  ?></a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tableAlumnos">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombres</th>
                  <th>Usuario</th>
                  <th>Cedula</th>
                  <th>Direccion</th>
                  <th>Telefono</th>
                  <th>Fecha de Nac</th>
                  <th>Fecha de Registro</th>
                  <th>Rol</th>
                  <th>Status</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>1</th>
                  <th>Luis</th>
                  <th>lemo0790</th>
                  <th>Administrador</th>
                  <th>4-765-376</th>
                  <th>7-4-1990</th>
                  <th>5-9-2020</th>
                  <th>Alumno</th>
                  <th>Activo</th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php footerAdmin($data); ?>
