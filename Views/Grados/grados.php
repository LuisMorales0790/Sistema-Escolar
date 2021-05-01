<?php
  headerAdmin($data); 
  getModal('modalGrados',$data);
   //  dep($_SESSION['permisos']); //para restringir el menu
   // dep($_SESSION['permisosMod']); //para restringir R-W-U-D
?> 
<main class="app-content">
    <div class="app-title">
    <div>
      <h1><i class="app-menu__icon fas fa-signal"></i> <?= $data['page_title'];  ?>
          <?php if(!empty($_SESSION['permisosMod']['w'])){ ?>
             <button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nuevo Grado</button>
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
            <table class="table table-hover table-bordered" id="tableGrados">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre Grado</th>
                  <th>Status</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>1</th>
                  <th>primero</th>
                  <th>activo</th>
                  <th></th>
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
