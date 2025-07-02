<?php
include_once './controlador/JuradoSession.php';
$jurado = new JuradoSession();
$error_sesion = "";

if (isset($_POST['cedula']) && isset($_POST['pass'])) {
    $cedula = $_POST['cedula'];
    $pass = $_POST['pass'];

    if ($jurado->existeJurado($cedula, $pass)) {
        header("Location: menu_jurado.php");
        exit;
    } else {
        $error_sesion = "Credenciales inválidas";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Jurado</title>
    <link rel="stylesheet" href="vendors/typicons/typicons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="plugins/sweetalert/sweetalert2.min.css">
    <script src="plugins/sweetalert/sweetalert2.min.js"></script>
    <link rel="shortcut icon" href="images/logo-nido.png" />
</head>
<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo text-center">
                            <img src="images/logo-nido.png" style="width: 200px;" alt="logo">
                        </div>
                        <h4 class="text-center">Ingreso de Jurado</h4>
                        <?php if (!empty($error_sesion)) : ?>
                            <script>
                                Swal.fire({
                                    title: 'Atención',
                                    text: '<?= $error_sesion ?>',
                                    icon: 'warning'
                                });
                            </script>
                        <?php endif; ?>
                        <form class="pt-3" method="POST">
                            <div class="form-group">
                                <input type="text" name="cedula" class="form-control form-control-lg" placeholder="Cédula" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="pass" class="form-control form-control-lg" placeholder="Contraseña" required>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium">Ingresar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="plugins/sweetalert/sweetalert2.min.js"></script>
<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/template.js"></script>
</body>
</html>
