function mostrarListarProyectoCurso() {
    let contenido = dameContenido("paginas/movimientos/proyecto_curso/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaProyectoCurso();
}

function mostrarAgregarProyectoCurso() {
    let contenido = dameContenido("paginas/movimientos/proyecto_curso/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaCursos("#curso_id");
    cargarListaProyectos("#proyecto_id");
}

async function guardarProyectoCurso() {
    if($("#curso_id").val()===null){
        mensaje_dialogo_info_ERROR("Debe seleccionar un curso","ATENCION");
        return;
    }
    if($("#proyecto_id").val()===null){
        mensaje_dialogo_info_ERROR("Debe seleccionar un proyecto","ATENCION");
        return;
    }
    let payload = {
        id_curso: $("#curso_id").val(),
        id_proyecto: $("#proyecto_id").val(),
        estado: $("#estado").val()
    };
    let body_content = new URLSearchParams();
    let mensaje = 'Registro guardado correctamente';
    if($("#id_proyecto_curso_edicion").val() === "0"){
        body_content.append('guardar', JSON.stringify(payload));
    }else{
        payload = {...payload, id_proyecto_curso: $("#id_proyecto_curso_edicion").val()};
        body_content.append('actualizar', JSON.stringify(payload));
        mensaje = 'Registro actualizado correctamente';
    }
    const response = await fetch('controlador/proyecto_curso.php', {
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
    mostrarListarProyectoCurso();
}

async function cargarTablaProyectoCurso(){
    let data = ejecutarAjax('controlador/proyecto_curso.php','leer=1');
    let fila = "";
    if(data === "0"){
        fila = "NO HAY REGISTROS";
    }else{
        let json_data = JSON.parse(data);
        json_data.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_proyecto_curso}</td>`;
            fila += `<td>${item.curso}</td>`;
            fila += `<td>${item.proyecto}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-proyecto-curso'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-proyecto-curso'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }
    $("#proyecto_curso_tb").html(fila);
}

$(document).on("click", ".editar-proyecto-curso", function(){
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let registro = ejecutarAjax('controlador/proyecto_curso.php', 'leer_id='+id);
    let json_registro = JSON.parse(registro);
    mostrarAgregarProyectoCurso();
    $("#curso_id").val(json_registro.id_curso).trigger('change');
    $("#proyecto_id").val(json_registro.id_proyecto).trigger('change');
    $("#estado").val(json_registro.estado);
    $("#id_proyecto_curso_edicion").val(json_registro.id_proyecto_curso);
});

$(document).on("click", ".eliminar-proyecto-curso", function(){
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
            ejecutarAjax('controlador/proyecto_curso.php','eliminar='+id);
            mensaje_dialogo_success('Registro eliminado','Exitoso');
            mostrarListarProyectoCurso();
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

async function cargarListaProyectos(selector){
    const $sel = $(selector).empty().append($('<option>',{value:'',text:'Selecciona un proyecto',disabled:true,selected:true}));
    try{
        const resp = await fetch('controlador/proyecto.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
            body:new URLSearchParams({leer:'1'})
        });
        if(!resp.ok) throw new Error(resp.status);
        const datos = await resp.json();
        datos.forEach(({id_proyecto, descripcion})=>{
            $sel.append($('<option>',{value:id_proyecto,text:descripcion}));
        });
        $sel.select2 && $sel.select2({width:'100%',allowClear:true});
    }catch(e){console.error(e);}
}
