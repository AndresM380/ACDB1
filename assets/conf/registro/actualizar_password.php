<?php
session_start();

include "../bd/conexion.php";

if (!isset($_SESSION["logueado"]) || $_SESSION["logueado"] !== true) {
    echo "Sesión no válida. Inicie sesión nuevamente.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Acceso no permitido.";
    exit;
}

$id_usuario = $_SESSION["usuario_id"];

$password_actual = $_POST["password_actual"] ?? "";
$password_nueva = $_POST["password_nueva"] ?? "";
$repetir_password_nueva = $_POST["repetir_password_nueva"] ?? "";

if ($password_actual === "" || $password_nueva === "" || $repetir_password_nueva === "") {
    echo "Todos los campos son obligatorios.";
    exit;
}

if (strlen($password_nueva) < 6) {
    echo "La nueva contraseña debe tener mínimo 6 caracteres.";
    exit;
}

if ($password_nueva !== $repetir_password_nueva) {
    echo "Las nuevas contraseñas no coinciden.";
    exit;
}

$sql = "SELECT password FROM usuarios WHERE id = ? LIMIT 1";

$stmt = mysqli_prepare($conexion, $sql);

if (!$stmt) {
    echo "Error al preparar la consulta.";
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {
    echo "Usuario no encontrado.";
    exit;
}

$fila = mysqli_fetch_assoc($resultado);
$password_bd = $fila["password"];

if (!password_verify($password_actual, $password_bd)) {
    echo "La contraseña actual es incorrecta.";
    exit;
}

$password_segura = password_hash($password_nueva, PASSWORD_DEFAULT);

$sql_update = "UPDATE usuarios 
               SET password = ?
               WHERE id = ?";

$stmt_update = mysqli_prepare($conexion, $sql_update);

if (!$stmt_update) {
    echo "Error al preparar la actualización.";
    exit;
}

mysqli_stmt_bind_param($stmt_update, "si", $password_segura, $id_usuario);

if (mysqli_stmt_execute($stmt_update)) {
    echo "ok";
} else {
    echo "Error al actualizar la contraseña.";
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($stmt_update);
mysqli_close($conexion);
?>