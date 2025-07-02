<?php
require_once '../conexion/db.php';

if(isset($_POST['leer_resultados'])){
    $db = new DB();
    $c = $db->conectar();
    $stmt = $c->prepare("SELECT e.descripcion AS especialidad, c.descripcion AS curso, SUM(id.logrado) AS total_logrado
                         FROM indicador_detalle id
                         INNER JOIN indicador_cabecera ic ON ic.id_indicador_cabecera=id.id_indicador_cabecera
                         INNER JOIN proyecto_curso pc ON pc.id_proyecto_curso=ic.id_proyecto_curso
                         INNER JOIN cursos c ON c.id_curso=pc.id_curso
                         INNER JOIN curso_especialidades ce ON ce.id_curso=c.id_curso
                         INNER JOIN especialidades e ON e.id_especialidad=ce.id_especialidad
                         GROUP BY e.descripcion, c.descripcion
                         ORDER BY e.descripcion, total_logrado DESC");

    $stmt->execute();
    if($stmt->rowCount()){
        print_r(json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)));
    }else{
        echo '0';
    }
    exit;
}
