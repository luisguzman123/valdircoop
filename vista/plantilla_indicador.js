function mostrarListarPlantilla(){
    let contenido = dameContenido("paginas/movimientos/plantilla_indicador/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaPlantillas();
}

function mostrarAgregarPlantilla(){
    let contenido = dameContenido("paginas/movimientos/plantilla_indicador/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaEspecialidad("#especialidad_id");
}

async function guardarPlantilla(){
    if($("#especialidad_id").val()===null){
        mensaje_dialogo_info_ERROR("Debe seleccionar una especialidad","Atenci\u00f3n");
        return;
    }
    let cab = {
        id_plantilla_indicador_cabecera: $("#id_cabecera_edicion").val(),
        id_especialidad: $("#especialidad_id").val(),
        estado: $("#estado_cab").val()
    };
    let detalles = [];
    $("#detalle_tb tr").each(function(index){
        let fila = {
            tmp_id: index+1,
            id_detalle: $(this).data('id')||0,
            descripcion: $(this).find('.desc_det').val(),
            puntaje: $(this).find('.puntaje_det').val(),
            orden: $(this).find('.orden_det').val(),
            id_padre: $(this).find('.padre_det').val(),
            estado: $(this).find('.estado_det').val()
        };
        if(fila.descripcion) detalles.push(fila);
    });
    let payload = {cabecera:cab, detalles:detalles};
    let body = new URLSearchParams();
    let mensaje = 'Plantilla guardada correctamente';
    if(cab.id_plantilla_indicador_cabecera === '0'){
        body.append('guardar_completo', JSON.stringify(payload));
    }else{
        body.append('actualizar_completo', JSON.stringify(payload));
        mensaje = 'Plantilla actualizada correctamente';
    }
    const resp = await fetch('controlador/plantilla_indicador.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
        body: body
    });
    const text = await resp.text();
    if(text.trim().length>0){
        mensaje_dialogo_info(`No se pudo guardar: ${text}`,'Error');
        return;
    }
    mensaje_dialogo_success(mensaje,'\u00c9xitoso');
    mostrarListarPlantilla();
}

function agregarFilaDetalle(data=null){
    let fila = `<tr data-id="${data?data.id_plantilla_indicador_detalle:0}">
        <td><input type="text" class="form-control desc_det" value="${data?data.descripcion:''}"></td>
        <td><input type="number" class="form-control puntaje_det" value="${data?data.puntaje:0}"></td>
        <td><input type="number" class="form-control orden_det" value="${data?data.orden||data.nivel||0}"></td>
        <td><input type="number" class="form-control padre_det" value="${data?data.id_padre:0}"></td>
        <td><select class="form-control estado_det">
                <option value="ACTIVO" ${(data&&data.estado==='ACTIVO')?'selected':''}>Activo</option>
                <option value="INACTIVO" ${(data&&data.estado==='INACTIVO')?'selected':''}>Inactivo</option>
            </select></td>
        <td><button class="btn btn-danger remover-detalle"><i class='fa fa-trash'></i></button></td>
    </tr>`;
    $("#detalle_tb").append(fila);
}

$(document).on('click','.remover-detalle', function(){
    $(this).closest('tr').remove();
});

function cargarTablaPlantillas(){
    let data = ejecutarAjax('controlador/plantilla_indicador.php','leer_cabeceras=1');
    let fila = '';
    if(data !== '0'){
        let json = JSON.parse(data);
        json.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_plantilla_indicador_cabecera}</td>`;
            fila += `<td>${item.id_especialidad}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-plantilla'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-plantilla'><i class='fa fa-trash'></i> Eliminar</button>
                     </td>`;
            fila += `</tr>`;
        });
    }else{
        fila = 'NO HAY REGISTROS';
    }
    $("#plantilla_cabecera_tb").html(fila);
}

$(document).on('click','.editar-plantilla', function(){
    let id = $(this).closest('tr').find('td:eq(0)').text();
    let registro = ejecutarAjax('controlador/plantilla_indicador.php','leer_cabecera_id='+id);
    let cab = JSON.parse(registro);
    mostrarAgregarPlantilla();
    $("#especialidad_id").val(cab.id_especialidad);
    $("#estado_cab").val(cab.estado);
    $("#id_cabecera_edicion").val(cab.id_plantilla_indicador_cabecera);
    let detalles = ejecutarAjax('controlador/plantilla_indicador.php','leer_detalles='+id);
    if(detalles !== '0'){
        JSON.parse(detalles).forEach(d=>agregarFilaDetalle(d));
    }
});

$(document).on('click','.eliminar-plantilla', function(){
    let id = $(this).closest('tr').find('td:eq(0)').text();
    Swal.fire({
        title:'Atencion',
        text:'Desea eliminar el registro?',
        icon:'question',
        showCancelButton:true,
        confirmButtonText:'Si',
        cancelButtonText:'No'
    }).then(result=>{
        if(result.isConfirmed){
            ejecutarAjax('controlador/plantilla_indicador.php','eliminar_cabecera='+id);
            mensaje_dialogo_success('Registro eliminado','Exitoso');
            cargarTablaPlantillas();
        }
    });
});

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
