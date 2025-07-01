<?php

require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    //crea un arreglo del texto que se le pasa
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new DB();
    
    $query = $base_datos->conectar()->prepare("INSERT INTO usuarios(
        nombreyapellido, cedula, contrasena, rol, estado, intentos, limite_intentos)
       VALUES (:nombreyapellido, :cedula, :contrasena, :rol, :estado, 0, 3)");

    $query->execute([
        "nombreyapellido" => $json_datos['nombreyapellido'],
        "cedula" => $json_datos['cedula'],
        "contrasena" => md5($json_datos['contrasena']),
        "rol" => $json_datos['rol'],
        "estado" => $json_datos['estado']
    ]);
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
if (isset($_POST['actualizar_sin_contra'])) {
    //crea un arreglo del texto que se le pasa
    $json_datos = json_decode($_POST['actualizar_sin_contra'], true);
    $base_datos = new DB();
    
    $query = $base_datos->conectar()->prepare("UPDATE usuarios SET
        nombreyapellido = :nombreyapellido, cedula = :cedula,
        rol = :rol , estado = :estado 
       WHERE id_usuario = :id_usuario");

    $query->execute([
        "id_usuario" => $json_datos['id_usuario'],
        "nombreyapellido" => $json_datos['nombreyapellido'],
        "cedula" => $json_datos['cedula'],
        "rol" => $json_datos['rol'],
        "estado" => $json_datos['estado']
    ]);
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
if (isset($_POST['actualizar_con_contra'])) {
    //crea un arreglo del texto que se le pasa
    $json_datos = json_decode($_POST['actualizar_con_contra'], true);
    $base_datos = new DB();
    
    $query = $base_datos->conectar()->prepare("UPDATE usuarios SET
        nombreyapellido = :nombreyapellido, cedula = :cedula,
        rol = :rol , estado = :estado , contrasena = :contrasena
       WHERE id_usuario = :id_usuario");

    $query->execute([
        "id_usuario" => $json_datos['id_usuario'],
        "nombreyapellido" => $json_datos['nombreyapellido'],
        "cedula" => $json_datos['cedula'],
        "contrasena" => md5($json_datos['contrasena']),
        "rol" => $json_datos['rol'],
        "estado" => $json_datos['estado']
    ]);
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if(isset($_POST['leer_persona'])){
   $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT id_usuario, nombreyapellido, cedula, rol, estado
FROM usuarios 
WHERE rol = 'PERSONA'");
    
    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if(isset($_POST['leer'])){
   $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT id_usuario, 
        nombreyapellido, cedula, rol, estado, intentos, limite_intentos
FROM usuarios 
ORDER BY id_usuario desc");
    
    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if(isset($_POST['leer_id'])){
   $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT id_usuario, 
        nombreyapellido, cedula, rol, estado, intentos, limite_intentos
FROM usuarios 
WHERE id_usuario = :id");
    
    $query->execute([
        "id" => $_POST['leer_id']
    ]);

    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}

