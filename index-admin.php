
<?php

include_once './controlador/usuarioSession.php';
//include_once './controladores/usuarioActivo.php';
$error_sesion = "";
$usuario = new UsuarioSession();
//$usuario_activo = new UsuarioActivo();


if ($usuario->usuarioLogeado()) {

    include_once 'menu-admin.php';

//    echo "usuario logeado";
} else if (isset($_POST['usuario']) && isset($_POST['pass'])) {


    if ($usuario->existeUsuario($_POST['usuario'], $_POST['pass'])) {
//      

        include_once 'menu-admin.php';
    } else {
        $error_sesion = "No se encontro usuario y/o contraseña";

        include_once 'login.php';

    }
} else {
    include_once 'login.php';
}
?>