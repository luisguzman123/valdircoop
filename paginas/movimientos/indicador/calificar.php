<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="card-title mb-4 text-center">Calificar Indicador</h5>
    <div class="row g-3 mb-3">
      <div class="col-md-8">
        <label for="indicador_id" class="form-label">Indicador</label>
        <select id="indicador_id" class="form-control"></select>
      </div>
      <div class="col-md-4 d-flex align-items-end">
        <button onclick="cargarDetalleCalificar(); return false;" class="btn btn-primary w-100">Cargar</button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Descripci&oacute;n</th>
            <th>Puntaje</th>
            <th>Logrado</th>
          </tr>
        </thead>
        <tbody id="calificar_tb"></tbody>
      </table>
    </div>
    <div class="mt-4">
      <button onclick="guardarCalificacion(); return false;" class="btn btn-success btn-lg px-5">Guardar</button>
      <button onclick="mostrarListarIndicador(); return false;" class="btn btn-secondary btn-lg px-5">Volver</button>
    </div>
  </div>
</div>
