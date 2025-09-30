<?php include_once __DIR__ . '/../layouts/session.php'; ?>
<?php include_once __DIR__ . '/../layouts/main.php'; ?>
<?php include_once __DIR__ . '/../layouts/app.php';
isAuth();
redirectIfNotAdmin();  ?>

<head>

    <title>Tipos Bien</title>
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
    <!-- Begin page -->
    <div class="wrapper">
        <div id="user-data" data-user-id="<?php echo htmlspecialchars($_SESSION['id']); ?>"></div>

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
                                <h4 class="page-title fs-2 nombre-pagina">Tipos Bien</h4>
                            </div>
                        </div>
                    </div>

                    <?php
                    $imprimir = false;
                    $consultarTodos = true;
                    require_once __DIR__ . '/../layouts/acciones.php';
                    ?>

                    <!-- Contenedor Modal -->
                    <div id="modalContainer"></div>

                    <!-- Tabla de bienes -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body table-responsive-sm" ">

                                    <div class=" table-responsive" name="tipos" data-table="div_table">
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
    <script type="module" src="<?= url('assets/js/build/tablas/tablas.js'); ?>"></script>
</body>

</html>