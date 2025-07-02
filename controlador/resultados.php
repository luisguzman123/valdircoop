<?php
require_once '../conexion/db.php';

if(isset($_POST['leer_resultados'])){
    $db = new DB();
    $c = $db->conectar();

    // Resultados agrupados por especialidad y curso
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
    $curso = $stmt->rowCount() ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

    // Resultados agrupados por proyecto
    $stmt = $c->prepare("SELECT e.descripcion AS especialidad, c.descripcion AS curso, p.descripcion AS proyecto, SUM(id.logrado) AS total_logrado
                         FROM indicador_detalle id
                         INNER JOIN indicador_cabecera ic ON ic.id_indicador_cabecera=id.id_indicador_cabecera
                         INNER JOIN proyecto_curso pc ON pc.id_proyecto_curso=ic.id_proyecto_curso
                         INNER JOIN cursos c ON c.id_curso=pc.id_curso
                         INNER JOIN proyectos p ON p.id_proyecto=pc.id_proyecto
                         INNER JOIN curso_especialidades ce ON ce.id_curso=c.id_curso
                         INNER JOIN especialidades e ON e.id_especialidad=ce.id_especialidad
                         GROUP BY e.descripcion, c.descripcion, p.descripcion
                         ORDER BY e.descripcion, c.descripcion, total_logrado DESC");
    $stmt->execute();
    $proyecto = $stmt->rowCount() ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

    // Premios: mejor proyecto por curso y por especialidad
    $mejorCurso = [];
    $mejorEspecialidad = [];
    foreach($proyecto as $p){
        if(!isset($mejorCurso[$p['curso']]) || $mejorCurso[$p['curso']]['total_logrado'] < $p['total_logrado']){
            $mejorCurso[$p['curso']] = ['proyecto' => $p['proyecto'], 'total_logrado' => $p['total_logrado']];
        }
        if(!isset($mejorEspecialidad[$p['especialidad']]) || $mejorEspecialidad[$p['especialidad']]['total_logrado'] < $p['total_logrado']){
            $mejorEspecialidad[$p['especialidad']] = ['proyecto' => $p['proyecto'], 'total_logrado' => $p['total_logrado']];
        }
    }

    $respuesta = [
        'por_curso' => $curso,
        'por_proyecto' => $proyecto,
        'mejor_curso' => $mejorCurso,
        'mejor_especialidad' => $mejorEspecialidad
    ];

    print_r(json_encode($respuesta));
    exit;
}
