<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="card-title mb-4 text-center">Registrar Curso</h5>
    <input type="text" id="id_curso_edicion" value="0" hidden>
    <form>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="descripcion" class="form-label">Descripci&oacute;n</label>
          <input type="text" id="descripcion" name="descripcion" class="form-control form-control-lg" placeholder="Descripci&oacute;n" required>
        </div>
        <div class="col-md-6">
          <label for="estado" class="form-label">Estado</label>
          <select id="estado" name="estado" class="form-control" required>
            <option value="ACTIVO" selected>Activo</option>
            <option value="INACTIVO">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="mt-4">
        <button onclick="guardarCurso(); return false;" class="btn btn-primary btn-lg px-5">Registrar</button>
        <button onclick="mostrarListarCurso(); return false;" class="btn btn-secondary btn-lg px-5">Volver</button>
      </div>
    </form>
  </div>
</div>
