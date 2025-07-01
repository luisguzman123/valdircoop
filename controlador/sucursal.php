<?php

require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    guardar($_POST['guardar']);
}

function guardar($lista) {
    session_start(); // Asegurate que esto esté al principio del archivo o dentro de la función si es necesario

    if (!isset($_SESSION['id_empresa'])) {
        die("❌ No hay empresa activa en sesión.");
    }

    $id_empresa = $_SESSION['id_empresa'];

    // Decodificamos los datos del formulario
    $json_datos = json_decode($lista, true);

    // Agregamos el id_empresa al array que se va a insertar
    $json_datos['id_empresa'] = $id_empresa;

    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("INSERT INTO `sucursales`(
        `sucursal`, `direccion`, `telefono`, `ubicacion_maps`, `estado`, `id_empresa`)
        VALUES (:sucursal, :direccion, :telefono, :ubicacion_maps, :estado, :id_empresa)");

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
    $query = $base_datos->conectar()->prepare("SELECT `id_sucursal`, `sucursal`, `direccion`,
     `telefono`, `ubicacion_maps`, `estado` 
     FROM `sucursales`

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
    $query = $base_datos->conectar()->prepare("SELECT `id_sucursal`, `sucursal`, `direccion`,
     `telefono`, `ubicacion_maps`, `estado` 
     FROM `sucursales`
      WHERE id_sucursal  = $id ");
    
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
    $query = $base_datos->conectar()->prepare("UPDATE `sucursales`
     SET `sucursal`=:sucursal,`direccion`=:direccion,`telefono`=:telefono, `ubicacion_maps`= :ubicacion_maps, `estado` = :estado
     WHERE `id_sucursal` = :id_sucursal");

    $query->execute($json_datos);
}

if(isset($_POST['eliminar'])){
    eliminar($_POST['eliminar']);
}

function eliminar($id){
   
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("DELETE FROM `sucursales` where id_sucursal = $id");

    $query->execute();
}



if (isset($_POST["leer_descripcion"])) {
    
    leer_descripcion($_POST["leer_descripcion"]);
   }
   function leer_descripcion ($sucursal){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT `id_sucursal`, `sucursal`, `direccion`,
     `telefono`, `ubicacion_maps`, `estado`
     FROM `sucursales`
WHERE CONCAT(id_sucursal, sucursal, direccion, telefono, ubicacion_maps, estado) LIKE '%$sucursal%'
ORDER BY id_sucursal DESC
LIMIT 50");
       $query ->execute ();
       
      if ($query->rowCount()) {
           print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
       } else {
           echo '0';
       }
   }

   

   if (isset($_POST['leer_sucursal_activos'])) {
    leer_sucursal_activos();
}

function leer_sucursal_activos() {
//    $json_datos = json_decode($lista, true);
    $base_datos = new DB();

    $query = $base_datos->conectar()->prepare(" SELECT `id_sucursal`,
     `sucursal`, `direccion`, `telefono`, `ubicacion_maps`,
      `estado`, `id_empresa` 
      FROM `sucursales`
");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}


if (isset($_POST["leer_descripcion_cliente"])) {
    
    leer_descripcion_cliente($_POST["leer_descripcion_cliente"]);
   }
   function leer_descripcion_cliente ($id_sucursal){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT `id_sucursal`, `sucursal`, `direccion`,
     `telefono`, `ubicacion_maps`, `estado` 
     FROM `sucursales`
WHERE CONCAT(id_sucursal, ' ' , sucursal) LIKE '%$id_sucursal%'");
       $query ->execute ();
       
      if ($query->rowCount()) {
           print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
       } else {
           echo '0';
       }
   }