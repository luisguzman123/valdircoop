<?php

require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    guardar($_POST['guardar']);
}

function guardar($lista) {
    //crea un arreglo del texto que se le pasa
    $json_datos = json_decode($lista, true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("INSERT INTO `usuario_admin`( `nombre`, `apellido`, `telefono`, `cedula`, `fecha_nacimiento`, `ubicacion`) "
            . "VALUES (:nombre ,:apellido ,:telefono ,:cedula ,:fecha_nacimiento ,:ubicacion)");

    $query->execute($json_datos);
}

//-----------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------

if(isset($_POST['leer'])){
    leer();
}

function leer(){
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT `id_admin`, `nombre`, `apellido`, `telefono`, `cedula`, `fecha_nacimiento`, `ubicacion` 
        FROM usuario_admin

");
    
    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
if(isset($_POST['id'])){
    id($_POST['id']);
}

function id($id){
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT `id_admin`, `nombre`, `apellido`, `telefono`, `cedula`, `fecha_nacimiento`, `ubicacion` "
            . "FROM usuario_admin "
            . "WHERE id_admin  = $id ");
    
    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetch(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}

//----------------------------------------------------------------
//----------------------------------------------------------------
//----------------------------------------------------------------
if(isset($_POST['actualizar'])){
    actualizar($_POST['actualizar']);
}

function actualizar($lista){
    $json_datos = json_decode($lista, true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("UPDATE usuario_admin 
    SET  nombre = :nombre, apellido = :apellido, telefono = :telefono, cedula = :cedula, fecha_nacimiento =:fecha_nacimiento, ubicacion=:ubicacion 
    WHERE id_admin = :id_admin");

    $query->execute($json_datos);
}

if(isset($_POST['eliminar'])){
    eliminar($_POST['eliminar']);
}

function eliminar($id){
   
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("DELETE FROM usuario_admin where id_admin = $id");

    $query->execute();
}



if (isset($_POST["leer_descripcion"])) {
    
    leer_descripcion($_POST["leer_descripcion"]);
   }
   function leer_descripcion ($usuario_admin){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT `id_admin`, `nombre`, `apellido`, 
       `telefono`, `cedula`, `fecha_nacimiento`, `ubicacion` 
           FROM usuario_admin
WHERE CONCAT(id_admin, nombre, apellido, telefono, cedula, fecha_nacimiento, ubicacion)
 LIKE '%$usuario_admin%'
ORDER BY id_admin DESC
LIMIT 50");
       $query ->execute ();
       
      if ($query->rowCount()) {
           print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
       } else {
           echo '0';
       }
   }

   

   if (isset($_POST['leer_usuario_admin'])) {
    leer_usuario_admin();
}

function leer_usuario_admin() {
//    $json_datos = json_decode($lista, true);
    $base_datos = new DB();

    $query = $base_datos->conectar()->prepare(" SELECT `id_admin`, `nombre`, `apellido`,
     `telefono`, `cedula`, `fecha_nacimiento`, `ubicacion` 
        FROM usuario_admin");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}


if (isset($_POST["leer_descripcion_usuario_admin"])) {
    
    leer_descripcion_usuario_admin($_POST["leer_descripcion_usuario_admin"]);
   }
   function leer_descripcion_usuario_admin ($id_admin){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT `id_admin`, `nombre`, `apellido`, `telefono`, `cedula`, `fecha_nacimiento`, `ubicacion` 
           FROM usuario_admin
WHERE CONCAT(id_admin, ' ' , usuario_admin) LIKE '%$id_admin%'");
       $query ->execute ();
       
      if ($query->rowCount()) {
           print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
       } else {
           echo '0';
       }
   }