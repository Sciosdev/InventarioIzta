<?php include_once __DIR__ . '/layouts/app.php'; ?>
<head>
    <title>Iniciar Sesion</title>
    <?php include_once 'layouts/title-meta.php'; ?>

    <?php include_once 'layouts/head-css.php'; ?>
</head>

<body class="authentication-bg position-relative">
    <?php include_once __DIR__ . '/../templates/background.php'; ?>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-10">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="text-center">

                                <h3 class="mt-4 text-uppercase mb-3">Tu cuenta ha sido creada </h3>
                                <p class="text-muted">Por favor, espera la aprobación del administrador.</p>
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <p class="text-muted">Puedes cerrar esta pestaña o iniciar sesión ahora<a href="<?= url('/'); ?>" class="text-muted ms-1 link-offset-3 text-decoration-underline"><b>Iniciar Sesión</b></a></p>
                                    </div> <!-- end col -->
                                </div>


                            </div> <!-- end /.text-center-->
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <?php include_once __DIR__ . '/layouts/footer-scripts.php'; ?>
    <!-- App js -->
    <!-- App js -->
    <script src="<?= url('assets/js/app.min.js'); ?>"></script>

</body>

</html>