<!-- Incluir Chart.js en tu layout (por ejemplo en el <head> o al final del <body>) -->


<div class="container py-4">
    <!-- Título -->
    <h2 class="mb-4 text-center">Progreso</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Selección de Usuario -->
            <div class="mb-4 bloque-usuario">
                <label for="usuario_id" class="form-label">Selecciona Usuario</label>
                <select class="form-control" id="usuario_id" name="usuario_id" required>
                    <option value="" selected disabled>-- Elige un usuario --</option>
                    <!-- Opciones cargadas dinámicamente -->
                </select>
            </div>

            <!-- Aviso para móviles -->
            <div
                class="alert alert-warning text-center mb-4 d-block d-md-none"
                role="alert"
                >
                Gira tu teléfono a posición horizontal para ver bien el gráfico.
            </div>

            <!-- Contenedor del gráfico -->
            <div>
                <canvas id="chartMedidas" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    (async function init() {
        // 1) Carga inicial de usuarios

        const select = $('#usuario_id');
        cargarListaUsuario("#usuario_id");

        // 2) Configuración base de Chart.js
        const ctx = document.getElementById('chartMedidas').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [], // fechas
                datasets: [
                    {label: 'Brazo Izq.', data: [], fill: false, tension: 0.2},
                    {label: 'Brazo Der.', data: [], fill: false, tension: 0.2},
                    {label: 'Pierna Izq.', data: [], fill: false, tension: 0.2},
                    {label: 'Pierna Der.', data: [], fill: false, tension: 0.2},
                    {label: 'Cintura', data: [], fill: false, tension: 0.2},
                    {label: 'Cadera', data: [], fill: false, tension: 0.2},
                    {label: 'Peso', data: [], fill: false, tension: 0.2},
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {title: {display: true, text: 'Fecha'}},
                    y: {title: {display: true, text: 'Medida (cm) / Kg'}}
                },
                plugins: {
                    legend: {position: 'bottom'}
                }
            }
        });

        // 3) Función para recargar datos y actualizar el gráfico
        async function actualizarGrafico(usuarioId) {
            try {
                const resp = await fetch('controlador/registro_medida.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: new URLSearchParams({get_medidas_usuario: usuarioId})
                });
                const datos = await resp.json();
                if (!Array.isArray(datos) || datos.length === 0) {
                    chart.data.labels = [];
                    chart.data.datasets.forEach(ds => ds.data = []);
                    chart.update();
                    return;
                }

                // Ordenar por fecha ascendente
                datos.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));

                // Mapear a arrays
                chart.data.labels = datos.map(r => formatearFechaDesdeString(r.fecha));
                chart.data.datasets[0].data = datos.map(r => parseFloat(r.brazo_izquierdo));
                chart.data.datasets[1].data = datos.map(r => parseFloat(r.brazo_derecho));
                chart.data.datasets[2].data = datos.map(r => parseFloat(r.pierna_izquierda));
                chart.data.datasets[3].data = datos.map(r => parseFloat(r.pierna_derecha));
                chart.data.datasets[4].data = datos.map(r => parseFloat(r.cintura));
                chart.data.datasets[5].data = datos.map(r => parseFloat(r.cadera));
                chart.data.datasets[6].data = datos.map(r => parseFloat(r.peso));

                chart.update();
            } catch (e) {
                console.error('Error al obtener medidas:', e);
            }
        }

        // 4) Evento al cambiar selección de usuario
        select.on('change', () => {
            const id = select.val();
            if (id)
                actualizarGrafico(id);
        });

        if ($("#id_rol_usuario").val() === "PERSONA") {
            $("#usuario_id").val($("#id_usuario_activo").val());
            $(".bloque-usuario").hide();

            actualizarGrafico($("#id_usuario_activo").val());
        }

    })();


    function formatearFechaDesdeString(fechaIso) {
        // fechaIso = "2025-06-16"
        const [anio, mes, dia] = fechaIso.split('-');
        return `${dia}-${mes}-${anio}`; // "16-06-2025"
    }
</script>
