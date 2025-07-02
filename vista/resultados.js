function mostrarResultados(){
    let contenido = dameContenido("paginas/movimientos/resultados/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaResultados();
}

async function cargarTablaResultados(){
    const body = new URLSearchParams();
    body.append('leer_resultados', '1');
    const response = await fetch('controlador/resultados.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'},
        body
    });
    let datos = await response.text();
    try{
        datos = JSON.parse(datos);
    }catch(e){
        datos = [];
    }
    if(Array.isArray(datos)){
        const cont = $("#resultados_cnt");
        cont.html('');
        const grupos = {};
        datos.forEach(d => {
            if(!grupos[d.especialidad]){
                grupos[d.especialidad] = [];
            }
            grupos[d.especialidad].push(d);
        });
        Object.keys(grupos).forEach(esp => {
            let html = `<h4>${esp}</h4>`;
            html += '<div class="table-responsive">';
            html += '<table class="table table-bordered table-striped table-head-bg-primary mt-2">';
            html += '<thead><tr><th>#</th><th>Curso</th><th>Puntaje Total</th></tr></thead><tbody>';
            grupos[esp].forEach((r, idx) => {
                html += `<tr><td>${idx + 1}</td><td>${r.curso}</td><td>${r.total_logrado}</td></tr>`;
            });
            html += '</tbody></table></div>';
            cont.append(html);
        });
    } else {
        $("#resultados_cnt").html('');
    }
}
