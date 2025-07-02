<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json = json_decode($_POST['guardar'], true);
    $db = new DB();
    $query = $db->conectar()->prepare("INSERT INTO proyecto_curso(id_curso, id_proyecto, estado) VALUES (:id_curso, :id_proyecto, :estado)");
    $query->execute([
        'id_curso' => $json['id_curso'],
        'id_proyecto' => $json['id_proyecto'],
        'estado' => $json['estado']
    ]);
    exit;
}

if (isset($_POST['actualizar'])) {
    $json = json_decode($_POST['actualizar'], true);
    $db = new DB();
    $query = $db->conectar()->prepare("UPDATE proyecto_curso SET id_curso=:id_curso, id_proyecto=:id_proyecto, estado=:estado WHERE id_proyecto_curso=:id");
    $query->execute([
        'id' => $json['id_proyecto_curso'],
        'id_curso' => $json['id_curso'],
        'id_proyecto' => $json['id_proyecto'],
        'estado' => $json['estado']
    ]);
    exit;
}

if (isset($_POST['eliminar'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("DELETE FROM proyecto_curso WHERE id_proyecto_curso=:id");
    $query->execute(['id' => $_POST['eliminar']]);
    exit;
}

if (isset($_POST['leer'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("SELECT pc.id_proyecto_curso, pc.estado, pc.id_curso, pc.id_proyecto, c.descripcion AS curso, p.descripcion AS proyecto FROM proyecto_curso pc INNER JOIN cursos c ON c.id_curso=pc.id_curso INNER JOIN proyectos p ON p.id_proyecto=pc.id_proyecto ORDER BY pc.id_proyecto_curso DESC");
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
    $query = $db->conectar()->prepare("SELECT id_proyecto_curso, id_curso, id_proyecto, estado FROM proyecto_curso WHERE id_proyecto_curso = :id");
    $query->execute(['id' => $_POST['leer_id']]);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}

if (isset($_POST['proyectos_por_curso'])) {
    $db = new DB();
    $query = $db->conectar()->prepare(
        "SELECT pc.id_proyecto_curso, p.id_proyecto, p.descripcion
         FROM proyecto_curso pc
         INNER JOIN proyectos p ON p.id_proyecto = pc.id_proyecto
         WHERE pc.id_curso = :id
           AND pc.estado = 'ACTIVO'
           AND p.estado = 'ACTIVO'"
    );
    $query->execute(['id' => $_POST['proyectos_por_curso']]);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}
?>
