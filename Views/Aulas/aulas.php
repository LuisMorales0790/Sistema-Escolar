<?php
  headerAdmin($data); 
  getModal('modalAulas',$data);
   //  dep($_SESSION['permisos']); //para restringir el menu
   // dep($_SESSION['permisosMod']); //para restringir R-W-U-D
?> 
<main class="app-content">
    <div class="app-title">
    <div>
      <h1><i class="app-menu__icon fas fa-door-open"></i> <?= $data['page_title'];  ?>
          <?php if(!empty($_SESSION['permisosMod']['w'])){ ?>
             <button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nueva Aula</button>
           <?php } ?>
      </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/aulas"><?= $data['page_title'];  ?></a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tableAulas">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre Aula</th>
                  <th>Status</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>1</th>
                  <th>primero A</th>
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
