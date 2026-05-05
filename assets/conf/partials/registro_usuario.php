<form id="formRegistro" class="form-registro">
  <h2>Registro de usuario</h2>

  <label for="email">Correo electrónico</label>
  <input type="email" id="email" name="email" placeholder="Ingrese su correo">

  <label for="nombres">Nombres</label>
  <input type="text" id="nombres" name="nombres" placeholder="Ingrese sus nombres">

  <label for="apellidos">Apellidos</label>
  <input type="text" id="apellidos" name="apellidos" placeholder="Ingrese sus apellidos">

  <label for="fecha_nacimiento">Fecha de nacimiento</label>
  <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">

  <label for="password">Contraseña</label>
  <input type="password" id="password" name="password" placeholder="Ingrese su contraseña">

  <label for="repetir_password">Repetir contraseña</label>
  <input type="password" id="repetir_password" name="repetir_password" placeholder="Repita su contraseña">

  <!-- Mensaje de error o éxito -->
  <label id="mensajeRegistro" class="mensaje-error"></label>

  <div class="botones">
    <button type="submit">Registrarse</button>
    <button type="reset">Cancelar</button>
  </div>

  <p class="login-link">
    ¿Ya tienes una cuenta?
    <a href="#" onclick="cargarPagina('assets/conf/partials/login.php')">Inicia sesión aquí</a>
  </p>
</form>