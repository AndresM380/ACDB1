<?php
include "../bd/conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Acceso no permitido.";
    exit;
}

$email = trim($_POST["email"] ?? "");
$nombres = trim($_POST["nombres"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$fecha_nacimiento = trim($_POST["fecha_nacimiento"] ?? "");
$password = $_POST["password"] ?? "";
$repetir_password = $_POST["repetir_password"] ?? "";

if ($email == "" || $nombres == "" || $apellidos == "" || $fecha_nacimiento == "" || $password == "" || $repetir_password == "") {
    echo "Todos los campos son obligatorios.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Correo electrónico no válido.";
    exit;
}

if ($password !== $repetir_password) {
    echo "Las contraseñas no coinciden.";
    exit;
}

if (strlen($password) < 6) {
    echo "La contraseña debe tener mínimo 6 caracteres.";
    exit;
}

// Encriptar contraseña
$password_segura = password_hash($password, PASSWORD_DEFAULT);

// Verificar si el correo ya existe
$consulta = "SELECT id FROM usuarios WHERE email = ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {
    echo "Este correo ya está registrado.";
    exit;
}

// Insertar usuario
$sql = "INSERT INTO usuarios 
        (email, nombres, apellidos, fecha_nacimiento, password)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $email,
    $nombres,
    $apellidos,
    $fecha_nacimiento,
    $password_segura
);

if (mysqli_stmt_execute($stmt)) {
    echo "ok";
} else {
    echo "Error al registrar el usuario.";
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>