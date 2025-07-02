function mostrarListarJurado() {
    let contenido = dameContenido("paginas/movimientos/jurado/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaJurados();
}

function mostrarAgregarJurado() {
    let contenido = dameContenido("paginas/movimientos/jurado/agregar.php");
    $("#contenido-principal").html(contenido);
}

async function guardarJurado() {
    if($("#nombre_apellido").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("El campo nombre no puede estar vacio", "ATENCION");
        return;
    }
    if($("#cedula_j").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("El campo cedula no puede estar vacio", "ATENCION");
        return;
    }
    if($("#pass_j").val().trim().length === 0 && $("#id_jurado_edicion").val() === "0"){
        mensaje_dialogo_info_ERROR("El campo contraseña no puede estar vacio", "ATENCION");
        return;
    }
    let payload = {
        nombre_apellido: $("#nombre_apellido").val(),
        cedula: $("#cedula_j").val(),
        pass: $("#pass_j").val(),
        estado: $("#estado_j").val()
    };
    let body = new URLSearchParams();
    let mensaje = 'Jurado guardado correctamente';
    if($("#id_jurado_edicion").val() === "0"){
        body.append('guardar', JSON.stringify(payload));
    }else{
        payload.id_jurado = $("#id_jurado_edicion").val();
        body.append('actualizar', JSON.stringify(payload));
        mensaje = 'Jurado actualizado correctamente';
    }
    const resp = await fetch('controlador/jurado.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},body:body});
    const text = await resp.text();
    if(text.trim().length > 0){
        mensaje_dialogo_info(`No se pudo guardar: ${text}`,'Error');
        return;
    }
    mensaje_dialogo_success(mensaje,'Éxitoso');
    mostrarListarJurado();
}

async function cargarTablaJurados(){
    let data = ejecutarAjax('controlador/jurado.php','leer=1');
    let fila = '';
    if(data === '0'){
        fila = 'NO HAY REGISTROS';
    }else{
        let json = JSON.parse(data);
        json.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_jurado}</td>`;
            fila += `<td>${item.nombre_apellido}</td>`;
            fila += `<td>${item.cedula}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>`+
                        `<button class='btn btn-warning editar-jurado'><i class='fa fa-edit'></i> Editar</button> `+
                        `<button class='btn btn-danger eliminar-jurado'><i class='fa fa-trash'></i> Eliminar</button>`+
                    `</td>`;
            fila += `</tr>`;
        });
    }
    $("#jurado_tb").html(fila);
}

$(document).on('click','.editar-jurado', function(){
    let id = $(this).closest('tr').find('td:eq(0)').text();
    let registro = ejecutarAjax('controlador/jurado.php','leer_id='+id);
    let json = JSON.parse(registro);
    mostrarAgregarJurado();
    $("#nombre_apellido").val(json.nombre_apellido);
    $("#cedula_j").val(json.cedula);
    $("#pass_j").val(json.pass);
    $("#estado_j").val(json.estado);
    $("#id_jurado_edicion").val(json.id_jurado);
});

$(document).on('click','.eliminar-jurado', function(){
    let id = $(this).closest('tr').find('td:eq(0)').text();
    Swal.fire({title:'Atencion',text:'Desea eliminar el registro?',icon:'question',showCancelButton:true,confirmButtonText:'Si',cancelButtonText:'No'}).then(res=>{
        if(res.isConfirmed){
            ejecutarAjax('controlador/jurado.php','eliminar='+id);
            mensaje_dialogo_success('Registro eliminado','Exitoso');
            cargarTablaJurados();
        }
    });
});
