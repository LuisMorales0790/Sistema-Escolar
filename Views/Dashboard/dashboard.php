   <?php headerAdmin($data); ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i><?= $data['page_title'];  ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">Dashboard</div>
            <!--Variable de sesion con todos los datos del usuario -->
            <?php 
              dep($_SESSION['userData']);
               dep($_SESSION['permisos']); //para restringir el menu
               dep($_SESSION['permisosMod']); //para restringir R-W-U-D
             ?>
          </div>
        </div>
      </div>
    </main>
    <?php footerAdmin($data); ?>
    