<?php
include_once './controlador/usuarioSession.php';

$usuario = new UsuarioSession();
$error_sesion = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'] ?? '';
    $pass = $_POST['pass'] ?? '';

    $intentos = $usuario->dameIntentos($cedula);
    $limite = $usuario->dameLimiteIntentos($cedula);

    if ($intentos >= $limite) {
        $usuario->bloquearUsuario($cedula);
        $error_sesion = "Usuario bloqueado por superar el límite de intentos.";
    } elseif ($usuario->existeUsuario($cedula, $pass)) {
        $usuario->actualizatIntentos($cedula, 0); // Reiniciar intentos
        header("Location: menu.php");
        exit;
    } else {
        $usuario->actualizatIntentos($cedula, $intentos + 1);
        $restantes = $limite - ($intentos + 1);
        $error_sesion = "Credenciales inválidas. Intentos restantes: $restantes";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=1, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>APP | EL NIDO</title>
        <link rel="stylesheet" href="vendors/typicons/typicons.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="css/vertical-layout-light/style.css">
        <link rel="stylesheet" href="plugins/sweetalert/sweetalert2.min.css">
        <script src="plugins/sweetalert/sweetalert2.min.js"></script>

    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light py-5 px-4 px-sm-5">
                                <div class="brand-logo text-center">
                                    <img src="images/logocpcc.jpeg" style="width: 250px;" alt="logo">
                                </div>
                                <h4>¡Hola! ¡Comencemos!</h4>

                                <form class="pt-3" method="POST">
                                    <div class="form-group">
                                        <input type="text" name="cedula" class="form-control form-control-lg" placeholder="Cédula" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="pass" class="form-control form-control-lg" placeholder="Contraseña" required>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium">INICIAR SESIÓN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ... tu HTML ... -->

        <!-- Carga jQuery primero -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Carga SweetAlert2 después -->
        <script src="plugins/sweetalert/sweetalert2.min.js"></script>

        <script src="vendors/js/vendor.bundle.base.js"></script>
        <script src="js/off-canvas.js"></script>
        <script src="js/template.js"></script>

        <?php if ($error_sesion): ?>
            <script>
                $(document).ready(function () {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: '<?= $error_sesion ?>'
                    });
                });
            </script>
        <?php endif; ?>

    </body>
    <style>
        .btn-primary {
            background-color: #28a745 !important;  /* verde Bootstrap */
            border-color:    #28a745 !important;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary.active,
        .show > .btn-primary.dropdown-toggle {
            background-color: #218838 !important;  /* un verde más oscuro al pasar el cursor */
            border-color:    #1e7e34 !important;
        }

    </style>


</html>

