function validarCampoDeTextoID(id, mensaje) {
    //validaciones de nombre
    if ($("#" + id + "").val().length <= 0) {
        mensaje_dialogo_info(mensaje);
        $("#" + id + "").focus();
        $("#" + id + "").parent().addClass("has-error");

        $("#" + id + "").keypress(function () {
            $("#" + id + "").parent().removeClass("has-error");
        });
        return false;
    }
    return true;
}
function validarCampoDeTextoComponente(comp, mensaje) {
    //validaciones de nombre
    if ($(comp).val().length <= 0) {
        mensaje_dialogo_info(mensaje);
        $(comp).focus();
        $(comp).parent().addClass("has-error");

        $(comp).keypress(function () {
            $(comp).parent().removeClass("has-error");
        });
        return false;
    }
    return true;
}

function validarListaDesplegableID(id, mensaje) {
    //validaciones de nombre
    if ($("#" + id + "").val() === 0) {
        mensaje_dialogo_info(mensaje, "Atención");
        $("#" + id + "").focus();
        $("#" + id + "").addClass("has-error");

        $("#" + id + "").click(function () {
            $("#" + id + "").parent().removeClass("has-error");
        });
        return false;
    }
    return true;
}



/**
 * Funcion que devuelve un numero separando los separadores de miles
 * Puede recibir valores negativos y con decimales
 */
function formatearNumero(valor) {
    // Variable que contendra el resultado final
    var numero = String(valor);
    var resultado = "";

    // Si el numero empieza por el valor "-" (numero negativo)
    if (numero[0] == "-")
    {
        // Cogemos el numero eliminando los posibles puntos que tenga, y sin
        // el signo negativo
        nuevoNumero = numero.replace(/\./g, '').substring(1);
    } else {
        // Cogemos el numero eliminando los posibles puntos que tenga
        nuevoNumero = numero.replace(/\./g, '');
    }

    // Si tiene decimales, se los quitamos al numero
    if (numero.indexOf(",") >= 0)
        nuevoNumero = nuevoNumero.substring(0, nuevoNumero.indexOf(","));

    // Ponemos un punto cada 3 caracteres
    for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++)
        resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0) ? "." : "") + resultado;

    // Si tiene decimales, se lo añadimos al numero una vez forateado con 
    // los separadores de miles
    if (numero.indexOf(",") >= 0)
        resultado += numero.substring(numero.indexOf(","));

    if (numero[0] == "-")
    {
        // Devolvemos el valor añadiendo al inicio el signo negativo
        return "-" + resultado;
    } else {
        return resultado;
    }
}
function formatearNumeroCampo(valor) {
    // Variable que contendra el resultado final
    var numero = $("#" + valor).val();
    var resultado = "";

    // Si el numero empieza por el valor "-" (numero negativo)
    if (numero[0] == "-")
    {
        // Cogemos el numero eliminando los posibles puntos que tenga, y sin
        // el signo negativo
        nuevoNumero = numero.replace(/\./g, '').substring(1);
    } else {
        // Cogemos el numero eliminando los posibles puntos que tenga
        nuevoNumero = numero.replace(/\./g, '');
    }

    // Si tiene decimales, se los quitamos al numero
    if (numero.indexOf(",") >= 0)
        nuevoNumero = nuevoNumero.substring(0, nuevoNumero.indexOf(","));

    // Ponemos un punto cada 3 caracteres
    for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++)
        resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0) ? "." : "") + resultado;

    // Si tiene decimales, se lo añadimos al numero una vez forateado con 
    // los separadores de miles
    if (numero.indexOf(",") >= 0)
        resultado += numero.substring(numero.indexOf(","));

    if (numero[0] == "-")
    {
        // Devolvemos el valor añadiendo al inicio el signo negativo
        $("#" + valor).val("-" + resultado);
    } else {
        $("#" + valor).val(resultado);
    }
}

