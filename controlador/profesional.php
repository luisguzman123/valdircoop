<?php

require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    guardar($_POST['guardar']);
}

function guardar($lista) {
    session_start(); // Asegurate que esto esté al principio si no se ha llamado antes

    if (!isset($_SESSION['id_empresa'])) {
        die("❌ No hay empresa activa en sesión.");
    }

    $id_empresa = $_SESSION['id_empresa'];

    // Decodificamos los datos del formulario
    $json_datos = json_decode($lista, true);

    // Agregamos el id_empresa al array que se va a insertar (si tu tabla lo necesita)
    $json_datos['id_empresa'] = $id_empresa;

    // Conectamos a la base de datos
    $base_datos = new DB();

    $query = $base_datos->conectar()->prepare("INSERT INTO `profesional`(
        `nombre`, `apellido`, `cedula`, `especialidad`, `estado`, `id_sucursal`, `id_empresa`) 
        VALUES(:nombre,:apellido,:cedula,:especialidad,:estado,:id_sucursal, :id_empresa)");
    

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
    $query = $base_datos->conectar()->prepare("SELECT id_profesional, nombre, apellido, cedula, especialidad, estado, id_sucursal 
     FROM profesional

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
    $query = $base_datos->conectar()->prepare("SELECT id_profesional, nombre,apellido,cedula,especialidad, estado, id_sucursal
        FROM profesional
        WHERE id_profesional = $id");

    
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
    $query = $base_datos->conectar()->prepare("UPDATE profesional
     SET nombre=:nombre,apellido=:apellido,cedula=:cedula,especialidad=:especialidad,estado=:estado,id_sucursal=:id_sucursal
     WHERE id_profesional = :id_profesional");

    $query->execute($json_datos);
}

if(isset($_POST['eliminar'])){
    eliminar($_POST['eliminar']);
}

function eliminar($id){
   
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("DELETE FROM profesional where id_profesional = $id");

    $query->execute();
}



if (isset($_POST["leer_descripcion"])) {
    
    leer_descripcion($_POST["leer_descripcion"]);
   }
   function leer_descripcion ($profesional){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT id_profesional, nombre,apellido,cedula,especialidad, estado
        FROM profesional
WHERE CONCAT(id_profesional, nombre,apellido,cedula,especialidad, estado) LIKE '%$profesional%'
ORDER BY id_profesional DESC
LIMIT 50");
       $query ->execute ();
       
      if ($query->rowCount()) {
           print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
       } else {
           echo '0';
       }
   }

   

   if (isset($_POST['leer_profesionales_activos'])) {
    leer_profesionales_activos();
}

function leer_profesionales_activos() {
//    $json_datos = json_decode($lista, true);
    $base_datos = new DB();

    $query = $base_datos->conectar()->prepare(" SELECT id_profesional, nombre,apellido,cedula,especialidad, estado
        FROM profesional
");

    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}


if (isset($_POST["leer_descripcion_profesional"])) {
    
    leer_descripcion_dias($_POST["leer_descripcion_profesional"]);
   }
   function leer_descripcion_profesional ($id_profesional){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT id_profesional, nombre, apellido, cedula, especialidad, estado
        FROM profesional
WHERE CONCAT(id_profesional, ' ' , nombre) LIKE '%$id_profesional%'");
       $query ->execute ();
       
      if ($query->rowCount()) {
           print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
       } else {
           echo '0';
       }
   }

   if(isset($_POST['disponible'])){
    //leer
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("select 
p.id_profesional ,
p.nombre ,
p.apellido ,
p.especialidad ,
p.estado 
from profesional p 
join profesional_horario ph on p.id_profesional = ph.id_profesional 
where p.estado = 'ACTIVO' and ph.estado = 'ACTIVO' and ph.id_horario_atencion = :id");
    
    $query->execute([
        "id" => $_POST['disponible']
    ]);

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}
