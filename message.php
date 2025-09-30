<?php include_once __DIR__ . '/layouts/app.php'; ?>
<head>
    <title>Mensaje</title>
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
                            <span><img src="<?= url('assets/images/logo-unam.png'); ?>" alt="logo" height="200"></span>
                        </div>

                        <div class="card-body py-2 px-4">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold fs-2">Contraseña creada</h4>
                                <p class="text-muted mb-3">Tu contraseña ha sido creada correctamente. Puedes cerrar esta pestaña o <a href="<?= url('/'); ?>" onclick="event.preventDefault(); location.replace(this.href);">iniciar sesión</a>.</p>
                            </div>
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
    <script src="<?= url('assets/js/app.min.js'); ?>"></script>

</body>

</html>