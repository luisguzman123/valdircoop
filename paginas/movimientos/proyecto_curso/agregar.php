<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="card-title mb-4 text-center">Registrar Proyecto Curso</h5>
    <input type="text" id="id_proyecto_curso_edicion" value="0" hidden>
    <form>
      <div class="row g-3">
        <div class="col-md-4">
          <label for="curso_id" class="form-label">Curso</label>
          <select id="curso_id" class="form-control"></select>
        </div>
        <div class="col-md-4">
          <label for="proyecto_id" class="form-label">Proyecto</label>
          <select id="proyecto_id" class="form-control"></select>
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
        <button onclick="guardarProyectoCurso(); return false;" class="btn btn-primary btn-lg px-5">Registrar</button>
        <button onclick="mostrarListarProyectoCurso(); return false;" class="btn btn-secondary btn-lg px-5">Volver</button>
      </div>
    </form>
  </div>
</div>
