<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="card-title mb-4 text-center">Registrar Usuario</h5>
    <input type="text" id="id_usuario_edicion" value="0" hidden>
    <form>
      <div class="row g-3">
        <div class="col-12">
          <label for="nombreyapellido" class="form-label">Nombre y Apellido</label>
          <input
            type="text"
            id="nombreyapellido"
            name="nombreyapellido"
            class="form-control form-control-lg"
            placeholder="Ingresa nombre y apellido"
            required
          >
        </div>

        <div class="col-md-6">
          <label for="cedula" class="form-label">Cédula</label>
          <input
            type="number"
            id="cedula"
            name="cedula"
            class="form-control form-control-lg"
            placeholder="Ej: 1234567"
            required
          >
        </div>

        <div class="col-md-6">
          <label for="contrasena" class="form-label">Contraseña</label>
          <input
            type="password"
            id="contrasena"
            name="contrasena"
            class="form-control form-control-lg"
            placeholder="••••••••"
            required
          >
        </div>

        <div class="col-md-6">
          <label for="rol" class="form-label">Rol</label>
          <select
            id="rol"
            name="rol"
            class="form-control"
            required
          >
            <option value="0" selected >-- Selecciona rol --</option>
            <option value="ADMINISTRADOR">Administrador</option>
            <option value="PERSONA">Persona</option>
            <!-- añade más según tu lógica -->
          </select>
        </div>

        <div class="col-md-6">
          <label for="estado" class="form-label">Estado</label>
          <select
            id="estado"
            name="estado"
            class="form-control"
            required
          >
            <option value="0" >-- Selecciona estado --</option>
            <option selected value="ACTIVO">Activo</option>
            <option value="INACTIVO">Inactivo</option>
          </select>
        </div>

        <div class="col-md-6"  hidden>
          <label for="intentos" class="form-label">Intentos</label>
          <input
            type="number"
            id="intentos"
            name="intentos"
            class="form-control form-control-lg"
            value="0"
            min="0"
          >
        </div>

          <div class="col-md-6" hidden>
          <label for="limite_intentos" class="form-label">Límite de Intentos</label>
          <input
            type="number"
            id="limite_intentos"
            name="limite_intentos"
            class="form-control form-control-lg"
            value="3"
            min="1"
          >
        </div>
      </div>

      <div class="mt-4 ">
          <button onclick="guardarUsuario(); return false;"  class="btn btn-primary btn-lg px-5">
          Registrar
        </button>
          <button onclick="mostrarListarUsuario(); return false;" class="btn btn-secondary btn-lg px-5">
          Volver
        </button>
      </div>
    </form>
  </div>
</div>
