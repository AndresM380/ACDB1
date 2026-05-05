<form id="formLogin" class="form-login">
  <h2>Iniciar sesión</h2>

  <label for="usuario">Email</label>
  <input type="email" id="usuario" name="usuario" placeholder="Ingrese su email">

  <label for="password">Contraseña</label>
  <input type="password" id="password" name="password" placeholder="Ingrese su contraseña">

  <!-- Mensaje de error o éxito -->
  <label id="mensajeLogin" class="mensaje-error"></label>

  <div class="botones">
    <button type="submit">Iniciar Sesión</button>
    <button type="reset">Cancelar</button>
  </div>

  <p class="registro">
    ¿No te has registrado?
    <a href="#" onclick="cargarPagina('assets/conf/partials/registro_usuario.php')">Hazlo aquí</a>
  </p>
</form>