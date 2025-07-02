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
    let fila = '';
    if(Array.isArray(datos)){
        let i = 1;
        datos.forEach(d => {
            fila += `<tr>
                        <td>${i++}</td>
                        <td>${d.especialidad}</td>
                        <td>${d.curso}</td>
                        <td>${d.total_logrado}</td>
                      </tr>`;
        });
    }
    $("#resultados_tb").html(fila);
}
