<?php include_once __DIR__ . '/../layouts/session.php'; ?>
<?php include_once __DIR__ . '/../layouts/main.php'; ?>
<?php include_once __DIR__ . '/../layouts/app.php';
isAuth();
?>

<head>

    <title>Bienes</title>
    

    <?php include_once __DIR__ . '/../layouts/title-meta.php'; ?>


    <!-- Datatables css -->
    <link href="<?= url('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= url('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= url('assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= url('assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= url('assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= url('assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Vector Map css -->
    <link rel="stylesheet" href="<?= url('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css'); ?>">



    <?php include_once __DIR__ . '/../layouts/head-css.php'; ?>
</head>

<body>
    <div id="user-data" data-user-id="<?php echo htmlspecialchars( $_SESSION['id']); ?>"></div>
    <!-- Begin page -->
    <div class="wrapper">

        <?php include_once __DIR__ . '/../layouts/menu.php'; ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title fs-2 nombre-pagina">Bienes</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-12 col-xl-6 text-center text-xl-start mb-2 mb-xl-0">
                                    <div class="page-title-box">
                                        <h4 class="page-title fs-3 fs-md-3">Filtros</h4>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-6 text-center text-sm-end  mb-3 mb-sm-0 ">
                                    <div class="page-title-box d-flex flex-column flex-sm-row gap-1 justify-content-between justify-content-xl-end mb-2 mb-xl-0">
                                        <button class="btn btn-primary fs-6  w-100 " id="consultar">
                                            Consultar
                                        </button>
                                        <!-- <button class="btn btn-info fs-6  w-100" id="todos">
                                            Todos
                                        </button> -->
                                        <button class="btn btn-danger fs-6  w-100" id="limpiar-filtros">
                                            Limpiar Filtros
                                        </button>

                                        <button class="btn btn-warning fs-6  w-100 " id="consultarVarios">
                                            Numeros Inventario
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <form class="filtros">
                                <div class="row g-3 fs-6"> <!-- Clase 'g-3' para espacio entre columnas -->
                                    <div class="col-md-3"> <!-- Columna para el primer filtro -->
                                        <label class="form-label" for="num_inventario">Número Inventario</label>
                                        <input type="text" class="form-control fs-6 filtro" id="num_inventario" placeholder="Ejemplo: 554821" name="numero_inventario" data-campo="numero_inventario">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tipo_inventario" class="form-label">Tipo Inventario</label>
                                        <select class="form-select fs-6 filtro" id="tipo_inventario" name="tipo_inventario" data-campo="tipo_inventario">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="unam">Unam</option>
                                            <option value="fesi">Fesi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tipos" class="form-label">Tipo de Bien</label>
                                        <select class="form-select fs-6 filtro" id="tipos" data-campo="tipobien">
                                            <option value="" disabled selected>Seleccionar</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="responsables" class="form-label">Responsable</label>
                                        <select class="form-select fs-6 filtro" id="responsables" data-campo="nombre_responsable">
                                            <option value="" disabled selected>Seleccionar</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="areas" class="form-label">Area</label>
                                        <select class="form-select fs-6 filtro" id="areas" data-campo="nombre_area">
                                            <option value="" disabled selected>Seleccionar</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="edificios" class="form-label">Edificio</label>
                                        <select class="form-select fs-6 filtro" id="edificios" data-campo="nombreedif">
                                            <option value="" disabled selected>Seleccionar</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="transferido" class="form-label">Transferencia</label>
                                        <input type="text" class="form-control fs-6 filtro" id="transferido" placeholder="Ejemplo: 1" name="transferido" data-campo="transferido">
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Finalizan filtros -->

                    <?php
                    $imprimir = true;
                    require_once __DIR__ . '/../layouts/acciones.php';

                    ?>

                    <!-- Contenedor Modal -->
                    <div id="modalContainer"></div>

                    <!-- Tabla de bienes -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body table-responsive-sm">

                                    <div class="table-responsive" name="bienes" data-table="div_table">
                                        <table class="table mb-0" id="tabla">

                                        </table>
                                    </div> <!-- end table-responsive-->


                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->

                </div><!-- container -->

            </div> <!-- content -->


            <?php include_once __DIR__ . '/../layouts/footer.php'; ?>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <?php include_once __DIR__ . '/../layouts/right-sidebar.php'; ?>
    <script>
  // Cuando se hace clic en “Imprimir”...
  document.getElementById('btnImprimirBienes')
    .addEventListener('click', () => {
      // 1) Trae los datos filtrados
      const raw = sessionStorage.getItem('bienes_imprimir');
      if (!raw) {
        return alert('No hay datos para imprimir');
      }
      // 2) Pásalos a otra clave para la página de print
      sessionStorage.setItem('printData', raw);
      // 3) Abre la página de impresión en nueva pestaña
      window.open('<?= url('print.php'); ?>', '_blank');
    });
</script>
    <?php include_once __DIR__ . '/../layouts/footer-scripts.php'; ?>


    <!-- Datatables js -->
    <script src="<?= url('assets/vendor/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-buttons/js/buttons.print.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js'); ?>"></script>
    <script src="<?= url('assets/vendor/datatables.net-select/js/dataTables.select.min.js'); ?>"></script>

    <!-- App js -->
    <script src="<?= url('assets/js/app.min.js'); ?>"></script>
    <script type="module" src="<?= url('assets/js/build/bienes/bienes.js?v=2'); ?>"></script>

</body>

</html>