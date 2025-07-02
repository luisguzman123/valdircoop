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

        
        <ul id="lista-cursos" class="list-group"></ul>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/template.js"></script>
<script>
var JURADO_ID = <?= $_SESSION['id_jurado']; ?>;

var historyStack = [];

function pushState(){
    historyStack.push($('#content-area').html());
}

function goBack(){
    if(historyStack.length > 0){
        var prev = historyStack.pop();
        $('#content-area').html(prev);
    }
}

function renderMessage(msg){
    pushState();
    var html = '<button id="back-btn" class="btn btn-primary mb-3"><i class="typcn typcn-arrow-left"></i> Atr\u00e1s</button>';
    html += '<p>' + msg + '</p>';
    $('#content-area').html(html);
}

function renderCourses(cursos) {
    pushState();
    var html = '<button id="back-btn" class="btn btn-primary mb-3"><i class="typcn typcn-arrow-left"></i> Atrás</button>';
    html += '<h3 class="mb-4">Seleccione un curso</h3><div class="row">';
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
    pushState();
    var html = '<button id="back-btn" class="btn btn-primary mb-3"><i class="typcn typcn-arrow-left"></i> Atrás</button>';
    html += '<h3 class="mb-4">Proyectos</h3><div class="row">';
    projects.forEach(function(p){
        html += '<div class="col-md-4 mb-3">';
        html += '  <div class="card project-card" data-id="'+p.id_proyecto_curso+'">';
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
                renderMessage('No hay cursos para esta especialidad');
            }else{
                try{ var cursos = JSON.parse(data); renderCourses(cursos); }catch(e){ renderMessage('Error al cargar cursos'); }
            }
        },
        error:function(){ renderMessage('Error de conexión'); }
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
                renderMessage('No hay proyectos para este curso');
            }else{
                try{ var proyectos = JSON.parse(data); renderProjects(proyectos); }catch(e){ renderMessage('Error al cargar proyectos'); }
            }
        },
        error:function(){ renderMessage('Error de conexión'); }



    });
});

$(document).on('click','.project-card',function(){
    var id = $(this).data('id');
    $.ajax({
        method:'POST',
        url:'controlador/indicador.php',
        data:{existe_jurado_proyecto:1,id_proyecto_curso:id,id_jurado:JURADO_ID},
        success:function(data){
            data = $.trim(data);
            if(data === '0'){
                Swal.fire({
                    title:'¿Desea calificar el proyecto?',
                    icon:'question',
                    showCancelButton:true,
                    confirmButtonText:'Si',
                    cancelButtonText:'No'
                }).then(function(res){
                    if(res.isConfirmed){
                        $.ajax({
                            method:'POST',
                            url:'controlador/indicador.php',
                            data:{crear_para_jurado:1,id_proyecto_curso:id,id_jurado:JURADO_ID},
                            success:function(resp){
                                resp = $.trim(resp);
                                if(resp !== '0'){
                                    window.location.href='print_indicador.php?id='+resp;
                                }else{
                                    renderMessage('No se pudo crear evaluación');
                                }
                            },
                            error:function(){ renderMessage('Error de conexión'); }
                        });
                    }
                });
            }else{
                window.location.href='print_indicador.php?id='+data;
            }
        },
        error:function(){ renderMessage('Error de conexión'); }
    });
});

$(document).on('click','#back-btn',function(){
    goBack();
});
</script>
</body>
</html>
