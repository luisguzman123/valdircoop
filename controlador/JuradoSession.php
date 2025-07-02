<?php


require_once "./conexion/db.php";



class JuradoSession {
    public function __construct() {
        session_start();
    }

    public function existeJurado($cedula, $pass) {
        $passMD5 = md5($pass);
        $db = new DB();
        $query = $db->conectar()->prepare("SELECT id_jurado, nombre_apellido, cedula, pass, estado FROM jurados WHERE cedula = :cedula AND pass = :pass LIMIT 1");


        $query->execute(['cedula' => $cedula, 'pass' => $pass]);


        if ($query->rowCount() > 0) {
            $jurado = $query->fetch(PDO::FETCH_ASSOC);
            if (strtoupper($jurado['estado']) === 'ACTIVO') {
                $_SESSION['id_jurado'] = $jurado['id_jurado'];
                $_SESSION['nombre_completo'] = $jurado['nombre_apellido'];
                $_SESSION['cedula'] = $jurado['cedula'];
                return true;
            }
        }
        return false;
    }

    public function juradoLogeado() {
        return isset($_SESSION['id_jurado']);
    }

    public function cerrarSesion() {
        session_unset();
        session_destroy();
    }
}
?>
