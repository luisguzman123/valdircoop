<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario de Medidas</title>

</head>
<body>
  <div class="container mt-5">
    <h3 class="mb-4">Registro de Medidas Corporales</h3>
    <form>
      <div class="row mb-3">
        <div class="col-md-4">
          <label for="brazoIzq" class="form-label">Brazo Izquierdo (cm)</label>
          <input type="number" step="0.01" class="form-control" id="brazoIzq" name="brazo_izquierdo" required>
        </div>
        <div class="col-md-4">
          <label for="brazoDer" class="form-label">Brazo Derecho (cm)</label>
          <input type="number" step="0.01" class="form-control" id="brazoDer" name="brazo_derecho" required>
        </div>
        <div class="col-md-4">
          <label for="piernaIzq" class="form-label">Pierna Izquierda (cm)</label>
          <input type="number" step="0.01" class="form-control" id="piernaIzq" name="pierna_izquierda" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4">
          <label for="piernaDer" class="form-label">Pierna Derecha (cm)</label>
          <input type="number" step="0.01" class="form-control" id="piernaDer" name="pierna_derecha" required>
        </div>
        <div class="col-md-4">
          <label for="cintura" class="form-label">Cintura (cm)</label>
          <input type="number" step="0.01" class="form-control" id="cintura" name="cintura" required>
        </div>
        <div class="col-md-4">
          <label for="cadera" class="form-label">Cadera (cm)</label>
          <input type="number" step="0.01" class="form-control" id="cadera" name="cadera" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="fecha" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <div class="col-md-6">
          <label for="usuario" class="form-label">Usuario</label>
          <select class="form-select" id="usuario" name="usuario" required>
            <option value="">Seleccione un usuario</option>
            <option value="usuario1">Usuario 1</option>
            <option value="usuario2">Usuario 2</option>
            <option value="usuario3">Usuario 3</option>
            <!-- Puedes llenar con los datos reales desde la base de datos -->
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
