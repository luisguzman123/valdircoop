<?php

include_once '../conexion/db.php';

//------------------------------------------------------------
//------------------------------------------------------------
//------------------------------------------------------------
if(isset($_POST['disponible'])){
    //leer
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT 
    ha.id_horario_atencion,
    ha.id_dias,
    DATE_FORMAT(ha.desde, '%H:%i') AS desde,
    DATE_FORMAT(ha.hasta, '%H:%i') AS hasta,
    d.dia,
    ha.estado,
    DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL seq - 1 DAY), '%Y-%m-%d') AS fecha_actual
FROM 
    (SELECT 1 AS seq UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
     UNION ALL SELECT 6 UNION ALL SELECT 7) seq_table
JOIN 
    horarios_atencion ha
JOIN 
    dias d ON d.id_dia = ha.id_dias
WHERE 
    ha.estado = 'ACTIVO'
    AND d.dia = CASE 
        WHEN DAYOFWEEK(DATE_ADD(CURDATE(), INTERVAL seq - 1 DAY)) = 1 THEN 'domingo'
        WHEN DAYOFWEEK(DATE_ADD(CURDATE(), INTERVAL seq - 1 DAY)) = 2 THEN 'lunes'
        WHEN DAYOFWEEK(DATE_ADD(CURDATE(), INTERVAL seq - 1 DAY)) = 3 THEN 'martes'
        WHEN DAYOFWEEK(DATE_ADD(CURDATE(), INTERVAL seq - 1 DAY)) = 4 THEN 'miércoles'
        WHEN DAYOFWEEK(DATE_ADD(CURDATE(), INTERVAL seq - 1 DAY)) = 5 THEN 'jueves'
        WHEN DAYOFWEEK(DATE_ADD(CURDATE(), INTERVAL seq - 1 DAY)) = 6 THEN 'viernes'
        WHEN DAYOFWEEK(DATE_ADD(CURDATE(), INTERVAL seq - 1 DAY)) = 7 THEN 'sábado'
    END
ORDER BY fecha_actual, ha.desde;");
    
    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}