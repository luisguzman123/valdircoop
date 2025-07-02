<?php
include_once './controlador/JuradoSession.php';
$session = new JuradoSession();
if (!$session->juradoLogeado()) {
    header('Location: login_jurado.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: menu_jurado.php');
    exit;
}

include_once './conexion/db.php';
$db = new DB();
$c = $db->conectar();

// Obtener cabecera del indicador
$q = $c->prepare("SELECT ic.titulo, ic.nro_stand, c.descripcion AS curso, p.descripcion AS proyecto FROM indicador_cabecera ic INNER JOIN proyecto_curso pc ON pc.id_proyecto_curso = ic.id_proyecto_curso INNER JOIN cursos c ON c.id_curso = pc.id_curso INNER JOIN proyectos p ON p.id_proyecto = pc.id_proyecto WHERE ic.id_indicador_cabecera = :id");
$q->execute(['id' => $_GET['id']]);
$cabecera = $q->fetch(PDO::FETCH_OBJ);

// Obtener detalles
$qdet = $c->prepare("SELECT id_indicador_detalle, descripcion, puntaje,  logrado FROM indicador_detalle WHERE id_indicador_cabecera = :id ORDER BY id_indicador_detalle");
$qdet->execute(['id' => $_GET['id']]);
$detalles = $qdet->fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificar Indicador</title>
    <link rel="stylesheet" href="plugins/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/sweetalert/sweetalert2.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h3 class="mb-3">Indicador #<?= htmlspecialchars($_GET['id']) ?></h3>
        <table class="table table-bordered">
            <tbody>
                <tr><th>Título</th><td><?= htmlspecialchars($cabecera->titulo) ?></td></tr>
                <tr><th>Curso</th><td><?= htmlspecialchars($cabecera->curso) ?></td></tr>
                <tr><th>Proyecto</th><td><?= htmlspecialchars($cabecera->proyecto) ?></td></tr>
                <tr><th>Nro Stand</th><td><?= htmlspecialchars($cabecera->nro_stand) ?></td></tr>
            </tbody>
        </table>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Puntaje</th>
                        <th>Logrado</th>
                    </tr>
                </thead>
                <tbody id="detalles_tb">
                <?php foreach ($detalles as $d): ?>
                    <tr data-id="<?= $d->id_indicador_detalle ?>">
                        <td><?= htmlspecialchars($d->descripcion) ?></td>
                        <td class="puntaje_td"><?= htmlspecialchars($d->puntaje) ?></td>
                        <td><input type="number" min="0" max="<?= htmlspecialchars($d->puntaje) ?>" class="form-control logrado_input" value="<?= htmlspecialchars($d->logrado) ?>"></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button id="guardar_btn" class="btn btn-success">Guardar</button>
        <a href="menu_jurado.php" class="btn btn-secondary">Volver</a>
    </div>
<script src="plugins/jquery-3.7.1.min.js"></script>
<script src="plugins/sweetalert/sweetalert2.min.js"></script>
<script>
$(function(){
    $('#guardar_btn').on('click', function(){
        var detalles = [];
        var valido = true;
        $('#detalles_tb tr').each(function(){
            var id = $(this).data('id');
            var input = $(this).find('.logrado_input');
            var val = parseFloat(input.val());
            var max = parseFloat(input.attr('max'));
            if(val > max){
                valido = false;
                input.addClass('is-invalid');
            }else{
                input.removeClass('is-invalid');
            }
            detalles.push({id:id, logrado:val});
        });
        if(!valido){
            Swal.fire('Advertencia','El valor logrado no puede superar el puntaje establecido','warning');
            return;
        }
        $.ajax({
            method:'POST',
            url:'controlador/indicador.php',
            data:{calificar:JSON.stringify({id_indicador:<?= (int)$_GET['id'] ?>,detalles:detalles})},
            success:function(resp){
                resp = $.trim(resp);
                if(resp.length===0){
                    Swal.fire('Éxito','Calificación guardada','success');
                }else{
                    Swal.fire('Error','No se pudo guardar: '+resp,'error');
                }
            },
            error:function(){
                Swal.fire('Error','No se pudo conectar con el servidor','error');
            }
        });
    });
});
</script>
</body>
</html>
