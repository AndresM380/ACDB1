<?php
session_start();

include "../bd/conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Acceso no permitido.";
    exit;
}

$usuario = trim($_POST["usuario"] ?? "");
$password = $_POST["password"] ?? "";

if ($usuario === "" || $password === "") {
    echo "Todos los campos son obligatorios.";
    exit;
}

$sql = "SELECT id, email, nombres, apellidos, fecha_nacimiento, password 
        FROM usuarios 
        WHERE email = ? 
        LIMIT 1";

$stmt = mysqli_prepare($conexion, $sql);

if (!$stmt) {
    echo "Error en la consulta.";
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {
    echo "Usuario o contraseña incorrectos.";
    exit;
}

$fila = mysqli_fetch_assoc($resultado);

$password_bd = $fila["password"];

if (password_verify($password, $password_bd)) {
    $_SESSION["usuario_id"] = $fila["id"];
    $_SESSION["usuario_email"] = $fila["email"];
    $_SESSION["usuario_nombres"] = $fila["nombres"];
    $_SESSION["usuario_apellidos"] = $fila["apellidos"];
    $_SESSION["usuario_fecha_nacimiento"] = $fila["fecha_nacimiento"];
    $_SESSION["logueado"] = true;

    echo "ok";
} else {
    echo "Usuario o contraseña incorrectos.";
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
