    <!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user">
    <img class="app-sidebar__user-avatar" src="<?= media(); ?>/images/uploads/user.png" alt="User Image">
      <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombre'] ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombre_rol'] ?></p>
      </div>
  </div>
  <ul class="app-menu">
    <?php if(!empty($_SESSION['permisos'][1]['r'])) { ?>
      <li>
        <a class="app-menu__item" href="<?= base_url();  ?>/dashboard">
          <i class="app-menu__icon fa fa-dashboard"></i>
          <span class="app-menu__label">Dashboard</span>
        </a>
      </li>
    <?php } ?>

    <?php if(!empty($_SESSION['permisos'][2]['r']) || !empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][3]['r'])) { ?>
      <li class="treeview">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
            <span class="app-menu__label">Usuarios</span>
          <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="treeview-item" href="<?= base_url();  ?>/usuarios">
              <i class="icon fa fa-user-circle-o" aria-hidden="true"></i>
              usuarios
            </a>
          </li>
          <!--------------------------------------------------------------------------------- -->
           <?php if(!empty($_SESSION['permisos'][4]['r'])) { ?>
            <li>
              <a class="app-menu__item" href="<?= base_url();  ?>/profesores">
                <i class="app-menu__icon fas fa-user-tie" aria-hidden="true"></i>
                <span class="app-menu__label">Profesores</span>
              </a>
            </li>
          <?php } ?>
          <!-------------------------------------------------------------------------------------->
           <?php if(!empty($_SESSION['permisos'][3]['r'])) { ?>
            <li>
              <a class="app-menu__item" href="<?= base_url();  ?>/alumnos">
                <i class=" app-menu__icon fas fa-book-reader" aria-hidden="true"></i>
                <span class="app-menu__label">Alumnos</span>
              </a>
            </li>
           <?php } ?>
           <!-------------------------------------------------------------------------------------->
            <li>
              <a class="treeview-item" href="<?= base_url();  ?>/roles" target="_blank" rel="noopener">
                <i class="icon fa fa-th-large" aria-hidden="true"></i> roles
              </a>
            </li>
        </ul>
      </li>
    <?php } ?>
    <?php if(!empty($_SESSION['permisos'][10]['r'])) { ?>
      <li>
        <a class="app-menu__item" href="<?= base_url();  ?>/ProcProfesor">
          <i class="app-menu__icon fas fa-chalkboard-teacher" aria-hidden="true"></i>
          <span class="app-menu__label">Proceso Profesor</span>
        </a>
      </li>
    <?php } ?>
    <?php if(!empty($_SESSION['permisos'][5]['r'])) { ?>
      <li>
        <a class="app-menu__item" href="<?= base_url();  ?>/grados">
          <i class="app-menu__icon fas fa-signal" aria-hidden="true"></i>
          <span class="app-menu__label">Grados</span>
        </a>
      </li>
    <?php } ?>
    <?php if(!empty($_SESSION['permisos'][2]['r'])) { ?>
      <li>
        <a class="app-menu__item" href="<?= base_url();  ?>/aulas">
          <i class="app-menu__icon fas fa-door-open" aria-hidden="true"></i>
          <span class="app-menu__label">Aulas</span>
        </a>
      </li>
    <?php } ?>
    <?php if(!empty($_SESSION['permisos'][7]['r'])) { ?>
      <li>
        <a class="app-menu__item" href="<?= base_url();  ?>/materias">
          <i class="app-menu__icon fas fa-book" aria-hidden="true"></i>
          <span class="app-menu__label">Materias</span>
        </a>
      </li>
    <?php } ?>
     <?php if(!empty($_SESSION['permisos'][8]['r'])) { ?>
      <li>
        <a class="app-menu__item" href="<?= base_url();  ?>/periodos">
          <i class="app-menu__icon far fa-calendar-check" aria-hidden="true"></i>
          <span class="app-menu__label">Periodos</span>
        </a>
      </li>
    <?php } ?>
     <?php if(!empty($_SESSION['permisos'][9]['r'])) { ?>
      <li>
        <a class="app-menu__item" href="<?= base_url();  ?>/actividades">
          <i class="app-menu__icon fas fa-edit" aria-hidden="true"></i>
          <span class="app-menu__label">Actividades</span>
        </a>
      </li>
    <?php } ?>
    <li>
      <a class="app-menu__item" href="<?= base_url();  ?>/logout">  
        <i class="app-menu__icon fa fa-times" aria-hidden="true"></i>
        <span class="app-menu__label">Logout</span>
      </a>
    </li>
  </ul>
</aside>