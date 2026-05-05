<?php
session_start();

// Limpiar variables de sesión
$_SESSION = [];

// Destruir sesión
session_destroy();

// Redirigir al inicio
header("Location: ../../../index.php");
exit;
?>