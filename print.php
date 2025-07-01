<?php
include_once './conexion/db.php';

$base_datos = new DB();
$query = $base_datos->conectar()->prepare("SELECT `id_persona`, "
        . "`nombre`, `apellido`, `fecha`, `sexo`, `color`, `foto`"
        . " FROM `persona` where id_persona = :id");

$query->execute([
    'id' => $_GET['id']
]);

$persona = $query->fetch(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Impresion</title>
        <link rel="stylesheet" href="plugins/bootstrap-5.3.3-dist/css/bootstrap.min.css">
        <script src="plugins/jquery-3.7.1.min.js"></script>
        <script src="plugins/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <h3>DATOS DE PERSONA #<?= $_GET['id'] ?></h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>DESCRIPCION</th>
                    <th>VALOR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>NOMBRE</th>
                    <td><?=$persona->nombre?></td>
                </tr>
                <tr>
                    <th>APELLIDO</th>
                    <td><?=$persona->apellido?></td>
                </tr>
                <tr>
                    <th>FECHA DE NACIMIENTO</th>
                    <td><?=$persona->fecha?></td>
                </tr>
                <tr>
                    <th>SEXO</th>
                    <td><?=$persona->sexo?></td>
                </tr>
                <tr>
                    <th>COLOR</th>
                    <td><?=$persona->color?></td>
                </tr>
                <tr>
                    <th>FOTO (Ubicacion)</th>
                    <td><?=$persona->foto?></td>
                </tr>
            </tbody>
        </table>

    </body>
    <script>
        window.print();
    </script>
</html>
