<?php
require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json = json_decode($_POST['guardar'], true);
    $db = new DB();
    $c = $db->conectar();
    $c->beginTransaction();
    try {
        $stmt = $c->prepare("INSERT INTO indicador_cabecera(id_proyecto_curso,titulo,id_plantilla,nro_stand,estado) VALUES(:proyecto,:titulo,:plantilla,:stand,:estado)");
        $stmt->execute([
            'proyecto' => $json['id_proyecto_curso'],
            'titulo' => $json['titulo'],
            'plantilla' => $json['id_plantilla'],
            'stand' => $json['nro_stand'],
            'estado' => $json['estado']
        ]);
        $cabId = $c->lastInsertId();

        $q = $c->prepare("SELECT id_plantilla_indicador_detalle,id_padre,nivel,descripcion,puntaje FROM plantilla_indicador_detalle WHERE id_plantilla_indicador_cabecera=:id ORDER BY id_plantilla_indicador_detalle");
        $q->execute(['id' => $json['id_plantilla']]);
        $ins = $c->prepare("INSERT INTO indicador_detalle(id_indicador_cabecera,id_padre,nivel,descripcion,puntaje,logrado) VALUES(:cab,:padre,:nivel,:desc,:puntaje,:logrado)");
        $map = [];
        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $padre = 0;
            if ((int)$row['id_padre'] !== 0) {
                $padre = $map[$row['id_padre']] ?? (int)$row['id_padre'];
            }
            $ins->execute([
                'cab' => $cabId,
                'padre' => $padre,
                'nivel' => $row['nivel'],
                'desc' => $row['descripcion'],
                'puntaje' => $row['puntaje'],
                'logrado' => 0
            ]);
            $newId = $c->lastInsertId();
            $map[$row['id_plantilla_indicador_detalle']] = $newId;
        }
        $c->commit();
        echo $cabId;
    } catch (Exception $e) {
        $c->rollBack();
        echo $e->getMessage();
    }
    exit;
}

if (isset($_POST['actualizar'])) {
    $json = json_decode($_POST['actualizar'], true);
    $db = new DB();
    $c = $db->conectar();
    $stmt = $c->prepare("UPDATE indicador_cabecera SET id_proyecto_curso=:proyecto,titulo=:titulo,id_plantilla=:plantilla,nro_stand=:stand,estado=:estado WHERE id_indicador_cabecera=:id");
    $stmt->execute([
        'id' => $json['id_indicador_cabecera'],
        'proyecto' => $json['id_proyecto_curso'],
        'titulo' => $json['titulo'],
        'plantilla' => $json['id_plantilla'],
        'stand' => $json['nro_stand'],
        'estado' => $json['estado']
    ]);
    exit;
}

if (isset($_POST['eliminar'])) {
    $db = new DB();
    $c = $db->conectar();
    $c->prepare("DELETE FROM indicador_detalle WHERE id_indicador_cabecera=:id")->execute(['id' => $_POST['eliminar']]);
    $c->prepare("DELETE FROM indicador_cabecera WHERE id_indicador_cabecera=:id")->execute(['id' => $_POST['eliminar']]);
    exit;
}

if (isset($_POST['leer'])) {
    $db = new DB();
    $query = $db->conectar()->prepare("SELECT ic.id_indicador_cabecera, ic.titulo, ic.nro_stand, ic.estado, c.descripcion AS curso, p.descripcion AS proyecto FROM indicador_cabecera ic INNER JOIN proyecto_curso pc ON pc.id_proyecto_curso=ic.id_proyecto_curso INNER JOIN cursos c ON c.id_curso=pc.id_curso INNER JOIN proyectos p ON p.id_proyecto=pc.id_proyecto ORDER BY ic.id_indicador_cabecera DESC");
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
    $query = $db->conectar()->prepare("SELECT id_indicador_cabecera,id_proyecto_curso,titulo,id_plantilla,nro_stand,estado FROM indicador_cabecera WHERE id_indicador_cabecera=:id");
    $query->execute(['id' => $_POST['leer_id']]);
    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}


if (isset($_POST['leer_detalles'])) {
    $db = new DB();
    $q = $db->conectar()->prepare("SELECT id_indicador_detalle, descripcion, puntaje, logrado FROM indicador_detalle WHERE id_indicador_cabecera=:id ORDER BY id_indicador_detalle");
    $q->execute(['id' => $_POST['leer_detalles']]);
    if ($q->rowCount()) {
        print_r(json_encode($q->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
    exit;
}

if (isset($_POST['calificar'])) {
    $json = json_decode($_POST['calificar'], true);
    $db = new DB();
    $c = $db->conectar();
    $c->beginTransaction();
    try {
        $stmt = $c->prepare("UPDATE indicador_detalle SET logrado=:logrado WHERE id_indicador_detalle=:id");
        foreach ($json['detalles'] as $d) {
            $stmt->execute(['logrado' => $d['logrado'], 'id' => $d['id']]);
        }
        $c->commit();
    } catch (Exception $e) {
        $c->rollBack();
        echo $e->getMessage();
    }
    exit;
}

?>
