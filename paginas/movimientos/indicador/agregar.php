<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="card-title mb-4 text-center">Registrar Indicador</h5>
    <input type="text" id="id_indicador_edicion" value="0" hidden>
    <form>
      <div class="row g-3">
        <div class="col-md-4">
          <label for="proyecto_curso_id" class="form-label">Proyecto Curso</label>
          <select id="proyecto_curso_id" class="form-control"></select>
        </div>
        <div class="col-md-4">
          <label for="plantilla_id" class="form-label">Plantilla</label>
          <select id="plantilla_id" class="form-control"></select>
        </div>
        <div class="col-md-4">
          <label for="nro_stand" class="form-label">Nro Stand</label>
          <input type="text" id="nro_stand" class="form-control">
        </div>
        <div class="col-md-8">
          <label for="titulo" class="form-label">Titulo</label>
          <input type="text" id="titulo" class="form-control">
        </div>
        <div class="col-md-4">
          <label for="estado_ind" class="form-label">Estado</label>
          <select id="estado_ind" class="form-control">
            <option value="ACTIVO" selected>Activo</option>
            <option value="INACTIVO">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="mt-4">
        <button onclick="guardarIndicador(); return false;" class="btn btn-primary btn-lg px-5">Guardar</button>
        <button onclick="mostrarListarIndicador(); return false;" class="btn btn-secondary btn-lg px-5">Volver</button>
      </div>
    </form>
  </div>
</div>
