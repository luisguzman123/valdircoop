function mostrarListarCursoEspecialidad() {
    let contenido = dameContenido("paginas/movimientos/curso_especialidad/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaCursoEspecialidad();
}

function mostrarAgregarCursoEspecialidad() {
    let contenido = dameContenido("paginas/movimientos/curso_especialidad/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaCursos("#curso_id");
    cargarListaEspecialidad("#especialidad_id");
}

async function guardarCursoEspecialidad() {
    if($("#curso_id").val()===null){
        mensaje_dialogo_info_ERROR("Debe seleccionar un curso","ATENCION");
        return;
    }
    if($("#especialidad_id").val()===null){
        mensaje_dialogo_info_ERROR("Debe seleccionar una especialidad","ATENCION");
        return;
    }
    let payload = {
        id_curso: $("#curso_id").val(),
        id_especialidad: $("#especialidad_id").val(),
        estado: $("#estado").val()
    };
    let body_content = new URLSearchParams();
    let mensaje = 'Registro guardado correctamente';
    if($("#id_curso_especialidad_edicion").val() === "0"){
        body_content.append('guardar', JSON.stringify(payload));
    }else{
        payload = {...payload, id_curso_especialidad: $("#id_curso_especialidad_edicion").val()};
        body_content.append('actualizar', JSON.stringify(payload));
        mensaje = 'Registro actualizado correctamente';
    }
    const response = await fetch('controlador/curso_especialidad.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
        body: body_content
    });
    const text = await response.text();
    if(text.trim().length > 0){
        mensaje_dialogo_info(`No se pudo guardar: ${text}`,'Error');
        return;
    }
    mensaje_dialogo_success(mensaje,'Éxitoso');
    mostrarListarCursoEspecialidad();
}

async function cargarTablaCursoEspecialidad(){
    let data = ejecutarAjax('controlador/curso_especialidad.php','leer=1');
    let fila = "";
    if(data === "0"){
        fila = "NO HAY REGISTROS";
    }else{
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_curso_especialidad}</td>`;
            fila += `<td>${item.curso}</td>`;
            fila += `<td>${item.especialidad}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-curso-especialidad'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-curso-especialidad'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }
    $("#curso_especialidad_tb").html(fila);
}

$(document).on("click", ".editar-curso-especialidad", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let registro = ejecutarAjax('controlador/curso_especialidad.php', 'leer_id='+id);
    let json_registro = JSON.parse(registro);
    mostrarAgregarCursoEspecialidad();
    $("#curso_id").val(json_registro.id_curso).trigger('change');
    $("#especialidad_id").val(json_registro.id_especialidad).trigger('change');
    $("#estado").val(json_registro.estado);
    $("#id_curso_especialidad_edicion").val(json_registro.id_curso_especialidad);
});

$(document).on("click", ".eliminar-curso-especialidad", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    Swal.fire({
        title:'Atencion',
        text:'Desea eliminar el registro?',
        icon:'question',
        showCancelButton:true,
        confirmButtonColor:'#3085d6',
        cancelButtonColor:'#d33',
        cancelButtonText:'No',
        confirmButtonText:'Si'
    }).then((result)=>{
        if(result.isConfirmed){
            ejecutarAjax('controlador/curso_especialidad.php','eliminar='+id);
            mensaje_dialogo_success('Registro eliminado','Exitoso');
            mostrarListarCursoEspecialidad();
        }
    });
});

async function cargarListaCursos(selector){
    const $sel = $(selector).empty().append($('<option>',{value:'',text:'Selecciona un curso',disabled:true,selected:true}));
    try{
        const resp = await fetch('controlador/curso.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
            body:new URLSearchParams({leer:'1'})
        });
        if(!resp.ok) throw new Error(resp.status);
        const datos = await resp.json();
        datos.forEach(({id_curso, descripcion})=>{
            $sel.append($('<option>',{value:id_curso,text:descripcion}));
        });
        $sel.select2 && $sel.select2({width:'100%',allowClear:true});
    }catch(e){console.error(e);}
}

async function cargarListaEspecialidad(selector){
    const $sel = $(selector).empty().append($('<option>',{value:'',text:'Selecciona una especialidad',disabled:true,selected:true}));
    try{
        const resp = await fetch('controlador/especialidad.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
            body:new URLSearchParams({leer:'1'})
        });
        if(!resp.ok) throw new Error(resp.status);
        const datos = await resp.json();
        datos.forEach(({id_especialidad, descripcion})=>{
            $sel.append($('<option>',{value:id_especialidad,text:descripcion}));
        });
        $sel.select2 && $sel.select2({width:'100%',allowClear:true});
    }catch(e){console.error(e);}
}
