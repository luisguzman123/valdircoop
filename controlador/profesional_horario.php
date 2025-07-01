<?php

include_once '../conexion/db.php';

//------------------------------------------------------------
//------------------------------------------------------------
//------------------------------------------------------------
if(isset($_POST['disponible'])){
    //obtenemos datos del horario
     $json_datos = json_decode($_POST['disponible'], true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("select 
   ha.desde ,
   ha.hasta 
   from horarios_atencion ha 
   where  ha.id_horario_atencion  = :id");
    
     $query->execute([
        "id" => $json_datos['id_horario_atencion']
    ]);
     
     $horario_atencion = $query->fetch(PDO::FETCH_OBJ);
    
    //horarios disponibles
    $query = $base_datos->conectar()->prepare("SELECT DISTINCT
    CONCAT(TIME_FORMAT(h.hora, '%H:%i')) AS horario_disponible
FROM 
    (SELECT TIME('".$horario_atencion->desde."') + INTERVAL n HOUR AS hora
     FROM (
         SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
         UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
         UNION ALL SELECT 10 UNION ALL SELECT 11
     ) horas
     WHERE TIME('".$horario_atencion->desde."') + INTERVAL n HOUR < TIME('".$horario_atencion->hasta."') -- Evitar intervalos fuera del rango
    ) h
JOIN 
    profesional_horario ph ON ph.id_profesional = '".$json_datos['id_profesional']."' AND ph.estado = 'ACTIVO'
JOIN 
    horarios_atencion ha ON ha.id_horario_atencion = ph.id_horario_atencion
LEFT JOIN 
    turno t ON t.id_profesional = ph.id_profesional 
              AND t.fecha = '".$json_datos['fecha']."' 
              AND h.hora = t.hora
WHERE 
    h.hora BETWEEN ha.desde AND ha.hasta -- Respetar el periodo de atención
    AND t.hora IS NULL                   -- Excluir horarios ya ocupados
    AND (
        '".$json_datos['fecha']."' != CURRENT_DATE -- Mostrar todos los horarios si la fecha no es hoy
        OR h.hora >= CURRENT_TIME                 -- Filtrar horarios según la hora actual si la fecha es hoy
    )
ORDER BY 
    h.hora;

");
    
    $query->execute();
    
    
    

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}