function dameFechaActual(id_componente) {
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var actual = "";
    if (mes - 10 < 0) {
        actual = fecha.getFullYear() + "-0" + mes + "-";

    } else {

        actual = fecha.getFullYear() + "-" + mes + "-";

    }

    if (dia - 10 < 0) {
        actual += "0" + dia;
    } else {
        actual += dia;
    }
    $("#" + id_componente).val(actual);

}
function dameMesActual(id_componente) {
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var actual = "";
    if (mes - 10 < 0) {
        actual = fecha.getFullYear() + "-0" + mes;

    } else {

        actual = fecha.getFullYear() + "-" + mes;

    }

    $("#" + id_componente).val(actual);

}
function dameMesActualSQL() {
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var actual = "";
    if (mes - 10 < 0) {
        actual = fecha.getFullYear() + "-0" + mes;

    } else {

        actual = fecha.getFullYear() + "-" + mes;

    }

    return (actual);

}

function dameFechaActualFormateada() {
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var actual = "";
    if (dia - 10 < 0) {
        actual = "0" + dia;
    } else {
        actual = dia;
    }
    if (mes - 10 < 0) {
        actual += "-0" + mes + "-" + fecha.getFullYear();

    } else {

        actual += "-" + mes + "-" + fecha.getFullYear();

    }

    return actual;

}
function dameFechaActualSQL() {
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var actual = "";
    if (mes - 10 < 0) {
        actual = fecha.getFullYear() + "-0" + mes + "-";

    } else {

        actual = fecha.getFullYear() + "-" + mes + "-";

    }

    if (dia - 10 < 0) {
        actual += "0" + dia;
    } else {
        actual += dia;
    }
    return  actual;

}
function dameFechaActualNormal() {
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var actual = "";
    if (dia - 10 < 0) {
        actual += "0" + dia + "/";
    } else {
        actual += dia + "/";
    }
    if (mes - 10 < 0) {
        actual += +"0" + mes + "/" + fecha.getFullYear();

    } else {

        actual += "" + mes + "/" + fecha.getFullYear();

    }

    return  actual;

}
function dameFechaFormateada(fecha) {
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate() + 1;
    var actual = "";
    if (dia - 10 < 0) {
        actual += "0" + dia;
    } else {
        actual += dia;
    }
    if (mes - 10 < 0) {
        actual += "-0" + mes + "-" + fecha.getFullYear();

    } else {

        actual += "-" + mes + "-" + fecha.getFullYear();

    }

    return  actual;

}

function formatearFecha(fecha) {

    var dia = fecha.getDate() + 1;
    var mes = fecha.getMonth() + 1;
    var anio = fecha.getFullYear();
    return  dia + "-" + mes + "-" + anio;
}

function dameFechaSQL() {
    var fecha = new Date();
    var dia = fecha.getDate() + 1;
    var mes = fecha.getMonth() + 1;
    var anio = fecha.getFullYear();
    return  anio + "-" + mes + "-" + dia;
}
function dameFechaSQL(fecha) {
    var fec = String(fecha).split("-");

    return  fec[0] + "-" + fec[2] + "-" + fec[1];
}

function quitarDecimalesConvertir(valor) {
    var num = String(valor);
    var numer = num.replace(/\./g, '');
    var nuevo_n = parseInt(numer);
    return nuevo_n;
}

function mensajeErrorUsuario(mensaje, titulo) {
    var modal = "<div class='modal fade' id='mensaje-usuario'>" +
            "<div class='modal-dialog'>" +
            "<div class='modal-content'>" +
            "<div class='modal-header' style='background: #990000;'> " +
            "<button class='close'" +
            " type='button'" +
            "data-dismiss='modal'" +
            "aria-label='Close'" +
            "><span aria-hidden='true'>&times;</span> </button>" +
            "<h4 class='modal-title' style='color: #fffc;'>" + titulo + "</h4>" +
            "</div>" +
            "<div class='modal-body' style='font-weight: bold;'>" +
            mensaje +
            "</div>" +
            "<div class='modal-footer'>" +
            "<button type='button'class='btn btn-default pull-left'" +
            " data-dismiss='modal'>Cerrar</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
    $("body").append(modal);
    $("#mensaje-usuario").modal("show");
}


