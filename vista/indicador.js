function mostrarListarIndicador(){
    let contenido = dameContenido("paginas/movimientos/indicador/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaIndicador();
}

function mostrarAgregarIndicador(){
    let contenido = dameContenido("paginas/movimientos/indicador/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaProyectoCurso("#proyecto_curso_id");
    cargarListaPlantillas("#plantilla_id");
}

async function guardarIndicador(){
    if($("#proyecto_curso_id").val()===null){
        mensaje_dialogo_info_ERROR('Debe seleccionar un proyecto curso','Atencion');
        return;
    }
    if($("#plantilla_id").val()===null){
        mensaje_dialogo_info_ERROR('Debe seleccionar una plantilla','Atencion');
        return;
    }
    let payload = {
        id_proyecto_curso: $("#proyecto_curso_id").val(),
        id_plantilla: $("#plantilla_id").val(),
        nro_stand: $("#nro_stand").val(),
        titulo: $("#titulo").val(),
        estado: $("#estado_ind").val()
    };
    let body = new URLSearchParams();
    let mensaje = 'Registro guardado correctamente';
    if($("#id_indicador_edicion").val()==='0'){
        body.append('guardar', JSON.stringify(payload));
    }else{
        payload.id_indicador_cabecera = $("#id_indicador_edicion").val();
        body.append('actualizar', JSON.stringify(payload));
        mensaje = 'Registro actualizado correctamente';
    }
    const resp = await fetch('controlador/indicador.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
        body: body
    });
    const text = await resp.text();
    if(text.trim().length>0){
        mensaje_dialogo_info(`No se pudo guardar: ${text}`,'Error');
        return;
    }
    mensaje_dialogo_success(mensaje,'Exitoso');
    mostrarListarIndicador();
}

async function cargarTablaIndicador(){
    let data = ejecutarAjax('controlador/indicador.php','leer=1');
    let fila = '';
    if(data !== '0'){
        let json = JSON.parse(data);
        json.map(function(item){
            fila += `<tr>`;
            fila += `<td>${item.id_indicador_cabecera}</td>`;
            fila += `<td>${item.titulo}</td>`;
            fila += `<td>${item.curso}</td>`;
            fila += `<td>${item.proyecto}</td>`;
            fila += `<td>${item.nro_stand}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>`+
                    `<button class='btn btn-warning editar-indicador'><i class='fa fa-edit'></i> Editar</button> `+
                    `<a class='btn btn-info imprimir-indicador' target='_blank' href='print_indicador.php?id=${item.id_indicador_cabecera}'><i class='fa fa-print'></i></a> `+
                    `<button class='btn btn-danger eliminar-indicador'><i class='fa fa-trash'></i> Eliminar</button>`+
                    `</td>`;
            fila += `</tr>`;
        });
    }else{
        fila = 'NO HAY REGISTROS';
    }
    $("#indicador_tb").html(fila);
}

$(document).on('click','.editar-indicador', function(){
    let id = $(this).closest('tr').find('td:eq(0)').text();
    let registro = ejecutarAjax('controlador/indicador.php','leer_id='+id);
    let cab = JSON.parse(registro);
    mostrarAgregarIndicador();
    $("#proyecto_curso_id").val(cab.id_proyecto_curso).trigger('change');
    $("#plantilla_id").val(cab.id_plantilla).trigger('change');
    $("#nro_stand").val(cab.nro_stand);
    $("#titulo").val(cab.titulo);
    $("#estado_ind").val(cab.estado);
    $("#id_indicador_edicion").val(cab.id_indicador_cabecera);
});

$(document).on('click','.eliminar-indicador', function(){
    let id = $(this).closest('tr').find('td:eq(0)').text();
    Swal.fire({title:'Atencion', text:'Desea eliminar el registro?', icon:'question', showCancelButton:true, confirmButtonText:'Si', cancelButtonText:'No'}).then(result=>{
        if(result.isConfirmed){
            ejecutarAjax('controlador/indicador.php','eliminar='+id);
            mensaje_dialogo_success('Registro eliminado','Exitoso');
            cargarTablaIndicador();
        }
    });
});

async function cargarListaProyectoCurso(selector){
    const $sel = $(selector).empty().append($('<option>',{value:'',text:'Selecciona un proyecto curso',disabled:true,selected:true}));
    try{
        const resp = await fetch('controlador/proyecto_curso.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},body:new URLSearchParams({leer:'1'})});
        if(!resp.ok) throw new Error(resp.status);
        const datos = await resp.json();
        datos.forEach(({id_proyecto_curso, curso, proyecto})=>{
            $sel.append($('<option>',{value:id_proyecto_curso,text:`${curso} - ${proyecto}`}));
        });
        $sel.select2 && $sel.select2({width:'100%',allowClear:true});
    }catch(e){console.error(e);}
}

async function cargarListaPlantillas(selector){
    const $sel = $(selector).empty().append($('<option>',{value:'',text:'Selecciona una plantilla',disabled:true,selected:true}));
    try{
        const resp = await fetch('controlador/plantilla_indicador.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},body:new URLSearchParams({leer_cabeceras:'1'})});
        if(!resp.ok) throw new Error(resp.status);
        const datos = await resp.json();
        datos.forEach(({id_plantilla_indicador_cabecera})=>{
            $sel.append($('<option>',{value:id_plantilla_indicador_cabecera,text:`Plantilla ${id_plantilla_indicador_cabecera}`}));
        });
        $sel.select2 && $sel.select2({width:'100%',allowClear:true});
    }catch(e){console.error(e);}
}


function mostrarCalificarIndicador(){
    let contenido = dameContenido("paginas/movimientos/indicador/calificar.php");
    $("#contenido-principal").html(contenido);
    cargarListaIndicadores("#indicador_id");
}

async function cargarListaIndicadores(selector){
    const $sel = $(selector).empty().append($('<option>',{value:'',text:'Selecciona un indicador',disabled:true,selected:true}));
    try{
        const resp = await fetch('controlador/indicador.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},body:new URLSearchParams({leer:'1'})});
        if(!resp.ok) throw new Error(resp.status);
        const datos = await resp.json();
        datos.forEach(({id_indicador_cabecera,titulo})=>{
            $sel.append($('<option>',{value:id_indicador_cabecera,text:`${id_indicador_cabecera} - ${titulo}`}));
        });
        $sel.select2 && $sel.select2({width:'100%',allowClear:true});
    }catch(e){console.error(e);}
}

async function cargarDetalleCalificar(){
    const id = $("#indicador_id").val();
    if(!id) return;
    const resp = await fetch('controlador/indicador.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},body:new URLSearchParams({leer_detalles:id})});
    if(!resp.ok) return;
    const datos = await resp.json();
    let fila='';
    datos.forEach(d=>{
        fila+=`<tr data-id="${d.id_indicador_detalle}">`+
               `<td>${d.descripcion}</td>`+
               `<td>${d.puntaje}</td>`+
               `<td><input type='number' class='form-control logrado_det' value='${d.logrado}'></td>`+
               `</tr>`;
    });
    $("#calificar_tb").html(fila);
}

async function guardarCalificacion(){
    const id = $("#indicador_id").val();
    if(!id){
        mensaje_dialogo_info_ERROR('Debe seleccionar un indicador','Atención');
        return;
    }
    let detalles=[];
    $("#calificar_tb tr").each(function(){
        detalles.push({id:$(this).data('id'),logrado:$(this).find('.logrado_det').val()});
    });
    const body = new URLSearchParams();
    body.append('calificar', JSON.stringify({id_indicador:id,detalles}));
    const resp = await fetch('controlador/indicador.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},body});
    const text = await resp.text();
    if(text.trim().length>0){
        mensaje_dialogo_info(`No se pudo guardar: ${text}`,'Error');
        return;
    }
    mensaje_dialogo_success('Calificación guardada','Éxitoso');
}

