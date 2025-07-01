async function cargarListaUsuario(selector) {
    const $select = $(selector).empty()
            .append($('<option>', {
                value: '',
                text: 'Selecciona un usuario',
                disabled: true,
                selected: true
            }));

    try {
        // 1) Enviar petición POST con fetch
        const response = await fetch('controlador/usuario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
            },
            body: new URLSearchParams({leer_persona: '1'})
        });

        // 2) Verificar estado HTTP
        if (!response.ok) {
            throw new Error(`HTTP ${response.status} – ${response.statusText}`);
        }

        // 3) Parsear JSON en un solo paso
        const datos = await response.json();
        if (!Array.isArray(datos) || datos.length === 0)
            return;

        // 4) Poblar <select>
        datos.forEach(({ id_usuario, nombreyapellido }) => {
            $select.append($('<option>', {
                value: id_usuario,
                text: nombreyapellido
            }));
        });

        $select.select2({
            placeholder: 'Selecciona un usuario',
            allowClear: true,
            width: '100%'            // Para que ocupe el ancho completo del contenedor
        });


    } catch (err) {
        console.error('Error al cargar turnos:', err);
        // aquí podrías añadir un mensaje de error al DOM, un toast, etc.
    }
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function mostrarListarUsuario() {
    let contenido = dameContenido("paginas/movimientos/usuario/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaUsuarios();
   
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------guardarMedidas()

function mostrarAgregarUsuario() {
    let contenido = dameContenido("paginas/movimientos/usuario/agregar.php");
    $("#contenido-principal").html(contenido);
   
}
async function guardarUsuario() {
    //VALIDACION DE CAMPO VACIO
    if($("#nombreyapellido").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("El campo nombre y apellido no puede estar vacio", "ATENCION");
        return;
    }
    
    if($("#cedula").val().trim().length === 0){
        mensaje_dialogo_info_ERROR("El campo cedula no puede estar vacio", "ATENCION");
        return;
    }
    
    if($("#contrasena").val().trim().length === 0 
            && $("#id_usuario_edicion").val() === "0"){
        mensaje_dialogo_info_ERROR("El campo contraseña no puede estar vacio", "ATENCION");
        return;
    }
    
    if($("#rol").val() === "0"){
        mensaje_dialogo_info_ERROR("Debes seleccionar un rol", "ATENCION");
        return;
    }
    
    if($("#estado").val() === "0"){
        mensaje_dialogo_info_ERROR("Debes seleccionar un estado", "ATENCION");
        return;
    }


// 4. Armar objeto de datos
    let payload = {
        nombreyapellido: $("#nombreyapellido").val(),
        cedula: $("#cedula").val(),
        contrasena: $("#contrasena").val(),
        rol: $("#rol").val(),
        estado: $("#estado").val()
    };
    // 5. Enviar por AJAX moderno (fetch)
    let mensaje = 'Usuario guardado correctamente';
    try {
        let body_content = new URLSearchParams({guardar: JSON.stringify(payload)});
        if($("#id_usuario_edicion").val() !== "0"){
            mensaje = "Usuario acualizado correctamente";
            
            payload = {...payload, "id_usuario" : $("#id_usuario_edicion").val()};
            if($("#contrasena").val().trim().length === 0){
                body_content = new URLSearchParams({actualizar_sin_contra: JSON.stringify(payload)});
            }else{
                body_content = new URLSearchParams({actualizar_con_contra: JSON.stringify(payload)});
                
            }
        }
        console.log(body_content);
        const response = await fetch('controlador/usuario.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'},
            body: body_content
        });
        if (!response.ok) {
            throw new Error(`Error HTTP ${response.status}`);
        }

        const text = await response.text();
        if (text.trim().length > 0) {
            // El controlador devuelve algo distinto de '1'  
            mensaje_dialogo_info(`No se pudo guardar: ${text}`, 'Error');
            return;
        }

        // 6. Éxito
        mensaje_dialogo_success(mensaje, 'Éxitoso');
        mostrarListarUsuario(); // función que recarga la lista de registros

    } catch (err) {
        console.error('Error guardando medidas:', err);
        mensaje_dialogo_info('Ocurrió un error al guardar usuario', 'Error');
    }
}
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
async function cargarTablaUsuarios(){
    let data = ejecutarAjax("controlador/usuario.php", "leer=1");


    let fila = "";
    if (data === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.id_usuario}</td>`;
            fila += `<td>${item.nombreyapellido}</td>`;
            fila += `<td>${item.cedula}</td>`;
            fila += `<td>${item.rol}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-usuario'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-usuario'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }

    $("#usuario_tb").html(fila);
}
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
$(document).on("click", ".editar-usuario", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    let registro = ejecutarAjax("controlador/usuario.php", "leer_id="+id);
    console.log(registro);
    let json_registro = JSON.parse(registro);
    
    mostrarAgregarUsuario();
    
    $("#nombreyapellido").val(json_registro.nombreyapellido);
    $("#cedula").val(json_registro.cedula);
    $("#rol").val(json_registro.rol);
    $("#estado").val(json_registro.estado);
    $("#intentos").val(json_registro.intentos);
    $("#limite_intentos").val(json_registro.limite_intentos);
    $("#id_usuario_edicion").val(json_registro.id_usuario);
    $("#intentos").closest("div").removeAttr("hidden");
    $("#limite_intentos").closest("div").removeAttr("hidden");
    
});