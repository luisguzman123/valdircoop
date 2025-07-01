function mostrarListarEspecialidad() {
    let contenido = dameContenido("paginas/movimientos/especialidad/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaEspecialidades();
}

function mostrarAgregarEspecialidad() {
    let contenido = dameContenido("paginas/movimientos/especialidad/agregar.php");
    $("#contenido-principal").html(contenido);
}

async function guardarEspecialidad() {
    if($("#descripcion").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("El campo descripcion no puede estar vacio", "ATENCION");
        return;
    }
    let payload = {
        descripcion: $("#descripcion").val(),
        estado: $("#estado").val()
    };
    let body_content = new URLSearchParams();
    let mensaje = 'Especialidad guardada correctamente';
    if($("#id_especialidad_edicion").val() === "0"){ 
        body_content.append('guardar', JSON.stringify(payload));
    }else{
        payload = {...payload, id_especialidad: $("#id_especialidad_edicion").val()};
        body_content.append('actualizar', JSON.stringify(payload));
        mensaje = 'Especialidad actualizada correctamente';
    }
    const response = await fetch('controlador/especialidad.php', {
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
    mostrarListarEspecialidad();
}

async function cargarTablaEspecialidades(){
    let data = ejecutarAjax("controlador/especialidad.php", "leer=1");
    let fila = "";
    if(data === "0"){
        fila = "NO HAY REGISTROS";
    }else{
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_especialidad}</td>`;
            fila += `<td>${item.descripcion}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-especialidad'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-especialidad'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }
    $("#especialidad_tb").html(fila);
}

$(document).on("click", ".editar-especialidad", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let registro = ejecutarAjax("controlador/especialidad.php", "leer_id="+id);
    let json_registro = JSON.parse(registro);
    mostrarAgregarEspecialidad();
    $("#descripcion").val(json_registro.descripcion);
    $("#estado").val(json_registro.estado);
    $("#id_especialidad_edicion").val(json_registro.id_especialidad);
});

$(document).on("click", ".eliminar-especialidad", function(){
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
            ejecutarAjax("controlador/especialidad.php", "eliminar="+id);
            mensaje_dialogo_success("Registro eliminado", "Exitoso");
            mostrarListarEspecialidad();
        }
    });
});
