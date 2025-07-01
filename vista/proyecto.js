function mostrarListarProyecto() {
    let contenido = dameContenido("paginas/movimientos/proyecto/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaProyectos();
}

function mostrarAgregarProyecto() {
    let contenido = dameContenido("paginas/movimientos/proyecto/agregar.php");
    $("#contenido-principal").html(contenido);
}

async function guardarProyecto() {
    if($("#descripcion").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("El campo descripcion no puede estar vacio", "ATENCION");
        return;
    }
    let payload = {
        descripcion: $("#descripcion").val(),
        estado: $("#estado").val()
    };
    let body_content = new URLSearchParams();
    let mensaje = 'Proyecto guardado correctamente';
    if($("#id_proyecto_edicion").val() === "0"){
        body_content.append('guardar', JSON.stringify(payload));
    }else{
        payload = {...payload, id_proyecto: $("#id_proyecto_edicion").val()};
        body_content.append('actualizar', JSON.stringify(payload));
        mensaje = 'Proyecto actualizado correctamente';
    }
    const response = await fetch('controlador/proyecto.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'},
        body: body_content
    });
    const text = await response.text();
    if(text.trim().length > 0){
        mensaje_dialogo_info(`No se pudo guardar: ${text}`, 'Error');
        return;
    }
    mensaje_dialogo_success(mensaje, 'Éxitoso');
    mostrarListarProyecto();
}

async function cargarTablaProyectos(){
    let data = ejecutarAjax("controlador/proyecto.php", "leer=1");
    let fila = "";
    if(data === "0"){
        fila = "NO HAY REGISTROS";
    }else{
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_proyecto}</td>`;
            fila += `<td>${item.descripcion}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-proyecto'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-proyecto'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }
    $("#proyecto_tb").html(fila);
}

$(document).on("click", ".editar-proyecto", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let registro = ejecutarAjax("controlador/proyecto.php", "leer_id="+id);
    let json_registro = JSON.parse(registro);
    mostrarAgregarProyecto();
    $("#descripcion").val(json_registro.descripcion);
    $("#estado").val(json_registro.estado);
    $("#id_proyecto_edicion").val(json_registro.id_proyecto);
});

$(document).on("click", ".eliminar-proyecto", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    Swal.fire({
        title: "Atencion",
        text: "Desea eliminar el registro?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "No",
        confirmButtonText: "Si"
    }).then((result)=>{
        if(result.isConfirmed){
            ejecutarAjax("controlador/proyecto.php", "eliminar="+id);
            mensaje_dialogo_success("Registro eliminado", "Exitoso");
            mostrarListarProyecto();
        }
    });
});
