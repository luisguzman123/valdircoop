<?php
include_once './controlador/JuradoSession.php';
$session = new JuradoSession();
if (!$session->juradoLogeado()) {
    header('Location: login_jurado.php');
    exit;
}
include_once './conexion/db.php';
$db = new DB();
$stmt = $db->conectar()->prepare("SELECT id_especialidad, descripcion FROM especialidades WHERE estado='ACTIVO' ORDER BY descripcion");
$stmt->execute();
$especialidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
$iconos = [
    1 => 'typcn-book',
    2 => 'typcn-leaf',
    3 => 'typcn-heart',
    4 => 'typcn-device-desktop',
    5 => 'typcn-lightbulb',
    6 => 'typcn-briefcase',
    7 => 'typcn-cog',
    8 => 'typcn-code-outline',
    9 => 'typcn-folder',
    10 => 'typcn-social-foursquare'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Especialidades</title>
    <link rel="stylesheet" href="vendors/typicons/typicons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="plugins/sweetalert/sweetalert2.min.css">
    <script src="plugins/sweetalert/sweetalert2.min.js"></script>
    <link rel="shortcut icon" href="images/logo-nido.png" />
</head>
<body>
<div class="container-scroller">

    <div class="content-wrapper p-4" id="content-area">
        <h3 class="mb-4">Seleccione una especialidad</h3>
        <div class="row" id="especialidades-row">

    <div class="content-wrapper p-4">
        <h3 class="mb-4">Seleccione una especialidad</h3>
        <div class="row">

            <?php foreach ($especialidades as $esp): $icon = $iconos[$esp['id_especialidad']] ?? 'typcn-star'; ?>
            <div class="col-md-4 mb-3">
                <div class="card specialty-card" data-id="<?= $esp['id_especialidad']; ?>">
                    <div class="card-body text-center">
                        <i class="typcn <?= $icon ?>" style="font-size:48px;"></i>
                        <h5 class="card-title mt-2"><?= $esp['descripcion']; ?></h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <h4 class="mt-4">Cursos vinculados</h4>
        <ul id="lista-cursos" class="list-group"></ul>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/template.js"></script>
<script>

function renderCourses(cursos) {
    var html = '<h3 class="mb-4">Seleccione un curso</h3><div class="row">';
    cursos.forEach(function(c){
        html += '<div class="col-md-4 mb-3">';
        html += '  <div class="card course-card" data-id="'+c.id_curso+'">';
        html += '    <div class="card-body text-center">';
        html += '      <i class="typcn typcn-bookmark" style="font-size:48px;"></i>';
        html += '      <h5 class="card-title mt-2">'+c.descripcion+'</h5>';
        html += '    </div></div></div>';
    });
    html += '</div>';
    $('#content-area').html(html);
}

function renderProjects(projects){
    var html = '<h3 class="mb-4">Proyectos</h3><div class="row">';
    projects.forEach(function(p){
        html += '<div class="col-md-4 mb-3">';
        html += '  <div class="card project-card">';
        html += '    <div class="card-body text-center">';
        html += '      <i class="typcn typcn-folder" style="font-size:48px;"></i>';
        html += '      <h5 class="card-title mt-2">'+p.descripcion+'</h5>';
        html += '    </div></div></div>';
    });
    html += '</div>';
    $('#content-area').html(html);
}

$(document).on('click', '.specialty-card', function(){
    var id = $(this).data('id');
    $.ajax({
        method:'POST',
        url:'controlador/curso_especialidad.php',
        data:{cursos_por_especialidad:id},
        success:function(data){
            data = $.trim(data);
            if(data === '0'){
                $('#content-area').html('<p>No hay cursos para esta especialidad</p>');
            }else{
                try{ var cursos = JSON.parse(data); renderCourses(cursos); }catch(e){ $('#content-area').html('<p>Error al cargar cursos</p>'); }
            }
        },
        error:function(){ $('#content-area').html('<p>Error de conexión</p>'); }
    });
});

$(document).on('click','.course-card',function(){
    var id = $(this).data('id');
    $.ajax({
        method:'POST',
        url:'controlador/proyecto_curso.php',
        data:{proyectos_por_curso:id},
        success:function(data){
            data = $.trim(data);
            if(data === '0'){
                $('#content-area').html('<p>No hay proyectos para este curso</p>');
            }else{
                try{ var proyectos = JSON.parse(data); renderProjects(proyectos); }catch(e){ $('#content-area').html('<p>Error al cargar proyectos</p>'); }
            }
        },
        error:function(){ $('#content-area').html('<p>Error de conexión</p>'); }




$('.specialty-card').on('click', function(){
    var id = $(this).data('id');
    $.post('controlador/curso_especialidad.php', {cursos_por_especialidad:id}, function(data){
        var list = $('#lista-cursos').empty();
        if(data === '0'){
            list.append('<li class="list-group-item">No hay cursos</li>');
        } else {
            var cursos = JSON.parse(data);
            cursos.forEach(function(c){
                list.append('<li class="list-group-item">'+c.descripcion+'</li>');
            });

        }

    });
});
</script>
</body>
</html>
