<?php
include_once 'conexion/db.php';

class UsuarioSession {

    public function __construct() {
        session_start();
    }

    public function existeUsuario($cedula, $pass) {
        $passMD5 = md5($pass);
        $db = new DB();

        $query = $db->conectar()->prepare("
            SELECT id_usuario, nombreyapellido, cedula, contrasena, rol, estado 
            FROM usuarios 
            WHERE cedula = :cedula AND contrasena = :pass
            LIMIT 1
        ");
        $query->execute(['cedula' => $cedula, 'pass' => $passMD5]);

        if ($query->rowCount() > 0) {
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if (strtoupper($user['estado']) === 'ACTIVO') {
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre_completo'] = $user['nombreyapellido'];
                $_SESSION['rol'] = $user['rol'];
                $_SESSION['cedula'] = $user['cedula'];
                return true;
            }
        }

        return false;
    }

    public function bloquearUsuario($cedula) {
        $db = new DB();
        $db->conectar()->prepare("UPDATE usuarios SET estado = 'BLOQUEADO' WHERE cedula = :cedula")
                       ->execute(['cedula' => $cedula]);
    }

    public function actualizatIntentos($cedula, $intentos) {
        $db = new DB();
        $db->conectar()->prepare("UPDATE usuarios SET intentos = :intentos WHERE cedula = :cedula")
                       ->execute(['cedula' => $cedula, 'intentos' => $intentos]);
    }

    public function dameIntentos($cedula) {
        $db = new DB();
        $query = $db->conectar()->prepare("SELECT intentos FROM usuarios WHERE cedula = :cedula");
        $query->execute(['cedula' => $cedula]);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['intentos'] : 0;
    }

    public function dameLimiteIntentos($cedula) {
        $db = new DB();
        $query = $db->conectar()->prepare("SELECT limite_intentos FROM usuarios WHERE cedula = :cedula");
        $query->execute(['cedula' => $cedula]);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['limite_intentos'] : 3;
    }

    public function usuarioLogeado() {
        return isset($_SESSION['id_usuario']);
    }

    public function getNombre() {
        return $_SESSION['nombre_completo'] ?? '';
    }

    public function getIdUsuario() {
        return $_SESSION['id_usuario'] ?? null;
    }

    public function getCedula() {
        return $_SESSION['cedula'] ?? '';
    }

    public function getRol() {
        return $_SESSION['rol'] ?? '';
    }
}
