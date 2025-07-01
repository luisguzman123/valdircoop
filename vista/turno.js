function mostrarListarTurnos() {
    let contenido = dameContenido("paginas/turnos/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaTurnos("#turnoss_tb");
}
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
function mostrarAgregarTurnos() {
    let contenido = dameContenido("paginas/turnos/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaSucursal("#turnoss_lst");
}
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
function cancelarTurnos() {
    Swal.fire({
        title: "Atencion",
        text: "Desea cancelar la operacion?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "No",
        confirmButtonText: "Si"
    }).then((result) => {
        if (result.isConfirmed) {
            let contenido = dameContenido("paginas/turnoss/listar.php");
            $("#contenido-principal").html(contenido);
            mostrarListarTurnos();
        }
    });

}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
function guardarTurnos() {

   
        // // Validar el campo 'Nombre y Apellido'
        // if ($("#nom_apell_turnoss").val().trim().length === 0) {
        //     mensaje_turnosslogo_info_ERROR("Atención" , "Debes ingresar el Nombre y Apellido" );
        //     return false;
        // }
    
        // // Validar el campo 'Teléfono'
        // if ($("#telefono").val().trim().length === 0) {
        //     mensaje_turnosslogo_info_ERROR("Atención", "Debes ingresar un número de teléfono");
        //     return false;
        // }
    
        // // Validar que el teléfono solo contenga números
        // if (!/^\d+$/.test($("#telefono").val().trim())) {
        //     mensaje_turnosslogo_info_ERROR("Atención" ,"El teléfono solo debe contener números");
        //     return false;
        // }
    
        // // Validar el campo 'Cédula'
        // if ($("#cedula_turnoss").val().trim().length === 0) {
        //     mensaje_turnosslogo_info_ERROR("Atención" ,"Debes ingresar la cédula del turnoss");
        //     return false;
        // }
    
        // // Validar que la cédula solo contenga números
        // if (!/^\d+$/.test($("#cedula_turnoss").val().trim())) {
        //     mensaje_turnosslogo_info_ERROR("Atención" ,"La cédula solo debe contener números");
        //     return false;
        // }
    
        // // Validar el campo 'Dirección'
        // if ($("#direccion").val().trim().length === 0) {
        //     mensaje_turnosslogo_info_ERROR("Atención" ,"Debes ingresar la dirección del turnoss");
        //     return false;
        // }
    
   
    
       
    
    


    let data = {
        'turnos': $("#turnos").val(),
        'estado': $("#estado").val()

    };


    if ($("#cod_turnoss").val() === "0") {

        let response = ejecutarAjax("controlador/turnos.php", "guardar=" + JSON.stringify(data));
//        console.log(response);
        mensaje_confirmacion("Guardado correctamente", "Guardado");
        mostrarListarTurnos();
console.log(response);
    } else {
        data = {...data, 'id_turnos': $("#cod_turnos").val()};
        let response = ejecutarAjax("controlador/turnos.php",
                "actualizar=" + JSON.stringify(data));
       console.log(response);
        mensaje_confirmacion("Actualizado Correctamente", "Actualizado");
        mostrarListarTurnos();
    }
   

}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function cargarTablaTurnos() {
    let data = ejecutarAjax("controlador/turnos.php", "leer=1");


    let fila = "";
    if (data === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.id_turno}</td>`;
            fila += `<td>${item.nombre_cliente}</td>`;
            fila += `<td>${item.apellido_cliente}</td>`;
            fila += `<td>${item.telefono}</td>`;
            fila += `<td>${item.fecha}</td>`;
            fila += `<td>${item.hora}</td>`;
            fila += `<td>${item.profesional_nombre}</td>`;
            fila += `<td>${item.sucursal}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-turnos'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-turnos'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }

    $("#turnos_tb").html(fila);
}
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
function abrirLink(url){
    console.log(url);
    window.open(url);
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$(document).on("click", ".editar-turnos", function (evt) {
    let id = $(this).closest("tr").find("td:eq(0)").text();
    Swal.fire({
        title: "Atencion",
        text: "Desea editar el registro?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "No",
        confirmButtonText: "Si"
    }).then((result) => {
        if (result.isConfirmed) {
            let response = ejecutarAjax("controlador/turnos.php", "id=" + id);
            console.log(response);
            if (response === "0") {

            } else {
                let json_data = JSON.parse(response);
                //abrir ventana
                let contenido = dameContenido("paginas/turnos/agregar.php");
                $("#contenido-principal").html(contenido);


                //cargar los datos
                let json_registro = JSON.parse(response);
                $("#cod_turnos").val(id);
                $("#turnos").val(json_registro['turnos']);
                $("#estado").val(json_registro['estado']);
            }
        }
    });
});
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$(document).on("click", ".eliminar-turnos", function (evt) {
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
    }).then((result) => {
        if (result.isConfirmed) {
            let response = ejecutarAjax("controlador/turnos.php",
                    "eliminar=" + id);

            console.log(response);
            mensaje_confirmacion("Eliminado Correctamente", "Eliminado");
            mostrarListarTurnos();
        }
    });
});
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$(document).on("keyup", "#b_turnos", function () {
    let valorBusqueda = $("#b_turnos").val().trim(); // Obtener el valor del input
    
    if (valorBusqueda === "") {
        $("#turnoss_tb").html(""); // Limpiar la tabla si el input está vacío
        return;
    }

    $.ajax({
        url: "controlador/turnos.php",
        type: "POST",
        data: { leer_descripcion: valorBusqueda },
        dataType: "json",
        success: function (data) {
            let fila = "";
            
            if (data.length === 0) {
                fila = "<tr><td colspan='5' class='text-center'>NO HAY REGISTROS</td></tr>";
            } else {
                data.forEach(function (item) {
                    fila += `<tr>
                        <td>${item.id_turnos}</td>
                        <td>${item.turnos}</td>
                        <td>${item.telefono}</td>
                        <td>${item.estado}</td>
                        <td>
                            <button class='btn btn-warning editar-turnos' data-id='${item.id_turnos}'><i class='fa fa-edit'></i> Editar</button>
                            <button class='btn btn-danger eliminar-turnos' data-id='${item.id_turnos}'><i class='fa fa-trash'></i> Eliminar</button>
                        </td>
                    </tr>`;
                });
            }

            $("#turnoss_tb").html(fila);
        },
        error: function () {
            console.error("Error al obtener los datos de turnos.");
        }
    });
});

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
function imprimirTurnos() {
    window.open("paginas/referenciales/turnoss/print.php");
}

