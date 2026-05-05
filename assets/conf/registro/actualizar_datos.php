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

$nombres = trim($_POST["nombres"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$fecha_nacimiento = trim($_POST["fecha_nacimiento"] ?? ""); 

if ($nombres === "" || $apellidos === "" || $fecha_nacimiento === "") {
    echo "Todos los campos son obligatorios.";
    exit;
}

$sql = "UPDATE usuarios 
        SET nombres = ?, apellidos = ?, fecha_nacimiento = ?    
        WHERE id = ?";

$stmt = mysqli_prepare($conexion, $sql);

if (!$stmt) {
    echo "Error al preparar la consulta.";
    exit;
}

mysqli_stmt_bind_param($stmt, "sssi", $nombres, $apellidos, $fecha_nacimiento, $id_usuario);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION["usuario_nombres"] = $nombres;
    $_SESSION["usuario_apellidos"] = $apellidos;
    $_SESSION["usuario_fecha_nacimiento"] = $fecha_nacimiento;

    echo "ok";
} else {
    echo "Error al actualizar los datos.";
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>