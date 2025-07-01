<?php

include_once '../conexion/db.php';
//POST -> SE ENVIAN DATOS DESDE UN FORMULARIO (SEGURA)
//GET -> OBETENER DATOS DE URL
//REQUEST ->HIBRIDA
if(isset($_POST['guardar'])){
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("
                        INSERT INTO `persona`
                        ( nombre, apellido,
                      fecha, sexo, color, foto) 
                      VALUES (:nombre, :apellido,
                      :fecha, :sexo, :color, :foto)");

    $query->execute($json_datos);
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
if(isset($_POST['eliminar'])){
    
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("
                        DELETE FROM `persona` WHERE `id_persona` = :id");

    $query->execute([
        'id' => $_POST['eliminar']
    ]);
}
//------------------------------------------------------------
//------------------------------------------------------------
//------------------------------------------------------------
if(isset($_POST['leer'])){
    //leer
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT `id_persona`, "
            . "`nombre`, `apellido`, `fecha`, `sexo`, `color`, `foto`"
            . " FROM `persona` ORDER BY id_persona DESC");
    
    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}
//------------------------------------------------------------
//------------------------------------------------------------
//------------------------------------------------------------
if(isset($_POST['leer_id'])){
    //leer
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT `id_persona`, "
            . "`nombre`, `apellido`, `fecha`, `sexo`, `color`, `foto`"
            . " FROM `persona` where id_persona = :id");
    
    $query->execute([
        'id' => $_POST['leer_id']
    ]);

    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}
//------------------------------------------------------------
//------------------------------------------------------------
//------------------------------------------------------------
if(isset($_POST['leer_descripcion'])){
    //leer
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT `id_persona`, "
            . "`nombre`, `apellido`, `fecha`, `sexo`, `color`, `foto`"
            . " FROM `persona` "
            . "where CONCAT(`nombre`, `apellido`, `fecha`,"
            . " `sexo`, `color`, `foto`) LIKE '%".$_POST['leer_descripcion']."%'");
    
    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}
//------------------------------------------------------------
//------------------------------------------------------------
//------------------------------------------------------------
if(isset($_POST['actualizar'])){
    //actualizar
}

