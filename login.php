<?php

include_once './controlador/UsuarioSession.php';

$usuario = new UsuarioSession();
$error_sesion = "";

if (isset($_POST['cedula']) && isset($_POST['pass'])) {
    $cedula = $_POST['cedula'];
    $pass = $_POST['pass'];

    $intentos = $usuario->dameIntentos($cedula);
    $limite = $usuario->dameLimiteIntentos($cedula);

    if ($intentos >= $limite) {
        $usuario->bloquearUsuario($cedula);
        $error_sesion = "Usuario bloqueado por superar el límite de intentos.";
    } else {
        if ($usuario->existeUsuario($cedula, $pass)) {
            $usuario->actualizatIntentos($cedula, 0); // Resetear intentos
            header("Location: menu.php");
            exit;
        } else {
            $intentos++;
            $usuario->actualizatIntentos($cedula, $intentos);
            $restantes = $limite - $intentos;
            $error_sesion = "Credenciales inválidas. Intentos restantes: $restantes";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>APP EL NIDO</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/typicons/typicons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="plugins/sweetalert/sweetalert2.min.css">
    <script src="plugins/sweetalert/sweetalert2.min.js"></script>
    <!-- endinject -->
    <link rel="shortcut icon" href="images/logo-nido.png" />
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <img src="images/logo-nido.png" style="width: 350px;" alt="logo">
                        </div>
                        <h4>¡Hola! ¡Comencemos!</h4>
                        <?php if (!empty($error_sesion)) : ?>
                            <script>
                                Swal.fire({
                                    title: "Atención",
                                    text: "<?= $error_sesion ?>",
                                    icon: "warning"
                                });
                            </script>
                        <?php endif; ?>
                        <h6 class="font-weight-light">Inicia sesión para continuar.</h6>
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
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input">
                                        Mantenerme conectado.
                                    </label>
                                </div>
                                <a href="#" class="auth-link text-black">¿Olvidaste tu contraseña?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- Carga jQuery primero -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Carga SweetAlert2 después -->
<script src="plugins/sweetalert/sweetalert2.min.js"></script>

<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/template.js"></script>

<?php if ($error_sesion): ?>
<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: '<?= $error_sesion ?>'
        });
    });
</script>
<?php endif; ?>

</body>
</html>