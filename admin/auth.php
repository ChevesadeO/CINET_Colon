<?php
// Iniciar sesión solo si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar autenticación del administrador
if (
    !isset($_SESSION["admin"]) ||
    $_SESSION["admin"] !== true
) {
    header("Location: login.php");
    exit();
}

// Protección básica adicional
// Verifica IP del usuario para evitar secuestro de sesión
if (!isset($_SESSION["ip"])) {
    $_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];
}

if ($_SESSION["ip"] !== $_SERVER["REMOTE_ADDR"]) {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
}

// Tiempo máximo de inactividad (30 minutos)
$tiempo_maximo = 1800;

if (isset($_SESSION['ultimo_acceso'])) {
    $inactivo = time() - $_SESSION['ultimo_acceso'];

    if ($inactivo > $tiempo_maximo) {
        session_unset();
        session_destroy();

        header("Location: login.php?expirada=1");
        exit();
    }
}

// Actualizar tiempo de actividad
$_SESSION['ultimo_acceso'] = time();
?>