<?php include_once __DIR__ . '/layouts/app.php'; ?>
<?php include_once __DIR__ . '/auth/login.php'; ?>

<head>
    <title>Iniciar Sesion</title>
    <?php include_once 'layouts/title-meta.php'; ?>

    <?php include_once 'layouts/head-css.php'; ?>
</head>

<body class="authentication-bg position-relative">

    <?php include_once __DIR__ . '/layouts/background.php'; ?>

    <div class="account-pages pt-2 pt-sm-3 pb-4 pb-sm-4 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-1 text-center bg-white">
                            <span><img src="assets/images/logo-unam.png" alt="logo" height="200"></span>
                        </div>

                        <div class="card-body py-2 px-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold fs-2">Iniciar Sesión</h4>
                                <p class="text-muted mb-3">Ingresa tu numero de cuenta y contraseña para acceder al panel principal.</p>
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

                            <form action="/" method="POST">

                                <div class="mb-3">
                                    <label for="numero_cuenta" class="form-label">Numero de Cuenta</label>
                                    <input class="form-control" type="text" id="num_cuenta" placeholder="Numero de cuenta" name="num_cuenta" value="<?php echo $usuario->num_cuenta ?>">
                                </div>

                                <div class="mb-3">
                                    <a href="auth-recoverpw.php" class="text-muted float-end fs-12">¿Olvidaste tu contraseña?</a>
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Tu contraseña">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> Iniciar Sesion </button>
                                </div>

                            </form>
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

    <footer class="footer footer-alt fw-medium">
        <span class="bg-body">
            <script>
                document.write(new Date().getFullYear())
            </script> © Facultad de Estudios Superiores Iztacala UNAM (FES Iztacala)
        </span>
    </footer>

   
    <?php include_once __DIR__ . '/layouts/footer-scripts.php'; ?>
  
      <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>