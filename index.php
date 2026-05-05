<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - UTPL</title>
  <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>

  <header>
    <h1>Universidad Técnica Particular de Loja - 5to CICLO PROGRANACION WEB</h1>

    <div>
      <a href="#" class="login" onclick="cargarPagina('assets/conf/partials/login.php')">Login</a>
      <a href="#" class="reload"  onclick="reload()">Recargar</a>
    </div>
  </header>

  <main>
    <h2>Bienvenido a la UTPL</h2>

    <div>
      <h2>
        <label id="page-title">Página Principal</label>
      </h2>
      <p>
        <div id="contenido">
          Esta es la página general del sistema. Para acceder a las funciones privadas,
          debes iniciar sesión con tu usuario y contraseña.
        </div>
        
      </p>
    </div>
  </main>

  <footer>
    <p>&copy; 2026 </p>
  </footer>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  function reload() {
    location.reload();
  }

  function validarLogin() {
    let usuario = document.getElementById("usuario").value.trim();
    let password = document.getElementById("password").value;

    if (usuario === "") {
      alert("Ingrese su usuario.");
      return false;
    }

    if (password === "") {
      alert("Ingrese su contraseña.");
      return false;
    }

    return true;
  }

  function validarRegistro() {
    let email = document.getElementById("email").value.trim();
    let nombres = document.getElementById("nombres").value.trim();
    let apellidos = document.getElementById("apellidos").value.trim();
    let fechaNacimiento = document.getElementById("fecha_nacimiento").value;
    let password = document.getElementById("password").value;
    let repetirPassword = document.getElementById("repetir_password").value;

    if (email === "") {
      $("#mensajeRegistro").text("Ingrese su correo electrónico.");
      return false;
    }

    if (!email.includes("@") || !email.includes(".")) {
      $("#mensajeRegistro").text("Ingrese un correo electrónico válido.");
      return false;
    }

    if (nombres === "") {
      $("#mensajeRegistro").text("Ingrese sus nombres.");
      return false;
    }

    if (apellidos === "") {
      $("#mensajeRegistro").text("Ingrese sus apellidos.");
      return false;
    }

    if (fechaNacimiento === "") {
      $("#mensajeRegistro").text("Ingrese su fecha de nacimiento.");
      return false;
    }

    if (password === "") {
      $("#mensajeRegistro").text("Ingrese una contraseña.");
      return false;
    }

    if (password.length < 6) {
      $("#mensajeRegistro").text("La contraseña debe tener mínimo 6 caracteres.");
      return false;
    }

    if (repetirPassword === "") {
      $("#mensajeRegistro").text("Repita la contraseña.");
      return false;
    }

    if (password !== repetirPassword) {
      $("#mensajeRegistro").text("Las contraseñas no coinciden.");
      return false;
    }

    $("#mensajeRegistro").text("");
    return true;
  }

  function cargarPagina(ruta) {
    fetch(ruta)
      .then(respuesta => respuesta.text())
      .then(html => {
        document.getElementById("contenido").innerHTML = html;
      })
      .catch(error => {
        console.error("Error:", error);
        document.getElementById("contenido").innerHTML =
          "<p>Error al cargar el contenido.</p>";
      });
  }

  $(document).on("submit", "#formRegistro", function(e) {
    e.preventDefault();

    if (!validarRegistro()) {
      return;
    }

    $.ajax({
      url: "assets/conf/registro/guardar_registro.php",
      type: "POST",
      data: $(this).serialize(),
      success: function(respuesta) {
        respuesta = respuesta.trim();

        if (respuesta === "ok") {
          $("#mensajeRegistro")
            .removeClass("mensaje-error")
            .addClass("mensaje-exito")
            .html("Usuario registrado correctamente.");

          $("#formRegistro")[0].reset();
        } else {
          $("#mensajeRegistro")
            .removeClass("mensaje-exito")
            .addClass("mensaje-error")
            .html(respuesta);
        }
      },
      error: function() {
        $("#mensajeRegistro")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .html("Error al registrar el usuario.");
      }
    });
  });

  $(document).on("submit", "#formLogin", function(e) {
  e.preventDefault();

  if (!validarLogin()) {
    return;
  }

  $.ajax({
    url: "assets/conf/login/validar_login.php",
    type: "POST",
    data: $(this).serialize(),
    success: function(respuesta) {
      respuesta = respuesta.trim();

      if (respuesta === "ok") {
        $("#mensajeLogin")
          .removeClass("mensaje-error")
          .addClass("mensaje-exito")
          .html("Inicio de sesión correcto.");

        // Redirigir después del login correcto
        window.location.href = "home/perfil.php";
      } else {
        $("#mensajeLogin")
          .removeClass("mensaje-exito")
          .addClass("mensaje-error")
          .html(respuesta);
      }
    },
    error: function() {
      $("#mensajeLogin")
        .removeClass("mensaje-exito")
        .addClass("mensaje-error")
        .html("Error al validar el inicio de sesión.");
    }
  });
});


</script>
</body>
</html>