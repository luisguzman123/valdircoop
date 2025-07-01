function mostrarRegistroMedidas() {
    let contenido = dameContenido("paginas/movimientos/medidas/agregar.php");
    $("#contenido-principal").html(contenido);
    dameFechaActual("fecha");
    cargarListaUsuario("#usuario_id");
}
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
async function guardarMedidas() {
// 1. Validar usuario seleccionado
    const usuarioId = $('#usuario_id').val();
    if (!usuarioId) {
        mensaje_dialogo_info('Debes seleccionar un usuario', 'Atención');
        $('#usuario_id').select2?.('open'); // si usas Select2, abre el dropdown
        return;
    }

// 2. Validar cada campo numérico > 0
    const camposNum = [
        {id: 'peso', etiqueta: 'Peso'},
        {id: 'brazo_izquierdo', etiqueta: 'Brazo Izquierdo'},
        {id: 'brazo_derecho', etiqueta: 'Brazo Derecho'},
        {id: 'pierna_izquierda', etiqueta: 'Pierna Izquierda'},
        {id: 'pierna_derecha', etiqueta: 'Pierna Derecha'},
        {id: 'cintura', etiqueta: 'Cintura'},
        {id: 'cadera', etiqueta: 'Cadera'}
    ];
    for (let {id, etiqueta} of camposNum) {
        const val = parseFloat($(`#${id}`).val());
        if (isNaN(val) || val <= 0) {
            mensaje_dialogo_info(`El campo "${etiqueta}" debe ser mayor que 0`, 'Atención');
            $(`#${id}`).focus();
            return;
        }
    }

// 3. Validar fecha
    const fecha = $('#fecha').val();
    if (!fecha) {
        mensaje_dialogo_info('Debes seleccionar la fecha de medición', 'Atención');
        $('#fecha').focus();
        return;
    }

// 4. Armar objeto de datos
    const payload = {
        usuario_id: parseInt(usuarioId, 10),
        peso: parseFloat($('#peso').val()),
        brazo_izquierdo: parseFloat($('#brazo_izquierdo').val()),
        brazo_derecho: parseFloat($('#brazo_derecho').val()),
        pierna_izquierda: parseFloat($('#pierna_izquierda').val()),
        pierna_derecha: parseFloat($('#pierna_derecha').val()),
        cintura: parseFloat($('#cintura').val()),
        cadera: parseFloat($('#cadera').val()),
        fecha            // ya es string YYYY-MM-DD
    };
    // 5. Enviar por AJAX moderno (fetch)
    try {
        const response = await fetch('controlador/registro_medida.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'},
            body: new URLSearchParams({guardar: JSON.stringify(payload)})
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
        mensaje_dialogo_success('Medidas guardadas correctamente', 'Éxitoso');
        //mostrarListarMedidas(); // función que recarga la lista de registros

    } catch (err) {
        console.error('Error guardando medidas:', err);
        mensaje_dialogo_info('Ocurrió un error al guardar las medidas', 'Error');
    }
}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
async function mostrarProgreso() {
    let contenido = dameContenido("paginas/movimientos/medidas/progreso.php");
    $("#contenido-principal").html(contenido);
}

