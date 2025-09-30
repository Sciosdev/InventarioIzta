<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">
  <!-- Brand Logo Light -->
  <a href="<?= url('dashboard.php'); ?>" class="logo logo-light">
    <span class="logo-lg">
      <img src="<?= url('assets/images/logo-unam-dorado.png'); ?>" alt="logo" style="height: 100px !important;" />
    </span>
    <span class="logo-sm">
      <img src="<?= url('assets/images/logo-unamDC.png'); ?>" alt="small logo" />
    </span>
  </a>

  <!-- Brand Logo Dark -->
  <a href="<?= url('dashboard.php'); ?>" class="logo logo-dark">
    <span class="logo-lg">
      <img src="<?= url('assets/images/logo-unam-dorado.png'); ?>" alt="dark logo" style="height: 100px !important;" />
    </span>
    <span class="logo-sm">
      <img src="<?= url('assets/images/logo-unamDC.png'); ?>" alt="small logo" />
    </span>
  </a>

  <!-- Sidebar Hover Menu Toggle Button -->
 
  <!-- Full Sidebar Menu Close Button -->
  <div class="button-close-fullsidebar">
    <i class="ri-close-fill align-middle"></i>
  </div>

  <!-- Sidebar -left -->
  <div class="h-100" id="leftside-menu-container" data-simplebar>


    <!-- Sidemenu -->
    <ul class="side-nav">
      <li class="side-nav-item">
        <a href="<?= url('dashboard.php'); ?>" class="side-nav-link">
          <i class="ri-home-4-line fs-5"></i>
          <span> Inicio </span>
        </a>
      </li>

      <li class="side-nav-title">Tablas</li>

      <li class="side-nav-item">
        <a href="<?= url('tablas/bienes.php'); ?>" class="side-nav-link">
          <i class="ri-archive-line fs-5"></i>
          <span> Bienes </span>
        </a>
      </li>

      <?php if (isAdmin()) { ?>

        <li class="side-nav-item">
          <a href="<?= url('tablas/tipos.php'); ?>" class="side-nav-link">
            <i class="ri-layout-grid-line fs-5"></i>
            <span> Tipos de Bien </span>
          </a>
        </li>
        <li class="side-nav-item">
          <a href="<?= url('tablas/edificios.php'); ?>" class="side-nav-link">
            <i class="ri-building-4-line fs-5"></i>
            <span> Edificios </span>
          </a>
        </li>
        <li class="side-nav-item">
          <a href="<?= url('tablas/areas.php'); ?>" class="side-nav-link">
            <i class="ri-map-pin-line fs-5"></i>
            <span> Unidades </span>
          </a>
        </li>
        <li class="side-nav-item">
          <a href="<?= url('tablas/responsables.php'); ?>" class="side-nav-link">
            <i class="ri-file-user-line fs-5"></i>
            <span> Responsables </span>
          </a>
        </li>
        <li class="side-nav-item">
          <a href="<?= url('tablas/usuarios.php'); ?>" class="side-nav-link">
            <i class="ri-shield-user-line fs-5"></i>
            <span> Usuarios </span>
          </a>
        </li>
      <?php } ?>
    </ul>
    <!--- End Sidemenu -->

    <div class="clearfix"></div>
  </div>
</div>
<!-- ========== Left Sidebar End ========== -->