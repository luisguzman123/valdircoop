<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="card-title mb-4 text-center">Registrar Jurado</h5>
    <input type="text" id="id_jurado_edicion" value="0" hidden>
    <form>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nombre_apellido" class="form-label">Nombre y Apellido</label>
          <input type="text" id="nombre_apellido" name="nombre_apellido" class="form-control form-control-lg" required>
        </div>
        <div class="col-md-6">
          <label for="cedula_j" class="form-label">C&eacute;dula</label>
          <input type="number" id="cedula_j" name="cedula_j" class="form-control form-control-lg" required>
        </div>
        <div class="col-md-6">
          <label for="pass_j" class="form-label">Contrase&ntilde;a</label>
          <input type="password" id="pass_j" name="pass_j" class="form-control form-control-lg" required>
        </div>
        <div class="col-md-6">
          <label for="estado_j" class="form-label">Estado</label>
          <select id="estado_j" name="estado_j" class="form-control" required>
            <option value="ACTIVO" selected>Activo</option>
            <option value="INACTIVO">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="mt-4">
        <button onclick="guardarJurado(); return false;" class="btn btn-primary btn-lg px-5">Registrar</button>
        <button onclick="mostrarListarJurado(); return false;" class="btn btn-secondary btn-lg px-5">Volver</button>
      </div>
    </form>
  </div>
</div>