function cargarListaTurnos(componente) {
    let datos = ejecutarAjax("controlador/turnoss.php", "leer_turnosss_activos=1");
    console.log(datos);
    let option = "";
    if (datos === "0") {
        option = "<option value='0'>Selecciona un turnoss</option>";
    } else {
        option = "<option value='0'>Selecciona un turnoss</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function (item) {
            option += `<option value='${item.id_turnoss}'>${item.turnoss}</option>`;


        });
    }
    $(componente).html(option);
}
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
function cargarListaTurnos(componente) {
    let datos = ejecutarAjax("controlador/turnoss.php", "leer_turnosss_activos=1");
    console.log(datos);
    let option = "";
    if (datos === "0") {
        option = "<option value='0'>Selecciona un turnoss</option>";
    } else {
        option = "<option value='0'>Selecciona un turnoss</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function (item) {
            option += `<option value='${item.id_turnoss}-${item.turnoss}'></option>`;


        });
    }
    $(componente).html(option);
}

$(document).on("keyup", "#b_turnoss2", function (evt) {
    let data = ejecutarAjax("controlador/turnos.php", "leer_descripcion_turnoss="+$("#b_turnoss2").val());

    console.log(data);
    let fila = "";
    if (data === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.cod_turnoss}</td>`;
            fila += `<td>${item.nom_apell_turnoss}</td>`;
            fila += `<td>${item.telefono}</td>`;
            fila += `<td>${item.cedula_turnoss}</td>`;
            fila += `<td>${item.direccion}</td>`;
            fila += `<td>${item.descripcion_ciud}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-turnoss'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-turnoss'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }

    $("#turnoss_tb").html(fila);
});


function BuscarTurno() {

    if ($("#desde").val() && $("#hasta").val()) { // Verifica que ambos campos tengan valores
        if (desde > hasta) {
            mensaje_confirmacion("⚠️ La fecha 'Desde' no puede ser mayor que la fecha 'Hasta'.");
            $("#hasta").val(""); // Borra el campo "Hasta"
            return false;
        } 
        if (hasta < desde) {
            mensaje_confirmacion("⚠️ La fecha 'Hasta' no puede ser menor que la fecha 'Desde'.");
            $("#desde").val(""); // Borra el campo "Desde"
            return false;
        }

        let filtro = {
            'desde' : $("#desde").val(),
            'hasta' : $("#hasta").val(),
            'estado' : $("#estado").val().trim()
        };
        console.log(filtro);

    let data = ejecutarAjax("controlador/turnos.php", "leer_busqueda="+JSON.stringify(filtro));
    

    console.log(data);
    let fila = "";
    if (data === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.id_turno}</td>`;
            fila += `<td>${item.nombre_cliente}</td>`;
            fila += `<td>${item.apellido_cliente}</td>`;
            fila += `<td>${item.telefono}</td>`;
            fila += `<td>${item.fecha_turno}</td>`;
            fila += `<td>${item.dia}</td>`;
            fila += `<td>${item.hora_turno}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-turno'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-turno'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }

    $("#turnos_tb").html(fila);
}
}