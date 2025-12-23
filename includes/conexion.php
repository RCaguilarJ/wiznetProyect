<?php
// archivo: includes/conexion.php

// ====================================================
// 1. CONFIGURACIÓN DEL ENTORNO
// ====================================================

// PON ESTO EN 'true' PARA TRABAJAR EN TU PC (WAMP)
// PON ESTO EN 'false' CUANDO LO SUBAS AL SERVIDOR
$modo_local = true; 


if ($modo_local) {
    // 🏠 DATOS PARA TU PC (WAMP)
    $host = "localhost";
    $user = "root";
    $password = ""; 
    
    // ⚠️ IMPORTANTE: Si en tu phpMyAdmin local tu base se llama "wiznet",
    // cambia la línea de abajo por: $database = "wiznet";
    $database = "wiznet"; 

} else {
    // ☁️ DATOS PARA EL SERVIDOR (PRODUCCIÓN)
    $host = "localhost"; 
    $user = "wiznet_wiznet";
    $password = 'YI13$~PNk@#z'; 
    $database = "wiznet_wiznet";
}

// ====================================================
// 2. CREAR LA CONEXIÓN
// ====================================================
// Usamos el @ para suprimir el error visual feo de PHP y manejarlo nosotros abajo
$conn = @new mysqli($host, $user, $password, $database);

// ====================================================
// 3. VERIFICAR ERRORES
// ====================================================
if ($conn->connect_error) {
    if ($modo_local) {
        // Mensaje detallado solo para ti en local
        die("<h1>❌ Error de Conexión Local (WAMP)</h1>
             <p><b>Error:</b> " . $conn->connect_error . "</p>
             <p><b>Revisa:</b><br>
             1. Que WAMP esté en verde.<br>
             2. Que la base de datos <b>'$database'</b> exista en phpMyAdmin.<br>
             3. Que el usuario sea 'root' y sin contraseña.</p>");
    } else {
        // Mensaje seguro para producción
        die("Error de conexión al sistema. Intente más tarde.");
    }
}

// Configurar caracteres especiales (tildes, ñ)
$conn->set_charset("utf8");

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>