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
        datos = null;
    }

    if(datos && Array.isArray(datos.por_curso)){
        const cont = $("#resultados_cnt");
        cont.html('');
        const grupos = {};
        datos.por_curso.forEach(d => {
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

    let fila = '';
    if(datos && Array.isArray(datos.por_curso)){
        let i = 1;
        datos.por_curso.forEach(d => {
            fila += `<tr>
                        <td>${i++}</td>
                        <td>${d.especialidad}</td>
                        <td>${d.curso}</td>
                        <td>${d.total_logrado}</td>
                      </tr>`;
        });
    }
    $("#resultados_tb").html(fila);

    // Resultados por proyecto
    if(datos && Array.isArray(datos.por_proyecto)){
        const cont = $("#resultados_proyecto_cnt");
        cont.html('');
        const grupos = {};
        datos.por_proyecto.forEach(d => {
            if(!grupos[d.curso]){
                grupos[d.curso] = [];
            }
            grupos[d.curso].push(d);
        });
        Object.keys(grupos).forEach(cur => {
            let html = `<h4>${cur}</h4>`;
            html += '<div class="table-responsive">';
            html += '<table class="table table-bordered table-striped table-head-bg-primary mt-2">';
            html += '<thead><tr><th>#</th><th>Proyecto</th><th>Puntaje Total</th></tr></thead><tbody>';
            grupos[cur].forEach((r, idx) => {
                html += `<tr><td>${idx + 1}</td><td>${r.proyecto}</td><td>${r.total_logrado}</td></tr>`;
            });
            html += '</tbody></table></div>';
            cont.append(html);
        });
    } else {
        $("#resultados_proyecto_cnt").html('');
    }

    // Premios
    if(datos && datos.mejor_curso){
        const cont = $("#premio_curso_cnt");
        cont.html('');
        Object.keys(datos.mejor_curso).forEach(cur => {
            const r = datos.mejor_curso[cur];
            cont.append(`<p><strong>${cur}:</strong> ${r.proyecto} (${r.total_logrado} puntos)</p>`);
        });
    } else {
        $("#premio_curso_cnt").html('');
    }

    if(datos && datos.mejor_especialidad){
        const cont = $("#premio_especialidad_cnt");
        cont.html('');
        Object.keys(datos.mejor_especialidad).forEach(esp => {
            const r = datos.mejor_especialidad[esp];
            cont.append(`<p><strong>${esp}:</strong> ${r.proyecto} (${r.total_logrado} puntos)</p>`);
        });
    } else {
        $("#premio_especialidad_cnt").html('');
    }

}
