<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json = json_decode($_POST['guardar'], true);
    $db = new DB();
    $query = $db->conectar()->prepare("INSERT INTO curso_especialidades(id_curso, id_especialidad, estado) VALUES (:id_curso, :id_especialidad, :estado)");
    $query->execute([
        'id_curso' => $json['id_curso'],
        'id_especialidad' => $json['id_especialidad'],
        'estado' => $json['estado']
    ]);
    exit;
}

if (isset($_POST['actualizar'])) {
    $json = json_decode($_POST['actualizar'], true);
    $db = new DB();
    $query = $db->conectar()->prepare("UPDATE curso_especialidades SET id_curso=:id_curso, id_especialidad=:id_especialidad, estado=:estado WHERE id_curso_especialidad=:id");
    $query->execute([
        'id' => $json['id_curso_especialidad'],
        'id_curso' => $json['id_curso'],
        'id_especialidad' => $json['id_especialidad'],
        'estado' => $json['estado']
    ]);
    exit;
}

if (isset($_POST['eliminar'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("DELETE FROM curso_especialidades WHERE id_curso_especialidad=:id");
    $query->execute(['id' => $_POST['eliminar']]);
    exit;
}

if (isset($_POST['leer'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("SELECT ce.id_curso_especialidad, ce.estado, ce.id_curso, ce.id_especialidad, c.descripcion AS curso, e.descripcion AS especialidad FROM curso_especialidades ce INNER JOIN cursos c ON c.id_curso=ce.id_curso INNER JOIN especialidades e ON e.id_especialidad=ce.id_especialidad ORDER BY ce.id_curso_especialidad DESC");
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
    $query = $db->conectar()->prepare("SELECT id_curso_especialidad, id_curso, id_especialidad, estado FROM curso_especialidades WHERE id_curso_especialidad = :id");
    $query->execute(['id' => $_POST['leer_id']]);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}
?>
