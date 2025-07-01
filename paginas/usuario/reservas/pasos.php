<script>
    function showStep(step) {
        const steps = document.querySelectorAll('.step');
        steps.forEach((s, index) => {
            if (index + 1 === step) {
                s.classList.remove('d-none');
            } else {
                s.classList.add('d-none');
            }
            //nuevo
        });
    }



    function previousStep(currentStep) {
        showStep(currentStep - 1);
    }
</script>
<div class="container">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h1 class="card-title text-center mb-4">Estas a un paso de realizar tu reserva</h1>

            <!-- Pasos -->
            <div>
                <div id="step1" class="step">
                    <input type="text" value="0" id="sucursal_seleccionado" hidden>
                    <input type="text" value="0" id="nombre_sucursal_seleccionado" hidden>
                    <h2 class="h5 mb-4">Sucursal </h2>
                    <p>Seleccione una sucursal:</p>
                    <div class="row" id="sucursales-panel">

                    </div>

                    <button type="button" onclick="nextStep(1)" class="btn btn-primary w-100 mt-3">Siguiente</button>
                </div>

                <div id="step2" class="step d-none">
                    <input type="text" value="0" id="dia_seleccionado" hidden >
                    <input type="text" value="0" id="id_horario_atencion" hidden >
                    <input type="text" value="0" id="dia_nombre" hidden >
                    <h2 class="h5 mb-4">Día </h2>
                    <p>Que día deseas ir?:</p>
                    <div class="row" id="dia-panel">

                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" id="btn_anterior_dia" onclick="previousStep(2)" class="btn btn-secondary">Anterior</button>
                        <button type="button" onclick="nextStep(2)" class="btn btn-primary">Siguiente</button>
                    </div>

                </div>

                <div id="step3" class="step d-none">
                    <input type="text" value="0" id="profesional_seleccionado" hidden >
                    <input type="text" value="0" id="nombre_profesional" hidden >
                    <h2 class="h5 mb-4">Profesional </h2>
                    <p>Elije el profesional:</p>
                    <div class="row" id="profesional-panel">

                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button"  onclick="previousStep(3)" class="btn btn-secondary">Anterior</button>
                        <button type="button" id="siguiente_profesional" onclick="nextStep(3)" class="btn btn-primary">Siguiente</button>
                    </div>
                </div>

                <div id="step4" class="step d-none">
                    <input type="text" value="0" id="hora_seleccionado" hidden>
                    <h2 class="h5 mb-4">Disponibles </h2>
                    <p>Elije le horario:</p>
                    <div class="row" id="horario-panel">

                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" id="" onclick="previousStep(4)" class="btn btn-secondary">Anterior</button>
                        <button type="button" id="siguiente_horario" onclick="nextStep(4)" class="btn btn-primary">Siguiente</button>
                    </div>
                </div>

                <div id="step5" class="step d-none">
                    <input type="text" value="0" id="datos_seleccionado" hidden>
                    <h2 class="h5 mb-4">Datos Personales</h2>
                    <p>Estamos a un paso de terminar la reserva!!!</p>
                    <div class="row" id="datos-panel" style="margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label>Nombre y Apellido</label>
                            <input type="text" id="nombre_apellido" class="form-control" placeholder="Ingrese su nombre y apellido aqui">
                        </div>
                        <div class="col-md-12">
                            <label>Número de Telefono (WhatsApp)</label>
                            <span>+595</span><input type="tel" id="celular" class="form-control" placeholder="Ejemplo: 971120612">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" id="" onclick="previousStep(5)" class="btn btn-secondary">Anterior</button>
                        <button type="button" id="siguiente_horario" onclick="nextStep(5)" class="btn btn-primary">Siguiente</button>
                    </div>
                </div>
                <div id="step6" class="step d-none">
                   
                    <h2 class="h5 mb-4">Confirmación</h2>
                    <p>Verifica los datos seleccionados y presiona en confirmar</p>
                    <div class="row" id="confirmacion-panel" style="margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label>Sucursal</label>
                            <input type="text" readonly id="sucursal_conf" class="form-control" >
                        </div>
                        <div class="col-md-12">
                            <label>Dia</label>
                            <input type="text" readonly id="dia_conf" class="form-control" >
                        </div>
                        <div class="col-md-12">
                            <label>Profesional</label>
                            <input type="text" readonly id="profesional_conf" class="form-control" >
                        </div>
                        <div class="col-md-12">
                            <label>Hora</label>
                            <input type="text" readonly id="hora_conf" class="form-control" >
                        </div>
                        <div class="col-md-12">
                            <label>Nombre y Apellido</label>
                            <input type="text" readonly id="nombre_conf" class="form-control" >
                        </div>
                        <div class="col-md-12">
                            <label>Teléfono de contacto</label>
                            <input type="text" readonly id="celular_conf" class="form-control" >
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" id="" onclick="previousStep(6)" class="btn btn-secondary">Anterior</button>
                        <button type="button" id="siguiente_horario" onclick="confirmar()" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
