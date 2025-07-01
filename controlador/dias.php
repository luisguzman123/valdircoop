<?php

require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    guardar($_POST['guardar']);
}

function guardar($lista) {
    //crea un arreglo del texto que se le pasa
    $json_datos = json_decode($lista, true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("INSERT INTO"
            . " `dias`( `dia`, `estado`, id_empresa) VALUES (:dia,:estado, ".$_POST['id_empresa'].")");

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
    $query = $base_datos->conectar()->prepare("SELECT id_dia, dia,estado 
     FROM dias");
    
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
    $query = $base_datos->conectar()->prepare("SELECT id_dia, dia, estado
        FROM dias
        WHERE id_dia = $id");

    
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
    $query = $base_datos->conectar()->prepare("UPDATE dias
     SET dia=:dia,estado=:estado
     WHERE id_dia = :id_dia");

    $query->execute($json_datos);
}

if(isset($_POST['eliminar'])){
    eliminar($_POST['eliminar']);
}

function eliminar($id){
   
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("DELETE FROM dias where id_dia = $id");

    $query->execute();
}



if (isset($_POST["leer_descripcion"])) {
    
    leer_descripcion($_POST["leer_descripcion"]);
   }
   function leer_descripcion ($dia){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT id_dia, dia, estado
     FROM dias
WHERE CONCAT(id_dia, dia, estado) LIKE '%$dia%'
ORDER BY id_dia DESC
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

function leer_dias_activos() {
//    $json_datos = json_decode($lista, true);
    $base_datos = new DB();

    $query = $base_datos->conectar()->prepare(" SELECT id_dia, dia, estado 
     FROM dias
");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}


if (isset($_POST["leer_descripcion_dias"])) {
    
    leer_descripcion_dias($_POST["leer_descripcion_dias"]);
   }
   function leer_descripcion_dias ($id_dia){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT id_dia, dia, direccion,estado 
     FROM dias
WHERE CONCAT(id_dia, ' ' , dia) LIKE '%$id_dia%'");
       $query ->execute ();
       
      if ($query->rowCount()) {
           print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
       } else {
           echo '0';
       }
   }
//----------------------------------------------------------------
//----------------------------------------------------------------
//----------------------------------------------------------------
if(isset($_POST['actualizar_estado'])){
    actualizarEstado();
}

function actualizarEstado(){
  
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("UPDATE dias
     SET estado=:estado
     WHERE id_dia = :id_dia");

    $query->execute([
        "id_dia" => $_POST['id'],
        "estado" => $_POST['actualizar_estado']
    ]);
}