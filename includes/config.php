<?php 
$host = "localhost";
$usuario = "fjpzawkhtd_cinet_user";
$contrasena = "P[p.TTA}ODF$"; 
$basedatos = "fjpzawkhtd_cinetcolon_db"; 

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>