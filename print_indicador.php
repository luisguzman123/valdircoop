<?php
include_once './conexion/db.php';

$base_datos = new DB();
$c = $base_datos->conectar();

$query = $c->prepare("SELECT ic.titulo, ic.nro_stand, ic.estado, c.descripcion AS curso, p.descripcion AS proyecto FROM indicador_cabecera ic INNER JOIN proyecto_curso pc ON pc.id_proyecto_curso=ic.id_proyecto_curso INNER JOIN cursos c ON c.id_curso=pc.id_curso INNER JOIN proyectos p ON p.id_proyecto=pc.id_proyecto WHERE ic.id_indicador_cabecera=:id");
$query->execute(['id' => $_GET['id']]);
$indicador = $query->fetch(PDO::FETCH_OBJ);

$qdet = $c->prepare("SELECT descripcion, puntaje, logrado FROM indicador_detalle WHERE id_indicador_cabecera=:id ORDER BY id_indicador_detalle");
$qdet->execute(['id' => $_GET['id']]);
$detalles = $qdet->fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Impresion</title>
    <link rel="stylesheet" href="plugins/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
    <h3>Indicador #<?= $_GET['id'] ?></h3>
    <table class="table table-bordered">
        <tbody>
            <tr><th>Titulo</th><td><?= $indicador->titulo ?></td></tr>
            <tr><th>Curso</th><td><?= $indicador->curso ?></td></tr>
            <tr><th>Proyecto</th><td><?= $indicador->proyecto ?></td></tr>
            <tr><th>Nro Stand</th><td><?= $indicador->nro_stand ?></td></tr>
            <tr><th>Estado</th><td><?= $indicador->estado ?></td></tr>
        </tbody>
    </table>
    <h4>Detalles</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Descripcion</th>
                <th>Puntaje</th>
                <th>Logrado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($detalles as $d): ?>
            <tr>
                <td><?= $d->descripcion ?></td>
                <td><?= $d->puntaje ?></td>
                <td><?= $d->logrado ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
<script>window.print();</script>
</html>
