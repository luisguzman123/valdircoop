function mostrarListarUsuarioAdmin() {
    let contenido = dameContenido("paginas/usuario_admin/listar.php");
    $("#contenido-principal").html(contenido);
    cargarTablaUsuarioAdmin("#usuario_admin_tb");
}
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
function mostrarAgregarUsuarioAdmin() {
    let contenido = dameContenido("paginas/usuario_admin/agregar.php");
    $("#contenido-principal").html(contenido);
    cargarListaSucursal("#usuario_admin_lst");
}
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
function cancelarUsuarioAdmin() {
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
            let contenido = dameContenido("paginas/usuario_admin/listar.php");
            $("#contenido-principal").html(contenido);
            mostrarListarUsuarioAdmin();
        }
    });

}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
function guardarUsuarioAdmin() {

   
        // // Validar el campo 'Nombre y Apellido'
        // if ($("#nom_apell_usuario_admin").val().trim().length === 0) {
        //     mensaje_usuario_adminlogo_info_ERROR("Atención" , "Debes ingresar el Nombre y Apellido" );
        //     return false;
        // }
    
        // // Validar el campo 'Teléfono'
        // if ($("#telefono").val().trim().length === 0) {
        //     mensaje_usuario_adminlogo_info_ERROR("Atención", "Debes ingresar un número de teléfono");
        //     return false;
        // }
    
        // // Validar que el teléfono solo contenga números
        // if (!/^\d+$/.test($("#telefono").val().trim())) {
        //     mensaje_usuario_adminlogo_info_ERROR("Atención" ,"El teléfono solo debe contener números");
        //     return false;
        // }
    
        // // Validar el campo 'Cédula'
        // if ($("#cedula_usuario_admin").val().trim().length === 0) {
        //     mensaje_usuario_adminlogo_info_ERROR("Atención" ,"Debes ingresar la cédula del usuario_admin");
        //     return false;
        // }
    
        // // Validar que la cédula solo contenga números
        // if (!/^\d+$/.test($("#cedula_usuario_admin").val().trim())) {
        //     mensaje_usuario_adminlogo_info_ERROR("Atención" ,"La cédula solo debe contener números");
        //     return false;
        // }
    
        // // Validar el campo 'Dirección'
        // if ($("#direccion").val().trim().length === 0) {
        //     mensaje_usuario_adminlogo_info_ERROR("Atención" ,"Debes ingresar la dirección del usuario_admin");
        //     return false;
        // }
    
   
    
       
    
    


    let data = {
        'nombre': $("#nombre").val(),
        'apellido': $("#apellido").val(),
        'cedula': $("#cedula").val(),
        'telefono': $("#telefono").val(),
        'fecha_nacimiento': $("#fecha_nacimiento").val(),
        'ubicacion': $("#ubicacion").val()

    };

    
    if ($("#cod_usuario").val() === "0") {

        let response = ejecutarAjax("controlador/usuario_admin.php", "guardar=" + JSON.stringify(data));
//        console.log(response);
        mensaje_confirmacion("Guardado correctamente", "Guardado");
        mostrarListarUsuarioAdmin();
console.log(response);
    } else {
        data = {...data, 'id_admin': $("#cod_usuario").val()};
        let response = ejecutarAjax("controlador/usuario_admin.php",
                "actualizar=" + JSON.stringify(data));
       console.log(response);
        mensaje_confirmacion("Actualizado Correctamente", "Actualizado");
        mostrarListarUsuarioAdmin();
    }
   

}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function cargarTablaUsuarioAdmin() {
    let data = ejecutarAjax("controlador/usuario_admin.php", "leer=1");


    let fila = "";
    if (data === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.id_admin}</td>`;
            fila += `<td>${item.nombre}</td>`;
            fila += `<td>${item.apellido}</td>`;
            fila += `<td>${item.telefono}</td>`;
            fila += `<td>${item.cedula}</td>`;
            fila += `<td>${item.fecha_nacimiento}</td>`;
            fila += `<td>${item.ubicacion}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-usuario_admin'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-usuario_admin'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }

    $("#usuario_admin_tb").html(fila);
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
$(document).on("click", ".editar-usuario_admin", function (evt) {
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
            let response = ejecutarAjax("controlador/usuario_admin.php", "id=" + id);
            console.log(response);
            if (response === "0") {

            } else {
                let json_data = JSON.parse(response);
                //abrir ventana
                let contenido = dameContenido("paginas/usuario_admin/agregar.php");
                $("#contenido-principal").html(contenido);


                //cargar los datos
                let json_registro = JSON.parse(response);
                $("#cod_usuario").val(id);
                $("#nombre").val(json_registro['nombre']);
                $("#apellido").val(json_registro['apellido']);
                $("#cedula").val(json_registro['cedula']);
                $("#telefono").val(json_registro['telefono']);
                $("#fecha_nacimiento").val(json_registro['fecha_nacimiento']);
                $("#ubicacion").val(json_registro['ubicacion']);
            }
        }
    });
});
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$(document).on("click", ".eliminar-usuario_admin", function (evt) {
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
            let response = ejecutarAjax("controlador/usuario_admin.php",
                    "eliminar=" + id);

            console.log(response);
            mensaje_confirmacion("Eliminado Correctamente", "Eliminado");
            mostrarListarUsuarioAdmin();
        }
    });
});
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$(document).on("keyup", "#b_usuario_admin", function (evt) {
    let data = ejecutarAjax("controlador/usuario_admin.php", "leer_descripcion=" + $("#b_usuario_admin").val());


    let fila = "";
    if (data === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.id_usuario_admin}</td>`;
            fila += `<td>${item.dias}</td>`;
            fila += `<td>${item.telefono}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-usuario_admin'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-usuario_admin'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }

    $("#usuario_admin_tb").html(fila);
});
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
function imprimirUsuarioAdmin() {
    window.open("paginas/referenciales/usuario_admin/print.php");
}

