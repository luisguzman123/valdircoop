<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json = json_decode($_POST['guardar'], true);
    $db = new DB();
    $query = $db->conectar()->prepare("INSERT INTO cursos(descripcion, estado) VALUES (:descripcion, :estado)");
    $query->execute([
        'descripcion' => $json['descripcion'],
        'estado' => $json['estado']
    ]);
    exit;
}

if (isset($_POST['actualizar'])) {
    $json = json_decode($_POST['actualizar'], true);
    $db = new DB();
    $query = $db->conectar()->prepare("UPDATE cursos SET descripcion=:descripcion, estado=:estado WHERE id_curso=:id_curso");
    $query->execute([
        'id_curso' => $json['id_curso'],
        'descripcion' => $json['descripcion'],
        'estado' => $json['estado']
    ]);
    exit;
}

if (isset($_POST['eliminar'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("DELETE FROM cursos WHERE id_curso=:id");
    $query->execute(['id' => $_POST['eliminar']]);
    exit;
}

if (isset($_POST['leer'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("SELECT id_curso, descripcion, estado FROM cursos ORDER BY id_curso DESC");
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
    $query = $db->conectar()->prepare("SELECT id_curso, descripcion, estado FROM cursos WHERE id_curso = :id");
    $query->execute(['id' => $_POST['leer_id']]);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}
