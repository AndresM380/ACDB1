<?php
session_start();

if (!isset($_SESSION["logueado"]) || $_SESSION["logueado"] !== true) {
    header("Location: ../index.php");
    exit;
}

$id = $_SESSION["usuario_id"]?? "";
$email = $_SESSION["usuario_email"]?? "";
$nombres = $_SESSION["usuario_nombres"]?? "";
$apellidos = $_SESSION["usuario_apellidos"]?? "";
$fecha_nacimiento = $_SESSION["usuario_fecha_nacimiento"] ?? "";

if ($fecha_nacimiento !== "") {
    $fecha_nacimiento = date("Y-m-d", strtotime($fecha_nacimiento));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de usuario</title>

  <link rel="stylesheet" href="../assets/css/index.css?v=2">
  <link rel="stylesheet" href="../assets/css/perfil.css?v=2">
</head>

<body>

  <header>
    <h1>Perfil de Usuario</h1>

    <div>
      <a href="../index.php" class="reload">Inicio</a>
      <a href="../assets/conf/login/logout.php" class="login">Cerrar sesión</a>
    </div>
  </header>

  <main class="perfil-main">

    <section class="perfil-contenedor">
      <h2>Mis datos</h2>

      <form id="formActualizarDatos" class="perfil-form">
        <label for="id_usuario">ID</label>
        <input type="text" id="id_usuario" name="id_usuario" value="<?php echo $id; ?>" readonly>

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly>

        <label for="nombres">Nombres</label>
        <input type="text" id="nombres" name="nombres" value="<?php echo $nombres; ?>">

        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>">

        <label for="fecha_nacimiento">Fecha de nacimiento</label>
        <input type="date" id="fecha_nacimiento"  name="fecha_nacimiento"  value="<?php echo $fecha_nacimiento; ?>">


        <label id="mensajeDatos" class="mensaje-error"></label>

        <div class="perfil-botones">
          <button type="submit">Actualizar datos</button>
          <button type="reset">Cancelar</button>
        </div>
      </form>
    </section>

    <section class="perfil-contenedor">
      <h2>Cambiar contraseña</h2>

      <form id="formActualizarPassword" class="perfil-form">
        <label for="password_actual">Contraseña actual</label>
        <input type="password" id="password_actual" name="password_actual" placeholder="Ingrese su contraseña actual">

        <label for="password_nueva">Nueva contraseña</label>
        <input type="password" id="password_nueva" name="password_nueva" placeholder="Ingrese la nueva contraseña">

        <label for="repetir_password_nueva">Repetir nueva contraseña</label>
        <input type="password" id="repetir_password_nueva" name="repetir_password_nueva" placeholder="Repita la nueva contraseña">

        <label id="mensajePassword" class="mensaje-error"></label>

        <div class="perfil-botones">
          <button type="submit">Guardar contraseña</button>
          <button type="reset">Cancelar</button>
        </div>
      </form>
    </section>

  </main>

  <footer>
    <p>&copy; 2026 UTPL</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    function validarDatosPerfil() {
      let nombres = $("#nombres").val().trim();
      let apellidos = $("#apellidos").val().trim();
      let fechaNacimiento = $("#fecha_nacimiento").val();

      if (nombres === "") {
        $("#mensajeDatos")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .text("Ingrese sus nombres.");
        return false;
      }

      if (apellidos === "") {
        $("#mensajeDatos")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .text("Ingrese sus apellidos.");
        return false;
      }

      if (fechaNacimiento === "") {
        $("#mensajeDatos")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .text("Ingrese su fecha de nacimiento.");
        return false;
      }

      $("#mensajeDatos")
        .removeClass("mensaje-error mensaje-exito")
        .text("");
      return true;
    }

    function validarCambioPassword() {
      let passwordActual = $("#password_actual").val();
      let passwordNueva = $("#password_nueva").val();
      let repetirPasswordNueva = $("#repetir_password_nueva").val();

      if (passwordActual === "") {
        $("#mensajePassword")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .text("Ingrese su contraseña actual.");
        return false;
      }

      if (passwordNueva === "") {
        $("#mensajePassword")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .text("Ingrese la nueva contraseña.");
        return false;
      }

      if (passwordNueva.length < 6) {
        $("#mensajePassword")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .text("La nueva contraseña debe tener mínimo 6 caracteres.");
        return false;
      }

      if (repetirPasswordNueva === "") {
        $("#mensajePassword")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .text("Repita la nueva contraseña.");
        return false;
      }

      if (passwordNueva !== repetirPasswordNueva) {
        $("#mensajePassword")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .text("Las nuevas contraseñas no coinciden.");
        return false;
      }

      $("#mensajePassword")
        .removeClass("mensaje-error mensaje-exito")
        .text("");
      return true;
    }

    $(document).on("submit", "#formActualizarDatos", function(e) {
      e.preventDefault();

      if (!validarDatosPerfil()) {
        return;
      }

      $.ajax({
        url: "../assets/conf/registro/actualizar_datos.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(respuesta) {
          respuesta = respuesta.trim();

          if (respuesta === "ok") {
            $("#mensajeDatos")
              .removeClass("mensaje-error")
              .addClass("mensaje-exito")
              .text("Datos actualizados correctamente.");
          } else {
            $("#mensajeDatos")
            .removeClass("mensaje-exito")
            .addClass("mensaje-error")
            .text(respuesta);
          }
        },
        error: function() {
          $("#mensajeDatos")
            .removeClass("mensaje-exito")
            .addClass("mensaje-error")
            .text("Error al actualizar los datos.");
        }
      });
    });

    $(document).on("submit", "#formActualizarPassword", function(e) {
      e.preventDefault();

      if (!validarCambioPassword()) {
        return;
      }

      $.ajax({
        url: "../assets/conf/registro/actualizar_password.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(respuesta) {
          respuesta = respuesta.trim();

          if (respuesta === "ok") {
            $("#mensajePassword")
              .removeClass("mensaje-error")
              .addClass("mensaje-exito")
              .text("Contraseña actualizada correctamente.");

            $("#formActualizarPassword")[0].reset();
          } else {
            $("#mensajePassword")
              .removeClass("mensaje-exito")
              .addClass("mensaje-error")
              .text(respuesta);
          }
        },
        error: function() {
          $("#mensajePassword")
            .removeClass("mensaje-exito")
            .addClass("mensaje-error")
            .text("Error al actualizar la contraseña.");
        }
      });
    });
  </script>

</body>
</html>
