<?php include_once __DIR__ . '/layouts/session.php'; ?>
<?php include_once __DIR__ . '/layouts/main.php'; ?>
<?php include_once __DIR__ . '/layouts/app.php';
isAuth(); ?>

<head>

    <title>Inicio</title>
    <?php include 'layouts/title-meta.php'; ?>

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="assets/vendor/daterangepicker/daterangepicker.css">

    <!-- Datatables css -->
    <link href="/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- Vector Map css -->
    <link rel="stylesheet" href="/assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">


    <?php include 'layouts/head-css.php'; ?>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <?php include 'layouts/menu.php'; ?>

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
                                <div class="page-title-right">
                                    <form class="d-flex">
                                        <div class="input-group">
                                            <input type="text" class="form-control shadow border-0" id="dash-daterange">
                                            <span class="input-group-text bg-primary border-primary text-white">
                                                <i class="ri-calendar-todo-fill fs-13"></i>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                <h4 class="page-title fs-2 nombre-pagina">Inicio</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de bienes -->
                    <div class="row">
                        <div class="col-12 card">
                            <div class="card-body">
                                <h4 class="header-title">Bienes</h4>
                                <div class="table-responsive" name="bienes" data-table="div_table">
                                    <table class="table mb-0">

                                    </table>
                                </div> <!-- end table-responsive-->

                                <div class="d-flex justify-content-end justify-content-lg-center mt-3">

                                    <a href="/tablas/bienes.php" class="btn btn-primary">Ver mas <i class="ri-arrow-right-line"></i></a>

                                </div>

                            </div> <!-- end card body-->
                            <!-- end card -->
                        </div><!-- end col-->
                    </div>
                    <!-- end row-->



                    <?php if (isAdmin()) { ?>
                        <!-- Todas las demas tablas -->
                        <div class="row">
                            <div class="col-xl-6 ">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Tipos de Bien</h4>
                                        <div class="table-responsive-sm" name="tipos" data-table="div_table">

                                            <table class="table mb-0">
                                            </table>

                                        </div> <!-- end table-responsive-->

                                        <div class="d-flex justify-content-end justify-content-lg-center mt-3">

                                            <a href="/tablas/tipos.php" class="btn btn-primary">Ver mas <i class="ri-arrow-right-line"></i></a>

                                        </div>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                            <div class="col-xl-6 ">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Edificios</h4>
                                        <div class="table-responsive-sm" name="edificios" data-table="div_table">
                                            <table class="table mb-0">
                                            </table>
                                        </div> <!-- end table-responsive-->

                                        <div class="d-flex justify-content-end justify-content-lg-center mt-3">

                                            <a href="/tablas/edificios.php" class="btn btn-primary">Ver mas <i class="ri-arrow-right-line"></i></a>

                                        </div>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                            <div class="col-xl-6 ">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Unidades</h4>
                                        <div class="table-responsive-sm" name="areas" data-table="div_table">
                                            <table class="table mb-0">
                                            </table>
                                        </div> <!-- end table-responsive-->

                                        <div class="d-flex justify-content-end justify-content-lg-center mt-3">

                                            <a href="/tablas/areas.php" class="btn btn-primary">Ver mas <i class="ri-arrow-right-line"></i></a>

                                        </div>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->


                            <div class="col-xl-6 ">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Responsables</h4>
                                        <div class="table-responsive-sm" name="responsables" data-table="div_table">
                                            <table class="table mb-0">
                                            </table>
                                        </div> <!-- end table-responsive-->

                                        <div class="d-flex justify-content-end justify-content-lg-center mt-3">

                                            <a href="/tablas/responsables.php" class="btn btn-primary">Ver mas <i class="ri-arrow-right-line"></i></a>

                                        </div>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Usuarios</h4>
                                        <div class="table-responsive-sm" name="usuarios" data-table="div_table">
                                            <table class="table mb-0">
                                            </table>
                                        </div> <!-- end table-responsive-->

                                        <div class="d-flex justify-content-end justify-content-lg-center mt-3">

                                            <a href="/tablas/usuarios.php" class="btn btn-primary">Ver mas <i class="ri-arrow-right-line"></i></a>

                                        </div>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->



                        </div><!-- end row-->
                    <?php  } ?>


                </div><!-- container -->

            </div> <!-- content -->


            <?php include 'layouts/footer.php'; ?>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <?php include 'layouts/right-sidebar.php'; ?>

    <?php include 'layouts/footer-scripts.php'; ?>

    <!-- Daterangepicker js -->
    <script src="assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- Apex Charts js -->
    <!-- <script src="assets/vendor/apexcharts/apexcharts.min.js"></script> -->

    <!-- Vector Map js -->
    <!-- <script src="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script> -->

    <!-- Dashboard App js -->
    <script src="assets/js/pages/demo.dashboard.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
    <script type="module" src="assets/js/build/dashboard.js"></script>


</body>

</html>