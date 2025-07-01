<?php

require_once '../conexion/db.php';

if (isset($_POST['leer'])) {
    leer();
}

function leer() {
    $datos = json_decode($_POST['leer']);
    $base_datos = new DB();
    $conexion = $base_datos->conectar();

    if (isset($datos->seccion)) {
        $estado = $datos->seccion; // ej: "pendientes", "atendidos", "cancelados"

        $query = $conexion->prepare("
            SELECT count(id_turno) as cantidad
            FROM `turno`
            WHERE `estado` like :estado
        ");
        $query->bindParam(':estado', $estado);
        $query->execute();

        if ($query->rowCount()) {
            echo json_encode($query->fetch(PDO::FETCH_OBJ));
        } else {
            echo '0';
        }
    }
}
