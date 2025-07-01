<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="card-title mb-4 text-center">Registrar Plantilla Indicadores</h5>
    <input type="text" id="id_cabecera_edicion" value="0" hidden>
    <form>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="especialidad_id" class="form-label">Especialidad</label>
          <select id="especialidad_id" class="form-control"></select>
        </div>
        <div class="col-md-6">
          <label for="estado_cab" class="form-label">Estado</label>
          <select id="estado_cab" class="form-control">
            <option value="ACTIVO" selected>Activo</option>
            <option value="INACTIVO">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="row g-3 mt-4">
        <div class="col-md-12">
          <button class="btn btn-secondary btn-sm" onclick="agregarFilaDetalle(); return false;"><i class="fa fa-plus"></i> Detalle</button>
          <div class="table-responsive mt-2">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width:5%">ID</th>
                  <th style="width:30%">Descripción</th>
                  <th style="width:10%">Puntaje</th>
                  <th style="width:15%">Orden</th>
                  <th style="width:25%">Padre</th>
                  <th style="width:10%">Estado</th>
                  <th style="width:10%"></th>
                </tr>
              </thead>
              <tbody id="detalle_tb"></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="mt-4">

        <button onclick="guardarCabecera(); return false;" class="btn btn-primary btn-lg px-5">Guardar Cabecera</button>

        <button onclick="mostrarListarPlantilla(); return false;" class="btn btn-secondary btn-lg px-5">Volver</button>
      </div>
    </form>
  </div>
</div>