function cargarListaUsuarioAdmin(componente) {
    let datos = ejecutarAjax("controlador/usuario_admin.php", "leer_usuario_admins_activos=1");
    console.log(datos);
    let option = "";
    if (datos === "0") {
        option = "<option value='0'>Selecciona un usuario_admin</option>";
    } else {
        option = "<option value='0'>Selecciona un usuario_admin</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function (item) {
            option += `<option value='${item.id_usuario_admin}'>${item.usuario_admin}</option>`;


        });
    }
    $(componente).html(option);
}
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
function cargarListaUsuarioAdmin(componente) {
    let datos = ejecutarAjax("controlador/usuario_admin.php", "leer_usuario_admins_activos=1");
    console.log(datos);
    let option = "";
    if (datos === "0") {
        option = "<option value='0'>Selecciona un usuario_admin</option>";
    } else {
        option = "<option value='0'>Selecciona un usuario_admin</option>";
        let json_datos = JSON.parse(datos);
        json_datos.map(function (item) {
            option += `<option value='${item.id_usuario_admin}-${item.usuario_admin}'></option>`;


        });
    }
    $(componente).html(option);
}

$(document).on("keyup", "#b_usuario_admin2", function (evt) {
    let data = ejecutarAjax("controlador/usuario_admin.php", "leer_descripcion_usuario_admin="+$("#b_usuario_admin2").val());

    console.log(data);
    let fila = "";
    if (data === "0") {
        fila = "NO HAY REGISTROS";
    } else {
        let json_data = JSON.parse(data);
        json_data.map(function (item) {
            fila += `<tr>`;
            fila += `<td>${item.cod_usuario_admin}</td>`;
            fila += `<td>${item.nom_apell_usuario_admin}</td>`;
            fila += `<td>${item.telefono}</td>`;
            fila += `<td>${item.cedula_usuario_admin}</td>`;
            fila += `<td>${item.direccion}</td>`;
            fila += `<td>${item.descripcion_ciud}</td>`;
            fila += `<td>${item.estado}</td>`;
            fila += `<td>
                        <button class='btn btn-warning editar-usuario_admin'><i class='fa fa-edit'></i> Editar</button>
                        <button class='btn btn-danger eliminar-usuario_admin'><i class='fa fa-trash'></i> Eliminar</button>
                    </td>`;
            fila += `</tr>`;
        });
    }

    $("#usuario_admin_tb").html(fila);
});
