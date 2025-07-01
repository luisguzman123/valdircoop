<?php

require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    guardar($_POST['guardar']);
}

function guardar($lista) {
    //crea un arreglo del texto que se le pasa
    $json_datos = json_decode($lista, true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("INSERT INTO `turno`(`id_turno`, "
            . "`id_cliente`, `id_usuario`, `fecha` `dia` `hora` `estado` `id_profesional` `id_sucursal`)"
            . "VALUES (:id_turno ,:id_cliente ,:id_usuario ,:fecha ,:dia ,:hora ,:estado ,:id_profesional ,:id_sucursal)");

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
    $query = $base_datos->conectar()->prepare("SELECT
    t.id_turno,
c.nombre as nombre_cliente,
c.apellido as apellido_cliente,
c.telefono,
u.nombre as nombre_usuario,
u.apellido as apellido_usuario,
r.fecha,
d.dia,
r.hora,
r.estado,
p.nombre as profesional_nombre,
p.apellido as profesional_apellido,
p.cedula,
p.especialidad,
p.estado as profesional_estado,
s.sucursal,
s.direccion,
s.ubicacion_maps,
t.estado
FROM turno t 
LEFT JOIN cliente c 
ON t.id_turno = c.id_cliente
LEFT JOIN usuario u 
ON t.id_turno = u.id_usuario
LEFT JOIN profesional p 
ON t.id_turno = p.id_profesional
LEFT JOIN sucursales s 
ON t.id_turno = s.id_sucursal
LEFT JOIN recepcion r 
ON t.id_turno = r.id_recepcion
LEFT JOIN dias d 
ON t.id_turno = d.id_dia

");
    
    $query->execute();

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}
//-----------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------

if(isset($_POST['leer_busqueda'])){
    leer_busqueda();
}

function leer_busqueda(){
    $json_datos = json_decode($_POST['leer_busqueda'], true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT
    t.id_turno,
c.nombre as nombre_cliente,
c.apellido as apellido_cliente,
c.telefono,
u.nombre as nombre_usuario,
u.apellido as apellido_usuario,
r.estado,
p.nombre as profesional_nombre,
p.apellido as profesional_apellido,
p.cedula,
p.especialidad,
p.estado as profesional_estado,
s.sucursal,
s.direccion,
s.ubicacion_maps,
t.fecha as fecha_turno,
t.hora as hora_turno,
t.estado
FROM turno t 
LEFT JOIN cliente c 
ON t.id_turno = c.id_cliente
LEFT JOIN usuario u 
ON t.id_turno = u.id_usuario
LEFT JOIN profesional p 
ON t.id_turno = p.id_profesional
LEFT JOIN sucursales s 
ON t.id_turno = s.id_sucursal
LEFT JOIN recepcion r 
ON t.id_turno = r.id_recepcion
LEFT JOIN dias d 
ON t.id_turno = d.id_dia
 WHERE t.fecha BETWEEN :desde AND :hasta 
        and trim(t.estado) = :estado
        LIMIT 300
");
    
    $query->execute($json_datos);

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
    $query = $base_datos->conectar()->prepare("SELECT
c.nombre,
c.apellido,
c.telefono,
u.nombre,
u.apellido,
r.fecha,
d.dia,
r.hora,
r.estado,
p.nombre,
p.apellido,
p.cedula,
p.especialidad,
p.estado,
s.sucursal,
s.direccion,
s.ubicacion_maps,
s.estado
FROM turno t 
LEFT JOIN cliente c 
ON t.id_turno = c.id_cliente
LEFT JOIN usuario u 
ON t.id_turno = u.id_usuario
LEFT JOIN profesional p 
ON t.id_turno = p.id_profesional
LEFT JOIN sucursales s 
ON t.id_turno = s.id_sucursal
LEFT JOIN recepcion r 
ON t.id_turno = r.id_recepcion
LEFT JOIN dias d 
ON t.id_turno = d.id_dia;  = $id ");
    
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
    $query = $base_datos->conectar()->prepare("UPDATE turno
     SET id_cliente=:id_cliente,
     id_usuario=:id_usuario, fecha= :fecha
     dia=:dia, hora= :hora
     estado=:estado, id_profesional= :id_profesional
     id_sucursal=:id_sucursal
     WHERE id_turno = :id_turno");

    $query->execute($json_datos);
}

if(isset($_POST['eliminar'])){
    eliminar($_POST['eliminar']);
}

function eliminar($id){
   
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("DELETE FROM turno where id_turno = $id");

    $query->execute();
}



if (isset($_POST["leer_descripcion"])) {
    
    leer_descripcion($_POST["leer_descripcion"]);
   }
   function leer_descripcion ($turno){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT
c.nombre,
c.apellido,
c.telefono,
u.nombre,
u.apellido,
r.fecha,
d.dia,
r.hora,
r.estado,
p.nombre,
p.apellido,
p.cedula,
p.especialidad,
p.estado,
s.sucursal,
s.direccion,
s.ubicacion_maps,
s.estado
FROM turno t 
LEFT JOIN cliente c 
ON t.id_turno = c.id_cliente
LEFT JOIN usuario u 
ON t.id_turno = u.id_usuario
LEFT JOIN profesional p 
ON t.id_turno = p.id_profesional
LEFT JOIN sucursales s 
ON t.id_turno = s.id_sucursal
LEFT JOIN recepcion r 
ON t.id_turno = r.id_recepcion
LEFT JOIN dias d 
ON t.id_turno = d.id_dia;");
       $query ->execute ();
       
      if ($query->rowCount()) {
           print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
       } else {
           echo '0';
       }
   }

   

   if (isset($_POST['leer_turno'])) {
    leer_turno();
}

function leer_turno() {
//    $json_datos = json_decode($lista, true);
    $base_datos = new DB();

    $query = $base_datos->conectar()->prepare("SELECT                                                                                                           
    t.id                                                                _turno
c.nombre,                                               
c.apellido,
c.telefono,                                                                                                
u.nombre,
u.apellido,
r.fecha,
d.dia,
r.hora,
r.estado,
p.nombre,
p.apellido,
p.cedula,
p.especialidad,
p.estado,
s.sucursal,
s.direccion,
s.ubicacion_maps,
s.estado
FROM turno t 
LEFT JOIN cliente c 
ON t.id_turno = c.id_cliente
LEFT JOIN usuario u 
ON t.id_turno = u.id_usuario
LEFT JOIN profesional p 
ON t.id_turno = p.id_profesional
LEFT JOIN sucursales s 
ON t.id_turno = s.id_sucursal
LEFT JOIN recepcion r 
ON t.id_turno = r.id_recepcion
LEFT JOIN dias d 
ON t.id_turno = d.id_dia;
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
   function leer_descripcion_cliente ($id_turno){
       $base = new DB();
       $query = $base ->conectar()->prepare("SELECT
c.nombre,
c.apellido,
c.telefono,
u.nombre,
u.apellido,
r.fecha,
d.dia,
r.hora,
r.estado,
p.nombre,
p.apellido,
p.cedula,
p.especialidad,
p.estado,
s.sucursal,
s.direccion,
s.ubicacion_maps,
s.estado
FROM turno t 
WHERE CONCAT(id_turno, ' ' , turno) LIKE '%$id_turno%'");
       $query ->execute ();
       
      if ($query->rowCount()) {
           print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
       } else {
           echo '0';
       }
   }