function ejecutarAjax(url, data) {

    var resultado = "";
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: url,
        data: data,
        success: function (datos) {
//                console.log(datos);

            resultado = datos;

        }
    });

    return resultado;
}

function ejecutarAjaxHTML(url, data) {

    var resultado = "";
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        dataType: 'html',
        url: url,
        data: data,
        success: function (datos) {
//                console.log(datos);
            resultado = datos;

        }
    });

    return resultado;
}


function ejecutarAjaxERROR(url, data, mensaje_error, mensaje_correcto) {

    var resultado = "";
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: url,
        data: data,
        success: function (datos) {

            resultado = datos;
            mensaje_dialogo_info(mensaje_correcto, "CORRECTO");

        }, error: function (jqXHR, textStatus, errorThrown) {
            mensaje_dialogo_info_ERROR(mensaje_error + " " + textStatus, "ERROR");
        }, beforeSend: function (xhr) {
            //logo de cargando
        }
    });

    return resultado;
}

var modalConfirm;
function mensaje_confirmacion(mensaje, titulo) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: "success"
    });

}


function mensaje_dialogo_info(mensaje, titulo) {

    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: "info"
    });

}

function mensaje_dialogo_success(mensaje, titulo) {

    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: "success"
    });

}



function mensaje_dialogo_info_ERROR(mensaje, titulo) {

     Swal.fire({
        title: titulo,
        text: mensaje,
        icon: "error"
    });

}


function dameContenido(dir) {
    var contenido = "";

    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: dir,
        success: function (datos) {
            contenido += datos;
        }
    });

    return contenido;
}

$(document).on("click", ".remover-item", function (evt) {
    var tr = $(this).closest("tr");
    alertify.confirm('ATENCION', 'Desea remover el item', function () {
        $(tr).remove();
        alertify.success('Removido');
    }
    , function () {
        alertify.error('Cancelo');
    });
});

function dameTimeStapActualSQL() {
    var fecha = new Date();
    return fecha.getFullYear() + "-" + (fecha.getMonth() + 1) + "-" + fecha.getDate() + " " +
            fecha.getHours() + ":" + fecha.getMinutes() + ":" + fecha.getSeconds();
}
function dameHoraActual() {
    var fecha = new Date();
    let hora = "";
    if (fecha.getHours() < 10) {
        hora = "0" + fecha.getHours();
    } else {
        hora = fecha.getHours();
    }
    if (fecha.getMinutes() < 10) {
        hora += ":0" + fecha.getMinutes();
    } else {
        hora += ":" + fecha.getMinutes();
    }


    return  hora;
}
function imprimir() {
    window.print();
}

function imprimirSeleccion(nombre) {
    var ficha = document.getElementById(nombre);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print( );
    ventimp.close();
}
function dameNombreMes(mes) {
    switch (mes) {
        case "1":
            return "ENERO";
            break;
        case "2":
            return "FEBRERO";
            break;
        case "3":
            return "MARZO";
            break;
        case "4":
            return "ABRIL";
            break;
        case "5":
            return "MAYO";
            break;
        case "6":
            return "JUNIO";
            break;
        case "7":
            return "JULIO";
            break;
        case "8":
            return "AGOSTO";
            break;
        case "9":
            return "SEPTIEMBRE";
            break;
        case "10":
            return "OCTUBRE";
            break;
        case "11":
            return "NOVIEMBRE";
            break;
        case "12":
            return "DICIEMBRE";
            break;

        default:

            break;
    }
}

function calcularEdad(fecha_nacimiento) {
    let fecha = dameFechaActualSQL();
    let anio = parseInt(fecha.split("-")[0]);
    let anio_nacimiento = parseInt(fecha_nacimiento.split("-")[0]);
    return anio - anio_nacimiento;
}

function soloTexto(e) {
    var code;
    if (!e)
        var e = window.event;
    if (e.keyCode)
        code = e.keyCode;
    else if (e.which)
        code = e.which;
    var character = String.fromCharCode(code);
    var AllowRegex = /^[\ba-zA-Z\s-]$/;
    if (AllowRegex.test(character))
        return true;
    return false;
}