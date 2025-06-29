<?php include_once __DIR__ . '/layouts/app.php'; ?>
<?php include_once __DIR__ . '/auth/password.php'; ?>


<head>
    <title>Crea una contraseña</title>
    <?php include_once 'layouts/title-meta.php'; ?>
    <?php include_once 'layouts/head-css.php'; ?>
</head>

<body class="authentication-bg position-relative">
    <?php include_once __DIR__ . '/layouts/background.php'; ?>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-1 text-center bg-white">
                            <span><img src="assets/images/logo-unam.png" alt="logo" height="200"></span>
                        </div>
                        <div class="card-body py-2 px-4">

                            <?php
                            if (empty($usuario)) {
                            ?>
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center pb-0 fw-bold fs-2">Token no valido</h4>
                                    <p class="text-muted mb-3">Por favor, verifica el enlace o solicita uno nuevo.</p>
                                </div>
                            <?php } else { ?>

                                <div>

                                    <div class="text-center w-75 m-auto">
                                        <h4 class="text-dark-50 text-center pb-0 fw-bold fs-2">Establece tu contraseña</h4>
                                        <p class="text-muted mb-3">Crea tu contraseña de acceso al sistema de inventario.</p>
                                    </div>

                                    <?php
                                    foreach ($alertas as $key => $alerta):
                                        foreach ($alerta as $mensaje):
                                    ?>
                                            <div class="alert alert-<?php echo $key; ?> text-uppercase fs-6" role="alert">
                                                <strong><?php echo $mensaje; ?></strong>
                                            </div>
                                    <?php endforeach;
                                    endforeach; ?>

                                    <form action="" method="POST">

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Escribe tu contraseña">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirm" class="form-label">Confirma Contraseña</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Repite tu contraseña">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-3 mb-0 text-center">
                                            <button class="btn btn-primary" type="submit"> Guardar contraseña </button>
                                        </div>

                                    </form>

                                </div> <!-- end /.text-center-->

                            <?php } ?>
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
    <script src="assets/js/app.min.js"></script>

</body>

</html>