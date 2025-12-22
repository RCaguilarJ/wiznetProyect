<?php
// archivo: includes/conexion.php

// --- CONFIGURACIÓN DE PRODUCCIÓN ---
// Al estar el archivo en el mismo servidor que la base de datos (cPanel), usamos "localhost".
$host = "localhost"; 
$user = "wiznet_wiznet";
// IMPORTANTE: Comillas simples ' ' para que el símbolo $ no rompa el código
$password = 'YI13$~PNk@#z'; 
$database = "wiznet_wiznet";

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar errores
if ($conn->connect_error) {
    // En producción mostramos un mensaje genérico por seguridad
    die("Error de conexión al sistema."); 
}

// Establecer codificación a UTF-8 para tildes y ñ
$conn->set_charset("utf8");

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>