<?php

include_once '../conexion/db.php';

if (isset($_POST['guardar'])) {
    $json_datos = json_decode($_POST['guardar'], true);
    $base_datos = new DB();

    $query = $base_datos->conectar()->prepare("
                        INSERT INTO cliente
(nombre, telefono, fecha)
VALUES(:nombre, :telefono, :fecha);");

    $query->execute([
        'nombre' => $json_datos['nombre'],
        'telefono' => $json_datos['telefono'],
        'fecha' => $json_datos['fecha']
    ]);

    $query = $base_datos->conectar()->prepare("
                        INSERT INTO turno
( id_cliente, id_usuario, fecha, tipo,
dia, hora, estado, color, id_profesional, id_sucursal)
VALUES( (SELECT MAX(c.id_cliente) from cliente c), 0, :fecha, 'CLIENTE', :dia, :hora, 'PENDIENTE', 
'#FFC107', :id_profesional, :id_sucursal);");

    $query->execute([
        'dia' => $json_datos['dia'],
        'hora' => $json_datos['hora'],
        'id_profesional' => $json_datos['id_profesional'],
        'id_sucursal' => $json_datos['id_sucursal'],
        'fecha' => $json_datos['fecha_turno']
    ]);

    //generacion de link 
    $titulo = urlencode("Cita en BARBERSHOP");
    $nombre = $json_datos['nombre'];
    $fecha = $json_datos['fecha_turno'];
    $hora = $json_datos['hora'];
    $direccion = "JJ6X+36X, Itauguá 110604";
    $contacto = "0971120612";

    $inicio = date("Ymd\THis", strtotime("$fecha $hora"));
    $fin = date("Ymd\THis", strtotime("$fecha $hora +30 minutes"));

    $descripcion = urlencode("Tu cita en $barberia ha sido confirmada. Dirección: $direccion. Si necesitas reprogramar, avísanos con anticipación. Contacto: $contacto");
    $ubicacion = urlencode($direccion);
    

    //envio de mensaje
    $mensaje = "📩 Mensaje de Confirmación:

Hola " . $json_datos['nombre'] . ",
Tu reserva en [Nombre de la Barbería] ha sido confirmada.
📅 Fecha: " . $json_datos['fecha_turno'] . "
⏰ Hora: " . $json_datos['hora'] . " hs
📍 Dirección: [Ubicación de la barbería]
Si necesitas reprogramar, avísanos con anticipación. ¡Te esperamos! ✂️💈

📞 Contacto: [Número de la barbería]";
    $data = [
        "number" => $json_datos['telefono'],
        "body" => $mensaje,
    ];
    $ch = curl_init("http://localhost:8080/api/messages/send");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer !@123321",
        "Content-Type: application/json"
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);
}



