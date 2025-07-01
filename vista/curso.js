function mostrarListarCurso() {
    let contenido = dameContenido("paginas/movimientos/curso/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaCursos();
}

function mostrarAgregarCurso() {
    let contenido = dameContenido("paginas/movimientos/curso/agregar.php");
    $("#contenido-principal").html(contenido);
}

async function guardarCurso() {
    if($("#descripcion").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("El campo descripcion no puede estar vacio", "ATENCION");
        return;
    }
    let payload = {
        descripcion: $("#descripcion").val(),
        estado: $("#estado").val()
    };
    let body_content = new URLSearchParams();
    let mensaje = 'Curso guardado correctamente';
    if($("#id_curso_edicion").val() === "0"){
        body_content.append('guardar', JSON.stringify(payload));
    }else{
        payload = {...payload, id_curso: $("#id_curso_edicion").val()};
        body_content.append('actualizar', JSON.stringify(payload));
        mensaje = 'Curso actualizado correctamente';
    }
    const response = await fetch('controlador/curso.php', {
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
    mostrarListarCurso();
}

async function cargarTablaCursos(){
    let data = ejecutarAjax("controlador/curso.php", "leer=1");
    let fila = "";
    if(data === "0"){
        fila = "NO HAY REGISTROS";
    }else{
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_curso}</td>`;
            fila += `<td>${item.descripcion}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-curso'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-curso'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }
    $("#curso_tb").html(fila);
}

$(document).on("click", ".editar-curso", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let registro = ejecutarAjax("controlador/curso.php", "leer_id="+id);
    let json_registro = JSON.parse(registro);
    mostrarAgregarCurso();
    $("#descripcion").val(json_registro.descripcion);
    $("#estado").val(json_registro.estado);
    $("#id_curso_edicion").val(json_registro.id_curso);
});

$(document).on("click", ".eliminar-curso", function(){
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
            ejecutarAjax("controlador/curso.php", "eliminar="+id);
            mensaje_dialogo_success("Registro eliminado", "Exitoso");
            mostrarListarCurso();
        }
    });
});
