<?php
// archivo: includes/conexion.php


$host = "localhost"; 
$user = "wiznet_wiznet";
$password = 'YI13$~PNk@#z'; // Comillas simples ' ' para proteger los símbolos
$database = "wiznet_wiznet";

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar errores
if ($conn->connect_error) {
    // En producción es mejor un mensaje genérico por seguridad
    die("Error de conexión al sistema.");
}

$conn->set_charset("utf8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>