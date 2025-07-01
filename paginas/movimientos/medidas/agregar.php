<div class="container py-4">
  <!-- Título del formulario -->
  <h2 class="mb-4 text-center">Registro de Medidas Corporales</h2>
  <!-- Card para envolver el formulario -->
  <div class="card shadow-sm">
    <div class="card-body">
      <div>
        <!-- Selección de Usuario (primer campo) -->
        <div class="mb-4">
          <label for="usuario_id" class="form-label">Selecciona Usuario</label>
          <select class="form-control" id="usuario_id" name="usuario_id" required>
            <option value="" selected disabled>-- Elige un usuario --</option>
            
          </select>
        </div>

        <!-- Campos de medidas en dos columnas para pantallas md+ -->
        <div class="row">
          <div class="col-md-12 mb-3">
            <label for="peso" class="form-label">Peso (Kg)</label>
            <input type="number" step="0.01" class="form-control" id="peso" name="peso" placeholder="Ej: 60.50" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="brazo_izquierdo" class="form-label">Brazo Izquierdo (cm)</label>
            <input type="number" step="0.01" class="form-control" id="brazo_izquierdo" name="brazo_izquierdo" placeholder="Ej: 32.50" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="brazo_derecho" class="form-label">Brazo Derecho (cm)</label>
            <input type="number" step="0.01" class="form-control" id="brazo_derecho" name="brazo_derecho" placeholder="Ej: 33.00" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="pierna_izquierda" class="form-label">Pierna Izquierda (cm)</label>
            <input type="number" step="0.01" class="form-control" id="pierna_izquierda" name="pierna_izquierda" placeholder="Ej: 60.25" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="pierna_derecha" class="form-label">Pierna Derecha (cm)</label>
            <input type="number" step="0.01" class="form-control" id="pierna_derecha" name="pierna_derecha" placeholder="Ej: 60.75" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="cintura" class="form-label">Cintura (cm)</label>
            <input type="number" step="0.01" class="form-control" id="cintura" name="cintura" placeholder="Ej: 80.00" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="cadera" class="form-label">Cadera (cm)</label>
            <input type="number" step="0.01" class="form-control" id="cadera" name="cadera" placeholder="Ej: 90.00" required>
          </div>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
          <label for="fecha" class="form-label">Fecha de Medición</label>
          <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>

        <!-- Botón de Envío -->
        <div class="text-end">
            <button  class="btn btn-primary px-4" onclick="guardarMedidas();">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div>
