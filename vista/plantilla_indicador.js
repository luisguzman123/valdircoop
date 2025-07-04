
let tmpIdCounter = 1;


function mostrarListarPlantilla(){
    let contenido = dameContenido("paginas/movimientos/plantilla_indicador/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaPlantillas();
}

function mostrarAgregarPlantilla(){
    let contenido = dameContenido("paginas/movimientos/plantilla_indicador/agregar.php");
    $("#contenido-principal").html(contenido);
    tmpIdCounter = 1;
    cargarListaEspecialidad("#especialidad_id");
}


async function guardarCabecera(){

    if($("#especialidad_id").val()===null){
        mensaje_dialogo_info_ERROR("Debe seleccionar una especialidad","Atenci\u00f3n");
        return;
    }

    let datos = {
        id_especialidad: $("#especialidad_id").val(),
        estado: $("#estado_cab").val()
    };
    let body = new URLSearchParams();
    let mensaje = 'Cabecera guardada, ahora agregue los detalles';
    if($("#id_cabecera_edicion").val()==='0'){
        body.append('guardar_cabecera', JSON.stringify(datos));
    }else{
        datos.id_plantilla_indicador_cabecera = $("#id_cabecera_edicion").val();
        body.append('actualizar_cabecera', JSON.stringify(datos));
        mensaje = 'Cabecera actualizada';

    }
    const resp = await fetch('controlador/plantilla_indicador.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
        body: body
    });

    const id = await resp.text();
    if($("#id_cabecera_edicion").val()==='0'){
        $("#id_cabecera_edicion").val(id.trim());
    }
    mensaje_dialogo_success(mensaje,'\u00c9xitoso');
}


async function agregarFilaDetalle(data = null) {

    if($("#id_cabecera_edicion").val()==='0'){
        mensaje_dialogo_info_ERROR('Debe guardar la cabecera primero','Atenci\u00f3n');
        return;
    }

    if(!data){
        let payload = {
            id_cabecera: $("#id_cabecera_edicion").val(),
            descripcion:'',
            puntaje:0,
            orden:0,
            id_padre:0,
            estado:'ACTIVO'
        };
        let body = new URLSearchParams();
        body.append('guardar_detalle', JSON.stringify(payload));
        const resp = await fetch('controlador/plantilla_indicador.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
            body: body
        });
        const id = await resp.text();
        data = {...payload, id_plantilla_indicador_detalle:id.trim()};
    }
    let idDetalle = data.id_plantilla_indicador_detalle;
    let descripcion = (data.descripcion ?? '').replace(/"/g, '&quot;');
    let puntaje = data.puntaje ?? 0;
    let orden = data.orden ?? data.nivel ?? 0;
    let idPadre = data.id_padre ?? 0;
    let estado = data.estado ?? 'ACTIVO';

    let fila = `<tr data-id="${idDetalle}">
        <td class="id_det">${idDetalle}</td>
        <td><input type="text" class="form-control desc_det" value="${descripcion}"></td>
        <td><input type="number" class="form-control puntaje_det" value="${puntaje}"></td>
        <td><input type="number" class="form-control orden_det" value="${orden}"></td>
        <td><input type="number" class="form-control padre_det" value="${idPadre}"></td>
        <td>
            <select class="form-control estado_det">
                <option value="ACTIVO" ${estado === 'ACTIVO' ? 'selected' : ''}>Activo</option>
                <option value="INACTIVO" ${estado === 'INACTIVO' ? 'selected' : ''}>Inactivo</option>
            </select>
        </td>
        <td>
            <button class="btn btn-success actualizar-detalle"><i class='fa fa-save'></i></button>
            <button class="btn btn-danger eliminar-detalle"><i class='fa fa-trash'></i></button>
        </td>
    </tr>`;

    $("#detalle_tb").append(fila);
}



$(document).on('click','.actualizar-detalle', function(){
    guardarDetalle($(this).closest('tr'));
});

$(document).on('click','.eliminar-detalle', function(){
    const $tr = $(this).closest('tr');
    const id = $tr.data('id')||0;
    if(id===0){
        $tr.remove();
    }else{
        Swal.fire({title:'Atenci\u00f3n', text:'Desea eliminar el detalle?', icon:'question', showCancelButton:true, confirmButtonText:'Si', cancelButtonText:'No'}).then(r=>{
            if(r.isConfirmed){
                ejecutarAjax('controlador/plantilla_indicador.php','eliminar_detalle='+id);
                $tr.remove();
            }
        });
    }
});

function cargarTablaPlantillas(){
    let data = ejecutarAjax('controlador/plantilla_indicador.php','leer_cabeceras=1');
    let fila = '';
    if(data !== '0'){
        let json = JSON.parse(data);
        json.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_plantilla_indicador_cabecera}</td>`;
            fila += `<td>${item.especialidad}</td>`;
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


async function guardarDetalle($tr){
    let payload = {
        id_cabecera: $("#id_cabecera_edicion").val(),
        descripcion: $tr.find('.desc_det').val(),
        puntaje: $tr.find('.puntaje_det').val(),
        orden: $tr.find('.orden_det').val(),
        id_padre: $tr.find('.padre_det').val(),
        estado: $tr.find('.estado_det').val()
    };
    let body = new URLSearchParams();
    if(($tr.data('id')||0)===0){
        body.append('guardar_detalle', JSON.stringify(payload));
    }else{
        payload.id_plantilla_indicador_detalle = $tr.data('id');
        body.append('actualizar_detalle', JSON.stringify(payload));
    }
    const resp = await fetch('controlador/plantilla_indicador.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
        body: body
    });
    const id = await resp.text();
    if(($tr.data('id')||0)===0){
        $tr.attr('data-id', id.trim());
    }
    mensaje_dialogo_success('Detalle guardado','\u00c9xitoso');
}


async function guardarPlantilla(){
    if($("#especialidad_id").val()===null){
        mensaje_dialogo_info_ERROR('Debe seleccionar una especialidad','Atenci\u00f3n');
        return;
    }
    let cabecera = {
        id_especialidad: $("#especialidad_id").val(),
        estado: $("#estado_cab").val()
    };
    if($("#id_cabecera_edicion").val() !== '0'){
        cabecera.id_plantilla_indicador_cabecera = $("#id_cabecera_edicion").val();
    }
    let detalles = [];
    $("#detalle_tb tr").each(function(){
        const $tr = $(this);
        let obj = {
            descripcion: $tr.find('.desc_det').val(),
            puntaje: $tr.find('.puntaje_det').val(),
            orden: $tr.find('.orden_det').val(),
            id_padre: $tr.find('.padre_det').val(),
            estado: $tr.find('.estado_det').val(),
            tmp_id: $tr.data('tmp')
        };
        if($tr.data('id')) obj.id_detalle = $tr.data('id');
        detalles.push(obj);
    });
    let payload = {cabecera, detalles};
    let body = new URLSearchParams();
    if($("#id_cabecera_edicion").val()==='0'){
        body.append('guardar_completo', JSON.stringify(payload));
    }else{
        body.append('actualizar_completo', JSON.stringify(payload));
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
    mensaje_dialogo_success('Plantilla guardada','\u00c9xitoso');
    mostrarListarPlantilla();
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