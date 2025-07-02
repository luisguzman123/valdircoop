<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $data = json_decode($_POST['guardar'], true);
    $db = new DB();
    $query = $db->conectar()->prepare(
        "INSERT INTO jurados(nombre_apellido,cedula,pass,estado) VALUES(:nombre_apellido,:cedula,:pass,:estado)"
    );
    $query->execute($data);
    exit;
}

if (isset($_POST['actualizar'])) {
    $data = json_decode($_POST['actualizar'], true);
    $db = new DB();
    $query = $db->conectar()->prepare(
        "UPDATE jurados SET nombre_apellido=:nombre_apellido, cedula=:cedula, pass=:pass, estado=:estado WHERE id_jurado=:id_jurado"
    );
    $query->execute($data);
    exit;
}

if (isset($_POST['eliminar'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("DELETE FROM jurados WHERE id_jurado=:id");
    $query->execute(['id' => $_POST['eliminar']]);
    exit;
}

if (isset($_POST['leer'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("SELECT id_jurado,nombre_apellido,cedula,estado FROM jurados ORDER BY id_jurado DESC");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}

if (isset($_POST['leer_id'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("SELECT id_jurado,nombre_apellido,cedula,pass,estado FROM jurados WHERE id_jurado=:id");
    $query->execute(['id' => $_POST['leer_id']]);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}
?>
