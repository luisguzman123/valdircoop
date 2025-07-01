<?php

include_once '../conexion/db.php';

//------------------------------------------------------------
//------------------------------------------------------------
//------------------------------------------------------------
if(isset($_POST['disponible'])){
    //leer
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("select 
s.id_sucursal ,
s.sucursal ,
s.telefono ,
s.direccion ,
s.ubicacion_maps,
s.estado 
from sucursales s 
where s.estado  = 'ACTIVO' ");
    
    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}