<?php

require_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
     //crea un arreglo del texto que se le pasa
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("INSERT INTO `registro_medidas` 
    (`brazo_izquierdo`, `brazo_derecho`, `pierna_izquierda`, `pierna_derecha`, 
     `cintura`, `cadera`, `fecha`, `usuario_id`, peso
    ) 
   VALUES 
    (:brazo_izquierdo, :brazo_derecho, :pierna_izquierda, :pierna_derecha, 
     :cintura, :cadera, :fecha, :usuario_id, :peso)");

    $query->execute($json_datos);
}
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
if(isset($_POST['get_medidas_usuario'])){
   $base_datos = new DB();
    $query = $base_datos->conectar()->prepare("SELECT `id`, `brazo_izquierdo`, `brazo_derecho`, `pierna_izquierda`, `pierna_derecha`, 
        `cintura`, `cadera`, `fecha`, `usuario_id`, peso FROM `registro_medidas` 
WHERE usuario_id = :id");
    
    $query->execute([
        "id" => $_POST['get_medidas_usuario']
    ]);

    if ($query->rowCount()) {
        print_r(json_encode($query->fetchAll(PDO::FETCH_OBJ)));
    } else {
        echo '0';
    }
}


