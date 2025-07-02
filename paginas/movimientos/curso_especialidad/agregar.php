<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="card-title mb-4 text-center">Registrar Curso Especialidad</h5>
    <input type="text" id="id_curso_especialidad_edicion" value="0" hidden>
    <form>
      <div class="row g-3">
        <div class="col-md-4">
          <label for="curso_id" class="form-label">Curso</label>
          <select id="curso_id" class="form-control"></select>
        </div>
        <div class="col-md-4">
          <label for="especialidad_id" class="form-label">Especialidad</label>
          <select id="especialidad_id" class="form-control"></select>
        </div>
        <div class="col-md-4">
          <label for="estado" class="form-label">Estado</label>
          <select id="estado" class="form-control">
            <option value="ACTIVO" selected>Activo</option>
            <option value="INACTIVO">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="mt-4">
        <button onclick="guardarCursoEspecialidad(); return false;" class="btn btn-primary btn-lg px-5">Registrar</button>
        <button onclick="mostrarListarCursoEspecialidad(); return false;" class="btn btn-secondary btn-lg px-5">Volver</button>
      </div>
    </form>
  </div>
</div>
