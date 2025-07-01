<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar_completo'])) {
    $json = json_decode($_POST['guardar_completo'], true);
    $db = new DB();
    $c = $db->conectar();
    $c->beginTransaction();
    try {
        $stmt = $c->prepare("INSERT INTO plantilla_indicadores_cabecera(id_especialidad, estado) VALUES(:id_especialidad, :estado)");
        $stmt->execute([
            'id_especialidad' => $json['cabecera']['id_especialidad'],
            'estado' => $json['cabecera']['estado']
        ]);
        $cab_id = $c->lastInsertId();
        $stmtD = $c->prepare("INSERT INTO plantilla_indicador_detalle(id_plantilla_indicador_cabecera,id_padre,nivel,descripcion,puntaje,estado) VALUES(:id_cabecera,:id_padre,:nivel,:descripcion,:puntaje,:estado)");
        foreach ($json['detalles'] as $d) {
            $stmtD->execute([
                'id_cabecera' => $cab_id,
                'id_padre' => $d['id_padre'],
                'nivel' => $d['orden'],
                'descripcion' => $d['descripcion'],
                'puntaje' => $d['puntaje'],
                'estado' => $d['estado']
            ]);
        }
        $c->commit();
    } catch (Exception $e) {
        $c->rollBack();
        echo $e->getMessage();
    }
    exit;
}

if (isset($_POST['actualizar_completo'])) {
    $json = json_decode($_POST['actualizar_completo'], true);
    $db = new DB();
    $c = $db->conectar();
    $c->beginTransaction();
    try {
        $stmt = $c->prepare("UPDATE plantilla_indicadores_cabecera SET id_especialidad=:id_especialidad, estado=:estado WHERE id_plantilla_indicador_cabecera=:id");
        $stmt->execute([
            'id_especialidad' => $json['cabecera']['id_especialidad'],
            'estado' => $json['cabecera']['estado'],
            'id' => $json['cabecera']['id_plantilla_indicador_cabecera']
        ]);
        $c->prepare("DELETE FROM plantilla_indicador_detalle WHERE id_plantilla_indicador_cabecera=:id")->execute(['id' => $json['cabecera']['id_plantilla_indicador_cabecera']]);
        $stmtD = $c->prepare("INSERT INTO plantilla_indicador_detalle(id_plantilla_indicador_cabecera,id_padre,nivel,descripcion,puntaje,estado) VALUES(:id_cabecera,:id_padre,:nivel,:descripcion,:puntaje,:estado)");
        foreach ($json['detalles'] as $d) {
            $stmtD->execute([
                'id_cabecera' => $json['cabecera']['id_plantilla_indicador_cabecera'],
                'id_padre' => $d['id_padre'],
                'nivel' => $d['orden'],
                'descripcion' => $d['descripcion'],
                'puntaje' => $d['puntaje'],
                'estado' => $d['estado']
            ]);
        }
        $c->commit();
    } catch (Exception $e) {
        $c->rollBack();
        echo $e->getMessage();
    }
    exit;
}

if (isset($_POST['eliminar_cabecera'])) {
    $db = new DB();
    $c = $db->conectar();
    $c->prepare("DELETE FROM plantilla_indicador_detalle WHERE id_plantilla_indicador_cabecera=:id")->execute(['id' => $_POST['eliminar_cabecera']]);
    $c->prepare("DELETE FROM plantilla_indicadores_cabecera WHERE id_plantilla_indicador_cabecera=:id")->execute(['id' => $_POST['eliminar_cabecera']]);
    exit;
}

if (isset($_POST['leer_cabeceras'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("SELECT id_plantilla_indicador_cabecera, id_especialidad, estado FROM plantilla_indicadores_cabecera ORDER BY id_plantilla_indicador_cabecera DESC");
    $query->execute();
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}

if (isset($_POST['leer_cabecera_id'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("SELECT id_plantilla_indicador_cabecera, id_especialidad, estado FROM plantilla_indicadores_cabecera WHERE id_plantilla_indicador_cabecera=:id");
    $query->execute(['id' => $_POST['leer_cabecera_id']]);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}

if (isset($_POST['leer_detalles'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("SELECT id_plantilla_indicador_detalle,id_plantilla_indicador_cabecera,id_padre,nivel AS orden,descripcion,puntaje,estado FROM plantilla_indicador_detalle WHERE id_plantilla_indicador_cabecera=:id");
    $query->execute(['id' => $_POST['leer_detalles']]);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}
